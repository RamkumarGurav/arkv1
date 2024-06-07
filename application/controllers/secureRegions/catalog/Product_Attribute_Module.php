<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/secureRegions/Main.php");
class Product_Attribute_Module extends Main {

	function __construct()
	{
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->model('administrator/catalog/Product_Attribute_Model');
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
		
		$this->data['page_module_id'] = 15;
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
		$this->load->view('admin/catalog/Product_Attribute_Module/list' , $this->data);
		parent::get_footer();
	}

	function listing()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 15;
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
		
		$data_count = $this->Product_Attribute_Model->get_product_attribute($search);
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
		$this->data['product_attribute_data'] = $this->Product_Attribute_Model->get_product_attribute($search);
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/catalog/Product_Attribute_Module/listing' , $this->data);
		parent::get_footer();
	}

	function view($product_attribute_id="")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 15;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if(empty($product_attribute_id))
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
		$this->data['product_attribute_detail'] = $this->Product_Attribute_Model->get_product_attribute(array("product_attribute_id"=>$product_attribute_id , "details"=>1));
		if(empty($product_attribute_id))
		{
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. </div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);
			exit;
		}

		$this->data['product_attribute_detail'] = $this->data['product_attribute_detail'][0];
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/catalog/Product_Attribute_Module/view' , $this->data);
		parent::get_footer();
	}


	function category_list_export()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 15;
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
		
		
		$this->load->view('admin/catalog/Product_Attribute_Module/microchip_list_export' , $this->data);
	}

	function category_list_pdf()
	{
		$this->load->library('pdf');

		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 15;
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
		
		
		//$this->load->view('admin/catalog/Product_Attribute_Module/microchip_list_export' , $this->data);
		$date = date('Y-m-d H:i:s');
		//echo "$customer_name : $customer_name <br>";
		$html = $this->load->view('admin/catalog/Product_Attribute_Module/microchip_list_pdf' , $this->data, true);
		//echo $html;
		//$html = $this->load->view('admin/catalog/reports/Project_Reports_Module/project_reports_list_pdf' , $this->data, true);
		$this->pdf->createPDF($html, $date, false);
		
	}

	function edit($product_attribute_id="")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 15;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if(empty($this->data['user_access']))
		{
			REDIRECT(MAINSITE_Admin."wam/access-denied");
		}
		if(empty($product_attribute_id))
		{
			if($user_access->add_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Add ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}
		if(!empty($product_attribute_id))
		{
			if($user_access->update_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Update ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}

		//$this->data['product_attribute_data'] = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'product_attribute' , 'where'=>"product_attribute_id > 0" , "order_by"=>"name ASC"));

		$this->data['page_is_master'] = $this->data['user_access']->is_master;
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;
		if(!empty($product_attribute_id)){
			$this->data['product_attribute_data'] = $this->Product_Attribute_Model->get_product_attribute(array("product_attribute_id"=>$product_attribute_id , "details"=>1));
			if(empty($this->data['product_attribute_data']))
			{
				$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> Record Not Found. 
				  </div>');
				REDIRECT(MAINSITE_Admin.$user_access->class_name.'/'.$user_access->function_name);
			}
			$this->data['product_attribute_data'] = $this->data['product_attribute_data'][0];
		}
		//$this->data['product_attribute_list'] = $this->Product_Attribute_Model->get_product_attribute();
		$this->data['attributes_input_list']=$this->Product_Attribute_Model->get_attribute_input_list();
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/catalog/Product_Attribute_Module/edit' , $this->data);
		parent::get_footer();
	}

	function doEdit()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 15;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		
		if(empty($_POST['name']) && empty($_POST['condition_per_product']) )
		{
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. anubhav</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);
			exit;
		}
		
		//print_r($_POST);
		$product_attribute_id = '';
		$product_attribute_id = $_POST['product_attribute_id'];
		
		
		if(empty($this->data['user_access']))
		{
			REDIRECT(MAINSITE_Admin."wam/access-denied");
		}
		if(empty($product_attribute_id))
		{
			if($user_access->add_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Add ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}
		if(!empty($product_attribute_id))
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
				
				$entereddata['product_attribute_id'] = $_POST['product_attribute_id'];
				$entereddata['attributes_input_id'] = $_POST['attributes_input_id'];				
				$entereddata['name'] = $_POST['name'];
				$entereddata['condition_per_product'] = $_POST['condition_per_product'];
				$entereddata['status'] = $_POST['status'];
				$entereddata['search'] = $_POST['search'];				
				$entereddata['list_page'] = $_POST['list_page'];
				$entereddata['details_page'] = $_POST['details_page'];

				$product_attribute_id=$_POST['product_attribute_id'];	
				$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. </div>';
				if(!empty($product_attribute_id)){
					$entereddata['updated_by'] = $this->data['session_uid'];		
					$entereddata['updated_on']=date('Y-m-d H:i:s');
					$condition="(product_attribute_id = '$product_attribute_id')";
					//$insertStatus = $this->Common_Model->update_operation($entereddata,'product_attribute',$product_attribute_id , $condition);
					$insertStatus = $this->Common_Model->update_operation(array('table'=>'product_attribute', 'data'=>$entereddata, 'condition'=>"product_attribute_id = $product_attribute_id"));
					if(!empty($insertStatus))
					{
						$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Record Updated Successfully </div>';
					}
					
				}else
				{
					//$max_category_position=$this->Common_Model->getMaxPosition('position','category_position' , $entereddata['super_category_id']);
					//$entereddata['position']=$max_category_position;
					$entereddata['added_by'] = $this->data['session_uid'];	
					$entereddata['added_on']=date('Y-m-d H:i:s');
					$product_attribute_id = $insertStatus = $this->Common_Model->add_operation(array('table'=>'product_attribute' , 'data'=>$entereddata));
					if(!empty($insertStatus))
					{
						$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> New Record Added Successfully </div>';
					}
					
				}
				
				if ($_POST['redirect_type']=='save-add-new') {REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name."/edit".$msg);}
//				                                       REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name."/attribute-edit".$msg);
				//$this->load->view('admin/catalog/Product_Attribute_Module/edit' , $this->data);
				
				$this->session->set_flashdata('alert_message', $alert_message);

		if(!empty($_POST['redirect_type']))
		{
			REDIRECT(MAINSITE_Admin.$user_access->class_name."/edit");
		}

		REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);
		
		
		
		
		
	}
	
	function doUpdateStatus()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 15;
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
				$response = $this->Common_Model->update_operation(array('table'=>"product_attribute" , 'data'=>$update_data , 'condition'=>"product_attribute_id in ($ids)" ));
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

	
	function logout()
	{
		$this->unset_only();
		$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="icon fas fa-check"></i> You Are Successfully Logout.
		</div>');
		$this->session->unset_userdata('sess_psts_uid');	
		REDIRECT(MAINSITE_Admin.'login');
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
	
	
	function GetCompleteAttributeValueListNewPos()
	{
		$search = array();
		$product_attribute_id = '';
		$podId = '';
		$podIdArr = '';
		

		if(!empty($_POST['product_attribute_id']))
			$product_attribute_id = $_POST['product_attribute_id'];
		
		if(!empty($_POST['podId']))
		{
			$podId = trim($_POST['podId'] , ',');
			$podIdArr = explode(',' , $podId);
		}
		
		$this->data['product_attribute_id'] = $product_attribute_id;
		$this->data['podId'] = $podIdArr;
		
		$search['product_attribute_id'] = $product_attribute_id;
		$search['podId'] = $podIdArr;
		$search['search_for'] = "count";
		
		$show = "No Record To Display";
		
		//$product_attribute_data = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'product_attribute_value' , 'where'=>"product_attribute_id  = $product_attribute_id"));
		$product_attribute_data = $this->Product_Attribute_Model->get_product_attribute($search);
		$count=0;
		$countPos=0;
		foreach($podIdArr as $row)
		{
			$countPos++;
			$update_data['position']=$countPos;//$podIdArr[$count];	
			$condition = "(product_attribute_value_id in ($row))";
			$insertStatus = $this->Common_Model->update_operation(array('table'=>'product_attribute_value' , 'data'=>$update_data , 'condition'=>$condition));
			$count++;
		}
		$this->GetCompleteAttributeValueList();
	}

	
	function GetCompleteAttributeValueList()
	{
			$product_attribute_id = 0;
			if(!empty($_POST['product_attribute_id'])){$product_attribute_id = $_POST['product_attribute_id'];}
//			$attribute_value_list=$this->Admin_Model->getListSearch('all_attribute_value_list',$product_attribute_id, '','', '','', '','', '');	
			//$attribute_value_list = $this->Product_Attribute_Model->get_product_attribute(array("product_attribute_id"=>$product_attribute_id , "details"=>1));
			$attribute_value_list = $this->Product_Attribute_Model->get_product_attribute_value(array("product_attribute_id"=>$product_attribute_id));
			$count=0;
			$query = $this->db->last_query(); 
			//echo "query : $query </br>";
			$show="";
			if(count($attribute_value_list) != 0){ 
				foreach($attribute_value_list as $row){
					$count++;
					$updated_on="";
					$link = MAINSITE_Admin."catalog/Product-Attribute-Module/attribute-edit/".$row->product_attribute_value_id;
					$color_val = '';
					if(!empty($row->color_name)){$color_val = '&nbsp;&nbsp;&nbsp;<span style="background-color:'.$row->color_name.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';}
				//if($row['updated_on'] !='0000-00-00 00:00:00'){$updated_on= date('d-m-Y', strtotime($row['updated_on']));}								
				$updated_on= date('d-m-Y', strtotime($row->updated_on));
					if($updated_on == '01-01-1970'){$updated_on='-';}
                    $show.="<tr id='$row->product_attribute_value_id'>";
					$show.="<td>$count</td>";//$count
					$show.="<td><label class='custom-control custom-checkbox'><input type='checkbox' class='custom-control-input' name='selectedRecords[]' id='selectedRecords$count' value='$row->product_attribute_value_id'><span class='custom-control-indicator'></span></label></td>";
					$show.="<td>$row->name $color_val</td>";
					$show.="<td>$row->attribute_name</td>";
					$show.='<td><span style="cursor: move;" class="fa fa-arrows-alt" aria-hidden="true"></span> '.$row->position.'</td>';
					if($row->status){$show.="<td align='center'><i class='fa fa-check true-icon'></i><span style='display:none'>Publish</span></td>";}
					else{$show.="<td align='center'><i class='fa fa-close false-icon'></i><span style='display:none'>Un Publish</span></td>";}
					$show.="<td>".date('d-m-Y', strtotime($row->added_on))."</td>";
					$show.="<td>$updated_on</td>";
					$show.="<td><a class='btn btn-primary btn-flat' href='$link' style='padding:1px 5px;'><i class='fa fa-pencil'></i></a></td>";
					$show."</tr>";
				}	
			}
			echo $show;
		
	}
	
	//END

	function attribute_listing()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 16;
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
		
		$data_count = $this->Product_Attribute_Model->get_product_attribute_value($search);
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
		$this->data['product_attribute_value_data'] = $this->Product_Attribute_Model->get_product_attribute_value($search);
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/catalog/Product_Attribute_Module/attribute_listing' , $this->data);
		parent::get_footer();
	}

	function attribute_view($product_attribute_value_id="")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 16;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if(empty($product_attribute_value_id))
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
		$this->data['product_attribute_value_detail'] = $this->Product_Attribute_Model->get_product_attribute_value(array("product_attribute_value_id"=>$product_attribute_value_id , "details"=>1));
		if(empty($product_attribute_value_id))
		{
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. </div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);
			exit;
		}

		$this->data['product_attribute_value_detail'] = $this->data['product_attribute_value_detail'][0];
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/catalog/Product_Attribute_Module/attribute-view' , $this->data);
		parent::get_footer();
	}
	

	function attribute_edit($product_attribute_value_id="")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 16;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if(empty($this->data['user_access']))
		{
			REDIRECT(MAINSITE_Admin."wam/access-denied");
		}
		if(empty($product_attribute_value_id))
		{
			if($user_access->add_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Add ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}
		if(!empty($product_attribute_value_id))
		{
			if($user_access->update_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Update ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}

		//$this->data['product_attribute_data'] = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'product_attribute' , 'where'=>"product_attribute_id > 0" , "order_by"=>"name ASC"));

		$this->data['page_is_master'] = $this->data['user_access']->is_master;
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;
		if(!empty($product_attribute_value_id)){
			$this->data['product_attribute_value_data'] = $this->Product_Attribute_Model->get_product_attribute_value(array("product_attribute_value_id"=>$product_attribute_value_id , "details"=>1));
			if(empty($this->data['product_attribute_value_data']))
			{
				$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> Record Not Found. 
				  </div>');
				REDIRECT(MAINSITE_Admin.$user_access->class_name.'/'.$user_access->function_name);
			}
			$this->data['product_attribute_value_data'] = $this->data['product_attribute_value_data'][0];
		}
		//$this->data['product_attribute_list'] = $this->Product_Attribute_Model->get_product_attribute();
		$this->data['product_attribute_list'] = $this->Product_Attribute_Model->get_product_attribute_active();
		//$this->data['attributes_input_list']=$this->Product_Attribute_Model->get_attribute_input_list();
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/catalog/Product_Attribute_Module/attribute_edit' , $this->data);
		parent::get_footer();
	}

	function doAtrributeEdit()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 16;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		
		if(empty($_POST['name']) && empty($_POST['product_attribute_id']) )
		{
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again.</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);
			exit;
		}
		
		//print_r($_POST); exit;
		$product_attribute_value_id = '';
		$product_attribute_value_id = $_POST['product_attribute_value_id'];
		
		
		if(empty($this->data['user_access']))
		{
			REDIRECT(MAINSITE_Admin."wam/access-denied");
		}
		if(empty($product_attribute_value_id))
		{
			if($user_access->add_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Add ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}
		if(!empty($product_attribute_value_id))
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
				
				$entereddata['product_attribute_value_id'] = $_POST['product_attribute_value_id'];
				$entereddata['product_attribute_id'] = $_POST['product_attribute_id'];				
				$entereddata['name'] = $_POST['name'];
				$entereddata['status'] = $_POST['status'];
				
				$product_attribute_value_id = $_POST['product_attribute_value_id'];

				$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. </div>';
				if(!empty($product_attribute_value_id)){
					$entereddata['updated_by'] = $this->data['session_uid'];		
					$entereddata['updated_on']=date('Y-m-d H:i:s');
					$condition="(product_attribute_value_id = '$product_attribute_value_id')";
					//$insertStatus = $this->Common_Model->update_operation($entereddata,'product_attribute',$product_attribute_id , $condition);
					$insertStatus = $this->Common_Model->update_operation(array('table'=>'product_attribute_value', 'data'=>$entereddata, 'condition'=>"product_attribute_value_id = $product_attribute_value_id"));
					if(!empty($insertStatus))
					{
						$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Record Updated Successfully </div>';
					}
					
				}else
				{
					$max_category_position=$this->Common_Model->getMaxPosition('position','attribute_position' , $entereddata['product_attribute_id']);
					$entereddata['position']=$max_category_position;
					$entereddata['added_by'] = $this->data['session_uid'];	
					$entereddata['added_on']=date('Y-m-d H:i:s');
					$product_attribute_id = $insertStatus = $this->Common_Model->add_operation(array('table'=>'product_attribute_value' , 'data'=>$entereddata));
					if(!empty($insertStatus))
					{
						$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> New Record Added Successfully </div>';
					}
					
				}
				
				//if ($_POST['action']=='save-add-new') {REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name."/attribute-edit".$msg);}
				
				$this->session->set_flashdata('alert_message', $alert_message);

		if(!empty($_POST['redirect_type']))
		{
			REDIRECT(MAINSITE_Admin.$user_access->class_name."/attribute-edit");
		}

		REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);
		
		
		
		
		
	}
}
