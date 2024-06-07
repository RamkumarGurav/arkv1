<?
$gst_info_id = (!empty($gst_info[0]->gst_info_id))?$gst_info[0]->gst_info_id:0;
?>


<span class="m-address">Manage Address</span>
     <div class="manage-address">
      <div class="manage-address-inner">
        <?php echo form_open(base_url().__shippingAddress__, array('method' => 'post', 'id' => 'gst_info_form', 'style' => 'display:block;', 'class' => 'shping-add')); ?>
        <?php 
                            $attributes = array(
                            'name'	=> 'gst_info_id',
                            'id'	=> 'gst_info_id',
                            'value'	=> $gst_info_id,
                            'type' => 'hidden'
                            );
                            echo form_input($attributes);?>
           
          <span class="manage-add"><?=($gst_info_id>0)?"UPDATE GST INFORMATION":"ADD A NEW GST INFORMATION"?></span>
          <div class="manage-class-inner row">
          <?=$message?>
            <div class="col-lg-6">
                <div class="mng-form-inner">
                    <?php 
					$value = set_value('gst_number');
					if(empty($value)){
						$value = (!empty($gst_info[0]->gst_number))?$gst_info[0]->gst_number:'';
					}
                            $attributes = array(
                            'name'	=> 'gst_number',
                            'id'	=> 'gst_number0',
                            'minlength'	=> 15,
                            'maxlength'	=> 16,
                            'value'	=> $value,
                            'class' => 'mng-form-inpt',
                            'autofocus' => 'autofocus',
                            'type' => 'text',
                            'required' => 'required'
                            );
                            echo form_input($attributes);?>
                            <label for="gst_number0" class=" mng-form-label">GST Number</label>
                </div>
              </div>
               <div class="col-lg-6">
                 <div class="mng-form-inner">
                    <?php 
					$value = set_value('company_name');
					if(empty($value)){
						$value = (!empty($gst_info[0]->company_name))?$gst_info[0]->company_name:'';
					}
                            $attributes = array(
                            'name'	=> 'company_name',
                            'id'	=> 'company_name0',
                            'value'	=> $value,
                            'class' => 'mng-form-inpt',
                            'type' => 'text',
                            'required' => 'required'
                            );
                            echo form_input($attributes);?>
                            <label for="company_name0" class=" mng-form-label">Company Name</label>
                </div>
                 </div>
              </div>
             

          <div class="save-btns">
            <button type="submit" id="submit" name="AddressSaveBTN" value="1" class="save-btn">Save </button> 
            <button class="cancel-btn cancelBTN" type="button" tabindex="11" data-id="<?=$gst_info_id?>">CANCEL</button></div>
          </div>
        <?php echo form_close() ?>
      </div>

     </div>
<div class="paddng-12"> </div>