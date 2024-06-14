<?php
class Employee_Model extends CI_Model
{
	public $session_uid = '';
	public $session_name = '';
	public $session_email = '';

	function __construct()
	{
		$this->load->database();


		$this->model_data = array();
		$this->db->query("SET sql_mode = ''");

		//session data
		$this->session_uid = $this->session->userdata('sess_psts_uid');
		$this->session_name = $this->session->userdata('sess_psts_name');
		$this->session_email = $this->session->userdata('sess_psts_email');

	}

	function get_employee($params = array())
	{
		$result = '';

		// Check if search_for parameter is provided to decide the count query
		if (!empty($params['search_for'])) {

			$this->db->select("count(aau.admin_user_id) as counts"); // Select count of records
		} else {

			// Select all required fields and additional information
			$this->db->select("aau.* , dm.designation_name , ci.city_name , s.state_name , c.country_name , c.country_short_name , c.dial_code ");
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.added_by) as added_by_name "); // Select added_by user's name
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.updated_by) as updated_by_name "); // Select updated_by user's name
		}

		// From admin_user table
		$this->db->from("admin_user as aau");

		// Joins with other tables
		$this->db->join("country as  c", "c.country_id = aau.country_id");
		$this->db->join("state as  s", "s.state_id = aau.state_id");
		$this->db->join("city as  ci", "ci.city_id = aau.city_id");
		$this->db->join("designation_master as  dm", "dm.designation_id = aau.designation_id");

		// Conditional logic for ordering results
		if (!empty($params['order_by'])) {
			$this->db->order_by($params['order_by']);
		} else {
			$this->db->order_by("admin_user_id desc"); // Default order by admin_user_id descending
		}

		// Conditions based on provided parameters
		if (!empty($params['admin_user_id'])) {
			$this->db->where("aau.admin_user_id", $params['admin_user_id']);
		}
		if (!empty($params['country_id'])) {
			$this->db->where("aau.country_id", $params['country_id']);
		}
		if (!empty($params['state_id'])) {
			$this->db->where("aau.state_id", $params['state_id']);
		}
		if (!empty($params['city_id'])) {
			$this->db->where("aau.city_id", $params['city_id']);
		}
		if (!empty($params['designation_id'])) {
			$this->db->where("aau.designation_id", $params['designation_id']);
		}
		if (!empty($params['user_role_id'])) {
			$this->db->where("aau.user_role_id", $params['user_role_id']);
		}
		if (!empty($params['start_date'])) {
			$temp_date = date('Y-m-d', strtotime($params['start_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')"); // Start date condition
		}
		if (!empty($params['end_date'])) {
			$temp_date = date('Y-m-d', strtotime($params['end_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')"); // End date condition
		}

		if (!empty($params['record_status'])) {
			if ($params['record_status'] == 'zero') {
				$this->db->where("aau.status = 0"); // Status zero condition
			} else {
				$this->db->where("aau.status", $params['record_status']); // Specific status condition
			}
		}
		if (!empty($params['field_value']) && !empty($params['field_name'])) {
			$this->db->where("$params[field_name] like ('%$params[field_value]%')"); // Field name and value condition
		}
		if (!empty($params['limit']) && !empty($params['offset'])) {
			$this->db->limit($params['limit'], $params['offset']); // Limit and offset for pagination
		} else if (!empty($params['limit'])) {
			$this->db->limit($params['limit']); // Limit for number of records
		}


		// Execute query and get results
		$query_get_list = $this->db->get();
		$result = $query_get_list->result();//RESULT CONTAINS ARRAY OF ADMIN_USERS

		// If details parameter is provided, fetch additional details
		if (!empty($result) && !empty($params['details'])) {
			foreach ($result as $r) {
				// Fetch roles for each admin_user
				$this->db->select("aur.* , urm.user_role_name , cp.company_unique_name");
				$this->db->from("admin_user_role as aur");
				$this->db->join("users_role_master as urm", "urm.user_role_id = aur.user_role_id");
				$this->db->join("company_profile as  cp", "cp.company_profile_id = aur.company_profile_id");
				$this->db->where("aur.admin_user_id", $r->admin_user_id);
				$r->roles = $this->db->get()->result();

				// Fetch files for each admin_user
				$this->db->select("auf.*");
				$this->db->from("admin_user_file as auf");
				$this->db->where("auf.admin_user_id", $r->admin_user_id);
				$r->files = $this->db->get()->result();
			}
		}

		return $result; // Return the final result
	}
}

?>