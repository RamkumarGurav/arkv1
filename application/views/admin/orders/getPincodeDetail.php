<?

$od = $orders_detail[0];

?>
<?php
$destination_pincode = $od->d_zipcode; // Mandatory
//$destination_pincode = 144009; 

$request_url = __delivery_api__.'pincode_detail.php';
//echo $request_url;
//$post_data="&pickup_pincode=".$pickup_pincode;
$post_data['destination_pincode']=$destination_pincode;
//print_r($post_data);
$post = curl_init();
curl_setopt($post, CURLOPT_URL, $request_url);
curl_setopt($post, CURLOPT_POST,1);
curl_setopt($post, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($post);
$error_msg = curl_error($post);
curl_close($post);
$result = json_decode($response, true);

echo $error_msg;
/*echo $response;
echo $request_url;
echo "<pre>";
//echo "<h3>Order Data</h3>";
//print_r($od);
echo "<h3>Posted Data</h3>";
print_r($post_data);
echo "<h3>Result</h3>";
print_r($result);
echo "<h3>Response</h3>";
print_r($response);
echo "</pre>";*/
/*echo "<pre>";
print_r($result);
echo "</pre>";*/

?>
      
 <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Pincode Detail</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
             <tr>
                <th>Sl No.</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        
        <?
		if(!empty($result))
		{
			if(!empty($result['delivery_codes']))
			{
        $count = 0;
			$pdata = $result['delivery_codes'];
			foreach($pdata as $dc)
			{
				$r = $dc['postal_code'];
				foreach($r as $key=>$value)
				{
					$count++;
					$key = str_replace('_' , ' ' , $key);
					$key = ucwords($key);
             ?>
            <tr>
                <td><?=$count?>.</td>
                <td><?=$key?></td>
                <td>
				<? if(is_array($value)){
					$shop = $value;
					foreach($value as $key1=>$value1)
					{
						echo '<table id="example2" class="table table-bordered table-hover">';
						foreach($value1 as $key2=>$value2)
						{
					?>

    <tr>
      <th><?php echo $key2; ?></th>
      <td><?php echo $value2; ?></td>
    </tr>
  


					<?
					}
					echo "</table>";
					}
				}else
				{
					echo $value;
				}?>
                </td>
			</tr>
            
		<? }}}
		
		else{echo '<tr><td colspan="3">There is No delivery</td></tr>';
		}
		
		}else{echo '<tr><td colspan="3">There is No delivery</td></tr>';
		} ?>
		
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
