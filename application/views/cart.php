

      <div  style="background-color: rgb(255, 255, 255);">
   <div class="container">
   	<nav  class="breadcrumb ">
	<ol>
    	<li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Cart</span></li>
	</ol>
</nav>
     
   </div>

</div>
      <div >
      
      <div class="container ">

         <div class="row">
         <div class="edit_profle row">	
         <?=$message?>
         	 <div class="cart1 mb-4 col-lg-8">
          <div class="row align-items-center">
            <div class="col-lg-6 col-6">
               <div class="">From Saved Addresses </div>
               <div><?=$this->session->userdata('application_sess_cart_page_address');?></div>
            </div>
       
         <div class="col-lg-6 col-6">
          
              <a href="" data-bs-toggle="modal" data-bs-target="#func_pin_location_modal_icon" class="delivery-pincode">Enter Delivery Pincode</a>
           
         </div>
     </div>
 </div>
 <div class="row cartPage cart_tabs_1 "> 
			<? $this->load->view('template/cart' , $this->data); ?>	
</div>
				
			</div>
           
         </div>
      </div>
    <!--   <div id="smartblog_block" class="block products_block hb-animate-element bottom-to-top hb-in-viewport">
         <div class="container">
         </div> -->


<?php /*?><script src="https://ebz-static.s3.ap-south-1.amazonaws.com/easecheckout/easebuzz-checkout.js"></script><?php */?>

<script>
function myFunction(){
	$('.errorInfo').html('');
	event.preventDefault();
	$.ajax({
   type: "POST",
	url:"<?=base_url(__payment__)?>",
   dataType : "json",
   data : $("#micro_chipForm").serialize(),
   success : function(result){
			if(result.status==1)
			{
			 //var easebuzzCheckout = new EasebuzzCheckout('5WY1W7OYZV', 'prod')
			 var easebuzzCheckout = new EasebuzzCheckout('2PBP7IABZ2', 'test')
				   var options = {
					   access_key: result.data, // access key received via Initiate Payment
					   onResponse: (response) => {
						   console.log(response);
						   if(response.status == "userCancelled"){
                            $(".errorInfo").html("User cancelled transaction.").css("color","red");
                        }
                        else if(response.status == "success"){
                            $(".errorInfo").html("Transaction successful.").css("color","green");

							$.ajax({
							   type: "POST",
								url:'<?=base_url()?>order_confirmation',
							   dataType : "json",
							   data : {'response' : response, "<?=$csrf['name']?>":"<?=$csrf['hash']?>" },
							   success : function(result){ //alert(result.status);
									 console.log('result start');

								   if(result.status==1)
								   {
									window.location = "<?=base_url()?>order_status";
									 }
									 else
									 {
										window.location = "<?=base_url()?>order_status";
										}

									}
							   });


                        }
                        else if(response.status == "failure"){
                            $(".errorInfo").html("Transaction failed.").css("color","red");
                        }
					   },
					   theme: "#123456" // color hex
				   }
				   easebuzzCheckout.initiatePayment(options);
			}
			else
			{
				$('.errorInfo').html(result.message);
			}

		}
   });
}
</script>
<div class="modal fade" id="func_pin_location_modal_icon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-custom1 ">
    <div class="modal-content">
      <div class="modal-header modal-header2">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Select Delivery Address</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">✕</button>
      </div>
      <div class="modal-body modal-body2 show_cart_page_address">
        <div class="row">
        	<div class="col-lg-1 col-1">
        		<input type="radio" name="" checked readonly>
        	</div>
        	<div class="col-lg-11 col-11">
        		<div class="select-delivery">
        			<div class="select-delivery-inner">
        				<div class="delivery-username">Rashmi</div>
        				<span>, 560048</span>
        				<span class="delivery-type">WORK</span>
        			</div>
        			<p class="select-delivery-desc">bangalore, jayanagar, Bengaluru</p>
        		</div>
        	</div>
        </div>
      </div>
     <? if(_shipping_show_service_availablity == 1){ ?>
      	<div class="use-pincode _shipping_show_service_availablity_cl">
      		<div class="use-pincode-inner">
      	          Use pincode to check delivery info
             </div>
             <div class="pincode-input-content">
             	<input placeholder="Enter pincode" type="text" maxlength="6" minlength="6" name="pincode_d" id="pincode_d" autocomplete="off" class="pincode-input" value="">
             	<div onclick="getPincodeDetail()" class="pincode-submit">Submit</div>
                
             </div>
             <div id="PincodeData" style="    margin-left: 20px;"></div>
        </div>
	 <? } ?>
 
    </div>
  </div>
</div>

<script>
function getPincodeDetail(){
	
	$('#PincodeData').html('');
	var pincode_d =  document.getElementById('pincode_d');
	if(pincode_d.value == '')
	{
		return false;
	}
	if(pincode_d.value.length !=6)
	{
		$('#PincodeData').html('<span style="color:red">Enter 6 Digit Pincode</span>');
		pincode_d.focus();
		return false;
	}
	if(!number_only (pincode_d.value))
	{
		$('#PincodeData').html('<span style="color:red">Enter 6 Digit Pincode</span>');
		pincode_d.focus();
		return false;
	}
	  
	$('#PincodeData').html('Checking Availability...');
	$.ajax({
		type: "POST",
		url:'<?=MAINSITE?>Products/getPincodeDetail/',
		data : {   'pincode' : pincode_d.value, 'page' : 'cart'},
		success : function(result){
			$('#PincodeData').html(result);
			window.location.reload();
		}
	});
}

window.addEventListener('load', function(){
	$("#func_pin_location_modal_icon").on('show.bs.modal', function () {
		$('.show_cart_page_address').html("Loading...");
		$.ajax({
			type: "POST",
			url:'<?=MAINSITE?>Products/getCartpageAddress/',
			data : {},
			success : function(result){
				$('.show_cart_page_address').html(result);
			}
		});
		
	});
	
	$(document).on('change', '.address_radio', function(){
			$(".add_edit_address_cl").html("");
				$.ajax({
			   type: "POST",
				url:'<?=base_url()?>dashboard/editDeliverHereAddress',
			   dataType : "json",
			   data : {'customers_address_id' : $(this).attr("id"), 'page' : 'cart'},
			   success : function(result){
					window.location.reload();
				   }
			   });
	})
})
</script>
