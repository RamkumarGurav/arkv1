<?php
$page_module_name = "Company Profile";
?>
<?
$company_email = $letterhead_header_image = $company_website = $logo = $company_unique_name = $company_name = $gst_no = $mobile_no = $alt_mobile_no = $name = $first_name = $last_name = $address1 = $address2 = $address3 = $email = $pincode = "";
$company_profile_id = 0;
$country_id = 0;
$state_id = 0;
$city_id = 0;
$status = 1;
$record_action = "Add New Record";

if (!empty($company_profile_data)) {
	$record_action = "Update";
	$company_profile_id = $company_profile_data->company_profile_id;
	$company_unique_name = $company_profile_data->company_unique_name;
	$company_name = $company_profile_data->company_name;
	$name = $company_profile_data->name;
	$first_name = $company_profile_data->first_name;
	$last_name = $company_profile_data->last_name;
	$address1 = $company_profile_data->address1;
	$address2 = $company_profile_data->address2;
	$address3 = $company_profile_data->address3;
	$status = $company_profile_data->status;
	$country_id = $company_profile_data->country_id;
	$state_id = $company_profile_data->state_id;
	$city_id = $company_profile_data->city_id;
	$mobile_no = $company_profile_data->mobile_no;
	$alt_mobile_no = $company_profile_data->alt_mobile_no;
	$email = $company_profile_data->email;
	$pincode = $company_profile_data->pincode;
	$gst_no = $company_profile_data->gst_no;
	$logo = $company_profile_data->logo;
	$letterhead_header_image = $company_profile_data->letterhead_header_image;
	$company_email = $company_profile_data->company_email;
	$company_website = $company_profile_data->company_website;
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
						<? if (!empty($company_profile_data)) { ?>
							<li class="breadcrumb-item"><a
									href="<?= MAINSITE_Admin . $user_access->class_name . "/company-profile-view/" . $company_profile_id ?>">View</a>
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
						<h3 class="card-title"><?= $name ?> <small><?= $record_action ?></small></h3>
					</div>
					<!-- /.card-header -->
					<?php
					if ($user_access->view_module == 1 || true) {
						?>
						<? echo $this->session->flashdata('alert_message'); ?>
						<div class="card-body">


							<?php echo form_open(
								MAINSITE_Admin . "$user_access->class_name/userCompanyProfileDoEdit",
								array(
									'method' => 'post',
									'id' => 'company_profile_form',
									"name" => "company_profile_form",
									'style' => '',
									'class' => 'form-horizontal',
									'role' => 'form',
									'onsubmit' => 'return validateForm()',
									'enctype' => 'multipart/form-data'
								)
							); ?>
							<input type="hidden" name="company_profile_id" id="company_profile_id" value="<?= $company_profile_id ?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="" />

							<div class="">

								<div class="form-group row">
									<div class="col-lg-3 col-md-4 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Name <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span>
											<div class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i>
												<span class="tooltiptext">Unique Company Name. This Name Can Not Be Duplicate. For Internal
													Purpose Only.</span>
											</div>
										</label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm"
												onfocusout="validate_company_unique_name('no')" required id="company_unique_name"
												name="company_unique_name" value="<?= $company_unique_name ?>" placeholder="Company Unique Name">
											<span style="color:red" class="error_span" id="company_unique_name_error"></span>
										</div>
									</div>
									<!--  <div class="col-md-3 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Unique Name <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<input type="text" class="form-control form-control-sm" onfocusout="validate_company_unique_name('no')" required id="company_unique_name" name="company_unique_name" value="<?= $company_unique_name ?>" placeholder="Company Unique Name">									
									<p class="help-block text-muted mb-0" style="line-height:20px;"><i><small><small>Unique Company Name. This Name Can Not Be Duplicate. For Internal Purpose Only.</small></small></i>
									<span style="color:red" class="error_span" id="company_unique_name_error" ></span>
									</p>
									
									</div>
																		</div> -->
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Company Name <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12	">
											<input type="text" class="form-control form-control-sm" required id="company_name"
												name="company_name" value="<?= $company_name ?>" placeholder="Company Name">
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Company Website <span
												style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" id="company_website" name="company_website"
												value="<?= $company_website ?>" placeholder="Company Website">
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Company Email <span
												style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" id="company_email" name="company_email"
												value="<?= $company_email ?>" placeholder="Company Email">
										</div>
									</div>
								</div>
								<div class="form-group row mb-0">
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">First Name <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" required id="first_name" name="first_name"
												value="<?= $first_name ?>" placeholder="Contact Person First Name">

										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Last Name <span
												style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" id="last_name" name="last_name"
												value="<?= $last_name ?>" placeholder="Contact Person Last Name">

										</div>
									</div>
									<!-- <div class="col-md-3 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Email <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
									<input type="email" class="form-control form-control-sm" onfocusout="validate_company_email('no')" required id="email" name="email" value="<?= $email ?>" placeholder="Email">
									<p class="help-block text-muted"><i><small><small>Unique Company Email. This Email Can Not Be Duplicate.</small></small></i>
									<span style="color:red" class="error_span" id="email_error" ></span>
									</p>
									</div>
								</div> -->
									<div class="col-lg-3 col-md-4 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Email <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span>
											<div class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i>
												<span class="tooltiptext">Unique Company Email. This Email Can Not Be Duplicate.</span>
											</div>
										</label>
										<div class="col-sm-12">
											<input type="email" class="form-control form-control-sm" onfocusout="validate_company_email('no')"
												required id="email" name="email" value="<?= $email ?>" placeholder="Email">
											<span style="color:red" class="error_span" id="company_unique_name_error"></span>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Mobile No. <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<input type="number" class="form-control form-control-sm" pattern="[0-9]{8,15}" required
												id="mobile_no" name="mobile_no" value="<?= $mobile_no ?>" placeholder="Mobile No.">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Alt Mobile No. <span
												style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
										<div class="col-sm-12">
											<input type="number" class="form-control form-control-sm" pattern="[0-9]{8,15}" id="mobile_no"
												name="alt_mobile_no" value="<?= $alt_mobile_no ?>" placeholder="Alt Mobile No.">
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">GST No. <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" maxlength="15" minlength="15" id="gst_no"
												name="gst_no" value="<?= $gst_no ?>" placeholder="GST No." required>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Address 1 <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" required id="address1" name="address1"
												value="<?= $address1 ?>" placeholder="Address Line 1">
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Address 2 </label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" id="address2" name="address2"
												value="<?= $address2 ?>" placeholder="Address Line 2">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Address 3 <span
												style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" id="address3" name="address3"
												value="<?= $address3 ?>" placeholder="Address Line 3">
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Pincode <span
												style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" id="pincode" name="pincode"
												value="<?= $pincode ?>" placeholder="Pincode">
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Country <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<select type="text" class="form-control form-control-sm custom-select" required id="country_id"
												onchange="getState(this.value ,0)" name="country_id">
												<option value="">Select Country</option>
												<? foreach ($country_data as $cd) {
													$selected = "";
													if ($cd->country_id == $country_id) {
														$selected = "selected";
													}
													?>
													<option value="<?= $cd->country_id ?>" <?= $selected ?>>
														<?= $cd->country_name ?>
														<? if ($cd->status != 1) {
															echo " [Block]";
														} ?>
													</option>
												<? } ?>
											</select>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">State <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<select type="text" class="form-control form-control-sm custom-select" required id="state_id"
												name="state_id" onchange="getCity(this.value ,0)">
												<option value="">Select State</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">City <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<select type="text" class="form-control form-control-sm custom-select" required id="city_id"
												name="city_id">
												<option value="">Select City</option>
											</select>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Upload Logo <span
												style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
										<div class="col-sm-12 d-flex">
											<div class="input-group" style="width:90%">
												<div class="custom-file">
													<input type="file" name="logo" class="custom-file-input" id="files">
													<label class="custom-file-label form-control-sm" for="files"></label>
												</div>
											</div>
											<div class="custom-file-display">
												<? if (!empty($logo)) { ?>
													<span class="pip">
														<a target="_blank" href="<?= _uploaded_files_ . 'company_profile/logo/' . $logo ?>">
															<img class="imageThumb" src="<?= _uploaded_files_ . 'company_profile/logo/' . $logo ?>" />
														</a>
													</span>
												<? } else { ?>
													<span class="pip">
														<img class="imageThumb" src="<?= MAINSITE ?>assets/images/no_image.jpg" />
													</span>
												<? } ?>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Upload Letterhead Header Image
											<span style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
										<div class="col-sm-12 d-flex">
											<div class="input-group" style="width:90%">
												<div class="custom-file">
													<input type="file" name="letterhead_header_image" class="custom-file-input"
														id="letterhead_header_image">
													<label class="custom-file-label form-control-sm" for="files"></label>
												</div>
											</div>
											<div class="custom-file-display1">
												<? if (!empty($letterhead_header_image)) { ?>
													<span class="pip1">
														<a target="_blank"
															href="<?= _uploaded_files_ . 'company_profile/letterhead_header_image/' . $letterhead_header_image ?>">
															<img class="imageThumb"
																src="<?= _uploaded_files_ . 'company_profile/letterhead_header_image/' . $letterhead_header_image ?>"
																style="max-width:100%	" />
														</a>
													</span>
												<? } else { ?>
													<span class="pip">
														<img class="imageThumb" src="<?= MAINSITE ?>assets/images/no_image.jpg"
															style="max-width:100%	" />
													</span>
												<? } ?>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<label for="radioSuccess1" class="col-sm-12 label_content px-2 py-0">Status</label>
										<div class="col-sm-12">
											<div class="form-check" style="">
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
										<div id="before_submit">
											<button type="submit" name="save" onclick=" redirect_type_func('');" value="1"
												class="btn btn-info">Save</button>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<button type="submit" name="save-add-new" onclick="redirect_type_func('save-add-new'); " value="1"
												class="btn btn-default ">Save And Add New</button>
										</div>

										<div id="after_submit" style="display:none">
											<button class="btn btn-info" type="button" disabled>
												<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
												Loading...
											</button>
										</div>
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

	// Function to validate the form before submission
	function validateForm() {
		event.preventDefault(); // Prevent the form from submitting
		showFormSubmitLoading(); // Show a loading indicator
		validate_company_unique_name('yes'); // Validate the company unique name, then proceed to validate email
		$(".error_span").html(""); // Clear any error messages
	}

	// Function to validate the company unique name
	function validate_company_unique_name(is_submit) {
		Pace.restart(); // Restart the Pace loading animation
		var company_unique_name = $('#company_unique_name').val(); // Get the value of the company unique name input
		var company_profile_id = $('#company_profile_id').val(); // Get the value of the company profile ID input
		$("#company_unique_name").removeClass("is-invalid"); // Remove invalid class if present
		$("#company_unique_name").removeClass("is-valid"); // Remove valid class if present
		$("#company_unique_name_error").html(""); // Clear any error messages

		if (company_unique_name == '') { // Check if the company unique name is empty
			toastrDefaultErrorFunc("Company Unique Name Can Not Be Empty."); // Show error message
			hideFormSubmitLoading(); // Hide the loading indicator
			return false; // Stop further execution
		}

		// AJAX request to validate the company unique name
		$.ajax({
			url: "<?= MAINSITE_Admin . 'Validation/isDuplicateCompanyUniqueName' ?>", // URL to send the request to
			type: 'post', // HTTP method
			dataType: "json", // Expected data type
			data: { 'company_unique_name': company_unique_name, 'company_profile_id': company_profile_id, "<?= $csrf['name'] ?>":"<?= $csrf['hash'] ?>" }, // Data to send
			success: function (response) { // Function to execute on successful response
				if (response.boolean_response) { // If the unique name exists in the database
					toastrDefaultErrorFunc(response.message); // Show error message
					hideFormSubmitLoading(); // Hide the loading indicator
					$("#company_unique_name").addClass("is-invalid"); // Add invalid class
					$("#company_unique_name_error").html("<br>" + response.message); // Show error message
					return false; // Stop further execution
				}
				else {
					$("#company_unique_name").addClass("is-valid"); // Add valid class
					if (is_submit == "yes") { validate_company_email(is_submit); } // If validation is successful, proceed to validate email
				}
			},
			error: function (request, error) { // Function to execute on error
				toastrDefaultErrorFunc("Unknown Error. Please Try Again"); // Show error message
			}
		});
	}


	// Function to validate the company email
	function validate_company_email(is_submit) {
		Pace.restart(); // Restart the Pace loading animation
		var email = $('#email').val(); // Get the value of the email input
		var company_profile_id = $('#company_profile_id').val(); // Get the value of the company profile ID input
		$("#email").removeClass("is-invalid"); // Remove invalid class if present
		$("#email").removeClass("is-valid"); // Remove valid class if present
		$("#email_error").html(""); // Clear any error messages

		if (email == '') { // Check if the email is empty
			toastrDefaultErrorFunc("Company Email Can Not Be Empty."); // Show error message
			hideFormSubmitLoading(); // Hide the loading indicator
			return false; // Stop further execution
		}

		// AJAX request to validate the company email
		$.ajax({
			url: "<?= MAINSITE_Admin . 'Validation/isDuplicateCompanyEmail' ?>", // URL to send the request to
			type: 'post', // HTTP method
			dataType: "json", // Expected data type
			data: { 'email': email, 'company_profile_id': company_profile_id, "<?= $csrf['name'] ?>":"<?= $csrf['hash'] ?>" }, // Data to send
			success: function (response) { // Function to execute on successful response
				if (response.boolean_response) { // If the email exists in the database
					toastrDefaultErrorFunc(response.message); // Show error message
					$("#email").addClass("is-invalid"); // Add invalid class
					hideFormSubmitLoading(); // Hide the loading indicator
					$("#email_error").html("<br>" + response.message); // Show error message
					return false; // Stop further execution
				}
				else {
					$("#email").addClass("is-valid"); // Add valid class
					if (is_submit == "yes") { $('#company_profile_form').attr('onsubmit', ''); $("#company_profile_form").submit(); } // If validation is successful, submit the form
				}
			},
			error: function (request, error) { // Function to execute on error
				toastrDefaultErrorFunc("Unknown Error. Please Try Again"); // Show error message
			}
		});
	}


	// Function to set the redirect type
	function redirect_type_func(data) {
		document.getElementById("redirect_type").value = data; // Set the redirect type value
		return true; // Return true
	}

	// Function to get states based on the selected country
	function getState(country_id, state_id = 0) {
		$("#state_id").html(''); // Clear the state dropdown
		$("#city_id").html(''); // Clear the city dropdown
		if (country_id > 0) { // Check if a valid country is selected
			Pace.restart(); // Restart the Pace loading animation
			$.ajax({
				url: "<?= MAINSITE_Admin . 'Ajax/getState' ?>", // URL to send the request to
				type: 'post', // HTTP method
				dataType: "json", // Expected data type
				data: { 'country_id': country_id, 'state_id': state_id, "<?= $csrf['name'] ?>":"<?= $csrf['hash'] ?>" }, // Data to send
				success: function (response) { // Function to execute on successful response
					$("#state_id").html(response.state_html); // Populate the state dropdown with the response
				},
				error: function (request, error) { // Function to execute on error
					toastrDefaultErrorFunc("Unknown Error. Please Try Again"); // Show error message
				}
			});
		}
	}

	// Function to get cities based on the selected state
	function getCity(state_id, city_id = 0) {
		$("#city_id").html(''); // Clear the city dropdown
		if (state_id > 0) { // Check if a valid state is selected
			Pace.restart(); // Restart the Pace loading animation
			$.ajax({
				url: "<?= MAINSITE_Admin . 'Ajax/getCity' ?>", // URL to send the request to
				type: 'post', // HTTP method
				dataType: "json", // Expected data type
				data: { 'city_id': city_id, 'state_id': state_id, "<?= $csrf['name'] ?>":"<?= $csrf['hash'] ?>" }, // Data to send
				success: function (response) { // Function to execute on successful response
					$("#city_id").html(response.city_html); // Populate the city dropdown with the response
				},
				error: function (request, error) { // Function to execute on error
					toastrDefaultErrorFunc("Unknown Error. Please Try Again"); // Show error message
				}
			});
		}
	}




	// Event listener for when the window loads
	window.addEventListener('load', function () {

		// If country_id and state_id are not empty, get the states for the selected country
		<? if (!empty($country_id) && !empty($state_id)) { ?>
			getState(<?= $country_id ?> , <?= $state_id ?>)	
<? } ?>

		// If city_id and state_id are not empty, get the cities for the selected state
		<? if (!empty($city_id) && !empty($state_id)) { ?>
			getCity(<?= $state_id ?>, <?= $city_id ?>)	
<? } ?>



		// Check if the File API is supported by the browser
		if (window.File && window.FileList && window.FileReader) {
			$("#files").on("change", function (e) {
				var files = e.target.files, // Get the selected files
					filesLength = files.length; // Get the number of selected files

				// Loop through each selected file
				for (var i = 0; i < filesLength; i++) {
					var f = files[i]; // Get the current file
					var fileReader = new FileReader(); // Create a new FileReader object
					fileReader.onload = (function (e) {
						var file = e.target; // Get the file from the event

						// Customized code to display the image
						$(".pip").remove(); // Remove any existing .pip elements
						$(".custom-file-display").html("<span class=\"pip\">" + // Insert the new image inside .custom-file-display element
							"<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "</span>");
					});
					fileReader.readAsDataURL(f);//actualy this triggers the above "	fileReader.onload"  // Read the file as a data URL (base64 encoded string)
				}
			});
		} else {
			alert("Your browser doesn't support to File API"); // Alert the user if the File API is not supported
		}

		// Check if the File API is supported by the browser
		if (window.File && window.FileList && window.FileReader) {
			$("#letterhead_header_image").on("change", function (e) {
				var files = e.target.files, // Get the selected files
					filesLength = files.length; // Get the number of selected files

				// Loop through each selected file
				for (var i = 0; i < filesLength; i++) {
					var f = files[i]; // Get the current file
					var fileReader = new FileReader(); // Create a new FileReader object
					fileReader.onload = (function (e) {
						var file = e.target; // Get the file from the event

						// Customized code to display the image
						$(".pip1").remove(); // Remove any existing .pip1 elements
						$(".custom-file-display1").html("<span class=\"pip1\">" + // Insert the new image inside .custom-file-display1 element
							"<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "</span>");
					});
					fileReader.readAsDataURL(f);//actualy this triggers the above "	fileReader.onload"  // Read the file as a data URL (base64 encoded string)
				}
			});
		} else {
			alert("Your browser doesn't support to File API"); // Alert the user if the File API is not supported
		}



	});
</script>