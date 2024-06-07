<?
include( APPPATH."third_party/shiprocket/auth.php");
//include( APPPATH."third_party/shiprocket/auth.php");
$od = $orders_detail[0];
//echo "<h1>Product Data</h1>";
//print_r($od);
//print_r($auth_response);
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



$delivery_postcode = $od->d_zipcode;
if($od->is_cod==1)
{
	$cod=1;
}
else
{
	$cod=0;
}

$headers = array(
"Content-type : application/json",
"Authorization: Bearer $token",
);

$request_url = 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/?pickup_postcode=560078&delivery_postcode='.$delivery_postcode.'&is_return=0&weight='.$total_product_weight_in_kg.'&cod='.$cod.'&declared_value='.$od->total.'';
//echo "<h1>URL</h1>";
//echo $request_url;
//echo "<h1>Headers</h1>";
//print_r( $headers);

$post = curl_init();
curl_setopt($post, CURLOPT_URL, $request_url);
curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($post, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($post);
curl_close($post);
$response = json_decode($response);
/*echo "<pre>";
echo "<h1>RESPONSE</h1>";
echo "<xmp>";
print_r($response);
echo "</xmp>";
echo "</pre>";
*/


?>

<? if(!empty($response)){ 

if(!empty($response->status))
{
	if($response->status==404)
	{
		?>
        <div class="alert alert-warning alert-dismissible"><i class="icon fas fa-ban"></i><?=$response->message?></div>
        <?
		exit;
	}
}

?>


 <div class="panel-group mt-3" id="accordion">
  <div class="card card-primary panel panel-default">
    <div class="card-header panel-heading">
      <h4 class="card-title panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" style="border-top: none !important">Dispatch Order Through Shiprocket</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in show">
      <div class="panel-body">
      <table id="example" width="100%" class="table table-bordered table-hover">
        <thead>
            <?php /*?><tr>
                <th colspan="15"><strong>Courier Company Options</strong></th>
            </tr><?php */?>
            <tr>
                <th>Sl No.</th>
                <th>Courier Name</th>
                <th>Estimated Delivery</th>
                <th>COD Price</th>
                <th>Freight Charge</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
        <?
        $count = 0;
        foreach($response->data->available_courier_companies as $r)
        {
            $count++;
          
             ?>
            <tr>
                <td><?=$count?>.</td>
                <td><?=$r->courier_name?></td>
                <td><?=$r->etd?> ( <?=$r->estimated_delivery_days?> Days )</td>
               
                <td><?=$r->cod_charges?></td>
                
                <td><?=$r->freight_charge?></td>
                <td><?=$r->rate?></td>
                <td><button type="button" onclick="assignShiprocketOrderAWB(<?=$r->courier_company_id?> , '<?=$r->rate?>')" class="btn btn-primary assignShiprocketOrderAWBBTN">Assign Docket</button></td>
            </tr>
      <? } ?>
     
        </tbody>
    </table>
      </div>
    </div>
  </div>
</div>
<!--<div id="ShippingServiceApiData">
</div>-->
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

$('#total_package_weight').prop('readonly', true);
$('#box_l').prop('readonly', true);
$('#box_b').prop('readonly', true);
$('#box_h').prop('readonly', true);
$('#courierShippingButton').hide();
ArrangeTable();


</script>

<? }else{ ?>

<div class="alert alert-warning alert-dismissible"><i class="icon fas fa-ban"></i> No Service found.</div>

<? } ?>

