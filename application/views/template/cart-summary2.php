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
<? if($c_count==1){ ?>
 <div class="col-md-12">
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
                              <div class="col-7">
                                 <div>
                                    <div class="itemContainer-base-brand"><a href="<?=$product_link?>"><?=$product_display_name?></a></div>
                                    <a class="itemContainer-base-itemLink aClick_1" href="<?=$product_link?>" ><?=$combi?></a>
                                 </div>
                                 <div class="itemComponents-base-sellerContainer">
                                    <div class="itemComponents-base-sellerData">Sold by: <?=$brand_name?></div>
                                 </div>
                                 <div class="itemContainer-base-price">

                                    <div class="itemComponents-base-price itemComponents-base-bold ">
                                       <div>
                                          <?=$currency->symbol.' '.round($final_price)?>
                                       </div>
                                    </div>
                                     <? if(!empty($discount) && $discount>0){ ?>
                                    <div class="">
                                    	&nbsp;&nbsp;<strike class="strike"> <i class="fa fa-inr"></i> <? echo round($price) ?></strike>&nbsp;<span class="pdisc1"><span class="disc-price">You Save: <span><span class="itemComponents-base-itemDiscount"><i class="fa fa-inr"></i> <?=$discounted_price?></span></span></span></span>


                                    </div>
                                    <? } ?>

                                 </div>
																 <? if(!empty($packing_charges)){ ?>
																 <p style="color:#12abc3"> Packing charges  <?=$currency->symbol?><?= round($packing_charges)?></p>
																 <? } ?>
                              </div>
                              <div class="col-5">
                                 <div class="itemContainer-base-sizeAndQtyContainer">

                                    <div class="itemContainer-base-sizeAndQty">
                                       <div class="qty ">

                                          <div class="input-group bootstrap-touchspin">
                                             <div class="center">
																							 <div class="" >

																							 <span class="QtyincreDecre list_detail">
																							 <button class="btn btn-default btn-number incToCartListBTNCART" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,1"><span class="glyphicon glyphicon-minus"></span></button>

																								 <span class="cart_quntity cart_increment_<? echo $product_in_store_id; ?>"><?=$prod_in_cart?></span>
																								 																					 <input type="hidden" class="cart_increment_<? echo $product_in_store_id; ?>" value="<?=$prod_in_cart?>">
																							 <button class="btn btn-default btn-number incToCartListBTNCART" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,2"><span class="glyphicon glyphicon-plus"></span></button>
																							 </span>

																								</div>
                                                <!-- <div class="input-group">
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
                                                <!-- <div class="input-group">
																									<input type="hidden" class="cart_increment_<?=$product_in_store_id?>" value="<?=$prod_in_cart?>">
                                                <span class="cart_quntity input-number inptbx cart_increment_<?=$product_in_store_id?>" data-pisd="<?=$product_in_store_id?>" data-pcid="<?=$product_combination_id?>" data-pid="<?=$product_id?>" ><?=$prod_in_cart?></span>
                                                </div> -->
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>


                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>







<? }} ?>
 </div>



<? }else{ ?>
<? } ?>
