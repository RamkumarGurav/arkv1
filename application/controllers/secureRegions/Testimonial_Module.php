<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once (APPPATH . "controllers/secureRegions/Main.php");
class Testimonial_Module extends Main
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->model('administrator/Testimonial_Model');
		$this->load->library('pagination');

		$this->load->library('User_auth');

		$session_uid = $this->data['session_uid'] = $this->session->userdata('sess_psts_uid');
		$this->data['session_name'] = $this->session->userdata('sess_psts_name');
		$this->data['session_email'] = $this->session->userdata('sess_psts_email');

		$this->load->helper('url');

		$this->data['User_auth_obj'] = new User_auth();
		$this->data['user_data'] = $this->data['User_auth_obj']->check_user_status();

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
		$this->load->view('admin/Testimonial_Module/list', $this->data);
		parent::get_footer();
	}

	function testimonial_list()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 44;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		$search = array();
		$field_name = '';
		$field_value = '';
		$end_date = '';
		$start_date = '';
		$record_status = "";

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


		$this->data['field_name'] = $field_name;
		$this->data['field_value'] = $field_value;
		$this->data['end_date'] = $end_date;
		$this->data['start_date'] = $start_date;
		$this->data['record_status'] = $record_status;

		$search['end_date'] = $end_date;
		$search['start_date'] = $start_date;
		$search['field_value'] = $field_value;
		$search['field_name'] = $field_name;
		$search['record_status'] = $record_status;
		$search['search_for'] = "count";

		$data_count = $this->Testimonial_Model->get_testimonial($search);
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

		$this->data['page_is_master'] = $this->data['user_access']->is_master;
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;

		$search['limit'] = $per_page;
		$search['offset'] = $offset;
		$this->data['testimonial_data'] = $this->Testimonial_Model->get_testimonial($search);

		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/Testimonial_Module/testimonial_list', $this->data);
		parent::get_footer();
	}

	function testimonial_list_export()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 44;
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


		$this->data['field_name'] = $field_name;
		$this->data['field_value'] = $field_value;
		$this->data['end_date'] = $end_date;
		$this->data['start_date'] = $start_date;
		$this->data['record_status'] = $record_status;

		$search['end_date'] = $end_date;
		$search['start_date'] = $start_date;
		$search['field_value'] = $field_value;
		$search['field_name'] = $field_name;
		$search['record_status'] = $record_status;

		$this->data['testimonial_data'] = $this->Testimonial_Model->get_testimonial($search);


		$this->load->view('admin/Testimonial_Module/testimonial_list_export', $this->data);
	}

	function testimonial_view($testimonial_id = "")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 44;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if (empty($testimonial_id)) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. anubhav</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
			exit;
		}
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		$this->data['page_is_master'] = $this->data['user_access']->is_master;
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;
		$this->data['testimonial_data'] = $this->Testimonial_Model->get_testimonial(array("testimonial_id" => $testimonial_id));
		if (empty($testimonial_id)) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. anubhav</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
			exit;
		}

		$this->data['testimonial_data'] = $this->data['testimonial_data'][0];

		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/Testimonial_Module/testimonial_view', $this->data);
		parent::get_footer();
	}

	function testimonial_edit($testimonial_id = "")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 44;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		if (empty($testimonial_id)) {
			if ($user_access->add_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Add " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}
		if (!empty($testimonial_id)) {
			if ($user_access->update_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Update " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}

		$this->data['page_is_master'] = $this->data['user_access']->is_master;
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;
		if (!empty($testimonial_id)) {
			$this->data['testimonial_data'] = $this->Testimonial_Model->get_testimonial(array("testimonial_id" => $testimonial_id));
			if (empty($this->data['testimonial_data'])) {
				$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> Record Not Found.
				  </div>');
				REDIRECT(MAINSITE_Admin . $user_access->class_name . '/' . $user_access->function_name);
			}
			$this->data['testimonial_data'] = $this->data['testimonial_data'][0];
		}

		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/Testimonial_Module/testimonial_edit', $this->data);
		parent::get_footer();
	}

	function usertestimonialDoEdit()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 44;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));

		if (empty($_POST['testimonial_name'])) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. anubhav</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
			exit;
		}
		$testimonial_id = $_POST['testimonial_id'];
		//print_r($_POST);
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		if (empty($testimonial_id)) {
			if ($user_access->add_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Add " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}
		if (!empty($testimonial_id)) {
			if ($user_access->update_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Update " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}

		$content = trim($_POST['content']);
		$testimonial_name = trim($_POST['testimonial_name']);
		$testimonial_video = trim($_POST['testimonial_video']);
		$status = $_POST['status'];
		$is_exist = $this->Common_Model->getData(array('select' => '*', 'from' => 'testimonial', 'where' => "testimonial_name = '$testimonial_name' and testimonial_id != $testimonial_id"));
		//	echo $this->db->last_query();
		//	print_r($is_exist);
		if (!empty($is_exist)) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Testimonial already exist in database.</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			//echo $this->session->flashdata('alert_message' );
			//echo "anubhav";
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/testimonial-edit/" . $testimonial_id);
			exit;
		}

		$enter_data['content'] = $content;
		$enter_data['testimonial_video'] = $testimonial_video;
		$enter_data['testimonial_name'] = $testimonial_name;
		$enter_data['status'] = $_POST['status'];

		$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. </div>';
		if (!empty($testimonial_id)) {
			$enter_data['updated_on'] = date("Y-m-d H:i:s");
			$enter_data['updated_by'] = $this->data['session_uid'];
			$insertStatus = $this->Common_Model->update_operation(array('table' => 'testimonial', 'data' => $enter_data, 'condition' => "testimonial_id = $testimonial_id"));
			if (!empty($insertStatus)) {

				$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Record Updated Successfully </div>';
			}

		} else {
			$enter_data['added_on'] = date("Y-m-d H:i:s");
			$enter_data['added_by'] = $this->data['session_uid'];
			$insertStatus = $this->Common_Model->add_operation(array('table' => 'testimonial', 'data' => $enter_data));
			if (!empty($insertStatus)) {

				$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> New Record Added Successfully </div>';
			}


		}
		$this->session->set_flashdata('alert_message', $alert_message);

		if (!empty($_POST['redirect_type'])) {
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/testimonial-edit");
		}

		REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
	}
	function GetCompletetestimoniallistNewPos()
	{
		$search = array();
		$testimonial_id = '';
		$podId = '';
		$podIdArr = '';
		if (!empty($_POST['testimonial_id']))
			$testimonial_id = $_POST['testimonial_id'];
		if (!empty($_POST['podId'])) {
			$podId = trim($_POST['podId'], ',');
			$podIdArr = explode(',', $podId);
		}
		$this->data['testimonial_id'] = $testimonial_id;
		$this->data['podId'] = $podIdArr;
		$search['testimonial_id'] = $testimonial_id;
		$search['podId'] = $podIdArr;
		$search['search_for'] = "count";
		$show = "No Record To Display";
		$banner_list = $this->Testimonial_Model->get_testimonial($search);
		$count = 0;
		$countPos = 0;
		foreach ($podIdArr as $row) {
			$countPos++;
			$update_data['position'] = $countPos;//$podIdArr[$count];
			$condition = "(testimonial_id in ($podIdArr[$count]))";
			//$insertStatus = $this->Admin_Model->update($update_data,'category','' , $condition); //echo $insertStatus;
			$insertStatus = $this->Common_Model->update_operation(array('table' => 'testimonial', 'data' => $update_data, 'condition' => $condition));
			//echo $this->db->last_query().'<br><br><br><br><br>';
			$count++;
		}
		$this->GetCompletetestimonialList($testimonial_id, 1, 1);
	}
	function GetCompletetestimonialList($testimonial_id = '', $withPosition = '', $sortByPosition = '')
	{
		$search = array();
		if (!empty($_POST['testimonial_id'])) {
			$testimonial_id = $_POST['testimonial_id'];
		}
		if (!empty($_POST['withPosition'])) {
			$withPosition = $_POST['withPosition'];
		}
		if (!empty($_POST['sortByPosition'])) {
			$sortByPosition = $_POST['sortByPosition'];
		}
		$search['testimonial_id'] = $testimonial_id;
		$search['withPosition'] = $withPosition;
		$search['sortByPosition'] = $sortByPosition;
		$data['testimonial_list'] = $this->Testimonial_Model->get_testimonial($search);
		//print_r($data['testimonial_list']);
		$show = '';
		$count = 0;
		foreach ($data['testimonial_list'] as $row) {
			$row = (array) $row;
			$count++;
			$link = MAINSITE_Admin . "testimonial-Module/view/" . $row['testimonial_id'];
			$link1 = MAINSITE_Admin . "testimonial-Module/edit/" . $row['testimonial_id'];
			if ($row['updated_on'] != '0000-00-00 00:00:00') {
				$updated_on = date('d-m-Y', strtotime($row['updated_on']));
			} else {
				$updated_on = 'N/A';
			}
			if ($row['testimonial_name'] == '') {
				$row['testimonial_name'];
			}
			$show .= "<tr id='$row[testimonial_id]'>";
			$show .= "<td>$count</td>";
			$show .= "<td><label class='custom-control custom-checkbox'><input type='checkbox' class='custom-control-input' name='selectedRecords[]' id='selectedRecords$count' value='$row[testimonial_id]'><span class='custom-control-indicator'></span></label></td>";
			$show .= "<td>$row[testimonial_name]</td>";

			if ($withPosition == 1) {
				$show .= '<td><span style="cursor: move;" class="fa fa-arrows-alt" ></span> ' . $row['position'] . '</td>';
			}
			if ($row['status']) {
				$show .= "<td class='nodrag' align='center'><i class='fa fa-check true-icon'></i><span style='display:none'>Publish</span></td>";
			} else {
				$show .= "<td align='center'><i class='fa fa-close false-icon'></i><span style='display:none'>Un Publish</span></td>";
			}
			$show .= "<td>" . date('d-m-Y', strtotime($row['added_on'])) . "</td>";
			$show .= "<td>$updated_on</td>";
			$show .= "<td><a class='btn btn-primary' href='$link' style='padding:1px 5px;'><i class='fa fa-eye'></i></a>
	    <a class='btn btn-info' href='$link1' style='padding:1px 5px;'><i class='fa fa-edit'></i></a></td>";
			$show .= '</tr>';
		}
		echo $show;
	}
	function setPositions()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 44;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		$this->data['page_is_master'] = $this->data['user_access']->is_master;
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;
		$this->data['testimonial_data'] = $this->Testimonial_Model->get_testimonial();

		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/Testimonial_Module/positions', $this->data);
		parent::get_footer();
	}

	function upload_testimonial_file($testimonial_id)
	{

		$logo_file_name = "";
		if (isset($_FILES["testimonial_image"]['name'])) {

			$timg_name = $_FILES['testimonial_image']['name'];
			$temp_var = explode(".", strtolower($timg_name));
			$timage_ext = end($temp_var);
			$timage_name_new = 'testimonial_' . $testimonial_id . "." . $timage_ext;
			$img_data['testimonial_image'] = $timage_name_new;
			$f_path = "assets/testimonial/" . $timage_name_new;
			$imginsertStatus = $this->Common_Model->update_operation(array('table' => 'testimonial', 'data' => $img_data, 'condition' => "testimonial_id = $testimonial_id"));
			if ($imginsertStatus == 1) {


				if (!is_dir(_uploaded_temp_files_ . 'testimonial')) {
					mkdir(_uploaded_temp_files_ . './testimonial', 0777, TRUE);

				}
				$c = move_uploaded_file($_FILES['testimonial_image']['tmp_name'], _uploaded_temp_files_ . "/testimonial/" . $timage_name_new);

				$banner_file_name = $timage_name_new;
			}
		}

	}

	function usertestimonial_doUpdateStatus()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 44;
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
				$response = $this->Common_Model->update_operation(array('table' => "testimonial", 'data' => $update_data, 'condition' => "testimonial_id in ($ids)"));
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
}
