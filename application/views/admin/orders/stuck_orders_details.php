<?
$od = $orders_detail[0];

?>
<style type="text/css" >
.newModalCss {border-radius: 15px 15px 0 0;overflow:hidden;}
	.newModalCss .modal-header{background-color: #3C8DBC;
    color: #fff;
    
}
	.newModalCss label{text-align:right;padding-top: 4px;}
</style>
    
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
            <!-- Content Header (Page header) -->

                <section class="content-header">
                    <h1>#<? echo $od->temp_orders_id;?><small> In Stuck Orders Details</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="<? echo MAINSITE."SecureRegions/wdm"; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<? echo MAINSITE."SecureRegions/orders/stuckOrders"; ?>"><i></i> All Stuck Orders List</a></li>
                        <li class="active">Order Details</li>
                    </ol>
                </section>
            
                <!-- Main content -->
                <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                	<div class="col-md-4">
                                	<h3 class="box-title">Order Details </h3>
                                    </div>
                                    <div class="col-md-8 text-right">
                                    
                                    <? if($od->status==0){ ?>
                                    <a href="#Modalpop" data-toggle="modal" class="btn btn-primary">Take Action</a>
                                    <? } ?>
                                   
                                    
                                    </div>
                                    
                                </div>
                                <? if($od->status==1){ ?>
                                	<div class="alert alert-success"><strong>Order Success!</strong> This order is placed successfully.</div>
                                <? }else{ ?>
                                	<div class="alert alert-danger"><strong>Order Fail!</strong> This order is failed.</div>
                                <? } ?>
                                
                                <div class="box-body">
                                <? 
							//	echo "<pre>";print_r($od);echo "</pre>";
								?>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                    	<tr>
                                        	<td width="50%" valign="top">
                                    			<table id="example2" class="table table-bordered table-hover">
                                                    <tbody>
                                                    	<tr>
                                                            <td width="20%">Order Id</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><strong>#<?=$od->temp_orders_id?></strong></td>
                                                        </tr>
                                                        <?php /*?><tr>
                                                            <td width="20%">Order Number</td>
                                                            <td width="5%">:</td>
                                                            <td width="*"><strong><?=$od->order_number?></strong></td>
                                                        </tr><?php */?>
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
                                                           Order Fail
                                                            </strong></p>
                                                            <? if(!empty($od->reason)){ ?>
                                                            <p><strong>Reason : </strong> <?=$od->reason?></p>
                                                            <? } ?>
                                                            </td>
                                                        </tr>
                                                       <? if(!empty($od->payment_details)){ ?>
                                                    	<tr>
                                                            <td width="20%">Payment Details</td>
                                                            <td width="5%">:</td>
                                                            <td width="*">
                                                            	<p>TxnreferenceNo : <strong><?=$od->payment_details[0]->TxnreferenceNo?></strong></p>
                                                                <p>BankReferenceNo : <strong><?=$od->payment_details[0]->BankReferenceNo?></strong></p>
                                                                <p>Mode : <strong>CC</strong></p>
                                                                <? if($od->payment_details[0]!='NA'){ ?><p>Error Description : <strong><?=$od->payment_details[0]->ErrorDescription	?></strong></p><? } ?>
                                                            </td>
                                                        </tr>
                                                        <? }else{ ?>
                                                        <tr>
                                                            <td width="20%">Reason</td>
                                                            <td width="5%">:</td>
                                                            <td width="*">
                                                                <div class="alert alert-danger">
                                                                <? if($od->stuck_status == 2){ ?>
                                                                Went For the Payment But Did not come back to the website it may be connection lost
                                                                <? }else{ ?>
                                                                Went For the Payment But Payment Not Done
                                                                <? } ?>
                                                                
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <? } ?>
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
                                                            	<?php /*?><p><?=$od->d_name?></p>
                                                                <p><?=$od->d_number?></p>
                                                                <p><?=$od->d_address?></p>
                                                                <p><?=$od->d_location_name?></p>
                                                                <p><?=$od->d_city_name?>, <?=$od->d_location_pincode?></p><?php */?>
                                                                <p><?=$od->d_name?></p>
                                                                <p><?=$od->d_number?></p>
                                                                <p><?=$od->d_address	?></p>
                                                                <p><?=$od->d_city_name?></p>
                                                                <p><?=$od->d_state_name?>, <?=$od->d_zipcode?></p>
                                                                <p><?=$od->d_country_name?></p>
                                                            </td>
                                                        </tr>
                                                         <tr>
                                                            <td width="20%">Billing Details</td>
                                                            <td width="5%">:</td>
                                                            <td width="*">
                                                            	<?php /*?><p><?=$od->d_name?></p>
                                                                <p><?=$od->d_number?></p>
                                                                <p><?=$od->d_address?></p>
                                                                <p><?=$od->d_location_name?></p>
                                                                <p><?=$od->d_city_name?>, <?=$od->d_location_pincode?></p><?php */?>
                                                                <p><?=$od->b_name?></p>
                                                                <p><?=$od->b_number?></p>
                                                                <p><?=$od->b_address	?></p>
                                                                <p><?=$od->b_city_name?></p>
                                                                <p><?=$od->b_state_name?>, <?=$od->b_zipcode?></p>
                                                                <p><?=$od->b_country_name?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%">Order Details</td>
                                                            <td width="5%">:</td>
                                                            <td width="*">
																<p>#Items : <strong><?=count($od->details)?></strong></p>
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
                                                            <th>Item Code</th>
                                                            <th>Remarks</th>
                                                            <th>Price</th>
                                                            <th>Final Price</th>
                                                            <th>Tax</th>
                                                            <th>Qty</th>
                                                            <th>Sub Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?
													$count = 0;
													foreach($od->details as $odd)
													{$count++
													 ?>
                                                    	<tr>
                                                            <td><?=$count?>.</td>
                                                            <td>
                                                            <p><?=$odd->product_name?></p>
                                                            <p><?=$odd->combi?></p>
                                                            </td>
                                                            <td><?=$odd->ref_code?></td>
                                                            <td><?=$odd->prod_comment?></td>
                                                            <td><?=$od->symbol ?> <? if(!empty($odd->discounted_price)){echo $odd->discounted_price;}else{echo $odd->price;}?></td>
                                                            <td><?=$od->symbol ?> <?=$odd->final_price?></td>
                                                            <td><?=$odd->tax_providers_percentage?>%</td>
                                                            <td><?=$odd->prod_in_cart?></td>
                                                            <td><?=$od->symbol ?> <?=$odd->sub_total?></td>
                                                        </tr>
                                                  <? } ?>
                                                  <? if(!empty($od->coupon_code)){ ?>
                                                  		<tr>
                                                            <td colspan="7"  style="text-align:right">Coupon (<?=$od->coupon_code?>)</td>
                                                            <td> <?=$od->discount?> %</td>
                                                        </tr>
                                                   <? } ?>
                                                  <? if(!empty($od->delivery_charges)){ ?>
                                                  		<tr>
                                                            <td colspan="7"  style="text-align:right">Delivery Charges</td>
                                                            <td><?=$od->symbol ?> <?=$od->delivery_charges?></td>
                                                        </tr>
                                                   <? } ?>
                                                   <tr>
                                                            <td colspan="7"  style="text-align:right">GST Charges</td>
                                                            <td><?=$od->symbol ?> <?=$od->total_gst?></td>
                                                        </tr> 
                                                        
                                                        <tr>
                                                            <td colspan="7"  style="text-align:right">Total</td>
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
                    </div>
            <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
<? if($od->status==0){ ?>
<div id="Modalpop" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content newModalCss">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <form class="" action="<?=MAINSITE.'SecureRegions/orders/stuckToSuccess'?>" method="post">
        <input type="hidden" name="temp_orders_id" id="temp_orders_id" value="<?=$od->temp_orders_id?>" />
        	<div class="clearfix">
            	<div class="clearfix form-group">
                    <label class="col-md-3">Action</label>
                    <div class="col-md-9">
                    	<select class="form-control" required name="status" id="status" >
                        	<option value="">Select Action</option>
                            <option value="1" selected>Make Order As Success</option>
                        </select>
                    </div>
                </div>
                
                <div class="clearfix form-group" id="id_courierNo">
                    <label class="col-md-3">TxnreferenceNo.</label>
                    <div class="col-md-9">
                    	<input type="text" name="TxnreferenceNo" placeholder="TxnreferenceNo." id="TxnreferenceNo" class="form-control" />
                    </div>
                </div>
                
                 <div class="clearfix form-group" id="BankReferenceNo">
                    <label class="col-md-3">BankReferenceNo.</label>
                    <div class="col-md-9">
                    	<input type="text" name="BankReferenceNo" placeholder="BankReferenceNo." id="BankReferenceNo" class="form-control" />
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


<? } ?>