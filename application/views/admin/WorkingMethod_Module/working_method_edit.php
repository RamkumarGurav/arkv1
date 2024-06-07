<?php
$page_module_name = "working_method";
?>
<?
$working_method_link='';
$link = $working_method_image = '';
$content='';
$working_method_name=$working_method_video = "";
$working_method_id=0;
$status=1;
$record_action = "Add New Record";
if(!empty($working_method_data))
{
	$record_action = "Update";
	$working_method_id = $working_method_data->working_method_id;
	$link = $working_method_data->working_method_link;
	$working_method_image = $working_method_data->working_method_image;
	$status = $working_method_data->status;

	$content = $working_method_data->content;
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
                    <h1 class="m-0 text-dark"><?=$page_module_name?> </small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin."wam"?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name?>"><?=$user_access->module_name?> List</a></li>
						<? if(!empty($working_method_data)){ ?>
						<li class="breadcrumb-item"><a href="<?=MAINSITE_Admin.$user_access->class_name."/role_manager_view/".$working_method_id?>">View</a></li>
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
                        <h3 class="card-title"><?=$working_method_name?> <small><?=$record_action?></small></h3>
                    </div>
                    <!-- /.card-header -->
                    <?php
						if($user_access->view_module==1 || true)	{
					?>
					<? echo $this->session->flashdata('alert_message'); ?>
                    <div class="card-body">
                        <form action="<?php echo MAINSITE_Admin."$user_access->class_name/userworking_methodDoEdit";?>"
                            name="ptype_list_form" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
							<input type="hidden" name="working_method_id" id="working_method_id" value="<?=$working_method_id?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="" />

                            	<div class="row">
								<div class="col-sm-10 row">
									<label for="inputEmail3" class="col-sm-3 label_content text-right mt-2">Working Method Image </label>
									<div class="col-sm-9">
									<input type="file" class="form-control form-control-sm" required id="working_method_image" name="working_method_image"  placeholder="working_method">
									<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span>
                                    <?
                                    	if(!empty($working_method_image)){
											?>
                                            <img src= "<?= MAINSITE.'assets/uploads/working_method/'.$working_method_image?>"/>
                                            <?
											}
									?>
									</div>
								</div>
								</div>
                                <br>
                            	<div class="row">
								<div class="col-sm-10 row">
									<label for="inputEmail3" class="col-sm-3 label_content text-right mt-2">Working Method Link </label>
									<div class="col-sm-9">
									<input type="text" class="form-control form-control-sm" required id="working_method_link" name="working_method_link" value="<?=$link?>" placeholder="working_method_link">
									<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span>
									</div>
								</div>
								</div>
                                <br>




                                <br>
								<div class="row">
								<div class="col-sm-10 row">
									<label for="inputEmail3" class="col-sm-3 label_content text-right mt-2">working_method Content</label>
									<div class="col-sm-9">
                                        <textarea name="content" id="content" required class="  form-control-sm summernote"  ><?=$content?></textarea>
									<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span>
									</div>
								</div>
								</div>
								<div class="row">
								<div class="col-sm-6 row">
									<label for="radioSuccess1" class="col-sm-4 text-right label_content mt-2">Status</label>
									<div class="col-sm-6">
									<div class="form-check" style="margin-top:12px">
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
									<button type="submit" name="save" onclick="return redirect_type_func('')" value="1" class="btn btn-info">Save</button>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="submit" name="save-add-new" onclick="return redirect_type_func('save-add-new')" value="1" class="btn btn-default ">Save And Add New</button>
									</center>
								</div>
								<!-- /.card-footer -->

                        </form>
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
window.addEventListener('load' , function(){
	$('.custom-file-input').on('change', function () {
		let fileName = Array.from(this.files).map(x => x.name).join(', ')
		$(this).siblings('.custom-file-label').addClass("selected").html(fileName);
	});

	})
</script>
