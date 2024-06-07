<?php

//$auth_api_data = array("email"=>"anubhav.gupta@marswebsolutions.com" , "password"=>"marsweb123");
$auth_api_data = array("email"=>"info@annadatha.in" , "password"=>"India@123#");


//$auth_api_data = json_encode($auth_api_data);
$headers = array(
    "Content-type : application/json"
);
$request_url = 'https://apiv2.shiprocket.in/v1/external/auth/login';

/*echo "<h1>URL</h1>";
echo $request_url;
echo "<h1>POST DATA</h1>";
print_r($auth_api_data);*/
//$request_url = __delivery_api__.'generateDocketNo.php';

$post = curl_init();
curl_setopt($post, CURLOPT_URL, $request_url);
curl_setopt($post, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($post, CURLOPT_POST,TRUE);
curl_setopt($post, CURLOPT_POSTFIELDS, $auth_api_data);
curl_setopt($post, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($post);
curl_close($post);



//$result = $response;
$auth_response = json_decode($response, true);
//echo "<h1>RESPONSE</h1>";
//print_r($auth_response);

$token = $auth_response['token'];


$shipment_status_arr = array(
		"1" => "AWB Assigned",
		"2" => "Label Generated",
		"3" => "Pickup Scheduled/Generated",
		"4" => "Pickup Queued",
		"5" => "Manifest Generated",
		"6" => "Shipped",
		"7" => "Delivered",
		"8" => "Cancelled",
		"9" => "RTO Initiated",
		"10" => "RTO Delivered",
		"11" => "Pending",
		"12" => "Lost",
		"13" => "Pickup Error",
		"14" => "RTO Acknowledged",
		"15" => "Pickup Rescheduled",
		"16" => "Cancellation Requested",
		"17" => "Out For Delivery",
		"18" => "In Transit",
		"19" => "Out For Pickup",
		"20" => "Pickup Exception",
		"21" => "Undelivered",
		"22" => "Delayed",
		"24" => "Destroyed",
		"25" => "Damaged",
		"26" => "Fulfilled",
		"38" => "Reached Destination Hub",
		"39" => "Misrouted",
		"40" => "RTO NDR",
		"41" => "RTO OFD",
		"42" => "Picked Up",
		"43" => "Self FulFiled",
		"44" => "Disposed Off",
		"45" => "Cancelled Before Dispatched",
		"46" => "RTO In Transit");
