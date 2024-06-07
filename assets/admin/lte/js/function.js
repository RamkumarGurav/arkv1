var mainsite = document.getElementById('base_url_function').innerHTML;

function create_modal(size , modal_id)
{
  $('#'+modal_id).remove();
  var template = '<div class="modal fade" id="'+modal_id+'" style="margin-top:10px;padding-top:10px "><div class="modal-dialog modal-'+size+'" id="'+modal_id+'-content"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Create Model</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body" id="'+modal_id+'-body-templete">Modal Content Comes Here</div><div class="modal-footer justify-content-between"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>';
  $('body').append(template);
}

function add_update_vendor_address(func_url='' , parent_id='' , id='' , is_page='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'vendor_address_id' : id , 'vendor_profile_id' : parent_id , 'is_page' : is_page },
      success: function( response ) {
        modal_id = 'dynamic-modal-vendor-add-update';
        create_modal('xl' , modal_id);
        
        $("#"+modal_id+"-content").html(response.template);
        $("#"+modal_id).modal();
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function view_vendor_address(func_url='' , parent_id , id='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'vendor_address_id' : id , 'vendor_profile_id' : parent_id },
      success: function( response ) {
        modal_id = 'dynamic-modal-vendor-view';
        create_modal('xl' , modal_id);
        
        $("#"+modal_id+"-content").html(response.template);
        $("#"+modal_id).modal();
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function add_update_vendor_contact(func_url='' , parent_id='' , id='' , is_page='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'vendor_contact_id' : id , 'vendor_profile_id' : parent_id , 'is_page' : is_page },
      success: function( response ) {
        modal_id = 'dynamic-modal-vendor-add-update';
        create_modal('xl' , modal_id);
        
        $("#"+modal_id+"-content").html(response.template);
        $("#"+modal_id).modal();
		bindContactNo();
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function view_vendor_contact(func_url='' , parent_id , id='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'vendor_contact_id' : id , 'vendor_profile_id' : parent_id },
      success: function( response ) {
        modal_id = 'dynamic-modal-vendor-view';
        create_modal('xl' , modal_id);
        
        $("#"+modal_id+"-content").html(response.template);
        $("#"+modal_id).modal();
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function add_update_customer_address(func_url='' , parent_id='' , id='' , is_page='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'customer_address_id' : id , 'customer_profile_id' : parent_id , 'is_page' : is_page },
      success: function( response ) {
        modal_id = 'dynamic-modal-customer-add-update';
        create_modal('xl' , modal_id);
        
        $("#"+modal_id+"-content").html(response.template);
        $("#"+modal_id).modal();
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function view_customer_address(func_url='' , parent_id , id='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'customer_address_id' : id , 'customer_profile_id' : parent_id },
      success: function( response ) {
        modal_id = 'dynamic-modal-customer-view';
        create_modal('xl' , modal_id);
        
        $("#"+modal_id+"-content").html(response.template);
        $("#"+modal_id).modal();
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function add_update_customer_contact(func_url='' , parent_id='' , id='' , is_page='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'customer_contact_id' : id , 'customer_profile_id' : parent_id , 'is_page' : is_page },
      success: function( response ) {
        modal_id = 'dynamic-modal-customer-add-update';
        create_modal('xl' , modal_id);
        
        $("#"+modal_id+"-content").html(response.template);
        $("#"+modal_id).modal();
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function view_customer_contact(func_url='' , parent_id , id='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'customer_contact_id' : id , 'customer_profile_id' : parent_id },
      success: function( response ) {
        modal_id = 'dynamic-modal-customer-view';
        create_modal('xl' , modal_id);
        
        $("#"+modal_id+"-content").html(response.template);
        $("#"+modal_id).modal();
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}


function add_update_procurement_quotation_details(func_url='' , parent_id='' , id='' , procurement_detail_id='' , is_page='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'quotation_enquiry_detail_id' : id , 'quotation_enquiry_id' : parent_id , 'quotation_enquiry_procurement_detail_id' : procurement_detail_id , 'is_page' : is_page },
      success: function( response ) {
        modal_id = 'dynamic-modal-procurement-quotation-detail-add-update';
        create_modal('xl' , modal_id);
        
        $("#"+modal_id+"-content").html(response.template);
        $("#"+modal_id).modal();
		$('.custom-file-input').on('change', function () {
			let fileName = Array.from(this.files).map(x => x.name).join(', ')
			$(this).siblings('.custom-file-label').addClass("selected").html(fileName);
		});
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function delete_procurement_quotation_details(func_url='' , parent_id='' , id='' , procurement_detail_id='' , is_page='')
{
	if(confirm("Do you really want to delete the item?"))
	{
		if(confirm("Item once deleted can not be recovered. Do you really want to delete?"))
		{
//			'quotation_enquiry_detail_id' : id , 'quotation_enquiry_id' : parent_id , 'quotation_enquiry_procurement_detail_id' : procurement_detail_id , 'is_page' : is_page
			var form = document.createElement("form");
			document.body.appendChild(form);
			form.method = "POST";
			form.action = func_url;
			
			var element1 = document.createElement("INPUT");         
			element1.name="quotation_enquiry_id"
			element1.value = parent_id;
			element1.type = 'hidden'
			form.appendChild(element1);
			
			var element2 = document.createElement("INPUT");         
			element2.name="quotation_enquiry_detail_id"
			element2.value = id;
			element2.type = 'hidden'
			form.appendChild(element2);
			form.submit();
		}
	}
}

function delete_additional_cost_data(func_url='' , id1='' , id='')
{
	Pace.restart();
	if(confirm("Do you really want to delete the record?"))
	{
		$.ajax({
		  url: func_url,
		  type: 'post',
		  dataType: "json",
		  data: {	'quotation_enquiry_procurement_additional_cost_id' : id1 , 'quotation_enquiry_procurement_detail_id' : id},
		  success: function( response ) {
			$("#template_pro_quote_charges_view"+id).html( response.template_pro_quote_charges_view );
			toastrDefaultSuccessFunc( response.toastr_message );
			$('.is_qute_create_button_cl').show();
		  },
		  error: function (request, error) {
			toastrDefaultErrorFunc("Unknown Error. Please Try Again");
		  }
		});
	}
}

function add_procurement_quotation_additional_cost(func_url='' , parent_id='' , id='' , procurement_detail_id='' , is_page='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'quotation_enquiry_detail_id' : id , 'quotation_enquiry_id' : parent_id , 'quotation_enquiry_procurement_detail_id' : procurement_detail_id , 'is_page' : is_page },
      success: function( response ) {
        modal_id = 'dynamic-modal-procurement-quotation-detail-add-update';
        create_modal('xl' , modal_id);
        
        $("#"+modal_id+"-content").html(response.template);
        $("#"+modal_id).modal();
		$('.custom-file-input').on('change', function () {
			let fileName = Array.from(this.files).map(x => x.name).join(', ')
			$(this).siblings('.custom-file-label').addClass("selected").html(fileName);
		});
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function create_quotation_from_p_rfq_pop(func_url='' , parent_id='' , id='' , is_page='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'quotation_enquiry_id' : parent_id , 'is_page' : is_page },
      success: function( response ) {
		if(response.success_response==0)
		{
			toastrDefaultErrorFunc(response.toastr_message);
		}
		else if(response.success_response==1)
		{
			modal_id = 'dynamic-modal-create-quotation-from-p-rfq-pop';
			create_modal('xl' , modal_id);
			$("#"+modal_id+"-content").html(response.template);
			$("#"+modal_id).modal();
		}
		else
		{
			toastrDefaultErrorFunc("Unknown Error. Please Try Again");
		}
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function add_quotation_followup_pop(func_url='' , parent_id='' , id='' , is_page='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'quotation_id' : parent_id , 'is_page' : is_page },
      success: function( response ) {
		if(response.success_response==0)
		{
			toastrDefaultErrorFunc(response.toastr_message);
		}
		else if(response.success_response==1)
		{
			modal_id = 'dynamic-modal-create-quotation-from-p-rfq-pop';
			create_modal('xl' , modal_id);
			$("#"+modal_id+"-content").html(response.template);
			$("#"+modal_id).modal();
		}
		else
		{
			toastrDefaultErrorFunc("Unknown Error. Please Try Again");
		}
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function pi_payment_remarks(func_url='' , parent_id='' , id='' , is_page='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'proforma_invoice_id' : parent_id , 'is_page' : is_page },
      success: function( response ) {
		if(response.success_response==0)
		{
			toastrDefaultErrorFunc(response.toastr_message);
		}
		else if(response.success_response==1)
		{
			modal_id = 'dynamic-modal-create-quotation-from-p-rfq-pop';
			create_modal('xl' , modal_id);
			$("#"+modal_id+"-content").html(response.template);
			$("#"+modal_id).modal();
		}
		else
		{
			toastrDefaultErrorFunc("Unknown Error. Please Try Again");
		}
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function add_sales_acknowledgement_pop(func_url='' , parent_id='' , id='' , old_data='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'quotation_id' : parent_id , 'old_data' : old_data , 'quotation_detail_id' : id },
      success: function( response ) {
		if(response.success_response==0)
		{
			toastrDefaultErrorFunc(response.toastr_message);
		}
		else if(response.success_response==1)
		{
			modal_id = 'dynamic-modal-create-quotation-s-p-acnk-pop';
			create_modal('xl' , modal_id);
			$("#"+modal_id+"-content").html(response.template);
			$("#"+modal_id).modal();
		}
		else
		{
			toastrDefaultErrorFunc("Unknown Error. Please Try Again");
		}
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function add_purchase_po_reff_pop(func_url='' , parent_id='' , id='' , old_data='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'purchase_order_id' : parent_id , 'old_data' : old_data , 'quotation_detail_id' : id },
      success: function( response ) {
		if(response.success_response==0)
		{
			toastrDefaultErrorFunc(response.toastr_message);
		}
		else if(response.success_response==1)
		{
			modal_id = 'dynamic-modal-create-po-reff-s-p-acnk-pop';
			create_modal('xl' , modal_id);
			$("#"+modal_id+"-content").html(response.template);
			$("#"+modal_id).modal();
		}
		else
		{
			toastrDefaultErrorFunc("Unknown Error. Please Try Again");
		}
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

function view_quotation_followup_pop(func_url='' , parent_id='' , id='' , is_page='')
{
  Pace.restart();
    $.ajax({
      url: func_url,
      type: 'post',
      dataType: "json",
      data: {	'quotation_id' : parent_id ,	'reff_quotation_id' : id , 'is_page' : is_page },
      success: function( response ) {
		if(response.success_response==0)
		{
			toastrDefaultErrorFunc(response.toastr_message);
		}
		else if(response.success_response==1)
		{
			modal_id = 'dynamic-modal-view-quotation-from-p-rfq-pop';
			create_modal('xl' , modal_id);
			$("#"+modal_id+"-content").html(response.template);
			$("#"+modal_id).modal();
		}
		else
		{
			toastrDefaultErrorFunc("Unknown Error. Please Try Again");
		}
      },
      error: function (request, error) {
        toastrDefaultErrorFunc("Unknown Error. Please Try Again");
      }
    });
}

