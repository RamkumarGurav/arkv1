 <?=$message?>
<div class="card">
  
  <div class="card-body">
    <h5 class="card-title manageGstInfo" data-id="0"><i class="fa fa-plus"></i> Add New GST Number</h5>
    <div class="add_edit_address_0 add_edit_address_cl" ></div>
  </div>
</div>

<? foreach($customer_gst_info_data->gst_info as $address){ ?>
<div class="card" style="margin-top:10px">
  <div class="card-header">
    <?=$address->company_name?>
    <div class="dropdown drp-dwm-custom show" style="float:right">
      <a role="button" id="dropdownMenuLink" aria-haspopup="true" aria-expanded="false">
       <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjE2IiB2aWV3Qm94PSIwIDAgNCAxNiI+CiAgICA8ZyBmaWxsPSIjODc4Nzg3IiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxjaXJjbGUgY3g9IjIiIGN5PSIyIiByPSIyIi8+CiAgICAgICAgPGNpcmNsZSBjeD0iMiIgY3k9IjgiIHI9IjIiLz4KICAgICAgICA8Y2lyY2xlIGN4PSIyIiBjeT0iMTQiIHI9IjIiLz4KICAgIDwvZz4KPC9zdmc+Cg==">
      </a>
    
      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item manageGstInfo" data-id="<?=$address->gst_info_id?>" >Edit</a>
       <?php /*?> <a class="dropdown-item" href="#">Delete</a><?php */?>
      </div>
    </div>
  </div>
  <div class="card-body">
    <h5 class="card-title"><?=$address->gst_number?></h5>
    <p class="card-text"><?=$address->company_name?></p>
    <div class="add_edit_address_cl add_edit_address_<?=$address->gst_info_id?>" ></div>
  </div>
</div>
<? } ?>