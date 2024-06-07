<?php
$page_module_name = "Order Detail";
?>
<?
$od = $order_data[0];
?>
<style type="text/css" >
.newModalCss {border-radius: 15px 15px 0 0;overflow:hidden;}
	.newModalCss .modal-header{background-color: #3C8DBC;
    color: #fff;
    
}
	.newModalCss label{text-align:right;padding-top: 4px;}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?=$page_module_name?> <small>Details</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=MAINSITE_Admin."wam"?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name?>"><?=$user_access->module_name?> List</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <?  ?>
    <section class="content">
        <div class="row">

                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                	<div class="col-md-4">
                                	<h3 class="box-title">Order Details </h3>
                                    </div>
                                    <div class="col-md-8 text-right">
                                    <?php /*?><a href="<? echo MAINSITE."secureRegions/wdm/stores/edit/".$od->orders_id;?>" class="btn btn-primary ">Update Stores Details</a>&nbsp;<?php */?>
                                    
                                    <? if(true){ ?>
                                    <? if($od->order_status!=6 && $od->order_status!=4){ ?>
                                    <a href="#Modalpop" data-toggle="modal" class="btn btn-primary">Take Action</a>
                                    <? }} ?>
                                    
                                    <a href="<? echo MAINSITE."secureRegions/orders/Orders_Module/orderInvoice/$od->orders_id"; ?>" target="_blank" class="btn btn-primary">Print Order</a>
                                    <? if(!empty($od->order_invoice)){ ?>
                                    <a href="<? echo base_url()."assets/uploads/invoice/".$od->order_invoice; ?>" target="_blank" class="btn btn-primary">Invoice</a>
                                    <? } ?>
                                    
                                    <? if($od->courier_name == 'Bluedart' && false){ 
									
									?>
                                    <a href="<? echo MAINSITE."secureRegions/orders/trackOrder/$od->orders_id"; ?>" target="_blank" class="btn btn-primary">Track Order</a>
                                    <? } ?>
                                    
                                     <? if(!empty($od->docket_no) && $od->courier_name =='Delhivery')
										{ ?>
                                       <a onclick="getTrackingData()" target="_blank" class="btn btn-primary">Track Order</a>
                                       <? } ?>
                                    
                                    </div>
                                </div>
                                <div class="box-body">

                                

<?
/*echo "<pre>";
print_r($od);
echo "</pre>";*/
?>
<div class="tab-content  ">
<ul class="nav nav-tabs " role="tablist">
    <li role="presentation" class="active"><a href="#od_details" id="od_details_a" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="true">Details</a></li>
    <li role="presentation" class=""><a href="#od_history" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">History</a></li>
    <? /*if($od->courier_name == 'Bluedart'){ ?>
    <li role="presentation" class=""><a href="#od_bluedart_tracking" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Tracking</a></li>
    <? }*/ ?>
</ul>


    
<div role="tabpanel" class="tab-pane fade  active in" id="od_details">
    <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title">Order Details</h3></div><!-- /.box-header -->
            <?php /*?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding images.</span><?php */?>
        <div class="box-body">
<?
if(!empty($od->order_status))
{
	if($od->order_status==2)
	{
		$insurance=2;
		$service=2;
		$total_package_weight = $od->total_weight;
		//$total_package_weight = round($od->total_weight/1000 , 3);
		$box_l = $box_b = $box_h = '10';
		?>

<? if($od->d_country_id == __const_country_id__ ){# only or local in india ?>
<? if(empty($od->docket_no)){ 

$domestic_shipping_type = ''; 

if(isset($_POST['by_bluedart']))
{
	$domestic_shipping_type = $_POST['by_bluedart']; 
}

if(isset($_POST['by_delhivery']))
{
	$domestic_shipping_type = $_POST['by_delhivery']; 
}
if(isset($_POST['by_dtdc']))
{
	$domestic_shipping_type = $_POST['by_dtdc'];
	//$this->load->library('DTDC_Lib'); 
	//$dtdc_Lib = new DTDC_Lib;
	
	/*$this->load->library('DTDC_Lib'); 
	$dtdc_Lib = new DTDC_Lib;
	$dtdc_service_type = $dtdc_Lib->getServiceTypes($od->d_zipcode);
	//echo $dtdc_service_type;
	$result = $json = json_decode($dtdc_service_type, true);
	if(!empty($result['message']) && $result['message']=='SUCCESS')
		{
			echo '<span style="color:#14c614">Delivery Available</span>';
			$domestic_shipping_type = 1;
		}
		else
		{
			echo '<span style="color:#F00">Delivery Not Available</span>';
		}*/
	
}


if($od->is_cod==1)
{
	$domestic_shipping_type = 2; 
}
else if(empty($domestic_shipping_type))
{
	
?>
<form action="#" method="post" >
<?php /*?><button type="submit" value="1" class="btn btn-info" name="by_bluedart">Ship By Bluedart</button>
<button type="submit" value="2" class="btn btn-danger" name="by_delhivery">Ship By Delhivery</button><?php */?>
<button type="submit" value="3" class="btn btn-danger" name="by_dtdc">Ship By DTDC</button>
</form>
<?	
}


?>


<? 
#bluedart
if($domestic_shipping_type==1){ 
?>
<script>
window.addEventListener("load", function(){
	
  getPincodeDetail();
});
</script>
		
        <form role="form" class="form-horizontal" name="ShippingForm" id="ShippingForm" action="" method="post" enctype="multipart/form-data">
        <div id="PincodeData">
		
<div class="alert alert-info">
 Getting Pincode Data
</div>
		
		</div>
                <section class="content">
                    <div class="row">
                    <input type="hidden" id="myurl" value="<?php echo MAINSITE."secureRegions/wdm";?>"/>
                    <input type="hidden" name="orders_id" id="orders_id" value="<?=$od->orders_id?>" />
                    	<!-- left column -->
                        <div class="col-md-10">
                        <!-- general form elements -->
                            <div class="box box-primary">
                                <!-- /.box-header -->
                                <div class="box-body">
                                	<div class="form-group">
                                        <div class="col-md-3">
                                            <div class="label-wrapper"><label class="control-label" for="Name">Package Send t</label>
                                                <div data-title="Total Package Weight (In Gram)." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">

                                            <div class="input-group input-group-required">
                                            <?
											foreach($delivery_type_list as $dtl)
											{
											?>
                                                <input type="radio" class="" name="blue_dart_product_code" id="blue_dart_product_code<?=$dtl->slno?>"
                                                 <? if($dtl->slno==1){echo "checked";} ?> value="<?=$dtl->blue_dart_product_code?>"   /> <?=$dtl->label?> &nbsp;&nbsp;
	                                        <? } ?>
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                   </div>
                                   
                                   <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="label-wrapper"><label class="control-label" for="Name">Package Weight (In GM)</label>
                                                <div data-title="Total Package Weight (In Gram)." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group input-group-required">
                                                <input type="number" step="any"  min="0.01" name="total_package_weight" id="total_package_weight" placeholder="Total Package Weight" class="form-control" value="<?=$total_package_weight?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                   </div>
                                   
                                   <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="label-wrapper"><label class="control-label" for="Name">Dimension (L*B*H)(In CM)</label>
                                                <div data-title="Package Dimension (L*B*H)(In CM)"  class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_l" id="box_l" min="1" placeholder="Lenght" class="form-control" value="<?=$box_l?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_b" id="box_b" min="1" placeholder="Breadth" class="form-control" value="<?=$box_b?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_h" id="box_h" min="1" placeholder="Height" class="form-control" value="<?=$box_h?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                   </div>

                                   <div class="form-group">
                                        
                                        <div class="col-md-12">
                                            <div class="input-group input-group-required">
                                                <center>
                                             <button type="button" class="btn btn-primary CalculateShippingBtn docket_btn" style="display:none"  onclick="generateBluedartDocketNo()" id="load1" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Calculating Shipping Price">Assign Docket No.</button>
<?php /*?><br>
  <br>
<button type="button" class="btn btn-primary btn-lg" id="load2" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Order">Submit Order</button><?php */?>


                                                </center>
                                               
                                                </div>
                                            </div>
                                        </div>
                                   </div>

                                </div>
                            </div>
                        <!-- /.box -->
                        </div>
                        <!--/.col (left) -->
                </section>
            <!-- /.content -->
            </form>
            <div id="ShippingPriceData"></div>
<? }else if($domestic_shipping_type==2 ){ ?>
<?
$insurance=2;
		$service=2;
		$total_package_weight = $od->total_weight;
		//$total_package_weight = round($od->total_weight/1000 , 3);
		$box_l = $box_b = $box_h = '10';
?>

<script>
window.addEventListener("load", function(){
  getPincodeDetailDelhivery();
});
</script>

<div id="PincodeData">
		
<div class="alert alert-info">
 Getting Pincode Data
</div>
		
		</div>
        
        <form role="form" class="form-horizontal" name="ShippingForm" id="ShippingForm" action="" method="post" enctype="multipart/form-data">
                <section class="content">
                    <div class="row">
                    <input type="hidden" id="myurl" value="<?php echo MAINSITE."secureRegions/wdm";?>"/>
                    <input type="hidden" name="orders_id" id="orders_id" value="<?=$od->orders_id?>" />
                    	<!-- left column -->
                        <div class="col-md-10">
                        <!-- general form elements -->
                            <div class="box box-primary">
                                <!-- /.box-header -->
                                <div class="box-body">
                                	<div class="form-group">
                                        <div class="col-md-3">
                                            <div class="label-wrapper"><label class="control-label" for="Name">Package Weight (In GM)</label>
                                                <div data-title="Total Package Weight (In Gram)." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group input-group-required">
                                                <input type="number" step="any"  min="0.01" name="total_package_weight" id="total_package_weight" placeholder="Total Package Weight" class="form-control" value="<?=$total_package_weight?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                   </div>
                                   
                                   <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="label-wrapper"><label class="control-label" for="Name">Dimension (L*B*H)(In CM)</label>
                                                <div data-title="Package Dimension (L*B*H)(In CM)"  class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_l" id="box_l" min="1" placeholder="Lenght" class="form-control" value="<?=$box_l?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_b" id="box_b" min="1" placeholder="Breadth" class="form-control" value="<?=$box_b?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_h" id="box_h" min="1" placeholder="Height" class="form-control" value="<?=$box_h?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                   </div>

                                   <div class="form-group">
                                        
                                        <div class="col-md-12">
                                            <div class="input-group input-group-required">
                                                <center>
                                                <button type="button" class="btn btn-primary CalculateShippingBtn"  onclick="generateDocketNoDelhivery()" id="load1" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Calculating Shipping Price">Assign Docket No.</button>
<?php /*?><br>
  <br>
<button type="button" class="btn btn-primary btn-lg" id="load2" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Order">Submit Order</button><?php */?>


                                                </center>
                                               
                                                </div>
                                            </div>
                                        </div>
                                   </div>

                                </div>
                            </div>
                        <!-- /.box -->
                        </div>
                        <!--/.col (left) -->
                        
                        
                </section>
            <!-- /.content -->
            </form>
            
  <div id="ShippingPriceData"></div>          
<script>



function assignShiprocketGenerateManifests(){
	if(confirm('Do you really want to Generate Manifest of Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketGenerateManifestsBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Generate Manifest For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_generate_manifest_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketGenerateManifestsBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}

function assignShiprocketPrintManifests(){
	if(confirm('Do you really want to Print Manifest of Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketPrintManifestsBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Print Manifest For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_print_manifest_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketPrintManifestsBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}

function assignShiprocketOrderLabel(){
	if(confirm('Do you really want to Generate Shipping Label For Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketOrderLabelBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Generating Shipping Label For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_label_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketOrderLabelBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}


function assignShiprocketOrderInvoice(){
	if(confirm('Do you really want to Generate Shipping Invoice For Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketOrderInvoiceBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Generating Shipping Invoice For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_invoice_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketOrderInvoiceBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}



</script>


<? }
else if($domestic_shipping_type==3 ){ ?>
<?
$insurance=2;
		$service=2;
		$total_package_weight = $od->total_weight;
		//$total_package_weight = round($od->total_weight/1000 , 3);
		$box_l = $box_b = $box_h = '10';
?>

<script>
window.addEventListener("load", function(){
  getPincodeDetailDTDC();
});
</script>

<div id="PincodeData">
		
<div class="alert alert-info">
 Getting Pincode Data
</div>
		
		</div>
        <div class="is_dtdc_service_available" style="display:none">
        <form role="form" class="form-horizontal" name="ShippingForm" id="ShippingForm" action="" method="post" enctype="multipart/form-data">
                <section class="content">
                    <div class="row">
                    <input type="hidden" id="myurl" value="<?php echo MAINSITE."secureRegions/wdm";?>"/>
                    <input type="hidden" name="orders_id" id="orders_id" value="<?=$od->orders_id?>" />
                    	<!-- left column -->
                        <div class="col-md-10">
                        <!-- general form elements -->
                            <div class="box box-primary">
                                <!-- /.box-header -->
                                <div class="box-body">
                                	<div class="form-group">
                                        <div class="col-md-3">
                                            <div class="label-wrapper"><label class="control-label" for="Name">Package Weight (In GM)</label>
                                                <div data-title="Total Package Weight (In Gram)." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group input-group-required">
                                                <input type="number" step="any"  min="0.01" name="total_package_weight" id="total_package_weight" placeholder="Total Package Weight" class="form-control" value="<?=$total_package_weight?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                   </div>
                                   
                                   <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="label-wrapper"><label class="control-label" for="Name">Dimension (L*B*H)(In CM)</label>
                                                <div data-title="Package Dimension (L*B*H)(In CM)"  class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_l" id="box_l" min="1" placeholder="Lenght" class="form-control" value="<?=$box_l?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_b" id="box_b" min="1" placeholder="Breadth" class="form-control" value="<?=$box_b?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_h" id="box_h" min="1" placeholder="Height" class="form-control" value="<?=$box_h?>" >
                                                <div class="input-group-btn"><span class="required">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                   </div>

                                   <div class="form-group">
                                        
                                        <div class="col-md-12">
                                            <div class="input-group input-group-required">
                                                <center>
                                                <button type="button" class="btn btn-primary CalculateShippingBtn"  onclick="generateDocketNoDTDC()" id="load1" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Calculating Shipping Price">Assign Docket No.</button>
<?php /*?><br>
  <br>
<button type="button" class="btn btn-primary btn-lg" id="load2" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Order">Submit Order</button><?php */?>


                                                </center>
                                               
                                                </div>
                                            </div>
                                        </div>
                                   </div>

                                </div>
                            </div>
                        <!-- /.box -->
                        </div>
                        <!--/.col (left) -->
                        
                        
                </section>
            <!-- /.content -->
            </form>
            </div>
            
  <div id="ShippingPriceData"></div>          
<script>



function assignShiprocketGenerateManifests(){
	if(confirm('Do you really want to Generate Manifest of Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketGenerateManifestsBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Generate Manifest For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_generate_manifest_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketGenerateManifestsBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}

function assignShiprocketPrintManifests(){
	if(confirm('Do you really want to Print Manifest of Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketPrintManifestsBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Print Manifest For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_print_manifest_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketPrintManifestsBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}

function assignShiprocketOrderLabel(){
	if(confirm('Do you really want to Generate Shipping Label For Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketOrderLabelBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Generating Shipping Label For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_label_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketOrderLabelBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}


function assignShiprocketOrderInvoice(){
	if(confirm('Do you really want to Generate Shipping Invoice For Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketOrderInvoiceBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Generating Shipping Invoice For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_invoice_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketOrderInvoiceBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}



</script>


<? }
 ?>
            
            
<? } else{?>
	<div class="alert alert-info">
     Docket No. Already assign
    </div>

<? } ?>
<? } 
else{ ?>
<? if(empty($od->docket_no)){ ?>
<script>
var box_no=0;
function addNewBox(){
	
	
	var odi_arr = document.getElementsByName('orders_details_ids[]');
	var boxNo_arr = document.getElementsByName('boxNo[]');
	var i , j , k;
	console.log(odi_arr);
	console.log(boxNo_arr);
	
	var pack_total = 0;
	var desc = '';
	for(i=0 ; i < boxNo_arr.length ; i++)
	{
		var box_total = 0;
		for(j=0 ; j < odi_arr.length ; j++)
		{
			if(document.getElementById('item_'+ boxNo_arr[i].value +'_i_'+ odi_arr[j].value) != undefined)
			{
				console.log( boxNo_arr[i].value +' : '+ odi_arr[j].value);
				console.log(document.getElementById('item_'+ boxNo_arr[i].value +'_i_'+ odi_arr[j].value).value)
				var temp_val = parseInt(document.getElementById('item_'+ boxNo_arr[i].value +'_i_'+ odi_arr[j].value).value);
				if(temp_val>0)
				{
					box_total = parseInt(box_total) + parseInt(temp_val);
				}
			}
		}
		$("#box_total_"+boxNo_arr[i].value).html(box_total);
		desc += 'Box No. : '+boxNo_arr[i].value+", Product Count: "+box_total+'<br>'
		pack_total = parseInt(pack_total) + parseInt(box_total);
	}
	document.getElementById('t_bc').innerHTML = boxNo_arr.length;
	document.getElementById('t_d').innerHTML = desc;
	document.getElementById('t_t').innerHTML = 'Total Product Pack : '+pack_total;
	console.log('box_total : '+box_total+' :: '+'pack_total : '+pack_total);
	
	if(box_total<=0)
	{
		alert("Please add Product for selected Box.");
		return false;
	}
	//$('.TBF_'+box_no).attr('disabled' , 'true');
	$('.TBF_all').attr('disabled' , 'true');
	
	$('.TBRemovebtn').hide();
	box_no++;
	var orders_id = $('#orders_id').val();
	document.getElementById('box_no').value = box_no;
	 var $this = $('.addNewBoxBTN');
	$this.button('loading');
	//box_no
	//orders_id
	$('.TBF_all').attr('disabled' , false);
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/addNewBox/',
		data : $('#ShippingForm').serialize(),
		success : function(result){
			$('.TBF_all').attr('disabled' , 'true');
			$('#addNewBoxData').append(result);
			$this.button('reset');
		}
	});
}

function removeTB(t_box_no)
{
	$('.table_box_'+t_box_no).remove();
	t_box_no--;
	box_no--;
	$( ".TBRemovebtn" ).last().show();
	//$( ".TBRemovebtn select" ).last().attr('readonly' , 'false');
	console.log($('.TBF_'+t_box_no).attr('disabled' , false));
	//$('.TBF_all').attr('disabled' , false);
	$('.dhlShippingBTN').hide();
	checkBoxPackItem('' , '')
}
function checkBoxPackItem(box_n , odi)
{
	var odi_arr = document.getElementsByName('orders_details_ids[]');
	var boxNo_arr = document.getElementsByName('boxNo[]');
	var i , j , k;
	console.log(odi_arr);
	console.log(boxNo_arr);
	
	var pack_total = 0;
	var desc='';
	for(i=0 ; i < boxNo_arr.length ; i++)
	{
		var box_total = 0;
		for(j=0 ; j < odi_arr.length ; j++)
		{
			if(document.getElementById('item_'+ boxNo_arr[i].value +'_i_'+ odi_arr[j].value) != undefined)
			{
				//console.log( boxNo_arr[i].value +' : '+ odi_arr[j].value);
				//console.log(document.getElementById('item_'+ boxNo_arr[i].value +'_i_'+ odi_arr[j].value).value)
				var temp_val = parseInt(document.getElementById('item_'+ boxNo_arr[i].value +'_i_'+ odi_arr[j].value).value);
				if(temp_val>0)
				{
					box_total = parseInt(box_total) + parseInt(temp_val);
				}
			}
		}
		
		$("#box_total_"+boxNo_arr[i].value).html(box_total);
		desc += 'Box No. : '+boxNo_arr[i].value+", Product Count: "+box_total+'<br>'
		pack_total = parseInt(pack_total) + parseInt(box_total);
	}
	
	document.getElementById('t_bc').innerHTML = boxNo_arr.length;
	document.getElementById('t_d').innerHTML = desc;
	document.getElementById('t_t').innerHTML = 'Total Product Pack : '+pack_total;
	
//	console.log('box_total : '+box_total+' :: '+'pack_total : '+pack_total);

}
</script>


		
<div class="alert alert-info">
Out Of India Servise Using DHL
</div>




<form role="form" class="form-horizontal" name="ShippingForm" id="ShippingForm" onsubmit="generateDocketNoDHL(); return false" action="" method="post" enctype="multipart/form-data">

<div id="addNewBoxData"></div>


<table id="example2" class="table table-bordered table-hover ">
    <thead>
        
        <tr>
            <th>Box Count</th>
            <th>Description</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
   
        <tr >
            <td id="t_bc">0</td>
            <td id="t_d">0</td>
            <td id="t_t">0</td>
           
        </tr>
  <tfoot>
        <tr>
            <th colspan="5"><div class="form-group">
                                        
                                        <div class="col-md-12">
                                            <div class="input-group input-group-required">
                                                <center>
                                                <button type="button" onclick="addNewBox()" class="btn btn-primary addNewBoxBTN" id="load3" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Adding Box" >Add New Box</button>


                                                </center>
                                               
                                                </div>
                                            </div>
                                        </div></th>
        </tr>
    </tfoot>
</table>


                <section class="content">
                    <div class="row">
                    <input type="hidden" id="myurl" value="<?php echo MAINSITE."secureRegions/wdm";?>"/>
                    <input type="hidden" name="orders_id" id="orders_id" value="<?=$od->orders_id?>" />
                    <input type="hidden" name="box_no" id="box_no" value="0" />
                    	<!-- left column -->
                        <div class="col-md-12" >
                        <!-- general form elements -->
                            <div class="box box-primary dhlShippingBTN" style="display:none">
                                <!-- /.box-header -->
                                <div class="box-body">
                                   <div class="form-group " >
                                        
                                        <div class="col-md-12">
                                            <div class="input-group input-group-required">
                                                <center>
                                                <button type="submit" class="btn btn-primary CalculateShippingBtn docket_btn" id="load1" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Calculating Shipping Price">Assign Docket No.</button>
<?php /*?><br>
  <br>
<button type="button" class="btn btn-primary btn-lg" id="load2" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Order">Submit Order</button><?php */?>


                                                </center>
                                               
                                                </div>
                                            </div>
                                        </div>
                                   </div>

                                </div>
                            </div>
                        <!-- /.box -->
                        </div>
                        <!--/.col (left) -->
                </section>
            <!-- /.content -->
</form>
            <div id="ShippingPriceDataDHL"></div>
<? } ?>
<? } ?>
       <?
       //$this->load->view('admin/orders/shipyaari_service_availability_api' , $this->data);
	}
}
?>
<?php  ?>
<? if($od->courier_name == "Delhivery"){ ?>
<? if($od->is_courier_txn == 1){ ?>
<div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Shipping Procedure</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="table-responsive">
        <table class="table no-margin">
          <thead>
          <tr>
            <th>#</th>
            <th>Label</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>

          <tr>
            <td>1.</td>
            <td>Packing Slip</td>
            <td>
            </td>
            <td>
            	<? if(!empty($od->is_packing_slip_generated)){ ?>
                <a href="<? echo MAINSITE."secureRegions/orders/printPackingSlip/$od->orders_id"; ?>" target="_blank" ><span class="label label-success">Print Packing Slip</span></a>

                <a style="float: right;" onclick="assignCourierPackingSlip()" class="assignCourierPackingSlipBTN" ><span class="label label-danger">Print Packing Slip Again if Error</span></a>
                <? }else{ ?>
            	<button type="button" onclick="assignCourierPackingSlip()" class="btn btn-primary assignCourierPackingSlipBTN">Generate Packing Slip</button>
  				
                <? } ?>
            </td>
            <?php /*?><td><span class="label label-success">Shipped</span></td><?php */?>
            
          </tr>
          
          <tr>
            <td>2.</td>
            <td>Pickup Request</td>
            <td>
            <? if(!empty($od->pickup_token_number)){ ?>
                Token : <?=$od->pickup_token_number?>
                <br>
                Time : <?=date('d-m-Y h:i:s A , l' , strtotime($od->pickup_scheduled_date));?>
                <br>
                <?=$od->pickup_data?>
                <? }else{ ?>
                
                <? } ?>
            </td>
            <td>
            	<? if(!empty($od->pickup_token_number)){ ?>
                <span class="label label-success">Print Packing Slip</span>
                <? }else{ ?>
                <input type="text" name="pickup_date" id="pickup_date" placeholder="Start Date" readonly="readonly" class="form-control datepickerfuture" value="<?=date('d-m-Y' , strtotime('+1 Days'))?>" style="display:none" >
            	<button type="button" onclick="assignCourierOrderPickup()" class="btn btn-primary assignCourierOrderPickupBTN">Assign Pickup</button>

<script>
window.addEventListener('load' , function(){

$('.datepickerfuture').datepicker({
  autoclose: true,
  format: 'dd-mm-yyyy',
  todayHighlight: true,
  startDate: new Date()
});	
	
})
</script>


                <? } ?>
            </td>
            <?php /*?><td><span class="label label-success">Shipped</span></td><?php */?>
            
          </tr>
          <?php /*?>
          <? if($od->is_manifest_ganerated ==0){?>
          <tr>
            <td>2.</td>
            <td>Generate Manifests</td>
            <td>
            <? if(!empty($od->manifest_url)){ ?>
                <a href="<?=$od->manifest_url?>" target="_blank">View File</a>
                <? }else{ ?>
                
                <? } ?>
            </td>
            <td>
            	<? if(empty($od->pickup_token_number)){ ?>
                <div class=' alert alert-warning'>To Generate the Manifest, Assigning Pickup For Order First.</div>
            	<? }else if(!empty($od->manifest_url)){ ?>
                <span class="label label-success">Generate Manifests</span>
                <? }else{ ?>
            	<button type="button" onclick="assignShiprocketGenerateManifests()" class="btn btn-primary assignShiprocketGenerateManifestsBTN">Generate Manifests</button>
                <? } ?>
            </td>
          </tr>
          <? }else{ ?>
          <tr>
            <td>2.</td>
            <td>Print Manifests</td>
            <td>
            	<a type="button" onclick="assignShiprocketPrintManifests()" class="btn btn-primary assignShiprocketPrintManifestsBTN">Print Manifests</a>
            </td>
            <td>
            	<span class="label label-success">Manifests Generated</span>
            </td>
            
          </tr>
          <? } ?>
          
          <tr>
            <td>3.</td>
            <td>Shipping Label</td>
            <td>
            <? if(!empty($od->label_url)){ ?>
                <a href="<?=$od->label_url?>" target="_blank" class="btn btn-primary ">Print / Download Shipping Label</a>
                <? }else{ ?>
                
                <? } ?>
            </td>
            <td>
            	<? if(!empty($od->label_url)){ ?>
                <span class="label label-success">Shipping Label Generated</span>
                <? }else{ ?>
            	<button type="button" onclick="assignShiprocketOrderLabel()" class="btn btn-primary assignShiprocketOrderLabelBTN">Generate Shipping Label</button>
                <? } ?>
            </td>
            
          </tr>
          
          <tr>
            <td>4.</td>
            <td>Shipping Invoice</td>
            <td>
            <? if(!empty($od->shipping_invoice_url)){ ?>
                <a href="<?=$od->shipping_invoice_url?>" target="_blank" class="btn btn-primary">Print / Download Shipping Invoice</a>
                <? }else{ ?>
                
                <? } ?>
            </td>
            <td>
            	<? if(!empty($od->shipping_invoice_url)){ ?>
                <span class="label label-success">Shipping Invoice Generated</span>
                <? }else{ ?>
            	<button type="button" onclick="assignShiprocketOrderInvoice()" class="btn btn-primary assignShiprocketOrderInvoiceBTN">Generate Shipping Invoice</button>
                <? } ?>
            </td>
          </tr>
          <?php */?>
          </tbody>
        </table>
      </div>
      <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
      <?php /*?><a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a><?php */?>
      <?php /*?><a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders ()</a><?php */?>
    </div>
    <!-- /.box-footer -->
  </div>
<script>

function assignCourierPackingSlip(){
	if(confirm('Do you really want to generate packing slip?'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#ShippingPriceData").html('');
	
	$(".assignCourierPackingSlipBTN").prop('disabled', true);
	$("#ShippingPriceData").html("<div class=' alert alert-info'>Assigning Pickup For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_courier_order_packing_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignCourierPackingSlipBTN").prop('disabled', false);
			$("#ShippingPriceData").html("");
			$('#ShippingPriceData').html(result);
		}
	});
}

function assignCourierOrderPickup(){
	var pickup_date = document.getElementById('pickup_date');
	if(pickup_date.value == '')
	{
		alert("select the pickup date.");
		pickup_date.focus();
		return false;
	}
	
	if(confirm('Do you really want to assign Pickup of Order?'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#ShippingPriceData").html('');
	
	$(".assignCourierOrderPickupBTN").prop('disabled', true);
	$("#ShippingPriceData").html("<div class=' alert alert-info'>Assigning Pickup For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_courier_order_pickup_api/',
		data : {  'orders_id' : orders_id , 'pickup_date' : pickup_date.value },
		success : function(result){
			$(".assignCourierOrderPickupBTN").prop('disabled', false);
			$("#ShippingPriceData").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#ShippingPriceData').html(result);
		}
	});
}

function assignShiprocketGenerateManifests(){
	if(confirm('Do you really want to Generate Manifest of Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketGenerateManifestsBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Generate Manifest For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_generate_manifest_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketGenerateManifestsBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}

function assignShiprocketPrintManifests(){
	if(confirm('Do you really want to Print Manifest of Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketPrintManifestsBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Print Manifest For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_print_manifest_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketPrintManifestsBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}

function assignShiprocketOrderLabel(){
	if(confirm('Do you really want to Generate Shipping Label For Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketOrderLabelBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Generating Shipping Label For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_label_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketOrderLabelBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}


function assignShiprocketOrderInvoice(){
	if(confirm('Do you really want to Generate Shipping Invoice For Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#shipRicketResponseDiv").html('');
	
	$(".assignShiprocketOrderInvoiceBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Generating Shipping Invoice For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_shiprocket_order_invoice_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketOrderInvoiceBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}



</script>
<? } ?>
<div id="ShippingPriceData"></div>
<script>
function assignCourierPackingSlip(){
	if(confirm('Do you really want to generate packing slip?'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#ShippingPriceData").html('');
	
	$(".assignCourierPackingSlipBTN").prop('disabled', true);
	$("#ShippingPriceData").html("<div class=' alert alert-info'>Assigning Pickup For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_courier_order_packing_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignCourierPackingSlipBTN").prop('disabled', false);
			$("#ShippingPriceData").html("");
			$('#ShippingPriceData').html(result);
		}
	});
}

function assignCourierOrderPickup(){
	var pickup_date = document.getElementById('pickup_date');
	if(pickup_date.value == '')
	{
		alert("select the pickup date.");
		pickup_date.focus();
		return false;
	}
	
	if(confirm('Do you really want to assign Pickup of Order?'))
	{
		// do nothing
	}
	else
	{
		return false;
	}
	
	var orders_id = $('#orders_id').val();
	
	$("#ShippingPriceData").html('');
	
	$(".assignCourierOrderPickupBTN").prop('disabled', true);
	$("#ShippingPriceData").html("<div class=' alert alert-info'>Assigning Pickup For Order.</div>");
	
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/assign_courier_order_pickup_api/',
		data : {  'orders_id' : orders_id , 'pickup_date' : pickup_date.value },
		success : function(result){
			$(".assignCourierOrderPickupBTN").prop('disabled', false);
			$("#ShippingPriceData").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#ShippingPriceData').html(result);
		}
	});
}
</script>
<? } ?>


<?php  ?>

<?=$this->session->flashdata('message')?>
        
        
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                    	<tr>
                                        	<td width="50%" valign="top">
                                    			<table id="example2" class="table table-bordered table-hover">
                                                    <tbody>
                                                    	<tr>
                                                            <td width="20%">Order Number</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><strong><?=$od->order_number?></strong></td>
                                                        </tr>
                                                        <? if(!empty($od->delivery_challan_no)){ ?>
                                                        <tr>
                                                            <td width="20%">Delivery Challan NO.</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><strong><?=$od->delivery_challan_no?></strong></td>
                                                        </tr>
                                                        <? } ?>
                                                        <tr>
                                                            <td width="20%">Courier Name</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><strong><?=$od->courier_name?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%">Docket No.</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><strong><?=$od->docket_no?></strong></td>
                                                        </tr>
                                                        <? if(!empty($od->file_link)){ ?>
                                                        
                                                        <tr>
                                                            <td width="20%">Docket File.</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><strong><a href="<?=base_url().'assets/docket/'.$od->file_link?>" target="_blank">View Docket File</a></strong></td>
                                                        </tr>
                                                        
                                                        <? } ?>
                                                        
                                                        <tr>
                                                            <td width="20%">Order Placed On</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><strong><?=date('d-m-Y h:i:s A', strtotime($od->added_on))?></strong></td>
                                                        </tr>
                                                        <? if(!empty($od->updated_on)){ ?>
                                                        <tr>
                                                            <td width="20%">Last Action taken On</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><strong><?=date('d-m-Y h:i:s A', strtotime($od->updated_on))?></strong></td>
                                                        </tr>
                                                        <? } ?>
                                                        <tr>
                                                            <td width="20%">Order Status</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><p><strong>
                                                            <?php if($od->order_status==1){echo "Order placed";}else if($od->order_status==2){echo "In Process";}else if($od->order_status==3){echo "Out For Delivery";}else if($od->order_status==4){echo "Delivered";}else if($od->order_status==5){echo "Not Deliver";}else if($od->order_status==6){echo "Cancle";} ?>
                                                            </strong></p>
                                                            <? if(!empty($od->reason)){ ?>
                                                            <p><strong>Reason : </strong> <?=$od->reason?></p>
                                                            <? } ?>
                                                            </td>
                                                        </tr>
                                                    	<tr>
                                                            <td width="20%">Payment Details</td>
                                                            <td width="5%">:</td>
                                                            <td width="*">
                                                            	<p>Total : <strong><?=$od->symbol ?> <?=$od->total?></strong></p>
                                                                <p>Mode : <strong><?=$od->mode?></strong></p>
                                                                <? if(!empty($od->mihpayid)){ ?><p>Bank Id : <strong><?=$od->mihpayid?></strong></p><? } ?>
                                                                <? if(!empty($od->txnid)){ ?><p>TXN Id : <strong><?=$od->txnid?></strong></p><? } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%">Amount</td>
                                                            <td width="5%">:</td>
                                                            <td width="*">
																<p>Total : <strong><?=$od->symbol ?> <?=$od->total?></strong></p>
                                                                <?php /*?><p>Saving in Rs : <strong><?=$od->total_saving_in_rs?></strong></p>
                                                                <p>Saving in % : <strong><?=number_format($od->total_saving_in_percent , 2)?></strong></p><?php */?>
                                                            </td>
                                                        </tr>
                                                         <tr>
                                                            <td width="20%">Customer Name</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><?=$od->name?></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td width="20%">Customer Contact</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><?=$od->number?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%">Customer Email</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><?=$od->email?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%">Delivery Details</td>
                                                            <td width="5%">:</td>
                                                            <td width="*">
                                                            	<p><?=$od->d_name?></p>
                                                                <p><?=$od->d_number?></p>
                                                                <p><?=$od->d_address?></p>
                                                                
                                                                <p><?=$od->d_city_name?>, <?=$od->d_zipcode?></p>
                                                                <p><?=$od->d_state_name?></p>
                                                                <p><?=$od->d_country_name?></p>
                                                            </td>
                                                        </tr>
                                                        <?php /*?><tr>
                                                            <td width="20%">Store Details</td>
                                                            <td width="5%">:</td>
                                                            <td width="*">
                                                            	<p><strong><?=$od->store_name?></strong></p>
                                                                <p><?=$od->store_contact_number?></p>
                                                                <p><?=$od->person_contact_name?></p>
                                                                <p><?=$od->person_contact_email?></p>
                                                                <p><?=$od->person_contact_number?></p>
                                                                <p><?=$od->person_contact_alt_number?></p>
                                                            </td>
                                                        </tr><?php */?>
                                                        <tr>
                                                            <td width="20%">Order Details</td>
                                                            <td width="5%">:</td>
                                                            <td width="*">
																<p>#Items : <strong><?=$od->total_prod?></strong></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                    			</table>
                                            </td>
                                        	
                                        </tr>
                                        
                                        <tr>
                                        	<td width="50%" valign="top">
                                    			<table id="example2" class="table table-bordered table-hover">
                                                    <thead>
                                                    	<tr>
                                                            <th colspan="15"><strong>Ordered Product In Detail</strong></th>
                                                        </tr>
                                                        <tr>
                                                        	<th>Sl No.</th>
                                                            <th>Item Name</th>
                                                            <th>Manufacturer</th>
                                                            <?php /*?><th>Remarks</th><?php */?>
                                                            <th>Price</th>
                                                            <th>Final Price</th>
                                                            <th>Qty</th>
                                                            <th>Sub Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?
													$count = 0;
													foreach($od->details as $odd)
													{$count++; //echo "<pre>";print_r($od->details);
													 ?>
                                                    	<tr>
                                                            <td><?=$count?>.</td>
                                                            <td><?php /*?><?=$odd->product_name?><br><?php */?><?=$odd->product_display_name?><br><?=$odd->combi?></td>
                                                            <td><?=$odd->brand_name?></td>
                                                            <?php /*?><td><?=$odd->prod_comment?></td><?php */?>
                                                            <td><?=$od->symbol ?> <?=$odd->price?></td>
                                                            <td><?=$od->symbol ?> <?=$odd->final_price?></td>
                                                            <td><?=$odd->prod_in_cart?></td>
                                                            <td><?=$od->symbol ?> <?=$odd->sub_total?></td>
                                                        </tr>
                                                  <? } ?>
<?
$colspan = 6;
?>
                                                  <? if(!empty($od->coupon_code)){
													  
													   ?>
                                                  		<tr>
                                                            <td colspan="<?=$colspan?>"  style="text-align:right">Coupon (<?=$od->coupon_code?>)</td>
                                                            <td> <?=$od->discount?> %</td>
                                                        </tr>
                                                   <? } ?>
                                                        <tr>
                                                            <td colspan="<?=$colspan?>"  style="text-align:right">GST Charges</td>
                                                            <td><?=$od->symbol ?> <?=$od->total_gst?></td>
                                                        </tr> 
                                                        <tr>
                                                            <td colspan="<?=$colspan?>"  style="text-align:right">Delivery Charges</td>
                                                            <td><?=$od->symbol ?> <?=$od->delivery_charges?></td>
                                                        </tr> 
                                                        <tr>
                                                            <td colspan="<?=$colspan?>"  style="text-align:right">COD Charges</td>
                                                            <td><?=$od->symbol ?> <?=$od->cod_charges?></td>
                                                        </tr> 
                                                        <tr>
                                                            <td colspan="<?=$colspan?>"  style="text-align:right">Total</td>
                                                            <td><?=$od->symbol ?> <?=$od->total?></td>
                                                        </tr>
                                                    </tbody>
                                    			</table>
                                            </td>
                                        	
                                        </tr>
                                    </table>
</div>
    </div>
</div>


<div role="tabpanel" class="tab-pane fade " id="od_history">
    <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title">History</h3></div><!-- /.box-header -->
            <?php /*?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding images.</span><?php */?>
        <div class="box-body">       
        
<? if(!empty($od->order_history) ){ ?>
    <ul class="timeline">
    <?
    $f_date='';
    foreach($od->order_history as $fud){
    ?>
    <?
    $temp_date = date('d-m-Y', strtotime($fud->updated_on));
    if($f_date!=$temp_date)
    {
        $f_date=$temp_date;
        ?>
        
      <li class="time-label">
        <span class="bg-red"><?=date('d M. Y' , strtotime($f_date))?></span>
      </li>
        <?
    }
    ?>
    
    <li>
        <?=$fud->order_status_display?>
          <div class="timeline-item" style="margin-left: 160px;top: -25px">
          <span class="time"><i class="fas fa-clock"></i> <?=date('d-m-Y h:i:s A' , strtotime($fud->updated_on))?></span>
          <h3 class="timeline-header"><?=$fud->caption?> <?php /*?>By : <a href="javascript:void(0)" ><?=$fud->updated_by_name?></a> <?php */?></h3>

          <div class="timeline-body">
            <? if(!empty($fud->description)) { echo "<p>";echo $fud->description;echo "</p>"; } ?>
            <? if(!empty($fud->remarks)) { echo "<p>";echo $fud->remarks;echo "</p>"; } ?>
            <? if(!empty($fud->long_description)) { echo "<p>";echo $fud->long_description;echo "</p>"; } ?>
          </div>
          <?php /*?><div class="timeline-footer">
            <a class="btn btn-primary btn-sm">Read more</a>
            <a class="btn btn-danger btn-sm">Delete</a>
          </div><?php */?>
        </div>
      </li>
      
      
    <? } ?>
     
        <div>
            <i class="fas fa-clock bg-gray"></i>
        </div>
    </ul>
    <? }else { ?>
    <div class="alert alert-warning alert-dismissible"><i class="icon fas fa-ban"></i> No Data To Display</div>
    <? } ?>
</div>
</div>
</div>

<div role="tabpanel" class="tab-pane fade " id="od_bluedart_tracking">
    <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title">Order Tracking History</h3></div><!-- /.box-header -->
            <?php /*?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding images.</span><?php */?>
        <div class="box-body">       
        <?
		/*$this->load->library('bluedart_tracking');
		$obj_bluedart_tracking = new bluedart_tracking();
		$docket_status = $obj_bluedart_tracking->docketStatusXML($od);
		$docket_status_html = $obj_bluedart_tracking->docketStatusHTML($od);*/
		//echo $docket_status_html;
		?>
<? if(!empty($docket_status_html)){ ?>

		<? echo $docket_status_html; ?>
    
    <? }else{ ?>
    <div class="alert alert-warning alert-dismissible"><i class="icon fas fa-ban"></i> No Data To Display</div>
    <? } ?>
</div>
</div>
</div>
</div>

   
                                </div>
                            </div>
                        </div>
                    </div>


    </section>
    <?  ?>
</div>

<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
    
            <!-- Content Wrapper. Contains page content -->
            
            <!-- /.content-wrapper -->
<div id="Modalpop" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content newModalCss">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Take Action</h4>
      </div>
      <div class="modal-body">
        <form class="" action="<?=MAINSITE.'secureRegions/orders/Orders_Module/update'?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="orders_id" id="orders_id" value="<?=$od->orders_id?>" />
        <input type="hidden" name="order_number" id="order_number" value="<?=$od->order_number?>" />
        	<div class="clearfix">
            	<div class="clearfix form-group">
                    <label class="col-md-3">Dropdown</label>
                    <div class="col-md-9">
                    	<select class="form-control" required name="order_status" id="order_status" onchange="setAction(this.value)">
                        	<option value="">Select Action</option>
                            <option value="1" <? if($od->order_status==1){echo "selected";} ?>>Order placed</option>
                            <option value="2" <? if($od->order_status==2){echo "selected";} ?>>In Process</option>
                            <option value="3" <? if($od->order_status==3){echo "selected";} ?>>Dispatched</option>
                            <option value="4" <? if($od->order_status==4){echo "selected";} ?>>Delivered</option>
                            <option value="5" <? if($od->order_status==5){echo "selected";} ?>>Not Delivered</option>
                            <option value="6" <? if($od->order_status==6){echo "selected";} ?>>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix form-group" style="display:none" id="id_order_invoice">
                    <label class="col-md-3">Upload Invoice</label>
                    <div class="col-md-9">
                    	<input type="file" name="order_invoice" id="order_invoice" class="form-control" >
                        <p><mute><em>Upload Invoice in .pdf Format.</em></mute></p>
                    </div>
                </div>
                <div class="clearfix form-group" style="display:none" id="id_reason">
                    <label class="col-md-3">Textarea</label>
                    <div class="col-md-9">
                    	<textarea name="reason" id="reason" class="form-control" rows="3"></textarea>	                        	
                    </div>
                </div>
                <div class="clearfix form-group ">
                	<div class="col-md-12 text-right">
                   <button type="submit" class="btn btn-primary btn-bg" name="OrderStatusBTN" value="1">Submit</button>
                   </div>
                </div>
            </div>
        </form>
      </div>
     
    </div>

  </div>
</div>
<script>
function setAction(val)
{
	if(val == 3)
	{
		document.getElementById('order_invoice').required = true;
		document.getElementById('id_order_invoice').style.display = "block";
		
		document.getElementById('reason').value = '';
		document.getElementById('reason').required = false;
		document.getElementById('id_reason').style.display = "block";
	}
	else if(val == 5 || val == 6)
	{
		document.getElementById('reason').required = true;
		document.getElementById('id_reason').style.display = "block";
		
		document.getElementById('order_invoice').value = '';
		document.getElementById('order_invoice').required = false;
		document.getElementById('id_order_invoice').style.display = "none";
	}
	else
	{
		document.getElementById('reason').value = '';
		document.getElementById('reason').required = false;
		document.getElementById('id_reason').style.display = "none";
		
		document.getElementById('order_invoice').value = '';
		document.getElementById('order_invoice').required = false;
		document.getElementById('id_order_invoice').style.display = "none";
	}
}
</script>
<script>

function getPincodeDetailDTDC(){
	var orders_id = $('#orders_id').val();
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/Orders_Module/getPincodeDetailDTDC/',
		data : {   'orders_id' : orders_id  },
		success : function(result){
			$('#PincodeData').html(result);
		}
	});
}

function getPincodeDetailDelhivery(){
	var orders_id = $('#orders_id').val();
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/getPincodeDetail/',
		data : {   'orders_id' : orders_id  },
		success : function(result){
			$('#PincodeData').html(result);
		}
	});
}

function getPincodeDetail(){
	var orders_id = $('#orders_id').val();
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/getPincodeDetailBluedart/',
		data : {   'orders_id' : orders_id  },
		success : function(result){
			$('#PincodeData').html(result);
		}
	});
}


function generateDocketNoDHL(){
	//var service = $("input[name='service']:checked").val();
	//var insurance = $("input[name='insurance']:checked").val();
	event.preventDefault()
	var total_package_weight = $('#total_package_weight').val();
	///var box_l = $('#box_l').val();
	//var box_b = $('#box_b').val();
	//var box_h = $('#box_h').val();
	var orders_id = $('#orders_id').val();
	
	/*if(total_package_weight == '' || total_package_weight <=0)
	{
		alert("Please Enter Product weight.");
		$('#total_package_weight').focus();
		return false;
	}
	if(box_l == '' || box_l <=0)
	{
		alert("Please Enter Shipping Box Length.");
		$('#box_l').focus();
		return false;
	}
	if(box_b == '' || box_b <=0)
	{
		alert("Please Enter Shipping Box Breadth.");
		$('#box_b').focus();
		return false;
	}
	if(box_h == '' || box_h <=0)
	{
		alert("Please Enter Shipping Box height.");
		$('#box_h').focus();
		return false;
	}*/
	$('.TBF_all').attr('disabled' , false);
	 var $this = $('.CalculateShippingBtn');
 	$this.button('loading');
	//'service' : service ,'insurance' : insurance , 
	//$('.docket_btn').hide();
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/generateDocketNoDHL/',
		data :  $('#ShippingForm').serialize() ,
		success : function(result){
			$this.button('reset');
			$('#ShippingPriceDataDHL').html(result);
			//$('.TBF_all').attr('disabled' , 'true');
			//window.location.reload();
		}
	});
}

function generateDocketNo(){
	//var service = $("input[name='service']:checked").val();
	//var insurance = $("input[name='insurance']:checked").val();
	
	var service_type = $('#service_type').val();
	var total_package_weight = $('#total_package_weight').val();
	var box_l = $('#box_l').val();
	var box_b = $('#box_b').val();
	var box_h = $('#box_h').val();
	var orders_id = $('#orders_id').val();
	
	if(service_type == '' || total_package_weight <=0)
	{
		alert("Please Select Service Type If Available.");
		$('#service_type').focus();
		return false;
	}
	if(total_package_weight == '' || total_package_weight <=0)
	{
		alert("Please Enter Product weight.");
		$('#total_package_weight').focus();
		return false;
	}
	if(box_l == '' || box_l <=0)
	{
		alert("Please Enter Shipping Box Length.");
		$('#box_l').focus();
		return false;
	}
	if(box_b == '' || box_b <=0)
	{
		alert("Please Enter Shipping Box Breadth.");
		$('#box_b').focus();
		return false;
	}
	if(box_h == '' || box_h <=0)
	{
		alert("Please Enter Shipping Box height.");
		$('#box_h').focus();
		return false;
	}
	 var $this = $('.CalculateShippingBtn');
 	$this.button('loading');
	//'service' : service ,'insurance' : insurance , 
	$('.docket_btn').hide();
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/generateDocketNo/',
		data : {   'orders_id' : orders_id , 'total_package_weight' : total_package_weight , 'box_l' : box_l, 'box_b' : box_b , 'box_h' : box_h  , 'service_type' : service_type },
		success : function(result){
			$this.button('reset');
			$('#ShippingPriceData').html(result);
			window.location.reload();
		}
	});
}


function generateBluedartDocketNo(){
	//var service = $("input[name='service']:checked").val();
	//var insurance = $("input[name='insurance']:checked").val();
	
	var total_package_weight = $('#total_package_weight').val();
	
	var blue_dart_product_code = $('input[name="blue_dart_product_code"]:checked').val();

	var box_l = $('#box_l').val();
	var box_b = $('#box_b').val();
	var box_h = $('#box_h').val();
	var orders_id = $('#orders_id').val();
	
	if(total_package_weight == '' || total_package_weight <=0)
	{
		alert("Please Enter Product weight.");
		$('#total_package_weight').focus();
		return false;
	}
	if(box_l == '' || box_l <=0)
	{
		alert("Please Enter Shipping Box Length.");
		$('#box_l').focus();
		return false;
	}
	if(box_b == '' || box_b <=0)
	{
		alert("Please Enter Shipping Box Breadth.");
		$('#box_b').focus();
		return false;
	}
	if(box_h == '' || box_h <=0)
	{
		alert("Please Enter Shipping Box height.");
		$('#box_h').focus();
		return false;
	}
	 var $this = $('.CalculateShippingBtn');
 	$this.button('loading');
	//'service' : service ,'insurance' : insurance , 
	//$('.docket_btn').hide();
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/generateBluedartDocketNo/',
		data : {   'orders_id' : orders_id , 'total_package_weight' : total_package_weight , 'box_l' : box_l, 'box_b' : box_b , 'box_h' : box_h  , 'blue_dart_product_code' : blue_dart_product_code },
		success : function(result){
			$this.button('reset');
			$('#ShippingPriceData').html(result);
			//window.location.reload();
		}
	});
}

function generateDocketNoDelhivery(){
	//var service = $("input[name='service']:checked").val();
	//var insurance = $("input[name='insurance']:checked").val();
	var total_package_weight = $('#total_package_weight').val();
	var box_l = $('#box_l').val();
	var box_b = $('#box_b').val();
	var box_h = $('#box_h').val();
	var orders_id = $('#orders_id').val();
	
	if(total_package_weight == '' || total_package_weight <=0)
	{
		alert("Please Enter Product weight.");
		$('#total_package_weight').focus();
		return false;
	}
	if(box_l == '' || box_l <=0)
	{
		alert("Please Enter Shipping Box Length.");
		$('#box_l').focus();
		return false;
	}
	if(box_b == '' || box_b <=0)
	{
		alert("Please Enter Shipping Box Breadth.");
		$('#box_b').focus();
		return false;
	}
	if(box_h == '' || box_h <=0)
	{
		alert("Please Enter Shipping Box height.");
		$('#box_h').focus();
		return false;
	}
	 var $this = $('.CalculateShippingBtn');
 	$this.button('loading');
	//'service' : service ,'insurance' : insurance , 
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/generateDocketNoDelhivery/',
		data : {   'orders_id' : orders_id , 'total_package_weight' : total_package_weight , 'box_l' : box_l, 'box_b' : box_b , 'box_h' : box_h },
		success : function(result){
			$this.button('reset');
			$('#ShippingPriceData').html(result);
		}
	});
}

function generateDocketNoDTDC(){
	//var service = $("input[name='service']:checked").val();
	//var insurance = $("input[name='insurance']:checked").val();
	var total_package_weight = $('#total_package_weight').val();
	var box_l = $('#box_l').val();
	var box_b = $('#box_b').val();
	var box_h = $('#box_h').val();
	var orders_id = $('#orders_id').val();

	if(total_package_weight == '' || total_package_weight <=0)
	{
		alert("Please Enter Product weight.");
		$('#total_package_weight').focus();
		return false;
	}
	if(box_l == '' || box_l <=0)
	{
		alert("Please Enter Shipping Box Length.");
		$('#box_l').focus();
		return false;
	}
	if(box_b == '' || box_b <=0)
	{
		alert("Please Enter Shipping Box Breadth.");
		$('#box_b').focus();
		return false;
	}
	if(box_h == '' || box_h <=0)
	{
		alert("Please Enter Shipping Box height.");
		$('#box_h').focus();
		return false;
	}
	// var $this = $('.CalculateShippingBtn');
 	//$this.button('loading');
	//'service' : service ,'insurance' : insurance , 

	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/Orders_Module/generateDocketNoDTDC/',
		data : {   'orders_id' : orders_id , 'total_package_weight' : total_package_weight , 'box_l' : box_l, 'box_b' : box_b , 'box_h' : box_h },
		success : function(result){
			//$this.button('reset');
			$('#ShippingPriceData').html(result);
		}
	});
}


function bookDocketAjax(order_id , service_id , partner_id ,  insurance , total_package_weight , box_l , box_b , box_h)
{
   $.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/ShippingServiceApi/',
		data : { 'orders_id' : orders_id , 'insurance' : insurance , 'total_package_weight' : total_package_weight , 'box_l' : box_l, 'box_b' : box_b , 'box_h' : box_h  , 'service_id' : service_id  , 'partner_id' : partner_id },
		success : function(result){
			//$this.button('reset');
			$('#ShippingServiceApiData').html(result);
		}
	});
}

</script>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Order Tracking (<?=$od->order_number?>)</h4>
      </div>
      <div class="modal-body tracking_data_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
function getTrackingData()
{
	$(".loader").show();
	$.ajax({
		type: "POST",
		url:'<?=base_url()?>Ajax/getTracking',
		//dataType : "json",
	   data : {'tracking_number':'<?=$od->docket_no?>'},
	   success : function(result){
		   $(".tracking_data_body").html(result);
		$(".loader").hide();
		$('#myModal').modal('show');
	   }
   });	
}
window.addEventListener("load", function(){
	$("#od_details_a").trigger("click");
})
</script>