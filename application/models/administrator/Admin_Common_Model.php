<?php
class Admin_Common_Model extends CI_Model
{
	public $session_uid = '';
	public $session_name = '';
	public $session_email = '';
	public $session_company_profile_id = '';

	function __construct()
	{
		$this->load->database();
		$this->model_data = array();
		$this->db->query("SET sql_mode = ''");
		$this->session_uid = $this->session->userdata('sess_psts_uid');
		$this->session_name = $this->session->userdata('sess_psts_name');
		$this->session_email = $this->session->userdata('sess_psts_email');
		$this->session_company_profile_id = $this->session->userdata('sess_company_profile_id');

	}

	function get_admin_user_data($params = array())
	{
		$result = '';
		$this->db->select("au.* ");//, urm.user_role_name
		$this->db->from("admin_user as au");
		//$this->db->join("users_role_master as urm" , "au.user_role_id = urm.user_role_id");
		$this->db->where("au.admin_user_id", $this->session_uid);
		$this->db->limit(1);

		$query_get_list = $this->db->get();
		$result = $query_get_list->result();
		if (!empty($result)) {
			foreach ($result as $r) {
				$this->db->select("aur.* , urm.user_role_name , cp.company_unique_name");
				$this->db->from("admin_user_role as aur");
				$this->db->join("users_role_master as urm", "urm.user_role_id = aur.user_role_id");
				$this->db->join("company_profile as  cp", "cp.company_profile_id = aur.company_profile_id");
				$this->db->where("aur.admin_user_id", $r->admin_user_id);
				$r->roles = $this->db->get()->result();
			}
			$result = $result[0];
			foreach ($result->roles as $r) {
				if ($this->session_company_profile_id == $r->company_profile_id) {
					$result->user_role_name = $r->user_role_name;
					$result->user_role_id = $r->user_role_id;
				}
			}
		}
		return $result;
	}

	/**
	 * Retrieves the left menu based on the given parameters.
	 *
	 * @param array $params An array of parameters to filter the menu items.
	 * @return array The left menu items.
	 */
	function get_left_menu_by_params($params = array())
	{
		// Initialize result variable.
		$result = '';

		// Select all columns from module_master (mm) and module_permissions (mp) tables.
		$this->db->select("mm.*, mp.*");

		// From the module_master table with alias mm.
		$this->db->from("module_master as mm");

		// Join the module_permissions table with alias mp on module_id.
		$this->db->join("module_permissions as mp", "mm.module_id = mp.module_id");

		// Join the admin_user_role table with alias au on user_role_id.
		$this->db->join("admin_user_role as au", "mp.user_role_id = au.user_role_id");

		// Filter by the company profile ID of the current session.
		$this->db->where("au.company_profile_id", $this->session_company_profile_id);

		// Filter by the admin user ID of the current session.
		$this->db->where("au.admin_user_id", $this->session_uid);

		// Filter to include only menu items marked for display.
		$this->db->where("mm.is_display", 1);

		// Filter to include only active menu items.
		$this->db->where("mm.status", 1);

		// Order the menu items by their position in ascending order.
		$this->db->order_by("mm.position ASC");

		// If a specific module ID is provided, add it to the filter.
		if (!empty($params['module_id'])) {

			$this->db->where("mm.module_id", $params['module_id']);
		}

		// If the is_master parameter is provided, filter based on its value.
		if (!empty($params['is_master'])) {
			if ($params['is_master'] == "zero") {
				$this->db->where("mm.is_master", 0);
			} else {
				$this->db->where("mm.is_master", $params['is_master']);
			}
		}

		// Redundant check for module_id, ensure only one instance is used.
		if (!empty($params['module_id'])) {
			$this->db->where("mm.module_id", $params['module_id']);
		}

		// If a specific parent module ID is provided, add it to the filter.
		if (!empty($params['parent_module_id'])) {
			$this->db->where("mm.parent_module_id", $params['parent_module_id']);
		}

		// Execute the query and get the result set.
		$query_get_list = $this->db->get();
		$result = $query_get_list->result();



		// If there are results, process each menu item.
		if (!empty($result)) {
			foreach ($result as $r) {
				// If direct_db_count and table_name are set, count the rows in the specified table.
				if (!empty($r->direct_db_count) && !empty($r->table_name)) {

					$this->db->select('count(*) as row_count');
					$this->db->from("$r->table_name");

					// If a count function is specified, apply it as a where condition.
					if (!empty($r->count_function_name)) {
						$this->db->where("$r->count_function_name");
					}

					// If the module is associated with a company profile, filter by company_profile_id.
					if ($r->is_company_profile_id == 1) {
						$this->db->where("company_profile_id", $this->session_company_profile_id);
					}

					// Execute the row count query and store the result.
					$row_count_result = $this->db->get()->result();
					$r->data_count = $row_count_result[0]->row_count;

				}



				// Retrieve the submenu items for this module.
				$r->submenu = $this->get_left_sub_menu_by_params(array("is_master" => "zero", "parent_module_id" => $r->module_id));

			}

		}



		// Return the final result.
		return $result;
	}

	/**
	 * Retrieves the left submenu items based on the given parameters.
	 *
	 * @param array $params An array of parameters to filter the submenu items.
	 * @return array The left submenu items.
	 */
	function get_left_sub_menu_by_params($params = array())
	{
		// Initialize result variable.
		$result = '';

		// Select all columns from module_master (mm) and module_permissions (mp) tables.
		$this->db->select("mm.*, mp.*");

		// From the module_master table with alias mm.
		$this->db->from("module_master as mm");

		// Join the module_permissions table with alias mp on module_id.
		$this->db->join("module_permissions as mp", "mm.module_id = mp.module_id");

		// Join the admin_user_role table with alias au on user_role_id.
		$this->db->join("admin_user_role as au", "mp.user_role_id = au.user_role_id");

		// Filter by the company profile ID of the current session.
		$this->db->where("au.company_profile_id", $this->session_company_profile_id);

		// Filter by the admin user ID of the current session.
		$this->db->where("au.admin_user_id", $this->session_uid);

		// Filter to include only menu items marked for display.
		$this->db->where("mm.is_display", 1);

		// Filter to include only active menu items.
		$this->db->where("mm.status", 1);

		// If the is_master parameter is provided, filter based on its value.
		if (!empty($params['is_master'])) {
			if ($params['is_master'] == "zero") {
				// Filter where is_master is 0.
				$this->db->where("mm.is_master = 0");
			} else {
				// Filter based on the provided is_master value.
				$this->db->where("mm.is_master", $params['is_master']);
			}
		}

		// If a specific parent module ID is provided, add it to the filter.
		if (!empty($params['parent_module_id'])) {
			$this->db->where("mm.parent_module_id", $params['parent_module_id']);
		}

		// Execute the query and get the result set.
		$query_get_list = $this->db->get();
		$result = $query_get_list->result();

		// If there are results, process each submenu item.
		if (!empty($result)) {
			foreach ($result as $r) {
				// If direct_db_count and table_name are set, count the rows in the specified table.
				if (!empty($r->direct_db_count) && !empty($r->table_name)) {
					$this->db->select('count(*) as row_count');
					$this->db->from("$r->table_name");

					// Execute the row count query and store the result.
					$row_count_result = $this->db->get()->result();
					$r->data_count = $row_count_result[0]->row_count;
				}
			}
		}

		// Return the final result.
		return $result;
	}
	/**
	 * Checks user access rights based on provided parameters.
	 * @param array $params Parameters for checking access.
	 * @return mixed Access result.
	 */
	function check_user_access($params = array())
	{
		$result = ''; // Initialize the result variable.

		// Select fields from the 'module_master' and 'module_permissions' tables.
		$this->db->select("mm.* , mp.*");
		$this->db->from("module_master as mm");
		$this->db->join("module_permissions as mp", "mm.module_id = mp.module_id");
		$this->db->join("users_role_master as urm", "urm.user_role_id = mp.user_role_id");
		//$this->db->join("admin_user as au" , "mp.user_role_id = au.user_role_id");
		$this->db->join("admin_user_role as au", "mp.user_role_id = au.user_role_id");

		// Filter by company profile ID and admin user ID from the session.
		$this->db->where("au.company_profile_id", $this->session_company_profile_id);
		$this->db->where("au.admin_user_id", $this->session_uid);

		// Filter by status of module and user role master.
		$this->db->where("mm.status", 1);
		$this->db->where("urm.status", 1);

		// Additional filtering based on provided parameters.

		if (!empty($params['is_master'])) {
			if ($params['is_master'] == "zero") {
				$this->db->where("mm.is_master", 0);
			} else {
				$this->db->where("mm.is_master", $params['is_master']);
			}
		}

		if (!empty($params['parent_module_id'])) {
			$this->db->where("mm.parent_module_id", $params['parent_module_id']);
		}


		//we get this $params['module_id'] from the functions in  Module controllers 
		//eg country_list() method in controllers/secureRegions/Country_Module 
		if (!empty($params['module_id'])) {
			$this->db->where("mm.module_id", $params['module_id']);
		}

		// Execute the query and get the result.
		$query_get_list = $this->db->get();
		$result = $query_get_list->result();

		// If result is not empty, assign the first result to $result.
		if (!empty($result)) {
			$result = $result[0];
		}

		return $result; // Return the access result.
	}


	function getData($params = array())
	{
		$this->db->select($params['select']);
		$this->db->from($params['from']);
		if (!empty($params['where'])) {
			$this->db->where("($params[where])");
		}

		if (!empty($params['limit'])) {
			$this->db->limit($params['limit']);
		}
		if (!empty($params['order_by'])) {
			$this->db->order_by($params['order_by']);
		}
		$query_get_list = $this->db->get();
		return $query_get_list->result();
	}
}

?>