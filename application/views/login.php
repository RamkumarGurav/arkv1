<div class="container">
<nav  class="breadcrumb ">
	<ol>
    	<li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Login</span></li>
	</ol>
</nav>
</div>
      <div class="mt-3">
      <div class=" mb-5">

         <div class="row login-width md-flex  align-items-center justify-content-center ">
            <div class=" col-md-5 pddng0">
               <div class="login-leftside"> 
                <span class="span-text"><span>Login</span></span>
                <p class="para"><span>Get access to your Orders, Wishlist and Recommendations</span></p>
               </div>
            </div>
            <div class="col-md-7 pddng0">
<h2 class="text-center mt-3">Existing User Login</h2>
               <div class="empty1 login-right-side mb-5">
                  <div class="row loginForm">
                  
                  <?php $this->load->view('template/login-form' , $this->data); ?>

                       <!-- <h4 class="form_headr1">Login Details</h4> -->
<!-- Pills navs -->

<!-- Pills navs -->

<!-- Pills content -->

<!-- Pills content -->
                      
                     
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
       <div id="snackbar1"><img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMjAnIGhlaWdodD0nMjAnIHZpZXdCb3g9JzAgMCAyMCAyMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz4KCTxnPgoJCTxwYXRoIGQ9J00tMi0yaDI0djI0SC0yeicgZmlsbD0nbm9uZScvPgoJCTxwYXRoIGQ9J00xMCAwQzQuNDggMCAwIDQuNDggMCAxMHM0LjQ4IDEwIDEwIDEwIDEwLTQuNDggMTAtMTBTMTUuNTIgMCAxMCAwek04IDE1bC01LTUgMS40MS0xLjQxTDggMTIuMTdsNy41OS03LjU5TDE3IDZsLTkgOXonIGZpbGw9JyMyNkJDNEUnLz4KCTwvZz4KPC9zdmc+Cg==" class="Rym-jM"> Verification code sent to 7676084926</div>
      <div id="smartblog_block" class="block products_block hb-animate-element bottom-to-top hb-in-viewport">
         <div class="container">
         </div>
         
         
         

<script>
window.addEventListener("load", function(){
	setRegisterForm();
})

function setRegisterForm(){
	$( "#login_form" ).submit(function( event ) {
		//alert( "Handler for .submit() called." );
		event.preventDefault();
		$(".loader").css("display","block");
		$.ajax({
			type: "POST",
			//url:$('.siteUrl').val()+'products/loadMoreProduct',
			url: '<?=base_url(__login__).'/loginAuth'?>',
			/*dataType : "json",*/
			data : $('#login_form').serialize(),
			success : function(result){
				$('.loginForm').html(result);
				$(".loader").css("display","none");
				setRegisterForm();
			},
			error : function(result){
				alert("error");
				$(".loader").css("display","none");
			}
		});
	});
}
</script>

<?php /*?>
         <script>

function remeberMe()
{
	var remember = document.getElementById('remember');
	var password = document.getElementById('password');
	var email = document.getElementById('email');
	
	if(remember.checked)
	{
		localStorage.setItem('username', window.btoa(email.value));
		localStorage.setItem('password', window.btoa(password.value));
	}
	return true;
	
}
window.addEventList9999ener('load' , function(){
	var username = localStorage.getItem('username');
	var password = localStorage.getItem('password');
	if(username != null && password != null )
	{
		if(document.getElementById('email').value == '' )
		{
			document.getElementById('email').value = atob(username);
			document.getElementById('password').value = atob(password);
		}
	}

})
</script>
<script>
  $('#ex1-content').on('click', function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>
<script>
  function snackBar1() {
    var x = document.getElementById("snackbar1")
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
</script><?php */?>
 <link href="<?=CSS?>login.css" rel="stylesheet">
 <script>
 
window.addEventListener("load", function(){
	$(document).on("keyup click", ".otpCl", function(e){
		var id = $(this).attr("data-id");
		var id_next = ++id;
		var id = $(this).attr("data-id");
		var id_pre = --id;
		console.log(event.which + ' : ' + id + ' : ' + id_next + ' : ' + id_pre);
		if(e.which == 8)
		{
			$(this).val('');
			if(id_pre >=0)
			{
				$('.otpCl_'+id_pre).focus();
			}
		}
		else
		{
			var now_id = 1;
			$( ".otpCl" ).each(function( index ) {
			  //console.log( index + ": " + $( this ).text() );
			  	var id = $(this).attr("data-id");
				var id_next = ++id;
				if($(this).val() != '')
				{
					now_id = id_next
					
				}
			});
			$('.otpCl_'+now_id).focus();
		}
	})
})
 
 </script>