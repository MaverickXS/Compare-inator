<?php

class Logout extends CI_Controller{
	private $data = array();

	public function index(){
		$this->session->sess_destroy();
    	session_destroy();

		delete_cookie('compareinator_session', '.compare-inator.com', '/');
		
		header('location: /');
		die();
	}
}
?>