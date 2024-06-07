<?php
$page_module_name = "Terms and Conditions";
?>
<?
$terms_and_conditions_name="";
$terms_and_conditions_id=0;
$status=1;
$record_action = "Add New Record";
if(!empty($terms_and_conditions_master_data))
{
	$record_action = "Update";
	$terms_and_conditions_id = $terms_and_conditions_master_data->terms_and_conditions_id;
	$terms_and_conditions_name = $terms_and_conditions_master_data->terms_and_conditions_name;
	$status = $terms_and_conditions_master_data->status;
	
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
                    <h1 class="m-0 text-dark"><small><?=$page_module_name?> </small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin."wam"?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name?>"><?=$user_access->module_name?> List</a></li>
						<? if(!empty($terms_and_conditions_master_data)){ ?>
						<li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/terms_and_conditions_view/".$terms_and_conditions_id?>">View</a></li>
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
                        <h3 class="card-title"><?=$terms_and_conditions_name?> <small><?=$record_action?></small></h3>
                    </div>
                    <!-- /.card-header -->
                    <?php 
						if($user_access->view_module==1 || true)	{
					?>
					<? echo $this->session->flashdata('alert_message'); ?>
                    <div class="card-body">
                        
                            
                            <?php echo form_open(MAINSITE_Admin."$user_access->class_name/userTermsandConditionsDoEdit", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form')); ?>
                            
							<input type="hidden" name="terms_and_conditions_id" id="terms_and_conditions_id" value="<?=$terms_and_conditions_id?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="" />
							
                            	<div class="row">
								<div class="form-group col-md-6 row">
									<label for="inputEmail3" class="col-sm-4 label_content text-right mt-2">Terms and Conditions </label>
									<div class="col-sm-6">
									<input type="text" class="form-control form-control-sm" required id="terms_and_conditions_name" name="terms_and_conditions_name" value="<?=$terms_and_conditions_name?>" placeholder="Terms and Conditions">
									<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span>
									</div>
								</div>
								<div class="form-group col-md-6 row">
									<label for="radioSuccess1" class="col-sm-4 label_content text-right mt-2">Status</label>
									<div class="col-sm-6">
									<div class="form-check" >
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

