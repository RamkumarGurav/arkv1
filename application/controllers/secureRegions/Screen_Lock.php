<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Screen_Lock extends CI_Controller
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
		$this->load->model('administrator/Screen_Lock_model');

		//messages
		$this->data['message'] = '';
		$this->data['alert_message'] = '';


		//session data
		$this->data['session_uid'] = $this->session->userdata('sess_psts_uid');
		$this->data['session_name'] = $this->session->userdata('sess_psts_name');
		$this->data['session_email'] = $this->session->userdata('sess_psts_email');
	}

	/****************************************************************
	 *HELPERS
	 ****************************************************************/

	function unset_only()
	{
		$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}
	}

	/****************************************************************
	 ****************************************************************/

	/**
	 * The index() function for the screen lock first checks if the user is logged in and if the screen isn't locked, redirecting to the main admin page if both conditions are met. If the login form is submitted, it validates the password field, attempts to log in the user via the Screen_Lock_model, and sets flash messages based on the outcome—successful login, blocked user, wrong password, or a general error. It then retrieves any existing flash messages to display appropriate alerts and loads the screen_lock view, passing any alert messages to it. Overall, the function handles the screen lock process by managing session checks, form validation, login attempts, and user feedback.
	 */
	function index()
	{
		// Retrieve the 'screen_lock' status from the session data
		$screen_lock = $this->session->userdata('screen_lock');

		// Check if the session variables for user ID, name, and email are set, and if 'screen_lock' is not set
		//this logic for "when admin_user is currently logged in but try to open Screen_Lock page using manually entering the 
		//"..../annadatha/secureRegions/Screen-Lock" then it desplays the default dashboard page which is ".../annadatha/secureRegions/wam"
		if (empty($screen_lock) && !empty($this->data['session_uid']) && !empty($this->data['session_name']) && !empty($this->data['session_email'])) {
			// Redirect to the main admin page(default dashboard) if the user is already logged in and the screen is not locked
			REDIRECT(MAINSITE_Admin . "wam");
		}


		if (empty($this->data['session_uid']) && empty($this->data['session_name']) && empty($this->data['session_email'])) {
			// Redirect to the main admin page(default dashboard) if the user is already logged in and the screen is not locked
			REDIRECT(MAINSITE_Admin . "login");
		}

		// Check if there is any POST data (indicating a form submission)
		if (!empty($_POST)) {
			// Set validation rules for the password field, making it required
			$this->form_validation->set_rules('password', "Password", 'required');

			// Set custom HTML delimiters for displaying validation errors
			$this->form_validation->set_error_delimiters(
				'<div class="alert alert-danger alert-dismissible">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<i class="icon fas fa-ban"></i>',
				'</div>'
			);

			// Run form validation
			if ($this->form_validation->run() == true) {
				// Set alert message with validation errors or flash message
				$this->data['alert_message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				// Attempt to sign in the user
				$response = $this->Screen_Lock_model->doSignInUser();

				// Check the response from the sign-in attempt
				if ($response) {
					// If sign-in is successful and the user's status is active
					if ($response->status == 1) {
						// Set a success message and clear the 'screen_lock' session data
						$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
													<i class="icon fas fa-check"></i> You Are Login Successfully 
													</div>');
						$this->session->set_userdata('screen_lock', '');
						// Redirect to the main admin page
						REDIRECT(MAINSITE_Admin . "wam");
					} else {
						// If the user is blocked, set a danger alert message
						$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
													<i class="icon fas fa-ban"></i> You are blocked by Management.
												</div>');
					}
				} else if (!$response) {
					// If the password is wrong, set a danger alert message
					$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
											<i class="icon fas fa-ban"></i> Wrong Password
										</div>');
				} else {
					// If there is a general error, set a generic danger alert message
					$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
											<i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. 
										</div>');
				}
			} else {
				// If validation fails, set alert message with validation errors or flash message
				$this->data['alert_message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('alert_message');
			}
		}

		// Retrieve any alert message set in flash data
		$temp_alert_message = $this->session->flashdata('alert_message');
		if (!empty($temp_alert_message)) {
			// Set alert message if flash data exists
			$this->data['alert_message'] = $temp_alert_message;
		}

		// Load the screen lock view and pass the data to it
		$this->load->view('admin//screen_lock', $this->data);
	}



	public function logout()
	{
		$this->unset_only();
		$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="icon fas fa-check"></i> You Are Successfully Logout.
		</div>');
		$this->session->unset_userdata('sess_psts_uid');
		REDIRECT(MAINSITE_Admin . 'login');
	}


}
