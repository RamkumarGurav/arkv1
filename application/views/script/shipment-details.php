<script type="text/javascript">
$('input.main_radio_btn.shipping:radio').change(function(){
	var editS  = $(this).prev('.edit_Adres.shipping');
	var $editAdd2S = $(this).next().next('.collapse_florm.shipping');
	var $deliverAddS = $(this).next().next('.deliver-here.shipping');	
	if ($(this).is(':checked')) { /*alert('dfger');*/
		$(editS).css('display','block');
		$($deliverAddS).css('display','block');
		$('.edit_Adres.shipping').not(editS).css('display','none');
		$('.deliver-here.shipping').not($deliverAddS).css('display','none');
		$('.collapse_florm.shipping').not($editAdd2S).slideUp(300);
	}
	
});
$('.edit_Adres.shipping').each(function(){
	var $editAddS = $(this).next().next().next().next('.collapse_florm.shipping');
	var $editAddSC = $(this).closest('.collapse_florm.shipping');
	var $deliverAdd2S = $(this).next().next().next('.deliver-here.shipping');	
	$(this).click(function(){
		$($editAddSC).css('display','block !important');
		$($editAddS).css('display','block !important');
		$($editAddSC).show();
		$($editAddS).show();
		$($editAddS).slideDown(300);
		$('.collapse_florm.shipping').not($editAddS).slideUp(300);
		$(this).css('display','none');
		//$(this + ".collapse_florm").next().css('display','block');
		//$(this + ".collapse_florm").next().show();
		$('.shipping_forms_ids'+$(this).data('ids')).show();
		$('.shipping_forms_ids'+$(this).data('ids')).css('display','block !important');
		$($deliverAdd2S).css('display','block !important');
		
		
		//$($deliverAdd2S).css('display','none');
	});
	//if($(this).css('display') == 'block'){ alert('gerge');
	//	$('.collapse_florm').not($editAdd).slideUp(300);
	//};
});
$('.edit2_Adres.shipping').each(function(){
	var $cancelEditS = $(this).parent('.ship-edit-forms-btns.shipping').parent('form').parent('.shping-form.shipping').parent('.collapse_florm.shipping').prev().prev().prev().prev('.edit_Adres.shipping');
	var $cancelEditFormS = $(this).parent('.ship-edit-forms-btns.shipping').parent('form').parent('.shping-form.shipping').parent('.collapse_florm.shipping');
	var $deliverAdd3S = $(this).parent('.ship-edit-forms-btns.shipping').parent('form').parent('.shping-form.shipping').parent('.collapse_florm.shipping').prev('.deliver-here.shipping');
	$(this).click(function(){
		
		$($cancelEditS).css('display','block');
		$($cancelEditFormS).css('display','none');
		$($deliverAdd3S).css('display','block');
		$('.shipping_edit'+$(this).data('ids')).css('display','block !important');
		$('.shipping_edit'+$(this).data('ids')).show();
	});
});



$('input.main_radio_btn.billing:radio').change(function(){
	var editB  = $(this).prev('.edit_Adres.billing');
	var $editAdd2B = $(this).next().next('.collapse_florm.billing');
	var $deliverAddB = $(this).next().next('.deliver-here.billing');	
	if ($(this).is(':checked')) { /*alert('dfger');*/
		$(editB).css('display','block');
		$($deliverAddB).css('display','block');
		
		
		
		
		$('.edit_Adres.billing').not(editB).css('display','none');
		$('.deliver-here.billing').not($deliverAddB).css('display','none');
		$('.collapse_florm.billing').not($editAdd2B).slideUp(300);
	}
	
});
$('.edit_Adres.billing').each(function(){
	var $editAddB = $(this).next().next().next().next('.collapse_florm.billing');
	var $deliverAdd2B = $(this).next().next().next('.deliver-here.billing');	
	$(this).click(function(){
		$($editAddB).slideDown(300);
		$('.collapse_florm.billing').not($editAddB).slideUp(300);
		$(this).css('display','none');
		$($deliverAdd2B).css('display','none');
		
		$('.billing_forms_ids'+$(this).data('ids')).show();
		$('.billing_forms_ids'+$(this).data('ids')).css('display','block !important');
	});
	//if($(this).css('display') == 'block'){ alert('gerge');
	//	$('.collapse_florm').not($editAdd).slideUp(300);
	//};
});
$('.edit2_Adres.billing').each(function(){
	var $cancelEditB = $(this).parent('.ship-edit-forms-btns.billing').parent('form').parent('.shping-form.billing').parent('.collapse_florm.billing').prev().prev().prev().prev('.edit_Adres.billing');
	var $cancelEditFormB = $(this).parent('.ship-edit-forms-btns.billing').parent('form').parent('.shping-form.billing').parent('.collapse_florm.billing');
	var $deliverAdd3B = $(this).parent('.ship-edit-forms-btns.billing').parent('form').parent('.shping-form.billing').parent('.collapse_florm.billing').prev('.deliver-here.billing');
	$(this).click(function(){
		$($cancelEditB).css('display','block');
		$($cancelEditFormB).css('display','none');
		$($deliverAdd3B).css('display','block');
		$('.billing_edit'+$(this).data('ids')).css('display','block !important');
		$('.billing_edit'+$(this).data('ids')).show();
	});
});
</script>

<?php /*?><script type="text/javascript">
$('input.radio-btn.ship:radio').change(function(){
	var editS  = $(this).prev('.edit_Adres.ship');
	var $editAdd2S = $(this).next().next().next('.shping-add.ship');
	var $deliverAddS = $(this).next().next('.del-p.ship').children('.deliver-here.ship');	
	if ($(this).is(':checked')) { //alert('dfger');
		$(editS).css('display','block');
		$($deliverAddS).css('display','inline-block');
		$('.edit_Adres.ship').not(editS).css('display','none');
		$('.deliver-here.ship').not($deliverAddS).css('display','none');
		$('.shping-add.ship').not($editAdd2S).slideUp(300);
	}
	
});
$('.edit_Adres.ship').each(function(){
	var $editAddS = $(this).next().next().next().next('.shping-add.ship');
	var $deliverAdd2S = $(this).next().next().next('.del-p.ship').children('.deliver-here.ship');	
	$(this).click(function(){
		$($editAddS).slideDown(300);
		$('.shping-add.ship').not($editAddS).slideUp(300);
		$(this).css('display','none');
		$($deliverAdd2S).css('display','none');
	});
	//if($(this).css('display') == 'block'){ alert('gerge');
	//	$('.collapse_florm').not($editAdd).slideUp(300);
	//};
});
$('.cancel.ship').each(function(){ 
	var $cancelEditS = $(this).parent('.shp-form-btn.ship').parent('form.ship').prev('.del-p.ship').prev('.radio-label.ship').prev('.radio-btn.ship').prev('.edit_Adres.ship');
	var $cancelEditFormS = $(this).parent('.shp-form-btn.ship').parent('form.ship');
	var $deliverAdd3S = $(this).parent('.shp-form-btn.ship').parent('form.ship').prev('.del-p.ship').children('.deliver-here.ship');
	$(this).click(function(){
		$($cancelEditS).css('display','block');
		$($cancelEditFormS).css('display','none');
		$($deliverAdd3S).css('display','inline-block');
	});
});



$('input.radio-btn.bill:radio').change(function(){
	var editB  = $(this).prev('.edit_Adres.bill');
	var $editAdd2B = $(this).next().next().next('.shping-add.bill');
	var $deliverAddB = $(this).next().next('.del-p.bill').children('.deliver-here.bill');	
	if ($(this).is(':checked')) { //alert('dfger');
		$(editB).css('display','block');
		$($deliverAddB).css('display','inline-block');
		$('.edit_Adres.bill').not(editB).css('display','none');
		$('.deliver-here.bill').not($deliverAddB).css('display','none');
		$('.shping-add.bill').not($editAdd2B).slideUp(300);
	}
	
});
$('.edit_Adres.bill').each(function(){
	var $editAddB = $(this).next().next().next().next('.shping-add.bill');
	var $deliverAdd2B = $(this).next().next().next('.del-p.bill').children('.deliver-here.bill');	
	$(this).click(function(){
		$($editAddB).slideDown(300);
		$('.shping-add.bill').not($editAddB).slideUp(300);
		$(this).css('display','none');
		$($deliverAdd2B).css('display','none');
	});
	//if($(this).css('display') == 'block'){ alert('gerge');
	//	$('.collapse_florm').not($editAdd).slideUp(300);
	//};
});
$('.cancel.bill').each(function(){
	var $cancelEditB = $(this).parent('.shp-form-btn.bill').parent('form.bill').prev('.del-p.bill').prev('.radio-label.bill').prev('.radio-btn.bill').prev('.edit_Adres.bill');
	var $cancelEditFormB = $(this).parent('.shp-form-btn.bill').parent('form.bill');
	var $deliverAdd3B = $(this).parent('.shp-form-btn.bill').parent('form,bill').prev('.del-p.bill').children('.deliver-here.bill');
	$(this).click(function(){
		$($cancelEditB).css('display','block');
		$($cancelEditFormB).css('display','none');
		$($deliverAdd3B).css('display','inline-block');
	});
});
$('.card-header h5 button').each(function(){
	var openCloseIcon = $(this).next('i');
	var cpllapseIcon = $(this).parent('h5').parent('.card-header').next('.collapse');
	$(this).click(function(){
		if($(cpllapseIcon).hasClass('show')){ 
			$(openCloseIcon).removeClass('lnr-plus-circle').addClass('lnr-circle-minus');	
		}
		else{
			$(openCloseIcon).removeClass('lnr-circle-minus').addClass('lnr-plus-circle');	
			}
	});
});
</script><?php */?>