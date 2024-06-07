<?php

$page_module_name = "Product Attribute";

?>
<?
$name="";
$condition_per_product=$list_page=$details_page="";
$product_attribute_detail_id=$attributes_input_id=0;
$status = $search = $list_page = $details_page = 1;
$record_action = "Add New Record";
//print_r($product_attribute_detail);
if(!empty($product_attribute_detail))
{
	// $record_action = "Update";
	 $product_attribute_id = $product_attribute_detail->product_attribute_id;
	 echo "product_attribute_id : $product_attribute_id </br>";
	// $city_name = $product_attribute_detail->city_name;
	// $status = $product_attribute_detail->status;
	
}
?>
<script>
$(document).ready(function() {
	$.ajax({
   type: "POST",

	url:'<? echo MAINSITE_Admin ?>catalog/Product-Attribute-Module/GetCompleteAttributeValueList',
   //dataType : "json", 
   data : {"product_attribute_id" : <? echo $product_attribute_id; ?>, "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},
   success : function(result){
	 //   alert(result);
		$('#stateList').html(result);
		//ArrangeTable();
		dragEvent();
	   }
   });
});
</script>
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
                        <h3 class="card-title"><?=$product_attribute_detail->name?></h3>
                        <div class="float-right">
                            <?php 
								if($user_access->add_module==1 && false)	{
								?>
								<a href="<?=MAINSITE_Admin.$user_access->class_name?>/edit"> 
                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                                New</button></a>
                            <? } ?>
                            <?php 
							if($user_access->update_module==1)	{
							?>
							<a href="<?=MAINSITE_Admin.$user_access->class_name?>/edit/<?=$product_attribute_detail->product_attribute_id?>"> 
                            <button type="button" class="btn btn-success btn-sm" ><i
                                    class="fas fa-edit"></i> Update</button>
                            </a>
                            <? } ?>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <?php 
						if($user_access->view_module==1)	{
					?>
                    <div class="card-body">
                        
                            <?php echo form_open(MAINSITE_Admin."$user_access->class_name/doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            
                            <input type="hidden" name="task" id="task" value="" />
                            <? echo $this->session->flashdata('alert_message'); ?>
                            <div class="divTable">
                            	<div class="TableRow">
                                	<div class="table_col">
                                        <label class="label_content_br">Data Base Id <span class="colen">:</span></label>
                                        <?=$product_attribute_detail->product_attribute_id?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Product Attribute Name  <span class="colen">:</span></label>
                                       <?=$product_attribute_detail->name?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">No. Of Attributes Per Product<span class="colen">:</span></label>
                                       <?=$product_attribute_detail->condition_per_product?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Attribute Display Type<span class="colen">:</span></label>
                                        <?=$product_attribute_detail->attribute_name?>
                                    </div>
                                    <div class="table_col" >
                                        <label class="label_content_br">Display On List Page <span class="colen">:</span></label>
                                        <? if($product_attribute_detail->list_page==1){ ?> Yes <i class="fas fa-check btn-success btn-sm "></i>
                                                <? }else{ ?> No <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?>
                                    </div>
                                	
                                    <div class="table_col">
                                    <label class="label_content_br">Display In Details Page <span class="colen">:</span></label>
                                   <? if($product_attribute_detail->details_page==1){ ?> Yes <i class="fas fa-check btn-success btn-sm "></i>
                                                <? }else{ ?> No <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?>
                                    </div>
                                    <div class="table_col">
                                    <label class="label_content_br">Searches Given<span class="colen">:</span></label>
                                   <? if($product_attribute_detail->search==1){ ?> Yes <i class="fas fa-check btn-success btn-sm "></i>
                                                <? }else{ ?> No <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?>
                                    </div>
                                </div>
                                <div class="TableRow">
                               		 <div class="table_col">
                                    <label class="label_content_br">Added On <span class="colen">:</span></label>
                                    <?=date("d-m-Y h:i:s A" , strtotime($product_attribute_detail->added_on))?>
                                    </div>
                                    <div class="table_col">
                                    <label class="label_content_br">Added By <span class="colen">:</span></label>
                                    <?=$product_attribute_detail->added_by_name?>
                                    </div>
                                    <div class="table_col">
                                    <label class="label_content_br">Updated On <span class="colen">:</span></label>
                                   <? if(!empty($product_attribute_detail->updated_on)){echo date("d-m-Y h:i:s A" , strtotime($product_attribute_detail->updated_on));}else{echo "-";}?>
                                    </div>
                                    <div class="table_col">
                                    <label class="label_content_br">Updated By <span class="colen">:</span></label>
                                    <? if(!empty($product_attribute_detail->updated_by_name)){echo $product_attribute_detail->updated_by_name;}else{echo "-";}?>
                                    </div>
                                    <div class="table_col">
                                    <label class="label_content_br">Status <span class="colen">:</span></label>
                                   <? if($product_attribute_detail->status==1){ ?> Active <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> Block <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?>
                                    </div>
                                    
                                </div>
                            </div>
                            <table id="" class="table table-bordered table-hover myviewtable" style="display:none;">                                
                                <tbody>                                    
									<tr>
										<td><strong class="full">Data Base Id</strong>
										<?=$product_attribute_detail->city_id?></td>
										<td><strong class="full">Country</strong>
										<?=$product_attribute_detail->country_name?></td>
										<td><strong class="full">State</strong>
										<?=$product_attribute_detail->state_name?></td>
										<td><strong class="full">City</strong>
										<?=$product_attribute_detail->city_name?></td>
										<td><strong class="full">City Code</strong>
										<?=$product_attribute_detail->city_code?></td>
										<td><strong class="full">is Display</strong>
										<? if($product_attribute_detail->is_display==1){ ?> Yes <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> No <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?></td>
									</tr>									
									<tr>
										<td><strong class="full">Added On</strong>
										<?=date("d-m-Y h:i:s A" , strtotime($product_attribute_detail->added_on))?></td>
										<td><strong class="full">Added By</strong>
										<?=$product_attribute_detail->added_by_name?></td>
										<td><strong class="full">Updated On</strong>
										<? if(!empty($product_attribute_detail->updated_on)){echo date("d-m-Y h:i:s A" , strtotime($product_attribute_detail->updated_on));}else{echo "-";}?></td>
										<td><strong class="full">Updated By</strong>
										<? if(!empty($product_attribute_detail->updated_by_name)){echo $product_attribute_detail->updated_by_name;}else{echo "-";}?></td>
										<td colspan="2"><strong class="full">Status</strong>
										<? if($product_attribute_detail->status==1){ ?> Active <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> Block <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?></td>
									</tr>
                                    
                                </tbody>
                                
						</table>
						<?php echo form_close() ?>
                    </div>
                    
                    <link rel="stylesheet" href="<? echo MAINSITE ?>assets/administrator/css/tablednd.css" type="text/css"/>
<div class="tableDemo">
                                    <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                        <th>Slno.</th>
                                            <th><input type="checkbox" name="main_check" id="main_check" onclick="check_uncheck_All_records()" value="Checkbox" /><span style="display:none">Checkbox</span></th>
                                           <th>Name</th>
                                            <th>Attribute Name</th>
                                            <th>Position</th>
                                            <th>Published</th>
                                            <th>Added On</th>                                            
                                            <th>Updated On</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="stateList">
                                    

                                    <tr>
                                    <td colspan="10"> <div class="clearfix text-center" >
                                <img  src="<? echo MAINSITE."assets/administrator/dist/images/load.gif"; ?>" />
                                </div></td>
                                    </tr>
                                   
                                   
                                    </tbody>
                                  <?php /*?><tfoot>
                                        <tr>
                                            <th width="3%"></th>
                                            <th width="3%"></th>
                                           <th>Name</th>
                                            <th>Attribute Name</th>
                                            <th>Published</th>
                                            <th>Added On</th>                                            
                                            <th>Updated On</th>
                                            <th></th>
                                        </tr>
                                    </tfoot><?php */?>
                                </table>
</div>
                    
                    
                    <? }else{ 
						$this->data['no_access_flash_message']="You Dont Have Access To View ".$page_module_name;
						$this->load->view('admin/template/access_denied' , $this->data); 
					} ?>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>


    </section>
    <?  ?>
</div>

<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<script src="<? echo MAINSITE ?>assets/administrator/js/jquery.tablednd.js" type="text/javascript"></script>


<script>    
                                
 
   
   function dragEvent()
   {
	 table_2 = $("#table-2");
        table_2.find("tr:even").addClass("alt");
		
		
		$("#table-2").tableDnD({
	    onDragClass: "myDragClass",
			onDrop: function(table, row) {
				var rows = table.tBodies[0].rows;
					var podId = '';
				for (var i=0; i<rows.length; i++) {
				podId+= rows[i].id+",";
				}
			
				$('#stateList').html('<tr><td colspan="10"> <div class="clearfix text-center" ><img  src="<? echo MAINSITE."assets/administrator/dist/images/load.gif"; ?>" /></div></td></tr>');
				$.ajax({
			   type: "POST",
			
				url:'<? echo MAINSITE_Admin ?>catalog/Product-Attribute-Module/GetCompleteAttributeValueListNewPos',
			   //dataType : "json", 
			   //data : {"product_attribute_id" : '<? echo $product_attribute_id; ?>' , 'podId':podId},
			   data : {"product_attribute_id" : '<? echo $product_attribute_id; ?>' , 'podId':podId , "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},
			   success : function(result){
				   alert(result);
					$('#stateList').html(result);
					$(table).parent().find('.result').text("Order Changed Successfully");
					dragEvent();
					}
			   });
				
			},
		onDragStart: function(table, row) {
			$(table).parent().find('.result').text("Started dragging row id "+row.id);
			
		},

	});
		  
   }
   
   
</script>
