<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authenticinator{
	var $CI;
	var $user_table = '`compare-inator`.`users`';

	function Authenticinator(){
		session_start();
		$this->CI =& get_instance();
	}

	function login($email_address = '', $password = ''){
		//Make sure login info was sent
		if($email_address == '' OR $password == ''){
			return false;
		}

		//Check if already logged in
		if($this->CI->session->userdata('email')==$email_address){
			//User is already logged in.
			return true;
		}

		//Check against user table
		$this->CI->db->where('email', $email_address);
		$query = $this->CI->db->get_where($this->user_table);

		if ($query->num_rows() > 0){
			$row = $query->row_array();

            //Check against password
			if (md5($password)!=$row['pw']){
				return 'invalidpass';
			}
			
			//Destroy old session
			$this->CI->session->sess_destroy();

			//Create a fresh, brand new session
			$this->CI->session->sess_create();

			// cookie monster
			$cookie = array(
				'name'   => 'compareinator_session',
				'value'  => md5($row['u_key'].$row['pw']),
				'expire' => '31536000',
				'domain' => '.compare-inator.com',
				'path'   => '/'
			);

			set_cookie($cookie);

			//Remove the password field
			unset($row['password']);

			//Set session data
			$this->CI->session->set_userdata($row);

			//Set logged_in to true
			$this->CI->session->set_userdata(array('logged_in' => true));            

			// Update Last Login
			$data = array('last_accessed' => date('Y-n-d H:i:s'));			
			$this->CI->db->where('u_key', $row['u_key']);
			$this->CI->db->update('users', $data);

			//Login was successful            
			return 'success';
		} else {
			//No database result found
			return 'norec';
		}    

	}
	
	function check_cookie(){
		// need to clean this up later - passing in the value isn't necessary
		$ck = get_cookie('compareinator_session');

		//Check against user table
		$query = $this->CI->db->query('SELECT * FROM '. $this->user_table .' WHERE md5(concat(u_key,pw)) = '. $this->CI->db->escape($ck));
		$row = $query->row();

		if ($query->num_rows() > 0){
			//Destroy old session
			$this->CI->session->sess_destroy();

			//Create a fresh, brand new session
			$this->CI->session->sess_create();

			// cookie monster
			$cookie = array(
				'name'   => 'compareinator_session',
				'value'  => md5($row->u_key.$row->pw),
				'expire' => '31536000',
				'domain' => '.compare-inator.com',
				'path'   => '/'
			);

			set_cookie($cookie);

			//Remove the password field
			//unset($row->salt);
			unset($row->password);

			//Set session data
			$this->CI->session->set_userdata($row);

			//Set logged_in to true
			$this->CI->session->set_userdata(array('logged_in' => true));            

			// Update Last Login
			$data = array('last_accessed' => date('Y-n-d H:i:s'));			
			$this->CI->db->where('u_key', $row->u_key);
			$this->CI->db->update('users', $data);

			//Login was successful            
			return 'success';
		} else {
			//No database result found
			return 'norec';
		}
	}

	function logout(){
		//Put here for PHP 4 users
		$this->CI =& get_instance();        

		//Destroy session
		$this->CI->session->sess_destroy();
	}
}
?>