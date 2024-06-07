<?
$insurance = 2;
if(!empty($_POST['insurance']))
{
	$insurance = $_POST['insurance'];
}
$service = 3;

if($insurance==1) { $insurance = 'yes'; }
else { $insurance = 'no'; }

$box_l=0;
$box_b=0;
$box_h=0;

if(!empty($_POST['service_id']))
{
	$service = $_POST['service_id'];
}

if($service==1){$service_name = 'Priority';}
if($service==2){$service_name = 'standard';}
if($service==3){$service_name = 'economy';}
if($service==4){$service_name = 'economy 2kgs';}
if($service==5){$service_name = 'economy 5kgs';}
if($service==6){$service_name = 'economy 0.5kgs';}

if(!empty($_POST['box_l']))
{ $box_l = $_POST['box_l']; }

if(!empty($_POST['box_b']))
{ $box_b = $_POST['box_b']; }

if(!empty($_POST['box_h']))
{ $box_h = $_POST['box_h']; }

$partner_id='';
if(!empty($_POST['partner_id']))
{ $partner_id = $_POST['partner_id']; }

if(!empty($_POST['service_id']))
{ $service_id = $_POST['service_id']; }

$od = $orders_detail[0];
$total_product_weight = 0;
if(!empty($_POST['total_package_weight']))
{
	$total_product_weight_in_kg = round($_POST['total_package_weight'] , 3);
}
else
{
	$total_product_weight_in_kg = round($od->total_weight/1000 , 3);
}
echo "<pre>";
echo "<h1>Product Data</h1>";
print_r($od);


$avnkey="8284@5181";
$avnkey_decode = base64_encode($avnkey);
$avn="8284";
$avn_decode = base64_encode($avn);
$username="info@konteraglobal.com";
$username_decode = base64_encode($username);
$no_of_packages = 1;
$no_of_packages_decode = base64_encode($no_of_packages);


$ship_api_data = array();


$ship_api_data['from_company_name'] = 'The Dentist Shop.';
$ship_api_data['username'] = $username;
$ship_api_data['insurance'] = $insurance;
$ship_api_data['order_id'] = $od->order_number;
$ship_api_data['from_contact_number'] = '911812686811';
$ship_api_data['from_pincode'] = '144003';
$ship_api_data['from_landmark'] = '';
$ship_api_data['from_address'] = 'Shop No. 3,4,5, Deol Nagar, Near Coca Cola Agency, ';
$ship_api_data['from_address2'] = 'Jalandhar, Punjab';
$ship_api_data['to_pincode'] = $od->d_zipcode;
$ship_api_data['to_landmark'] = $od->d_address;
$ship_api_data['to_address'] = $od->d_address;
$ship_api_data['to_address2'] = $od->d_city_name;
$ship_api_data['customer_name'] = $od->d_name;
$ship_api_data['customer_email'] = $od->d_number;
$ship_api_data['customer_contact_no'] = $od->d_city_name;
$ship_api_data['ship_date'] = date('Y-m-d');
$ship_api_data['package_type'] = 'Identical';
$ship_api_data['package_content'] = 'product';
$ship_api_data['package_content_desc'] = 'test';
$ship_api_data['total_invoice_value'] = $od->total;
$ship_api_data['created_by'] = $avn;
$ship_api_data['avnkey'] = $avnkey;
$ship_api_data['payment_mode'] = 'online';
$ship_api_data['package_name'] = $service_name;
$ship_api_data['partner_id'] = $partner_id;
$ship_api_data['no_of_packages'] = 1;

$josn_arr = array();
foreach($ship_api_data as $key=>$value)
{$josn_arr[$key]=base64_encode($value);}

$josn_arr['total_price_set'] = $od->total;
$josn_arr['channel'] = "API";



echo "<h1>Shipping API Data</h1>";
print_r($ship_api_data);


/*$josn_arr = array(
"from_company_name"=>"",
"username"=>$username_decode,
"insurance"=>"bm8%3D",
"order_id"=>"T1JENUQ5NzFDRTJDQjRCNA%3D%3D",
"from_contact_number"=>"NzA1NTY4Mzg4OQ%3D%3D",
"from_pincode"=>"MTIyMDEw",
"from_landmark"=>"UGhhc2UgMyBNZXRybyBTdGF0aW9u",
"from_address"=>"RGFnYXIgQXBhcnRtZW50",
"from_address2"=>"VS0yNyAsIFBpbmsgdG93biBob3VzZSByb2Fk",
"to_pincode"=>"MTIyMDAz",
"to_landmark"=>"R3VyZ2Fvbg%3D%3D",
"to_address"=>"RGVsbWlzaCBUZWNobm9sb2dpZXM%3D",
"to_address2"=>"S2FuaGFpIHNlYyA0NQ%3D%3D",
"customer_name"=>"RHJpc2hhbg%3D%3D",
"customer_email"=>"ZHJpc2hhbi5kYW5nQGRlbG1pc2h0ZWNobm9sb2dpZXMuY29t",
"customer_contact_no"=>"ODg1MTY3ODQ0Mg%3D%3D",
"ship_date"=>"MjAxOS0xMC0wNQ%3D%3D",
"package_type"=>"SWRlbnRpY2Fs",
"package_content"=>"cHJvZHVjdA%3D%3D",
"package_content_desc"=>"dGVzdA%3D%3D",
"total_invoice_value"=>"MTg1MA%3D%3D",
"created_by"=>$avn_decode,
"avnkey"=>$avnkey_decode,
"payment_mode"=>"b25saW5l",
"package_name"=>"",
"partner_id"=>base64_encode(9),
"no_of_packages"=>$no_of_packages_decode,
"total_price_set"=>"2900",
"channel"=>"API"
);*/

$product_arr = array();
foreach($od->details as $d)
{
	$product_arr[] = (object)array(
		"name"=>$d->product_name.' - '.$d->combi,
		"total"=>"1450",
		"qty"=>$d->prod_in_cart,
		"sku"=>$d->combi_ref_code,
		"hsn"=>""
	);
}

$josn_arr['product_data']=array(
					  array(
					"package_weight"=>$total_product_weight_in_kg,
					"package_length"=>$box_l,
					"package_width"=>$box_b,
					"package_height"=>$box_h,
					"package_details"=>(object)$product_arr,
					"total"=>$od->total,
					"total_qty"=>$od->total_prod
				)
					  );

echo "<h1>Json API Data</h1>";

print_r($josn_arr);
$json = json_encode($josn_arr);
print_r($json);
$json1 = json_decode($json);
print_r($json1);
?>

<?php
echo "</pre>";
exit;
$pickup_pincode="144003"; // Mandatory
$delivery_pincode=$od->d_zipcode; // Mandatory
$weight=$total_product_weight_in_kg; // Mandatory
$paymentmode="online"; // Mandatory online or cod
$invoicevalue=$od->amount; // Mandatory
$avnkey="8284@5181"; // Mandatory client ID@parent ID
$insurance=$insurance; // optional yes or no
$service_type="normal"; // optional
$partner=""; //optional. Get all available partner
$service="standard"; //optional Priority, standard, economy, economy 2kgs,
//economy 2kgs, economy 5kgs, economy 0.5kgs,
$length=$box_l; // Mandatory
$width=$box_b; // Mandatory
$height=$box_h; // Mandatory
$request_url ='https://seller.shipyaari.com/logistic/webservice/SearchAvailability_new.php';
$post_data="&pickup_pincode=".$pickup_pincode."&delivery_pincode=".$delivery_pincode."&weight=".$weight."&paymentmode=".$paymentmode."&invoicevalue=".$invoicevalue."&avnkey=".$avnkey."&service_type=".$service_type."&partner=".$partner."&service=".$service."&length=".$length."&width=".$width."&height=".$height;
$post = curl_init();
curl_setopt($post, CURLOPT_URL, $request_url);
curl_setopt($post, CURLOPT_POST,TRUE);
curl_setopt($post, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($post, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($post);
curl_close($post);
$result = json_decode($response, true);
//echo "<pre>";
//echo "<h3>Posted Data</h3>";
//print_r($post_data);
//echo "<h3>Result</h3>";
//print_r($result);
//echo "<h3>Response</h3>";
//print_r($response);
//echo "</pre>";
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
                <th colspan="15"><strong>Ordered Product In Detail</strong></th>
            </tr>
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
                <td><button onclick="bookDocket(<?=$od->orders_id?> , <?=$r['service_id']?> , <?=$r['partner_id']?>)" class="btn btn-primary">Book</button></td>
            </tr>
      <? }} ?>
     
        </tbody>
    </table>
      </div>
    </div>
  </div>
</div>
<div id="ShippingServiceApiData">
</div>
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




</script>
