<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."controllers/secureRegions/Main.php");

class Category_Module extends Main {



	function __construct()

	{

        parent::__construct();

		$this->load->database();

		$this->load->library('session');

		$this->load->model('Common_Model');

		$this->load->model('administrator/Admin_Common_Model');

		$this->load->model('administrator/Admin_model');

		$this->load->model('administrator/catalog/Category_Model');

		$this->load->library('pagination');

		

		$this->load->library('User_auth');

		

		$session_uid = $this->data['session_uid']=$this->session->userdata('sess_psts_uid');

		$this->data['session_name']=$this->session->userdata('sess_psts_name');

		$this->data['session_email']=$this->session->userdata('sess_psts_email');



		$this->load->helper('url');

		

		$this->data['User_auth_obj'] = new User_auth();

		$this->data['user_data'] = $this->data['User_auth_obj']->check_user_status();



		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

		$this->output->set_header("Pragma: no-cache");  

		

		$this->data['page_module_id'] = 9;

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



	function index()

	{

		parent::get_header();

		parent::get_left_nav();

		$this->load->view('admin/catalog/Category_Module/list' , $this->data);

		parent::get_footer();

	}



	function listing()

	{

		$this->data['page_type'] = "list";

		$this->data['page_module_id'] = 9;

		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));

		//print_r($this->data['user_access']);

		if(empty($this->data['user_access']))

		{

			REDIRECT(MAINSITE_Admin."wam/access-denied");

		}

		$search = array();

		$end_date = '';

		$start_date = '';

		$record_status="";

		$customer_profile_id="";

		$microchip_mode="";

		$admin_user_id="";



		if(!empty($_POST['end_date']))

			$end_date = $_POST['end_date'];

		

		if(!empty($_POST['start_date']))

			$start_date = $_POST['start_date'];

			 

		if(!empty($_POST['record_status']))

			$record_status = $_POST['record_status'];



		if(!empty($_POST['customer_profile_id']))

			$customer_profile_id = $_POST['customer_profile_id'];



		if(!empty($_POST['microchip_mode']))

			$microchip_mode = $_POST['microchip_mode'];



		if(!empty($_POST['admin_user_id']))

			$admin_user_id = $_POST['admin_user_id'];

				 

		$this->data['end_date'] = $end_date;

		$this->data['start_date'] = $start_date;

		$this->data['record_status'] = $record_status;

		$this->data['customer_profile_id'] = $customer_profile_id;

		$this->data['microchip_mode'] = $microchip_mode;

		$this->data['admin_user_id'] = $admin_user_id;

		

		$search['end_date'] = $end_date;

		$search['start_date'] = $start_date;

		$search['record_status'] = $record_status;

		$search['customer_profile_id'] = $customer_profile_id;

		$search['microchip_mode'] = $microchip_mode;

		$search['admin_user_id'] = $admin_user_id;

		$search['search_for'] = "count";

		

		$data_count = $this->Category_Model->get_category($search);

		$r_count = $this->data['row_count'] = $data_count[0]->counts;



		unset($search['search_for']);

		

		$offset = (int)$this->uri->segment(5); //echo $offset;

		if($offset == "")

		{

			$offset ='0' ;

		} 

		$per_page = _all_pagination_;

		

		$this->load->library('pagination');

		//$config['base_url'] =MAINSITE.'secure_region/reports/DispatchedOrders/'.$module_id.'/';

		$this->load->library('pagination');

		$config['base_url'] =MAINSITE_Admin.$this->data['user_access']->class_name.'/'.$this->data['user_access']->function_name.'/';

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



		$search['details'] = 1;

		$search['limit'] = $per_page;

		$search['offset'] = $offset;

		$this->data['employee_data'] = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'admin_user' , 'where'=>"admin_user_id > 0" , "order_by"=>"name ASC"));

		$this->data['category_data'] = $this->Category_Model->get_category($search);

		

		parent::get_header();

		parent::get_left_nav();

		$this->load->view('admin/catalog/Category_Module/listing' , $this->data);

		parent::get_footer();

	}



	function view($category_id="")

	{

		$this->data['page_type'] = "list";

		$this->data['page_module_id'] = 9;

		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));

		//print_r($this->data['user_access']);

		if(empty($category_id))

		{

			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. </div>';

			$this->session->set_flashdata('alert_message', $alert_message);

			REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);

			exit;

		}

		if(empty($this->data['user_access']))

		{

			REDIRECT(MAINSITE_Admin."wam/access-denied");

		}

		$this->data['page_is_master'] = $this->data['user_access']->is_master;

		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;

		$this->data['category_detail'] = $this->Category_Model->get_category(array("category_id"=>$category_id , "details"=>1));

		if(empty($category_id))

		{

			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. </div>';

			$this->session->set_flashdata('alert_message', $alert_message);

			REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);

			exit;

		}



		$this->data['category_detail'] = $this->data['category_detail'][0];

		

		parent::get_header();

		parent::get_left_nav();

		$this->load->view('admin/catalog/Category_Module/category_details' , $this->data);

		parent::get_footer();

	}



	function list_export()

	{

		$this->data['page_type'] = "list";

		$this->data['page_module_id'] = 9;

		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));

		//print_r($this->data['user_access']);

		if(empty($this->data['user_access']))

		{

			REDIRECT(MAINSITE_Admin."wam/access-denied");

		}



		if($this->data['user_access']->export_data!=1)

		{

			$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Export ".$user_access->module_name);

			REDIRECT(MAINSITE_Admin."wam/access-denied");

		}

		$search = array();

		$end_date = '';

		$start_date = '';

		$record_status="";

		$customer_profile_id="";

		$microchip_mode="";

		$admin_user_id="";



		if(!empty($_POST['end_date']))

			$end_date = $_POST['end_date'];

		

			if(!empty($_POST['start_date']))

			$start_date = $_POST['start_date'];

			 

			if(!empty($_POST['record_status']))

			$record_status = $_POST['record_status'];

				 

		if(!empty($_POST['customer_profile_id']))

			$customer_profile_id = $_POST['customer_profile_id'];

				 

		if(!empty($_POST['microchip_mode']))

			$microchip_mode = $_POST['microchip_mode'];

				 

		if(!empty($_POST['admin_user_id']))

			$admin_user_id = $_POST['admin_user_id'];



		$this->data['end_date'] = $end_date;

		$this->data['start_date'] = $start_date;

		$this->data['record_status'] = $record_status;

		$this->data['customer_profile_id'] = $customer_profile_id;

		$this->data['microchip_mode'] = $microchip_mode;

		$this->data['admin_user_id'] = $admin_user_id;

		

		$search['end_date'] = $end_date;

		$search['start_date'] = $start_date;

		$search['record_status'] = $record_status;

		$search['customer_profile_id'] = $customer_profile_id;

		$search['microchip_mode'] = $microchip_mode;

		$search['admin_user_id'] = $admin_user_id;

		$search['details'] = 1;

		

		$this->data['microchip_data'] = $this->Category_Model->get_microchip($search);

		

		

		$this->load->view('admin/catalog/Category_Module/microchip_list_export' , $this->data);

	}



	function pdf()

	{

		$this->load->library('pdf');



		$this->data['page_type'] = "list";

		$this->data['page_module_id'] = 9;

		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));

		//print_r($this->data['user_access']);

		if(empty($this->data['user_access']))

		{

			REDIRECT(MAINSITE_Admin."wam/access-denied");

		}



		if($this->data['user_access']->export_data!=1)

		{

			$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Export ".$user_access->module_name);

			REDIRECT(MAINSITE_Admin."wam/access-denied");

		}

		$search = array();

		$end_date = '';

		$start_date = '';

		$record_status="";

		$customer_profile_id="";

		$microchip_mode="";

		$admin_user_id="";



		if(!empty($_POST['end_date']))

			$end_date = $_POST['end_date'];

		

			if(!empty($_POST['start_date']))

			$start_date = $_POST['start_date'];

			 

			if(!empty($_POST['record_status']))

			$record_status = $_POST['record_status'];

				 

		if(!empty($_POST['customer_profile_id']))

			$customer_profile_id = $_POST['customer_profile_id'];

				 

		if(!empty($_POST['microchip_mode']))

			$microchip_mode = $_POST['microchip_mode'];

				 

		if(!empty($_POST['admin_user_id']))

			$admin_user_id = $_POST['admin_user_id'];



		$this->data['end_date'] = $end_date;

		$this->data['start_date'] = $start_date;

		$this->data['record_status'] = $record_status;

		$this->data['customer_profile_id'] = $customer_profile_id;

		$this->data['microchip_mode'] = $microchip_mode;

		$this->data['admin_user_id'] = $admin_user_id;

		

		$search['end_date'] = $end_date;

		$search['start_date'] = $start_date;

		$search['record_status'] = $record_status;

		$search['customer_profile_id'] = $customer_profile_id;

		$search['microchip_mode'] = $microchip_mode;

		$search['admin_user_id'] = $admin_user_id;

		$search['details'] = 1;

		

		$this->data['microchip_data'] = $this->Category_Model->get_microchip($search);

		

		

		//$this->load->view('admin/catalog/Category_Module/microchip_list_export' , $this->data);

		$date = date('Y-m-d H:i:s');

		//echo "$customer_name : $customer_name <br>";

		$html = $this->load->view('admin/catalog/Category_Module/microchip_list_pdf' , $this->data, true);

		//echo $html;

		//$html = $this->load->view('admin/catalog/reports/Project_Reports_Module/project_reports_list_pdf' , $this->data, true);

		$this->pdf->createPDF($html, $date, false);

		

	}



	function edit($category_id="")

	{

		//echo "category_id : $category_id <br>"; exit;

		$this->data['page_type'] = "list";

		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));

		//print_r($this->data['user_access']);

		if(empty($this->data['user_access']))

		{

			REDIRECT(MAINSITE_Admin."wam/access-denied");

		}

		if(empty($category_id))

		{

			if($user_access->add_module!=1)

			{

				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Add ".$user_access->module_name);

				REDIRECT(MAINSITE_Admin."wam/access-denied");

			}

		}

		if(!empty($category_id))

		{

			if($user_access->update_module!=1)

			{

				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Update ".$user_access->module_name);

				REDIRECT(MAINSITE_Admin."wam/access-denied");

			}

		}



		$this->data['employee_data'] = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'admin_user' , 'where'=>"admin_user_id > 0" , "order_by"=>"name ASC"));



		$this->data['page_is_master'] = $this->data['user_access']->is_master;

		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;

		if(!empty($category_id))

		{

			$this->data['category_data'] = $this->Category_Model->get_category(array("category_id"=>$category_id , "details"=>1));

			if(empty($this->data['category_data']))

			{

				$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">

					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

					<i class="icon fas fa-ban"></i> Record Not Found. 

				  </div>');

				REDIRECT(MAINSITE_Admin.$user_access->class_name.'/'.$user_access->function_name);

			}

			$this->data['category_data'] = $this->data['category_data'][0];

		}

		$this->data['category_list'] = $this->Category_Model->get_category();
		
		

		parent::get_header();

		parent::get_left_nav();

		$this->load->view('admin/catalog/Category_Module/category_edit' , $this->data);

		parent::get_footer();

	}



	function doEdit()

	{

		$this->data['page_type'] = "list";

		$this->data['page_module_id'] = 9;

		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));

		

		if(empty($_POST['name']) && empty($_POST['slug_url']) && empty($_POST['meta_title']) && empty($_POST['meta_description']) && empty($_POST['meta_keyword']) )

		{

			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. anubhav</div>';

			$this->session->set_flashdata('alert_message', $alert_message);

			REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);

			exit;

		}

		

		//print_r($_POST);

		$category_id = '';

		$category_id = $_POST['category_id'];

		

		

		if(empty($this->data['user_access']))

		{

			REDIRECT(MAINSITE_Admin."wam/access-denied");

		}

		if(empty($category_id))
		{
			if($user_access->add_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Add ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}

		if(!empty($category_id))
		{
			if($user_access->update_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Update ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}

		/*$order_date = $_POST['order_date'];

		$mc_chip_no = $_POST['mc_chip_no'];

		$order_no = $_POST['order_no'];

		$status = $_POST['status'];

		

		

		$enter_data['order_date'] = date("Y-m-d" , strtotime($_POST['order_date']));

		$enter_data['mc_chip_no'] = $_POST['mc_chip_no'];

		$enter_data['order_no'] = $_POST['order_no'];

		$enter_data['status'] = $_POST['status'];*/ 

		

		$msg = 'fail';

				

				$entereddata['category_id'] = $_POST['category_id'];

				$entereddata['name'] = $_POST['name'];
				if(!empty($_POST['super_category_id']))
				{
					$entereddata['super_category_id'] = $_POST['super_category_id'];
				}
				else
				{
					$entereddata['super_category_id'] = 0;
				}

				$entereddata['status'] = $_POST['status'];

				$entereddata['category_id'] = $_POST['category_id'];

				

				$entereddata['meta_keyword'] = $_POST['meta_keyword'];

				$entereddata['meta_description'] = $_POST['meta_description'];

				$entereddata['meta_title'] = $_POST['meta_title'];

				$entereddata['slug_url'] = $_POST['slug_url'];

				$entereddata['header_1_url'] = $_POST['header_1_url'];

				$entereddata['footer_1_url'] = $_POST['footer_1_url'];

				$entereddata['is_display_home_page'] = $_POST['is_display_home_page'];

				$entereddata['is_outer_menu'] = $_POST['is_outer_menu'];

				$entereddata['description'] = $_POST['description'];

				$entereddata['short_description'] = $_POST['short_description'];



				$category_id=$_POST['category_id'];	

				$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. </div>';

				if(!empty($category_id)){

					$entereddata['updated_by'] = $this->data['session_uid'];		

					$entereddata['updated_on']=date('Y-m-d H:i:s');

					$condition="(category_id = '$category_id')";

					//$insertStatus = $this->Common_Model->update_operation($entereddata,'category',$category_id , $condition);
					$insertStatus = $this->Common_Model->update_operation(array('condition'=>$condition, "table"=>"category", "data"=>$entereddata));

					if(!empty($insertStatus))

					{

						$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Record Updated Successfully </div>';

					}

					

				}else

				{

					$max_category_position=$this->Common_Model->getMaxPosition('position','category_position' , $entereddata['super_category_id']);

					$entereddata['position']=$max_category_position;

					$entereddata['added_by'] = $this->data['session_uid'];	

					$entereddata['added_on']=date('Y-m-d H:i:s');

					$category_id = $insertStatus = $this->Common_Model->add_operation(array('table'=>'category' , 'data'=>$entereddata));

					if(!empty($insertStatus))

					{

						$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> New Record Added Successfully </div>';

					}

					

				}

				

				if($insertStatus >= 1 )
				{
					$condition="(category_id = '$category_id')";
					if(!empty($_FILES["category_icon"]['name']))
					{
						$image_name = $_FILES['category_icon']['name'];
						$end = explode(".",strtolower($image_name));
						$image_ext = end($end);
						$image_name_new = "icon"."_".$category_id.".".$image_ext; 
						$image_name_new_update['category_icon']=$image_name_new;
						//$insertStatus = $this->Admin_Model->update($image_name_new_update,'category',$category_id , $condition); 
						$insertStatus = $this->Common_Model->update_operation(array('table'=>'category', 'data'=>$image_name_new_update, 'condition'=>"category_id = $category_id"));
						//move_uploaded_file ($_FILES['category_icon']['tmp_name'],"assets/category/".$image_name_new);
						$uploadedfile = $_FILES['category_icon']['tmp_name'];
						if ($image_ext == 'jpeg' || $image_ext == 'jpg') 
						{
							$src = imagecreatefromjpeg($uploadedfile);
						}
						elseif ($image_ext == 'gif') 
						{
							$src = imagecreatefromgif($uploadedfile);
						}
						elseif ($image_ext == 'png') 
						{
							$src = imagecreatefrompng($uploadedfile);
						}
						//$src = imagecreatefromjpeg($uploadedfile);
						list($width,$height)=getimagesize($uploadedfile);
						$newwidth=225;
						$newheight=($height/$width)*$newwidth;
						$tmp=imagecreatetruecolor($newwidth,$newheight);
						imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
						$filename = _uploaded_temp_files_."category/". $image_name_new;
						imagejpeg($tmp,$filename,95);
					}
					unset($image_name_new_update);

					if(!empty($_FILES["cover_image"]['name']))
					{
						$image_name = $_FILES['cover_image']['name'];
						$end = explode(".",strtolower($image_name));
						$image_ext = end($end);
						$image_name_new = "cover"."_".$category_id.".".$image_ext; 
						$image_name_new_update['cover_image']=$image_name_new;
					//	$insertStatus = $this->Admin_Model->update($image_name_new_update,'category',$category_id , $condition); 
						$insertStatus = $this->Common_Model->update_operation(array('table'=>'category', 'data'=>$image_name_new_update, 'condition'=>"category_id = $category_id"));
						//move_uploaded_file ($_FILES['cover_image']['tmp_name'],"assets/category/".$image_name_new);
						$uploadedfile = $_FILES['cover_image']['tmp_name'];
						if ($image_ext == 'jpeg' || $image_ext == 'jpg') 
						{
							$src = imagecreatefromjpeg($uploadedfile);
						}
						elseif ($image_ext == 'gif') 
						{
							$src = imagecreatefromgif($uploadedfile);
						}
						elseif ($image_ext == 'png') 
						{
							$src = imagecreatefrompng($uploadedfile);
						}
						//$src = imagecreatefromjpeg($uploadedfile);
						list($width,$height)=getimagesize($uploadedfile);
						$newwidth=400;
						$newheight=($height/$width)*$newwidth;
						$tmp=imagecreatetruecolor($newwidth,$newheight);
						imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
						$filename = _uploaded_temp_files_."category/". $image_name_new;
						imagejpeg($tmp,$filename,95);
					}

					if(!empty($_FILES["header_1_img"]['name']))
					{
						$image_name = $_FILES['header_1_img']['name'];
						$end = explode(".",strtolower($image_name));
						$image_ext = end($end);
						$image_name_new = "header_1_img"."_".$category_id.".".$image_ext; 
						$image_name_new_update['header_1_img']=$image_name_new;
						//$insertStatus = $this->Admin_Model->update($image_name_new_update,'category',$category_id , $condition); 
						$insertStatus = $this->Common_Model->update_operation(array('table'=>'category', 'data'=>$image_name_new_update, 'condition'=>"category_id = $category_id"));
						move_uploaded_file ($_FILES['header_1_img']['tmp_name'],_uploaded_temp_files_."category/".$image_name_new);

					}

					if(!empty($_FILES["footer_1_img"]['name']))
					{
						$image_name = $_FILES['footer_1_img']['name'];
						$end = explode(".",strtolower($image_name));
						$image_ext = end($end);
						$image_name_new = "footer_1_img"."_".$category_id.".".$image_ext; 
						$image_name_new_update['footer_1_img']=$image_name_new;
						//$insertStatus = $this->Admin_Model->update($image_name_new_update,'category',$category_id , $condition); 
						$insertStatus = $this->Common_Model->update_operation(array('table'=>'category', 'data'=>$image_name_new_update, 'condition'=>"category_id = $category_id"));
						move_uploaded_file ($_FILES['footer_1_img']['tmp_name'],_uploaded_temp_files_."category/".$image_name_new);

					}
				}

				

				$this->session->set_flashdata('alert_message', $alert_message);

//				if ($_POST['action']=='save-add-new') {REDIRECT(ADMIN."categories/add/0/".$msg);}

				

				



		if(!empty($_POST['redirect_type']))

		{

			REDIRECT(MAINSITE_Admin.$user_access->class_name."/edit");

		}



		REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);

		

		

		

		

		

	}

	

	function doUpdateStatus()

	{

		$this->data['page_type'] = "list";

		$this->data['page_module_id'] = 9;

		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));

		//print_r($this->data['user_access']);

		$task = $_POST['task'];

		$id_arr = $_POST['sel_recds'];

		if(empty($user_access))

		{

			REDIRECT(MAINSITE_Admin."wam/access-denied");

		}

		if($user_access->update_module==1)

		{

			$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">

					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

					<i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. 

				  </div>');

			$update_data = array();

			if(!empty($id_arr))

			{

				$action_taken = "";

				$ids = implode(',' , $id_arr);

				if($task=="active")

				{

					$update_data['status'] = 1;

					$action_taken = "Activate";

				}

				if($task=="block")

				{

					$update_data['status'] = 0;

					$action_taken = "Blocked";

				}

				$update_data['updated_on'] = date("Y-m-d H:i:s");

				$update_data['updated_by'] = $this->data['session_uid'];

				$response = $this->Common_Model->update_operation(array('table'=>"category" , 'data'=>$update_data , 'condition'=>"category_id in ($ids)" ));

				if($response){

					$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<i class="icon fas fa-check"></i> Records Successfully '.$action_taken.' 

						</div>');

				}

			}

			REDIRECT(MAINSITE_Admin.$user_access->class_name.'/'.$user_access->function_name);

		}

		else

		{

			$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Update ".$user_access->module_name);

			REDIRECT(MAINSITE_Admin."wam/access-denied");

		}

	}

	

	function GetCompleteCategoryListNewPos()

	{

		$search = array();

		$super_category_id = '';

		$podId = '';

		$podIdArr = '';

		



		if(!empty($_POST['super_category_id']))

			$super_category_id = $_POST['super_category_id'];

		

		if(!empty($_POST['podId']))

		{

			$podId = trim($_POST['podId'] , ',');

			$podIdArr = explode(',' , $podId);

		}

		

		$this->data['super_category_id'] = $super_category_id;

		$this->data['podId'] = $podIdArr;

		

		$search['super_category_id'] = $super_category_id;

		$search['podId'] = $podIdArr;

		$search['search_for'] = "count";

		

		$show = "No Record To Display";

		//$super_category_id='';

		/*$super_category_id = $_POST['super_category_id'];

		$podId = trim($_POST['podId'] , ',');

		$podIdArr = explode(',' , $podId);*/

		//$category_list=$this->Category_Model->get_category('category_list','', '',$super_category_id, '','', '','', '');

		

		

		$category_list = $this->Category_Model->get_category($search);

		$count=0;

		$countPos=0;

		foreach($podIdArr as $row)

		{

			$countPos++;

			$update_data['position']=$countPos;//$podIdArr[$count];	

			$condition = "(category_id in ($podIdArr[$count]))";

			//$insertStatus = $this->Admin_Model->update($update_data,'category','' , $condition); //echo $insertStatus;

			$insertStatus = $this->Common_Model->update_operation(array('table'=>'category', 'data'=>$update_data, 'condition'=>$condition));

			//echo $this->db->last_query().'<br><br><br><br><br>';

			$count++;

		}

		$this->GetCompleteCategoryList($super_category_id , 1 , 1);

	}

	

	function GetCompleteCategoryList($super_category_id='' , $withPosition='' , $sortByPosition='')	
	{

		$search = array();

		if(!empty($_POST['super_category_id'])){$super_category_id = $_POST['super_category_id'];}

		if(!empty($_POST['withPosition'])){$withPosition = $_POST['withPosition'];}

		if(!empty($_POST['sortByPosition'])){$sortByPosition = $_POST['sortByPosition'];}

		$search['super_category_id'] = $super_category_id;

		$search['withPosition'] = $withPosition;

		$search['sortByPosition'] = $sortByPosition;

		$data['category_list'] = $this->Category_Model->get_category($search);

		//$data['category_list']=$this->Category_Model->get_category('category_list','', '',$super_category_id, '','', '','', $sortByPosition);

		//print_r($data['category_list']);

		$show='';

		$count=0;

		foreach($data['category_list'] as $row)

		{

			$row = (array)$row;

			$count++;

			$link = MAINSITE_Admin."catalog/Category-Module/view/".$row['category_id'];

			$link1 = MAINSITE_Admin."catalog/Category-Module/edit/".$row['category_id'];

			if($row['updated_on'] !='0000-00-00 00:00:00'){$updated_on= date('d-m-Y', strtotime($row['updated_on']));}else{$updated_on='N/A';}

			if($row['super_category_name'] ==''){$row['super_category_name']= 'Parent';}

			$show.="<tr id='$row[category_id]'>";

			$show.="<td>$count</td>";

			$show.="<td><label class='custom-control custom-checkbox'><input type='checkbox' class='custom-control-input' name='selectedRecords[]' id='selectedRecords$count' value='$row[category_id]'><span class='custom-control-indicator'></span></label></td>";

			$show.="<td>$row[name]</td>";

			$show.="<td>$row[super_category_name]</td>";

			if($withPosition==1)

			{

				$show.='<td><span style="cursor: move;" class="fa fa-arrows-alt" ></span> '.$row['position'].'</td>';

			}

			if($row['status']){$show.="<td class='nodrag' align='center'><i class='fa fa-check true-icon'></i><span style='display:none'>Publish</span></td>";}

					else{$show.="<td align='center'><i class='fa fa-close false-icon'></i><span style='display:none'>Un Publish</span></td>";}

			$show.="<td>".date('d-m-Y', strtotime($row['added_on']))."</td>";

			$show.="<td>$updated_on</td>";

			$show.="<td><a class='btn btn-primary' href='$link' style='padding:1px 5px;'><i class='fa fa-eye'></i></a>

			<a class='btn btn-info' href='$link1' style='padding:1px 5px;'><i class='fa fa-edit'></i></a></td>";

			

			

			//$show.='<td class="text-right"><a class="btn btn-default" href="'.IMAGE.'assets/product/large/'.$row['product_image_name'].'" target="_blank"><i class="fa fa-eye"></i>View This Image</a></td>';

			$show.='</tr>';

		}

		echo $show;

	}

	function deleteImagesForCategory()
	{
		$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					 Error While Processing. Please Try Again.
					</div>');
		$column = $_POST["column"];
		$id = $_POST["id"];
		if(empty($column) || empty($id))
		{
			echo 0;
		}
		else
		{
			$row_data = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'category' , 'where'=>"category_id  = $id"));
			if(!empty($row_data))
			{
				$row_data = $row_data[0];
				@unlink(_uploaded_temp_files_."category/".$row_data->{$column});
				$update_data[$column]='';
				$condition = "(category_id=$id)";
				$this->Common_Model->update_operation(array('table'=>"category" , 'data'=>$update_data , 'condition'=>$condition ));
				$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					 Image Delete Successfully.
					</div>');
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}


	

	//END

	

	

}

