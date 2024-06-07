<nav  class="breadcrumb ">
	<ol>
    	<li><a href="<?=base_url();1?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Forgot Password</span></li>
	</ol>
</nav>
      <div class="mt-5">
      <div class="container mb-5">
         <div class="row ">
            <div class=" col-md-6">
                <img src="<?=IMAGE;?>sign-up.jpg" class="loginleft">
            </div>
            <div class="col-md-5">
              
               <div class="empty1 mb-5">
                  <div class="row m-2 margnlft" >
                     <div class="col-sm-6 col-lg-12">
                        <div class="user-area">

                           <div class="user-item" id="profile_setting">
                              <?php echo form_open(base_url(__forgotPassword__), array('method' => 'post', 'id' => '', 'style' => '', 'class' => '', 'accept-charset' => 'utf-8', 'autocomplete' => 'off')); ?>
                              <?=$message?>
                                  <h2 class="form_headr1">Forgot Password</h2>
                                 <div class="form-group">
                                 	<?php 
                                                $attributes = array(
                                                'name'	=> 'email',
                                                'id'	=> 'email',
                                                'value'	=> set_value('email'),
                                                'class' => 'profil_form',
                                                'autofocus' => 'autofocus',
                                                'placeholder' => 'Enter Email Address',
                                                'type' => 'text',
                                                'required' => 'required'
                                                );
                                                echo form_input($attributes);?>
                                   
                                    <p> <a href="<?=base_url(__login__);?>">Back to login <i class="fa fa-long-arrow-left"></i></a></p>
                                 </div>
                                 
                                 <div class="" style=" margin:0 auto"> 

                                    <button class="btn common-btn1" name="doForegotPasswordBTN" value="1" type="submit">Continue</button>
                                 </div>
                              
<br>
       
  
                              
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
         