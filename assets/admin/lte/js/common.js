const number_only = string => [...string].every(c => '0123456789+ '.includes(c));

function contactErrClear(obj)
{
	$(obj).removeClass('is-invalid');
	$(obj).addClass('is-valid');
	$(obj).closest('div').find('.error_cl').html('');
}
function contactErrFunc(obj)
{
	obj.focus();
	$(obj).addClass('is-invalid');
	$(obj).removeClass('is-valid');
	var msg = '<p class="help-block text-muted"><span style="color:red" ><i> Enter Correct Number ( Number [+] [0-9] & [space] Allowed).</i></span></p>';
	$(obj).closest('div').find('.error_cl').html(msg);
}

function validateContactNo(obj )
{
	var temp = $(obj).val();
	status = true;
	//console.log('required : ' + $(obj).prop("required"));
	if(temp==''){if($(obj).prop("required")){return false;}else{return true;}}
	var i=0;
	for(i=0 ; i< temp.length ; i++)
	{
		if(!number_only(temp[i]))
		{
			var temp = $(obj).val('');
			contactErrFunc(obj)
			event.preventDefault();
			status = false;
			//return false;
		}
	}
	return status;
	//if(status){contactErrClear(obj);}
}

function eventContactNo(obj , evt)
{
	var keyCode = evt.which ? evt.which : evt.keyCode;
	var lisShiftkeypressed = evt.shiftKey;
	//if(lisShiftkeypressed && parseInt(keyCode) != 9){return false;}
	if((parseInt(keyCode)>=48 && parseInt(keyCode)<=57) || keyCode==37/*LFT ARROW*/ || keyCode==39/*RGT ARROW*/ || keyCode==38/*UP ARROW*/ || keyCode==40/*DOWN ARROW*/ || keyCode==8/*BCKSPC*/ || keyCode==46/*DEL*/ || keyCode==9/*TAB*/  || keyCode==45/*minus sign*/ || keyCode==43/*plus sign*/ || keyCode==32/*space*/ || keyCode==13/*enter*/){contactErrClear(obj);return true;}
	contactErrFunc(obj)
	event.preventDefault();
	return false;
}
function bindContactNo(){
	$(".eventContactNo").bind("keypress", function() {eventContactNo(this , event); });
	$(".eventContactNo").bind("keyup", function() {validateContactNo(this ); });
}

$(function () {
	bindContactNo();
});
if($( "body" ).hasClass( "select2bs4" ))
{
	$('.select2bs4').select2({
	  theme: 'bootstrap4'
	});
}
if($( "body" ).hasClass( "select2" ))
{
	$('.select2').select2();
}
function setSelect2(cl)
{
	$('.'+cl).select2();
}
	


function dataTableFunc(table_id){
	$("#"+table_id).DataTable({
	  aLengthMenu: [
			[25, 50, 100, 200, -1],
			[25, 50, 100, 200, "All"]
		],
		iDisplayLength: 100,	
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
	 // "scrollX": true,
	  "info": true,
      "autoWidth": false,
      "responsive": true
    });
}

function showFormSubmitLoading(id=''){
  $("#before_submit"+id).hide();
  $("#after_submit"+id).show();
}

function hideFormSubmitLoading(id=''){
  $("#before_submit"+id).show();
  $("#after_submit"+id).hide();
}

function showFormSubmitLoadingCl(id=''){
  $("#before_submit"+id).hide();
  $("#after_submit"+id).show();
}

function hideFormSubmitLoadingCl(id=''){
  $("#before_submit"+id).show();
  $("#after_submit"+id).hide();
}

function strip_html_tags(str)
{
   if ((str===null) || (str===''))
       return '';
  else
   str = str.toString();
  return str.replace(/<[^>]*>/g, '');
}


$(function () {
	//Function for side bar navigation
$('#sidebar-form').on('submit', function (e) {
	e.preventDefault();
});

$('.sidebar-menu li.active').data('lte.pushmenu.active', true);

$('#search-input').on('keyup', function () {
	var term = $('#search-input').val().trim();

	if (term.length === 0) {
		$('.sidebar-menu li').each(function () {
			$(this).show(0);
			$(this).removeClass('active');
			if ($(this).data('lte.pushmenu.active')) {
				$(this).addClass('active');
			}
		});
		return;
	}

	$('.sidebar-menu li').each(function () {
		if ($(this).text().toLowerCase().indexOf(term.toLowerCase()) === -1) {
			$(this).hide(0);
			$(this).removeClass('pushmenu-search-found  menu-open', false);

			if ($(this).is('.treeview')) {
				$(this).removeClass('active');
			}
		} else {
			$(this).show(0);
			
			
			/*var temp = $(this).text();
			var txt = temp.replace(term, function(str) {
              return "<b>" + str + "</b>"
            });
			$(this).text(txt);*/
			
			//var reg = new RegExp(searchItem, 'gi');  
			//console.log($(this).text());
			
			$(this).addClass('pushmenu-search-found menu-open');

			if ($(this).is('.treeview')) {
				$(this).addClass('active');
			}

			var parent = $(this).parents('li').first();
			if (parent.is('.treeview')) {
				parent.show(0);
			}
		}

		if ($(this).is('.header')) {
			$(this).show();
		}
	});

	$('.sidebar-menu li.pushmenu-search-found.treeview').each(function () {
		$(this).find('.pushmenu-search-found').show(0);
	});
});
});