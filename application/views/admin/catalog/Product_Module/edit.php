<link rel="stylesheet" href="<?=_admin_files_?>css/tablednd.css" type="text/css"/>

<style>

   * {  box-sizing: border-box;}

   #myUL {list-style-type: none;padding: 0;margin: 0;}

   #myUL li a {background-color: #f6f6f6;}

   #myUL li a:hover:not(.header) {background-color: #eee;}
   .edit_button{
    padding: 5px !important;
    font-size: 14px !important;
   }
   .bg-blue {
    background-color: #007bff!important;
    font-size: 14px !important;
}

</style>

<link href="<?=_admin_files_?>skin-lion/ui.easytree.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php

   $page_module_name = "Product";

   /*echo "<pre>";

   print_r($tax_list);

   echo "</pre>";*/

   ?>

<?

   $is_update=false;

   $alert=$this->uri->segment(6);

   $record_action = "Add New Record";

   $product_id=0;

   $name='';

    $brand_id="";

   $brand_name="";

   $ref_code="";

   $hsn_code="";

   $tax_id="";

   $tax_name="";

   $short_description="";

   $description="";

   $application="";

   $added_on="";

   $added_by="";

   $updated_on="";

   $updated_by="";

   $updated_by_name="";

   $added_by_name="";

    $status=0;

   $tax_categories_id=0;

   $discount_group_id=0;

   $tax_providers_id=0;

   $is_sell_local=2;

   $is_bulk_enquiry=0;

   $product_sell_to=1;

   $product_use_info = array();

   $product_tag = array();

   $category_id_arr = array();

   $autoMetaCategory='';

   //print_r($product_detail);

   if(!empty($product_detail))

   {

    $record_action = "Update";

    $product_id = $product_detail->product_id;

    $name = $product_detail->name;

    $brand_id = $product_detail->brand_id;

    $brand_name = $product_detail->brand_name;

    $ref_code = $product_detail->ref_code;

    $hsn_code = $product_detail->hsn_code;

    $tax_id = $product_detail->tax_id;

    //$discount_group_id = $product_detail->discount_group_id;



    //$tax_name = $product_detail->tax_name;

    $short_description = $product_detail->short_description;

   $description = $product_detail->description;

   $application = $product_detail->application;

   $is_bulk_enquiry = $product_detail->is_bulk_enquiry;

    $added_on = $product_detail->added_on;

    $added_by = $product_detail->added_by_name;

    $updated_on = $product_detail->updated_on;

    $admin_user_id = $product_detail->updated_by_name;

    $status = $product_detail->status;





   }

   if(!empty($product_category_detail)){

      foreach($product_category_detail as $row){

        $category_id_arr[]=$row->category_id;

      }

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

   /*float: right;*/

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

   #list li{

              padding: 5px 10px;

    list-style-type: none;

    background: #ececec;

    margin-left: 5px;

    border-radius: 5px;

    color: #000 !important;

    font-size: 14px;

   }

     #list li::marker{

      display: none;

   }

   #list li img{

/*padding-left: 20px;*/

   }

   .img-checkbox img{

          width: 160px;

    height: 120px;

    object-fit: contain;

   }

   .table td, .table th {

    padding: 0.75rem;

    vertical-align: top;

    border-top: 1px solid #dee2e6;

    vertical-align: middle;

    text-align: center;

}

.edit_button{

      /* display: inline-block;*/

          background-color: #0062cc!important;

    border-color: #005cbf;

    font-weight: 400;

    color: #fff !important;

    text-align: center;

    vertical-align: middle;

    cursor: pointer;

    -webkit-user-select: none;

    -moz-user-select: none;

    -ms-user-select: none;

    user-select: none;

    background-color: transparent;

    border: 1px solid transparent;

    padding: 0.375rem 0.75rem;

    font-size: 1rem;

    line-height: 1.5;

    border-radius: 0.25rem;

    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;

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

                  <? if(!empty($product_detail)){ ?>

                  <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/view/".$product_id?>">View</a></li>

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

         <?
            $active_tab = $this->session->userdata("active_tab");
		 	//echo "active_tab : $active_tab";
            if(empty($active_tab))
            {
                $active_tab = "INFORMATION";
            }
            ?>

         <div class="col-md-12">
			<?=$this->session->flashdata('alert_message');?>
            <div class="row align-items-center bg-white tabb">

               <span class="pull-right n-pop-small" id="PopUpMsg"><i></i></span>

               <ul class="nav nav-tabs admin-tab1   col-md-9" role="tablist">



                  <li role="presentation" class="<? if($active_tab == "INFORMATION"){ echo "active";} ?>"><a href="#INFORMATION" class="<? if($active_tab == "INFORMATION"){ echo "active";} ?>" aria-controls="home" role="tab" data-toggle="tab">INFORMATION</a></li>

                  <li role="presentation" class=" <? if($active_tab == "COMBINATIONS"){ echo " active ";} ?>"><a href="#COMBINATIONS" class="<? if($active_tab == "COMBINATIONS"){ echo "active";} ?>" aria-controls="profile" role="tab" data-toggle="tab">COMBINATIONS</a></li>

                  <li role="presentation" class=" <? if($active_tab == "COMBINATIONS_POS"){ echo " active ";} ?>"><a href="#COMBINATIONS_POS" class="<? if($active_tab == "COMBINATIONS_POS"){ echo "active";} ?>" aria-controls="profile" role="tab" data-toggle="tab"> POSITION</a></li>

                  <li role="presentation" class=" <? if($active_tab == "images"){ echo " active ";} ?>"><a href="#images" class="<? if($active_tab == "images"){ echo "active";} ?>" aria-controls="messages" role="tab" data-toggle="tab">IMAGES</a></li>

                  <?php /*?>

                  <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>

                  <?php */?>

                  <?php if(!empty($user_access_seo)){ if($user_access_seo->update_module==1)  { ?>

                  <li role="presentation" class=" <? if($active_tab == "settings"){ echo " active ";} ?>"><a href="#settings" class="<? if($active_tab == "settings"){ echo "active";} ?>" aria-controls="settings" role="tab" data-toggle="tab">SEO Settings</a></li>

                  <? }} ?>

                  <li role="presentation" class=" <? if($active_tab == "add_review"){ echo " active ";} ?>"><a href="#add_review" class="<? if($active_tab == "add_review"){ echo "active";} ?>" aria-controls="add_review" role="tab" data-toggle="tab">Add Review</a></li>

               </ul>

               <div class="col-md-3 text-right" >

                  <a href="<?=MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i>&nbsp; Back To Product List</a>

               </div>

            </div>

         </div>

         <div class="col-md-12">

            <? if($alert == "success" || $alert == "update" || $alert == "fail" || $alert == "imageUpdate" || $alert == "wrongimageformat" || $alert == "imageDelete" || $alert == "combiSuccess"){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if($alert == "success") {echo "Record Inserted Successfully.";}else if($alert == "update") {echo "Record Updated Successfully.";}else if($alert == "fail"){echo "Error in updating this input.";}else if($alert == "imageUpdate"){echo "Image Inserted Seccessfully.";}else if($alert == "wrongimageformat"){echo "Wrong Image format. Only .jpg , .jpeg or .png image is allowed.";}else if($alert == "imageDelete"){echo "Image Deleted Seccessfully.";}else if($alert == "combiSuccess"){
				//echo "Combination Inserted Seccessfully.";
				}?></span><? }?>

            <div class="tab-content  admin-tab-cont1">

               <!--Information TAB-->

               <div role="tabpanel" class="tab-pane show fade <? if($active_tab == "INFORMATION"){ echo "in active show ";} ?>" id="INFORMATION">

                  <div class="box box-primary">

                     <div class="box-header with-border">

                        <h3 class="box-title">Product Information</h3>

                     </div>

                     <!-- /.box-header -->

                     <div class="box-body">

                        <?php echo form_open(MAINSITE_Admin."$user_access->class_name/doEdit", array('method' => 'post', 'id' => 'product_form' , "name"=>"product_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return validateForm()')); ?>

                        <input type="hidden" name="action" id="action_info" value="" />

                        <input type="hidden" name="product_id"  id="product_id" value="<?php echo $product_id; ?>" />

                        <div class="row">

                           <div class="form-group  col-md-8">

                              <div class="row">

                                 <div class="col-md-6">

                                    <label class="control-label" for="Name">

                                       Product Name

                                       <div data-title="The name of the Product." class="ico-help icon_title_box"> &nbsp;<i class="fa fa-question-circle"></i></div>

                                       <span class="required">*</span>

                                    </label>

                                    <input type="text" name="name" id="name" placeholder="Product Name" class="form-control" value="<? echo $name;?>" required >

                                    <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                 </div>

                                 <? if($product_id<=0){ ?>

                                 <div class="col-md-6" >

                                    <label class="control-label col-sm-3" for="Name">

                                       Image

                                       <div data-title="Product Images." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                       <span class="required">*</span>

                                    </label>

                                    <div class="col-md-9">

                                       <input type="file" name="image[]" id="p_image"  required  multiple />

                                    </div>

                                    <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                 </div>

                                 <? }else{ ?>

                                 <input type="file" style="display:none" name="image[]" id="p_image"  multiple />

                                 <? } ?>

                              </div>

                              <div class="col-md-12">

                                 <div class="row">

                                    <div class="col-md-4">

                                       <label class="control-label" for="Name">

                                          Brands/Manufacturer <? echo $brand_id; ?>

                                          <div data-title="Brands/Manufacturer." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                          <span class="required">*</span>

                                       </label>

                                       <select  name="brand_id" id="brand_id" class="form-control" required >

                                          <option value="">Please Select</option>

                                          <? foreach($brand_list as $row){ ?>

                                          <option <? if($brand_id==$row->brand_id){echo "selected";} ?> value="<? echo $row->brand_id; ?>"><? echo $row->brand_name; ?></option>

                                          <? } ?>

                                       </select>

                                       <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                    </div>

                                    <div class="col-md-4">

                                       <label class="control-label" for="Name">

                                          Reference Code

                                          <div data-title="Reference Code." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                          <span class="required">*</span>

                                       </label>

                                       <input type="text" name="ref_code" id="ref_code" placeholder="Reference Code" class="form-control" value="<? echo $ref_code;?>" required >

                                       <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                    </div>

                                    <div class="col-md-4">

                                       <label class="control-label" for="Name">

                                          HSN Code

                                          <div data-title="HSN Code." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                          <span class="required">*</span>

                                       </label>

                                       <input type="text" name="hsn_code" id="hsn_code" placeholder="HSN Code" class="form-control" value="<? echo $hsn_code;?>" required ><span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                    </div>

                                 </div>

                              </div>

                              <div class="col-md-12">

                                 <div class="row">

                                    <div class="col-md-4">

                                       <label class="control-label" for="Name">

                                          Tax Category

                                          <div data-title="Select The Tax Category." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                          <span class="required">*</span>

                                       </label>

                                       <select  name="tax_categories_id" id="tax_categories_id" class="form-control" required onchange="getTaxProvider(this)">

                                          <option value="">Please Select</option>

                                          <?

                                             foreach($tax_list as $row){ ?>

                                          <option <? if($tax_id==$row->tax_id){echo "selected";} ?> value="<? echo $row->tax_id; ?>"><? echo $row->tax_name; ?></option>

                                          <? } ?>

                                       </select>

                                       <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                    </div>

                                    <div class="col-md-4">

                                       <div class="label-wrapper">

                                          <label class="control-label" for="Name">Bulk Enquiry?</label>

                                          <div data-title="Is product available for bulk enquiry?" class="ico-help icon_title_box"> &nbsp;<i class="fa fa-question-circle"></i> </div>

                                          <span class="required">*</span>

                                          <div class="demo-radio-button">
                                          	<div class="icheck-success d-inline">

                                             <input type="radio" class="radio-col-green" name="is_bulk_enquiry" id="is_bulk_enquiry1" value="1" <?php if($is_bulk_enquiry==1) echo ' checked'; ?> required /><label for="is_bulk_enquiry1">Yes</label>

                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                             </div>
                                             <div class="icheck-danger d-inline">

                                             <input type="radio" class="radio-col-red" name="is_bulk_enquiry" id="is_bulk_enquiry2" value="0" <?php if($is_bulk_enquiry==0) echo ' checked'; ?> /><label for="is_bulk_enquiry2">No</label>   </div>

                                          </div>

                                       </div>

                                    </div>



                                 </div>

                              </div>

                              <div class="form-group">

                                 <div class="col-md-12">

                                    <div class="row">

                                       <div class="col-md-9" >

                                       </div>

                                    </div>

                                 </div>

                              </div>

                              <div class="col-md-12">

                                 <label class="control-label" for="Name">

                                    Short Description / Tag Line

                                    <div data-title="Short Description Of Product." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                    <span class="required"></span>

                                 </label>

                                 <textarea  class="search_textbox form-control" rows="8"  name="short_description" id="short_description" ><? echo $short_description;?></textarea>

                                 <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                              </div>

                           </div>

                           <div class="col-md-4">

                              <div class="sidebar1">

                                 <label class="control-label" for="Name">Select Category Name</label>

                                 <div class="input-group input-group-required">

                                    <input type="hidden" id="inputType" value="checkbox" />

                                    <div id="demo1_menu">

                                       <ul >

                                          <li class="isFolder isExpanded" title="New Parent Category">

                                             <i class="fa fa-folder"></i> <?php /*?><a href="0" target="super_category_id,0,true" ><?php */?> New Parent Category<?php /*?></a><?php */?>

                                             <? foreach($category_list as $row1){

                                                if($row1->super_category_id==0){ ?>

                                             <ul >

                                                <? $liClassExpend='';$liClass = ''; $liFolderCount=0;foreach($category_list as $row2){if(in_array($row2->category_id , $category_id_arr ))$liClassExpend = 'isExpanded';if($row2->super_category_id==$row1->category_id)$liFolderCount++;}if($liFolderCount>0){$liClass = 'isFolder';} ?>

                                                <li class="<? echo $liClass." ".$liClassExpend; ?> " title="Parent Category">

                                                   <i class="fa fa-angle-right"></i>

                                                   <?php /*?> <a href="0" target="super_category_id,<? echo $row1['category_id']; ?>,false" ><? echo $row1['name']; ?></a>

                                                   <a href="0" target="category_id[],<? echo $row1['category_id']; ?>,false" ><? echo $row1['name']; ?></a><?php */?>

                                                   <a href="0" target="category_id[],<? echo $row1->category_id; ?>,<? if(in_array($row1->category_id , $category_id_arr )){echo 'true';}else {echo "false";} ?>"><? echo $row1->name; ?></a>

                                                   <? foreach($category_list as $row3){

                                                      if($row3->super_category_id==$row1->category_id){

                                                       ?>

                                                   <ul>

                                                      <? $liClassExpend='';$liClass = ''; $liFolderCount=0;foreach($category_list as $row4){if($row4->super_category_id ==$row3->category_id)$liFolderCount++;}if($liFolderCount>0){$liClass = 'isFolder';if(in_array($row3->category_id , $category_id_arr ))$liClassExpend = 'isExpanded';} ?>

                                                      <li class="<? echo $liClass." ".$liClassExpend; ?>  " title="Sub Category">

                                                         <a href="0" target="category_id[],<? echo $row3->category_id; ?>,<? if(in_array($row3->category_id , $category_id_arr )){echo 'true';}else {echo "false";} ?>"><? echo $row3->name; ?></a>

                                                         <ul>

                                                            <? foreach($category_list as $row5){

                                                               if($row5->super_category_id==$row3->category_id){ ?>

                                                            <li class="" title="Super Sub Category"><a href="0" target="category_id[],<? echo $row5->category_id; ?>,<? if(in_array($row5->category_id , $category_id_arr )){echo 'true';}else {echo "false";} ?>"><? echo $row5->name; ?></a></li>

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

                                    <div class="input-group-btn"><span class="required">*</span>

                                    </div>

                                 </div>

                                 <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                              </div>

                           </div>

                        </div>

                        <div class="form-group">

                           <div class="col-md-12">

                              <label class="control-label" for="Name">

                                 Product Description

                                 <div data-title="Complete Product Description." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                 <span class="required"></span>

                              </label>

                              <textarea  class="search_textbox ckeditor"  name="description" id="description" style="width: 576px; height: 200px;"><? echo $description;?></textarea>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                        </div>

                        <div class="form-group">

                           <div class="col-md-12">

                              <label class="control-label" for="Name">

                                 Application

                                 <div data-title="Complete Product Application." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                 <span class="required"></span>

                              </label>

                              <textarea  class="search_textbox ckeditor"  name="application" id="application" style="width: 576px; height: 200px;"><? echo $application;?></textarea>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                        </div>

                        <? if($product_id>0){ ?>

                        <div class="form-group row">

                           <div class="col-md-2">

                              <div class="label-wrapper">

                                 <label class="control-label" for="Name">Published</label>

                                 <div data-title="Determines whether this Product is published." class="ico-help icon_title_box"> &nbsp;<i class="fa fa-question-circle"></i></div>

                                 <span class="required">*</span>

                              </div>

                           </div>

                           <div class="col-md-2" style="">

                              <div class="demo-radio-button ">

                                 <input type="radio" class="radio-col-green" name="status" id="status1" value="1" <?php if($status) echo ' checked'; ?> required /><label for="status1"> &nbsp;Active</label>

                                 &nbsp;&nbsp;

                                 <input type="radio" class="radio-col-red" name="status" id="status2" value="0" <?php if(!$status) echo ' checked'; ?> /><label for="status2"> &nbsp;Block</label>   </li>

                              </div>

                           </div>

                           <div class="col-md-2">

                              <div class="label-wrapper">

                                 <label class="control-label" for="Name">Added By</label>

                                 <div data-title="Added By." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </div>

                           </div>

                           <div class="col-md-2">

                              <div class="input-group input-group-required mt-2">

                                 <?php if(!empty($added_by_name)){  echo $added_by_name;}else echo "N/A"; ?>

                              </div>

                           </div>

                           <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           <div class="col-md-2">

                              <div class="label-wrapper">

                                 <label class="control-label" for="Name">Updated By</label>

                                 <div data-title="Updated By." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </div>

                           </div>

                           <div class="col-md-2">

                              <div class="input-group input-group-required mt-2">

                                 <?php if(!empty($updated_by_name)){ echo $updated_by_name;}else echo "N/A"; ?>

                              </div>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                        </div>

                        <div class="form-group row">

                           <div class="col-md-2">

                              <div class="label-wrapper">

                                 <label class="control-label" for="Name">Added On</label>

                                 <div data-title="Added On." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </div>

                           </div>

                           <div class="col-md-3">

                              <div class="input-group input-group-required">

                                 <?php  echo date('d-M-Y h:i:s A' , strtotime($added_on)); ?>

                              </div>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                           <div class="col-md-2">

                              <div class="label-wrapper">

                                 <label class="control-label" for="Name">Updated On</label>

                                 <div data-title="Updated On." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </div>

                           </div>

                           <div class="col-md-3">

                              <div class="input-group input-group-required">

                                 <?php if($updated_on!='0000-00-00 00:00:00'){  echo date('d-M-Y h:i:s A' , strtotime($updated_on));}else echo "N/A"; ?>

                              </div>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                        </div>

                        <div class="form-group row">

                        </div>

                        <? } ?>

                        <div class="col-md-12 text-center">

                           <button type="submit" onclick="return productValidation('save')"  class="btn btn-primary"><i class="fa fa-floppy-o"></i>Save</button>

                           <button type="submit" onclick="return productValidation('save-edit')" class="btn btn-default"><i class="fa fa-floppy-o"></i>Save and Continue Edit</button>

                        </div>

                        <?php echo form_close() ?>

                     </div>

                  </div>

               </div>

               <!--Combination TAB-->

               <div role="tabpanel" class="tab-pane fade <? if($active_tab == "COMBINATIONS"){ echo " in active show ";} ?>" id="COMBINATIONS">

                  <div class="box box-primary">

                     <div class="row mb-">

                        <div class="col-md-6">

                           <h3 class="box-title">PRODUCT COMBINATIONS</h3>

                        </div>

                        <div class="col-md-6">

                           <button type="button" style="float: right;" class="btn btn-danger " <?php /*?>data-toggle="collapse" data-target="#collapseOne"<?php */?>  onclick="setCombinationFormHeader(1)">Add New Combination</button>

                        </div>

                     </div>

                       <div class="bs-example" style="margin:0">

                           <div class="card-header" id="headingOne" style="    padding: 0.2rem 1.25rem !important; ">

                           </div>

                           <div class="accordion" id="accordionExample">

                              <div class="card">

                                 <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">

                                    <div class="card-body">

                                       <center>

                                          <i>

                                             <h3 id="combinationFormHeader">Add New Combination</h3>

                                          </i>

                                       </center>

                                       <?php echo form_open(MAINSITE_Admin.'catalog/Product-Module/doAddProductCombination', array('method' => 'post', 'name' => 'ProductAttributeForm', 'id' => 'ProductAttributeForm', 'style' => '', 'class' => 'form-horizontal', "enctype"=>"multipart/form-data")); ?>

                                       <?

                                          $trending_now=0;$hot_selling_now=0;$best_sellers=0;$new_product=0;

                                              ?>

                                       <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>" />

                                       <input type="hidden" name="product_combination_id" id="product_combination_id" value="0" />

                                       <div class="row">

                                          <div class="col-md-6">

                                             <label class="control-label"  for="Name">

                                                Product Display Name

                                                <div data-title="Product Display Name." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                <span class="required">*</span>

                                             </label>

                                             <input type="text" name="product_display_name" id="product_display_name" class="form-control" required />

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                           <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Combinations Reference Code

                                                <div data-title="Combinations Reference Code." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                <span class="required" style="margin-left:0">*</span>

                                             </label>

                                             <input type="text" name="ref_code" id="combref_code" placeholder="Reference Code" class="form-control" value="" required >

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Unit of Measurement

                                                <div data-title="Unit of Measurement for this Combination." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <select name="uom_id" id="uom_id"  class="form-control" required >

                                                <option value="">Select UOM</option>

                                                <? foreach($uom_list as $col){ ?>

                                                <option value="<? echo $col->unit_of_measurement_id; ?>"><? echo $col->unit_of_measurement_name; ?></option>

                                                <? } ?>

                                             </select>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                       </div>

                                       <div class="row">

                                          <div class="col-md-3">

                                             <label class="control-label"  for="Name">

                                                Attribute Name

                                                <div data-title="The Name Of The Product Attribute." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <select type="text" name="select_product_attribute_id" id="select_product_attribute_id" class="form-control"  onchange="getAttributeVal(this.value)">

                                                <option value="">Select Attribute</option>

                                                <? foreach($product_attribute_list as $col){ ?>

                                                <option value="<? echo $col->product_attribute_id; ?>"><? echo $col->name; ?></option>

                                                <? } ?>

                                             </select>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label"  for="Name">

                                                Attribute Value

                                                <div data-title="The Value Of The Selected Attribute." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <div class="input-group input-group-required" id="showAttributeValue">

                                                <? //echo "<pre>"; print_r($attribute_value_list);echo "</pre>"; ?>

                                                <select name="select_product_attribute_value_id" id="select_product_attribute_value_id" class="form-control" >

                                                   <option value="">Select Value</option>

                                                   <? foreach($attribute_value_list as $col){ ?>

                                                   <option value="<? echo $col->product_attribute_value_id; ?>"><? echo $col->name; ?></option>

                                                   <? } ?>

                                                </select>

                                             </div>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label"  for="Name">

                                                Combination Value

                                                <div data-title="The Value Of The Combination." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <input type="text" name="combination_values" id="combination_values" class="form-control" />

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label"   for="Name">

                                                Create Combination

                                                <div data-title="Create Combination." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <div class="input-group input-group-required" id="showAttributeValue"><? //echo "<pre>"; print_r($attribute_value_list);echo "</pre>"; ?>

                                                <input type="button" onclick="myFunc()" class="btn bg-blue" value="Make Combination" / style="width: 100%;">

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                       </div>



                                       <div class="row mt-2">

                                          <div class="col-md-12">

                                             <label class="control-label"  for="Name">

                                                Combinations

                                                <div data-title="Created Combinations." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <ul id="list" style="display: inline-flex;"> </ul>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                       </div>

                                       <div class="row">

                                           <div class="col-md-3" id="do_not_update" >

                                             <label class="control-label" for="Name">

                                                Quantity

                                                <div data-title="Quantity Of This Combination" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                <span class="required">*</span>

                                             </label>

                                             <input type="text" name="quantity" id="quantity" pattern="[0-9]{1,10}" title="Enter Only Number" placeholder="Combination Quantity" class="form-control" value="1" required >

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Price Excl. GST

                                                <div data-title="Price Of This Combination. Price Excluding GST" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                <span class="required">*</span>

                                             </label>

                                             <input type="text" name="price" id="price" pattern="[0-9]{1,10}" title="Enter Only Number"  placeholder="Combination Price" class="form-control" value="" required >

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Discounted Price Excl. GST

                                                <div data-title="Enter Discounted Price to calculate discount Percentage. Discounted Price Excluding GST" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <input type="number" name="discounted_price" id="discounted_price" onchange="discountByPrice()"  onkeyup="discountByPrice()" onclick="discountByPrice()" step="any" title="Enter Only Number"  placeholder="Discounted Price" class="form-control" value=""  >

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Discount

                                                <div data-title="Discount Of This Combination." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <input type="text" name="discount" id="discount" pattern="[0-9]{1,10}" title="Enter Only Number" placeholder="Combination Discount" class="form-control" value="0"  >

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Discount Variable

                                                <div data-title="Discount Variable for This Combination." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <select name="discount_var" id="discount_var"  class="form-control" >

                                                <option value="" style="display:none">Select Discount Variable</option>

                                                <option value="Rs">Rs. Off</option>

                                                <option value="%" selected> % Off</option>

                                             </select>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                       </div>

                                       <div class="row">

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Final Price

                                                <div data-title="Final Price Of This Combination." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                <span class="required">*</span>

                                             </label>

                                             <div class="input-group">

                                                <input  type="text" readonly="readonly" name="final_price" id="final_price"  placeholder="Combination Final Price" class="form-control" value="" required>

                                                <div class="input-group-btn">

                                                   <button type="button" class="btn btn-default btn-xs" onclick="combinationValidation(1)"  ><i class="fa fa-refresh text-danger" style="font-size:27px;"></i></button>

                                                </div>

                                             </div>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Product Weight(In Gram)

                                                <div data-title="Product Weight For Internal Use." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <input type="text" name="product_weight" id="product_weight" pattern="[0-9]{1,10}" title="Enter Only Number" placeholder="Product Weight" class="form-control" value=""  >

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-6">

                                             <label class="control-label" for="Name">

                                                Product Dimension ( IN CM ) (Length x Breadth x Height)

                                                <div data-title="Product Dimension In CM For Internal Use." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <div class="row">

                                                <div class="col-md-4">

                                                   <input type="number" name="product_l" id="product_l" step="any" pattern="[0-9]{1,10}" title="Enter Only Number"placeholder="Length" class="form-control" value=""  >

                                                   <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                                </div>

                                                <div class="col-md-4">

                                                   <input type="number" name="product_b" id="product_b" step="any" pattern="[0-9]{1,10}" title="Enter Only Number"  placeholder="Breadth" class="form-control" value=""  >

                                                   <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                                </div>

                                                <div class="col-md-4">

                                                   <input type="number" name="product_h" id="product_h" step="any" pattern="[0-9]{1,10}" title="Enter Only Number" placeholder="Height" class="form-control" value=""  >

                                                   <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                                </div>

                                             </div>

                                          </div>

                                          <div class="col-md-3">
                                          	<label class="control-label" for="Name">

                                                Is Trending Now

                                                <div data-title="Is Trending Now." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>



                                             </label>

                                             <div class="demo-radio-button">
                                             	<div class="icheck-success d-inline">
                                                	<input type="radio" class="radio-col-green" name="trending_now" id="trending_now1" value="1" <?php if($trending_now) echo ' checked'; ?> required />
                                                    <label for="trending_now1">Active &nbsp; &nbsp;</label>
                                               	</div>
                                                <div class="icheck-danger d-inline">
                                                	<input type="radio" class="radio-col-red" name="trending_now" id="trending_now2" value="0" <?php if(!$trending_now) echo ' checked'; ?> />
                                                    <label  for="trending_now2">Block &nbsp; &nbsp;</label>
												</div>

                                          </div>
                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Is Hot Selling Now

                                                <div data-title="Is Hot Selling Now" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>



                                             </label>

                                             <div class="demo-radio-button">
                                             	<div class="icheck-success d-inline">
                                                	<input type="radio" class="radio-col-green" name="hot_selling_now" id="hot_selling_now1" value="1" <?php if($hot_selling_now) echo ' checked'; ?> required />
                                                    <label for="hot_selling_now1">Active &nbsp; &nbsp;</label>
                                                    </div>
                                                    <div class="icheck-danger d-inline">

                                                <input type="radio" class="radio-col-red" name="hot_selling_now" id="hot_selling_now2" value="0" <?php if(!$hot_selling_now) echo ' checked'; ?> />

                                                <label  for="hot_selling_now2">Block &nbsp; &nbsp;</label>
                                                </div>

                                             </div>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Is Best Sellers

                                                <div data-title="Is Best Sellers" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>



                                             </label>

                                             <div class="demo-radio-button">
                                             	<div class="icheck-success d-inline">

                                                <input type="radio" class="radio-col-green" name="best_sellers" id="best_sellers1" value="1" <?php if($best_sellers) echo ' checked'; ?> required />

                                                <label for="best_sellers1">Active &nbsp; &nbsp;</label>
                                                </div>
                                                <div class="icheck-danger d-inline">

                                                <input type="radio" class="radio-col-red" name="best_sellers" id="best_sellers2" value="0" <?php if(!$best_sellers) echo ' checked'; ?> />

                                                <label  for="best_sellers2">Block &nbsp; &nbsp;</label>
                                                </div>

                                             </div>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Is New Product

                                                <div data-title="Is New Product" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>



                                             </label>

                                             <div class="demo-radio-button">
                                             	<div class="icheck-success d-inline">

                                                <input type="radio" class="radio-col-green" name="new_product" id="new_product1" value="1" <?php if($new_product) echo ' checked'; ?> required />

                                                <label for="new_product1">Active &nbsp; &nbsp;</label>
                                                </div>
                                                <div class="icheck-danger d-inline">

                                                <input type="radio" class="radio-col-red" name="new_product" id="new_product2" value="0" <?php if(!$new_product) echo ' checked'; ?> />

                                                <label for="new_product2">Block &nbsp; &nbsp;</label>
                                                </div>

                                             </div>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Delivery Charges

                                                <div data-title="Delivery Charges For This Product." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                Cancel

                                             </label>

                                             <input type="text" name="delivery_charges" id="delivery_charges" pattern="[0-9]{1,10}" title="Enter Only Number"  placeholder="Delivery Charges" class="form-control" value="0" required >

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Sold In Last  7 Days (In Number)

                                                <div data-title="Sold In Last  7 Days (In Number)" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <input type="number" name="current_sold_msg" id="current_sold_msg"  placeholder="Sold In Last  7 Days (In Number)" class="form-control" value=""  >

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-12">

                                             <label class="control-label" for="Name">

                                                Combination Default Image

                                                <div data-title="Price Of This Combination." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </label>

                                             <article class="row">

                                                <?

                                                   $pid_count=0;

                                                   foreach($product_image_detail as $col){$pid_count++; ?>

                                                <div class="img-checkbox demo-radio-button">
                                                	<div class="icheck-success d-inline">

                                                   <input class="radio-col-green"
                                                   <?=($col->default_image==1)? 'checked' : ''?>
                                                    name="product_image_id" id="product_image_id_<? echo $col->product_image_id; ?>" value="<? echo $col->product_image_id; ?>" <? if($pid_count==1){echo "selected";} ?> required type="radio" />

                                                   <label  for="product_image_id_<? echo $col->product_image_id; ?>">

                                                   <img id="img_product_image_id_<? echo $col->product_image_id ?>" src="<?=_uploaded_files_?>product/small/<? echo $col->product_image_name; ?>" width="80" />
                                                   </label>
</div>
                                                </div>

                                                <? } ?>

                                             </article>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>



                                       </div>

                                       <br>

                                       <?php /*?>

                                       <div class="form-group">

                                          <div class="col-md-3">

                                             <div class="label-wrapper">

                                                <label class="control-label" for="Name">Combinations Slug Url</label>

                                                <div data-title="The name of the Main Category." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </div>

                                          </div>

                                          <div class="col-md-9">

                                             <div class="input-group input-group-required">

                                                <? echo MAINSITE.$slug_url.'-';?> <input type="text" name="comb_slug_url" id="comb_slug_url" style="width:200px" placeholder="Combinations Slug Url" class="form-control" value="" required >

                                                <div class="input-group-btn"><span class="required">*</span>

                                                </div>

                                             </div>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                       </div>

                                       <?php */?>

                                       <div class="form-group row" >

                                          <div class="col-md-1">

                                             <div class="label-wrapper">

                                                <label class="control-label" for="Name">GTIN</label>

                                                <div data-title="Is display on Google merchant?" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </div>

                                          </div>

                                          <div class="col-md-2">

                                             <div class="demo-radio-button">
                                             	<div class="icheck-success d-inline">

                                                <input type="radio" class="radio-col-green is_google_product" name="is_google_product" id="is_google_product1" value="1" />

                                                <label for="is_google_product1">Yes &nbsp;&nbsp;</label>
                                                </div>
                                                <div class="icheck-danger d-inline">

                                                <input type="radio" class="radio-col-red is_google_product" checked="checked" name="is_google_product" id="is_google_product2" value="0" />

                                                <label for="is_google_product2"> No &nbsp;&nbsp;</label>
                                                </div>

                                             </div>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>



                                          <div class="col-md-1 gtin_class">

                                             <div class="label-wrapper">

                                                <label class="control-label" for="Name">GTIN</label>

                                                <div data-title="A Global Trade Item Number (GTIN) " class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </div>

                                          </div>

                                          <div class="col-md-2 gtin_class">

                                             <div class="input-group input-group-required">

                                                <input type="text" name="gtin" id="gtin"  maxlength="255" placeholder="Global Trade Item Number (GTIN)" class="form-control" value=""  >

                                                <div class="input-group-btn">

                                                </div>

                                             </div>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>
                                           <div class="col-md-2">

                                             <div class="label-wrapper">

                                                <label class="control-label" for="Name">Edit SEO Tags</label>

                                                <div data-title="Edit SEO Tags." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </div>

                                          </div>

                                          <div class="col-md-2">

                                             <div class="input-group input-group-required">

                                                <script>

                                                   window.addEventListener("load" , function(){

                                                    $('input[type=radio][name=is_seo_tag]').change(function() {

                                                      if (this.value == '1') {

                                                        $(".auto_seo_combi_tags").show();

                                                        $(".auto_seo_combi_tags_input").attr("required",true);

                                                      }

                                                      else if (this.value == '0') {

                                                        $(".auto_seo_combi_tags").hide();

                                                        $(".auto_seo_combi_tags_input").attr("required",false);

                                                      }

                                                    });

                                                   })



                                                </script>

                                                <div class="demo-radio-button">
                                                  <div class="icheck-success d-inline">

                                                   <input type="radio" class="radio-col-green" name="is_seo_tag" id="is_seo_tag1" value="1"  checked="checked" />

                                                   <label for="is_seo_tag1">Yes &nbsp;&nbsp;</label>
                                                   </div>
                                                   <div class="icheck-danger d-inline">

                                                   <input type="radio" class="radio-col-red" name="is_seo_tag" id="is_seo_tag2" value="0"  />

                                                   <label for="is_seo_tag2"> No &nbsp;&nbsp;</label>
                                                   </div>

                                                </div>

                                             </div>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                          <div class="col-md-2 auto_seo_combi_tags">

                                             <button type="button" class="btn bg-blue" onclick="combinationValidation('generateMeta')">Generate SEO Tags</button>

                                          </div>

                                       </div>

                                        <div class="form-group" style="display:none">

                                          <div class="col-md-3">

                                             <div class="label-wrapper">

                                                <label class="control-label" for="Name">Current Viewers Number</label>

                                                <div data-title="Current Viewers Message. Only Number" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </div>

                                          </div>

                                          <div class="col-md-9">

                                             <div class="input-group input-group-required">

                                                <input type="text" name="current_viewers_msg" id="current_viewers_msg"  maxlength="450" placeholder="Current Viewers Message" class="form-control" value=""  >

                                                <div class="input-group-btn">

                                                </div>

                                             </div>

                                             <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                          </div>

                                       </div>

                                       <div class="form-group" style="display:none">

                                          <div class="col-md-3">

                                             <div class="label-wrapper">

                                                <label class="control-label" for="Name">Is Message Dynamic</label>

                                                <div data-title="Is New Product" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </div>

                                          </div>

                                          <div class="col-md-9">

                                             <div class="input-group input-group-required">
                                             	<div class="icheck-success d-inline">

                                                <input type="radio" class="" name="is_msg_dynamic" id="is_msg_dynamic1" value="1"  required /> Yes &nbsp;&nbsp;
                                                </div>

                                                <input type="radio" class="" name="is_msg_dynamic" id="is_msg_dynamic2" value="0"  checked="checked" /> No

                                                <div class="input-group-btn"><span class="required">*</span>

                                                </div>

                                             </div>

                                          </div>

                                       </div>

                                        <div class="form-group" style="display:none">

                                          <div class="col-md-3">

                                             <div class="label-wrapper">

                                                <label class="control-label" for="Name">Add/Update Combination IN Store</label>

                                                <div data-title="Add/Update Combination IN Store." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                             </div>

                                          </div>

                                          <div class="col-md-9">

                                             <div class="input-group input-group-required">

                                                <input type="radio" class="" name="is_update_store" id="is_update_store1" value="1" checked  required /> Yes &nbsp;&nbsp;

                                                <input type="radio" class="" name="is_update_store" id="is_update_store2" value="0"   /> No

                                                <div class="input-group-btn"><span class="required">*</span>

                                                </div>

                                             </div>

                                          </div>

                                       </div>

                                      <!-- <div class="row">



                                       </div> -->

                                       <br>

                                       <div class="auto_seo_combi_tags">

                                          <input type="hidden" name="product_seo_id" id="auto_product_seo_id" value="0">

                                          <div class="form-group row">

                                             <div class="col-md-2">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Slug URL</label>

                                                   <div data-title="Slug URL." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-4">

                                                <div class="input-group input-group-required">

                                                   <input type="text" name="slug_url" id="auto_slug_url" placeholder="Slug URL" class="form-control auto_seo_combi_tags_input" value="" required >

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>





                                             <div class="col-md-2">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Meta Tite</label>

                                                   <div data-title="Meta Tite." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-4">

                                                <div class="input-group input-group-required">

                                                   <input type="text" name="meta_title"  maxlength="60" id="auto_meta_title" placeholder="Page Tite" class="form-control auto_seo_combi_tags_input" value="" required >

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>



                                          </div>

                                          <div class="form-group row">

                                           <div class="col-md-2">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name"> Meta Description</label>

                                                   <div data-title="Meta Description." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-4">

                                                <div class="input-group input-group-required">

                                                   <input type="text" name="meta_description" maxlength="160" id="auto_meta_description" placeholder="Meta Description" class="form-control auto_seo_combi_tags_input" value="" required >

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                              <div class="col-md-2">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Meta Keywords</label>

                                                   <div data-title="Meta Keywords." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-4">

                                                <div class="input-group input-group-required">

                                                   <input type="text" name="meta_keywords" id="auto_meta_keywords" placeholder="Meta Keywords" class="form-control auto_seo_combi_tags_input" value="" required >

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>





                                       </div>

                                       <div class="form-group row">

                                              <div class="col-md-3">

                                             <label class="control-label" for="Name">

                                                Published

                                                <div data-title="Determines whether this Product is published." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                <span class="required">*</span>

                                             </label>

                                             <div class="demo-radio-button">
                                             	<div class="icheck-success d-inline">

                                                <input type="radio" class="radio-col-green" name="status" id="combstatus1" value="1" <?php if($status) echo ' checked'; ?> required />

                                                <label for="combstatus1">Active &nbsp;&nbsp;</label>
                                                </div>
                                                <div class="icheck-danger d-inline">

                                                <input type="radio" class="radio-col-red" name="status" id="combstatus2" value="0" <?php if(!$status) echo ' checked'; ?> />

                                                <label for="combstatus2"> Block &nbsp;&nbsp;</label>
                                                </div>

                                             </div>

                                          </div>

                                          </div>

                                       <div class="row text-center">



                                          <button type="reset" onclick="combinationFormReset()" class="btn bg-blue" style="margin-right: 10px"><i class="fa fa-refresh"></i>&nbsp;Reset</button>





                                          <button type="button" onclick="return combinationValidation()" class="btn bg-blue normal_field"><i class="fa fa-floppy-o"></i>&nbsp;Save and Continue Edit</button>



                                          <button type="button" style="display:none" onclick="combinationCloneValidation()" class="btn bg-blue clone_field"><i class="fa fa-clone"></i>&nbsp; Clone and Continue Edit</button>

                                       </div>

                                       </form>

                                    </div>

                                 </div>

                              </div>

                           </div>

                        </div>

                     <div class="box-header with-border">

                     </div>



                     <!-- /.box-header -->

                     <? if($product_id<=0){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding product combinations.</span><? }?>

                     <? if(empty($product_image_detail)){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save the atleast one image of this product before adding product combinations.</span><? }?>

                     <div class="box-body">

                        <? if($product_id>=1 && !empty($product_image_detail)){?>

                        <table class="table table-striped">

                           <tr>

                              <th>Image</th>

                              <th class="text-center">Reff Code</th>

                              <th class="text-center">Combination</th>

                              <th class="text-center">Quantity</th>

                              <th class="text-center">Price</th>

                              <th class="text-center">Discount</th>

                              <th class="text-center">Final Price</th>

                              <th class="text-center">Status</th>

                              <th class="text-right">Default</th>

                              <th class="text-right">Actions</th>

                           </tr>

                           <tbody id="ProductCombinationList">

                           </tbody>

                        </table>

                        <script>

                           function setProductDefaultCombination(id , productId)

                           {

                              popUp("Processing The Request <i></i>" , 10000);

                              $.ajax({

                              type: "POST",

                            url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/setProductDefaultCombination',

                              //dataType : "json",

                              data : {"productId" : productId , "id" : id, "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},

                              success : function(result){

                              //alert(result);

                              if(result==1)

                              {

                                $('.checkCombBoxClass').attr('checked', false); // Unchecks it

                                $('#checkCombBoxId_'+id).attr('checked', true); // Checks it

                                document.getElementById('checkCombBoxId_'+id).checked = 'true';

                                popUp("Default Combination Set Successfully <i></i>" , 5000);

                              }

                              else{

                                popUp("Processing Failed. Try Again <i></i>" , 5000);

                              }

                              //$('#ProductImageList').html(result);

                              }

                              });

                           }

                              function editCombination(id)

                              {



                             //  document.getElementById('do_not_update').style.display = 'none';

                               document.getElementById('quantity').required = false;

                               //document.getElementById('select_product_attribute_id').focus();

                               $('#select_product_attribute_id').focus();
                              <? foreach($product_combination_detail as $row){$row = (array)$row; ?>

                                if(id== <? echo $row['product_combination_id'] ?>)

                                {

                                  //alert(id);

                                  document.getElementById('product_combination_id').value = '<? echo $row['product_combination_id'] ?>';

                                  document.getElementById('combref_code').value = '<? echo addslashes($row['ref_code']) ?>';

                                  document.getElementById('quantity').value = '<? echo $row['quantity'] ?>';

                                  document.getElementById('uom_id').value = '<? echo $row['uom_id'] ?>';

                                  document.getElementById('price').value = '<? echo $row['price'] ?>';

                                  document.getElementById('discount').value = '<? echo $row['discount'] ?>';

                                  document.getElementById('final_price').value = '<? echo $row['final_price'] ?>';

                                  document.getElementById('discounted_price').value = '<? echo $row['final_price'] ?>';

                                  <?php /*?>document.getElementById('comb_slug_url').value = '<? echo $row['comb_slug_url'] ?>';<?php */?>

                                  document.getElementById('product_l').value = '<? echo $row['product_l'] ?>';

                                  document.getElementById('product_b').value = '<? echo $row['product_b'] ?>';

                                  document.getElementById('product_h').value = '<? echo $row['product_h'] ?>';

                                  document.getElementById('product_weight').value = '<? echo $row['product_weight'] ?>';

                                  document.getElementById('product_display_name').value = '<? echo addslashes($row['product_display_name']) ?>';

                                  document.getElementById('delivery_charges').value = '<? echo $row['delivery_charges'] ?>';

                                  document.getElementById('current_viewers_msg').value = '<? echo $row['current_viewers_msg'] ?>';

                                  document.getElementById('gtin').value = '<? echo $row['gtin'] ?>';

                                  <? if(empty($row['product_seo_id'])){$row['product_seo_id']=0;} ?>

                                  document.getElementById('auto_product_seo_id').value = '<? echo $row['product_seo_id'] ?>';

                                  document.getElementById('auto_slug_url').value = '<? echo $row['slug_url'] ?>';

                                  document.getElementById('auto_meta_title').value = '<? echo $row['meta_title'] ?>';

                                  document.getElementById('auto_meta_description').value = '<? echo $row['meta_description'] ?>';

                                  document.getElementById('auto_meta_keywords').value = '<? echo $row['meta_keywords'] ?>';



                                  document.getElementById('current_sold_msg').value = '<? echo $row['current_sold_msg'] ?>';

                                  if(<? echo $row['is_msg_dynamic'] ?>==1)

                                  { document.getElementById('is_msg_dynamic1').checked = true; }

                                  else

                                  { document.getElementById('is_msg_dynamic2').checked = true; }

                                  if(<? echo $row['trending_now'] ?>==1)

                                  { document.getElementById('trending_now1').checked = true; }

                                  else

                                  { document.getElementById('trending_now2').checked = true; }

                                  if(<? echo $row['hot_selling_now'] ?>==1)

                                  { document.getElementById('hot_selling_now1').checked = true; }

                                  else

                                  { document.getElementById('hot_selling_now2').checked = true; }

                                  if(<? echo $row['best_sellers'] ?>==1)

                                  { document.getElementById('best_sellers1').checked = true; }

                                  else

                                  { document.getElementById('best_sellers2').checked = true; }

                                  if(<? echo $row['new_product'] ?>==1)

                                  { document.getElementById('new_product1').checked = true; }

                                  else

                                  { document.getElementById('new_product2').checked = true; }

                                  if(<? echo $row['status'] ?>==1)

                                  { document.getElementById('combstatus1').checked = true; }

                                  else

                                  { document.getElementById('combstatus2').checked = true; }



                                  if(<? echo $row['is_google_product'] ?>==1)

                                  { document.getElementById('is_google_product1').checked = true; }

                                  else

                                  { document.getElementById('is_google_product2').checked = true; }





                                  if(<? echo $row['product_image_id'] ?>>0)

                                  {

                                    document.getElementById('product_image_id_<? echo $row['product_image_id'] ?>').checked = true;

                                    document.getElementById('img_product_image_id_<? echo $row['product_image_id'] ?>').border = "5px !important";

                                  }

                                  if('<? echo $row['discount_var'] ?>'=='Rs')

                                    document.getElementById('discount_var').getElementsByTagName('option')[1].selected = 'selected';

                                  if('<? echo $row['discount_var'] ?>'=='%')

                                    document.getElementById('discount_var').getElementsByTagName('option')[2].selected = 'selected';

                                  var ul= document.getElementById("list");

                                  $('li', ul).each(function() {$(this).remove();});

                                  <?

                              foreach($product_combination_attribute_detail as $col)

                              {

                                $col = (array)$col;

                                if($col['product_combination_id']==$row['product_combination_id'])

                                {

                                  $attribute = '';

                                  $product_attribute_id = '';

                                  $attribute_val = '';

                                  $combination_value = $col['combination_value'];

                                  $product_attribute_value_id = '';

                                  foreach($product_attribute_list as $col1){$col1 = (array)$col1;if($col1['product_attribute_id']==$col['product_attribute_id']){$attribute=$col1['name'];$product_attribute_id = $col1['product_attribute_id'];}}

                                  foreach($attribute_value_list as $col1){$col1 = (array)$col1; if($col1['product_attribute_value_id']==$col['product_attribute_value_id']){$attribute_val=$col1['name'];$product_attribute_value_id=$col1['product_attribute_value_id'];}}



                                  ?>

                                      // $show.="$attribute : $col[combination_value] $attribute_val<br>";



                                       var li = document.createElement("li");

                                      li.appendChild(document.createTextNode('<? echo $attribute; ?>' ));

                                      li.innerHTML = '<? echo addslashes("$attribute : $combination_value $attribute_val"); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img width="22px" height="22px" src="<?=_admin_files_."images/cancel.png" ?>" /> <input type="hidden" name="product_attribute_id[]" value="<? echo $product_attribute_id ?>" /><input type="hidden" name="combination_value[]" value="<? echo addslashes($combination_value) ?>" /><input type="hidden" name="product_attribute_value_id[]" value="<? echo $product_attribute_value_id ?>"  />';

                                      li.setAttribute("onclick", "$(this).remove();");

                                      ul.appendChild(li);

                                       <?

                              }

                              }



                              ?>

                           var color = '#f00';

                              for(a=0;a<ul.getElementsByTagName("li").length ; a++){

                                if(a==ul.getElementsByTagName("li").length-1){color="#00f";}

                                ul.getElementsByTagName("li")[a].style.color=color;

                              }



                                }

                              <? } ?>



                              }

                        </script>

                        <style type="text/css">

                           .bs-example{

                           margin: 20px;

                           }

                           .card-header {

                           padding: .75rem -0.25rem;

                           margin-bottom: 0;

                           background-color: rgba(0,0,0,.03);

                           border-bottom: 1px solid rgba(0,0,0,.125);

                           }

                        </style>

                        <script>

                           function setCombinationFormHeader(task , pName='')

                           {

                            $(".clone_field").hide();

                            $(".normal_field").show();

                            if(task==3)

                            {

                              $('#combinationFormHeader').html('Clone this Combination : '+pName);

                              $(".clone_field").show();

                              $(".normal_field").hide();
							  document.getElementById('do_not_update').style.display = 'block';
                              document.getElementById('quantity').required = true;

                            }

                            else if(task==2)

                            {

                              $('#combinationFormHeader').html('Edit Combination : '+pName);

                            }

                            else

                            {

                              $('#combinationFormHeader').html('Add New Combination');

                              document.getElementById("ProductAttributeForm").reset();
							  document.getElementById('do_not_update').style.display = 'block';
                              document.getElementById('quantity').required = true;

                              $('#list').html('');

                              $('#product_combination_id').val(0);

                              var t_product_image_id = document.getElementsByName('product_image_id');

                              //t_product_image_id[0].checked=true;

                              //console.log(t_product_image_id);

                              //$("input:radio[name=product_image_id]:visible")[0].checked=true;

                              //$("input:radio[name=product_image_id][disabled=false]:first").attr('checked', true);

                              //$("#parentId input:radio[disabled=false]:first").attr('checked', true);

                              <?php /*?>//document.getElementById('product_image_id_<? echo $row['product_image_id'] ?>').checked = true;<?php */?>

                              <?php /*?>//document.getElementById('img_product_image_id_<? echo $row['product_image_id'] ?>').border = "5px !important";<?php */?>



                            }

                            $('#collapseOne').addClass("collapse show in");

                            $('#combinationFormHeader').focus();

							setGtin();

                           }

                        </script>



                        <? } ?>

                        <script>

                           function combinationCloneValidation()

                           {

                            event.preventDefault();

                            document.getElementById('product_combination_id').value = '0';

                            if(confirm("Do you really want to clone this product combination? If Yes this step can not be roll back."))

                            {

                              combinationValidation()

                            }

                            else

                            {

                              //do nothing

                            }

                           }





                           function combinationFormReset()

                           {

                            document.getElementById('do_not_update').style.display = 'block';

                            document.getElementById('quantity').required = true;

                            document.getElementById('product_combination_id').value=0;

                            var ul= document.getElementById("list");

                                  $('li', ul).each(function() {$(this).remove();});

                           }



                           function discountByPrice()

                           {

                            var discounted_price = document.getElementById("discounted_price");

                            var product_display_name = document.getElementById("product_display_name");

                            var price = document.getElementById("price");

                            var final_price = document.getElementById("final_price");

                            var discount = document.getElementById("discount");

                            var discount_var = document.getElementById("discount_var");

                            var temp=document.getElementById("price");

                            if(discounted_price.value == '')

                            {

                              return false;

                            }



                            if(Number(discounted_price.value) > Number(price.value))

                            {

                              alert("Final Price Cannot be less than price or 0");

                              return false;

                            }



                            discount_var.value = '%';

                            final_price.value = Number(discounted_price.value);

                            var dv = ((Number(price.value) - Number(final_price.value))/Number(price.value))*Number(100);

                            dv = dv.toFixed(2);

                            dv = dv.replace(/\.00$/,'');

                            discount.value = dv;



                           }



                           function combinationValidation(val='')

                           {

							   window.scrollTo(0, 20);

                            var t_product_attribute_id = document.getElementsByName('product_attribute_id[]');

                            var t_combination_value = document.getElementsByName('combination_value[]');

                            var t_product_attribute_value_id = document.getElementsByName('product_attribute_value_id[]');



                            var discounted_price = document.getElementById("discounted_price");

                            var product_display_name = document.getElementById("product_display_name");

                            var price = document.getElementById("price");

                            var final_price = document.getElementById("final_price");

                            var discount = document.getElementById("discount");

                            var discount_var = document.getElementById("discount_var");

                            var temp=document.getElementById("price");

                            var t_product_image_id = document.getElementsByName('product_image_id');

                            var t_product_image_id = document.getElementsByName('product_image_id');



                            var auto_meta_keywords = document.getElementById('auto_meta_keywords');

                            var auto_meta_description = document.getElementById('auto_meta_description');

                            var auto_meta_title = document.getElementById('auto_meta_title');

                            var auto_slug_url = document.getElementById('auto_slug_url');

                            var is_seo_tag = document.querySelector('input[name="is_seo_tag"]:checked').value;





                            const slug_url_only = string => [...string].every(c => '0123456789abcdefghijklmnopqrstuvwxyz-.ABCDEFGHIJKLMNOPQRSTUVWXYZ'.includes(c));



                            if(val==1 || val==3){

                              event.preventDefault();

                              if(discount_var.value=='Rs')

                              {

                                final_price.value = Number(price.value)-Number(discount.value);

                              }

                              else if(discount_var.value=='%')

                              {



                                if(discounted_price.value != '' && discounted_price.value>0)

                                {

                                  //discount_var.value = '%';

                                  final_price.value = Number(discounted_price.value);

                                  var dv = ((Number(price.value) - Number(final_price.value))/Number(price.value))*Number(100);

                                  dv = dv.toFixed(2);

                                  dv = dv.replace(/\.00$/,'');

                                  discount.value = dv;

                                }

                                else if(discount.value=='' && discount.value==0){

                                  final_price.value = price.value;

                                }

                                else

                                {

                                  var fp_temp = Number(price.value)-((price.value)*Number(discount.value)/100) ;

                                  //var fp_temp = parseFloat(fp_temp.toFixed(1));



                                  final_price.value = fp_temp;

                                }

                              }

                              else

                              {

                                final_price.value = price.value;

                              }

                              if(Number(price.value) < Number(final_price.value) || Number(final_price.value)<0)

                              {

                                alert("Final Price Cannot be less than price or 0");

                                return false;

                              }

                              return false;

                            }

                            else if(document.getElementsByName('product_attribute_id[]').length<=0)

                            {

                              alert("Create Atleast One Combination ");

                              return false;

                            }







                            if(product_display_name.value == '' || product_display_name.value == '')

                            {

                              alert("Please Provide Product Display Name");

                              product_display_name.focus();

                              return false;

                            }

                            if(discount.value == '' || discount.value == '')

                            {

                              document.getElementById("discount_var").required = false;

                              document.getElementById("discount").required = false;

                            }

                            if((discount.value != '' || discount.value == '') && (discount.value == '' || discount.value != ''))

                            {

                              document.getElementById("discount_var").required = true;

                              document.getElementById("discount").required = true;

                              //return false;

                            }

                            else

                            {

                              document.getElementById("discount_var").required = true;

                              document.getElementById("discount").required = true;

                            }

                            if(discount_var.value=='Rs')

                            {

                              final_price.value = Number(price.value)-Number(discount.value);

                            }

                            else if(discount_var.value=='%')

                            {

                              if(discounted_price.value != '' && discounted_price.value>0)

                              {

                                //discount_var.value = '%';

                                final_price.value = Number(discounted_price.value);

                                var dv = ((Number(price.value) - Number(final_price.value))/Number(price.value))*Number(100);

                                dv = dv.toFixed(2);

                                dv = dv.replace(/\.00$/,'');

                                discount.value = dv;

                              }

                              else if(discount.value==''){

                                  final_price.value = price.value;

                                }

                              else

                              {

                                var fp_temp = Number(price.value)-((price.value)*Number(discount.value)/100) ;

                                //var fp_temp = parseFloat(fp_temp.toFixed(1));



                                final_price.value = fp_temp;

                              }

                            }

                            else

                            {

                              final_price.value = price.value;

                            }

                            if(Number(price.value) < Number(final_price.value) || Number(final_price.value)<0)

                            {

                              alert("Final Price Cannot be less than price or 0");

                              return false;

                            }//ProductAttributeForm product_combination_id product_id comb_slug_url

                            var pid_check = true;

                            for(var ii=0 ; ii< t_product_image_id.length ; ii++)

                            {

                              if(t_product_image_id[ii].checked)

                              {

                                pid_check = false;

                              }

                            }



                            if(pid_check)

                            {

                              alert("Please select the default image for this combination.");

                              return false;

                            }



                            if(val=='generateMeta'){



                              generate_auto_seo_tags();

                              return false;

                            }





                            var form = document.getElementById('ProductAttributeForm');

                            //console.log(form.elements);

                            for(var i=0; i < form.elements.length; i++){

                                 if(form.elements[i].value === '' && form.elements[i].hasAttribute('required')){

                                form.elements[i].focus();

                                   alert(form.elements[i].name + ' is required fields!');

                                   return false;

                                 }

                               }





                            if(is_seo_tag==1)

                            {

                              if(auto_slug_url.value == '')

                              {

                                alert("Please Enter Slug Url");

                                auto_slug_url.focus();

                                return false;

                              }

                              if(!slug_url_only(auto_slug_url.value))

                              {

                                alert("Slug Url Contains Only A-Z a-z 0-9 '.' and '-' only. without space");

                                auto_slug_url.focus();

                                return false;

                              }



                              if(auto_meta_title.value == '')

                              {

                                alert("Please Enter Meta Title");

                                auto_meta_title.focus();

                                return false;

                              }

                              var auto_meta_title_val = auto_meta_title.value;



                              if(auto_meta_title_val.length > 60)

                              {

                                alert("Meta Title alphabet count should not be greater than 60 characters");

                                auto_meta_title.focus();

                                return false;

                              }



                              if(auto_meta_description.value == '')

                              {

                                alert("Please Enter Meta Description");

                                auto_meta_description.focus();

                                return false;

                              }



                              var auto_meta_description_val = auto_meta_description.value;



                              if(auto_meta_description_val.length > 160)

                              {

                                alert("Meta Description alphabet count should not be greater than 160 characters");

                                auto_meta_description.focus();

                                return false;

                              }



                              if(auto_meta_keywords.value == '')

                              {

                                alert("Please Enter Meta Keywords");

                                auto_meta_keywords.focus();

                                return false;

                              }

                            }





                            event.preventDefault();

                            console.log(Array.from(t_product_attribute_id));

                            console.log(Array.from(t_product_attribute_value_id));

                            console.log(Array.from(t_combination_value));

                            var form_obj = $('#ProductAttributeForm');

                           //, "t_product_attribute_id" : t_product_attribute_id, "t_product_attribute_value_id" : t_product_attribute_value_id, "t_combination_value" : t_combination_value



                            $.ajax({

                                   type: "POST",

                                  url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/checkProductCombinationCombiRefCode',

                                   dataType : "json",

                                   <?php /*?>data : {"product_id" : document.getElementById('product_id').value , "combref_code" : document.getElementById('combref_code').value, "product_combination_id" : document.getElementById('product_combination_id').value, "t_product_attribute_id" : Array.from(t_product_attribute_id), "t_product_attribute_value_id" : Array.from(t_product_attribute_value_id), "t_combination_value" : Array.from(t_combination_value) },<?php */?>

                                   data: form_obj.serialize(),

                                   success : function(result){

                                    //alert(result);

                                    if(result.position_status=='')

                                    {

                                      if(document.getElementById('product_combination_id').value>0)

                                      {

                                        alert("Kindly update the Product SEO Settings is required.");

                                      }

                                      $('.loader').show();

                                      if(val==1){}



                                      else

                                      {

                                        document.ProductAttributeForm.submit();

                                      }

                                    }

                                    else{

                                      if(result.position_status=='exist')

                                      {

                                        alert("The Product reference code is already in database");

                                        document.getElementById('combref_code').focus();

                                      }

                                      if(result.position_status=='combi_duplicate')

                                      {

                                        alert("The Product combination is already in database");

                                        document.getElementById('select_product_attribute_id').focus();

                                      }



                                      if(result.position_status=='slug_duplicate')

                                      {

                                        alert("The Product slug Url is already in database");

                                        document.getElementById('auto_slug_url').focus();

                                      }





                                    }

                                    }

                                   });

                                //document.ProductAttributeForm.submit();





                           }



                           function generate_auto_seo_tags()

                           {

                            //alert("func call");

                            var final_price = document.getElementById("final_price");

                            var product_display_name = document.getElementById('product_display_name');

                            var combi = "";



                            var auto_meta_keywords = document.getElementById('auto_meta_keywords');

                            var auto_meta_description = document.getElementById('auto_meta_description');

                            var auto_meta_title = document.getElementById('auto_meta_title');

                            var auto_slug_url = document.getElementById('auto_slug_url');





                            $slug_url = "#product_name#-#combi#";



                            //$title = "#product_name# - #combi# in India | Buy #product_name# #combi# Online At Best Price at seasonkart.com | #category#";

                            $title = "#product_name# - #combi# in India";



                            $keyword = "#product_name# - #combi# Price, #product_name#, Buy #product_name# Online";



                            //$description = "Buy #product_name# - #combi# for Rs.#price# online. #product_name# at best prices with FREE shipping & cash on delivery. Only Genuine Products";

                            $description = "Buy #product_name# - #combi# for Rs.#price# online. #product_name# at best prices with FREE shipping & cash on delivery.";



                            $slug_url = $slug_url.replace("#category#", "<?=$autoMetaCategory?>");

                            $title = $title.replace("#category#", "<?=$autoMetaCategory?>");

                            $keyword = $keyword.replace("#category#", "<?=$autoMetaCategory?>");

                            $description = $description.replace("#category#", "<?=$autoMetaCategory?>");



                            $slug_url = replaceAll($slug_url , "#product_name#", product_display_name.value);

                            $title = replaceAll($title , "#product_name#", product_display_name.value);

                            $keyword = replaceAll($keyword , "#product_name#", product_display_name.value);

                            $description = replaceAll($description , "#product_name#", product_display_name.value);



                            $slug_url = replaceAll($slug_url , "#price#", final_price.value);

                            $title = replaceAll($title , "#price#", final_price.value);

                            $keyword = replaceAll($keyword , "#price#", final_price.value);

                            $description = replaceAll($description , "#price#", final_price.value);





                              $('#list li').each(function(){

                                var myText = $(this).text();

                                combi = combi.concat(' '+myText);

                                combi = combi.trim();

                              });



                            $slug_url = replaceAll($slug_url , "#combi#", combi);

                            $title = replaceAll($title , "#combi#", combi);

                            $keyword = replaceAll($keyword , "#combi#", combi);

                            $description = replaceAll($description , "#combi#", combi);



                            //$slug_url = encodeURI($slug_url);



                            $slug_url = replaceAll($slug_url, ' ', '-')

                            $slug_url = replaceAll($slug_url, ':', '-')

                            $slug_url = replaceAll($slug_url, '--', '-')

                            $slug_url = replaceAll($slug_url, '--', '-')

							$slug_url = $slug_url.replace(/[^a-zA-Z 0-9 & -]/g, "");

                            var text = $slug_url;




                            auto_slug_url.value = text.toLowerCase($slug_url);

                            auto_meta_title.value = $title;
							var auto_meta_title_count = auto_meta_title.value.substring(0, 60);
							auto_meta_title.value = auto_meta_title_count;

                            auto_meta_description.value = $description;
							var auto_meta_description_count = auto_meta_description.value.substr(0, 160);
							auto_meta_description.value = auto_meta_description_count;

                            auto_meta_keywords.value = $keyword;







                           }



                           function replaceAll(str, find, replace)

                           {

                             return str.replace(new RegExp(find, 'g'), replace);

                           }







                        </script>

                     </div>

                  </div>

               </div>

               <!--Combination Position TAB-->

               <div role="tabpanel" class="tab-pane fade images-sec <? if($active_tab == "COMBINATIONS_POS"){ echo " in active show ";} ?>" id="COMBINATIONS_POS">

                  <div class="box box-primary">

                     <div class="box-header with-border">

                        <h3 class="box-title">Combination Position</h3>

                     </div>

                     <!-- /.box-header -->

                     <? if(count($product_combination_detail)<=0){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must add the product combination.</span><? }?>

                     <div class="box-body">

                        <? if(count($product_combination_detail)>0){?>

                        <div class="tableDemo">

                           <table class="table table-striped" id="table-3">

                              <thead>

                                 <tr >

                                    <th>Image</th>

                                    <th>Name</th>

                                    <th>Combination</th>

                                    <th >Position</th>

                                 </tr>

                              </thead>

                              <tbody id="ProductCombiListPOS">

                              </tbody>

                              <tr style="display:none">

                                 <td><img src="<? echo MAINSITE?>images/service-8.jpg" width="200" /></td>

                                 <td class="text-center" ><input id="checkBoxId_" class="checkBoxClass" onclick="setProductDefaultImage(id , productId)" type="checkbox" /></td>

                                 <td class="text-right"><a target="_blank" class="btn btn-default" onclick="javascript:location.href='';"><i class="fa fa-eye"></i>View This Image</a></td>

                              </tr>

                           </table>

                           <div class="result"></div>

                        </div>

                        <script>

                           function setProductDefaultImage(id , productId)

                           {

                            popUp("Processing The Request <i></i>" , 10000);

                            $.ajax({

                            type: "POST",

                           url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/setProductDefaultImage',

                            //dataType : "json",

                            data : {"productId" : productId , "id" : id , "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},

                            success : function(result){

                              //alert(result);

                           if(result==1)

                           {

                            $('.checkBoxClass').attr('checked', false); // Unchecks it

                            $('#checkBoxId_'+id).attr('checked', true); // Checks it

                            document.getElementById('checkBoxId_'+id).checked = 'true';

                            popUp("Default Image Set Successfully <i></i>" , 5000);

                           }

                           else{

                            popUp("Processing Failed. Try Again <i></i>" , 5000);

                           }

                           //$('#ProductImageList').html(result);

                           }

                            });

                           }

                        </script>

                        <? } ?>

                     </div>

                  </div>

               </div>

               <!--Image TAB-->

               <div role="tabpanel" class="tab-pane fade images-sec <? if($active_tab == "images"){ echo " in active show ";} ?>" id="images">

                  <div class="box box-primary">

                     <div class="box-header with-border">

                        <h3 class="box-title">Images</h3>

                     </div>

                     <!-- /.box-header -->

                     <? if($product_id<=0){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding images.</span><? }?>

                     <div class="box-body">

                        <? if($product_id>=1){?>

                        <?php echo form_open(MAINSITE_Admin."$user_access->class_name/doAddProductImages", array('method' => 'post', 'id' => 'product_image_form' , "name"=>"product_image_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return validateForm()')); ?>

                        <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>" />

                        <div class="form-group row">

                           <div class="col-md-2 ">

                              <label class="control-label" for="Name">Image</label>

                              <div data-title="Add More Images To This Product" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                           </div>

                           <div class="col-md-6">

                              <input type="file" class="form-control" name="image[]" id="image"  required  multiple />

                              <div id="preview"></div>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                           <div class="col-md-3">

                              <button type="submit" class="btn bg-blue"><i class="fa fa-floppy-o"></i>Add Images</button>

                           </div>

                        </div>

                        <?php echo form_close() ?>

                        <div class="tableDemo">

                           <table class="table table-striped" id="table-2">

                              <thead>

                                 <tr >

                                    <th>Image</th>

                                    <th>Position</th>

                                    <?php /*?><th class="text-center">Set As Default</th><?php */?>

                                    <th class="text-right">Action</th>

                                 </tr>

                              </thead>

                              <tbody id="ProductImageList">

                              </tbody>

                              <tr style="display:none">

                                 <td><img src="<? echo MAINSITE?>images/service-8.jpg" width="200" /></td>

                                 <td class="text-center" ><input id="checkBoxId_" class="checkBoxClass" onclick="setProductDefaultImage(id , productId)" type="checkbox" /></td>

                                 <td class="text-right"><a target="_blank" class="btn btn-default" onclick="javascript:location.href='';"><i class="fa fa-eye"></i>View This Image</a></td>

                              </tr>

                           </table>

                           <div class="result"></div>

                        </div>

                        <script>

                           function dragEvent()

                           {

                           table_2 = $("#table-2");

                                table_2.find("tr:even").addClass("alt");





                           $("#table-2").tableDnD({

                             onDragClass: "myDragClass",

                           onDrop: function(table, row) {

                            var rows = table.tBodies[0].rows;

                            var podId = '';

                            for (var i=0; i<rows.length; i++) {

                              podId+= rows[i].id+",";

                            }



                            $('#ProductImageList').html('<tr><td colspan="10"> <div class="clearfix text-center" ><img  src="<?=_admin_files_."images/load.gif"; ?>" /></div></td></tr>');

                            $.ajax({

                              type: "POST",



                            url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/GetCompleteProductImageListNewPos',

                              //dataType : "json",

                              data : {"product_id" : <? echo $product_id; ?> , 'podId':podId , "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},

                              success : function(result){

                              // alert(result);

                              $('#ProductImageList').html(result);

                              $(table).parent().find('.result').text("Order Changed Successfully");

                              dragEvent();

                              }

                              });



                           },

                           onDragStart: function(table, row) {

                           $(table).parent().find('.result').text("Started dragging row "+row.id);



                           },

                           onDragStop: function(table, row) {

                           $(table).parent().find('.result').text("Stop dragging row "+row.id);



                           var rows = table.tBodies[0].rows;

                           var rows =table.rows;

                           var debugStr = "Row dropped was "+row.id+". New order: ";





                           $(table).parent().find('.result').text(debugStr);



                           }

                           });



                           }



                           function setProductDefaultImage(id , productId)

                           {

                            popUp("Processing The Request <i></i>" , 10000);

                            $.ajax({

                            type: "POST",

                           url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/setProductDefaultImage',

                            //dataType : "json",

                            data : {"productId" : productId , "id" : id , "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},

                            success : function(result){

                              //alert(result);

                           if(result==1)

                           {

                            $('.checkBoxClass').attr('checked', false); // Unchecks it

                            $('#checkBoxId_'+id).attr('checked', true); // Checks it

                            document.getElementById('checkBoxId_'+id).checked = 'true';

                            popUp("Default Image Set Successfully <i></i>" , 5000);

                           }

                           else{

                            popUp("Processing Failed. Try Again <i></i>" , 5000);

                           }

                           //$('#ProductImageList').html(result);

                           }

                            });

                           }

                        </script>

                        <? } ?>

                     </div>

                  </div>

               </div>

               <div role="tabpanel" class="tab-pane fade" id="messages">dshfbwi wfiwe fewiu</div>

               <div role="tabpanel" class="tab-pane fade <? if($active_tab == "settings"){ echo " in active show ";} ?>" id="settings">

                  <div class="box box-primary">

                     <div class="box-header with-border">

                        <h3 class="box-title">SEO Settings</h3>

                     </div>

                     <!-- /.box-header -->

                     <? if($alert == "success" || $alert == "fail"){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if($alert == "success") {echo "Record Updated Successfully.";}else if($alert == "fail"){echo "Error in updating this input.";}?></span><? }?>

                     <div class="box-body">

                        <? if($product_id<=0){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding SEO Settings.</span><? }?>

                        <? if($product_id>=1){?>

                        <? if(!empty($product_combination_detail)){ ?>

                        <div class = "container col-md-12">

                           <div class="panel-group" id="accordion">

                              <? $ss_count=0; foreach($product_combination_detail as $pcd){$ss_count++; ?>

                              <? //print_r($pcd);

                                 $pcd = (array)$pcd;

                                  $show='';

                                  $final_price='';

                                    $category='';

                                  $query_get_list = $this->db->query("SELECT c.name FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and pc.product_id = ".$product_id);

                                 $query_data = $query_get_list->result();

                                 $category_arr = array();

                                 $category = '';

                                 if(!empty($query_data))

                                 {

                                  foreach($query_data as $qd)

                                  {

                                    $category_arr[] = $qd->name;

                                  }

                                  $category_arr = array_unique($category_arr);

                                  $category = implode(', ' , $category_arr);

                                 }



                                  foreach($product_combination_attribute_detail as $col)

                                  {

                                   $col = (array)$col;

                                   if($col['product_combination_id']==$pcd['product_combination_id'])

                                  {

                                    $show='';

                                    foreach($product_attribute_list as $col1){$col1 = (array)$col1;if($col1['product_attribute_id']==$col['product_attribute_id']){$attribute=$col1['name'];}}

                                    foreach($attribute_value_list as $col1){$col1 = (array)$col1;if($col1['product_attribute_value_id']==$col['product_attribute_value_id']){$attribute_val=$col1['name'];}}

                                    $show.="$attribute : $col[combination_value] $attribute_val<br>";

                                  }

                                 }

                                 if(!empty($product_seo_detail)){}



                                   ?>

                              <div class="panel panel-default">

                                 <div class="panel-heading">

                                    <h4 class="panel-title">

                                       <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#seo_setting_<? echo $ss_count; ?>">

                                       <? echo $pcd['product_display_name']; ?>  - <? echo $show; ?> <br>

                                       </a>

                                    </h4>

                                 </div>

                                 <div id="seo_setting_<? echo $ss_count; ?>" class="panel-collapse collapse <? if($ss_count==1){echo ' in';} ?> ">

                                    <div class="panel-body">

                                       <?php /*?>

                                       <pre><? print_r($product_seo_detail) ?></pre>

                                       <?php */?>

                                       <?

                                          $product_seo_id = 0;

                                          $slug_url  = $meta_title = $meta_description = $meta_keywords = $others='';

                                          if(!empty($product_seo_detail))

                                          {

                                            foreach($product_seo_detail as $psd)

                                          {

                                          if($psd['product_combination_id'] == $pcd['product_combination_id'])

                                          {

                                            $product_seo_id = $psd['product_seo_id'];

                                            $slug_url = $psd['slug_url'];

                                            $meta_title = $psd['meta_title'];

                                            $meta_description = $psd['meta_description'];

                                            $meta_keywords = $psd['meta_keywords'];

                                            $others = $psd['others'];

                                          }

                                          }

                                          }







                                          ?>

                                       <form role="form" class="form-horizontal" name="ProductFormSEO_<? echo $ss_count ?>" id="ProductFormSEO_<? echo $ss_count ?>" action="<?php echo MAINSITE_Admin.'products/doAddProductSEO';?>" method="post" enctype="multipart/form-data">

                                          <input type="hidden" name="action" id="action_info_<? echo $ss_count ?>" value="" />

                                          <input type="hidden" name="product_id"  id="product_id_<? echo $ss_count ?>" value="<?php echo $product_id; ?>" /><br />

                                          <input type="hidden" name="product_combination_id"  id="product_combination_id_<? echo $ss_count ?>" value="<?php echo $pcd['product_combination_id']; ?>" /><br />

                                          <input type="hidden" name="product_seo_id"  id="product_seo_id_<? echo $ss_count ?>" value="<? echo $product_seo_id ?>" /><br />

                                          <div class="form-group">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Final Price</label>

                                                   <div data-title="Final Price." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <input type="text" placeholder="Category" class="form-control" value="<? echo $pcd['final_price']?>">

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="form-group">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Category</label>

                                                   <div data-title="Category." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <input type="text" placeholder="Category" class="form-control" value="<? echo $category?>">

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="form-group">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Slug URL</label>

                                                   <div data-title="Slug URL." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <input type="text" name="slug_url" id="slug_url_<? echo $ss_count ?>" placeholder="Slug URL" class="form-control" value="<? echo $slug_url ?>" required >

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="form-group">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Meta Tite</label>

                                                   <div data-title="Meta Tite." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <input type="text" name="meta_title"  maxlength="60" id="meta_title_<? echo $ss_count ?>" placeholder="Page Tite" class="form-control" value="<? echo $meta_title ?>" required >

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="form-group">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name"> Meta Description</label>

                                                   <div data-title="Meta Description." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <input type="text" name="meta_description" maxlength="160" id="meta_description_<? echo $ss_count ?>" placeholder="Meta Description" class="form-control" value="<? echo $meta_description ?>" required >

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="form-group">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Meta Keywords</label>

                                                   <div data-title="Meta Keywords." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <input type="text" name="meta_keywords" id="meta_keywords_<? echo $ss_count ?>" placeholder="Meta Keywords" class="form-control" value="<? echo $meta_keywords ?>" required >

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="form-group" style="display:none">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Others Tags </label>

                                                   <div data-title="Others Tags." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <textarea  class="search_textbox "  name="others" id="others_<? echo $ss_count ?>" placeholder="Others Tags" style="width: 576px; height: 200px;"><? echo $others ?></textarea>

                                                   <div class="input-group-btn"><span class="required"></span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="pull-right">

                                             <button type="submit" onclick="return productSEOValidation('save' , <? echo $ss_count ?>)"  class="btn bg-blue"><i class="fa fa-floppy-o"></i>Save</button>

                                             <button type="submit" onclick="return productSEOValidation('save-edit' , <? echo $ss_count ?>)" class="btn bg-blue"><i class="fa fa-floppy-o"></i>Save and Continue Edit</button>

                                          </div>

                                       </form>

                                    </div>

                                 </div>

                              </div>

                              <? } ?>

                           </div>

                           <script>

                              function productSEOValidation(submitAction , id)

                              {

                                event.preventDefault();



                                const slug_url_only = string => [...string].every(c => '0123456789abcdefghijklmnopqrstuvwxyz-.ABCDEFGHIJKLMNOPQRSTUVWXYZ'.includes(c));





                                document.getElementById('action_info_'+id).value = submitAction;

                                var product_id = document.getElementById('product_id_'+id);

                                var product_combination_id = document.getElementById('product_combination_id_'+id);

                                var slug_url = document.getElementById('slug_url_'+id);

                                var meta_title = document.getElementById('meta_title_'+id);

                                var meta_description = document.getElementById('meta_description_'+id);

                                var meta_keywords = document.getElementById('meta_keywords_'+id);

                                var product_seo_id = document.getElementById('product_seo_id_'+id);



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



                                if(meta_title.value == '')

                                {

                                  alert("Please Enter Meta Title");

                                  meta_title.focus();

                                  return false;

                                }



                                if(meta_description.value == '')

                                {

                                  alert("Please Enter Meta Description");

                                  meta_description.focus();

                                  return false;

                                }



                                if(meta_keywords.value == '')

                                {

                                  alert("Please Enter Meta Keywords");

                                  meta_keywords.focus();

                                  return false;

                                }





                                $.ajax({

                                   type: "POST",



                                  url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/checkProductSEOSlugUrl',

                                   //dataType : "json",

                                   data : {"product_id" : product_id.value , "product_combination_id" : product_combination_id.value , "slug_url" : slug_url.value , "product_seo_id" : product_seo_id.value, "<?=$csrf['name']?>":"<?=$csrf['hash']?>" },

                                   success : function(result){

                                    //alert(result);

                                    if(result=='')

                                    {

                                      //document.ProductFormSEO_+id.submit();

                                      $( "#ProductFormSEO_"+id ).submit();

                                      $('.loader').show();

                                    }

                                    else

                                    {

                                      alert("The Slug Url is already in database");

                                      slug_url.focus();

                                    }

                                  }

                                });

                                return false;

                              }



                           </script>

                        </div>

                        <? }else{ ?>

                        <span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save any combination this product before adding SEO Settings.</span>

                        <? } ?>

                        <? } ?>

                     </div>

                  </div>

               </div>

               <div role="tabpanel" class="tab-pane fade <? if($active_tab == "add_review"){ echo " in active show ";} ?>" id="add_review">

                  <div class="box box-primary">

                     <div class="box-header with-border">

                        <h3 class="box-title">Add New Review</h3>

                     </div>

                     <!-- /.box-header -->

                     <? if($alert == "success" || $alert == "fail"){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if($alert == "success") {echo "Record Updated Successfully.";}else if($alert == "fail"){echo "Error in updating this input.";}?></span><? }?>

                     <div class="box-body">

                        <? if($product_id<=0){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding New Review.</span><? }?>

                        <? if($product_id>=1){?>

                        <? if(!empty($product_combination_detail)){ ?>

                        <div class = "container col-md-12">

                           <div class="panel-group" id="accordion">

                              <? $ss_count=0; foreach($product_combination_detail as $pcd){$ss_count++; ?>

                              <? //print_r($pcd);

                                 $pcd = (array)$pcd;

                                  $show='';

                                  foreach($product_combination_attribute_detail as $col)

                                  {

                                   $col = (array)$col;

                                   if($col['product_combination_id']==$pcd['product_combination_id'])

                                  {

                                    $show='';

                                    foreach($product_attribute_list as $col1){$col1 = (array)$col1;if($col1['product_attribute_id']==$col['product_attribute_id']){$attribute=$col1['name'];}}

                                    foreach($attribute_value_list as $col1){$col1 = (array)$col1;if($col1['product_attribute_value_id']==$col['product_attribute_value_id']){$attribute_val=$col1['name'];}}

                                    $show.="$attribute : $col[combination_value] $attribute_val<br>";

                                  }

                                 }







                                   ?>

                              <div class="panel panel-default">

                                 <div class="panel-heading">

                                    <h4 class="panel-title">

                                       <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#add_review_<? echo $ss_count; ?>">

                                       <? echo $pcd['product_display_name']; ?>  - <? echo $show; ?>

                                       </a>

                                    </h4>

                                 </div>

                                 <div id="add_review_<? echo $ss_count; ?>" class="panel-collapse collapse <? if($ss_count==1){echo ' in';} ?> ">

                                    <div class="panel-body">

                                       <?php /*?>

                                       <pre><? print_r($product_seo_detail) ?></pre>

                                       <?php */?>

                                       <form role="form" class="form-horizontal" name="ProductFormAddReview_<? echo $ss_count ?>" id="ProductFormAddReview_<? echo $ss_count ?>" action="<?php echo MAINSITE_Admin.'products/doAddProductReview';?>" method="post" enctype="multipart/form-data">

                                          <input type="hidden" name="product_id"  id="product_id_<? echo $ss_count ?>" value="<?php echo $product_id; ?>" /><br />

                                          <input type="hidden" name="product_combination_id"  id="product_combination_id_<? echo $ss_count ?>" value="<?php echo $pcd['product_combination_id']; ?>" /><br />

                                          <div class="form-group">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Name</label>

                                                   <div data-title="Name To Display." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <input type="text" name="customer_name" id="customer_name_<? echo $ss_count ?>" placeholder="Name" class="form-control" value="" required >

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="form-group">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Review Title</label>

                                                   <div data-title="Review Title." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <input type="text" name="review_title" id="review_title_<? echo $ss_count ?>" placeholder="Review Title" class="form-control" value="" required >

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="form-group">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name"> Review</label>

                                                   <div data-title="Review." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <textarea type="text" name="review" id="review_<? echo $ss_count ?>" placeholder="Review" class="form-control" required ></textarea>

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="form-group">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Rating</label>

                                                   <div data-title="Meta Keywords." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <select name="rating" id="rating_<? echo $ss_count ?>" class="form-control"  required >

                                                      <option value="">Select Rating</option>

                                                      <option value="1">1</option>

                                                      <option value="2">2</option>

                                                      <option value="3">3</option>

                                                      <option value="4">4</option>

                                                      <option value="5">5</option>

                                                   </select>

                                                   <div class="input-group-btn"><span class="required">*</span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="pull-right">

                                             <button type="submit" name="action" value="" class="btn bg-blue"><i class="fa fa-floppy-o"></i>Save</button>

                                             <button type="submit" name="action" value="save-edit" class="btn bg-blue"><i class="fa fa-floppy-o"></i>Save and Add New</button>

                                          </div>

                                       </form>

                                    </div>

                                 </div>

                              </div>

                              <? } ?>

                           </div>

                        </div>

                        <? }else{ ?>

                        <span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save any combination this product before adding New Review.</span>

                        <? } ?>

                        <? } ?>

                     </div>

                  </div>

               </div>

            </div>

            <!-- general form elements -->

            <!-- /.box -->

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

    /*event.preventDefault();

    //user_role user_role_id



    $(".error_span").html("");

    var user_role_id_arr = document.getElementsByName("user_role_id[]");

    var i=0;

    var user_role_check = true;

    for(i=0 ; i< user_role_id_arr.length ; i++)

    {

        if(user_role_id_arr[i].value !='')

        {

            user_role_check = false;

        }

    }

    if(user_role_check)

    {

        toastrDefaultErrorFunc("You Did Not Assign The Role To The User.");

        $("#user_role_error").html("You Did Not Assign The Role To The User.");

    }

    else{



    }*/

    $('#product_form').attr('onsubmit', '');

        $( "#product_form" ).submit();

   }





    function redirect_type_func(data)

    {

        document.getElementById("redirect_type").value = data;

        return true;

    }



    function previewImages()

   {

   var $preview = $('#preview').empty();

   if (this.files) $.each(this.files, readAndPreview);

   function readAndPreview(i, file)

   {

   if (!/\.(jpe?g|png|gif)$/i.test(file.name))

   {

    return alert(file.name +" is not an image");

   } // else...



   var reader = new FileReader();

   $(reader).on("load", function()

   {

    $preview.append( $("<img/>", {src:this.result, height:100}));

   });



   reader.readAsDataURL(file);

   }

   }

   $('#image').on("change", previewImages);









</script>

<script>

   $(document).ready(function()

   {



    $('.n-pop-click').click(function clickOpen(){

      $('.n-pop-small').css('display' , 'block');

      setTimeout(function() { $('.n-pop-small').css('display' , 'none');},5000);

    });

    $('.n-pop-small i').click(function(){

      $('.n-pop-small').css('display' , 'none');

    });



    $.ajax({

      type: "POST",



    url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/GetCompleteProductImageList',

      //dataType : "json",

      data : {"product_id" : <? echo $product_id; ?> , "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},

      success : function(result){

      // alert(result);

      $('#ProductImageList').html(result);

      dragEvent();

      }

      });



      $.ajax({

      type: "POST",



    url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/GetCompleteProductCombinationListPOS',

      //dataType : "json",

      data : {"product_id" : <? echo $product_id; ?> , "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},

      success : function(result){

      // alert(result);

      $('#ProductCombiListPOS').html(result);

      window.addEventListener("load", function(){

              dragEventPos();

            });

      }

      });



      $.ajax({

      type: "POST",



    url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/GetCompleteProductCombinationList',

      //dataType : "json",

      data : {"product_id" : <? echo $product_id; ?> , "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},

      success : function(result){

     //   alert(result);

      $('#ProductCombinationList').html(result);

      }

      });







   });

   function popUp(msg , popuptime)

   {

    $('.n-pop-small').css('display' , 'block');

    $('#PopUpMsg').html(msg);

    $('.n-pop-small i').click(function(){

      $('.n-pop-small').css('display' , 'none');

    });

    setTimeout(function() {$('.n-pop-small').css('display' , 'none');},popuptime);

   }

</script>

<script>

   function myFunc(){

    event.preventDefault()

    var ul= document.getElementById("list");

    var select_product_attribute_id = document.getElementById('select_product_attribute_id').value;

    var select_product_attribute_value_id = document.getElementById('select_product_attribute_value_id').value;

    var combination_values = document.getElementById('combination_values').value;

    var select_product_attribute_text = $("#select_product_attribute_id option:selected").text();

    var select_product_attribute_value_text = $("#select_product_attribute_value_id option:selected").text();

    var val = select_product_attribute_text + " : " +  combination_values + " " + select_product_attribute_value_text + '  ';

    if(select_product_attribute_id>0 && select_product_attribute_value_id>0)

    {

      var condition_per_product_count = 0;

      var select_product_attribute_condition_per_product = getAttributePerProduct(select_product_attribute_id);

      var select_product_attribute_condition_per_product_count = document.getElementsByName('product_attribute_id[]');

      for(a=0;a<select_product_attribute_condition_per_product_count.length ; a++){

        if(select_product_attribute_condition_per_product_count[a].value==select_product_attribute_id)

        condition_per_product_count++;

      }

      //alert(select_product_attribute_condition_per_product+" : "+condition_per_product_count);

      if(condition_per_product_count>=select_product_attribute_condition_per_product)

      {

        alert("You Can Not Create More Than "+select_product_attribute_condition_per_product+" Combination of Selected Attribute.");

        return false;

      }



      var li = document.createElement("li");

      if(val.trim()!=''){

        li.appendChild(document.createTextNode(val ));

        li.innerHTML = val+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img width="22px" height="22px" src="<?=_admin_files_."images/cancel.png" ?>" /> <input type="hidden" name="product_attribute_id[]" value="'+select_product_attribute_id+'" /><input type="hidden" name="combination_value[]" value="'+combination_values+'" /><input type="hidden" name="product_attribute_value_id[]" value="'+select_product_attribute_value_id+'"  />';

        li.setAttribute("onclick", "$(this).remove();");

        ul.appendChild(li);

        document.getElementById('combination_values').value='';

      }

      var a=0;

      var color = '#f00';

      for(a=0;a<ul.getElementsByTagName("li").length ; a++){

        if(a==ul.getElementsByTagName("li").length-1){color="#00f";}

        ul.getElementsByTagName("li")[a].style.color=color;

      }



      $('li', ul).each(function() {

        if($('li:contains("' + $(this).text() + '")', ul).length > 1)

          $(this).remove();

      });

    }

   }

   function getAttributeVal(attribute_value)

   {

    var optionText = '<option value="">Select Value</option>';



    <? foreach($attribute_value_list as $col){ ?>

    if(attribute_value==<? echo $col->product_attribute_id; ?>)

      optionText+='<option value="<? echo $col->product_attribute_value_id; ?>"><? echo $col->name; ?></option>'

    <? } ?>



    document.getElementById('showAttributeValue').innerHTML = '<select type="text" name="select_product_attribute_value_id" id="select_product_attribute_value_id" class="form-control" required>'+optionText+'</select><div class="input-group-btn"><span class="required">*</span>';

   }

   function getAttributePerProduct(attribute_value)

   {

    <? foreach($product_attribute_list as $col){ ?>

      if(attribute_value==<? echo $col->product_attribute_id; ?>)

        return "<? echo $col->condition_per_product; ?>";

    <? } ?>

    else return 1;

   }



   function dragEventPos()

      {

     table_2 = $("#table-3");

           table_2.find("tr:even").addClass("alt");





      $("#table-3").tableDnD({

        onDragClass: "myDragClass",

        onDrop: function(table, row) {

          var rows = table.tBodies[0].rows;

          var podId = '';

          for (var i=0; i<rows.length; i++) {

            podId+= rows[i].id+",";

          }



          $('#ProductCombiListPOS').html('<tr><td colspan="10"> <div class="clearfix text-center" ><img  src="<?=_admin_files_."images/load.gif"; ?>" /></div></td></tr>');

          $.ajax({

           type: "POST",



          url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/GetCompleteProductCombinationListPOS',

           //dataType : "json",

           data : {"product_id" : <? echo $product_id; ?> , 'podId':podId, "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},

           success : function(result){

            // alert(result);

            $('#ProductCombiListPOS').html(result);

            $(table).parent().find('.result').text("Order Changed Successfully");

            window.addEventListener("load", function(){

              dragEventPos();

            });

            }

           });



        },

      onDragStart: function(table, row) {

        $(table).parent().find('.result').text("Started dragging row "+row.id);



      },

      onDragStop: function(table, row) {

        $(table).parent().find('.result').text("Stop dragging row "+row.id);



        var rows = table.tBodies[0].rows;

        var rows =table.rows;

        var debugStr = "Row dropped was "+row.id+". New order: ";





        $(table).parent().find('.result').text(debugStr);



      }

    });



      }

</script>

<script src="<?=_admin_files_?>js/jquery.easytree.js"></script>

<script src="<?=_admin_files_?>js/jquery.tablednd.js" type="text/javascript"></script>

<script>

   window.addEventListener('load' , function(){

        $('#demo1_menu').easytree();

    });

</script>


<script>
function productValidation1(submitAction)
{
	document.getElementById('action_info').value = submitAction;
}
function productValidation(submitAction)
{
	//alert(submitAction);
	event.preventDefault();
	document.getElementById('action_info').value = submitAction;

	var description = CKEDITOR.instances.description.getData().replace(/(\r\n|\n|\r)/gm,"");
	document.getElementById('description').value = description;

	var application = CKEDITOR.instances.application.getData().replace(/(\r\n|\n|\r)/gm,"");
	document.getElementById('application').value = application;

	//var how_to_use = CKEDITOR.instances.how_to_use.getData().replace(/(\r\n|\n|\r)/gm,"");
	//document.getElementById('how_to_use').value = how_to_use;

	var category_id_arr = document.getElementsByName('category_id[]');
	var category_id_checked = 0;
	//alert(category_id_arr.length);
	for(var i=0 ; i<category_id_arr.length; i++)
	{
		if(category_id_arr[i].checked)
		{
			category_id_checked++;
		}
	}
	//alert(category_id_checked);
	if(category_id_checked==0)
	{
		alert("Please Select Atleast One Category");
		return false;
	}


		if(document.getElementById('name').validationMessage!='')
	{
		alert(document.getElementById('name').validationMessage);
		document.getElementById('name').focus();
		return false;
	}

		if(document.getElementById('brand_id').validationMessage!='')
	{
		alert(document.getElementById('brand_id').validationMessage);
		document.getElementById('brand_id').focus();
		return false;
	}

		if(document.getElementById('ref_code').validationMessage!='')
	{
		alert(document.getElementById('ref_code').validationMessage);
		document.getElementById('ref_code').focus();
		return false;
	}

		/*if(document.getElementById('slug_url').validationMessage!='')
	{
		alert(document.getElementById('slug_url').validationMessage);
		document.getElementById('slug_url').focus();
		return false;
	}*/

		if(document.getElementById('tax_categories_id').validationMessage!='')
	{
		alert(document.getElementById('tax_categories_id').validationMessage);
		document.getElementById('tax_categories_id').focus();
		return false;
	}

		if(document.getElementById('tax_categories_id').validationMessage!='')
	{
		alert(document.getElementById('tax_categories_id').validationMessage);
		document.getElementById('tax_categories_id').focus();
		return false;
	}

		if(document.getElementById('short_description').validationMessage!='')
	{
		alert(document.getElementById('short_description').validationMessage);
		document.getElementById('short_description').focus();
		return false;
	}

		if(document.getElementById('p_image').validationMessage!='')
	{
		alert(document.getElementById('p_image').validationMessage);
		document.getElementById('p_image').focus();
		return false;
	}

		if(document.getElementById('description').validationMessage!='')
	{
		alert(document.getElementById('description').validationMessage);
		document.getElementById('description').focus();
		return false;
	}

		/*if(document.getElementById('how_to_use').validationMessage!='')
	{
		alert(document.getElementById('how_to_use').validationMessage);
		document.getElementById('how_to_use').focus();
		return false;
	}*/

	$.ajax({
	   type: "POST",

		url:'<? echo MAINSITE_Admin ?>catalog/Product-Module/checkProductRefCode',
	   dataType : "json",
	   data : {"product_id" : document.getElementById('product_id').value , "ref_code" : document.getElementById('ref_code').value, "<?=$csrf['name']?>":"<?=$csrf['hash']?>" },
	   success : function(result){
			//alert(result);
			if(result.response==1)
			{
				//document.product_form.submit();
				$( "#product_form" ).submit();
				$('.loader').show();
			}
			else{
				alert("The Product Reference Code already in database");
				document.getElementById('ref_code').focus();
			}
			}
	   });
	//document.ProductFormMain.submit();

	return false;
}


function ConfirmImage()
{
	if(confirm("Do you really want to delete the image?"))
	{
		return true;
	}
	else
	{
		return false;
	}
}


$(document).on("change", ".is_google_product" , function(){
	setGtin();
})

function setGtin()
{
	if($("#is_google_product1").is(":checked"))
	{
		$(".gtin_class").show();
		$("#gtin").attr("required", true);
	}
	else
	{
		$(".gtin_class").hide();
		$("#gtin").attr("required", false);
		document.getElementById('gtin').value = '';
	}
}
</script>
