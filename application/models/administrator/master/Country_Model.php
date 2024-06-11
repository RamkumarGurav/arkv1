<?php
class Country_Model extends CI_Model
{
	public $session_uid = '';
	public $session_name = '';
	public $session_email = '';

	function __construct()
	{
		$this->load->database();
		$this->model_data = array();
		$this->db->query("SET sql_mode = ''");
		$this->session_uid = $this->session->userdata('sess_psts_uid');
		$this->session_name = $this->session->userdata('sess_psts_name');
		$this->session_email = $this->session->userdata('sess_psts_email');

	}


	/**
	 * getting countries with search ,pagination  and sorting using params ,if your using this method to find single country data with its country_id then it will be present int the 0th index of the resultant array
	 */
	function get_country($params = array())
	{
		$result = ''; // Initialize the variable to store the result

		// Check if 'search_for' parameter is provided
		if (!empty($params['search_for'])) {
			// If searching for count, select the count of country_id
			$this->db->select("count(urm.country_id) as counts");
		} else {
			// Otherwise, select all fields from the country table
			$this->db->select("urm.*");
			// Select the name of the user who added the country
			$this->db->select("(select au.name from admin_user as au where au.admin_user_id = urm.added_by) as added_by_name");
			// Select the name of the user who last updated the country
			$this->db->select("(select au.name from admin_user as au where au.admin_user_id = urm.updated_by) as updated_by_name");
		}

		// Set the table to select data from
		$this->db->from("country as urm");
		// Order the results by country_id in descending order
		$this->db->order_by("country_id desc");

		// Check if country_id parameter is provided
		if (!empty($params['country_id'])) {
			// Add a condition to select data only for the specified country_id
			$this->db->where("urm.country_id", $params['country_id']);
		}

		// Check if start_date parameter is provided
		if (!empty($params['start_date'])) {
			// Convert start_date to proper format and add condition to select data added on or after start_date
			$temp_date = date('Y-m-d', strtotime($params['start_date']));
			$this->db->where("DATE_FORMAT(urm.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}

		// Check if end_date parameter is provided
		if (!empty($params['end_date'])) {
			// Convert end_date to proper format and add condition to select data added on or before end_date
			$temp_date = date('Y-m-d', strtotime($params['end_date']));
			$this->db->where("DATE_FORMAT(urm.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}

		// Check if record_status parameter is provided
		if (!empty($params['record_status'])) {
			// Add condition based on record_status value
			if ($params['record_status'] == 'zero') {
				// If record_status is 'zero', select data where status is 0
				$this->db->where("urm.status = 0");
			} else {
				// Otherwise, select data for the specified record_status
				$this->db->where("urm.country_id", $params['record_status']);
			}
		}

		// Check if field_name and field_value parameters are provided for searching
		if (!empty($params['field_value']) && !empty($params['field_name'])) {
			// Add a condition to select data where the specified field contains the specified value
			$this->db->where("$params[field_name] like ('%$params[field_value]%')");
		}

		// Check if limit and offset parameters are provided for pagination
		if (!empty($params['limit']) && !empty($params['offset'])) {
			// Limit the number of results based on the provided limit and offset
			$this->db->limit($params['limit'], $params['offset']);
		} else if (!empty($params['limit'])) {
			// If only limit is provided, limit the number of results without offset
			$this->db->limit($params['limit']);
		}

		// Execute the query and retrieve the result
		$query_get_list = $this->db->get();
		$result = $query_get_list->result();

		// Return the result
		return $result;
	}

}

?>