<?
$CI=&get_instance();
$payment_gateway_data['temp_orders_id'] = "#".__order_initial__."-".$payment_gateway_data['temp_orders_id'];

$payment_gateway_data['status'] = 'success';
$payment_gateway_data['mode'] = 'COD';
$payment_gateway_data['mihpayid'] = '';
$payment_gateway_data['net_amount_debit'] = $payment_gateway_data['total'];
$payment_gateway_data['txnid'] = $payment_gateway_data['Order_Id'];
$payment_gateway_data['udf1'] = $payment_gateway_data['Order_Id'];
$payment_gateway_data['udf2'] = $payment_gateway_data['name'];
$payment_gateway_data['udf3'] = $payment_gateway_data['email'];


//echo "<pre>";print_r($payment_gateway_data);
//exit;
$CI->order_confirmation_cod($payment_gateway_data);
