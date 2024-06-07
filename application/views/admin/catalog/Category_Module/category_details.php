<?
$page_module_name = "Category";
$category_id=0;
$super_category_id=0;
$name="";
$super_category_name="";
$added_on="";
$added_by="";
$added_on="";
$updated_by="";
$is_outer_menu='';
$updated_on="";
$ai_name="";
$cover_image='';
$category_icon='';
$description="";
$short_description="";
$condition_per_product="";
$status=0;
$is_display_home_page=0;
/*echo "<pre>";
print_r($category_detail);
echo "</pre>";*/
if(!empty($category_detail))
{ 
		$row = (array)$category_detail;
		$category_id=$row['category_id']; //echo "dfdf".$db_enqid;
		$super_category_id=$row['super_category_id'];
		$name=$row['name'];
		$status=$row['status'];
		$added_on=$row['added_on'];
		$added_by=$row['added_by'];
		$updated_on=$row['updated_on'];
		$updated_by=$row['updated_by'];
		$updated_by_name=$row['updated_by_name'];
		$added_by_name=$row['added_by_name'];
		$super_category_name=$row['super_category_name'];
		$is_dropdown=$row['is_dropdown'];
		if(empty($super_category_name)){$super_category_name='Parent';}
		
		$is_outer_menu=$row['is_outer_menu'];
		$cover_image=$row['cover_image'];
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
		$meta_description=$row['meta_description'];
		$meta_title=$row['meta_title'];
		$meta_keyword=$row['meta_keyword'];
		$others=$row['others'];
		$ads_image=$row['ads_image'];
		$ads_image_sub_cat=$row['ads_image_sub_cat'];
		$ads_image_super_sub_cat=$row['ads_image_super_sub_cat'];
		$category_icon=$row['category_icon'];
		$description=$row['description'];
		$short_description=$row['short_description'];
		$is_display_home_page=$row['is_display_home_page'];
}
?>
<script>
<?php  if($user_access->view_module==1)	{ ?>
$(document).ready(function() {
	$.ajax({
   type: "POST",

	url:'<? echo MAINSITE_Admin ?>catalog/Category-Module/GetCompleteCategoryList',
   //dataType : "json", 
   data : {"super_category_id" : '<? echo $category_id; ?>' , "withPosition" : 1  , 'sortByPosition':1 , "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},
   success : function(result){
	 //   alert(result);
		$('#stateList').html(result);
		//ArrangeTable();
		dragEvent();
	   }
   });
});
<? } ?>
</script>    
<style>
    body{
        overflow-x: hidden;
    }
</style>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper ">
            <!-- Content Header (Page header) -->
            
            <div class="content-header">
        <div class="container-fluid ">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-2 text-dark"><?=$page_module_name?> <small>Details</small></h1>
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

                
            
                <!-- Main content -->
                <div class="row card">
                        <div class="col-md-12 card-body ">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                	<h3 class="box-title">Category Details <? if($category_id!='parents'){ ?>
									<?php  if($user_access->update_module==1)	{ ?>
									<a href="<?=MAINSITE_Admin.$user_access->class_name?>/edit/<?=$category_id?>" class="btn btn-primary" style="float :right;margin-top: -5px">Update Category Details
									</a>
									<? } ?>
									<? } ?></h3>
                                </div>
                                <div class="box-body">
								<?php  if($user_access->view_module==1)	{ ?>
                                     <table id="" class="table  table-hover myviewtable responsiveTableNewDesign">  
                                         <tbody>  
                                    	<tr>
                                        	<td width="50%" valign="top">
                                    			<table id="example2" class="table table-bordered table-hover">
                                                    <tbody>
                                                        <tr>
                                                           <td> <strong class="full">Category Name</strong>
                                        <?php   echo $name; ?></td>
                                                            <td colspan="2" >
                                        <strong class="full">Is Outside Menu Required</strong>
                                        <?php if($is_outer_menu==1) { echo "Yes"; } else { echo "No"; } ?></td>
                                        <td colspan="3">
                                        <strong class="full">Is Dropdown</strong>
                                        <?php if($is_dropdown=="0") { echo "No"; } else if ($is_dropdown=="1") { echo "Yes"; } ?></td>
                                        <td >
                                        <strong class="full">Display on Homepage</strong>
                                        <?php if($is_display_home_page=="0") { echo "No"; } else if ($is_display_home_page=="1") { echo "Yes"; } ?></td>
                                        
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td colspan="1">
                                        <strong class="full">Long Description</strong>
                                        <?php   echo $description; ?></td>
                                        <td colspan="3">
                                        <strong class="full">Slug Url</strong>
                                        <?php   echo $slug_url; ?></td>
                                        <td colspan="2">
                                        <strong class="full">Meta Title</strong>
                                        <?php   echo $meta_title; ?></td>
                                        <td >
                                        <strong class="full">Meta Description </strong>
                                        <?php   echo $meta_description; ?></td>
                                        
                                                        </tr>
                                                        
                                                       <tr>
                                                            <td colspan="1">
                                        <strong class="full">Meta Keyword</strong>
                                        <?php   echo $meta_keyword; ?></td>
                                        <td colspan="3">
                                        <strong class="full">Others Meta tags</strong>
                                        <?php   echo nl2br($others); ?></td>
                                        <td colspan="2">
                                        <strong class="full">Icon Image</strong>
                                        <? if(!empty($category_icon)){ ?><a href="<?php echo _uploaded_files_.'category/'.$category_icon; ?>" target="_blank"><img width="150" src="<?php echo _uploaded_files_.'category/'.$category_icon; ?>" /></a><? } ?></td>
                                        <td >
                                        <strong class="full">Cover Image</strong>
                                        <? if(!empty($cover_image)){ ?><a href="<?php echo _uploaded_files_.'category/'.$cover_image; ?>" target="_blank"><img width="150" src="<?php echo _uploaded_files_.'category/'.$cover_image; ?>" /></a><? } ?></td>
                                        
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1">
                                        <strong class="full">Header 1 Image</strong>
                                        <? if(!empty($cover_image)){ ?><a href="<?php echo _uploaded_files_.'category/'.$header_1_img; ?>" target="_blank"><img width="150" src="<?php echo _uploaded_files_.'category/'.$header_1_img; ?>"" /></a><? } ?></td>
                                        <td colspan="3">
                                        <strong class="full">Header1  Url</strong>
                                        <? if(!empty($cover_image)){ ?><a href="<?php echo _uploaded_files_.'category/'.$header_1_img; ?>" target="_blank"><img width="150" src="<?php echo _uploaded_files_.'category/'.$header_1_img; ?>"" /></a><? } ?></td>
                                        <td colspan="2">
                                        <strong class="full">Status</strong>
                                        <?php if($status=="0") { echo "Blocked"; } else if ($status=="1") { echo "Active"; } ?></td>
                                        <td >
                                        <strong class="full">Added On</strong>
                                        <?php   echo date('d-M-Y h:i:s A' , strtotime($added_on)); ?></td>
                                        
                                                        </tr>
                                                       <tr>
                                                            <td colspan="1">
                                        <strong class="full">Added By</strong>
                                        <?php if(!empty($added_by_name)){   echo $added_by_name;}else echo "N/A"; ?></td>
                                        <td colspan="3">
                                        <strong class="full">Updated On</strong>
                                        <?php if($updated_on!='0000-00-00 00:00:00'){   echo date('d-M-Y h:i:s A' , strtotime($updated_on));}else echo "N/A"; ?></td>
                                        <td colspan="2">
                                        <strong class="full">Updated By</strong>
                                        <?php if(!empty($updated_by_name)){ echo $updated_by_name;}else echo "N/A"; ?></td>
                                        
                                                        </tr> 
                                                        
                                                         
                                                    </tbody>
                                    			</table>
                                            </td>
                                        	
                                        </tr>
                                    </table>
<link rel="stylesheet" href="<? echo MAINSITE ?>assets/administrator/css/tablednd.css" type="text/css"/>
<div class="tableDemo">
                                	<table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                        <th>Slno.</th>
                                            <th><input type="checkbox" name="main_check" id="main_check" onclick="check_uncheck_All_records()" value="Checkbox" /><span style="display:none">Checkbox</span></th>
                                           <th>Category Name</th>
                                            <th>Super Category Name</th>
                                            <th>Position</th>
                                            <th>Published</th>
                                            <th>Added On</th>                                            
                                            <th>Updated On</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="stateList">
                                    

                                    <tr>
                                    <td colspan="10"> <div class="clearfix text-center" >
                                <img  src="<? echo _uploaded_files_."load.gif"; ?>" />
                                </div></td>
                                    </tr>
                                   
                                   
                                    </tbody>
                                 
                                </table>
 <div class="result"></div>
                                        </div>

<? }else{ 
						//$this->data['no_access_flash_message']="You Dont Have Access To View ".$page_module_name;
						$this->load->view('admin/template/access_denied' , $this->data); 
					} ?>

<script src="<? echo MAINSITE ?>assets/administrator/js/jquery.tablednd.js" type="text/javascript"></script>

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
			
				$('#stateList').html('<tr><td colspan="10"> <div class="clearfix text-center" ><img  src="<? echo _uploaded_files_."load.gif"; ?>" /></div></td></tr>');
				$.ajax({
			   type: "POST",
			   url: '<?=MAINSITE_Admin.'catalog/Category-Module/GetCompleteCategoryListNewPos'?>',
			   //dataType : "json", 
			   data : {"super_category_id" : '<? echo $category_id; ?>' , 'podId':podId , "<?=$csrf['name']?>":"<?=$csrf['hash']?>"},
			   success : function(result){
				  // alert(result);
					$('#stateList').html(result);
					$(table).parent().find('.result').text("Order Changed Successfully");
					dragEvent();
					}
			   });
				
			},
		onDragStart: function(table, row) {
			$(table).parent().find('.result').text("Started dragging row id "+row.id);
			
		},

	});
		  
   }
   
   
</script>   
                                </div>
                            </div>
                        </div>
                    </div>
            <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        
