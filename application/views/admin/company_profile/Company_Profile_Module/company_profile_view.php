<?php

$page_module_name = "Company Profile";

?>
<?
$name="";
$company_profile_id=0;
$status=1;
$record_action = "Add New Record";
if(!empty($company_profile_data))
{
	// $record_action = "Update";
	// $company_profile_id = $company_profile_data->company_profile_id;
	// $name = $company_profile_data->name;
	// $status = $company_profile_data->status;
	
}
?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?=$page_module_name?> <small>Details</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=MAINSITE_Admin."wam"?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name?>"><?=$user_access->module_name?> List</a></li>
                        <li class="breadcrumb-item active">Details</li>
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
                        <h3 class="card-title"><?=$company_profile_data->name?></h3>
                        <div class="float-right">
                            <?php 
								if($user_access->add_module==1 && false)	{
								?>
								<a href="<?=MAINSITE_Admin.$user_access->class_name?>/company-profile-edit"> 
                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                                New</button></a>
                            <? } ?>
                            <?php 
							if($user_access->update_module==1)	{
							?>
							<a href="<?=MAINSITE_Admin.$user_access->class_name?>/company-profile-edit/<?=$company_profile_data->company_profile_id?>"> 
                            <button type="button" class="btn btn-success btn-sm" ><i
                                    class="fas fa-edit"></i> Update</button>
                            </a>
                            <? } ?>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <?php 
						if($user_access->view_module==1)	{
					?>
                    <div class="card-body card-primary card-outline">
                        
                            <?php echo form_open(MAINSITE_Admin."$user_access->class_name/userRole-doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="task" id="task" value="" />
                            <? echo $this->session->flashdata('alert_message'); ?>
                            
                            <?php /*?><div class="divTable">
                            	<div class="TableRow">
                                	<div class="table_col">
                                        <label class="label_content_br">Data Base Id <span class="colen">:</span></label>
                                        <?=$company_profile_data->company_profile_id?>
                                    </div>                                     
                                	<div class="table_col">
                                        <label class="label_content_br">Company Unique Name <span class="colen">:</span></label>
                                        <?=$company_profile_data->company_unique_name?>
                                    </div>                                    
                                	<div class="table_col">
                                        <label class="label_content_br">Company Name<span class="colen">:</span></label>
                                        <?=$company_profile_data->company_name?>
                                    </div>                                     
                                	<div class="table_col">
                                        <label class="label_content_br">Company Website <span class="colen">:</span></label>
                                        <?=$company_profile_data->company_website?>
                                    </div>
                                	<div class="table_col">
                                        <label class="label_content_br">Company Email<span class="colen">:</span></label>
                                        <?=$company_profile_data->company_email?>
                                    </div> 
                                </div>
                            	<div class="TableRow">
                                	<div class="table_col">
                                        <label class="label_content_br">Name <span class="colen">:</span></label>
                                        <?=$company_profile_data->name?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Email Id <span class="colen">:</span></label>
                                        <?=$company_profile_data->email?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Mobile No <span class="colen">:</span></label>
                                        <?=$company_profile_data->mobile_no?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Alt Mobile No <span class="colen">:</span></label>
                                        <?=$company_profile_data->alt_mobile_no?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Fax No <span class="colen">:</span></label>
                                        <?=$company_profile_data->gst_no?>
                                    </div>       
                                </div>
                            	<div class="TableRow">
                                	<div class="table_col">
                                        <label class="label_content_br">Address <span class="colen">:</span></label>
                                        <? echo $company_profile_data->address1;
											if(!empty($company_profile_data->address1)){echo "<br>".$company_profile_data->address2;}
											if(!empty($company_profile_data->address3)){echo "<br>".$company_profile_data->address3;}
											echo "<br>".$company_profile_data->city_name." ($company_profile_data->pincode) ";
											echo "<br>".$company_profile_data->state_name;
											echo "<br>".$company_profile_data->country_name." ($company_profile_data->dial_code) ";
										?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Country <span class="colen">:</span></label>
                                        <?=$company_profile_data->country_name?>
                                    </div>
                                    <div class="table_col table_wrap">
                                        <label class="label_content_br">Logo <span class="colen">:</span></label>
                                        <? if(!empty($company_profile_data->logo)){ ?>
											<span class="pip">
											<a target="_blank" href="<?=MAINSITE.'assets/company_profile/logo/'.$company_profile_data->logo?>">
											<img class="imageThumb" src="<?=MAINSITE.'assets/company_profile/logo/'.$company_profile_data->logo?>" />
											</a>
											</span>
										<? }else{ ?>
											<span class="pip">
											<img class="imageThumb" src="<?=MAINSITE?>assets/images/no_image.jpg" />
											</span>
										<? } ?>
                                    </div>
                                    <div class="table_col table_wrap">
                                        <label class="label_content_br">Letterhead Header Image <span class="colen">:</span></label>
                                        <? if(!empty($company_profile_data->letterhead_header_image)){ ?>
											<span class="pip">
											<a target="_blank" href="<?=MAINSITE.'assets/company_profile/letterhead_header_image/'.$company_profile_data->letterhead_header_image?>">
											<img class="imageThumb" src="<?=MAINSITE.'assets/company_profile/letterhead_header_image/'.$company_profile_data->letterhead_header_image?>"  style="max-width:320px;"/>
											</a>
											</span>
										<? }else{ ?>
											<span class="pip">
											<img class="imageThumb" src="<?=MAINSITE?>assets/images/no_image.jpg" />
											</span>
										<? } ?>
                                    </div>
                                </div>
                            </div><?php */?>  
                              
                            <table id="" class="table table-bordered table-hover myviewtable responsiveTableNewDesign">                                
                                <tbody>                                    
									<tr>
										<td >
										<strong class="full">Data Base Id</strong>
										<?=$company_profile_data->company_profile_id?></td>
										<td >
										<strong class="full">Company Unique Name</strong>
										<?=$company_profile_data->company_unique_name?></td>
										<td >
										<strong class="full">Company Name</strong>
										<?=$company_profile_data->company_name?></td>
										<td >
										<strong class="full">Company Website</strong>
										<?=$company_profile_data->company_website?></td>
										<td >
										<strong class="full">Company Email</strong>
										<?=$company_profile_data->company_email?></td>
									</tr>
									<tr>
										<td >
										<strong class="full">Name</strong>
										<?=$company_profile_data->name?></td>
										<td >
										<strong class="full">Email Id</strong>
										<?=$company_profile_data->email?></td>
										<td >
                                        <strong class="full">Mobile No</strong>
                                         <?=$company_profile_data->mobile_no?></td>
										<td >
										<strong class="full">Alt Mobile No</strong>
										<?=$company_profile_data->alt_mobile_no?></td>
										<td >
										<strong class="full">GST No</strong>
										<?=$company_profile_data->gst_no?></td>
									</tr>									
									<tr>
										<td >
										<strong class="full">Address</strong>
										<? echo $company_profile_data->address1;
											if(!empty($company_profile_data->address1)){echo "<br>".$company_profile_data->address2;}
											if(!empty($company_profile_data->address3)){echo "<br>".$company_profile_data->address3;}
											echo "<br>".$company_profile_data->city_name." ($company_profile_data->pincode) ";
											echo "<br>".$company_profile_data->state_name;
											echo "<br>".$company_profile_data->country_name." ($company_profile_data->dial_code) ";
										?></td>
										<td >
										<strong class="full">Country</strong>
										<?=$company_profile_data->country_name?></td>
										<td >
										<strong class="full">Logo</strong>
										<? if(!empty($company_profile_data->logo)){ ?>
											<span class="pip">
											<a target="_blank" href="<?=_uploaded_files_.'company_profile/logo/'.$company_profile_data->logo?>">
											<img class="imageThumb" src="<?=_uploaded_files_.'company_profile/logo/'.$company_profile_data->logo?>" />
											</a>
											</span>
										<? }else{ ?>
											<span class="pip">
											<img class="imageThumb" src="<?=MAINSITE?>assets/images/no_image.jpg" />
											</span>
										<? } ?></td>
										<td colspan="2">
										<strong class="full">Letterhead Header Image</strong>
										<? if(!empty($company_profile_data->letterhead_header_image)){ ?>
											<span class="pip">
											<a target="_blank" href="<?=_uploaded_files_.'company_profile/letterhead_header_image/'.$company_profile_data->letterhead_header_image?>">
											<img class="imageThumb" src="<?=_uploaded_files_.'company_profile/letterhead_header_image/'.$company_profile_data->letterhead_header_image?>"  style="max-width:320px;"/>
											</a>
											</span>
										<? }else{ ?>
											<span class="pip">
											<img class="imageThumb" src="<?=MAINSITE?>assets/images/no_image.jpg" />
											</span>
										<? } ?></td>
									</tr>

									<tr>
										<td >
										<strong class="full">Added On</strong>
										<?=date("d-m-Y h:i:s A" , strtotime($company_profile_data->added_on))?></td>
										<td >
										<strong class="full">Added By</strong>
										<?=$company_profile_data->added_by_name?></td>
										<td >
										<strong class="full">Updated On</strong>
										<? if(!empty($company_profile_data->updated_on)){echo date("d-m-Y h:i:s A" , strtotime($company_profile_data->updated_on));}else{echo "-";}?></td>
										<td >
										<strong class="full">Updated By</strong>
										<? if(!empty($company_profile_data->updated_by_name)){echo $company_profile_data->updated_by_name;}else{echo "-";}?></td>
										<td >
										<strong class="full">Status</strong>
										<? if($company_profile_data->status==1){ ?> Active <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> Block <i class="fas fa-ban btn-danger btn-sm "></i>
                                                <? }?></td>
									</tr>
                                    
                                </tbody>
							</table>
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


    </section>
    <?  ?>
</div>

<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>

<script type="application/javascript">
function check_uncheck_All_records() // done
{
    var mainCheckBoxObj = document.getElementById("main_check");
    var checkBoxObj = document.getElementsByName("sel_recds[]");

    for (var i = 0; i < checkBoxObj.length; i++) {
        if (mainCheckBoxObj.checked)
            checkBoxObj[i].checked = true;
        else
            checkBoxObj[i].checked = false;
    }
}

function validateCheckedRecordsArray() // done
{
    var checkBoxObj = document.getElementsByName("sel_recds[]");
    var count = true;

    for (var i = 0; i < checkBoxObj.length; i++) {
        if (checkBoxObj[i].checked) {
            count = false;
            break;
        }
    }

    return count;
}

function validateRecordsActivate() // done
{
    if (validateCheckedRecordsArray()) {
        //alert("Please select any record to activate.");
        toastrDefaultErrorFunc("Please select any record to activate.");
        document.getElementById("sel_recds1").focus();
        return false;
    } else {
        document.ptype_list_form.task.value = 'active';
        document.ptype_list_form.submit();
    }
}

function validateRecordsBlock() // done
{
    if (validateCheckedRecordsArray()) {
        //alert("Please select any record to block.");
        toastrDefaultErrorFunc("Please select any record to block.");
        document.getElementById("sel_recds1").focus();
        return false;
    } else {
        document.ptype_list_form.task.value = 'block';
        document.ptype_list_form.submit();
    }
}
</script>
