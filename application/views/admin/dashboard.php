
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard v2</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

		<!-- Main content -->
      <section class="content">
          <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
            <? if($is_module_id_25==1){ ?>
              <div class="col-12 col-md-12">  
                <div class="card">
                      <div class="card-header border-transparent">
                        <h3 class="card-title">Upcoming Followup For Quotation</h3>
        
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table m-0">
                            <thead>
                            <tr>
                              <th>Quotation Number</th>
                              <th>Comany Name</th>
                              <th>Status</th>
                              <th>Follow Up On</th>
                              <th>View</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? if(!empty($upcoming_follow_up_data)){ ?>
                            <? foreach($upcoming_follow_up_data as $ufud){ ?>
                            <tr>
                              <td><a href="<?=MAINSITE_Admin."Quotation-Module/quotation-view/".$ufud->quotation_id?>" target="_blank"><?=$ufud->quotation_number?></a></td>
                              <td><?=$ufud->customer_name?></td>
                              <td><?=$ufud->status_display?></td>
                              <td><?=date('d-m-Y h:i:s A' , strtotime($ufud->next_followup))?></td>
                              <td>
                                <button type="button" class="btn btn-info btn-sm" title="View" onclick="view_quotation_followup_pop('<?=MAINSITE_Admin."Quotation-Module/view-quotation-followup-pop"?>' , <?=$ufud->quotation_id?> , <?=$ufud->reff_quotation_id?>)"><i class="fas fa-eye"></i> </button>
                              </td>
                            </tr>
                            <? } ?>
                            <? }else{ ?>
                            <tr>
                              <td colspan="5">No Record to display...</td>
                             </tr>
                            <? } ?>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.table-responsive -->
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer clearfix">
                       <?php /*?><a target="_blank" href="<?=MAINSITE_Admin.$is_module_id_25_data->class_name.'/quotation-edit'?>" class="btn btn-sm btn-info float-left">Add New</a><?php */?>
              <?
			  $a_link = $is_module_id_25_data->class_name.'/'.$is_module_id_25_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="btn btn-sm btn-secondary float-right">View All </a>
                      </div>
                      <!-- /.card-footer -->
                    </div>
              </div>
            <? } ?>
            </div>
          </div>
      </section>
      <section class="content">
      <div class="row">
	      <div class="col-md-8">
          <? if($is_module_id_21==1){ ?>
          <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Quotation Enquiry(RFQ)</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                        <th>RFQ Number</th>
                        <th>Customer</th>
                        <th>Inquiry Date</th>
                        <th>Closing Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                     <? if(!empty($quotation_enquiry_data)){ ?>
                    
                        <? 
                            foreach($quotation_enquiry_data as $urm) { 
                                ?>
                        <tr>
                            <td><a href="<?=MAINSITE_Admin.$is_module_id_21_data->class_name."/quotation-enquiry-view/".$urm->quotation_enquiry_id?>"><?=$urm->quotation_enquiry_number ?></a></td>
                            <td><?=$urm->customer_unique_name?></td>
                            <td><?php /*?><i class="fas fa-check"></i> <?php */?><?=date("d-m-Y" , strtotime($urm->inquiry_date))?></td>
                            <td><?php /*?><i class="fas fa-times"></i> <?php */?><?=date("d-m-Y h:i A" , strtotime($urm->inquiry_closing_date))?></td>
                            <td><?=$urm->status_display?></td>
                        </tr>
                        <? } ?>
                    
                    <? }else{ ?>
                    
                    <? } ?>
                    <tbody>
                    
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a target="_blank" href="<?=MAINSITE_Admin.$is_module_id_21_data->class_name.'/quotation-enquiry-edit'?>" class="btn btn-sm btn-info float-left">Add New</a>
              <?
			  $a_link = $is_module_id_21_data->class_name.'/'.$is_module_id_21_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="btn btn-sm btn-secondary float-right">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          <? if($is_module_id_25==1){ ?>
          <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Quotation </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Quotation Number</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Added By</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                     <? if(!empty($quotation_data)){ ?>
                    
                        <? 
                            foreach($quotation_data as $urm) { 
                                ?>
                        <tr>
                            <td><a href="<?=MAINSITE_Admin.$is_module_id_25_data->class_name."/quotation-view/".$urm->quotation_id?>"><?=$urm->quotation_number ?></a></td>
                            <td><?=$urm->customer_unique_name?></td>
                            <td><i class="fas fa-credit-card"></i> <?=$urm->total?><br><i class="fas fa-sort-amount-up"></i> <?=$urm->total_qty?></td>
                            <td><?=$urm->added_by_name?></td>
                            <td><?=$urm->status_display?></td>
                        </tr>
                        <? } ?>
                    
                    <? }else{ ?>
                    
                    <? } ?>
                    <tbody>
                    
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <?php /*?><a target="_blank" href="<?=MAINSITE_Admin.$is_module_id_25_data->class_name.'/quotation-edit'?>" class="btn btn-sm btn-info float-left">Add New</a><?php */?>
              <?
			  $a_link = $is_module_id_25_data->class_name.'/'.$is_module_id_25_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="btn btn-sm btn-secondary float-right">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          <? if($is_module_id_26==1){ ?>
          <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Proforma Invoice </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                        <th>PI Number</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Added By</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                     <? if(!empty($proforma_invoice_data)){ ?>
                    
                        <? 
                            foreach($proforma_invoice_data as $urm) { 
                                ?>
                        <tr>
                            <td><a href="<?=MAINSITE_Admin.$is_module_id_26_data->class_name."/proforma-invoice-view/".$urm->proforma_invoice_id?>"><?=$urm->proforma_invoice_number ?></a></td>
                            <td><?=$urm->customer_unique_name?></td>
                            <td><i class="fas fa-credit-card"></i> <?=$urm->total?><br><i class="fas fa-sort-amount-up"></i> <?=$urm->total_qty?></td>
                            <td><?=$urm->added_by_name?></td>
                            <td><?=$urm->status_display?></td>
                        </tr>
                        <? } ?>
                    
                    <? }else{ ?>
                    
                    <? } ?>
                    <tbody>
                    
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <?php /*?><a target="_blank" href="<?=MAINSITE_Admin.$is_module_id_26_data->class_name.'/quotation-edit'?>" class="btn btn-sm btn-info float-left">Add New</a><?php */?>
              <?
			  $a_link = $is_module_id_26_data->class_name.'/'.$is_module_id_26_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="btn btn-sm btn-secondary float-right">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          <? if($is_module_id_27==1){ ?>
          <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Invoice </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Added By</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                     <? if(!empty($invoice_data)){ ?>
                    
                        <? 
                            foreach($invoice_data as $urm) { 
                                ?>
                        <tr>
                            <td><a href="<?=MAINSITE_Admin.$is_module_id_27_data->class_name."/invoice-view/".$urm->invoice_id?>"><?=$urm->invoice_number ?></a></td>
                            <td><?=$urm->customer_unique_name?></td>
                            <td><i class="fas fa-credit-card"></i> <?=$urm->total?><br><i class="fas fa-sort-amount-up"></i> <?=$urm->total_qty?></td>
                            <td><?=$urm->added_by_name?></td>
                            <td><?=$urm->status_display?></td>
                        </tr>
                        <? } ?>
                    
                    <? }else{ ?>
                    
                    <? } ?>
                    <tbody>
                    
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <?php /*?><a target="_blank" href="<?=MAINSITE_Admin.$is_module_id_27_data->class_name.'/quotation-edit'?>" class="btn btn-sm btn-info float-left">Add New</a><?php */?>
              <?
			  $a_link = $is_module_id_27_data->class_name.'/'.$is_module_id_27_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="btn btn-sm btn-secondary float-right">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          <? if($is_module_id_39==1){ ?>
          <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Delivery Note </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Delivery Note Number</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Added By</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                     <? if(!empty($invoice_delivery_note_data)){ ?>
                    
                        <? 
                            foreach($invoice_delivery_note_data as $urm) { 
                                ?>
                        <tr>
                            <td><a href="<?=MAINSITE_Admin.$is_module_id_39_data->class_name."/invoice-delivery-note-view/".$urm->invoice_delivery_note_id?>"><?=$urm->invoice_delivery_note_number ?></a></td>
                            <td><?=$urm->customer_unique_name?></td>
                            <td><i class="fas fa-credit-card"></i> <?=$urm->total?><br><i class="fas fa-sort-amount-up"></i> <?=$urm->total_qty?></td>
                            <td><?=$urm->added_by_name?></td>
                            <td><?=$urm->status_display?></td>
                        </tr>
                        <? } ?>
                    
                    <? }else{ ?>
                    
                    <? } ?>
                    <tbody>
                    
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <?php /*?><a target="_blank" href="<?=MAINSITE_Admin.$is_module_id_39_data->class_name.'/quotation-edit'?>" class="btn btn-sm btn-info float-left">Add New</a><?php */?>
              <?
			  $a_link = $is_module_id_39_data->class_name.'/'.$is_module_id_39_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="btn btn-sm btn-secondary float-right">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          <? if($is_module_id_38==1){ ?>
          <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Purchase Order </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Supplier</th>
                        <th>Amount</th>
                        <th>Added By</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                     <? if(!empty($purchase_order_data)){ ?>
                    
                        <? 
                            foreach($purchase_order_data as $urm) { 
                                ?>
                        <tr>
                            <td><a href="<?=MAINSITE_Admin.$is_module_id_38_data->class_name."/purchase-order-view/".$urm->purchase_order_id?>"><?=$urm->purchase_order_number ?></a></td>
                            <td><?=$urm->vendor_name?></td>
                            <td><i class="fas fa-credit-card"></i> <?=$urm->total?><br><i class="fas fa-sort-amount-up"></i> <?=$urm->total_qty?></td>
                            <td><?=$urm->added_by_name?></td>
                            <td><?=$urm->status_display?></td>
                        </tr>
                        <? } ?>
                    
                    <? }else{ ?>
                    
                    <? } ?>
                    <tbody>
                    
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <?php /*?><a target="_blank" href="<?=MAINSITE_Admin.$is_module_id_38_data->class_name.'/quotation-edit'?>" class="btn btn-sm btn-info float-left">Add New</a><?php */?>
              <?
			  $a_link = $is_module_id_38_data->class_name.'/'.$is_module_id_38_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="btn btn-sm btn-secondary float-right">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          </div>
	      <div class="col-md-4">
      	  <? if($is_module_id_21==1){ ?>
      		<div class="card">
              <div class="card-header">
                <h3 class="card-title">Quotation Enquiry(RFQ) Status</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body ">
              <? if(!empty($quotation_enquiry_status_data)){ ?>
              <? foreach($quotation_enquiry_status_data as $qsd){ 
			  $percent=(($qsd->counts/$qsd->total)*100);
			  
			  ?>
                <div class="progress-group">
                      <?=$qsd->status_name?>
                      <span class="float-right"><b><?=$qsd->counts?></b>/<?=$qsd->total?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar <?=$qsd->status_color_class?>" style="width: <?=$percent?>%"></div>
                      </div>
                    </div>
               <? } ?>
              <? }else{ ?>
                No data to display...
              <? } ?>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
              <?
			  $a_link = $is_module_id_21_data->class_name.'/'.$is_module_id_21_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="uppercase">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          
          <? if($is_module_id_22==1 && false){ ?>
      		<div class="card">
              <div class="card-header">
                <h3 class="card-title">Procurement Status</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body ">
              <? if(!empty($quotation_status_data)){ ?>
              <? foreach($quotation_status_data as $qsd){ 
			  $percent=(($qsd->counts/$qsd->total)*100);
			  
			  ?>
                <div class="progress-group">
                      <?=$qsd->status_name?>
                      <span class="float-right"><b><?=$qsd->counts?></b>/<?=$qsd->total?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar <?=$qsd->status_color_class?>" style="width: <?=$percent?>%"></div>
                      </div>
                    </div>
               <? } ?>
              <? }else{ ?>
                No data to display...
              <? } ?>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
              <?
			  $a_link = $is_module_id_22_data->class_name.'/'.$is_module_id_22_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="uppercase">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          <? if($is_module_id_25==1){ ?>
      		<div class="card">
              <div class="card-header">
                <h3 class="card-title">Quotation Status</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body ">
              <? if(!empty($quotation_status_data)){ ?>
              <? foreach($quotation_status_data as $qsd){ 
			  $percent=(($qsd->counts/$qsd->total)*100);
			  
			  ?>
                <div class="progress-group">
                      <?=$qsd->status_name?>
                      <span class="float-right"><b><?=$qsd->counts?></b>/<?=$qsd->total?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar <?=$qsd->status_color_class?>" style="width: <?=$percent?>%"></div>
                      </div>
                    </div>
               <? } ?>
              <? }else{ ?>
                No data to display...
              <? } ?>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
              <?
			  $a_link = $is_module_id_25_data->class_name.'/'.$is_module_id_25_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="uppercase">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          <? if($is_module_id_26==1){ ?>
      		<div class="card">
              <div class="card-header">
                <h3 class="card-title">Proforma Invoice Status</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body ">
              <? if(!empty($proforma_invoice_status_data)){ ?>
              <? foreach($proforma_invoice_status_data as $qsd){ 
			  $percent=(($qsd->counts/$qsd->total)*100);
			  
			  ?>
                <div class="progress-group">
                      <?=$qsd->status_name?>
                      <span class="float-right"><b><?=$qsd->counts?></b>/<?=$qsd->total?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar <?=$qsd->status_color_class?>" style="width: <?=$percent?>%"></div>
                      </div>
                    </div>
               <? } ?>
              <? }else{ ?>
                No data to display...
              <? } ?>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
              <?
			  $a_link = $is_module_id_26_data->class_name.'/'.$is_module_id_26_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="uppercase">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          <? if($is_module_id_27==1){ ?>
      		<div class="card">
              <div class="card-header">
                <h3 class="card-title"> Invoice Status</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body ">
              <? if(!empty($invoice_status_data)){ ?>
              <? foreach($invoice_status_data as $qsd){ 
			  $percent=(($qsd->counts/$qsd->total)*100);
			  
			  ?>
                <div class="progress-group">
                      <?=$qsd->status_name?>
                      <span class="float-right"><b><?=$qsd->counts?></b>/<?=$qsd->total?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar <?=$qsd->status_color_class?>" style="width: <?=$percent?>%"></div>
                      </div>
                    </div>
               <? } ?>
              <? }else{ ?>
                No data to display...
              <? } ?>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
              <?
			  $a_link = $is_module_id_27_data->class_name.'/'.$is_module_id_27_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="uppercase">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          <? if($is_module_id_39==1){ ?>
      		<div class="card">
              <div class="card-header">
                <h3 class="card-title"> Delivery Note Status</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body ">
              <? if(!empty($invoice_delivery_note_status_data)){ ?>
              <? foreach($invoice_delivery_note_status_data as $qsd){ 
			  $percent=(($qsd->counts/$qsd->total)*100);
			  
			  ?>
                <div class="progress-group">
                      <?=$qsd->status_name?>
                      <span class="float-right"><b><?=$qsd->counts?></b>/<?=$qsd->total?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar <?=$qsd->status_color_class?>" style="width: <?=$percent?>%"></div>
                      </div>
                    </div>
               <? } ?>
              <? }else{ ?>
                No data to display...
              <? } ?>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
              <?
			  $a_link = $is_module_id_39_data->class_name.'/'.$is_module_id_39_data->function_name;
			  ?>
                <a target="_blank" href="<?=MAINSITE_Admin.$a_link?>" class="uppercase">View All </a>
              </div>
              <!-- /.card-footer -->
            </div>
          <? } ?>
          </div>
       </div>
      	<?php /*?><div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Monthly Recap Report</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                    </p>

                    
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>Quotation Status</strong>
                    </p>
                    <? if(!empty($quotation_status_data1)){ ?>
                    
                    

                    <div class="progress-group">
                      Add Products to Cart
                      <span class="float-right"><b>160</b>/200</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: 80%"></div>
                      </div>
                    </div>
                    <? }else{ ?>
                    No data to display...
                    <? } ?>
                    <!-- /.progress-group -->

                    

                    <!-- /.progress-group -->
                    

                    <!-- /.progress-group -->
                    
                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                      <h5 class="description-header">$35,210.43</h5>
                      <span class="description-text">TOTAL REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                      <h5 class="description-header">$10,390.90</h5>
                      <span class="description-text">TOTAL COST</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                      <h5 class="description-header">$24,813.53</h5>
                      <span class="description-text">TOTAL PROFIT</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                      <h5 class="description-header">1200</h5>
                      <span class="description-text">GOAL COMPLETIONS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div><?php */?>
      </section>
    
    <?php /*?><section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">
                  10
                  <small>%</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">41,410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number">760</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">New Members</span>
                <span class="info-box-number">2,000</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Monthly Recap Report</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                    </p>

                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>Goal Completion</strong>
                    </p>

                    <div class="progress-group">
                      Add Products to Cart
                      <span class="float-right"><b>160</b>/200</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: 80%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      Complete Purchase
                      <span class="float-right"><b>310</b>/400</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: 75%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      <span class="progress-text">Visit Premium Page</span>
                      <span class="float-right"><b>480</b>/800</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 60%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      Send Inquiries
                      <span class="float-right"><b>250</b>/500</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                      <h5 class="description-header">$35,210.43</h5>
                      <span class="description-text">TOTAL REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                      <h5 class="description-header">$10,390.90</h5>
                      <span class="description-text">TOTAL COST</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                      <h5 class="description-header">$24,813.53</h5>
                      <span class="description-text">TOTAL PROFIT</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                      <h5 class="description-header">1200</h5>
                      <span class="description-text">GOAL COMPLETIONS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-8">
            <!-- MAP & BOX PANE -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">US-Visitors Report</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden">
                    <!-- Map will be created here -->
                    <div id="world-map-markers" style="height: 325px; overflow: hidden">
                      <div class="map"></div>
                    </div>
                  </div>
                  <div class="card-pane-right bg-success pt-2 pb-2 pl-4 pr-4">
                    <div class="description-block mb-4">
                      <div class="sparkbar pad" data-color="#fff">90,70,90,70,75,80,70</div>
                      <h5 class="description-header">8390</h5>
                      <span class="description-text">Visits</span>
                    </div>
                    <!-- /.description-block -->
                    <div class="description-block mb-4">
                      <div class="sparkbar pad" data-color="#fff">90,50,90,70,61,83,63</div>
                      <h5 class="description-header">30%</h5>
                      <span class="description-text">Referrals</span>
                    </div>
                    <!-- /.description-block -->
                    <div class="description-block">
                      <div class="sparkbar pad" data-color="#fff">90,50,90,70,61,83,63</div>
                      <h5 class="description-header">70%</h5>
                      <span class="description-text">Organic</span>
                    </div>
                    <!-- /.description-block -->
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="row">
              <div class="col-md-6">
                <!-- DIRECT CHAT -->
                <div class="card direct-chat direct-chat-warning">
                  <div class="card-header">
                    <h3 class="card-title">Direct Chat</h3>

                    <div class="card-tools">
                      <span data-toggle="tooltip" title="3 New Messages" class="badge badge-warning">3</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts"
                              data-widget="chat-pane-toggle">
                        <i class="fas fa-comments"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">
                      <!-- Message. Default to the left -->
                      <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                          <span class="direct-chat-name float-left">Alexander Pierce</span>
                          <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img class="direct-chat-img" src="<?=_lte_files_?>dist/img/user1-128x128.jpg" alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          Is this template really for free? That's unbelievable!
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->

                      <!-- Message to the right -->
                      <div class="direct-chat-msg right">
                        <div class="direct-chat-infos clearfix">
                          <span class="direct-chat-name float-right">Sarah Bullock</span>
                          <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img class="direct-chat-img" src="<?=_lte_files_?>dist/img/user3-128x128.jpg" alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          You better believe it!
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->

                      <!-- Message. Default to the left -->
                      <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                          <span class="direct-chat-name float-left">Alexander Pierce</span>
                          <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img class="direct-chat-img" src="<?=_lte_files_?>dist/img/user1-128x128.jpg" alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          Working with AdminLTE on a great new app! Wanna join?
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->

                      <!-- Message to the right -->
                      <div class="direct-chat-msg right">
                        <div class="direct-chat-infos clearfix">
                          <span class="direct-chat-name float-right">Sarah Bullock</span>
                          <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img class="direct-chat-img" src="<?=_lte_files_?>dist/img/user3-128x128.jpg" alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          I would love to.
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->

                    </div>
                    <!--/.direct-chat-messages-->

                    <!-- Contacts are loaded here -->
                    <div class="direct-chat-contacts">
                      <ul class="contacts-list">
                        <li>
                          <a href="#">
                            <img class="contacts-list-img" src="<?=_lte_files_?>dist/img/user1-128x128.jpg">

                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Count Dracula
                                <small class="contacts-list-date float-right">2/28/2015</small>
                              </span>
                              <span class="contacts-list-msg">How have you been? I was...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img class="contacts-list-img" src="<?=_lte_files_?>dist/img/user7-128x128.jpg">

                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Sarah Doe
                                <small class="contacts-list-date float-right">2/23/2015</small>
                              </span>
                              <span class="contacts-list-msg">I will be waiting for...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img class="contacts-list-img" src="<?=_lte_files_?>dist/img/user3-128x128.jpg">

                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Nadia Jolie
                                <small class="contacts-list-date float-right">2/20/2015</small>
                              </span>
                              <span class="contacts-list-msg">I'll call you back at...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img class="contacts-list-img" src="<?=_lte_files_?>dist/img/user5-128x128.jpg">

                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Nora S. Vans
                                <small class="contacts-list-date float-right">2/10/2015</small>
                              </span>
                              <span class="contacts-list-msg">Where is your new...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img class="contacts-list-img" src="<?=_lte_files_?>dist/img/user6-128x128.jpg">

                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                John K.
                                <small class="contacts-list-date float-right">1/27/2015</small>
                              </span>
                              <span class="contacts-list-msg">Can I take a look at...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img class="contacts-list-img" src="<?=_lte_files_?>dist/img/user8-128x128.jpg">

                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Kenneth M.
                                <small class="contacts-list-date float-right">1/4/2015</small>
                              </span>
                              <span class="contacts-list-msg">Never mind I found...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                      </ul>
                      <!-- /.contacts-list -->
                    </div>
                    <!-- /.direct-chat-pane -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <form action="#" method="post">
                      <div class="input-group">
                        <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                        <span class="input-group-append">
                          <button type="button" class="btn btn-warning">Send</button>
                        </span>
                      </div>
                    </form>
                  </div>
                  <!-- /.card-footer-->
                </div>
                <!--/.direct-chat -->
              </div>
              <!-- /.col -->

              <div class="col-md-6">
                <!-- USERS LIST -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Latest Members</h3>

                    <div class="card-tools">
                      <span class="badge badge-danger">8 New Members</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <ul class="users-list clearfix">
                      <li>
                        <img src="<?=_lte_files_?>dist/img/user1-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Alexander Pierce</a>
                        <span class="users-list-date">Today</span>
                      </li>
                      <li>
                        <img src="<?=_lte_files_?>dist/img/user8-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Norman</a>
                        <span class="users-list-date">Yesterday</span>
                      </li>
                      <li>
                        <img src="<?=_lte_files_?>dist/img/user7-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Jane</a>
                        <span class="users-list-date">12 Jan</span>
                      </li>
                      <li>
                        <img src="<?=_lte_files_?>dist/img/user6-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">John</a>
                        <span class="users-list-date">12 Jan</span>
                      </li>
                      <li>
                        <img src="<?=_lte_files_?>dist/img/user2-160x160.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Alexander</a>
                        <span class="users-list-date">13 Jan</span>
                      </li>
                      <li>
                        <img src="<?=_lte_files_?>dist/img/user5-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Sarah</a>
                        <span class="users-list-date">14 Jan</span>
                      </li>
                      <li>
                        <img src="<?=_lte_files_?>dist/img/user4-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nora</a>
                        <span class="users-list-date">15 Jan</span>
                      </li>
                      <li>
                        <img src="<?=_lte_files_?>dist/img/user3-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nadia</a>
                        <span class="users-list-date">15 Jan</span>
                      </li>
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer text-center">
                    <a href="javascript::">View All Users</a>
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!--/.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Item</th>
                      <th>Status</th>
                      <th>Popularity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR9842</a></td>
                      <td>Call of Duty IV</td>
                      <td><span class="badge badge-success">Shipped</span></td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR1848</a></td>
                      <td>Samsung Smart TV</td>
                      <td><span class="badge badge-warning">Pending</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR7429</a></td>
                      <td>iPhone 6 Plus</td>
                      <td><span class="badge badge-danger">Delivered</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR7429</a></td>
                      <td>Samsung Smart TV</td>
                      <td><span class="badge badge-info">Processing</span></td>
                      <td>
                        <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR1848</a></td>
                      <td>Samsung Smart TV</td>
                      <td><span class="badge badge-warning">Pending</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR7429</a></td>
                      <td>iPhone 6 Plus</td>
                      <td><span class="badge badge-danger">Delivered</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR9842</a></td>
                      <td>Call of Duty IV</td>
                      <td><span class="badge badge-success">Shipped</span></td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Inventory</span>
                <span class="info-box-number">5,200</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Mentions</span>
                <span class="info-box-number">92,050</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Downloads</span>
                <span class="info-box-number">114,381</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="far fa-comment"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Direct Messages</span>
                <span class="info-box-number">163,921</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Browser Usage</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <div class="chart-responsive">
                      <canvas id="pieChart" height="150"></canvas>
                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <ul class="chart-legend clearfix">
                      <li><i class="far fa-circle text-danger"></i> Chrome</li>
                      <li><i class="far fa-circle text-success"></i> IE</li>
                      <li><i class="far fa-circle text-warning"></i> FireFox</li>
                      <li><i class="far fa-circle text-info"></i> Safari</li>
                      <li><i class="far fa-circle text-primary"></i> Opera</li>
                      <li><i class="far fa-circle text-secondary"></i> Navigator</li>
                    </ul>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer bg-white p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      United States of America
                      <span class="float-right text-danger">
                        <i class="fas fa-arrow-down text-sm"></i>
                        12%</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      India
                      <span class="float-right text-success">
                        <i class="fas fa-arrow-up text-sm"></i> 4%
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      China
                      <span class="float-right text-warning">
                        <i class="fas fa-arrow-left text-sm"></i> 0%
                      </span>
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.footer -->
            </div>
            <!-- /.card -->

            <!-- PRODUCT LIST -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Recently Added Products</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                  <li class="item">
                    <div class="product-img">
                      <img src="<?=_lte_files_?>dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Samsung TV
                        <span class="badge badge-warning float-right">$1800</span></a>
                      <span class="product-description">
                        Samsung 32" 1080p 60Hz LED Smart HDTV.
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="<?=_lte_files_?>dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Bicycle
                        <span class="badge badge-info float-right">$700</span></a>
                      <span class="product-description">
                        26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="<?=_lte_files_?>dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">
                        Xbox One <span class="badge badge-danger float-right">
                        $350
                      </span>
                      </a>
                      <span class="product-description">
                        Xbox One Console Bundle with Halo Master Chief Collection.
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="<?=_lte_files_?>dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">PlayStation 4
                        <span class="badge badge-success float-right">$399</span></a>
                      <span class="product-description">
                        PlayStation 4 500GB Console (PS4)
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">View All Products</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
		</section><?php */?>
		
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  