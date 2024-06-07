<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Main.php');

class Dashboard extends Main {



	public function __construct()

	{

		parent::__construct();

        $this->load->database();

		$this->load->model('Dashboard_model');

		$this->load->model('Common_model');

		//$this->load->library('session');

		$this->load->library('Rules_Lib');

		$this->load->model('Checkout_model');

		$this->load->library('Add_Update_Data_Lib');

		$this->load->helper('form');

		$this->load->library('form_validation');

		include_once(APPPATH.'models/administrator/Database_Tables.php');
		$this->load->model('administrator/orders/Orders_Model');

		$this->load->helper('url');

		$this->data['action'] = '';

		$this->data['message']='';

		$this->data['message1']='';

		$this->session->set_userdata('application_sess_store_id',1);

		$this->data['temp_name'] = $this->session->userdata('application_sess_temp_name');

		$this->data['login_type'] = $this->session->userdata('application_sess_login_type');

		$this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');

		$this->data['store_id'] = $this->session->userdata('application_sess_store_id');

		$this->data['store_id'] = 1;

		$this->Common_Model->getWishlistItemCount();

		$this->data['wishlist_count'] = $this->session->userdata('application_sess_wishlist_count');

		if(empty($this->data['temp_name']) || empty($this->data['temp_id']) ||  $this->data['login_type'] == 'guest'){



			if( $this->data['login_type'] == 'guest')

			{

				REDIRECT(base_url());

			}

			$this->session->set_flashdata('message', '<div class=" alert alert-danger">Session out. Please login again!</div>');

			REDIRECT(base_url(__login__));

		}

		$this->data['profile'] = $this->Dashboard_model->getProfile(array('customers_id'=>$this->data['temp_id']));

		$this->data['customers_del_address'] = $this->Common_model->getName(array('select'=>'c.* ' , 'from'=>'customers_address as c' , 'where'=>"c.delivery_status=1 and  c.customers_id=".$this->data['temp_id'] ));





		$application_post_country_id='';

			$this->data['customers_del_address'] = $this->Common_model->getName(array('select'=>'c.* ' , 'from'=>'customers_address as c' , 'where'=>"c.delivery_status=1 and  c.customers_id=".$this->data['temp_id'] ));

			if(!empty($this->data['customers_del_address']))

			{

				$this->data['customers_del_address'] = $this->data['customers_del_address'][0];



				$application_post_country_id = $this->data['customers_del_address']->country_id;

				$this->session->set_userdata('application_sess_country_id',$application_post_country_id);

			}

			else

			{

				$application_post_country_id == __const_country_id__;

				$this->session->set_userdata('application_sess_country_id',$application_post_country_id);

			}

		if($application_post_country_id == __const_country_id__)

		$this->session->set_userdata('application_sess_currency_id',1);

		else

		$this->session->set_userdata('application_sess_currency_id',2);

		if($this->data['profile']->is_guest==1)

		{

			$this->session->set_flashdata('message', '<div class=" alert alert-warning">You are a guest user. Please <a href="'.base_url().__logout__.'">Logout</a> and Click on the foregot password to access my account!</div>');

			REDIRECT(base_url(__cart__));

		}





		$this->_rules = $this->data['_rules'] = new Rules_Lib();

		$this->_audl = $this->data['_audl'] = new Add_Update_Data_Lib();



		//$this->data['currency'] = parent::setCurrency(array());

		//$this->output->enable_profiler(TRUE);

	}



	public function index()

	{

		$this->data['profileOrdersCount'] = $this->Dashboard_model->profileOrdersCount(array('customers_id'=>$this->data['temp_id']));

		$this->data['profileWishlistCount'] = $this->Dashboard_model->profileWishlistCount(array('customers_id'=>$this->data['temp_id']));



		$this->data['user'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));

		$msg = $this->session->flashdata('message');

		if(!empty($msg))

		$this->data['message'] = $this->session->flashdata('message');

		$this->data['css'] = array();

		$this->data['js'] = array();

		$this->data['active_left_menu'] = 'profile_information';

		parent::getHeader('header' , $this->data);

		$this->load->view('dashboard' , $this->data);

		parent::getFooter('footer' , $this->data);

	}



	public function contact_email_verify()

	{

		$this->load->helper('form');

		$this->load->library('form_validation');

		$email = $this->data['profile']->email;

		$contact = $this->data['profile']->number;

		$name = $this->data['profile']->name;

		$customers_id = $this->data['profile']->customers_id;

		if(isset($_POST['verifyContactBTN']))

		{

			$this->form_validation->set_rules('otp', 'OTP', 'required|callback_check_contact_Otp');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->Common_model->update_operation(array('table'=>'customers' , 'data'=>array('is_contact_verify'=>1) , 'condition'=>"customers_id = $customers_id" ));

				$this->Common_model->delete_operation(array("where"=>array('contact'=>$contact , 'otp_for'=>'verify_contact' , 'otp'=>$_POST['otp']) , "table"=>'otp_log' ));

				$this->session->set_flashdata('message', '<div class=" alert alert-success">Your contact number is successfully verified.</div>');

				REDIRECT(base_url(__contact_email_verify__));

			}

			else

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			}

		}



		if(isset($_POST['verifyEmailBTN']))

		{

			$this->form_validation->set_rules('otp', 'OTP', 'required|callback_check_email_Otp');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->Common_model->update_operation(array('table'=>'customers' , 'data'=>array('is_email_verify'=>1) , 'condition'=>"customers_id = $customers_id" ));

				$this->Common_model->delete_operation(array("where"=>array('contact'=>$email , 'otp_for'=>'verify_email' , 'otp'=>$_POST['otp']) , "table"=>'otp_log' ));

				$this->session->set_flashdata('message', '<div class=" alert alert-success">Your contact number is successfully verified.</div>');

				REDIRECT(base_url(__contact_email_verify__));

			}

			else

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			}

		}



		if($this->data['profile']->is_email_verify == 1 && $this->data['profile']->is_contact_verify == 1)

		{

			$redirect = $this->session->userdata('application_sess_redirect');

			if(!empty($redirect))

			{ REDIRECT(base_url($redirect)); }

			else

			{ REDIRECT(base_url().__dashboard__); }

		}



		$msg = $this->session->flashdata('message');

		if(!empty($msg))

		$this->data['message'] = $this->session->flashdata('message');

		$this->data['css'] = array();

		$this->data['js'] = array();

		parent::getHeader('header' , $this->data);

		$this->load->view('contact_email_verify' , $this->data);

		parent::getFooter('footer' , $this->data);

	}



	function verify_contact_resend_otp()

	{

		$contact = $this->data['profile']->number;

		$name = $this->data['profile']->name;



		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'verify_contact'));

		if(!empty($is_exist_otp)){

			$exist_otp_data = $is_exist_otp[0];

			$otp = $exist_otp_data->otp;

		}

		else{

			$otp = $this->Common_model->random_password(6 , 'number');

			$add_new_otp_log_params = array('otp'=>$otp , 'contact'=>$contact , 'otp_for'=>'verify_contact');

			$this->_audl->add_new_otp_log($add_new_otp_log_params);

		}




		$template = "{$otp} is the verification code to log in to your "._brand_name_." account. DO NOT share this code with anyone including delivery agents. @"._project_web_." #{$otp}";





		$this->Common_model->send_sms($contact , $template);

	}



	public function check_contact_Otp($otp)

	{

		$contact = $this->data['profile']->number;

		$name = $this->data['profile']->name;

		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'verify_contact' , 'otp'=>$otp));

		if(!empty($is_exist_otp))

		{ return TRUE; }

		else {

			$this->form_validation->set_message('check_contact_Otp', 'You Entered wrong OTP.  Please try again.');

			return FALSE;



		}

	}



	function verify_email_resend_otp($email='')

	{
		if(empty($email))
		{
			$email = $this->data['profile']->email;
		}



		$contact = $this->data['profile']->number;

		$name = $this->data['profile']->name;



		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$email , 'otp_for'=>'verify_email'));

		if(!empty($is_exist_otp)){

			$exist_otp_data = $is_exist_otp[0];

			$otp = $exist_otp_data->otp;

		}

		else{

			$otp = $this->Common_model->random_password(6 , 'number');

			$add_new_otp_log_params = array('otp'=>$otp , 'contact'=>$email , 'otp_for'=>'verify_email');

			$this->_audl->add_new_otp_log($add_new_otp_log_params);

		}



		$mailMessage = file_get_contents(APPPATH.'mailer/email-verification-otp.html');

		$mailMessage = str_replace("#name#",stripslashes($name),$mailMessage);

		$mailMessage = str_replace("#OTP#",stripslashes($otp),$mailMessage);
		$mailMessage = str_replace("#OTP_VALIDITY#",stripslashes("10 minutes"),$mailMessage);
		$mailMessage = str_replace("#social_media#","",$mailMessage);
		$mailMessage = str_replace("#social_media#",_project_name_,$mailMessage);
		$mailMessage = str_replace("#project_contact#",_project_contact_without_space_,$mailMessage);
		$mailMessage = str_replace("#project_email#",_project_email_,$mailMessage);
		$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
		$mailMessage = str_replace("#project_website#",_project_name_,$mailMessage);
		$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);


		$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);

		//$mailMessage = str_replace("#mainsitepp#",base_url().__privacyPolicy__,$mailMessage);

		$mailMessage = str_replace("#mainsitecontact#",base_url().__contactUs__,$mailMessage);

		//$mailMessage = str_replace("#mainsitefaq#",base_url().__faq__,$mailMessage);

		$mailMessage = str_replace("#mainsiteaccount#",base_url().__dashboard__,$mailMessage);

		$social_media = '';
			if(_FACEBOOK_!='')
				$social_media = $social_media.'<a href="'._FACEBOOK_.'" target="_blank" ><img src="'.IMAGE.'email/facebook.png" width="25"></a>';
			if(_INSTAGRAM_!='')
				$social_media = $social_media.'<a href="'._INSTAGRAM_.'" target="_blank" ><img src="'.IMAGE.'email/instagram.png" width="25"></a>';
			if(_PINTEREST_!='')
				$social_media = $social_media.'<a href="'._PINTEREST_.'" target="_blank" ><img src="'.IMAGE.'email/pinterest.png" width="25"></a>';
			if(_TWITTER_!='')
				$social_media = $social_media.'<a href="'._TWITTER_.'" target="_blank" ><img src="'.IMAGE.'email/twitter.png" width="25"></a>';
			if(_LINKEDIN_!='')
				$social_media = $social_media.'<a href="'._LINKEDIN_.'" target="_blank" ><img src="'.IMAGE.'email/linkedin.png" width="25"></a>';
			if(_YOUTUBE_!='')
				$social_media = $social_media.'<a href="'._YOUTUBE_.'" target="_blank" ><img src="'.IMAGE.'email/youtube.png" width="25"></a>';
			$mailMessage = str_replace("#social_media#",$social_media,$mailMessage);

		$subject = "Verify your email !"._brand_name_;

		$mailStatus = $this->Common_model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$this->data['profile']->email , "name"=>$this->data['profile']->name ));

		$subject = "Verify your email !"._brand_name_;
		//$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$this->data['profile']->email , "name"=>$this->data['profile']->name ));
		$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$email , "name"=>$this->data['profile']->name ));

	}



	public function check_email_Otp($otp, $email='')

	{
		if(empty($email))
		{
			$email = $this->data['profile']->email;
		}


		$contact = $this->data['profile']->number;

		$name = $this->data['profile']->name;

		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$email , 'otp_for'=>'verify_email' , 'otp'=>$otp));

		if(!empty($is_exist_otp))

		{ return TRUE; }

		else {

			$this->form_validation->set_message('check_email_Otp', 'You Entered wrong OTP.  Please try again.');

			return FALSE;



		}

	}



	public function profile_gst()

	{

		$this->load->helper('form');

		$this->load->library('form_validation');

		$this->data['country'] = $this->Dashboard_model->getCountry();

		$this->data['customer_gst_info_data'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));

		//print_r($this->data['customer_gst_info_data']);exit;

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



		if(isset($_POST['updateUserGSTInfoBTNName']))

		{

			$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');

			$this->form_validation->set_rules('gst_number', 'GST Number', 'alpha_numeric|trim|required|min_length[15]|max_length[15]');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$register=$this->Dashboard_model->doUpdateUserGST(array('customers_id'=>$this->data['temp_id']));

				if($register>0){

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Your GST information is successfully updated.</div>');

					$is_gst_claim = $this->session->userdata('is_gst_claim');

					if($is_gst_claim==1)

					{$this->session->set_userdata('is_gst_claimed', 1);REDIRECT(base_url().__cart__);}

					$redirect = $this->session->userdata('app_sess_redirect');



					if(!empty($redirect))

					{ REDIRECT(base_url($redirect)); }

					else

					{ REDIRECT(base_url().__dashboard__); }

				}

				else if($register=='gstExist'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">GST Number is already exist in the database.</div>');

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



		if(isset($_POST['is_gst_claim']))

		{

			$this->session->set_userdata('is_gst_claim', 1);

			$redirect = $this->session->userdata('app_sess_redirect');

			if(isset($_POST['is_gst']))

			{

				if(!empty($this->data['profile']->company_name) && $this->data['profile']->gst_number)

				{

					$this->session->set_userdata('is_gst_claimed', 1);

					if(!empty($_SERVER['HTTP_REFERER']))

					{

						{ REDIRECT($_SERVER['HTTP_REFERER']); }

					}

					else

					REDIRECT(base_url(__cart__));

				}

			}

			else

			{

				$this->session->set_userdata('is_gst_claimed', 0);

				$this->session->set_userdata('is_gst_claim', 0);

				if(!empty($_SERVER['HTTP_REFERER']))

					{

						{ REDIRECT($_SERVER['HTTP_REFERER']); }

					}

					else

				REDIRECT(base_url(__cart__));

			}

		}





		$msg = $this->session->flashdata('message');

		if(!empty($msg))

		$this->data['message'] = $this->session->flashdata('message');

		$this->data['css'] = array();

		$this->data['js'] = array();

		$this->data['php'] = array( );//'add-script/my-account-menu-for-mobile' ,'add-script/personal-gst-information'

		parent::getHeader('header' , $this->data);

		$this->load->view('personal-gst-information' , $this->data);

		parent::getFooter('footer' , $this->data);





	}



	public function changePassword()

	{

		$this->load->helper('form');

		$this->load->library('form_validation');

		$contact = $this->data['profile']->number;

		$name = $this->data['profile']->name;

		if(isset($_POST['changePasswordInfoBTN']))

		{

			$this->form_validation->set_rules('old_password', 'Old Password', 'required');

			$this->form_validation->set_rules('password', 'New Password', 'required|min_length[5]|differs[email]|differs[old_password]|callback_check_Password');

			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

			$this->form_validation->set_rules('otp', 'OTP', 'required|callback_check_Otp');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$register=$this->Dashboard_model->changeUserPassword(array('customers_id'=>$this->data['temp_id']));

				if($register>0){

					$this->Common_model->delete_operation(array("where"=>array('contact'=>$contact , 'otp_for'=>'change_password' , 'otp'=>$_POST['otp']) , "table"=>'otp_log' ));

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Your password is successfully updated.</div>');

					REDIRECT(base_url(__dashboard__));

				}

				else if($register=='wrongPassword'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">You entered the wrong password.</div>');

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



		$msg = $this->session->flashdata('message');

		if(!empty($msg))

		$this->data['message'] = $this->session->flashdata('message');

		$this->data['css'] = array();

		$this->data['js'] = array();

		parent::getHeader('header' , $this->data);

		$this->load->view('change-password' , $this->data);

		parent::getFooter('footer' , $this->data);

	}



	public function check_Otp($otp)

	{

		$contact = $this->data['profile']->number;

		$name = $this->data['profile']->name;

		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'change_password' , 'otp'=>$otp));

		if(!empty($is_exist_otp))

		{

			return TRUE;

		}

		else

		{

			$this->form_validation->set_message('check_Otp', 'You Entered wrong OTP.  Please try again.');

			return FALSE;



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



	function resend_otp()

	{

		$contact = $this->data['profile']->number;

		$name = $this->data['profile']->name;



		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'change_password'));

		if(!empty($is_exist_otp))

		{

			$exist_otp_data = $is_exist_otp[0];

			$otp = $exist_otp_data->otp;

		}

		else

		{

			$otp = $this->Common_model->random_password(6 , 'number');

			$add_new_otp_log_params = array('otp'=>$otp , 'contact'=>$contact , 'otp_for'=>'change_password');

			$this->_audl->add_new_otp_log($add_new_otp_log_params);

		}




		$template = "{$otp} is the verification code to log in to your "._brand_name_." account. DO NOT share this code with anyone including delivery agents. @"._project_web_." #{$otp}";

		$this->Common_model->send_sms($contact , $template);

	}





	public function update_gender()

	{

		if(isset($_POST))

		{

			$message = '';

			$response = 0;

			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');



				$customers_id = $this->data['temp_id'];

				$update_data['updated_on'] = date('Y-m-d H:i:s');

				$update_data['gender'] = trim($_POST['gender']);



				$register=$this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$update_data , 'condition'=>"(customers_id=$customers_id)" ));

				if($register>0){

					$response = 1;

					$this->data['message'] = '<div class=" alert alert-success">Your gender is successfully updated.</div>';

				}

				else{

					$this->data['message'] = '<div class=" alert alert-danger">Something went wrong please try again.</div>';

				}

			}

			else

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			}

		}

		$message = $this->data['message'];

		echo json_encode(array("message"=>$message, "response"=>$response));

	}



	public function update_personal_info()

	{

		if(isset($_POST))

		{

			$message = '';

			$response = 0;

			$sess_user_name='';

			$sess_first_name = "";

			$sess_last_name = "";

			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');

			//$this->form_validation->set_rules('last_name', 'Last Name', 'alpha_numeric_spaces|trim|required');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');



				$customers_id = $this->data['temp_id'];

				$update_data['updated_on'] = date('Y-m-d H:i:s');

				$update_data['first_name'] = trim($_POST['first_name']);

				$update_data['last_name'] = trim($_POST['last_name']);

				$update_data['name'] = trim(trim($_POST['first_name']).' '.trim($_POST['last_name']));



				$register=$this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$update_data , 'condition'=>"(customers_id=$customers_id)" ));

				if($register>0){

					$response = 1;

					$this->data['message'] = '<div class=" alert alert-success">Your name is successfully updated.</div>';

					$this->session->set_userdata('application_sess_temp_name', $update_data['name']);

					$sess_user_name = $update_data['name'];

					$sess_first_name = $update_data['first_name'];

					$sess_last_name = $update_data['last_name'];

				}

				else{

					$this->data['message'] = '<div class=" alert alert-danger">Something went wrong please try again.</div>';

				}

			}

			else

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			}

		}

		$message = $this->data['message'];

		echo json_encode(array("message"=>$message, "response"=>$response, "sess_user_name"=>$sess_user_name, "sess_first_name"=>$sess_first_name, "sess_last_name"=>$sess_last_name));

	}



	public function update_email_info()

	{

		if(isset($_POST))

		{

			$message = '';

			$response = 0;

			$sess_user_name='';

			$sess_email = "";

			$this->data['is_email_change'] = $is_email_change = false;

			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');

			$subject = _brand_name_." Account - ".$otp." is your verification code for secure access";



			//$this->form_validation->set_rules('last_name', 'Last Name', 'alpha_numeric_spaces|trim|required');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');



				$customers_id = $this->data['temp_id'];

				$update_data['updated_on'] = date('Y-m-d H:i:s');

				$update_data['email'] = trim($_POST['email']);





				$this->data['is_email_change'] = $is_email_change = false;

				if(!empty($this->data['profile']->email) && $this->data['profile']->email != $_POST['email'])

				{

					$this->data['is_email_change'] = $is_email_change = true;

				}



				if($is_email_change)

				{

					if($is_email_change && !empty($_POST['email_otp']))

					{

						$u_email = $_POST['email'];

						$u_otp = $_POST['email_otp'];

						$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$u_email , 'otp_for'=>'update_email' , 'otp'=>$u_otp));

						if(empty($is_exist_otp))

						{

							$this->data['message'] = '<div class=" alert alert-danger">You entered wrong email verification OTP.</div>';

						}

						else

						{

							$is_email_change = false;

						}



					}

				}

				if(!$is_email_change)

				{

					if(!empty($_POST['email_otp']))

					{

						$u_email = $_POST['email'];

						$u_otp = $_POST['email_otp'];

						$this->Common_model->delete_operation(array("where"=>array('contact'=>$u_email , 'otp_for'=>'update_email' , 'otp'=>$u_otp) , "table"=>'otp_log' ));

					}



					$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

					$register=$this->Dashboard_model->doUpdateUser(array('customers_id'=>$this->data['temp_id']));

					if($register>0){

						//$this->session->set_flashdata('message', '<div class=" alert alert-success">Your profile information is successfully updated.</div>');

						$this->data['message'] = '<div class=" alert alert-success">Your profile information is successfully updated.</div>';

						$this->data['is_email_change'] = $is_email_change = false;

						//REDIRECT(base_url(__dashboard__));

					}

					else if($register=='emailExist'){

						//$this->session->set_flashdata('message', '<div class=" alert alert-danger">Email is already exist in the database.</div>');

						$this->data['message'] = '<div class=" alert alert-danger">Email is already exist in the database.</div>';

					}

					else{

						//$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');

						$this->data['message'] = '<div class=" alert alert-danger">Something went wrong please try again.</div>';

					}

				}



				$register=$this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$update_data , 'condition'=>"(customers_id=$customers_id)" ));

				if($register>0){

					$response = 1;

					$this->data['message'] = '<div class=" alert alert-success">Your email is successfully updated.</div>';

					//$this->session->set_userdata('application_sess_temp_name', $update_data['name']);



					$sess_email = $update_data['email'];

				}

				else{

					$this->data['message'] = '<div class=" alert alert-danger">Something went wrong please try again.</div>';

				}

			}

			else

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			}

		}

		$message = $this->data['message'];

		echo json_encode(array("message"=>$message, "response"=>$response, "sess_email"=>$sess_email));

	}



	public function update_number_info()

	{

		if(isset($_POST))

		{

			$message = '';

			$response = 0;

			$sess_user_name='';

			$sess_number = "";

			$this->data['is_number_change'] = $is_number_change = false;

			$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');



				$customers_id = $this->data['temp_id'];

				$update_data['updated_on'] = date('Y-m-d H:i:s');

				$update_data['number'] = trim($_POST['number']);





				$this->data['is_number_change'] = $is_number_change = false;

				if(!empty($this->data['profile']->number) && $this->data['profile']->number != $_POST['number'])

				{

					$this->data['is_number_change'] = $is_number_change = true;

				}



				if($is_number_change)

				{

					if($is_number_change && !empty($_POST['number_otp']))

					{

						$u_number = $_POST['number'];

						$u_otp = $_POST['number_otp'];

						$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$u_number , 'otp_for'=>'update_number' , 'otp'=>$u_otp));

						if(empty($is_exist_otp))

						{

							$this->data['message'] = '<div class=" alert alert-danger">You entered wrong number verification OTP.</div>';

						}

						else

						{

							$is_number_change = false;

						}



					}

				}

				if(!$is_number_change)

				{

					if(!empty($_POST['number_otp']))

					{

						$u_number = $_POST['number'];

						$u_otp = $_POST['number_otp'];

						$this->Common_model->delete_operation(array("where"=>array('contact'=>$u_number , 'otp_for'=>'update_number' , 'otp'=>$u_otp) , "table"=>'otp_log' ));

					}



					$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

					$register=$this->Dashboard_model->doUpdateUser(array('customers_id'=>$this->data['temp_id']));

					if($register>0){

						//$this->session->set_flashdata('message', '<div class=" alert alert-success">Your profile information is successfully updated.</div>');

						$this->data['message'] = '<div class=" alert alert-success">Your profile information is successfully updated.</div>';

						$this->data['is_number_change'] = $is_number_change = false;

						//REDIRECT(base_url(__dashboard__));

					}

					else if($register=='numberExist'){

						//$this->session->set_flashdata('message', '<div class=" alert alert-danger">Email is already exist in the database.</div>');

						$this->data['message'] = '<div class=" alert alert-danger">Email is already exist in the database.</div>';

					}

					else{

						//$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');

						$this->data['message'] = '<div class=" alert alert-danger">Something went wrong please try again.</div>';

					}

				}



				$register=$this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$update_data , 'condition'=>"(customers_id=$customers_id)" ));

				if($register>0){

					$response = 1;

					$this->data['message'] = '<div class=" alert alert-success">Your number is successfully updated.</div>';

					//$this->session->set_userdata('application_sess_temp_name', $update_data['name']);



					$sess_number = $update_data['number'];

				}

				else{

					$this->data['message'] = '<div class=" alert alert-danger">Something went wrong please try again.</div>';

				}

			}

			else

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			}

		}

		$message = $this->data['message'];

		echo json_encode(array("message"=>$message, "response"=>$response, "sess_number"=>$sess_number));

	}



	public function profile_ajax()

	{

		$this->load->helper('form');

		$this->load->library('form_validation');

		$this->data['is_contact_change'] = $is_contact_change = false;

		$this->data['is_email_change'] = $is_email_change = false;

		$this->data['country'] = $this->Dashboard_model->getCountry();

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



		if(isset($_POST))

		{

			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');

			//$this->form_validation->set_rules('last_name', 'Last Name', 'alpha_numeric_spaces|trim|required');

			$this->form_validation->set_rules('country_id', 'Country', 'required');

			$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');

			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{





				$this->data['is_contact_change'] = $is_contact_change = false;

				$this->data['is_email_change'] = $is_email_change = false;

				if($this->data['profile']->number != $_POST['number'])

				{

					$this->data['is_contact_change'] = $is_contact_change = true;

				}



				if($this->data['profile']->email != $_POST['email'])

				{

					$this->data['is_email_change'] = $is_email_change = true;

				}



				if($is_email_change || $is_contact_change)

				{

					if($is_email_change && !empty($_POST['email_otp']))

					{

						$u_email = $_POST['email'];

						$u_otp = $_POST['email_otp'];

						$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$u_email , 'otp_for'=>'update_email' , 'otp'=>$u_otp));

						if(empty($is_exist_otp))

						{

							$this->data['message'] = '<div class=" alert alert-danger">You entered wrong email verification OTP.</div>';

						}

						else

						{

							$is_email_change = false;

						}



					}



					if($is_contact_change && !empty($_POST['contact_otp']))

					{

						$u_conatct = $_POST['number'];

						$u_otp = $_POST['contact_otp'];

						$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$u_conatct , 'otp_for'=>'update_contact' , 'otp'=>$u_otp));

						if(empty($is_exist_otp))

						{

							$this->data['message'] = '<div class=" alert alert-danger">You entered wrong mobile number verification OTP.</div>';

						}

						else

						{

							$is_contact_change = false;

						}



					}



				}

				if(!$is_email_change && !$is_contact_change)

				{



					if(!empty($_POST['email_otp']))

					{

						$u_email = $_POST['email'];

						$u_otp = $_POST['email_otp'];

						$this->Common_model->delete_operation(array("where"=>array('contact'=>$u_email , 'otp_for'=>'update_email' , 'otp'=>$u_otp) , "table"=>'otp_log' ));

					}



					if(!empty($_POST['contact_otp']))

					{

						$u_number = $_POST['number'];

						$u_otp = $_POST['contact_otp'];

						$this->Common_model->delete_operation(array("where"=>array('contact'=>$u_number , 'otp_for'=>'update_contact' , 'otp'=>$u_otp) , "table"=>'otp_log' ));

					}



					$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

					$register=$this->Dashboard_model->doUpdateUser(array('customers_id'=>$this->data['temp_id']));

					if($register>0){

						//$this->session->set_flashdata('message', '<div class=" alert alert-success">Your profile information is successfully updated.</div>');

						$this->data['message'] = '<div class=" alert alert-success">Your profile information is successfully updated.</div>';

						$this->data['is_contact_change'] = $is_contact_change = false;

						$this->data['is_email_change'] = $is_email_change = false;

						//REDIRECT(base_url(__dashboard__));

					}

					else if($register=='emailExist'){

						//$this->session->set_flashdata('message', '<div class=" alert alert-danger">Email is already exist in the database.</div>');

						$this->data['message'] = '<div class=" alert alert-danger">Email is already exist in the database.</div>';

					}

					else if($register=='numberExist'){

						//$this->session->set_flashdata('message', '<div class=" alert alert-danger">Contact number is already exist in the database.</div>');

						$this->data['message'] = '<div class=" alert alert-danger">Contact number is already exist in the database.</div>';

					}

					else{

						//$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');

						$this->data['message'] = '<div class=" alert alert-danger">Something went wrong please try again.</div>';

					}

				}

			}

			else

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			}

		}



		//$msg = $this->session->flashdata('message');

		//if(!empty($msg))

		//$this->data['message'] = $this->session->flashdata('message');

		$this->data['css'] = array();

		$this->data['js'] = array();

		//$this->data['php'] = array( 'add-script/personal-information');//'add-script/my-account-menu-for-mobile' ,

		//parent::getHeader('header' , $this->data);

		$this->load->view('templates/personal-information-template' , $this->data);

		//parent::getFooter('footer' , $this->data);





	}



	function verify_update_contact_resend_otp()

	{

		//$contact = $this->data['profile']->number;

		$contact = $_POST['number'];

		$name = $this->data['profile']->name;



		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'update_contact'));

		if(!empty($is_exist_otp)){

			$exist_otp_data = $is_exist_otp[0];

			$otp = $exist_otp_data->otp;

		}

		else{

			$otp = $this->Common_model->random_password(6 , 'number');

			$add_new_otp_log_params = array('otp'=>$otp , 'contact'=>$contact , 'otp_for'=>'update_contact');

			$this->_audl->add_new_otp_log($add_new_otp_log_params);

		}




		$template = "{$otp} is the verification code to log in to your "._brand_name_." account. DO NOT share this code with anyone including delivery agents. "._project_web_." #{$otp}";

		$this->Common_model->send_sms($contact , $template);

	}



	public function check_update_contact_Otp($otp)

	{

		$contact = $this->data['profile']->number;

		$name = $this->data['profile']->name;

		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'update_email' , 'otp'=>$otp));

		if(!empty($is_exist_otp))

		{ return TRUE; }

		else {

			$this->form_validation->set_message('check_contact_Otp', 'You Entered wrong OTP.  Please try again.');

			return FALSE;



		}

	}






	public function profile()

	{

		$this->load->helper('form');

		$this->load->library('form_validation');

		$this->data['is_contact_change'] = $is_contact_change = false;

		$this->data['is_email_change'] = $is_email_change = false;

		$this->data['country'] = $this->Dashboard_model->getCountry();

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



		if(isset($_POST['updateUserInfoBTNName']))

		{

			$this->data['is_contact_change'] = $is_contact_change = false;

			$this->data['is_email_change'] = $is_email_change = false;

			if($this->data['profile']->number != $_POST['number'])

			{

				$is_contact_change = true;

			}



			if($this->data['profile']->email != $_POST['email'])

			{

				$is_email_change = true;

			}



			if($is_email_change)

			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');

			//$this->form_validation->set_rules('last_name', 'Last Name', 'alpha_numeric_spaces|trim|required');

			$this->form_validation->set_rules('country_id', 'Country', 'required');

			$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');

			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$register=$this->Dashboard_model->doUpdateUser(array('customers_id'=>$this->data['temp_id']));

				if($register>0){

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Your profile information is successfully updated.</div>');

					REDIRECT(base_url(__dashboard__));

				}

				else if($register=='emailExist'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Email is already exist in the database.</div>');

				}

				else if($register=='numberExist'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Contact number is already exist in the database.</div>');

				}

				else{

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');

				}

			}

		}



		if(isset($_POST['updateUserInfoBTNEmail']))

		{

			//$this->form_validation->set_rules('first_name', 'First Name', 'alpha_numeric_spaces|trim|required');

			//$this->form_validation->set_rules('last_name', 'Last Name', 'alpha_numeric_spaces|trim|required');

			//$this->form_validation->set_rules('country_id', 'Country', 'required');

			//$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[8]|max_length[15]');

			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$register=$this->Dashboard_model->doUpdateUser(array('customers_id'=>$this->data['temp_id']));

				if($register>0){

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Your profile information is successfully updated.</div>');

					REDIRECT(base_url(__dashboard__));

				}

				else if($register=='emailExist'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Email is already exist in the database.</div>');

				}

				else if($register=='numberExist'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Contact number is already exist in the database.</div>');

				}

				else{

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');

				}

			}

		}



		if(isset($_POST['updateUserInfoBTNNumber']))

		{

			//$this->form_validation->set_rules('first_name', 'First Name', 'alpha_numeric_spaces|trim|required');

			//$this->form_validation->set_rules('last_name', 'Last Name', 'alpha_numeric_spaces|trim|required');

			$this->form_validation->set_rules('country_id', 'Country', 'required');

			$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[8]|max_length[15]');

			//$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$register=$this->Dashboard_model->doUpdateUser(array('customers_id'=>$this->data['temp_id']));

				if($register>0){

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Your profile information is successfully updated.</div>');

					REDIRECT(base_url(__dashboard__));

				}

				else if($register=='emailExist'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Email is already exist in the database.</div>');

				}

				else if($register=='numberExist'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Contact number is already exist in the database.</div>');

				}

				else{

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');

				}

			}

		}



		if(isset($_POST['changePasswordInfoBTN']))

		{

			$this->form_validation->set_rules('old_password', 'Old Password', 'required');

			$this->form_validation->set_rules('password', 'New Password', 'required|min_length[5]|differs[email]');

			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$register=$this->Dashboard_model->changeUserPassword(array('customers_id'=>$this->data['temp_id']));

				if($register>0){

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Your password is successfully updated.</div>');

					REDIRECT(base_url(__dashboard__));

				}

				else if($register=='wrongPassword'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">You entered the wrong password.</div>');

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



		$msg = $this->session->flashdata('message');

		if(!empty($msg))

		$this->data['message'] = $this->session->flashdata('message');

		$this->data['css'] = array();

		$this->data['js'] = array();

		$this->data['php'] = array( 'add-script/personal-information');//'add-script/my-account-menu-for-mobile' ,

		parent::getHeader('header' , $this->data);

		$this->load->view('personal-information' , $this->data);

		parent::getFooter('footer' , $this->data);



		/*$this->load->helper('form');

		$this->load->library('form_validation');

		$this->data['country'] = $this->Dashboard_model->getCountry();

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





		if(isset($_POST['updateUserInfoBTN']))

		{

			$this->form_validation->set_rules('first_name', 'First Name', 'alpha_numeric_spaces|trim|required');

			//$this->form_validation->set_rules('last_name', 'Last Name', 'alpha_numeric_spaces|trim|required');

			$this->form_validation->set_rules('country_id', 'Country', 'required');

			$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[8]|max_length[15]');

			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$register=$this->Dashboard_model->doUpdateUser(array('customers_id'=>$this->data['temp_id']));

				if($register>0){

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Your profile information is successfully updated.</div>');

					REDIRECT(base_url(__dashboard__));

				}

				else if($register=='emailExist'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Email is already exist in the database.</div>');

				}

				else if($register=='numberExist'){

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Contact number is already exist in the database.</div>');

				}

				else{

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');

				}

			}

		}





		$this->data['css'] = array();

		$this->data['js'] = array();

		$this->data['php'] = array('add-script/my-account-menu-for-mobile');

		parent::getHeader('header' , $this->data);

		$this->load->view('personal-information' , $this->data);

		parent::getFooter('footer' , $this->data);*/

	}



	public function order_tracking()

	{

		$orders_id = $_POST['orders_id'];

		$this->data['orders'] = $this->Dashboard_model->getOrder(array('customers_id'=>$this->data['temp_id'] , 'orders_id'=>$orders_id));

		if(empty($this->data['orders'])){show_404();}

		$html_data = $this->load->view('order_tracking' , $this->data , true);



		echo json_encode(array('html_data'=>$html_data , 'order_courier_name'=>$this->data['orders'][0]->courier_name , 'order_docket_no'=>$this->data['orders'][0]->docket_no));

	}



	public function orderDetails($orders_id='')

	{

		if(empty($orders_id)){show_404();}

			$this->data['orders'] = $this->Dashboard_model->getOrder(array('customers_id'=>$this->data['temp_id'] , 'orders_id'=>$orders_id));

		if(empty($this->data['orders'])){show_404();}

		$this->data['css'] = array();

		$this->data['js'] = array();

		$this->data['php'] = array();//'add-script/my-account-menu-for-mobile'

		parent::getHeader('header' , $this->data);

		$this->load->view('order-details' , $this->data);

		parent::getFooter('footer' , $this->data);

	}



	public function ReOrder($orders_id='')

	{

		if(empty($orders_id)){show_404();}

			$this->data['orders'] = $this->Dashboard_model->getOrder(array('customers_id'=>$this->data['temp_id'] , 'orders_id'=>$orders_id , 'for_reorder'=>1));

		if(empty($this->data['orders'])){show_404();}

		$this->data['css'] = array();

		$this->data['js'] = array();

		$this->data['php'] = array('add-script/my-account-menu-for-mobile');

		parent::getHeader('header' , $this->data);

		$this->load->view('re-order' , $this->data);

		parent::getFooter('footer' , $this->data);

	}



	public function orderInvoice($orders_id='')

	{

		if(empty($orders_id)){show_404();}

			$this->data['orders'] = $this->Dashboard_model->getOrder(array('customers_id'=>$this->data['temp_id'] , 'orders_id'=>$orders_id));

		if(empty($this->data['orders'])){show_404();}

		$this->data['css'] = array();

		$this->data['js'] = array();

		$this->data['php'] = array();//'add-script/my-account-menu-for-mobile'

		$this->load->view('invoice/invoice' , $this->data);

	}

	function track_shiprocket_order_api()
	{
		$orders_id = $_POST['orders_id'];
		//$orders_id = 15;
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>1));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);
		$html = $this->load->view('track_shiprocket_order_api' , $this->data,true);
		echo json_encode(array('template'=>$html));
		die;
	}
	public function track_shiprocket_design($value='')
	{
		parent::getHeader('header' , $this->data);

		$this->load->view('track_shiprocket_status' , $this->data);

		parent::getFooter('footer' , $this->data);
	}

	public function orderHistory()

	{


		$this->data['orders'] = $this->Dashboard_model->getOrder(array('customers_id'=>$this->data['temp_id']));



		$this->data['css'] = array();

		$this->data['js'] = array();

		$this->data['php'] = array();//'add-script/my-account-menu-for-mobile'

		parent::getHeader('header' , $this->data);

		$this->load->view('order-history' , $this->data);

		parent::getFooter('footer' , $this->data);

	}

		public function reviewRatings()

	{

			$this->data['css'] = array();

		$this->data['js'] = array();



		parent::getHeader('header' , $this->data);

		$this->load->view('ratings-reviews' , $this->data);

		parent::getFooter('footer' , $this->data);

	}



	public function shippingAddress()

	{



		$this->load->model('Checkout_model');

		$this->data['user'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));

		$this->data['active_left_menu'] = 'manage_address';



		if(isset($_POST['DeliverBTN']))

		{

			$register=$this->Checkout_model->doUpdateUserDeliverAddress(array('customers_address_id'=>$_POST['customers_address_id'] , 'customers_id'=>$this->data['temp_id']));

			if($register>0){

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Success! Your Delivery address is successfully updated.</div>');

				$redirect = $this->session->userdata('application_sess_redirect');

				if(!empty($redirect))

				{ REDIRECT(base_url($redirect)); }

				else

				{ REDIRECT(base_url().__shippingAddress__); }

			}

			else{

				$this->session->set_flashdata('message', '<div class=" alert alert-danger">Error! Something went wrong please try again.</div>');

			}

		}

		if(isset($_POST['BillingBTN']))

		{

			$register=$this->Checkout_model->doUpdateUserBillingAddress(array('customers_address_id'=>$_POST['customers_address_id'] , 'customers_id'=>$this->data['temp_id']));

			if($register>0){

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Success! Your Billing address is successfully updated.</div>');

				$redirect = $this->session->userdata('application_sess_redirect');

				if(!empty($redirect))

				{ REDIRECT(base_url($redirect)); }

				else

				{ REDIRECT(base_url().__shippingAddress__); }

			}

			else{

				$this->session->set_flashdata('message', '<div class=" alert alert-danger">Error! Something went wrong please try again.</div>');

			}

		}



		if(isset($_POST['DeleteAddress']))

		{

			$customers_id = $this->data['temp_id'];

			$customers_address_id = $_POST['customers_address_id'];

			$update_data['status']=0;

			$update_data['updated_on'] = date('Y-m-d H:i:s');

			$register=$this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$update_data , 'condition'=>"(customers_id=$customers_id and customers_address_id=$customers_address_id)" ));

			if($register>0){

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Success! Your Address is successfully removed.</div>');

				$redirect = $this->session->userdata('application_sess_redirect');

				REDIRECT(base_url().__shippingAddress__);

			}

			else{

				$this->session->set_flashdata('message', '<div class=" alert alert-danger">Error! Something went wrong please try again.</div>');

			}

		}



		if(isset($_POST['AddressBTN']) || isset($_POST['AddressSaveBTN']))

		{

			$this->form_validation->set_rules('name', 'Name', 'alpha_numeric_spaces|trim|required');

			$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');

			$this->form_validation->set_rules('address', 'Address', 'required');

			$this->form_validation->set_rules('country_id', 'Country', 'required');

			$this->form_validation->set_rules('state_id', 'State', 'required');

			$this->form_validation->set_rules('city_id', 'City', 'required');

			$this->form_validation->set_rules('pincode', 'Pincode', 'numeric|trim|required|min_length[6]|max_length[6]');

			$this->form_validation->set_rules('locality', 'Locality');

			$this->form_validation->set_rules('landmark', 'Landmark');

			$this->form_validation->set_rules('alternate_number', 'Alternate Number', 'numeric|trim|min_length[10]|max_length[10]');

			$this->form_validation->set_rules('address_type', 'Address Type');



			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



			if ($this->form_validation->run() == true)

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$register=$this->Checkout_model->doAddUserAddress(array('customers_address_id'=>$_POST['customers_address_id'] , 'customers_id'=>$this->data['temp_id']));



				if($register>0){

					if(empty($_POST['customers_address_id']))

					{

						$this->session->set_flashdata('message', '<div class=" alert alert-success">Success! Your address is successfully inserted.</div>');

					}

					else

					{

						$this->session->set_flashdata('message', '<div class=" alert alert-success">Success! Your address is successfully updated.</div>');

					}

				$redirect = $this->session->userdata('application_sess_redirect');

				if(!empty($redirect))

				{ REDIRECT(base_url($redirect)); }

				else

				{ REDIRECT(base_url().__shippingAddress__); }

				}

				else{

					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Error! Something went wrong please try again.</div>');

				}

			}

			else

			{

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			}

		}

		$this->data['customer_address_data'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));



		$this->data['country']=$this->Common_model->getCountry(array());

		$options = array();

		$options['']  = 'Select Country';

		if(!empty($this->data['country']))

			foreach($this->data['country'] as $c)

				$options[$c->country_id]  = $c->country_name;



		$this->data['countryOptions'] = $options;



		$this->data['css'] = array();

		$this->data['js'] = array();

		$this->data['php'] = array('add-script/my-account-menu-for-mobile');

		$msg = $this->session->flashdata('message1');

		if(!empty($msg))

		$this->data['message1'] = $this->session->flashdata('message1');



		//if(!empty($this->session->flashdata('message')))

		$this->data['message'] = $this->session->flashdata('message');



		$this->data['php'] = array('script/shipment-details');

		parent::getHeader('header' , $this->data);

		$this->load->view('shipping-address' , $this->data);

		parent::getFooter('footer' , $this->data);

	}



	function editUpdateAddress()

	{



		$customers_address_id = $_POST['customers_address_id'];

		$this->data['address_data'] = $this->Common_model->getName(array('select'=>'c.* ' , 'from'=>'customers_address as c' , 'where'=>"c.customers_address_id=$customers_address_id and  c.customers_id=".$this->data['temp_id'] ));

		$this->data['country']=$this->Common_model->getCountry(array());

		$options = array();

		$options['']  = 'Select Country';

		if(!empty($this->data['country']))

			foreach($this->data['country'] as $c)

				$options[$c->country_id]  = $c->country_name;



		$this->data['countryOptions'] = $options;

		echo $this->load->view('template/edit_address' , $this->data, true);

	}



	function do_ship_address()

	{

		$is_update_address = 0;

		$redirect_to = '';



		$this->form_validation->set_rules('name', 'Name', 'alpha_numeric_spaces|trim|required');

		$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');

		$this->form_validation->set_rules('address', 'Address', 'required');

		$this->form_validation->set_rules('country_id', 'Country', 'required');

		$this->form_validation->set_rules('state_id', 'State', 'required');

		$this->form_validation->set_rules('city_id', 'City', 'required');

		$this->form_validation->set_rules('pincode', 'Pincode', 'numeric|trim|required|min_length[6]|max_length[6]');

		$this->form_validation->set_rules('locality', 'Locality');

		if(!empty($_POST['landmark']))

		$this->form_validation->set_rules('landmark', 'Landmark');

		if(!empty($_POST['alternate_number']))

		$this->form_validation->set_rules('alternate_number', 'Alternate Number', 'numeric|trim|min_length[10]|max_length[10]');

		$this->form_validation->set_rules('address_type', 'Address Type');



		$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



		if ($this->form_validation->run() == true)

		{

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$register=$this->Checkout_model->doAddUserAddress(array('customers_address_id'=>$_POST['customers_address_id'] , 'customers_id'=>$this->data['temp_id']));



			if($register>0){

				$is_update_address = 1;

				if(empty($_POST['customers_address_id']))

				{

					$this->data['message'] = '<div class=" alert alert-success">Success! Your address is successfully inserted.</div>';

				}

				else

				{

					$this->data['message'] = '<div class=" alert alert-success">Success! Your address is successfully updated.</div>';

				}

			$redirect = $this->session->userdata('application_sess_redirect');



			if(!empty($redirect))

			{ $redirect_to = base_url($redirect); }

			else

			{ $redirect_to = base_url().__shippingAddress__; }

			}

			else{

				$this->data['message'] = '<div class=" alert alert-danger">Error! Something went wrong please try again.</div>';

			}

		}

		else

		{

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->data['message'];

		}



		$this->data['country']=$this->Common_model->getCountry(array());

		$options = array();

		$options['']  = 'Select Country';

		if(!empty($this->data['country']))

			foreach($this->data['country'] as $c)

				$options[$c->country_id]  = $c->country_name;



		$this->data['countryOptions'] = $options;

		if($is_update_address==1)

		{

			$this->data['customer_address_data'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));

			$data_html = $this->load->view('template/customers_address' , $this->data, true);

		}

		else

		{

			$data_html = $this->load->view('template/edit_address' , $this->data, true);

		}

		echo json_encode(array('redirect_to'=>$redirect_to, 'status'=>$is_update_address, 'data_html'=>$data_html));

	}



	function editUpdateAddressPayment()

	{



		$customers_address_id = $_POST['customers_address_id'];

		$this->data['address_data'] = $this->Common_model->getName(array('select'=>'c.* ' , 'from'=>'customers_address as c' , 'where'=>"c.customers_address_id=$customers_address_id and  c.customers_id=".$this->data['temp_id'] ));

		$this->data['country']=$this->Common_model->getCountry(array());

		$options = array();

		$options['']  = 'Select Country';

		if(!empty($this->data['country']))

			foreach($this->data['country'] as $c)

				$options[$c->country_id]  = $c->country_name;



		$this->data['countryOptions'] = $options;

		echo $this->load->view('template/edit_address_payment' , $this->data, true);

	}



	function do_ship_address_payment()

	{

		$is_update_address = 0;

		$redirect_to = '';

		$data_selected_html = '';



		$this->form_validation->set_rules('name', 'Name', 'alpha_numeric_spaces|trim|required');

		$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');

		$this->form_validation->set_rules('address', 'Address', 'required');

		$this->form_validation->set_rules('country_id', 'Country', 'required');

		$this->form_validation->set_rules('state_id', 'State', 'required');

		$this->form_validation->set_rules('city_id', 'City', 'required');

		$this->form_validation->set_rules('pincode', 'Pincode', 'numeric|trim|required|min_length[6]|max_length[6]');

		$this->form_validation->set_rules('locality', 'Locality');

		if(!empty($_POST['landmark']))

		$this->form_validation->set_rules('landmark', 'Landmark');

		if(!empty($_POST['alternate_number']))

		$this->form_validation->set_rules('alternate_number', 'Alternate Number', 'numeric|trim|min_length[10]|max_length[10]');

		$this->form_validation->set_rules('address_type', 'Address Type');



		$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



		if ($this->form_validation->run() == true)

		{

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$register=$this->Checkout_model->doAddUserAddress(array('customers_address_id'=>$_POST['customers_address_id'] , 'customers_id'=>$this->data['temp_id'], 'do_update_deliver_here'=>1));



			if($register>0){

				$is_update_address = 1;

				if(empty($_POST['customers_address_id']))

				{

					$this->data['message'] = '<div class=" alert alert-success">Success! Your address is successfully inserted.</div>';



				}

				else

				{

					$this->data['message'] = '<div class=" alert alert-success">Success! Your address is successfully updated.</div>';

				}

			$redirect = $this->session->userdata('application_sess_redirect');



			if(!empty($redirect))

			{ $redirect_to = base_url($redirect); }

			else

			{ $redirect_to = base_url().__shippingAddress__; }

			}

			else{

				$this->data['message'] = '<div class=" alert alert-danger">Error! Something went wrong please try again.</div>';

			}

		}

		else

		{

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->data['message'];

		}



		$this->data['country']=$this->Common_model->getCountry(array());

		$options = array();

		$options['']  = 'Select Country';

		if(!empty($this->data['country']))

			foreach($this->data['country'] as $c)

				$options[$c->country_id]  = $c->country_name;



		$this->data['countryOptions'] = $options;

		if($is_update_address==1)

		{

			$this->data['customer_address_data'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));

			$data_html = $this->load->view('template/customers_address_payment' , $this->data, true);

			$data_selected_html = $this->load->view('template/selected_customers_address_payment' , $this->data, true);



		}

		else

		{

			$data_html = $this->load->view('template/edit_address_payment' , $this->data, true);

		}

		echo json_encode(array('redirect_to'=>$redirect_to, 'status'=>$is_update_address, 'data_html'=>$data_html, 'data_selected_html'=>$data_selected_html));

	}



	function editDeliverHereAddress()

	{

		$this->data['page'] = '';

		if(!empty($_POST['page']))

		{

			$this->data['page'] = $_POST['page'];

		}

		$is_update_address = 0;

		$register=$this->Checkout_model->doAddUserDeliverHereAddress(array('customers_address_id'=>$_POST['customers_address_id'] , 'customers_id'=>$this->data['temp_id'], 'do_update_deliver_here'=>1));



			if($register>0){

				$is_update_address = 1;

				if(empty($_POST['customers_address_id']))

				{

					$this->data['message'] = '<div class=" alert alert-success">Success! Your address is successfully inserted.</div>';



				}

				else

				{

					$this->data['message'] = '<div class=" alert alert-success">Success! Your address is successfully updated.</div>';

				}

			}





		if($is_update_address==1)

		{

			$this->data['customer_address_data'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));

			$data_selected_html = $this->load->view('template/selected_customers_address_payment' , $this->data, true);

			if($this->data['page'] == 'cart')

			{

				$data_selected_html = $this->load->view('template/selected_customers_address_payment_cart' , $this->data, true);

				$this->session->set_userdata('application_sess_cart_page_address',$data_selected_html);

				$this->session->set_userdata('application_sess_cart_page_selected_address_id',$_POST['customers_address_id']);

			}



		}

		echo json_encode(array('status'=>$is_update_address, 'data_selected_html'=>$data_selected_html));

	}



	function editUpdateGstInfo()

	{



		$gst_info_id = $_POST['gst_info_id'];

		$this->data['gst_info'] = $this->Common_model->getName(array('select'=>'c.* ' , 'from'=>'gst_info as c' , 'where'=>"c.gst_info_id=$gst_info_id and  c.customers_id=".$this->data['temp_id'] ));



		echo $this->load->view('template/edit_gst_info' , $this->data, true);

	}



	function do_gst_info_form()

	{

		$is_update_gst_info = 0;

		$redirect_to = '';



		$this->form_validation->set_rules('company_name', 'Company Name', 'alpha_numeric_spaces|trim|required');

		$this->form_validation->set_rules('gst_number', 'GST Number', 'alpha_numeric_spaces|trim|required|min_length[15]|max_length[16]');



		$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');



		if ($this->form_validation->run() == true)

		{

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$register=$this->Checkout_model->doAddUserGSTInfo(array('gst_info_id'=>$_POST['gst_info_id'] , 'customers_id'=>$this->data['temp_id']));



			if($register>0){

				$is_update_gst_info = 1;

				if(empty($_POST['gst_info_id']))

				{

					$this->data['message'] = '<div class=" alert alert-success">Success! Your GST Information is successfully inserted.</div>';

				}

				else

				{

					$this->data['message'] = '<div class=" alert alert-success">Success! Your GST Information is successfully updated.</div>';

				}

			$redirect = $this->session->userdata('application_sess_redirect');



			if(!empty($redirect))

			{ $redirect_to = base_url($redirect); }

			else

			{ $redirect_to = base_url().__profileGSTInformation__; }

			}

			else{

				$this->data['message'] = '<div class=" alert alert-danger">Error! Something went wrong please try again.</div>';

			}

		}

		else

		{

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->data['message'];

		}



		if($is_update_gst_info==1)

		{

			$this->data['customer_gst_info_data'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));

			$data_html = $this->load->view('template/customers_gst_info' , $this->data, true);

		}

		else

		{

			$data_html = $this->load->view('template/edit_gst_info' , $this->data, true);

		}

		echo json_encode(array('redirect_to'=>$redirect_to, 'status'=>$is_update_gst_info, 'data_html'=>$data_html));

	}

	function do_gst_info_payment_form()
	{
		$is_update_gst_info = 0;
		$redirect_to = '';

		$this->form_validation->set_rules('company_name', 'Company Name', 'alpha_numeric_spaces|trim|required');
		$this->form_validation->set_rules('gst_number', 'GST Number', 'alpha_numeric_spaces|trim|required|min_length[15]|max_length[16]');

		$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');

		if ($this->form_validation->run() == true)
		{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$is_exist_gst = $this->Common_model->getName(array('select'=>'*' , 'from'=>'gst_info' , 'where'=>"gst_number = '".$_POST['gst_number']."' and company_name = '".$_POST['company_name']."' and customers_id =".$this->data['temp_id'] ));

			if(!empty($is_exist_gst))
			{
				$this->data['message'] = '<div class=" alert alert-danger">GST already exist in database.</div>';
			}
			else
			{
				$_POST['gst_info_id'] = 0;
				$register=$this->Checkout_model->doAddUserGSTInfo(array('gst_info_id'=>$_POST['gst_info_id'] , 'customers_id'=>$this->data['temp_id']));
				if($register>0 ){
					$is_update_gst_info = 1;
					$this->data['message'] = '<div class=" alert alert-success">Success! Your GST Information is successfully inserted.</div>';
				}
				else{
					$this->data['message'] = '<div class=" alert alert-danger">Error! Something went wrong please try again.</div>';
				}
			}

		}
		else
		{
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->data['message'];
	}

		if(true)
		{
			$this->data['customer_address_data'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));
			$data_html = $this->load->view('getPaymentpageGstInfo' , $this->data, true);
		}
		echo json_encode(array( 'status'=>$is_update_gst_info, 'data_html'=>$data_html, 'message'=>$this->data['message']));
	}


	function getPaymentpageGstInfo()

	{

		$this->load->model('Checkout_model');

		$this->data['customer_address_data'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));

		$this->load->view('getPaymentpageGstInfo' , $this->data);

	}



	function editSelectedGstInfoForOrder()

	{

		$gst_info_id = $_POST['id'];

		$selected_for_order = $_POST['selected_for_order'];

		$customers_id = $this->data['temp_id'];



		$reg_data['selected_for_order'] = $selected_for_order;

		$update_data['selected_for_order']=0;



		$this->Common_model->update_operation(array('table'=>'gst_info' , 'data'=>$update_data , 'condition'=>"(customers_id=$customers_id)" ));

		$this->Common_model->update_operation(array('table'=>'gst_info' , 'data'=>$reg_data , 'condition'=>"(gst_info_id=$gst_info_id and customers_id=$customers_id)" ));



	}



	function editSelectedGstInfo()

	{

		$this->data['page'] = '';

		if(!empty($_POST['page']))

		{

			$this->data['page'] = $_POST['page'];

		}

		$is_update_address = 0;

		$register=$this->Checkout_model->doAddUserSelectedGstInfo(array('gst_info_id'=>$_POST['gst_info_id'] , 'customers_id'=>$this->data['temp_id'], 'do_update_deliver_here'=>1));



			if($register>0){

				$is_update_address = 1;



				if(empty($_POST['gst_info_id']))

				{

					$this->data['message'] = '<div class=" alert alert-success">Success! Your GST info is successfully inserted.</div>';

				}

				else

				{

					$this->data['message'] = '<div class=" alert alert-success">Success! Your GST Info is successfully updated.</div>';

				}

			}



		// gst_info_id

		if($is_update_address==1)

		{

			$this->session->set_flashdata('application_sess_show_payment_tab', 3);

			/*

			$this->data['customer_address_data'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));

			$data_selected_html = $this->load->view('template/selected_customers_address_payment' , $this->data, true);

			if($this->data['page'] == 'cart')

			{

				$data_selected_html = $this->load->view('template/selected_customers_address_payment_cart' , $this->data, true);

				$this->session->set_userdata('application_sess_cart_page_address',$data_selected_html);

				$this->session->set_userdata('application_sess_cart_page_selected_address_id',$_POST['customers_address_id']);

			}

			*/

		}

		echo json_encode(array('status'=>$is_update_address));

	}







	public function my_cart_page_detail()

	{

		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');

		$application_sess_store_id = $this->session->userdata('application_sess_store_id');

		$this->load->model('Products_model');

		$distinct_product_id_in_wishlist = $this->Products_model->temp_cart('distinct_product_id_in_wishlist', '', '', '', '', '', $application_sess_temp_id, $application_sess_store_id);

		if (count($distinct_product_id_in_wishlist) > 0) {

			$product_ids = '';

			$product_combination_ids = '';

			foreach ($distinct_product_id_in_wishlist as $col) {

				$product_ids .= $col['product_id'] . ',';

				$product_combination_ids .= $col['product_combination_id'] . ',';

			}

			$product_ids = trim($product_ids, ',');

			$product_combination_ids = trim($product_combination_ids, ',');

			$this->data['products_list'] = $this->Products_model->productsSearch('products_list_group', '', '', $application_sess_temp_id, $application_sess_store_id, $product_ids, $product_combination_ids);

			//print_r($this->data['products_list']);

		}

		$this->data['css'] = array();

		$this->data['js'] = array();

		$this->load->view('templates/wishlist' , $this->data);

	}



	public function wishlist()

	{

		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');

		$application_sess_store_id = $this->session->userdata('application_sess_store_id');

		$this->load->model('Products_model');

		$distinct_product_id_in_wishlist = $this->Products_model->temp_cart('distinct_product_id_in_wishlist', '', '', '', '', '', $application_sess_temp_id, $application_sess_store_id);

		if (count($distinct_product_id_in_wishlist) > 0) {

			$product_ids = '';

			$product_combination_ids = '';

			foreach ($distinct_product_id_in_wishlist as $col) {

				$product_ids .= $col['product_id'] . ',';

				$product_combination_ids .= $col['product_combination_id'] . ',';

			}

			$product_ids = trim($product_ids, ',');

			$product_combination_ids = trim($product_combination_ids, ',');

			$this->data['products_list'] = $this->Products_model->productsSearch('products_list_group', '', '', $application_sess_temp_id, $application_sess_store_id, $product_ids, $product_combination_ids);

			//print_r($this->data['products_list']);

		}

		$this->data['css'] = array();

		$this->data['js'] = array();

		parent::getHeader('header' , $this->data);

		$this->load->view('wishlist' , $this->data);

		parent::getFooter('footer' , $this->data);

	}


	function doUpdateEmailForm()
	{

		$contact = $this->data['profile']->number;
		$name = $this->data['profile']->name;
		$customers_id = $this->data['profile']->customers_id;
		$email = $_POST['email'];
		$otp = $_POST['otp'];

		if($this->data['profile']->email == $email && empty($otp))
		{
			echo '<div class=" alert alert-warning">Please enter the new email!</div>';
			return true;
		}

		$is_exist_email = $this->Common_model->getName(array('select'=>'*' , 'from'=>'customers' , 'where'=>"email = '".$email."' and customers_id !=".$this->data['temp_id'] ));
		if(!empty($is_exist_email))
		{
			echo '<div class=" alert alert-danger">Email id is already exist!</div>';
			return true;
		}
		if(empty($otp))
		{
			//$this->data['profile']->email = $email;
			$this->verify_email_resend_otp($email);
			echo '<div class=" alert alert-success">OTP sent to your email.</div>';
			echo '<script>resend_otp_time_e();
			$("#email_send_to").html("'.$email.'");
			myOTPTimer_e = setInterval(resend_otp_time_e, 1000);
			$(".func_update_email_info_modal_body").hide();
			$("#emailOTPInput").show();
			$("#otp_email_e").attr("required", true);
			</script>';

			return false;
		}

		if(strlen($otp)!=6)
		{
			echo '<div class=" alert alert-danger">Please enter 6 digit OTP!</div>';
			return true;
		}
		if($this->check_email_Otp($otp, $email))
		{
			$this->Common_model->update_operation(array('table'=>'customers' , 'data'=>array('is_email_verify'=>1, "email"=>$email) , 'condition'=>"customers_id = $customers_id" ));
			$this->Common_model->delete_operation(array("where"=>array('contact'=>$email , 'otp_for'=>'verify_email' , 'otp'=>$_POST['otp']) , "table"=>'otp_log' ));
			$m1 = "Email goes to ".$email;
			$m2 = "Update your email";
			$m3 = "<div class=' alert alert-sucess'>Email updated sucessfully!</div>";
			echo '<script>
				$("#func_update_email_info_modal_a").html("'.$m2.'");
				$("#func_update_email_info_modal_span").html("'.$m1.'");
				$("#func_update_email_info_modal_div").html("'.$m3.'");
				$("#func_update_email_info_modal").modal("toggle");
			</script>';
			$this->session->set_userdata('application_sess_temp_email',$email);
			//$this->session->set_flashdata('message', '<div class=" alert alert-success">Your contact number is successfully verified.</div>');
		}
		else
		{
			echo '<div class=" alert alert-danger">Wrong OTP entered.</div>';
			return true;
		}


	}
}
