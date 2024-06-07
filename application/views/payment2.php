<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<?

$tab_count = 1;
$CI=&get_instance();
$final_payable_amount = $total = 0;
$sub_total = 0;
$total_saving = 0;
$total_prod = 0;
$display_body='';
$total_gst = 0;
$total_weight = 0;
$delivery_charges = 0;
$total_packing_charges=0;
//echo "<pre>";print_r($products_list); echo "</pre>";
foreach($products_list as $col){
$product_name = $col['name'];
$product_id = $col['product_id'];
$tax_percentage = $col['tax_percentage'];
$coupon_code = $this->session->userdata('application_sess_coupon_code');
$coupon_discount = $this->session->userdata('application_sess_discount');
//Default combination details
foreach($col['product_combination'] as $row){


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
    //$price = $CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['price']));
	$price = $row['price'];
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
    //$price = $CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['price']));
	$price = $row['price'];
  	//$final_price = $CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['final_price']));
	$final_price = $row['final_price'];
  //echo "final_price : $final_price </br>";
}

  //$discount = $row['discount'].' '.$row['discount_var'];$discount = trim($discount);
  //$price = $CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['price']));
  //$final_price = $CI->getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['final_price']));
  $product_image_name = $row['product_image_name'];
  $combi = $row['combi'];
  $product_in_store_id = $row['product_in_store_id'];
  $product_combination_id = $row['product_combination_id'];
  $prod_in_cart = $row['prod_in_cart'];
  $in_store_quantity = $row['quantity'];
  $stock_out_msg = $row['stock_out_msg'];
  $quantity_per_order = $row['quantity_per_order'];
  $pc_delivery_charges = $row['delivery_charges'];
  $packing_charges = $row['delivery_charges'];

  $temp_delivery_charges = floatval($pc_delivery_charges)*$prod_in_cart;
  $delivery_charges+=$temp_delivery_charges;
  //echo "prod_in_cart : $prod_in_cart </br>";
  $total_prod+=$prod_in_cart;
  $total+=$prod_in_cart*$final_price;
  $sub_total+=$prod_in_cart*$final_price;
  //echo "sub_total : $sub_total </br>";
  $total_saving+=$prod_in_cart*$price;
  //echo "total_saving : $total_saving </br>";
  $total_packing_charges += $prod_in_cart*$packing_charges;

  if($tax_percentage<10)
  {
    $tax_percentage = ($tax_percentage/100);
    $tax_percentage = 1 + $tax_percentage;
  }
  else
  {
    $tax_percentage = ($tax_percentage/100);
    $tax_percentage = 1 + $tax_percentage;
  }
  //echo $tax_percentage.' - '.$tax_percentage.'<br>';
  //$total_gst += ($prod_in_cart*$final_price)*($tax_percentage/100);
  $total_gst += (($prod_in_cart*$final_price) - ($prod_in_cart*$final_price)/$tax_percentage);
  //echo "total_gst : $total_gst </br>";
  //echo $total_gst.'<br>';
  $total_weight += floatval($row['product_weight'])*$prod_in_cart;
  }
}


if(_is_coupon_required ==1){
    if(!empty($cart_coupon_discount) && !empty($cart_coupon_code) ){
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
        $total_saving = $total_saving+$cart_coupon_discount_value;
        $total -=$cart_coupon_discount_value;
    }
}
//echo "total_saving : $total_saving : sub_total :$sub_total)";
$total_saving_in_percent = (($total_saving-$sub_total)/$sub_total)*100 ;
$total_saving_in_rs = $total_saving-$sub_total ;
$sub_total-=$total_gst;
//echo "sub_total : $sub_total </br>";



$Dcount=0;
$delivery_pin_code='';
$delivery_city_id='';

if(!empty($user->address))
foreach($user->address as $add){$Dcount++;


if($add->delivery_status==1){

  $delivery_pin_code = $add->zipcode;
  $delivery_city_id = $add->city_id;
  break;
}}
$delivery_charges = 0;
$ship_details = (object)array();

$final_cart_amount = $total+$total_packing_charges;
if($final_cart_amount <= __free_shipping_above__) { $delivery_charges = 90; } else { $delivery_charges = 0;}

$ship_details->is_cod_available=1;
$ship_details->cod_charges=0;
$cart_value = $total;
//echo "subcart_value_total : $cart_value </br>";
//echo "final_cart_amount : $final_cart_amount </br>";
$total = round($final_cart_amount + $delivery_charges);
//echo "total : $total </br>";
$final_payable_amount = round($final_cart_amount + $delivery_charges);
//echo "final_payable_amount : $final_payable_amount </br>";

/*echo "<pre>";
print_r($ship_details);
echo "</pre>";*/


?>
 <div class="container">
    <nav  class="breadcrumb ">
  <ol>
      <li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Pay Now</span></li>
  </ol>
</nav>
     <?
				echo $this->session->flashdata('message');
				echo $this->session->flashdata('message1');
				?>
   </div>
<div class="deta_prodct">
  <div class="container">

    <div class="row">



                <div class="col-md-8 col-sm-8 col-xs-12">


					<div class="l-c-head changeLogin" <? if(empty($temp_name)){ ?> style="display:none" <? } ?>>
                        <h3 class="l-c-h3">
                           <span class="l-c-span"><?=$tab_count?></span>
                        </h3>
                        <div class="l-c-div">
                           <div class="l-c-login">
                              Login
                              <svg height="10" width="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="_1t8m48">
                                 <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" stroke="#e7b70e"></path>
                              </svg>
                           </div>
                           <div class="l-c-phone">
                              <div>
                                <? if(!empty($temp_name)){
                                  ?>
                                 <span class="l-c-phone-span" style="font-weight: 600"><?=$user->name?> </span>

                                   <span class="l-c-phone-span"><?=$user->number?></span>

                                   <?
                                 }
                                   ?>
                              </div>
                           </div>
                        </div>
                        <button class="l-c-change-btn changeLoginDivBtn" id="hide">Change</button>
                     </div>
                     <div class="hide-div changeLoginDiv" <? if(empty($temp_name)){ ?> style="display" <? } else { ?>style="display:none"<? } ?>>
                        <h3 class="hide-div-heading">
                           <span class="hide-div-span1">1</span>
                           <span class="hide-div-span2">Sign Up / Login</span>
                        </h3>
                        <div class="hide-div-content">
                           <div>
                             <? if(!empty($temp_name)){ ?>
                              <div class="hide-div-left-content-inner row" <? if(empty($temp_name)){ ?> style="display:none" <? } ?>>
                                 <div class="col col-lg-5">
                                    <div class="hide-div-left">
                                       <div class="hide-div-left-inner">
                                          <span class="hide-div-phone-h">Phone</span>
                                          <span class="hide-div-phone"><?=$user->number?></span>
                                       </div>
                                       <div class="hide-div-btn">
                                          <a class="hide-div-link" href="<?=base_url().__logout__?>"><span>Logout &amp; Sign in to another account</span></a>
                                       </div>
                                       <div class="hide-div-checkout">
                                          <button class="hide-div-checkout-btn changeLoginDivBackBtn"><span>Continue Checkout</span></button>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="hide-div-right-content col col-lg-7">
                                    <div class="hide-div-right-inner">
                                       <span>Advantages of our secure login</span>
                                       <ul>
                                          <li>
                                             <svg width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="YXdkEF">
                                                <g fill="none" fill-rule="evenodd">
                                                   <path d="M9.466 18.257h4.87c0 1.764 1.42 3.195 3.174 3.195a3.185 3.185 0 0 0 3.175-3.195H22.5c.276 0 .499-.23.499-.496v-5.57l-3.273-4.868h-3.261V4.645a.497.497 0 0 0-.497-.502H1.497A.498.498 0 0 0 1 4.645v13.11c0 .277.219.502.497.502h1.62a3.185 3.185 0 0 0 3.175 3.195 3.185 3.185 0 0 0 3.174-3.195zm6.978-8.381H18.7l2.214 3.057h-4.47V9.876zm2.644 8.381c0 .877-.706 1.588-1.578 1.588a1.583 1.583 0 0 1-1.578-1.588c0-.877.706-1.588 1.578-1.588.872 0 1.578.71 1.578 1.588zm-11.218 0c0 .877-.707 1.588-1.578 1.588a1.583 1.583 0 0 1-1.579-1.588c0-.877.707-1.588 1.579-1.588.871 0 1.578.71 1.578 1.588z" fill="#d5b215"></path>
                                                </g>
                                             </svg>
                                             <span>Easily Track Orders, Hassle free Returns</span>
                                          </li>
                                          <li>
                                             <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" fill="#d5b215"></path>
                                             </svg>
                                             <span>Get Relevant Alerts and Recommendation</span>
                                          </li>
                                          <li>
                                             <span class="star">★</span><span>Wishlist, Reviews, Ratings and more.</span>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <div class="hide-div-please-note row">
                                 <span>Please note that upon clicking "Logout" you will lose all items in cart and will be redirected to Bionovastore home page.</span>
                              </div>
                              </div>
                              <?
                            }
                              ?>
                              <? if(empty($temp_name)){
                                 ?>
                              <hr>
                                 <div class="hide-div-sec row login_div"  >
                                 <hr>
                                 <?php
								 $this->data['is_valid_username']='';
								 ?>
								 <div class="registerForm">
                                 <?php
								 $this->load->view('template/register-form-payment' , $this->data); ?>
                                  <div class="col-lg-6">
                                               <div class="sign_difrnt">
                        </div>


					</div>
   </div>



                                 </div>
                                 <? } ?>



                           </div>
                        </div>

               		</div>

                      <?php /*?><div class="leftside-checkout">
                        <div class="leftside-checkout-inner">
                          <div class="lefside-checkout-content">
                            <div class="l-c-head changeLogin">
                              <h3 class="l-c-h3">
                                <span class="l-c-span">1</span></h3>
                                <div class="l-c-div">
                                  <div class="l-c-login">Login
                                    <svg height="10" width="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="_1t8m48"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" stroke="#859212"></path></svg>
                                  </div>
                                  <div class="l-c-phone"><div>
                                    <span class="l-c-phone-span" style="font-weight: 600"><?=(!empty($user->name))?$user->name:''?></span>
                                    <span class="l-c-phone-span">+91<?=(!empty($user->number))?$user->number:''?></span>
                                  </div>
                                </div>
                              </div>
                              <button class="l-c-change-btn changeLoginDivBtn" id="show">Change</button>
                            </div>

                          <div class="hide-div changeLoginDiv" style="display:none">
                            <h3 class="hide-div-heading">
                              <span class="hide-div-span1">1</span>
                              <span class="hide-div-span2">Login</span>
                            </h3>
                            <div class="hide-div-content"><div>
                              <div class="hide-div-left-content-inner row">
                                <div class="col col-5-12">
                                  <div class="hide-div-left">
                                    <div class="hide-div-left-inner">
                                      <span class="hide-div-phone-h">Phone</span>
                                      <span class="hide-div-phone">+91<?=$user->number?></span>
                                    </div>
                                    <div class="hide-div-btn">
                                      <a class="hide-div-link" href="javscript:void(0);">
                                        <span>Logout &amp; Sign in to another account</span>
                                      </a>
                                    </div>
                                      <div class="hide-div-checkout">
                                        <button class="hide-div-checkout-btn changeLoginDivBackBtn"><span>Continue Checkout</span>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                                <div class="hide-div-right-content col col-7-12">
                                  <div class="hide-div-right-inner">
                                    <span>Advantages of our secure login</span>
                                    <ul>
                                      <li >
                                        <svg width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="YXdkEF"><g fill="none" fill-rule="evenodd"><path d="M9.466 18.257h4.87c0 1.764 1.42 3.195 3.174 3.195a3.185 3.185 0 0 0 3.175-3.195H22.5c.276 0 .499-.23.499-.496v-5.57l-3.273-4.868h-3.261V4.645a.497.497 0 0 0-.497-.502H1.497A.498.498 0 0 0 1 4.645v13.11c0 .277.219.502.497.502h1.62a3.185 3.185 0 0 0 3.175 3.195 3.185 3.185 0 0 0 3.174-3.195zm6.978-8.381H18.7l2.214 3.057h-4.47V9.876zm2.644 8.381c0 .877-.706 1.588-1.578 1.588a1.583 1.583 0 0 1-1.578-1.588c0-.877.706-1.588 1.578-1.588.872 0 1.578.71 1.578 1.588zm-11.218 0c0 .877-.707 1.588-1.578 1.588a1.583 1.583 0 0 1-1.579-1.588c0-.877.707-1.588 1.579-1.588.871 0 1.578.71 1.578 1.588z" fill="#8d9a13"></path></g></svg>
                                        <span>Easily Track Orders, Hassle free Returns</span></li>
                                        <li >
                                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                  <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" fill="#8d9a13"/>
                              </svg>

                                          <span>Get Relevant Alerts and Recommendation</span>
                                        </li>
                                        <li>
                                          <span class="star">★</span><span>Wishlist, Reviews, Ratings and more.</span></li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="hide-div-please-note row">
                                    <span>Please note that upon clicking "Logout" you will lose all items in cart and will be redirected to <?=_brand_name_?> home page.</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </div>
                        </div>
                      </div><?php */?>
                <? if(!empty($temp_name)){

                   ?>
                <div class="leftside-checkout">
                        <div class="leftside-checkout-inner">
                          <div class="lefside-checkout-content">
                            <div class="l-c-head tab2_head" style="display:none">
                              <h3 class="l-c-h3">
                                <span class="l-c-span"><? $tab_count++;?><?=$tab_count?></span></h3>
                                <div class="l-c-div">
                                  <div class="l-c-login">DELIVERY ADDRESS

                                  </div>
                                  <div class="l-c-phone"><div>

                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="l-c-head changeAddress tab2_selected" style="display:none">
                              <h3 class="l-c-h3">
                                <span class="l-c-span">2</span></h3>
                                <div class="l-c-div">
                                  <div class="l-c-login">DELIVERY ADDRESS
                                    <svg height="10" width="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="_1t8m48"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" stroke="#859212"></path></svg>
                                  </div>
                                  <div class="l-c-phone"><div>
                                    <span class="l-c-phone-span allAddressSelectedCl">
                                                <? $this->load->view('template/selected_customers_address_payment' , $this->data); ?>
                                                </span>
                                  </div>
                                </div>
                              </div>
                              <button class="l-c-change-btn changeAddressDivBtn" id="show">Change</button>
                            </div>

                          <div class="hide-div changeAddressDiv tab2_selection" >
                            <h3 class="hide-div-heading">
                              <span class="hide-div-span1"><?=$tab_count?></span>
                              <span class="hide-div-span2">DELIVERY ADDRESS</span>
                            </h3>
                            <div class="hide-div-content1 allAddressCl">


                  <? $this->load->view('template/customers_address_payment' , $this->data); ?>

                          <!--  </div> -->
                            </div>
                            </div>
                        </div>
                      </div>
               </div>
               <? } ?>


                      <div class="leftside-checkout">
                        <div class="leftside-checkout-inner">
                          <div class="lefside-checkout-content">

                            <div class="l-c-head tab3_head">
                              <h3 class="l-c-h31">
                                <span class="l-c-span"><? $tab_count++;?><?=$tab_count?></span></h3>
                                <div class="l-c-div">
                                  <div class="l-c-login">ORDER SUMMARY
                                    <svg height="10" width="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="_1t8m48"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" stroke="#859212"></path></svg>
                                  </div>
                                  <div class="l-c-div">


                                  <div class="l-c-phone"><div>
                                    <span class="l-c-phone-span"><?=$total_prod?> Items</span>
                                  </div>
                                </div>
                              </div>


                              </div>
                               <a href="<?=base_url(__cart__)?>" class="l-c-change-btn" id="show">Change</a>
                            </div>

                          <div class="hide-div tab3_selection" style="display:none">
                            <h3 class="hide-div-heading">
                              <span class="hide-div-span1"><?=$tab_count?></span>
                              <span class="hide-div-span2">ORDER SUMMARY</span>
                            </h3>
                                <div class="hide-div-content1">

                              <div class="hide-div-label" style="overflow-y: scroll; ">
                                <div class="row ">

                                            <? $this->load->view('template/cart-summary2' , $this->data); ?>

                                  </div>

                                  </div>

                            </div>

                            </div>


                            </div>
                        </div>
                      </div>
                      <? if(!empty($temp_name)){ ?>
   <div class="leftside-checkout" >
                        <div class="leftside-checkout-inner">
                          <div class="lefside-checkout-content" >

                                <div class="hide-div tab3_selection" style="display: none;">
                            <div class="hide-div-content1">

                              <div class="hide-div-label" >
                                <div class="row ">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#func_gst_info_modal_icon" class="delivery-pincode1">
                                        <input type="checkbox" >  Use This GST</a>
                                       <div class="gst-no">   <? if(!empty($user->gst_info)){ ?>
                                        <? foreach($user->gst_info as $gi){ ?>
                                        <? if($gi->is_selected == 1){ ?>
                                            <span><input type="checkbox"  class="gst_info_cl" id="_gst_info" <? if($gi->selected_for_order == 1){echo "checked";} ?> data-id="<?=$gi->gst_info_id?>" /></span>
                                            <?
                      echo $gi->gst_number.' &nbsp; &nbsp; | &nbsp; &nbsp; '.$gi->company_name;
                      ?>
                                         <? } ?>
                                         <? } ?>
                                         <? } ?>

                                         <?php /*?><button class="l-c-change-btn" id="show">Change</button><?php */?>

                                            <? //$this->load->view('template/cart-summary' , $this->data); ?>
                                          </div>
                                  </div>
                                  </div>

                            </div>
                            </div>

                                </div>
                              </div>
                            </div>
                            <? } ?>

<? if(!empty($temp_name)){ ?>
                               <div class="leftside-checkout" style="display:none">
                        <div class="leftside-checkout-inner">
                          <div class="lefside-checkout-content">
                                <div class="hide-div tab3_selection" >
                            <div class="hide-div-content1">

                              <div class="hide-div-label" >
                                <div class="row ">
                                        <div id="func_update_email_info_modal_div"></div>
                                        <span id="func_update_email_info_modal_span">
                                        <?
                    if(!empty($user->email))
                    {
                      ?>
                                        Email goes to <?=$user->email?>
                                            <?
                    } else{
                    ?>
                                        Please add your e-mail.
                                        <? } ?>
                                        </span>

                                         <?php /*?><button class="l-c-change-btn" id="show">Change</button><?php */?>
                                         <a href="" data-bs-toggle="modal" data-bs-target="#func_update_email_info_modal" id="func_update_email_info_modal_a" onclick="changeEmail()" class="delivery-pincode"> <?=(!empty($user->email))?"Update":"Add" ?> Your email</a>

                                  </div>
                                  </div>

                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
<? } ?>


<? if(!empty($temp_name)){ ?>
        <div class="leftside-checkout">


                        <div class="leftside-checkout-inner">
                          <div class="lefside-checkout-content">
                              <div class="l-c-head tab4_head" style="display:none">
                              <h3 class="l-c-h3">
                                <span class="l-c-span">4</span></h3>
                                <div class="l-c-div">
                                  <div class="l-c-login">PAYMENT OPTIONS

                                  </div>
                                  <div class="l-c-phone"><div>

                                  </div>
                                </div>
                              </div>
                            </div>




                          <div class="hide-div tab4_selection" style="display:none">
                            <h3 class="hide-div-heading">
                              <span class="hide-div-span1"><? $tab_count++;?><?=$tab_count?></span>
                              <span class="hide-div-span2">PAYMENT OPTIONS</span>
                            </h3>
                                <form action="<?=base_url().'pay-now'?>" id="pay-now" onsubmit="myFunction()"  method="post">
                            <div class="hide-div-content1">

                              <div class="hide-div-label1">
                                <label class="row ">
                                  <div class="col-lg-1 col-1">
                                  <input type="radio" checked="checked" class="hide-div-radio" name="payment_type" id="payment_type_1" value="1" readonly="" >
                                  </div>
                                  <div class="col-lg-11 col-11">
                                    <div  class="hide-div-address-pay-options">


                                          <span >Credit / Debit / ATM Card  (<?=$currency->symbol?>  <?=$final_payable_amount?> )</span>
                                            <span class="span-cus">Add and secure your card as per RBI guidelines</span>

                                    <?
                                      // echo 'dsdsd';
                                      // echo _cod_min_cart_value;
                                      // echo 'max';
                                      // echo _cod_max_cart_value;
                                      // echo 'ccv';
                                      // echo $cart_value;
                                    ?>
                                        </div>


                                    </div>

                                  </label>
                                  </div>

                            </div>
                            <?php /*?><div class="hide-div-content1">

                              <div class="hide-div-label1">
                                <label class="row ">
                                  <div class="col-lg-1 col-1">
                                  <input type="radio" class="hide-div-radio" name="address" readonly="" >
                                  </div>
                                  <div class="col-lg-11 col-11">
                                    <div  class="hide-div-address-pay-options">
                                        <span >Net Banking</span>
                                    </div>


                                    </div>

                                  </label>
                                  </div>

                            </div><?php */?>

<?

$Dcount=0;
$delivery_pin_code='';
$delivery_city_id='';

if(!empty($user->address))
foreach($user->address as $add){$Dcount++;


if($add->delivery_status==1){

  $delivery_pin_code = $add->zipcode;
  $delivery_city_id = $add->city_id;
  break;
}}
if(!empty($this->data['user']->address))
foreach($this->data['user']->address as $add){$Dcount++;


if($add->delivery_status==1){

  $delivery_pin_code = $add->zipcode;
  $delivery_city_id = $add->city_id;
  break;
}}
$ship_details = '';
if(!empty($delivery_pin_code))
{

  //include(APPPATH.'controllers/Main.php');
  //$mainclass = new Main();
  $CI =& get_instance();



  //$ship_details =   $CI->getDeliveryPrice(array('total_weight'=>$total_weight , 'delivery_pin_code'=>$delivery_pin_code , 'delivery_city_id'=>$delivery_city_id , 'order_total'=>$total));
  $ship_details = '';
}
?>
                                <? if(!empty($ship_details) && $ship_details->is_cod_available==1){
              //                     echo _cod_amount_api;
              //                     echo 'safeanil';
              // if(_cod_amount_api == 1)
              // {
              //   // Do nothing
              // }
              // else
              // {
              //   $ship_details->cod_charges = _cod_amount;
              // }
              // if($total > 1000){
              //   $ship_details->cod_charges = 0;
              // }else{
              //   $ship_details->cod_charges = 100;
              // }

               ?>
                             <? // if(_is_cod == 1 && $cart_value >= _cod_min_cart_value && $cart_value <= _cod_max_cart_value){ ?>
                             <? if(_is_cod == 1 && $cart_value <= _cod_max_cart_value){ ?>
                        <?php /*?><a onclick="order_cod_func()" class="subscribe_btn proceed_cod"><i class="fa fa-money"></i>&nbsp; COD (<?=$currency->symbol?> <?=number_format($total + $ship_details->cod_charges)?>)</a><?php */?>

                            <div class="hide-div-content1">

                              <div class="hide-div-label1">
                                <label class="row ">
                                  <div class="col-lg-1 col-1">
                                  <input type="radio" class="hide-div-radio" name="payment_type" id="payment_type_2" value="2" readonly="" >
                                  </div>
                                  <div class="col-lg-11 col-11">
                                    <div  class="hide-div-address-pay-options">
                                      <?
                                      $cod_total =  round($total+$ship_details->cod_charges);
                                      ?>
                                        <span >Cash on Delivery (<?=$currency->symbol?> <?=$cod_total?>)</span>
                                        <span class="span-cus">COD Charges : <?=$ship_details->cod_charges?></span>

                                    </div>


                                    </div>

                                  </label>
                                  </div>

                            </div>
                             <? } ?>
                        <? } ?>

                        <div class="errorInfo"></div>
                         <div class="hide-div-label1">
                            <center><button type="submit" id="payNowBTN" name="orderBTN" value="1" class="subscribe_btn proceed_ckt">  <i class="fa fa-credit-card"></i>&nbsp; Pay Now</button></center> <br>
                            </div>
                                </form><br>
                            </div>
                            </div>
                        </div>
                      </div>
               <? } ?>

                </div>
              <!--   </div> -->

                <div class="col-md-4 col-sm-4 col-xs-12 summary-price">
                  <div class="">
                  <? $this->load->view('template/cart-summary-price' , $this->data); ?>

                              </div>
               </div>
           </div>

          <?php /*?><form action="<?=base_url().'pay-now'?>" onsubmit="myFunction()"  method="post">
                      <div class="paymentBtn-flex">
            <a href="<?=base_url().__cart__?>" class="payment-ship-link1"><em class="fa fa-angle-double-left"></em> Update cart</a>

                        <? if($ship_details->is_cod_available==1){
              if(_cod_amount_api == 1)
              {
                // Do nothing
              }
              else
              {
                $ship_details->cod_charges = _cod_amount;
              }

               ?>
                             <? if(_is_cod == 1 && $cart_value >= _cod_min_cart_value && $cart_value <= _cod_max_cart_value){ ?>
                        <a onclick="order_cod_func()" class="subscribe_btn proceed_cod"><i class="fa fa-money"></i>&nbsp; COD (<?=$currency->symbol?> <?=number_format($total + $ship_details->cod_charges)?>)</a>
                          <? } ?>
                        <? } ?>


            <button type="submit" id="payNowBTN" name="orderBTN" value="1" class="subscribe_btn proceed_ckt">  <i class="fa fa-credit-card"></i>&nbsp; Pay Now (<?=$currency->symbol?> <?=$total?>)</button>

                       </div>
          </form><?php */?>

          <?php /*?><a href=""><button class="pay_buton_1">Pay Now<button></a><?php */?>
                </div>


                <div class="col-md-6 col-sm-6 col-xs-12">



        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal  fade" id="ship_modal"  role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document" >
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Shipping & Delivery Policy</h4>
        <span id="user_pin_close"></span>
      </div>
      <div class="modal-body modal_space">
          <div class="">
                        <?php /*?><h2 class="prodt_head4"><span>Privacy Policy</span></h2><?php */?>
                        <? $this->load->view('template/shipping-delivery-policy' , $this->data); ?>

                </div>



      </div>

    </div>
  </div>
</div>



<!-- <script src="https://ebz-static.s3.ap-south-1.amazonaws.com/easecheckout/easebuzz-checkout.js"></script> -->

<script>
function myFunction(){

  $('.errorInfo').html('');
  event.preventDefault();
  var payment_type = $('input[name="payment_type"]:checked').val();
   if(payment_type==2)
   {
    // order_cod_func();
    var form_url =  "<?=base_url().'place-cod-order'?>";
    $('#pay-now').attr('action',form_url);
    //$('#pay-now').trigger('submit');
    document.getElementById('pay-now').submit();
  }else if(payment_type==1)
  {
    var form_url =  "<?=base_url().'pay-now'?>";
  $("#payNowBTN").prepend('<i class="fa fa-spinner fa-spin"></i>  ');
  $("#payNowBTN").attr('disabled', true);
    var data = $("#micro_chipForm").serialize();

  $.ajax({
   type: "POST",
  url:"<?=base_url('pay-now')?>",
   dataType : "json",
   data : $("#micro_chipForm").serialize(),
   success : function(result){
     var text = $("#payNowBTN").html()
     text = text.replace('<i class="fa fa-spinner fa-spin"></i>', '');
     $("#payNowBTN").html(text);

      if(result.status==1)
      {


        window.location.href = result.url;
      }
      else
      {

        $('.errorInfo').html(result.message);
      }

    }
   });
  }
  else
  {
    $('.errorInfo').html("Please select Payment type");
  }
}
</script>
<script>

$(document).ready(function(){
$(document).on("click","#hide",function() {
  // $(this).text('Cancel');
  $(this).attr('id','show');
     $('#show1').show();
      $('#hide1').hide();
  });
$(document).on("click","#show",function() {
    // $(this).text('Edit');
  $(this).attr('id','hide');
  $('#show1').hide();
      $('#hide1').show();
  });
});


</script>
 <script>

function onTab1Active()
{
  $(".tab2_head").show();
  $(".tab2_selection").hide();
  $(".tab2_selected").hide();

  $(".tab3_head").show();
  $(".tab3_selection").hide();
  $(".tab3_selected").hide();

  $(".tab4_head").show();
  $(".tab4_selection").hide();
  $(".tab4_selected").hide();

}

function onTab1Selected()
{
  $(".tab2_head").hide();
  $(".tab2_selection").show();
  $(".tab2_selected").hide();
}

window.addEventListener("load", function(){
  $(document).on("click", ".changeLoginDivBtn", function(e){
    $(".changeLoginDiv").show();
    $(".changeLogin").hide();
    onTab1Active();
  })
  $(document).on("click", ".changeLoginDivBackBtn", function(e){
    $(".changeLoginDiv").hide();
    $(".changeLogin").show();
    onTab1Selected();
  })

  $(document).on("click", ".changeAddressDivBtn", function(e){
    $(".changeAddressDiv").show();
    $(".changeAddress").hide();

    $(".tab3_head").show();
    $(".tab3_selection").hide();
    $(".tab3_selected").hide();

    $(".tab4_head").show();
    $(".tab4_selection").hide();
    $(".tab4_selected").hide();
  })
  /*$(document).on("click", ".changeLoginDivBackBtn", function(e){
    $(".changeAddressDiv").hide();
    $(".changeAddress").show();
  })*/
  $(document).on("change", ".address_radio", function(){
    id = $(this).data('id');
    $(".deliver_btn").hide();
    $("#deliver_btn_"+id).show();

    $(".edit_btn_cl").hide();
    $("#edit_btn_cl_"+id).show();
  })

  <? if(empty($temp_name)){ ?>

  $(".tab3_head").hide();
  $(".tab3_selection").show();
  $(".tab3_selected").show();
  <? } ?>

})

 </script>

<script type="text/javascript">
function getState(country_obj , state_element_id , state_id)
{
//var country_id = country_obj.value;
var country_id = 1;
  $.ajax({
   type: "POST",
  url:'<?=base_url()?>getState',
   //dataType : "json",
   data : {'country_id' : country_id , 'state_id' : state_id},
   success : function(result){
    $('#'+state_element_id).html(result);
     }
   });
}

function getCity(state_id , city_element_id , city_id , state_id_n='')
{
  console.log();

if(state_id=='')
{
  state_id = state_id_n;
}
  $.ajax({
   type: "POST",
  url:'<?=base_url()?>getCity',
   //dataType : "json",
   data : {'state_id' : state_id , 'city_id' : city_id},
   success : function(result){
    $('#'+city_element_id).html(result);
     }
   });
}
var id = 0;
window.addEventListener('load', function(){
  $(document).on("click", '.manageAddress', function(){
    id = $(this).data('id');

    editAddress(id);
  })
  $(document).on("click", '.setDeliverHereAddress', function(){
    id = $(this).data('id');

    editDeliverHereAddress(id);
  })

})
function editDeliverHereAddress(id)
{
  $(".add_edit_address_cl").html("");
  $.ajax({
   type: "POST",
  url:'<?=base_url()?>dashboard/editDeliverHereAddress',
   dataType : "json",
   data : {'customers_address_id' : id},
   success : function(result){
    if(result.status==0)
      {
        //$('.add_edit_address_'+id).html(result.data_html);
        //do_ship_address(id);
      }
      else
      {
        //$(".noAddressCl").html('');
        //$('.allAddressCl').html(result.data_html);
        $('.allAddressSelectedCl').html(result.data_selected_html);
        $(".changeAddressDiv").hide();
        $(".changeAddress").show();

        $(".tab3_head").hide();
        $(".tab3_selection").show();
        $(".tab3_selected").show();

        $(".tab4_head").hide();
        $(".tab4_selection").show();
        $(".tab4_selected").show();
      }
     }
   });
}

function editAddress(id)
{
  $('.loader').show();
  $(".add_edit_address_cl").html("");
  $.ajax({
   type: "POST",
  url:'<?=base_url()?>dashboard/editUpdateAddressPayment',
   //dataType : "json",
   data : {'customers_address_id' : id},
   success : function(result){
     $('.loader').hide();
    $('.add_edit_address_'+id).html(result);
    do_ship_address(id);
    $(document).on("click", ".cancelBTN", function(){
      $(".add_edit_address_"+$(this).data('id')).html('');
    })

    if($("*").hasClass("noAddress"))
    {
      $(".cancelBTN").remove();
    }
     }
   });
}

function do_ship_address(id)
{
  $("#ship_address").submit(function(){
    event.preventDefault();
    $('.loader').show();
    $.ajax({
     type: "POST",
    url:'<?=base_url()?>dashboard/do_ship_address_payment',
     dataType : "json",
     data : $("#ship_address").serialize(),
     success : function(result){
       $('.loader').hide();

      if(result.status==0)
      {
        $('.add_edit_address_'+id).html(result.data_html);
        do_ship_address(id);
      }
      else
      {
        $(".noAddressCl").html('');
        $('.allAddressCl').html(result.data_html);
        $('.allAddressSelectedCl').html(result.data_selected_html);
        $(".changeAddressDiv").hide();
        $(".changeAddress").show();

        $(".tab3_head").hide();
        $(".tab3_selection").show();
        $(".tab3_selected").show();

        $(".tab4_head").hide();
        $(".tab4_selection").show();
        $(".tab4_selected").show();
      }
       }
     });

  });

}


</script>

<div class="modal fade" id="func_gst_info_modal_icon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-custom1 ">
    <div class="modal-content">
      <div class="modal-header modal-header2">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Select GST Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">✕</button>
      </div>
      <div class="modal-body modal-body2 show_cart_page_address">

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="func_update_email_info_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-custom1 ">
    <div class="modal-content">
      <div class="modal-header modal-header2">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><?=(!empty($user->email))?"Update":"Add" ?> Your email</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">✕</button>
      </div>
      <form name="update_email_form" id="update_email_form" onsubmit="func_update_email_form()">
      <div class="func_update_email_info_modal_header">

      </div>
      <? if(!empty($temp_name)){ ?>
      <div class="modal-body modal-body2 func_update_email_info_modal_body">
      <div class="manage-class-inner row">

                <div class="mng-form-inner">
                    <input type="text" name="email" id="email" value="<?=$user->email?>" class="mng-form-inpt" >
                            <label for="Email" class=" mng-form-label">&nbsp;&nbsp;Email</label>
                </div>


              </div>
        <!--  <input type="email" required name="email" id="email" value="<?=$user->email?>" /> -->

      </div>
      <?
    }
      ?>

      <div class="emailOTPInput" id="emailOTPInput" style="display:none">
        OTP sent to <span id="email_send_to"></span> <button type="button" class="btn btn-info" onclick="changeEmail()"> Change</button>
              <input type="number" pattern="[0-9]{6,6}" class="mng-form-inpt mt-2" title="Enter 6 digit OTP" name="otp" id="otp_email_e" value="" / style="padding:0 !important">
              <label for="name" class=" mng-form-label">Enter OTP</label>
      </div>

      <a class="resend_otp" id="otp_func_e" style="display:none" onclick="password_change_otp_func_e()"><div class="otp-text-last" >Not received your code? <span>Resend code</span></div></a>
      <a class="resend_otp" id="otp_func_count_e" style="display:none" ></a>

      <div class="func_update_email_info_modal_footer">
        <button class=" continue2" type="submit">
            <div class="mb-btn-inner-content mb-btn-inner-content1">
               <svg class="" viewBox="25 25 50 50">
                  <circle stroke="#fff" class="" cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke-miterlimit="10"></circle>
               </svg>
            </div>
           <!--  <span>Continue</span> -->
           Continue
         </button>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
function func_update_email_form()
{
  event.preventDefault();

  $('.loader').show();
  $(".func_update_email_info_modal_header").html('');
  $.ajax({
    type: "POST",
    url:'<?=MAINSITE?>Dashboard/doUpdateEmailForm/',
    data : $("#update_email_form").serialize(),
    success : function(result){
      $('.loader').hide();
      $(".func_update_email_info_modal_header").html(result);
    }
  });

}
var myOTPTimer_e='';
if(typeof myOTPTimer != "undefined")
{
  clearInterval(myOTPTimer_e);
}

var time_sec = 20;
function resend_otp_time_e () {
  //alert();
  $('#otp_func_count_e').show();
  time_sec = time_sec - 1;
  $('#otp_func_count_e').html('Resend OTP in '+ time_sec +' Seconds.');
  if(time_sec==0)
  {
    clearInterval(myOTPTimer_e);
    $('#otp_func_e').show();
    $('#otp_func_count_e').html('');
    $('#otp_func_count_e').hide();
  }
}

function changeEmail()
{
  $("#otp_email_e").val('');
  $(".func_update_email_info_modal_header").html('');
  clearInterval(myOTPTimer_e);
  $('#otp_func_e').hide();
    $('#otp_func_count_e').html('');
    $('#otp_func_count_e').hide();
  time_sec = 20;
  $("#otp_email_e").attr("required", false);
  $(".func_update_email_info_modal_body").show();
  $("#emailOTPInput").hide();

}

function password_change_otp_func_e()
{
  $('#otp_func_e').hide();
    $('#otp_func_count_e').html('');
    $('#otp_func_count_e').hide();
  time_sec = 20;
  $("#otp_email_e").attr("required", false);
  $("#otp_email_e").val("");
  func_update_email_form();
  $("#otp_email_e").attr("required", true);
}


window.addEventListener('load', function(){
  $("#func_gst_info_modal_icon").on('show.bs.modal', function () {
    $('.show_cart_page_address').html("Loading...");
    $('.loader').show();
    $.ajax({
      type: "POST",
      url:'<?=MAINSITE?>Dashboard/getPaymentpageGstInfo/',
      data : {},
      success : function(result){
        $('.loader').hide();
        $('.show_cart_page_address').html(result);
      }
    });

  });

  $(document).on('change', '.payment_gst_info_radio', function(){
    $('.loader').show();
      $(".add_edit_address_cl").html("");
        $.ajax({
         type: "POST",
        url:'<?=base_url()?>dashboard/editSelectedGstInfo',
         dataType : "json",
         data : {'gst_info_id' : $(this).attr("id"), 'page' : 'payment'},
         success : function(result){
          window.location.reload();
           }
         });
  })

  $(document).on('change', '#_gst_info', function(){
    var selected_for_order = 0;
    var id = $(this).data("id");
    if($(this).is(":checked"))
    {
      selected_for_order = 1;
    }
    $.ajax({
       type: "POST",
      url:'<?=base_url()?>dashboard/editSelectedGstInfoForOrder',
       dataType : "json",
       data : {'id' : id, 'selected_for_order' : selected_for_order, 'page' : 'payment'},
       success : function(result){
        //window.location.reload();
        $('.loader').hide();
         }
       });
  })
})
</script>
<?
$show_tab = $this->session->flashdata('application_sess_show_payment_tab');
if($show_tab == 3)
{
  ?>

    <script>
  window.addEventListener("load", function(){
    $(".changeAddressDiv").hide();
    $(".changeAddress").show();

    $(".tab3_head").hide();
    $(".tab3_selection").show();
    $(".tab3_selected").show();

    $(".tab4_head").hide();
    $(".tab4_selection").show();
    $(".tab4_selected").show();
  })
  </script>
    <?
}
?>
<?php /*?>
    <script>
  window.addEventListener("load", function(){
    $(".changeAddressDiv").hide();
    $(".changeAddress").show();

    $(".tab3_head").hide();
    $(".tab3_selection").show();
    $(".tab3_selected").show();

    $(".tab4_head").hide();
    $(".tab4_selection").show();
    $(".tab4_selected").show();
  })
  </script><?php */?>


<script>

function order_cod_func()
{
	$(".loader").css("display","block");
	$.ajax({
		type: "POST",
		//url:$('.siteUrl').val()+'products/loadMoreProduct',
		url:$('.siteUrl').val()+'Payment_Checkout/place_order_cod_verify',
		/*dataType : "json",*/
		data : {},
		success : function(result){
			$('#otp_verify_modal_body').html(result);
			$('#otp_verify_modal').modal('show');
			$(".loader").css("display","none");
			setAllAnchorFunc();
		}
	});
}

</script>

<div id="otp_verify_modal" class="modal fade" role="dialog" style="z-index:9999999">
  <div class="modal-dialog modal-sm">

    <div class="modal-content">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
      <div class="modal-body row" id="otp_verify_modal_body" style="margin:0">

	      </div>
    </div>
  </div>
</div>


<script>
	window.addEventListener("load", function(){


		$(document).on("click", ".show_sign_in", function(){
			$(".register_div").hide();
			$(".login_div").show();
		})
		$(document).on("click", ".show_register", function(){
			$(".register_div").show();
			$(".login_div").hide();
		})

		$(document).on("change", ".payment_type_radio", function(){
			$(".online_payment_button").hide();
			$(".proceed_cod").hide();
			if($(this).val() == 1)
			{
				$(".online_payment_button").show();
			}
			if($(this).val() == 2)
			{
				$(".proceed_cod").show();
			}
		})
		//cart_summary_price();
		<? if(empty($user->number) && !empty($temp_name)){ ?>
		$("#update_contact_modal").modal({"backdrop":"static", "keyboard":false, "show":true});


		$("#updateContactForm").submit(function(e) {

        //prevent Default functionality
        e.preventDefault();

		$("#updateContact").html("");
        //do your own request an handle the results
        $.ajax({
                url: "<?=base_url().'updateContact'?>",
                type: 'post',
                dataType: 'json',
                data: $("#updateContactForm").serialize(),
                success: function(data) {
					$("#updateContact").html(data.message);
					if(data.status == 1)
					{
						window.location.reload();
					}
                }
        });

    });


		<? } ?>
	})
	</script>


<?php /*login script start*/ ?>
<script>
window.addEventListener("load", function(){
	setRegisterForm();
})

function setRegisterForm(){
	$( "#registration_form" ).submit(function( event ) {
		//alert( "Handler for .submit() called." );
		event.preventDefault();
		$(".loader").css("display","block");
		$.ajax({
			type: "POST",
			//url:$('.siteUrl').val()+'products/loadMoreProduct',
			url: '<?=base_url(__signup__).'/auth'?>',
			/*dataType : "json",*/
			data : $('#registration_form').serialize(),
			success : function(result){
				$('.registerForm').html(result);
				$(".loader").css("display","none");
				setRegisterForm();
			},
			error : function(result){
				alert("error");
				$(".loader").css("display","none");
			}
		});
	});
}

function gst_info_form_submit()
{
	event.preventDefault();
		$.ajax({
	   type: "POST",
		url:'<?=base_url()?>dashboard/do_gst_info_payment_form',
	   dataType : "json",
	   data : $("#gst_info_form").serialize(),
	   success : function(result){
			$('.loader').hide();
			if(result.status==0)
			{
				$('.gst_message').html(result.message);
			}
			else
			{
				$(".noGstInfoCl").html('');
				$('.show_cart_page_address').html(result.data_html);
				$("#gst_number0").val('');
				$("#company_name0").val('');
				window.location.reload();
			}
		   }
	   });

}
</script>
<?php /*login script end*/ ?>
