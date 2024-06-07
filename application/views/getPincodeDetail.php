


<?



include_once( APPPATH."third_party/shiprocket/auth.php");
$destination_pincode = $params['delivery_pin_code'] =  $pincode;
$destination_pincode = $params['total_weight'] =  $total_weight;
$order_api_data = array(
"pickup_postcode"=> 502101,
"delivery_postcode"=> $params['delivery_pin_code'],
"cod"=>1,
//'declared_value'=>$params['order_total'],
"weight"=>round(($params['total_weight']/1000) , 3)
);
$order_api_data_json = $post_json_data = json_encode($order_api_data);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS =>$post_json_data,
  CURLOPT_HTTPHEADER => array(
  'Content-Type: application/json',
  "Authorization: Bearer $token"
  ),
));

$responsejson = $response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response);

// print_r($response);
// die;

// $request_url = __delivery_api__.'pincode_detail.php';
// //echo $request_url;
// //$post_data="&pickup_pincode=".$pickup_pincode;
// $post_data['destination_pincode']=$destination_pincode;
// //print_r($post_data);
// $post = curl_init();
// curl_setopt($post, CURLOPT_URL, $request_url);
// curl_setopt($post, CURLOPT_POST,1);
// curl_setopt($post, CURLOPT_POSTFIELDS, json_encode($post_data));
// curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
// $response = curl_exec($post);
// $error_msg = curl_error($post);
// curl_close($post);
// $result = json_decode($response, true);
//print_r($result);
?>
	<?
    if(!empty($response->data->available_courier_companies))
    {

			?>

    <span style="color:#14c614">Delivery Available</span>
    <?
  }
		else
		{
			?>
    <span style="color:#F00">There is No delivery</span>
    <?
		}
    $count = 0;
