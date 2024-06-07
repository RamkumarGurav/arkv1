<? $o = $orders[0];

$store_data = $o->store_data[0];





 ?>

<!DOCTYPE HTML>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><? echo $store_data->name?> : <?=$o->order_number?></title>

<link rel="stylesheet" href="<?=base_url().__scriptFilePath__?>css/invoice.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>



<body id="tax-invoice">

<div style="width:800px; margin:0 auto;">



<div id="mainDivId" class="MainDiv">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tbody>

  	<tr>

    	<td colspan="2" class="GeneralTd HEader" style="vertical-align:top;">

        	<img src="<?=base_url().__scriptFilePath__?>images/logo.png" width="100" style="margin:0;">

            

        </td>
       
        <td colspan="2" class="GeneralTd HEader" style="vertical-align:top;padding-left: 80px;">
        <p style="margin:0;"><strong><? echo $store_data->name?></strong></p>

            <p style="margin:0;"><i class="fa fa-map-marker"></i> <? echo nl2br($store_data->address)?>.</p>

            <p style=" margin:0"><i class="fa fa-envelope"></i> <? echo $store_data->person_contact_email;?></p>
            <p style=" margin:0"><i class="fa fa-phone"></i> <? echo $store_data->person_contact_number;?></p>

            <p style="margin:0;">

        		<strong>GST No :</strong> <? echo $store_data->gst_no;?>

            </p>
        </td>

        <td colspan="3" class="GeneralTd2 HEader <?php /*?>text-right<?php */?> Head2">

        	<p style="margin-top:2px; margin-bottom:2px;">

        		<strong>Invoice No :</strong> <span><?=$o->order_number?></span>

            </p>

            <p style="margin-top:2px; margin-bottom:2px;">

        		<strong>Invoice Date :</strong> <span><?=date("d M y" , strtotime($o->added_on))?></span>

            </p>
            
            <? if($o->is_cod==2){ ?>
            <p style="margin-top:2px; margin-bottom:2px;">
        		<strong>Payment Method :</strong> <span>Prepaid</span>
            </p>
            <p style="margin-top:2px; margin-bottom:2px;">
        		<strong>Bank Reff No. :</strong> <span><?=$o->bank_ref_num?></span>
            </p>
            <p style="margin-top:2px; margin-bottom:2px;">
        		<strong>Payment Mode :</strong> <span><?=$o->mode?></span>
            </p>
            <? }else{ ?>
            <p style="margin-top:2px; margin-bottom:2px;">
        		<strong>Payment Method :</strong> <span>Cash On Delivery</span>
            </p>
            <? } ?>

        </td>

    </tr>

    

    <tr>

    	<td colspan="7" class="GeneralTd3 text-center" style="padding:5px;"><strong>Bill / Receipt Details</strong></td>

    </tr>

    <tr>

    	<td colspan="7" class="GeneralTd text-left  B-TB"><strong>Order By :</strong> <?=$o->name?> <? if(!empty($o->number)){echo ' , '.$o->number;} ?> , <?=$o->email?></td>

    </tr>

    <tr>

    	<td colspan="4" class="GeneralTd B-TB">

        	<h4 style="margin:0 0 5px;">Billing Address</h4>

            <h5 style="margin:0 0 5px;"><?=$o->b_name?></h5>

            <p style="margin:0 0 5px;"><?=$o->b_number?></p>

            <p style="margin:0 0 5px;"><?=$o->b_address?>,<br><?=$o->b_city_name?> - <?=$o->b_zipcode?><br><?=$o->b_state_name?><br><?=$o->b_country_name?></p>
            
            <? if(!empty($o->company_name) && !empty($o->gst_number)){ ?>
            <p style="margin:0 0 5px;">
				<strong><?=$o->company_name?></strong>
                <br>
				<strong>GSTIN:</strong> <?=$o->gst_number?>
                
            </p>
            <? } ?>

        </td>

        <td colspan="3" class="GeneralTd  B-TB" style="vertical-align:top;">

        	<h4 style="margin:0 0 5px;">Shipping Address</h4>

            <h5 style="margin:0 0 5px;"><?=$o->d_name?></h5>

            <p style="margin:0 0 5px;"><?=$o->d_number?></p>

            <p style="margin:0 0 5px;"><?=$o->d_address?>,<br><?=$o->d_city_name?> - <?=$o->d_zipcode?><br><?=$o->d_state_name?><br><?=$o->d_country_name?></p>

        </td>

    </tr>
<tr>


 <tr>

    <td colspan="7" class="GeneralTd text-center B-TB"><strong>Order Particular(s) :</strong></td>

</tr>
<td colspan="7">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

    	<td width="1%" class="GeneralTd BorderBot"><strong>Sl</strong></td>

        <td width="40%" colspan="2" class="GeneralTd BorderBot"><strong>Description</strong></td>

        <td width="5%" class="GeneralTd BorderBot text-right"><strong>Qty</strong></td>

        <td width="15%" class="GeneralTd BorderBot text-right"><strong>Price </strong></td>

        <td width="15%" class="GeneralTd BorderBot text-right"><strong>GST</strong></td>

        <td width="20%" class="GeneralTd BorderBot text-right"><strong>Total Price </strong></td>

    </tr>

    <? $slno=0;foreach($o->details as $od){$slno++; ?>

    <tr>

    	<td class="GeneralTd BorderBot"><?=$slno?></td>

        <td colspan="2" class="GeneralTd BorderBot"><?=$od->product_name?> - <?=$od->combi?></td>

        <td class="GeneralTd text-right BorderBot"><?=$od->prod_in_cart?></td>

        <td class="GeneralTd text-right BorderBot"><?=$o->symbol?> <?=$od->final_price?></td>

        <td class="GeneralTd text-right BorderBot"><?=$o->symbol?> <?=$od->total_gst?> (<?=$od->tax_providers_percentage?>%)</td>

        <td class="GeneralTd text-right BorderBot"><?=$o->symbol?> <?=$od->total?></td>

    </tr>

    <? } ?>
</table>
</td>
</tr>
    <tr>

    	<td colspan="7" height="1"></td>

    </tr>


	<? if(!empty($o->delivery_charges)){ ?>
    <tr>
    	<td colspan="3" rowspan="1" class="GeneralTd B-B" style="vertical-align:top;"><!--Mode of Payment: NB / HDFC--></td>
      	<td colspan="3" class="GeneralTd text-right B-B"><strong>Delivery Charges</strong></td>
  		<td  class="GeneralTd text-right B-B"><strong><?=$o->symbol?> <?=$o->delivery_charges?></strong></td>
    </tr>
    <? } ?>

    <? if(!empty($o->total_packing_charges)){ ?>
    <tr>
    	<td colspan="3" rowspan="1" class="GeneralTd B-B" style="vertical-align:top;"><!--Mode of Payment: NB / HDFC--></td>
      	<td colspan="3" class="GeneralTd text-right B-B"><strong>Packing Charges</strong></td>
  		<td  class="GeneralTd text-right B-B"><strong><?=$o->symbol?> <?=$o->total_packing_charges?></strong></td>
    </tr>
    <? } ?>

    <? if(!empty($o->shipping_discount)){ ?>
    <tr>
    	<td colspan="3" rowspan="1" class="GeneralTd B-B" style="vertical-align:top;"><!--Mode of Payment: NB / HDFC--></td>
      	<td colspan="3" class="GeneralTd text-right B-B"><strong>Shipping Discount</strong></td>
  		<td  class="GeneralTd text-right B-B"><strong>- <?=$o->symbol?> <?=$o->shipping_discount?></strong></td>
    </tr>
    <? } ?>

    <? if(!empty($o->cod_charges) && $o->cod_charges>0){ ?>
    <tr>
    	<td colspan="5" rowspan="1" class="GeneralTd B-B" style="vertical-align:top;"><!--Mode of Payment: NB / HDFC--></td>
      	<td class="GeneralTd text-right B-B"><strong>COD Charges</strong></td>
  		<td  class="GeneralTd text-right B-B"><strong><?=$o->symbol?> <?=$o->cod_charges?></strong></td>
    </tr>
    <? } ?>

    <tr>
    	<td colspan="5" rowspan="1" class="GeneralTd B-B" style="vertical-align:top;"><!--Mode of Payment: NB / HDFC--></td>
      	<td class="GeneralTd text-right B-B"><strong>Total</strong></td>
  		<td  class="GeneralTd text-right B-B"><strong><?=$o->symbol?> <?=$o->total?></strong></td>
    </tr>

    

	<?php /*?><tr>

    	<td class="GeneralTd text-right"><strong>Discount (-)</strong></td>

  		<td class="GeneralTd text-right"><strong>0</strong></td>

    </tr>

    <tr>

    	<td class="GeneralTd text-right B-T"><strong>Billable Amt</strong></td>

  		<td class="GeneralTd text-right B-T"><strong>249</strong></td>

    </tr>

    <tr>

    	<td class="GeneralTd text-right B-TB"><strong>Received</strong></td>

  		<td class="GeneralTd text-right B-TB"><strong>249</strong></td>

    </tr><?php */?>

	<tr>

    	<td colspan="4" height="10" class="GeneralTd B-B2" valign="top" style=" padding:3px; text-align:left;">

        	 <strong><?=ucwords(getIndianCurrency($o->total))?></strong>

        </td>

        <td colspan="3" height="10" class="GeneralTd B-B2" style=" padding:3px; text-align:right;">

        	

           <img src="<?=base_url().__scriptFilePath__?>images/signature.jpg" width="150" style="margin:0;">

            <br>

            Authorized Signatory

        </td>

    </tr>

    

  </tbody>

</table>







</div>

</div>



</body>

</html>

<?

function getIndianCurrency_old( $number)

{

    $decimal = round($number - ($no = floor($number)), 2) * 100;

    $hundred = null;

    $digits_length = strlen($no);

    $i = 0;

    $str = array();

    $words = array(0 => '', 1 => 'one', 2 => 'two',

        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',

        7 => 'seven', 8 => 'eight', 9 => 'nine',

        10 => 'ten', 11 => 'eleven', 12 => 'twelve',

        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',

        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',

        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',

        40 => 'forty', 50 => 'fifty', 60 => 'sixty',

        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');

    $digits = array('', 'hundred','thousand','lakh', 'crore');

    while( $i < $digits_length ) {

        $divider = ($i == 2) ? 10 : 100;

        $number = floor($no % $divider);

        $no = floor($no / $divider);

        $i += $divider == 10 ? 1 : 2;

        if ($number) {

            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;

            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;

            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;

        } else $str[] = null;

    }

    $Rupees = implode('', array_reverse($str));

    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';

    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise ;

}

?>

<script>window.print(); </script>