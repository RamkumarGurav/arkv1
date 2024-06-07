<html>
<head>
<style>.
form {
    display: block;
    margin-top: 0em;
}
.card-primary.card-outline {
    border-top: 3px solid #007bff;
}
.card-body {
    padding: 0 0.25rem !important;
}
button, input {
    overflow: visible;
}
button, input, optgroup, select, textarea {
    margin: 0;
    font-family: 'lato', sans-serif;
    font-size: inherit;
    line-height: inherit;
}
.table:not(.table-dark) {
    color: inherit;
}
.table-bordered {
    border: 1px solid #dee2e6;
}
.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    background-color: transparent;
}
table {
    border-collapse: collapse;
}
tbody {
    display: table-row-group;
    vertical-align: middle;
    border-color: inherit;
}
.myviewtable td {
    padding: 8px 10px;
    font-size: 14px;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
.table td, .table th {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.table td, .table th {
    font-size: 13px !important;
    padding: 0 0.75rem !important;
    font-size: 12px !important;
}
thead {
    display: table-header-group;
    vertical-align: middle;
    border-color: inherit;
}
.table-bordered thead td, .table-bordered thead th {
    border-bottom-width: 2px;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
.table td, .table th {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.table td, .table th {
    font-size: 13px !important;
    padding: 0 0.75rem !important;
    font-size: 12px !important;
}
th {
    text-align: inherit;
}
#footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 150px; background-color: lightblue; }
    #footer .page:after { content: counter(page, upper-roman); }
</style>
	</head>

<body>

<section class="content">
        <div class="row">
            <div class="col-12">
<center>
<?php
$path = base_url('assets/images/logo.png');// Modify this part (your_img.png
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); 
?>
	<img src="<?=$base64?>">
</center>
                <div class="card ">

                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <div class="float-right">
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body card-primary card-outline">
                    	
                        
                        
                        <?php echo form_open(MAINSITE_Admin."$user_access->class_name/#", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="task" id="task" value="">
                                                        <div class="divTable" style="display:none;"></div>
                            
                            <table id="" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr align="center"><td colspan="6" align="center"><strong>Enquiry</strong></td></tr>
                                    <tr>
                                        <th width="4%">#</th>
                                        <th width="%">Enquiry Date</th>
                                        <th width="%">Name</th>
                                        <th width="%">Email</th>
                                        <th width="%">Contact No</th>
                                        <th width="%">Subject</th>
                                        <th width="%">Description</th>
                                        <th width="%">Added On</th>
                                        <th width="%">Updated On</th>
                                        <th width="%">Updated By</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <? 
								if(!empty($enquiry_data)){ ?>
                                <tbody>
									<? 
									$offset_val = (int)$this->uri->segment(5);
										
									$count=$offset_val;
										
										foreach($enquiry_data as $urm) { 
											$count++;
											?>
                                    <tr>
                                        <td><?=$count?>.</td>
										<td><?=date("d-m-Y" , strtotime($urm->added_on))?></td>                                        
                                        <td><?=$urm->name?></td>
                                        <td><?=$urm->email?></td>
                                        <td><?=$urm->contactno?></td>
                                        <td><?=$urm->subject?></td>
                                        <td><?=$urm->description?></td>
                                        <td><?=date("d-m-Y" , strtotime($urm->added_on))?></td>
                                        <td><?=date("d-m-Y" , strtotime($urm->updated_on))?></td>
                                        <td><?=$urm->updated_by_name?></td>
                                        <td width="6%"><? if($row->status==1){ ?> Active <?}else{ ?>Block <? }?>	</td>
                                    </tr>
                                    <? } ?>
                                </tbody>
                                <? } ?>
                                
						</table>
						<?php echo form_close() ?>
                        
                       
                            
                            
                            
                                        <!-- /.card-body -->
                </div>
            </div>
        </div>
        </div>


    </section>
    <div id="footer">
    <p class="page">Page </p>
  </div>
  
</body>
</html>