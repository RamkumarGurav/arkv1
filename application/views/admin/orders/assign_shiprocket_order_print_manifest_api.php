<?
include_once( APPPATH."third_party/shiprocket/auth.php");
$od = $orders_detail[0];

$order_api_data = array(
"order_ids"=> array($od->courier_order_id));


$order_api_data_json = $post_json_data = json_encode($order_api_data);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/manifests/print',
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

//exit;
//echo $response;
//$result = $response;
//$auth_response = json_decode($response, true);
//echo "<h1>RESPONSE</h1>";
//echo "<pre>";
//print_r($response);
//exit;

if(!empty($response))
{
	if($response->manifest_url)
	{
		$manifest_url = $response->manifest_url;
		
		echo "<script>window.open('".$manifest_url."', '_blank');</script>";
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