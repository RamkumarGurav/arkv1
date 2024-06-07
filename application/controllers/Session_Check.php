<?
class Session_Check extends CI_Controller {
  public function __construct()
  {
    //session_start();
	//$this->load->database();
	parent::__construct();
	$this->load->library('session');
	//$this->load->model('Common_Model');
    print_r($_SESSION);
    // die;
  }
  public function order_confirmation_sc()
  {
    //print_r($_SESSION);
    //echo 'session_controler';
    //echo "<pre>";	print_r($_POST);
    //REDIRECT(base_url());
  //  header('Location: '.$newURL);
   // header("Location: https://www.annadatha.in/");
   
   
   
		 print_r($_SESSION);
		// die;
	//	header("Location: http://mars-500/xampp/MARS1/annadatha");
			//error_reporting(E_ALL);
		 echo "<pre>";	print_r($_POST);
		 //die;
		 //check status API
/*


//$merchantId = 'your_merchant_id';  // Replace with your actual merchant ID
//$merchantTransactionId = 'your_merchant_transaction_id';  // Replace with your actual merchant transaction ID
$merchantId = $_POST["merchantId"];
$merchantTransactionId = $_POST["providerReferenceId"];
//$merchantTransactionId = $_POST["transactionId"];
$url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/{$merchantId}/{$merchantTransactionId}";
//$url = "https://api.phonepe.com/apis/hermes/pg/v1/status/$merchantId/$merchantTransactionId";

$headers = [
    'Accept: application/json',
    'Content-Type: application/json',
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}

curl_close($ch);

echo "Response : ".$response;
echo 'ddddd';
print_r( $response);
echo 'rrrrr';
die;

*/










		 if(empty($_POST)){

		 }else{
			  $merchantId = $_POST["merchantId"];
			  //$transactionId = $_POST["providerReferenceId"];
			  $transactionId = $_POST["transactionId"];
			 $salt_index = 1;
			 $apiKey="099eb0cd-02cf-4e2a-8aca-3e6c6aff0399"; // sandbox

			// $payload = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status" . $apiKey;
			 $payload = "pg/v1/status/$merchantId/$transactionId".$apiKey;
			 $sha256 = hash("sha256", $payload);
			 $final_x_header = $sha256 . '###' . $salt_index;
			 $curl = curl_init();
			 curl_setopt_array($curl, [

				 CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/$merchantId/$transactionId", //TEST
				// CURLOPT_URL => " https://api.phonepe.com/apis/hermes/pg/v1/status/$merchantId/$transactionId", //LIVE
				 CURLOPT_RETURNTRANSFER => true,
		 	  // CURLOPT_ENCODING => "",
		 	  // CURLOPT_MAXREDIRS => 10,
		 	  // CURLOPT_TIMEOUT => 30,
		 	//  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		 	  CURLOPT_CUSTOMREQUEST => "GET",

		 	  CURLOPT_HTTPHEADER => [
					"accept: text/plain",
		 	    "Content-Type: application/json",
		 	    "X-VERIFY: " . $final_x_header

		 	  ],
			 ]);

			 $response = curl_exec($curl);
			 $err = curl_error($curl);

			 curl_close($curl);
			 if ($err) {
				 echo 'error';
				 print_r($err);
				exit;
			 } else {
					$res = json_decode($response);
					// echo 'curl pass';
					// print_r($res);
					// die;
				}
			 //print_r($response);
			 echo 'curl';
			  echo "<pre>";
				print_r($response);
				echo "</pre>";
				echo 'response prrinee';
			//die;
		 }
		 // echo 'sssss';
		 // die;
		// echo $this->data['temp_id'];
		// die;
		//error_reporting(E_ALL);
		 // echo "<pre>";	print_r($_POST);//exit;
		 // die;
		$orderData['status']='';
		error_reporting(0);

		$pv_status = '';
		$pv_txn_status = '';
		$pv_transaction_amount = '';
		$pv_udf1 = '';

		$response = $_POST;
		$_POST = (array)$response;
		//print_r($_POST);
		$orderData['status']='';
		print_r($_SESSION);
		if(!empty($_POST) )
		{
			$pv_status = $pv_txn_status = $orderData['status']=$_POST["code"];
		//	$orderData['mode']=$_POST["mode"];
			$orderData['mihpayid']=$_POST["providerReferenceId"];
		//	$orderData['firstname']=$_POST["firstname"];
			$pv_transaction_amount = $orderData['amount']=$_POST["amount"];
			$orderData['txnid']=$_POST["transactionId"];
			//$orderData['error_Message']=$_POST["error_Message"];
			// $orderData['bank_ref_num']=$_POST["bank_ref_num"];
			// $orderData['posted_hash']=$_POST["hash"];
			// $orderData['key']=$_POST["key"];
			// $orderData['productinfo']=$_POST["productinfo"];
			// $orderData['email']=$_POST["email"];
			// $orderData['error']=$_POST["error"];
			// $orderData['salt']='';
		 $orderData['udf1'] = $_POST["transactionId"];
			 $orderData['udf2'] = $_POST["transactionId"];
			// $orderData['cardnum'] = $_POST["cardnum"];
			// $orderData['name_on_card'] = $_POST["name_on_card"];
			$pv_udf1 = $temp_orders_id = $_POST["transactionId"];

		}

print_r($_SESSION); exit;
		 $sess__pg_amount = $this->session->userdata('pg_amount');
		 $sess__pg_temp_orders_id = $this->session->userdata('pg_temp_orders_id');
		print_r($_SESSION); exit;

		if((empty($sess__pg_amount) || empty($sess__pg_temp_orders_id)) && !empty($pv_udf1))
		{
			echo "1";
			$temp_o_data = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"(temp_orders_id=$pv_udf1)"));
			if(!empty($temp_o_data))
			{
				$temp_o_data = $temp_o_data[0];
				$sess__pg_amount = $temp_o_data->total;
				$sess__pg_temp_orders_id = $temp_o_data->temp_orders_id;
			}
		}

		/*if($orderData['status']=='success' && $pv_txn_status == 'success' && $pv_transaction_amount == $sess__pg_amount && $sess__pg_temp_orders_id == $pv_udf1)
		{
			echo "if";
		}
		else
		{
			echo "else";
		}
		echo "<br>";

		echo $orderData['status']."<br>";
		echo $pv_status."<br>";
		echo $pv_txn_status."<br>";
		echo $pv_transaction_amount."<br>";
		echo $pv_udf1."<br>";
		echo $sess__pg_amount."<br>";
		echo $sess__pg_temp_orders_id."<br>";
		echo $pv_udf1."<br>";*/

		//exit;

		/*echo $orderData['status']."<br>";
		echo $pv_status."<br>";
		echo $pv_txn_status."<br>";
		echo $pv_transaction_amount."<br>";
		echo $pv_udf1."<br>";
		echo $sess__pg_amount."<br>";
		echo $sess__pg_temp_orders_id."<br>";
		echo $pv_udf1."<br>";

		if(1==1.00)
		{

			echo "fer";
		}

		if($orderData['status']=='success' && $pv_status == 1 && $pv_txn_status == 'success' && $pv_transaction_amount == $sess__pg_amount && $sess__pg_temp_orders_id == $pv_udf1)
		{
			echo "if";
		}

		exit;*/



		$pv_transaction_amount = $sess__pg_amount;
		echo "2";

		if($orderData['status']=='PAYMENT_SUCCESS' && $pv_txn_status == 'PAYMENT_SUCCESS'  && $sess__pg_temp_orders_id == $pv_udf1)
		{echo "3";


			/*$r_payment_data['temp_order_id'] = $temp_order_id;
			$r_payment_data['orders_id'] = '';
			$r_payment_data['id'] = $cc_orderData["tracking_id"];
			$r_payment_data['entity'] = $cc_orderData["bank_ref_no"];
			$r_payment_data['amount'] = $cc_orderData["mer_amount"]*100;
			$r_payment_data['currency'] = 'INR';
			$r_payment_data['status'] = $cc_orderData["order_status"];
			$r_payment_data['order_id'] = '';
			$r_payment_data['invoice_id'] = '';
			$r_payment_data['international'] = '';
			$r_payment_data['method'] = $cc_orderData["payment_mode"];
			$r_payment_data['amount_refunded'] = '';
			$r_payment_data['refund_status'] = '';
			$r_payment_data['captured'] = '';
			$r_payment_data['description'] = '';
			$r_payment_data['card_id'] = '';
			$r_payment_data['bank'] = '';
			$r_payment_data['wallet'] = '';
			$r_payment_data['vpa'] = '';
			$r_payment_data['email'] = $cc_orderData["billing_email"];;
			$r_payment_data['contact'] = '';
			$r_payment_data['fee'] = '';
			$r_payment_data['tax'] = '';
			$r_payment_data['error_code'] = '';
			$r_payment_data['error_description'] = '';
			$r_payment_data['error_source'] = '';
			$r_payment_data['error_step'] = '';
			$r_payment_data['error_reason'] = '';
			$r_payment_data['created_at'] = time();
			$r_payment_data['stuck_order_status'] = 1;*/

			//$payment_response_id = $this->Common_Model->add_operation(array('table'=>'payment_response' , 'data'=>$r_payment_data));

			$page_data = array();
			exit;
			$this->data['tempOrdersData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"(temp_orders_id=$orderData[udf1] and status=0)"));
			if(empty($this->data['tempOrdersData']))
				REDIRECT(base_url());
			$update_temp_orders_data['status']=1;
			$update_temp_orders_data['stuck_status']=1;
			$update_temp_orders_data['stock_status']=1;
			$this->Common_Model->update_operation(array('table'=>'temp_orders' , 'data'=>$update_temp_orders_data , 'condition'=>"(temp_orders_id=$orderData[udf1])"));
			$tempOrdersData = $this->data['tempOrdersData'][0];
			foreach($tempOrdersData as $key => $value)
			{
				$orderData[$key]=$value;
			}

			$orderData['order_number'] = '';
			$orderData['order_status'] = 1;
			$orderData['order_status'] = 1;
			$orderData['pg_response_json'] = json_encode($_POST);
			$orderData['status'] = 1;


			unset($orderData['tracking_id']);
			//unset($orderData['bank_ref_num']);
			unset($orderData['order_status']);
			unset($orderData['failure_message']);
			//unset($orderData['payment_mode']);
			//unset($orderData['card_name']);
			unset($orderData['status_code']);
			unset($orderData['status_message']);
			unset($orderData['productinfo']);
			unset($orderData['error']);
			unset($orderData['salt']);
			unset($orderData['udf1']);
			unset($orderData['udf2']);
			unset($orderData['stuck_status']);
			unset($orderData['stock_status']);
			unset($orderData['bank_ref_no']);
			//$orderData['mode'] = $orderData['payment_mode'];
			unset($orderData['payment_mode']);

			unset($orderData['card_name']);
			//$orderData['bank_ref_num'] = time().' - ONLINE';


			$orders_id = $this->Common_Model->add_operation(array('table'=>'orders' , 'data'=>$orderData));
			//echo $this->db->last_query();
			//exit;

			$update_payment_response_data['orders_id']=$orders_id;
			//$this->Common_Model->update_operation(array('table'=>'payment_response' , 'data'=>$update_payment_response_data , 'condition'=>"(payment_response_id=$payment_response_id)"));
/*
			if($orders_id>0)
			{

				$add_new_order_history_params = array('orders_id'=>$orders_id , 'order_status_id'=>1 , 'caption'=>'Order Placed');
				$orders_history_id = $this->_sosl->add_new_order_history($add_new_order_history_params);


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

				$this->data['order_number'] = "#".__order_initial__."/".date('Y').'/'.date('m').'/'.date('d').'/'.$orders_id;
				$page_data['order_number'] = $this->data['order_number'];
				$page_data['date'] = date('M d Y');
				$page_data['txnid'] = $_POST["txnid"];
			}

			$update_orders_data['status']=$_POST["status"];
			$update_orders_data['mode']=$_POST["mode"];
			$update_orders_data['mihpayid']=$_POST["easepayid"];
			$update_orders_data['firstname']=$_POST["udf2"];
			$update_orders_data['amount']=$_POST["net_amount_debit"];
			$update_orders_data['txnid']=$_POST["txnid"];
			$update_orders_data['posted_hash']='';
			$update_orders_data['key']='';
			$update_orders_data['productinfo']='';
			//$update_orders_data['email']=$_POST["udf3"];
			$update_orders_data['salt']='';
			$update_orders_data['udf1'] = $_POST["udf1"];
			$update_orders_data['udf2'] = $_POST["udf1"];

			$temp_orders_id = $_POST["udf1"];
			$update_orders_data['customers_id'] = $this->data['temp_id'];
			$update_orders_data['stores_id']=$this->data['store_id'];

			unset($update_orders_data['productinfo']);
			unset($update_orders_data['salt']);
			unset($update_orders_data['udf1']);
			unset($update_orders_data['udf2']);
			unset($update_orders_data['tracking_id']);


			$update_orders_data['order_number']=$this->data['order_number'];
			$update_orders_data['order_status_id'] = 1;
			$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>$update_orders_data , 'condition'=>"(orders_id=$orders_id)"));
			$this->session->set_flashdata('orders_id', $orders_id);
			$this->data['page_data'] = $page_data;

			$this->Common_Model->delete_operation(array("where"=>array('application_sess_temp_id' => $this->data['temp_id']) , "table"=>'temp_cart' ));
			$this->session->set_userdata('application_sess_cart_count' , '');
			$this->data['cart_count'] = '0';

			//mail and sms code start
			$this->data['orders'] = $this->Checkout_model->getOrder(array("orders_id"=>$orders_id , "customers_id"=>$this->data['temp_id']));
			//print_r($this->data['orders']);

			$o=$this->data['orders'] = $this->data['orders'][0];

			//email sms code start
			$contact = $o->number;
			$template = "Dear $o->name, your order is confirmed. Your order id is $o->order_number. For more details login to your account "._SMS_BRAND_;
			//echo $template;
			$this->Common_Model->send_sms($contact , $template);

			$template = "Dear Admin, you have a new order. Order id is $o->order_number. For more details login to your account "._SMS_BRAND_;
			//echo $template;
			$this->Common_Model->send_sms(__adminsms__ , $template);


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
			$ship_data = '';
			if($o->shipping_discount>0)
			{
				$ship_data .= '<tr>
					<td colspan="3" style="font-family:Arial, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;border-collapse: collapse;">
					<strong>Shipping Discount</strong>
					</td>
					<td style="font-family:Arial, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;border-collapse: collapse;">-
						'.$o->symbol.' '.$o->shipping_discount.'
					</td>
				</tr>';
			}
			if($o->cod_charges>0)
			{
				$ship_data .= '<tr>
					<td colspan="3" style="font-family:Arial, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;border-collapse: collapse;">
					<strong>COD Charges</strong>
					</td>
					<td style="font-family:Arial, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;border-collapse: collapse;">
						'.$o->symbol.' '.$o->cod_charges.'
					</td>
				</tr>';
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
			$mailMessage = str_replace("#total_packing_charges#",stripslashes($o->symbol.' '.$o->total_packing_charges),$mailMessage);
			$mailMessage = str_replace("#total#",stripslashes($o->symbol.' '.$o->total),$mailMessage);
			$mailMessage = str_replace("#product_detail#",$product_detail,$mailMessage);
			$mailMessage = str_replace("#ship_data#",$ship_data,$mailMessage);
			$mailMessage = str_replace("#total_gst#",stripslashes($o->symbol.' '.$o->total_gst),$mailMessage);

			$mailMessage = str_replace("#project_contact#",_project_contact_,$mailMessage);
			$mailMessage = str_replace("#project_contact_without_space#",_project_contact_without_space_,$mailMessage);
			$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
			$mailMessage = str_replace("#project_website#",_project_web_,$mailMessage);
			$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);
			$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
			$social_media = '';
			if(_FACEBOOK_!='')
				$social_media = $social_media.'<a href="'._FACEBOOK_.'" target="_blank" ><img src="'.IMAGE.'email/facebook.png" width="25"></a>';
			if(_INSTAGRAM_!='')
				$social_media = $social_media.'<a href="'._INSTAGRAM_.'" target="_blank" ><img src="'.IMAGE.'email/instagram.png" width="25"></a>';
			if(_PINTEREST_!='')
				$social_media = $social_media.'<a href="'._PINTEREST_.'" target="_blank" ><img src="'.IMAGE.'email/pinterest.png" width="25"></a>';
			if(_TWITTER_!='')
				$social_media = $social_media.'<a href="'._TWITTER_.'" target="_blank" ><img src="'.IMAGE.'email/twitter.png" width="25"></a>';
			if(_LINKEDIN_!='')
				$social_media = $social_media.'<a href="'._LINKEDIN_.'" target="_blank" ><img src="'.IMAGE.'email/linkedin.png" width="25"></a>';
			if(_YOUTUBE_!='')
				$social_media = $social_media.'<a href="'._YOUTUBE_.'" target="_blank" ><img src="'.IMAGE.'email/youtube.png" width="25"></a>';
			$mailMessage = str_replace("#social_media#",$social_media,$mailMessage);
			$mailMessage = str_replace("#mainsiteaccount#",base_url().__dashboard__,$mailMessage);

			$subject = "Your Order Placed Successfully. Order No.: $o->order_number !"._brand_name_;
			$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$o->email , "name"=>$o->name ));
			//$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>'anil@marswebsolutions.com' , "name"=>$o->name ));

			$subject = "New Order Placed. Order No.: $o->order_number !"._brand_name_;
			$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>__adminemail__ , "name"=>'Admin' ));

			$this->data['order_success_g_tag'] = "";
			$this->session->set_flashdata('orders_id', $orders_id);
			$this->data['order_success_amp_triggers'] = '';
			// echo '<pre>';
			// print_r($this->data['orders'] );
			// echo '<pre>';
			//die;

			// echo $mailMessage;
			// die;
		//	echo json_encode(array("status"=>1));
			//REDIRECT(base_url().__orderStatus__);
			//echo $mailMessage;
			//email sms code end
*/
			parent::getHeader('header' , $this->data);
			$this->load->view('order_confirmation',$this->data);
			parent::getFooter('footer' , $this->data);

		}
		else
		{
			//echo "<pre>";print_r($_POST);echo "</pre>";
			//echo "<pre>";print_r($orderData);echo "</pre>";
			//exit;
			echo "4";

			if(!empty($orderData['udf1']))
			{echo "5";
				/*if(!empty($_POST["status_message"]))
					$order_fail_data['status_message'] = $_POST["status_message"];
				if(!empty($_POST["error_Message"]))
					$order_fail_data['error_Message'] = $_POST["error_Message"];
				if(!empty($_POST["mihpayid"]))
					$order_fail_data['mihpayid'] = $_POST["mihpayid"];
				if(!empty($_POST["amount"]))
					$order_fail_data['amount'] = $_POST["amount"];
				if(!empty($_POST["txnid"]))
					$order_fail_data['txnid'] = $_POST["txnid"];*/

				if(!empty($_POST["error_Message"]))
					$update_temp_orders_data['status_message']=$_POST["error_Message"];;
				if(!empty($_POST["mihpayid"]))
					$update_temp_orders_data['tracking_id']=$_POST["mihpayid"];
				if(!empty($_POST["field8"]))
					$update_temp_orders_data['failure_message']=$_POST["field8"];


				$update_temp_orders_data['pg_response']=json_encode($_POST);

				/*$update_temp_orders_data['bank_ref_no']=$_POST["bank_ref_no"];
				$update_temp_orders_data['order_status']=$_POST["order_status"];
				$update_temp_orders_data['failure_message']=$_POST["failure_message"];
				$update_temp_orders_data['payment_mode']=$_POST["mode"];
				$update_temp_orders_data['card_name']=$_POST["card_name"];
				$update_temp_orders_data['status_code']=$_POST["status_code"];*/

				$update_temp_orders_data['stuck_status ']=3;
				$this->Common_Model->update_operation(array('table'=>'temp_orders' , 'data'=>$update_temp_orders_data , 'condition'=>"(temp_orders_id=$orderData[udf1])"));
				$this->order_stock_plus($orderData['udf1']);

				$this->data['tempOrdersDetailsData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"temp_orders_id=$orderData[udf1]"));
				$this->data['tempOrdersDetailsData'] = $this->data['tempOrdersDetailsData'][0];
			}

			echo "6";
			print_r($_SESSION); //exit;
				echo json_encode(array("status"=>0,'message'=>'Payment Failed'));
				//die;
			echo "7";
			print_r($_SESSION); //exit;

			parent::getHeader('header' , $this->data);
			$this->load->view('order_fail',$this->data);
			parent::getFooter('footer' , $this->data);
		}
	
   
  }
}
?>
