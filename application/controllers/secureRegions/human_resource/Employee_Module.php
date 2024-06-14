<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once (APPPATH . "controllers/secureRegions/Main.php");
class Employee_Module extends Main
{

	function __construct()
	{
		parent::__construct();

		//db
		$this->load->database();

		//libraries
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('User_auth');

		//helpers
		$this->load->helper('url');

		//models
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->model('administrator/human_resource/Employee_Model');

		//session data
		$session_uid = $this->data['session_uid'] = $this->session->userdata('sess_psts_uid');
		$this->data['session_name'] = $this->session->userdata('sess_psts_name');
		$this->data['session_email'] = $this->session->userdata('sess_psts_email');


		//admin status
		$this->data['User_auth_obj'] = new User_auth();
		$this->data['user_data'] = $this->data['User_auth_obj']->check_user_status();

		//headers
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");

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


	function index()
	{

		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/human_resource/Employee_Module/list', $this->data);
		parent::get_footer();
	}

	function employee_list()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 12;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));


		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}


		$search = array();
		$field_name = '';
		$field_value = '';
		$end_date = '';
		$start_date = '';
		$record_status = "";
		$country_id = "";
		$state_id = "";
		$city_id = "";
		$user_role_id = "";
		$designation_id = "";

		if (!empty($_REQUEST['field_name']))
			$field_name = $_POST['field_name'];
		else if (!empty($field_name))
			$field_name = $field_name;

		if (!empty($_REQUEST['field_value']))
			$field_value = $_POST['field_value'];
		else if (!empty($field_value))
			$field_value = $field_value;

		if (!empty($_POST['end_date']))
			$end_date = $_POST['end_date'];

		if (!empty($_POST['start_date']))
			$start_date = $_POST['start_date'];

		if (!empty($_POST['record_status']))
			$record_status = $_POST['record_status'];

		if (!empty($_POST['country_id']))
			$country_id = $_POST['country_id'];

		if (!empty($_POST['state_id']))
			$state_id = $_POST['state_id'];

		if (!empty($_POST['city_id']))
			$city_id = $_POST['city_id'];

		if (!empty($_POST['user_role_id']))
			$user_role_id = $_POST['user_role_id'];

		if (!empty($_POST['designation_id']))
			$designation_id = $_POST['designation_id'];

		//this is useful to retian values inside search panel after selecting country or any other options
		$this->data['field_name'] = $field_name;
		$this->data['field_value'] = $field_value;
		$this->data['end_date'] = $end_date;
		$this->data['start_date'] = $start_date;
		$this->data['record_status'] = $record_status;
		$this->data['country_id'] = $country_id;
		$this->data['state_id'] = $state_id;
		$this->data['city_id'] = $city_id;
		$this->data['user_role_id'] = $user_role_id;
		$this->data['designation_id'] = $designation_id;

		$search['end_date'] = $end_date;
		$search['start_date'] = $start_date;
		$search['field_value'] = $field_value;
		$search['field_name'] = $field_name;
		$search['record_status'] = $record_status;
		$search['country_id'] = $country_id;
		$search['state_id'] = $state_id;
		$search['city_id'] = $city_id;
		$search['user_role_id'] = $user_role_id;
		$search['designation_id'] = $designation_id;
		$search['search_for'] = "count";

		$data_count = $this->Employee_Model->get_employee($search);
		$r_count = $this->data['row_count'] = $data_count[0]->counts;

		unset($search['search_for']);

		$offset = (int) $this->uri->segment(5); //echo $offset;
		if ($offset == "") {
			$offset = '0';
		}
		$per_page = _all_pagination_;

		$this->load->library('pagination');
		//$config['base_url'] =MAINSITE.'secure_region/reports/DispatchedOrders/'.$module_id.'/';
		$this->load->library('pagination');
		$config['base_url'] = MAINSITE_Admin . $this->data['user_access']->class_name . '/' . $this->data['user_access']->function_name . '/';
		$config['total_rows'] = $r_count;
		$config['uri_segment'] = '5';
		$config['per_page'] = $per_page;
		$config['num_links'] = 4;
		$config['first_link'] = '&lsaquo; First';
		$config['last_link'] = 'Last &rsaquo;';
		$config['prev_link'] = 'Prev';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['attributes'] = array('class' => 'paginationClass');


		$this->pagination->initialize($config);

		// $this->data['page_is_master'] = $this->data['user_access']->is_master;
		// $this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;

		$search['details'] = 1;

		$search['limit'] = $per_page;
		$search['offset'] = $offset;


		$this->data['country_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'country', 'where' => "country_id > 0", "order_by" => "country_name ASC"));
		$this->data['users_role_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'users_role_master', 'where' => "user_role_id > 0", "order_by" => "user_role_name ASC"));

		$this->data['designation_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'designation_master', 'where' => "designation_id > 0", "order_by" => "designation_name ASC"));
		$this->data['employee_data'] = $this->Employee_Model->get_employee($search);

		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/human_resource/Employee_Module/employee_list', $this->data);
		parent::get_footer();
	}

	function employee_list_export()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 12;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}

		if ($this->data['user_access']->export_data != 1) {
			$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Export " . $user_access->module_name);
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		$search = array();
		$field_name = '';
		$field_value = '';
		$end_date = '';
		$start_date = '';
		$record_status = "";
		$country_id = "";
		$state_id = "";

		if (!empty($_REQUEST['field_name']))
			$field_name = $_POST['field_name'];
		else if (!empty($field_name))
			$field_name = $field_name;

		if (!empty($_REQUEST['field_value']))
			$field_value = $_POST['field_value'];
		else if (!empty($field_value))
			$field_value = $field_value;

		if (!empty($_POST['end_date']))
			$end_date = $_POST['end_date'];

		if (!empty($_POST['start_date']))
			$start_date = $_POST['start_date'];

		if (!empty($_POST['record_status']))
			$record_status = $_POST['record_status'];

		if (!empty($_POST['country_id']))
			$country_id = $_POST['country_id'];

		if (!empty($_POST['state_id']))
			$state_id = $_POST['state_id'];


		$this->data['field_name'] = $field_name;
		$this->data['field_value'] = $field_value;
		$this->data['end_date'] = $end_date;
		$this->data['start_date'] = $start_date;
		$this->data['record_status'] = $record_status;
		$this->data['country_id'] = $country_id;
		$this->data['state_id'] = $state_id;

		$search['end_date'] = $end_date;
		$search['start_date'] = $start_date;
		$search['field_value'] = $field_value;
		$search['field_name'] = $field_name;
		$search['record_status'] = $record_status;
		$search['country_id'] = $country_id;
		$search['state_id'] = $state_id;
		$search['details'] = 1;

		$this->data['employee_data'] = $this->Employee_Model->get_employee($search);


		$this->load->view('admin/human_resource/Employee_Module/employee_list_export', $this->data);
	}

	function employee_view($admin_user_id = "")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 12;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));


		if (empty($admin_user_id)) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close"
			 data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. </div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
			exit;
		}


		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}


		// $this->data['page_is_master'] = $this->data['user_access']->is_master;
		// $this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;


		$this->data['employee_data'] = $this->Employee_Model->get_employee(array("admin_user_id" => $admin_user_id, "details" => 1));

		if (empty($admin_user_id)) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" 
			aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. </div>';
			$this->session->set_flashdata('alert_message', $alert_message);

			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
			exit;
		}

		$this->data['employee_data'] = $this->data['employee_data'][0];

		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/human_resource/Employee_Module/employee_view', $this->data);
		parent::get_footer();
	}

	function employee_edit($admin_user_id = "")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 12;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));


		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}

		if (empty($admin_user_id)) {
			if ($user_access->add_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Add " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}

		if (!empty($admin_user_id)) {
			if ($user_access->update_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Update " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}

		$this->data['country_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'country', 'where' => "country_id > 0", "order_by" => "country_name ASC"));

		$this->data['users_role_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'users_role_master', 'where' => "user_role_id > 0", "order_by" => "user_role_name ASC"));

		$this->data['company_profile_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'company_profile', 'where' => "company_profile_id > 0 and status = 1", "order_by" => "company_unique_name ASC"));

		$this->data['designation_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'designation_master', 'where' => "designation_id > 0", "order_by" => "designation_name ASC"));

		// $this->data['page_is_master'] = $this->data['user_access']->is_master;
		// $this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;


		if (!empty($admin_user_id)) {
			$this->data['employee_data'] = $this->Employee_Model->get_employee(array("admin_user_id" => $admin_user_id, "details" => 1));
			if (empty($this->data['employee_data'])) {
				$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> Record Not Found. 
				  </div>');
				REDIRECT(MAINSITE_Admin . $user_access->class_name . '/' . $user_access->function_name);
			}
			$this->data['employee_data'] = $this->data['employee_data'][0];
		}

		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/human_resource/Employee_Module/employee_edit', $this->data);
		parent::get_footer();
	}

	function userEmployeeDoEdit()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 12;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));

		if (empty($_POST['first_name']) && empty($_POST['country_id']) && empty($_POST['state_id']) && empty($_POST['designation_id']) && empty($_POST['users_role_id']) && empty($_POST['address1']) && empty($_POST['email']) && empty($_POST['mobile_no']) && empty($_POST['show_password'])) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. anubhav</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
			exit;
		}
		$admin_user_id = $_POST['admin_user_id'];

		//print_r($_POST);
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		if (empty($admin_user_id)) {
			if ($user_access->add_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Add " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}
		if (!empty($admin_user_id)) {
			if ($user_access->update_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Update " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}

		$email = trim($_POST['email']);
		$name = trim($_POST['first_name']);
		if (!empty($_POST['last_name'])) {
			$name .= ' ' . trim($_POST['last_name']);
		}
		$country_id = $_POST['country_id'];
		$state_id = $_POST['state_id'];
		$city_id = $_POST['city_id'];
		$status = $_POST['status'];
		$is_exist = $this->Common_Model->getData(array('select' => '*', 'from' => 'admin_user', 'where' => "email = '$email' and admin_user_id != $admin_user_id"));
		//	echo $this->db->last_query();
		//	print_r($is_exist);
		if (!empty($is_exist)) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Human Resource already exist in database.</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			//echo $this->session->flashdata('alert_message' );
			//echo "anubhav";
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/employee-edit/" . $admin_user_id);
			exit;
		}

		$enter_data['fax_no'] = $_POST['fax_no'];
		$enter_data['email'] = $_POST['email'];
		$enter_data['show_password'] = $_POST['show_password'];
		$enter_data['password'] = md5($_POST['show_password']);
		$enter_data['first_name'] = trim($_POST['first_name']);
		$enter_data['last_name'] = trim($_POST['last_name']);
		$enter_data['address1'] = trim($_POST['address1']);
		$enter_data['address2'] = trim($_POST['address2']);
		$enter_data['address3'] = trim($_POST['address3']);
		$enter_data['mobile_no'] = trim($_POST['mobile_no']);
		$enter_data['alt_mobile_no'] = trim($_POST['alt_mobile_no']);
		$enter_data['pincode'] = trim($_POST['pincode']);
		$enter_data['country_id'] = $country_id;
		$enter_data['state_id'] = $state_id;
		$enter_data['city_id'] = $city_id;
		$enter_data['city_id'] = $city_id;
		$enter_data['name'] = $name;
		$enter_data['status'] = $_POST['status'];
		$enter_data['designation_id'] = $_POST['designation_id'];
		$enter_data['joining_date'] = date("Y-m-d", strtotime($_POST['joining_date']));
		if (!empty($_POST['termination_date']))
			$enter_data['termination_date'] = date("Y-m-d", strtotime($_POST['termination_date']));

		//$enter_data['user_role_id'] = $_POST['user_role_id'];
		$enter_data['approval_access'] = $_POST['approval_access'];
		$enter_data['data_view'] = $_POST['data_view'];

		$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. </div>';
		if (!empty($admin_user_id)) {
			$enter_data['updated_on'] = date("Y-m-d H:i:s");
			$enter_data['updated_by'] = $this->data['session_uid'];
			$insertStatus = $this->Common_Model->update_operation(array('table' => 'admin_user', 'data' => $enter_data, 'condition' => "admin_user_id = $admin_user_id"));
			if (!empty($insertStatus)) {
				$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Record Updated Successfully </div>';
			}

		} else {
			$enter_data['added_on'] = date("Y-m-d H:i:s");
			$enter_data['added_by'] = $this->data['session_uid'];
			$admin_user_id = $insertStatus = $this->Common_Model->add_operation(array('table' => 'admin_user', 'data' => $enter_data));
			if (!empty($insertStatus)) {
				$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> New Record Added Successfully </div>';
			}
		}
		if ($insertStatus > 0) {
			$user_role_id_arr = $_POST['user_role_id'];
			$company_profile_id_arr = $_POST['company_profile_id'];
			$this->upload_employee_file($admin_user_id);

			if (!empty($user_role_id_arr) && !empty($company_profile_id_arr)) {
				$this->Common_Model->delete_operation(array('table' => 'admin_user_role', 'where' => "admin_user_id = $admin_user_id"));
				for ($i = 0; $i < count($user_role_id_arr); $i++) {
					if (!empty($user_role_id_arr)) {
						$admin_user_role_data['admin_user_id'] = $admin_user_id;
						$admin_user_role_data['user_role_id'] = $user_role_id_arr[$i];
						$admin_user_role_data['company_profile_id'] = $company_profile_id_arr[$i];
						$this->Common_Model->add_operation(array('table' => 'admin_user_role', 'data' => $admin_user_role_data));
					}
				}
			}

		}
		$this->session->set_flashdata('alert_message', $alert_message);

		if (!empty($_POST['redirect_type'])) {
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/employee-edit");
		}

		REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
	}

	function upload_employee_file($admin_user_id)
	{
		$logo_file_name = "";
		$count = 0;
		if (!empty($_FILES["file"]['name'])) {
			if (!is_dir(_uploaded_temp_files_ . 'employee_file')) {
				mkdir('./' . _uploaded_temp_files_ . 'employee_file', 0777, TRUE);
			}

			$file_title = $_POST['file_title'];
			//echo count($_FILES["file"]['name']);
			for ($i = 0; $i < count($_FILES["file"]['name']); $i++) {
				if (isset($_FILES["file"]['name'][$i]) && !empty($_FILES["file"]['name'][$i])) {
					$count++;
					$timg_name = $_FILES['file']['name'][$i];
					$temp_var = explode(".", strtolower($timg_name));
					//$temp_count = rand(10,10000);
					$timage_ext = end($temp_var);
					$timage_name_new = $temp_var[0] . '_' . $admin_user_id . '_' . $count . "." . $timage_ext;
					//$timage_name_new = "file_".$quotation_enquiry_id.'_'.$count.".".$timage_ext; 
					$img_data['file_title'] = $file_title[$i];
					$img_data['admin_user_id'] = $admin_user_id;
					$img_data['file_name'] = $timage_name_new;
					$imginsertStatus = $this->Common_Model->add_operation(array('table' => 'admin_user_file', 'data' => $img_data));
					if ($imginsertStatus > 0) {
						move_uploaded_file($_FILES['file']['tmp_name'][$i], _uploaded_temp_files_ . "employee_file/" . $timage_name_new);
						$logo_file_name = $timage_name_new;
					}
				}
			}
		}
	}

	function userEmployee_doUpdateStatus()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 12;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		$task = $_POST['task'];
		$id_arr = $_POST['sel_recds'];
		if (empty($user_access)) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		if ($user_access->update_module == 1) {
			$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. 
				  </div>');
			$update_data = array();
			if (!empty($id_arr)) {
				$action_taken = "";
				$ids = implode(',', $id_arr);
				if ($task == "active") {
					$update_data['status'] = 1;
					$action_taken = "Activate";
				}
				if ($task == "block") {
					$update_data['status'] = 0;
					$action_taken = "Blocked";
				}
				$update_data['updated_on'] = date("Y-m-d H:i:s");
				$update_data['updated_by'] = $this->data['session_uid'];
				$response = $this->Common_Model->update_operation(array('table' => "admin_user", 'data' => $update_data, 'condition' => "admin_user_id in ($ids)"));
				if ($response) {
					$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="icon fas fa-check"></i> Records Successfully ' . $action_taken . ' 
						</div>');
				}
			}
			REDIRECT(MAINSITE_Admin . $user_access->class_name . '/' . $user_access->function_name);
		} else {
			$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Update " . $user_access->module_name);
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
	}




	function logout()
	{
		$this->unset_only();
		$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="icon fas fa-check"></i> You Are Successfully Logout.
		</div>');
		$this->session->unset_userdata('sess_psts_uid');
		REDIRECT(MAINSITE_Admin . 'login');
	}



	public function index1()
	{
		$this->load->view('welcome_message');
	}

	function mypdf()
	{


		$this->load->library('pdf');


		$this->pdf->load_view('mypdf');
		$this->pdf->render();


		$this->pdf->stream("welcome.pdf");
	}

	public function addNewFileLine()
	{
		if (!empty($_POST['append_id'])) {
			$this->data['append_id'] = $_POST['append_id'];
		}
		$template = $this->load->view('admin/human_resource/Employee_Module/template/file_line_add_more', $this->data, true);
		echo json_encode(array("template" => $template));
	}
}
