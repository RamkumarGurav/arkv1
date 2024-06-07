<?php
$page_module_name = "Client Group";
?>
<?
$group_name=$group_description="";
$group_id=$minimum_order_value=0;
$category_id=0;
$status=1;
$record_action = "Add New Record";
$client_group_category_data = array();
if(!empty($client_group_data))
{
	$record_action = "Update";
	$group_id = $client_group_data->group_id;
	$group_name = $client_group_data->group_name;
	$group_description = $client_group_data->group_description;
	$minimum_order_value = $client_group_data->minimum_order_value;
	$status = $client_group_data->status;
	$client_group_category_data = $client_group_data->client_group_category_data;
}
?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?=$page_module_name?> </small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin."wam"?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name?>"><?=$user_access->module_name?> List</a></li>
						<? if(!empty($client_group_data)){ ?>
						<li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/city_view/".$group_id?>">View</a></li>
						<? } ?>
						<li class="breadcrumb-item"><?=$record_action?></li>
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
                        <h3 class="card-title"><?=$group_name?> <small><?=$record_action?></small></h3>
                    </div>
                    <!-- /.card-header -->
                    <?php 
						if($user_access->view_module==1 || true)	{
					?>
					<? echo $this->session->flashdata('alert_message'); ?>
                    <div class="card-body">
                    <?php echo form_open(MAINSITE_Admin."$user_access->class_name/doEdit", array('method' => 'post', 'id' => '' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form')); ?>
							<input type="hidden" name="group_id" id="group_id" value="<?=$group_id?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="" />
							
                            	<div class="form-group row">
								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Client Group Name <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-10">
														<input type="text" class="form-control form-control-sm" required id="group_name" name="group_name" value="<?=$group_name?>" placeholder="Client Group Name">				
									</div>
								</div>

								

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Client Group Description <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" required id="group_description" name="group_description" value="<?=$group_description?>" placeholder="Client Group Description">
							
									</div>
								</div>
                                
                                <div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Minimum order Value<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" required id="minimum_order_value" name="minimum_order_value" value="<?=$minimum_order_value?>" placeholder="Minimum Order Value">
							
									</div>
								</div>
								
                                </div>
                                
                                <div class="form-group row">
								
								<div class="col-lg-12 col-md-4 col-sm-6">
									<label for="radioSuccess1" class="col-sm-12 label_content px-2 py-0">Category</label>
									<div class="col-md-10">
                                    <? if(!empty($client_group_category_data)){ ?>
                                   
                                    <? foreach($client_group_category_data as $dgd){ ?>
                                    
										<div class="form-group clearfix">
                                            <div class="row">
                                            <div class="col-md-4">
                                            <label for="radioSuccess1" <? if($dgd->status != 1){ ?> style="color:#F00" <? } ?>> <?=$dgd->category_name?></label>
                                            </div>
                                            <div class="col-md-6">
                                            <input type="hidden" name="category_id[]" class="form-control" value="<?=$dgd->category_id?>" >
                                             <input type="number" min="0" max="99" name="category_disc_mrp[]" value="<?=$dgd->category_disc_mrp?>" class="form-control" step="any" >
                                            </div>
                                           
                                            </div>
										</div>
                                    <? } ?>  
                                    <? } else if(!empty($category_data)){ ?>   
                                    
                                    <? foreach($category_data as $dgd){ ?>
                                    
										<div class="form-group clearfix">
                                            <div class="row">
                                            <div class="col-md-6">
                                            <label for="radioSuccess1"> <?=$dgd->name?></label>
                                            </div>
                                            <div class="col-md-6">
                                            <input type="hidden" name="category_id[]" class="form-control" value="<?=$dgd->category_id?>" >
                                            <input type="number" value="0" min="0" max="99" name="category_disc_mrp[]" class="form-control" step="any" >
                                            </div>
                                            </div>
										</div>
                                    <? } ?>
                                    <? } ?>
									</div>
								</div>
								</div>
                                
                                
                                <div class="form-group row">
								
								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="radioSuccess1" class="col-sm-12 label_content px-2 py-0">Status</label>
									<div class="col-sm-10">
									<div class="form-check" style="margin-top:12px">
										<div class="form-group clearfix">
											<div class="icheck-success d-inline">
												<input type="radio" name="status" <? if($status==1){echo "checked"; }?> value="1" id="radioSuccess1">
												<label for="radioSuccess1"> Active
												</label>
											</div>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<div class="icheck-danger d-inline">
												<input type="radio" name="status" <? if($status!=1){echo "checked"; }?> value="0" id="radioSuccess2">
												<label for="radioSuccess2"> Block
												</label>
											</div>
										</div>
									</div>
									</div>
								</div>
								</div>
								<!-- /.card-body -->
								<div class="card-footer">
									<center>
									<button type="submit" name="save" onclick="return redirect_type_func('')" value="1" class="btn btn-info">Save</button>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="submit" name="save-add-new" onclick="return redirect_type_func('save-add-new')" value="1" class="btn btn-default ">Save And Add New</button>
									</center>
								</div>
								<!-- /.card-footer -->
						
                         <?php echo form_close() ?>
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
<script>
	function redirect_type_func(data)
	{
		document.getElementById("redirect_type").value = data;
		return true;
	}
</script>