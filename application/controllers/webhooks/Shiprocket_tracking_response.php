<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Shiprocket_tracking_response extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->library('session');
		$this->session->set_userdata('sess_psts_uid', 1);
		$this->session->set_userdata('sess_psts_name', "Webhook");
		$this->session->set_userdata('sess_psts_email', "Webhook");
		$this->session->set_userdata('sess_company_profile_id', 1);
		
		
						
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->model('administrator/orders/Orders_Model');
		$this->load->library('pagination');
		$session_uid = $this->data['session_uid']=$this->session->userdata('sess_psts_uid');
		$this->data['session_name']=$this->session->userdata('sess_psts_name');
		$this->data['session_email']=$this->session->userdata('sess_psts_email');

		$this->load->helper('url');
		
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
	
	function tracking_response()
	{
		echo "<pre>";
		if(!empty($_SERVER['HTTP_X_API_KEY']))
		{
			if($_SERVER['HTTP_X_API_KEY'] == "1234567890123456")
			{
				$shiprocket_status = array('1'=>'AWB Assigned',
				'2'=>'Label Generated',
				'3'=>'Pickup Scheduled/Generated',
				'4'=>'Pickup Queued',
				'5'=>'Manifest Generated',
				'6'=>'Shipped',
				'7'=>'Delivered',
				'8'=>'Cancelled',
				'9'=>'RTO Initiated',
				'10'=>'RTO Delivered',
				'11'=>'Pending',
				'12'=>'Lost',
				'13'=>'Pickup Error',
				'14'=>'RTO Acknowledged',
				'15'=>'Pickup Rescheduled',
				'16'=>'Cancellation Requested',
				'17'=>'Out For Delivery',
				'18'=>'In Transit',
				'19'=>'Out For Pickup',
				'20'=>'Pickup Exception',
				'21'=>'Undelivered',
				'22'=>'Delayed',
				'23'=>'Partial_Delivered',
				'24'=>'Destroyed',
				'25'=>'Damaged',
				'26'=>'Fulfilled',
				'38'=>'Reached at Destination',
				'39'=>'Misrouted',
				'40'=>'RTO NDR',
				'41'=>'RTO OFD',
				'42'=>'Picked Up',
				'43'=>'Self Fulfilled',
				'44'=>'DISPOSED_OFF',
				'45'=>'CANCELLED_BEFORE_DISPATCHED',
				'46'=>'RTO_IN_TRANSIT',
				'47'=>'QC Failed',
				'48'=>'Reached Warehouse',
				'49'=>'Custom Cleared',
				'50'=>'In Flight',
				'51'=>'Handover to Courier',
				'52'=>'Shipment Booked',
				'54'=>'In Transit Overseas',
				'55'=>'Connection Aligned',
				'56'=>'Reached Overseas Warehouse',
				'57'=>'Custom Cleared Overseas',
				'59'=>'Box Packing'
				);
				$json = file_get_contents('php://input');
				//echo $json;
				if(!empty($json))
				{
					$json_data = json_decode($json, true);
					$awb = $json_data['awb'];
					$current_status_id = $json_data['current_status_id'];
					if(!empty($shiprocket_status[$current_status_id]))
					{

						$_SERVER["HTTP_REFERER"]='';
						//echo "<br>".$awb;
						//echo "<br>".$current_status_id;
						//$imginsertStatus = $this->Common_Model->get(array('table'=>'orders' , 'data'=>$orderUpdateInvData , 'condition'=>"(orders_id=$orders_id)"));
						$order_data = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'orders' , 'where'=>"(orders_id >0 and docket_no='$awb')" ));
						//print_r($order_data);
		
						$delivered_array = array(7);
						$in_transit_array = array(6, 17, 18, 19, 42);
						if(!empty($order_data))
						{
							$od = $order_data[0];
							#delivered
							if(in_array($current_status_id, $delivered_array))
							{
								if(in_array($od->order_status_id, array(1,2,3)))
								{
									$_POST['OrderStatusBTN'] = 1;
									$orders_id = $_POST['orders_id'] = $od->orders_id;
									$order_number = $_POST['order_number'] = $od->order_number;
									$order_status = $_POST['order_status'] = 4;
									$sosl_remarks = $reason = $_POST['reason'] = '';
									$this->update();
								}
							}
							#in transit
							else if(in_array($current_status_id, $in_transit_array))
							{
								if(in_array($od->order_status_id, array(1, 2)))
								{
									$_POST['OrderStatusBTN'] = 1;
									$orders_id = $_POST['orders_id'] = $od->orders_id;
									$order_number = $_POST['order_number'] = $od->order_number;
									$order_status = $_POST['order_status'] = 3;
									$sosl_remarks = $reason = $_POST['reason'] = '';
									$this->update();
								}
							}
						}
						
					}
				}
				log_message('error', $json);
			}
		}
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
								//REDIRECT(MAINSITE.'secureRegions/orders/details/'.$orders_id);
							}
						}
						else
						{
							$this->session->set_flashdata('message', '<div class=" alert alert-danger">Upload the invoice in pdf format.</div>');
							//REDIRECT(MAINSITE.'secureRegions/orders/details/'.$orders_id);
						}
					}
					else
					{
						$this->session->set_flashdata('message', '<div class=" alert alert-danger">Upload the invoice.</div>');
						//REDIRECT(MAINSITE.'secureRegions/orders/details/'.$orders_id);
					}
				}
				else
				{
					$this->session->set_flashdata('message', '<div class=" alert alert-danger">Upload the invoice.</div>');
					//REDIRECT(MAINSITE.'secureRegions/orders/details/'.$orders_id);
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
				
				$add_new_order_history_params = array('orders_id'=>$orders_id , 'order_status_id'=>$sosl_order_status_id , 'caption'=>$sosl_caption , 'remarks'=>$sosl_remarks , 'updated_by'=>$this->session->userdata("sess_psts_uid"));
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
		}
	}
	

}


/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */