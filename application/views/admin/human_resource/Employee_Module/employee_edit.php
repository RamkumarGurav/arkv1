<?php
$page_module_name = "Employee";
?>
<?
//$joining_date;
$joining_date_input=date('d-m-Y');
$termination_date_input='';
$fax_no=$show_password=$mobile_no=$alt_mobile_no=$name=$first_name=$last_name=$address1=$address2=$address3=$email=$pincode="";
$admin_user_id=0;
$country_id=0;
$state_id=0;
$city_id=0;
$user_role_id=0;
$designation_id=0;
$data_view=$approval_access=0;
$status=1;
$record_action = "Add New Record";
$selected_user_role = array();
$selected_company = array();
if(!empty($employee_data))
{
	$record_action = "Update";
	$admin_user_id = $employee_data->admin_user_id;
	$name = $employee_data->name;
	$first_name = $employee_data->first_name;
	$last_name = $employee_data->last_name;
	$address1 = $employee_data->address1;
	$address3 = $employee_data->address3;
	$name = $employee_data->name;
	$status = $employee_data->status;
	$country_id = $employee_data->country_id;
	$state_id = $employee_data->state_id;
	$city_id = $employee_data->city_id;
	$user_role_id = $employee_data->user_role_id;
	$designation_id = $employee_data->designation_id;
	$mobile_no = $employee_data->mobile_no;
	$alt_mobile_no = $employee_data->alt_mobile_no;
	$email = $employee_data->email;
	$pincode = $employee_data->pincode;
	$data_view = $employee_data->data_view;
	$approval_access = $employee_data->approval_access;
	$show_password = $employee_data->show_password;
	$fax_no = $employee_data->fax_no;
	$joining_date_input = date('d-m-Y', strtotime($employee_data->joining_date));
	//$joining_date = $employee_data->joining_date;
	
	if(!empty($employee_data->termination_date) && $employee_data->termination_date != '0000-00-00' && $employee_data->termination_date != '01-01-1970' && $employee_data->termination_date != '1970-01-01')
		$termination_date_input = date('d-m-Y', strtotime($employee_data->termination_date));
	else
		$termination_date_input = '';
	
	
	if(!empty($employee_data->roles))
	{
		foreach($employee_data->roles as $role)
		{
			$selected_user_role[] = $role->user_role_id;
			$selected_company[] = $role->company_profile_id;
		}
	}
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
						<? if(!empty($employee_data)){ ?>
						<li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/employee-view/".$admin_user_id?>">View</a></li>
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
                        <h3 class="card-title"><?=$name?> <small><?=$record_action?></small></h3>
                    </div>
                    <!-- /.card-header -->
                    <?php 
						if($user_access->view_module==1 || true)	{
					?>
					<? echo $this->session->flashdata('alert_message'); ?>
                    <div class="card-body">
                        
                            <?php echo form_open(MAINSITE_Admin."$user_access->class_name/userEmployeeDoEdit", array('method' => 'post', 'id' => 'employee_form' , "name"=>"employee_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
							<input type="hidden" name="admin_user_id" id="admin_user_id" value="<?=$admin_user_id?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="" />
                            <input type="hidden" name="approval_access" value="0">
							
                            	<div class="form-group row">
								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Role 
											<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<? if(count($company_profile_data)>1){ ?>
									<div class="">
										<table class="table table-hover text-nowrap" style="width:90%">
										<thead>
											<tr>
											<th style="width: 10px">#</th>
											<th>Company</th>
											<th>Role <span style="color:#f00;font-size: 11px;margin-top: 3px;">*</span></th>
											</tr>
										</thead>
										<tbody>
										<? $c_count=0;foreach($company_profile_data as $cpd){$c_count++; ?>
											<tr>
											<td><?=$c_count?>.</td>
											<td><?=$cpd->company_unique_name?></td>
											<td>
											<input type="hidden" name="company_profile_id[]" value="<?=$cpd->company_profile_id?>">
											<?
												$selected_role="";
												if(!empty($employee_data->roles))
												{
													foreach($employee_data->roles as $role)
													{
														if($role->company_profile_id == $cpd->company_profile_id)
														{
															$selected_role = $role->user_role_id;
														}
													}
												}
											?>
											<select type="text" class="form-control form-control-sm" id="user_role_id" name="user_role_id[]" >
												<option value="">Select Role</option>
												<? foreach($users_role_data as $urd){
													$selected="";
													if($urd->user_role_id == $selected_role){$selected = "selected";}
													?>
													<option value="<?=$urd->user_role_id?>" <?=$selected?>><?=$urd->user_role_name?>
													<? if($urd->status!=1){echo " [Block]";} ?>
													</option>
												<? } ?>
											</select>
											</td>
											</tr>
										<? } ?>
										</tbody>
										</table>
										
									</div>
									<? }else{ ?>
										<? $c_count=0;foreach($company_profile_data as $cpd){$c_count++; ?>
										<input type="hidden" name="company_profile_id[]" value="<?=$cpd->company_profile_id?>">
											<?
												$selected_role="";
												if(!empty($employee_data->roles))
												{
													foreach($employee_data->roles as $role)
													{
														if($role->company_profile_id == $cpd->company_profile_id)
														{
															$selected_role = $role->user_role_id;
														}
													}
												}
											?>
											<select required type="text" class="form-control form-control-sm" id="user_role_id" name="user_role_id[]" >
												<option value="">Select Role <?=$selected_role?></option>
												<? foreach($users_role_data as $urd){
													$selected="";
													if($urd->user_role_id == $selected_role){$selected = "selected";}
													?>
													<option value="<?=$urd->user_role_id?>" <?=$selected?>><?=$urd->user_role_name?>
													<? if($urd->status!=1){echo " [Block]";} ?>
													</option>
												<? } ?>
											</select>
											<p class="help-block text-muted mb-0">
											<span style="color:red" class="error_span" id="user_role_error" ></span>
											</p>
												<? } ?>
									<? } ?>									
									</div>
								</div>

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Designation <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<select type="text" class="form-control form-control-sm" required id="designation_id" name="designation_id" >
										<option value="">Select Designation</option>
										<? foreach($designation_data as $d){
											$selected="";
											if($d->designation_id == $designation_id){$selected = "selected";}
											?>
											<option value="<?=$d->designation_id?>" <?=$selected?>><?=$d->designation_name?>
											<? if($d->status!=1){echo " [Block]";} ?>
											</option>
										<? } ?>
									</select>
									
									</div>
								</div>
								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="py-0 px-2 col-sm-12 col-form-label-lg label_content">Joining Date  <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
                                        <div class="col-sm-12">
                                        <div class="input-group date joining_date_input" id="joining_date_input" data-target-input="nearest">
                                            <input type="text" readonly="readonly" value="<?=$joining_date_input?>" name="joining_date" id="joining_date" placeholder="Joining Date" style="width: 100%;"  class="form-control datetimepicker-input width100 form-control-sm" data-target="#joining_date_input"/>
                                            <div class="input-group-append" data-target="#joining_date_input" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                           
                                        </div>
                                        
                                        </div>
								</div>

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="py-0 px-2 col-sm-12 col-form-label-lg label_content">Termination Date  <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
                                        <div class="col-sm-12">
                                        <div class="input-group date termination_date_input" id="termination_date_input" data-target-input="nearest">
                                            <input type="text" readonly="readonly" value="<?=$termination_date_input?>" name="termination_date" id="termination_date" placeholder="Termination Date" style="width: 100%;"  class="form-control datetimepicker-input width100 form-control-sm" data-target="#termination_date_input"/>
                                            <div class="input-group-append" data-target="#termination_date_input" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                           
                                        </div>
                                        
                                        </div>
								</div>
								
                                </div>
                                <div class="form-group row">
                                	<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">First Name <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" required id="first_name" name="first_name" value="<?=$first_name?>" placeholder="First Name">
									</div>
								</div>

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Last Name <span style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm"  id="last_name" name="last_name" value="<?=$last_name?>" placeholder="Last Name">
									
									</div>
								</div>
								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Email <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<input type="email" class="form-control form-control-sm" required id="email" name="email" value="<?=$email?>" placeholder="Email">
									</div>
								</div>

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Password <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" required id="show_password" name="show_password" value="<?=$show_password?>" placeholder="Password">
									</div>
								</div>

								
                                </div>
                                <div class="form-group row">

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Fax No. <span style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="col-sm-12">
									<input type="number" class="form-control form-control-sm" pattern="[0-9]{8,15}" id="fax_no" name="fax_no" value="<?=$fax_no?>" placeholder="Fax No.">
									</div>
								</div>

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Mobile No. <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<input type="number" class="form-control form-control-sm" pattern="[0-9]{8,15}" required id="mobile_no" name="mobile_no" value="<?=$mobile_no?>" placeholder="Mobile No.">
									</div>
								</div>

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Alt Mobile No. <span style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="col-sm-12">
									<input type="number" class="form-control form-control-sm" pattern="[0-9]{8,15}" id="mobile_no" name="alt_mobile_no" value="<?=$alt_mobile_no?>" placeholder="Alt Mobile No.">
									</div>
								</div>
							</div>
								<div class="form-group row">

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Address 1 <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" required id="address1" name="address1" value="<?=$address1?>" placeholder="Address Line 1">
									</div>
								</div>

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Address 2 <span style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" id="address2" name="address2" value="<?=$address2?>" placeholder="Address Line 2">
									</div>
								</div>

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Address 3 <span style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" id="address3" name="address3" value="<?=$address3?>" placeholder="Address Line 3">
									</div>
								</div>
                                
                                
								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Pincode <span style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" id="pincode" name="pincode" value="<?=$pincode?>" placeholder="Pincode">
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Country <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<select type="text" class="form-control form-control-sm custom-select" required id="country_id" onchange="getState(this.value ,0)" name="country_id" >
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

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">State <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<select type="text" class="form-control form-control-sm custom-select" required id="state_id" name="state_id" onchange="getCity(this.value ,0)"  >
										<option value="">Select State</option>
									</select>
									</div>
								</div>

								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">City <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<select type="text" class="form-control form-control-sm custom-select" required id="city_id" name="city_id" >
										<option value="">Select City</option>
									</select>
									</div>
								</div>
                                </div>
                                
                                <div class="form-group row">
								

								<div class="col-lg-4 col-md-8 col-sm-6">
                                        <div class="card-body py-0 px-2" >
                                            <table class="table table-sm">
                                              	<thead>
                                                	<tr>
                                                      	<th>#</th>
                                                      	<th width="25%">File Title</th>
                                                      	<th>File</th>
                                                      	<th></th>
                                                	</tr>
                                              	</thead>
                                              	<tbody class="RFQDetailBody">
                                              		<? $this->load->view('admin/human_resource/Employee_Module/template/file_line_add_more', $this->data); ?>
                                              	</tbody>
                                                <tfoot>
                                              		<tr>
                                              			<td colspan="9"><button type="button" onclick="addNewRFQDeatilLine(0)" class="btn btn-block btn-default">Add New Line</button><td>
                                              		</tr>
                                              	</tfoot>
                                            </table>
                                             <?php if(!empty($employee_data->files)){ ?>
            <div class="card-body p-0 " style="width:90% !important">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th colspan="2" style="padding: 10px 5px;"><a data-target="#uploadImg" data-toggle="collapse" class="collapsed uploadImgClick">Uploaded Files <span class="bg-primary fa fa-chevron-down" ></span></a></th>
                        </tr>
                    </thead>
                    <tbody class="collapse" id="uploadImg">
                        <?php foreach($employee_data->files as $f){ ?>
                        <tr id="quotation_enquiry_file_<?=$f->admin_user_file_id?>">
                            <td><a href="<?=_uploaded_files_?>employee_file/<?=$f->file_name?>" target="_blank"><?=$f->file_title?></a></td>
                            <td><button class="btn btn-outline-danger btn-xs" onclick="return delEmployeeFile('<?=$f->admin_user_file_id?>')" title="remove"><i class="fas fa-trash"></i></button></td>
                        </tr>
                        <?php } ?>
                        <tr><td colspan="2"></td></tr>
                    </tbody>
                </table>
            </div>                                        
			<?php } ?>
                                        </div>
									
								</div>

								
                               
                                
                              
								<div class="col-lg-2 col-md-4 col-sm-6">
									<label for="data_view1" class="col-sm-12 label_content px-2 py-0">Data View <span style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="col-sm-12">
									<div class="form-check" style="margin-top:12px">
										<div class="form-group clearfix">
											<div class="icheck-success d-inline">
												<input type="radio" name="data_view" <? if($data_view==1){echo "checked"; }?> value="1" id="data_view1">
												<label for="data_view1"> Yes
												</label>
											</div>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<div class="icheck-danger d-inline">
												<input type="radio" name="data_view" <? if($data_view!=1){echo "checked"; }?> value="0" id="data_view2">
												<label for="data_view2"> No
												</label>
											</div>
										</div>
									</div>
									</div>
								</div>

								
								
								<div class="col-lg-2 col-md-4 col-sm-6">
									<label for="radioSuccess1" class="col-sm-12 label_content px-2 py-0">Status <span style="color:#f00;font-size: 22px;margin-top: 3px;">	</span></label>
									<div class="col-sm-12">
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
									<button type="submit" name="save" onclick=" redirect_type_func('');" value="1" class="btn btn-info">Save</button>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="submit" name="save-add-new" onclick=" redirect_type_func('save-add-new');" value="1" class="btn btn-default ">Save And Add New</button>
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
function validateForm()
{
	event.preventDefault();
	//user_role user_role_id
	
	$(".error_span").html("");
	var user_role_id_arr = document.getElementsByName("user_role_id[]");
	var i=0;
	var user_role_check = true;
	for(i=0 ; i< user_role_id_arr.length ; i++)
	{
		if(user_role_id_arr[i].value !='')
		{
			user_role_check = false;
		}
	}
	if(user_role_check)
	{
		toastrDefaultErrorFunc("You Did Not Assign The Role To The User.");
		$("#user_role_error").html("You Did Not Assign The Role To The User.");
	}
	else{
		$('#employee_form').attr('onsubmit', ''); 
		$( "#employee_form" ).submit();
	}
}

function redirect_type_func(data)
{
	document.getElementById("redirect_type").value = data;
	return true;
}

function getState(country_id , state_id=0)
{
	$("#state_id").html( '' );
	$("#city_id").html( '' );
	if(country_id > 0)
	{
		Pace.restart();
		$.ajax({
			url: "<?=MAINSITE_Admin.'Ajax/getState'?>",
			type: 'post',
			dataType: "json",
			data: {	'country_id' : country_id , 'state_id' : state_id , "<?=$csrf['name']?>":"<?=$csrf['hash']?>" },
			success: function( response ) {
				$("#state_id").html( response.state_html );
			},
			error: function (request, error) {
				toastrDefaultErrorFunc("Unknown Error. Please Try Again");
			}
		});
	}	
}

function getCity(state_id , city_id=0)
{
	$("#city_id").html( '' );
	if(state_id > 0)
	{
		Pace.restart();
		$.ajax({
			url: "<?=MAINSITE_Admin.'Ajax/getCity'?>",
			type: 'post',
			dataType: "json",
			data: {	'city_id' : city_id , 'state_id' : state_id  , "<?=$csrf['name']?>":"<?=$csrf['hash']?>" },
			success: function( response ) {
				$("#city_id").html( response.city_html );
			},
			error: function (request, error) {
				toastrDefaultErrorFunc("Unknown Error. Please Try Again");
			}
		});
	}	
}
window.addEventListener('load' , function(){
<? if(!empty($country_id) && !empty($state_id)){ ?>
	getState(<?=$country_id?> , <?=$state_id?>)	
<? } ?>

<? if(!empty($city_id) && !empty($state_id)){ ?>
	getCity(<?=$state_id?> , <?=$city_id?>)	
<? } ?>
	
	//setSearch();
	var dateFormat = "DD-MM-YYYY";
	var CurrDate = new Date();
	var MinDate = new Date();
	var MaxDate = new Date();
	  
	  dateCurr = moment(CurrDate, dateFormat);
	  dateMin = moment(MinDate, dateFormat);
	  dateMax = moment(MaxDate, dateFormat);
	$('#joining_date_input').datetimepicker({
        format: dateFormat,
		//maxDate: dateMax,
		ignoreReadonly:true
	});
	
	$('#termination_date_input').datetimepicker({
        format: dateFormat,
		//maxDate: dateMax,
		timepicker:false,
		ignoreReadonly:true
	});
	<? if(!empty($termination_date)){ ?>
	$('#termination_date_input').val('');
	<? } ?>
	
})


var append_id = 1;
function addNewRFQDeatilLine(id=0)
{
	append_id++;
	Pace.restart();
	$.ajax({
		url: "<?=MAINSITE_Admin.$user_access->class_name.'/addNewFileLine'?>",
		type: 'post',
		dataType: "json",
		data: { 'id':id	, 'append_id':append_id , "<?=$csrf['name']?>":"<?=$csrf['hash']?>" },
		success: function( response ) {
			$(".RFQDetailBody").append( response.template );
			set_qe_sub_table_count();
			set_qe_sub_table_remove_btn();
			calculate_qe_sub_table_price();
			set_input_element_functions()
			//$('.summernote').summernote();
			$('.summernote').summernote({<?=_summernote_?>});
			$('.custom-file-input').on('change', function () {
				let fileName = Array.from(this.files).map(x => x.name).join(', ')
				$(this).siblings('.custom-file-label').addClass("selected").html(fileName);
			});
		},
		error: function (request, error) {
			toastrDefaultErrorFunc("Unknown Error. Please Try Again");
		}
	});
}


function set_qe_sub_table_count()
{
	var count=0;
	$('.qe_sub_table_count').each(function(index, value) {
		count++;
	  $(this).html(count+'.');
	});
}

function set_qe_sub_table_remove_btn()
{
	$('.qe_sub_table_remove_td').html('');
	var count=0;
	$('.qe_sub_table_remove_td').each(function(index, value) {
		count++;
	});
	if(count>1)
	{
		$('.qe_sub_table_remove_td').html('<button class="btn btn-outline-danger btn-xs" onclick="remove_qe_sub_table_row($(this))" title="remove"><i class="fas fa-trash"></i></button>');
	}
}

function remove_qe_sub_table_row(row)
{
	row.closest('tr').remove();
	set_qe_sub_table_remove_btn();
	set_qe_sub_table_count();
}


function delEmployeeFile(admin_user_file_id)
	{
		if(parseInt(admin_user_file_id) > 0){
			var s = confirm('You want to delete this file?');
			if(s){
				$.ajax({
					url: "<?=MAINSITE_Admin.'Ajax/del_employee_file'?>",
					type: 'post',
					//dataType: "json",
					data: {	'admin_user_file_id' : admin_user_file_id , "<?=$csrf['name']?>":"<?=$csrf['hash']?>" },
					success: function( response ) {
						//alert(response);
						$("#quotation_enquiry_file_"+admin_user_file_id).hide();
					},
					error: function (request, error) {
						toastrDefaultErrorFunc("Unknown Error. Please Try Again");
					}
				});
			}
		}
		
		return false;
	}	
</script>
<script>
require(['bootstrap-multiselect'], function(purchase){
$('#mySelect').multiselect();
});
</script>
