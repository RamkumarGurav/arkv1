<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
        parent::__construct();
		//$this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Login_model');
		$this->load->helper('url');
		$this->data['message']='';
		$this->data['alert_message']='';

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->data['session_uid']=$this->session->userdata('sess_psts_uid');
		$this->data['session_name']=$this->session->userdata('sess_psts_name');
		$this->data['session_email']=$this->session->userdata('sess_psts_email');
    }



	function index()
	{
		if(!empty($this->data['session_uid']) && !empty($this->data['session_name']) && !empty($this->data['session_email']))
		{
			REDIRECT(MAINSITE_Admin."wam");
		}
		if(isset($_POST['login_btn']))
		{
			$this->form_validation->set_rules('username', "Username", 'required');
			$this->form_validation->set_rules('password', "Password", 'required');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>', '</div>');
			
			if ($this->form_validation->run() == true )
			{
				$this->data['alert_message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$response=$this->Login_model->doSignInUser();
				if($response){
					if($response->status==1)
					{
						$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="icon fas fa-check"></i> You Are Login Successfully 
						</div>');
						$this->session->set_userdata('sess_psts_uid', $response->admin_user_id);
						$this->session->set_userdata('sess_psts_name', $response->name);
						$this->session->set_userdata('sess_psts_email', $response->email);
						$this->session->set_userdata('sess_company_profile_id', $response->roles[0]->company_profile_id);
						
						$this->load->library('fiscalYear');
						$fy = new fiscalYear();
						$result = $fy->setFiscalYear();
						$this->session->set_userdata('sess_fiscal_year_id',$result->fiscal_year_id);
						
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
					<i class="icon fas fa-ban"></i> Wrong Email Id Or Password
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
		$this->load->view('admin/login' , $this->data);
	}

	public function index1()
	{
		$this->load->view('welcome_message');
	}

	
}
