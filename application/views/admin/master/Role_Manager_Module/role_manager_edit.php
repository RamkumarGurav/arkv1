<?php
// Set the page module name to "Role Master"
$page_module_name = "Role Master";
?>


<?
//THIS IS FOR ADD NEW RECORD PAGE
$record_action = "Add New Record";
$user_role_id = 0;
$user_role_name = "";
$status = 1;

//THIS IS FOR UPDATE EXISTING RECORD PAGE
// Check if $users_role_master_data is not empty (i.e., we are updating an existing user role)
if (!empty($users_role_master_data)) {
	$record_action = "Update";
	$user_role_id = $users_role_master_data->user_role_id;
	$user_role_name = $users_role_master_data->user_role_name;
	$status = $users_role_master_data->status;

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
					<h1 class="m-0 text-dark"><?= $page_module_name ?> </small></h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= MAINSITE_Admin . "wam" ?>">Home</a></li>
						<li class="breadcrumb-item"><a
								href="<?= MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name ?>"><?= $user_access->module_name ?>
								List</a></li>
						<? if (!empty($users_role_master_data)) { ?>
							<li class="breadcrumb-item"><a
									href="<?= MAINSITE_Admin . $user_access->class_name . "/role_manager_view/" . $user_role_id ?>">View</a>
							</li>
						<? } ?>
						<li class="breadcrumb-item"><?= $record_action ?></li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<? ?>
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"><?= $user_role_name ?> <small><?= $record_action ?></h3>
					</div>
					<!-- /.card-header -->
					<?php
					if ($user_access->view_module == 1 || true) {
						?>
						<? echo $this->session->flashdata('alert_message'); ?>
						<div class="card-body">

							<?php echo form_open(MAINSITE_Admin . "$user_access->class_name/userRoleDoEdit", array('method' => 'post', 'id' => 'ptype_list_form', "name" => "ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>

							<input type="hidden" name="user_role_id" id="user_role_id" value="<?= $user_role_id ?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="" />

							<div class="card-body">
								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-2 col-form-label-lg">User Role Name</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" required id="user_role_name" name="user_role_name"
											value="<?= $user_role_name ?>" placeholder="User Role Name">
										<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span>
									</div>
								</div>
								<div class="form-group row ">
									<table id="" class="table table-bordered table-hover" style="font-size:medium">
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
										<tbody>
											<?
											$count = 0;

											foreach ($module_data as $md) {
												$count++;
												?>

												<?
												$all_checked = $view_checked = $add_checked = $update_checked = $delete_checked = $approval_checked = $import_checked = $export_checked = '';
												if (!empty($module_permission_data)) {
													foreach ($module_permission_data as $mpd) {
														if ($md->module_id == $mpd->module_id) {
															if (!empty($mpd->view_module)) {
																$view_checked = 'checked ';
																$all_checked = 'checked';
															}

															if (!empty($mpd->add_module)) {
																$add_checked = 'checked';
																$all_checked = 'checked';
															}

															if (!empty($mpd->update_module)) {
																$update_checked = 'checked';
																$all_checked = 'checked';
															}

															if (!empty($mpd->delete_module)) {
																$delete_checked = 'checked';
																$all_checked = 'checked';
															}

															if (!empty($mpd->approval_module)) {
																$approval_checked = 'checked';
																$all_checked = 'checked';
															}

															if (!empty($mpd->import_data)) {
																$import_checked = 'checked';
																$all_checked = 'checked';
															}

															if (!empty($mpd->export_data)) {
																$export_checked = 'checked';
																$all_checked = 'checked';
															}
														}

													}
												}




												?>


												<tr>
													<td><?= $count ?>.</td>
													<td><?= $md->module_name ?> [ <?= $master_name[$md->is_master] ?> ]</td>

													<td>
														<input type="checkbox" value="<?= $md->module_id ?>" name="module_ids[]"
															class="module_all m_check_all_<?= $md->module_id ?>" data-module_id="<?= $md->module_id ?>"
															<?= $all_checked ?> data-bootstrap-switch data-off-color="danger" data-on-color="success"
															data-on-text="Yes" data-off-text="No">
													</td>
													<td>
														<input type="checkbox" value="1" name="view_<?= $md->module_id ?>"
															class="module_field m_check_field_<?= $md->module_id ?>"
															data-module_id="<?= $md->module_id ?>" <?= $view_checked ?> data-bootstrap-switch
															data-off-color="danger" data-on-color="success" data-on-text="Yes" data-off-text="No">
													</td>
													<td>
														<input type="checkbox" value="1" name="add_<?= $md->module_id ?>"
															class="module_field m_check_field_<?= $md->module_id ?>"
															data-module_id="<?= $md->module_id ?>" <?= $add_checked ?> data-bootstrap-switch
															data-off-color="danger" data-on-color="success" data-on-text="Yes" data-off-text="No">
													</td>
													<td>
														<input type="checkbox" value="1" name="update_<?= $md->module_id ?>"
															class="module_field m_check_field_<?= $md->module_id ?>"
															data-module_id="<?= $md->module_id ?>" <?= $update_checked ?> data-bootstrap-switch
															data-off-color="danger" data-on-color="success" data-on-text="Yes" data-off-text="No">
													</td>

													<td>
														<input type="checkbox" value="1" name="import_<?= $md->module_id ?>"
															class="module_field m_check_field_<?= $md->module_id ?>"
															data-module_id="<?= $md->module_id ?>" <?= $import_checked ?> data-bootstrap-switch
															data-off-color="danger" data-on-color="success" data-on-text="Yes" data-off-text="No">
													</td>
													<td>
														<input type="checkbox" value="1" name="export_<?= $md->module_id ?>"
															class="module_field m_check_field_<?= $md->module_id ?>"
															data-module_id="<?= $md->module_id ?>" <?= $export_checked ?> data-bootstrap-switch
															data-off-color="danger" data-on-color="success" data-on-text="Yes" data-off-text="No">
													</td>
												</tr>
											<? } ?>
										</tbody>
									</table>
								</div>


								<div class="form-group row">
									<label for="radioSuccess1" class="col-sm-2 col-form-label-lg">Status</label>
									<div class="col-sm-10">
										<div class="form-check" style="margin-top:12px">
											<div class="form-group clearfix">
												<div class="icheck-success d-inline">
													<input type="radio" name="status" <? if ($status == 1) {
														echo "checked";
													} ?> value="1"
														id="radioSuccess1">
													<label for="radioSuccess1"> Active
													</label>
												</div>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<div class="icheck-danger d-inline">
													<input type="radio" name="status" <? if ($status != 1) {
														echo "checked";
													} ?> value="0"
														id="radioSuccess2">
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
									<button type="submit" name="save" onclick="return redirect_type_func('')" value="1"
										class="btn btn-info">Save</button>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="submit" name="save-add-new" onclick="return redirect_type_func('save-add-new')" value="1"
										class="btn btn-default ">Save And Add New</button>
								</center>
							</div>
							<!-- /.card-footer -->

							<?php echo form_close() ?>
							</table>
						</div>
					<? } else {
						$this->data['no_access_flash_message'] = "You Dont Have Access To View " . $page_module_name;
						$this->load->view('admin/template/access_denied', $this->data);
					} ?>
					<!-- /.card-body -->
				</div>
			</div>
		</div>


	</section>
	<? ?>
</div>

<aside class="control-sidebar control-sidebar-dark">
	<!-- Control sidebar content goes here -->
</aside>
<script>
	function redirect_type_func(data) {
		document.getElementById("redirect_type").value = data;
		return true;
	}




	window.addEventListener('load', function () {

		// Variables to prevent infinite loops during the switch state changes
		//When you change the state of one switch, it can trigger other switches to change their state. This could potentially create an infinite loop of state changes. For example:
		// You toggle the "All" switch.
		// This changes the states of all related "field" switches.
		// Each "field" switch change might trigger logic that updates the "All" switch again. To prevent this situation we use below flags
		var approve_all = false;
		var approve_field = false;

		// Event listener for changes to 'module_all' checkboxes
		$('.module_all').on('switchChange.bootstrapSwitch', function (event, state) {

			// If the 'approve_field' flag is true, exit the function to prevent recursion
			if (approve_field) { return false: }

			// Get the module ID from the data attribute of the checkbox
			var module_id = $(this).attr("data-module_id");
			// Set the 'approve_all' flag to true to indicate we're handling a 'module_all' switch change
			approve_all = true;

			// Change the state of all related 'module_field' checkboxes to match the 'module_all' checkbox
			//$(".m_check_field_" + module_id) will be array of checkboxes 
			$(".m_check_field_" + module_id).each(function (index) {
				//here this is each checkbox , and we are assigning the "module_all"'s switch state to all its corresponding "$(".m_check_field_" + module_id)" switch state
				$(this).bootstrapSwitch('state', state);
			});
			// Reset the 'approve_all' flag after handling the change
			approve_all = false;
		});

		// Event listener for changes to 'module_field' checkboxes
		$('.module_field').on('switchChange.bootstrapSwitch', function (event, state) {
			// If the 'approve_all' flag is true, exit the function to prevent recursion
			if (approve_all) { return false; }
			// Set the 'approve_field' flag to true to indicate we're handling a 'module_field' switch change
			approve_field = true;
			// Get the module ID from the data attribute of the checkbox
			var module_id = $(this).attr("data-module_id");
			var total_count = 0;  // Total number of 'module_field' checkboxes
			var true_count = 0;   // Number of checked 'module_field' checkboxes
			var false_count = 0;  // Number of unchecked 'module_field' checkboxes

			// Iterate over all 'module_field' checkboxes related to the current module
			$(".m_check_field_" + module_id).each(function (index) {
				total_count++;
				// Count the number of checked and unchecked checkboxes
				//$(this).bootstrapSwitch('state') gives true or false based on switch state
				if ($(this).bootstrapSwitch('state')) {
					true_count++;
				} else {
					false_count++;
				}
			});

			// Update the 'module_all' checkbox based on the states of the 'module_field' checkboxes
			if (true_count == total_count) {
				// If all 'module_field' checkboxes are checked, set the 'module_all' checkbox to checked
				$(".m_check_all_" + module_id).bootstrapSwitch('state', true);
			} else if (false_count == total_count) {
				// If all 'module_field' checkboxes are unchecked, set the 'module_all' checkbox to unchecked
				$(".m_check_all_" + module_id).bootstrapSwitch('state', false);
			} else {
				// If some 'module_field' checkboxes are checked and some are unchecked, set the 'module_all' checkbox to checked
				$(".m_check_all_" + module_id).bootstrapSwitch('state', true);
			}

			// Reset the 'approve_field' flag after handling the change
			approve_field = false;
		});
	})
</script>