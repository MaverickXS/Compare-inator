<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
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

		$this->data['active_link']  = 'register';
		$this->data['page_title']   = 'Register';
    }

	public function index(){
        // Load Helpers
        $this->load->helper('user');
        
        // Load Models
        $this->load->model('Users');
		
        // Load Libraries
        $this->load->library('form_validation');

        // Setup form validation
		$this->form_validation->set_rules('email', 'E-mail Address', 'trim|required|valid_email|min_length[5]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[50]|md5');

        // Load views
        $this->load->view('template_top', $this->data);
        $this->load->view('register_view', $this->data);
        $this->load->view('template_bot', $this->data);
    }
}
?>