<? $o = $orders[0];
/*echo "<pre>";
print_r($o);
echo "</pre>";*/

 ?>
<nav  class="breadcrumb ">
	<ol>
    	<li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span><i class="fa fa-angle-right"></i></span></li>
        <li><a href="<?=base_url(__orderHistory__)?>">My Orders</a></li>
			<li><span><i class="fa fa-angle-right"></i></span></li>
			<li><?=$o->order_number?></li>
	</ol>
</nav>
      <div class="mt-5">
      <div class="container">
         <div class="row">
         	<? $this->load->view('template/left-menu' , $this->data); ?>

            <div class="col-md-9">
               <h4 class="form_headr1">Order Details</h4>
               <div class="empty1 mb-5">
                  <div class=" m-2">
                 <div class="col-sm-12 col-lg-12">


            <div class="user-item">
              <button type="button" onclick="trackShiprocketOrder()" class="btn btn-primary trackShiprocketOrderBTN">Track Order</button>
              <div id="shipRicketResponseDiv">

              </div>
            	<div class="cartfl_list">
					<h4 class="about_sbhead ordercont"><span>My Order Details <a class="aClick_3">(<?=$o->order_number?>)</a></span>
					  <div>

                                        <a href="<?=base_url().__orderInvoice__.'/'.$o->orders_id?>" class="btn2 aClick_3" target="_blank"><i class="fa fa-file-text-o"></i>  Invoice</a>
                    </div></h4>

<?
$order_on = '';
$is_processed = false;
$processed_on = '';
$is_shipped = false;
$shipped_on = '';
$is_delivered = false;
$delivered_on = '';


foreach($o->history as $h)
{
	if($h->order_status_id ==1)
	{
		$order_on = date('d M y' , strtotime($h->updated_on));
	}

	if($h->order_status_id ==2)
	{
		$is_processed = true;
		$processed_on = date('d M y' , strtotime($h->updated_on));
	}

	if($h->order_status_id ==3)
	{
		$is_shipped = true;
		$shipped_on = date('d M y' , strtotime($h->updated_on));
	}

	if($h->order_status_id ==4)
	{
		$is_delivered = true;
		$delivered_on = date('d M y' , strtotime($h->updated_on));
	}
}


?>
                    	<div class="user_track">
   <form>
      <div class="o_details">
         <div class="o_item">
            <div class="bazooka_tracking wrap">
               <div class="bazooka">
                  <ul>
                     <li class="order_confirm active">
                        <span>
                        <b> Order Placed</b>
                        <a href="javascript:void(0);">
                        <i></i>
                        </a>
                        <b><?=$order_on?></b>
                        </span>
                     </li>
                     <li class="order_processing <? if($is_processed){echo 'active';}?>">
                        <span>
                        <b>Order Processing</b>
                        <a href="javascript:void(0);">
                        <i></i>
                        </a>
                        <b><?=$processed_on?></b>
                        </span>
                     </li>
                     <? if($o->is_self_pickup==2){}else{ ?>
                     <li class="order_shipped  <? if($is_shipped){echo 'active';}?>">
                        <span>
                        <b>In Transit</b>
                        <a href="javascript:void(0);">
                        <i></i>
                        </a>
                        <b><?=$shipped_on?></b>
                        </span>
                     </li>
                     <? } ?>
                     <li class="order_delivered  <? if($is_delivered){echo 'active';}?>">
                        <span>
                        <b>Delivered </b>
                        <a href="javascript:void(0);">
                        <i></i>
                        </a>
                        <b><?=$delivered_on?></b>
                        </span>
                     </li>
                  </ul>
               </div>
            </div>
            <!--                // end bazooka //             -->
         </div>
      </div>
   </form>
</div>

                    	<?php /*?><div class="user_track">
   <form autocomplete="off">
      <div class="o_details">
         <div class="o_item">
            <div class="bazooka_tracking wrap">
               <div class="bazooka">
                  <ul>
                     <li class="order_confirm active">
                        <span>
                        <b> Order Placed</b>
                        <a href="javascript:void(0);" class="aClick_3">
                        <i></i>
                        </a>
                        <b>06 Oct 21</b>
                        </span>
                     </li>
                     <li class="order_processing ">
                        <span>
                        <b>Order Processing</b>
                        <a href="javascript:void(0);" class="aClick_3">
                        <i></i>
                        </a>
                        <b></b>
                        </span>
                     </li>
                                          <li class="order_delivered  ">
                        <span>
                        <b>Delivered </b>
                        <a href="javascript:void(0);" class="aClick_3">
                        <i></i>
                        </a>
                        <b></b>
                        </span>
                     </li>
                  </ul>
               </div>
            </div>
            <!--                // end bazooka //             -->
         </div>
      </div>
   </form>
</div><?php */?>
</div>
<div class="ordr_lister">
							<div class="cart_prdtw">
                                <div class="row">
                                <? if($o->is_self_pickup==2){ ?>
                                    <div class="col-lg-4 col-md-6   orderDetail">
                                                                            <h3 class="table_h5para"><strong><span class="table_h5pspan">Pickup Address</span></strong></h3>
                                        <h5 class="ceckout_name"> <strong><?=_project_name_?></strong></h5>
                                        <p class="ceckout_adrs"><?=_project_address_?></p>
                                        <p class="ceckout_adrs"> <strong><?=_project_contact_?></strong></p>
                                                                        </div>
                                <? } ?>
                                    <div class="col-lg-4 col-md-6  orderDetail">
                                        <h5 class="table_h5para"><strong><span class="table_h5pspan">Billing Address</span></strong></h5>
                                        <p><strong><?=$o->d_name?></strong><br><?=$o->b_number?><br><?=$o->b_address?>,<br><?=$o->b_city_name?> - <?=$o->b_zipcode?><br><?=$o->b_state_name?><br><?=$o->b_country_name?></p>
                                    </div>
                                     <div class="col-lg-4 col-md-6  orderDetail">
                                        <h5 class="table_h5para"><strong><span class="table_h5pspan">Delivery Address</span></strong></h5>
                                        <p><strong><?=$o->d_name?></strong><br><?=$o->d_number?><br><?=$o->d_address?>,<br><?=$o->d_city_name?> - <?=$o->d_zipcode?><br><?=$o->d_state_name?><br><?=$o->d_country_name?></p>
                                    </div>
                                    <div class="col-lg-4 col-md-6  orderDetail liketable">
                                        <h5 class="table_h5para"><strong><span class="table_h5pspan">Payment Detail</span></strong></h5>
                                                                                <p><strong>Txn Id</strong> <span>: <?=$o->txnid?></span></p>
                                                                                <?php if(!empty($o->mode)) { ?><p><strong>Payment Mode</strong> <span>: <?=$o->mode?></span></p><?php } ?>
                                                                                <p><strong>Order Id</strong> <span>: <?=$o->order_number?></span></p>
                                                                                <p><strong>Order On</strong> <span>: <? echo date('d M y H:i:s' , strtotime($o->added_on)) ?></span></p>

                                    </div>
                                                                </div>
							</div>
						</div>
<?
$ordered_product = array();
foreach($o->details as $od){
	$is_exist = 0;
	$index = 0;
	if(!empty($ordered_product))
	{
		foreach($ordered_product as $key=>$op)
		{
			if($od->category_id == $key)
			{
				$index = $key;
				$is_exist = 1;
			}
		}
	}

	if($is_exist==1)
	{
		$ordered_product[$index]['data'][] = $od;
	}
	else
	{
		$ordered_product[$od->category_id]['category_name'] = $od->category_name;
		$ordered_product[$od->category_id]['category_id'] = $od->category_id;
		$ordered_product[$od->category_id]['data'][] = $od;
	}
}
//echo "<pre>";print_r($ordered_product);echo "</pre>";

$total_sub_total = 0;
$total_acctual_total = 0;
$total_delivery = 0;
$total_coupon_dis = 0;
?>

						<h4 class="about_sbhead">Product List</h4>
						<div class="prodictOrderList">
                        <div class="prodictOrderListRow RowHead ">
                        	<div class="prodictOrderListCell"> # </div>
                            <div class="prodictOrderListCell"> ITEM DESCRIPTION </div>
                            <div class="prodictOrderListCell"> UNIT PRICE   </div>
                            <div class="prodictOrderListCell"> QUANTITY  </div>
                            <div class="prodictOrderListCell"> SUBTOTAL </div>
                            <div class="prodictOrderListCell"> SAVINGS  </div>
                        </div>

                    	<? foreach($ordered_product as $op){ ?>

                        <div class="prodictOrderListRow RowTitle ">
                        	<div class="prodictOrderListCell sm-none"></div>
                        	<div class="prodictOrderListCell" style="width: 100% !important"><a ><?=$op['category_name']?></a> </div>

                            <?


							$cat_qty = 0;
							$cat_sub_total = 0;
							$cat_acctual_price = 0;
							foreach($op['data'] as $da)
							{
								$cat_sub_total += round(($da->final_price * $da->prod_in_cart) , 2);
								$cat_acctual_price += round(($da->prod_in_cart * $da->price) , 2);
								$cat_qty += $da->prod_in_cart;
							}
							$total_sub_total += $cat_sub_total;
							$total_acctual_total += $cat_acctual_price;
							?>

                            <div class="prodictOrderListCell sm-none" data-title="Total"> </div>
                            <div class="prodictOrderListCell sm-none"><?=$cat_qty?></div>
                            <div class="prodictOrderListCell" data-title="Total">&nbsp; <?=$o->symbol?> <?=$cat_sub_total?></div>
                            <div class="prodictOrderListCell" data-title="saved">&nbsp; <?=$o->symbol?> <?=($cat_acctual_price - $cat_sub_total)?></div>
                        </div>
                        <?
						$r_count = 0;
						foreach($op['data'] as $da)
						{$r_count++;
						?>
                        <div class="prodictOrderListRow ">
                        	<div class="prodictOrderListCell countsec"> <?=$r_count?>. </div>
                            <div class="prodictOrderListCell prdtDesc">
                            <p class="imgdesc">
                            <?

							$image_link = base_url().'assets/front/images/noimg.png';
							if(!empty($da->product_image_name))
							{
								$image_link = _uploaded_files_.'product/small/'.$da->product_image_name;
							}
							?>
                            	<img src="<?=$image_link?>">
                            <strong><a ><?=$da->brand_name?></a></strong>
                            <a><?=$da->product_name?></a>
                            <a><?=$da->combi?></a>
                            </p>

                            </div>
                            <div class="prodictOrderListCell qtysec" data-title="Unit price"> <?=$o->symbol?> <?=$da->final_price?> </div>
                            <div class="prodictOrderListCell qtycart"  data-title="Qty"> <?=$da->prod_in_cart?>  </div>
                            <div class="prodictOrderListCell sbbtotalsec"  data-title="Sub total"> <?=$o->symbol?> <?=$da->total?> </div>
                            <div class="prodictOrderListCell totalsec" data-title="saving"> <?=$o->symbol?>&nbsp;<?=round((($da->prod_in_cart * $da->price) - $da->total) , 2)?>  </div>
                        </div>
                        <? } ?>


                    <? } ?>

                                        	</div>

                                        	<div class="prodictOrderSaving">
                        	<ul class="prodictOrderAmt">
                            	<li><span>Net Amount</span><span>:</span><span><?=$o->symbol?> <?=$o->sub_total?></span></li>
                                <li><span>Tax</span><span>:</span><span><?=$o->symbol?> <?=$o->total_gst?></span></li>
                                <li><span>Subtotal</span><span>:</span><span><?=$o->symbol?> <?=$o->sub_total + $o->total_gst?></span></li>
                                <li><span>Delivery Charges</span><span>:</span><span><?=$o->symbol?> <?=$o->delivery_charges?></span></li>

                                <? if($o->shipping_discount>0){ ?><li><span>Shipping Discount</span><span>:</span><span>- <?=$o->symbol?> <?=$o->shipping_discount?></span></li><? } ?>
                                <? if($o->cod_charges>0){ ?><li><span>COD Charges</span><span>:</span><span><?=$o->symbol?> <?=$o->cod_charges?></span></li><? } ?>

                                <? if($o->total_packing_charges>0){ ?><li><span>Packing Charges</span><span>:</span><span><?=$o->symbol?> <?=$o->total_packing_charges?></span></li><? } ?>

                                <li><span> Discount</span><span>:</span><span><?=$o->symbol?> <?=round(($total_acctual_total - $total_sub_total) , 2)?></span></li>
                                <li><span style="padding:5px;"></span></li>
                                <li class="last-child"><span>TOTAL</span><span>:</span><span><?=$o->symbol?> <?=$o->total?></span></li>
                            </ul>
                            <div class="savingIcon">
                            	<img src="<?=base_url().'assets/front/images/saving.jpg'?>" class="img-responsive">
                                <p>You saved! <br> <?=$o->symbol?> <?=round(($total_acctual_total - $total_sub_total) , 2)?></p>
                            </div>

                        </div>
             </div>


         </div>

            </div>
               </div>
            </div>
         </div>
      </div>
      <div id="smartblog_block" class="block products_block hb-animate-element bottom-to-top hb-in-viewport">
         <div class="container">
         </div>
<script type="text/javascript">
function trackShiprocketOrder(){

  var orders_id = <?=$o->orders_id?>;

  $("#shipRicketResponseDiv").html('');

  $(".trackShiprocketOrderBTN").prop('disabled', true);
  $("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Trackin Shipment.</div>");

  $.ajax({
    type: "POST",
    url:'<?=MAINSITE?>Dashboard/track_shiprocket_order_api/',
    dataType: "json",
    data : {  'orders_id' : orders_id },
    success : function(result){

      $(".trackShiprocketOrderBTN").prop('disabled', false);
      $("#shipRicketResponseDiv").html("");
      //$('#shipRicketRateServiceData').html(result);
      $('#shipRicketResponseDiv').html(result.template);

      // $('.track_order_modal_body').html(result)

      //$('#track_order_modal').modal({show:true})
      //$('#user_pin_close').html('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>')


    }
  });
}
</script>
