<center>
  <div class="row">
<?
$_prow_count = 4;
$_prow_countm = 6;
if(empty($callFor)){$callFor='';}
if($callFor == 'slider') {$_prow_count = 12;$_prow_countm=12;}
//if($callFor == 'slider') {$_prow_count = 3;}
if($callFor == 'nonslider') {$_prow_count = 4;}
$display_product_count = 0;
$page_count = 0;
if(!empty($products_list))
{
  foreach ($products_list as $col)
  {
    $display_product_count++;
    $page_count++;
        $product_name = $col['name'];
        $ps_slug_url = $col['ps_slug_url'];
        $product_id = $col['product_id'];
        $short_description = $col['short_description'];
        $manufacturer_name = _brand_name_;
        $totalrating = $col['totalrating'];
        $totalreview = $col['totalreview'];
    $avgrating = $col['avgrating'];
    $pc_ref_code = $col['pc_ref_code'];
    $product_id = $col['product_id'];
    $gtm_product_list_category='';
    $query_get_list = $this->db->query("SELECT c.name , c.slug_url , c.category_id , c.super_category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and super_category_id = 0 and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1 ");
    $query_data = $query_get_list->result();
    if(!empty($query_data))
    {
      $qd = $query_data[0];
      $gtm_product_list_category.= $qd->name;
      $query_get_list = $this->db->query("SELECT c.name , c.slug_url , c.super_category_id , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd->category_id."  and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1  ");
      $query_data1 = $query_get_list->result();
      if($query_data1)
      {
        $qd1 = $query_data1[0];
        $gtm_product_list_category.= ' -> '.$qd1->name;
        $query_get_list = $this->db->query("SELECT c.name , c.super_category_id , c.slug_url , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd1->category_id." and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1  ");
        $query_data2 = $query_get_list->result();
        if($query_data2)
        {
          $qd2 = $query_data2[0];
          $gtm_product_list_category.= ' -> '.$qd2->name;
        }
      }
    }
    $gtm_combi = str_replace('&nbsp;' , ' ' , $col['combi']);
        if ($col['discount_var'] == 'Rs')
    {
            $discount = $currency->symbol . ' ' . $col['discount'];
            $discount = trim($discount);
        }
    else
    {
            $discount = round($col['discount']) . ' ' . $col['discount_var'];
            $discount = trim($discount);
        }
        $price = $col['price'];
        $final_price = $col['final_price'];
    $discounted_price = $price - $final_price;
        $product_image_name = $col['product_image_name'];
        $combi = $col['combi'];
        $product_display_name = $col['product_display_name'];
        if(!empty($product_display_name))
    {
            $product_name = $product_display_name;
        }
    else
    {
            $product_name = $product_name;// . '<br>' . $combi;
        }
        unset($attribute);
        $attribute = $col['attribute'];
        $product_in_store_id = $col['product_in_store_id'];
        $product_combination_id = $col['product_combination_id'];
        $prod_in_cart = $col['prod_in_cart'];
        $prod_in_wishList = $col['prod_in_wishList'];
        $in_store_quantity = $col['quantity'];
        $stock_out_msg = $col['stock_out_msg'];
        //echo $combi;      
        //echo "<pre>";print_r($attribute);echo "</pre>";
        //echo $pre_url_product;
        //echo '<br>'.$ps_slug_url;
        $product_link =  'products-details/' . $product_id.'/'.$product_combination_id;
        if (!empty($ps_slug_url))
    {
      $product_link = '';
  //        $product_link .= base_url();
            if (!empty($pre_url_product))
      {
                $product_link .= $pre_url_product;
            }
            $product_link .= $ps_slug_url;
        }
        ?>
        
 <div class="product-miniature col-lg-<?=$_prow_count?> col-<?=$_prow_countm?>"> 
       

<div class="js-product product product-card">
                     
                           <div class="thumbnail-container reviews-loading">
                              <div class="ttproduct-image ttpc-parent">
                               <a href="<?= $product_link ?>" title="<? echo $product_name; ?> ">
                                 <img class="ttproduct-img1 img-fluid lazy_product "  data-src="<?=_uploaded_files_?>product/medium/<? echo $product_image_name; ?>" data-page_count="<? echo $page_count; ?>" alt="<? echo $product_name; ?>" title="<? echo $product_name; ?>" data-full-size-image-url="<?=_uploaded_files_?>product/medium/<? echo $product_image_name; ?>" data-callfor='<?=$callFor?>' >
                                </a>
                                 <ul class="product-flags">
                                    <li class="new">New product</li>
                                 </ul>
                                 <div class="ttproducthover ">
                                    <div class="tt-button-container">
                                    </div>
                                    <?php /*?><? if (!empty($discount) && $discount>0) { ?><span class="dis_section"> <span><?=$discounted_price?></span><div class="clearfix"></div>OFF</span><?php } ?><?php */?>
                                    <? if (!empty($discount) && $discount>0) { ?><span class="dis_section"> <span><?=$discount?></span><div class="clearfix"></div>OFF</span><?php } ?>
                                    <div class="wishlist">
                                       <span class="addToWishlist">
                                       <!--<i class="material-icons">favorite_border</i>-->
                                       <a class="cart_wishlist_<? echo $product_in_store_id; ?> dark-bg cart_wishlist_n_<? echo $product_in_store_id; ?> addToWishlistListBTN<? echo ($offset!=1)?$offset:'' ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,1" title="Add to Wishlist - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" style="cursor: pointer; <? if ($prod_in_wishList <= 0) { echo " display:inline-block";} else {echo "display:none";} ?> " ><i class="material-icons">favorite_border</i></a>
            
            <a class="cart_wishlist_<? echo $product_in_store_id; ?> light-bg cart_wishlist_y_<? echo $product_in_store_id; ?> addToWishlistListBTN<? echo ($offset!=1)?$offset:'' ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,2" title="Remove from Wishlist - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" style="cursor: pointer; <? if ($prod_in_wishList >= 1) {echo " display:inline-block";} else {echo "display:none";} ?> " ><i class="material-icons">favorite_border</i></a>
                                       </span>
                                       
                                         <a  style="cursor: pointer;" onclick="product_quick_view_func(<?=$product_id?> , <?=$product_combination_id?>)" title="Quick View - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" class="addToview" >
                                       <i class="material-icons">zoom_in</i>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                      
                           <div class="ttproduct-desc text-center">
                           <a href="<?= $product_link ?>" title="<? echo $product_name; ?> ">
                              <div class="product-description">
                                 <h2 class="h3 product-title  product-card__title" style="font-size: 13px"><? echo $product_name; ?> -<?=$combi?></h2>
                                 <div class="product-desc-short"></div>
                                 <div class="product-price-and-shipping">
                                    <span class="price">₹ <? echo number_format($final_price) ?></span>
                                    <? if (!empty($discount) && $discount>0) { ?><span class="sr-only">Price</span>&nbsp;<strike><i class="fa fa-inr"></i> <? echo number_format($price) ?></strike>&nbsp;<span class="pdisc">Save <i class="fa fa-inr"></i> <?=number_format($discounted_price)?> Off</span><?php } ?>
                                   
                                 </div>
                              </div>
                           </a>
                              <?php if ($in_store_quantity > 0) { ?>
                              
                              <?php /*?><input type="button" value="Add to cart" class="adtocart"><?php */?>
                              <button></button>
                              <div  class=" productAddShow_<? echo $product_in_store_id; ?>" <? if (!empty($prod_in_cart) || $prod_in_cart > 0) { ?> style="display:none;" <? } ?>>
                <button type="button" title="Add To Cart - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" class=" adtocart ad_crt2_btn addToCartListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,2">Add to cart</button>
                </div>
                
                <div class=" go_to_cart qty_increDecre_<? echo $product_in_store_id; ?>" style="display:<? if (!empty($prod_in_cart) || $prod_in_cart > 0) {echo " block";} else {echo "none";} ?>">
                <button  class="adtocart selected_c" <?php /*?>href="<?=__cart__?>"<?php */?> onclick="cartopenNav()" target="_blank" title="Go to cart"  >Go to cart</button>
                </div>
                                
                                
                                
                                
                               
                              
                              <?php } else{ ?>
                      
                      <span class="out-of-stock out-of-stock-dtails sold_out"><? echo $stock_out_msg; ?></span>
                      <? } ?>
                           </div>
                        </div> 
                         </div>


<? } ?>





 <? }else{ ?>
  
    <div class="row " style="clear: both;padding: 20px;font-weight: 600;font-size: 18px;text-shadow: 1px 4px 6px #b1b1b1;"><?php /*?>No product found. Please refine search criteria<?php */?>
    <div class="no_prd_found"><span>Sorry!</span> No Product Found</div>
    <img src="<?='assets/front/images/no-product.jpg'?>" class="responsiveImg">
    </div>
   
  
<? } ?>
</div>
</center>