<? if(!empty($user->address)){$customer_address_data = $user;} ?>
<? if(!empty($customer_address_data)){ ?>
<? foreach($customer_address_data->address as $address){
	if($address->billing_status ==1)
	{
	 ?>

<span class="span2"><?=$address->address_type?></span>
<span class="span1"><?=$address->name?></span>
<span class="span3"><?=$address->number?></span>

<span class="span4"><?=$address->address?>, <?=$address->city_name?>, <?=$address->state_name?> 
<span class="span5"><?=$address->zipcode?></span>
</span>
<? } ?>
<? } ?>
<? } ?>
