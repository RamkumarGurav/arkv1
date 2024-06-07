<section class="brdcrm-bck"><div class="container"><a href="<?=base_url();?>" title="Back to the frontpage">Home</a><span aria-hidden="true" class="breadcrumb__sep"> / </span><span>Contact Us</span></div></section>

<div id="greenfield-section-template--14390924279842__main" class="greenfield-section">
	<div class=" contact-page">
    	<div class="row">
        	<h2> Contact Form </h2>
        	<div class="col-lg-3">
            	<ul class="dt-contact-iconblock-section ">
                	<li class="dt-contact-icon-block">
                    	<div class="dt-contact-icon-image"><i class="fa fa-phone"></i></div>
                        <div class="dt-contact-icon-content"><h4>Phone</h4><p>  <b>Toll-Free: </b> <?=_project_contact_?> </p></div>
          			</li>
                    <li class="dt-contact-icon-block">
                    	<div class="dt-contact-icon-image"><i class="fa fa-envelope"></i></div>
                        <div class="dt-contact-icon-content"><h4>Email</h4><p><?=_project_email_?></p></div>
          			</li>
                    <li class="dt-contact-icon-block">
                    	<div class="dt-contact-icon-image"><i class="fa fa-location-arrow"></i></div>
                        <div class="dt-contact-icon-content"><h4>Address</h4><p><?=_project_address_?></p></div>
					</li>
				</ul>
			</div>
            <div class="col-lg-4"><div id="map mt-3"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3887150.3253291342!2d75.30627358359817!3d17.930043778181616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcc69d4bbcd1f19%3A0xc5363cbd4f4f4875!2sSri%20annadatha%20rythu%20seva%20kendram!5e0!3m2!1sen!2sin!4v1693946883138!5m2!1sen!2sin"  referrerpolicy="no-referrer-when-downgrade" width="1920" height="550" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div></div>
            <div class="col-lg-5">
            	<div class="contact-form-section">
                	<h2>  </h2>
                   	<?php echo form_open(base_url().'doContact', array('method' => 'post', 'id' => 'contact_form' , "name"=>"contact_form", 'enctype' => 'multipart/form-data', 'class' => '', 'role' => 'form')); ?>
                		<?php echo $message; ?>
                		<label class="label2">Your Name</label>
                        <?php 
								$attributes = array(
								'name'	=> 'name',
								'id'	=> 'name',
								'value'	=> set_value('name'),
								'class' => 'input-full',
								'placeholder' => 'Name',
								'type' => 'text',
								'required' => 'required'
								);
								echo form_input($attributes);?>


								<label class="label2">Your Email</label>
                    	
                        <?php 
								$attributes = array(
								'name'	=> 'email',
								'id'	=> 'email',
								'value'	=> set_value('email'),
								'placeholder' => 'Email',
								'class' => 'input-full',
								'type' => 'email',
								'required' => 'required'
								);
								echo form_input($attributes);?>


								<label class="label2"> Mobile Number</label>
                                
                        <?php 
									$attributes = array(
									'name'	=> 'mobile_no',
									'id'	=> 'mobile_no',
									'value'	=> set_value('mobile_no'),
									'class' => 'input-full',
									'placeholder' => 'Mobile Number',
									'type' => 'number',
									'pattern' => '[0-9]{10,10}',
									'title' => 'Enter only number between 0-9',
									'required' => 'required'
									);
									echo form_input($attributes);?>
                         
                        <label class="label2"> Subject</label>
                        <?php $attributes = array(); ?>
                                <?php 
						$subject_arr[""] = "Select Subject";
						$subject_arr["Bulk Inquiry"] = "Bulk Inquiry";
						$subject_arr["Custom Blend Inquiry"] = "Custom Blend Inquiry";
						$subject_arr["Export Inquiry"] = "Export Inquiry";
						$subject_arr["Others"] = "Others";
										$value=set_value('subject');
										$attributes = array(
										'name'	=> 'subject',
										'id'	=> 'subject',
										'title' => "Select Subject",
										'tabindex' => '11',
										'class' => 'input-full',
										'style' => 'width:100%',
										'required' => 'required'
										);
										echo form_dropdown($attributes , $subject_arr , $value );?>   

                        <label class="label2">Message</label>
                        <?php 
									$attributes = array(
									'name'	=> 'message',
									'id'	=> 'message',
									'value'	=> set_value('message'),
									'class' => 'input-full',
									'placeholder' => 'Requirement',
									'type' => 'text',
									'style' => 'height: 150px',
									'required' => 'required'									
									);
									echo form_textarea($attributes);?>
                        <button type="submit" class="dt-sc-btn" name="sendEnquiry" value="1">Send Message</button>
					<?php echo form_close() ?>   
        		</div>
     		</div>
      	</div> <br><br>
     </div>
</div>