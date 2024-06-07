<style>


p {
  padding: 0;
  margin: 0;
}



.filter-price {
  width: 220px;
  border: 0;
  padding: 0;
  margin: 0;
}

.price-title {
  position: relative;
  color: #fff;
  font-size: 14px;
  line-height: 1.2em;
  font-weight: 400;
  background: #d58e32;
  padding:10px;
}

.price-container {
      display: flex;
    border: 1px solid #ccc;
    padding: 5px;
/*    margin-left: 35px;*/

  width:fit-content
}

.price-field {
  position: relative;
  width: 100%;
  height: 36px;
  box-sizing: border-box;
  padding-top: 15px;
  padding-left: 0px;
}

.price-field input[type=range] {
    position: absolute;
}

/* Reset style for input range */

.price-field input[type=range] {
  width: 100%;
    height: 7px;
border: 6px solid #22564b !important;
    outline: 0;
    box-sizing: border-box;
    border-radius: 5px;
    pointer-events: none;
    -webkit-appearance: none;
/*    background: #b2c310 !important;*/
}

.price-field input[type=range]::-webkit-slider-thumb {
    -webkit-appearance: none;
}

.price-field input[type=range]:active,
.price-field input[type=range]:focus {
  outline: 0;
}

.price-field input[type=range]::-ms-track {
  width: 188px;
  height: 2px;
  border: 0;
  outline: 0;
  box-sizing: border-box;
  border-radius: 5px;
  pointer-events: none;
  background: transparent;
  border-color: transparent;
  color: red;
  border-radius: 5px;
}

/* Style toddler input range */

.price-field input[type=range]::-webkit-slider-thumb {
  /* WebKit/Blink */
    position: relative;
    -webkit-appearance: none;
    margin: 0;
    border: 0;
    outline: 0;
    border-radius: 50%;
    height: 10px;
    width: 10px;
    margin-top: -4px;
    background-color: #b2c310;
    cursor: pointer;
    cursor: pointer;
    pointer-events: all;
    z-index: 100;
}

.price-field input[type=range]::-moz-range-thumb {
  /* Firefox */
  position: relative;
  appearance: none;
  margin: 0;
  border: 0;
  outline: 0;
  border-radius: 50%;
  height: 10px;
  width: 10px;
  margin-top: -5px;
  background-color: #fff;
  cursor: pointer;
  cursor: pointer;
  pointer-events: all;
  z-index: 100;
}

.price-field input[type=range]::-ms-thumb  {
  /* IE */
  position: relative;
  appearance: none;
  margin: 0;
  border: 0;
  outline: 0;
  border-radius: 50%;
  height: 10px;
  width: 10px;
  margin-top: -5px;
  background-color: #242424;
  cursor: pointer;
  cursor: pointer;
  pointer-events: all;
  z-index: 100;
}

/* Style track input range */

.price-field input[type=range]::-webkit-slider-runnable-track {
  /* WebKit/Blink */
  width: 188px;
  height: 2px;
  cursor: pointer;
  background: #555;
  border-radius: 5px;
}

.price-field input[type=range]::-moz-range-track {
  /* Firefox */
  width: 188px;
  height: 2px;
  cursor: pointer;
  background: #242424;
  border-radius: 5px;
}

.price-field input[type=range]::-ms-track {
  /* IE */
  width: 188px;
  height: 2px;
  cursor: pointer;
  background: #242424;
  border-radius: 5px;
}

/* Style for input value block */

.price-wrap {
/*  display: flex;*/
  color: #242424;
  font-size: 14px;
  line-height: 1.2em;
  font-weight: 400;
  margin-bottom: 0px;
}

.price-wrap-1,
.price-wrap-2 {
  display: flex;
  margin-left: 0px;
}

.price-title {
  margin-right: 5px;
}

.price-wrap_line {
    margin: 6px 20px 5px 5px;
}

.price-wrap #one,
.price-wrap #two {
  width: 50px;
    /* text-align: right; */
    margin: 0;
    padding: 0;
    margin: 4px;
    background: 0;
    border: 0;
    outline: 0;
    color: #242424;

    font-size: 17px;
    line-height: 1.2em;
    font-weight: 600;
}

.price-wrap label {
    text-align: right;
    margin-top: 6px;
    padding-left: 5px;
}

/* Style for active state input */

.price-field input[type=range]:hover::-webkit-slider-thumb {
  box-shadow: 0 0 0 0.5px #242424;
  transition-duration: 0.3s;
}

.price-field input[type=range]:active::-webkit-slider-thumb {
  box-shadow: 0 0 0 0.5px #242424;
  transition-duration: 0.3s;
}
</style>
<input type="hidden" name="c_max_final_price" id="c_max_final_price" value="<?=ceil($max_final_price)?>" />
<input type="hidden" name="r_min_final_price" id="r_min_final_price" value="<?=round($min_final_price)?>" />
<?

$cat_name = '';
if(!empty($current_category->name))
{
	$cat_name = $current_category->name;
}

$searchSugg = '';
		if(!empty($_REQUEST['searchSugg']))
		{
			$searchSugg = $_REQUEST['searchSugg'];
		}
?>
<? //echo $breadcrumbs; ?>
<form id="prd_search_form" name="prd_search_form" action="" method="post" >
<?
$att_count=0;
if(!empty($super_sub_cat)){$attribute_cat = $super_sub_cat;$sub_cat='';$main_cat='';}
else if(!empty($sub_cat)){$attribute_cat = $sub_cat;$super_sub_cat='';$main_cat='';}
else if(!empty($main_cat)){$attribute_cat = $main_cat;$sub_cat='';$super_sub_cat='';}
?>
<input type="hidden" name="main_cat_search" id="main_cat_search" value="<?=$main_cat?>" />
<input type="hidden" name="sub_cat_search" id="sub_cat_search" value="<?=$sub_cat?>" />
<input type="hidden" name="super_sub_cat_search" id="super_sub_cat_search" value="<?=$super_sub_cat?>" />
<input type="hidden" name="searchSugg" id="searchSugg" value="<?=$searchSugg?>" />
<input type="hidden" name="offset" id="offset" value="0" />
<input type="hidden" name="callFor" id="callFor" value="loadMore" />
<input type="hidden" name="p_search_by" id="p_search_by" value="" />
 <nav class=" text-center" aria-label="breadcrumbs">
      <div class="container">

      </div>
   </nav>


         <div class="container mb-4">
            <div class="row ">

               <div  class="banner_col1">

<? if($check_screen == 'isdesktop'){ ?>
                  <div class="StickySidebar">
                     <div class="left-column">
                        <div id="search_filters_wrapper" style="overflow-y: scroll;
    max-height: 83vh;">
                           <div id="search_filters">
                              <div class="facet clearfix">

                                 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


                                 	<?
									//echo "<pre>"; print_r($left_nav_category); echo "</pre>"; exit;
									if(!empty($left_nav_category))
									{

										 ?>

                                    <div class="panel panel-default panel-custom ">
                                       <p class="text-uppercase h6 hidden-sm-down">Filter By</p>
                                       <div class="panel-heading" role="tab" id="category">
                                          <h4 class="panel-title">
                                             <a role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <i class="more-less glyphicon glyphicon-minus"></i>
                                                <p class="h6 facet-title hidden-sm-down">Categories</p>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="collapseOne">
                                          <div class="panel-body" >
                                             <ul class="categories-list categories-list-scroll height-scroll">
                                             	<?
									$count1=0;
									$count2=0;
									$count3=0;
									foreach($left_nav_category as $mc){$count1++;
									$category_link = MAINSITE."all-products/$mc->category_id";
									if(!empty($mc->slug_url)){$category_link = MAINSITE."$mc->slug_url"; }
									 ?>
										<li>
											<a href="<?=$category_link?>"><i class="fa fa-circle"></i>
                                             <? if($l_main_cat==$mc->category_id){echo "<strong>";} ?>
											<?=$mc->name?>
                                            <? if($l_main_cat==$mc->category_id){echo "</strong>";} ?>
                                            </a>
											<? if(!empty($mc->sub_category)){ ?>

											<a class="collapse_btn <? if($l_main_cat!=$mc->category_id){echo "collapsed";}else{ echo " active ";} ?>" data-toggle="collapse" href="#collapse_<?=$mc->category_id?>"></a>

                                            <div id="collapse_<?=$mc->category_id?>" class="panel-collapse <? if($l_main_cat==$mc->category_id){echo " active  in ";}else{echo 'collapse'; } ?>">
												<ul class="filter-custom-control">
													<?
													$count2=0;
													foreach($mc->sub_category as $sc){ $count2++;
													$sub_category_link = MAINSITE."all-products/$mc->category_id/$sc->category_id";
													if(!empty($sc->slug_url)){$sub_category_link = MAINSITE."$mc->slug_url/$sc->slug_url"; }
													 ?>
													<li><a href="<?=$sub_category_link?>"><i class="fa fa-circle"></i>
                                                    <? if($l_sub_cat==$sc->category_id){echo "<strong>";} ?>
                                                     <?=$sc->name?>
                                                     <? if($l_sub_cat==$sc->category_id){echo "</strong>";} ?>
                                                     </a>

                                                    <? if(!empty($sc->super_sub_category)){ ?>
                                                    <a class="collapse_btn <? if($l_sub_cat!=$sc->category_id){echo "collapsed";}else{ echo " active ";} ?>" data-toggle="collapse" href="#collapse_<?=$sc->category_id?>"></a>
                                                    <div id="collapse_<?=$sc->category_id?>" class="panel-collapse <? if($l_sub_cat==$sc->category_id){echo "  in ";}else{echo 'collapse'; } ?>">
                                                        <ul class="sub_categr2">
                                                            <?
                                                            $count2=0;
                                                            foreach($sc->super_sub_category as $ssc){ $count2++;
                                                            $super_sub_category_link = MAINSITE."all-products/$mc->category_id/$sc->category_id/$ssc->category_id";
                                                            if(!empty($sc->slug_url)){$super_sub_category_link = MAINSITE."$mc->slug_url/$sc->slug_url/$ssc->slug_url"; }
                                                             ?>
                                                            <li><a class="<? if($l_super_sub_cat!=$ssc->category_id){echo "";}else{ echo " active ";} ?>" href="<?=$super_sub_category_link?>"><i class="fa fa-circle"></i>
                                                            <? if($l_super_sub_cat==$ssc->category_id){echo "<strong>";} ?>
                                                             <?=$ssc->name?>
                                                             <? if($l_super_sub_cat==$ssc->category_id){echo "</strong>";} ?>
                                                             </a></li>
                                                            <? } ?>
                                                        </ul>
                                                    </div>
                                                    <? } ?>



                                                    </li>
													<? } ?>
												</ul>
											</div>
											<? } ?>
										</li>
									<? } ?>
                                                <!--<li>
                                                   <div class="filter-custom-control">
                                                      <input type="checkbox" class="" name="filter.p.product_type1" value="Plants" id="Filter-Product type-mobile-1" wfd-invisible="true">
                                                      <label class=" " for="Filter-Product type-mobile-1">
                                                      Flowers
                                                      </label>
                                                   </div>
                                                </li>
                                                <li>
                                                   <div class="filter-custom-control">
                                                      <input type="checkbox" class="" name="filter.p.product_type2" value="Plants" id="Filter-Product type-mobile-2" wfd-invisible="true">
                                                      <label class=" " for="Filter-Product type-mobile-2">
                                                      Birthday Gifts
                                                      </label>
                                                   </div>
                                                </li>
                                                <li>
                                                   <div class="filter-custom-control">
                                                      <input type="checkbox" class="" name="filter.p.product_type3" value="Plants" id="Filter-Product type-mobile-3" wfd-invisible="true">
                                                      <label class=" " for="Filter-Product type-mobile-3">
                                                      plant Nursery
                                                      </label>
                                                   </div>
                                                </li>-->
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                    <?php } ?>

                                     <? if(!empty($attribute)){

							foreach($attribute as $a){
								if(!empty($a->attributeVal)){
							$att_count++;
								   ?>   <div class="accordion-item">
                                 <div class="panel panel-default panel-custom ">
                                       <div class="panel-heading" role="tab" id="catFilter_<?=$att_count?>">
                                          <h4 class="panel-title">
                                             <a class="collapsed" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#catFilter_<?=$att_count?>" aria-expanded="false" aria-controls="catFilter_<?=$att_count?>">
                                                <i class="more-less glyphicon glyphicon-minus"></i>
                                                <p class="h6 facet-title hidden-sm-down"><?=$a->name?></p>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="catFilter_<?=$att_count?>" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="catFilter_<?=$att_count?>">
                                          <div class="panel-body">
                                             <ul class="categories-list">
                                             <?
                                foreach($a->attributeVal as $av){

                            ?>
                                <li>
                                <div class="filter-custom-control">
                                <?
                            $checked = '';
                            if(in_array($av->product_attribute_value_id , $Qsearch)){ $checked = 'checked="checked"';}

                            $atter_val = json_encode(array('product_attribute_value_id'=>$av->product_attribute_value_id , 'combination_value'=>$av->combination_value));

                            ?>
                                    <input onchange="$('#p_search_by').val('f_attr_<?=$a->product_attribute_id?>');searchProduct()" <?=$checked?> value='<?=$atter_val?>' id="att_check_<?=$av->product_attribute_value_id?>" name="search<?=$a->product_attribute_id?>[]" type="checkbox<? //=$a->type?>" data-attparent='<?=$a->name ?>'  data-attchild='<?=$av->name ?>' class="checkbox-custom search_att">
                                    <label class="checkbox-custom-label" for="att_check_<?=$av->product_attribute_value_id?>"><?=$av->combination_value?> <?=$av->name?></label>
                                    </div>
                                </li>
                              <? } ?>


                                             </ul>
                                          </div>
                                       </div>


                                    </div>
                                    </div>

                               <? }}} ?>


                                    <div class="panel panel-default panel-custom ">
                                       <div class="panel-heading" role="tab" id="headingTwo">
                                          <h4 class="panel-title">
                                             <a class="collapsed" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <i class="more-less glyphicon glyphicon-minus"></i>
                                                <p class="h6 facet-title hidden-sm-down">Availability</p>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="collapseTwo" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingTwo">
                                          <div class="panel-body">
                                             <ul class="categories-list">
                                                <li>
                                                   <div class="filter-custom-control">
                                                      <input onchange="searchProduct()" type="checkbox" name="in_stock" class="checkbox-custom search_att" id="st_in_stock" value="1" data-attparent='Exclude Our Of Stock'  data-attchild='Yes'>

                                                      <label class="checkbox-custom-label" for="st_in_stock">Exclude Out Of Stock</label>

                                                   </div>
                                                </li>

                                             </ul>
                                          </div>
                                       </div>


                                    </div>




                                    <div class="panel panel-default panel-custom " >
                                       <div class="panel-heading" role="tab" id="headingThree">
                                          <h4 class="panel-title">
                                             <a class="collapsed" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <i class="more-less glyphicon glyphicon-minus"></i>
                                                <p class="h6 facet-title hidden-sm-down">Price </p>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="collapseThree" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingThree">
                                          <div class="panel-body slider-range">




<div class="wrapper">
  <fieldset class="filter-price">

    <div class="price-field">

      <input type="range" min="<?=$min_final_price?>" max="<?=$max_final_price?>" value="<?=$min_final_price?>" name="min_price" id="min_price" class="pr_lu" >
      <input type="range" min="<?=$min_final_price?>" max="<?=ceil($max_final_price)?>" value="<?=$max_final_price?>" name="max_price" id="max_price" class="pr_lu" >
    </div>
    <div class="price-wrap">
      <?php /*?><span class="price-title">FILTER</span><?php */?>
      <center>
      <div class="price-container">
        <div class="price-wrap-1">

          <label for="one"><i class="fa fa-inr"></i></label>
          <input id="one" readonly="readonly">
        </div>
        <div class="price-wrap_line">-</div>
        <div class="price-wrap-2">
          <label for="two"><i class="fa fa-inr"></i></label>
          <input id="two" readonly="readonly">

        </div>
      </div>
      </center>
    </div>
  </fieldset>
</div>






                                             <?php /*?><section class="range-slider" id="facet-price-range-slider">
                                       <!--         <input name="range-1" value="0" min="0" max="1250" step="1" type="range">
                              					<input name="range-2" value="1250" min="0" max="1250" step="1" type="range"> -->
                                                <input type="range" min="<?=$min_final_price?>" value="0" max="<?=$max_final_price-100?>" oninput="validity.valid||(value='<?=$min_final_price?>');" id="min_price" name="min_price" class="price-range-field left_price" />
												<input type="range" min="<?=$min_final_price+100?>" max="<?=ceil($max_final_price)?>"  value="" oninput="validity.valid||(value='<?=$max_final_price?>');" id="max_price" name="max_price" class="price-range-field rigt_price" />
                                             </section><?php */?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- panel-group -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
<? } else{ ?>
                  <div class="mobile-filter">




                     <div class="banner_col1">
<button type="button" class="openbtn"  onclick="openNav()"><i class="fa fa-filter"></i></button>

                     <div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onClick="closeNav()">×</a>
 <div class="floating-form contact_form visiable" style="left: 0px; display: block;">

               <div class="leftFilterHead"><span class="fa fa-arrow-left contact_opener" onClick="closeNav()"></span>&nbsp; Filter </div>
                    <div class="mobiFilterNav">
                      <div class="left-column">
                        <div id="search_filters_wrapper" style="overflow-y: scroll;
    max-height: 83vh;">
                           <div id="search_filters">
                              <div class="facet clearfix">

                                 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


                                  <?
                  //echo "<pre>"; print_r($left_nav_category); echo "</pre>"; exit;
                  if(!empty($left_nav_category))
                  {

                     ?>

                                    <div class="panel panel-default panel-custom ">
                                       <!-- <p class="text-uppercase h6 hidden-sm-down">Filter By</p> -->
                                       <div class="panel-heading" role="tab" id="category">
                                          <h4 class="panel-title">
                                             <a role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <i class="more-less glyphicon glyphicon-minus"></i>
                                                <p class="h6 facet-title hidden-sm-down">Categories</p>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="collapseOne">
                                          <div class="panel-body" >
                                             <ul class="categories-list categories-list-scroll height-scroll">
                                              <?
                  $count1=0;
                  $count2=0;
                  $count3=0;
                  foreach($left_nav_category as $mc){$count1++;
                  $category_link = MAINSITE."all-products/$mc->category_id";
                  if(!empty($mc->slug_url)){$category_link = MAINSITE."$mc->slug_url"; }
                   ?>
                    <li>
                      <a href="<?=$category_link?>"><i class="fa fa-circle"></i>
                                             <? if($l_main_cat==$mc->category_id){echo "<strong>";} ?>
                      <?=$mc->name?>
                                            <? if($l_main_cat==$mc->category_id){echo "</strong>";} ?>
                                            </a>
                      <? if(!empty($mc->sub_category)){ ?>

                      <a class="collapse_btn <? if($l_main_cat!=$mc->category_id){echo "collapsed";}else{ echo " active ";} ?>" data-toggle="collapse" href="#collapse_<?=$mc->category_id?>"></a>

                                            <div id="collapse_<?=$mc->category_id?>" class="panel-collapse <? if($l_main_cat==$mc->category_id){echo " active  in ";}else{echo 'collapse'; } ?>">
                        <ul class="filter-custom-control">
                          <?
                          $count2=0;
                          foreach($mc->sub_category as $sc){ $count2++;
                          $sub_category_link = MAINSITE."all-products/$mc->category_id/$sc->category_id";
                          if(!empty($sc->slug_url)){$sub_category_link = MAINSITE."$mc->slug_url/$sc->slug_url"; }
                           ?>
                          <li><a href="<?=$sub_category_link?>"><i class="fa fa-circle"></i>
                                                    <? if($l_sub_cat==$sc->category_id){echo "<strong>";} ?>
                                                     <?=$sc->name?>
                                                     <? if($l_sub_cat==$sc->category_id){echo "</strong>";} ?>
                                                     </a>

                                                    <? if(!empty($sc->super_sub_category)){ ?>
                                                    <a class="collapse_btn <? if($l_sub_cat!=$sc->category_id){echo "collapsed";}else{ echo " active ";} ?>" data-toggle="collapse" href="#collapse_<?=$sc->category_id?>"></a>
                                                    <div id="collapse_<?=$sc->category_id?>" class="panel-collapse <? if($l_sub_cat==$sc->category_id){echo "  in ";}else{echo 'collapse'; } ?>">
                                                        <ul class="sub_categr2">
                                                            <?
                                                            $count2=0;
                                                            foreach($sc->super_sub_category as $ssc){ $count2++;
                                                            $super_sub_category_link = MAINSITE."all-products/$mc->category_id/$sc->category_id/$ssc->category_id";
                                                            if(!empty($sc->slug_url)){$super_sub_category_link = MAINSITE."$mc->slug_url/$sc->slug_url/$ssc->slug_url"; }
                                                             ?>
                                                            <li><a class="<? if($l_super_sub_cat!=$ssc->category_id){echo "";}else{ echo " active ";} ?>" href="<?=$super_sub_category_link?>"><i class="fa fa-circle"></i>
                                                            <? if($l_super_sub_cat==$ssc->category_id){echo "<strong>";} ?>
                                                             <?=$ssc->name?>
                                                             <? if($l_super_sub_cat==$ssc->category_id){echo "</strong>";} ?>
                                                             </a></li>
                                                            <? } ?>
                                                        </ul>
                                                    </div>
                                                    <? } ?>



                                                    </li>
                          <? } ?>
                        </ul>
                      </div>
                      <? } ?>
                    </li>
                  <? } ?>
                                                <!--<li>
                                                   <div class="filter-custom-control">
                                                      <input type="checkbox" class="" name="filter.p.product_type1" value="Plants" id="Filter-Product type-mobile-1" wfd-invisible="true">
                                                      <label class=" " for="Filter-Product type-mobile-1">
                                                      Flowers
                                                      </label>
                                                   </div>
                                                </li>
                                                <li>
                                                   <div class="filter-custom-control">
                                                      <input type="checkbox" class="" name="filter.p.product_type2" value="Plants" id="Filter-Product type-mobile-2" wfd-invisible="true">
                                                      <label class=" " for="Filter-Product type-mobile-2">
                                                      Birthday Gifts
                                                      </label>
                                                   </div>
                                                </li>
                                                <li>
                                                   <div class="filter-custom-control">
                                                      <input type="checkbox" class="" name="filter.p.product_type3" value="Plants" id="Filter-Product type-mobile-3" wfd-invisible="true">
                                                      <label class=" " for="Filter-Product type-mobile-3">
                                                      plant Nursery
                                                      </label>
                                                   </div>
                                                </li>-->
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                    <?php } ?>

                                    <? if(!empty($attribute)){

							foreach($attribute as $a){
								if(!empty($a->attributeVal)){
							$att_count++;
								   ?>   <div class="accordion-item">
                                 <div class="panel panel-default panel-custom ">
                                       <div class="panel-heading" role="tab" id="catFilter_<?=$att_count?>">
                                          <h4 class="panel-title">
                                             <a class="collapsed" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#catFilter_<?=$att_count?>" aria-expanded="false" aria-controls="catFilter_<?=$att_count?>">
                                                <i class="more-less glyphicon glyphicon-minus"></i>
                                                <p class="h6 facet-title hidden-sm-down"><?=$a->name?></p>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="catFilter_<?=$att_count?>" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="catFilter_<?=$att_count?>">
                                          <div class="panel-body">
                                             <ul class="categories-list">
                                             <?
                                foreach($a->attributeVal as $av){

                            ?>
                                <li>
                                <div class="filter-custom-control">
                                <?
                            $checked = '';
                            if(in_array($av->product_attribute_value_id , $Qsearch)){ $checked = 'checked="checked"';}

                            $atter_val = json_encode(array('product_attribute_value_id'=>$av->product_attribute_value_id , 'combination_value'=>$av->combination_value));

                            ?>
                                    <input onchange="$('#p_search_by').val('f_attr_<?=$a->product_attribute_id?>');searchProduct()" <?=$checked?> value='<?=$atter_val?>' id="att_check_<?=$av->product_attribute_value_id?>" name="search<?=$a->product_attribute_id?>[]" type="checkbox<? //=$a->type?>" data-attparent='<?=$a->name ?>'  data-attchild='<?=$av->name ?>' class="checkbox-custom search_att">
                                    <label class="checkbox-custom-label" for="att_check_<?=$av->product_attribute_value_id?>"><?=$av->combination_value?> <?=$av->name?></label>
                                    </div>
                                </li>
                              <? } ?>


                                             </ul>
                                          </div>
                                       </div>


                                    </div>
                                    </div>

                               <? }}} ?>




                                    <div class="panel panel-default panel-custom ">
                                       <div class="panel-heading" role="tab" id="headingTwo">
                                          <h4 class="panel-title">
                                             <a class="collapsed" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <i class="more-less glyphicon glyphicon-minus"></i>
                                                <p class="h6 facet-title hidden-sm-down">Availability</p>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="collapseTwo" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingTwo">
                                          <div class="panel-body">
                                             <ul class="categories-list">
                                                <li>
                                                   <div class="filter-custom-control">
                                                      <input onchange="searchProduct()" type="checkbox" name="in_stock" class="checkbox-custom search_att" id="st_in_stock" value="1" data-attparent='Exclude Our Of Stock'  data-attchild='Yes'>

                                                      <label class="checkbox-custom-label" for="st_in_stock">Exclude Out Of Stock</label>

                                                   </div>
                                                </li>

                                             </ul>
                                          </div>
                                       </div>


                                    </div>




                                    <div class="panel panel-default panel-custom " >
                                       <div class="panel-heading" role="tab" id="headingThree">
                                          <h4 class="panel-title">
                                             <a class="collapsed" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <i class="more-less glyphicon glyphicon-minus"></i>
                                                <p class="h6 facet-title hidden-sm-down">Price  </p>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="collapseThree" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingThree">
                                          <div class="wrapper">
  <fieldset class="filter-price">

    <div class="price-field">

      <input type="range" min="<?=$min_final_price?>" max="<?=$max_final_price?>" value="<?=$min_final_price?>" name="min_price" id="min_price" class="pr_lu" >
      <input type="range" min="<?=$min_final_price?>" max="<?=ceil($max_final_price)?>" value="<?=$max_final_price?>" name="max_price" id="max_price" class="pr_lu" >
    </div>
    <div class="price-wrap">
      <?php /*?><span class="price-title">FILTER</span><?php */?>
      <center>
      <div class="price-container">
        <div class="price-wrap-1">

          <label for="one"><i class="fa fa-inr"></i></label>
          <input id="one" readonly="readonly">
        </div>
        <div class="price-wrap_line">-</div>
        <div class="price-wrap-2">
          <label for="two"><i class="fa fa-inr"></i></label>
          <input id="two" readonly="readonly">

        </div>
      </div>
      </center>
    </div>
  </fieldset>
</div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- panel-group -->
                              </div>
                           </div>
                        </div>
                     </div>
                    </div>











                        <div class="leftFilterfoote"><a class="cart_button  contact_opener contact_opener_apply aClick_1">Apply Now</a></div>
            </div>
         </div>
</div>
                  </div>

<? } ?>
               </div>

               <div class="prodct_sec2 mt-3">
                <nav  class="breadcrumb  brdpdng">
  <ol>
      <!--<li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Bend Leather</span></li>-->
        <? echo $breadcrumbs; ?>
  </ol>

</nav><div class="clearfix"></div>
                 <? if(!empty($current_category->header_1_img)){ ?>
            <? if(!empty($current_category->header_1_url)){ ?>
            <a href="<?=$current_category->header_1_url?>" target="_blank">
             <? } ?>
            <img src="<?=base_url().'assets/uploads/category/'.$current_category->header_1_img?>" alt="<?=$cat_name?>" title="<?=$cat_name?>" class="breadcrumb-img">
            <? if(!empty($current_category->header_1_url)){ ?>
            </a>
             <? } ?>
              <? } ?>
           <?
       echo $this->session->flashdata('alert_message');
       ?>

                  <div  class="products-selection">
                    <div  class="row">
                     <div class="col-lg-7 col-5 hidden-sm-down total-products" >
                        <p><span>

						<?
						if(!empty($list_heading_title)){ echo $list_heading_title; }
						else if(!empty($searchSugg)){ echo $searchSugg; }
						else if(!empty($current_category->name)){echo $current_category->name;}else{echo "All Products";}
						?>

                        </span> <span class="products_count_cl"></span></p>
                     </div>
                     <div class="col-lg-4 col-6 borderright" style="padding:10px">
                        <div class="row sort-by-row">
                           <span class="col-sm-3 col-md-3 hidden-sm-down sort-by">Sort by:</span>
                           <div class="col-sm-9 col-xs-8 col-md-9 products-sort-order dropdown">
                              <select onchange="searchProduct()" name="order" class="sort_sectin">
							<option <? if($order==1){echo "selected";} ?> value="1">Price: Low to High</option>
							<option <? if($order==2){echo "selected";} ?> value="2">Price: High to Low</option>
							<option <? if($order==3){echo "selected";} ?> value="3">Product: Featured Products</option>
							<option <? if($order==4){echo "selected";} ?> value="4">Product: Hot Selling Now</option>
							<option <? if($order==5){echo "selected";} ?> value="5">Product: Best Sellers</option>
							<option <? if($order==6){echo "selected";} ?> value="6">Product: What's New</option>
							<option <? if($order==7){echo "selected";} ?> value="7">Discount: High to Low</option>
							<option <? if($order==8){echo "selected";} ?> value="8">Name: A to Z</option>
							<option <? if($order==9){echo "selected";} ?> value="9">Name: Z to A</option>
						</select>

                           </div>
                        </div>
                     </div>
                  </div>
                </div>
                  <div class="row DisplayMoreProd">


                     <?
									if(!empty($products_list))
									{
										$this->load->view('template/product-list',$this->data);
									}
									else
									{?>
                                    	<div class="no_prd_found text-center">
                                        <h2 class="no_product">Sorry<span class="no_product_symbol">!</span></h2>
                                        <p class="no_product_para">No Product <span class="no_product_text">Found.</span></p>
                                        </div>
                                    	<img src="<?=base_url().'assets/front/images/no-product.jpg'?>" class="responsiveImg">
										<?php /*?><p class="">No Products to display</p><?php */?>
									<?
									}
								?>


                  </div>
                  <div class="load-more-btn-p">
						<div class="row loadMoreProductText" style="    clear: both;text-align: center;padding: 20px;font-weight: 600;font-size: 16px;text-shadow: 1px 4px 6px #b1b1b1;"></div>


                        <div class="load_lazy_product"></div>
                        <center>
						<div class="<?php /*?>col-md-4 col-sm-4 col-xs-6 col-2 col-md-offset-4<?php */?>" style="margin-top: 80px; display: none; " id="list_loder">
							<div class="sk-chase ">
							  <div class="sk-chase-dot"></div>
							  <div class="sk-chase-dot"></div>
							  <div class="sk-chase-dot"></div>
							  <div class="sk-chase-dot"></div>
							  <div class="sk-chase-dot"></div>
							  <div class="sk-chase-dot"></div>
							</div>
						</div>
                        </center>
					</div>
                    <? for($i=1 ; $i<=1 ; $i++){ ?>
                        <? if(!empty($current_category->{'footer_'.$i.'_img'})){ ?>
                        	<? if(!empty($current_category->{'footer_'.$i.'_url'})){ ?>
                            <a href="<?=$current_category->{'footer_'.$i.'_url'}?>" target="_blank">
                             <? } ?>
                            <img src="<?=_uploaded_files_.'category/'.$current_category->{'footer_'.$i.'_img'}?>" alt="<?=$cat_name?>" title="<?=$cat_name?>" class="breadcrumb-img">
                           <? if(!empty($current_category->{'footer_'.$i.'_url'})){ ?>
                            </a>
                             <? } ?>
                         <? } ?>
                          <? } ?>
               </div>
            </div>
         </div>

      <div id="smartblog_block" class="block products_block hb-animate-element bottom-to-top hb-in-viewport">
         <div class="container">
         </div>
      </div>
      </form>
     <script>
         function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass('glyphicon-plus glyphicon-minus');
         }
         $('.panel-group').on('hidden.bs.collapse', toggleIcon);
         $('.panel-group').on('shown.bs.collapse', toggleIcon);
      </script>
<script>
function aaaaa()
{
	$('.search_display_li').html('');
	$('.left_menu_filter_cl').hide();
	var i_count=0;
	var pre_attparent='';
	$(".search_att").each(function() {
		if($(this).prop('checked'))
		{
			$('.left_menu_filter_cl').show();
			if(i_count==0){$('.search_display_li').append('<li><a class="cleaer_bt1" onclick="update_search(0)">Clear All</a></li>');}
			var attparent = $(this).data('attparent');
			var attchild = $(this).data('attchild');
			var attval = $(this).val();
			if(pre_attparent!=attparent)
			{
				$('.search_display_li').append('<li><strong>' + attparent + ' : </strong><span class="close_btn1" onclick="update_search(' + attval + ')">' + attchild + '<i class="fa fa-times"></i></span>');
			}
			else
			{
				$('.search_display_li').append('' + attchild + '<span class="close_btn1" onclick="update_search(' + attval + ')"><i class="fa fa-times"></i></span></li>');
			}


			pre_attparent=attparent;
			i_count++;
		}
	});
};
var c_max_final_price = <?=ceil($max_final_price)?>;
var r_min_final_price = <?=round($min_final_price)?>;
window.addEventListener('load', (event) => {
  aaaaa();
  $(".search_att").bind("click", function(){
	  aaaaa();
	});

	  <?php /*?>$("#slider-range").slider({
		range: true,
		orientation: "horizontal",
		min: r_min_final_price,
		max: c_max_final_price,
		values: [0, c_max_final_price],
		step: 1,
		slide: function (event, ui) {
//			console.log(ui.values[0] +" : "+ ui.values[1]);
		  if (ui.values[0] == ui.values[1]) {
			  return false;
		  }

		},
		stop: function( event, ui ) {
		 console.log('anu');
		  $('#p_search_by').val('price');
		  $("#min_price").val(ui.values[0]);
		  $("#max_price").val(ui.values[1]);
		  searchProduct();}
	  });
	  		$("#min_price").val($("#slider-range").slider("values", 0));
		    $("#max_price").val($("#slider-range").slider("values", 1));<?php */?>
	});
function update_search(id)
{
	if(id==0)
	{
		$(".search_att").each(function() {
			$(this).prop('checked' , false);
		});
	}
	else
	{
		document.getElementById('att_check_'+id).checked = false;
	}
	searchProduct();
	aaaaa();
}

</script>
 <script>
function openNav() {
  document.getElementById("mySidebar").style.width = "100%";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
}
</script>

<script>
var lowerSlider = document.querySelector('#min_price');
var  upperSlider = document.querySelector('#max_price');
var c_max_final_price = <?=ceil($max_final_price)?>;
var r_min_final_price = <?=round($min_final_price)?>;

document.querySelector('#two').value=upperSlider.value;
document.querySelector('#one').value=lowerSlider.value;

var  lowerVal = parseInt(lowerSlider.value);
var upperVal = parseInt(upperSlider.value);

upperSlider.oninput = function () {
    lowerVal = parseInt(lowerSlider.value);
    upperVal = parseInt(upperSlider.value);

    if (upperVal < lowerVal + 4) {
        lowerSlider.value = upperVal - 4;
        if (lowerVal == lowerSlider.min) {
        upperSlider.value = 4;
        }
    }
	console.log("R - "+this.value);
    document.querySelector('#two').value=this.value
	document.querySelector('#one').value=document.querySelector('#min_price').value
};

lowerSlider.oninput = function () {
    lowerVal = parseInt(lowerSlider.value);
    upperVal = parseInt(upperSlider.value);
    if (lowerVal > upperVal - 4) {
        upperSlider.value = lowerVal + 4;
        if (upperVal == upperSlider.max) {
            lowerSlider.value = parseInt(upperSlider.max) - 4;
        }
    }

    document.querySelector('#one').value=this.value;//alert(this.value);
	document.querySelector('#two').value=document.querySelector('#max_price').value;//alert(document.querySelector('#max_price').value);
	console.log("L - "+this.value + " : R - " + document.querySelector('#max_price').value);
};
window.addEventListener("load", function(){
	$('.pr_lu').on('mouseup', function() {
		//this.blur();console.log("up");
		searchProduct();
	})
})
</script>
