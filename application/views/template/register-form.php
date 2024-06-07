<?php echo form_open('', array('method' => 'post', 'id' => 'registration_form', 'style' => '', 'accept-charset' => 'utf-8', 'class' => 'registration_form', 'autocomplete' => 'off')); ?>
<div class="user-area">
    <div class="user-item" id="profile_setting">    
    <?php echo $message; ?>
    <div class="form-group">
      <div class="mb-number mb-number">
       <?php 
    $attributes = array(
    'name'  => 'username',
    'id'  => 'username',
    'value' => set_value('username'),
    'class' => 'mb-input',
    'autofocus' => 'autofocus',
    //'placeholder' => 'Email / Mobile Number',
    'type' => 'text',
    'required' => 'required'
    );
	if($is_valid_username == 1)
	{
		$attributes['readonly'] = 'readonly';
	}
    echo form_input($attributes);?>
    <span class="mb-input-inner"></span>
    <label class="mb-input-label">
    <span>Enter Mobile Number</span></label>
    </div>
    </div>
    <? if($is_valid_username == 1){ ?>
    <div class="form-group">
      <div class="mb-number mb-number">
       <?php 
    $attributes = array(
    'name'  => 'otp',
    'id'  => 'otp',
    'value' => set_value('otp'),
    'class' => 'mb-input',
    'autofocus' => 'autofocus',
    //'placeholder' => 'Email / Mobile Number',
    'type' => 'number',
    'required' => 'required'
    );

    echo form_input($attributes);?>
    <span class="mb-input-inner"></span>
    <label class="mb-input-label">
    <span>Enter OTP</span></label>
    </div>
    </div>
    <a class="resend_otp" id="otp_func_e" onclick="password_change_otp_func_e()">Send OTP</a>
	                                <a class="resend_otp" id="otp_func_count_e" style="display:none" ></a>
    <? } ?>
    
   
    <div class="d-flex justify-content-between" style=" margin:0 auto">
      <!-- <div class="form-check">
          <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1"><label class="form-check-label" for="remember"><a>&nbsp; Remember Me</a></label>
    </div> -->
        <button class="btn login-btn" name="doRegisterBTN" value="1" type="submit"  >Continue</button>
        
    </div>
     <div class="privacy-text">By continuing, you agree to <?=_project_name_?>
    <a class="privacy-link" target="_blank" href="<?=base_url(__terms_conditions__);?>">Terms of Use</a> and
     <a class="privacy-link" target="_blank" href="<?=base_url(__privacy_policy__);?>">Privacy Policy</a>.</div>
    </div>

<div class="req-box">

<!-- 
<button class="btn req-btn">Request OTP</button> -->
</div>

<a class=" btn req-btn"  href="<?=base_url(__login__);?>">Existing User? Log in</a>



<!-- <div class="mt-4">
  <div class="form-divider">
      <label class="before"></label>
        <span class="or">OR</span>
        <label class="after"></label>
</div>
</div><br> -->
<!--  <p class="text-center">Didn't Have An Account?</p>
<div class="d-flex justify-content-between">
  <a href="<?=base_url(__forgotPassword__);?>" class="btn common-btn aClick_1">Forgot Password</a>
    <a href="<?=base_url(__signup__);?>" class="btn common-btn aClick_1">Sign Up Now</a> -->
</div>
<?php echo form_close() ?>

    <? if($is_valid_username == 1){ ?>
<script>
if(typeof myOTPTimer != "undefined")
{
	clearInterval(myOTPTimer);
}

var time_sec = 20;
function resend_otp_time() {
  $('#otp_func_count').show();	
  time_sec = time_sec - 1;
  $('#otp_func_count').html('Resend OTP in '+ time_sec +' Seconds.');
  if(time_sec==0)
  {
	  clearInterval(myOTPTimer);
	  $('#otp_func').show();
	  $('#otp_func_count').html('');
	  $('#otp_func_count').hide();
  }
}

function password_change_otp_func()
{
	$(".loader").css("display","block");
	$.ajax({
		type: "POST",
		//url:$('.siteUrl').val()+'products/loadMoreProduct',
		url:$('.siteUrl').val()+'Dashboard/verify_update_contact_resend_otp',
		/*dataType : "json",*/
		data : {'number':$('#profile_number').val()},
		success : function(result){
			time_sec = 20;
			$('#otp_func').hide();
			myOTPTimer = setInterval(resend_otp_time, 1000);
			$(".loader").css("display","none");
		}
	});
}
</script>

<script>
if(typeof myOTPTimer_e != "undefined")
{
	clearInterval(myOTPTimer_e);
}
var time_sec_e = 20;
function resend_otp_time_e() {
  $('#otp_func_count_e').show();	
  time_sec_e = time_sec_e - 1;
  $('#otp_func_count_e').html('Resend OTP in '+ time_sec_e +' Seconds.');
  if(time_sec_e==0)
  {
	  clearInterval(myOTPTimer_e);
	  $('#otp_func_e').show();
	  $('#otp_func_count_e').html('');
	  $('#otp_func_count_e').hide();
  }
}

function password_change_otp_func_e()
{
	$(".loader").css("display","block");
	$.ajax({
		type: "POST",
		//url:$('.siteUrl').val()+'products/loadMoreProduct',
		url:$('.siteUrl').val()+'register/auth',
		/*dataType : "json",*/
		data : {'username':$('#username').val()},
		success : function(result){
			time_sec_e = 20;
			$('#otp_func_e').hide();
			myOTPTimer_e = setInterval(resend_otp_time_e, 1000);
			$(".loader").css("display","none");
		}
	});
}
<? if(!empty($is_call_counter)){ ?>


	myOTPTimer_e = setInterval(resend_otp_time_e, 1000);

<? } ?>
</script>
<? } ?>