<div class="tab-content" id="ex1-content">
             

<div class="col-sm-6 col-lg-12">
<?php echo $message; ?>
                     <?php /*?>   <div class="user-area">
                          <div class="user-item" id="profile_setting">
                              <?php echo form_open(base_url(__login__).'/loginAuth', array('method' => 'post', 'id' => '', 'style' => '', 'accept-charset' => 'utf-8', 'class' => '', 'autocomplete' => 'off')); ?>
                                <?php echo $message; ?>
                                <div class="form-group">
                                  
                                  <div class="mb-number mb-number">
        <input maxlength="10" autofocus="autofocus" type="text" class="mb-input " value="">
        <span class="mb-input-inner"></span>
        <label class="mb-input-label input-transition">
        Enter Email Mobile Number</label>
        </div>
                                 <!--  <?php 
                $attributes = array(
                'name'  => 'email',
                'id'  => 'email',
                'value' => set_value('email'),
                'class' => 'profil_form1',
                'autofocus' => 'autofocus',
                'placeholder' => 'Email / Mobile Number',
                'type' => 'text',
                'required' => 'required'
                );
                echo form_input($attributes);?> -->
                              </div>
                                <div class="form-group">
                                  <div class="mb-number mb-number">
        <input  autocomplete="on" type="text" class="mb-input " value="">
        <span class="mb-input-inner"></span>
        <label class="mb-input-label input-transition">
          Enter Password</label>
        </div>
                                 <!--  <?php 
                                                    $attributes = array(
                                                    'name'  => 'password',
                                                    'id'  => 'password',
                                                    'value' => set_value('password'),
                                                    'class' => 'profil_form1',
                                                    'placeholder' => 'Password',
                                                    'type' => 'password',
                                                    'required' => 'required'
                                                    );
                                                echo form_input($attributes);?> -->
                                                <ul class=" nav-pills login-pills mb-3" id="ex1" role="tablist">
  <li  role="presentation" style="display: none;">
    <a class=" active" id="ex1-tab-1" data-bs-toggle="pill" href="#ex1-pills-1" role="tab" aria-controls="ex1-pills-1"aria-selected="true"></a>
  </li>

    <a class="Forgotp" id="ex1-tab-3"  data-bs-toggle="pill" href="#ex1-pills-3" role="tab" aria-controls="ex1-pills-3"aria-selected="false"
      ><span>Forgot?</span></a>

  
</ul>
                                               <!--  <a class="Forgotp" tabindex="-1"><span>Forgot?</span></a> -->
                              </div>
                              <div class="privacy-text">By continuing, you agree to <?=_project_name_?>
                                <a class="privacy-link" target="_blank" href="<?=base_url(__terms_conditions__);?>">Terms of Use</a> and
                                 <a class="privacy-link" target="_blank" href="<?=base_url(__privacy_policy__);?>">Privacy Policy</a>.</div>
                                <div class="d-flex justify-content-between" style=" margin:0 auto">
                                  <!-- <div class="form-check">
                                      <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1"><label class="form-check-label" for="remember"><a>&nbsp; Remember Me</a></label>
                  </div> -->
                                    <button class="btn login-btn" name="doLoginBTN" value="1" type="submit"  onclick="remeberMe()">Login</button>
                </div>

                           </div>

                            <div class="req-box">
                  <div class="log-or">OR</div>
                 <!-- 
                  <button class="btn req-btn">Request OTP</button> -->
                </div>
<ul class=" nav-pills login-pills mb-3" id="ex1" role="tablist">
  <li  role="presentation" style="display: none;">
    <a class=" active" id="ex1-tab-1" data-bs-toggle="pill" href="#ex1-pills-1" role="tab" aria-controls="ex1-pills-1"aria-selected="true">Tab 1</a>
  </li>

    <button class=" btn req-btn" id="ex1-tab-2"  data-bs-toggle="pill" href="#ex1-pills-2" role="tab" aria-controls="ex1-pills-2"aria-selected="false"
      >Request OTP</button>

  <li  role="presentation" style="display: none;">
    <a  class="" id="ex1-tab-3" data-bs-toggle="pill" href="#ex1-pills-3" role="tab" aria-controls="ex1-pills-3"aria-selected="false">Tab 3</a
    >
  </li>
</ul>
                
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
                  </div><br><div class="bottom-txt text-center" style="padding:25px">
                  New to <?=_project_name_?>? <a class="bottom-link " href="<?=base_url(__signup__);?>">Create an account</a>
                </div>
                              <?php echo form_close() ?>
                        <?php */?>

<? if(!empty($username)){ ?>
        

   <div class="login-otp">
      <div>Please enter the OTP sent to</div>
      <div><span class="m-number"><?=$username?>.</span><a class="m-link" onclick="update_username()">Change</a></div>
      <?php echo form_open(base_url(__login__).'/loginAuth', array('method' => 'post', 'id' => 'login_form', 'name' => 'login_form', 'style' => '', 'accept-charset' => 'utf-8', 'class' => '', 'autocomplete' => 'off')); ?>
       <?
	  $username = set_value('username');
	   $attributes = array(
                'name'  => 'username',
                'id'  => 'username',
                'value' => $username,
                'class' => 'mb-input mb-input-bx mb-input-name mb-input-bx1',
                'autofocus' => 'autofocus',
                //'placeholder' => 'Email / Mobile Number',
                'style' => 'display:none',
                'type' => 'text',
                'required' => 'required'
                );
                echo form_input($attributes);?>
         <div class="m-code">
         <? for($i=1; $i<=6; $i++){$field_id = 'otp'.$i; ?>
            <div class="m-c-item">
                     <div class="mb-number mb-number">
                     <?
	  $value = set_value($field_id);
	   $attributes = array(
                'name'  => $field_id,
                'id'  => $field_id,
                'value' => $value,
                'class' => 'mb-input otpCl otpCl_'.$i,
                'autofocus' => 'autofocus',
                //'placeholder' => 'Email / Mobile Number',
                'type' => 'text',
                'data-id' => $i,
                'maxlength' => '1',
                'min' => '0',
                'required' => 'required'
                );
                echo form_input($attributes);?>
        <span class="mb-input-inner"></span>
        <label class="mb-input-label">
          <span></span></label>
        </div>
        <!--  <input maxlength="1" autocomplete="off" type="text" class="mc-input" required="" value="">
              <span class="mc-apsn"></span>
              <label class="mc-label"></label> -->
            </div>
         <? } ?>
           
         </div>
         <div class="mb-btn-code">
         <button class="mb-btn-inner mb-btn-inner1 mb-btn-inner2" type="submit">
            <div class="mb-btn-inner-content mb-btn-inner-content1">
               <svg class="" viewBox="25 25 50 50">
                  <circle stroke="#fff" class="" cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke-miterlimit="10"></circle>
               </svg>
            </div>
            <span>Verify</span>
         </button>
         
      </div>
      
      <?php echo form_close() ?>
      <a class="resend_otp" id="otp_func_e" style="display:none" onclick="password_change_otp_func_e()"><div class="otp-text-last" >Not received your code? <span>Resend code</span></div></a>
      <a class="resend_otp" id="otp_func_count_e" style="display:none" ></a>
   </div>
   <? }else{ ?>

<div>
   <?php echo form_open(base_url(__login__).'/loginAuth', array('method' => 'post', 'id' => 'login_form', 'name' => 'login_form', 'style' => '', 'accept-charset' => 'utf-8', 'class' => '', 'autocomplete' => 'off')); ?>
      <div class="mb-number">
      <?
	  $username = set_value('username');
	   $attributes = array(
                'name'  => 'username',
                'id'  => 'username',
                'value' => $username,
                'class' => 'mb-input mb-input-bx mb-input-name mb-input-bx1',
                'autofocus' => 'autofocus',
                //'placeholder' => 'Enter Email/Mobile number',
                'type' => 'text',
                'required' => 'required'
                );
                echo form_input($attributes);?>
	  
        <span class="mb-input-inner mb-input-bx"></span>
        <label class="mb-input-label mb-input-bx">
          <span>Enter Email/Mobile number</span>
        </label>
        <span class="mb-input-code">+91</span>
        <? if(!empty($username) && false){ ?>
        <a href="#" class="mb-input-code-inner mb-input-code-link" tabindex="-1">
          <span>Change?</span></a>
          <? } ?>
          
        </div>
     
      <?php /*?><div class="otp-bx">
        <span>OTP sent to Mobile</span>
        <a href="#" onclick="snackBar1()" class="mb-input-code-link mb-input-code-otplink" tabindex="-1">
          <span>Resend?</span>
        </a>
       
      </div>
      <div class="mb-number mb-number">
        <input maxlength="6" autocomplete="on" type="text" class="mb-input " value="">
        <span class="mb-input-inner"></span>
        <label class="mb-input-label">
          <span>Enter OTP</span></label>
        </div>
      <div class="mb-number mb-number">
        <input autocomplete="off" type="password" class="mb-input " value="">
        <span class="mb-input-inner"></span>
        <label class="mb-input-label">
          <span>Set Password</span>
        </label>
      </div><?php */?>
      
      <div class="mb-btn-code">
         <button class="mb-btn-inner mb-btn-inner1 mb-btn-inner2" type="submit">
            <div class="mb-btn-inner-content mb-btn-inner-content1">
               <svg class="" viewBox="25 25 50 50">
                  <circle stroke="#fff" class="" cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke-miterlimit="10"></circle>
               </svg>
            </div>
            <span>Request OTP</span>
         </button>
           <div class="privacy-text">By continuing, you agree to <?=_project_name_?>
                                <a class="privacy-link" target="_blank" href="<?=base_url(__terms_conditions__);?>">Terms of Use</a> and
                                 <a class="privacy-link" target="_blank" href="<?=base_url(__privacy_policy__);?>">Privacy Policy</a>.</div>
         <a href="<?=base_url(__signup__);?>"><button type="button"  class=" mb-btn-inner1 mb-btn1-inner-content"><span>New to <?=_project_name_?>? Create an account</span></button></a>
      </div>

   <?php echo form_close() ?>
</div>

<? } ?>

 </div>
</div>


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
		url:$('.siteUrl').val()+'login/loginAuth',
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
function update_username()
{
	$(".loader").css("display","block");
	$.ajax({
		type: "POST",
		//url:$('.siteUrl').val()+'products/loadMoreProduct',
		url:$('.siteUrl').val()+'login/loginAuth',
		/*dataType : "json",*/
		data : {'is_update_username':1},
			success : function(result){
				$('.loginForm').html(result);
				$(".loader").css("display","none");
				setRegisterForm();
			},
			error : function(result){
				alert("error");
				$(".loader").css("display","none");
			}
	});
}
<? if(!empty($is_call_counter)){ ?>


	myOTPTimer_e = setInterval(resend_otp_time_e, 1000);

<? } ?>
</script>
<? } ?>