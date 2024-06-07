<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
   <div class="">
      <div class="container">
        <nav  class="breadcrumb ">
  <ol>
      <li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Dashboard</span></li>
  </ol>
</nav>
        <div class="row ">
        	<?php $this->load->view('template/left-menu', $this->data);?>

                  <div class="col-md-9">

                    <div class="pddnl-16">
                      <div class="min-heigt">
                        <div class="second-sec">
                          <div class="pddng-24-32">
                            <div class="mrgn-bt-56">
                                <div class="pddng-bt-24">
                                  <span class="personal-inf">Personal Information</span>
                                  <span class="edit-2" id="edit_personal_info">Edit</span>

                                  <form class="mt-3" name="personal_info_form" id="personal_info_form" onsubmit="update_personal_info()">
                                  <div id="edit_personal_info_err_msg"></div>
                                    <div class="pddg-bt-2 row">
                                    <div class="input1">
                                      <div class="input2">
                                        <input type="text" class="inner-inp _2mFmU7 edit_personal_info_field" name="first_name" id="first_name" required="" autocomplete="name" tabindex="1" value="<?=$profile->first_name?>" disabled>
                                      </div>
                                    </div>
                                     <div class="input1">
                                      <div class="input2">
                                        <input type="text" class="inner-inp _2mFmU7 edit_personal_info_field" name="last_name" id="last_name" autocomplete="name" tabindex="1" value="<?=$profile->last_name?>" disabled>
                                      </div>
                                    </div>

                                  	 <button class="btn-save" type="submit" id="edit_personal_info_btn" style="display:none" tabindex="5">SAVE</button>

                                  </div>

                                  </form>
<script>
var sess_first_name = '<?=$profile->first_name?>';
var sess_last_name = '<?=$profile->last_name?>';
$(document).ready(function(){

	$(document).on("click", "#edit_personal_info", function(){
		if($(this).hasClass("fomActive"))
		{
			$(this).removeClass("fomActive");
			$(this).html("Edit");
			$("#edit_personal_info_btn").hide();
			$(".edit_personal_info_field").prop("disabled", true);
			$("#first_name").val(sess_first_name);
			$("#last_name").val(sess_last_name);
		}
		else
		{
			$(this).html("Cancel");
			$(this).addClass("fomActive");
			$("#edit_personal_info_btn").show();
			$(".edit_personal_info_field").prop("disabled", false);
		}

	})
});
function update_personal_info()
{
	event.preventDefault();
	var personal_info_form = $('#personal_info_form');
	$("#list_loder").show();
	$("#edit_personal_info_err_msg").html('');
	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'Dashboard/update_personal_info/',
		dataType : "json",
		data : $(personal_info_form).serialize(),
		success : function(result){
			if(result.response==1)
			{
				$("#edit_personal_info_err_msg").html(result.message);
				$(".sess_user_name").html(result.sess_user_name);
				$("#edit_personal_info").removeClass("fomActive");
				$("#edit_personal_info").html("Edit");
				$("#edit_personal_info_btn").hide();
				$(".edit_personal_info_field").prop("disabled", true);
				sess_last_name = result.sess_last_name;
				sess_first_name = result.sess_first_name;
			}
			else
			{
				$("#edit_personal_info_err_msg").html(result.message);
			}
			$("#list_loder").hide();

		}
	});
}
</script>


                                  <div class="paddng-12"> Your Gender </div>
                                  <div id="edit_gender_err_msg"></div>
                                  <div>

                                    <label for="Male" class="inner-radio">
                                      <input type="radio" class="update_profile_gender" <?=($profile->gender == 'Male')?"checked":""?> value="Male" name="gender" readonly="" id="Male" >

                                      <!--  <span class="radio-circle"> </span> -->
                                        <span tabindex="3">Male</span>
                                      </label>
                                      <label for="Female" class="inner-radio">
                                        <input type="radio" class="update_profile_gender" <?=($profile->gender == 'Female')?"checked":""?> value="Female" name="gender" readonly="" id="Female" >

                                       <!--  <span class="radio-circle"> </span> -->
                                          <span tabindex="4">Female</span>

                                      </label>
                                    </div>
<script>
window.addEventListener("load", function(){
	$(document).on("change", ".update_profile_gender", function(){
		$("#list_loder").show();
		$("#edit_gender_err_msg").html('');
		$.ajax({
			type: "POST",
			url:$('.siteUrl').val()+'Dashboard/update_gender/',
			dataType : "json",
			data : {"gender":$(this).val()},
			success : function(result){
				if(result.response==1)
				{
					$("#edit_gender_err_msg").html(result.message);
				}
				else
				{
					$("#edit_gender_err_msg").html(result.message);
				}
				$("#list_loder").hide();

			}
		});
	})
})
</script>
                                    <div id="hide1">
									<form class="mt-3" name="email_info_form" id="email_info_form" onsubmit="update_email_info()">
                                    <div id="edit_email_info_err_msg"></div>
                                     <!-- <div class="paddng-12"> </div> -->
                                    <span class="personal-inf">Email Address</span><span class="edit-2" id="edit_email_info">Edit</span>
                                    <div class="pddg-bt-2 row">
                                    <div class="input1">
                                      <div class="input2">
                                        <input type="email" class="inner-inp _2mFmU7 edit_email_info_field" name="email" id="email" required="" tabindex="1" value="<?=$profile->email?>" disabled>
                                      </div>
                                    </div>


                                  <button class="btn-save" type="submit" id="edit_email_info_btn" style="display:none" tabindex="5">SAVE</button>
                                  <a type="button" class="btn1" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >
  Verify OTP
</a>
                                  </div>
                                  </form>
                                  <script>
var sess_email = '<?=$profile->email?>';
$(document).ready(function(){
$(document).on("click", "#edit_email_info", function(){
		if($(this).hasClass("fomActive"))
		{
			$(this).removeClass("fomActive");
			$(this).html("Edit");
			$("#edit_email_info_btn").hide();
			$(".edit_email_info_field").prop("disabled", true);
			$("#email").val(sess_email);
		}
		else
		{
			$(this).html("Cancel");
			$(this).addClass("fomActive");
			$("#edit_email_info_btn").show();
			$(".edit_email_info_field").prop("disabled", false);
		}

	})
});
function update_email_info()
{
	event.preventDefault();
	var email_info_form = $('#email_info_form');
	$("#list_loder").show();
	$("#edit_email_info_err_msg").html('');
	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'Dashboard/update_email_info/',
		dataType : "json",
		data : $(email_info_form).serialize(),
		success : function(result){
			if(result.response==1)
			{
				$("#edit_email_info_err_msg").html(result.message);
				$(".sess_user_name").html(result.sess_user_name);
				$("#edit_email_info").removeClass("fomActive");
				$("#edit_email_info").html("Edit");
				$("#edit_email_info_btn").hide();
				$(".edit_email_info_field").prop("disabled", true);
				sess_email = result.sess_email;
			}
			else
			{
				$("#edit_email_info_err_msg").html(result.message);
			}
			$("#list_loder").hide();

		}
	});
}
</script>

									<form class="mt-4" name="number_info_form" id="number_info_form" onsubmit="update_number_info()">
                                    <div id="edit_number_info_err_msg"></div>
                                       <div class="paddng-12"> </div>
                                  <span class="personal-inf">Mobile Number</span><span class="edit-2" id="edit_number_info">Edit</span>
                                    <div class="pddg-bt-2 row">
                                    <div class="input1">
                                      <div class="input2">
                                        <input type="number" class="inner-inp _2mFmU7 edit_number_info_field" name="number" required="" tabindex="1" value="<?=$profile->number?>" style="input[type=number] {-moz-appearance: textfield;}" disabled>
                                      </div>
                                    </div>


                                  <button class="btn-save" type="submit" id="edit_number_info_btn" style="display:none" tabindex="5">SAVE</button>
                                  </div>
                                  </form>
                                  <script>
var sess_number = '<?=$profile->number?>';
$(document).ready(function(){
$(document).on("click", "#edit_number_info", function(){
		if($(this).hasClass("fomActive"))
		{
			$(this).removeClass("fomActive");
			$(this).html("Edit");
			$("#edit_number_info_btn").hide();
			$(".edit_number_info_field").prop("disabled", true);
			$("#number").val(sess_number);
		}
		else
		{
			$(this).html("Cancel");
			$(this).addClass("fomActive");
			$("#edit_number_info_btn").show();
			$(".edit_number_info_field").prop("disabled", false);
		}

	})
});
function update_number_info()
{
	event.preventDefault();
	var number_info_form = $('#number_info_form');
	$("#list_loder").show();
	$("#edit_number_info_err_msg").html('');
	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'Dashboard/update_number_info/',
		dataType : "json",
		data : $(number_info_form).serialize(),
		success : function(result){
			if(result.response==1)
			{
				$("#edit_number_info_err_msg").html(result.message);
				$(".sess_user_name").html(result.sess_user_name);
				$("#edit_number_info").removeClass("fomActive");
				$("#edit_number_info").html("Edit");
				$("#edit_number_info_btn").hide();
				$(".edit_number_info_field").prop("disabled", true);
				sess_number = result.sess_number;
			}
			else
			{
				$("#edit_number_info_err_msg").html(result.message);
			}
			$("#list_loder").hide();

		}
	});
}
</script>
                                </div>
                                <div class="paddng-12"> </div>
                                <div>
                                	<h5>FAQs</h5>
                                    <div>
                                    	<h6>What happens when I update my email address (or mobile number)?</h6>
                                        <p>Your login email id (or mobile number) changes, likewise. You'll receive all your account related communication on your updated email address (or mobile number).</p>
                                        <h6>When will my <?=_brand_name_?> account be updated with the new email address (or mobile number)?</h6>
                                        <p>It happens as soon as you confirm the verification code sent to your email (or mobile) and save the changes.</p>
                                        <h6>What happens to my existing <?=_brand_name_?> account when I update my email address (or mobile number)?</h6>
                                        <p>Updating your email address (or mobile number) doesn't invalidate your account. Your account remains fully functional. You'll continue seeing your Order history, saved information and personal details.</p>
									</div>
                                </div>
                                </div>
                            </div>
                          </div>
                        </div>

                    </div>
</div>
</div>





                  
                  </div>


             </div>
      </div>
      <div id="smartblog_block" class="block products_block hb-animate-element bottom-to-top hb-in-viewport">
         <div class="container">
         </div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-custom3">
    <div class="modal-content modal-content-custom3">
      <div class="modal-header modal-header-custom2">
        <h5 class="modal-title" id="staticBackdropLabel">Verify OTP</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">✕</button>
        <button type="button" class="resend-otp" >Resend OTP</button>
      </div>
      <div class="modal-body">
       <div class="manage-class-inner">
                      <div class="mng-form-div1">
                <div class="mng-form-inner mng-form-inner11">
                    <input type="text" name="name" value="" id="name0" class="mng-form-inpt" autofocus="autofocus" required="required">
                            <label for="name" class=" mng-form-label">Enter OTP sent to pankaj@marswebsolutions.com</label>
                </div>

              </div>
               <div class="mng-form-div1">
                <div class="mng-form-inner mng-form-inner11">
                    <input type="text" name="name" value="" id="name0" class="mng-form-inpt" autofocus="autofocus" required="required">
                            <label for="name" class=" mng-form-label"> Enter OTP sent to 91-9886551433</label>
                </div>

              </div>



          <div class="save-btns">
            <button type="submit" id="submit" name="AddressSaveBTN" value="1" class="save-btn1">SUBMIT </button>
           </div>
          </div>
      </div>

    </div>
  </div>
</div>
