<? if(!empty($user->address)){$customer_address_data = $user;} ?>
<? if(!empty($customer_address_data)){ ?>
<? foreach($customer_address_data->address as $address){
	if($address->billing_status ==1)
	{
	 ?>
     
     <div class="select-delivery">
                <div class="select-delivery-inner">
                    <div class="delivery-username"><?=$address->name?></div>
                    <span>, <?=$address->zipcode?></span>
                    <span class="delivery-type"><?=$address->address_type?></span>
                </div>
                <p class="select-delivery-desc"><?=$address->address?>, <?=$address->city_name?>, <?=$address->state_name?> </p>
            </div>

<? } ?>
<? } ?>
<? } ?>
