<?php
$page_module_name = "State";
?>
<?
$state_name="";
$state_code="";
$state_id=0;
$country_id=0;

$status=1;
$is_display=1;
$record_action = "Add New Record";
if(!empty($state_data))
{
	$record_action = "Update";
	$state_id = $state_data->state_id;
	$state_name = $state_data->state_name;
	$state_code = $state_data->state_code;
	$status = $state_data->status;
	$country_id = $state_data->country_id;
	$is_display = $state_data->is_display;
	
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
						<? if(!empty($state_data)){ ?>
						<li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/state_view/".$state_id?>">View</a></li>
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
                        <h3 class="card-title"><?=$state_name?> <small><?=$record_action?></small></h3>
                    </div>
                    <!-- /.card-header -->
                    <?php 
						if($user_access->view_module==1 || true)	{
					?>
					<? echo $this->session->flashdata('alert_message'); ?>
                    <div class="card-body">
                        
                            <?php echo form_open(MAINSITE_Admin."$user_access->class_name/userStateDoEdit", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
							<input type="hidden" name="state_id" id="state_id" value="<?=$state_id?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="" />
							
                            	<div class="form-group row">
								<div class="col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Country 
									<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-10">
									<select type="text" class="form-control form-control-sm" required id="country_id" name="country_id" >
										<option value="">Select Country</option>
										<? foreach($country_data as $cd){
											$selected="";
											if($cd->country_id == $country_id){$selected = "selected";}
											?>
											<option value="<?=$cd->country_id?>" <?=$selected?>><?=$cd->country_name?>
											<? if($cd->status!=1){echo " [Block]";} ?>
											</option>
										<? } ?>
									</select>
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">State 
									<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" required id="state_name" name="state_name" value="<?=$state_name?>" placeholder="State">
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">State Code 
									<span style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm"  id="state_code" name="state_code" value="<?=$state_code?>" placeholder="State Code">
									</div>
								</div>
                                </div>
                                <div class="form-group row">
								<div class="col-md-4 col-sm-6">
									<label for="radioSuccess1" class="col-sm-12 label_content px-2 py-0">Is Display?</label>
									<div class="col-sm-10">
									<div class="form-check" style="margin-top:12px">
										<div class="form-group clearfix">
											<div class="icheck-success d-inline">
												<input type="radio" name="is_display" <? if($is_display==1){echo "checked"; }?> value="1" id="is_displaySuccess1">
												<label for="is_displaySuccess1"> Yes
												</label>
											</div>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<div class="icheck-danger d-inline">
												<input type="radio" name="is_display" <? if($is_display!=1){echo "checked"; }?> value="0" id="is_displaySuccess2">
												<label for="is_displaySuccess2"> No
												</label>
											</div>
										</div>
									</div>
									</div>
								</div>

								<div class="col-md-4 col-sm-6">
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

