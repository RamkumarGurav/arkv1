<? $CI=&get_instance(); ?>
<?
$total = 0;
$total_mrp_price = 0;
$sub_total = 0;
$total_saving = 0;
$final_cart_amount = 0;
$total_prod = 0;
$display_body='';
$total_packing_charges=0;
$total_dicount_price=0;
$discounted_price=0;
$currency = (object)array("symbol" => '<i class="fa fa-inr"></i>');
$SimagePath = _uploaded_files_ . 'product/small/';
$delivery_charges = 0;
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
					$discount = $row['discount'].' '.$row['discount_var'];$discount = trim($discount);
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
					$discount = $row['discount'].' '.$row['discount_var'];$discount = trim($discount);
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
<? }}

$final_cart_amount = $total+$total_packing_charges;
						if($final_cart_amount <= __free_shipping_above__) { $delivery_charges = 90; } else { $delivery_charges = 0;}
?>
 </div>

 <div class="col-md-12">
               <div class="sticky-price-section">
                  <div class="itemContainer-base-item itemContainer-base-item1 ">
                  <div class="priceBlock-base-container">
                     <div class="priceBlock-base-priceHeader">PRICE DETAILS <hr></div>
                     <div class="priceBreakUp-base-orderSummary" id="priceBlock">
                        <div class="priceDetail-base-row">
                           <span>Price (<?=$total_prod?> Items)</span>
                           <span class="priceDetail-base-value ">
                              <span></span>

                              <span> <?=$currency->symbol?> <?=round($total_mrp_price)?></span>
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
                           <span><?=$currency->symbol?> <?=round($total_packing_charges)?></span>
                           </span>
                        </div>
                        <? } ?>
						<? if(!empty($total_packing_charges)){ ?>
                        <div class="priceDetail-base-row">
                           <span>Shipping Charges</span>
                           <span class="priceDetail-base-value priceDetail-base-discount">
                           <span>-</span>
                           <span><?=$currency->symbol?> <?=number_format($delivery_charges )?></span>
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
                        <?php

						?>
                        <div class="priceDetail-base-row">

                           <span >Shipping 	<i class="fa fa-info-circle help-tip" aria-hidden="true" style="color: #737d11;font-size: 16px;" onclick="$('#ship_modal').modal()">         <span>Shipping will be free on order <?=__free_shipping_above__?> and above.</span></i></span>
                           <span class="priceDetail-base-value priceDetail-base-discount">
                          <!--  <span>-</span> -->
                           <span>   <?=$currency->symbol?> <?=number_format($delivery_charges )?></span>
                           </span>
                        </div>
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
                           <span><?=$currency->symbol?> <?=round($total+$total_packing_charges+$delivery_charges)?></span>
                           </span>
                        </div>
                     </div>
                  </div>
                  <div>

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
