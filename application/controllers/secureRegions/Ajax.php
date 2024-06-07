<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("Main.php");
class Ajax extends Main {

	function __construct()
	{
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->model('administrator/Ajax_Model');
		$this->load->library('User_auth');
		
		$session_uid = $this->data['session_uid']=$this->session->userdata('sess_psts_uid');
		$this->data['session_name']=$this->session->userdata('sess_psts_name');
		$this->data['session_email']=$this->session->userdata('sess_psts_email');
		$this->data['sess_company_profile_id']=$this->session->userdata('sess_company_profile_id');

		$this->load->helper('url');
		
		$this->data['User_auth_obj'] = new User_auth();
		$this->data['user_data'] = $this->data['User_auth_obj']->check_user_status();
		$sess_left_nav = $this->session->flashdata('sess_left_nav');
		if(!empty($sess_left_nav))
		{
			$this->session->set_flashdata('sess_left_nav', $sess_left_nav);
			$this->data['page_module_id'] = $sess_left_nav;
		}
		
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
	
	
	function getState()
	{
		$state_id = $country_id ='0'; 
		if(!empty($_POST['country_id'])){ $country_id = $_POST['country_id']; }
		if(!empty($_POST['state_id'])){ $state_id = $_POST['state_id']; }

		$state_data = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'state' , 'where'=>"country_id = $country_id" , "order_by"=>"state_name ASC"));
		$result = '<option value="">Select State</option>';
		if(!empty($state_data))
		{
			foreach($state_data as $r)
			{
				$if_block = $selected = '';
				if($r->state_id == $state_id){ $selected = "selected"; }
				if($r->status!=1){$if_block= " [Block]";}
				$result .= '<option value="'.$r->state_id.'" '.$selected.'>'.$r->state_name.$if_block.'</option>';
			}
		}
		echo json_encode(array("state_html"=>$result , "state_json"=>$state_data));
	}

	function getCity()
	{
		$state_id = $city_id ='0'; 
		if(!empty($_POST['city_id'])){ $city_id = $_POST['city_id']; }
		if(!empty($_POST['state_id'])){ $state_id = $_POST['state_id']; }

		$city_data = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'city' , 'where'=>"state_id = $state_id" , "order_by"=>"city_name ASC"));
		$result = '<option value="">Select City</option>';
		if(!empty($city_data))
		{
			foreach($city_data as $r)
			{
				$if_block = $selected = '';
				if($r->city_id == $city_id){ $selected = "selected"; }
				if($r->status!=1){$if_block= " [Block]";}
				$result .= '<option value="'.$r->city_id.'" '.$selected.'>'.$r->city_name.$if_block.'</option>';
			}
		}
		echo json_encode(array("city_html"=>$result , "city_json"=>$city_data));
	}

	function del_employee_file()
	{
		$admin_user_file_id = $_POST['admin_user_file_id'];
		$file_data = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'admin_user_file' , 'where'=>"admin_user_file_id = $admin_user_file_id"));
		if(!empty($file_data))
		{
			$file_data = $file_data[0];
			unlink("assets/employee_file/".$file_data->file_name);
			$this->Common_Model->delete_operation(array('table'=>'admin_user_file' , 'where'=>"admin_user_file_id = $admin_user_file_id"));
		}
	}
	
}
