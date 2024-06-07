<?php



$page_module_name = "Product Inventory";

$product_image_name='';

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

							

							<!-- /.col -->

							<div class="col-md-3">

								<div class="form-group">

									<label>Customer</label>

									

									</select>

									

								</div>

							</div>



							<div class="col-md-3">

								<div class="form-group">

									<label>Enquiry Mode</label>

									

									</select>

									

								</div>

							</div>

                            

                            <div class="col-md-3">

								<div class="form-group">

									<label>Status</label>

									<select name="record_status" id="record_status" class="form-control" style="width: 100%;">

										<option value='' >Active / Block</option>

										<option value='1' <? if($record_status==1){echo 'selected';} ?>>Active</option>

										<option value='zero' <? if($record_status=='zero'){echo 'selected';} ?>>Block</option>

									</select>

									

								</>

							</div>

							<!-- /.col -->

							<div class="col-md-6">

								

							</div>

						</div>

                        

                        	<div class="col-md-3">

								<div class="form-group">

									<label>Employee</label>

									

									</select>

									

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



                                <div class="panel-footer">

                                        <center>

                                            <button type="submit" class="btn btn-info" id="search_report_btn" name="search_report_btn" value="1">Search</button>

                                            &nbsp;&nbsp;<button type="reset" class="btn btn-default">Reset</button>

                                        </center>

                                </div>

                                </div>

                                 <?php echo form_close() ?>

                      </div>

                    </div>

                  </div>

                  

                </div>

              

                <div class="card">



                    <div class="card-header">

                        <h3 class="card-title"><span style="color:#FF0000;">Total Records: <?php echo $row_count; ?></span></h3>

                        <div class="float-right">

                            <?php 

									if($user_access->add_module==1)	{

								?>

								<a href="<?=MAINSITE_Admin.$user_access->class_name?>/edit"> 

                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add

                                New</button></a>

                            <? } ?>

                            <?php 

							if($user_access->update_module==1)	{

							?>

                            <button type="button" class="btn btn-success btn-sm" onclick="validateRecordsActivate()"><i

                                    class="fas fa-check"></i> Publish</button>

                            <button type="button" class="btn btn-dark btn-sm" onclick="validateRecordsBlock()"><i

                                    class="fas fa-ban"></i> Unpublish</button>

							<? } ?>

							<?php 

							if($user_access->export_data==1)	{

							?>

                            <button type="button" class="btn btn-success btn-sm export_excel" ><i

                                    class="fas fa-file-excel"></i> Export</button>

                            <? } ?>

							<?php 

							if($user_access->export_data==1 )	{

							?>

                            <button type="button" class="btn btn-success btn-sm export_pdf" ><i

                                    class="fas fa-file-pdf" style='color:red'></i> Print</button>

                            <? } ?>

                        </div>

                    </div>

                    <!-- /.card-header -->

                    <?php 

						if($user_access->view_module==1)	{

					?>

                    <div class="card-body">

                        

                            <?php echo form_open(MAINSITE_Admin."$user_access->class_name/doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>

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

                                        <th>Product Name</th>

                                        <th>Category</th>

                                        <th>Quantity</th>

                                        <th>Combination</th>

                                        <th>Image</th>

                                        <th>Status</th>

                                        <th>Added On</th>

                                    </tr>

                                </thead>

                                <? if(!empty($product_data)){ ?>

                                <tbody>

									<? 

									$offset_val = (int)$this->uri->segment(5);

										

									$count=$offset_val;

										

										foreach($product_data as $urm) { 

											$count++;

											//if($urm->super_category_id == '') { $urm->super_category_id == '0';}

											?>

                                    <tr>

                                        <td><?=$count?>.</td>

                                        <?php if($user_access->update_module==1)	{ ?>

                                        <td><input type="checkbox" name="sel_recds[]"

                                                id="sel_recds<?php echo $count; ?>"

                                                value="<?php echo $urm->product_id; ?>" /></td>

                                        <? } ?>

										<td><a href="<?=MAINSITE_Admin."catalog/Product-Module/view/".$urm->product_id?>"><?=$urm->product_display_name?></a></td>

                                        <td>
                                        <? if(!empty($urm->combi)){ ?>
										<?
										$category_name = explode("~;" , $urm->combi);
										if(count($category_name)>1)
										{
											echo "<ol>";
											foreach($category_name as $cn)
											{
												echo "<li>$cn</li>";
											}
											echo "</ol>";
										}
										else
										{
											echo $category_name[0];
										}
										
										?>
                                        
                                        <? }else{echo "-";} ?>
                                        </td>

                                        

                                        <td><?=$urm->quantity?></td>

                                       <td><a class='btn btn-default' data-toggle="modal" data-target="#myModal" onclick='productMoniter(<?=$urm->product_id?> , <?=$urm->product_combination_id?>)'
 style='padding:1px 5px;'><i class='fa fa-pencil'></i>Change Stock</a></td>

                                        

                                        <td><a class="btn btn-default" href="<?=_uploaded_files_.'product/large/'?><?=$urm->product_image_name?>" target="_blank"><img src="<?=_uploaded_files_.'product/small/'?><?=$urm->product_image_name?>" width="75" /></a></td>

                                        <?php if($urm->status != '0') { ?>

                                        <td class='nodrag' align='center'><i class='fa fa-check true-icon'></i><span style='display:none'>Publish</span></td>

                                        <?php } else {  ?>

                                   		<td class='nodrag'  align='center'><i class="fa fa-cross" style="font-size:48px;color:red"></i><span style='display:none'>Un Publish</span></td>     

                                        <?php } ?>

                                        <td><?=date("d-m-Y" , strtotime($urm->added_on))?></td>

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

	

	

	$(".export_pdf").bind("click" , function(){

			

		$('#search_report_form').attr('action', '<? echo MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name."-pdf"; ?>');

		$('#search_report_form').attr('target', '_blank');

		$('#search_report_btn').click();

		

		$('#search_report_form').attr('action', '<? echo MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name; ?>');

		$('#search_report_form').attr('target', '');

	})

	

})


</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product Quantity</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="editProduct" style="padding:30px !important">
        <p>Some text in the Modal Body</p>
      <p>Some other text...</p>
      </div>
      <div class="modal-footer">
       <h3 style="display:none">Modal Footer</h3>
      <h3 id="prodError"></h3>
      <div class="pull-right" id="DisplayLoading"></div>
      </div>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Edit Product Quantity </h2>
    </div>
    <div class="modal-body" id="editProduct">
      <p>Some text in the Modal Body</p>
      <p>Some other text...</p>
    </div>
    <div class="modal-footer">
      <h3 style="display:none">Modal Footer</h3>
      <h3 id="prodError"></h3>
      <div class="pull-right" id="DisplayLoading"></div>
      
    </div>
    
  </div>

</div> -->
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
//var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
//btn.onclick = function() {
//    modal.style.display = "block";
//}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}


function productMoniter(product_id, combi_id)
{
	document.getElementById("DisplayLoading").innerHTML = '<img src="<? echo MAINSITE."images/loading-dots.gif" ?>" />';
	modal.style.display = "block";
	//popUp("Fetching The Product List <i></i>" , 10000000);
	$.ajax({
   type: "POST",
	url:'<?=MAINSITE_Admin."catalog/Stock-Module/"?>GetCompleteProductsListInStoreMonitoringEditQtyPrice',
   //dataType : "json",
   data : {'product_id' : product_id , 'combi_id' : combi_id},
   success : function(result){
	   // alert(result);
		$('#editProduct').html(result);
		document.getElementById("DisplayLoading").innerHTML = '';
	//	document.getElementById("DisplayButton").innerHTML = '<img src="<? echo MAINSITE."images/loading-dots.gif" ?>" />';
		//ArrangeTable();
		//	popUp("Product List Fetched <i></i>" , 4000);
	   }
   });
}
</script>