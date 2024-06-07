<?php

$page_module_name = "Orders";

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
                    <h1 class="m-0 text-dark"><?=$page_module_name?> <small>List</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin."wam"?>">Home</a></li>
                        <li class="breadcrumb-item active"><?=$page_module_name?></li>
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
			    <div id="accordion">
                  <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                  <div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="" aria-expanded="false">
                          Search Panel
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" style="">
                      <div class="card-body">
					  
                      <?php echo form_open(MAINSITE_Admin."$user_access->class_name/$user_access->function_name", array('method' => 'post', 'id' => 'search_report_form' , "name"=>"search_report_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>

					  <div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								<label>Field</label>
								<select name="field_name" id="field_name" class="form-control" style="width: 100%;">
									<!-- <option value=''>Select Field</option> -->
									<option value='urm.order_number' <? if($field_name=='urm.order_number'){echo 'selected';} ?>>Order Number</option>
									<option value='urm.name' <? if($field_name=='urm.name'){echo 'selected';} ?>>Customer Name</option>
									<option value='urm.number' <? if($field_name=='urm.number'){echo 'selected';} ?>>Customer Number</option>
								</select>
								
								</div>
							</div>
							<!-- /.col -->
							<div class="col-md-6">
								<div class="form-group">
								<label>Field Value</label>
								<input type="text" name="field_value" id="field_value" placeholder="Field Value" style="width: 100%;" class="form-control" value="<?=$field_value?>"  >
								</div>
							</div>
						</div>
					
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								<label>Start Date</label>
								<div class="input-group date reservationdate" id="reservationdate" data-target-input="nearest">
									<input type="text" value="<?=$start_date?>" name="start_date" id="start_date" placeholder="Start Date" style="width: 100%;"  class="form-control datetimepicker-input" data-target="#reservationdate"/>
									<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
								
								</div>
							</div>
							<!-- /.col -->
							<div class="col-md-6">
								<div class="form-group">
								<label>End Date</label>
								<div class="input-group date reservationdate1" id="reservationdate1" data-target-input="nearest">
									<input type="text" value="<?=$end_date?>" name="end_date" id="end_date" placeholder="End Date" style="width: 100%;"  class="form-control datetimepicker-input" data-target="#reservationdate1"/>
									<div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
								
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								<label>Status</label>
								<?php /*?><select name="record_status" id="record_status" class="form-control" style="width: 100%;">
									<option value='' >Active / Block</option>
									<option value='1' <? if($record_status==1){echo 'selected';} ?>>Active</option>
									<option value='zero' <? if($record_status=='zero'){echo 'selected';} ?>>Block</option>
								</select><?php */?>
								
								</div>
							</div>
							<!-- /.col -->
							<div class="col-md-6">
								<!-- <div class="form-group">
								<label>Field Value</label>
								<input type="text" name="field_value" id="field_value" placeholder="Field Value" style="width: 100%;" class="form-control" value="<?=$field_value?>"  >
								</div> -->
							</div>
						</div>
						
						
					</div>
                                <div class="panel-footer">
                                        <center>
                                            <button type="submit" class="btn btn-info" id="search_report_btn" name="search_report_btn" value="1">Search</button>
                                            &nbsp;&nbsp;<button type="reset" class="btn btn-default">Reset</button>
                                        </center>
                                </div>
                                 <?php echo form_close() ?>
                      </div>
                    </div>
                  </div>
                  
                </div>
              
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title"><span style="color:#FF0000;">Total Records: <?php echo $row_count; ?></span></h3>
                        
                    </div>
                    <!-- /.card-header -->
                    <?php 
						if($user_access->view_module==1)	{
					?>
                    <div class="card-body">
                        
                            <?php echo form_open(MAINSITE_Admin."$user_access->class_name/userCountry-doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="task" id="task" value="" />
                            <? echo $this->session->flashdata('alert_message'); ?>
                            <table id="example1" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <?php if($user_access->update_module==1)	{ ?>
                                        <th width="4%"><input type="checkbox" name="main_check" id="main_check"
                                                onclick="check_uncheck_All_records()" value="" /></th>
                                        <? } ?>
                                        <th>Order Number</th>
                                        <th>Customer Name</th>
                                        <th>Contact Number</th>
                                        <th>Amount</th>
                                        <th>Items</th>
                                        <th>Ordered On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <? if(!empty($orders_list)){ ?>
                                <tbody>
									<? 
									$offset_val = (int)$this->uri->segment(5);
										
									$count=$offset_val;
										
										foreach($orders_list as $urm) { 
											$count++;
											?>
                                    <tr>
                                        <td><?=$count?>.</td>
                                        <?php if($user_access->update_module==1)	{ ?>
                                        <td><input type="checkbox" name="sel_recds[]"
                                                id="sel_recds<?php echo $count; ?>"
                                                value="<?php echo $urm->orders_id; ?>" /></td>
                                        <? } ?>
                                        <td><a href="<?=MAINSITE_Admin.$user_access->class_name."/details/".$urm->orders_id?>"><?=$urm->order_number	?></a></td>
                                        <td><?=$urm->name?></td>
										<td><?=$urm->number?></td>
                                        <td><?=$urm->symbol ?> <?=$urm->total?></td>
                                        <td><?=$urm->total_prod?></td>
										<td><?=date("d-m-Y" , strtotime($urm->added_on))?></td>
                                        <td><a class="btn btn-default" href="<? echo MAINSITE."secureRegions/orders/Orders-Module/details/".$urm->orders_id;?>"><i class="fa fa-pencil"></i>Edit</a></td>
                                    </tr>
                                    <? } ?>
                                </tbody>
                                <? } ?>
						</table>
						<?php echo form_close() ?>
						<center><div class="pagination_custum"><? echo $this->pagination->create_links(); ?></div></center>
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

window.addEventListener('load' , function(){

	$( ".paginationClass" ).click(function() {
		// console.log($(this).data('ci-pagination-page'));
		// console.log($(this));
		// console.log($(this).attr('href'));//alert();
		//alert(this.data('ci-pagination-page'));
		$('#search_report_form').attr('action', $(this).attr('href'));
		$('#search_report_form').submit();
		return false ;
	});
	$('#reservationdate').datetimepicker({
        format: 'DD-MM-YYYY'
	});
	$('#reservationdate1').datetimepicker({
        format: 'DD-MM-YYYY'
	});
	
	$(".export_excel").bind("click" , function(){
			
		$('#search_report_form').attr('action', '<? echo MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name."-export"; ?>');
		$('#search_report_form').attr('target', '_blank');
		$('#search_report_btn').click();
		
		$('#search_report_form').attr('action', '<? echo MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name; ?>');
		$('#search_report_form').attr('target', '');
	})
	
	
	
})

</script>
