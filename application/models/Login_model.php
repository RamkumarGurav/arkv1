<?php
class Login_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->library('session');
    }
	
	function doLoginUser($params = array())
	{
		
		$status = true;
		//$email = $_POST['email'];
		$email = $_POST['username'];
		if(!empty($_POST['doLoginG']))
		{}
		else
		{ $password = base64_encode($_POST['password']); }
		
		$this->db
		->select('c.*')
		->from('customers as c')
		->where("email = '$email' or number = '$email' ")
		->limit(1);
		
		if(!empty($_POST['doLoginG']))
		{}
		else
		{ $this->db->where('password' , $password); }
		
		$result = $this->db->get();
		//echo $this->db->last_query();
		if($result->num_rows() > 0 )
		{
			$result = $result->result();
			$result = $result[0];
			
			$temp_id = $this->session->userdata('application_sess_temp_id');
			
			$this->Common_model->update_operation(array("table"=>"temp_wishlist" , "data"=>array("application_sess_temp_id"=>$result->customers_id ), "condition"=>"(application_sess_temp_id = $temp_id)"));
			$this->Common_model->update_operation(array("table"=>"temp_cart" , "data"=>array("application_sess_temp_id"=>$result->customers_id) , "condition"=>"(application_sess_temp_id = $temp_id)"));
			
			$sql_get_list="DELETE tc2 FROM temp_cart tc1, temp_cart tc2 WHERE tc1.temp_cart_id > tc2.temp_cart_id AND tc1.application_sess_temp_id = tc2.application_sess_temp_id AND tc1.product_id = tc2.product_id AND tc1.product_in_store_id = tc2.product_in_store_id ";
			$query_get_list=$this->db->query($sql_get_list);
			
			$sql_get_list="DELETE tc1 FROM temp_wishlist tc1, temp_wishlist tc2 WHERE tc1.temp_wishlist_id > tc2.temp_wishlist_id AND tc1.application_sess_temp_id = tc2.application_sess_temp_id AND tc1.product_id = tc2.product_id AND tc1.product_in_store_id = tc2.product_in_store_id ";
			$query_get_list=$this->db->query($sql_get_list);
			
			//$this->Common_model->delete_operation(array("table"=>"temp_cart" , "where"=>"(application_sess_temp_id = $result->customers_id and store_id!=$result->stores_id)"));
			//$this->Common_model->delete_operation(array("table"=>"temp_wishlist" , "where"=>"(application_sess_temp_id = $result->customers_id and store_id!=$result->stores_id)"));
			return $result;
		}
		
		else
		{
			if(!empty($_POST['doLoginG']))
			{
				$registered_via = "Social Media";
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
				
				$reg_data['registered_via'] = $registered_via;
				$reg_data['registered_device'] = $last_screen;
				$reg_data['name'] = $_POST['p_name'];
				$reg_data['first_name'] = $_POST['p_name'];
				$reg_data['last_name'] = '';
				$reg_data['email'] = $_POST['email'];
				$reg_data['country_id'] = 1;
				$reg_data['number'] = '';
				$reg_data['password'] = '';
				$reg_data['show_password'] = '';
				$reg_data['updated_on'] = date('Y-m-d H:i:s');
				$reg_data['added_on'] = date('Y-m-d H:i:s');
				$reg_data['status'] = 1;
				$reg_data['password_recovery_id'] = 0;
				$reg_data['type'] = 0;
				$reg_data['is_guest'] = 0;
				$customers_id = $this->Common_model->add_operation(array('table'=>'customers' , 'data'=>$reg_data ));
				
				$subject = "Welcome To My PRJ";
				$mailMessage = file_get_contents(APPPATH.'mailer/registration.html');
				$mailMessage = preg_replace('/\\\\/','', $mailMessage); //Strip backslashes
				$mailMessage = str_replace("#name#",stripslashes($_POST['p_name']),$mailMessage);
				$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
				$mailMessage = str_replace("#mainsitepp#",base_url().__privacyPolicy__,$mailMessage);
				$mailMessage = str_replace("#mainsitecontact#",base_url().__contactUs__,$mailMessage);
				$mailMessage = str_replace("#mainsitefaq#",base_url().__faq__,$mailMessage);
				
				$gtm_signup_con_tag = "<script> gtag('event', 'conversion', {'send_to': 'AW-10785804854/iRV9CN-nyf8CELakiZco'});</script>";
				//$this->session->set_flashdata('gtm_signup_con_tag', $gtm_signup_con_tag);
				
				$gtm_tag1='';
				if(!empty($_POST['login_method']))
				{
					if($_POST['login_method']=="facebook")
					{
						$gtm_tag1 = "<script>gtag('event', 'sign_up', {    'send_to': ".__gtag_send_to__.",    'method': 'facebook'  });</script>".$gtm_signup_con_tag;
						$this->session->set_userdata('gtm_tag_signup',$gtm_tag1);
					}
					else
					{
						$gtm_tag1 = "<script>gtag('event', 'sign_up', {    'send_to': ".__gtag_send_to__.",    'method': 'gmail'  });</script>".$gtm_signup_con_tag;
						$this->session->set_userdata('gtm_tag_signup',$gtm_tag1);
						
					}
				}
				
				
				
				$mailStatus = $this->Common_model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$_POST['email'] , "name"=>$_POST['p_name'] ));
				$this->db
				->select('c.*')
				->from('customers as c')
				->where('customers_id' , $customers_id)
				->limit(1);
				$result = $this->db->get();
				$result = $result->result();
				$result = $result[0];
				
				$temp_id = $this->session->userdata('application_sess_temp_id');
				$this->Common_model->update_operation(array("table"=>"temp_wishlist" , "data"=>array("application_sess_temp_id"=>$result->customers_id ), "condition"=>"(application_sess_temp_id = $temp_id)"));
				$this->Common_model->update_operation(array("table"=>"temp_cart" , "data"=>array("application_sess_temp_id"=>$result->customers_id) , "condition"=>"(application_sess_temp_id = $temp_id)"));
				
				$sql_get_list="DELETE tc2 FROM temp_cart tc1, temp_cart tc2 WHERE tc1.temp_cart_id > tc2.temp_cart_id AND tc1.application_sess_temp_id = tc2.application_sess_temp_id AND tc1.product_id = tc2.product_id AND tc1.product_in_store_id = tc2.product_in_store_id ";
				$query_get_list=$this->db->query($sql_get_list);
				
				$sql_get_list="DELETE tc1 FROM temp_wishlist tc1, temp_wishlist tc2 WHERE tc1.temp_wishlist_id > tc2.temp_wishlist_id AND tc1.application_sess_temp_id = tc2.application_sess_temp_id AND tc1.product_id = tc2.product_id AND tc1.product_in_store_id = tc2.product_in_store_id ";
				$query_get_list=$this->db->query($sql_get_list);
				
				return $result;
			}
			else
			{ return 'error'; }
		}
		
	}
	
	function doForegotPasswordUser($params = array())
	{
		$status = true;
		$email = $_POST['emailF'];
		
		$this->db
		->select('c.*')
		->from('customers as c')
		->where('email' , $email)
		->limit(1);
		$result = $this->db->get();
		if($result->num_rows() > 0 )
		{
			$result = $result->result();
			return $result[0];
		}
		else
		{
			return 'error';
		}
		
	}
	
	function doUpdateUserPassword($params = array())
	{
		$status = true;
		$reg_data['password'] = base64_encode($_POST['password']);
		$reg_data['show_password'] = $_POST['password'];
		$reg_data['updated_on'] = date('Y-m-d H:i:s');
		$reg_data['password_recovery_id'] = 0;
		$reg_data['is_guest'] = 0;
		return $this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$reg_data , 'condition'=>"password_recovery_id = '$params[password_recovery_id]'"));
		
	}
}

?>