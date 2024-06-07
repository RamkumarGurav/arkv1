
<?
$offset = '';
//getCurrencyPrice
$CI = &get_instance();
$selected_product_image_id='';
foreach ($products_list as $col) {
	 //echo "<pre>";
//	 print_r($col);
//	 echo "</pre>";
	$product_name = $col['name'];
	$product_id = $col['product_id'];
	$short_description = $col['short_description'];
	$manufacturer_name = (!empty($col['manufacturer_name']))?$col['manufacturer_name']:'';
	$description =(!empty($col['description']))?$col['description']:'';
	$how_to_use = (!empty($col['how_to_use']))?$col['how_to_use']:''; 
	$totalrating = $col['totalrating']; //echo $totalrating;
	$totalreview = $col['totalreview']; //echo $totalreview;
	$avgrating = $col['avgrating'];
	$onerating = $col['onerating'];
	$tworating = $col['tworating'];
	$threerating = $col['threerating'];
	$fourrating = $col['fourrating'];
	$fiverating = $col['fiverating'];
	$product_use_info = $col['product_use_info'];
	$is_sell_local = (!empty($col['is_sell_local']))?$col['is_sell_local']:''; 

if(empty($selected_combination_id))
{
	foreach($col['product_combination'] as $cpc)
	{
		if($cpc['product_combination_id'] == $_POST['product_combination_id']){
			$selected_combination_id = $default_product_combination_id = $product_combination_id = $cpc['product_combination_id'];
			break;
		}
	}
}
//echo $selected_combination_id;
//$selected_combination_id = $default_product_combination_id = $product_combination_id = $_POST['product_combination_id'];

$selected_product_image_id='';

foreach($col['product_combination'] as $cpc)
{
	if($cpc['product_combination_id'] == $selected_combination_id)
	{
	//Default combination details
	$temp_currency_id = $this->session->userdata('application_sess_currency_id');
	$selected_product_image_id = $cpc['product_image_id'];
		if(empty($temp_currency_id) || $temp_currency_id==1)
		{
			if ($cpc['discount_var'] == 'Rs') {
				$discount = $currency->symbol . ' ' . $cpc['discount'];
				$discount = trim($discount);
			} else {
				$discount = round($cpc['discount']) . ' ' . $cpc['discount_var'];
				$discount = trim($discount);
			}
			$price = $cpc['price'];
			$final_price = $cpc['final_price'];
		}
		else
		{
			if ($cpc['other_discount_var'] == 'Rs') {
				$discount = $cpc['other_discount'];
				$discount = trim($discount);
			} else {
				$discount = $cpc['other_discount'] . ' ' . $cpc['other_discount_var'];
				$discount = trim($discount);
			}
			$price = $cpc['other_price'];
			$final_price = $cpc['other_final_price'];
		}
	$discounted_price = $price - $final_price;
	
	$product_image_name = $cpc['product_image_name'];
	
	$r_product_name = $cpc['product_display_name'];
	$r_combi = $cpc['combi'];
	$combi = $cpc['combi'];
	$combi_ref_code =  $cpc['ref_code'];
	$product_in_store_id = $cpc['product_in_store_id'];
	$default_product_combination_id = $product_combination_id = $cpc['product_combination_id'];
	$prod_in_cart = $cpc['prod_in_cart'];
	$prod_in_wishList = $cpc['prod_in_wishList'];
	$delivery_charges = $cpc['delivery_charges'];
	$product_display_name = $cpc['product_display_name'];
	$model_number = $cpc['model_number'];
	if (!empty($product_display_name)) {
		//$product_name = $product_display_name;
	} else {
		//$product_name = $product_name . '<br>' . $combi;
		$product_name = $product_name;
	}
	$current_viewers_msg = $cpc['current_viewers_msg'];
	$current_sold_msg = $cpc['current_sold_msg'];
	$is_msg_dynamic = $cpc['is_msg_dynamic'];
	$in_store_quantity = $cpc['quantity'];
	$stock_out_msg = $cpc['stock_out_msg'];
	}}
	
}
//print_r($product_image_name = $cpc);
$SimagePath = _uploaded_files_.'product/small/';
$MimagePath = _uploaded_files_.'product/medium/';
$LimagePath = _uploaded_files_.'product/large/';
//setTimeout(function(){ $('head').append( '<meta property="og:title" content="short title of your website/webpage" />' ); }, 1500);
//<meta property="og:title" content="short title of your website/webpage" />/
//<meta property="og:url" content="https://www.example.com/webpage/" />
//<meta property="og:description" content="description of your website/webpage">
//<meta property="og:image" content="//cdn.example.com/uploads/images/webpage_300x200.png">
//<meta property="og:type" content="article" />
//<meta property="og:locale" content="en_US" />
$og_title=$product_name;
if(!empty($meta_title))
{ $og_title=$meta_title; }

$product_link = base_url() . 'products-details/' . $product_id;
        if (!empty($product_seo_list[0]->slug_url)) {
            $product_link = '';
            $product_link .= base_url();
            if (!empty($pre_url_product)) {
                $product_link .= $pre_url_product;
            }
            $product_link .= $product_seo_list[0]->slug_url;
        }
$og_url = $product_link;
$og_description = $short_description;
if(!empty($meta_description))
{ $og_description=$meta_description; }
$og_product_image_name='';
//$og_product_image_name = $SimagePath.$cpc['product_image_name'];



if(empty($product_specification))
{
	$product_specification = array();
}
$product_specification_temp[] = array('info_title'=>"Brand" , 'info'=>$manufacturer_name);
if(!empty($current_category)){
$product_specification_temp[] = array('info_title'=>"Category" , 'info'=>$current_category->name);
}
if(!empty($model_number)){
$product_specification_temp[] = array('info_title'=>"Model" , 'info'=>$model_number);
}
$product_specification = array_merge($product_specification_temp , $product_specification);

$products_image_d= array();
$products_image_o= array();
//echo "<pre>"; print_r($products_image); echo "</pre>";
foreach ($products_image as $pi) {
	if($selected_product_image_id==$pi['product_image_id'])
	{
		$products_image_d[] = $pi;
	}
	else
	{
		$products_image_o[] = $pi;
	}
	
}
$products_image = array_merge($products_image_d , $products_image_o);
//echo "$LimagePath";
//echo "<pre>";print_r($products_image_d);echo "</pre>";
?>
<div class="main_banner prodct_sec1 container">		
    <div class="row prodct_wrap"> 
        <div class="col-md-6 prdt-sticky-top">
            <div class="Product-popImg">
                <? foreach ($products_image as $pi) { ?>
                    <img src='<?= $LimagePath . $pi['product_image_name'] ?>' class="image" alt="<?= $product_name ?>" title="<?= $product_name ?>">
                <? } ?>
            </div>
        </div>
        <div class="prodct_det2 product_cnt col-md-6">
            <h2 class="prodt_head1"><?= $product_display_name ?></h2>
 <div class="rate_setion">
                <div class="rate">
                <div class="star-rating rating-xs rating-disabled"><div class="clear-rating " title="Clear"><i class="glyphicon glyphicon-minus-sign"></i></div><div class="rating-container rating-gly-star" data-content="☆☆☆☆☆"><div class="rating-stars" data-content="☆☆☆☆☆" style="width: 0%;"></div>
               <!--  <input id="input-21b" value="<? echo number_format($avgrating, 1);?>" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="xs" required title="" disabled="disabled"> -->
            </div><div class="caption"><span class="label label-default"></span></div></div>  <span class="rating_valu">(<?= $totalreview ?>)</span>
                                   </div>
            </div>
         
            
            <? if (!empty($product_use_info)) { ?>
            
                <ul class="prdoct_fetr">
                    <? foreach ($product_use_info as $pui) { ?>
                        <li><img src="<?= base_url() ?>assets/front/images/product-use-info-icons/<?= $pui->image ?>"><?= $pui->content ?></li>
                    <? } ?>
                </ul>
            <? } ?>
            <div class="ProdtDescHeight">
            
                <p class="main_parag2"> <?=$short_description?>
                </p>
                
            </div>
            
            
            
            <?
			$offer_class_quick_view = 'offer_tag_quick';
			 include(APPPATH.'views/template/product-list-detail.php'); ?>
            
            <?
			
//echo "<pre>";print_r($products_list);echo "</pre>";
if(count($products_list[0]['product_combination'])>1){
?>

        
        <? //$this->load->view('templates/product-list',$this->data); ?>

<?

foreach($products_list[0]['product_combination'] as $r_pc){
if($default_product_combination_id != $r_pc['product_combination_id'])
{
$r_product_name = $r_pc['product_display_name'];
$r_combi = $r_pc['combi'];

$product_image_name = $r_pc['product_image_name'];
$ps_slug_url = $r_pc['ps_slug_url'];
$combi = $r_pc['combi'];
$combi_ref_code =  $r_pc['ref_code'];
$product_in_store_id = $r_pc['product_in_store_id'];
$product_combination_id = $r_pc['product_combination_id'];
$prod_in_cart = $r_pc['prod_in_cart'];
$prod_in_wishList = $r_pc['prod_in_wishList'];
$delivery_charges = $r_pc['delivery_charges'];
$product_display_name = $r_pc['product_display_name'];
$model_number = $r_pc['model_number'];
if (!empty($product_display_name)) {
$product_name = $product_display_name;
} else {
//$product_name = $product_name . '<br>' . $combi;
$product_name = $product_name;
}
$current_viewers_msg = $r_pc['current_viewers_msg'];
$current_sold_msg = $r_pc['current_sold_msg'];
$is_msg_dynamic = $r_pc['is_msg_dynamic'];
$in_store_quantity = $r_pc['quantity'];
$stock_out_msg = $r_pc['stock_out_msg'];
                
$temp_currency_id = $this->session->userdata('application_sess_currency_id');
if(empty($temp_currency_id) || $temp_currency_id==1)
{
    if ($r_pc['discount_var'] == 'Rs') {
        $discount = $currency->symbol . ' ' . $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $r_pc['discount']));
        $discount = trim($discount);
    } else {
        $discount = round($r_pc['discount']) . ' ' . $r_pc['discount_var'];
        $discount = trim($discount);
    }
    $price = $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $r_pc['price']));
    $final_price = $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $r_pc['final_price']));
}
else
{
    if ($r_pc['other_discount_var'] == 'Rs') {
        $discount = $currency->symbol . ' ' . $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $r_pc['other_discount']));
        $discount = trim($discount);
    } else {
        $discount = $r_pc['other_discount'] . ' ' . $r_pc['other_discount_var'];
        $discount = trim($discount);
    }
    $price = $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $r_pc['other_price']));
    $final_price = $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $r_pc['other_final_price']));
}
$product_link = base_url() . 'products-details/' . $product_id.'/'.$product_combination_id;
if (!empty($ps_slug_url)) {
    $product_link = '';
    $product_link .= base_url();
    if (!empty($pre_url_product)) {
        $product_link .= $pre_url_product;
    }
    $product_link .= $ps_slug_url;
}
if($product_combination_id==$_POST['product_combination_id'])
{

            ?>
            
            

        <div class="product_sec1">
            <h4>offer_tag_quick<?= $r_product_name ?> - <?=$r_combi?></h4>
            <h4 class="prodct_prce">
            <? if (!empty($discount)) { ?><span class="old_price"><?= $currency->symbol ?> <? echo $price ?></span><? } ?>
                <span class="new_price"><?= $currency->symbol ?> <? echo $final_price ?></span>
                <span class="offer_tag_quick"><? if (!empty($discount)) { ?> <?= $discount ?> OFF<? } ?></span>
                
            </h4>
            
            <div class="button_wrap ">
            
            
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
                <div >
                    <span class="out-of-stock out-of-stock-dtails sold_out"><? echo $stock_out_msg; ?></span>
                        <span class="quantity_hd">Email : </span>

                        <input class="profil_form email-notification notfy_mail" type="email" name="notify_email" id="notify_email" value="<? if (!empty($customers->email)) {
                                                                                                                        echo $customers->email;
                                                                                                                    } ?>" />
                        <span class="error_span"></span>

                        <button class="notify_btn1 notify_buton addToNotifyMeListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>">Notify Me <i class="icon ion-ios-notifications"></i> </button>
                    <? } ?>
            
                <a class="crt_button3 wishlist-i cart_wishlist_<? echo $product_in_store_id; ?> cart_wishlist_n_<? echo $product_in_store_id; ?> addToWishlistListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,1"  title="Add to Wishlist - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" style=" <? if ($prod_in_wishList <= 0) { echo " display:inline-block";} else {echo "display:none";} ?> " ><i class="fa fa-heart-o"></i></a>
                
                <a class="crt_button3 wishlist-i cart_wishlist_<? echo $product_in_store_id; ?> cart_wishlist_y_<? echo $product_in_store_id; ?> addToWishlistListBTN<? echo $offset ?>" data-val="<? echo $product_in_store_id; ?>,<? echo $product_id; ?>,<? echo $product_combination_id; ?>,2"  title="Remove from Wishlist - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>" style=" <? if ($prod_in_wishList >= 1) {echo " display:inline-block";} else {echo "display:none";} ?> " ><i class="fa fa-heart"></i></a>
            </div>
            </div>
            </div>
            	
            
<? }}} ?>

<?
}?> 
			<div class="col-md-12 text-right prdt-sticky-btm">
            	<a href="<?= $og_url?>" class="themeBtn" title="View More - <? echo $product_name; ?> - <? echo str_replace('&nbsp;' , ' ' , $combi); ?>">View More</a>
            </div>
        </div> 
    </div> 
</div>


<script>


window.addEventListener('load' , function(){  
	$('.changeDescHeight').click(function(){
		$(this).parent().toggleClass('show');									  
	})

  var owl_1 = $('#owl-1');

  var owl_2 = $('#owl-2');  

  owl_1.owlCarousel({

    loop:false,

    margin:10,

    nav:false,

    items: 1,

    dots: false

  });

  

  owl_2.owlCarousel({

    margin:10,

    nav: true,

	navText: [

		"<i class='fa fa-caret-left'></i>",

		"<i class='fa fa-caret-right'></i>"

	],

    items: 5,

	animateOut: 'slideOutUp',

	animateIn: 'slideInUp',

    dots: false

  });

  

  owl_2.find(".item").click(function(){

    var slide_index = owl_2.find(".item").index(this);

    owl_1.trigger('to.owl.carousel',[slide_index,300]);

  });

  

  // Custom Button

  $('.customNextBtn').click(function() {

    owl_1.trigger('next.owl.carousel',500);

  });

  $('.customPreviousBtn').click(function() {

    owl_1.trigger('prev.owl.carousel',500);

  }); });
</script>




<?
if(!empty($product_seo_list))
{
	$slug_url = $product_seo_list[0]->slug_url;
	$product_url = base_url().$pre_url_product.$slug_url;
}
else
{
	$product_url = base_url() . 'products-details/' . $product_id.'/'.$product_combination_id;
}

?>

<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "<? echo $product_name;?>@Rs.<? echo $final_price;?>",
  "image":    "<? echo $LimagePath . $product_image_name;?>",
  "description": "<? echo $meta_description;?>",
  "sku": "<? echo $combi_ref_code;?>",
  "mpn": "<? echo $combi_ref_code;?>",
  "brand": {
    "@type": "Thing",
    "name": "Annadatha"
  },
  "review": {
    "@type": "Review",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "4.6",
      "bestRating": "5"
    },
    "author": {
      "@type": "Person",
      "name": "Annadatha"
    }
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "90"
  },
  "offers": {
    "@type": "Offer",
    "url": "<? echo $product_url;?>",
    "priceCurrency": "INR",
    "price": "<? echo $final_price;?>",
    "priceValidUntil": "2025-12-12",
    "itemCondition": "New",
    "availability": "InStock",
    "seller": {
      "@type": "Organization",
      "name": "Annadatha"
    }
  }
}
</script>
<script type="application/ld+json">
{"@context":"https:\/\/schema.org\/",
"@type":"BreadcrumbList","itemListElement":
	[
		{
		"@type":"ListItem",
		"position":1,
		"item":
			{"name":"Home",
			"@id":"<? echo MAINSITE;?>",
			"image": "<? echo $LimagePath . $product_image_name;?>"
			}
		},
		{"@type":"ListItem",
		"position":2,
		"item":
			{"name":"<? echo $product_name;?>",
			"@id":"<? echo base_url().$pre_url_product;?>",
			"image": "<? echo $LimagePath . $product_image_name;?>"
			}
		},
		{	
		"@type":"ListItem",
		"position":3,
		"item":
			{"name":"<? echo $product_name;?>",
			"@id":"<? echo $product_url;?>",
			"image": "<? echo $LimagePath . $product_image_name;?>"
			}
		}
	]
}
</script>
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"Place",
  "image": "<? echo $LimagePath . $product_image_name;?>",
  "@id":"<? echo $product_url;?>",
  "name":"Rs.<? echo $final_price;?>-<? echo $product_name;?> Annadatha",
  "address":{
    "@type":"PostalAddress",
    "streetAddress":"MPP Complex, Shop No. 14 15 Siddipet Road Ramayampet Medak",
    "addressLocality":"Telangana",
    "addressRegion":"Telangana",
    "postalCode":" 502101",
    "addressCountry":"IND"
  },
  "geo":{
    "@type":"GeoCoordinates",
    "latitude":18.0813922,
    "longitude":78.3883787
  },
  "telephone":"+91 9392199595",
  "potentialAction":{
    "@type":"ReserveAction",
    "target":{
      "@type":"EntryPoint",
      "urlTemplate":"https://g.page/Annadatha?share",
      "inLanguage":"en-US",
      "actionPlatform":[
        "https://schema.org/DesktopWebPlatform",
        "https://schema.org/IOSPlatform",
        "https://schema.org/AndroidPlatform"
      ]
    },
    "result":{
      "@type":"Reservation",
      "name":"<? echo $product_name;?>"
    }
  }
}
</script>



<script>

waShBtn = function() {
  if( this.isIos === true ) {
    var b = [].slice.call( document.querySelectorAll(".wa_btn") );
    for (var i = 0; i < b.length; i++) {
      var t = b[i].getAttribute("data-text" , '<?=$og_title?>');
      var u = b[i].getAttribute("data-href" , '<?=$og_url?>');
      var o = b[i].getAttribute("href");
      var at = "whatsapp://send?text=" + encodeURIComponent( t );
      if (t) {
          at += "%20%0A";
      }
      if (u) {
          at += encodeURIComponent( u );
      } else {
          at += encodeURIComponent( document.URL );
      }
      b[i].setAttribute("href", o + at);
      b[i].setAttribute("target", "_top");
      b[i].setAttribute("target", "_top");
      b[i].className += ' activeWhatsapp';
    }
  }
  else{
    var b = [].slice.call( document.querySelectorAll(".wa_btn") );
    for (var i = 0; i < b.length; i++) {
      var t = b[i].getAttribute("data-text" , '<?=$og_title?>');
      var u = b[i].getAttribute("data-href" , '<?=$og_url?>');
      var o = b[i].getAttribute("href");
      var at = "https://web.whatsapp.com?text=" + encodeURIComponent( t );
      if (t) {
          at += "%20%0A";
      }
      if (u) {
          at += encodeURIComponent( u );
      } else {
          at += encodeURIComponent( document.URL );
      }
      b[i].setAttribute("href", o + at);
      b[i].setAttribute("target", "_top");
      b[i].setAttribute("target", "_top");
      b[i].className += ' activeWhatsapp';
    }
  }
}

waShBtn.prototype.isIos = ((navigator.userAgent.match(/Android|iPhone/i) && !navigator.userAgent.match(/iPod|iPad/i)) ? true : false);

var theWaShBtn = new waShBtn();
</script>