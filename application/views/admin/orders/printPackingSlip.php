<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Packing Slip</title>
<style type="text/css">
/*	.table {border:1px solid #000;}*/
	.tbale_page p{color:#333;margin:0;font-size:13px; line-height:20px}
	.full_bor{border-top: 2px solid #000;
    border-right: 1px solid #000;
    border-bottom: 2px solid #000;
    border-left: 1px solid #000;}
	.quot th{    text-align: center;
    border: 1px solid #000;    
    color: #383535;}
	.quot td{border:1px solid #000;padding: 3px;}
	.border{border:1px solid #000;}
	.tbale_page p span{color:#f00;}
	table tr td, table tr th{ font-family:Verdana, Geneva, sans-serif; font-size:13px; line-height:20px; padding:0 10px;}
	table tr th{ font-weight:bold;}
	
	table {
  border-spacing: 0;
  border-collapse: collapse;
}
td,
th {
	padding: 0;
	color: #333;
}

thead {
    display: table-header-group;
  }
  
@media print {
#printTd {display:none;}
	.table {
		border-collapse: collapse !important;
	  }
	  .table td,
	  .table th {
		background-color: #fff !important;
	  }
	  .table-bordered th,
	  .table-bordered td {
		border: 1px solid #ddd !important;
	  }
}

th {
  text-align: left;
}
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 20px;
}
.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top:0;
}
.table > thead > tr > th {
  vertical-align: bottom;
  border-bottom:0;
}
.table > caption + thead > tr:first-child > th,
.table > colgroup + thead > tr:first-child > th,
.table > thead:first-child > tr:first-child > th,
.table > caption + thead > tr:first-child > td,
.table > colgroup + thead > tr:first-child > td,
.table > thead:first-child > tr:first-child > td {
  border-top: 0;
}
.table > tbody + tbody {
  border-top: 2px solid #ddd;
}
.table .table {
  background-color: #fff;
}
.table-condensed > thead > tr > th,
.table-condensed > tbody > tr > th,
.table-condensed > tfoot > tr > th,
.table-condensed > thead > tr > td,
.table-condensed > tbody > tr > td,
.table-condensed > tfoot > tr > td {
  padding: 5px;
}
.table-bordered {
  border: 1px solid #ddd;
}
.table-bordered > thead > tr > th,
.table-bordered > tbody > tr > th,
.table-bordered > tfoot > tr > th,
.table-bordered > thead > tr > td,
.table-bordered > tbody > tr > td,
.table-bordered > tfoot > tr > td {
  border: 1px solid #ddd;
}
.table-bordered > thead > tr > th,
.table-bordered > thead > tr > td {
  border-bottom-width: 2px;
}
.table-striped > tbody > tr:nth-of-type(odd) {
  background-color: #f9f9f9;
}
.table-hover > tbody > tr:hover {
  background-color: #f5f5f5;
}
table col[class*="col-"] {
  position: static;
  display: table-column;
  float: none;
}
table td[class*="col-"],
table th[class*="col-"] {
  position: static;
  display: table-cell;
  float: none;
}
.table > thead > tr > td.active,
.table > tbody > tr > td.active,
.table > tfoot > tr > td.active,
.table > thead > tr > th.active,
.table > tbody > tr > th.active,
.table > tfoot > tr > th.active,
.table > thead > tr.active > td,
.table > tbody > tr.active > td,
.table > tfoot > tr.active > td,
.table > thead > tr.active > th,
.table > tbody > tr.active > th,
.table > tfoot > tr.active > th {
  background-color: #f5f5f5;
}
.table-hover > tbody > tr > td.active:hover,
.table-hover > tbody > tr > th.active:hover,
.table-hover > tbody > tr.active:hover > td,
.table-hover > tbody > tr:hover > .active,
.table-hover > tbody > tr.active:hover > th {
  background-color: #e8e8e8;
}
.table > thead > tr > td.success,
.table > tbody > tr > td.success,
.table > tfoot > tr > td.success,
.table > thead > tr > th.success,
.table > tbody > tr > th.success,
.table > tfoot > tr > th.success,
.table > thead > tr.success > td,
.table > tbody > tr.success > td,
.table > tfoot > tr.success > td,
.table > thead > tr.success > th,
.table > tbody > tr.success > th,
.table > tfoot > tr.success > th {
  background-color: #dff0d8;
}
.table-hover > tbody > tr > td.success:hover,
.table-hover > tbody > tr > th.success:hover,
.table-hover > tbody > tr.success:hover > td,
.table-hover > tbody > tr:hover > .success,
.table-hover > tbody > tr.success:hover > th {
  background-color: #d0e9c6;
}
.table > thead > tr > td.info,
.table > tbody > tr > td.info,
.table > tfoot > tr > td.info,
.table > thead > tr > th.info,
.table > tbody > tr > th.info,
.table > tfoot > tr > th.info,
.table > thead > tr.info > td,
.table > tbody > tr.info > td,
.table > tfoot > tr.info > td,
.table > thead > tr.info > th,
.table > tbody > tr.info > th,
.table > tfoot > tr.info > th {
  background-color: #d9edf7;
}
.table-hover > tbody > tr > td.info:hover,
.table-hover > tbody > tr > th.info:hover,
.table-hover > tbody > tr.info:hover > td,
.table-hover > tbody > tr:hover > .info,
.table-hover > tbody > tr.info:hover > th {
  background-color: #c4e3f3;
}
.table > thead > tr > td.warning,
.table > tbody > tr > td.warning,
.table > tfoot > tr > td.warning,
.table > thead > tr > th.warning,
.table > tbody > tr > th.warning,
.table > tfoot > tr > th.warning,
.table > thead > tr.warning > td,
.table > tbody > tr.warning > td,
.table > tfoot > tr.warning > td,
.table > thead > tr.warning > th,
.table > tbody > tr.warning > th,
.table > tfoot > tr.warning > th {
  background-color: #fcf8e3;
}
.table-hover > tbody > tr > td.warning:hover,
.table-hover > tbody > tr > th.warning:hover,
.table-hover > tbody > tr.warning:hover > td,
.table-hover > tbody > tr:hover > .warning,
.table-hover > tbody > tr.warning:hover > th {
  background-color: #faf2cc;
}
.table > thead > tr > td.danger,
.table > tbody > tr > td.danger,
.table > tfoot > tr > td.danger,
.table > thead > tr > th.danger,
.table > tbody > tr > th.danger,
.table > tfoot > tr > th.danger,
.table > thead > tr.danger > td,
.table > tbody > tr.danger > td,
.table > tfoot > tr.danger > td,
.table > thead > tr.danger > th,
.table > tbody > tr.danger > th,
.table > tfoot > tr.danger > th {
  background-color: #f2dede;
}
.table-hover > tbody > tr > td.danger:hover,
.table-hover > tbody > tr > th.danger:hover,
.table-hover > tbody > tr.danger:hover > td,
.table-hover > tbody > tr:hover > .danger,
.table-hover > tbody > tr.danger:hover > th {
  background-color: #ebcccc;
}
.table-responsive {
  min-height: .01%;
  overflow-x: auto;
}
@media screen and (max-width: 767px) {
 #printTd {display:none;}
  .table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-y: hidden;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #ddd;
  }
  .table-responsive > .table {
    margin-bottom: 0;
  }
  .table-responsive > .table > thead > tr > th,
  .table-responsive > .table > tbody > tr > th,
  .table-responsive > .table > tfoot > tr > th,
  .table-responsive > .table > thead > tr > td,
  .table-responsive > .table > tbody > tr > td,
  .table-responsive > .table > tfoot > tr > td {
    white-space: nowrap;
  }
  .table-responsive > .table-bordered {
    border: 0;
  }
  .table-responsive > .table-bordered > thead > tr > th:first-child,
  .table-responsive > .table-bordered > tbody > tr > th:first-child,
  .table-responsive > .table-bordered > tfoot > tr > th:first-child,
  .table-responsive > .table-bordered > thead > tr > td:first-child,
  .table-responsive > .table-bordered > tbody > tr > td:first-child,
  .table-responsive > .table-bordered > tfoot > tr > td:first-child {
    border-left: 0;
  }
  .table-responsive > .table-bordered > thead > tr > th:last-child,
  .table-responsive > .table-bordered > tbody > tr > th:last-child,
  .table-responsive > .table-bordered > tfoot > tr > th:last-child,
  .table-responsive > .table-bordered > thead > tr > td:last-child,
  .table-responsive > .table-bordered > tbody > tr > td:last-child,
  .table-responsive > .table-bordered > tfoot > tr > td:last-child {
    border-right: 0;
  }
  .table-responsive > .table-bordered > tbody > tr:last-child > th,
  .table-responsive > .table-bordered > tfoot > tr:last-child > th,
  .table-responsive > .table-bordered > tbody > tr:last-child > td,
  .table-responsive > .table-bordered > tfoot > tr:last-child > td {
    border-bottom: 0;
  }
}

.text-center{ text-align:center;}

.table {border:1px solid #000;}
.tbale_page p{color:#333;margin:0;font-size:13px; line-height:20px}
.full_bor{border-top: 2px solid #000;
border-right: 1px solid #000;
border-bottom: 2px solid #000;
border-left: 1px solid #000;}
.quot th{    text-align: center;
border: 1px solid #000;    
color: #383535;}
.quot td{border:1px solid #000;padding: 3px;}
.border{border:1px solid #000;}
.tbale_page p span{color:#f00;}
table tr td, table tr th{ font-family:Verdana, Geneva, sans-serif; font-size:13px; line-height:20px; padding:0 10px;}
table tr th{ font-weight:bold;}
* ISO Paper Size */
@page {
  size: A4 landscape;
}

/* Size in mm */    
@page {
  size: 100mm 200mm landscape;
}

/* Size in inches */    
@page {
  size: 4in 6in landscape;
}
</style>
<?php /*?><link rel="stylesheet" type="text/css" href="<?php echo MAINSITE;?>css/printdc.css" media="print">
<link rel="stylesheet" href="<?php echo MAINSITE;?>css/stylesheetdc.css" type="text/css" charset="utf-8" /><?php */?>
</head>
<body>
<?
$od = $orders[0];
$slip_data = json_decode($od->packing_slip_data[0]->packing_slip_json);
$store_data = $od->store_data[0];
/*	echo "<pre>";
//	print_r($od); 
	print_r($slip_data);
	echo "</pre>";*/
//exit;									  

  ?>
	<div style="width:700px; margin:0 auto; margin-top:10px;">
        <table class="table" cellpadding="0" border="1" cellspacing="0" style='width:100%; max-width: 100%; margin-bottom: 20px;color:#333;margin:0;font-size:12px; line-height:20px; border:1px solid #000'>
            <tbody>                
                <tr>
                    <td colspan="8" align="center" style="border-bottom:1px solid #000; border-left:1px solid #000;  border-right:1px solid #000; line-height:15px;padding:5px 10px;"><strong>Delivery Challan</strong></td>
                </tr>
    
                <tr style="text-align:left;color: #383535;">
                    <td colspan="5" style="border-bottom:1px solid #000; border-left:1px solid #000;  border-right:0; padding-left:10px;">
                        <h2 style="font-size:13px; margin:0;"><?=$store_data->name?></h2>
                        <p style="margin-top:0;margin-bottom:0;font-size:12px;"><strong>India's leading online supplies store for Dental products</strong></p>
                        <p style="margin-bottom:0;margin-top:5px;line-height:17px;   font-size: 12px;">	Warehouse<br/>
                            <?=nl2br($store_data->address)?><br>
                            GSTIN: <strong><?=$store_data->gst_no?></strong><br/>
                            Ph: <?=$store_data->store_contact_number?>
                        </p>
                    </td>
                    <td colspan="3" style="border-bottom:1px solid #000; border-left:0;  border-right:1px solid #000; text-align:right; padding-right:10px">
                      <h4 style="margin-top:1px;font-weight:600;">&nbsp;</h4>
                        <p><?=$od->courier_name?> Reff No :<?=$od->delivery_challan_no?><br>Order Date : <? echo date('d/m/Y' , strtotime($od->added_on));?><br/>Order No : <?=$od->order_number?></p>
                    </td>
                </tr>
                <tr>
                	<td colspan="8" style="padding:5px 10px; border-right:1px solid #000; border-bottom:1px solid #000;" align="left">
                    	<h3 style="margin-top:0; margin-bottom:5px;font-size: 12px"><?php echo strtoupper($od->name); ?></h3>
                        <p style="text-transform:uppercase; line-height:16px;font-size: 12px;margin-top:0;margin-bottom:0;">
                        	<?=$od->d_address?><br/>
                            <?=$od->d_city_name?> <?=$od->d_zipcode?>
                            <br/>
                            <?=$od->d_state_name?>
                            <br>
                            Tel: <?=$od->d_number?>
						</p>
                    </td>
                </tr>
              
                
                <tr>
                	<th colspan="4" style="padding: 3px 5px 3px 10px; border-right:0; border-left:0; border-bottom:1px solid #000; text-align:left;font-size:11px;" align="left">Description</th>
                   	<th colspan="2" style="padding: 3px 5px; border-right:0; border-left:0; border-bottom:1px solid #000; text-align:left;font-size:11px;" align="left">Total Quantity </th>
                    <th colspan="2" style="padding: 3px 10px 3px 5px; border-right:1px solid #000; border-left:0; border-bottom:1px solid #000;font-size:11px;text-align:right;" align="right">Total (Rs.)
</th>
                </tr>
                
                <tr>
                	<td colspan="4" width="40%" style="padding: 3px 5px 3px 10px; border-right:0; border-bottom:0; border-left:0; line-height:20px;;font-size: 12px" align="left"><div style="min-height:60px;">Dental Products</div></td>
                   	<td colspan="2" width="5%" style="padding: 3px 5px; border-right:0; border-left:0; border-bottom:0; line-height:20px;;font-size: 12px" align="left"><div style="min-height:60px;"><?=$od->total_prod?></div></td>
                    <td colspan="2" width="15%" style="padding: 3px 10px 3px 5px; border-right:1px solid #000; border-left:0; border-bottom:0; text-align:right; line-height:20px;;font-size: 12px" align="right"><div style="min-height:60px;"><?=$od->total?> /-</div></td>
                    
                </tr>
                
                <tr>
                   	<td colspan="4" style="padding: 3px 5px 3px 10px; border-right:0; border-bottom:1px solid #000; border-top:1px solid #000;font-size: 11px" align="left"><strong>MRP (Inclusive of applicable Tax) </strong></td>
                    <td colspan="4" style="padding: 3px 10px 3px 5px; border-left:0; border-right:1px solid #000; border-bottom:1px solid #000;font-size: 11px; border-top:1px solid #000;" align="right"><strong>Grand Total: <?=$od->total?> /-</strong></td>
                </tr>
              
                
                <tr>
                   	<td colspan="7" style="padding: 4px 5px 4px 10px; border-right:0; border-bottom:1px solid #000; border-top:1px solid #000;font-size:12px;" align="left">This is a computer generated Delivery Challan, no signature required</td>
                    <td colspan="1" style="padding: 3px 10px 3px 5px; border-left:0; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;font-size:12px;" align="right">Print No: 1</td>
                </tr>
               
            </tbody>	
         </table>
         <table class="table" cellpadding="0" border="0" cellspacing="0" style='width:100%; margin-bottom:0; max-width: 100%; color:#333; font-size:12px; line-height:20px; border:0'>
         	<tr>
         		<td style="padding:0;">
                	<div style="border-top:1px dashed #000; margin:20px 0; width:100%;"></div>
                </td>
            </tr>
         </table>
         <table class="table" cellpadding="0" border="1" cellspacing="0" style='width:100%; max-width: 100%; margin-bottom: 20px;color:#333;margin:0;font-size:12px; line-height:20px; border:1px solid #000;'>
            <tbody>
                <tr>
                    <td colspan="8" align="center" style="border-bottom:1px solid #000; border-left:1px solid #000;  border-right:1px solid #000; padding-left:20px; padding-right:20px;"><strong>AIRWAY BILL - <?=$od->courier_name?></strong></td>
                </tr>
                <tr>
                    <td colspan="3" width="45%" align="left" style="border-bottom:1px solid #000; border-left:1px solid #000;  border-right:1px solid #000; padding-left:10px; padding-right:10px;">
                    	<p style="margin-top:0;font-weight:600	; margin-bottom:0; font-size: 13px"><?php echo strtoupper($od->name); ?></p>
                    	<p style="font-size: 12px;line-height:15px;margin-top:5px;margin-bottom:5px;">
                              <?=$od->d_address?><br/>
                             <?=$od->d_city_name?> <?=$od->d_zipcode?>
                            <br/>
                            <?=$od->d_state_name?>
                        </p>
                        <p style="margin:0;"><span style="display:inline-block;font-size: 13px">
                            	Tel: <?=$od->d_number?><br/>
								Order : <?=$od->order_number?>
                            </span></p>
                            <p style="margin:0"><span style="display:inline-block;font-size: 13px;margin-top:5px;">
                            	ORG: Bangalore<br/>
								DEST: <?=$od->d_city_name?>
                            </span></p>
                        </td>
                         <td colspan="5"  width="55%" align="left" style="border-bottom:1px solid #000; border-left:1px solid #000;  border-right:1px solid #000; padding-left:20px; padding-right:20px;">
                        <div style="margin-bottom:10px;margin-top:10px;">
                        	<!--<span style="display:inline-block;">
                            	Tel: <? // echo $phone_no;?><br/>
								Order : <? // echo $grs_order_no;?>
                            </span>-->
                            
                            <span style="display:inline-block;">
                            	
                                <div id="externalbox" style="width:100%; display:inline-block" >
                                <? $font_size = "25px"; ?>
                               
<?php
$packing_slip_data_json = $slip_data->packages;
$packing_slip_data_json = $packing_slip_data_json[0];
//print_r($packing_slip_data_json);
?>
                                <img src="<?=$packing_slip_data_json->barcode?>">
                            <div class="font123" style="display:inline-block; font-size: <?=$font_size?>;"><?php echo $packing_slip_data_json->wbn; ?></div>    
<?php /*?><div id="inputdata<? echo $i;?>1" style="display:inline-block"><?php echo $barcode_no; ?></div><?php */?>
</div>
<?php /*?><script type="text/javascript">
  function get_object(id) {
   var object = null;
   if (document.layers) {
   object = document.layers[id];
   } else if (document.all) {
   object = document.all[id];
   } else if (document.getElementById) {
    object = document.getElementById(id);
   }
   //alert(object);
   return object;
   
  }
get_object("inputdata<? echo $i;?>1").innerHTML=DrawCode39Barcode(get_object("inputdata<? echo $i;?>1").innerHTML,0);

</script><?php */?>
                                
                                
                            </span>
						</div>
						<div>
                        	<!--<span style="display:inline-block;">
                            	ORG: Bangalore<br/>
								DEST: <? // echo $city;?>
                            </span>-->
                            <span style="display:inline-block;">
                            	  <div id="externalbox" style="width:3in; display:inline-block" >
                                  <img src="<?=$slip_data->packages[0]->oid_barcode?>" width="200">
                                  <div class="font123" style="display:inline-block; font-size: 40px;"><?php //echo $delivery_chalan_no; ?></div>    
<?php /*?><div id="inputdata<? echo $i;?>2" style="display:inline-block"><?php echo $delivery_chalan_no; ?></div><?php */?>
</div>
<?php /*?><script type="text/javascript">
  function get_object(id) {
   var object = null;
   if (document.layers) {
   object = document.layers[id];
   } else if (document.all) {
   object = document.all[id];
   } else if (document.getElementById) {
    object = document.getElementById(id);
   }
   //alert(object);
   return object;
   
  }
get_object("inputdata<? echo $i;?>2").innerHTML=DrawCode39Barcode(get_object("inputdata<? echo $i;?>2").innerHTML,0);
</script><?php */?>
                            </span>
						</div>
					</td>
                        </tr>
                       
                </tr>
    		</tbody>	
         </table>
   	</div>
    <div style="page-break-after: always;"></div>
    
<div id="printTd" style="width:650px; text-align:right; clear:both"><img src="<?php echo base_url();?>assets/front/images/print.png" alt="Print" width="32" height="32" border="0" onClick="window.print()"/></div>
</body>
</html>
   