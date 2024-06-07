<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Screen_Lock extends CI_Controller {

	function __construct() {
        parent::__construct();
		//$this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Screen_Lock_model');
		$this->load->helper('url');
		$this->data['message']='';
		$this->data['alert_message']='';

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->data['session_uid']=$this->session->userdata('sess_psts_uid');
		$this->data['session_name']=$this->session->userdata('sess_psts_name');
		$this->data['session_email']=$this->session->userdata('sess_psts_email');
    }

	function unset_only() {
		$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}
	}

	function index()
	{
		$screen_lock = $this->session->userdata('screen_lock');
		if(!empty($this->data['session_uid']) && !empty($this->data['session_name']) && !empty($this->data['session_email']) && empty($screen_lock))
		{
			REDIRECT(MAINSITE_Admin."wam");
		}
		//if(isset($_POST['login_btn']))
		if(!empty($_POST))
		{
			$this->form_validation->set_rules('password', "Password", 'required');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>', '</div>');
			
			if ($this->form_validation->run() == true )
			{
				$this->data['alert_message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$response=$this->Screen_Lock_model->doSignInUser();
				if($response){
					if($response->status==1)
					{
						$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="icon fas fa-check"></i> You Are Login Successfully 
						</div>');
						$this->session->set_userdata('screen_lock', '');
						REDIRECT(MAINSITE_Admin."wam");
					}
					else{
						$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="icon fas fa-ban"></i> You are blocked by Management.
					  </div>');
					}
				}
				else if(!$response){
					$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> Wrong Password
				  </div>');
				}
				else{
					$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. 
				  </div>');
				}
			}
			else
			{
				$this->data['alert_message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('alert_message');
			}
		}
		$temp_alert_message = $this->session->flashdata('alert_message');
		if(!empty($temp_alert_message))
		{
			$this->data['alert_message'] = $temp_alert_message;
		}
		//echo "<pre>";print_r($_POST);echo "</pre>";
		$this->load->view('admin//screen_lock' , $this->data);
	}



	public function logout()
	{
		$this->unset_only();
		$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="icon fas fa-check"></i> You Are Successfully Logout.
		</div>');
		$this->session->unset_userdata('sess_psts_uid');	
		REDIRECT(MAINSITE_Admin.'login');
	}

	
}
