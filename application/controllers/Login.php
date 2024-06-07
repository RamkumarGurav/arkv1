<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Main.php');
class Login extends Main {

	public function __construct()
	{
		parent::__construct();
        $this->load->database();
		//$this->load->library('session');
		$this->load->model('Common_model');
		$this->load->model('Login_model');
		$this->load->library('Rules_Lib');
		$this->load->library('Add_Update_Data_Lib');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->session->set_userdata('application_sess_store_id',1);
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
		$this->data['is_valid_username'] = 0;
		$this->data['store_id'] = 1;
		$this->data['otp'] = '';
		$this->data['action'] = '';
		$this->data['message']='';
		$this->data['message1']='';
		$this->data['bodyClass']=' login-bg';
		if(!empty($this->data['temp_name']) && !empty($this->data['temp_id']) ){
			REDIRECT(base_url(__dashboard__));
		}
		$this->data['currency'] = parent::setCurrency(array());

		$this->session->set_userdata('application_sess_currency_id',1);
		$this->session->set_userdata('application_sess_country_id',__const_country_id__);
		$app_sess_currency_id = $this->session->userdata('application_sess_currency_id');
		if(empty($app_sess_currency_id) && false)
		{
			$user_ip = getenv('REMOTE_ADDR');
			//$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
			if(!empty($geo["geoplugin_countryName"]))
			{
				if($geo["geoplugin_countryName"]=='India')
				{

					$this->session->set_userdata('application_sess_currency_id',1);
					$this->session->set_userdata('application_sess_country_id',__const_country_id__);
				}
				else
				{
					$country_name = $geo["geoplugin_countryName"];
					$getCountry_data=$this->Common_model->getName(array('select'=>'*' , 'from'=>'country' , 'where'=>"(country_name like '$country_name' and status=1)"));
					if(!empty($getCountry_data))
					{
						$getCountry_data = $getCountry_data[0];
						$this->session->set_userdata('application_sess_currency_id',2);
						$this->session->set_userdata('application_sess_country_id',$getCountry_data->country_id);
					}
					else
					{
						$this->session->set_userdata('application_sess_currency_id',1);
						$this->session->set_userdata('application_sess_country_id',__const_country_id__);
					}

				}
			}
			else
			{
				$this->session->set_userdata('application_sess_currency_id',1);
				$this->session->set_userdata('application_sess_country_id',__const_country_id__);
			}
		}

		$this->_rules = $this->data['_rules'] = new Rules_Lib();
		$this->_audl = $this->data['_audl'] = new Add_Update_Data_Lib();


	}

	public function index()
	{
		$this->data['css'] = array();
		$this->data['js'] = array();
		$this->data['tab'] = 'login';
		$msg = $this->session->flashdata('message');
		if(!empty($msg))
		$this->data['message'] = $this->session->flashdata('message');
		//$this->data['php'] = array('add-script/login_page');
		parent::getHeader('header' , $this->data);
		$this->load->view('login' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function guest_login()
	{

		if(isset($_POST['doGuestLoginBTN']))
		{
			//$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			//$this->form_validation->set_rules('email', 'Email', 'trim|required');
			//$this->form_validation->set_rules('number', 'Number', 'trim|required');

			$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');

			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');

			if ($this->form_validation->run() == true)
			{
				//$this->session->set_userdata('application_sess_temp_id','guest');
				$this->session->set_userdata('application_sess_login_type','guest');
				$this->session->set_userdata('application_sess_temp_name',$_POST['name']);
				$this->session->set_userdata('application_sess_temp_number',$_POST['number']);
				$this->session->set_userdata('application_sess_temp_email',$_POST['email']);
				$this->session->set_flashdata('message', '<div class=" alert alert-success">You are successfully sign in.</div>');

				$gtm_tag1 = "<script>gtag('event', 'login', {    'send_to': ".__gtag_send_to__.",    'method': 'guest_login'  });gtag('event', 'conversion', {'send_to': 'AW-10785804854/83c1CPuypP8CELakiZco'});</script>";
				$this->session->set_flashdata('gtm_tag1', $gtm_tag1);

				$redirect = $this->session->userdata('application_sess_redirect');
				if(!empty($redirect))
				{ REDIRECT(base_url($redirect)); }
				else
				{ REDIRECT(base_url()); /*REDIRECT(base_url(__dashboard__));*/ }

			}
			else
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			}
		}
		$this->load->model('Register_model');
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

		$this->data['css'] = array();
		$this->data['js'] = array();
		$this->data['tab'] = 'login';
		$msg = $this->session->flashdata('message');
		if(!empty($msg))
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['php'] = array('add-script/login_page');
		parent::getHeader('header' , $this->data);
		$this->load->view('guest_login' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function updatePassword($password_recovery_id='')
	{
		if(empty($password_recovery_id)){show_404();}
		$this->data['password_recovery_id'] = $password_recovery_id;
		$response = $this->Common_model->getName(array('from'=>'customers' , 'select'=>'*' , 'where'=>"password_recovery_id = '$password_recovery_id'"));
		if(!empty($response))
		{
			$this->session->set_flashdata('message', '');
			$this->data['response'] = $response[0];
			if(isset($_POST['changePasswordBTN']))
			{
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|differs[email]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');
			if($this->form_validation->run() == true)
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$register=$this->Login_model->doUpdateUserPassword(array('password_recovery_id'=>$password_recovery_id));
				if($register>0){
					$this->session->set_flashdata('message', '<div class=" alert alert-success">Your password is successfully updated.</div>');
					REDIRECT(base_url(__login__));
					}
					else{
						$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');
					}
				}
				else
				{
					$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				}
			}
		}
		else
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-danger">Link Expired. Please try again.</div>');
			$this->data['response'] = 'Link Expired';
			REDIRECT(base_url(__login__));
		}
		$this->data['css'] = array();
		$this->data['js'] = array();
		$this->data['php'] = array('add-script/login_page');
		$this->data['tab'] = 'login';
		$msg = $this->session->flashdata('message');
		if(!empty($msg))
		$this->data['message'] = $this->session->flashdata('message');
		parent::getHeader('header' , $this->data);
		$this->load->view('update-password' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	function verify_login_resend_otp()
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

			$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'login_contact'));
			if(!empty($is_exist_otp)){
				$exist_otp_data = $is_exist_otp[0];
				$this->data['otp'] = $otp = $exist_otp_data->otp;
			}
			else{
				$this->data['otp'] = $otp = $this->Common_model->random_password(6 , 'number');
				$add_new_otp_log_params = array('otp'=>$otp , 'contact'=>$contact , 'otp_for'=>'login_contact');
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
		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'login_contact' , 'otp'=>$otp));
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

		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$email , 'otp_for'=>'login_email'));
		if(!empty($is_exist_otp)){
			$exist_otp_data = $is_exist_otp[0];
			$this->data['otp'] = $otp = $exist_otp_data->otp;
		}
		else{
			$this->data['otp'] = $otp = $this->Common_model->random_password(6 , 'number');
			$add_new_otp_log_params = array('otp'=>$otp , 'contact'=>$email , 'otp_for'=>'login_email');
			$this->_audl->add_new_otp_log($add_new_otp_log_params);
		}

		$mailMessage = file_get_contents(APPPATH.'mailer/email_otp_verify.html');
		$mailMessage = str_replace("#name#",stripslashes($name),$mailMessage);
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
		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$email , 'otp_for'=>'login_email' , 'otp'=>$otp));
		if(!empty($is_exist_otp))
		{ return TRUE; }
		else {
			$this->form_validation->set_message('check_email_Otp', 'You Entered wrong OTP.  Please try again.');
			return FALSE;

		}
	}

	public function loginAuth()
	{

		$is_update_username = (!empty($_POST['is_update_username']))?1:0;
		$this->data['is_valid_username'] = 0;
		$username = (!empty($_POST['username']))?trim($_POST['username']):'';
		$message = '';
		$is_email = 0;
		$is_contact = 0;
		if($is_update_username==0)
		{

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
			if(isset($_POST['otp1']) && isset($_POST['otp2']) && isset($_POST['otp3']) && isset($_POST['otp4']) && isset($_POST['otp5']) && isset($_POST['otp6']))
			{
				$_POST['otp'] = $_POST['password'] = $_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5'].$_POST['otp6'];
			}
			//echo $username;

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

				$this->db
				->select('c.*')
				->from('customers as c')
				->where("email = '$username' or number = '$username' ")
				->limit(1);
				$result_user = $this->db->get()->result();
				//pr($result);
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				//echo '<h1>'.$this->data['is_valid_username'].'</h1>';
				if($this->data['is_valid_username'] ==1 && !empty($result_user))
				{
					if(!isset($_POST['otp']))
					{
						if($is_contact)
						{
							$this->verify_login_resend_otp();
						}
						if($is_email)
						{
							$this->verify_email_resend_otp();
						}
						$this->data['is_call_counter'] =1;
						$result_user = $result_user[0];
						$this->Common_model->update_operation(array("table"=>"customers" , "data"=>array("show_password"=>$this->data['otp'], "password"=>base64_encode($this->data['otp']) ), "condition"=>"(customers_id = $result_user->customers_id)"));
						//$message =  '<div class=" alert alert-success">Otp sent to '.$username.'</div>';
					}
					else
					{
						$register=$this->Login_model->doLoginUser();

						if(!empty($register) && $register!= 'emailExist' && $register!='numberExist'){
							$this->session->set_flashdata('message', '<div class=" alert alert-success">Welcome User! You have successfully signed up with us.</div>');
							$this->data['message'] = $this->session->flashdata('message');
							$this->session->set_userdata('application_sess_temp_id',$register->customers_id);
						$this->session->set_userdata('application_sess_temp_name',$register->name);
						$this->session->set_userdata('application_sess_temp_email',$register->email);
						$this->session->set_flashdata('message', '<div class=" alert alert-success">You are successfully sign in.</div>');
						$screen =  $this->Common_model->checkScreen();
						$reg_data['screen'] = 2;
						$gtm_tag1='';
						if($screen == 'isdesktop')
						{
							$reg_data['screen'] = 1;
						}
						//$gtag_con_ = "gtag('event', 'conversion', {'send_to': 'AW-10785804854/83c1CPuypP8CELakiZco'});";
						$login_vias = '';
						if($is_email)
						{
							$login_vias = 'email';
							/*$gtm_tag1 = "<script>gtag('event', 'login', {    'send_to': ".__gtag_send_to__.",    'method': 'email'  });".$gtag_con_."</script>";*/
						}
						else if($is_contact)
						{
							$login_vias = 'number';
								/*$gtm_tag1 = "<script>gtag('event', 'login', {    'send_to': ".__gtag_send_to__.",    'method': 'number'  });".$gtag_con_."</script>";*/
						}


						$this->session->set_flashdata('gtm_tag1', $gtm_tag1);

						$reg_data['customers_id'] = $register->customers_id;
						$reg_data['login_on'] = date('Y-m-d H:i:s');
						$reg_data['agent'] = '';
						$reg_data['ip'] = $this->input->ip_address();;
						if(!empty($_SERVER['HTTP_USER_AGENT']))
							$reg_data['agent'] = $_SERVER['HTTP_USER_AGENT'];


						$this->Common_model->add_operation(array('table'=>'customers_login_log' , 'data'=>$reg_data ));
						$last_screen =  $this->Common_model->checkScreen();
						if($last_screen == 'isdesktop')
						{
							$last_screen = "Desktop";
						}
						else
						{
							$last_screen = "Mobile or Tablet";
						}
						$customers_update_datas = array(
									'password'=>'',
									'show_password'=>'',
									'last_login'=>date('Y-m-d H:i:s') ,
									'last_login_via'=>$login_vias ,
									'last_login_device'=>$last_screen
									);
						$update_response = $this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$customers_update_datas , 'condition'=>"customers_id = $register->customers_id"));

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
							$message =  '<div class=" alert alert-danger">Email is already exist in the database.</div>';
						}
						else if($register=='numberExist'){
							$message =  '<div class=" alert alert-danger">Contact number is already exist in the database.</div>';
						}
						else{
							$message =  '<div class=" alert alert-danger">Something went wrong please try again.</div>';
						}
					}
				}
				else
				{
					$username = '';
					$message = '<div class=" alert alert-danger">Enter valid contact number or email.</div>';
				}
			}
		}

		$this->data['username'] = $username;
		$this->data['message'] = (validation_errors()) ? validation_errors() : $message;

		echo $this->load->view('template/login-form' , $this->data, true);
		if(!empty($redirect_to))
		echo "<script>window.location.href = '$redirect_to';</script>";
		return true;

		$this->data['tab'] = 'login';
		if(isset($_POST['doLoginBTN']))
		{
			//$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|differs[email]');

			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');

			if ($this->form_validation->run() == true)
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$register=$this->Login_model->doLoginUser();

				if($register!='error'){

					$this->session->set_userdata('application_sess_temp_id',$register->customers_id);
					$this->session->set_userdata('application_sess_temp_name',$register->name);
					$this->session->set_userdata('application_sess_temp_email',$register->email);
					$this->session->set_flashdata('message', '<div class=" alert alert-success">You are successfully sign in.</div>');
					$screen =  $this->Common_model->checkScreen();
					$reg_data['screen'] = 2;
					$gtm_tag1='';
					if($screen == 'isdesktop')
					{
						$reg_data['screen'] = 1;
					}
					$gtag_con_ = "gtag('event', 'conversion', {'send_to': 'AW-10785804854/83c1CPuypP8CELakiZco'});";
					$login_vias = '';
					if($_POST['email'] == $register->email)
					{
						$login_vias = 'email';
						$gtm_tag1 = "<script>gtag('event', 'login', {    'send_to': ".__gtag_send_to__.",    'method': 'email'  });".$gtag_con_."</script>";
					}
					else if(!empty($register->contact))
					{
						$login_vias = 'number';
						if($_POST['email'] == $register->contact)
						{
							$gtm_tag1 = "<script>gtag('event', 'login', {    'send_to': ".__gtag_send_to__.",    'method': 'number'  });".$gtag_con_."</script>";
						}
					}


					$this->session->set_flashdata('gtm_tag1', $gtm_tag1);

					$reg_data['customers_id'] = $register->customers_id;
					$reg_data['login_on'] = date('Y-m-d H:i:s');
					$reg_data['agent'] = '';
					$reg_data['ip'] = $this->input->ip_address();;
					if(!empty($_SERVER['HTTP_USER_AGENT']))
						$reg_data['agent'] = $_SERVER['HTTP_USER_AGENT'];


					$this->Common_model->add_operation(array('table'=>'customers_login_log' , 'data'=>$reg_data ));
					$last_screen =  $this->Common_model->checkScreen();
					if($last_screen == 'isdesktop')
					{
						$last_screen = "Desktop";
					}
					else
					{
						$last_screen = "Mobile or Tablet";
					}
					$customers_update_datas = array(
								'last_login'=>date('Y-m-d H:i:s') ,
								'last_login_via'=>$login_vias ,
								'last_login_device'=>$last_screen
								);
					$update_response = $this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$customers_update_datas , 'condition'=>"customers_id = $register->customers_id"));

					$redirect = $this->session->userdata('application_sess_redirect');
					if(!empty($redirect))
					{ REDIRECT(base_url($redirect)); }
					else
					{ REDIRECT(base_url()); /*REDIRECT(base_url(__dashboard__));*/ }
				}
				else if($register=='error'){
					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Email/Mobile number or password is incorrect.</div>');
				}
				else{
					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');
				}
			}
		}
		else if(isset($_POST['doLoginG']))
		{
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			//$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|differs[email]');

			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');

			if ($this->form_validation->run() == true)
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$register=$this->Login_model->doLoginUser();
				//print_r($register);
				if($register!='error'){

					$this->session->set_userdata('application_sess_temp_id',$register->customers_id);
					$this->session->set_userdata('application_sess_temp_name',$register->name);
					$this->session->set_userdata('application_sess_temp_email',$register->email);
					$this->session->set_flashdata('message', '<div class=" alert alert-success">You are successfully sign in.</div>');
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
					$last_login_via = "Social Media";
					if(!empty($_POST['login_method']))
					{
						$last_login_via = $_POST['login_method'];
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
					$customers_update_datas = array(
						'last_login'=>date('Y-m-d H:i:s') ,
						'last_login_via'=>$last_login_via,
						'last_login_device'=>$last_screen
						);

					$update_response = $this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$customers_update_datas  , 'condition'=>"customers_id = $register->customers_id"));

					/*$redirect = $this->session->userdata('application_sess_redirect');
					if(!empty($redirect))
					{ REDIRECT(base_url($redirect)); }
					else
					{ REDIRECT(base_url()); }*/
				}
				else if($register=='error'){
					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Email-id or password is incorrect.</div>');
				}
				else{
					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');
				}
			}
			return true;
			exit;
		}
		else
		{
			redirect(base_url(__login__));
		}

		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message1'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message1');
		$this->data['css'] = array();
		$this->data['js'] = array();
		$this->data['php'] = array('add-script/login_page');
		parent::getHeader('header' , $this->data);
		$this->load->view('login' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

}
