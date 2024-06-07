<?
foreach($footer_category as $fc){
?>
<li><a href="<?=base_url().$fc->slug_url?>"><?=$fc->name?></a></li>
<? } ?>