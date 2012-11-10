<?php
class Users extends CI_Model{
    function __construct(){
	    parent::__construct();
    }
    	
    public function get_user_list($username = ''){
        $this->db->select('*');
        $this->db->from('users');
        if ($username != ''){
            $this->db->where('username', $username);
        }
        $this->db->order_by('username');
        return $this->db->get();
    }

    public function get_psn_users(){
        $this->db->select('u_key');
        $this->db->select('psn_id');
        $this->db->select('last_updated');
        $this->db->from('users');
        $this->db->where('users.psn_id Is Not Null And users.psn_id != \'\'');
        return $this->db->get();
    }

    public function get_steam_users(){
        $this->db->select('u_key');
        $this->db->select('steam_id');
        $this->db->select('last_updated');
        $this->db->from('users');
        $this->db->where('users.steam_id Is Not Null And users.steam_id != \'\'');
        return $this->db->get();
    }

    public function get_xbl_users(){
        $this->db->select('u_key');
        $this->db->select('xbl_id');
        $this->db->select('last_updated');
        $this->db->from('users');
        $this->db->where('users.xbl_id Is Not Null And users.xbl_id != \'\'');
        return $this->db->get();
    }

	public function update_user($u_key, $data){
		$this->db->where('u_key', $u_key);
		$this->db->update('users', $data); 
	}

}
?>