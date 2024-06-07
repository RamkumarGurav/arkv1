<?php $alert=$uriid=$this->uri->segment(4); ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
            <form role="form" class="form-horizontal" name="recordslistform" id="recordslistform" action="#" method="post" enctype="multipart/form-data">
			<div>
                <div class="content-header clearfix">
                    <h1 class="pull-left">Orders Are Delivered</h1>
                    
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
                            <div class="panel-body">
                            
                                <table width="85%" class="table table-bordered table-hover" id="example2">
                                    <thead>
                                        <tr>
                                            <?php /*?><th width="3%"><input type="checkbox" name="main_check" id="main_check" onClick="check_uncheck_All_records()" value="" /></th><?php */?>
                                            <th width="*%"><strong>Order No.</strong></th>
                                            <th width="*%"><strong>Customer Name</strong></th>
                                            <th width="*%"><strong>Store Name</strong></th>
                                            <th width="*%"><strong>Amount</strong></th>
                                            <th width="*%"><strong>#Items</strong></th>
                                            <th width="*%"><strong>Order Placed On</strong></th>                                            
                                            <?php /*?><th width="*%"><strong>Status</strong></th><?php */?>
                                            <th width="*%"><strong>Edit</strong></th>
                                            
                                                                                         
                                            
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
												
                                    ?>
                                                <tr style="background-color: <? if($o->order_status==1){echo "#F00";} ?>">
                                                    <?php /*?><td>
                                                     <label class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" name="selectedRecords[]" id="selectedRecords<?php echo $count; ?>" value="<?php echo $row['tax_providers_id']; ?>">
    <span class="custom-control-indicator"></span>
   
  </label></td><?php */?>
  
                                                    <td><?=$o->order_number?></td>
													<td><?=$o->name?></td>
                                                    <td><?=$o->store_name?></td>
                                                    <td><?=$o->symbol ?> <?=$o->amount?></td>
                                                    <td><?=$o->total_prod?></td>
                                                    <td><?=date('d-m-Y h:i:s A', strtotime($o->added_on))?></td>
                                                    <?php /*?><td><?php if($o->order_status==1){echo "Order placed";}else if($o->order_status==2){echo "In Process";}else if($o->order_status==3){echo "Out For Delivery";}else if($o->order_status==4){echo "Delivered";}else if($o->order_status==5){echo "Not Deliver";}else if($o->order_status==6){echo "Cancle";} ?></td><?php */?>
                                                    <td><a class="btn btn-default" href="<? echo MAINSITE."SecureRegions/orders/details/".$o->orders_id;?>"><i class="fa fa-pencil"></i>Edit</a></td>
                                                    
                                                  
                                                </tr>
									<?php	
											}	
											 ?>
                                   <tr>
                                   	<td colspan="8">
                                    
                                    	</td></tr>
                                    <?
											
									}
										else
										{
									?>
                                            <tr>
                                                <td colspan="8">No records to display...</td>
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
        
