<?php $alert=$uriid=$this->uri->segment(4); ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
            <form role="form" class="form-horizontal" name="recordslistform" id="recordslistform" action="#" method="post" enctype="multipart/form-data">
			<div>
                <div class="content-header clearfix">
                    <h1 class="pull-left">Stuck Orders</h1>
                    
                        <?php /*?><div class="pull-right"><a class="btn bg-blue" href="<? echo MAINSITE."SecureRegions/wdm/tax_providers_action_page";?>"><i class="fa fa-plus-square"></i>Add New</a>
                            <button type="submit" id="act_tax_providers" name="act_tax_providers" value="1" class="btn bg-teal" onClick="javascript: return validateActivate();"><i class="fa fa-check-square-o"></i>Publish Selected</button>
                            <button type="submit" id="blk_tax_providers" name="blk_tax_providers" value="1" class="btn bg-navy" onClick="javascript: return validateBlock();"><i class="fa fa-minus-square-o"></i>Unpublish Selected</button>
                            
                            <a class="btn bg-green" href="/Admin/Country/ExportCsv"><i class="fa fa-download"></i>Export states to CSV</a>
                            <button type="submit" name="importcsv" class="btn bg-olive" data-toggle="modal" data-target="#importcsv-window"><i class="fa fa-upload"></i>Import States From CSV</button>
                            
                        </div><?php */?>
                     
                </div>
                
                <div class="row">
                    <div class="col-xs-12">
                    
                     <?=$this->session->flashdata('message')?>
                   
                        <div class="panel">
                        <br>

                        <span style="background-color:#0F0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 	Order Successfull&nbsp;&nbsp;&nbsp;
                        <span style="background-color:#0FF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 	Go For the Payment But Did not come back &nbsp;&nbsp;&nbsp;
                        <span style="background-color:#F0F">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 	Go For the Payment But Payment Not Done&nbsp;&nbsp;&nbsp;
                            <div class="panel-body">
                            
                                <table width="85%" class="table table-bordered table-hover" id="example2">
                                    <thead>
                                        <tr>
                                            <?php /*?><th width="3%"><input type="checkbox" name="main_check" id="main_check" onClick="check_uncheck_All_records()" value="" /></th><?php */?>
                                            <th width="*%"><strong>Sl No.</strong></th>
                                            <th width="*%"><strong>Order No.</strong></th>
                                            <th width="*%"><strong>Customer Name</strong></th>
                                            <th width="*%"><strong>Amount</strong></th>
                                            <?php /*?><th width="*%"><strong>#Items</strong></th><?php */?>
                                            <th width="*%"><strong>Order Placed On</strong></th>                                            
                                            <th width="*%"><strong>Status</strong></th>
                                            
                                            
                                                                                         
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                    
                                   <?php 
										$offset_val = (int)$this->uri->segment(4);
										
										$count=$offset_val;
										if(count($orders_list) != 0)
										{ 
											foreach($orders_list as $o)   
											{
												$count++;
												
		//1=Order Placed , 2= Go For the Payment But Did not come back , 3= Go For the Payment But Payment Not Done										
$color = '';
if($o->stuck_status==1){$color= "#0F0";}//Order Placed
if($o->stuck_status==2){$color= "#0FF";}//Go For the Payment But Did not come back 
if($o->stuck_status==3){$color= "#F0F";}//Go For the Payment But Payment Not Done
                                    ?>
                                                <tr style="background-color: <?=$color?>">
                                                    <?php /*?><td>
                                                     <label class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" name="selectedRecords[]" id="selectedRecords<?php echo $count; ?>" value="<?php echo $row['tax_providers_id']; ?>">
    <span class="custom-control-indicator"></span>
   
  </label></td><?php */?>
  
                                                    <td><?=$count?></td>
                                                    <td>
													<? if(!empty($o->order_number)){ ?><a class="btn btn-default" target="_blank" href="<? echo MAINSITE."SecureRegions/orders/details/".$o->orders_id;?>"><?=$o->order_number?></a><? }else{ ?>
                                                    <a class="btn btn-default" href="<? echo MAINSITE."SecureRegions/orders/stuckOrderDetails/".$o->temp_orders_id;?>">View Details</a>
                                                    <? } ?>
                                                    
                                                    </td>
													<td><?=$o->name?></td>
                                                    <td><?=$o->total?></td>
                                                    <?php /*?><td><?=$o->total_prod?></td><?php */?>
                                                    <td><?=date('d-m-Y h:i:s A', strtotime($o->added_on))?></td>
                                                    <td><?php if($o->status==1 ){echo "Order Successfull";}else {echo "Order Fail";} ?></td>
                                                  
                                                    
                                                  
                                                </tr>
									<?php	
											}	
											 ?>
                                   <?php /*?><tr>
                                   	<td colspan="8">
                                    <div class="style13"><div class="pagination" align="center"><?php echo $this->pagination->create_links(); ?></div></div>
                                    	</td></tr><?php */?>
                                    <?
											
									}
										else
										{
									?>
                                            <tr>
                                                <td colspan="6">No records to display...</td>
                                            </tr>
									<?php	
										}
									?>
                                   
                                    </tbody>
                                  
                                </table>
                                
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            </form>
            </div>
            <!-- /.content-wrapper -->
        
			
        
        <script type="application/javascript">
			function check_uncheck_All_records() // done
			{
				var mainCheckBoxObj = document.getElementById("main_check");
				var checkBoxObj = document.getElementsByName("selectedRecords[]");
				
				for(var i = 0; i < checkBoxObj.length; i++)
				{
					if(mainCheckBoxObj.checked)
						checkBoxObj[i].checked = true;
					else
						checkBoxObj[i].checked = false;
				}
			}
		
			function validateCheckedRecordsArray() // done
			{
				var checkBoxObj = document.getElementsByName("selectedRecords[]");
				var count = true;
			
				for(var i = 0; i < checkBoxObj.length; i++)
				{
					if(checkBoxObj[i].checked)
					{
						count = false;
						break;
					}
				}
				
				return count;
			} 
		
			function validateActivate() // done
			{
				if(validateCheckedRecordsArray())
				{
					alert("Please select any Record to activate.");
					document.getElementById("selectedRecords1").focus();
					return false;
				}
				else
				{
					//document.getElementById("recordslistform").action = "http://localhost/xampp/MARS/knitt_silk_ecommerce/SecureRegions/wdm/doActiveState/";
					document.getElementById("recordslistform").action = "<?php echo MAINSITE.'SecureRegions/wdm/doActiveTaxProviders/';?>";
					document.getElementById("recordslistform").submit();
				}
			}
			
			function validateBlock() // done
			{
				if(validateCheckedRecordsArray())
				{
					alert("Please select any Record to block.");
					document.getElementById("selectedRecords1").focus();
					return false;
				}
				else
				{
					//document.getElementById("recordslistform").action = "http://localhost/xampp/MARS/knitt_silk_ecommerce/SecureRegions/wdm/doBlockState/";
					document.getElementById("recordslistform").action = "<?php echo MAINSITE.'SecureRegions/wdm/doBlockTaxProviders/';?>";
					document.getElementById("recordslistform").submit();
				}
			}
		</script>
        
