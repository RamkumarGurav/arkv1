<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/secureRegions/Main.php");
class Orders_Module extends Main
{
	function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->model('administrator/orders/Orders_Model');
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
		
		$this->load->helper('url');
		$this->load->library('upload');
		$this->load->helper('file');
		$this->load->library('Set_Order_Status_Lib');
		$this->_sosl = $this->data['_sosl'] = new Set_Order_Status_Lib();
		$this->data['backend_sess_id'] = 1;
		/*
		$login_satus = true;
		$this->load->library('User_auth');
		$session_uid = $this->data['session_uid']=$this->session->userdata('sess_psts_uid');
		$this->data['session_name']=$this->session->userdata('sess_psts_name');
		$this->data['session_email']=$this->session->userdata('sess_psts_email');
		$this->load->helper('url');
		$this->data['User_auth_obj'] = new User_auth();
		$this->data['user_data'] = $this->data['User_auth_obj']->check_user_status();
		$this->data['backend_sess_id'] = 1;
		*/
		/*
		
		
		
		$this->data['delivery_type_list'] = (object)array(
			(object)array('slno'=>1 , 'value'=>1 , 'label'=>'By Air' , 'blue_dart_product_code'=>'D' , 'blue_dart_sub_product_code'=>''),
			(object)array('slno'=>2 , 'value'=>2 , 'label'=>'By Road' , 'blue_dart_product_code'=>'E' , 'blue_dart_sub_product_code'=>'')
		);*/
	}
	
	function unset_only()
	{
		$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value)
		{
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity')
			{
				$this->session->unset_userdata($key);
			}
		}
	}
	
	function index()
	{
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/orders_list' , $this->data);
		parent::get_footer();
		
		
		/*$this->data['orders_list']=$this->Orders_Model->getOrders(array("stores_id"=>$this->data['backend_sess_id']));	
		//print_r($this->data['orders_list']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/orders_list' , $this->data);
		parent::get_footer();	*/
	} 
	
	function NewOrders()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 20;
		//$search['search_for'] = "count";
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
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
		
		$data_count = $this->Orders_Model->getOrders($search);
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
		
		//$this->data['orders_list']=$this->Orders_Model->getOrders(array("stores_id"=>$this->data['backend_sess_id'] , "order_status"=>1));
		$this->data['orders_list']=$this->Orders_Model->getOrders($search);
		
		
		//print_r($this->data['orders_list']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/new_orders' , $this->data);
		parent::get_footer();	
	}
	
	function details($orders_id='')
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 20;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if(empty($orders_id))
		{
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again.</div>';
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
		$this->data['order_data'] = $this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id, "stores_id"=>$this->data['backend_sess_id']));
		if(empty($orders_id))
		{
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. anubhav</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name);
			exit;
		}
		$this->data['order_data'] = $this->data['order_data'][0];
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/orders_details1' , $this->data);
		parent::get_footer();
		
		/*
		if(empty($orders_id))
		{ REDIRECT(MAINSITE.'SecureRegions/orders'); }
		else if(!is_numeric($orders_id))
		{ REDIRECT(MAINSITE.'SecureRegions/orders'); }
		
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 13;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/orders_details' , $this->data);
		parent::get_footer();	
		*/
	}
	
	function update()
	{
		if(isset($_POST['OrderStatusBTN']))
		{
			$orders_id = $_POST['orders_id'];
			$order_number = $_POST['order_number'];
			$order_status = $_POST['order_status'];
			$sosl_remarks = $reason = nl2br($_POST['reason']);
			$delivered_on='';

			$sosl_order_status_id = 1;
			$sosl_caption = '';
			$this->data['orders'] = $this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
			//print_r($this->data['orders']);
			$o = $this->data['orders'][0];
			if(empty($reason)){$reason=NULL;}
			if($order_status==1)
			{
				$sosl_order_status_id = 1;
				$sosl_caption = 'Order Placed';
				$subject_order_status = "Order Placed";
				$subject = "Your $subject_order_status Successfully. Order No.: $o->order_number "._brand_name_;
				$mail_message = "Your The "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> has been placed successfully.<br>We will update you the order processing action.";
				$template = "Dear $o->name, your order is confirmed. Your order id is $o->order_number. For more details login to your account "._brand_name_."";
			}
			if($order_status==2)
			{
				$sosl_order_status_id = 2;
				$sosl_caption = 'In Process';
				$subject_order_status = "In Process";
				$subject = "Your Order is in Processing State. Order No.: $o->order_number "._brand_name_."";
				$mail_message = "Your The "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> is in Processing State.<br>We will update you the order processing action.";
				$template = "Dear $o->name, your order is in process. Your order id is $o->order_number. For more details login to your account "._brand_name_."";
			}
			if($order_status==3)
			{
				$sosl_order_status_id = 3;
				$sosl_caption = 'has been shipped';
				$subject_order_status = "has been shipped";
				$subject = "Your Order $subject_order_status. Order No.: $o->order_number !"._brand_name_."";
				$mail_message = "Your The "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> has been shipped.<br>$reason";
				if(!empty($o->docket_no) && !empty($o->courier_name))
				{
					$mail_message .= "<br>Docket No. : ".$o->docket_no;
					$mail_message .= "<br>Shipped From : ".$o->courier_name;
				}
				//$mail_message .= "<br>Will update you the order processing action.";
				//$template = "Dear $o->name, your order is out for delivery. Your order id is $o->order_number. For more details login to your account thedentistshop.com";
				$template = "Dear $o->name, your order has been shipped. Your order id is $o->order_number. For more details login to your account "._brand_name_."";
				
				if(isset($_FILES["order_invoice"]['name']))
				{
					//echo "Test";
					$timg_name = $_FILES['order_invoice']['name'];
					if(!empty($timg_name))
					{
						//$deleteImgStatus = $this->admin_tbl->delete($image_id,'delete_prod_images'); //echo $insertStatus;
						$end = explode(".",strtolower($timg_name));
						$timage_ext = end($end);
						if($timage_ext=='pdf' || $timage_ext=='PDF')
						{
							$timage_name_new = time().'-'.$orders_id.".".$timage_ext; 
						
							$orderUpdateInvData['order_invoice'] = $timage_name_new;
							$imginsertStatus = $this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>$orderUpdateInvData , 'condition'=>"(orders_id=$orders_id)"));
							//echo $this->db->last_query();
							if($imginsertStatus)
							{
								$msg='success';	
								move_uploaded_file($_FILES['order_invoice']['tmp_name'],"assets/uploads/invoice/".$timage_name_new);	
							}
							else
							{
								$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong. Please try again.</div>');
								REDIRECT(MAINSITE.'SecureRegions/orders/details/'.$orders_id);
							}
						}
						else
						{
							$this->session->set_flashdata('message', '<div class=" alert alert-danger">Upload the invoice in pdf format.</div>');
							REDIRECT(MAINSITE.'SecureRegions/orders/details/'.$orders_id);
						}
					}
					else
					{
						$this->session->set_flashdata('message', '<div class=" alert alert-danger">Upload the invoice.</div>');
						REDIRECT(MAINSITE.'SecureRegions/orders/details/'.$orders_id);
					}
				}
				else
				{
					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Upload the invoice.</div>');
					REDIRECT(MAINSITE.'SecureRegions/orders/details/'.$orders_id);
				}
		
			}
			if($order_status==4)
			{
				$delivered_on = "<br>Delivered on <strong>".date("d M y")."</strong>";
				$sosl_order_status_id = 4;
				$sosl_caption = 'Delivered';
				$subject_order_status = "Delivered";
				$subject = "Your Order $subject_order_status Successfully. Order No.: $o->order_number !"._brand_name_."";
				$mail_message = "Your "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> has been Delivered successfully.<br>";
				$template = "Dear $o->name, your order is delivered successfully. Your order id is $o->order_number. For more details login to your account "._brand_name_."";
			}
			if($order_status==5)
			{
				$sosl_order_status_id = 5;
				$sosl_caption = 'Not Deliver';
				$subject_order_status = "Not Deliver";
				$subject = "Your Order $subject_order_status. Order No.: $o->order_number !"._brand_name_."";
				$mail_message = "Your "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> has not been Delivered.<br>$reason.";
				$template = "Dear $o->name, your order is not delivered. Your order id is $o->order_number. For more details login to your account "._brand_name_."";
			}
			if($order_status==6)
			{
				$sosl_order_status_id = 6;
				$sosl_caption = 'Cancel';
				$subject_order_status = "Cancel";
				$subject = "Your Order has been $subject_order_status. Order No.: $o->order_number !"._brand_name_."";
				$mail_message = "Your "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> has been Cancel.<br>$reason";
				$template = "Dear $o->name, your order is cancelled. Your order id is $o->order_number. For more details login to your account "._brand_name_."";
			}
				
			$orderUpdateData['updated_on'] = date("Y-m-d H:i:s");
			$orderUpdateData['reason'] = $reason;
			$orderUpdateData['order_status'] = $order_status;
			$orderUpdateData['order_status_id'] = $sosl_order_status_id;
			$UpdateStatus=$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>$orderUpdateData , 'condition'=>"(orders_id=$orders_id)"));
			if($UpdateStatus)
			{
				$this->session->set_flashdata('message', "<div class=' alert alert-success'>Order status successfully set to '$subject_order_status' for order No : $order_number.</div>");
				
				$add_new_order_history_params = array('orders_id'=>$orders_id , 'order_status_id'=>$sosl_order_status_id , 'caption'=>$sosl_caption , 'remarks'=>$sosl_remarks , 'updated_by'=>$this->session->userdata("sess_user_id"));
				$orders_history_id = $this->_sosl->add_new_order_history($add_new_order_history_params);
			
				//mail and sms code start
				
				$contact = $o->number;
				$this->Common_Model->send_sms($contact , $template);
				
				
				$shipping_address = $o->d_name.'<br>'.$o->d_number.'<br>'.$o->d_address.'<br>'.$o->d_city_name.' - '.$o->d_zipcode.'<br>'.$o->d_state_name.'<br>'.$o->d_country_name;
			$billing_address = $o->b_name.'<br>'.$o->b_number.'<br>'.$o->b_address.'<br>'.$o->b_city_name.' - '.$o->b_zipcode.'<br>'.$o->b_state_name.'<br>'.$o->b_country_name;
			$product_detail = "";
			foreach($o->details as $od)
			{
				$product_detail .="<tr>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$od->product_name ($od->combi)
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$od->prod_in_cart
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$o->symbol $od->final_price
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$o->symbol $od->sub_total
					</td>
				</tr>
				";
			}
				$mailMessage = file_get_contents(APPPATH.'mailer/orders.html');
				$mailMessage = str_replace("#name#",stripslashes($o->name),$mailMessage);
				$mailMessage = str_replace("#order_number#",stripslashes($o->order_number),$mailMessage);
				$mailMessage = str_replace("#mode#",stripslashes($o->mode),$mailMessage);
				$mailMessage = str_replace("#added_on#",stripslashes(date("d M y" , strtotime($o->added_on))),$mailMessage);
				$mailMessage = str_replace("#txnid#",stripslashes($o->txnid),$mailMessage);
				$mailMessage = str_replace("#shipping_address#",stripslashes($shipping_address),$mailMessage);
				$mailMessage = str_replace("#billing_address#",stripslashes($billing_address),$mailMessage);
				$mailMessage = str_replace("#order_status#",stripslashes($subject_order_status),$mailMessage);
				$mailMessage = str_replace("#mail_message#",stripslashes($mail_message),$mailMessage);
				$mailMessage = str_replace("#delivery_charges#",stripslashes($o->symbol.' '.$o->delivery_charges),$mailMessage);
				$mailMessage = str_replace("#delivered_on#",stripslashes($delivered_on),$mailMessage);
				$mailMessage = str_replace("#total#",stripslashes($o->symbol.' '.$o->total),$mailMessage);
				$mailMessage = str_replace("#product_detail#",$product_detail,$mailMessage);
				$mailMessage = str_replace("#total_gst#",stripslashes($o->symbol.' '.$o->total_gst),$mailMessage);
				//$mailMessage = str_replace("#mainsite#",IMAGE,$mailMessage);
				$mailMessage = str_replace("#mainsitepp#",IMAGE.__privacyPolicy__,$mailMessage);
				$mailMessage = str_replace("#mainsitecontact#",IMAGE.__contactUs__,$mailMessage);
				$mailMessage = str_replace("#mainsitefaq#",IMAGE.__faq__,$mailMessage);
				$mailMessage = str_replace("#mainsiteaccount#",IMAGE.__dashboard__,$mailMessage);
				
				$mailMessage = str_replace("#project_contact#",_project_contact_,$mailMessage);
				$mailMessage = str_replace("#project_contact_without_space#",_project_contact_without_space_,$mailMessage);
				$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
				$mailMessage = str_replace("#project_website#",_project_web_,$mailMessage);
				$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);
				$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
				$social_media = '';
				if(_FACEBOOK_!='')
					$social_media = $social_media.'<a href="'._FACEBOOK_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/facebook.png" width="25"></a>';
				if(_INSTAGRAM_!='')
					$social_media = $social_media.'<a href="'._INSTAGRAM_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/instagram.png" width="25"></a>';
				if(_PINTEREST_!='')
					$social_media = $social_media.'<a href="'._PINTEREST_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/pinterest.png" width="25"></a>';
				if(_TWITTER_!='')
					$social_media = $social_media.'<a href="'._TWITTER_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/twitter.png" width="25"></a>';
				if(_LINKEDIN_!='')
					$social_media = $social_media.'<a href="'._LINKEDIN_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/linkedin.png" width="25"></a>';
				if(_YOUTUBE_!='')
					$social_media = $social_media.'<a href="'._YOUTUBE_.'" target="_blank" ><img src="'.APPPATH.'mailer/images/email/youtube.png" width="25"></a>';
				$mailMessage = str_replace("#social_media#",$social_media,$mailMessage);
						
				if($o->cod_charges>0)
				{ 
					$cod_content = '<tr><td colspan="3" style="font-family:Arial, Helvetica, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;"><strong>	COD Charges </strong></td><td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;">'.$o->symbol.' '.$o->cod_charges.'</td></tr>';
					$mailMessage = str_replace("#cod_charges#",stripslashes($cod_content),$mailMessage); 
				}
				else
				{ $mailMessage = str_replace("#cod_charges#",stripslashes(''),$mailMessage); }
				
			//	$subject = "Your Order Placed Successfully. Order No.: $o->order_number !"._brand_name_."";
				$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$o->email , "name"=>$o->name ));
				//mail and sms code end
				
				
			}
			else
			{
				$this->session->set_flashdata('message', '<div class=" alert alert-danger">Failed to change the order status for order No : $order_number.</div>');
			}
			if(!empty($_SERVER["HTTP_REFERER"]))
			{
				REDIRECT($_SERVER["HTTP_REFERER"]);
			}
			//REDIRECT(MAINSITE.'SecureRegions/orders/');
		}
	}

	function inProcess()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 21;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		
		$this->data['orders_list']=$this->Orders_Model->getOrders(array("stores_id"=>$this->data['backend_sess_id'] , "order_status"=>2));	
		//print_r($this->data['orders_list']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/new_orders' , $this->data);
		parent::get_footer();	
	}

	function outForDelivery()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 22;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		
		$this->data['orders_list']=$this->Orders_Model->getOrders(array("stores_id"=>$this->data['backend_sess_id'] , "order_status"=>3));	
		//print_r($this->data['orders_list']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/new_orders' , $this->data);
		parent::get_footer();	
	}
	
	function delivered()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 23;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		
		$this->data['orders_list']=$this->Orders_Model->getOrders(array("stores_id"=>$this->data['backend_sess_id'] , "order_status"=>4));	
		//print_r($this->data['orders_list']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/new_orders' , $this->data);
		parent::get_footer();	
	}
	
	function notDeliver()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 24;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		
		$this->data['orders_list']=$this->Orders_Model->getOrders(array("stores_id"=>$this->data['backend_sess_id'] , "order_status"=>5));	
		//print_r($this->data['orders_list']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/new_orders' , $this->data);
		parent::get_footer();	
	}
	
	function cancle()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 25;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		
		$this->data['orders_list']=$this->Orders_Model->getOrders(array("stores_id"=>$this->data['backend_sess_id'] , "order_status"=>6));	
		//print_r($this->data['orders_list']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/new_orders' , $this->data);
		parent::get_footer();	
	}
	
	
	function ShippingServiceApi()
	{
		$orders_id = $_POST['orders_id'];
		//$orders_id = 15;
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/shipyaari_shipping_service_api' , $this->data);
	}
	
	function getPincodeDetail()
	{
		$orders_id = $_POST['orders_id'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/getPincodeDetail' , $this->data);
	}
	
	function getPincodeDetailDTDC()
	{
		$orders_id = $_POST['orders_id'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/getPincodeDetailDTDC' , $this->data);
	}
	
	function generateDocketNo()
	{
		$orders_id = $_POST['orders_id'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/generateDocketNo' , $this->data);
	}
	
	function generateDocketNoDelhivery()
	{
		$orders_id = $_POST['orders_id'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/generateDocketNoDelhivery' , $this->data);
	}
	
	function generateDocketNoDTDC()
	{
		$orders_id = $_POST['orders_id'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/generateDocketNoDTDC' , $this->data);
	}
	
	function getPincodeDetailBluedart()
	{
		$orders_id = $_POST['orders_id'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/getPincodeDetailBluedart' , $this->data);
	}
	
	function generateBluedartDocketNo()
	{
		$orders_id = $_POST['orders_id'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/generateBluedartDocketNo' , $this->data);
	}
	
	function generateDocketNoDHL()
	{
		$orders_id = $_POST['orders_id'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/generateDocketNoDHL' , $this->data);
	}
	
	
	function trackOrder($orders_id='')
	{
		if(empty($orders_id))
		{ REDIRECT(MAINSITE.'SecureRegions/orders'); }
		else if(!is_numeric($orders_id))
		{ REDIRECT(MAINSITE.'SecureRegions/orders'); }
		
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/orders_details' , $this->data);
		parent::get_footer();	
	}
	
	function addNewBox()
	{
		$this->data['orders_id'] = $orders_id = $_POST['orders_id'];
		$this->data['box_no'] = $box_no = $_POST['box_no'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		
		$this->load->view('admin/orders/addNewBox' , $this->data);
	}
	
	public function orderInvoice($orders_id='')
	{
		///$this->data['orders'] = $this->Dashboard_model->getOrder(array('customers_id'=>$this->data['temp_id'] , 'orders_id'=>$orders_id));
		if(empty($orders_id)){show_404();}
			$this->data['orders']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , 'for_invoice'=>1 , "stores_id"=>$this->data['backend_sess_id']));
		if(empty($this->data['orders'])){show_404();}
		$this->data['css'] = array();
		$this->data['js'] = array();
		$this->data['php'] = array('add-script/my-account-menu-for-mobile');
		$this->load->view('invoice/invoice' , $this->data);
	}
	
	public function orderInvoiceBulk()
	{
		///$this->data['orders'] = $this->Dashboard_model->getOrder(array('customers_id'=>$this->data['temp_id'] , 'orders_id'=>$orders_id));
		if(!empty($_POST['selectedRecords']))
		$selectedRecords = implode(',' , $_POST['selectedRecords']);
		if(empty($selectedRecords)){show_404();}
			$this->data['orders']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$selectedRecords , 'for_invoice'=>1 , "stores_id"=>$this->data['backend_sess_id']));
		if(empty($this->data['orders'])){show_404();}
		$this->data['css'] = array();
		$this->data['js'] = array();
		$this->data['php'] = array('add-script/my-account-menu-for-mobile');
		$this->load->view('invoice/invoice' , $this->data);
	}
	
	
	
	function stuckOrderDetails($temp_orders_id='')
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 26;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		$this->data['orders_list']=$this->Orders_Model->getTempOrders(array("stores_id"=>$this->data['backend_sess_id']));	
		if(empty($temp_orders_id))
		{ REDIRECT(MAINSITE.'SecureRegions/stuckOrders'); }
		else if(!is_numeric($temp_orders_id))
		{ REDIRECT(MAINSITE.'SecureRegions/stuckOrders'); }
		$this->data['orders_detail']=$this->Orders_Model->getTempOrdersDetails(array("temp_orders_id"=>$temp_orders_id ));
	//	print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/orders/stuck_orders_details' , $this->data);
		parent::get_footer();	
	}
	
	function stuckOrders()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 26;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		$this->data['orders_list']=$this->Orders_Model->getTempOrders(array("stores_id"=>$this->data['backend_sess_id']));	
		//print_r($this->data['orders_list']);

		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	

		parent::get_header();

		parent::get_left_nav();

		$this->load->view('admin/orders/stuck-orders' , $this->data);

		parent::get_footer();	

	}
	
	function stuckToSuccess()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 26;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id"=>$this->data['page_module_id']));
		$this->data['orders_list']=$this->Orders_Model->getTempOrders(array("stores_id"=>$this->data['backend_sess_id']));	
		if($_SERVER['REQUEST_METHOD']==='POST') 
		{  // REQUIRE POST OR DIE
			$temp_orders_id = $_POST['temp_orders_id'];
			$TxnreferenceNo = $_POST['TxnreferenceNo'];
			$BankReferenceNo = $_POST['BankReferenceNo'];
			$temp_orders_id = $_POST['temp_orders_id'];
			
			$this->data['tempOrdersData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"(temp_orders_id=$temp_orders_id and status=0)"));
			if(empty($this->data['tempOrdersData']))
			{
				$this->session->set_flashdata('message', "<div class=' alert alert-danger'><strong>Error! </strong> Order not found.</div>");
				REDIRECT(MAINSITE.'SecureRegions/'.$user_access->class_name.'/'.$user_access->function_name);
			}
			$od_arr = $this->data['tempOrdersData'][0];
			$page_data = array();
			//$this->data['orders_detail']=$this->Orders_Model->getTempOrdersDetails(array("temp_orders_id"=>$temp_orders_id,  "status"=>0 ));
			
			$update_temp_orders_data['status']=1;
			$update_temp_orders_data['stuck_status ']=1;
			$this->Common_Model->update_operation(array('table'=>'temp_orders' , 'data'=>$update_temp_orders_data , 'condition'=>"(temp_orders_id=$temp_orders_id)"));
			$tempOrdersData = $this->data['tempOrdersData'][0];
			foreach($tempOrdersData as $key => $value)
			{
				$orderData[$key]=$value;
			}
			
			$orderData['order_number'] = '';
			$orderData['order_status'] = 1;
			$orderData['status'] = 1;
			
		
			unset($orderData['tracking_id']);
			unset($orderData['bank_ref_no']);
			unset($orderData['failure_message']);
			unset($orderData['payment_mode']);
			unset($orderData['card_name']);
			unset($orderData['status_code']);
			unset($orderData['status_message']);
			unset($orderData['productinfo']);
			unset($orderData['salt']);
			unset($orderData['udf1']);
			unset($orderData['udf2']);
			unset($orderData['stuck_status']);
			unset($orderData['stock_status']);
			
			$orders_id = $this->Common_Model->add_operation(array('table'=>'orders' , 'data'=>$orderData));
			if($orders_id>0)
			{
				$this->data['tempOrdersDetailsData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders_details" , 'where'=>"temp_orders_id=$temp_orders_id"));
				foreach($this->data['tempOrdersDetailsData'] as $tpdd)
				{
					foreach($tpdd as $key => $value)
					{
						$orderDetailsData[$key]=$value;
					}
					unset($orderDetailsData['temp_orders_id']);
					unset($orderDetailsData['temp_orders_details_id']);
					$orderDetailsData['orders_id']=$orders_id;
					$orders_details_id = $this->Common_Model->add_operation(array('table'=>'orders_details' , 'data'=>$orderDetailsData));
				}
				
				$this->data['order_number'] = "#GS/".date('Y').'/'.date('m').'/'.date('d').'/'.$orders_id;
				$page_data['order_number'] = $this->data['order_number'];
				$page_data['date'] = date('M d Y');
				$page_data['txnid'] = $TxnreferenceNo;
			}
			
			$update_orders_data['status']=1;
			$update_orders_data['mode']=$tempOrdersData->payment_mode;
			$update_orders_data['mihpayid']=$BankReferenceNo;
			$update_orders_data['firstname']='';
			$update_orders_data['amount']=$tempOrdersData->total;
			$update_orders_data['txnid']=$TxnreferenceNo;
			$update_orders_data['posted_hash']='';
			$update_orders_data['key']='';
			$update_orders_data['productinfo']='';
			$update_orders_data['email']=$tempOrdersData->email;
			$update_orders_data['salt']='';
			$update_orders_data['udf1'] = '';
			$update_orders_data['udf2'] = '';
			$update_orders_data['cardnum'] = '';
			$update_orders_data['name_on_card'] = '';
			$temp_orders_id = $tempOrdersData->temp_orders_id;
			$update_orders_data['customers_id'] = $tempOrdersData->customers_id;
			$update_orders_data['stores_id']=$tempOrdersData->stores_id;
			
			unset($update_orders_data['productinfo']);
			unset($update_orders_data['salt']);
			unset($update_orders_data['udf1']);
			unset($update_orders_data['udf2']);
			unset($update_orders_data['tracking_id']);
			
			
			$update_orders_data['order_status_id']=1;
			$update_orders_data['order_number']=$this->data['order_number'];
			$update_orders_data['status']=1;
			$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>$update_orders_data , 'condition'=>"(orders_id=$orders_id)"));
			
			$add_new_order_history_params = array('orders_id'=>$orders_id , 'order_status_id'=>1 , 'caption'=>'Order Placed' , 'updated_by'=>$this->session->userdata("sess_user_id"));
			$orders_history_id = $this->_sosl->add_new_order_history($add_new_order_history_params);
			
			$this->data['page_data'] = $page_data;
			
			//mail and sms code start
			$this->data['orders'] = $this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "customers_id"=>$tempOrdersData->customers_id));
			//print_r($this->data['orders']);
			$o=$this->data['orders'] = $this->data['orders'][0];
			//email sms code start
			$contact = $o->number;
			$template = "Dear $o->name, your order is confirmed. Your order id is $o->order_number. For more details login to your account "._brand_name_;
			//echo $template;
			$this->Common_Model->send_sms($contact , $template);
			
			
			$mail_message = "Your "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> has been placed successfully.<br>We will update you the order processing action.";
			$shipping_address = $o->d_name.'<br>'.$o->d_number.'<br>'.$o->d_address.'<br>'.$o->d_city_name.' - '.$o->d_zipcode.'<br>'.$o->d_state_name.'<br>'.$o->d_country_name;
			$billing_address = $o->b_name.'<br>'.$o->b_number.'<br>'.$o->b_address.'<br>'.$o->b_city_name.' - '.$o->b_zipcode.'<br>'.$o->b_state_name.'<br>'.$o->b_country_name;
			$product_detail = "";
			foreach($o->details as $od)
			{
				$product_detail .="<tr>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$od->product_name ($od->combi)
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$od->prod_in_cart
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$o->symbol $od->final_price
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$o->symbol $od->sub_total
					</td>
				</tr>
				";
			}
			$mailMessage = file_get_contents(APPPATH.'mailer/orders.html');
			$mailMessage = str_replace("#name#",stripslashes($o->name),$mailMessage);
			$mailMessage = str_replace("#order_number#",stripslashes($o->order_number),$mailMessage);
			$mailMessage = str_replace("#mode#",stripslashes($o->mode),$mailMessage);
			$mailMessage = str_replace("#added_on#",stripslashes(date("d M y" , strtotime($o->added_on))),$mailMessage);
			$mailMessage = str_replace("#txnid#",stripslashes($o->txnid),$mailMessage);
			$mailMessage = str_replace("#shipping_address#",stripslashes($shipping_address),$mailMessage);
			$mailMessage = str_replace("#billing_address#",stripslashes($billing_address),$mailMessage);
			$mailMessage = str_replace("#order_status#",stripslashes("Order Placed"),$mailMessage);
			$mailMessage = str_replace("#mail_message#",stripslashes($mail_message),$mailMessage);
			$mailMessage = str_replace("#delivery_charges#",stripslashes($o->symbol.' '.$o->delivery_charges),$mailMessage);
			$mailMessage = str_replace("#delivered_on#",stripslashes(''),$mailMessage);
			$mailMessage = str_replace("#total#",stripslashes($o->symbol.' '.$o->total),$mailMessage);
			$mailMessage = str_replace("#product_detail#",$product_detail,$mailMessage);
			$mailMessage = str_replace("#total_gst#",stripslashes($o->symbol.' '.$o->total_gst),$mailMessage);
			$mailMessage = str_replace("#ship_data#",'',$mailMessage);
			$mailMessage = str_replace("#total_packing_charges#",'',$mailMessage);
			$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
			$mailMessage = str_replace("#social_media#","",$mailMessage);
			
			$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
			//$mailMessage = str_replace("#mainsitepp#",base_url().__privacyPolicy__,$mailMessage);
			$mailMessage = str_replace("#mainsitecontact#",base_url().__contactUs__,$mailMessage);
			//$mailMessage = str_replace("#mainsitefaq#",base_url().__faq__,$mailMessage);
			$mailMessage = str_replace("#mainsiteaccount#",base_url().__dashboard__,$mailMessage);
			if($o->cod_charges>0)
			{ 
				$cod_content = '<tr><td colspan="3" style="font-family:Arial, Helvetica, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;"><strong>	COD Charges </strong></td><td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;">'.$o->symbol.' '.$o->cod_charges.'</td></tr>';
				$mailMessage = str_replace("#cod_charges#",stripslashes($cod_content),$mailMessage); 
			}
			else
			{ $mailMessage = str_replace("#cod_charges#",stripslashes(''),$mailMessage); }
			$subject = "Your Order Placed Successfully. Order No.: $o->order_number "._brand_name_;
			$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$o->email , "name"=>$o->name ));
				$this->session->set_flashdata('message', "<div class=' alert alert-success'><strong>Success! </strong> Order status successfully set to Success for order No : ".$o->order_number.".</div>");
				REDIRECT(MAINSITE.'SecureRegions/'.$user_access->class_name.'/'.$user_access->function_name);
		
		}
	}
	
	function assign_courier_order_packing_api()
	{
		$orders_id = $_POST['orders_id'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/assign_courier_order_packing_api' , $this->data);
	}
	
	function assign_courier_order_pickup_api()
	{
		$orders_id = $_POST['orders_id'];
		$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);	
		$this->load->view('admin/orders/assign_courier_order_pickup_api' , $this->data);
	}
	
	public function printPackingSlip($orders_id='')
	{
		///$this->data['orders'] = $this->Dashboard_model->getOrder(array('customers_id'=>$this->data['temp_id'] , 'orders_id'=>$orders_id));
		if(empty($orders_id)){show_404();}
			$this->data['orders']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , 'for_invoice'=>1 , 'for_packing_slip'=>1 , "stores_id"=>$this->data['backend_sess_id']));
		if(empty($this->data['orders'])){show_404();}
		
		$this->data['css'] = array();
		$this->data['js'] = array();
		$this->load->view('admin/orders/printPackingSlip' , $this->data);
	}
	
	
	
	
}


/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */