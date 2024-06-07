<!--
     <link rel="stylesheet" type="text/css" href="assets/front/css/jquery.fancybox.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/front/css/helpers/jquery.fancybox-buttons.css" /> -->

<?
$offset = '';
$CI = &get_instance();
foreach ($products_list as $col) {
   //	echo "<pre>"; print_r($col); echo "</pre>";
   $is_bulk_enquiry = $col['is_bulk_enquiry'];
   $product_main_name = $product_name = $col['name'];
   $product_id = $col['product_id'];
   $short_description = $col['short_description'];
   $brand_name = $col['brand_name'];
   $description = $col['description'];
   $application = $col['application'];
   $totalrating = $col['totalrating']; //echo $totalrating;
   $totalreview = $col['totalreview']; //echo $totalreview;
   $avgrating = $col['avgrating'];
   $onerating = $col['onerating'];
   $tworating = $col['tworating'];
   $threerating = $col['threerating'];
   $fourrating = $col['fourrating'];
   $fiverating = $col['fiverating'];
   $product_use_info = $col['product_use_info'];

   if (empty($selected_combination_id)) {
      foreach ($col['product_combination'] as $cpc) {
         $selected_combination_id = $default_product_combination_id = $product_combination_id = $cpc['product_combination_id'];
         break;
      }
   }
   $selected_product_image_id = '';
   //echo "<pre>"; print_r($col['product_combination']); echo "</pre>";
   foreach ($col['product_combination'] as $cpc) {
      if ($cpc['product_combination_id'] == $selected_combination_id) {
         //Default combination details
         $selected_product_image_id = $cpc['product_image_id'];
         $temp_currency_id = $this->session->userdata('application_sess_currency_id');
         //echo "temp_currency_id : $temp_currency_id </br>";
         if (empty($temp_currency_id) || $temp_currency_id == 1) {
            if ($cpc['discount_var'] == 'Rs') {
               $discount = $currency->symbol . ' ' . $cpc['discount'];
               $discount = trim($discount);
            } else {
               $discount = round($cpc['discount']) . ' ' . $cpc['discount_var'];
               $discount = trim($discount);
            }
            $price = $cpc['price'];
            $final_price = $cpc['final_price'];
            $discounted_price = $price - $final_price;
         } else {
            if ($cpc['other_discount_var'] == 'Rs') {
               $discount = $currency->symbol . ' ' . $cpc['other_discount'];
               $discount = trim($discount);
            } else {
               $discount = $cpc['other_discount'] . ' ' . $cpc['other_discount_var'];
               $discount = trim($discount);
            }
            $price = $cpc['other_price'];
            $final_price = $cpc['other_final_price'];
            $discounted_price = $price - $final_price;
         }

         //	echo "final_price : $final_price </br>";
         $product_image_name = $cpc['product_image_name'];

         $r_product_name = $cpc['product_display_name'];
         $r_combi = $cpc['combi'];
         $combi = $cpc['combi'];

         //echo "<pre>"; print_r($cpc['combi']); echo "</pre>";



         $combi_ref_code = $cpc['ref_code'];
         $combi_product_l = $cpc['product_l'];
         $combi_product_b = $cpc['product_b'];
         $combi_product_h = $cpc['product_h'];

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
         $product_weight = $cpc['product_weight'];

         break;
      }
   }

}
//print_r($product_image_name = $cpc);
$SimagePath = _uploaded_files_ . 'product/small/';
$MimagePath = _uploaded_files_ . 'product/medium/';
$LimagePath = _uploaded_files_ . 'product/large/';
$LimagePath = 'assets/uploads/product/large/';
//setTimeout(function(){ $('head').append( '<meta property="og:title" content="short title of your website/webpage" />' ); }, 1500);
//<meta property="og:title" content="short title of your website/webpage" />/
//<meta property="og:url" content="https://www.example.com/webpage/" />
//<meta property="og:description" content="description of your website/webpage">
//<meta property="og:image" content="//cdn.example.com/uploads/images/webpage_300x200.png">
//<meta property="og:type" content="article" />
//<meta property="og:locale" content="en_US" />
$og_title = $product_name;
if (!empty($meta_title)) {
   $og_title = $meta_title;
}

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
if (!empty($meta_description)) {
   $og_description = $meta_description;
}
$og_product_image_name = '';
//$og_product_image_name = $SimagePath.$cpc['product_image_name'];



if (empty($product_specification)) {
   $product_specification = array();
}
if (!empty($current_category)) {
   $product_specification_temp[] = array('info_title' => "Category", 'info' => $current_category->name);
}
if (!empty($model_number)) {
   //$product_specification_temp[] = array('info_title'=>"Model" , 'info'=>$model_number);
}
//$product_specification = array_merge($product_specification_temp , $product_specification);

$products_image_d = array();
$products_image_o = array();

foreach ($products_image as $pi) {
   if ($selected_product_image_id == $pi['product_image_id']) {
      $products_image_d[] = $pi;
   } else {
      $products_image_o[] = $pi;
   }

}
$products_image = array_merge($products_image_d, $products_image_o);
//echo $selected_combination_id;
//echo "<pre>";print_r($cpc);print_r($products_image);echo "</pre>";
?>
<style>
   .carousel-dark .carousel-indicators [data-bs-target] {
      background-color: #fff !important;
      position: relative;
      width: 100%;
      max-width: 400px;
      margin: auto;

   }

   .carousel-dark .carousel-indicators [data-bs-target] img {
      vertical-align: middle;
      width: 100%;
      object-fit: contain;
      padding: 10px;
      border: 1px solid #e2e2e2;
      margin-bottom: 10px;
      height: 100px;
   }
</style>
<? if ($is_bulk_enquiry == 1) { ?>
   <div class="modal  fade" id="mycomment" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog " role="document">
         <div class="modal-content ">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Enquire for bulk Order</h5>
               <button type="button" class="close" data-bs-dismiss="modal">×</button>
            </div>
            <!--  <div class="modal-header">
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Enquire for bulk Order</h4>
            <span id="user_pin_close"></span>
            </div> -->
            <div class="modal-body modal_space">
               <div class="row ">
                  <div class=" col-md-12 col-sm-12  wow animated slideInLeft" data-wow-delay=".5s">
                     <div id='bulk_enquiry_form_msg'></div>
                     <div class="alert alert-danger hidden" role="alert" id='bulk_enquiry_form_err'></div>
                  </div>
                  <?php echo form_open(base_url() . __contactUs__, array('method' => 'post', 'id' => 'bulk_enquiry_form', 'name' => 'bulk_enquiry_form', 'style' => '', 'class' => '')); ?>
                  <input type="hidden" name="product_id" value="<?= $product_id ?>" />
                  <input type="hidden" name="product_name" value="<?= $product_main_name ?>" />
                  <?php echo $message; ?>
                  <div id='not_find_product_form_msg'></div>
                  <div class="alert alert-danger hidden" role="alert" id='not_find_product_form_err'></div>
                  <div class="row">
                     <div class=" col-md-6 col-sm-12  wow animated slideInLeft" data-wow-delay=".5s">
                        <div class="position-R form-group">
                           <span class="placeholder_label">Name *</span>
                           <?php
                           $value = '';
                           if (!empty($customers->name)) {
                              $value = $customers->name;
                           } else {
                              $value = set_value('name');
                           }
                           $attributes = array(
                              'name' => 'name',
                              'id' => 'name',
                              'value' => $value,
                              'class' => 'profil_form',
                              'placeholder' => 'Name *',
                              'autofocus' => 'autofocus',
                              'type' => 'text',
                              'required' => 'required'
                           );
                           echo form_input($attributes); ?>
                        </div>
                     </div>
                     <div class=" col-md-6 col-sm-12  wow animated slideInLeft" data-wow-delay=".5s">
                        <div class="position-R form-group">
                           <span class="placeholder_label">Email *</span>
                           <?php
                           $value = '';
                           if (!empty($customers->email)) {
                              $value = $customers->email;
                           } else {
                              $value = set_value('email');
                           }
                           $attributes = array(
                              'name' => 'email',
                              'id' => 'email',
                              'value' => $value,
                              'class' => 'profil_form',
                              'placeholder' => 'Email *',
                              'autofocus' => 'autofocus',
                              'type' => 'text',
                              'required' => 'required'
                           );
                           echo form_input($attributes); ?>
                        </div>
                     </div>
                     <div class=" col-md-6 col-sm-12  wow animated slideInLeft" data-wow-delay=".5s">
                        <div class="position-R form-group hasValue">
                           <span class="placeholder_label">Phone Number *</span>
                           <?php
                           $value = '';
                           if (!empty($customers->number)) {
                              $value = $customers->number;
                           } else {
                              $value = set_value('contact');
                           }
                           $attributes = array(
                              'name' => 'contact',
                              'id' => 'contact',
                              'value' => $value,
                              'class' => 'profil_form',
                              'placeholder' => 'Contact *',
                              'autofocus' => 'autofocus',
                              'type' => 'text',
                              'required' => 'required'
                           );
                           echo form_input($attributes); ?>
                        </div>
                     </div>
                     <div class=" col-md-6 col-sm-12  wow animated slideInLeft" data-wow-delay=".5s">
                        <div class="position-R form-group">
                           <span class="placeholder_label">Quantity *</span>
                           <?php
                           $value = '';
                           $value = set_value('bulk_quantity');
                           $attributes = array(
                              'name' => 'bulk_quantity',
                              'id' => 'bulk_quantity',
                              'value' => $value,
                              'class' => 'profil_form',
                              'placeholder' => 'Quantity *',
                              'autofocus' => 'autofocus',
                              'type' => 'text',
                              'required' => 'required'
                           );
                           echo form_input($attributes); ?>
                        </div>
                     </div>
                     <div class="col-xs-12 wow animated slideInRight" data-wow-delay=".5s">
                        <div class="position-R">
                           <span class="placeholder_label">Message *</span>
                           <?php
                           $attributes = array(
                              'name' => 'message',
                              'id' => 'message',
                              'value' => set_value('message'),
                              'class' => 'profil_form',
                              'placeholder' => 'Message *',
                              'autofocus' => 'autofocus',
                              'type' => 'text',
                              'style' => 'height:100px;resize:none;',
                              'rows' => 3,
                              'required' => 'required'
                           );
                           echo form_textarea($attributes); ?>
                        </div>
                     </div>
                  </div>
                  <div class="relative fullwidth col-xs-12">
                     <button type="button" onclick="validate_bulk_enquiry_form()" id="submit" name="EnquiryBTN" value="1"
                        class="save_button">Send Message</button>
                  </div>
                  <div class="clear"></div>
                  <?php echo form_close() ?>
               </div>
            </div>
         </div>
      </div>
   </div>
<? } ?>
<nav class=" text-center" aria-label="breadcrumbs">
   <div class="container">

   </div>
</nav>

<div class="mt-2">
   <div class="container-fluid mb-4">

      <div class="row ">
         <div class="col-md-8 mt-3">
            <div class="row">
               <div class="col-md-6">

                  <div class="sticky-carousel1">

                     <div class="card">
                        <div class="demo">
                           <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                              <div class="carousel-inner">
                                 <? $picount = 0;
                                 foreach ($products_image as $pi) {
                                    $picount++; ?>
                                    <div class="carousel-item <? if ($picount == 1) {
                                       echo "active";
                                    } ?>"
                                       data-bs-interval="10000">
                                       <div class="zoom-outer" data-image="<?= $LimagePath . $pi['product_image_name'] ?>">
                                          <figure class="zoom" onmousemove="zoom(event)"
                                             style="background-image: url(<?= $LimagePath . $pi['product_image_name'] ?>)">
                                             <img class="img-fluid" id="zoom"
                                                src="<?= $LimagePath . $pi['product_image_name'] ?>"
                                                alt="<?= $product_name ?>" title="<?= $product_name ?>" />
                                          </figure>
                                       </div>
                                    </div>
                                 <? } ?>
                              </div>
                              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                                 data-bs-slide="prev">
                                 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                 <span class="visually-hidden">Previous</span>
                              </button>
                              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                                 data-bs-slide="next">
                                 <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                 <span class="visually-hidden">Next</span>
                              </button>
                              <div class="carousel-indicators"
                                 style="position:relative !important;margin-right: 25% !important;    bottom: -5% !important;margin-bottom: 50px;">
                                 <? $picount = 0;
                                 foreach ($products_image as $pi) {
                                    ?>
                                    <button type="button" data-bs-target="#carouselExampleDark"
                                       data-bs-slide-to="<?= $picount ?>" class="active" aria-current="true"
                                       aria-label="Slide <? echo $picount + 1; ?>" style="    width: 80px;"> <img
                                          src="<?= $SimagePath . $pi['product_image_name'] ?>"
                                          data-mdb-img="<?= $LimagePath . $pi['product_image_name'] ?>"
                                          alt="<?= $product_name ?>" title="<?= $product_name ?>"
                                          class=" d-block w-100 img-fluid" style="height: auto !important" /></button>
                                    <? $picount++;
                                 } ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6 pb-right-column mt-3">
                  <nav class="breadcrumb brdpdng">
                     <ol>
                        <? echo $breadcrumbs; ?>&nbsp;<i class="fa fa-angle-right"></i>
                        <li>
                           <?= $product_name ?>
                        </li>
                     </ol>
                  </nav>

                  <h3 class="tt-product-category">
                     <? //=$sub_cat_slug ?><!-- Brass Products -->
                  </h3>
                  <h1 class="h1 tt-producttitle">
                     <?= $product_display_name ?>
                  </h1>


                  <div class="product-prices js-product-prices col-sm-10 col-xs-10">
                     <div class="product-price h5 ">
                        <div class="current-price d-flex align-items-center">
                           <span class="current-price-value" content="12.9"><?= $currency->symbol ?>
                              <? echo number_format($final_price) ?>
                           </span>&nbsp;
                           <? if (!empty($discount) && $discount > 0) { ?>
                              <strike class="strike"><?= $currency->symbol ?>
                                 <? echo number_format($price) ?>
                              </strike>&nbsp;<span class="pdisc1"><span class="disc-price">You Save:
                                    <span><span><?= $currency->symbol ?>
                                          <?= number_format($discounted_price) ?>
                                       </span></span></span></span>
                           <?php } ?>
                           <div class="showhim">
                              &nbsp;<img class="_3ECE0V" src="assets/front/images/price-info-icon.svg"
                                 id="price-info-icon">
                              <div class="showme">
                                 <div class="showme-main showme-content">
                                    <div class=""><strong>Price details</strong></div>
                                    <div class="">
                                       <div class="showme-price">
                                          <div class="">
                                             Maximum Retail Price
                                             <div class="">(incl. of all taxes)</div>
                                          </div>
                                          <div class=""> <?= $currency->symbol ?>
                                             <? echo number_format($price) ?>
                                          </div>
                                       </div>
                                       <? if (!empty($discount) && $discount > 0) { ?>
                                          <div class="showme-s-price">
                                             <div class="showme-price">
                                                <div class="">Selling Price</div>
                                                <div class=""> <?= $currency->symbol ?>
                                                   <? echo number_format($final_price) ?>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="">
                                             <div class="showme-overall">Overall you save <?= $currency->symbol ?>
                                                <? echo number_format($discounted_price) ?> on this product
                                             </div>
                                          </div>
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div><a onClick="callScrollView()" class="review-txt" style="cursor:pointer;">
                     Be the first to Review this product

                  </a>
                  <?
                  $short_description_string = strip_tags($short_description);

                  if (strlen($short_description_string) > 250) {

                     // truncate string
                     $short_description_stringCut = substr($short_description_string, 0, 250);
                     $endPoint = strrpos($short_description_stringCut, ' ');
                     $short_description_stringLeft = substr($short_description_string, $endPoint);

                     //if the string doesn't contain any space then it will cut without word basis.
                     $short_description_string = $endPoint ? substr($short_description_stringCut, 0, $endPoint) : substr($short_description_stringCut, 0);
                     $short_description_string .= '<span id="sd_read_more"> ... Read More </span> <span id="sd_read_more_content" style="display:none">' . $short_description_stringLeft . '</span>';
                  }
                  //echo $short_description_string;
                  ?>
                  <div class="product-information">
                     <div id="product-description-short-18">
                        <p class="main_parag2">
                           <?= $short_description_string ?><i class="fa fa-hand-o-left"></i>
                        </p>
                     </div>

                  </div>
                  <div>


                     <div class="clearfix"></div>
                     <span id='pd_read_more' style="display:none">Read more </span>
                     <div class="row">
                        <div class="col-lg-12">
                           <p class="newp"><strong>Product code:</strong>
                              <?= $combi_ref_code ?>
                           </p>

                        </div>
                     </div>

                  </div>
                  <div class="prdt_price_sec"><br>
                     <? if (_shipping_show_service_availablity == 1) { ?>
                        <div class="width100 _shipping_show_service_availablity_cl">
                           <div class="form-group">
                              <p><strong>Check Service Availability</strong></p>
                              <hr class="myNewHr" style="    margin: 9px 0 !important;">
                              <div class="input-group align-items-center">
                                 <input type="text" id="pincode_d" class="form-control" placeholder="6 Digit Pincode " />
                                 <span class="input-group-btn">
                                    <button type="button" onclick="getPincodeDetail()"
                                       class="btn btn-warning">Check</button>
                                 </span>
                                 <div id="PincodeData" style="    margin-left: 20px;"></div>
                              </div>

                           </div>
                        </div>
                     <? } ?>
                  </div>

                  <br>
               </div>
            </div>






            <!--     <div class="sticky-carousel">

<div class="exzoom hidden" id="exzoom">
    <div class="exzoom_img_box clinic-gallery-indi">
        <ul class='exzoom_img_ul '>
            <? $picount = 1;
            foreach ($products_image as $pi) {
               ?>
                    <a class="fancybox-buttons" href="<?= $LimagePath . $pi['product_image_name'] ?>" data-fancybox-group="button" ><li><img src="<?= $LimagePath . $pi['product_image_name'] ?>"></li></a>
                    <? } ?>
        </ul>
         <div class="exzoom_nav1"></div>
    <p class="exzoom_btn exzoom_btn1">
        <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="fa fa-angle-left"></i> </a>
        <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="fa fa-angle-right"></i> </a>
    </p>
    </div>
    <div class="exzoom_nav"></div>
    <p class="exzoom_btn">
        <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="fa fa-angle-left"></i> </a>
        <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="fa fa-angle-right"></i> </a>
    </p>
</div>
</div> -->

            <?php /*?><div class="sticky-carousel">
          <div class="row">

             <div id="myCarousel" class="carousel slide" data-bs-interval="false">

                <div id="carousel" class="carousel slide gallery" data-ride="carousel">
                   <div class="carousel-inner ">
                      <? $picount = 1;
                         foreach ($products_image as $pi) {
                           ?>
                      <div class="carousel-item <? if($picount==1){echo "active";} ?>" data-bs-slide-number="<?=$picount?>">
                         <img  class="magniflier" src="<?= $LimagePath . $pi['product_image_name'] ?>" alt="<?=$product_name ?>" title="<?=$product_name ?>" >
                      </div>
                      <? $picount++; } ?>
                   </div>



                   <a class="carousel-control-prev" href="#carousel" role="button" data-bs-slide="prev">
                  <span class="icon-prev  iconbck hidden-xs" aria-hidden="true"><i class="fa fa-angle-left"></i></span>
           <span class="sr-only">Previous</span>
                   </a>
                   <a class="carousel-control-next" href="#carousel" role="button" data-bs-slide="next">
                  <span class="icon-next iconbck " aria-hidden="true"><i class="fa fa-angle-right"></i></span>
           <span class="sr-only">Next</span>
                   </a>
                </div>




                <div id="carousel-thumbs" class="carousel slide" data-bs-ride="carousel">
                   <div class="carousel-inner">
                      <? $thumb_image_count=1;$i_count = 1;$four_items = 1;
                      foreach ($products_image as $pi) { ?>
                      <? if(($i_count %4) == 1 ){ ?>
                      <div class="carousel-item <?=($thumb_image_count==1)?"active":"" ?>" data-bs-slide-number="<?=$four_items?>">
                         <div class="row mx-0">
                            <? } ?>
                            <div id="carousel-selector-<?=$thumb_image_count;?>" class="thumb col-lg-3 col-3 px-0 py-2 <?php if($thumb_image_count<1) { echo "selected"; }?>" data-bs-target="#carousel" data-bs-slide-to="<?=$thumb_image_count;?>">
                               <img src="<?= $SimagePath . $pi['product_image_name'] ?>" class="img-fluid" alt="<?=$product_name ?>" title="<?= $product_name ?>">
                            </div>
                            <?php
                               if($i_count > 1){
                                  ?>
                            <? if(($i_count %4) == 0 || $i_count == count($products_image) ){ ?>
                               <? $four_items++;?>
                         </div>
                      </div>
                      <? } ?>
                      <?php
                         }
                         ?>

                      <?php $i_count++; $thumb_image_count++;} ?>

                      <a class="carousel-control-prev" href="#carousel-thumbs" role="button" data-bs-slide="prev">
                  <span class="icon-prev  iconbck hidden-xs" aria-hidden="true"><i class="fa fa-angle-left"></i></span>
           <span class="sr-only">Previous</span>
                   </a>
                   <a class="carousel-control-next" href="#carousel-thumbs" role="button" data-bs-slide="next">
                  <span class="icon-next iconbck " aria-hidden="true"><i class="fa fa-angle-right"></i></span>
           <span class="sr-only">Next</span>
                   </a>


                   </div>
                </div>



             </div>
          </div>
       </div><?php */ ?>


         </div>
         <!-- Carousel wrapper -->


         <div class="col-lg-4 pb-right-column height-scroll1 sticky-rightside no-position  mt-3">




            <div class="">

               <?
               include(APPPATH . 'views/template/product-list-detail.php');

               ob_start();
               require(APPPATH . 'views/template/product-list-detail-footer.php');
               $footer_data = ob_get_clean();

               //$footer_data = include(APPPATH.'views/templates/product-list-detail-footer.php' );  ?>
               <?
               //echo "<pre>";print_r($products_list);echo "</pre>";
               if (count($products_list[0]['product_combination']) > 1) {
                  ?>


                  <? //$this->load->view('templates/product-list',$this->data);  ?>

                  <?

                  foreach ($products_list[0]['product_combination'] as $r_pc) {
                     if ($default_product_combination_id != $r_pc['product_combination_id']) {
                        $r_product_name = $r_pc['product_display_name'];
                        $r_combi = $r_pc['combi'];

                        $product_image_name = $r_pc['product_image_name'];
                        $ps_slug_url = $r_pc['ps_slug_url'];
                        $combi = $r_pc['combi'];
                        $combi_ref_code = $r_pc['ref_code'];
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
                        if (empty($temp_currency_id) || $temp_currency_id == 1) {
                           if ($r_pc['discount_var'] == 'Rs') {
                              $discount = $currency->symbol . ' ' . $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $r_pc['discount']));
                              $discount = trim($discount);
                           } else {
                              $discount = round($r_pc['discount']) . ' ' . $r_pc['discount_var'];
                              $discount = trim($discount);
                           }
                           $price = $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $r_pc['price']));
                           $final_price = $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $r_pc['final_price']));
                        } else {
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
                        $product_link = base_url() . 'products-details/' . $product_id . '/' . $product_combination_id;
                        if (!empty($ps_slug_url)) {
                           $product_link = '';
                           $product_link .= base_url();
                           if (!empty($pre_url_product)) {
                              $product_link .= $pre_url_product;
                           }
                           $product_link .= $ps_slug_url;
                        }
                        ?>



                        <? include(APPPATH . 'views/template/product-list-detail.php'); ?>

                     <? }
                  } ?>

                  <?
               } ?>

               <div class="clearfix"></div>

            </div>
            <? if ($is_bulk_enquiry == 1) { ?>
               <div class="qntity_sect mycommnt_dvd">
                  <h5>
                     <strong>
                        <!-- <i class="fa fa-angle-double-right" ></i> --> <a type="button"
                           style="cursor:pointer ; color:#eca906" class="btn btn-warning bulk-enquiry"
                           data-bs-toggle="modal" data-bs-target="#mycomment">For Bulk Enquiry</a>
                     </strong>
                  </h5>
                  <br>
               </div>
            <? } ?>
         </div>
         <div class="col-lg-8">
         <div class="container">
               <div class="row">
                  <div class="product-tab" id="down">
                     <div class="dt-sc-tabs-container">
                        <div class="dt-sc-tabs dt-sc-list-inline ">
                           <button class="button tablinks active" onClick="openTab(event, 'tab-description')">Product
                              Description</button>
                           <button class="button tablinks" onClick="openTab(event, 'tab-custom')">Application</button>
                           <button class="button tablinks" onClick="openTab(event, 'tab-review')"
                              id="reviews-li">Reviews</button>
                        </div>

                        <div class="dt-sc-tabs-content  product-single__description rte" id="tab-description"
                           style="display: block;">
                           <p> <strong>Description : </strong>
                              <?= $description ?>
                           </p>
                        </div>


                        <div class="dt-sc-tabs-content" id="tab-custom" style="display: none;">
                           <p><strong>Application : </strong></p>
                           <p>
                              <?= $application ?>
                           </p>
                        </div>


                        <div class="dt-sc-tabs-content" id="tab-review" style="display: none;">
                           <div id="shopify-product-reviews" data-id="6897996726306">
                              <style scoped="">
                                 .spr-container {
                                    padding: 24px;
                                    border-color: #ECECEC;
                                 }

                                 .spr-review,
                                 .spr-form {
                                    border-color: #ECECEC;
                                 }
                              </style>

                              <div class="spr-container">
                                 <div class="spr-header">
                                    <h2 class="spr-header-title">Customer Reviews</h2>
                                    <div class="spr-summary rte">

                                       <span class="spr-starrating spr-summary-starrating" aria-label="3.0 of 5 stars"
                                          role="img">
                                          <i class="spr-icon spr-icon-star" aria-hidden="true"></i><i
                                             class="spr-icon spr-icon-star" aria-hidden="true"></i><i
                                             class="spr-icon spr-icon-star" aria-hidden="true"></i><i
                                             class="spr-icon spr-icon-star-empty" aria-hidden="true"></i><i
                                             class="spr-icon spr-icon-star-empty" aria-hidden="true"></i>
                                       </span>
                                       <span class="spr-summary-caption"><span
                                             class="spr-summary-actions-togglereviews">Based on 1 review</span>
                                       </span><span class="spr-summary-actions">
                                          <a href="#" class="spr-summary-actions-newreview"
                                             onClick="SPR.toggleForm(6897996726306);return false">Write a review</a>
                                       </span>
                                    </div>
                                 </div>

                                 <div class="row">
                                    <div class="col-sm-5">
                                       <div class="rating-block">
                                          <h4>Average user rating</h4>
                                          <h2 class="bold padding-bottom-7" style="margin-top: 20px;
                                              margin-bottom: 20px;">0.0<small>/ 5</small></h2>
                                          <div class="starrr_myBtn">
                                             <div class="star-rating rating-sm rating-disabled">
                                                <ul class="list-inline rating-list">
                                                   <li class="gray"><i class="fa fa-star"></i></li>
                                                   <li class="gray"><i class="fa fa-star"></i></li>
                                                   <li class="gray"><i class="fa fa-star"></i></li>
                                                   <li class="gray"><i class="fa fa-star"></i></li>
                                                   <li class="yellow"><i class="fa fa-star"></i></li>
                                                   <li><span class="text text-success"><i
                                                            class="fa fa-smile-o fa-2x"></i></span></li>
                                                </ul>
                                                <input id="rating-system" type="number" class="rating" min="1" max="5"
                                                   step="1" style="display: none;">
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-md-7">
                                       <div class="well well-sm">
                                          <div class="row" id="post-review-box">
                                             <div class="col-md-12">
                                                <form accept-charset="UTF-8" action="" method="post" autocomplete="off">
                                                   <span id="review_alert_msg" class="review_alert_msg"></span>
                                                   <input type="hidden" name="product_id" id="product_id" value="2284">
                                                   <input type="hidden" name="product_combination_id"
                                                      id="product_combination_id" value="2794">

                                                   <input class="form-control animated" type="text" name="review_title"
                                                      id="review_title" maxlength="60"
                                                      placeholder="Maximum 60 Words. (Example: Great Product)">
                                                   <br>
                                                   <textarea class="form-control animated" cols="50"
                                                      name="customer_review" id="customer_review"
                                                      placeholder="Enter your review here..." rows="5"></textarea>


                                                   <br>
                                                   <div class="starrr_myBtn">
                                                      <!--  <input id="rating" name="rating" value="4.0" type="text" class="rating" data-min="0" data-max="5" data-step="1" data-size="sm" required title=""> -->
                                                   </div>
                                                   <div class="show-result clear-fix">No stars selected yet.</div>
                                                   <div class="text-right">

                                                      <div class="star-rating"><s><s><s><s><s></s></s></s></s></s></div>




                                                      <a class="btn btn-danger btn-sm aClick_5" href="#"
                                                         id="close-review-box"
                                                         style="display:none; margin-right: 10px;">
                                                         <span class="glyphicon glyphicon-remove"></span>Cancel</a>
                                                      <button class="save_button" type="button"
                                                         onClick="SubmitReviewForm()"> Save</button>
                                                   </div>
                                                </form>
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

               </form>
            </div>
         </div>


         <br>
      </div>

   </div>

   <div id="smartblog_block"
      class="block products_block hb-animate-element bottom-to-top hb-in-viewport slider_related_products_now_main ">
      <div class="texture-bck">
         <div class="container " id="whatsnew">
            <div class="products_block_inner">
               <div class="tt-titletab">
                  <h2 class="homepage-heading">
                     <a href="" class="tt-title">Related Products</a>
                  </h2>
                  <br>
               </div>
               <div class="row">
                  <div class="sdsblog-box-content block_content">
                     <div id="smartblog-carousel" class="owl-carousel product_list owl-loaded owl-drag">
                        <div class="owl-slider">
                           <div id="slider_related_products_now" class="owl-carousel"
                              data-val="<?= $product_id ?> , <?= $product_combination_id ?>">

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

<div id="smartblog_block" class="block products_block hb-animate-element bottom-to-top hb-in-viewport">
   <div class="container">
   </div>
   <?
   if (!empty($product_seo_list)) {
      $slug_url = $product_seo_list[0]->slug_url;
      $product_url = base_url() . $pre_url_product . $slug_url;
   } else {
      $product_url = base_url() . 'products-details/' . $product_id . '/' . $product_combination_id;
   }

   ?>
   <script type="application/ld+json">
<?
$short_description = str_replace("'", '', $short_description);
?>
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "<? echo $product_name; ?>@Rs.<? echo $final_price; ?>",
  "image":    "<? echo $LimagePath . $product_image_name; ?>",
  "description": "<? if (!empty($short_description)) {
     echo addslashes($short_description);
  } else {
     echo $product_name;
  } ?>",
  "sku": "<? echo $combi_ref_code; ?>",
  "mpn": "<? echo $combi_ref_code; ?>",
  "brand": {
    "@type": "Brand",
    "name": "<?= $brand_name ?>"
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
      "name": "<?= _project_name_ ?>"
    }
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "90"
  },
  "offers": {
    "@type": "Offer",
    "url": "<? echo $product_url; ?>",
    "priceCurrency": "INR",
    "price": "<? echo $final_price; ?>",
    "priceValidUntil": "2025-12-12",
    "itemCondition": "New",
    "availability": "InStock",
    "seller": {
      "@type": "Organization",
      "name": "<?= _project_name_ ?>"
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
         "@id":"<? echo MAINSITE; ?>",
         "image": "<? echo base_url() . $LimagePath . $product_image_name; ?>"
         }
      },
      {"@type":"ListItem",
      "position":2,
      "item":
         {"name":"<? echo $product_name; ?>",
         "@id":"<? echo base_url() . $pre_url_product; ?>",
         "image": "<? echo base_url() . $LimagePath . $product_image_name; ?>"
         }
      },
      {
      "@type":"ListItem",
      "position":3,
      "item":
         {"name":"<? echo $product_name; ?>",
         "@id":"<? echo $product_url; ?>",
         "image": "<? echo base_url() . $LimagePath . $product_image_name; ?>"
         }
      }
   ]
}
</script>
   <script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"Place",
  "image": "<? echo $LimagePath . $product_image_name; ?>",
  "@id":"<? echo $product_url; ?>",
  "name":"Rs.<? echo $final_price; ?>-<? echo $product_name; ?> <?= _project_name_ ?>",
  "address":{
    "@type":"PostalAddress",
    "streetAddress":"MPP Complex, Shop No. 14 15 Siddipet Road Ramayampet ",
    "addressLocality":"Medak",
    "addressRegion":"Telangana",
    "postalCode":" 502101",
    "addressCountry":"IND"
  },
  "geo":{
    "@type":"GeoCoordinates",
    "latitude":18.31116,
    "longitude":78.42639
  },
  "telephone":"+919441178412",
  "potentialAction":{
    "@type":"ReserveAction",
    "target":{
      "@type":"EntryPoint",
      "urlTemplate":"https://g.page/Annadatha+Rythu+Seva+Kendram?share",
      "inLanguage":"en-US",
      "actionPlatform":[
        "https://schema.org/DesktopWebPlatform",
        "https://schema.org/IOSPlatform",
        "https://schema.org/AndroidPlatform"
      ]
    },
    "result":{
      "@type":"Reservation",
      "name":"<? echo $product_name; ?>"
    }
  }
}
</script>
   <script>
      function callScrollView() {

         $("#down").get(0).scrollIntoView();

         $('#regularCollapseSecond').addClass('accordion-collapse collapse show').attr({ 'aria-expanded': 'true', 'aria-hidden': 'false' }).show();
         $('#regularCollapseFirst').addClass('accordion-collapse collapse').attr({ 'aria-expanded': 'false', 'aria-hidden': 'true' }).show();

      }
   </script>


   <!--Thumbnail Slider Script  -->
   <script>
      window.addEventListener('load', function () {
         // 	var y = $(window).scrollTop();  //your current y position on the page
         //	alert(y)
         $(window).scrollTop(100);
         $('#sd_read_more').click(function () {
            $("#sd_read_more_content ").show();
            $("#sd_read_more ").hide();
         })

         //alert($(".tabProdtDesc1").height());
         var pd_height = $(".tabProdtDesc_outer").height();

         if (pd_height > 60) {
            $('#pd_read_more').show();
            $(".tabProdtDesc_outer").height(60);
            $(".tabProdtDesc_outer").css('overflow', 'hidden');
            $('#pd_read_more').click(function () {
               $(".tabProdtDesc_outer").height(pd_height);
               $(".tabProdtDesc_outer").css('overflow', 'visible');
               $("#pd_read_more ").hide();
            })
         }
         else {
            $(".tabProdtDesc_outer").height(pd_height);
         }


      });

   </script>
   <script>
      function openTab(evt, TabName) {
         var i, tabcontent, tablinks;
         tabcontent = document.getElementsByClassName("dt-sc-tabs-content");
         for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
         }
         tablinks = document.getElementsByClassName("tablinks");
         for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
         }
         document.getElementById(TabName).style.display = "block";
         evt.currentTarget.className += " active";
      }


      window.addEventListener("load", function () {
         $(".tablinks").first().addClass("active");
         $(".dt-sc-tabs-content").first().css("display", "block");
         if ($("*").hasClass("_shipping_show_service_availablity_cl")) {
            var t_pincode_d = localStorage.getItem('pincode_d');
            if (t_pincode_d != null) {
               document.getElementById('pincode_d').value = t_pincode_d;
               getPincodeDetail();
            }
         }

      });
      function getPincodeDetail() {

         $('#PincodeData').html('');
         var pincode_d = document.getElementById('pincode_d');
         var total_weight = <?= $product_weight ?>;
         if (pincode_d.value == '') {
            return false;
         }
         if (pincode_d.value.length != 6) {
            $('#PincodeData').html('<span style="color:red">Enter 6 Digit Pincode</span>');
            pincode_d.focus();
            return false;
         }
         if (!number_only(pincode_d.value)) {
            $('#PincodeData').html('<span style="color:red">Enter 6 Digit Pincode</span>');
            pincode_d.focus();
            return false;
         }



         localStorage.setItem('pincode_d', pincode_d.value);
         $('#PincodeData').html('Checking Availability...');
         $.ajax({
            type: "POST",
            url: '<?= MAINSITE ?>Products/getPincodeDetail/',
            data: { 'pincode': pincode_d.value, 'total_weight': total_weight },
            success: function (result) {
               $('#PincodeData').html(result);
            }
         });
      }
   </script>
