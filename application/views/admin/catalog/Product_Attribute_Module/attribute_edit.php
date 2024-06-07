<?php
$page_module_name = "Product Attribute";
?>
<?
$name=$color_name="";
$condition_per_product=$list_page=$details_page="";
$product_attribute_value_id=$product_attribute_id=$position=0;
$status = 1;
$record_action = "Add New Record";
//echo "<pre>";
//print_r($product_attribute_value_data); //exit;
if(!empty($product_attribute_value_data))
{
	//$product_attribute_value_data as $product_attribute_value_data;
	$record_action = "Update";
	$product_attribute_value_id = $product_attribute_value_data->product_attribute_value_id;
	$product_attribute_id = $product_attribute_value_data->product_attribute_id;
	echo "1product_attribute_id : $product_attribute_id </br>";
	$name = $product_attribute_value_data->name;
	$color_name = $product_attribute_value_data->color_name;
	$position = $product_attribute_value_data->position;
	$status = $product_attribute_value_data->status;
}
?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<style >
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
                    <h1 class="m-0 text-dark"><?=$page_module_name?> </small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin."wam"?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name?>"><?=$user_access->module_name?> List</a></li>
						<? if(!empty($product_attribute_value_data)){ ?>
						<li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/attribute-view/".$product_attribute_value_id?>">View</a></li>
						<? } ?>
						<li class="breadcrumb-item"><?=$record_action?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <?  ?>
    <section class="content">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title"><?=$name?> <small><?=$record_action?></small></h3>
                    </div>
                    <!-- /.card-header -->
                    <?php 
						if($user_access->view_module==1 || true)	{
					?>
					<? echo $this->session->flashdata('alert_message'); ?>
                    <div class="card-body">

                            <?php echo form_open(MAINSITE_Admin."$user_access->class_name/doAtrributeEdit", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
							<input type="hidden" name="product_attribute_value_id" id="product_attribute_value_id" value="<?=$product_attribute_value_id?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="1" />
							
                            	<div class="row">
								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Attribute Name <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-10">
									<select name="product_attribute_id" id="product_attribute_id"  class="form-control" required autofocus >
                                                <option value="">Select Attribute Name</option>
                                                <? 
												
												//print_r($attributes_input_list);
												
												foreach($product_attribute_list as $col){ ?>
                                                <option value="<?=$col->product_attribute_id; ?>" <? if($product_attribute_id== $col->product_attribute_id){echo "selected";} ?>><?=$col->name; ?></option>
                                                <? } ?>
                                                </select>
									
									</div>
								</div>
								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Attribute Value <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-10">
									<input type="text" class="form-control form-control-sm" required id="name" name="name" value="<?=$name?>" placeholder="Attributes Value">
									
									</div>
								</div>
								 <div class="col-md-3">
                                        <div class="col-md-12">
                                        <label class="control-label" for="Name">Published <div data-title="Determines whether this state is published (visible for creation of registration/shipping/billing addresses)." class="ico-help icon_title_box"><i class="fa fa-question-circle"></i></div> <span class="required">*</span></label>
                                            <div class="demo-radio-button">
                                                <input type="radio" class="radio-col-green" name="status" id="status1" value="1" <?php if($status) echo ' checked'; ?> required />
                                                <label for="status1">Active &nbsp; &nbsp; </label>
                                <input type="radio" class="radio-col-red" name="status" id="status2" value="0" <?php if(!$status) echo ' checked'; ?> /> 
                                <label for="status2">Block</label>
                                            </div>
                                        </div>
                                    </div>
							</div>
								<div class="row">
								
                                
                               
								</div>
								<br>
								<!-- /.card-body -->
								<div class="card-footer">
									<center>
									<button type="submit" name="save" onclick="return redirect_type_func('')" value="1" class="btn btn-info">Save</button>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="submit" name="save-add-new" onclick="return redirect_type_func('save-add-new')" value="1" class="btn btn-default ">Save And Add New</button>
									</center>
								</div>
								<!-- /.card-footer -->
						
                        <?php echo form_close() ?>
                        </table>
                    </div>
                    <? }else{ 
											$this->data['no_access_flash_message']="You Dont Have Access To View ".$page_module_name;
											$this->load->view('admin/template/access_denied' , $this->data); 
										} ?>
                    <!-- /.card-body -->
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
	function redirect_type_func(data)
	{
		document.getElementById("redirect_type").value = data;
		return true;
	}
</script>

