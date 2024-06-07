
<div class="main_banner prodct_sec1 container">		
    <div class="row"> 

        <div class="prodct_det2 product_cnt">
<form action="<?=base_url().'place-cod-order'?>" name="place_cod_order_form" id="place_cod_order_form" method="post" onsubmit='return  verify_otp()'>
            <div class="form-group position-R">
                <input type="number" name="o_otp" id="o_otp" class="profil_form" minlength="6" maxlength="6" autofocus="autofocus" placeholder="Enter OTP" required="required">
                <span class="placeholder_label">Enter OTP</span>
            </div>
            <button class="login_butn1" name="o_otp_btn" id="o_otp_btn" value="1" type="submit" style="margin-bottom:10px;">Verify OTP and Place Order</button>
            
            </form>


			<button class="login_butn1" style="display:none" name="resend_otp_btn" id="resend_otp_btn" value="1" type="button" onclick="resend_otp()">Re-Send OTP</button>
            <span id="resend_otp_err"></span>
        </div> 
    </div> 
</div>

<script>


clearInterval(myOTPTimer);
var time_sec = 20;
function resend_otp_func()
{
	
}
var myOTPTimer = setInterval(resend_otp_time, 1000);

function resend_otp_time() {

  time_sec = time_sec - 1;
  $('#resend_otp_err').html('Resend OTP in '+ time_sec +' Seconds.');
  if(time_sec==0)
  {
	  clearInterval(myOTPTimer);
	  $('#resend_otp_btn').show();
	  $('#resend_otp_err').html('');
  }
}

function resend_otp()
{
	$(".loader").css("display","block");
	$.ajax({
		type: "POST",
		//url:$('.siteUrl').val()+'products/loadMoreProduct',
		url:$('.siteUrl').val()+'Payment_Checkout/resend_otp',
		/*dataType : "json",*/
		data : {},
		success : function(result){
			time_sec = 20;
			$('#resend_otp_btn').hide();
			myOTPTimer = setInterval(resend_otp_time, 1000);
			$(".loader").css("display","none");
		}
	});
}

$(document).on("submit", '#place_cod_order_form', function(){
	$(".loader").css("display","block");
	$(".loader").css("z-index","99999999");
	$('#otp_verify_modal').modal('hide');
})
</script>