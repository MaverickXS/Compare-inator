<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
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

		$this->data['active_link']  = 'dashboard';
		$this->data['page_title']   = 'Dashboard';
    }

	public function index(){
        // Load Helpers
        $this->load->helper('user');
        
        // Load Models
        $this->load->model('Users');
		
        // Load views
        $this->load->view('template_top', $this->data);
        $this->load->view('dashboard_view', $this->data);
        $this->load->view('template_bot', $this->data);
    }
}
?>