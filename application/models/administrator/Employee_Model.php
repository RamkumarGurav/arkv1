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

		$this->session_uid = $this->session->userdata('sess_psts_uid');
		$this->session_name = $this->session->userdata('sess_psts_name');
		$this->session_email = $this->session->userdata('sess_psts_email');

	}

	/**
	 * The get_employee method retrieves employee data from the database based on various parameters such as filters for country, state, city, designation, user role, and date ranges. It also includes pagination and can optionally fetch detailed role and file information for each employee. If a search parameter is provided, it returns a count of matching records.
	 */
	function get_employee($params = array())
	{
		$result = '';

		// Check if 'search_for' parameter is provided
		if (!empty($params['search_for'])) {
			// If 'search_for' is provided, select the count of admin_user_id
			$this->db->select("count(aau.admin_user_id) as counts");
		} else {
			// If 'search_for' is not provided, select various fields from admin_user and related tables
			$this->db->select("aau.* , dm.designation_name , ci.city_name , s.state_name , c.country_name , c.country_short_name , c.dial_code ");
			//These lines are subqueries that fetch the names of user who added and updated the current admin_user record
			$this->db->select("(select au.name from admin_user as au where au.admin_user_id = aau.added_by) as added_by_name ");
			$this->db->select("(select au.name from admin_user as au where au.admin_user_id = aau.updated_by) as updated_by_name ");
		}

		// From the admin_user table alias aau
		$this->db->from("admin_user as aau");

		// Join with country, state, city, and designation_master tables
		$this->db->join("country as c", "c.country_id = aau.country_id");
		$this->db->join("state as s", "s.state_id = aau.state_id");
		$this->db->join("city as ci", "ci.city_id = aau.city_id");
		$this->db->join("designation_master as dm", "dm.designation_id = aau.designation_id");

		// Apply order by clause if 'order_by' parameter is provided
		if (!empty($params['order_by'])) {
			$this->db->order_by($params['order_by']);
		} else {
			// Default order by admin_user_id in descending order
			$this->db->order_by("admin_user_id desc");
		}

		// Apply filters based on provided parameters
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

		// Apply date filters
		if (!empty($params['start_date'])) {
			$temp_date = date('Y-m-d', strtotime($params['start_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}


		if (!empty($params['end_date'])) {
			$temp_date = date('Y-m-d', strtotime($params['end_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}

		// Apply status filter
		if (!empty($params['record_status'])) {
			if ($params['record_status'] == 'zero') {
				$this->db->where("aau.status = 0");
			} else {
				$this->db->where("aau.status", $params['record_status']);
			}
		}

		// Apply field name and value filter for search
		if (!empty($params['field_value']) && !empty($params['field_name'])) {
			$this->db->where("$params[field_name] like ('%$params[field_value]%')");
		}

		// Apply limit and offset for pagination
		if (!empty($params['limit']) && !empty($params['offset'])) {
			$this->db->limit($params['limit'], $params['offset']);
		} else if (!empty($params['limit'])) {
			$this->db->limit($params['limit']);
		}

		// Execute the query
		$query_get_list = $this->db->get();
		$result = $query_get_list->result();

		// Check if the result is not empty
		if (!empty($result)) {
			// If 'details' parameter is provided, fetch additional details
			if (!empty($params['details'])) {
				foreach ($result as $r) {
					// Fetch roles for each admin user
					$this->db->select("aur.* , urm.user_role_name , cp.company_unique_name");
					$this->db->from("admin_user_role as aur");
					$this->db->join("users_role_master as urm", "urm.user_role_id = aur.user_role_id");
					$this->db->join("company_profile as cp", "cp.company_profile_id = aur.company_profile_id");
					$this->db->where("aur.admin_user_id", $r->admin_user_id);
					$r->roles = $this->db->get()->result();

					// Fetch files for each admin user
					$this->db->select("auf.*");
					$this->db->from("admin_user_file as auf");
					$this->db->where("auf.admin_user_id", $r->admin_user_id);
					$r->files = $this->db->get()->result();
				}
			}
		}



		// Return the result
		return $result;
	}

}

?>