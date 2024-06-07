
<link href="<? echo MAINSITE ?>assets/admin/table.js/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="<? echo MAINSITE ?>assets/admin/table.js/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="<? echo MAINSITE ?>assets/admin/table.js/css/font-awesome.min.css" rel="stylesheet">
<link href="<? echo MAINSITE ?>assets/admin/table.js/css/dataTables.searchHighlight.css" rel="stylesheet">
<?php
$page_module_name = "Order Details";
?>
<?
$name="";
$company_profile_id=0;
$status=1;
$record_action = "Add New Record";
if(!empty($order_data))
{
	// $record_action = "Update";
	// $company_profile_id = $order_data->company_profile_id;
	// $name = $order_data->name;
	// $status = $order_data->status;
//	echo "<pre>"; print_r($order_data); echo "</pre>";
}
?>
<style type="text/css" >
.newModalCss {border-radius: 15px 15px 0 0;overflow:hidden;}
	.newModalCss .modal-header{background-color: #3C8DBC;
    color: #fff;

}
	.newModalCss label{text-align:right;padding-top: 4px;}
</style>

<!-- /.navbar -->

<!-- Main Sidebar Container -->


<!-- Content Wrapper. Contains page content -->
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
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title"><?=$order_data->name?></h3>
                        <div class="float-right">
                            <?php
								if($user_access->add_module==1 && false)	{
								?>
								<a href="<?=MAINSITE_Admin.$user_access->class_name?>/company-profile-edit">
                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                                New</button></a>
                            <? } ?>
                            <?php
							if($user_access->update_module==1)	{
							?>
							<a href="<?=MAINSITE_Admin.$user_access->class_name?>/edit/<?=$order_data->orders_id?>">
                            <button type="button" class="btn btn-success btn-sm" ><i
                                    class="fas fa-edit"></i> Update</button>
                            </a>
                            <? } ?>
                        </div>
                        <div class="col-md-8 text-right">
                                    <?php /*?><a href="<? echo MAINSITE."secureRegions/wdm/stores/edit/".$order_data->orders_id;?>" class="btn btn-primary ">Update Stores Details</a>&nbsp;<?php */?>

                                    <? if(true){ ?>
                                    <? if($order_data->order_status!=6 && $order_data->order_status!=4){ ?>
                                    <a href="#Modalpop" data-toggle="modal" class="btn btn-primary">Take Action</a>
                                    <? }} ?>

                                    <a href="<? echo MAINSITE."secureRegions/orders/Orders_Module/orderInvoice/$order_data->orders_id"; ?>" target="_blank" class="btn btn-primary">Print Order</a>
                                    <? if(!empty($order_data->order_invoice)){ ?>
                                    <a href="<? echo base_url()."assets/uploads/invoice/".$order_data->order_invoice; ?>" target="_blank" class="btn btn-primary">Invoice</a>
                                    <? } ?>

                                    <? if($order_data->courier_name == 'Bluedart' && false){

									?>
                                    <a href="<? echo MAINSITE."secureRegions/orders/Orders-Module/trackOrder/$order_data->orders_id"; ?>" target="_blank" class="btn btn-primary">Track Order</a>
                                    <? } ?>

                                     <? if(!empty($order_data->docket_no) && $order_data->courier_name =='Delhivery')
										{ ?>
                                       <a onclick="getTrackingData()" target="_blank" class="btn btn-primary">Track Order</a>
                                       <? } ?>

                                    </div>
                    </div>
                    <div class="card-body p-0" style="display: block;">
                    	<div class="table-responsive">
                        	<div id="accordion" class="edit_payment_detail">
    <?php

                $tab1 = 100;
                $tab2 = 200;
                $index = 0;

                ?>
                <script>
  function  setTab(tab,index)
  {
    //alert('sa');
//$('.all_tab_2').length();
//$('.all_tab_2').hide();

  $('.'+'all_tab_'+index).hide();
  $('.'+tab).css('display','block');
  $('.'+tab).css('opacity','1');
  }
  </script>
                    <!-- /.card-header -->
                    <?php
						if($user_access->view_module==1)	{
					?>
                    <div class="card-header p-0 border-bottom-0">
                    	<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        	<li class="nav-item" onclick="setTab('<?=$tab1?>','<?=$index?>')">
                            	<a class="nav-link active" onclick="setTab('<?=$tab1?>','<?=$index?>')" id="custom-tabs-four-home-tab<?=$index?>" data-toggle="pill" href="#custom-tabs-four-home<?=$index?>" role="tab" aria-controls="custom-tabs-four-home<?=$index?>" aria-selected="true">Order Details</a>
                      		</li>
                            <li class="nav-item" onclick="setTab('<?=$tab2?>','<?=$index?>')">
                            	<a class="nav-link" onclick="setTab('<?=$tab2?>','<?=$index?>')" id="custom-tabs-four-profile-tab<?=$index?>" data-toggle="pill" href="#custom-tabs-four-profile<?=$index?>" role="tab" aria-controls="custom-tabs-four-profile<?=$index?>" aria-selected="false">FollowUp Details</a>
                        	</li>
                    	</ul>
                  </div>
					<div class="card card-primary card-outline card-outline-tabs">
                    	<?php /*?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding images.</span><?php */?>
        <div class="box-body">
<?
if(!empty($order_data->order_status) && empty($order_data->docket_no))
{
	if($order_data->order_status==2 && $order_data->is_self_pickup==1)
	{
		$insurance=2;
		$service=2;
		$total_package_weight = round($order_data->total_weight/1000 , 3);
		$box_l = $box_b = $box_h = 10;
		?>
        <form role="form" class="form-horizontal" name="ShippingForm" id="ShippingForm" action="" method="post" enctype="multipart/form-data">
                <section class="content">
                    <div class="row">
                    <input type="hidden" id="myurl" value="<?php echo MAINSITE."secureRegions/wdm";?>"/>
                    <input type="hidden" name="orders_id" id="orders_id" value="<?=$order_data->orders_id?>" />
                    	<!-- left column -->
                        <div class="col-md-12 mt-3" style="padding:0 20px">
                        <!-- general form elements -->
                            <div class="box box-primary">
                                <!-- /.box-header -->
                                <div class="box-body border-box2 ">

                                    <? $insurance==2; ?>
                                    <div class="row form-group" style="display:none">
                                        <div class="col-md-2">
                                                    	<div class="label-wrapper"><label class="control-label" for="Name">Is Insurance Required?</label>
                                                        	<div data-title="Is Insurance Required?" class="ico-help icon_title_box"><i class="far fa-question-circle"></i></div>
                                                        </div>
                                        </div>

                                        <div class="col-md-2">
                                                    	<div class="input-group input-group-required">
                                                        	<input type="radio" class="" name="insurance" id="insurance1" value="1" <?php if($insurance==1) echo ' checked'; ?> required /> Yes &nbsp;&nbsp;
                                        	<input type="radio" class="" name="insurance" id="insurance2" value="2" <?php if($insurance==2) echo ' checked'; ?> /> No
                                                            <div class="input-group-btn">
                                                                <span class="required star">*</span>
                                                            </div>
                                                        </div>
                                                    </div>


                                    </div>

                                	<div class="row form-group" style="margin-bottom: 0 !important">
                                        <div class="col-md-3">
                                            <div class="label-wrapper"><label class="control-label" for="Name">Package Weight (In Kg)</label>
                                                <div data-title="Total Package Weight (In Kg)." class="ico-help icon_title_box"><i class="far fa-question-circle" aria-hidden="true"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="input-group input-group-required">
                                                <input type="number" step="any"  min="0.01" name="total_package_weight" id="total_package_weight" placeholder="Total Package Weight" class="form-control" value="<?=$total_package_weight?>" >
                                                <div class="input-group-btn"><span class="required star">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                          <div class="col-md-3">
                                            <div class="label-wrapper"><label class="control-label" for="Name">Dimension (L*B*H)(In CM)</label>
                                                <div data-title="Package Dimension (L*B*H)(In CM)"  class="ico-help icon_title_box"><i class="far fa-question-circle"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_l" id="box_l" min="1" placeholder="Lenght" class="form-control" value="<?=$box_l?>" >
                                                <div class="input-group-btn"><span class="required star">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_b" id="box_b" min="1" placeholder="Breadth" class="form-control" value="<?=$box_b?>" >
                                                <div class="input-group-btn"><span class="required star">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="input-group input-group-required">
                                                <input type="number" name="box_h" id="box_h" min="1" placeholder="Height" class="form-control" value="<?=$box_h?>" >
                                                <div class="input-group-btn"><span class="required star">*</span>
                                                </div>
                                            </div><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>
                                          <div class="col-md-2">
                                        <button type="button" class="btn btn-primary CalculateShippingBtn123"  onclick="CalculateShippingPrice()" id="load1" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Calculating Shipping Price">Get Shipping Price</button>
                                    </div>
                                   </div>

                                  <!--  <div class="row form-group">

                                   </div> -->

                                   <div class="row form-group" id="shipRicketRateServiceDataDiv" style="display:none">
                                        <div class="col-md-12" id="shipRicketRateServiceData">
                                        </div>
                                   </div>



                                <!--    <div class="row form-group" id="courierShippingButton">

                                        <div class="col-md-12">

                                            <div class="input-group input-group-required">
                                                <center>




                                                </center>

                                                </div>
                                            </div>
                                        </div>
                                         -->

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
//shipRicketRateServiceData shipRicketRateServiceDataDiv


function CalculateShippingPrice(){
	$("#shipRicketResponseDiv").html('');
	//var service = $("input[name='service']:checked").val();
	var insurance = $("input[name='insurance']:checked").val();
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

	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Getting Rate for Courier Service.</div>");


	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/Orders-Module/shiprocket_shipping_service_api/',
		data : {  'orders_id' : orders_id , 'insurance' : insurance , 'total_package_weight' : total_package_weight , 'box_l' : box_l, 'box_b' : box_b , 'box_h' : box_h },
		success : function(result){
			$("#shipRicketResponseDiv").html("");
			$this.button('reset');
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketRateServiceData').html(result);
			$('#shipRicketRateServiceDataDiv').show();
		}
	});
}

function assignShiprocketOrderAWB(courier_company_id , shipping_rate){
	if(courier_company_id=='')
	{
		alert("Something went wrong please try again");
		window.location.reload();
		return false;
	}
	if(confirm('Do you really want to assign Docket No.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}


	$("#shipRicketResponseDiv").html('');
	//var service = $("input[name='service']:checked").val();
	var insurance = $("input[name='insurance']:checked").val();
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
	$(".assignShiprocketOrderAWBBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Assigning Docket For Order.</div>");

	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/Orders-Module/assign_shiprocket_order_awb_api/',
		data : {  'orders_id' : orders_id , 'insurance' : insurance , 'total_package_weight' : total_package_weight , 'box_l' : box_l, 'box_b' : box_b , 'box_h' : box_h  , 'courier_company_id' : courier_company_id , 'shipping_rate' : shipping_rate },
		success : function(result){
			$(".assignShiprocketOrderAWBBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			$this.button('reset');
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}

</script>



       <?
       //$this->load->view('admin/orders/shipyaari_service_availability_api' , $this->data);
	}
}
?>
</div>
<?
/*echo "<pre>";
print_r($od);
echo "</pre>";*/
?>

<? if($order_data->is_courier_txn == 1){ ?>
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
            <td>Pickup Request</td>
            <td>
            <? if(!empty($order_data->pickup_scheduled_date)){ ?>
                Token : <?=$order_data->pickup_token_number?>
                <br>
                Time : <?=date('d-m-Y h:i:s A , l' , strtotime($order_data->pickup_scheduled_date));?>
                <br>
                <?=$order_data->pickup_data?>
                <? }else{ ?>

                <? } ?>
            </td>
            <td>
            	<? if(!empty($order_data->pickup_scheduled_date)){ ?>
                <span class="label label-success">Pickup Scheduled</span>
                <? }else{ ?>
            	<button type="button" onclick="assignShiprocketOrderPickup()" class="btn btn-primary assignShiprocketOrderPickupBTN">Assign Pickup</button>
                <? } ?>
            </td>
            <?php /*?><td><span class="label label-success">Shipped</span></td><?php */?>

          </tr>

          <? if($order_data->is_manifest_ganerated ==0){?>
          <tr>
            <td>2.</td>
            <td>Generate Manifests</td>
            <td>
            <? if(!empty($order_data->manifest_url)){ ?>
                <a href="<?=$order_data->manifest_url?>" target="_blank">View File</a>
                <? }else{ ?>

                <? } ?>
            </td>
            <td>
            	<? if(empty($order_data->pickup_scheduled_date)){ ?>
                <div class=' alert alert-warning'>To Generate the Manifest, Assigning Pickup For Order First.</div>
            	<? }else if(!empty($order_data->manifest_url)){ ?>
                <span class="label label-success">Generate Manifests</span>
                <? }else{ ?>
            	<button type="button" onclick="assignShiprocketGenerateManifests()" class="btn btn-primary assignShiprocketGenerateManifestsBTN">Generate Manifests</button>
                <? } ?>
            </td>
            <?php /*?><td><span class="label label-success">Shipped</span></td><?php */?>

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
            <?php /*?><td><span class="label label-success">Shipped</span></td><?php */?>

          </tr>
          <? } ?>

          <tr>
            <td>3.</td>
            <td>Shipping Label</td>
            <td>
            <? if(!empty($order_data->label_url)){ ?>
                <a href="<?=$order_data->label_url?>" target="_blank" class="btn btn-primary ">Print / Download Shipping Label</a>
                <? }else{ ?>

                <? } ?>
            </td>
            <td>
            	<? if(!empty($order_data->label_url)){ ?>
                <span class="label label-success">Shipping Label Generated</span>
                <? }else{ ?>
            	<button type="button" onclick="assignShiprocketOrderLabel()" class="btn btn-primary assignShiprocketOrderLabelBTN">Generate Shipping Label</button>
                <? } ?>
            </td>
            <?php /*?><td><span class="label label-success">Shipped</span></td><?php */?>

          </tr>

          <tr>
            <td>4.</td>
            <td>Shipping Invoice</td>
            <td>
            <? if(!empty($order_data->shipping_invoice_url)){ ?>
                <a href="<?=$order_data->shipping_invoice_url?>" target="_blank" class="btn btn-primary">Print / Download Shipping Invoice</a>
                <? }else{ ?>

                <? } ?>
            </td>
            <td>
            	<? if(!empty($order_data->shipping_invoice_url)){ ?>
                <span class="label label-success">Shipping Invoice Generated</span>
                <? }else{ ?>
            	<button type="button" onclick="assignShiprocketOrderInvoice()" class="btn btn-primary assignShiprocketOrderInvoiceBTN">Generate Shipping Invoice</button>
                <? } ?>
            </td>
            <?php /*?><td><span class="label label-success">Shipped</span></td><?php */?>

          </tr>

          <tr>
            <td>5.</td>
            <td>Tracking</td>
            <td>

            </td>
            <td>

            	<button type="button" onclick="trackShiprocketOrder()" class="btn btn-primary trackShiprocketOrderBTN">Track Order</button>
            </td>
            <?php /*?><td><span class="label label-success">Shipped</span></td><?php */?>

          </tr>

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

function assignShiprocketOrderPickup(){
	if(confirm('Do you really want to assign Pickup of Order.'))
	{
		// do nothing
	}
	else
	{
		return false;
	}

	var orders_id = $('#orders_id').val();

	$("#shipRicketResponseDiv").html('');

	$(".assignShiprocketOrderPickupBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Assigning Pickup For Order.</div>");

	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/Orders-Module/assign_shiprocket_order_pickup_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketOrderPickupBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
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
		url:'<?=MAINSITE?>secureRegions/orders/Orders-Module/assign_shiprocket_order_generate_manifest_api/',
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
		url:'<?=MAINSITE?>secureRegions/orders/Orders-Module/assign_shiprocket_order_print_manifest_api/',
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
		url:'<?=MAINSITE?>secureRegions/orders/Orders-Module/assign_shiprocket_order_label_api/',
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
		url:'<?=MAINSITE?>secureRegions/orders/Orders-Module/assign_shiprocket_order_invoice_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".assignShiprocketOrderInvoiceBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);
		}
	});
}

function trackShiprocketOrder(){

	var orders_id = $('#orders_id').val();

	$("#shipRicketResponseDiv").html('');

	$(".trackShiprocketOrderBTN").prop('disabled', true);
	$("#shipRicketResponseDiv").html("<div class=' alert alert-info'>Trackin Shipment.</div>");

	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/Orders-Module/track_shiprocket_order_api/',
		data : {  'orders_id' : orders_id },
		success : function(result){
			$(".trackShiprocketOrderBTN").prop('disabled', false);
			$("#shipRicketResponseDiv").html("");
			//$('#shipRicketRateServiceData').html(result);
			$('#shipRicketResponseDiv').html(result);

			//$('.track_order_modal_body').html(result)

			//$('#track_order_modal').modal({show:true})
			$('#user_pin_close').html('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>')


		}
	});
}



</script>
<? } ?>
<div class="form-group">
                                        <div class="col-md-12" id="shipRicketResponseDiv">
                                        </div>
                                    </div>
                    	<div class="tab-pane fade all_tab_<?=$index?> <?=$tab1?> active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab" style="">
                    		<div class="card-body card-primary card-outline">

                            <?php echo form_open(MAINSITE_Admin."$user_access->class_name/doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="task" id="task" value="" />

                            <?=$this->session->flashdata('message')?>
                            <table id="" class="table table-bordered table-hover myviewtable responsiveTableNewDesign">
                                <tbody>
									<tr>
										<td><strong class="full">Order Number</strong><?=$order_data->order_number?></td>
										<td><strong class="full">Order Placed On</strong><?=date('d-m-Y h:i:s A', strtotime($order_data->added_on))?></td>
										<td><strong class="full">Last Action taken On</strong><?php if(!empty($order_data->updated_on)) { echo date('d-m-Y h:i:s A', strtotime($order_data->updated_on)); } else { echo "N/A"; }?></td>
										<td><strong class="full">Order Status</strong><?php if($order_data->order_status==1){echo "Order placed";}else if($order_data->order_status==2){echo "In Process";}else if($order_data->order_status==3){echo "Out For Delivery";}else if($order_data->order_status==4){echo "Delivered";}else if($order_data->order_status==5){echo "Not Deliver";}else if($order_data->order_status==6){echo "Cancle";} ?></td>
									</tr>
                                    <tr>
										<td ><strong class="full">Customer Name</strong><?=$order_data->d_name?></td>
										<td colspan="2"><strong class="full">Company Email</strong><?=$order_data->email?></td>
                                        <td colspan="1"><strong class="full">Customer Contact No.</strong><?=$order_data->d_number?></td>

									</tr>
                                    <tr>
										<td><strong class="full">Delivery Challan NO.</strong><?php if(!empty($order_data->delivery_challan_no)) { echo $order_data->delivery_challan_no;} else { echo "N/A"; }?></td>
										<td><strong class="full">Courier Name</strong><?php if(!empty($order_data->courier_name)) { echo $order_data->courier_name;} else { echo "N/A"; }?></td>
										<td><strong class="full">Docket No.</strong><?php if(!empty($order_data->docket_no)) { echo $order_data->docket_no;} else { echo "N/A"; }?></td>
                                        <td><strong class="full">Docket File</strong><?php if(!empty($order_data->file_link)) { ?><a href="<?=base_url().'assets/uploads/docket/'.$order_data->file_link?>" target="_blank">View Docket File</a><?php } else { echo "N/A"; }?></td>

									</tr>
                                    <tr>
										<td><strong class="full">Total</strong><?=$order_data->symbol ?> <?=$order_data->total?></td>
                                        <td><strong class="full">Payment Mode</strong><?php if(!empty($order_data->mode)) { echo $order_data->mode; } else { echo "N/A" ;}?></td>
										<td><strong class="full">Transaction ID</strong><?php if(!empty($order_data->txnid)) { echo $order_data->txnid; } else { echo "N/A" ;}?></td>
										<td colspan="2"><strong class="full">Bank ID</strong><?php if(!empty($order_data->mihpayid)) { echo $order_data->mihpayid; } else { echo "N/A" ;}?></td>
									</tr>
									<tr>
										<td colspan="1" >
										<strong class="full">Delivery Address</strong>
										<? echo $order_data->d_address;
											if(!empty($order_data->d_address2)){echo "<br>".$order_data->d_address2;}
											if(!empty($order_data->d_address3)){echo "<br>".$order_data->d_address3;}
											echo "<br>".$order_data->d_city_name." ($order_data->d_zipcode) ";
											echo "<br>".$order_data->d_state_name;
											echo "<br>".$order_data->d_country_name." ";
										?></td>
										<td colspan="1">
										<strong class="full">Billing Address</strong>
										<? echo $order_data->b_address;
											if(!empty($order_data->b_address2)){echo "<br>".$order_data->b_address2;}
											if(!empty($order_data->b_address3)){echo "<br>".$order_data->b_address3;}
											echo "<br>".$order_data->b_city_name." ($order_data->b_zipcode) ";
											echo "<br>".$order_data->b_state_name;
											echo "<br>".$order_data->b_country_name." ";
										?></td>

									</tr>



                                </tbody>
							</table>
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
													foreach($order_data->details as $order_details)
													{$count++; //echo "<pre>";print_r($order_data->details);
													 ?>
                                                    	<tr>
                                                            <td><?=$count?>.</td>
                                                            <td><?php /*?><?=$odd->product_name?><br><?php */?><?=$order_details->product_display_name?><br><?=$order_details->combi?></td>
                                                            <td><?=$order_details->brand_name?></td>
                                                            <?php /*?><td><?=$odd->prod_comment?></td><?php */?>
                                                            <td><?=$order_data->symbol ?> <?=$order_details->price?></td>
                                                            <td><?=$order_data->symbol ?> <?=$order_details->final_price?></td>
                                                            <td><?=$order_details->prod_in_cart?></td>
                                                            <td><?=$order_data->symbol ?> <?=$order_details->sub_total?></td>
                                                        </tr>
                                                  <? } ?>
<?
$colspan = 6;
?>
                                                  <? if(!empty($order_data->coupon_code)){

													   ?>
                                                  		<tr>
                                                            <td colspan="<?=$colspan?>"  style="text-align:right">Coupon (<?=$order_data->coupon_code?>)</td>
                                                            <td> <?=$order_data->discount?> %</td>
                                                        </tr>
                                                   <? } ?>
                                                        <tr>
                                                            <td colspan="<?=$colspan?>"  style="text-align:right">GST Charges</td>
                                                            <td><?=$order_data->symbol ?> <?=$order_data->total_gst?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="<?=$colspan?>"  style="text-align:right">Delivery Charges</td>
                                                            <td><?=$order_data->symbol ?> <?=$order_data->delivery_charges?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="<?=$colspan?>"  style="text-align:right">COD Charges</td>
                                                            <td><?=$order_data->symbol ?> <?=$order_data->cod_charges?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="<?=$colspan?>"  style="text-align:right">Total</td>
                                                            <td><?=$order_data->symbol ?> <?=$order_data->total?></td>
                                                        </tr>
                                                    </tbody>
                                    			</table>
						<?php echo form_close() ?>
                    </div>
                    	</div>
                        <div class="tab-pane fade all_tab_<?=$index?> <?=$tab2?>"  id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                             <div class="card-body card-primary card-outline">

                            <div class="col-md-12">
                              <? if(!empty($order_data->order_history) ){ ?>

                                <div class="timeline">
                          <?
                          $f_date='';
                          foreach($order_data->order_history as $fud){
                          ?>
                          <?
                          $temp_date = date('d-m-Y', strtotime($fud->updated_on));
                          if($f_date!=$temp_date)
                          {
                              $f_date=$temp_date;
                              ?>

                            <div class="time-label">
                              <span class="bg-red"><?=date('d M. Y' , strtotime($f_date))?></span>
                            </div>
                              <?
                          }
                          ?>
          <div>
            <div class="bg-success status_custom color-palette"><span><i class="fas fa-angle-double-right"></i>  <?=$order_data->order_number?></span></div>          <div class="timeline-item" style="margin-left: 198px;top: -25px">
              <span class="time"><i class="fas fa-clock"></i> <?=date('d-m-Y h:i:s A' , strtotime($fud->updated_on))?></span>
              <h3 class="timeline-header"><?=$fud->caption?> </h3>

              <div class="timeline-body">
              	<? if(!empty($fud->description)) { echo "<p>";echo $fud->description;echo "</p>"; } ?>
            <? if(!empty($fud->remarks)) { echo "<p>";echo $fud->remarks;echo "</p>"; } ?>
            <? if(!empty($fud->long_description)) { echo "<p>";echo $fud->long_description;echo "</p>"; } ?>
                          </div>
                      </div>
          </div>

        <? } ?>

      <div>
          <i class="fas fa-clock bg-gray"></i>
      </div>
  </div>
</div>
  <? }else{ ?>
  <div class="alert alert-warning alert-dismissible"><i class="icon fas fa-ban"></i> No Data To Display</div>
  <? } ?>


                                </div>
                        </div>
                    </div>
                    <? }else{
						$this->data['no_access_flash_message']="You Dont Have Access To View ".$page_module_name;
						$this->load->view('admin/template/access_denied' , $this->data);
					} ?>
                    <!-- /.card-body -->
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
        <input type="hidden" name="orders_id" id="orders_id" value="<?=$order_data->orders_id?>" />
        <input type="hidden" name="order_number" id="order_number" value="<?=$order_data->order_number?>" />
        	<div class="clearfix">
            	<div class="clearfix form-group">
                    <label class="col-md-3">Dropdown</label>
                    <div class="col-md-9">
                    	<select class="form-control" required name="order_status" id="order_status" onchange="setAction(this.value)">
                        	<option value="">Select Action</option>
                            <option value="1" <? if($order_data->order_status==1){echo "selected";} ?>>Order placed</option>
                            <option value="2" <? if($order_data->order_status==2){echo "selected";} ?>>In Process</option>
                            <option value="3" <? if($order_data->order_status==3){echo "selected";} ?>>Dispatched</option>
                            <option value="4" <? if($order_data->order_status==4){echo "selected";} ?>>Delivered</option>
                            <option value="5" <? if($order_data->order_status==5){echo "selected";} ?>>Not Delivered</option>
                            <option value="6" <? if($order_data->order_status==6){echo "selected";} ?>>Cancelled</option>
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
function bookDocketAjax(order_id , service_id , partner_id ,  insurance , total_package_weight , box_l , box_b , box_h)
{
   $.ajax({
		type: "POST",
		url:'<?=MAINSITE?>secureRegions/orders/Orders-Module/ShippingServiceApi/',
		data : { 'orders_id' : orders_id , 'insurance' : insurance , 'total_package_weight' : total_package_weight , 'box_l' : box_l, 'box_b' : box_b , 'box_h' : box_h  , 'service_id' : service_id  , 'partner_id' : partner_id },
		success : function(result){
			//$this.button('reset');
			$('#ShippingServiceApiData').html(result);
		}
	});
}

</script>
<script src="<? echo MAINSITE ?>assets/admin/table.js/js/jquery.dataTables.min.js"></script>
<script src="<? echo MAINSITE ?>assets/admin/table.js/js/dataTables.buttons.min.js"></script>
<script src="<? echo MAINSITE ?>assets/admin/table.js/js/buttons.flash.min.js"></script>
<script src="<? echo MAINSITE ?>assets/admin/table.js/js/jszip.min.js"></script>
<script src="<? echo MAINSITE ?>assets/admin/table.js/js/pdfmake.min.js"></script>
<script src="<? echo MAINSITE ?>assets/admin/table.js/js/vfs_fonts.js"></script>
<script src="<? echo MAINSITE ?>assets/admin/table.js/js/buttons.html5.min.js"></script>
<script src="<? echo MAINSITE ?>assets/admin/table.js/js/buttons.print.min.js"></script>
<script src="<? echo MAINSITE ?>assets/admin/table.js/js/buttons.colVis.min.js"></script>
<script src="<? echo MAINSITE ?>assets/admin/table.js/js/dataTables.searchHighlight.min.js"></script>
<? $filename='ship'; ?>
<script>
function ArrangeTable(){
	/*$('#example tfoot th').each( function () {
        var title = $(this).text();
		if(title!='')
        $(this).html( '<input style="width:100%;padding:3px 1px;font-weight:normal;font-size: 12.5px;" type="text" placeholder="Search '+title+'" />' );
    } );*/

    $('#example').DataTable( {
		"paging":   false,
        "ordering": true,
		"autoWidth": true,
		"info":     true,
		"dragColumn":true,
		//"searchHighlight": true,
		"mark": true,
		"order": [[ 0  , 'asc']],
		//"scrollY":        "700px",
        "scrollCollapse": true,
		//"scrollX": true,
	//  responsive: true,


        lengthMenu: [
            [ 10, 25, 50, 100, -1 ],
            [ '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]
        ],
        /*"columnDefs": [
            {
                "targets": [ '' ],
                "visible": false,
                //"searchable": false
            },

        ]*/

    } );

	var table = $('#example').DataTable();
 table.columns.adjust().draw();
    $('#example tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

   /*table.columns().every( function () {
        var that = this;

        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value )
                    table.draw();
            }
        } );

    } );*/

	 table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          //  cell.innerHTML = i+1;
        } );
    } ).draw();


}


</script>
<div class="modal fade " id="track_order_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title" id="myModalLabel">Delivery By <span class="order_courier_name"></span></h4>
        <h5 class="modal-title" id="myModalLabel">Tracking ID: <span class="order_docket_no"></span> </h5>
        <span id="user_pin_close"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></span>
      </div>
      <div class="modal-body modal_space track_order_modal_body">
</div>

    </div>
  </div>
</div>
