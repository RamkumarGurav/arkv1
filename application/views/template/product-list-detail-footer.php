<?
if(__is_location_wise_product__ &&  __app_is_sell_local__ == 2 && $is_sell_local==1)
{
	// do nothing
}
else{

?>
<div class="product_sec2">
					<div class="col-md-1 mobile_none" style="padding-right:0px">
                    <? 
					$pi = $products_image[0];  ?>
							
                    	<img src='<?= $SimagePath . $pi['product_image_name'] ?>' width="60" alt="<?= $product_name ?>" title="<?= $product_name ?>"  />
                        &nbsp;&nbsp;&nbsp;&nbsp;
						</div><div class="col-md-5"><h4 class="prodct_prce"><?= $r_product_name ?> - <?=$r_combi?></h4>
                    </div>
                    <div class="col-md-6">
						<h4 class="prodct_prce mobile_none">
						<? if (!empty($discount) && $discount>0) { ?><span class="old_price mobile_none"><? echo"₹"; ?> <? echo $price ?></span><? } ?>
							<span class="new_price mobile_none"> ₹ <? echo $final_price ?></span>
							<? if (!empty($discount) && $discount>0) { ?><span class="offer_tag"> <?= $discount ?> OFF</span><? } ?>
							
						</h4>
					
					<div class="button_wrap " style="text-align: center;">
					
					
					<? if ($in_store_quantity > 0) { ?>
							
								<div class="disply_inline mar-l-r-0 productAddShow_10 prdt_cost_right" style="">
									<div class="disply_inline input-group padd-l-r-0 pdt-list-qty" style="display:none">
										<div class="input-group-prepend">
											<div class="input-group-text">Qty</div>
										</div>
										<input type="text" class="form-control" value="1">
									</div>
									<div class="disply_inline input_group plus-minus-input">
										<div class="pad-mar-l-r-0 productAddShow_<? echo $product_in_store_id; ?>" <? if (!empty($prod_in_cart) || $prod_in_cart > 0) { ?> style="display:none"<? } ?>><button class=" crt_button2 ad_cart_btn addToCartListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,2"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
									<div class="disply_inline pad-mar-l-r-0 productInCartShow_<? echo $product_in_store_id; ?>" <? if (!empty($prod_in_cart) || $prod_in_cart > 0) { ?> style="display:inline-block"<? } else { ?>style="display:none"<? } ?>>
										<?php /*?><a href="<?=base_url().__cart__?>"><button class="ad_cart_btn "> Go To Cart</button></a><?php */?>
										
										<div class="">
										
										<span class="QtyincreDecre list_detail">
										<button class="btn btn-default btn-number incToCartListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,1"><span class="glyphicon glyphicon-minus"></span></button>
											<span class="cart_quntity cart_increment_<? echo $product_in_store_id; ?>"><?=$prod_in_cart?></span>
										<button class="btn btn-default btn-number incToCartListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,2"><span class="glyphicon glyphicon-plus"></span></button>
										</span>
										
									   </div>
										
										
									</div>
									<? /*  ?><div class="col-lg-6 col-xs-12 pdt-details-cart-btn productInCartShow_<? echo $product_in_store_id; ?>" <? if (!empty($prod_in_cart) || $prod_in_cart > 0) { ?> style="display:none"
										<? } else { ?>style="display:none"
										<? } ?>>
										<button style="display:none" class="btn btn-primary margi_algn">In Cart</button>
									</div><? */ ?>
									<div class="disply_inline input_group plus-minus-input" style="margin-left:10px;">
										<button class="crt_button1 addToCartListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,8">Buy Now</button>
									</div>
								</div>
                                
						<? } else { ?> 
						<div class="disply_inline prdt_cost_right prdt_cost_sold" style="">
							<span class="out-of-stock out-of-stock-dtails sold_out"><? echo $stock_out_msg; ?></span>
								<?php /*?><span class="quantity_hd">Email : </span><?php */?>

								<input style="display:none" class="profil_form email-notification notfy_mail" type="email" name="notify_email" id="notify_email" value="<? if (!empty($customers->email)) { echo $customers->email; } ?>" />
								

								<button class="notify_btn1 notify_buton addToNotifyMeListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>">Notify Me <i class="icon ion-ios-notifications"></i> </button>
                                <span class="en_error_span<? echo $product_combination_id; ?>"></span>
                                </div>
							<? } ?>
					
						<button class="crt_button3 wishlist-i cart_wishlist_<? echo $product_in_store_id; ?> cart_wishlist_n_<? echo $product_in_store_id; ?> addToWishlistListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,1" title="Add to Wishlist - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" style=" <? if ($prod_in_wishList <= 0) { echo " display:inline-block";} else {echo "display:none";} ?> " ><i class="fa fa-heart-o"></i></button>
						
						<button class="crt_button3 wishlist-i cart_wishlist_<? echo $product_in_store_id; ?> cart_wishlist_y_<? echo $product_in_store_id; ?> addToWishlistListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,2" title="Remove from Wishlist - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" style=" <? if ($prod_in_wishList >= 1) {echo " display:inline-block";} else {echo "display:none";} ?> " ><i class="fa fa-heart"></i></button>
					</div>
                    </div>
					</div>
                    
                    
                    
<? } ?>
