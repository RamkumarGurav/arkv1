<?
include( APPPATH."third_party/shiprocket/auth.php");
$od = $orders_detail[0];


$order_api_data = array(
"shipment_id"=> $od->courier_shipment_id);

$order_api_data_json = $post_json_data = json_encode($order_api_data);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/generate/pickup',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$post_json_data,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    "Authorization: Bearer $token"
  ),
));

$responsejson = $response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response);
//echo "<h1>RESPONSE</h1>";
//echo "<xmp>";
//print_r($response);

//exit;
//echo $response;
//$result = $response;
//$auth_response = json_decode($response, true);
//echo "<h1>RESPONSE</h1>";
//echo "<xmp>";
//print_r($response);

if(!empty($response->pickup_status))
{
	if($response->pickup_status==1)
	{
		$pickup_token_number = $response->response->pickup_token_number;
		$pickup_scheduled_date = $response->response->pickup_scheduled_date;
		$pickup_data = $response->response->data;
		
		
		$add_new_order_docket_history_params = array('orders_id'=>$od->orders_id , 'docket_no'=>$od->docket_no ,'courier_name'=>$od->courier_name, 'order_status_id'=>7 , 'caption'=>"Assign Order Pickup" , 'posted_data'=>'', 'response'=>$responsejson , 'post_json'=>$order_api_data_json , 'updated_by'=>$this->session->userdata("sess_user_id") , 'courier_order_id'=>$od->courier_order_id , 'courier_shipment_id'=>$od->courier_shipment_id);
		
		$orders_docket_history_id = $_sosl->add_new_order_docket_history($add_new_order_docket_history_params);
		
		$add_new_order_history_params = array('orders_id'=>$od->orders_id , 'order_status_id'=>7 , 'caption'=>"Assign Order Pickup" , 'remarks'=>$pickup_data , 'updated_by'=>$this->session->userdata("sess_user_id"));
		$orders_history_id = $_sosl->add_new_order_history($add_new_order_history_params);
		
		
		$h_description = "Pickup Assigned";
		$this->Common_Model->update_operation(array('table'=>'orders_history' , 'data'=>array('description'=>$h_description) , 'condition'=>"(orders_history_id = $orders_history_id)"));
		
		
		$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>array('pickup_token_number'=>$pickup_token_number , 'pickup_scheduled_date'=>$pickup_scheduled_date , 'pickup_data'=>$pickup_data , 'pickup_json'=>$responsejson) , 'condition'=>"(orders_id = $od->orders_id )"));
		//echo $this->db->last_query();
		$is_docket_assign = true;
		$this->session->set_flashdata('message', "<div class=' alert alert-success'>Pickup Assigned Successfully</div>");
		echo "<script>window.location.reload();location.reload();</script>";
	}
	else{
		echo "<h1>RESPONSE</h1>";
		echo "<pre>";
		print_r($response);
		echo "</pre>";
	}
}
else{
	echo "<h1>RESPONSE</h1>";
	echo "<pre>";
	print_r($response);
	echo "</pre>";
}



?>