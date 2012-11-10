<?php
class Games extends CI_Model{
    function __construct(){
	    parent::__construct();
    }

    public function get_game_list(){
        $this->db->select('*, IfNull(`games`.`nm_override`, `games`.`nm`) As nm', False);
        $this->db->from('games');
        $this->db->where('`status`', 1, False);
        $this->db->where('`parent_g_id` Is Null', '', False);
        $this->db->where('(`games`.`trophies` > 0 Or `games`.`achievements` > 0)', '', False);
        $this->db->order_by('nm', 'asc');
        return $this->db->get();
    }

    public function get_game($g_key){
        $this->db->from('games');
        $this->db->where('g_key', $g_key);
        return $this->db->get()->row();
    }

    public function get_g_key_from_slug($sSlug){
        $Result = 0;
        $this->db->select('g_key');
        $this->db->from('games');
        $this->db->where('slug', $sSlug);
		$oRow = $this->db->get()->row();

        if (count($oRow) > 0){
            $Result = $oRow->g_key;
        }
        return $Result;
    }

    public function get_g_key_from_name($sName){
        $Result = 0;
        $this->db->select('g_key');
        $this->db->from('games');
        $this->db->where('nm', $sName);
		$oRow = $this->db->get()->row();

        if (count($oRow) > 0){
            $Result = $oRow->g_key;
        }
        return $Result;
    }

	public function insert_update_game($game_data){
        $type = 'insert';

        // Replace invalid characters
        $name = $game_data['nm'];
        $game_data['nm'] = preg_replace("/[^a-z0-9 \&\/\\:\-'\!]+/i", "", $name);

        $g_key = $this->get_g_key_from_name($game_data['nm']);

        if ($g_key > 0){
            $type = 'update';
        }

        if ($type=='update'){
            // Update
            unset($game_data['slug']);
            $this->db->where('g_key', $g_key);
            $this->db->update('games', $game_data);
        } else {
            // Insert
            $this->db->insert('games', $game_data);
            $g_key = $this->get_g_key_from_slug($game_data['slug']);
        }

        return array($g_key, $type);
	}

}
?>