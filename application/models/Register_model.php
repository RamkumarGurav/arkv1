<?php
class Register_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('Common_model');
    }
	
	function getCountry($params = array())
	{
		$this->db
		->select('c.country_id , c.country_name , country_short_name , c.country_code')
		->from('country as c')
		->where('c.status' , 1)
		->order_by('c.country_name ASC');
		$result = $this->db->get();
		if($result->num_rows() > 0)
			return $result->result();
		else
			return false;
	}
	
	function doAddUser($params = array())
	{
		$status = true;
		
		$registered_via = "Direct Registration";
			if(!empty($_POST['login_method']))
			{
				$registered_via = $_POST['login_method'];
			}
			
			$last_screen =  $this->Common_model->checkScreen();
			if($last_screen == 'isdesktop')
			{
				$last_screen = "Desktop";
			}
			else
			{
				$last_screen = "Mobile or Tablet";
			}
			$username = (!empty($_POST['username']))?trim($_POST['username']):'';
			$is_email =0;
			$is_contact =0;
			if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
			  $emailErr = "email format";
			  $is_email = 1;
			  $reg_data['number'] = '';
			  $reg_data['email'] = $username;
			}
			else if(is_numeric($username) && strlen($username) == 10)
			{
				$emailErr = "contact format";
				$is_contact = 1;
				$reg_data['email'] = '';
				$reg_data['number'] = $username;
			}
			else
			{
				$emailErr = "error";
			}
		$_POST['password'] = $this->Common_model->random_password(6 , 'number');
		$_POST['first_name'] = "User";
		$_POST['last_name'] = '';
		$_POST['country_id'] = __const_country_id__;
		
		$reg_data['registered_via'] = $registered_via;
		$reg_data['registered_device'] = $last_screen;
		
		$reg_data['name'] = $_POST['first_name'].' '.$_POST['last_name'];
		$reg_data['first_name'] = $_POST['first_name'];
		$reg_data['last_name'] = $_POST['last_name'];
		$reg_data['country_id'] = $_POST['country_id'];
		$reg_data['password'] = base64_encode($_POST['password']);
		$reg_data['show_password'] = $_POST['password'];
		$reg_data['updated_on'] = date('Y-m-d H:i:s');
		$reg_data['added_on'] = date('Y-m-d H:i:s');
		$reg_data['status'] = 1;
		$reg_data['password_recovery_id'] = 0;
		$reg_data['type'] = 0;
		$reg_data['is_guest'] = 0;
		if($is_email ==1)
		{
			$this->db
			->select('count(customers_id) as counts')
			->from('customers')
			->where('email' , $username);
			$result = $this->db->get();
			$result = $result->result();
			$result = $result[0];
			if($result->counts>0)
			{
				$status = false;
				return 'emailExist';
			}
		}
		if($is_contact == 1)
		{
			$this->db
			->select('count(customers_id) as counts')
			->from('customers')
			->where('number' , $username)
			->where('country_id' , $_POST['country_id']);
			$result = $this->db->get();
			$result = $result->result();
			$result = $result[0];
			if($result->counts>0)
			{
				$status = false;
				return 'numberExist';
			}
		}
		
		if($status)
		{
			return $this->Common_model->add_operation(array('table'=>'customers' , 'data'=>$reg_data ));
		}
	}
	
}

?>