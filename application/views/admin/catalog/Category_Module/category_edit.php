<link href="<?=_admin_files_?>skin-lion/ui.easytree.css" rel="stylesheet" type="text/css" />

<?php

   $page_module_name = "Enquiry";

   ?>

<?

   $category_id=$is_outer_menu=$super_category_id=$is_display_home_page=0;

   $name=$category_icon=$cover_image=$header_1_img=$header_1_url=$footer_1_img=$footer_1_url=$short_description=$description=$slug_url=$meta_title=$meta_description=$meta_keyword='';

   $data_view=$approval_access=0;

   $status=1;

   $record_action = "Add New Record";

   $selected_user_role = array();

   $selected_company = array();

   if(!empty($category_data))

   {

    $record_action = "Update";

    $category_id = $category_data->category_id;

    $name = $category_data->name;

    $is_outer_menu = $category_data->is_outer_menu;

    $category_icon = $category_data->category_icon;
    $cover_image = $category_data->cover_image;

    $super_category_id = $category_data->super_category_id;

    $header_1_img = $category_data->header_1_img;

    $header_1_url = $category_data->header_1_url;

    $footer_1_img = $category_data->footer_1_img;

    $footer_1_url = $category_data->footer_1_url;

    $is_display_home_page = $category_data->is_display_home_page;

    $short_description = $category_data->short_description;

    $description = $category_data->description;

    $slug_url = $category_data->slug_url;

    $meta_title = $category_data->meta_title;

    $meta_description = $category_data->meta_description;

    $meta_keyword = $category_data->meta_keyword;













    $added_on = $category_data->added_on;

    $added_by = $category_data->added_by;

    $updated_on = $category_data->updated_on;

    $admin_user_id = $category_data->updated_by;

    $status = $category_data->status;





   }

   ?>

<!-- /.navbar -->

<!-- Main Sidebar Container -->

<!--<script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=hbFUjwt7utvmec3SKB26RewkkVRK8TRSR6z3u0F90ARuGsSb_9YZJB4mbmvFbhbhocMBRMuidMgN783Am8YPuw" charset="UTF-8"></script>

<link rel="stylesheet" crossorigin="anonymous" href="https://gc.kis.v2.scr.kaspersky-labs.com/E3E8934C-235A-4B0E-825A-35A08381A191/abn/main.css?attr=aHR0cHM6Ly90cnlpdC53M3NjaG9vbHMuY29tL2NvZGVfZGF0YXMucGhw"/>-->

<script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<style type="text/css">

   .card {

   padding: 10px;

   }

   .input-group{

   position: relative;

   display: table;

   border-collapse: separate;

   }

   .icon_title_box {

   color: var(--primary);

   position: relative;

   display: inline-block;

   }

   .input-group-btn {

   position: relative;

   font-size: 0;

   white-space: nowrap;

   }

   .input-group .form-control:first-child, .input-group-addon:first-child, .input-group-btn:first-child>.btn, .input-group-btn:first-child>.btn-group>.btn, .input-group-btn:first-child>.dropdown-toggle, .input-group-btn:last-child>.btn-group:not(:last-child)>.btn, .input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle) {

   border-top-right-radius: 0;

   border-bottom-right-radius: 0;

   }

   input[type=file].form-control {

   height: auto !important;

   }

   .input-group .form-control, .input-group-addon, .input-group-btn {

   display: table-cell;

   }

   .input-group .form-control {

   position: relative;

   z-index: 2;

   float: left;

   width: 100%;

   margin-bottom: 0;

   }

   .form-control {

   border-radius: 0;

   box-shadow: none;

   border-color: #d2d6de;

   }

   .form-control {

   display: block;

   width: 100%;

   height: 34px !important;

   padding: 6px 12px !important;

   font-size: 14px !important;

   line-height: 1.42857143;

   color: #555;

   background-color: #fff;

   background-image: none;

   border: 1px solid #ccc;

   border-radius: 4px;

   }

   .form-horizontal .label-wrapper {

   display: table;

   float: right;

   min-height: 28px;

   }

   .input-group-addon, .input-group-btn {

   width: 1%;

   white-space: nowrap;

   vertical-align: middle;

   }

   textarea.form-control {

   height: auto !important;

   }

   ul.easytree-container li {

    list-style-image: none;

    list-style-position: outside;

    list-style-type: none;

    -moz-background-clip: border;

    -moz-background-inline-policy: continuous;

    -moz-background-origin: padding;

    background-attachment: scroll;

    background-color: transparent;

    background-position: 0 0;

    background-repeat: repeat-y;

    background-image: none;

    margin: 0;

    padding: 1px 0 0 0;

}

.icon_title_box{

  position: relative;

    display: inline-block;

}

</style>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

   <!-- Content Header (Page header) -->

   <div class="content-header">

      <div class="container-fluid">

         <div class="row mb-2">

            <div class="col-sm-6">

               <h1 class="m-0 text-dark"><small><?=$page_module_name?> </small></h1>

            </div>

            <!-- /.col -->

            <div class="col-sm-6">

               <ol class="breadcrumb float-sm-right">

                  <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin."wam"?>">Home</a></li>

                  <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name?>"><?=$user_access->module_name?> List</a></li>

                  <? if(!empty($category_data)){ ?>

                  <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/view/".$category_id?>">View</a></li>

                  <? } ?>

                  <li class="breadcrumb-item"><?=$record_action?></li>

               </ol>

            </div>

            <!-- /.col -->

         </div>

         <!-- /.row -->

      </div>

      <!-- /.container-fluid -->

   </div>

   <!-- /.content-header -->

   <!-- Main content -->

   <?  ?>

   <section class="content">

      <div class="row">

         <div class="col-12">

            <div class="card">

               <div class="card-header">

                  <h3 class="card-title"> <small><?=$record_action?></small></h3>

               </div>

               <!-- /.card-header -->

                <div class="row">

               <div class="col-12">

                  <?php

                     if($user_access->view_module==1 || true)   {

                     ?>

                  <? echo $this->session->flashdata('alert_message'); ?>

                  <div class="card-body">

                     <?php echo form_open(MAINSITE_Admin."$user_access->class_name/doEdit", array('method' => 'post', 'id' => 'category_form' , "name"=>"category_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return validateForm()')); ?>

                     <input type="hidden" name="category_id" id="category_id" value="<?=$category_id?>" />

                     <input type="hidden" name="redirect_type" id="redirect_type" value="" />

                     <input type="hidden" name="approval_access" value="0">

                     <div class="row">

                     <div class="col-lg-8 col-md-6 col-sm-6">

                     <div class="form-group row justify-align-center">

                        <div class="col-lg-4 col-md-12 col-sm-12">

                           <label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Category Name <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>

                           <div class="col-sm-12">

                              <input type="text" class="form-control form-control-sm" required id="name" name="name" value="<? echo $name;?>" placeholder="Category Name">

                           </div>

                        </div>

                        <div class="col-lg-8 col-md-12 col-sm-12" >
                        	<div class="form-group row" style="padding-top: 40px">
                            	<div class="col-md-6">
                                	<div class="label-wrapper">
                                    	<label class="control-label" for="Name">Is Outside Menu Required</label>
                                        <label for="is_outer_menu1" class="col-sm-12 label_content px-2 py-0">Display on Homepage?</label>
                                        <div data-title="Is Outside Menu Required." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                                 	</div>
                              	</div>
                                <div class="col-md-6">
                                	<div class="form-check" style="margin-top:12px">
                                    	<div class="form-group clearfix">
                                        	<div class="icheck-success d-inline">
                                            	<input type="radio" name="is_outer_menu" <? if($is_outer_menu==1){echo "checked"; }?> value="1" id="is_outer_menu1">
                                        		<label for="is_outer_menu1"> Yes</label> &nbsp;&nbsp;
                                 			</div>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                             <div class="icheck-danger d-inline">
                                             	<input type="radio" name="is_outer_menu" <? if($is_outer_menu!=1){echo "checked"; }?> value="0" id="is_outer_menu2">
                                        <label for="is_outer_menu2"> No</label>

                                             </div>

                              </div>

                           </div>


                              	</div>
                           </div>
                        </div>







                        <div class="form-group is_parent_field" <?php /*?>style=" <? if(empty($super_category_id)){ ?> display:block <? }else{ ?> display:none <? } ?>"<?php */?> >

                     <div class="form-group row">

						<div class="col-lg-6 col-md-4 col-sm-6">
                       		<label class="control-label" for="Name">Category Icon
                            	<div data-title="Category Icon." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>
                            </label>
                            <div class="input-group">
                            	<input type="file" class="form-control imgInp" name="category_icon" id="category_icon" />
                                <mute><em>Icon Size : 20px X 20px</em></mute>
                                <div class="input-group-btn" style="border:1px solid #ddd"><div class="category-icon-display"> <? if(!empty($category_icon)){ ?><a href="<?php echo _uploaded_files_.'category/'.$category_icon; ?>" target="_blank"><img width="70" src="<?php echo _uploaded_files_.'category/'.$category_icon; ?>" class="img-preview" /></a><? } else{ ?> <img width="70" src="<?=_lte_files_.'dist/img/no-img.png'; ?>" class="img-preview" /> <?php } ?></div></div>
                                <? if(!empty($category_icon) && !empty($category_id)){ ?>
                                	<a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='category_icon' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>
                              <? } ?>
                           </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">

                           <label class="control-label" for="Name">

                              Cover Image

                              <div data-title="Cover Image." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                           </label>

                           <div class="input-group">

                              <input type="file" class="form-control imgInp" name="cover_image" id="cover_image" />

                              <mute><em>Image Size : 310 X 200</em></mute>

                              <div class="input-group-btn" style="border:1px solid #ddd"><div class="cover-image-display"> <? if(!empty($cover_image)){ ?><a href="<?php echo _uploaded_files_.'category/'.$cover_image; ?>" target="_blank"><img width="70" src="<?php echo _uploaded_files_.'category/'.$cover_image; ?>" class="img-preview" /></a><? } else{ ?> <img width="70" src="<?=_lte_files_.'dist/img/no-img.png'; ?>" class="img-preview" /> <?php } ?>  </div></div>

                              <? if(!empty($cover_image) && !empty($category_id)){ ?>

                              <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='cover_image' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>

                              <? } ?>

                           </div>

                        </div>

                        <div class="col-md-12">

                           <hr style="display:none">

                           <center style=""><strong>Header Main Image</strong> size(969px X 322px)</center>

                        </div>

                        <div class="col-md-6"   style="">

                           <label class="control-label" for="Name">

                              Header Image

                              <div data-title="Header Image." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                           </label>

                           <div class="input-group">

                              <input type="file" class="form-control" name="header_1_img" id="header_1_img" />

                              <div class="input-group-btn"><div class="header1-image-display">

                                 <? if(!empty($header_1_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$header_1_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$header_1_img; ?>" /></a><? } else{ ?> <img width="70" src="<?=_lte_files_.'dist/img/no-img.png'; ?>" class="img-preview" /> <?php } ?>

                              </div></div>

                              <? if(!empty($header_1_img) && !empty($category_id)){ ?>

                              <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='header_1_img' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>

                              <? } ?>

                           </div>

                        </div>

                        <div class="col-md-6" style="display:block">

                           <label class="control-label" for="Name">

                              Header Image Url

                              <div data-title="Header Image URL." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                           </label>

                           <input type="text" class="form-control" name="header_1_url" id="header_1_url" value="<?=$header_1_url?>" />

                        </div>

                     </div>

                     <div class="form-group row">

                        <div class="col-md-12" >

                           <hr>

                           <center><strong>Footer Images</strong> size(900px X 260px)</center>

                           <hr>

                        </div>

                        <div class="col-md-6" >

                           <label class="control-label" for="Name">

                              Footer Image

                              <div data-title="Footer Image1." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                           </label>

                           <div class="input-group">

                              <input type="file" class="form-control" name="footer_1_img" id="footer_1_img" />

                              <div class="input-group-btn"><div class="footer-image-display">

                                 <? if(!empty($footer_1_img)){ ?><a href="<?php echo _uploaded_files_.'category/'.$footer_1_img; ?>" target="_blank"><img width="40" src="<?php echo _uploaded_files_.'category/'.$footer_1_img; ?>" /></a><? } else{ ?> <img width="70" src="<?=_lte_files_.'dist/img/no-img.png'; ?>" class="img-preview" /> <?php } ?>

                              </div></div>

                              <? if(!empty($footer_1_img) && !empty($category_id)){ ?>

                              <a style="margin-left:20px;color:#F00;font-size:18px" onclick="deleteImage(this)" data-table='category' data-column='footer_1_img' data-id='<?=$category_id?>' ><i class="fa fa-trash"></i></a>

                              <? } ?>

                           </div>

                        </div>

                        <div class="col-md-6" >

                           <label class="control-label" for="Name">

                              Footer Image Url

                              <div data-title="Footer Image URL 1." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                           </label>

                           <input type="text" class="form-control" name="footer_1_url" id="footer_1_url" value="<?=$footer_1_url?>" />

                        </div>

                     </div>

                   <div class="col-lg-6 col-md-6 col-sm-6">

                        <label for="is_display_home_page1" class="col-sm-12 label_content px-2 py-0">Display on Homepage?</label>

                        <div class="col-sm-10">

                           <div class="form-check" style="margin-top:12px">

                              <div class="form-group clearfix">

                                 <div class="icheck-success d-inline">

                                    <input type="radio" name="is_display_home_page" <? if($is_display_home_page==1){echo "checked"; }?> value="1" id="is_display_home_page1">

                                    <label for="is_display_home_page1"> Yes

                                    </label>

                                 </div>

                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                 <div class="icheck-danger d-inline">

                                    <input type="radio" name="is_display_home_page" <? if($is_display_home_page!=1){echo "checked"; }?> value="0" id="is_display_home_page2">

                                    <label for="is_display_home_page2"> No

                                    </label>

                                 </div>

                              </div>

                           </div>

                        </div>

                  </div>

                 </div>

                     </div>

                     <div class="form-group row">







                      <div class="col-lg-3 col-md-4 col-sm-6">

                           <label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Slug URL<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>

                           <div class="col-sm-12">

                              <input type="text" class="form-control form-control-sm" required id="slug_url" name="slug_url" value="<? echo $slug_url;?>" placeholder="Slug URL">

                           </div>

                        </div>



                         <div class="col-lg-3 col-md-4 col-sm-6">

                           <label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Meta Title <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>

                           <div class="col-sm-12">

                              <input type="text" class="form-control form-control-sm" maxlength="60" required id="meta_title" name="meta_title" value="<? echo $meta_title;?>" placeholder="Meta Title">

                           </div>

                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6">

                           <label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Meta Description <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>

                           <div class="col-sm-12">

                              <input type="text" class="form-control form-control-sm" maxlength="160" required id="meta_description" name="meta_description" value="<? echo $meta_description;?>" placeholder="Meta Description">

                           </div>

                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6">

                           <label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Meta Keyword<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>

                           <div class="col-sm-12">

                              <input type="text" class="form-control form-control-sm" required id="meta_keyword" name="meta_keyword" value="<? echo $meta_keyword;?>" placeholder="Meta Keyword">

                           </div>

                        </div>

                        </div>



                     </div>

                     <div class="col-lg-4 col-md-4 col-sm-6">



 					<div class="sidebar1">

           <label class="control-label" for="Name">Super Category Name <div data-title="The name of the Main Category." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div><span class="required">*</span></label>

           <div class="input-group input-group-required">

              <input type="hidden" id="inputType" value="radio" />



              <div id="demo1_menu">

                 <ul>

                    <li class="isFolder isExpanded" title="New Parent Category">

                       <a href="0" target="super_category_id,0,<? if($super_category_id==0)echo "true";else echo "false"; ?>" > New Parent Category</a>

                       <?

					   foreach($category_list as $row1)

					   {

                          if($row1->super_category_id==0)

						  {

					 ?>

                     			<ul >

								<?

									$liClassExpend=''; $liClass = ''; $liFolderCount=0;

									foreach($category_list as $row2)

									{

										if($super_category_id==$row2->category_id)

											$liClassExpend = 'isExpanded';

										if($row2->super_category_id==$row1->category_id)

											$liFolderCount++;

									}

									if($liFolderCount>0)

									{

										$liClass = 'isFolder';

									}

								?>

                          <?  ?>

                          <li class="<? echo $liClass." ".$liClassExpend; ?> " title="Parent Category">

                             <a href="0" target="super_category_id,<? echo $row1->category_id; ?>,<? if($super_category_id==$row1->category_id)echo "true";else echo "false"; ?>" ><? echo $row1->name; ?></a>

                             <? foreach($category_list as $row3){

                                if($row3->super_category_id==$row1->category_id){

                                 ?>

                             <ul>

                                <? $liClassExpend='';$liClass = ''; $liFolderCount=0;foreach($category_list as $row4){if($super_category_id==$row4->category_id)$liClassExpend = 'isExpanded';if($row4->super_category_id==$row3->category_id)$liFolderCount++;}if($liFolderCount>0){$liClass = 'isFolder';} ?>



                                <li class="<? echo $liClass." ".$liClassExpend; ?> " title="Sub Category">

                                   <a href="0" target="super_category_id,<? echo $row3->category_id; ?>,<? if($super_category_id==$row3->category_id)echo "true";else echo "false"; ?>"><? echo $row3->name; ?></a>
                                  <? echo $row3->name; ?>

                                   <ul>

                                      <? foreach($category_list as $row5){ //echo "<pre>"; print_r($category_list); echo "</pre>";

                                         if($row5->super_category_id==$row3->category_id){ ?>

                                      <li class="" title="Super Sub Category"><a href="0" target="super_category_id,<? echo $row5->category_id; ?>,false"><? echo $row5->name; ?></a></li>

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

					</div>

                    </div>

               <div class="">

                  <div class="">

                     <div class="form-group row">

                        <div class="col-md-12">

                          <label for="inputEmail3" class="col-sm-12 label_content px-2 py-0"> Short Description <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span> <div data-title="Short Description " class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>

                          <!--  <label class="control-label" for="Name">

                              Short Description

                              <div data-title="Short Description " class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                           </label> -->

                           <textarea name="short_description" id="short_description" placeholder="Short Description" class="form-control" ><? echo $short_description;?></textarea>

                        </div>

                        <div class="col-md-12">

                           <label for="inputEmail3" class="col-sm-12 label_content px-2 py-0"> Long Description <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span> <div data-title="Short Description " class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div></label>

                          <!--  <label class="control-label" for="Name">

                              Long Description

                              <div data-title="Long Description " class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                           </label> -->

                           <textarea name="description" id="description" placeholder="Description" class="form-control ckeditor" ><? echo $description;?></textarea>

                        </div>

                        <!-- <textarea name="editor1" id="editor1" rows="10" cols="80">

                           This is my textarea to be replaced with CKEditor.

                           </textarea> -->

                        <script>

                           CKEDITOR.replace( 'description' );

                        </script>

                        <script type="text/javascript">

                           function readTextFile(file, callback, encoding) {

                           var reader = new FileReader();

                           reader.addEventListener('load', function (e) {

                           callback(this.result);

                           });

                           if (encoding) reader.readAsText(file, encoding);

                           else reader.readAsText(file);

                           }



                           function fileChosen(input, output) {

                           if (input.files && input.files[0]) {

                           readTextFile(

                            input.files[0],

                            function (str) {

                             output.value = str;

                            }

                           );

                           }

                           }



                           $('#files').on('change', function () {

                           var result = $("#files").text();



                           fileChosen(this, document.getElementById('description'));

                           CKEDITOR.instances['description'].setData(result);

                           });

                        </script>

                     </div>



                     <hr>

                     <div class="form-group row">

                        <div class="col-lg-3 col-md-6 col-sm-6">

                           <label for="radioSuccess1" class="col-sm-12 label_content px-2 py-0">Status</label>

                           <div class="col-sm-10">

                              <div class="form-check" style="">

                                 <div class="form-group clearfix">

                                    <div class="icheck-success d-inline">

                                       <input type="radio" name="status" <? if($status==1){echo "checked"; }?> value="1" id="radioSuccess1">

                                       <label for="radioSuccess1"> Active

                                       </label>

                                    </div>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <div class="icheck-danger d-inline">

                                       <input type="radio" name="status" <? if($status!=1){echo "checked"; }?> value="0" id="radioSuccess2">

                                       <label for="radioSuccess2"> Block

                                       </label>

                                    </div>

                                 </div>

                              </div>

                           </div>

                        </div>

                     </div>

                     <!-- /.card-body -->

                     <div class="card-footer">

                        <center>

                           <button type="submit" name="save" onclick=" redirect_type_func('');" value="1" class="btn btn-info">Save</button>

                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                           <button type="submit" name="save-add-new" onclick=" redirect_type_func('save-add-new');" value="1" class="btn btn-default ">Save And Add New</button>

                        </center>

                     </div>

                     </div>

                     </div>

                     <!-- /.card-footer -->

                     <?php echo form_close() ?>



                  </div>

                  <? }else{

                     $this->data['no_access_flash_message']="You Dont Have Access To View ".$page_module_name;

                     $this->load->view('admin/template/access_denied' , $this->data);

                     } ?>

                  <!-- /.card-body -->

               </div>

            </div>

         </div>

      </div>

      </div>

   </section>

   <?  ?>

</div>

<aside class="control-sidebar control-sidebar-dark">

   <!-- Control sidebar content goes here -->

</aside>


<script>
function validateForm()
{
	$('#category_form').attr('onsubmit', '');
	$( "#category_form" ).submit();
}

function redirect_type_func(data)
{
	document.getElementById("redirect_type").value = data;
	return true;
}
</script>
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
			url:'<? echo MAINSITE_Admin ?>catalog/Category-Module/deleteImagesForCategory',
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
<script>
window.addEventListener('load' , function(){
  if (window.File && window.FileList && window.FileReader) {
    $("#category_icon").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
		  //customized code
		  $(".pip").remove();
          $(".category-icon-display").html("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "</span>");
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }

  if (window.File && window.FileList && window.FileReader) {
    $("#cover_image").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
		  //customized code
		  $(".pip1").remove();
          $(".cover-image-display").html("<span class=\"pip1\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "</span>");
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }

  if (window.File && window.FileList && window.FileReader) {
    $("#header_1_img").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
		  //customized code
		  $(".pip2").remove();
          $(".header1-image-display").html("<span class=\"pip2\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "</span>");
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }

  if (window.File && window.FileList && window.FileReader) {
    $("#footer_1_img").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
		  //customized code
		  $(".pip3").remove();
          $(".footer-image-display").html("<span class=\"pip3\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "</span>");
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
</script>
