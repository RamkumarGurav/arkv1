<link href="<?=_admin_files_?>skin-lion/ui.easytree.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<? echo MAINSITE; ?>dist/css/lightbox.min.css">

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

</style>

<? 

   $page_module_name = "Product";

   $record_action = "View Record";

    ?>

<?php

   $trending_now=0;$hot_selling_now=0;$best_sellers=0;$new_product=0;

    $alert=$this->uri->segment(6);

    $product_id=0;

       $brand_id="";

    $name="";

    $ref_code="";

    $slug_url="";

    $short_description="";

    $description="";

    $application="";

    $added_on="";

    $added_by="";

    $updated_on="";

    $updated_by="";

    $updated_by_name="";

    $added_by_name="";

    $hsn_code="";

       $status=0;

    $is_sell_local=2;

    $is_bulk_enquiry=0;

    $product_sell_to=1;

    $tax_id='';

    $tax_categories_id='';

    $category_id_arr = array();

	//print_r($product_detail);

    if(!empty($product_detail)){ 

      //foreach($product_detail as $row){

        $product_id=$product_detail->product_id;

        $brand_id=$product_detail->brand_id;

        $name=$product_detail->name;

        $ref_code=$product_detail->ref_code;

        $short_description=$product_detail->short_description;

        $description=$product_detail->description;

        $application=$product_detail->application;

        $status=$product_detail->status;

        $added_on=$product_detail->added_on;

        $updated_on=$product_detail->updated_on;

        $updated_by_name=$product_detail->updated_by_name;

        $added_by_name=$product_detail->added_by_name;

        $status=$product_detail->status;

        $tax_id=$product_detail->tax_id;

        $hsn_code=$product_detail->hsn_code;

        $is_bulk_enquiry=$product_detail->is_bulk_enquiry;

      //} 

    }

    if(!empty($product_category_detail)){ 

      foreach($product_category_detail as $row){

        $category_id_arr[]=$row->category_id;

      } 

    }          

   ?>

   <!--  <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script> -->

    <style type="text/css">

      div.ex1 {

border: 1px solid #ececec;

  width: 100%;

  height: 110px;

  overflow: scroll;

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

   <!-- Main content -->

   <?=$this->session->flashdata('alert_message');?>

   <section class="content">

      <div class="row">

         <!-- form start -->

         <!-- Horizontal Form -->

         <!-- left column -->

         <div class="col-md-12">

            <? if($alert == "success" || $alert == "update" || $alert == "fail" || $alert == "imageUpdate" || $alert == "combiSuccess"){?><? if($alert == "success") {echo "<div class='alert alert-success'>Record Inserted Successfully.</div>";}else if($alert == "update") {echo "<div class='alert alert-success'>Record Updated Successfully.</div>";}else if($alert == "fail"){echo "<div class='alert alert-danger'>Error in updating this input.</div>";}else if($alert == "imageUpdate"){echo "<div class='alert alert-success'>Image Inserted Seccessfully.</div>";}else if($alert == "combiSuccess"){echo "<div class='alert alert-success'>Combination Inserted Seccessfully.</div>";}?><? }?>

            <div class="row align-items-center bg-white tabb">

               <ul class="nav nav-tabs admin-tab1 col-md-6" role="tablist">

                  <li role="presentation" class="active"><a href="#INFORMATION" aria-controls="home" class="active" role="tab" data-toggle="tab">INFORMATION</a></li>

                  <li role="presentation"><a href="#COMBINATIONS" aria-controls="profile" role="tab" data-toggle="tab">COMBINATIONS</a></li>

                  <li role="presentation"><a href="#images" aria-controls="messages" role="tab" data-toggle="tab">IMAGES</a></li>

                  <?php /*?>

                  <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>

                  <?php */?>

                  <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">SEO Settings</a></li>

               </ul>

               <div class="col-md-6">

                  <?php /*?><a href="<? echo MAINSITE."SecureRegions/wdm/products/list"; ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back To Product List</a><?php */?>
                  <a href="<?=MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name?>" class="btn btn-warning" ><?=$user_access->module_name?> Back To Product List</a>

                  <? if($product_id>0){ ?>

                  <?php  if($user_access->update_module==1) { ?>

                  <a href="<?=MAINSITE_Admin?>catalog/Product-Module/edit/<? echo $product_id ?>" class="btn btn-info" >Update Product</a>

                  <a href="<?=MAINSITE_Admin?>catalog/Product-Module/product_clone/<? echo $product_id ?>" onclick="return confirm('Do you really want to clone this product? ')" class="btn bg-danger" ><i class="fa fa-clone"></i>Clone and Continue Edit</a>

                  <? } } ?>

               </div>

            </div>

         </div>

         <div class="col-md-12">

            <div class="tab-content  admin-tab-cont1">

               <div role="tabpanel" class="tab-pane show fade in active" id="INFORMATION">

                  <div class="box box-primary">

                     <div class="box-header with-border">

                        <h3 class="box-title">Product Information</h3>

                     </div>

                     <!-- /.box-header -->

                     <div class="box-body ">

                        <form role="form" class="form-horizontal" name="ProductForm" id="ProductForm" action="<?php echo MAINSITE_Admin.'products/doAddProduct';?>" method="post" enctype="multipart/form-data">

                           <input type="hidden" name="action" id="action_info" value="" />

                           <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>" />   

                           <div class="row">          

                           <div class="col-md-9">

                              <div class="row">

                                 <div class="col-md-6">

                                    <label class="control-label" for="Name">

                                       Product Name 

                                       <div data-title="The name of the Product." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                    </label>

                                    <p><? echo $name;?></p>

                                    <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                 </div>

                                 <div class="col-md-6">

                                    <label class="control-label" for="Name">

                                       Brands/Manufacturer 

                                       <div data-title="Brands/Manufacturer." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                    </label>

                                    <p> <? foreach($brand_list as $row){ ?>

                                       <? if($brand_id==$row->brand_id){ echo $row->brand_name; } ?>

                                       <? } ?>

                                    </p>

                                    <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                 </div>

                                 <div class="col-md-6">

                                    <label class="control-label" for="Name">

                                       HSN Code 

                                       <div data-title="HSN Code." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                    </label>

                                    <p> <? echo $hsn_code;?></p>

                                    <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                 </div>

                                 <div class="col-md-6">

                                    <label class="control-label" for="Name">

                                       Reference Code 

                                       <div data-title="Reference Code." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                    </label>

                                    <p> <? echo $ref_code;?></p>

                                    <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                 </div>

                                 <div class="col-md-6">

                                    <label class="control-label" for="Name">

                                       Tax Category 

                                       <div data-title="Select The Tax Category." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                    </label>

                                    <p> <? foreach($tax_list as $row){ ?>

                                       <? if($tax_id==$row->tax_id){echo $row->tax_name;} ?>

                                       <? } ?>

                                    </p>

                                    <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                 </div>



                           <div class="col-md-6">

                              <label class="control-label" for="Name">

                                 Product Sold To 

                                 <div data-title="Product Sold To" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </label>

                              <p> <? 

                                 if($product_sell_to==1){echo "BOTH (Customer and Vendor)";}

                                 else if($product_sell_to==2){echo "Customer Only";}

                                 else if($product_sell_to==3){echo "Vendor Only";}

                                 ?></p>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                           <div class="col-md-6">

                              <label class="control-label" for="Name">

                                 Delivery In 

                                 <div data-title="Delivery In." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </label>

                              <p> <? if($is_sell_local==1){echo "Seasonkart Location";}else if($is_sell_local==1){echo "All India";}?></p>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                           <div class="col-md-6">

                              <label class="control-label" for="Name">

                                 Bulk Enquiry? 

                                 <div data-title="Is product available for bulk enquiry?" class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </label>

                              <p> <? if($is_bulk_enquiry==1){echo "Yes";}else {echo "No";}?></p>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                           <div class="col-md-12">

                              <label class="control-label" for="Name">

                                 Short Description / Tag Line 

                                 <div data-title="Short Description Of Product." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                 <span class="required"></span>

                              </label>

                              <!-- <p><? echo $short_description;?></p> -->



                                                                <textarea  class="search_textbox form-control" rows="8"  name="short_description" id="short_description" ><? echo $short_description;?></textarea>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>



                           <div class="col-md-12">

                              <label class="control-label" for="Name">

                                 Product Description 



                                 <div data-title="Complete Product Description." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                 <span class="required"></span>

                              </label>

                             <!--  <div class="ex1"><p><? echo $description;?></p></div> -->

                              <textarea  class="search_textbox ckeditor"  name="description" id="description" style="width: 576px; height: 200px;"><? echo $description;?></textarea>

                             

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>
                           
                           <div class="col-md-12">

                              <label class="control-label" for="Name">

                                 Application



                                 <div data-title="Complete Product Application." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                 <span class="required"></span>

                              </label>

                             <!--  <div class="ex1"><p><? echo $application;?></p></div> -->

                              <textarea  class="search_textbox ckeditor"  name="application" id="application" style="width: 576px; height: 200px;"><? echo $application;?></textarea>

                             

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                           <div class="col-md-3">

                              <label class="control-label" for="Name">

                                 Published

                                 <div data-title="Determines whether this Product is published." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </label>

                              <div class="demo-radio-button">

                                 <input type="radio" class="radio-col-green" name="status" id="status1" value="1" <?php if($status) echo ' checked'; ?> required /> <label for="status1">Active &nbsp;&nbsp;</label> 

                                 <input type="radio" class="radio-col-red" name="status" id="status2" value="0" <?php if(!$status) echo ' checked'; ?> />

                                 <label for="status2">Block &nbsp;&nbsp;</label> 

                              </div>

                           </div>

                           <? if($product_id>0){ ?>

                           <div class="col-md-3">

                              <label class="control-label" for="Name">

                                 Added By

                                 <div data-title="Added By." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </label>

                              <p><?php if(!empty($added_by_name)){  echo $added_by_name;}else echo "N/A"; ?> </p>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                           <div class="col-md-3">

                              <label class="control-label" for="Name">

                                 Added On 

                                 <div data-title="Added On." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </label>

                              <p><?php echo date('d-M-Y h:i:s A' , strtotime($added_on)); ?></p>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                           <div class="col-md-3">

                              <label class="control-label" for="Name">

                                 Updated On 

                                 <div data-title="Updated On." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </label>

                              <p><?php if($updated_on!='0000-00-00 00:00:00'){  echo date('d-M-Y h:i:s A' , strtotime($updated_on));}else echo "N/A"; ?></p>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                           <div class="col-md-3">

                              <label class="control-label" for="Name">

                                 Updated By 

                                 <div data-title="Updated By." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                              </label>

                              <p><?php if(!empty($updated_by_name)){  echo $updated_by_name;}else echo "N/A"; ?></p>

                              <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                           </div>

                           <? } ?>

                        </form>

</div>



                          </div>

                          <div class="col-md-3">

                            <div class="sidebar1">

                           <label class="control-label" for="Name">

                              Select Category Name 

                              <div data-title="Select The Product Category." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                           </label>

                           <input type="hidden" id="inputType" value="checkbox" />

                           <div id="demo1_menu">

                              <ul>

                                 <li class="isFolder isExpanded" title="New Parent Category">

                                    <?php /*?><a href="0" target="super_category_id,0,true" ><?php */?> New Parent Category<?php /*?></a><?php */?>

                                    <? foreach($category_list as $row1){

                                       if($row1->super_category_id==0){ ?>

                                    <ul >

                                       <? $liClassExpend='';$liClass = ''; $liFolderCount=0;foreach($category_list as $row2){if(in_array($row2->category_id , $category_id_arr ))$liClassExpend = 'isExpanded';if($row2->super_category_id==$row1->category_id)$liFolderCount++;}if($liFolderCount>0){$liClass = 'isFolder';} ?>

                                       <li class="<? echo $liClass." ".$liClassExpend; ?> " title="Parent Category">

                                          <?php /*?><a href="0" target="super_category_id,<? echo $row1['category_id']; ?>,false" ><?php */?><? echo $row1->name; ?><?php /*?></a><?php */?>

                                          <a href="0" target="category_id[],<? echo $row1->category_id; ?>,<? if(in_array($row1->category_id , $category_id_arr )){echo 'true';}else {echo "false";} ?>"><? echo $row1->name; ?></a>

                                          <? foreach($category_list as $row3){

                                             if($row3->super_category_id==$row1->category_id){

                                              ?>                

                                          <ul>

                                             <? $liClassExpend='';$liClass = ''; $liFolderCount=0;foreach($category_list as $row4){if($row4->super_category_id==$row3->category_id)$liFolderCount++;}if($liFolderCount>0){$liClass = 'isFolder';if(in_array($row3->category_id , $category_id_arr ))$liClassExpend = 'isExpanded';} ?>

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

                           <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                        </div>

                      </div>

                        </div>



                        

                     </div>

                  </div>

               </div>

               <div role="tabpanel" class="tab-pane fade" id="COMBINATIONS">

                  <div class="box box-primary">

                     <div class="box-header with-border">

                        <h3 class="box-title">PRODUCT COMBINATIONS</h3>

                     </div>

                     <!-- /.box-header -->

                     <? if($product_id<=0){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding product combinations.</span><? }?>

                     <div class="box-body">

                        <? if($product_id>=1){?>

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

                            function setProductDefaultCombination(id , productId)

                            {

                             popUp("Processing The Request <i></i>" , 10000);

                             $.ajax({

                             type: "POST",

                           url:'<? echo MAINSITE_Admin ?>setProductDefaultCombination',

                             //dataType : "json", 

                             data : {"productId" : productId , "id" : id},

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

                             document.getElementById('select_product_attribute_id').focus();

                            <? foreach($product_combination_detail as $row){$row = (array)$row; ?>

                            if(id== <? echo $row['product_combination_id'] ?>)

                            {

                              //alert(id);

                              document.getElementById('product_combination_id').value = '<? echo $row['product_combination_id'] ?>';

                              document.getElementById('combref_code').value = '<? echo $row['ref_code'] ?>';

                              document.getElementById('quantity').value = '<? echo $row['quantity'] ?>';

                              document.getElementById('product_weight').value = '<? echo $row['product_weight'] ?>';

                              document.getElementById('product_dimension').value = '<? echo $row['product_dimension'] ?>';

                              document.getElementById('price').value = '<? echo $row['price'] ?>';

                              document.getElementById('discount').value = '<? echo $row['discount'] ?>';

                              document.getElementById('final_price').value = '<? echo $row['final_price'] ?>';

                              document.getElementById('comb_slug_url').value = '<? echo $row['comb_slug_url'] ?>';

                              document.getElementById('product_l').value = '<? echo $row['product_l'] ?>';

                              document.getElementById('product_b').value = '<? echo $row['product_b'] ?>';

                              document.getElementById('product_h').value = '<? echo $row['product_h'] ?>';

                              document.getElementById('product_weight').value = '<? echo $row['product_weight'] ?>';

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

                              { document.getElementById('combstatus2').checked = false; }

                              document.getElementById('product_image_id_<? echo $row['product_image_id'] ?>').checked = true;

                              document.getElementById('img_product_image_id_<? echo $row['product_image_id'] ?>').border = "5px !important";

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

                                  li.innerHTML = '<? echo "$attribute : $combination_value $attribute_val"; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img width="22px" height="22px" src="<?=_admin_files_."images/cancel.png" ?>" /> <input type="hidden" name="product_attribute_id[]" value="<? echo $product_attribute_id ?>" /><input type="hidden" name="combination_value[]" value="<? echo $combination_value ?>" /><input type="hidden" name="product_attribute_value_id[]" value="<? echo $product_attribute_value_id ?>"  />';

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

                        <? } ?>

                        <script>

                           function combinationFormReset()

                           {

                            document.getElementById('product_combination_id').value=0;

                            var ul= document.getElementById("list");

                                  $('li', ul).each(function() {$(this).remove();});

                           }

                           

                           function combinationValidation(val)

                           {

                            if(val==1){}

                            

                            else if(document.getElementsByName('product_attribute_id[]').length<=0)

                            {

                              alert("Create Atleast One Combination ");

                              return false;

                            }

                            var price = document.getElementById("price");

                            var final_price = document.getElementById("final_price");

                            var discount = document.getElementById("discount");

                            var discount_var = document.getElementById("discount_var");

                            var temp=document.getElementById("price");

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

                              final_price.value = Number(price.value)-(Number(price.value)*Number(discount.value)/100);

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

                            

                           }

                        </script>

                     </div>

                  </div>

               </div>

               <div role="tabpanel" class="tab-pane fade images-sec" id="images">

                  <div class="box box-primary">

                     <div class="box-header with-border">

                        <h3 class="box-title">Images</h3>

                     </div>

                     <!-- /.box-header -->

                     <? if($product_id<=0){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding images.</span><? }?>

                     <div class="box-body">

                        <? if($product_id>=1){?>

                        <link rel="stylesheet" href="<? echo MAINSITE ?>assets/administrator/css/tablednd.css" type="text/css"/>

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

                        <script src="<?=_admin_files_?>js/jquery.tablednd.js" type="text/javascript"></script>

                        <script>    

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

               <div role="tabpanel" class="tab-pane fade" id="settings">

                  <div class="box box-primary">

                     <div class="box-header with-border">

                        <h3 class="box-title">SEO Settings</h3>

                     </div>

                     <!-- /.box-header -->

                     <? 
					 
					 if($alert == "success" || $alert == "fail"){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if($alert == "success") {echo "Record Updated Successfully.";}else if($alert == "fail"){echo "Error in updating this input.";}?></span><? }?>

                     <div class="box-body">

                        <? if($product_id<=0){?><span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save this product before adding SEO Settings.</span><? }?>

                        <? if($product_id>=1){?> 

                        <? if(!empty($product_combination_detail)){ ?>                

                        <div class = "container col-md-12">

                           <div class="panel-group" id="accordion">

                              <? $ss_count=0; foreach($product_combination_detail as $pcd){$ss_count++;$pcd = (array)$pcd; ?>

                              <? //print_r($pcd);

                                 foreach($product_combination_attribute_detail as $col)

                                 {
									 $show="";
									$col = (array)$col;
                                  if($col['product_combination_id']==$pcd['product_combination_id'])

                                 {

                                  $show='';

                                  foreach($product_attribute_list as $col1){$col1 = (array)$col1; if($col1['product_attribute_id']==$col['product_attribute_id']){$attribute=$col1['name'];}}

                                  foreach($attribute_value_list as $col1){$col1 = (array)$col1; if($col1['product_attribute_value_id']==$col['product_attribute_value_id']){$attribute_val=$col1['name'];}}

                                  $show.="$attribute : $col[combination_value] $attribute_val<br>";

                                 }

                                 }

                                 

                                 

                                 if(!empty($product_seo_detail)){}

                                 

                                  ?>

                              <div class="panel panel-default">

                                 <div class="panel-heading">

                                    <h4 class="panel-title">

                                       <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#seo_setting_<? echo $ss_count; ?>">

                                       <? echo $pcd['product_display_name']; ?>  - <? echo $show; ?>

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
											  //echo "<pre>";print_r($product_seo_detail);echo "</pre>";

                                            foreach($product_seo_detail as $psd)

                                          {
											  $psd = (array)$psd;

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

                                          <input type="hidden" name="product_id"  id="product_id_<? echo $ss_count ?>" value="<?php echo $product_id; ?>" />

                                          <input type="hidden" name="product_combination_id"  id="product_combination_id_<? echo $ss_count ?>" value="<?php echo $pcd['product_combination_id']; ?>" />

                                          <input type="hidden" name="product_seo_id"  id="product_seo_id_<? echo $ss_count ?>" value="<? echo $product_seo_id ?>" />

                                          <div class="form-group form-horizontal">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Slug URL</label>

                                                   <div data-title="Slug URL." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <? echo $slug_url ?>

                                                   <div class="input-group-btn">

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

                                                   <? echo $meta_title ?>

                                                   <div class="input-group-btn">

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

                                                   <? echo $meta_description ?>

                                                   <div class="input-group-btn">

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

                                                   <? echo $meta_keywords ?>

                                                   <div class="input-group-btn">

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                          <div class="form-group"  style="display:none">

                                             <div class="col-md-3">

                                                <div class="label-wrapper">

                                                   <label class="control-label" for="Name">Others Tags </label>

                                                   <div data-title="Others Tags." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div>

                                                </div>

                                             </div>

                                             <div class="col-md-9">

                                                <div class="input-group input-group-required">

                                                   <? echo $others ?>

                                                   <div class="input-group-btn"><span class="required"></span>

                                                   </div>

                                                </div>

                                                <span class="field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>

                                             </div>

                                          </div>

                                       </form>

                                    </div>

                                 </div>

                              </div>

                              <? } ?>

                           </div>

                        </div>

                        <? }else{ ?>                                         

                        <span style="color:#FF0000; font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You must save any combination this product before adding SEO Settings.</span> 

                        <? } ?>

                        <? } ?>       

                     </div>

                  </div>

               </div>

            </div>

            <!-- general form elements -->

            <!-- /.box -->

         </div>

         <!--/.col (left) -->

      </div>

   </section>

   <!-- /.content -->

</div>

<!-- /.content-wrapper -->

<script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script src="<?=_admin_files_?>js/jquery.easytree.js"></script>

<?php /*?><script src="<? echo MAINSITE?>dist/js/lightbox-plus-jquery.min.js"></script><?php */?>

<script>

   window.addEventListener('load' , function(){

       $('#demo1_menu').easytree();

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