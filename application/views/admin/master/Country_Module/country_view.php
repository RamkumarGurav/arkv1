<?php

$page_module_name = "Country";

?>
<?
$country_name="";
$country_id=0;
$status=1;
$record_action = "Add New Record";
if(!empty($country_data))
{
	// $record_action = "Update";
	// $country_id = $country_data->country_id;
	// $country_name = $country_data->country_name;
	// $status = $country_data->status;
	
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
                        <h3 class="card-title"><?=$country_data->country_name?></h3>
                        <div class="float-right">
                            <?php 
								if($user_access->add_module==1 && false)	{
								?>
								<a href="<?=MAINSITE_Admin.$user_access->class_name?>/country-edit"> 
                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                                New</button></a>
                            <? } ?>
                            <?php 
							if($user_access->update_module==1)	{
							?>
							<a href="<?=MAINSITE_Admin.$user_access->class_name?>/country-edit/<?=$country_data->country_id?>"> 
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
                    <div class="card-body">
                        
                         <?php echo form_open(MAINSITE_Admin."$user_access->class_name/userRole-doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>   
                            <input type="hidden" name="task" id="task" value="" />
                            <? echo $this->session->flashdata('alert_message'); ?>
                            <div class="divTable">
                            	<div class="TableRow">
                                	<div class="table_col">
                                        <label class="label_content_br">Data Base Id <span class="colen">:</span></label>
                                        <?=$country_data->country_id?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Country <span class="colen">:</span></label>
                                        <?=$country_data->country_name?>
                                    </div>
                                    <div class="table_col">
                                        <label class="label_content_br">Short Name <span class="colen">:</span></label>
                                        <?=$country_data->country_short_name?>
                                    </div>
                                    <div class="table_col" >
                                        <label class="label_content_br">Country Code <span class="colen">:</span></label>
                                        <?=$country_data->country_code?>
                                    </div>
                                	
                                    <div class="table_col">
                                    <label class="label_content_br">Added On <span class="colen">:</span></label>
                                    <?=date("d-m-Y h:i:s A" , strtotime($country_data->added_on))?>
                                    </div>
                                    
                                    
                                </div>
                                <div class="TableRow">
                                    <div class="table_col">
                                    <label class="label_content_br">Added By <span class="colen">:</span></label>
                                    <?=$country_data->added_by_name?>
                                    </div>
                                    <div class="table_col">
                                    <label class="label_content_br">Updated On <span class="colen">:</span></label>
                                    <? if(!empty($country_data->updated_on)){echo date("d-m-Y h:i:s A" , strtotime($country_data->updated_on));}else{echo "-";}?>
                                    </div>
                                    <div class="table_col">
                                    <label class="label_content_br">Updated By <span class="colen">:</span></label>
                                    <? if(!empty($country_data->updated_by_name)){echo $country_data->updated_by_name;}else{echo "-";}?>
                                    </div>
                                    <div class="table_col">
                                    <label class="label_content_br">Status <span class="colen">:</span></label>
                                   	<? if($country_data->status==1){ ?> Active <i class="fas fa-check btn-success btn-sm "></i>
                                    <?}else{ ?> Block <i class="fas fa-ban btn-danger btn-sm "></i> Block
                                    <? }?>
                                    </div>
                                    
                                </div>
                            </div>
                            <table id="" class="table table-bordered table-hover myviewtable" style="display:none;">
                                <tbody>
								<tr><td>
										<strong class="full">Data Base Id</strong>
										<?=$country_data->country_id?></td> <td>
										<strong class="full">Country</strong>
										<?=$country_data->country_name?></td> <td>
										<strong class="full">Short Name</strong>
										<?=$country_data->country_short_name?></td> 
									<?php /*?><tr>
										<td width="27%">Dial Code</td>
										<td width="3%">:</td>
										<td width="70%"><?=$country_data->dial_code?></td>
									</tr><?php */?> <td>
										<strong class="full">Country Code</strong>
										<?=$country_data->country_code?></td>
                                        <td>
										<strong class="full">Added On</strong>
										<?=date("d-m-Y h:i:s A" , strtotime($country_data->added_on))?></td>
                                         <td>
										<strong class="full">Added By</strong>
										<?=$country_data->added_by_name?></td> 
                                        <td>
										<strong class="full">Updated On</strong>
										<? if(!empty($country_data->updated_on)){echo date("d-m-Y h:i:s A" , strtotime($country_data->updated_on));}else{echo "-";}?></td> 
                                        <td>
										<strong class="full">Updated By</strong>
										<? if(!empty($country_data->updated_by_name)){echo $country_data->updated_by_name;}else{echo "-";}?></td>
                                        <td>
										<strong class="full">Status</strong>
										<? if($country_data->status==1){ ?> Active <i class="fas fa-check btn-success btn-sm "></i>
                                                <?}else{ ?> Block <i class="fas fa-ban btn-danger btn-sm "></i> Block
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
