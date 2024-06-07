<div class="">
<? if(!empty($customer_address_data->gst_info)){ ?>
<div class="row gstList">
<? foreach($customer_address_data->gst_info as $gst_info){ ?>
	<div style="margin-top:10px">
    <label class="row ">
        <div class="col-lg-1 col-1">
            <input type="radio" class="hide-div-radio payment_gst_info_radio" <? if($gst_info->selected_for_order == 1){echo "checked";} ?> data-id='<?=$gst_info->gst_info_id?>'  data-idval='<?=$gst_info->gst_info_id?>' id="<?=$gst_info->gst_info_id?>" name="address" readonly="" <? 	if($gst_info->gst_info_id ==$this->session->userdata('application_sess_cart_page_selected_address_id')){?> checked <? } ?>> 
        </div>
        <div class="col-lg-11 col-11">
            <div class="select-delivery">
                <div class="select-delivery-inner">
                    <div class="delivery-username"><?=$gst_info->gst_number?> | <?=$gst_info->company_name?></div>
                </div>
            </div>
        </div>
        </label>
    </div>
    
<? } ?>
</div>
<? } ?>

<button class="btn btn-info paymentGSTBtn" onclick="paymentGSTBtnFunc()">Add new gst number</button>

<div class="manage-class-inner row paymentGSTDiv" style="display:none">
<div class="gst_message"></div>
<?php echo form_open(base_url().__shippingAddress__, array('method' => 'post', 'id' => 'gst_info_form', 'onsubmit' => 'gst_info_form_submit()', 'style' => 'display:block;', 'class' => 'shping-add')); ?>
            <div class="col-lg-12">
                <div class="mng-form-inner">
                    <?php 
					$value = set_value('gst_number');
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
               <div class="col-lg-12">
                 <div class="mng-form-inner">
                    <?php 
					$value = set_value('company_name');
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
                 <div class="save-btns">
            <button type="submit" id="submit" name="AddressSaveBTN" value="1" class="save-btn">Save </button> 
            <button class="cancel-btn cancelBTN" onclick="paymentGSTBtnFunc()" type="button" tabindex="11" >CANCEL</button></div>
          </div>
        <?php echo form_close() ?>
              </div>
<script>
function paymentGSTBtnFunc(){
	$(".paymentGSTDiv").toggle();
	$(".paymentGSTBtn").toggle();
	$(".gstList").toggle();
}
</script>
