<?
$box_l=10;
$box_b=10;
$box_h=10;

if(!empty($_POST['box_l']))
{ $box_l = $_POST['box_l']; }

if(!empty($_POST['box_b']))
{ $box_b = $_POST['box_b']; }

if(!empty($_POST['box_h']))
{ $box_h = $_POST['box_h']; }


$od = $orders_detail[0];
$total_product_weight = 100;

if(!empty($_POST['total_package_weight']))
{
	$total_product_weight = round($_POST['total_package_weight'] , 2);
}

?>
<?php

if($od->d_zipcode)
{
	
}
else
{
	
}
$item_array = array();
$count = 0;
foreach($od->details as $odd)
{$count++;

$item_array[] = array(
	 "images" => "", 
	 "color" => "test", 
	 "reason" => "test", 
	 "descr" => "test", 
	 "ean" => "test", 
	 "imei" => "test", 
	 "brand" => "test", 
	 "pcat" => "test", 
	 "si" => "test" 
  );
}


$item_array = array();

foreach($od->details as $odd){
	$product_weight = $odd->product_weight;
	if(empty($product_weight)){$product_weight='0.100';}
	
	$item_array[] = array(
		"images"=> 'test',
		"color"=> 'test',
		"reason"=> 'test',
		"descr"=> $odd->product_name .', '.$odd->combi,
		"ean"=> $odd->hsn_code,
		"imei"=> $odd->combi_ref_code,
		"brand"=> $odd->manufacturer_name,
		"pcat"=> 'test',
		"si"=> 'test'
	);
}


$payment_mode = 'Prepaid';
$cod_amount = 0;
if($od->is_cod==1)
{
	$payment_mode = 'COD';
	$cod_amount = number_format((float)$od->total, 2, '.', '');
}

$destination_pincode = $od->d_zipcode; // Mandatory
$vendor_address = 'SHOP NO 4,5 THE DENTIST SHOP DEOL NAGAR JALANDHAR , Jalandhar, PUNJAB ,India 144003';
$vendor_city = 'Jalandhar';
$vendor_state = 'Punjab';
$vendor_country = 'India';
$vendor_name = 'The Dentist Shop';
$vendor_phone = '8054732811';
$vendor_pin = '144003';
$vendor_gst = '03AAOFT2230M1Z4';
$order_reff_number = $od->order_reff_number = time(); # client order number
$docket_api_data  = array(
	"shipments"=>
	 array(array(
	 	"name"=> $od->d_name, # consignee
		"add"=> $od->d_address,
		"city" => $od->d_city_name, 
		"state" => $od->d_state_name,
		"country" => $od->d_country_name,
		"address_type"=> "home",
		"phone"=> $od->d_number,
		"payment_mode"=> $payment_mode,
		"pin"=> $od->d_zipcode,
		"order"=> $od->order_reff_number, # client order number
		"shipment_width" => $box_b,
		 //"order"=> 'BEO'.time(), # client order number  number_format((float)$number, 2, '.', '');
		 "consignee_gst_amount" => number_format((float)$od->total_gst, 2, '.', ''), 
            "integrated_gst_amount" => number_format((float)$od->total_gst, 2, '.', ''), 
            "ewbn" => "", 
            "consignee_gst_tin" => "", 
            "client_gst_tin" => "", 
            "hsn_code" => "0000", 
            "gst_cess_amount" => "", 
            "client" => "THEDENTIST FRANCHISE", 
            "tax_value" => number_format((float)$od->total_gst, 2, '.', ''), 
            "commodity_value" => number_format((float)$od->total, 2, '.', ''), 
            "weight" => $total_product_weight." gm", 
            "document_number" => "", 
            "od_distance" => "", 
            "sales_tax_form_ack_no" => "", 
            "document_type" => "", 
            
            /*"qc" => array(
               "item" => $item_array
            ),*/ 
		 "product_quantity" => $od->total_prod, 
            "category_of_goods" => "0", 
            "cod_amount" => $cod_amount, 
            "document_date" => "", 
            "taxable_amount" => number_format((float)($od->total - $od->total_gst), 2, '.', ''), 
            "products_desc" => "Dental Products", 
            "dangerous_good" => "", 
            "waybill" => "", 
            "consignee_tin" => "", 
            "order_date" => $od->added_on, 
            "total_amount" => $od->total, 
			"extra_parameters" => array(
                        "return_reason" => "" 
                     ), 
            "supply_sub_type" => "", 
            "plastic_packaging" => "", 
            "quantity" => 1,
			
			"return_name" => '', 
            "return_pin" => '', 
            "return_add" => '', 
			"return_city" => '',
			"return_state" => '', 
            "return_country" => '',
            "return_phone" => '',
			
/*			"return_name" => $vendor_name, 
            "return_pin" => $vendor_pin, 
            "return_add" => $vendor_address, 
			"return_city" => $vendor_city,
			"return_state" => $vendor_state, 
            "return_country" => $vendor_country,
            "return_phone" => $vendor_phone,*/
			
			"seller_name" => '',
			"seller_tin" => "", 
            "seller_gst_amount" => '', 
            "seller_inv" => $od->order_reff_number, 
			"seller_cst" => "", 
			"seller_add" => '',
			"seller_gst_tin" => '', 
			
			/*"seller_name" => $vendor_name,
			"seller_tin" => "", 
            "seller_gst_amount" => number_format((float)$od->total_gst, 2, '.', ''), 
            "seller_inv" => $od->order_reff_number, 
			"seller_cst" => "", 
			"seller_add" => $vendor_address,
			"seller_gst_tin" => $vendor_gst, */
         ) 
      ),  
		 
	"pickup_location" =>array(
		"name"=> "THEDENTIST FRANCHISE",
		"city"=> "Jalandhar",
		"pin"=> "144003",
		"country"=> "India",
		"phone"=> "8054732811",
	  "add"=> "SHOP NO 4,5 THE DENTIST SHOP DEOL NAGAR JALANDHAR , Jalandhar, PUNJAB ,India 144003",
	)
	
	
);


//$docket_api_data = json_encode($docket_api_data);
$order_api_data_json = json_encode($docket_api_data);
$request_url = __delivery_api__.'generateDocketNo.php';
//echo $request_url;
//$post_data="&pickup_pincode=".$pickup_pincode;
$post_data['destination_pincode']=$destination_pincode;
$post_data['docket_api_data']=$docket_api_data;
$post = curl_init();
curl_setopt($post, CURLOPT_URL, $request_url);
curl_setopt($post, CURLOPT_POST,TRUE);
curl_setopt($post, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt( $post, CURLOPT_HTTPHEADER, array('Authentication:'.__dl_token__));
curl_setopt($post, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($post);
curl_close($post);
//$result = json_decode($response, true);
$result_json = $result = $response;
$result_obj = json_decode($result);
/*echo "<pre>";
echo "<h3>Payload Data</h3>";
print_r($post_data);
echo "<h3>Result Data</h3>";
print_r($result_obj);
echo "</pre>";*/

//$docket_api_data = json_decode($docket_api_data);
//echo "<pre>";
//echo "<h3>response Data</h3>";
//print_r($response);

//echo "<h3>Posted Data</h3>";
//print_r($docket_api_data);
//echo "<h3>Order Data</h3>";
//print_r($od);
//echo "</pre>";
echo 0;
if(!empty($result_obj->response))
{
	$delhivery_response = json_decode($result_obj->response);
	if($delhivery_response->success)
	{echo 2;
		if(!empty($delhivery_response->packages))
		{echo 3;
			$awb_obj = $delhivery_response->packages[0];
			$docket_number = $awb_obj->waybill;
			$refnum = $awb_obj->refnum;
			$courier_name = 'Delhivery';
			$courier_order_id = 1;
			$courier_shipment_id = 1;
			$shipping_rate = 0;
			
			
			$add_new_order_docket_history_params = array('orders_id'=>$od->orders_id , 'docket_no'=>$docket_number ,'courier_name'=>$courier_name, 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'posted_data'=>$order_api_data_json, 'response'=>$result_json , 'post_json'=>$order_api_data_json , 'updated_by'=>$this->session->userdata("sess_user_id") , 'courier_order_id'=>$courier_order_id , 'courier_shipment_id'=>$courier_shipment_id);
			
			$orders_docket_history_id = $_sosl->add_new_order_docket_history($add_new_order_docket_history_params);
			
			$add_new_order_history_params = array('orders_id'=>$od->orders_id , 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'remarks'=>'' , 'updated_by'=>$this->session->userdata("sess_user_id"));
			$orders_history_id = $_sosl->add_new_order_history($add_new_order_history_params);
			
			$courier_docket_no_data['caption'] = 'To Customer';
			$courier_docket_no_data['orders_id'] = $od->orders_id;
			$courier_docket_no_data['docket_no'] = $docket_number;
			$courier_docket_no_data['courier_order_id'] = $courier_order_id;
			$courier_docket_no_data['courier_shipment_id'] = $courier_shipment_id;
			$courier_docket_no_data['delivery_chalan_no'] = '';
			$courier_docket_no_data['order_status_id'] = 1;
			$courier_docket_no_data['courier_name'] = $courier_name;
			$courier_docket_no_data['shipping_price'] = $shipping_rate;
			$courier_docket_no_data['added_by'] = $this->session->userdata("sess_user_id");
			$courier_docket_no_data['added_on'] = date("Y-m-d H:i:s");
			$courier_docket_no_data['status'] = 1;
			
			$courier_docket_no_id = $this->Common_Model->add_operation(array('table'=>'courier_docket_no' , 'data'=>$courier_docket_no_data));
			
			
			$h_description = "Docket Number Assign With $courier_name Docket No. Is : $docket_number";
			$this->Common_Model->update_operation(array('table'=>'orders_history' , 'data'=>array('description'=>$h_description) , 'condition'=>"(orders_history_id = $orders_history_id)"));
			
			if(empty($shipping_rate))
			{ $shipping_rate = ''; }
			
			$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>array('docket_no'=>$docket_number , 'courier_name'=>$courier_name , 'courier_order_id'=>$courier_order_id , 'courier_shipment_id'=>$courier_shipment_id , 'courier_status_id'=>1 , 'is_courier_txn'=>1  , 'shipping_price'=>$shipping_rate , 'delivery_challan_no'=>$refnum , 'order_reff_number'=>$order_reff_number ) , 'condition'=>"(orders_id = $od->orders_id )"));
			//echo $this->db->last_query();
			$is_docket_assign = true;
			$this->session->set_flashdata('message', "<div class=' alert alert-success'>Docket No. Assigned Successfully</div>");
			echo "<script>window.location.reload();location.reload();</script>";
		}
		else{
			echo "<h1>RESPONSE</h1>";
			echo "<pre>";
			print_r($result_obj);
			echo "</pre>";
		}
	}
	else{
		echo "<h1>RESPONSE</h1>";
		echo "<pre>";
		print_r($result_obj);
		echo "</pre>";
	}
}
else{
	echo "<h1>RESPONSE</h1>";
	echo "<pre>";
	print_r($result_obj);
	echo "</pre>";
}


exit;

?>
      
 <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Dispatch Order Through Shipyaari</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
             <tr>
                <th>Sl No.</th>
                <th>Courier Name</th>
                <th>Service Name</th>
                <th>User Weight</th>
                <th>Price</th>
                <th>COD Price</th>
                <th>Charges Description</th>
                <th>Zone</th>
                <th>subtotal</th>
                <th>Tax</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
        <?
        $count = 0;
        foreach($result as $r)
        {
            $count++;
            if(!empty($result['status']))
            {
                echo '<td colspan="15">'.$result['status'].'</td>';
            }
            else{
             ?>
            <tr>
                <td><?=$count?>.</td>
                <td><?=$r['courier_name']?></td>
                <td><?=$r['service_name']?></td>
                <td>
                <span class="" data-placement="right" role="button"  data-popover-content="#popover_weight_description<?=$count?>" data-toggle="popover" tabindex="0"><em><?=$r['user_weight']?></em></span>
                <div class="hidden" id="popover_weight_description<?=$count?>">
                  <div class="popover-heading">
                    Weight Description
                  </div>
                
                  <div class="popover-body" >
                   <table id="example2" class="table table-bordered table-hover">
                   <tbody>
                        <tr><td>User Weight</th><td><?=$r['user_weight']?></td></tr>
                        <tr><td>Pricing Weight</td><td><?=$r['pricing_weight']?></td></tr>
                        <tr><td>Compare Weight</td><td><?=$r['compare_weight']?></td></tr>
                        <tr><td>Actual Weight</td><td><?=$r['actual_weight']?></td></tr>
                   </tbody>
                   </table>
                </div>
               </div> 
                </td>
                <td><?=$r['price']?></td>
                <td>
                <span class="" data-placement="right" role="button"  data-popover-content="#popover_cod_description<?=$count?>" data-toggle="popover" tabindex="0"><em><?=$r['cod_price']?></em></span>
                <div class="hidden" id="popover_cod_description<?=$count?>">
                  <div class="popover-heading">
                    COD Price Description
                  </div>
                
                  <div class="popover-body" >
                   <table id="example2" class="table table-bordered table-hover">
                   <tbody>
                        <tr><td>COD Price</th><td><?=$r['cod_price']?></td></tr>
                        <tr><td>COD Percentage</td><td><?=$r['cod_percentage']?></td></tr>
                        <tr><td>COD Parcentage</td><td><?=$r['cod_parcentage']?></td></tr>
                        <tr><td>Total COD Amount</td><td><?=$r['total_cod_amount']?></td></tr>
                   </tbody>
                   </table>
                </div>
               </div> 
                
                </td>
                <td>
                <span class="" data-placement="right" role="button"  data-popover-content="#popover_other_charges_description<?=$count?>" data-toggle="popover" tabindex="0"><em>View</em></span>
                <div class="hidden" id="popover_other_charges_description<?=$count?>">
                  <div class="popover-heading">
                    All Charges Description
                  </div>
                
                  <div class="popover-body" >
                   <table id="example2" class="table table-bordered table-hover">
                   <tbody>
                        <tr><td>Minimum Price</th><td><?=$r['minimum_price']?></td></tr>
                        <tr><td>remaining Price</td><td><?=$r['remaining_price']?></td></tr>
                        <tr><td>Delivery Charge</td><td><?=$r['delivery_charge']?></td></tr>
                        <tr><td>Fuel Charge</td><td><?=$r['fuel_charge']?></td></tr>
                        <tr><td>Total Insurance</td><td><?=$r['total_insurance']?></td></tr>
                        <tr><td>Insurance Percentage</td><td><?=$r['insurance_percentage']?></td></tr>
                        <tr><td>Fual Parcentage</td><td><?=$r['fual_parcentage']?></td></tr>
                  </tbody>
                   </table>
                </div>
               </div> 
                
                </td>
                <td><?=$r['zone']?></td>
                <td><?=$r['subtotal']?></td>
                <td><?=$r['tax']?></td>
                <td><?=$r['total']?></td>
                <td>
                <button type="button" class="btn btn-primary ShippingAPIBtn" onclick="bookDocket(<?=$od->orders_id?> , <?=$r['service_id']?> , <?=$r['partner_id']?>)" id="load1" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">Book</button>
                
                </td>
            </tr>
      <? }} ?>
     
        </tbody>
    </table>
      </div>
    </div>
  </div>
</div>
<div id="ShippingServiceApiData"></div>
<script>

					  
	//code for popover
	$("[data-toggle=popover]").popover({
		html : true,
		content: function() {
		  var content = $(this).attr("data-popover-content");
		  return $(content).children(".popover-body").html();
		},
		title: function() {
		  var title = $(this).attr("data-popover-content");
		  return $(title).children(".popover-heading").html();
		}
	});
	
	$('body').on('click', function (e) {
		//did not click a popover toggle, or icon in popover toggle, or popover
		if ($(e.target).data('toggle') !== 'popover' && $(e.target).parents('[data-toggle="popover"]').length === 0
			&& $(e.target).parents('.popover.in').length === 0) {
			(($('[data-toggle="popover"]').popover('hide').data('bs.popover') || {}).inState || {}).click = false;
		}
	});


function bookDocket(order_id , service_id , partner_id)
{
	var insurance = <?=$_POST['insurance']?>;
	var total_product_weight_in_kg = <?=$total_product_weight_in_kg?>;
	var box_l = <?=$_POST['box_l']?>;
	var box_b = <?=$_POST['box_b']?>;
	var box_h = <?=$_POST['box_h']?>;

	if(confirm("Do You Really want to continue?"))
    {
		var $this = $('.ShippingAPIBtn');
	 	$this.button('loading');
		$.ajax({
			type: "POST",
			url:'<?=MAINSITE?>SecureRegions/orders/ShippingServiceApi/',
			data : { 'orders_id' : order_id , 'insurance' : insurance , 'total_package_weight' : total_product_weight_in_kg , 'box_l' : box_l, 'box_b' : box_b , 'box_h' : box_h  , 'service_id' : service_id  , 'partner_id' : partner_id },
			success : function(result){
				$this.button('reset');
				$('#ShippingServiceApiData').html(result);
			}
		});
    }
}

</script>
