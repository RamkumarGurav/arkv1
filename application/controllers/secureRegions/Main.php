<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		//db
		$this->load->database();

		//libraries
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('User_auth');


		//helpers
		$this->load->helper('url');
		$this->load->helper('form');

		//models
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');


		//data storing from sessions
		$session_uid = $this->data['session_uid'] = $this->session->userdata('sess_psts_uid');
		$this->data['session_name'] = $this->session->userdata('sess_psts_name');
		$this->data['session_email'] = $this->session->userdata('sess_psts_email');

		//checking logged in admin user status
		$this->data['User_auth_obj'] = new User_auth();
		$this->data['user_data'] = $this->data['User_auth_obj']->check_user_status();


		$this->data['csrf'] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);


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
	 * loads the header.
	 */

	function get_header()
	{
		$this->load->view('admin/inc/header', $this->data);
	}

	/**
	 * Generates the left navigation menu based on user permissions and loads the view.
	 */
	function get_left_nav()
	{
		// Initialize variables to store the current page's master status, parent module ID, and module ID.
		$page_is_master = "";
		$page_parent_module_id = "";
		$page_module_id = "";

		// Check if 'page_is_master' is set in the data array and assign it to the variable if it exists.
		if (!empty($this->data['page_is_master'])) {
			$page_is_master = $this->data['page_is_master'];
		}

		// Check if 'page_parent_module_id' is set in the data array and assign it to the variable if it exists.
		if (!empty($this->data['page_parent_module_id'])) {
			$page_parent_module_id = $this->data['page_parent_module_id'];
		}

		// Check if 'page_module_id' is set in the data array and assign it to the variable if it exists.
		if (!empty($this->data['page_module_id'])) {
			$page_module_id = $this->data['page_module_id'];
		}

		// Create an associative array with the page parameters.
		$params_arr = array(
			"page_is_master" => $page_is_master,
			"page_parent_module_id" => $page_parent_module_id,
			"page_module_id" => $page_module_id
		);

		// Get the left menu for master modules and store it in the 'left_menu_master' key of the data array.
		$this->data['left_menu_master'] = $this->data['User_auth_obj']
			->get_left_menu_by_ismaster_params_moduleid(1, $params_arr);

		// The following lines are commented out but show how to get other types of menus.
		// Get the left menu for company profiles and store it in the 'left_menu_company_profile' key of the data array.
		$this->data['left_menu_company_profile'] = $this->data['User_auth_obj']
			->get_left_menu_by_ismaster_params_moduleid(3, $params_arr);

		// Get the left menu for employees and store it in the 'left_menu_employee' key of the data array.
		$this->data['left_menu_employee'] = $this->data['User_auth_obj']
			->get_left_menu_by_ismaster_params_moduleid(2, $params_arr);

		// Get the left menu for catalog and store it in the 'left_menu_catalog' key of the data array.
		// $this->data['left_menu_catalog'] = $this->data['User_auth_obj']
		//     ->get_left_menu_by_ismaster_params_moduleid(4, $params_arr);

		// Get the left menu for enquiries and store it in the 'left_menu_enquiry' key of the data array.
		// $this->data['left_menu_enquiry'] = $this->data['User_auth_obj']->get_left_menu_by_ismaster_params_moduleid(5, $params_arr);

		// Get the left menu for banners and store it in the 'left_menu_banner' key of the data array.
		// $this->data['left_menu_banner'] = $this->data['User_auth_obj']->get_left_menu_by_ismaster_params_moduleid(6, $params_arr);

		// Get the left menu for gallery and store it in the 'left_menu_gallery' key of the data array.
		// $this->data['left_menu_gallery'] = $this->data['User_auth_obj']->get_left_menu_by_ismaster_params_moduleid(7, $params_arr);

		// Get the left menu for videos and store it in the 'left_menu_videos' key of the data array.
		// $this->data['left_menu_videos'] = $this->data['User_auth_obj']->get_left_menu_by_ismaster_params_moduleid(9, $params_arr);

		// Get the left menu for working methods and store it in the 'left_menu_working_method' key of the data array.
		// $this->data['left_menu_working_method'] = $this->data['User_auth_obj']->get_left_menu_by_ismaster_params_moduleid(10, $params_arr);

		// Get the left menu for orders and store it in the 'left_menu_orders' key of the data array.
		// $this->data['left_menu_orders'] = $this->data['User_auth_obj']->get_left_menu_by_ismaster_params_moduleid(13, $params_arr);

		// Get the left menu for customers and store it in the 'left_menu_customers' key of the data array.
		// $this->data['left_menu_customers'] = $this->data['User_auth_obj']->get_left_menu_by_ismaster_params_moduleid(8, $params_arr);

		// Load the 'left_nav' view and pass the data array to it.
		$this->load->view('admin/inc/left_nav', $this->data);
	}


	/**
	 * Generates the folter and loads the view.
	 */
	function get_footer()
	{
		$this->load->view('admin/inc/footer', $this->data);
	}


}
