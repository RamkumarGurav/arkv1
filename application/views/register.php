<nav  class="breadcrumb ">
	<ol>
    	<li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Register</span></li>
	</ol>
</nav>
      <div class="mt-1">
      <div class="container mb-5">
      	<div class="row login-width md-flex align-items-center justify-content-center">
            <div class=" col-md-5 pddng0">
               <div class="login-leftside">
                <span class="span-text"><span>Looks like you're new here!</span></span>
                <p class="para"><span>Sign up with your mobile number to get started</span></p>
               </div>
            </div>
            <div class="col-md-7 pddng0">
<h2 class="text-center mt-3">New User Sign Up</h2>
               <div class="empty1 login-right-side mb-5">
                  <div class="row ">

                       <!-- <h4 class="form_headr1">Login Details</h4> -->
<!-- Pills navs -->

<!-- Pills navs -->

<!-- Pills content -->

<!-- Pills content -->
                      

<div class="col-sm-6 col-lg-12 registerForm">
                        
                             <?php $this->load->view('template/register-form' , $this->data); ?>
                        </div>

                     
                     </div>
                  </div>
               </div>
            </div>
         <!-- <div class="row ">
            <div class=" col-md-6">
                <img src="<?=IMAGE?>sign-up.jpg" class="loginleft">
            </div>
            <div class="col-md-5">
              
               <div class="empty1 mb-5">
                  <div class="row m-2 margnlft">
                      <h2 class="form_headr1">Sign Up</h2>
                     <div class="col-sm-6 col-lg-12 paddg0">
                        <div class="user-area">

						<div class="user-item" id="profile_setting">
                        	<?php echo form_open(base_url(__signup__).'/addUser', array('method' => 'post', 'id' => '' , "name"=>"", 'enctype' => 'multipart/form-data', 'class' => '', 'accept-charset' => 'utf-8', 'autocomplete' => 'off')); ?>
                            <?php echo $message; ?>
                            <div class="form-group">
                            	<?php 
								$attributes = array(
								'name'	=> 'name',
								'id'	=> 'name',
								'value'	=> set_value('name'),
								'class' => 'profil_form',
								'placeholder' => 'Name',
								'autofocus' => 'autofocus',
								'type' => 'text',
								'required' => 'required'
								);
								echo form_input($attributes);?>
                                
                                <?php 
								$attributes = array(
								'name'	=> 'email',
								'id'	=> 'email',
								'value'	=> set_value('email'),
								'placeholder' => 'Email',
								'class' => 'profil_form',
								'type' => 'email',
								'required' => 'required',
								'onfocusout' => "validate_email('no')" 
								);
								echo form_input($attributes);?>
                                
                                <?php 
									$attributes = array(
									'name'	=> 'mobile_no',
									'id'	=> 'mobile_no',
									'value'	=> set_value('mobile_no'),
									'class' => 'profil_form',
									'placeholder' => 'Mobile Number',
									'type' => 'number',
									'pattern' => '[0-9]{10,10}',
									'title' => 'Enter only number between 0-9',
									'required' => 'required',
									'onfocusout' => "validate_mobile('no')"
									);
									echo form_input($attributes);?>
                                
                                <?php
									$attributes = array(
									'name'	=> 'password',
									'id'	=> 'password',
									'value'	=> set_value('password'),
									'placeholder' => 'Enter Password',
									'class' => 'profil_form',
									'type' => 'password',
									'required' => 'required'
									);
									echo form_input($attributes);?>    
                                    
                                    
                                    <p class="hereby">Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="<?=base_url();?>privacy-policy"  target="_blank">privacy policy</a>.</p> 
                                 </div>
                                 <br>
                                 <div class="d-flex justify-content-between" style=" margin:0 auto"> 
                                    <p><a href="<?=base_url(__login__);?>" class="bcklog">Back to login <i class="fa fa-long-arrow-left"></i></a></p>
                                    <button type="submit" class="btn common-btn1" name="sendRegistration" id="sendRegistration" value="1" >Submit </button>
                                 </div>
                              <?php echo form_close() ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div> -->
      </div>
      <div id="smartblog_block" class="block products_block hb-animate-element bottom-to-top hb-in-viewport">
         <div class="container">
         </div>
         <link href="<?=CSS?>login.css" rel="stylesheet">
         
         


<script>
window.addEventListener("load", function(){
	setRegisterForm();
})

function setRegisterForm(){
	$( "#registration_form" ).submit(function( event ) {
		//alert( "Handler for .submit() called." );
		event.preventDefault();
		$(".loader").css("display","block");
		$.ajax({
			type: "POST",
			//url:$('.siteUrl').val()+'products/loadMoreProduct',
			url: '<?=base_url(__signup__).'/auth'?>',
			/*dataType : "json",*/
			data : $('#registration_form').serialize(),
			success : function(result){
				$('.registerForm').html(result);
				$(".loader").css("display","none");
				setRegisterForm();
			},
			error : function(result){
				alert("error");
				$(".loader").css("display","none");
			}
		});
	});
}
</script>

