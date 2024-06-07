<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Main.php');
class Register extends Main {

	public function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->model('Register_model');
		$this->load->model('Common_model');
		//$this->load->library('session');
		$this->load->library('Rules_Lib');
		$this->load->library('Add_Update_Data_Lib');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['action'] = '';
		$this->session->set_userdata('application_sess_store_id',1);
		$this->data['message']='';
		$this->data['temp_name'] = $this->session->userdata('application_sess_temp_name');
		$this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');
		$this->data['store_id'] = $this->session->userdata('application_sess_store_id');
		$this->data['login_type'] = $this->session->userdata('application_sess_login_type');
		if(empty($this->data['temp_id']))
		{
			$sess_temp_id = date("dmYhis");
			if(empty($_COOKIE["application_user"]))
			{
				setcookie("application_user", $sess_temp_id, time() + (86400 * 365), "/");
				$this->session->set_userdata('application_sess_temp_id',$sess_temp_id);
			}
			else
			{
				$this->session->set_userdata('application_sess_temp_id',$_COOKIE["application_user"]);
			}
		}
		$this->data['store_id'] = 1;
		//$this->data['currency'] = parent::setCurrency(array());
		$this->data['currency'] = array();
		$this->data['bodyClass']=' login-bg';
		$this->_rules = $this->data['_rules'] = new Rules_Lib();
		$this->_audl = $this->data['_audl'] = new Add_Update_Data_Lib();
	}

	public function index()
	{

		$this->data['meta_title'] = _project_name_." - Sign Up";
		$this->data['meta_description'] = _project_name_." - Sign Up";
		$this->data['meta_keywords'] = _project_name_." - Sign Up";
		$this->data['meta_others'] = "";
		$this->data['is_valid_username'] = 0;

		$this->data['country'] = $this->Register_model->getCountry();
		$options = array();
		$options = array('' => 'Select Country');
		if(!empty($this->data['country']))
		{
			foreach($this->data['country'] as $c)
			{
				$options[$c->country_id]  = $c->country_name.'( '.$c->country_code.' )';
			}
		}
		$this->data['options'] = $options;

		if( !empty($this->data['temp_name']) && !empty($this->data['temp_id']) )
		{
			$redirect = $this->session->userdata('application_sess_redirect');
					if(!empty($redirect))
					{ REDIRECT(base_url($redirect)); }
					else
					{ REDIRECT(base_url()); /*REDIRECT(base_url(__dashboard__));*/ }
		}

		$this->data['css'] = array();
		$this->data['js'] = array();
		$this->data['direct_js'] = array( 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js','https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js');//, 'js/all-scripts.js'
		//pr($this->data['options'], 1);
		parent::getHeader('header' , $this->data);
		$this->load->view('register' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	function verify_register_resend_otp()
	{
		$this->data['is_valid_username'] = 0;
		$username = (!empty($_POST['username']))?trim($_POST['username']):'';
		$is_email = 0;
		$is_contact = 0;
		if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$is_email = 1;
		  $emailErr = "email format";
		  $this->data['is_valid_username'] = 1;
		}
		else if(is_numeric($username) && strlen($username) == 10)
		{
			$is_contact = 1;
			$emailErr = "contact format";
			$this->data['is_valid_username'] = 1;
		}
		if($is_contact == 1)
		{
			$contact = $username;
			$name = "User";

			$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'register_contact'));
			if(!empty($is_exist_otp)){
				$exist_otp_data = $is_exist_otp[0];
				$otp = $exist_otp_data->otp;
			}
			else{
				$otp = $this->Common_model->random_password(6 , 'number');
				$add_new_otp_log_params = array('otp'=>$otp , 'contact'=>$contact , 'otp_for'=>'register_contact');
				$this->_audl->add_new_otp_log($add_new_otp_log_params);
			}

			$template = "{$otp} is the verification code to log in to your "._brand_name_." account. DO NOT share this code with anyone including delivery agents. "._project_web_." #{$otp}";
			$this->Common_model->send_sms($contact , $template);
		}
	}

	public function check_contact_Otp($otp)
	{
		$contact = $username = (!empty($_POST['username']))?trim($_POST['username']):'';
		$name = "User";
		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'register_contact' , 'otp'=>$otp));
		if(!empty($is_exist_otp))
		{ return TRUE; }
		else {
			$this->form_validation->set_message('check_contact_Otp', 'You Entered wrong OTP.  Please try again.');
			return FALSE;

		}
	}

	function verify_email_resend_otp()
	{
		$email = $username = (!empty($_POST['username']))?trim($_POST['username']):'';
		$name = "User";

		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$email , 'otp_for'=>'register_email'));
		if(!empty($is_exist_otp)){
			$exist_otp_data = $is_exist_otp[0];
			$otp = $exist_otp_data->otp;
		}
		else{
			$otp = $this->Common_model->random_password(6 , 'number');
			$add_new_otp_log_params = array('otp'=>$otp , 'contact'=>$email , 'otp_for'=>'register_email');
			$this->_audl->add_new_otp_log($add_new_otp_log_params);
		}

		$mailMessage = file_get_contents(APPPATH.'mailer/email_otp_verify.html');
		// $mailMessage = str_replace("#name#",stripslashes($name),$mailMessage);
		$mailMessage = str_replace("#otp#",stripslashes($otp),$mailMessage);

		$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
		//$mailMessage = str_replace("#mainsitepp#",base_url().__privacyPolicy__,$mailMessage);
		$mailMessage = str_replace("#mainsitecontact#",base_url().__contactUs__,$mailMessage);
		//$mailMessage = str_replace("#mainsitefaq#",base_url().__faq__,$mailMessage);
		$mailMessage = str_replace("#mainsiteaccount#",base_url().__dashboard__,$mailMessage);

		$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
		$mailMessage = str_replace("#social_media#","",$mailMessage);
		$mailMessage = str_replace("#project_contact#",_project_contact_,$mailMessage);
		$mailMessage = str_replace("#project_contact_without_space#",_project_contact_without_space_,$mailMessage);
		$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
		$mailMessage = str_replace("#project_website#",_project_web_,$mailMessage);
		$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);

		$subject = "Verify your email "._brand_name_;
		$mailStatus = $this->Common_model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$email , "name"=>"User" ));

	}

	public function check_email_Otp($otp)
	{
		$email = $username = (!empty($_POST['username']))?trim($_POST['username']):'';
		$name = "user";
		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$email , 'otp_for'=>'register_email' , 'otp'=>$otp));
		if(!empty($is_exist_otp))
		{ return TRUE; }
		else {
			$this->form_validation->set_message('check_email_Otp', 'You Entered wrong OTP.  Please try again.');
			return FALSE;

		}
	}

	public function auth()
	{
		//echo "<pre>";print_r($_POST);exit;
		$is_payment_page = 0;
		if(!empty($_POST['payment-page']))
		{
			$is_payment_page = 1;
		}
		$this->data['is_valid_username'] = 0;
		$username = (!empty($_POST['username']))?trim($_POST['username']):'';
		$is_email = 0;
		$is_contact = 0;
		if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
		  $emailErr = "email format";
		  $this->data['is_valid_username'] = 1;
		  $is_email = 1;
		}
		else if(is_numeric($username) && strlen($username) == 10)
		{
			$emailErr = "contact format";
			$this->data['is_valid_username'] = 1;
			$is_contact = 1;
		}
		else
		{
			$emailErr = "error";
		}
		$this->data['country'] = $this->Register_model->getCountry();
		$options = array();
		$options = array('' => 'Select Country');
		if(!empty($this->data['country']))
		{
			foreach($this->data['country'] as $c)
			{
				$options[$c->country_id]  = $c->country_name.'( '.$c->country_code.' )';
			}
		}
		$this->data['options'] = $options;

		if(isset($_POST['addUserInfoBTN']) || true)
		{
			$this->form_validation->set_rules('username', 'Email or contact number is required', 'trim|required');
			if($this->data['is_valid_username'] == 1 && isset($_POST['otp']))
			{
				if($is_email ==1)
				{
					$this->form_validation->set_rules('otp', 'OTP', 'numeric|trim|required|min_length[6]|max_length[6]|callback_check_email_Otp');
				}
				else
				{
					$this->form_validation->set_rules('otp', 'OTP', 'numeric|trim|required|min_length[6]|max_length[6]|callback_check_contact_Otp');
				}
			}
			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');

			if ($this->form_validation->run() == true)
			{


				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				if($this->data['is_valid_username'] ==1)
				{
					if(!isset($_POST['otp']))
					{
						if($is_contact)
						{
							$this->verify_register_resend_otp();
						}
						if($is_email)
						{
							$this->verify_email_resend_otp();
						}
						$this->data['is_call_counter'] =1;
						$this->session->set_flashdata('message', '<div class=" alert alert-success">Otp sent to '.$username.'</div>');
					}
					else
					{
						$register=$this->Register_model->doAddUser();

						if($register>0){
							$this->session->set_flashdata('message', '<div class=" alert alert-success">Welcome Aboard! You have successfully signed up with us.</div>');
							$this->data['message'] = $this->session->flashdata('message');
							$customerData = $this->Common_model->getName(array('select'=>'*' , 'from'=>'customers' , 'where'=>"customers_id=$register" ));
							$register = $customerData = $customerData[0];
							$temp_id = $this->session->userdata('application_sess_temp_id');

							$this->Common_model->update_operation(array("table"=>"temp_wishlist" , "data"=>array("application_sess_temp_id"=>$customerData->customers_id ), "condition"=>"(application_sess_temp_id = $temp_id)"));
							$this->Common_model->update_operation(array("table"=>"temp_cart" , "data"=>array("application_sess_temp_id"=>$customerData->customers_id) , "condition"=>"(application_sess_temp_id = $temp_id)"));

							$sql_get_list="DELETE tc2 FROM temp_cart tc1, temp_cart tc2 WHERE tc1.temp_cart_id > tc2.temp_cart_id AND tc1.application_sess_temp_id = tc2.application_sess_temp_id AND tc1.product_id = tc2.product_id AND tc1.product_in_store_id = tc2.product_in_store_id ";
							$query_get_list=$this->db->query($sql_get_list);

							$sql_get_list="DELETE tc1 FROM temp_wishlist tc1, temp_wishlist tc2 WHERE tc1.temp_wishlist_id > tc2.temp_wishlist_id AND tc1.application_sess_temp_id = tc2.application_sess_temp_id AND tc1.product_id = tc2.product_id AND tc1.product_in_store_id = tc2.product_in_store_id ";
							$query_get_list=$this->db->query($sql_get_list);

							if($is_contact == 1)
							{
								$contact = $customerData->number;

								$template = "Dear $customerData->name, Thank you for registering with us "._SMS_BRAND_;
								$this->Common_model->send_sms($contact , $template);
							//	$template = "Dear $customerData->name, thank you for choosing "._SMS_BRAND_;
								//$this->Common_model->send_sms($contact , $template);
							}
							if($is_email == 1 && false)
							{
								$subject = "Welcome To MY PRJ";
								$mailMessage = file_get_contents(APPPATH.'mailer/registration.html');
								$mailMessage = preg_replace('/\\\\/','', $mailMessage); //Strip backslashes
								$mailMessage = str_replace("#name#",stripslashes($customerData->name),$mailMessage);
								$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
								$mailMessage = str_replace("#mainsitepp#",base_url().__privacyPolicy__,$mailMessage);
								$mailMessage = str_replace("#mainsitecontact#",base_url().__contactUs__,$mailMessage);
								$mailMessage = str_replace("#mainsitefaq#",base_url().__faq__,$mailMessage);
								$mailStatus = $this->Common_model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$customerData->email , "name"=>$customerData->name ));
							}

							/*$gtm_tag2 = "<script>gtag('event', 'sign_up', {    'send_to': ".__gtag_send_to__.",    'method': 'Website'  });</script>";
							$this->session->set_flashdata('gtm_tag2', $gtm_tag2);

							$gtm_signup_con_tag = "<script> gtag('event', 'conversion', {'send_to': 'AW-10785804854/iRV9CN-nyf8CELakiZco'});";
							$this->session->set_flashdata('gtm_signup_con_tag', $gtm_signup_con_tag);*/





							$this->session->set_flashdata('message', '<div class=" alert alert-success">Welcome Aboard! You have successfully signed up with us.</div>');
							$this->session->set_flashdata('alert_message', '<div class=" alert alert-success">Welcome Aboard! You have successfully signed up with us.</div>');

							$this->session->set_userdata('application_sess_temp_id',$register->customers_id);
							$this->session->set_userdata('application_sess_temp_name',$register->name);
							$this->session->set_userdata('application_sess_temp_email',$register->email);

							$screen =  $this->Common_model->checkScreen();
							$reg_data['screen'] = 2;
							if($screen == 'isdesktop')
							{
								$reg_data['screen'] = 1;
							}

							$reg_data['customers_id'] = $register->customers_id;
							$reg_data['login_on'] = date('Y-m-d H:i:s');
							$reg_data['agent'] = '';
							$reg_data['ip'] = $this->input->ip_address();;
							if(!empty($_SERVER['HTTP_USER_AGENT']))
								$reg_data['agent'] = $_SERVER['HTTP_USER_AGENT'];


							$this->Common_model->add_operation(array('table'=>'customers_login_log' , 'data'=>$reg_data ));

							$update_response = $this->Common_model->update_operation(array('table'=>'customers' , 'data'=>array('last_login'=>date('Y-m-d H:i:s')) , 'condition'=>"customers_id = $register->customers_id"));

							$redirect = $this->session->userdata('application_sess_redirect');
							if(!empty($redirect))
							{
								//REDIRECT(base_url($redirect));
								$redirect_to = base_url($redirect);
							}
							else
							{
								 //REDIRECT(base_url().'all-products');
								 $redirect_to = base_url().'all-products';
							}


						}
						else if($register=='emailExist'){
							$this->session->set_flashdata('message', '<div class=" alert alert-danger">Email is already exist in the database.</div>');
						}
						else if($register=='numberExist'){
							if($is_payment_page ==1)
							{
								$redirect_to = '';
								if($this->check_contact_Otp($_POST['otp']))
								{
									$customerData = $this->Common_model->getName(array('select'=>'*' , 'from'=>'customers' , 'where'=>"number='".$_POST['username']."'" ));
									if(!empty($customerData))
									{
										$temp_id = $this->session->userdata('application_sess_temp_id');
										$customerData = $customerData[0];
										$this->session->set_userdata('application_sess_temp_id',$customerData->customers_id);
										$this->session->set_userdata('application_sess_temp_name',$customerData->name);
										$this->session->set_userdata('application_sess_temp_email',$customerData->email);
										$this->session->set_flashdata('message', '<div class=" alert alert-success">You are successfully sign in.</div>');

										$this->Common_Model->delete_operation(array("where"=>array('contact'=>$_POST['username'] , 'otp_for'=>'register_contact' , 'otp'=>$_POST['otp']) , "table"=>'otp_log' ));


										$this->Common_model->update_operation(array("table"=>"temp_wishlist" , "data"=>array("application_sess_temp_id"=>$customerData->customers_id ), "condition"=>"(application_sess_temp_id = $temp_id)"));
										$this->Common_model->update_operation(array("table"=>"temp_cart" , "data"=>array("application_sess_temp_id"=>$customerData->customers_id) , "condition"=>"(application_sess_temp_id = $temp_id)"));

										$sql_get_list="DELETE tc2 FROM temp_cart tc1, temp_cart tc2 WHERE tc1.temp_cart_id > tc2.temp_cart_id AND tc1.application_sess_temp_id = tc2.application_sess_temp_id AND tc1.product_id = tc2.product_id AND tc1.product_in_store_id = tc2.product_in_store_id ";
										$query_get_list=$this->db->query($sql_get_list);

										$sql_get_list="DELETE tc1 FROM temp_wishlist tc1, temp_wishlist tc2 WHERE tc1.temp_wishlist_id > tc2.temp_wishlist_id AND tc1.application_sess_temp_id = tc2.application_sess_temp_id AND tc1.product_id = tc2.product_id AND tc1.product_in_store_id = tc2.product_in_store_id ";


										$redirect_to = base_url('payment');
									}
									else
									{
										$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong. Please try again.</div>');
									}
								}
							}
							else
							{
								$this->session->set_flashdata('message', '<div class=" alert alert-danger">Contact number is already exist in the database.</div>');
							}

						}
						else{
							$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');
						}
					}
				}
				else
				{
					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Enter valid contact number or email.</div>');
				}
			}
		}
		else
		{
			//redirect(base_url(__register__));
		}
		if($is_payment_page ==1)
		{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			echo $this->load->view('template/register-form-payment' , $this->data, true);
			if(!empty($redirect_to))
			echo "<script>window.location.href = '$redirect_to';</script>";
		}
		else
		{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			echo $this->load->view('template/register-form' , $this->data, true);
			if(!empty($redirect_to))
			echo "<script>window.location.href = '$redirect_to';</script>";
		}
	}

	public function check_Password($pwd)
	{
		$dataArray=array(
			'password'=>$pwd
		);
		$response =  $this->_rules->check_Password($dataArray);
		if($response['success'])
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_Password', $response['errors']);
			return FALSE;
		}
	}

}
