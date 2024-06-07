<nav  class="breadcrumb ">
	<ol>
    	<li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Profile</span></li>
	</ol>
</nav>
      <div class="mt-5">
      <div class="container">
         <div class="row ">
            <?php $this->load->view('template/left-menu', $this->data);?>
            <div class="col-md-9">
               <h4 class="form_headr1">Personal Information</h4>
               <div class="empty1 mb-5">
                  <div class="row m-2">
                     <div class="col-sm-6 col-lg-12">
                        <div class="user-area">
                           <div class="user-item" id="profile_setting">
                           		<?=$this->session->flashdata('message')?>
                                <?php echo form_open('#', array('method' => 'post', 'id' => 'personal_info_form', 'onsubmit' => 'javascript: update_profile()', 'class' => '', 'accept-charset' => 'utf-8', 'autocomplete' => 'off')); ?>	
                              
                                 <div class="form-group">
                                    <?php 
                                        $value = set_value('first_name');
                                        if(empty($value)){//$value = $profile->first_name;
										}
                                            $attributes = array(
                                            'name'	=> 'first_name',
                                            'id'	=> 'first_name',
                                            'value'	=> $value,
                                            'class' => 'profil_form',
											'placeholder' => 'First Name and Last Name',
                                            'autofocus' => 'autofocus',
                                            'type' => 'text',
                                            'required' => 'required'
                                            );
                                            echo form_input($attributes);?>
                                 </div>
                                 <div class="form-group">
                                    
                                    <?php 
                                            $value = set_value('number');
                                            if(empty($value)){//$value = $profile->number;
											}
                                                $attributes = array(
                                                'name'	=> 'number',
                                                'id'	=> 'profile_number',
                                                'value'	=> $value,
												'placeholder' => 'Your Mobile Number',
                                                'class' => 'profil_form',
                                                'type' => 'text',
                                                'pattern' => '[0-9]{8,15}',
                                                'title' => 'Enter only number between 0-9',
                                                'required' => 'required'
                                                );
                                                echo form_input($attributes);?>
                                 </div>
                                 <div class="form-group">
                                    <?php 
                                        $value = set_value('email');
                                        if(empty($value)){//$value = $profile->email;
										}
                                            $attributes = array(
                                            'name'	=> 'email',
                                            'id'	=> 'profile_email',
                                            'value'	=> $value,
											'placeholder' => 'Your Mail ID',
                                            'class' => 'profil_form',
                                            'type' => 'email',
                                            'required' => 'required'
                                            );
                                            echo form_input($attributes);?>
                                 </div>
                                 <div class="d-flex justify-content-between0" style=" margin:0 auto"> 
                                    <button name="updateUserInfoBTNName"  value="1" type="submit" class="btn common-btn">Update</button>
                                    
                                 </div>
                              <?php form_close();?>
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
         