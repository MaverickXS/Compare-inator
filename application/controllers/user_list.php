<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_list extends CI_Controller {
	private $data = array();

	public function __construct(){
        parent::__construct();

		if ($ck = get_cookie('compareinator_session')){
			$this->authenticinator->check_cookie($ck);
		}
		
		$this->data['admin']		= false;
		$this->data['user']			= $this->session->userdata;
		$this->data['logged_in']	= $this->session->userdata('logged_in');
		if (isset($this->data['user']['is_admin'])){
			if ($this->data['user']['is_admin']){
				$this->data['admin'] = true;
			}
		}

		$this->data['active_link']  = 'user';
		$this->data['page_title']   = '';
	}

	public function index($username = ''){
        // Load Helpers
        $this->load->helper('user');
        
        // Load Models
        $this->load->model('Users');

        // Get necessary data
        if ($username==''){
            // List View
            $this->data['user_list'] = $this->Users->get_user_list($username);
        } else {
            // Detail View
            $this->data['user_detail'] = $this->Users->get_user_list($username);
        }

        // Load views
        $this->load->view('template_top', $this->data);
        if ($username==''){
            $this->load->view('users_view', $this->data);
        } else {
        }
        $this->load->view('template_bot', $this->data);
    }
}
?>