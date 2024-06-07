<?
$this->load->library('bluedart');
$obj_bluedart = new bluedart();
$od = $orders_detail[0];
$destination_pincode = $od->d_zipcode; // Mandatory
$GetServicesforPincode = $obj_bluedart->funcGetServicesforPincode($destination_pincode);
//$GetServicesforPincode = $obj_bluedart->funcGetServicesforPincode(125001);
//echo "<pre>";print_r($GetServicesforPincode);echo "</pre>";
$is_bluedart_service = false;
if(!empty($GetServicesforPincode))
{
	if(!empty($GetServicesforPincode->GetServicesforPincodeResult->ApexInbound))
	{
		if($GetServicesforPincode->GetServicesforPincodeResult->ApexInbound == 'yes' || $GetServicesforPincode->GetServicesforPincodeResult->ApexInbound == 'Yes')
		{
			$is_bluedart_service = true;
		}
	}
}
//echo $is_bluedart_service;
//exit;
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

        <?
		if($is_bluedart_service)
		{
			
        $count = 0;
			
				
             ?>
           <div class="alert alert-success"><strong>Success!</strong> Bluedart Delivery Available</div>
           <script>$('.docket_btn').show()</script> 
		<? 
		}
		else{?>
        
        <div class="alert alert-danger"><strong>Success!</strong> Bluedart Delivery Not Available</div>
<script>$('.docket_btn').hide()</script> 
        <? } ?>
		
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

<?php /*?>
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
<?php */?>
</script>
