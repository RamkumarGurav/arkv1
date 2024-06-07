<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('Main.php');
class User extends Main {

	public function __construct()
	{
		parent::__construct();
        $this->load->database();
       // $this->clear_all_cache();
		//$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('User_model');
		$this->load->model('Common_Model');
		$this->load->model('Products_model');
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->session->set_userdata('application_sess_store_id',1);
		$this->data['message'] = '';
		$this->data['temp_name'] = $this->session->userdata('application_sess_temp_name');
		$this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');
		$this->data['login_type'] = $this->session->userdata('application_sess_login_type');
		$this->data['store_id'] = $this->session->userdata('application_sess_store_id');
		$this->data['message']='';
		$this->data['currency'] = parent::setCurrency(array());
		//echo $this->db->last_query();

	}

	public function clear_all_cache()
	{
		$CI =& get_instance();
		$path = $CI->config->item('cache_path');
		$path1 = rtrim(APPPATH , 'application/');
		$path1 = $path1.'/';
		$cache_path = ($path == '') ? $path1.'cache/' : $path;
		//echo $cache_path;
		$handle = opendir($cache_path);
		//echo $handle;
		while (($file = readdir($handle))!== FALSE)
		{
			//Leave the directory protection alone
			if ($file != '.htaccess' && $file != 'index.html')
			{
			   @unlink($cache_path.'/'.$file);
			}
		}
		closedir($handle);
	}

	function _not_device_detection()
	{
		$ua = $_SERVER['HTTP_USER_AGENT'];
		$qs = $_SERVER['QUERY_STRING'];
		$agent = "error";
		if (preg_match('/^pc$/i', $qs)) {
			/* This assumes you have a single query string value of "pc" */
			$agent = "pc";
		} else if (preg_match('/^pom$/i', $qs)) {
			/* This assumes you have a single query string value of "pom" */
			$agent = "pom";
		} else if (preg_match('/^iphone$/i', $qs)) {
			/* This assumes you have a single query string value of "iphone" */
			$agent = "iphone";
		} else if (preg_match('/.*iP(hone|od)(;|\s).*$/i', $ua)) {
			/* This user agent should be an iPhone/iPod */
			$agent = "iphone";
		} else if (preg_match('/Windows\s+CE/i', $ua)) {
			/* This user agent should be a Windows Mobile device - you may want a special class for this and possibly high-end Symbian too */
			$agent = "pom";
		} else if (
			(!preg_match('/Linux/i', $ua)) and
			(!preg_match('/Win/i', $ua)) and
			(!preg_match('/OS\s+(X|9)/i', $ua)) and
			(!preg_match('/Solaris/i', $ua)) and
			(!preg_match('/BSD/i', $ua))
		) {
			/* This user agent is not Linux, Windows, a Mac, Solaris or BSD */
			$agent = "pom";
		} else {
			/* Otherwise assume it's a PC */
			$agent = "pc";
		}
		return $agent;
	}

	public function pageNotFound()
	{
		$this->data['meta_title'] = _project_name_." - Page Not Found";
		$this->data['meta_description'] = _project_name_." - Page Not Found";
		$this->data['meta_keywords'] = _project_name_." - Page Not Found";
		$this->data['meta_others'] = "";

		parent::getHeader('header' , $this->data);
		$this->load->view('pageNotFound' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function thanks()
	{
		$this->data['css'] = array();
		$this->data['js'] = array();
		parent::getHeader('header' , $this->data);
		$this->load->view('thank-you' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function found404()
	{
		$this->data['meta_title'] = _project_name_." - 404 found";
		$this->data['meta_description'] = _project_name_." - 404 found";
		$this->data['meta_keywords'] = _project_name_." - 404 found";
		$this->data['meta_others'] = "";

		parent::getHeader('header' , $this->data);
		$this->load->view('404found' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function logout()
	{
		//$this->session->sess_destroy();
		//$this->load->library('session');
		$this->session->set_userdata('application_sess_cart_page_address','');
		$this->session->set_userdata('application_sess_cart_page_selected_address_id','');
		$this->session->set_userdata('application_sess_temp_id','');
		$this->session->set_userdata('application_sess_temp_name','');
		$this->session->set_userdata('application_sess_login_type','');
		$this->session->set_userdata('application_sess_temp_number','');
		$this->session->set_userdata('application_sess_temp_email','');
		$this->session->set_userdata('application_sess_coupon_code','');
		$this->session->set_userdata('application_sess_discount','');
		$this->session->set_userdata('application_sess_redirect','');
		$this->session->set_flashdata('message', '<div class=" alert alert-success">You are successfully sign out.</div>');
		$this->session->set_userdata('application_sess_temp_id',$_COOKIE["application_user"]);
		REDIRECT(base_url(__login__));
	}

	public function index()
	{
		$this->data['meta_title'] = _project_name_;
		$this->data['meta_description'] = _project_name_;
		$this->data['meta_keywords'] = _project_name_;
		$this->data['meta_others'] = "";
		$last_screen =  $this->Common_Model->checkScreen();
		if($last_screen == 'isdesktop')
		{
			$last_screen = "Desktop";
			$banners_condition = "b.status=1 and b.banner_for=1";
		}
		else
		{
			$last_screen = "Mobile or Tablet";
			$banners_condition = "b.status=1 and b.banner_for=0";
		}

		$this->data['banners'] = $this->Common_Model->getData(array('select'=>'b.* ' , 'from'=>'banner as b' , 'where'=>$banners_condition , 'order_by'=>'position ASC' ));

		$this->data['index_category'] = $this->Products_model->getIndexCategory(array('select'=>'category_id , position , name , slug_url ' , 'from'=>'category' , 'where'=>"(category_id =1 and status=1)" ));
		$this->data['testimonial_videos'] = $featured_courses = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'testimonial' , 'where'=>"status = 1",'order_by'=>'position ASC' ));
		$this->data['working_methods'] = $working_methods = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'working_method' , 'where'=>"status = 1",'order_by'=>'position ASC' ));

		 $this->data['js'] = array( 'js/home.js'  );//, 'js/all-scripts.js'
		$this->data['direct_css'] = array( 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css' );//, 'js/all-scripts.js'
		 $this->data['direct_js'] = array( 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', );//, 'js/all-scripts.js'
		$this->data['php'] = array('script/topcategories' , 'script/whatsnew' );
		// ,'add-script/star-script'
		$this->data['php_template'] = array('template/home-page-footer');// ,'add-script/star-script'
		$this->data['css'] = array('product-list.css','home.css');

		parent::getHeader('header' , $this->data);
		$this->load->view('home' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function contact()
	{
		$this->data['meta_title'] = _project_name_."- Contact Us";
		$this->data['meta_description'] = _project_name_."- Contact Us";
		$this->data['meta_keywords'] = _project_name_."- Contact Us";
		$this->data['meta_others'] = "";
			// $this->data['direct_js'] = array('https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js');
		parent::getHeader('header' , $this->data);
		$this->load->view('contact-us' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function doContact()
	{
		if(isset($_POST['sendEnquiry']))
		{
			$this->form_validation->set_rules('name', 'Name', 'alpha_numeric_spaces|trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('mobile_no', 'Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('subject', 'Subject', 'alpha_numeric_spaces|trim|required');
			$this->form_validation->set_rules('message', 'Description', 'alpha_numeric_spaces|trim|required');

			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');

			if ($this->form_validation->run() == true)
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$register=$this->User_model->doAddInquiry();

				if($register>0){
					$this->session->set_flashdata('message', '<div class=" alert alert-success">Thank You! We will get back within 24 - 48 hours.</div>');
					//$this->data['message'] = $this->session->flashdata('message');
					$customerData = $this->Common_Model->getName(array('select'=>'*' , 'from'=>'enquiry' , 'where'=>"enquiry_id=$register" ));
					$register = $customerData = $customerData[0];
					$name = $customerData->name;
					$email_id = $customerData->email;
					$contact = $customerData->contactno;
					$subject = $customerData->subject;
					$description = $customerData->description;

					//$template = "Dear Admin, new enquiry received from whizzles.com";
					//$this->Common_Model->send_sms(__admincontact__ , $template);
					$subject = "Contact Us Inquiry from "._project_complete_name_;
					$mailMessage = file_get_contents(APPPATH.'mailer/enquiry-to-admin.html');
					$mailMessage = preg_replace('/\\\\/','', $mailMessage); //Strip backslashes
					$mailMessage = str_replace("#name#",stripslashes($customerData->name),$mailMessage);
					$mailMessage = str_replace("#contact#",stripslashes($customerData->contactno),$mailMessage);
					$mailMessage = str_replace("#email#",stripslashes($customerData->email),$mailMessage);
					$mailMessage = str_replace("#subject#",stripslashes($customerData->subject),$mailMessage);
					$mailMessage = str_replace("#message#",stripslashes($customerData->description),$mailMessage);
					$mailMessage = str_replace("#project_contact#",_project_contact_,$mailMessage);
						$mailMessage = str_replace("#project_contact_without_space#",_project_contact_without_space_,$mailMessage);
						$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
						$mailMessage = str_replace("#project_website#",_project_web_,$mailMessage);
						$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);
						$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
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
					$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>__adminemail__ , "name"=>_project_complete_name_ ));
					$template = "Dear Admin, Thank you for inquiry with us "._SMS_BRAND_;
					$this->Common_Model->send_sms(__adminsms__ , $template);
					REDIRECT(base_url(__thanks__));
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
		if (!empty($msg))
			$this->data['message'] = $this->session->flashdata('message');
		$this->data['css'] = array();
		$this->data['js'] = array();
		parent::getHeader('header' , $this->data);
		$this->load->view('contact-us' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function about()
	{
		$this->data['meta_title'] = _project_name_." - About Us";
		$this->data['meta_description'] = _project_name_." - About Us";
		$this->data['meta_keywords'] = _project_name_." - About Us";
		$this->data['meta_others'] = "";
			// $this->data['direct_js'] = array('https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js');
		parent::getHeader('header' , $this->data);
		$this->load->view('about-us' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function faq()
	{
		$this->data['meta_title'] = _project_name_." - FAQ";
		$this->data['meta_description'] = _project_name_." - FAQ";
		$this->data['meta_keywords'] = _project_name_." - FAQ";
		$this->data['meta_others'] = "";
		// $this->data['direct_js'] = array('https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js');
		parent::getHeader('header' , $this->data);
		$this->load->view('faq' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function doSubscribe()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$status='false';
		$message = '';

		if(!empty($_POST))
		{
			$this->form_validation->set_rules('subscriber_email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');
			if ($this->form_validation->run() == true)
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$customerData = $this->Common_Model->getName(array('select'=>'*' , 'from'=>'newsletter' , 'where'=>"subscriber_email like ('$_POST[subscriber_email]')" ));
				if(count($customerData)<=0)
				{
					$register=$this->User_Model->doAddSubscribeFormInquiry();
					if($register>0)
					{
						$this->session->set_flashdata('message', '<div class=" alert alert-success">Thank You! We will get back with in 24 - 48 hours.</div>');
						$this->data['message'] = $this->session->flashdata('message');
						$subscriberData = $this->Common_Model->getName(array('select'=>'*' , 'from'=>'newsletter' , 'where'=>"id=$register" ));
						$register = $subscriberData = $subscriberData[0];
						$contact = $subscriberData->subscriber_email;

						$subject = "Subscribed for "._project_name_;
						$mailMessage = file_get_contents(APPPATH.'mailer/subscribe-enquiry-to-admin.html');
						$mailMessage = preg_replace('/\\\\/','', $mailMessage); //Strip backslashes
						$mailMessage = str_replace("#email#",stripslashes($subscriberData->subscriber_email),$mailMessage);
						$mailMessage = str_replace("#project_contact#",__projectcontact__,$mailMessage);
						$mailMessage = str_replace("#project_contact_without_space#",__projectcontactwithoutspace__,$mailMessage);
						$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
						$mailMessage = str_replace("#project_website#",__projectwebsite__,$mailMessage);
						$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);
						$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
						$social_media = '';
						if(_FACEBOOK_!='')
							$social_media = $social_media.'<a href="'._FACEBOOK_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/facebook.png" width="25"></a>';
						if(_INSTAGRAM_!='')
							$social_media = $social_media.'<a href="'._INSTAGRAM_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/instagram.png" width="25"></a>';
						if(_PINTEREST_!='')
							$social_media = $social_media.'<a href="'._PINTEREST_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/pinterest.png" width="25"></a>';
						if(_TWITTER_!='')
							$social_media = $social_media.'<a href="'._TWITTER_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/twitter.png" width="25"></a>';
						if(_LINKEDIN_!='')
							$social_media = $social_media.'<a href="'._LINKEDIN_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/linkedin.png" width="25"></a>';
						if(_YOUTUBE_!='')
							$social_media = $social_media.'<a href="'._YOUTUBE_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/youtube.png" width="25"></a>';
						$mailMessage = str_replace("#social_media#",$social_media,$mailMessage);

						$mailStatus = $this->Common_Model->send_mail_api(array("template"=>$mailMessage , "subject"=>$subject , "to"=>__adminemail__ , "name"=>_project_complete_name_ ));
						$status = 'true';
						$this->session->set_flashdata('message', '<div class=" alert alert-success">You subscribed our Broadcast.</div>');
					}
					else{
						$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');
					}
				}
				else
				{
					$this->session->set_flashdata('message', '<div class=" alert alert-danger">You already subscribed our Broadcast.</div>');
				}
			}
			else
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->session->set_flashdata('message', $this->data['message']);
			}
		}
		$msg = $this->session->flashdata('message');

		if (!empty($msg))
			$message = $this->session->flashdata('message');

			$this->session->set_flashdata('message', '');
		echo json_encode(array('status'=>$status , 'message'=>$message));
	}

	public function privacy_policy()
	{
		$this->data['meta_title'] = _project_name_." - Privacy Policy";
		$this->data['meta_description'] = _project_name_." - Privacy Policy";
		$this->data['meta_keywords'] = _project_name_." - Privacy Policy";
		$this->data['meta_others'] = "";

		parent::getHeader('header' , $this->data);
		$this->load->view('privacy-policy' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function terms_conditions()
	{
		$this->data['meta_title'] = _project_name_." - Terms & Conditions";
		$this->data['meta_description'] = _project_name_." - Terms & Conditions";
		$this->data['meta_keywords'] = _project_name_." - Terms & Conditions";
		$this->data['meta_others'] = "";

		parent::getHeader('header' , $this->data);
		$this->load->view('terms-conditions' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	

	public function shipping_policy()
	{
		$this->data['meta_title'] = _project_name_." - Shipping Policy";
		$this->data['meta_description'] = _project_name_." - Shipping Policy";
		$this->data['meta_keywords'] = _project_name_." - Shipping Policy";
		$this->data['meta_others'] = "";

		parent::getHeader('header' , $this->data);
		$this->load->view('shipping-policy' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	

	public function return_policy()
	{
		$this->data['meta_title'] = _project_name_." - Return Policy";
		$this->data['meta_description'] = _project_name_." - Return Policy";
		$this->data['meta_keywords'] = _project_name_." - Return Policy";
		$this->data['meta_others'] = "";

		parent::getHeader('header' , $this->data);
		$this->load->view('return-policy' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	

	public function doRegistration()
	{
		//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
		if(isset($_POST['sendRegistration']))
		{
			$this->form_validation->set_rules('company_name', 'Company Name', 'alpha_numeric_spaces|trim|required');
			$this->form_validation->set_rules('name', 'Contact Person Name', 'alpha_numeric_spaces|trim|required');
			$this->form_validation->set_rules('company_email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('mobile_no', 'Mobile Number', 'numeric|trim|required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('gst_no', 'GST Number', 'alpha_numeric_spaces|trim|required|min_length[15]|max_length[15]');
			$this->form_validation->set_rules('state_id', 'State', 'numeric|trim|required|min_length[1]|max_length[3]');
			$this->form_validation->set_rules('city_id', 'City', 'numeric|trim|required|min_length[1]|max_length[3]');
			//$this->form_validation->set_rules('alt_mobile_no1', 'Alternate Mobile Number-1', 'numeric|trim|min_length[10]|max_length[10]');
			//$this->form_validation->set_rules('alt_mobile_no2', 'Alternate Mobile Number-2', 'numeric|trim|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('address1', 'Address', 'trim|required');

			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');

			if ($this->form_validation->run() == true)
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$register=$this->User_model->doAddRegistration();

				if($register>0){
					$this->upload_gst_certificate($register);
					$this->session->set_flashdata('message', '<div class=" alert alert-success">Thank You! We will get back with in 24 - 48 hours.</div>');
					$this->data['message'] = $this->session->flashdata('message');
					//exit;
					$customerData = $this->Common_Model->getName(array('select'=>'cust.company_name,cust.company_email,cust.name,cust.address1,cust.mobile_no,cust.gst_no,cou.country_name, sta.state_name, cit.city_name' , 'from'=>'dealer_profile as cust, country as cou, state as sta, city as cit' , 'where'=>"cust.dealer_profile_id = $register and cust.country_id = cou.country_id and cust.state_id = sta.state_id and cust.city_id = cit.city_id" ));

					//echo $this->db->last_query();
					$register = $customerData = $customerData[0];
					$company_name = $customerData->company_name;
					$name = $customerData->name;
					$company_email = $customerData->company_email;
					$mobile_no = $customerData->mobile_no;
					$country_name = $customerData->country_name;
					$state_name = $customerData->state_name;
					$city_name = $customerData->city_name;
					$address1 = $customerData->address1;
					//exit;

					//$template = "Dear Admin, new enquiry received from whizzles.com";
					//$this->Common_Model->send_sms(__admincontact__ , $template);
					$subject = "New Dealer Registgration from "._project_complete_name_;
					$mailMessage = file_get_contents(APPPATH.'mailer/enquiry-to-admin.html');
					$mailMessage = preg_replace('/\\\\/','', $mailMessage); //Strip backslashes
					$mailMessage = str_replace("#company_name#",stripslashes($customerData->company_name),$mailMessage);
					$mailMessage = str_replace("#name#",stripslashes($customerData->name),$mailMessage);
					$mailMessage = str_replace("#email#",stripslashes($customerData->company_email),$mailMessage);
					$mailMessage = str_replace("#contact#",stripslashes($customerData->mobile_no),$mailMessage);
					$mailMessage = str_replace("#country_name#",stripslashes($customerData->country_name),$mailMessage);
					$mailMessage = str_replace("#state_name#",stripslashes($customerData->state_name),$mailMessage);
					$mailMessage = str_replace("#city_name#",stripslashes($customerData->city_name),$mailMessage);
					$mailMessage = str_replace("#address#",stripslashes($customerData->address1),$mailMessage);
					$mailMessage = str_replace("#project_contact#",__projectcontact__,$mailMessage);
					$mailMessage = str_replace("#project_contact_without_space#",__projectcontactwithoutspace__,$mailMessage);
					$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
					$mailMessage = str_replace("#project_website#",__projectwebsite__,$mailMessage);
					$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);
					$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
				//	echo "mailMessage : $mailMessage <br>";
					$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>__adminemail__ , "name"=>_project_complete_name_ ));
					//echo "mailStatus : $mailStatus <br>";
					/*
					$subject = "Your enquiry placed successfully to "._project_complete_name_;
					$mailMessage = file_get_contents(APPPATH.'mailer/after-enquiry-to-user.html');
					$mailMessage = preg_replace('/\\\\/','', $mailMessage); //Strip backslashes
					$mailMessage = str_replace("#name#",stripslashes($customerData->name),$mailMessage);
					$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
					$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$customerData->email , "name"=>$customerData->name ));*/
					$msg = $this->session->flashdata('message');
					if (!empty($msg))
						$this->data['message'] = $this->session->flashdata('message');

					REDIRECT(base_url(__thanks__));
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
		if (!empty($msg))
			$this->data['message'] = $this->session->flashdata('message');
		$this->data['state_list'] = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'state' , 'where'=>"state_id > 0" , 'where'=>"status = 1" , 'where'=>"country_id = 1" , "order_by"=>"state_name ASC"));

		$options = array();
		$options['']  = 'Select STate';
		if(!empty($this->data['state_list']))
			foreach($this->data['state_list'] as $c)
				$options[$c->state_id]  = $c->state_name;

		$this->data['stateOptions'] = $options;

		$this->data['css'] = array();
		$this->data['js'] = array();
		parent::getHeader('header' , $this->data);
		$this->load->view('dealer-registration' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function upload_gst_certificate($dealer_profile_id)
	{
		$gst_certificate_file_name = "";
		if(isset($_FILES["gst_certificate"]['name'])){
			$timg_name = $_FILES['gst_certificate']['name'];
			if(!empty($timg_name)){
				$temp_var = explode(".",strtolower($timg_name));
				$timage_ext = end($temp_var);
				$timage_name_new = "gst_certificate_".$dealer_profile_id.".".$timage_ext;
				$image_enter_data['gst_certificate'] = $timage_name_new;
				$imginsertStatus = $this->Common_Model->update_operation(array('table'=>'dealer_profile', 'data'=>$image_enter_data, 'condition'=>"dealer_profile_id = $dealer_profile_id"));
				if($imginsertStatus==1)
				{
					if (!is_dir('assets/dealer_profile')) {
						mkdir('./assets/dealer_profile', 0777, TRUE);
					}
					if (!is_dir('assets/dealer_profile/gst_certificate')) {
						mkdir('./assets/dealer_profile/gst_certificate', 0777, TRUE);
					}
					move_uploaded_file ($_FILES['gst_certificate']['tmp_name'],"assets/dealer_profile/gst_certificate/".$timage_name_new);
					$gst_certificate_file_name = $timage_name_new;
				}

			}
		}
	}

	

	public function reviewnotfound()
	{
		$this->data['meta_title'] = _project_name_." - review not found";
		$this->data['meta_description'] = _project_name_." - review not found";
		$this->data['meta_keywords'] = _project_name_." - review not found";
		$this->data['meta_others'] = "";

		parent::getHeader('header' , $this->data);
		$this->load->view('reviewnotfound' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function morereviews()
	{
		$this->data['meta_title'] = _project_name_." - More Reviews ";
		$this->data['meta_description'] = _project_name_." - More Reviews";
		$this->data['meta_keywords'] = _project_name_." - More Reviews";
		$this->data['meta_others'] = "";

		parent::getHeader('header' , $this->data);
		$this->load->view('morereviews' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function bulk_enquiry_product()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$status='false';
		$message = '';

		if(!empty($_POST))
		{
			$this->form_validation->set_rules('name', 'Name', 'alpha_numeric_spaces|trim|required');
			$this->form_validation->set_rules('bulk_quantity', 'Quantity', 'numeric|trim|required');
			$this->form_validation->set_rules('contact', 'Contact Number', 'numeric|trim|required|min_length[8]|max_length[15]');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			//$this->form_validation->set_rules('eQmessage', 'Message', 'required|min_length[50]');
			$this->form_validation->set_rules('message', 'Message', 'required');
			//product_name , product_id
			$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');

			if ($this->form_validation->run() == true)
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$register=$this->User_model->doAddBulkEnquiryProduct();
				if($register>0){
					$status = 'true';
					$this->session->set_flashdata('message', '<div class=" alert alert-success">Your enquiry/message is successfully submitted. We will get back to you soon.</div>');
					$customerData = $this->Common_Model->getName(array('select'=>'e.*' , 'from'=>'bulk_enquiry_product as e' , 'where'=>"e.bulk_enquiry_product_id=$register" ));
					$customerData = $customerData[0];
					//$contact = $customerData->number;
					//$template = "Dear $customerData->name, Thank you for registering with us kumkumwallpapers.in";
					//$this->Common_Model->send_sms($contact , $template);
					$subject = "Enquiry placed To "._project_name_." at For Bulk Quantity ";
					$mailMessage = file_get_contents(APPPATH.'mailer/enquiry-to-admin-bulk-quantity.html');
					$mailMessage = preg_replace('/\\\\/','', $mailMessage); //Strip backslashes
					$mailMessage = str_replace("#product_name#",stripslashes($_POST['product_name']),$mailMessage);
					$mailMessage = str_replace("#mail_message#",stripslashes("New enquiry placed, details are as follow :-"),$mailMessage);
					$mailMessage = str_replace("#name#",stripslashes($customerData->name),$mailMessage);
					$mailMessage = str_replace("#email#",stripslashes($customerData->email),$mailMessage);
					$mailMessage = str_replace("#contact#",stripslashes($customerData->number),$mailMessage);
					$mailMessage = str_replace("#message#",stripslashes($customerData->message),$mailMessage);
					$mailMessage = str_replace("#quantity#",stripslashes($customerData->quantity),$mailMessage);
					$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);

					$mailMessage = str_replace("#project_contact#",_project_contact_,$mailMessage);
					$mailMessage = str_replace("#project_contact_without_space#",_project_contact_without_space_,$mailMessage);
					$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
					$mailMessage = str_replace("#project_website#",_project_web_,$mailMessage);
					$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);
					$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
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
					//$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>'order@kumkumwallpapers.in' , "name"=>'Admin' ));
					$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>__adminemail__ , "name"=>'Admin' ));

					$subject = "Your enquiry placed successfully to "._project_name_;
					$mailMessage = file_get_contents(APPPATH.'mailer/after-enquiry-to-user.html');
					$mailMessage = preg_replace('/\\\\/','', $mailMessage); //Strip backslashes
					$mailMessage = str_replace("#product_name#",stripslashes($_POST['product_name']),$mailMessage);
					$mailMessage = str_replace("#mail_message#",stripslashes("Thank you for your enquiry. We will get back to you soon. Enquiry details are as follow :-"),$mailMessage);
					$mailMessage = str_replace("#name#",stripslashes($customerData->name),$mailMessage);
					$mailMessage = str_replace("#email#",stripslashes($customerData->email),$mailMessage);
					$mailMessage = str_replace("#contact#",stripslashes($customerData->number),$mailMessage);
					$mailMessage = str_replace("#message#",stripslashes($customerData->message),$mailMessage);
					$mailMessage = str_replace("#quantity#",stripslashes($customerData->quantity),$mailMessage);
					$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);

					$mailMessage = str_replace("#project_contact#",_project_contact_,$mailMessage);
					$mailMessage = str_replace("#project_contact_without_space#",_project_contact_without_space_,$mailMessage);
					$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
					$mailMessage = str_replace("#project_website#",_project_web_,$mailMessage);
					$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);
					$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
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

					$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$customerData->email , "name"=>$customerData->name ));

				}
				else{
					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong please try again.</div>');
				}
			}
			else
			{
				$message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			}
		}
		$msg = $this->session->flashdata('message');
		if (!empty($msg))
			$message = $this->session->flashdata('message');
		echo json_encode(array('status'=>$status , 'message'=>$message));
	}

	public function google_merchant_center()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$mailMessage = $data['mailMessage'];
		$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);

		$mailMessage = str_replace("#project_contact#",_project_contact_,$mailMessage);
		$mailMessage = str_replace("#project_contact_without_space#",_project_contact_without_space_,$mailMessage);
		$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
		$mailMessage = str_replace("#project_website#",_project_web_,$mailMessage);
		$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);
		$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
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

		$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$data['subject'] , "to"=>$data['email'] , "name"=>$data['name'] ));
	}


}
