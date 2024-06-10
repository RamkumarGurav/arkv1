<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class User_auth
{
	private $CI;
	public $session_uid = '';
	public $session_name = '';
	public $session_email = '';
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->library('session');
		$this->CI->load->helper('url');
		$this->CI->load->model('administrator/Admin_Common_Model');

		$this->session_uid = $this->CI->session->userdata('sess_psts_uid');
		$this->session_name = $this->CI->session->userdata('sess_psts_name');
		$this->session_email = $this->CI->session->userdata('sess_psts_email');
		$this->sess_company_profile_id = $this->CI->session->userdata('sess_company_profile_id');
	}

	function check_user_status()
	{
		$this->data['user_data'] = '';
		if ($this->session_uid > 0 && !empty($this->session_name)) {
			$this->data['user_data'] = $this->CI->Admin_Common_Model->get_admin_user_data(array());
			if (!empty($this->data['user_data'])) {
				if ($this->data['user_data']->status != 1) {
					$this->unset_only();
					$this->CI->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> You are blocked by Management.
					</div>');
					$this->CI->session->unset_userdata('sess_psts_uid');
					$this->CI->session->unset_userdata('sess_psts_uid');
					REDIRECT(MAINSITE_Admin . 'login');
				}
			} else {
				$this->unset_only();
				$this->CI->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again.
				</div>');
				$this->CI->session->unset_userdata('sess_psts_uid');
				REDIRECT(MAINSITE_Admin . 'login');
			}

		} else {
			$this->unset_only();
			$this->CI->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<i class="icon fas fa-ban"></i> Session Out Please Try Again.
			</div>');
			$this->CI->session->unset_userdata('sess_psts_uid');
			REDIRECT(MAINSITE_Admin . 'login');
		}

		$screen_lock = $this->CI->session->userdata('screen_lock');
		if (!empty($screen_lock)) {
			REDIRECT(MAINSITE_Admin . 'Screen-Lock');
		}


		return $this->data['user_data'];
	}

	function unset_only()
	{
		$user_data = $this->CI->session->all_userdata();
		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->CI->session->unset_userdata($key);
			}
		}
	}

	/**
	 * Generates the left menu HTML based on the master status, additional parameters, and module ID.
	 *
	 * @param mixed $is_master The master status to filter the menu items.
	 * @param array $params Additional parameters to customize the menu.
	 * @param int $module_id The ID of the module to filter the menu items.
	 * @return string|false The generated HTML for the left menu, or false if the conditions are not met.
	 */
	function get_left_menu_by_ismaster_params_moduleid($is_master, $params = array(), $module_id = 0)
	{
		// Check if $is_master is not empty or if the condition is always true (which it currently is).
		if (!empty($is_master) || true) {
			// Get the menu items from the Admin_Common_Model based on the provided parameters.
			//here menu details are fetched based on the "is_master" value
			$menu = $this->CI->Admin_Common_Model->get_left_menu_by_params(array("is_master" => $is_master, "module_id" => $module_id));

			// Initialize the display_menu variable to hold the generated HTML.
			$display_menu = "";

			// Iterate over each menu item.
			foreach ($menu as $m) {
				// Check if the current menu item has a submenu.
				//in this project there are no submenues
				if (!empty($m->submenu)) {

					// Generate the HTML for the main menu item with submenus.
					$display_menu .= $this->get_main_menu_html_by_obj_params($m, $params);
				} else {
					// Generate the HTML for the submenu item.
					$display_menu .= $this->get_sub_menu_html_by_obj_params($m, $params);
				}
			}

			// Return the generated menu HTML.
			return $display_menu;
		} else {
			// If $is_master is empty and the condition is false, return false.
			return false;
		}
	}

	/**
	 * Generates HTML for a main menu item with submenus based on the provided object and parameters.
	 *
	 * @param object $obj The menu item object containing information such as class name, function name, module name, etc.
	 * @param array $params Additional parameters to customize the menu.
	 * @return string The generated HTML for the main menu item.
	 */
	function get_main_menu_html_by_obj_params($obj, $params)
	{
		// Initialize the variable to store the active class if the current menu item is active.
		$active = "";

		// Initialize the variable to store the 'is_menu' class if needed.
		$is_menu = '';

		// Create the link URL using the main site admin path, class name, and function name.
		$page_url = MAINSITE_Admin . $obj->class_name . '/' . $obj->function_name;

		// Start generating the HTML for the main menu item.
		$html = '<li class="nav-item has-treeview ' . $is_menu . '">
        <a href="#" class="nav-link ' . $active . '">
            <i class="nav-icon fas fa-circle"></i>
            <p>
            ' . $obj->module_name;

		// Add an angle-left icon to indicate that this menu item has submenus.
		$html .= '<i class="right fas fa-angle-left"></i>';

		// If the menu item has a data count, add a badge to display the count.
		if (!empty($obj->data_count)) {
			$html .= '<span class="badge badge-info right">' . $obj->data_count . '</span>';
		}

		// Close the <p> tag and start a new <ul> for the submenu items.
		$html .= '</p></a><ul class="nav nav-treeview">';

		// Iterate over each submenu item and generate its HTML.
		foreach ($obj->submenu as $s) {
			$html .= $this->get_sub_menu_html_by_obj_params($s, $params);
		}

		// Close the <ul> and <li> tags for the main menu item.
		$html .= "</ul></li>";

		// Return the generated HTML for the main menu item.
		return $html;
	}


	/**
	 * Generates HTML for a submenu item based on the given object and parameters.
	 *
	 * @param object $obj The module object containing submenu details.
	 * @param array $params An array of parameters to determine active state and other conditions.
	 * @return string The generated HTML for the submenu item.
	 */
	function get_sub_menu_html_by_obj_params($obj, $params)
	{
		// Initialize the active variable.
		$active = "";

		// Check if page_module_id is provided in params and matches the current module's ID.
		if (!empty($params['page_module_id'])) {
			if ($params['page_module_id'] == $obj->module_id) {
				// Set the active class if the current module is active.
				$active = "active";
			}
		}

		// Generate the URL for the submenu item.
		$page_url = MAINSITE_Admin . $obj->class_name . '/' . $obj->function_name;

		// Start building the HTML for the submenu item.
		$html = '<li class="nav-item"><a href="' . $page_url . '" class="nav-link ' . $active . '">';



		// Check if the module object has an icon.
		if (!empty($obj->icon)) {
			// If an icon is provided, replace placeholder with the base URL.
			$nav_icon = $obj->icon;
			$nav_icon = str_replace('#mainsite#', base_url(), $nav_icon);
			// Add the icon HTML to the submenu item.
			$html .= $nav_icon;
		} else {
			// If no icon is provided, use a default icon.
			$html .= '<i class="far fa-circle nav-icon"></i>';
		}

		// Add the module name to the submenu item.
		$html .= '<p>' . $obj->module_name;

		// If data_count is provided, add it as a badge to the submenu item.
		if (!empty($obj->data_count)) {
			$html .= '<span class="badge badge-info right">' . $obj->data_count . '</span>';
		}

		// Close the HTML tags for the submenu item.
		$html .= "</p></a></li>";


		// Return the generated HTML.
		return $html;
	}


	function check_user_access($params = array())
	{
		if (!empty($params)) {
			$menu = $this->CI->Admin_Common_Model->check_user_access($params);
			return $menu;
		} else {
			return false;
		}
	}

	function getData($params = array())
	{
		$this->CI->db->select($params['select']);
		$this->CI->db->from($params['from']);
		$this->CI->db->where("($params[where])");
		if (!empty($params['limit'])) {
			$this->CI->db->limit($params['limit']);
		}
		if (!empty($params['order_by'])) {
			$this->CI->db->order_by($params['order_by']);
		}
		$query_get_list = $this->CI->db->get();
		return $query_get_list->result();
	}

	function add_operation($params = array())
	{
		if (empty($params))
			return false;
		$status = $this->CI->db->insert($params['table'], $params['data']);
		if ($status) {
			$status = $status = $this->CI->db->insert_id();
		}
		return $status;
	}

	public function getFiscalYear()
	{
		$result = array();
		$start = '';
		$end = '';
		$s_start = '';
		$s_end = '';
		if (date('m') < 4) {//Upto march 
			$start = date('Y') - 1;
			$end = date('Y');
			$s_start = date('y') - 1;
			$s_end = date('y');
			//$financial_year = (date('Y')-1) . '-' . date('Y');
		} else {//form April 
			$start = date('Y');
			$end = date('Y') + 1;
			$s_start = date('y');
			$s_end = date('y') + 1;
			//$financial_year = date('Y') . '-' . (date('Y') + 1);
		}

		$work_year = date('Y');
		$result['work_year'] = $work_year;
		$result['start'] = $start;
		$result['end'] = $end;
		$result['short_start'] = $s_start;
		$result['short_end'] = $s_end;
		$result['financial_year'] = $work_year;
		$result['short_financial_year'] = $s_start . '-' . $s_end;

		return (object) $result;
	}


}
