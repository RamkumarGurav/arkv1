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
						<li class="breadcrumb-item active">Profile</li>
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
					<? 
					if(empty($employee_data->username))
					{
						echo '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> You Have Not Set The User Name  </div>';
					}
					
					echo $this->session->flashdata('alert_message');
					if(!empty($profile_alert_massage)){echo $profile_alert_massage;}
					?>
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Tabs</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link <? if($tab_type=='profile'){echo "active";} ?> " href="#tab_profile" data-toggle="tab">Profile</a></li>
                  <li class="nav-item"><a class="nav-link <? if($tab_type=='password'){echo "active";} ?> " href="#tab_password" data-toggle="tab">Change Password</a></li>
                  <li class="nav-item"><a class="nav-link <? if($tab_type=='user_name'){echo "active";} ?>" href="#tab_user_name" data-toggle="tab">User Name</a></li>
                  <? /* ?><li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                      Dropdown <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" tabindex="-1" href="#">Action</a>
                      <a class="dropdown-item" tabindex="-1" href="#">Another action</a>
                      <a class="dropdown-item" tabindex="-1" href="#">Something else here</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" tabindex="-1" href="#">Separated link</a>
                    </div>
                  </li><? */ ?>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane <? if($tab_type=='profile'){echo "active";} ?>" id="tab_profile">
				  		<table id="" class="table table-bordered table-hover myviewtable responsiveTableNewDesign">
                                <tbody>
									<tr>
										<td>
                                        <strong class="full">Role</strong>
										    <?
										    if(count($employee_data->roles)>1 )
										    {
										        ?>
										        <table id="" class="table table-bordered table-hover">
										            <tbody>
    										            <tr>
                    										<th >#</th>
                    										<th >Company Name</th>
                    										<th >Role</th>
                    									</tr>
                    									<? $r_count=0;foreach($employee_data->roles as $r){$r_count++; ?>
                    									<tr>
                    										<td ><?=$r_count?></td>
                    										<td ><?=$r->user_role_name?></td>
                    										<td ><?=$r->company_unique_name?></td>
                    									</tr>
                    									<? } ?>
                									</tbody>
										        </table>
										        <?
										        
										    }
										    else{
										        echo $employee_data->roles[0]->user_role_name;
										    
										    }
										    ?>
										    
										    </td>
										<td>
										<strong class="full">Designation</strong>
										<?=$employee_data->designation_name?></td>
										<td>
										<strong class="full">Employee Name</strong>
										<?=$employee_data->name?></td>
										<td>
										<strong class="full">Email Id</strong>
										<?=$employee_data->email?></td>
										<td>
										<strong class="full">Mobile No</strong>
										<?=$employee_data->mobile_no?></td>
									</tr>
									
									<tr>
                                    	<td rowspan="2" colspan="2">
										<strong class="full">Address</strong>
										<? echo $employee_data->address1;
											if(!empty($employee_data->address1)){echo "<br>".$employee_data->address2;}
											if(!empty($employee_data->address3)){echo "<br>".$employee_data->address3;}
											echo "<br>".$employee_data->city_name." ($employee_data->pincode) ";
											echo "<br>".$employee_data->state_name;
											echo "<br>".$employee_data->country_name." ($employee_data->dial_code) ";
										?></td>
										<td>
										<strong class="full">Alt Mobile No</strong>
										<?=$employee_data->alt_mobile_no?></td>
										
										<td>
										<strong class="full">Country</strong>
										<?=$employee_data->country_name?></td>
                                        
										<td>
										<strong class="full">Data View</strong>
										<? if($employee_data->data_view==1){ ?> Yes <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> No <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?></td>
									</tr>
<tr>
                                    <td >
										<strong class="full">Joining Date</strong>
										<? if(!empty($employee_data->joining_data)){echo date("d-m-Y" , strtotime($employee_data->joining_data));}else{echo "-";}?></td>
										<td >
										<strong  class="full">Termination By</strong>
										<? if(!empty($employee_data->termination_date) && $employee_data->termination_date != '0000-00-00' && $employee_data->termination_date != '01-01-1970' && $employee_data->termination_date != '1970-01-01'){echo date("d-m-Y" , strtotime($employee_data->termination_date));}else{echo "-";}?></td>
										<td colspan="3">
										<strong class="full">Files</strong>
										<? if(!empty($employee_data->files)){ ?>
                                        <ol>
                                        <? foreach($employee_data->files as $f){ ?>
                                        <li><?=$f->file_title?>  &nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="<?=base_url().'assets/employee_file/'.$f->file_name?>">View</a></li>
                                        <? } ?>
                                        </ol>
                                        
                                                <? }else{ ?>-<? } ?></td>
									</tr>
									<tr>
										<td>
										<strong class="full">Data View</strong>
										<? if($employee_data->approval_access==1){ ?> Yes <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> No <i class="fas fa-ban btn-danger btn-sm "></i> 
                                                <? }?></td>
										<td>
										<strong class="full">Last Login IP</strong>
										<?=$employee_data->last_loginip?></td>
                                        
                                    
										<td>
										<strong class="full">Last Login On</strong>
										<? if(!empty($employee_data->last_login)){echo date("d-m-Y h:i:s A" , strtotime($employee_data->last_login));}else{echo "-";}?></td>
									</tr>
									
									<tr>
										<td>
										<strong class="full">Added On</strong>
										<?=date("d-m-Y h:i:s A" , strtotime($employee_data->added_on))?></td>
										<td>
										<strong  class="full">Added By</strong>
										<?=$employee_data->added_by_name?></td>
										<td>
										<strong class="full">Updated On</strong>
										<? if(!empty($employee_data->updated_on)){echo date("d-m-Y h:i:s A" , strtotime($employee_data->updated_on));}else{echo "-";}?></td>
										<td>
										<strong class="full">Updated By</strong>
										<? if(!empty($employee_data->updated_by_name)){echo $employee_data->updated_by_name;}else{echo "-";}?></td>
										<td>
										<strong class="full">Status</strong>
										<? if($employee_data->status==1){ ?> Active <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> Block <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?></td>
									</tr>
                                    
                                </tbody>
                                
						</table>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane <? if($tab_type=='password'){echo "active";} ?>" id="tab_password">
				  		
                        <?php echo form_open(MAINSITE_Admin."wam/view-profile", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            
							<input type="hidden" name="tab_type" id="tab_type" value="password" />
							
                            	<div class="form-group row">
								<div class="col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Old Password <span class="text-danger sup">*</span></label>
									<div class="col-sm-12">
									<input type="password" class="form-control form-control-sm" required id="old_password" name="old_password"  placeholder="Old Password">
									</div>
								</div>
								
								<div class="col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">New Password <span class="text-danger sup">*</span></label>
									<div class="col-sm-12">
									<input type="password" class="form-control form-control-sm" required id="new_password" name="new_password"  placeholder="New Password">
									</div>
								</div>

								<div class="col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Re Enter Password <span class="text-danger sup">*</span></label>
									<div class="col-sm-12">
									<input type="password" class="form-control form-control-sm" required id="re_new_password" name="re_new_password"  placeholder="Re Enter Password">
									
									</div>
								</div>
								
								</div>
								<!-- /.card-body -->
								<div class="card-footer">
									<center>
									<button type="submit" name="update_password_button" value="1" class="btn btn-info">Update</button>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</center>
								</div>
								<!-- /.card-footer -->
						
                        
                        <?php echo form_close() ?>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane <? if($tab_type=='user_name'){echo "active";} ?>" id="tab_user_name">
				 <?php echo form_open(MAINSITE_Admin."wam/view-profile", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
							<input type="hidden" name="tab_type" id="tab_type" value="user_name" />
							
                            	<div class="form-group row">
								<div class="col-sm-4 offset-2 row">
									<label for="inputEmail3" class="col-sm-5 label_content text-right mt-2">User Name <span class="text-danger sup">*</span></label>
									<div class="col-sm-6">
									<input type="text" class="form-control form-control-sm" required id="user_name" name="user_name"  placeholder="User Name">
									</div>
								</div>

								<div class="col-sm-4 row">
									<label for="inputEmail3" class="col-sm-4 label_content text-right mt-2">Password 
									<span class="text-danger sup">*</span></label>
									<div class="col-sm-6">
									<input type="password" class="form-control form-control-sm" required id="password" name="password"  placeholder="Password">
									</div>
								</div>
								
								</div>
								<!-- /.card-body -->
								<div class="card-footer">
									<center>
									<button type="submit" name="update_username_button" value="1" class="btn btn-info">Update</button>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</center>
								</div>
								<!-- /.card-footer -->
						
                        
                        <?php echo form_close() ?>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
           </div>
       </div>


    </section>
    <?  ?>
</div>

<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>


