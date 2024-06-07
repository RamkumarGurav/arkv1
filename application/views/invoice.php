

<!DOCTYPE HTML>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Invoice</title>

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

            <img src="<?=base_url().__scriptFilePath__?>images/logo.png" width="150" style="margin:0;">

            

        </td>
       
        <td colspan="2" class="GeneralTd HEader" style="vertical-align:top;padding-left: 80px;">
        	<p style="margin:0;"><strong><?=_project_name_?></strong></p>
            <p style="margin:0;"><i class="fa fa-map-marker"></i> <?=_project_address_?></p>
            <p style=" margin:0"><i class="fa fa-envelope"></i> <?=_project_email_?></p>
            <p style=" margin:0"><i class="fa fa-phone"></i><?=_project_contact_?></p>
            <p style="margin:0;"><strong>GST No :</strong> <?=__GSTIN__?></p>
        </td>

        <td colspan="3" class="GeneralTd2 HEader <?php /*?>text-right<?php */?> Head2">

            <p style="margin-top:2px; margin-bottom:2px;">

                <strong>Invoice No :</strong> <span>123</span>

            </p>

            <p style="margin-top:2px; margin-bottom:2px;">

                <strong>Invoice Date :</strong> <span>21/11/2022</span>

            </p>
            
           
            <p style="margin-top:2px; margin-bottom:2px;">
                <strong>Payment Method :</strong> <span>Prepaid</span>
            </p>
            <p style="margin-top:2px; margin-bottom:2px;">
                <strong>Bank Reff No. :</strong> <span>123</span>
            </p>
            <p style="margin-top:2px; margin-bottom:2px;">
                <strong>Payment Mode :</strong> <span>online</span>
            </p>
       
            <p style="margin-top:2px; margin-bottom:2px;">
                <strong>Payment Method :</strong> <span>Cash On Delivery</span>
            </p>
         

        </td>

    </tr>

    

    <tr>

        <td colspan="7" class="GeneralTd3 text-center" style="padding:5px;"><strong>Bill / Receipt Details</strong></td>

    </tr>

    <tr>

        <td colspan="7" class="GeneralTd text-left  B-TB"><strong>Order By :</strong> rashmi , 123 , rashmi@marswebsolutions.com</td>

    </tr>

    <tr>

        <td colspan="4" class="GeneralTd B-TB">

            <h4 style="margin:0 0 5px;">Billing Address</h4>

            <h5 style="margin:0 0 5px;">rashmi</h5>

            <p style="margin:0 0 5px;">123</p>

            <p style="margin:0 0 5px;">abc<br>bangalore - 560048<br>Karnataka<br>India</p>
            
           
            <p style="margin:0 0 5px;">
                <strong>Customer data</strong>
                <br>
                <strong>GSTIN:</strong> GST123
                
            </p>
       

        </td>

        <td colspan="3" class="GeneralTd  B-TB" style="vertical-align:top;">

            <h4 style="margin:0 0 5px;">Shipping Address</h4>

            <h5 style="margin:0 0 5px;">rashmi</h5>

            <p style="margin:0 0 5px;">123</p>

            <p style="margin:0 0 5px;">abc<br>bangalore - 560048<br>Karnataka<br>India</p>

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


    <tr>

        <td class="GeneralTd BorderBot">1</td>

        <td colspan="2" class="GeneralTd BorderBot">brass - 123</td>

        <td class="GeneralTd text-right BorderBot">2</td>

        <td class="GeneralTd text-right BorderBot">160.00</td>

        <td class="GeneralTd text-right BorderBot">15.24(%)</td>

        <td class="GeneralTd text-right BorderBot">320</td>

    </tr>

   
</table>
</td>
</tr>
    <tr>

        <td colspan="7" height="1"></td>

    </tr>


   
    <tr>
        <td colspan="3" rowspan="1" class="GeneralTd B-B" style="vertical-align:top;"><!--Mode of Payment: NB / HDFC--></td>
        <td colspan="3" class="GeneralTd text-right B-B"><strong>Delivery Charges</strong></td>
        <td  class="GeneralTd text-right B-B"><strong>0.00</strong></td>
    </tr>
 

   
    <tr>
        <td colspan="3" rowspan="1" class="GeneralTd B-B" style="vertical-align:top;"><!--Mode of Payment: NB / HDFC--></td>
        <td colspan="3" class="GeneralTd text-right B-B"><strong>Packing Charges</strong></td>
        <td  class="GeneralTd text-right B-B"><strong>0.00</strong></td>
    </tr>
 

   
    <tr>
        <td colspan="3" rowspan="1" class="GeneralTd B-B" style="vertical-align:top;"><!--Mode of Payment: NB / HDFC--></td>
        <td colspan="3" class="GeneralTd text-right B-B"><strong>Shipping Discount</strong></td>
        <td  class="GeneralTd text-right B-B"><strong>0%</strong></td>
    </tr>
  

 
    <tr>
        <td colspan="5" rowspan="1" class="GeneralTd B-B" style="vertical-align:top;"><!--Mode of Payment: NB / HDFC--></td>
        <td class="GeneralTd text-right B-B"><strong>COD Charges</strong></td>
        <td  class="GeneralTd text-right B-B"><strong>0.00</strong></td>
    </tr>
 

    <tr>
        <td colspan="5" rowspan="1" class="GeneralTd B-B" style="vertical-align:top;"><!--Mode of Payment: NB / HDFC--></td>
        <td class="GeneralTd text-right B-B"><strong>Total</strong></td>
        <td  class="GeneralTd text-right B-B"><strong>320</strong></td>
    </tr>

    

   
    <tr>

        <td colspan="4" height="10" class="GeneralTd B-B2" valign="top" style=" padding:3px; text-align:left;">

             <strong>Three Hundred and Twenty Rupees</strong>

        </td>

        <td colspan="3" height="10" class="GeneralTd B-B2" style=" padding:3px; text-align:right;">

            

           <!-- <img src="<?=base_url().__scriptFilePath__?>images/signature.jpg" width="150" style="margin:0;"> -->

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



<script>window.print(); </script>