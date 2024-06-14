<?php
# Same Model we are using for Reports section
class Company_Profile_Model extends CI_Model
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

	function get_company_profile($params = array())
	{
		$result = ''; // Initialize result variable

		if (!empty($params['search_for'])) { // Check if search_for parameter is set
			$this->db->select("count(aau.company_profile_id) as counts"); // Select count of company profiles
		} else {
			// Select specific columns and additional fields for company profiles
			$this->db->select("aau.*, ci.city_name, s.state_name, c.country_name, c.country_short_name, c.dial_code");
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.added_by) as added_by_name");
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.updated_by) as updated_by_name");
		}


		$this->db->from("company_profile as aau"); // Select from company_profile table
		$this->db->join("country as c", "c.country_id = aau.country_id"); // Join country table
		$this->db->join("state as s", "s.state_id = aau.state_id"); // Join state table
		$this->db->join("city as ci", "ci.city_id = aau.city_id"); // Join city table
		$this->db->order_by("company_profile_id desc"); // Order results by company_profile_id in descending order

		if (!empty($params['company_profile_id'])) {
			$this->db->where("aau.company_profile_id", $params['company_profile_id']); // Filter by company_profile_id
		}
		if (!empty($params['country_id'])) {
			$this->db->where("aau.country_id", $params['country_id']); // Filter by country_id
		}

		if (!empty($params['state_id'])) {
			$this->db->where("aau.state_id", $params['state_id']); // Filter by state_id
		}

		if (!empty($params['city_id'])) {
			$this->db->where("aau.city_id", $params['city_id']); // Filter by city_id
		}

		if (!empty($params['start_date'])) {
			// Filter by start date formatted to Y-m-d
			$temp_date = date('Y-m-d', strtotime($params['start_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}

		if (!empty($params['end_date'])) {
			// Filter by end date formatted to Y-m-d
			$temp_date = date('Y-m-d', strtotime($params['end_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}

		if (!empty($params['record_status'])) {
			if ($params['record_status'] == 'zero') {
				$this->db->where("aau.status = 0"); // Filter by status equals 0
			} else {
				$this->db->where("aau.company_profile_id", $params['record_status']); // Filter by company_profile_id
			}
		}

		if (!empty($params['field_value']) && !empty($params['field_name'])) {
			// Filter by field name and value using LIKE operator
			$this->db->where("$params[field_name] like ('%$params[field_value]%')");
		}

		if (!empty($params['limit']) && !empty($params['offset'])) {
			// Apply limit and offset for pagination
			$this->db->limit($params['limit'], $params['offset']);
		} else if (!empty($params['limit'])) {
			// Apply only limit
			$this->db->limit($params['limit']);
		}

		$query_get_list = $this->db->get(); // Execute the query
		$result = $query_get_list->result(); // Fetch results into $result variable

		return $result; // Return the fetched results
	}

}

?>