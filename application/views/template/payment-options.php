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
// $ship_details = (object)array();
//
 $final_cart_amount = $total+$total_packing_charges;
 if($final_cart_amount <= __free_shipping_above__) { $delivery_charges = 90; } else { $delivery_charges = 0;}
//
// $ship_details->is_cod_available=1;
// $ship_details->cod_charges=0;
$cart_value = $total;
$total = round($final_cart_amount + $delivery_charges);
//echo "total : $total </br>";
$final_payable_amount = round($final_cart_amount + $delivery_charges);
?>
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
  $ship_details =   $CI->getDeliveryPrice(array('total_weight'=>$total_weight , 'delivery_pin_code'=>$delivery_pin_code , 'delivery_city_id'=>$delivery_city_id , 'order_total'=>$total));
  // print_r($ship_details);
  // die;
}
//print_r($ship_details);
?>
    <? if(!empty($ship_details) && $ship_details->is_cod_available==1){

// if(_cod_amount_api == 1)
// {
// // Do nothing
// }
// else
// {
// $ship_details->cod_charges = _cod_amount;
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
          $cod_total =  round($total+$ship_details->cod_charges)  ;
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
