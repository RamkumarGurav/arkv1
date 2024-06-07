<?
$od = $orders_detail[0];
?>
<?php



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://track.delhivery.com/api/p/packing_slip?wbns='.$od->docket_no);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_POST,TRUE);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Authorization:Token ".__dl_token__ , "Content-Type:application/json"));
//curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
$response_json = curl_exec($ch);
//echo $response_json;




if(!empty($response_json))
{
	$response_obj = json_decode($response_json);
	/*echo "<pre>";
	print_r($response_obj);
	echo "</pre>";
	curl_close($ch);*/
	
	$add_new_order_history_params = array('orders_id'=>$od->orders_id , 'order_status_id'=>7 , 'caption'=>"Generate Packing Slip." , 'remarks'=>'' , 'updated_by'=>$this->session->userdata("sess_user_id"));
	$orders_history_id = $_sosl->add_new_order_history($add_new_order_history_params);
	
	$courier_packing_slip_data['docket_no'] = $od->docket_no;
	$courier_packing_slip_data['orders_id'] = $od->orders_id;
	$courier_packing_slip_data['packing_slip_json'] = $response_json;

	$courier_packing_slip_id = $this->Common_Model->add_operation(array('table'=>'courier_packing_slip' , 'data'=>$courier_packing_slip_data));
	
	$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>array('is_packing_slip_generated'=>1) , 'condition'=>"(orders_id = $od->orders_id )"));
	//echo $this->db->last_query();
	$is_docket_assign = true;
	$this->session->set_flashdata('message', "<div class=' alert alert-success'>Packing Slip Generated.</div>");
	echo "<script>window.location.reload();location.reload();</script>";
		
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
