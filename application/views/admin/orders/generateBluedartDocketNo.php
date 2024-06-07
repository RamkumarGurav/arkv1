<?
$this->load->library('Bluedart');
$obj_bluedart = new Bluedart();

function str_limit($value , $start=0, $limit = 100, $end = '...')
{
	$limit = $limit - mb_strlen($end); // Take into account $end string into the limit
	$valuelen = mb_strlen($value);
	//echo "<br>mbs : ".mb_strlen($end)."<br>";
	//echo "<br>limit : $limit <br>";
	//echo "<br>valuelen : $valuelen <br>";
	return mb_substr($value, $start, $limit);
	//return mb_substr($value, $start, mb_strrpos($value, ' ', $limit - $valuelen));
    //return $limit < $valuelen ? mb_substr($value, $start, mb_strrpos($value, ' ', $limit - $valuelen)) . $end : $value;
}

$box_l=0;
$box_b=0;
$box_h=0;
$blue_dart_product_code = "E";
$blue_dart_product_sub_code = '';
$service_type='';
if(!empty($_POST['blue_dart_product_code']))
{ $blue_dart_product_code = $_POST['blue_dart_product_code']; }

if(!empty($_POST['box_l']))
{ $box_l = $_POST['box_l']; }

if(!empty($_POST['box_b']))
{ $box_b = $_POST['box_b']; }

if(!empty($_POST['box_h']))
{ $box_h = $_POST['box_h']; }

if(!empty($_POST['service_type']))
{ $service_type = $_POST['service_type']; }

$od = $orders_detail[0];
$total_product_weight = 0;

if(!empty($_POST['total_package_weight']))
{
	$total_product_weight = round($_POST['total_package_weight'] , 2);
}


//$limit = $limit - mb_strlen($end); // Take into account $end string into the limit
$d_address = strip_tags($od->d_address);
$valuelen = mb_strlen($d_address);
//echo $valuelen.'<br>';
$valuelen1 = round($valuelen/3);
//print( str_limit($d_address , $start , $limit , ''));
//echo $valuelen1;
//echo $d_address;
$d_address1 = str_limit($d_address , 0 , $valuelen1, '');
$d_address2 = str_limit($d_address , ($valuelen1) , $valuelen1 , '');
$d_address3 = str_limit($d_address , ($valuelen1*2) , $valuelen1 , '');



//echo $d_address.'<br>';
//echo $d_address1.'<br>';
//echo $d_address2.'<br>';
//echo $d_address3.'<br>';

if(empty($d_address1)){$d_address1 = "     ";};
if(empty($d_address2)){$d_address2 = "     ";};
if(empty($d_address3)){$d_address3 = "     ";};

$order_products = array();

foreach($od->details as $odd){
	$product_weight = $odd->product_weight;
	if(empty($product_weight)){$product_weight='0.100';}
	
	$order_products[] = array(
		"skuNumber"=> '',
		"description"=> $odd->product_name .', '.$odd->combi,
		"itemValue"=> $odd->final_price,
		"itemQuantity"=> $odd->prod_in_cart,
		"grossWeight"=> $product_weight,
		"contentIndicator"=> '',
		"countryOfOrigin"=> "IN",
		"hsCode"=> '',
		"height"=> 10,
		"length"=> 10,
		"width"=> 10,
		"volumetricWeight"=> 10 * 10 * 10
	
	);
}

$memo = $od->orders_id;
$codValue = 0;
if($od->is_cod==1)
{
	$codValue = $od->total;
	$blue_dart_product_code = "A";
	$blue_dart_product_sub_code = "C";
}
?>

<?php
$destination_pincode = $od->d_zipcode; // Mandatory
$vendor_address = 'Shop No. 3,4,5';
$vendor_address2 = 'Deol Nagar';
$vendor_address3 = 'Near Coca Cola Agency,';
$vendor_city = 'Jalandhar';
$vendor_state = 'Punjab';
$vendor_country = 'India';
$vendor_name = 'The Dentist Shop';
$vendor_company_name = 'The Dentist Shop';
$vendor_phone = '8026544144';
$vendor_pin = '144003';
$vendor_email = 'anubhav.gupta@marswebsolutions.com';

$docket_api_data  = array(
		'shipperAddress'=>array(
				"companyName"=> $vendor_company_name,
                "name"=> $vendor_name,
                "address1"=> $vendor_address,
                "address2"=> $vendor_address2,
                "address3"=> $vendor_address3,
                "city"=> $vendor_city,
                "state"=> $vendor_state,
                "district"=> $vendor_city,
                "country"=> "IN",
                "postCode"=> $vendor_pin,
                "phone"=> $vendor_phone,
                "email"=> $vendor_email
				),
		'shipmentDetails'=>array(
		
		 'consigneeAddress'=>array(
			"companyName"=> $od->d_name,
			"name"=> $od->d_name, # consignee
			"address1"=> $d_address1,
			"address2"=> $d_address2,
			"address3"=> $d_address3,
			"city"=> $od->d_city_name,
			"state"=> $od->d_state_name,
			"district"=> $od->d_city_name,
			"country"=> 'IN',
			"postCode"=> $od->d_zipcode,
			"phone"=> $od->d_number,
			"email"=> $od->email
			),
		'returnAddress'=>array(
			"companyName"=> $vendor_company_name,
			"name"=> $vendor_name,
			"address1"=> $vendor_address,
			"address2"=> $vendor_address2,
			"address3"=> $vendor_address3,
			"city"=> $vendor_city,
			"state"=> $vendor_state,
			"district"=> $vendor_city,
			"country"=> "IN",
			"postCode"=> $vendor_pin,
			"phone"=> $vendor_phone,
			"email"=> $vendor_email,
			"contentId"=> 1
			),
			'shipmentID'=>'BD-T1-'.$od->order_number,
			'memo'=>$memo,
			"codValue"=> $codValue,
			"insured"=> "YES",
			"packageDesc"=> "test",
			"totalWeight"=> $total_product_weight,
			"totalWeightUOM"=> "gram",
			"dimensionUOM"=> "cm",
			"height"=> $box_h,
			"length"=> $box_l,
			"width"=> $box_b,
			"noOfPieces"=> $od->total_prod,
			"invoiceValue"=> $od->total,
			'shipmentContents'=>$order_products,
			'blue_dart_product_code'=>$blue_dart_product_code,
			'blue_dart_product_sub_code'=>$blue_dart_product_sub_code,
			"label"=> array(
                "pageSize"=> "400x600",
                "format"=> "PDF",
                "layout"=> "4x6",
                "labelReq"=> false,
                "invoiceReq"=> false
            	)

			 
		 
	  )
);


/*echo "<pre>";
print_r($od);
print_r($docket_api_data);
exit;*/
//$docket_api_data = json_encode($docket_api_data);
$docket_api_encoded_data = $docket_api_data = json_encode($docket_api_data);

$docket_api_decoded_data = json_decode($docket_api_encoded_data);
//echo "<pre>";print_r($docket_api_decoded_data);echo "</pre>";exit;

$WayBillGeneration = $obj_bluedart->getWayBillGeneration($docket_api_decoded_data); 

if(!empty($WayBillGeneration->GenerateWayBillResult->AWBNo))
{
	$file_name = 'bluedart_'.$memo.'.pdf';
	file_put_contents( 'assets/docket/'.$file_name, $WayBillGeneration->GenerateWayBillResult->AWBPrintContent );
	$docket_number = $WayBillGeneration->GenerateWayBillResult->AWBNo;
	
	
	$add_new_order_history_params = array('orders_id'=>$od->orders_id , 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'remarks'=>'' , 'updated_by'=>$this->session->userdata("sess_user_id"));
$orders_history_id = $_sosl->add_new_order_history($add_new_order_history_params);

$add_new_order_docket_history_params = array('orders_id'=>$od->orders_id , 'courier_name'=>"Bluedart", 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'posted_data'=>$docket_api_encoded_data , 'updated_by'=>$this->session->userdata("sess_user_id") , 'file_link'=>$file_name, 'delivery_challan_no'=>$memo  );
$orders_docket_history_id = $_sosl->add_new_order_docket_history($add_new_order_docket_history_params);

$t_response = $WayBillGeneration;
unset($t_response->GenerateWayBillResult->AWBPrintContent);

$response = json_encode($t_response);
$this->Common_Model->update_operation(array('table'=>'orders_docket_history' , 'data'=>array('response'=>$response) , 'condition'=>"(orders_docket_history_id = $orders_docket_history_id)"));
	
	
	$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>array('docket_no'=>$docket_number , 'courier_name'=>"Bluedart" , 'delivery_challan_no'=>$memo  , 'file_link'=>$file_name) , 'condition'=>"(orders_id = $od->orders_id)"));
	
	$this->Common_Model->update_operation(array('table'=>'orders_docket_history' , 'data'=>array('docket_no'=>$docket_number , 'courier_name'=>"Bluedart") , 'condition'=>"(orders_docket_history_id = $orders_docket_history_id)"));
	
	$h_description = "Docket Number Assign With Bluedart. Docket No. Is : $docket_number";
	$this->Common_Model->update_operation(array('table'=>'orders_history' , 'data'=>array('description'=>$h_description) , 'condition'=>"(orders_history_id = $orders_history_id)"));
	
	$this->session->set_flashdata('message', "<div class=' alert alert-success'>Docket No. Assigned Successfully</div>");
	
	
	$orders_docket_no_data['orders_id'] = $od->orders_id;
	$orders_docket_no_data['docket_no'] = $docket_number;
	$orders_docket_no_data['delivery_chalan_no'] = $memo;
	$orders_docket_no_data['order_status_id'] = 7;
	$orders_docket_no_data['courier_name'] = 'Bluedart';
	$orders_docket_no_data['updated_by'] = $this->session->userdata("sess_user_id");
	$orders_docket_no_data['updated_on'] = date("Y-m-d H:i:s");
	$orders_docket_no_data['status'] = 1;
	$orders_docket_no_id = $this->Common_Model->add_operation(array('table'=>'orders_docket_no' , 'data'=>$orders_docket_no_data));
	
	
	echo '<script>window.location.reload();</script>';
}
else
{
	# below comment code is work for live 
	$alert_message='';
	$err_message='';
	if (is_array($WayBillGeneration->GenerateWayBillResult->Status->WayBillGenerationStatus))
	{
		$icount = 0;
		foreach($WayBillGeneration->GenerateWayBillResult->Status->WayBillGenerationStatus as $er)
		{
			$icount++;
			$err_message .= "<br> $icount. ".$er->StatusInformation;
		}
	}
	else
	{
		$err_message = $WayBillGeneration->GenerateWayBillResult->Status->WayBillGenerationStatus->StatusInformation;
	}
	$alert_message .= '<div class="alert alert-danger"><strong>ERROR!</strong> Way Bill is not generated for Order Number : 1245878.<br>'.$err_message.'</div>';
	echo $err_message;
}

exit;
$add_new_order_history_params = array('orders_id'=>$od->orders_id , 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'remarks'=>'' , 'updated_by'=>$this->session->userdata("sess_user_id"));
$orders_history_id = $_sosl->add_new_order_history($add_new_order_history_params);

$add_new_order_docket_history_params = array('orders_id'=>$od->orders_id , 'courier_name'=>"DTDC", 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'posted_data'=>$docket_api_encoded_data , 'updated_by'=>$this->session->userdata("sess_user_id"));
$orders_docket_history_id = $_sosl->add_new_order_docket_history($add_new_order_docket_history_params);



//echo $docket_api_data;


$this->Common_Model->update_operation(array('table'=>'orders_docket_history' , 'data'=>array('response'=>$response) , 'condition'=>"(orders_docket_history_id = $orders_docket_history_id)"));

$response_decoded = json_decode($response);
//print_r($response_decoded);
//$this->session->set_flashdata('message', "<div class=' alert alert-alert'>Order status successfully set to '$subject_order_status' for order No : $order_number.</div>");
$docket_number='';
$messageDetails='';
if(!empty($response_decoded))
{
	if(!empty($response_decoded->labels[0]->responseStatus))
	{
		if(!empty($response_decoded->labels[0]->responseStatus->code))
		{
			if($response_decoded->labels[0]->responseStatus->code == 200)
			{
				if(!empty($response_decoded->labels[0]->deliveryConfirmationNo))
				{
					$docket_number = $response_decoded->labels[0]->deliveryConfirmationNo;
				}
			}
			$messageDetails = $response_decoded->labels[0]->responseStatus->messageDetails;
		}
	}
	
}


if(!empty($docket_number))
{
	$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>array('docket_no'=>$docket_number , 'courier_name'=>"DTDC") , 'condition'=>"(orders_id = $od->orders_id)"));
	
	$this->Common_Model->update_operation(array('table'=>'orders_docket_history' , 'data'=>array('docket_no'=>$docket_number , 'courier_name'=>"DTDC") , 'condition'=>"(orders_docket_history_id = $orders_docket_history_id)"));
	
	$h_description = "Docket Number Assign With DTDC. Docket No. Is : $docket_number";
	$this->Common_Model->update_operation(array('table'=>'orders_history' , 'data'=>array('description'=>$h_description) , 'condition'=>"(orders_history_id = $orders_history_id)"));
	
	$this->session->set_flashdata('message', "<div class=' alert alert-success'>Docket No. Assigned Successfully</div>");
}
else
{
	$this->session->set_flashdata('message', "<div class=' alert alert-danger'>Error while Assigned  Docket No. $messageDetails</div>");
}
//$docket_api_data = json_decode($docket_api_data);
//echo "<pre>";
//echo "<h3>response Data</h3>";
//print_r($response);
// echo "<h3>Result Data</h3>";
// print_r($result);
//echo "<h3>Posted Data</h3>";
//print_r($docket_api_data);
//echo "<h3>Order Data</h3>";
//print_r($od);
//echo "</pre>";
//exit;

?>
 