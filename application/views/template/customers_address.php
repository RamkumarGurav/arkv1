 <?=$message?>
<div class="card">
  
  <div class="card-body">
    <h5 class="card-title manageAddress" data-id="0"><i class="fa fa-plus"></i> ADD NEW ADDRESS</h5>
    <div class="add_edit_address_0 add_edit_address_cl" ></div>
  </div>
</div>

<? foreach($customer_address_data->address as $address){ ?>
<div class="card" style="margin-top:10px">
  <div class="card-header">
    <?=$address->address_type?>
    <div class="dropdown drp-dwm-custom show" style="float:right">
      <a role="button" id="dropdownMenuLink" aria-haspopup="true" aria-expanded="false">
       <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjE2IiB2aWV3Qm94PSIwIDAgNCAxNiI+CiAgICA8ZyBmaWxsPSIjODc4Nzg3IiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxjaXJjbGUgY3g9IjIiIGN5PSIyIiByPSIyIi8+CiAgICAgICAgPGNpcmNsZSBjeD0iMiIgY3k9IjgiIHI9IjIiLz4KICAgICAgICA8Y2lyY2xlIGN4PSIyIiBjeT0iMTQiIHI9IjIiLz4KICAgIDwvZz4KPC9zdmc+Cg==">
      </a>
    
      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item manageAddress" data-id="<?=$address->customers_address_id?>" >Edit</a>
       <?php /*?> <a class="dropdown-item" href="#">Delete</a><?php */?>
      </div>
    </div>
  </div>
  <div class="card-body">
    <h5 class="card-title"><?=$address->name?> &nbsp;&nbsp;&nbsp;&nbsp;<?=$address->number?></h5>
    <p class="card-text"><?=$address->address?></p>
    <p class="card-text"><?=$address->city_name?>, <?=$address->state_name?> - <?=$address->zipcode?></p>
    <?php /*?><a href="#" class="btn btn-primary">Go somewhere</a><?php */?>
    <div class="add_edit_address_cl add_edit_address_<?=$address->customers_address_id?>" ></div>
  </div>
</div>
<? } ?>