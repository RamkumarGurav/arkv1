<? if(!empty($customer_address_data->address)){ ?>
<div class="row">
<? foreach($customer_address_data->address as $address){ ?>
	<div class="address-row-bg" style="margin-top:10px">
    <label class="row ">
        <div class="col-lg-1 col-1">
            <input type="radio" class="hide-div-radio address_radio" data-id='<?=$address->customers_address_id?>'  data-idval='<?=$address->customers_address_id?>' id="<?=$address->customers_address_id?>" name="address" readonly="" <? 	if($address->customers_address_id ==$this->session->userdata('application_sess_cart_page_selected_address_id')){?> checked <? } ?>> 
        </div>
        <div class="col-lg-11 col-11">
            <div class="select-delivery">
                <div class="select-delivery-inner">
                    <div class="delivery-username"><?=$address->name?></div>
                    <span>, <?=$address->zipcode?></span>
                    <span class="delivery-type"><?=$address->address_type?></span>
                </div>
                <p class="select-delivery-desc"><?=$address->address?>, <?=$address->city_name?>, <?=$address->state_name?> </p>
            </div>
        </div>
        </label>
    </div>
    
<? } ?>
</div>
<? } ?>
