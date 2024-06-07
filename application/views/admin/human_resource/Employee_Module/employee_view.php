<?php

$page_module_name = "Employee";

?>
<?
$name="";
$admin_user_id=0;
$status=1;
$record_action = "Add New Record";
if(!empty($employee_data))
{
	// $record_action = "Update";
	// $admin_user_id = $employee_data->admin_user_id;
	// $name = $employee_data->name;
	// $status = $employee_data->status;
	
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

                <div class="card ">

                    <div class="card-header">
                        <h3 class="card-title"><?=$employee_data->name?></h3>
                        <div class="float-right">
                            <?php 
								if($user_access->add_module==1 && false)	{
								?>
								<a href="<?=MAINSITE_Admin.$user_access->class_name?>/employee-edit"> 
                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                                New</button></a>
                            <? } ?>
                            <?php 
							if($user_access->update_module==1)	{
							?>
							<a href="<?=MAINSITE_Admin.$user_access->class_name?>/employee-edit/<?=$employee_data->admin_user_id?>"> 
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
                    <div class="card-body card-primary card-outline">
                            <?php echo form_open(MAINSITE_Admin."$user_access->class_name/userRole-doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            
                            <input type="hidden" name="task" id="task" value="" />
                            <? echo $this->session->flashdata('alert_message'); ?>
                            <div class="divTable" style="display:none;">
                            	<div class="TableRow">
                                	<div class="table_col">
                                        <label class="label_content_br">Data Base Id <span class="colen">:</span></label>
                                        <?=$employee_data->admin_user_id?>
                                    </div>
                                    <div class="table_col table_wrap">
                                        <label class="label_content_br">Role  <span class="colen">:</span></label>
                                       <? if(count($employee_data->roles) >1){ ?>
                                       		
											<table class="table table-hover" style="width:90%">
											<thead>
												<tr>
												<th style="width: 10px">#</th>
												<th>Company</th>
												<th>Role </th>
												</tr>
											</thead>
											<tbody>
											<? $c_count=0;foreach($employee_data->roles as $role){$c_count++; ?>
												<tr>
												<td><?=$c_count?>.</td>
												<td><?=$role->company_unique_name?></td>
												<td><?=$role->user_role_name?></td>
												</tr>
											<? } ?>
											</tbody>
											</table>
											<? }else{ $role = $employee_data->roles[0]; ?>
												<?=$role->user_role_name?>
											<? } ?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Designation<span class="colen">:</span></label>
                                       <?=$employee_data->designation_name?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Employee Name<span class="colen">:</span></label>
                                        <?=$employee_data->name?>
                                    </div>
                                    <div class="table_col" >
                                        <label class="label_content_br">Password <span class="colen">:</span></label>
                                        <?=$employee_data->show_password?>
                                    </div>                                	
                                    <div class="table_col">
                                    <label class="label_content_br">Email Id<span class="colen">:</span></label>
                                   <?=$employee_data->email?>
                                    </div>
                                </div>                                 
                            	<div class="TableRow">
                                	<div class="table_col">
                                        <label class="label_content_br">Address<span class="colen">:</span></label>
                                        <? echo $employee_data->address1;
											if(!empty($employee_data->address1)){echo ", ".$employee_data->address2;}
											if(!empty($employee_data->address3)){echo ", ".$employee_data->address3;}
											echo ", ".$employee_data->city_name." ($employee_data->pincode) ";
											echo ", ".$employee_data->state_name;
											echo ", ".$employee_data->country_name." ($employee_data->dial_code) ";
										?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Mobile No<span class="colen">:</span></label>
                                        <?=$employee_data->mobile_no?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Alt Mobile No<span class="colen">:</span></label>
                                        <?=$employee_data->alt_mobile_no?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Fax No<span class="colen">:</span></label>
                                        <?=$employee_data->fax_no?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Country<span class="colen">:</span></label>
                                        <?=$employee_data->country_name?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Data View<span class="colen">:</span></label>
                                        <? if($employee_data->data_view==1){ ?> Yes <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> No <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?>
                                    </div> 
                                </div>                                  
                            	<div class="TableRow">
                                	
                                    <div class="table_col">
                                        <label class="label_content_br">Last Login IP<span class="colen">:</span></label>
                                        <?=$employee_data->last_loginip?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Last Login On<span class="colen">:</span></label>
                                        <? if(!empty($employee_data->last_login)){echo date("d-m-Y h:i:s A" , strtotime($employee_data->last_login));}else{echo "-";}?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Added On<span class="colen">:</span></label>
                                        <?=date("d-m-Y h:i:s A" , strtotime($employee_data->added_on))?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Added By<span class="colen">:</span></label>
                                        <?=$employee_data->added_by_name?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Updated On<span class="colen">:</span></label>
                                        <? if(!empty($employee_data->updated_on)){echo date("d-m-Y h:i:s A" , strtotime($employee_data->updated_on));}else{echo "-";}?>
                                    </div>
                                </div>                           
                            	<div class="TableRow">
                                	<div class="table_col">
                                        <label class="label_content_br">Updated By<span class="colen">:</span></label>
                                        <? if(!empty($employee_data->updated_by_name)){echo $employee_data->updated_by_name;}else{echo "-";}?>
                                    </div>
                                	<div class="table_col">
                                        <label class="label_content_br">Status<span class="colen">:</span></label>
                                        <? if($employee_data->status==1){ ?> Active <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> Block <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?>
                                    </div>
                               </div>                            
                            </div>
                            
                            <table id="" class="table table-bordered table-hover myviewtable responsiveTableNewDesign"  >
                                <tbody>
								<tr>
										<td >
										<strong class="full">Data Base Id</strong>
										<?=$employee_data->admin_user_id?></td>
										<td >
                                        	<strong class="full">Role</strong>
										<? if(count($employee_data->roles) >1){ ?>
											<table class="table table-hover text-nowrap" style="width:90%">
											<thead>
												<tr>
												<th style="width: 10px">#</th>
												<th>Company</th>
												<th>Role </th>
												</tr>
											</thead>
											<tbody>
											<? $c_count=0;foreach($employee_data->roles as $role){$c_count++; ?>
												<tr>
												<td><?=$c_count?>.</td>
												<td><?=$role->company_unique_name?></td>
												<td><?=$role->user_role_name?></td>
												</tr>
											<? } ?>
											</tbody>
											</table>
											<? }else{ $role = $employee_data->roles[0]; ?>
												<?=$role->user_role_name?>
											<? } ?>
										</td>
										<td >
										<strong class="full">Designation</strong>
										<?=$employee_data->designation_name?></td>
                                          <td >
                                        <strong class="full">Joining Date1</strong>
                                        <? if(!empty($employee_data->joining_date)){echo date("d-m-Y" , strtotime($employee_data->joining_date));}else{echo "-";}?></td>
                                        <td >
                                        <strong  class="full">Termination By</strong>
                                        <? if(!empty($employee_data->termination_date) && $employee_data->termination_date != '0000-00-00' && $employee_data->termination_date != '01-01-1970' && $employee_data->termination_date != '1970-01-01'){echo date("d-m-Y" , strtotime($employee_data->termination_date));}else{echo "-";}?></td>

										
									</tr>

									<tr>
                                        <td >
                                        <strong class="full">Employee Name</strong>
                                        <?=$employee_data->name?></td>
                                        <td >
                                        <strong class="full">Password</strong>
                                        <?=$employee_data->show_password?></td>
                                        <td >
                                        <strong class="full">Email Id</strong>
                                        <?=$employee_data->email?></td>
                                    	<td colspan="4">
										<strong class="full">Address</strong>
										<? echo $employee_data->address1;
											if(!empty($employee_data->address1)){echo ", ".$employee_data->address2;}
											if(!empty($employee_data->address3)){echo ", ".$employee_data->address3;}
											echo ", ".$employee_data->city_name." ($employee_data->pincode) ";
											echo ", ".$employee_data->state_name;
											echo ", ".$employee_data->country_name." ($employee_data->dial_code) ";
										?></td>
										
                                       
									</tr>
                                    <tr>
                                        <td >
                                        <strong class="full">Country</strong>
                                        <?=$employee_data->country_name?></td>
                                        <td >
                                        <strong class="full">Mobile No</strong>
                                         <?=$employee_data->mobile_no?></td>
                                        <td >
                                        <strong class="full">Alt Mobile No</strong>
                                        <?=$employee_data->alt_mobile_no?></td>
                                        <td >
                                        <strong class="full">Fax No</strong>
                                        <?=$employee_data->fax_no?></td>
                                        
                                        
                                        <strong class="full">Data View</strong>
                                        <? if($employee_data->data_view==1){ ?> Yes <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> No <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?></td>
                                                <td >
                                        <strong class="full">Files</strong>
                                        <? if(!empty($employee_data->files)){ ?>
                                        <ol>
                                        <? foreach($employee_data->files as $f){ ?>
                                        <li><?=$f->file_title?>  &nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="<?=_uploaded_files_.'employee_file/'.$f->file_name?>">View</a></li>
                                        <? } ?>
                                        </ol>
                                        
                                                <? }else{ ?>-<? } ?></td>
                                    </tr>
									<tr>
										
										<td >
										<strong class="full">Last Login IP</strong>
										<?=$employee_data->last_loginip?></td>
										<td >
										<strong class="full">Last Login On</strong>
										<? if(!empty($employee_data->last_login)){echo date("d-m-Y h:i:s A" , strtotime($employee_data->last_login));}else{echo "-";}?></td>
										<td >
										<strong class="full">Added On</strong>
										<?=date("d-m-Y h:i:s A" , strtotime($employee_data->added_on))?></td>
										<td >
										<strong class="full">Added By</strong>
										<?=$employee_data->added_by_name?></td>
										
									</tr>
									
									
                                    
                                    <tr>
                                    <td >
										<strong class="full">Updated On</strong>
										<? if(!empty($employee_data->updated_on)){echo date("d-m-Y h:i:s A" , strtotime($employee_data->updated_on));}else{echo "-";}?></td>
										<td >
										<strong  class="full">Updated By</strong>
										<? if(!empty($employee_data->updated_by_name)){echo $employee_data->updated_by_name;}else{echo "-";}?></td>
										<td colspan="3">
										<strong class="full">Status</strong>
										<? if($employee_data->status==1){ ?> Active <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> Block <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?></td>
									</tr>
                                    
                                </tbody>
                                
						</table>
						<?php echo form_close() ?>
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

<script type="application/javascript">
function check_uncheck_All_records() // done
{
    var mainCheckBoxObj = document.getElementById("main_check");
    var checkBoxObj = document.getElementsByName("sel_recds[]");

    for (var i = 0; i < checkBoxObj.length; i++) {
        if (mainCheckBoxObj.checked)
            checkBoxObj[i].checked = true;
        else
            checkBoxObj[i].checked = false;
    }
}

function validateCheckedRecordsArray() // done
{
    var checkBoxObj = document.getElementsByName("sel_recds[]");
    var count = true;

    for (var i = 0; i < checkBoxObj.length; i++) {
        if (checkBoxObj[i].checked) {
            count = false;
            break;
        }
    }

    return count;
}

function validateRecordsActivate() // done
{
    if (validateCheckedRecordsArray()) {
        //alert("Please select any record to activate.");
        toastrDefaultErrorFunc("Please select any record to activate.");
        document.getElementById("sel_recds1").focus();
        return false;
    } else {
        document.ptype_list_form.task.value = 'active';
        document.ptype_list_form.submit();
    }
}

function validateRecordsBlock() // done
{
    if (validateCheckedRecordsArray()) {
        //alert("Please select any record to block.");
        toastrDefaultErrorFunc("Please select any record to block.");
        document.getElementById("sel_recds1").focus();
        return false;
    } else {
        document.ptype_list_form.task.value = 'block';
        document.ptype_list_form.submit();
    }
}
</script>
