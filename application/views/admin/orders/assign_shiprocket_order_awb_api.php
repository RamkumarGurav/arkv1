<?
include( APPPATH."third_party/shiprocket/auth.php");
$od = $orders_detail[0];
$courier_order_id = '';
$courier_shipment_id = '';
$courier_company_id = $_POST['courier_company_id'];
$shipping_rate = $_POST['shipping_rate'];

$insurance = 2;
if(!empty($_POST['insurance']))
{
	$insurance = $_POST['insurance'];
}


if($insurance==1) { $insurance = 'yes'; }
else { $insurance = 'no'; }

$box_l=0;
$box_b=0;
$box_h=0;

if(!empty($_POST['service_id']))
{
	$service = $_POST['service_id'];
}



if(!empty($_POST['box_l']))
{ $box_l = $_POST['box_l']; }

if(!empty($_POST['box_b']))
{ $box_b = $_POST['box_b']; }

if(!empty($_POST['box_h']))
{ $box_h = $_POST['box_h']; }



$total_product_weight = 0;
if(!empty($_POST['total_package_weight']))
{
	$total_product_weight_in_kg = round($_POST['total_package_weight'] , 3);
}
else
{
	$total_product_weight_in_kg = round($od->total_weight/1000 , 3);
}


//echo "<pre>";
//echo "<h1>Product Data</h1>";
//print_r($od);


foreach($od->details as $odd)
{
	if(empty($odd->hsn_code)){$odd->hsn_code='000000';}
	$order_item[] = array(
		  "name"=> $odd->product_name.' - '.html_entity_decode($odd->combi),
		  "sku"=> $odd->combi_ref_code.'-'.$odd->orders_details_id,
		  "units"=> $odd->prod_in_cart,
		  "selling_price"=> $odd->price,
		  "discount"=> $odd->price - $odd->final_price,
		  "tax"=> $odd->tax_providers_percentage,
		  "hsn"=> $odd->hsn_code
		);
}

$payment_method='';

if($od->is_cod==1)
{
	$payment_method='cod';
}
else
{
	$payment_method='Prepaid';
}
$_order_number = str_replace('#' , '' , $od->order_number);
$_order_number = str_replace('/' , '-' , $od->order_number);
//0224-479
$order_api_data = array(
"order_id"=> $_order_number,
"order_date"=> date('Y-m-d H:i' , strtotime($od->added_on)),
//"pickup_location"=> "#35/6, Dr. DVG Road, Basavanagudi",
"pickup_location"=> "ANNADATHA RYTHU SEVA KENDRAM",
//"channel_id"=> "1410503",
"channel_id"=> "",
"comment"=> "",
"reseller_name"=> "",
"company_name"=> "",
  "billing_customer_name"=> $od->b_name,
  "billing_last_name"=> "",
  "billing_address"=> $od->b_address,
  "billing_address_2"=> $od->b_address2.' , '.$od->b_address3,
  "billing_isd_code"=> "",
  "billing_city"=> $od->b_city_name,
  "billing_pincode"=> $od->b_zipcode,
  "billing_state"=> $od->b_state_name,
  "billing_country"=> $od->b_country_name,
  "billing_email"=> $od->email,
  "billing_phone"=> $od->b_number,
  "billing_alternate_phone"=> "",
  "shipping_is_billing"=> false,
  "shipping_customer_name"=> $od->d_name,
  "shipping_last_name"=> "",
  "shipping_address"=> $od->d_address,
  "shipping_address_2"=> $od->d_address2.' , '.$od->d_address3,
  "shipping_city"=> $od->d_city_name,
  "shipping_pincode"=> $od->d_zipcode,
  "shipping_country"=> $od->d_country_name,
  "shipping_state"=> $od->d_state_name,
  "shipping_email"=> $od->email,
  "shipping_phone"=> $od->d_number,
  "order_items"=> $order_item,
  "payment_method"=> $payment_method,
  "shipping_charges"=> 0,
  "giftwrap_charges"=> 0,
  "transaction_charges"=> 0,
  "total_discount"=> 0,
  "sub_total"=> $od->total,
  "length"=> $box_l,
  "breadth"=> $box_b,
  "height"=> $box_h,
  "weight"=> $total_product_weight_in_kg,
  //"ewaybill_no"=> "",
  //"customer_gstin"=> "",
  //"invoice_number"=> ""

);
/*echo  "<pre>";
print_r($order_api_data);
echo "</pre>";
exit;*/
$order_api_data_json = $post_json_data = json_encode($order_api_data);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/orders/create/adhoc',
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

$response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response);
//echo "<h1>RESPONSE</h1>";
//echo "<xmp>";
//print_r($response);

if(!empty($response->order_id) && !empty($response->shipment_id))
{
	$courier_order_id = $response->order_id;
	$courier_shipment_id = $response->shipment_id;
}
else
{
	echo "<pre>";
	print_r($response);
	echo "</pre>";
	exit;
}


$awb_api_data = array(
//"order_id"=> $response->order_id,
"shipment_id"=> $response->shipment_id,
  "courier_id"=> $courier_company_id
);


$awb_api_json_data = json_encode($awb_api_data);
$awb_api_data = json_decode($awb_api_json_data);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/assign/awb',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$awb_api_data,
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer $token"
  ),
));

$responsejson = $response = curl_exec($curl);

$response_awb = $response = json_decode($response);
//echo $response;
//$result = $response;
//$auth_response = json_decode($response, true);
//echo "<h1>RESPONSE</h1>";
//echo "<xmp>";
print_r($response);

if(!empty($response->awb_assign_status))
{
	if($response->awb_assign_status==1)
	{
		$docket_number = $response->response->data->awb_code;
		$courier_name = $response->response->data->courier_name;


		$add_new_order_docket_history_params = array('orders_id'=>$od->orders_id , 'docket_no'=>$docket_number ,'courier_name'=>$courier_name, 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'posted_data'=>'', 'response'=>$responsejson , 'post_json'=>$order_api_data_json , 'updated_by'=>$this->session->userdata("sess_psts_uid") , 'courier_order_id'=>$courier_order_id , 'courier_shipment_id'=>$courier_shipment_id);

		$orders_docket_history_id = $_sosl->add_new_order_docket_history($add_new_order_docket_history_params);

		$add_new_order_history_params = array('orders_id'=>$od->orders_id , 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'remarks'=>'' , 'updated_by'=>$this->session->userdata("sess_psts_uid"));
		$orders_history_id = $_sosl->add_new_order_history($add_new_order_history_params);

		$shiprocket_docket_no_data['caption'] = 'To Customer';
		$shiprocket_docket_no_data['orders_id'] = $od->orders_id;
		$shiprocket_docket_no_data['docket_no'] = $docket_number;
		$shiprocket_docket_no_data['courier_order_id'] = $courier_order_id;
		$shiprocket_docket_no_data['courier_shipment_id'] = $courier_shipment_id;
		$shiprocket_docket_no_data['delivery_chalan_no'] = '';
		$shiprocket_docket_no_data['order_status_id'] = 1;
		$shiprocket_docket_no_data['courier_name'] = $courier_name;
		$shiprocket_docket_no_data['shipping_price'] = $shipping_rate;
		$shiprocket_docket_no_data['added_by'] = $this->session->userdata("sess_psts_uid");
		$shiprocket_docket_no_data['added_on'] = date("Y-m-d H:i:s");
		$shiprocket_docket_no_data['status'] = 1;

		$shiprocket_docket_no_id = $this->Common_Model->add_operation(array('table'=>'shiprocket_docket_no' , 'data'=>$shiprocket_docket_no_data));


		$h_description = "Docket Number Assign With $courier_name Docket No. Is : $docket_number";
		$this->Common_Model->update_operation(array('table'=>'orders_history' , 'data'=>array('description'=>$h_description) , 'condition'=>"(orders_history_id = $orders_history_id)"));

		if(empty($shipping_rate))
		{ $shipping_rate = ''; }

		$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>array('docket_no'=>$docket_number , 'courier_name'=>$courier_name , 'courier_order_id'=>$courier_order_id , 'courier_shipment_id'=>$courier_shipment_id , 'courier_status_id'=>1 , 'is_courier_txn'=>1  , 'shipping_price'=>$shipping_rate ) , 'condition'=>"(orders_id = $od->orders_id )"));
		//echo $this->db->last_query();
		$is_docket_assign = true;
		$this->session->set_flashdata('message', "<div class=' alert alert-success'>Docket No. Assigned Successfully</div>");
		echo "<script>window.location.reload();location.reload();</script>";
	}
	else{
		echo "<h1>RESPONSE</h1>";
		echo "<pre>";
		print_r($response_awb);
		echo "</pre>";
	}
}
else{
	echo "<h1>RESPONSE</h1>";
	echo "<pre>";
	print_r($response_awb);
	echo "</pre>";
}


?>
