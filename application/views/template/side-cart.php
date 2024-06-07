<? $CI=&get_instance(); ?>
<?
$total = 0;
$total_mrp_price = 0;
$sub_total = 0;
$total_saving = 0;
$total_prod = 0;
$display_body='';
$total_packing_charges=0;
$total_dicount_price=0;
$discounted_price=0;
$currency = (object)array("symbol" => '<i class="fa fa-inr"></i>');
$SimagePath = _uploaded_files_ . 'product/small/';
//echo "<pre>"; print_r($products_list); echo "</pre>";
if(!empty($products_list)){
$c_count=0;
foreach($products_list as $col){
			$product_name = $col['name'];
			$product_id = $col['product_id'];
			if(empty($col['brand_name'])){$col['brand_name'] = '';}
			$brand_name = $col['brand_name'];
			$short_description = $col['short_description'];
			//Default combination details
			foreach($col['product_combination'] as $row){

		$temp_currency_id = $this->session->userdata('application_sess_currency_id'); //echo "temp_currency_id : $temp_currency_id </br>";
		if(empty($temp_currency_id) || $temp_currency_id==1)
		{
			if(!empty($cart_coupon_code) && !empty($cart_coupon_discount) && _is_coupon_applicable_on_mrp ==1 ){
				if($row['discount_var']=='Rs')
				{
					//$discount = $currency->symbol.' '.$CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['discount']));$discount = trim($discount);
					$discount = $currency->symbol.' '.$row['discount'];$discount = trim($discount);
				}
				else
				{
					$discount = round($row['discount']).' '.$row['discount_var'];$discount = trim($discount);
				}
				$discount='';
				$price = $row['price'];
				//$final_price = $CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['final_price']));
				$final_price = $price;
			}
			else{
				if($row['discount_var']=='Rs')
				{
					//$discount = $currency->symbol.' '.$CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['discount']));$discount = trim($discount);
					$discount = $currency->symbol.' '.$row['discount'];$discount = trim($discount);
				}
				else
				{
					$discount = round($row['discount']).' '.$row['discount_var'];$discount = trim($discount);
				}
				$price = $row['price'];
				$final_price = $row['final_price'];
				$discounted_price = $price - $final_price;
			}
		}
		else
		{
			if(!empty($coupon_discount) && !empty($coupon_code) ){
				if($row['discount_var']=='Rs')
				{
					//$discount = $currency->symbol.' '.$CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['other_discount']));$discount = trim($discount);
					$discount = $currency->symbol.' '.$row['other_discount'];$discount = trim($discount);
				}
				else
				{
					$discount = $row['other_discount'].' '.$row['other_discount_var'];$discount = trim($discount);
				}
				$discount='';
				$price = $row['other_price'];
				//$final_price = $CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['final_price']));
				$final_price = $price;
				$discounted_price = $price - $final_price;
			}
			else{
				if($row['other_discount_var']=='Rs')
				{
					//$discount = $currency->symbol.' '.$CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['other_discount']));$discount = trim($discount);
					$discount = $currency->symbol.' '.$row['other_discount'];$discount = trim($discount);
				}
				else
				{
					$discount = $row['other_discount'].' '.$row['other_discount_var'];$discount = trim($discount);
				}
				$price = $row['other_price'];
				$final_price = $row['other_final_price'];
				$discounted_price = $price - $final_price;
			}
		}
				//$discount = $row['discount'].' '.$row['discount_var'];$discount = trim($discount);

				$product_image_name = $row['product_image_name'];
				$product_display_name = $row['product_display_name'];
				$combi = $row['combi'];
				$product_in_store_id = $row['product_in_store_id'];
				$product_combination_id = $row['product_combination_id'];
				$prod_in_cart = $row['prod_in_cart'];
				$cart_comment = $row['cart_comment'];
				$prod_in_wishList = $row['prod_in_wishList'];
				$in_store_quantity = $row['quantity'];
				$stock_out_msg = $row['stock_out_msg'];
				$quantity_per_order = $row['quantity_per_order'];
				$packing_charges = $row['delivery_charges'];

				$total_packing_charges += $prod_in_cart*$packing_charges;
				$total_dicount_price += $prod_in_cart*$discounted_price;

				$total_prod+=$prod_in_cart;
				$total+=$prod_in_cart*$final_price;
				$total_mrp_price+=$prod_in_cart*$price;
				$sub_total+=$prod_in_cart*$final_price;
				$total_saving+=$prod_in_cart*$price;
$c_count++;
$product_link = base_url() . 'products-details/' . $product_id;

        if (!empty($ps_slug_url)) {

            $product_link = '';

            $product_link .= base_url();

            if (!empty($pre_url_product)) {

                $product_link .= $pre_url_product;

            }

            $product_link .= $ps_slug_url;

        }
?>
<? if($c_count==1){ ?>

 <div class="col-md-12" style="overflow-y: scroll;height: 350px;overflow-x: hidden;">
<? } ?>


<div class="row align-items-center justify-content-center ">

            <div class="col-lg-4 col-4">
               <img src="<?=$SimagePath.$product_image_name?>" alt="<?=$product_name?>" title="<?=$product_name?>">
            </div>
            <div class="col-lg-8 col-8">
               <div class="CartItem__Info">
                  <h2 class="CartItem__Title Heading">
                     <a href="<?=$product_link?>"><?=$product_display_name?> - <?=$combi?></a>
                  </h2>
                  <div class="CartItem__Meta Heading Text--subdued">
                     <div class="CartItem__PriceList"><span class="CartItem__Price Price" data-money-convertible=""><?=$currency->symbol.' '.$final_price?></span></div>

                     <? if(!empty($discount) && $discount>0){ ?>
                        <div class="">
                            &nbsp;&nbsp;<strike class="strike"> <i class="fa fa-inr"></i> <? echo $price ?></strike>&nbsp;<span class="pdisc1"><span class="pdisc disc-price">You Save: <span><span ><i class="fa fa-inr"></i> <?=$discounted_price?></span></span></span></span>


                        </div>
                        <? } ?>
                        <? if(!empty($packing_charges)){ ?>
                        <p style="color:#12abc3"> Packing charges  <?=$currency->symbol.' '.$packing_charges?></p>
                        <? } ?>
                  </div>
                  <div class="button_wrap align-items-center mt-3" style="float: left !important;">
                     <div class="row align-items-center justify-content-center" >
                        <div class="col-lg-8 col-8">


                        	<? if($in_store_quantity>0){ ?>
                           <span class="QtyincreDecre list_detail">
                           <button class=" btn-default btn-number incToCartListBTNC" data-val='<?=$product_in_store_id?>,<?=$product_id?>,<?=$product_combination_id?>,1'><span class="glyphicon glyphicon-minus"></span></button>
													 <input type="hidden" class="cart_increment_<?=$product_in_store_id?>" value="<?=$prod_in_cart?>"></input>

													 <span class="cart_quntity cart_increment_<?=$product_in_store_id?>" style="padding: 10px;" data-pisd="<?=$product_in_store_id?>" data-pcid="<?=$product_combination_id?>" data-pid="<?=$product_id?>"><?=$prod_in_cart?></span>
                           <button class=" btn-default btn-number incToCartListBTNC" data-val='<?=$product_in_store_id?>,<?=$product_id?>,<?=$product_combination_id?>,2'><span class="glyphicon glyphicon-plus"></span></button>
                           </span>
                           <? }else{ ?>
								<?=$stock_out_msg?><br>Remove Product From Cart
                            <? } ?>
                        </div>
                        <div class="col-lg-4 col-4">
                           <a  class="cart-remove incToCartListBTNC" data-val='<?=$product_in_store_id?>,<?=$product_id?>, <?=$product_combination_id?>,3'>Remove</a>
                        </div>
                     </div>
                  </div>
               </div>


            </div>
         </div>


<?php /*?><div class="item-base-item">
                  <div class="itemContainer-base-item ">
                     <div class="itemContainer-base-itemLeft">
                        <a href="<?=$product_link?>" class="aClick_1">
                           <div class="cartbx">
                              <div class="LazyLoad is-visible">
                                 <picture class="image-base-imgResponsive" >
                                    <img src="<?=$SimagePath.$product_image_name?>" alt="<?=$product_name?>" title="<?=$product_name?>" class="image-base-imgResponsive"  >
                                 </picture>

                              </div>
                           </div>
                        </a>
                     </div>
                     <div class="itemContainer-base-itemRight ">
                        <div class="itemContainer-base-details">
                           <div class="row mb-4">
                              <div class="col-md-7">
                                 <div>
                                    <div class="itemContainer-base-brand"><a href="<?=$product_link?>"><?=$product_display_name?></a></div>
                                    <a class="itemContainer-base-itemLink aClick_1" href="<?=$product_link?>" ><?=$combi?></a>
                                 </div>
                                 <div class="itemComponents-base-sellerContainer">
                                    <div class="itemComponents-base-sellerData">Sold by: <?=$brand_name?></div>
                                 </div>
                                 <div class="itemContainer-base-price">

                                    <div class="itemComponents-base-price itemComponents-base-bold ">

                                       <div class="price">
                                          <?=$currency->symbol.' '.$final_price?>
                                       </div>
                                    </div>
                                     <? if(!empty($discount) && $discount>0){ ?>
                                    <div class="">
                                    	&nbsp;&nbsp;<strike class="strike"> <i class="fa fa-inr"></i> <? echo $price ?></strike>&nbsp;<span class="pdisc1"><span class="pdisc disc-price">You Save: <span><span ><i class="fa fa-inr"></i> <?=$discounted_price?></span></span></span></span>


                                    </div>
                                    <? } ?>
                                    <? if(!empty($packing_charges)){ ?>
                                    <p style="color:#12abc3"> Packing charges  <?=$currency->symbol.' '.$packing_charges?></p>
                                    <? } ?>
                                 </div>
                              </div>
                              <div class="col-md-5">
                                 <div class="itemContainer-base-sizeAndQtyContainer">

                                    <div class="itemContainer-base-sizeAndQty">
                                       <div class="qty ">

                                          <div class="input-group bootstrap-touchspin">
                                             <div class="center">
                                              <!--  <div class="input-group">
                                                   <span class="input-group-btn">
                                                   <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                   <span class="glyphicon glyphicon-minus"></span>
                                                   </button>
                                                   </span>
                                                   <input type="text" name="quant[1]" class="form-control input-number inptbx" value="8" min="8" max="30">
                                                   <span class="input-group-btn">
                                                   <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                                                   <span class="glyphicon glyphicon-plus"></span>
                                                   </button>
                                                   </span>
                                                </div> -->
                                                <div class="input-group">
                                                <? if($in_store_quantity>0){ ?>
                                                	<div class="cart_quantiy">
                                                    	<a class="input-group-prepend input-group-addon incToCartListBTNCART" data-val='<?=$product_in_store_id?>,<?=$product_id?>,<?=$product_combination_id?>,1'><span class="glyphicon glyphicon-minus"></a></span>
                                                        <span class="cart_quntity input-number inptbx cart_increment_<?=$product_in_store_id?>" data-pisd="<?=$product_in_store_id?>" data-pcid="<?=$product_combination_id?>" data-pid="<?=$product_id?>" ><?=$prod_in_cart?></span>
                                                        <a  class="input-group-prepend input-group-addon incToCartListBTNCART right" data-val='<?=$product_in_store_id?>,<?=$product_id?>,<?=$product_combination_id?>,2'><span class="glyphicon glyphicon-plus"></a></span>
                                               		</div>
            									<? }else{ ?>
                                                	<?=$stock_out_msg?><br>Remove Product From Cart
												<? } ?>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 <a class=" btn btn1 btn-danger delete incToCartListBTNCART btn btn-danger" data-val='<?=$product_in_store_id?>,<?=$product_id?>, <?=$product_combination_id?>,3'>Delete <i class="fa fa-trash"></i></a>
								<a class="btn btn1 btn-warning save-for-later cart_wishlist_<? echo $product_in_store_id; ?> addToWishlistListBTNCART" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,3" >Save for Later</a>

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div><?php */?>







<? }} ?>
 </div>

<div class="cart-footer">
          <div  class="ccc">
          <p >Prices Include GST &amp; Free Shipping</p>
          <a href="#smile-home"> Sign Up For MQ Rewards To Redeem For Special Offers Discounts</a>
        </div>


          <a class="mt-3 ccc" onClick="noteopenNav()">Add A Note To Your Order</a>
          <div id="mySidenote" class="addnote">
            <div style="     padding: 0px 30px 0px 30px;
">

<span class="Cart__NoteButton">Add A Note To Your Order</span>
<div class="Form__Item ">
              <textarea name="customer_order_note" id="customer_order_note_sc" class="" placeholder="Add a Note"><?=$this->session->userdata('application_sess_customer_order_note');?></textarea>
            </div>

            <button type="button" class="notesave" data-action="toggle-cart-note" onClick="notecloseNav()">Save</button>
</div>
</div>
<div  class="ccc">
<? if(!empty($total) && $total>0){ ?>
            <a href="<?=base_url().'payment' //__payment__?>"  class="aClick_1" title="Checkout">
          <button type="button" name="checkout" class="cart_buton3 btn-chechout1 ccc" >
         <span>Checkout - <?=$currency->symbol?> <?=$total+$total_packing_charges?></span>
        </button>
        </a>
        <?php } ?>
      </div>
         </div>

<? }else{ ?>
<article class="cart_tabs_1 clearfix col-lg-12 cart-indi">
	<img src="<?=__scriptFilePath__?>images/emptycart.png" class="empty_notif_2">

   <!--  <span class="empty_notif_1">your cart is empty</span> -->
    <a href="<?=base_url()?>all-products" class="empty_notif_3" title="Continue Shopping"><button class="proceed_ckt"><i class="fa fa-shopping-cart"></i> <span> Continue Shopping</button></a>
</article>
<? } ?>


<style>
.quantity{max-width: 6rem;
    padding: 1.5rem;
    font-size: 1.5rem;
    height: 1.5rem;
    color: #495057;}
</style>




<script>
window.addEventListener("load" , function(){
	afterGetDetail();
	$(".cart_increment_input").bind("click", function(){
		setCartInputBox(this);
	});

	$(".cart_increment_input").bind("click", function(){
		setCartInputBox(this);
	});
});
function setCartInputBox(obj)
{
	$(obj).unbind();
	var in_cart = $(obj).html();
	var pisd = $(obj).data('pisd');
	var pcid = $(obj).data('pcid');
	var pid = $(obj).data('pid');

	$('.cart_increment_btn_'+pisd).hide();
	$(obj).html('<input class="quantity" id="quantity'+ pisd +'" min="0" autofocus name="quantity" type="number">');

	document.getElementById('quantity'+ pisd).focus();
	document.getElementById('quantity'+ pisd).value = in_cart;

	$('#quantity'+ pisd).keypress(function (e) {
		var key = e.which;
		var is_task_run=false;
		console.log(key +' : '+is_task_run);
		if(key == 13)  // the enter key code
		{ is_task_run=true; }
		if(is_task_run)
		{
			var in_cart_new = $(this).val();
			$(".cart_increment_"+ pisd).html(in_cart_new);
			$('.cart_increment_btn_'+pisd).show();

			if(in_cart_new >= in_cart)
				AddToCart(pisd , pid , pcid , 2 , 'cart')
			else if(in_cart_new <= in_cart)
				AddToCart(pisd , pid , pcid , 1 , 'cart')

			$(obj).bind("click", function(){
				setCartInputBox(this);
			});
			$('#quantity'+ pisd).unbind();
		}
	});


	$('#quantity'+ pisd).bind("focusout", function(e){
		var in_cart_new = $(this).val();
		$(".cart_increment_"+ pisd).html(in_cart_new);
		$('.cart_increment_btn_'+pisd).show();

		if(in_cart_new >= in_cart)
			AddToCart(pisd , pid , pcid , 2 , 'cart')
		else if(in_cart_new <= in_cart)
			AddToCart(pisd , pid , pcid , 1 , 'cart')

		$(obj).bind("click", function(){
			setCartInputBox(this);
		});
		$('#quantity'+ pisd).unbind();
	});
}
</script>
