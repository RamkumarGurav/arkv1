<?
require_once(APPPATH.'third_party/dtdc_auth.php');

function str_limit($value , $start=0, $limit = 100, $end = '...')
{
	$limit = $limit - mb_strlen($end); // Take into account $end string into the limit
	$valuelen = mb_strlen($value);
	//echo "<br>limit : $limit <br>";
	//echo "<br>valuelen : $valuelen <br>";
	return mb_substr($value, $start, mb_strrpos($value, ' ', $limit - $valuelen));
    //return $limit < $valuelen ? mb_substr($value, $start, mb_strrpos($value, ' ', $limit - $valuelen)) . $end : $value;
}

$box_l=0;
$box_b=0;
$box_h=0;
$service_type='';
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
$d_address = $od->d_address;
$valuelen = mb_strlen($d_address);
$valuelen1 = $valuelen/3;
//print( str_limit($d_address , $start , $limit , ''));

$d_address1 = str_limit($d_address , 0 , 95, '');
$d_address2 = str_limit($d_address , $valuelen1 , 95 , '');
$d_address3 = str_limit($d_address , ($valuelen1*2) , 95 , '');

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

?>

<?php
$hdr = array('messageType'=>"CPDP_API",
'messageDateTime'=>date('Y-m-d').'T'.date('H:i:s').'+05:30',
'accessToken'=>$key,
'messageVersion'=>'1.0',
'messageLanguage'=>'en'
);
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
		//"dispatch_date"=> "", # optional ­ date/time    2013-05-31T10:53:46.789382+00:00
		//"dispatch_id"=> '',# optional ­ dispatch id
		# address from where shipments need to be picked up from
	
	 "labelRequest"=>
	 array('hdr'=>$hdr,
	 'bd'=>
	 array('accountType'=>'CPDP' , 
	 	'hubDetails'=>array("hubType"=> "FR",
                "hubCode"=> "JF1480",
                "recievingDateTime"=> "Thu Feb 5 2021 05:34:55 GMT+0530 (UTC)",
                "recievingRemarks"=> "",
                "custCode" => "JF1480"
				),
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
		'shipmentItems'=>array(
		array(
		 'consigneeAddress'=>array(
			"companyName"=> '',
			"name"=> $od->d_name, # consignee
			"address1"=> $d_address1,
			"address2"=> $d_address2,
			"address3"=> $d_address3,
			"city"=> $od->d_city_name,
			"state"=> $od->d_state_name,
			"district"=> '',
			"country"=> 'IN',
			"postCode"=> $od->d_zipcode,
			"phone"=> $od->d_number,
			"email"=> $od->email,
			"idNumber"=> '',
			"idType"=> '',
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
			'shipmentID'=>'T2-'.$od->order_number,
			"deliveryConfirmationNo"=> null,
			"serviceType"=> $service_type,
			"codValue"=> 0,
			"insured"=> "YES",
			"insuredBy"=> "OWNER",
			"shipmentType"=> "DOX",
			"volumetricWeight"=> "0.501",
			"packageDesc"=> "test",
			"totalWeight"=> $total_product_weight/1000,
			"totalWeightUOM"=> "KG",
			"dimensionUOM"=> "3.001",
			"height"=> $box_h,
			"length"=> $box_l,
			"width"=> $box_b,
			"noOfPieces"=> $od->total_prod,
			"invoiceValue"=> $od->total,
			'shipmentContents'=>$order_products,
			"label"=> array(
                "pageSize"=> "400x600",
                "format"=> "PDF",
                "layout"=> "4x6",
                "labelReq"=> false,
                "invoiceReq"=> false
            	)

			 
		  )
		  )
		  )
	  )
);
$headers = array(
    "X-Access-Token: $key",
	"Content-type : application/json",
	"messageVersion : 1.0",
	"messageLanguage : En",
	"messageType : CPDP_API",
	"messageDateTime : ".date('Y-m-d').'T'.date('H:i:s').'+05:30'
);

//echo "<pre>";
//print_r($od);
//$docket_api_data = json_encode($docket_api_data);
$docket_api_encoded_data = $docket_api_data = json_encode($docket_api_data);


$add_new_order_history_params = array('orders_id'=>$od->orders_id , 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'remarks'=>'' , 'updated_by'=>$this->session->userdata("sess_user_id"));
$orders_history_id = $_sosl->add_new_order_history($add_new_order_history_params);

$add_new_order_docket_history_params = array('orders_id'=>$od->orders_id , 'courier_name'=>"DTDC", 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'posted_data'=>$docket_api_encoded_data , 'updated_by'=>$this->session->userdata("sess_user_id"));
$orders_docket_history_id = $_sosl->add_new_order_docket_history($add_new_order_docket_history_params);



//echo $docket_api_data;
//$request_url = __delivery_api__.'generateDocketNo.php';
$request_url = $curr_url.'api/custOrder/addCPDPBookingOrder';
//echo "<h2>URL</h2>";
//echo $request_url;
//echo "<h2>Header</h2>";
//print_r($headers);
//echo "<h2>API DATA</h2>";
//print($docket_api_data);
//print_r(json_decode($docket_api_data));
//exit;
//$post_data="&pickup_pincode=".$pickup_pincode;
//$post_data['destination_pincode']=$destination_pincode;
//$post_data['docket_api_data']=$docket_api_data;
$post = curl_init();
curl_setopt($post, CURLOPT_URL, $request_url);
curl_setopt($post, CURLOPT_POST,TRUE);
curl_setopt($post, CURLOPT_POSTFIELDS, $docket_api_data);
//echo "<h1>Start</h1>";
//echo json_encode($docket_api_data);
//echo "<h1>end</h1>";
curl_setopt($post, CURLOPT_HTTPHEADER, $headers);
curl_setopt($post, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($post);
curl_close($post);
//$result = json_decode($response, true);
$result = $response;


//$response = '{"labels":[{"shipmentID":"T-125","deliveryConfirmationNo":"Z11228955","altReferenceNo":null,"nodeId":"DTDC","content":null,"invoiceContent":null,"empEmailId":null,"childDetails":[],"responseStatus":{"code":200,"message":"SUCCESS","messageDetails":"Shipment processed successfully","logMsg":null}}],"responseStatus":{"code":200,"message":"SUCCESS","messageDetails":"All shipments processed successfully","logMsg":[]}}';

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
 