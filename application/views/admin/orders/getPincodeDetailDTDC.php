<?

$od = $orders_detail[0];

$this->load->library('DTDC_Lib'); 
	$dtdc_Lib = new DTDC_Lib;
	$dtdc_service_type = $dtdc_Lib->getServiceTypes($od->d_zipcode);
	//echo $dtdc_service_type;
	$result = $json = json_decode($dtdc_service_type, true);
	if(!empty($result['message']) && $result['message']=='SUCCESS')
		{
			$is_delivery_msg = '<span style="color:#14c614">Delivery Available</span>';
			$domestic_shipping_type = 1;
			echo "<script>$('.is_dtdc_service_available').show();</script>";
		}
		else
		{
			$is_delivery_msg = '<span style="color:#F00">Delivery Not Available</span>';
		}

?>

      
 <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Pincode Detail <?=$is_delivery_msg?></a>
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
			if(!empty($result['data']))
			{
        $count = 0;
			$pdata = $result['data'];
			foreach($pdata as $dc)
			{
				{
					$count++;
             ?>
            <tr>
                <td><?=$count?>.</td>
                <td>-</td>
                <td>
				<? 
					echo $dc;
				?>
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
