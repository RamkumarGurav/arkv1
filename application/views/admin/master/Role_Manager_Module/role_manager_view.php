<?php

$page_module_name = "Role Master";

?>
<?
$user_role_name="";
$user_role_id=0;
$status=1;
$record_action = "Add New Record";
if(!empty($users_role_master_data))
{
	// $record_action = "Update";
	// $user_role_id = $users_role_master_data->user_role_id;
	// $user_role_name = $users_role_master_data->user_role_name;
	// $status = $users_role_master_data->status;
	
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

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title"><?=$users_role_master_data->user_role_name?></h3>
                        <div class="float-right">
                            <?php 
								if($user_access->add_module==1 && false)	{
								?>
								<a href="<?=MAINSITE_Admin.$user_access->class_name?>/role-manager-edit"> 
                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                                New</button></a>
                            <? } ?>
                            <?php 
							if($user_access->update_module==1)	{
							?>
							<a href="<?=MAINSITE_Admin.$user_access->class_name?>/role-manager-edit/<?=$users_role_master_data->user_role_id?>"> 
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
                        
         <?php echo form_open(MAINSITE_Admin."$user_access->class_name/userRole-doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            
                            <input type="hidden" name="task" id="task" value="" />
                            <? echo $this->session->flashdata('alert_message'); ?>
                            

							<div class="form-group row table-responsive">
									<table id="" class="table table-bordered table-hover " style="font-size:medium" >
										<thead>
											<tr>
												<th>#</th>
												<th>Role</th>
												<th>All</th>
												<th>View</th>
												<th>Add</th>
												<th>Update</th>
												<? /* ?><th>Delete</th>
												<th>Approval</th><? */ ?>
												<th>Import</th>
												<th>Export</th>
											</tr>
										</thead>
										<tbody >
											<? 
											$count=0;
												
												foreach($module_data as $md) 
												{ 
													$count++;
											?>

											<?
											$all_checked = $view_checked = $add_checked = $update_checked = $delete_checked = $approval_checked = $import_checked = $export_checked ='<button type="button" class="btn btn-sm btn-block btn-danger">No</button>'; 
											if(!empty($module_permission_data)){
												foreach($module_permission_data as $mpd)
												{
													if($md->module_id == $mpd->module_id)
													{
														if(!empty($mpd->view_module))
														{ $view_checked = '<button type="button" class="btn btn-sm btn-block btn-success">Yes</button> ';		 $all_checked = 'checked';}

														if(!empty($mpd->add_module))
														{ $add_checked = '<button type="button" class="btn btn-sm btn-block btn-success">Yes</button>';			 $all_checked = 'checked';}
									
														if(!empty($mpd->update_module))
														{ $update_checked = '<button type="button" class="btn btn-sm btn-block btn-success">Yes</button>';		 $all_checked = 'checked';}
									
														if(!empty($mpd->delete_module))
														{ $delete_checked = '<button type="button" class="btn btn-sm btn-block btn-success">Yes</button>';		 $all_checked = 'checked';}
									
														if(!empty($mpd->approval_module	))
														{ $approval_checked = '<button type="button" class="btn btn-sm btn-block btn-success">Yes</button>';	 $all_checked = 'checked';}
									
														if(!empty($mpd->import_data))
														{ $import_checked = '<button type="button" class="btn btn-sm btn-block btn-success">Yes</button>';		 $all_checked = 'checked';}
									
														if(!empty($mpd->export_data))
														{ $export_checked = '<button type="button" class="btn btn-sm btn-block btn-success">Yes</button>';		 $all_checked = 'checked';}
													}
								
												}
											}
											
											if($all_checked == 'checked')
											{
												$all_checked = '<button type="button" class="btn btn-sm btn-block btn-success">Yes</button>';
											}


											?>


											<tr>
												<td><?=$count?>.</td>
												<td><?=$md->module_name?> [ <?=$master_name[$md->is_master]?> ]</td>
												<td >
													<?=$all_checked?> 
												</td>
												<td>
													<?=$view_checked?> 
												</td>
												<td>
													<?=$add_checked?>
												</td>
												<td>
													<?=$update_checked?>
												</td>
												<? /* ?><td>
													<?=$delete_checked?>
												</td>
												<td>
													<?=$approval_checked?>
												</td><? */ ?>
												<td>
													<?=$import_checked?>
												</td>
												<td>
													<?=$export_checked?>
												</td>
											</tr>
												<? } ?>
										</tbody>
									</table>
								</div>
                                
                                <div class="row">
                                <table id="" class="table table-bordered table-hover myviewtable responsiveTableNewDesign">
                                    
                                    <tbody>
                                        
                                    <tr>
                                            <td>
                                            <strong class="full">Data Base Id</strong>
                                            <?=$users_role_master_data->user_role_id?></td>
                                            <td>
                                            <strong class="full">User Role Name</strong>
                                            <?=$users_role_master_data->user_role_name?></td>
                                            <td>
                                            <strong class="full">Added On</strong>
                                            <?=date("d-m-Y h:i:s A" , strtotime($users_role_master_data->added_on))?></td>
                                            <td class="full">
                                            <strong class="full">Added By</strong>
                                            <?=$users_role_master_data->added_by_name?></td>
                                            <td>
                                            <strong class="full">Updated On</strong>
                                            <? if(!empty($users_role_master_data->updated_on)){echo date("d-m-Y h:i:s A" , strtotime($users_role_master_data->updated_on));}else{echo "-";}?></td>
                                            <td>
                                            <strong class="full">Updated By</strong>
                                            <? if(!empty($users_role_master_data->updated_by_name)){echo $users_role_master_data->updated_by_name;}else{echo "-";}?></td>
                                            <td >
                                            <strong  class="full">Status</strong>
                                            <? if($users_role_master_data->status==1){ ?> Active <i class="fas fa-check btn-success btn-sm "></i>
                                                    <?}else{ ?> Block <i class="fas fa-ban btn-danger btn-sm "></i> Block
                                                    <? }?></td>
                                        </tr>
                                        
                                    </tbody>
                                    
                                </table>
                            </div>
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
