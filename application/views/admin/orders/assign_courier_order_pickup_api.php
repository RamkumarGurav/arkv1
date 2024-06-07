<?
$od = $orders_detail[0];
?>
<?php
$pickup_date = $_POST['pickup_date'];

$post_data_arr['pickup_time'] = "14:00:00";
$post_data_arr['pickup_date'] = date('Y-m-d' , strtotime($pickup_date));
$post_data_arr['expected_package_count'] = 1;
$post_data_arr['pickup_location'] = "ANNADATHA RYTHU SEVA KENDRAM";
$post_data_json = json_encode($post_data_arr);
$ch = curl_init();
//$url = 'https://staging-express.delhivery.com/​fm/request/new/';
$url = 'https://track.delhivery.com/fm/request/new/';
echo $url;
echo "<br>";
echo __dl_token__;
echo "<br>";
echo $post_data_json;
//exit;
//curl_setopt($ch, CURLOPT_URL, 'https://track.delhivery.com/​fm/request/new/');
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST,TRUE);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Authorization:Token ".__dl_token__ , "Content-Type:application/json"));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data_json);
$response_json = curl_exec($ch);
echo $response_json;
//exit;



if(!empty($response_json))
{
	$response_obj = json_decode($response_json);
	/*echo "<pre>";
	print_r($response_obj);
	echo "</pre>";
	curl_close($ch);*/

	$add_new_order_history_params = array('orders_id'=>$od->orders_id , 'order_status_id'=>7 , 'caption'=>"Generate Packing Slip." , 'remarks'=>'' , 'updated_by'=>$this->session->userdata("sess_user_id"));
	$orders_history_id = $_sosl->add_new_order_history($add_new_order_history_params);

	$courier_packing_slip_data['docket_no'] = $od->docket_no;
	$courier_packing_slip_data['orders_id'] = $od->orders_id;
	$courier_packing_slip_data['packing_slip_json'] = $response_json;

	$courier_packing_slip_id = $this->Common_Model->add_operation(array('table'=>'courier_packing_slip' , 'data'=>$courier_packing_slip_data));

	$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>array('is_packing_slip_generated'=>1) , 'condition'=>"(orders_id = $od->orders_id )"));
	//echo $this->db->last_query();
	$is_docket_assign = true;
	$this->session->set_flashdata('message', "<div class=' alert alert-success'>Pickup Assigned Successfully.</div>");
	echo "<script>window.location.reload();location.reload();</script>";

}
else{
	echo "<h1>RESPONSE</h1>";
	echo "<pre>";
	print_r($result_obj);
	echo "</pre>";
}


exit;

?>
