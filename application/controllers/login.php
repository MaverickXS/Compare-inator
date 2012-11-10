<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
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

		$this->data['active_link']  = 'login';
		$this->data['page_title']   = 'Login';
    }

	public function index(){
		$this->data['login_error'] = '';		

        // Load Helpers
        $this->load->helper('user');
        
        // Load Models
        $this->load->model('Users');
		
        // Load Libraries
        $this->load->library('form_validation');

        // Setup form validation
		$this->form_validation->set_rules('email', 'E-mail Address', 'trim|required|valid_email|min_length[5]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('pw', 'Password', 'trim|required|min_length[5]|max_length[50]|md5');
		$this->form_validation->set_error_delimiters(' <span class="err_text"><span class="label label-important">ERROR!</span> ', '</span>');

        // Process post (if any)
		if ($this->form_validation->run()==true){
			$login_result = $this->authenticinator->login($this->input->post('email'), $this->input->post('pw'));
			switch ($login_result){
				case 'success':
					header('location: /dashboard/');
					die();
					break;
				case 'norec':
					$this->data['login_error'] = 'Invalid E-mail Address.';
					break;
				case 'invalidpass':
					$this->data['login_error'] = 'Invalid Password.';
					break;
				default:
					$this->data['login_error'] = 'Unknown error. What\'d you do?!';
					break;
			}			
		}

        // Load views
        $this->load->view('template_top', $this->data);
        $this->load->view('login_view', $this->data);
        $this->load->view('template_bot', $this->data);
    }
}
?>