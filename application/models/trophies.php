<?php
class Trophies extends CI_Model{
    function __construct(){
	    parent::__construct();
    }

    public function get_trophies_by_game($g_id){
        $this->db->from('trophies');
        $this->db->where('g_id', $g_id);
        return $this->db->get();
    }

    public function get_t_key_from_nm($sName, $g_id){
        $Result = 0;
        $this->db->select('t_key');
        $this->db->from('trophies');
        $this->db->where('trophy', $sName);
        $this->db->where('g_id', $g_id, False);
		$oRow = $this->db->get()->row();

        if (count($oRow) > 0){
            $Result = $oRow->t_key;
        }
        return $Result;
    }

	public function insert_update_trophy($trophy_data){
        $type = 'insert';
        $t_key = $this->get_t_key_from_nm($trophy_data['trophy'], $trophy_data['g_id']);

        if ($t_key > 0){
            $type = 'update';
        }

        if ($type=='update'){
            // Update
            $this->db->where('t_key', $t_key);
            $this->db->insert('trophies', $trophy_data);
        } else {
            // Insert
            $this->db->insert('trophies', $trophy_data);
            $t_key = $this->get_t_key_from_nm($trophy_data['trophy'], $trophy_data['g_id']);
        }

        return array($t_key, $type);
	}

    public function set_earned_trophy($t_id, $u_id, $type, $earned){
        return $this->db->query("Insert Into trophy_user_map (t_id, u_id, type, earned) Values ($t_id, $u_id, '$type', '$earned') On Duplicate Key Update earned = '$earned';");
    }
}
?>