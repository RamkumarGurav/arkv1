<?php
class User_model extends CI_Model
{
	function __construct()
    {
		$this->load->database();
        date_default_timezone_set("Asia/Kolkata");
		$this->db->query("SET sql_mode = ''");	
    }
	
	function doAddBulkEnquiryProduct($params = array())
	{
		$status = true;
		$customers_id = 0;
		$temp_name = $this->session->userdata('application_sess_temp_name');
		$temp_id = $this->session->userdata('application_sess_temp_id');
		if(!empty($temp_name) && !empty($temp_id))
		{
			$customers_id = $temp_id;
		}
		$reg_data['customers_id'] = $customers_id;
		$reg_data['name'] = $_POST['name'];
		$reg_data['email'] = $_POST['email'];
		$reg_data['product_id'] = $_POST['product_id'];
		$reg_data['number'] = $_POST['contact'];
		$reg_data['message'] = $_POST['message'];
		$reg_data['quantity'] = $_POST['bulk_quantity'];
		$reg_data['updated_on'] = date('Y-m-d H:i:s');
		$reg_data['added_on'] = date('Y-m-d H:i:s');
		$reg_data['status'] = 0;
		
		return $this->Common_Model->add_operation(array('table'=>'bulk_enquiry_product' , 'data'=>$reg_data ));
	}
	 
	function doAddInquiry($params = array())
	{	//eQname eQemail eQcountry_id eQcontact eQmessage state_id city_id
		$status = true;
		$reg_data['name'] = $_POST['name'];
		$reg_data['email'] = $_POST['email'];
		$reg_data['contactno'] = $_POST['mobile_no'];
		$reg_data['subject'] = $_POST['subject'];
		$reg_data['description'] = $_POST['message'];
		$reg_data['updated_on'] = date('Y-m-d H:i:s');
		$reg_data['added_on'] = date('Y-m-d H:i:s');
		$reg_data['status'] = 0;
		
		return $this->Common_Model->add_operation(array('table'=>'enquiry' , 'data'=>$reg_data ));
	}
	
	function doAddSubscribeFormInquiry($params = array())
	{	//eQname eQemail eQcountry_id eQcontact eQmessage state_id city_id
		$status = true;
		$input_data['subscriber_email'] = $_POST['subscriber_email'];
		$input_data['status'] = '1';
		$input_data['added_on'] = date('Y-m-d H:i:s');

		return $this->Common_Model->add_operation(array('table'=>'newsletter' , 'data'=>$input_data ));
	}
	 
	function doAddRegistration($params = array())
	{	//eQname eQemail eQcountry_id eQcontact eQmessage state_id city_id
		$status = true;
		$reg_data['company_profile_id'] = '';
		$reg_data['company_name'] = $_POST['company_name'];
		$reg_data['company_email'] = $_POST['company_email'];
		$reg_data['company_website'] = '';
		$reg_data['name'] = $_POST['name'];
		$reg_data['country_id'] = 1;
		$reg_data['state_id'] = $_POST['state_id'];
		
		$reg_data['city_id'] = $_POST['city_id'];
		
		$reg_data['address1'] = $_POST['address1'];
		$reg_data['address2'] = '';
		$reg_data['address3'] = '';
		//$reg_data['pincode'] = $_POST['pincode'];
		$reg_data['pincode'] = '';
		$reg_data['mobile_no'] = $_POST['mobile_no'];

		$reg_data['alt_mobile_no1'] = $_POST['alt_mobile_no1'];
		$reg_data['alt_mobile_no2'] = $_POST['alt_mobile_no2'];
		
		$reg_data['gst_no'] = $_POST['gst_no'];
		//$reg_data['password'] = $_POST['password'];
		$reg_data['password'] = '';
		$reg_data['added_on'] = date('Y-m-d H:i:s');
		$reg_data['status'] = 2;
		
		return $this->Common_Model->add_operation(array('table'=>'dealer_profile' , 'data'=>$reg_data ));
	}
	
}

?>