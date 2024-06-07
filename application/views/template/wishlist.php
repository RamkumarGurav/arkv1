				
<? $CI=&get_instance(); ?>

<?
$total = 0;
$sub_total = 0;
$total_saving = 0;
$total_prod = 0;
$display_body='';
$currency = (object)array("symbol" => '<i class="fa fa-inr"></i>');
$SimagePath = _uploaded_files_ . 'product/small/';
if(!empty($products_list)){
?>


<? //echo "<pre>"; print_r($products_list); echo "</pre>";
foreach($products_list as $col){ 
			$product_name = $col['name'];
			$product_id = $col['product_id'];			
			if(empty($col['brand_name'])){$col['brand_name'] = '';}
			$brand_name = $col['brand_name'];
			$short_description = $col['short_description'];
			//Default combination details
			foreach($col['product_combination'] as $row){
			if($row['discount_var']=='Rs')
{
	$discount = $currency->symbol.' '.$CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['discount']));$discount = trim($discount);
}
else
{
	$discount = round($row['discount']).' '.$row['discount_var'];$discount = trim($discount);
}
				//$discount = $row['discount'].' '.$row['discount_var'];$discount = trim($discount);
				$price = $CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['price']));
				$final_price = $CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['final_price']));
				$product_image_name = $row['product_image_name'];
				$combi = $row['combi'];
				$ps_slug_url = $row['ps_slug_url'];
				$product_in_store_id = $row['product_in_store_id'];
				$product_combination_id = $row['product_combination_id'];
				$prod_in_cart = $row['prod_in_cart'];
				$prod_in_wishList = $row['prod_in_wishList'];
				$in_store_quantity = $row['quantity'];
				$stock_out_msg = $row['stock_out_msg'];
				$quantity_per_order = $row['quantity_per_order'];
				$offset='';
				$total_prod+=$prod_in_cart;
				$total+=$prod_in_cart*$final_price;
				$sub_total+=$prod_in_cart*$final_price;
				$total_saving+=$prod_in_cart*$price;
				
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
<div class="proditem" infinite-scroll="">
                                <div class="leftside-icons">
                                  <a class="product-item-photo aClick_2 aClick_1" href="<?=$product_link?>" title="">
                                  <img class="pro-img" width="100px" height="100px" src="<?=$SimagePath.$product_image_name?>" alt="<?=$product_name?>" title="<?=$product_name?>"></a>
                                </div>
                                
                                <div class="rightside-details">
                                  <div class="row m-0">
                                    <div class="product-item-name col-lg-8 col-md-6 pl-0">
                                       <a href="<?=$product_link?>" title="" class="aClick_2 aClick_1"><?=$product_name?><br><small><?=$combi?></small></a>
                                    </div>
                                    
                                    <div class="item-prices col-lg-4 col-md-6 p-0 text-right">
                                      <span class="itemprice"><?=$currency->symbol.' '.$final_price?></span>
                                      <? if(!empty($discount) && $discount>0){ ?>
                                                                             <span class="price_old"><?  echo $discount." OFF"; ?></span>
                                      <span class="mrpprice">M.R.P: <span><?=$currency->symbol.' '.$price?></span></span>
                                      <? } ?>
                                                                                                       </div>
                                  </div>
                                      
                                  <div class="row m-0">
                                    <div class="mfr-name col-lg-7 col-md-6 pl-0"><!----><p _ngcontent-ynj-c9="" class="m-0 mt-1">By: <a href="<?=$product_link?>"><?=$brand_name?></a></p></div>
                                    <div class="addtocartbox col-lg-5 col-md-6 p-0 text-right"><!----><!----><!----><!----><!---->
                                    
                                    
               
                <button type="button" class="cart_buton3 bg btn btn-default WishlistListBTN move-to-cart-btn" data-val='<?=$product_in_store_id?>,<?=$product_id?>,<?=$product_combination_id?>,4'>Move to Cart <i class="fa fa-shopping-cart"></i></button>
                
                <a class="delete WishlistListBTN btn btn-danger aClick_2 aClick_1" data-val="<?=$product_in_store_id?>,<?=$product_id?>,<?=$product_combination_id?>,2"><i class="fa fa-trash"></i></a>
                                    
                                      
                                          <div class="remove-drug mt-2 d-none">
                                            <a class="action action-delete removeitem aClick_2 aClick_1" href="javascript:void(0);" title="Remove item">Remove</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>


<? }}?>
<? }else{ ?>
<?php /*?><article class="cart_tabs_1 clearfix col-lg-12 cart-indi">
	<img src="<?=__scriptFilePath__?>images/icons/heart.png" class="empty_notif_2">
	
    <span class="empty_notif_1">your wishlist is empty</span>
    <a href="<?=base_url()?>all-products" class="empty_notif_3"><button class="proceed_ckt"><i class="fa fa-shopping-cart"></i> <span> Continue Shopping</span></button></a>
</article><?php */?>

<article class="cart_tabs_1 clearfix col-md-12 cart-indi wishlistPageEmpty">
	<img src="<?=__scriptFilePath__?>images/empty-wishlist.png" class="empty_notif_2">
	
    <!--<span class="empty_notif_1">your wishlist is empty</span>-->
    <a href="<?=base_url()?>all-products" class="empty_notif_3"><button class="proceed_ckt"><i class="fa fa-shopping-cart"></i> <span> Continue Shopping</span></button></a>
</article>

<? } ?>

<script>

window.addEventListener('load' , function(){
	setWishlistBtn();
})
</script>
                        