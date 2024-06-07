 <link href="<?=_admin_files_?>skin-lion/ui.easytree.css" rel="stylesheet" type="text/css" />
<?
$ads_image_url  = $ads_image_sub_cat_url  = $ads_image_super_sub_cat_url = $ads_image_lower  = $ads_image_lower_url='';
$is_outer_menu='';
$cover_image='';
$is_update=false;
$alert=$this->uri->segment(6);
$category_id=0;
$super_category_id=0;
$is_dropdown=0;
$name="";
$super_category_name="";
$added_on="";
$added_by="";
$added_on="";
$updated_by="";
$updated_on="";
$ai_name="";
$header_1_url="";
$header_1_img="";
$footer_1_url="";
$footer_1_img="";
$footer_2_url="";
$footer_2_img="";
$footer_3_url="";
$footer_4_img="";
$category_icon='';
$left_1_img="";
$left_1_url="";
$left_2_img="";
$left_2_url="";
$left_3_img="";
$left_3_url="";
$left_4_img="";
$left_4_url="";
$left_5_img="";
$left_5_url="";
$left_6_img="";
$left_6_url="";

$slug_url="";
$meta_title="";
$meta_description="";
$meta_keyword="";
$others="";
$description="";
$short_description="";
$is_display_home_page=0;

$condition_per_product="";
$status=0;
if(!empty($category_detail))
{ 
$is_update=true;
	foreach($category_detail as $row)   
	{
		$category_id=$row['category_id']; //echo "dfdf".$db_enqid;
		$super_category_id=$row['super_category_id'];
		$name=$row['name'];
		$status=$row['status'];
		$added_on=$row['added_on'];
		$added_by=$row['added_by'];
		$updated_on=$row['updated_on'];
		$updated_by=$row['updated_by'];
		$cover_image=$row['cover_image'];
		$updated_by_name=$row['updated_by_name'];
		$added_by_name=$row['added_by_name'];
		$super_category_name=$row['super_category_name'];
		$is_dropdown=$row['is_dropdown'];
		
		$header_1_img=$row['header_1_img'];
		$header_1_url=$row['header_1_url'];
		$footer_1_img=$row['footer_1_img'];
		$footer_1_url=$row['footer_1_url'];
		$footer_2_img=$row['footer_2_img'];
		$footer_2_url=$row['footer_2_url'];
		$footer_3_img=$row['footer_3_img'];
		$footer_3_url=$row['footer_3_url'];
		$left_1_img=$row['left_1_img'];
		$left_1_url=$row['left_1_url'];
		$left_2_img=$row['left_2_img'];
		$left_2_url=$row['left_2_url'];
		$left_3_img=$row['left_3_img'];
		$left_3_url=$row['left_3_url'];
		$left_4_img=$row['left_4_img'];
		$left_4_url=$row['left_4_url'];
		$left_5_img=$row['left_5_img'];
		$left_5_url=$row['left_5_url'];
		$left_6_img=$row['left_6_img'];
		$left_6_url=$row['left_6_url'];
		$slug_url=$row['slug_url'];
		$meta_title=$row['meta_title'];
		$meta_description=$row['meta_description'];
		$meta_keyword=$row['meta_keyword'];
		$others=$row['others'];
		$is_outer_menu=$row['is_outer_menu'];
		$ads_image=$row['ads_image'];
		$ads_image_sub_cat=$row['ads_image_sub_cat'];
		$ads_image_super_sub_cat=$row['ads_image_super_sub_cat'];
		$category_icon=$row['category_icon'];
		$description=$row['description'];
		$short_description=$row['short_description'];
		$is_display_home_page=$row['is_display_home_page'];

		$ads_image_url=$row['ads_image_url'];
		$ads_image_sub_cat_url=$row['ads_image_sub_cat_url'];
		$ads_image_super_sub_cat_url=$row['ads_image_super_sub_cat_url'];
		$ads_image_lower=$row['ads_image_lower'];
		$ads_image_lower_url=$row['ads_image_lower_url'];
		
		
		
		if(empty($super_category_name)){$super_category_name='Parent';}
	}
}

$is_access_this=false;
if($user_access->add_module==1)	{$is_access_this=true;}
if($is_update)
{
	$is_access_this=false;
	if($user_access->update_module==1)	{ $is_access_this=true;}
}

if(!$is_access_this)
{REDIRECT(MAINSITE."SecureRegions/wdm/access_denied");}
?>    
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <form role="form" class="form-horizontal" name="main_categoryForm" id="main_categoryForm" action="<?php echo ADMIN.'categories/doAddCategory';?>" method="post" enctype="multipart/form-data">
<script>
function checkSlugUrl()
{
	$('.loader').show();
	event.preventDefault();
	const slug_url_only = string => [...string].every(c => '0123456789abcdefghijklmnopqrstuvwxyz-.ABCDEFGHIJKLMNOPQRSTUVWXYZ'.includes(c));
	var slug_url = document.getElementById('slug_url');
	var category_id = document.getElementById('category_id');
	
	if(slug_url.value == '')
	{
		alert("Please Enter Slug Url");
		slug_url.focus();
		return false;
	}
	if(!slug_url_only(slug_url.value))
	{
		alert("Slug Url Contains Only A-Z a-z 0-9 '.' and '-' only. without space");
		slug_url.focus();
		return false;
	}
	
	$.ajax({
	   type: "POST",
	
		url:'<? echo ADMIN ?>checkCategorySlugUrl',
	   //dataType : "json", 
	   data : {"category_id" : category_id.value , "slug_url" : slug_url.value},
	   success : function(result){
			//alert(result);
			if(result=='')
			{
				//document.ProductFormSEO_+id.submit();
				$( "#main_categoryForm").submit();
				$('.loader').show();
			}
			else
			{
				$('.loader').hide();
				alert("The Slug Url is already in database");
				slug_url.focus();
			}
		}
	});
	return false;
}
function setAction(id)
{
	$('#action').val(id);
	
	return checkSlugUrl()
}
</script>
                <section class="content-header">
                    <h1><?php if($category_id > 0) echo 'Edit'; else echo 'Add'; ?> Category Details - <?php echo $name;?></h1>
                </section>
            
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                    <!-- form start -->
                    <!-- Horizontal Form -->
                    
                   <input type="hidden" name="action" id="action" value="" />
                    <input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id; ?>" />
                    	<!-- left column -->
                        <div class="col-md-12">
                        <!-- general form elements -->
                        <? if($alert == "success" || $alert == "fail" || $alert == "update"){?><? if($alert == "success") {echo "<div class='alert alert-success'>Record Inseted Successfully.</div>";}else if($alert == "fail"){echo "<div class='alert alert-danger'>Error in updating this input.</div>";}else if($alert == "update"){echo "<div class='alert alert-info'>Record updated Successfully.</div>";}?></span><? }?>
                            <div class="box box-primary">
                            
                                <div class="box-header with-border row" style="padding:5px;">
                                	<div class="col-md-9">
                                        <h3 class="box-title" style="line-height:35px;">Category Info</h3>
                                    </div><!-- /.box-header -->
                                    <div class="col-md-3 text-right">
                                    	<a href="<? echo ADMIN."categories/list"; ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i>Back To Category List</a>
                                    </div> 
                                    <div class="box-body"> 
                                    <div class="">
                                    
                                        <div class="col-md-8">
                                        <?=$this->session->flashdata('alert_message');?>
                                            <div class="row">
                                                <div class="col-md-12"> 
                                                    <label class="control-label" for="Name">Category Name <div data-title="The name of the Main Category." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div> <span class="required">*</span></label>   
                                                    <input type="text" name="name" id="name" placeholder="Category Name" class="form-control" value="<? echo $name;?>" required > 												<span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                                </div>
                                                <div class="form-group" id="is_dropdown_req1" style=" <? if(empty($super_category_id)){ ?> display:none <? }else{ ?> display:none <? } ?>" >
                                        <div class="col-md-3">
                                                    	<div class="label-wrapper"><label class="control-label" for="Name">Is Dropdown Required</label>
                                                        	<div data-title="Is Dropdown Required." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                        </div>
                                        </div>
                                        
                                        <div class="col-md-9">
                                                    	<div class="input-group input-group-required">
                                                        	<input type="radio" class="" name="is_dropdown" id="is_dropdown1" value="1" <?php if($is_dropdown) echo ' checked'; ?> required /> Yes &nbsp;&nbsp;
                                        	<input type="radio" class="" name="is_dropdown" id="is_dropdown2" value="0" <?php if(!$is_dropdown) echo ' checked'; ?> /> No
                                                            <div class="input-group-btn"><span class="required">*</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  
                                        
                                    </div>
                                    
                                    
                                    			<div class="form-group is_parent_field" style=" <? if(empty($super_category_id)){ ?> display:block <? }else{ ?> display:none <? } ?>" >
                                        <div class="col-md-6">
                                                    	<div class="label-wrapper"><label class="control-label" for="Name">Is Outside Menu Required</label>
                                                        	<div data-title="Is Outside Menu Required." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                        </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                                    	<div class="input-group input-group-required">
                                                        	<input type="radio" class="" name="is_outer_menu" id="is_outer_menu1" value="1" <?php if($is_outer_menu) echo ' checked'; ?> required /> Yes &nbsp;&nbsp;
                                        	<input type="radio" class="" name="is_outer_menu" id="is_outer_menu2" value="0" <?php if(!$is_outer_menu) echo ' checked'; ?> /> No
                                                            <div class="input-group-btn"><span class="required">*</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  
                                        
                                    </div>
                                    
                                    <div class="form-group is_parent_field" style=" <? if(empty($super_category_id)){ ?> display:none <? }else{ ?> display:none <? } ?>" >
                                        <div class="col-md-6"> 
                                                    <label class="control-label" for="Name">Category Icon <div data-title="Category Icon." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                                     <div class="input-group">
                                                        <input type="file" class="form-control imgInp" name="category_icon" id="category_icon" />
                                                        
                                                        <div class="input-group-btn" style="border:1px solid #ddd"> <? if(!empty($category_icon)){ ?><a href="<?php echo _uploaded_files_.'category/'.$category_icon; ?>" target="_blank"><img width="70" src="<?php echo _uploaded_files_.'category/'.$category_icon; ?>" class="img-preview" /></a>
														<? } else{ ?> <img width="70" src="<?php echo _uploaded_files_.'no-img.png'; ?>" class="img-preview" /> <?php } ?>  </div>
                                                         <? if(!empty($category_icon) && !empty($category_id)){ ?>
                                                        <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='category_icon' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>
                                                        <? } ?>
                                                    </div>
                                                    
                                                </div>
                                        
                                        <div class="col-md-6">
                                                    	
                                                    </div>
                                                  
                                        
                                    </div>
                                    
                                    
                                    <div class="form-group is_parent_field" style=" <? if(empty($super_category_id)){ ?> display:none <? }else{ ?> display:none <? } ?>" >
                                        <div class="col-md-6"> 
                                                    <label class="control-label" for="Name">Ads Image Upper <div data-title="Ads Image Upper." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                                     <div class="input-group">
                                                        <input type="file" class="form-control imgInp" name="ads_image" id="ads_image" />
                                                        <mute><em>Image Size : 320 X 190</em></mute>
                                                        <div class="input-group-btn" style="border:1px solid #ddd"> <? if(!empty($ads_image)){ ?><a href="<?php echo _uploaded_files_.'category/'.$ads_image; ?>" target="_blank"><img width="70" src="<?php echo _uploaded_files_.'category/'.$ads_image; ?>" class="img-preview" /></a><? } else{ ?> <img width="70" src="<?php echo _uploaded_files_.'no-img.png'; ?>" class="img-preview" /> <?php } ?>  </div>
                                                        
                                                        <? if(!empty($ads_image) && !empty($category_id)){ ?>
                                                        <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='ads_image' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>
                                                        <? } ?>
                                                        
                                                    </div>
                                                    
                                                    
                                                </div>
                                        
                                        <div class="col-md-6">
                                            <label class="control-label" for="Name">Ads Url Upper <div data-title="Ads Url Upper ." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                        <input type="text" class="form-control" name="ads_image_url" id="ads_image_url" value="<?=$ads_image_url?>" />        	
                                                    </div>
                                                  
                                        
                                    </div>
                                    
                                    <div class="form-group is_parent_field" style=" <? if(empty($super_category_id)){ ?> display:none <? }else{ ?> display:none <? } ?>" >
                                        <div class="col-md-6"> 
                                                    <label class="control-label" for="Name">Ads Image Lower <div data-title="Ads Image Lower." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                                     <div class="input-group">
                                                        <input type="file" class="form-control imgInp" name="ads_image_lower" id="ads_image_lower" />
                                                        <mute><em>Image Size : 320 X 190</em></mute>
                                                        <div class="input-group-btn" style="border:1px solid #ddd"> <? if(!empty($ads_image_lower)){ ?><a href="<?php echo _uploaded_files_.'category/'.$ads_image_lower; ?>" target="_blank"><img width="70" src="<?php echo _uploaded_files_.'category/'.$ads_image_lower; ?>" class="img-preview" /></a><? } else{ ?> <img width="70" src="<?php echo _uploaded_files_.'no-img.png'; ?>" class="img-preview" /> <?php } ?>  </div>
                                                        
                                                        <? if(!empty($ads_image_lower) && !empty($category_id)){ ?>
                                                        <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='ads_image_lower' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>
                                                        <? } ?>
                                                        
                                                    </div>
                                                    
                                                    
                                                </div>
                                        
                                        <div class="col-md-6">
                                            <label class="control-label" for="Name">Ads Url Upper <div data-title="Ads Url Upper ." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                        <input type="text" class="form-control" name="ads_image_lower_url" id="ads_image_lower_url" value="<?=$ads_image_lower_url?>" />        	
                                                    </div>
                                                  
                                        
                                    </div>
                                    
                                    
                                    <div class="form-group is_parent_field" style=" <? if(empty($super_category_id)){ ?> display:none <? }else{ ?> display:none <? } ?>" >
                                        <div class="col-md-6"> 
                                                    <label class="control-label" for="Name">Ads Image 1 <div data-title="Ads Image For Sub Category." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                                     <div class="input-group">
                                                        <input type="file" class="form-control imgInp" name="ads_image_sub_cat" id="ads_image_sub_cat" />
                                                        <mute><em>Image Size : 225 X 408</em></mute>
                                                        <div class="input-group-btn" style="border:1px solid #ddd"> <? if(!empty($ads_image_sub_cat)){ ?><a href="<?php echo _uploaded_files_.'category/'.$ads_image_sub_cat; ?>" target="_blank"><img width="70" src="<?php echo _uploaded_files_.'category/'.$ads_image_sub_cat; ?>" class="img-preview" /></a><? } else{ ?> <img width="70" src="<?php echo _uploaded_files_.'no-img.png'; ?>" class="img-preview" /> <?php } ?>  </div>
                                                        
                                                        <? if(!empty($ads_image_sub_cat) && !empty($category_id)){ ?>
                                                        <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='ads_image_sub_cat' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>
                                                        <? } ?>
                                                        
                                                    </div>
                                                </div>
                                        
                                         <div class="col-md-6">
                                            <label class="control-label" for="Name">Ads 1 Url<div data-title="Ads 2 Url ." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                        <input type="text" class="form-control" name="ads_image_sub_cat_url" id="ads_image_sub_cat_url" value="<?=$ads_image_sub_cat_url?>" />        	
                                                    </div>
                                    </div>
                                    
                                    <div class="form-group is_parent_field" style=" <? if(empty($super_category_id)){ ?> display:none <? }else{ ?> display:none <? } ?>" >
                                        
                                        <div class="col-md-6"> 
                                                    <label class="control-label" for="Name">Ads Image 2<div data-title="Ads Image Super Sub Category." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                                     <div class="input-group">
                                                        <input type="file" class="form-control imgInp" name="ads_image_super_sub_cat" id="ads_image_super_sub_cat" />
                                                        <mute><em>Image Size : 225 X 408</em></mute>
                                                        <div class="input-group-btn" style="border:1px solid #ddd"> <? if(!empty($ads_image_super_sub_cat)){ ?><a href="<?php echo _uploaded_files_.'category/'.$ads_image_super_sub_cat; ?>" target="_blank"><img width="70" src="<?php echo _uploaded_files_.'category/'.$ads_image_super_sub_cat; ?>" class="img-preview" /></a><? } else{ ?> <img width="70" src="<?php echo _uploaded_files_.'no-img.png'; ?>" class="img-preview" /> <?php } ?>  </div>
                                                        
                                                        <? if(!empty($ads_image_super_sub_cat) && !empty($category_id)){ ?>
                                                        <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='ads_image_super_sub_cat' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>
                                                        <? } ?>
                                                        
                                                    </div>
                                                    
                                                    
                                                </div>          
                                                
                                                <div class="col-md-6">
                                            <label class="control-label" for="Name">Ads 2 Url<div data-title="Ads 2 Url  ." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                        <input type="text" class="form-control" name="ads_image_super_sub_cat_url" id="ads_image_super_sub_cat_url" value="<?=$ads_image_sub_cat_url?>" />        	
                                                    </div>
                                        
                                    </div>
                                    
                                                <div class="col-md-6"> 
                                                    <label class="control-label" for="Name">Cover Image <div data-title="Cover Image." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                                     <div class="input-group">
                                                        <input type="file" class="form-control imgInp" name="cover_image" id="cover_image" />
                                                        <mute><em>Image Size : 289px X 260px</em></mute>
                                                        <div class="input-group-btn" style="border:1px solid #ddd"> <? if(!empty($cover_image)){ ?><a href="<?php echo _uploaded_files_.'category/'.$cover_image; ?>" target="_blank"><img width="70" src="<?php echo _uploaded_files_.'category/'.$cover_image; ?>" class="img-preview" /></a><? } else{ ?> <img width="70" src="<?php echo _uploaded_files_.'no-img.png'; ?>" class="img-preview" /> <?php } ?>  </div>
                                                        <? if(!empty($cover_image) && !empty($category_id)){ ?>
                                                        <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='cover_image' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>
                                                        <? } ?>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="col-md-12">
                                               <hr style="display:none"> 
                                             <center style=""><strong>Header Main Image</strong> size(969px X 322px)</center></div>
                                                <div class="col-md-6"   style="">
                                                <label class="control-label" for="Name">Header Image <div data-title="Header Image." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>  
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" name="header_1_img" id="header_1_img" />
                                                        <div class="input-group-btn">
                                                         <? if(!empty($header_1_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$header_1_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$header_1_img; ?>" /></a><? } else{ ?> <img width="70" src="<?php echo _uploaded_files_.'no-img.png'; ?>" class="img-preview" /> <?php } ?>
                                                        </div>
                                                        <? if(!empty($header_1_img) && !empty($category_id)){ ?>
                                                        <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='header_1_img' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>
                                                        <? } ?>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6" style="display:block">
                                        <label class="control-label" for="Name">Header Image Url <div data-title="Header Image URL." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                        <input type="text" class="form-control" name="header_1_url" id="header_1_url" value="<?=$header_1_url?>" />
                                                
                                            </div>
                                            	<div class="col-md-12"  style="display:none"><hr><center><strong>Footer Images</strong> size(900px X 260px)</center></div>
                                                <div class="col-md-6"  style="display:none" >
                                                <label class="control-label" for="Name">Footer Image <div data-title="Footer Image1." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>  
                                                    <div class="input-group">
                                                         <input type="file" class="form-control" name="footer_1_img" id="footer_1_img" />
                                                        <div class="input-group-btn">
                                                         <? if(!empty($footer_1_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$footer_1_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$footer_1_img; ?>" /></a><? } else{ ?> <img width="70" src="<?php echo _uploaded_files_.'no-img.png'; ?>" class="img-preview" /> <?php } ?>
                                                        </div>
                                                        <? if(!empty($footer_1_img) && !empty($category_id)){ ?>
                                                        <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='footer_1_img' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>
                                                        <? } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="display:none">
                                        <label class="control-label" for="Name">Footer Image Url <div data-title="Footer Image URL 1." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                        <input type="text" class="form-control" name="footer_1_url" id="footer_1_url" value="<?=$footer_1_url?>" />
                                                
                                            </div>
                                            	<div style="clear:both"></div>
                                             	<div class="col-md-6"  style="display:none" >
                                                <label class="control-label" for="Name">Footer Image 2 <div data-title="Footer Image2." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>  
                                                    <div class="input-group">
                                                         <input type="file" class="form-control" name="footer_2_img" id="footer_2_img" />
                                                        <div class="input-group-btn">
                                                          <? if(!empty($footer_2_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$footer_2_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$footer_2_img; ?>" /></a><? } else{ ?> <img width="70" src="<?php echo _uploaded_files_.'no-img.png'; ?>" class="img-preview" /> <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"  style="display:none">
                                        <label class="control-label" for="Name">Footer Image Ur2 <div data-title="Footer Image URL 2." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                        <input type="text" class="form-control" name="footer_2_url" id="footer_2_url" value="<?=$footer_2_url?>" />
                                                
                                            </div>
                                            	<div style="clear:both"></div>
                                             	<div class="col-md-6"  style="display:none" >
                                                <label class="control-label" for="Name">Footer Image 3 <div data-title="Footer Image3." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>  
                                                    <div class="input-group">
                                                         <input type="file" class="form-control" name="footer_3_img" id="footer_3_img" />
                                                        <div class="input-group-btn">
                                                          <? if(!empty($footer_3_img)){ ?><a href="<?php echo MAINSITE_uploaded_files_.'category/'.$footer_3_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$footer_3_img; ?>" /></a><? } else{ ?> <img width="70" src="<?php echo _uploaded_files_.'no-img.png'; ?>" class="img-preview" /> <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"  style="display:none">
                                        <label class="control-label" for="Name">Footer Image Url3 <div data-title="Footer Image URL 3." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                        <input type="text" class="form-control" name="footer_3_url" id="footer_3_url" value="<?=$footer_3_url?>" />
                                                
                                            </div>
                                            </div> 
                                        </div> 
                                        <div class="col-md-4"> 
                                            <label class="control-label" for="Name">Super Category Name <div data-title="The name of the Main Category." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div> <span class="required">*</span></label>
                                                
                                            <div class="input-group input-group-required">
                                            <input type="hidden" id="inputType" value="radio" />
                                            <div id="demo1_menu">
                                                <ul>
                                                    <li class="isFolder isExpanded" title="New Parent Category"><a href="0" target="super_category_id,0,<? if($super_category_id==0)echo "true";else echo "false"; ?>" > New Parent Category</a>
                                                    <? foreach($category_list as $row1){
                                                        if($row1['super_category_id']==0){ ?>
                                                        
                                                        <ul >
                                                        <? $liClassExpend='';$liClass = ''; $liFolderCount=0;foreach($category_list as $row2){if($super_category_id==$row2['category_id'])$liClassExpend = 'isExpanded';if($row2['super_category_id']==$row1['category_id'])$liFolderCount++;}if($liFolderCount>0){$liClass = 'isFolder';} ?>
                                                        <?  ?>
                                                            <li class="<? echo $liClass." ".$liClassExpend; ?> " title="Parent Category">
                                                            <a href="0" target="super_category_id,<? echo $row1['category_id']; ?>,<? if($super_category_id==$row1['category_id'])echo "true";else echo "false"; ?>" ><? echo $row1['name']; ?></a>
                                                                <? foreach($category_list as $row3){
                                                                    if($row3['super_category_id']==$row1['category_id']){
                                                                     ?>                
                                                                <ul>
                                                                    <? $liClassExpend='';$liClass = ''; $liFolderCount=0;foreach($category_list as $row4){if($super_category_id==$row4['category_id'])$liClassExpend = 'isExpanded';if($row4['super_category_id']==$row3['category_id'])$liFolderCount++;}if($liFolderCount>0){$liClass = 'isFolder';} ?>
                                                                    <
                                                                    <li class="<? echo $liClass." ".$liClassExpend; ?> " title="Sub Category"><a href="0" target="super_category_id,<? echo $row3['category_id']; ?>,<? if($super_category_id==$row3['category_id'])echo "true";else echo "false"; ?>"><? echo $row3['name']; ?></a>
                                                                        <ul>
                                                                        <? foreach($category_list as $row5){
                                                                        if($row5['super_category_id']==$row3['category_id']){ ?>
                                                                            <li class="" title="Super Sub Category"><?php /*?><a href="0" target="super_category_id,<? echo $row5['category_id']; ?>,false"><?php */?><? echo $row5['name']; ?><?php /*?></a><?php */?></li>
                                                                        
                                                                            <? }} ?>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                                <? }} ?>
                                                            </li>
                                                        </ul>
                                                    <? }} ?>
                                                    </li>
                                                </ul>
                                            </div> 
                                        </div>
                                        
                                        
                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                                </div>    
                                <div style="display:none">  
                                    <div class="col-md-12"><p><center><strong>Left Images</strong> size(400px X 250px)</center></p></div>
                                        <hr>
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image 1</label>
                                                    <div data-title="Left Image 1." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                    <div class="input-group input-group-required">
                                                        <input type="file" class="form-control" name="left_1_img" id="left_1_img" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                            <? if(!empty($left_1_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$left_1_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$left_1_img; ?>" /></a><? } ?></div>
                                        </div>                                        
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image Url 1</label>
                                                    <div data-title="Left Image URL 1." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                    <div class="input-group input-group-required">
                                                        <input type="text" class="form-control" name="left_1_url" id="left_1_url" value="<?=$left_1_url?>" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image 2</label>
                                                    <div data-title="Left Image 2." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                    <div class="input-group input-group-required">
                                                        <input type="file" class="form-control" name="left_2_img" id="left_2_img" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                            <? if(!empty($left_2_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$left_2_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$left_2_img; ?>" /></a><? } ?></div>
                                        </div>                                        
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image Url 2</label>
                                                    <div data-title="Left Image URL 2." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                    <div class="input-group input-group-required">
                                                        <input type="text" class="form-control" name="left_2_url" id="left_2_url" value="<?=$left_2_url?>" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>                                        
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image 3</label>
                                                    <div data-title="Left Image 3." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                    <div class="input-group input-group-required">
                                                        <input type="file" class="form-control" name="left_3_img" id="left_3_img" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                            <? if(!empty($left_3_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$left_3_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$left_3_img; ?>" /></a><? } ?></div>
                                        </div>                                        
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image Url 3</label>
                                                    <div data-title="Left Image URL 3." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                    <div class="input-group input-group-required">
                                                        <input type="text" class="form-control" name="left_3_url" id="left_3_url" value="<?=$left_3_url?>" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>                                        
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image 4</label>
                                                    <div data-title="Left Image 4." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                    <div class="input-group input-group-required">
                                                        <input type="file" class="form-control" name="left_4_img" id="left_4_img" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                            <? if(!empty($left_4_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$left_4_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$left_4_img; ?>" /></a><? } ?></div>
                                        </div>                                        
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image Url 4</label>
                                                    <div data-title="Left Image URL 4." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                    <div class="input-group input-group-required">
                                                        <input type="text" class="form-control" name="left_4_url" id="left_4_url" value="<?=$left_4_url?>" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>                                        
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image 5</label>
                                                    <div data-title="Left Image 5." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                    <div class="input-group input-group-required">
                                                        <input type="file" class="form-control" name="left_5_img" id="left_5_img" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                            <? if(!empty($left_5_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$left_5_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$left_5_img; ?>" /></a><? } ?></div>
                                        </div>                                        
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image Url 5</label>
                                                    <div data-title="Left Image URL 5." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                    <div class="input-group input-group-required">
                                                        <input type="text" class="form-control" name="left_5_url" id="left_5_url" value="<?=$left_5_url?>" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>                                        
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image 6</label>
                                                    <div data-title="Left Image 6." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                    <div class="input-group input-group-required">
                                                        <input type="file" class="form-control" name="left_6_img" id="left_6_img" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                            <? if(!empty($left_6_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$left_6_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$left_6_img; ?>" /></a><? } ?></div>
                                        </div>                                        
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <div class="label-wrapper"><label class="control-label" for="Name">Left Image Url 6</label>
                                                    <div data-title="Left Image URL 6." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                    <div class="input-group input-group-required">
                                                        <input type="text" class="form-control" name="left_6_url" id="left_6_url" value="<?=$left_6_url?>" />
                                                        <div class="input-group-btn">
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
									</div>

                                    </div>
                                    <div style="clear:both"></div>
                                                <div class="col-md-3">
                                        <label class="control-label" for="Name">Display on Homepage <div data-title="Determines whether this Main Category is published (visible for creation of registration/shipping/billing addresses)." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div> <span class="required">*</span></label>
                                        <div class="demo-radio-button">
                                                        	<input type="radio" class="radio-col-green" name="is_display_home_page" id="is_display_home_page1" value="1" <?php if($is_display_home_page) echo ' checked'; ?> required /> 
                                                            <label for="is_display_home_page1">Yes &nbsp;&nbsp;</label>
                                        	<input type="radio" class="radio-col-red" name="is_display_home_page" id="is_display_home_page2" value="0" <?php if(!$is_display_home_page) echo ' checked'; ?> />
                                            <label for="is_display_home_page2">No &nbsp;&nbsp;</label> 
                                                            <div class="input-group-btn">
                                                            </div>
                                                        </div>
                                    </div>    
                                                    <div class="col-md-12"> 
                                                    <label class="control-label" for="Name">Short Description <div data-title="Short Description " class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div> </label>   
                                                    <textarea name="short_description" id="short_description" placeholder="Short Description" class="form-control" ><? echo $short_description;?></textarea>
                                                	</div>
                                                    	
                                                    	<div class="col-md-12"> 
                                                    <label class="control-label" for="Name">Long Description <div data-title="Long Description " class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div> </label>   
                                                    <textarea name="description" id="description" placeholder="Description" class="form-control ckeditor" ><? echo $description;?></textarea>
                                                	</div>
                                                    
            						<div class="" >
                                    <hr>	
                                        <div class="col-md-3">
                                        <label class="control-label" for="Name">Slug URL <div data-title="Slug URL." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div> <span class="required">*</span></label>
                                        <input type="text" class="form-control" required name="slug_url" id="slug_url" value="<?=$slug_url?>" />
                                                
                                            </div>  
                                        <div class="col-md-3">
                                            <label class="control-label" for="Name">Meta Title <div data-title="Meta Title." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div> <span class="required">*</span></label>
                                            <input type="text" class="form-control"  maxlength="60" required name="meta_title" id="meta_title" value="<?=$meta_title?>" />
                                        </div>  
                                        <div class="col-md-3"> 
                                        	<label class="control-label" for="Name">Meta Description <div data-title="Meta Description." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div> <span class="required">*</span></label>
                                            <input type="text" class="form-control"  maxlength="160" required name="meta_description" id="meta_description" value="<?=$meta_description?>" />
                                                
                                        </div>
                                        
                                        <div class="col-md-3"> 
                                            <label class="control-label" for="Name">Meta Keyword <div data-title="Meta Keyword." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div><span class="required">*</span></label>
                                            <input type="text" class="form-control" required name="meta_keyword" id="meta_keyword" value="<?=$meta_keyword?>" />
                                        </div>
                                      </div>
                                    
                                    <div class="form-group"  style="display:none">
                                        <div class="col-md-3">
                                            <div class="label-wrapper"><label class="control-label" for="Name">Other Tags</label>
                                                <div data-title="Other Tags." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                                <div class="input-group input-group-required">
                                                    <textarea class="form-control" name="others" id="others" ><?=$others?></textarea>
                                                    <div class="input-group-btn">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="">
                                    <hr>
                                        <div class="col-md-3">
                                        <label class="control-label" for="Name">Published <div data-title="Determines whether this Main Category is published (visible for creation of registration/shipping/billing addresses)." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div> <span class="required">*</span></label>
                                        <div class="demo-radio-button">
                                                        	<input type="radio" class="radio-col-green" name="status" id="status1" value="1" <?php if($status) echo ' checked'; ?> required /> 
                                                            <label for="status1">Active &nbsp;&nbsp;</label>
                                        	<input type="radio" class="radio-col-red" name="status" id="status2" value="0" <?php if(!$status) echo ' checked'; ?> />
                                            <label for="status2">Block &nbsp;&nbsp;</label> 
                                                            <div class="input-group-btn">
                                                            </div>
                                                        </div>
                                    </div>
                                    <? if($category_id>0){ ?> 
                                        <div class="col-md-3"> 
                                            <label class="control-label" for="Name">Added By <div data-title="The Type Of The Attribute Display To The User." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                            <p><?php if(!empty($added_by_name)){	echo $added_by_name;}else echo "N/A"; ?></p>
                                            <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                                
                                            </div>  
                                        <div class="col-md-3"> 
                                            <label class="control-label" for="Name">Added On <div data-title="The Type Of The Attribute Display To The User." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                            <p><?php	echo date('d-M-Y h:i:s A' , strtotime($added_on)); ?></p>
                                            <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>  
                                        <div class="col-md-3"> 
                                            <label class="control-label" for="Name">Updated On <div data-title="The Type Of The Attribute Display To The User." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                            <p><?php if($updated_on!='0000-00-00 00:00:00'){	echo date('d-M-Y h:i:s A' , strtotime($updated_on));}else echo "N/A"; ?></p>
                                            <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div>  
                                        <div class="col-md-3"> 
                                            <label class="control-label" for="Name">Updated By <div data-title="The Type Of The Attribute Display To The User." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>
                                            <p><?php if(!empty($updated_by_name)){	echo $updated_by_name;}else echo "N/A"; ?></p>
                                            <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                        </div> 
                                   <? } ?>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                    	<button type="button" onclick="return setAction('save')"  name="action" value="save" class="btn bg-blue"><i class="fa fa-floppy-o"></i>Save</button>
                    	<?php /*?><button type="submit" onclick="return setAction('save-add-new')" name="action" value="save-add-new" class="btn bg-blue"><i class="fa fa-floppy-o"></i>Save and Add New</button><?php */?>
                    </div>
                        <!-- /.box -->
                        </div>
                        <!--/.col (left) -->
                        
                        
                    
                    </div>
                </section>
            <!-- /.content -->
            </form>
            </div>
            <!-- /.content-wrapper -->
        
			<script src="<?=_admin_files_?>js/jquery.easytree.js"></script>
<script>
    $('#demo1_menu').easytree();
function deleteImage(obj)
{
	if(confirm('Do you really want to delete the image?'))
	{
		$('.loader').show();
		$(obj).data("column");
		
		var column = $(obj).data("column");
		var id = $(obj).data("id");
		
		//alert($(obj).data("table") + ' : ' + $(obj).data("column") + ' : ' + $(obj).data("id"));
		$.ajax({
		   type: "POST",
		
			url:'<? echo ADMIN ?>catalog/Category-Module/deleteImagesForCategory',
		   //dataType : "json", 
		   data : {"column" : column , "id" : id},
		   success : function(result){
				if(result==1)
				{
					location.reload();
				}
				else
				{
					$('.loader').hide();
					alert("Error while process.");
					location.reload();
				}
			}
		});
	}
}
</script>      