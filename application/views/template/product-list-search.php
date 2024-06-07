<?php
$min_final_price = 0;
$max_final_price = 0;
if(!empty($products_min_max_price))
{
	$min_final_price = $products_min_max_price[0]['min_final_price'];
	$max_final_price = $products_min_max_price[0]['max_final_price'];
}

$manufacturer_id_arr = array();
if(!empty($_POST['manufacturer_id']))
{
	$manufacturer_id_arr = $_POST['manufacturer_id'];
}
?>
<script>
//f_brand_aj cl
$('#brand').show();
$('#Stock').show();
<? if($p_search_by!='brand' && false){ ?>
	$('.f_brand_aj').html('');
	
	<? $md_count=0; foreach($manufacturer_data as $md){$md_count++; ?>
		<? 
		$checked = '';
		if(in_array($md->manufacturer_id , $search_manufacturer_data)){ $checked = 'checked="checked"';}
		?>
	$('.f_brand_aj').append('	<li> 		<input onchange="$(\'#p_search_by\').val(\'brand\');searchProduct()" <?=$checked?> type="checkbox" name="manufacturer_id[]" class="checkbox-custom search_att" id="md_<?=$md_count?>" value="<?=$md->manufacturer_id?>" data-attparent="Brand"  data-attchild="<?=addslashes($md->manufacturer_name)?>">		<label class="checkbox-custom-label" for="md_<?=$md_count?>"><?=addslashes($md->manufacturer_name)?></label>	</li>');
	<? } ?>

<? } ?>

<? if(empty($manufacturer_data)){ ?>
$('#brand').hide();
<? } ?>
//alert('<?=$p_search_by?>');

<? if($p_search_by!='price'){ ?>

var c_max_final_price = <?=ceil($max_final_price)?>;
var r_min_final_price = <?=round($min_final_price)?>;
$("#c_max_final_price").val('<?=ceil($max_final_price)?>')
$("#r_min_final_price").val('<?=round($min_final_price)?>')

<?php /*?>$("#slider-range").slider({
		range: true,
		orientation: "horizontal",
		min: r_min_final_price,
		max: c_max_final_price,
		values: [0, c_max_final_price],
		step: 1,

		slide: function (event, ui) {
		  if (ui.values[0] == ui.values[1]) {
			  return false;
		  }
		  
		  $("#min_price").val(ui.values[0]);
		  $("#max_price").val(ui.values[1]);
		},
		stop: function( event, ui ) {$('#p_search_by').val('price');searchProduct();}
	  });

	  $("#min_price").val($("#slider-range").slider("values", 0));
	  $("#max_price").val($("#slider-range").slider("values", 1));<?php */?>
<? } ?>

//filter_attr_li_
$('.filter_attr_all').hide();
<? if(!empty($attribute)){
							$att_count=0;
							foreach($attribute as $a){
								//echo "<pre>";print_r($a);echo "</pre>";
							if(!empty($a->attributeVal) && $p_search_by!='filter_attr_'.$a->product_attribute_id){
								?>
								
$('.filter_attr_<?=$a->product_attribute_id?>').show();
							<?
							$att_count++;
							 ?>
							<?php /*?><div class="clearfilter"><a href="#">Clear Filter</a></div><?php */?>
$('.filter_attr_li_<?=$a->product_attribute_id?>').html('');
							<? 
                                foreach($a->attributeVal as $av){
									
                            ?>
                                <? 
                            $checked = '';
							//print_r($f_attr_val);
                            if(in_array($av->product_attribute_value_id , $f_attr_val)){ 
								if(in_array($av->combination_value , $QsearchVal)){ 
									$checked = 'checked="checked"';
								}
							
							}
                            
                            $atter_val = json_encode(array('product_attribute_value_id'=>$av->product_attribute_value_id , 'combination_value'=>$av->combination_value));

                            ?>
							
                               $('.filter_attr_li_<?=$a->product_attribute_id?>').append(' <li>    <input onchange="$(\'#p_search_by\').val(\'f_attr_<?=$a->product_attribute_id?>\');searchProduct()" <?=$checked?> value=\'<?=$atter_val?>\' id="att_check_<?=$av->product_attribute_value_id?>" name="search<?=$a->product_attribute_id?>[]" type="checkbox<? //=$a->type?>" data-attparent=\'<?=$a->name ?>\'  data-attchild=\'<?=$av->name ?>\' class="checkbox-custom search_att">                                    <label class="checkbox-custom-label" for="att_check_<?=$av->product_attribute_value_id?>"><?=$av->combination_value?> <?=$av->name?></label>                                </li> ');
                              <? } ?>
                            
                 <? }}} ?>

</script>
