<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('User_auth');

		$session_uid = $this->data['session_uid']=$this->session->userdata('sess_psts_uid');
		$this->data['session_name']=$this->session->userdata('sess_psts_name');
		$this->data['session_email']=$this->session->userdata('sess_psts_email');

		$this->load->helper('url');

		$this->data['User_auth_obj'] = new User_auth();
		$this->data['user_data'] = $this->data['User_auth_obj']->check_user_status();
		$this->data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
		);


    }

	function unset_only()
	{
		$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}
	}


	function get_header()
	{
		$this->load->view('admin/inc/header', $this->data);
	}

	function get_left_nav()
	{
		$page_is_master = "";
		$page_parent_module_id = "";
		$page_module_id = "";
		//print_r($this->data['user_access']);
		if(!empty($this->data['page_is_master'])){
			$page_is_master = $this->data['page_is_master'];
		}

		if(!empty($this->data['page_parent_module_id'])){
			$page_parent_module_id = $this->data['page_parent_module_id'];
		}

		if(!empty($this->data['page_module_id'])){
			$page_module_id = $this->data['page_module_id'];
		}

		$params_arr = array(
			"page_is_master"=>$page_is_master ,
			"page_parent_module_id"=>$page_parent_module_id ,
			"page_module_id"=>$page_module_id
		);
		//print_r($params_arr);

		$this->data['left_menu_master'] = $this->data['User_auth_obj']->get_left_menu( 1 , $params_arr);
		$this->data['left_menu_employee'] = $this->data['User_auth_obj']->get_left_menu( 2 , $params_arr);
		$this->data['left_menu_company_profile'] = $this->data['User_auth_obj']->get_left_menu( 3 , $params_arr);
		$this->data['left_menu_catalog'] = $this->data['User_auth_obj']->get_left_menu( 4 , $params_arr);
		$this->data['left_menu_enquiry'] = $this->data['User_auth_obj']->get_left_menu( 5 , $params_arr);
		$this->data['left_menu_banner'] = $this->data['User_auth_obj']->get_left_menu( 6 , $params_arr);
		$this->data['left_menu_gallery'] = $this->data['User_auth_obj']->get_left_menu( 7 , $params_arr);
		$this->data['left_menu_videos'] = $this->data['User_auth_obj']->get_left_menu( 9 , $params_arr);
		$this->data['left_menu_working_method'] = $this->data['User_auth_obj']->get_left_menu( 10 , $params_arr);
		$this->data['left_menu_orders'] = $this->data['User_auth_obj']->get_left_menu( 13  , $params_arr);
		$this->data['left_menu_customers'] = $this->data['User_auth_obj']->get_left_menu( 8 , $params_arr);
		/* $this->data['quotation_menu'] = $this->data['User_auth_obj']->get_left_menu( 7 , $params_arr);
		$this->data['pi_menu'] = $this->data['User_auth_obj']->get_left_menu( 8 , $params_arr);
		$this->data['invoice_menu'] = $this->data['User_auth_obj']->get_left_menu( 9 , $params_arr);
		$this->data['po_menu'] = $this->data['User_auth_obj']->get_left_menu( 11 , $params_arr);
		$this->data['delivery_note_menu'] = $this->data['User_auth_obj']->get_left_menu( 12 , $params_arr);
		$this->data['rfq_menu'] = $this->data['User_auth_obj']->get_left_menu( 0 , $params_arr , 21);
		*/
		//print_r($this->data['left_menu_master']);
		$this->load->view('admin/inc/left_nav', $this->data);
	}

	function get_footer()
	{
		$this->load->view('admin/inc/footer', $this->data);
	}


}
