<?
if(empty($offer_class_quick_view))
{
	$offer_class_quick_view = 'offer_tag';
}
?>
<div class="product_sec1">

						<h4><a href="<?= $product_link ?>"><?= $r_product_name ?> -<?=$r_combi?></a></h4>
                        <? if($in_store_quantity>0 && $in_store_quantity<=10){ ?>
                        <? if($in_store_quantity>1){ ?>
                        <h6 style="color:#9b0101">Only <?=$in_store_quantity?> Units are left.</h6>
                        <? }else{ ?>

                        <h6 style="color:#9b0101">Only <?=$in_store_quantity?> Unit is left.</h6>
                        <? } ?>
                        <? } ?>

                     <div class="row">

		<div class="col-lg-6">   <h4 class="prodct_prce">
            <p class="Bysizyprice">
            <span class="curprice ">
           <i class="fa fa-inr"></i> <? echo number_format($final_price) ?>
            </span>
            <? if (!empty($discount) && $discount>0) { ?>
            <br><span class="price">M.R.P: <strike><i class="fa fa-inr"></i> <? echo number_format($price) ?></strike> <br><span class="disc-price">You Save: <span><span><i class="fa fa-inr"></i> <?=number_format($discounted_price)?></span></span></span>                        </span>
            <?php } ?>
            </p>
            </h4>
			<? if(!empty($delivery_charges)){ ?>
	<h6 style="color:#12abc3"><strong>Packing charges ₹ <?=$delivery_charges?> extra.</strong></h6>
<? } ?>
            </div>
				<div class="col-lg-12">

				<div class=" align-items-center">


					<? if ($in_store_quantity > 0) { ?>

								<div class="disply_inline1 mar-l-r-0 productAddShow_10 prdt_cost_right" style="">
									<div class="disply_inline input-group padd-l-r-0 pdt-list-qty" style="display:none">
										<div class="input-group-prepend">
											<div class="input-group-text">Qty</div>
										</div>
										<input type="text" class="form-control" value="1">
									</div>

									<div class="disply_inline justify-content-between" <? if (!empty($prod_in_cart) || $prod_in_cart > 0) { ?> style="display:none;gap:10px"
									<? } else { ?>style="display:flex;gap:10px"
										<? } ?>>


                                        <div style="width:50%" class=" pad-mar-l-r-0 productAddShow_<? echo $product_in_store_id; ?>" <? if (!empty($prod_in_cart) || $prod_in_cart > 0) { ?> style="display:none"<? } ?>><button  style=" " class="w-100 crt_button2 ad_cart_btn  addToCartListBTN<? echo $offset ?>" title="Add To Cart - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,2" style="width:100%; ;"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
										<div style="width:50%" class=" pad-mar-l-r-0 productAddShow_<? echo $product_in_store_id; ?>" <? if (!empty($prod_in_cart) || $prod_in_cart > 0) { ?> style="display:none"<? } ?>><button style=" " class="w-100 crt_button2 ad_cart_btn addToCartListBTN<? echo $offset ?>" title="Add To Cart - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,8"><i class="fa fa-credit-card"></i> Buy Now</button>
</div>
									</div>
									<div class="disply_inline pad-mar-l-r-0 productInCartShow_<? echo $product_in_store_id; ?>" <? if (!empty($prod_in_cart) || $prod_in_cart > 0) { ?> style="display:inline-block"<? } else { ?>style="display:none"<? } ?>>
										<?php /*?><a href="<?=base_url().__cart__?>"><button class="ad_cart_btn mt-2"> Go To Cart</button></a><?php */?>

										<div class="" style="display:none">

										<span class="QtyincreDecre list_detail">
										<button class="btn btn-default btn-number incToCartListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,1"><span class="glyphicon glyphicon-minus"></span></button>
											<span class="cart_quntity cart_increment_<? echo $product_in_store_id; ?>"><?=$prod_in_cart?></span>
										<button class="btn btn-default btn-number incToCartListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,2"><span class="glyphicon glyphicon-plus"></span></button>
										</span>

									   </div>
										 <a onclick="cartopenNav()" target="_blank" class="adtocart mt-2 selected_c aClick_2" title="Go to cart">Go to cart</a>

									</div>

								</div>
						<? } else { ?>
						<div class="disply_inline prdt_cost_right prdt_cost_sold justify-content-between" style="">
							<span class="ad_cart_btn w-100 out-of-stock out-of-stock-dtails sold_out"><? echo $stock_out_msg; ?></span>
								<?php /*?><span class="quantity_hd">Email : </span><?php */?>

								<input style="display:none" class="profil_form email-notification notfy_mail" type="email" name="notify_email" id="notify_email" value="<? if (!empty($customers->email)) { echo $customers->email; } ?>" />


								<button style="margin-right: 0" class="w-100 ad_cart_btn notify_btn1 notify_buton addToNotifyMeListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>">Notify Me <i class="icon ion-ios-notifications"></i> </button>
                                <span class="en_error_span<? echo $product_combination_id; ?>"></span>
                                </div>
							<? } ?>


						<button class="disply_inline crt_button3 wishlist-i cart_wishlist_<? echo $product_in_store_id; ?> cart_wishlist_n_<? echo $product_in_store_id; ?> addToWishlistListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,1" title="Add to Wishlist - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" style=" <? if ($prod_in_wishList <= 0) { echo " display:inline-block";} else {echo "display:none";} ?> " ><i class="fa fa-heart-o"></i></button>

						<button class="disply_inline crt_button3 wishlist-i cart_wishlist_<? echo $product_in_store_id; ?> cart_wishlist_y_<? echo $product_in_store_id; ?> addToWishlistListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,2" title="Remove from Wishlist - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" style=" <? if ($prod_in_wishList >= 1) {echo " display:inline-block";} else {echo "display:none";} ?> " ><i class="fa fa-heart"></i></button>




					</div>
				</div>

			</div>
					</div>
