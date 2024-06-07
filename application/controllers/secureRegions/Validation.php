<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("Main.php");
class Validation extends Main {

	function __construct()
	{
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->library('User_auth');
		
		$session_uid = $this->data['session_uid']=$this->session->userdata('sess_psts_uid');
		$this->data['session_name']=$this->session->userdata('sess_psts_name');
		$this->data['session_email']=$this->session->userdata('sess_psts_email');

		$this->load->helper('url');
		
		$this->data['User_auth_obj'] = new User_auth();
		$this->data['user_data'] = $this->data['User_auth_obj']->check_user_status();
		
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

	function isDuplicateCustomerUniqueName()
	{
		$customer_unique_name =''; 
		$customer_profile_id =0; 
		if(!empty($_POST['customer_unique_name'])){ $customer_unique_name = trim($_POST['customer_unique_name']); }
		if(!empty($_POST['customer_profile_id'])){ $customer_profile_id = trim($_POST['customer_profile_id']); }
		
		$where = "customer_name = '$customer_unique_name' and customer_profile_id != $customer_profile_id";
		$boolean_response = false;
		$message = "Customer Name You Entered Does Not Exist In Database.";
		$numaric_response = 0;
		$is_exist = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'customer_profile' , 'where'=>$where ));
		if(!empty($is_exist) )
		{
			$boolean_response = true;
			$message = "Customer Name You Entered is Exist In Database. Please try Another.";
			$numaric_response = 1;
		}
		
		echo json_encode(array("boolean_response"=>$boolean_response , "message"=>$message , "numaric_response"=>$numaric_response));
	}

	function isDuplicateTransporterUniqueName()
	{
		$transporter_unique_name =''; 
		$transporter_profile_id =0; 
		if(!empty($_POST['transporter_unique_name'])){ $transporter_unique_name = trim($_POST['transporter_unique_name']); }
		if(!empty($_POST['transporter_profile_id'])){ $transporter_profile_id = trim($_POST['transporter_profile_id']); }
		
		$where = "transporter_name = '$transporter_unique_name' and transporter_profile_id != $transporter_profile_id";
		$boolean_response = false;
		$message = "Transporter Name You Entered Does Not Exist In Database.";
		$numaric_response = 0;
		$is_exist = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'transporter_profile' , 'where'=>$where ));
		if(!empty($is_exist) )
		{
			$boolean_response = true;
			$message = "Transporter Name You Entered is Exist In Database. Please try Another.";
			$numaric_response = 1;
		}
		
		echo json_encode(array("boolean_response"=>$boolean_response , "message"=>$message , "numaric_response"=>$numaric_response));
	}
	
	function isDuplicateCustomermc_chip_no()
	{
		$mc_chip_no = $order_no =''; 
		if(!empty($_POST['mc_chip_no'])){ $mc_chip_no = trim($_POST['mc_chip_no']); }
		if(!empty($_POST['order_no'])){ $order_no = trim($_POST['order_no']); }
		$where = "mc_chip_no = '$mc_chip_no'";
		$where = "mc_chip_no = '$mc_chip_no' and order_no != $order_no";
		$boolean_response = false;
		$message = "Customer Microchip NumberYou Entered Does Not Exist In Database.";
		$numaric_response = 0;
		$is_exist = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'microchip' , 'where'=>$where ));
		if(empty($is_exist))
		{
			//$where = "email = '$email'";
			//$is_exist = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'customer_contact' , 'where'=>$where ));
		}
		
		if(!empty($is_exist))
		{
			$boolean_response = true;
			$message = "Customer Microchip Number You Entered is Exist In Database. Please try Another.";
			$numaric_response = 1;
		}
		
		echo json_encode(array("boolean_response"=>$boolean_response , "message"=>$message , "numaric_response"=>$numaric_response));
	}

	function isDuplicateTransporterEmail()
	{
		$email =''; 
		$transporter_profile_id =0; 
		if(!empty($_POST['email'])){ $email = trim($_POST['email']); }
		if(!empty($_POST['transporter_profile_id'])){ $transporter_profile_id = trim($_POST['transporter_profile_id']); }
		
		$where = "email = '$email' and transporter_profile_id != $transporter_profile_id";
		$boolean_response = false;
		$message = "Transporter Email You Entered Does Not Exist In Database.";
		$numaric_response = 0;
		$is_exist = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'transporter_profile' , 'where'=>$where ));
		
		if(!empty($is_exist))
		{
			$boolean_response = true;
			$message = "Transporter Email You Entered is Exist In Database. Please try Another.";
			$numaric_response = 1;
		}
		
		echo json_encode(array("boolean_response"=>$boolean_response , "message"=>$message , "numaric_response"=>$numaric_response));
	}

	function isDuplicateCompanyUniqueName()
	{
		$company_unique_name =''; 
		$company_profile_id =0; 
		if(!empty($_POST['company_unique_name'])){ $company_unique_name = trim($_POST['company_unique_name']); }
		if(!empty($_POST['company_profile_id'])){ $company_profile_id = trim($_POST['company_profile_id']); }
		
		$where = "company_unique_name = '$company_unique_name' and company_profile_id != $company_profile_id";
		$boolean_response = false;
		$message = "Company Name You Entered Does Not Exist In Database.";
		$numaric_response = 0;
		$is_exist = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'company_profile' , 'where'=>$where ));
		if(!empty($is_exist) )
		{
			$boolean_response = true;
			$message = "Company Name You Entered is Exist In Database. Please try Another.";
			$numaric_response = 1;
		}
		
		echo json_encode(array("boolean_response"=>$boolean_response , "message"=>$message , "numaric_response"=>$numaric_response));
	}

	function isDuplicateCompanyEmail()
	{
		$email =''; 
		$company_profile_id =0; 
		if(!empty($_POST['email'])){ $email = trim($_POST['email']); }
		if(!empty($_POST['company_profile_id'])){ $company_profile_id = trim($_POST['company_profile_id']); }
		
		$where = "email = '$email' and company_profile_id != $company_profile_id";
		$boolean_response = false;
		$message = "Company Email You Entered Does Not Exist In Database.";
		$numaric_response = 0;
		$is_exist = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'company_profile' , 'where'=>$where ));
		if(!empty($is_exist))
		{
			$boolean_response = true;
			$message = "Company Email You Entered is Exist In Database. Please try Another.";
			$numaric_response = 1;
		}
		
		echo json_encode(array("boolean_response"=>$boolean_response , "message"=>$message , "numaric_response"=>$numaric_response));
	}
	
}
