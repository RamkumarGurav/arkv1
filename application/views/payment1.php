<?
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
{
	foreach($user->address as $add){$Dcount++;
		if($add->delivery_status==1){
		
		  $delivery_pin_code = $add->zipcode;
		  $delivery_city_id = $add->city_id;
		  break;
		}
	} 
}
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<div class="container">
   <?
      echo $this->session->flashdata('message');
      echo $this->session->flashdata('message1');
      ?>
</div>
<div class=" payment-checkout">
<div class="container">
   <div class="row">
      <div class="col-lg-7 pddng0">
         <div class="leftside ">
            <div class="text-center">
               <img src="http://mars-500/xampp/MARS1/greenfieldeco/assets/front/images/logo.jpg" alt="<?=_project_name_?>" title="<?=_project_name_?>" class="img-fluid" style="width: 100px;margin-top: 20px">
               <nav  class="breadcrumb mt-3 mb-3" style="    ">
                  <ol>
                     <li><span>Home &nbsp;<i class="fa fa-angle-right"></i>&nbsp; Cart &nbsp;<i class="fa fa-angle-right"></i>&nbsp; Information &nbsp;<i class="fa fa-angle-right"></i>&nbsp; Shipping &nbsp;<i class="fa fa-angle-right"></i>&nbsp; Payment</span></li>
                  </ol>
               </nav>
            </div>
            <div class="row">
               <div class="col-lg-6">
                  <h2 class="contact">Contact</h2>
               </div>
               <div class="col-lg-6"><span class="_19gi7yt0 _19gi7ytf _1fragem1i">Already have an account? <a href="#">Log in</a></span></div>
            </div>
            <div class="form-group">
               <input id="email" name="email" placeholder="Enter an email or phone number" type="text" class="form-control ct-inp">
               <div class="mt-2 mb-4">
                  <input type="checkbox" checked="" style="background: #000 !important">
                  <span class="geekmark"></span>
                  <label class="main"> Email me with news and offers</label>
               </div>
            </div>
            <div class="form-group">
               <h2 class="contact">Shipping address</h2>
               <label for="Select0" class="QOQ2V NKh24"><span class="KBYKh"><span class="rermvf1 _1fragem7i _1fragem7k _1fragem14">Saved addresses</span></span></label>
               <select name="countryCode" id="Select0" placeholder="country" required="" autocomplete="shipping country" class="form-control ct-inp">
                  <option value="IN">India</option>
               </select>
            </div>
            <div class="form-group row mt-2">
               <div class="col-lg-6">
                  <input id="TextField0" name="firstName" placeholder="First Name" required="" type="text" class="form-control ct-inp">
               </div>
               <div class="col-lg-6">
                  <input id="TextField0" name="firstName" placeholder="Last Name" required="" type="text" class="form-control ct-inp">
               </div>
            </div>
            <div class="form-group row mt-2">
               <div class="col-lg-12">
                  <input id="TextField0" name="firstName" placeholder="Company Name and GSTIN (Optional)" required="" type="text" class="form-control ct-inp">
               </div>
            </div>
            <div class="form-group row mt-2">
               <div class="col-lg-12">
                  <input id="TextField0" name="firstName" placeholder="Address Line 1" required="" type="text" class="form-control ct-inp">
               </div>
            </div>
            <div class="form-group row mt-2">
               <div class="col-lg-12">
                  <input id="TextField0" name="firstName" placeholder="Address Line 2 (Apt, Flat Number)" required="" type="text" class="form-control ct-inp">
               </div>
            </div>
            <div class="form-group row mt-2">
               <div class="col-lg-4">
                  <input id="TextField0" name="firstName" placeholder="City" required="" type="text" class="form-control ct-inp">
               </div>
               <div class="col-lg-4">
                  <select name="zone" id="Select1" placeholder="City" class="form-control ct-inp" required="" autocomplete="shipping address-level1" class="_b6uH RR8sg vYo81 RGaKd">
                     <option hidden="" disabled="" value="">&nbsp;</option>
                     <option value="AN">Andaman and Nicobar Islands</option>
                     <option value="AP">Andhra Pradesh</option>
                     <option value="AR">Arunachal Pradesh</option>
                     <option value="AS">Assam</option>
                     <option value="BR">Bihar</option>
                     <option value="CH">Chandigarh</option>
                     <option value="CG">Chhattisgarh</option>
                     <option value="DN">Dadra and Nagar Haveli</option>
                     <option value="DD">Daman and Diu</option>
                     <option value="DL">Delhi</option>
                     <option value="GA">Goa</option>
                     <option value="GJ">Gujarat</option>
                     <option value="HR">Haryana</option>
                     <option value="HP">Himachal Pradesh</option>
                     <option value="JK">Jammu and Kashmir</option>
                     <option value="JH">Jharkhand</option>
                     <option value="KA">Karnataka</option>
                     <option value="KL">Kerala</option>
                     <option value="LA">Ladakh</option>
                     <option value="LD">Lakshadweep</option>
                     <option value="MP">Madhya Pradesh</option>
                     <option value="MH">Maharashtra</option>
                     <option value="MN">Manipur</option>
                     <option value="ML">Meghalaya</option>
                     <option value="MZ">Mizoram</option>
                     <option value="NL">Nagaland</option>
                     <option value="OR">Odisha</option>
                     <option value="PY">Puducherry</option>
                     <option value="PB">Punjab</option>
                     <option value="RJ">Rajasthan</option>
                     <option value="SK">Sikkim</option>
                     <option value="TN">Tamil Nadu</option>
                     <option value="TS">Telangana</option>
                     <option value="TR">Tripura</option>
                     <option value="UP">Uttar Pradesh</option>
                     <option value="UK">Uttarakhand</option>
                     <option value="WB">West Bengal</option>
                  </select>
               </div>
               <div class="col-lg-4">
                  <input id="TextField0" name="firstName" placeholder="PIN code" required="" type="text" class="form-control ct-inp">
               </div>
            </div>
            <div class="form-group row mt-2">
               <div class="col-lg-12">
                  <input id="TextField0" name="firstName" placeholder="Phone Number" required="" type="text" class="form-control ct-inp">
               </div>
            </div>
            <div class="mt-2 mb-4">
               <input type="checkbox"  style="background: #000 !important">
               <span class="geekmark"></span>
               <label class="main"> Save this information for next time</label>
            </div>
            <div class="row mt-3 align-items-center justify-content-center">
               <div class="col-lg-6">
                  <a href="#" class="QT4by eVFmT j6D1f janiy adBMs"><i class="fa fa-angle-left" ></i> Return to cart</a>
               </div>
               <div class="col-lg-6">
                  <button type="submit" class="cont-ship">Continue to shipping</button>
               </div>
            </div>
            <br>
            <hr style="margin-bottom: 0 !important">
            <div class="payment-foot">
               <a type="button" aria-haspopup="dialog">Refund policy</a>
               <a type="button" aria-haspopup="dialog" >Shipping policy</a>
               <a type="button" aria-haspopup="dialog" >Privacy policy</a>
               <a type="button" aria-haspopup="dialog" >Terms of service</a>
               <a type="button" aria-haspopup="dialog" >Contact information</a>
            </div>
         </div>
      </div>
      <div class="col-lg-5" style="background: #fafafa;border-left: 1px solid #ababab;">
         <div class="rightside mt-5">
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
            <div class="row  align-items-center justify-content-center">
               <div class="col-lg-2 col-3">
                  <img src="<?=$SimagePath.$product_image_name?>" alt="<?=$product_name?>" title="<?=$product_name?>" style="width:50px">
                  <span class="prod-count"><?=$prod_in_cart?></span>
               </div>
               <div class="col-lg-5 col-8 pddng-lr">
                  <div class="CartItem__Info">
                     <h2 class="CartItem__Title Heading">
                        <a href="<?=$product_link?>"><?=$product_display_name?> - <?=$combi?></a>
                     </h2>
                  </div>
               </div>
               <div class="col-lg-5 col-4">
                  <div class="price1">
                     <h3><?=$currency->symbol.' '.($final_price * $prod_in_cart)?></h3>
                  </div>
               </div>
            </div>
<? }}} ?>
            
            <div class="form-group row align-items-center justify-content-center">
              <div class="col-lg-7 col-7">
               <input id="email" name="email" placeholder="Gift card or discount code" type="text" class="form-control ct-inp">
             </div>
               <div class="col-lg-5 col-5" style="padding-left:0 !important">
               <button type="submit" class="payment-apply ">Apply</button>
             </div>
            </div>
               <div class="form-group row align-items-center justify-content-center mt-2">
                <div class="col-lg-7">
                  <p class="price-d">Subtotal</p>
                </div>
                 <div class="col-lg-5">
                  <p class="price-d"><strong> ₹14,565.00</strong></p>
                </div>
               </div>
               <div class="form-group row align-items-center justify-content-center mt-2">
                <div class="col-lg-6">
                   <p class="price-d">Shipping <a href="" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-question-circle-o"></i></a></p>
                </div>
                 <div class="col-lg-6">
                   <span style="font-size: 12px">Calculated at next step</span>
                </div>
               </div>
               <div class="form-group row align-items-center justify-content-center mt-2">
                <div class="col-lg-6">
                  <strong>Total</strong><br>
                  <span style="font-size: 12px">Including ₹1,560.54 in taxes</span>
                </div>
                 <div class="col-lg-6">
                 INR <strong>₹14,565.00</strong>
                </div>
               </div>



         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Shipping policy</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <body class="page-policies default-background text-container">
      <p><strong>[These terms form part of the Terms &amp; Conditions relating to access of the website including the mobile applications. For other terms, kindly refer to Terms &amp; Conditions’ section]</strong></p>
<p><em>ModernQuests.com and its mobile applications are defined as "Website"<span>&nbsp;</span><br>Quests Creative Private Limited is defined as “Company”, “We”, “Our” or “Us”<br></em><em>User of website/mobile applications is defined as “You” or “Your”</em></p>
<p>For the time being, We only process orders for delivery within India.</p>
<p>Your shipping address, city, state and pin code will be verified before shipping the product. If Your order cannot be delivered by Our delivery partners, We shall request You to provide Us with a different shipping address that can be serviced by Our delivery partners. If there is any dispute regarding the delivery of any order to the shipping address specified by You that is not covered by Our delivery partners, the Company shall not be held responsible for not delivering the products. If the order has already been paid for, the refund will be processed directly back to Your credit card, debit card or bank account or any other payment method used for the transaction. For Cash On Delivery orders, no refund shall be given as no payment has been collected by the Company.</p>
<p>Depending on the value of the order placed by You, the product(s) may have to be shipped in different batches or consignments, for which an intimation shall be sent to You.</p>
<p>Before processing, dispatching or delivering any product or service to You, the Company may request You to provide documents supporting Your identity. These documents may include, but are not limited to, an identification or residence proof issued by the Government of India, to establish the ownership of the instrument of payment used by You for the purchase of a product or service.</p>
<p><span>We usually get most orders delivered within 2 to 8 working days from the date of Order Acceptance. Based on Your location, an estimate of delivery period is provided when completing the checkout process. The estimated days mentioned regarding dispatch and delivery times are for guidance only. The Website or the Company shall not be held liable to meet such estimated dispatch and delivery guidelines. In case of any delays in delivery of a product that occur because of reasons beyond Our control, We shall not be held responsible for the same.</span></p>


    <div class="hidden">
  <span class="visually-hidden" id="forwarding-external-new-window-message">
    Opens external website in a new window.
  </span>

  <span class="visually-hidden" id="forwarding-new-window-message">
    Opens in a new window.
  </span>

  <span class="visually-hidden" id="forwarding-external-message">
    Opens external website.
  </span>

  <span class="visually-hidden" id="checkout-context-step-one">
    Customer information - Modern Quests - Checkout
  </span>
</div>

  

</body>
        </div>
      
      </div>
    </div>
  </div>
    
</div>