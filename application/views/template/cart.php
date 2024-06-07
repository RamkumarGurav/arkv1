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
 <div class="col-md-8">
<? } ?>

<div class="item-base-item">
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
               </div>







<? }} ?>
 </div>

 <div class="col-md-4">
               <div class="sticky-price-section">
                  <div class="itemContainer-base-item itemContainer-base-item1 ">
                  <div class="priceBlock-base-container">
                     <div class="priceBlock-base-priceHeader">PRICE DETAILS <hr></div>
                     <div class="priceBreakUp-base-orderSummary" id="priceBlock">
                        <div class="priceDetail-base-row">
                           <span>Price (<?=$total_prod?> Items)</span>
                           <span class="priceDetail-base-value ">
                              <span></span>

                              <span> <?=$currency->symbol?> <?=$total_mrp_price?></span>
                           </span>
                        </div>
                        <? if(!empty($total_dicount_price)){ ?>
                        <div class="priceDetail-base-row">
                           <span>Discount</span>
                           <span class="priceDetail-base-value priceDetail-base-discount">
                           <span>-</span>
                           <span><?=$currency->symbol?> <?=$total_dicount_price?></span>
                           </span>
                        </div>
                        <? } ?>
						<? if(!empty($total_packing_charges)){ ?>
                        <div class="priceDetail-base-row">
                           <span>Packing Charges</span>
                           <span class="priceDetail-base-value priceDetail-base-discount">
                           <span>-</span>
                           <span><?=$currency->symbol?> <?=$total_packing_charges?></span>
                           </span>
                        </div>
                        <? } ?>


                        <? if(_is_coupon_required ==1){ ?>
                        <? if(!empty($cart_coupon_discount) && !empty($cart_coupon_code) ){ ?>
                        <div class="priceDetail-base-row">
                        <?
							if($total <= $cart_discount_on_cart_value)
							{
								REDIRECT(base_url().__removeCoupon__.'?total_mismatch=1');
							}
						   $cart_coupon_discount_value = 0;
						   $cart_coupon_discount_value_var = '';
							if($cart_discount_in==1)
							{
								$cart_coupon_discount_value = $cart_coupon_discount;
								$cart_coupon_discount_value_var = $cart_discount_variable.' '.$cart_coupon_discount;
							}
							else
							{
								$cart_coupon_discount_value = (($cart_coupon_discount/100)*($total));
								$cart_coupon_discount_value_var = $cart_coupon_discount.''.$cart_discount_variable;
							}
						   ?>
                           <span>Discount (<?=$cart_coupon_code?> at <?=$cart_coupon_discount_value_var?>)</span>
                           <span class="priceDetail-base-value priceDetail-base-discount">
                           <span>-</span>
                           <span><?=$currency->symbol?> <? echo $cart_coupon_discount_value; $total -=$cart_coupon_discount_value; ?><a href="<?=base_url().__removeCoupon__?>" class="close lnr lnr-cross" title="Remove Discount" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-trash"></i></a></span>
                           </span>
                        </div>
                        <? } ?>
                        <? if(empty($cart_coupon_discount) && empty($cart_coupon_code) ){ ?>
                        <div class="priceDetail-base-row">
                           <span>Promo Code</span>
                           <span class="priceDetail-base-value priceDetail-base-discount">
                           <!-- <span>-</span> -->
                           <div class="cart_tots_2" style="float: right;">
                    	<form action="<?=base_url().__cart__?>" method="post" class="promoform1" >
						<input class="custom_form" type="text" id="coupon" name="coupon" required placeholder="Enter Coupon code" >
                        <button type="submit" name="CouponBTN" value="1" class="promo_bvn_1 btn btn-info">Apply</button>
                        </form>
					</div>
                           </span>
                        </div>
                        <? } ?>
                        <? } ?>

                        <div class="priceDetail-base-total">
                           <span>Total Amount</span>
                           <span class="priceDetail-base-value ">
                           <span></span>
                           <span><?=$currency->symbol?> <?=$total+$total_packing_charges?></span>
                           </span>
                        </div>
                     </div>
                  </div>
                  <div>
                     <a href="<?=base_url()?>all-products" class="aClick_1"><button type="button" class="button-base-button" title="Continue Shopping">Continue Shopping <i class="fa fa-shopping-cart"></i></button></a>
                     <? if(!empty($total) && $total>0){ ?>
            <a href="<?=base_url().__payment__?>"  class="aClick_1" title="Checkout"><button type="button" class="cart_buton3 btn-chechout">Checkout <span class="glyphicon glyphicon-play"></span></button></a>
            <? } ?>
                  </div>
               </div>
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
