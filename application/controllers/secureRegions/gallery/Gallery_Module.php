<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/secureRegions/Main.php");
class Gallery_Module extends Main {

	function __construct()
	{
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->model('administrator/gallery/Gallery_Model');
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
		$this->load->view('admin/gallery/Gallery_Module/list' , $this->data);
		parent::get_footer();
	}

	function listing()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 10;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if(empty($this->data['user_access']))
		{
			REDIRECT(MAINSITE_Admin."wam/access-denied");
		}
		$search = array();
		$field_name = '';
		$field_value = '';
		$end_date = '';
		$start_date = '';
		$record_status="";
		$user_role_id="";
		$designation_id="";

		if(!empty($_REQUEST['field_name']))
			$field_name = $_POST['field_name'];
		else if(!empty($field_name))	
			$field_name = $field_name;
			
		if(!empty($_REQUEST['field_value']))
			$field_value = $_POST['field_value'];
		else if(!empty($field_value))	
			$field_value = $field_value;
			
		if(!empty($_POST['end_date']))
			$end_date = $_POST['end_date'];
		
		if(!empty($_POST['start_date']))
			$start_date = $_POST['start_date'];
			 
		if(!empty($_POST['record_status']))
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
		
		$data_count = $this->Gallery_Model->get_gallery($search);
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

		$search['limit'] = $per_page;
		$search['offset'] = $offset;
		$this->data['gallery_data'] = $this->Gallery_Model->get_gallery($search);
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/gallery/Gallery_Module/listing' , $this->data);
		parent::get_footer();
	}
	
	function doUpdateStatus()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 10;
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
				$response = $this->Common_Model->update_operation(array('table'=>"gallery" , 'data'=>$update_data , 'condition'=>"id in ($ids)" ));
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

	function view($id="")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 10;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if(empty($id))
		{
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. anubhav</div>';
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
		$this->data['gallery_data'] = $this->Gallery_Model->get_gallery(array("id"=>$id));
		if(empty($id))
		{
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. anubhav</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);
			exit;
		}

		$this->data['gallery_data'] = $this->data['gallery_data'][0];
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/gallery/Gallery_Module/view' , $this->data);
		parent::get_footer();
	}

	function edit($id="")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 10;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if(empty($this->data['user_access']))
		{
			REDIRECT(MAINSITE_Admin."wam/access-denied");
		}
		if(empty($id))
		{
			if($user_access->add_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Add ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}
		if(!empty($id))
		{
			if($user_access->update_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Update ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}

		$this->data['page_is_master'] = $this->data['user_access']->is_master;
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;
		if(!empty($id)){
			$this->data['gallery_data'] = $this->Gallery_Model->get_gallery(array("id"=>$id));
			if(empty($this->data['gallery_data']))
			{
				$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> Record Not Found. 
				  </div>');
				REDIRECT(MAINSITE_Admin.$user_access->class_name.'/'.$user_access->function_name);
			}
			$this->data['gallery_data'] = $this->data['gallery_data'][0];
		}
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/gallery/Gallery_Module/edit' , $this->data);
		parent::get_footer();
	}

	function doEdit()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 10;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		
		if(empty($_POST['name']))
		{
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. anubhav</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);
			exit;
		}
		$id = $_POST['id'];
		
		//print_r($_POST);
		if(empty($this->data['user_access']))
		{
			REDIRECT(MAINSITE_Admin."wam/access-denied");
		}
		if(empty($id))
		{
			if($user_access->add_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Add ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}
		if(!empty($id))
		{
			if($user_access->update_module!=1)
			{
				$this->session->set_flashdata('no_access_flash_message' , "You Are Not Allowed To Update ".$user_access->module_name);
				REDIRECT(MAINSITE_Admin."wam/access-denied");
			}
		}
		
		$name = trim($_POST['name']);
		$status = $_POST['status'];
		
		$enter_data['name'] = $_POST['name'];
		$enter_data['status'] = $_POST['status'];
		
		$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. </div>';
		if(!empty($id))
		{
			$enter_data['updated_on'] = date("Y-m-d H:i:s");
			$enter_data['updated_by'] = $this->data['session_uid'];
			$insertStatus = $this->Common_Model->update_operation(array('table'=>'gallery', 'data'=>$enter_data, 'condition'=>"id = $id"));
			if(!empty($insertStatus))
			{
				$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Record Updated Successfully </div>';
				$this->upload_gallery_image($id);
			}
			
		}
		else
		{
			$enter_data['added_on'] = date("Y-m-d H:i:s");
			$enter_data['added_by'] = $this->data['session_uid'];
			$id = $insertStatus = $this->Common_Model->add_operation(array('table'=>'gallery' , 'data'=>$enter_data));
			if(!empty($insertStatus))
			{
				$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> New Record Added Successfully </div>';
				$this->upload_gallery_image($id);
			}
			
			
		}
		$this->session->set_flashdata('alert_message', $alert_message);

		if(!empty($_POST['redirect_type']))
		{
			REDIRECT(MAINSITE_Admin.$user_access->class_name."/edit");
		}

		REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);
	}
	
	function upload_gallery_image($id)
	{
		$max_image_id=$this->Admin_model->getMaxid('id','gallery_image');
		$max_image_position=$this->Admin_model->getMaxPosition('position','gallery_image_position' , $id);
		$image_name = $_FILES['image']['name'];
		$end = explode(".",strtolower($image_name));
		$image_ext = end($end);
		$image_name_new = "gallery_".$id."_".$max_image_id.".".$image_ext; 
		$imagedata['position']=$max_image_position;
		$imagedata['image']=$image_name_new;
		$condition = "(id in ($id))";
			//$insertStatus = $this->Admin_model->update($update_data,'category','' , $condition); //echo $insertStatus;
		$insertStatus = $this->Common_Model->update_operation(array('table'=>'gallery', 'data'=>$imagedata, 'condition'=>$condition));
		if($insertStatus>=1)
		{
			$uploadedfile = $_FILES['image']['tmp_name'];
			$src = imagecreatefromstring(file_get_contents($uploadedfile));
			list($width,$height)=getimagesize($uploadedfile);
			//$newwidth=150;
			//$newheight=($height/$width)*$newwidth;
			//$tmp=imagecreatetruecolor($newwidth,$newheight);
			$newwidth1=400;
			$newheight1=($height/$width)*$newwidth1;
			$tmp1=imagecreatetruecolor($newwidth1,$newheight1);
			$newwidth2=1000;
			$newheight2=($height/$width)*$newwidth2;
			$tmp2=imagecreatetruecolor($newwidth2,$newheight2);
			//imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
			imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
			imagecopyresampled($tmp2,$src,0,0,0,0,$newwidth2,$newheight2,$width,$height);
			//$filename = _uploaded_temp_files_."product/small/". $image_name_new;
			$filename1 = _uploaded_temp_files_."gallery/medium/". $image_name_new;
			$filename2 = _uploaded_temp_files_."gallery/large/". $image_name_new;
//			imagejpeg($tmp,$filename,30);
			imagejpeg($tmp1,$filename1,35);	
			imagejpeg($tmp2,$filename2,40);	
			//move_uploaded_file ($_FILES['image']['tmp_name'][$i],"products/product/".$image_name_new);
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/*$gallery_file_name = "";
		if(isset($_FILES["image"]['name'])){
			$timg_name = $_FILES['image']['name'];
			if(!empty($timg_name)){
				$temp_var = explode(".",strtolower($timg_name));
				$timage_ext = end($temp_var);
				$timage_name_new = "gallery_".$id.".".$timage_ext; 
				$image_enter_data['image'] = $timage_name_new;
				$imginsertStatus = $this->Common_Model->update_operation(array('table'=>'gallery', 'data'=>$image_enter_data, 'condition'=>"id = $id"));
				if($imginsertStatus==1)
				{
					if (!is_dir(_uploaded_temp_files_.'gallery')) {
						mkdir(_uploaded_temp_files_.'./gallery', 0777, TRUE); 
				
					}
					move_uploaded_file ($_FILES['image']['tmp_name'],_uploaded_temp_files_."gallery/".$timage_name_new);
					$gallery_file_name = $timage_name_new;
				}
						
			} 
		} */
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

	function setPositions()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 10;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if(empty($this->data['user_access']))
		{
			REDIRECT(MAINSITE_Admin."wam/access-denied");
		}
		$this->data['page_is_master'] = $this->data['user_access']->is_master;
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;
		$this->data['gallery_data'] = $this->Gallery_Model->get_gallery();
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/gallery/Gallery_Module/positions' , $this->data);
		parent::get_footer();
	}

	function GetCompleteGalleryList($id='' , $withPosition='' , $sortByPosition='')	
	{
		$search = array();
		if(!empty($_POST['id'])){$id = $_POST['id'];}
		if(!empty($_POST['withPosition'])){$withPosition = $_POST['withPosition'];}
		if(!empty($_POST['sortByPosition'])){$sortByPosition = $_POST['sortByPosition'];}
		$search['id'] = $id;
		$search['withPosition'] = $withPosition;
		$search['sortByPosition'] = $sortByPosition;
		$data['gallery_list'] = $this->Gallery_Model->get_gallery($search);
		//print_r($data['gallery_list']);
		$show='';
		$count=0;
		foreach($data['gallery_list'] as $row)
		{
			$row = (array)$row;
			$count++;
			$link = MAINSITE_Admin."gallery/Gallery-Module/view/".$row['id'];
			$link1 = MAINSITE_Admin."gallery/Gallery-Module/edit/".$row['id'];
			if($row['updated_on'] !='0000-00-00 00:00:00'){$updated_on= date('d-m-Y', strtotime($row['updated_on']));}else{$updated_on='N/A';}
			if($row['name'] ==''){$row['name'];}
			$show.="<tr id='$row[id]'>";
			$show.="<td>$count</td>";
			$show.="<td><label class='custom-control custom-checkbox'><input type='checkbox' class='custom-control-input' name='selectedRecords[]' id='selectedRecords$count' value='$row[id]'><span class='custom-control-indicator'></span></label></td>";
			$show.="<td>$row[name]</td>";
			//$show.="<td>$row[title1]</td>";
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
			$show.='</tr>';
		}
		echo $show;
	}
	
	function GetCompleteGalleryListNewPos()
	{
		$search = array();
		$id = '';
		$podId = '';
		$podIdArr = '';
		if(!empty($_POST['id']))
			$id = $_POST['id'];
		if(!empty($_POST['podId']))
		{
			$podId = trim($_POST['podId'] , ',');
			$podIdArr = explode(',' , $podId);
		}
		$this->data['id'] = $id;
		$this->data['podId'] = $podIdArr;
		$search['id'] = $id;
		$search['podId'] = $podIdArr;
		$search['search_for'] = "count";
		$show = "No Record To Display";
		$gallery_list = $this->Gallery_Model->get_gallery($search);
		$count=0;
		$countPos=0;
		foreach($podIdArr as $row)
		{
			$countPos++;
			$update_data['position']=$countPos;//$podIdArr[$count];	
			$condition = "(id in ($podIdArr[$count]))";
			//$insertStatus = $this->Admin_Model->update($update_data,'category','' , $condition); //echo $insertStatus;
			$insertStatus = $this->Common_Model->update_operation(array('table'=>'gallery', 'data'=>$update_data, 'condition'=>$condition));
			//echo $this->db->last_query().'<br><br><br><br><br>';
			$count++;
		}
		$this->GetCompleteGalleryList($id , 1 , 1);
	}

}
