<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//$this->load->database();

		//libraries
		$this->load->library('session');
		$this->load->library('form_validation');

		//helpers
		$this->load->helper('url');
		$this->load->helper('form');

		//models
		$this->load->model('Common_Model');
		$this->load->model('administrator/Login_model');

		// storing data from session in data
		$this->data['session_uid'] = $this->session->userdata('sess_psts_uid');
		$this->data['session_name'] = $this->session->userdata('sess_psts_name');
		$this->data['session_email'] = $this->session->userdata('sess_psts_email');

		//initilizing message and alert_message data
		$this->data['message'] = '';
		$this->data['alert_message'] = '';



	}


	/**
	 * The method checks if the user is already logged in based on session data and redirects to "controllers/secureRegions/ Wam.php"'s index() method which loads the dashboard, if they are.If the login form is submitted with valid credentials it runs "doSignInUser()" from "admininistrator/Login_model.php" and sets appropriate session data and messages based on the response.If the user is successfully logged in, they are redirected to the admin page.if validation fails or the login attempt fails, it sets the appropriate error messages.Finally, it loads the login view, passing along any alert messages to be displayed
	 */
	function index()
	{
		// Check if the session variables for user ID, name, and email are set
		if (!empty($this->data['session_uid']) && !empty($this->data['session_name']) && !empty($this->data['session_email'])) {
			// If session variables are set, redirect to the main site admin 'wam' page
			REDIRECT(MAINSITE_Admin . "wam");
		}

		// Check if the login form has been submitted
		if (isset($_POST['login_btn'])) {
			// Set validation rules for the username and password fields
			$this->form_validation->set_rules('username', "Username", 'required');
			$this->form_validation->set_rules('password', "Password", 'required');

			// Set custom error delimiters for form validation errors
			$this->form_validation->set_error_delimiters(
				'<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>',
				'</div>'
			);

			// Run form validation
			if ($this->form_validation->run() == true) {
				// Set alert message with validation errors or session flash message
				$this->data['alert_message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				// Attempt to sign in the user using the Login_model
				$response = $this->Login_model->doSignInUser();

				// Check if the sign-in was successful
				if ($response) {
					// Check if the user status is active (1)
					if ($response->status == 1) {
						// Set a success message in the session flash data
						$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
											<div type="button" class="close" data-dismiss="alert" aria-hidden="true">×</div>
											<i class="icon fas fa-check"></i> You Are Login Successfully 
											</div>');

						// Set user session data
						$this->session->set_userdata('sess_psts_uid', $response->admin_user_id);
						$this->session->set_userdata('sess_psts_name', $response->name);
						$this->session->set_userdata('sess_psts_email', $response->email);
						$this->session->set_userdata('sess_company_profile_id', $response->roles[0]->company_profile_id);

						// Load the fiscalYear library and set the fiscal year
						$this->load->library('fiscalYear');
						$fy = new fiscalYear();
						$result = $fy->setFiscalYear();
						$this->session->set_userdata('sess_fiscal_year_id', $result->fiscal_year_id);

						// Redirect to the main site admin 'wam' page
						REDIRECT(MAINSITE_Admin . "wam");
					} else {
						// If the user is blocked, set an error message in the session flash data
						$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
											<div type="button" class="close" data-dismiss="alert" aria-hidden="true">×</div>
											<i class="icon fas fa-ban"></i> You are blocked by Management.
											</div>');
					}
				} else if (!$response) {
					// If the sign-in failed due to incorrect credentials, set an error message in the session flash data
					$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
									<div type="button" class="close" data-dismiss="alert" aria-hidden="true">×</div>
									<i class="icon fas fa-ban"></i> Wrong Email/Username Or Password
									</div>');
				} else {
					// If the sign-in failed due to some other reason, set a generic error message in the session flash data
					$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
									<div type="button" class="close" data-dismiss="alert" aria-hidden="true">×</div>
									<i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. 
									</div>');
				}
			} else {
				// If form validation fails, set the alert message with validation errors or session flash message
				$this->data['alert_message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('alert_message');
			}
		}

		// Retrieve any alert message stored in the session flash data loaded in the logout method of "secureRegions/Wam.php"
		$temp_alert_message = $this->session->flashdata('alert_message');
		if (!empty($temp_alert_message)) {
			$this->data['alert_message'] = $temp_alert_message;
		}

		// Load the login view and pass the data to it
		$this->load->view('admin/login', $this->data);
	}

	public function index1()
	{
		$this->load->view('welcome_message');
	}


}
