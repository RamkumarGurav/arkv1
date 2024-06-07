<nav  class="breadcrumb ">
	<ol>
    	<li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Change Password</span></li>
	</ol>
</nav>
      <div class="mt-5">
      <div class="container">
         <div class="row">
         	<? $this->load->view('template/left-menu' , $this->data); ?>
            
            <div class="col-md-9">
               <h4 class="form_headr1">Change Password</h4>
               <div class="empty1 mb-5">
                  <div class="row m-2">
                 <div class="col-sm-6 col-lg-12">
            <div class="user-area">
           
            <div class="user-item">
             
                    <?php echo form_open(base_url(__changePassword__).'', array('method' => 'post', 'id' => '', 'style' => '', 'class' => '', 'accept-charset' => 'utf-8', 'autocomplete' => 'off')); ?>
				<?=$message?>
            <div class="form-group">
            <?php 
								$attributes = array(
								'name'	=> 'old_password',
								'id'	=> 'old_password',
								'value'	=> set_value('old_password'),
								'class' => 'profil_form',
								'placeholder' => 'Type Current Password',
								'type' => 'password',
								'required' => 'required'
								);
								echo form_input($attributes);?>
   
            </div>
             <div class="form-group">
            <?php 
								$attributes = array(
								'name'	=> 'password',
								'id'	=> 'password',
								'value'	=> set_value('password'),
								'class' => 'profil_form',
								'type' => 'password',
								'placeholder' => 'Type New Password',
								'required' => 'required'
								);
								echo form_input($attributes);?>	
   
            </div>
            <div class="form-group">
            <?php 
							$attributes = array(
							'name'	=> 'confirm_password',
							'id'	=> 'password-field',
							'value'	=> set_value('confirm_password'),
							'class' => 'profil_form',
							'placeholder' => 'Retype New Password  ',
							'type' => 'password',
							'required' => 'required'
							);
							echo form_input($attributes);?>
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
   
            </div>
             <div class="form-group">
             <?php 
								$attributes = array(
								'name'	=> 'otp',
								'id'	=> 'otp',
								'value'	=> set_value('otp'),
								'class' => 'profil_form',
								'type' => 'text',
								'placeholder' => 'Enter OTP',
								'required' => 'required'
								);
								echo form_input($attributes);?>	
   
            </div>

            <div class="d-flex justify-content-between">
              <h5><span>
              	<a class="resend_otp" style="cursor: pointer" id="otp_func" onclick="password_change_otp_func()">Click to get OTP</a>
				<a class="resend_otp" id="otp_func_count" style="display:none" ></a>
                                
                                </span><br><br> </h5>
            <button name="changePasswordInfoBTN" id="changePasswordInfoBTN" value="1" type="submit" class="btn common-btn">Update</button>

            </div>
            <?php echo form_close() ?>
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
<script>
clearInterval(myOTPTimer);
var time_sec = 20;

//var myOTPTimer = setInterval(resend_otp_time, 1000);

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
	  $('#otp_func').html('Resend OTP');
  }
}

function password_change_otp_func()
{
	$(".loader").css("display","block");
	$.ajax({
		type: "POST",
		//url:$('.siteUrl').val()+'products/loadMoreProduct',
		url:$('.siteUrl').val()+'Dashboard/resend_otp',
		/*dataType : "json",*/
		data : {},
		success : function(result){
			time_sec = 20;
			$('#otp_func').hide();
			myOTPTimer = setInterval(resend_otp_time, 1000);
			$(".loader").css("display","none");
		}
	});
}



$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
</script>