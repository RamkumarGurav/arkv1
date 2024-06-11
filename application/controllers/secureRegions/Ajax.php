<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ("Main.php");
class Ajax extends Main
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->model('administrator/Ajax_Model');
		$this->load->library('User_auth');

		$session_uid = $this->data['session_uid'] = $this->session->userdata('sess_psts_uid');
		$this->data['session_name'] = $this->session->userdata('sess_psts_name');
		$this->data['session_email'] = $this->session->userdata('sess_psts_email');
		$this->data['sess_company_profile_id'] = $this->session->userdata('sess_company_profile_id');

		$this->load->helper('url');

		$this->data['User_auth_obj'] = new User_auth();
		$this->data['user_data'] = $this->data['User_auth_obj']->check_user_status();
		$sess_left_nav = $this->session->flashdata('sess_left_nav');
		if (!empty($sess_left_nav)) {
			$this->session->set_flashdata('sess_left_nav', $sess_left_nav);
			$this->data['page_module_id'] = $sess_left_nav;
		}

	}

	function unset_only()
	{
		$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}
	}

	/**
	 * Get HTML of select Dropdown of states and states data json
	 */
	function getState()
	{
		// Initialize variables for state_id and country_id with default value '0'
		$state_id = $country_id = '0';

		// Check if 'country_id' is present in the POST request, if so, assign it to $country_id
		if (!empty($_POST['country_id'])) {
			$country_id = $_POST['country_id'];
		}

		// Check if 'state_id' is present in the POST request, if so, assign it to $state_id
		if (!empty($_POST['state_id'])) {
			$state_id = $_POST['state_id'];
		}

		// Query to get state data from the database for the given country_id
		$state_data = $this->Common_Model->getData(
			array(
				'select' => '*',
				'from' => 'state',
				'where' => "country_id = $country_id",
				"order_by" => "state_name ASC"
			)
		);

		// Initialize the result with the default option
		$result = '<option value="">Select State</option>';

		// Check if there is any state data retrieved
		if (!empty($state_data)) {
			// Loop through each state data
			foreach ($state_data as $r) {
				// Initialize variables for block status and selected option
				$if_block = $selected = '';

				// If the state_id matches the retrieved state_id, mark it as selected
				if ($r->state_id == $state_id) {
					$selected = "selected";
				}

				// If the state status is not active (status != 1), mark it as blocked
				if ($r->status != 1) {
					$if_block = " [Block]";
				}

				// Append the state option to the result string with the state name and block status if applicable
				$result .= '<option value="' . $r->state_id . '" ' . $selected . '>' . $r->state_name . $if_block . '</option>';
			}
		}

		// Return the result as a JSON response with the state options and state data
		echo json_encode(array("state_html" => $result, "state_json" => $state_data));
	}


	/**
	 * Get HTML json of select Dropdown of cities and cities data json
	 */
	function getCity()
	{
		$state_id = $city_id = '0';
		if (!empty($_POST['city_id'])) {
			$city_id = $_POST['city_id'];
		}
		if (!empty($_POST['state_id'])) {
			$state_id = $_POST['state_id'];
		}

		$city_data = $this->Common_Model->getData(array('select' => '*', 'from' => 'city', 'where' => "state_id = $state_id", "order_by" => "city_name ASC"));
		$result = '<option value="">Select City</option>';
		if (!empty($city_data)) {
			foreach ($city_data as $r) {
				$if_block = $selected = '';
				if ($r->city_id == $city_id) {
					$selected = "selected";
				}
				if ($r->status != 1) {
					$if_block = " [Block]";
				}
				$result .= '<option value="' . $r->city_id . '" ' . $selected . '>' . $r->city_name . $if_block . '</option>';
			}
		}
		echo json_encode(array("city_html" => $result, "city_json" => $city_data));
	}

	function del_employee_file()
	{
		$admin_user_file_id = $_POST['admin_user_file_id'];
		$file_data = $this->Common_Model->getData(array('select' => '*', 'from' => 'admin_user_file', 'where' => "admin_user_file_id = $admin_user_file_id"));
		if (!empty($file_data)) {
			$file_data = $file_data[0];
			unlink("assets/employee_file/" . $file_data->file_name);
			$this->Common_Model->delete_operation(array('table' => 'admin_user_file', 'where' => "admin_user_file_id = $admin_user_file_id"));
		}
	}

}
