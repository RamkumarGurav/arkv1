
<script>
function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
var view_product = getRandomInt(4 , 20);
var str = document.getElementById('current_viewers_msg').innerHTML;
//res = str.replace("%d", view_product);
document.getElementById('current_viewers_msg').innerHTML = "<img src='<?=__scriptFilePath__?>images/icons/eye.svg'> Currently " + view_product + " people are viewing this product";
</script>
<? if($check_screen == 'isdesktop'){ ?>
<script src="<?=__scriptFilePath__?>js/Drift.min.js"></script>
<script>
<? $picount = 0;
foreach ($products_image as $pi) {
	$picount++; ?>
	var test = new Drift(document.querySelector('.drift-demo-trigger<?=$picount?>'), {
		paneContainer: document.querySelector('.product_cnt'),
		inlinePane: 900,
		inlineOffsetY: -85,
		containInline: true,
		hoverBoundingBox: true
	});
<? } ?>
<? } ?>
</script>
<script>

$('.quantity_ul li a').click( function(){
    if ( $(this).hasClass('current') ) {
        $(this).removeClass('current');
    } else {
        $('li a.current').removeClass('current');
        $(this).addClass('current');    
    }
});

$('.flavors_uli li a').click( function(){
    if ( $(this).hasClass('current') ) {
        $(this).removeClass('current');
    } else {
        $('li a.current').removeClass('current');
        $(this).addClass('current');    
    }
});
</script>
<script>
	// $(document).ready(function(){
		// $('#ex1').zoom();
	// });
	// $(document).ready(function(){
		// $('#ex2').zoom();
	// });
	// $(document).ready(function(){
		// $('#ex3').zoom();
	// });
	// $(document).ready(function(){
		// $('#ex4').zoom();
	// });
	// $(document).ready(function(){
		// $('#ex5').zoom();
	// });
	// $(document).ready(function(){
		// $('#ex6').zoom();
	// });
	// $(document).ready(function(){
		// $('#ex7').zoom();
	// });
</script>


<script type="text/javascript">
	// $('.ReadMoreReview').click(function(){
		// $(this).toggleClass('less')	
		// $('.mainreviweContenttext').toggleClass('open')
	// });
// $(document).ready(function(){
		// $('.zoom').zoom();
	// });
</script>
	<script>
	var test = new Drift(document.querySelector('.drift-demo-trigger1'), {
		paneContainer: document.querySelector('.product_cnt'),
		inlinePane: 900,
		inlineOffsetY: -85,
		containInline: true,
		hoverBoundingBox: true
	});
	var test = new Drift(document.querySelector('.drift-demo-trigger2'), {
		paneContainer: document.querySelector('.product_cnt'),
		inlinePane: 900,
		inlineOffsetY: -85,
		containInline: true,
		hoverBoundingBox: true
	});
	var test = new Drift(document.querySelector('.drift-demo-trigger3'), {
		paneContainer: document.querySelector('.product_cnt'),
		inlinePane: 900,
		inlineOffsetY: -85,
		containInline: true,
		hoverBoundingBox: true
	});

</script>

<script>

var Roffset=10;

var Rresult='';

   function product_reviews(pid) {

   

       var mainsite = "<?php echo MAINSITE; ?>";

       if (pid > 0) {

	  // alert(Qresult);

	   if(Rresult != 'NO')

	   {

		   Roffset = Roffset + 10;

		   

			   $.ajax({

				   type: "POST",

				   url: mainsite+"Products/product_review",

				   data: { 

					   "product_id": pid,

					   "offset": Roffset,

				   },

				   success: function(result) {

					   //console.log(Qresult);

					   Rresult=result;

					   if(Rresult == 'NO')

					   {

					   	result='<div class="alert alert-danger" role="alert">No More Reviews To Display</div>';

					   }

					  $(".reviewsBody").append(result);

					  var $input = $('input.rating'), count = Object.keys($input).length;

					   if (count > 0) {

						   $input.rating();

					   }

				   }

			   });

		   } 

		}

		else {

			   alert("Error in ajax request")

		   }

   }

   

   var Qoffset=5;

var Qresult='';

   function product_questions(pid) {

   

       var mainsite = "<?php echo MAINSITE; ?>";

       if (pid > 0) {

	  // alert(Qresult);

	   if(Qresult != '<div class="alert alert-danger" role="alert">No More Questions To Display</div>')

	   {

		   Qoffset = Qoffset + 5;

		   

			   $.ajax({

				   type: "POST",

				   url: mainsite+"Products/product_questions",

				   data: { 

					   "product_id": pid,

					   "offset": Qoffset,

				   },

				   success: function(result) {

					   //console.log(Qresult);

					   Qresult=result;

					  $(".questionAnswerBody").append(result);

				   }

			   });

		   } 

		}

		else {

			   alert("Error in ajax request")

		   }

   }

   

function SubmitRatingForm(product_id)

{

	var mainsite = "<?=base_url()?>"; 

	$('.review_alert_msg').hide();

	$('.review_alert_msg').html('');

	var rating=document.getElementById('customer_rating').value; 

	if(rating == '' || rating == 0)

	{

		alert(' Please rate this product first');

		document.getElementById('customer_rating').focus();

		return false;

	}else{

		 //alert(product_id+'   '+rating);

		 $(".loader").show();

			$.ajax({

			type: "POST",

			url : mainsite+"index.php/Products/doPostRating",

			//dataType : 'json',

			data : {"rating" :rating , "product_id" : product_id},

			success : function(result){			

			//alert(result);

			$('.review_alert_msg').show();

			$('.review_alert_msg').html(result);

			$(".loader").hide();

			}

			});

						

	}

				

}



function SubmitReviewForm()
{
	
	var mainsite = "<?=base_url()?>"; 
	$('.review_alert_msg').html('');
	var product_id=document.getElementById('product_id').value; 
	var product_combination_id=document.getElementById('product_combination_id').value; 
	var rating=document.getElementById('rating').value; 
	//var customer_name=document.getElementById('customer_name').value; 
	var review_title=document.getElementById('review_title').value; 
	var review=document.getElementById('customer_review').value;
	$('.review_alert_msg').hide();
	$('.review_alert_msg').html(''); 
	
	if(rating == '' || rating == 0)
	{
		$('.review_alert_msg').show();
		$('.review_alert_msg').html('<div class="alert alert-danger" role="alert">Please select rating</div>');
		document.getElementById('rating').focus();
		return false;
	}
	<?php /*?>else if(review_title == '' || review_title == 0)
	{
		$('.review_alert_msg').show();
		$('.review_alert_msg').html('<div class="alert alert-danger" role="alert">Please enter review title</div>');
		document.getElementById('review_title').focus();
		return false;
	}
	else if(review == '' || review == 0 || review.length < 100)
	{
		$('.review_alert_msg').show();
		$('.review_alert_msg').html(' <div class="alert alert-danger" role="alert">Please enter review of atleast 100 characters</div>');
		document.getElementById('customer_review').focus();
		return false;
	}<?php */?>
	else{
		 //alert(product_id+'   '+rating);
		 $(".loader").show();
			$.ajax({
			type: "POST",
			url : mainsite+"Products/doPostReview",
			dataType : 'json',
			//data : {"rating" :rating , "product_id" : product_id, "customer_name" :customer_name , "review_title" :review_title, "review" :review},
			data : {"rating" :rating , "product_id" : product_id, "review_title" :review_title, "review" :review, "product_combination_id" :product_combination_id},
			success : function(result){			
			//alert(result);
			//document.getElementById('review_response').innerHTML = '<div class="alert alert-success" role="alert">' + result + '</div>';
			$('.review_alert_msg').show();
			$('.review_alert_msg').html(result.response_text);
			//document.getElementById('customer_name').value=''; 
			if(result.response_code == 1)
			{
				document.getElementById('review_title').value=''; 
				document.getElementById('customer_review').value='';
			}
			$(".loader").hide();
			}
			});
						
	}
			
}

function SubmitQuestionForm()
{
	var mainsite = "<?=base_url()?>"; 
	
	var product_id=document.getElementById('product_id').value; 
	var question=document.getElementById('question').value; 
	var customer_name=document.getElementById('customer_nm').value; 
	var customer_email=document.getElementById('custmr_email').value; 
	
	$('.question_alert_msg').hide();
	$('.question_alert_msg').html('');
	
	if(customer_name == '')
	{
		alert(' Please enter your name.');
		document.getElementById('customer_nm').focus();
		return false;
	}else if(customer_email == '')
	{
		alert(' Please enter your email');
		document.getElementById('custmr_email').focus();
		return false;
	}else if(question == '')
	{
		alert('select enter your question.');
		document.getElementById('question').focus();
		return false;
	}else{
		 //alert(product_id+'   '+rating);
		 $(".loader").show();
			$.ajax({
			type: "POST",
			url : mainsite+"index.php/Products/doPostQuestion",
			//dataType : 'json',
			data : {"question" :question , "product_id" : product_id, "customer_name" :customer_name , "customer_email" : customer_email},
			success : function(result){			
			//alert(result);
			$('.question_alert_msg').show();
			$('.question_alert_msg').html(result);
			document.getElementById('question').value=''; 
			document.getElementById('customer_nm').value=''; 
			document.getElementById('custmr_email').value=''; 
			$(".loader").hide();
		}
			});
						
	}
}

function SubmitAnswerForm(id)
{
	var mainsite = "<?=base_url()?>"; 
	var answerfield='answer'+id;
	var customer_nmefield='customer_nme'+id;
	var custmr_emailidfield='custmr_emailid'+id;
	var question_idfield='question_id'+id;
	var to_namefield='to_name'+id;
	var ans_for_quesfield='ans_for_ques'+id;
	
	var product_id=document.getElementById('product_id').value; 
	var answer=document.getElementById(answerfield).value; //alert(answer);
	var customer_name=document.getElementById(customer_nmefield).value; //alert(customer_name);
	var customer_email=document.getElementById(custmr_emailidfield).value; //alert(customer_email);
	var question_id=document.getElementById(question_idfield).value; //alert(question_id);
	var to_name=document.getElementById(to_namefield).value; //alert(to_name);
	var ans_for_ques=document.getElementById(ans_for_quesfield).value; //alert(ans_for_ques);
	
	$('.answer_alert_msg'+id).hide();
	$('.answer_alert_msg'+id).html('');
			
	if(customer_name == '')
	{
		alert(' Please enter your name.');

		document.getElementById(customer_nmefield).focus();

		return false;

	}else if(customer_email == '')

	{

		alert(' Please enter your email');

		document.getElementById(custmr_emailidfield).focus();

		return false;

	}else if(answer == '')

	{

		alert('select enter your answer.');

		document.getElementById(answerfield).focus();

		return false;

	}else{

		 //alert('product_id'+' -  '+product_id);

		 //$.noConflict();

		 $(".loader").show();

		 $.ajax({

			type: "POST",

			url : mainsite+"index.php/Products/doPostAnswer",

			//dataType : 'json',

			data : {"question_id" : question_id , "answer" : answer, "product_id" : product_id , "customer_name" : customer_name, "customer_email" : customer_email, "ans_for_ques" : ans_for_ques, "to_name" : to_name},

			success : function(result){			

			//alert(result);

			$('.answer_alert_msg'+id).show();

			$('.answer_alert_msg'+id).html(result);

			$(".loader").hide();

			document.getElementById(customer_nmefield).value=''; //alert(customer_name);

			document.getElementById(custmr_emailidfield).value=''; //alert(customer_email);

			document.getElementById(ans_for_quesfield).value=''; //alert(ans_for_ques);

			

			}

			});

		 

	}

}



function SubmitAnswerForm1(id)

{

	var mainsite = "<?=base_url()?>"; 

	var answerfield='m_answer'+id;

	var customer_nmefield='m_customer_nme'+id;

	var custmr_emailidfield='m_custmr_emailid'+id;

	var question_idfield='m_question_id'+id;

	var to_namefield='m_to_name'+id;

	var ans_for_quesfield='m_ans_for_ques'+id;

	

	var product_id=document.getElementById('product_id').value; 

	var answer=document.getElementById(answerfield).value; 

	var customer_name=document.getElementById(customer_nmefield).value; 

	var customer_email=document.getElementById(custmr_emailidfield).value; 

	var question_id=document.getElementById(question_idfield).value; 

	var to_name=document.getElementById(to_namefield).value; 

	var ans_for_ques=document.getElementById(ans_for_quesfield).value; 

	

	

	if(customer_name == '')

	{

		alert(' Please enter your name.');

		document.getElementById(customer_nmefield).focus();

		return false;

	}else if(customer_email == '')

	{

		alert(' Please enter your email');

		document.getElementById(custmr_emailidfield).focus();

		return false;

	}else if(answer == '')

	{

		alert('select enter your answer.');

		document.getElementById(answerfield).focus();

		return false;

	}else{

		

		 //lert('product_id'+' -  '+product_id);

			$.ajax({

			type: "POST",

			url : mainsite+"index.php/Products/doPostAnswer",

			//dataType : 'json',

			data : {"question_id" :question_id, "answer" :answer , "product_id" : product_id, "customer_name" :customer_name , "customer_email" : customer_email, "ans_for_ques" :ans_for_ques, "to_name" :to_name},

			success : function(result){			

			alert(result);

			

			}

			});

						

	}

}

var likequestionfunctioncall = true;

function likequestion(id, spanid)

{

	var mainsite = "<?=base_url()?>";

	$(".loader").show(); 

	$('.likequestion_alert_msg'+id).hide();

	$('.likequestion_alert_msg'+id).html('');

	if(likequestionfunctioncall){

		$.ajax({

			type: "POST",

			url : mainsite+"index.php/Products/dolikeQuestion",

			dataType : 'json',

			data : {"question_id" :id},

			success : function(result){	

			if(result.likedby>0)

			{

				document.getElementById(spanid).innerHTML=result.likedby;

			}

			$(".loader").hide();

			//alert(result);

			//likequestionfunctioncall = false;

			$('.likequestion_alert_msg'+id).show();

			$('.likequestion_alert_msg'+id).html(result.message);

			}

			});

	}

		else

		{

			$('.likequestion_alert_msg'+id).show();

			$('.likequestion_alert_msg'+id).html('<strong>Warning!</strong> You already liked this answer');

			$(".loader").hide();

		}

}



var likeanswerfunctioncall = true;

function likeanswer(id, spanid)

{

	var mainsite = "<?=base_url()?>"; 

	$(".loader").show();

	$('.likeanswer_alert_msg'+id).hide();

	$('.likeanswer_alert_msg'+id).html('');

	if(likeanswerfunctioncall){

		$.ajax({

			type: "POST",

			url : mainsite+"index.php/Products/dolikeAnswer",

			dataType : 'json',

			data : {"answer_id" :id},

			success : function(result){			

			//document.getElementById(spanid).innerHTML=result;	

				if(result.likedby>0)

				{

					document.getElementById(spanid).innerHTML=result.likedby;

				}

				$(".loader").hide();

				//alert(result);

				//likeanswerfunctioncall = false;

				$('.likeanswer_alert_msg'+id).show();

				$('.likeanswer_alert_msg'+id).html(result.message);

			}

			});

		}

		else

		{

			$('.likeanswer_alert_msg'+id).show();

			$('.likeanswer_alert_msg'+id).html('<strong>Warning!</strong> You already liked this answer');

			$(".loader").hide();

		}

}



function checkemail(email_id, id)

{

	if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email_id))

	{

		if(!email_id=="")

			{

				//document.getElementById(id).focus();

				return true;

			}

		else

			{

				document.getElementById(id).value = "";

				document.getElementById(id).focus();

				return false;

			}

	}

	else

	{

		document.getElementById(id).value = "";

		document.getElementById(id).focus();

		alert("Invalid E-mail Address! Please re-enter From Address.");

		

		return false;

	}

}



function alphaonly(input,event)

{

			var keyCode = event.which ? event.which : event.keyCode;

			//Small Alphabets

			if(parseInt(keyCode)>=97 && parseInt(keyCode)<=122){return true;}

			//Caps Alphabets

			if(parseInt(keyCode)>=65 && parseInt(keyCode)<=90){return true;}

			if(parseInt(keyCode)==32 || parseInt(keyCode)==13 || parseInt(keyCode)==46 || keyCode==9/*TAB*/ || keyCode==8/*BCKSPC*/ || keyCode==37/*LFT ARROW*/ || keyCode==39/*RGT ARROW*/ || keyCode==38/*UP ARROW*/ || keyCode==40/*DOWN ARROW*/ ){return true;}

			alert("Please enter only alphbets.");

			input.focus();

			return false;

}





function validate_bulk_enquiry_form()
{
	event.preventDefault(); 
	$('#bulk_enquiry_form_err').removeClass('hidden');
	$('#bulk_enquiry_form_err').hide();
	$('#bulk_enquiry_form_err').html('');
	var count=0;
	var err='';
	var name = document.getElementById("bulk_enquiry_form").elements.namedItem("name");
	var email = document.getElementById("bulk_enquiry_form").elements.namedItem("email");
	var contact = document.getElementById("bulk_enquiry_form").elements.namedItem("contact");
	var bulk_quantity = document.getElementById("bulk_enquiry_form").elements.namedItem("bulk_quantity");
	var message = document.getElementById("bulk_enquiry_form").elements.namedItem("message");
	
	if(name.value == '')
	{
		err = 'Name Should Not Be Empty';
		count++;
		name.focus();
	}
	else if(!name_only(name.value))
	{
		err = 'Name Should Only Alphabets';
		count++;
		name.focus();
	}
	
	else if(email.value == '')
	{
		err = 'Email Should Not Be Empty';
		count++;
		email.focus();
	}
	else if(!ValidateEmail(email.value))
	{
		err = 'Please Enter Valid Email Id';
		count++;
		email.focus();
	}
	else if(contact.value == '')
	{
		err = 'Contact Number Should Not Be Empty';
		count++;
		contact.focus();
	}
	else if(contact.value.length != 10)
	{
		err = 'Please Enter 10 Digit Mobile Number';
		count++;
		contact.focus();
	}
	else if(!number_only(contact.value))
	{
		err = 'Please Enter Valid Email Id';
		count++;
		contact.focus();
	}
	else if(bulk_quantity.value == '')
	{
		err = 'Please Enter Required Quantity';
		count++;
		bulk_quantity.focus();
	}
	else if(!number_only(bulk_quantity.value))
	{
		err = 'Please Enter Valid Quantity';
		count++;
		bulk_quantity.focus();
	}
	else if(message.value == '')
	{
		err = 'Message Should Not Be Empty';
		count++;
		message.focus();
	}
	
	if(count>0)
	{
		$('#loader').hide();
		$('#bulk_enquiry_form_err').show();
		$('#bulk_enquiry_form_err').html(err);
		return false;
	}   
	else
	{
		$('#loader').show();
		var Form_obj = $('#bulk_enquiry_form');
		$.ajax({
			type: Form_obj.attr('method'),
			url: '<?=base_url()?>user/bulk_enquiry_product',
			data: Form_obj.serialize(),
			dataType: "json",
			success: function (data) {
				if(data.status=='true')
				{
					$('#bulk_enquiry_form_msg').html(data.message);
					name.value='';
					email.value='';
					contact.value='';
					message.value='';
					bulk_quantity.value='';
				}
				else
				{
					$('#bulk_enquiry_form_msg').html(data.message);
					
				}
				$('#loader').hide();
			},
			error: function (data) {
				$('#loader').hide();
				alert('Unknown error occurred.');
			},
		});
	}
}



function validate_not_find_product_form()
{
	event.preventDefault(); 
	$('#not_find_product_form_err').removeClass('hidden');
	$('#not_find_product_form_err').hide();
	$('#not_find_product_form_err').html('');
	var count=0;
	var err='';
	var name = document.getElementById("not_find_product_form").elements.namedItem("name");
	var email = document.getElementById("not_find_product_form").elements.namedItem("email");
	var contact = document.getElementById("not_find_product_form").elements.namedItem("contact");
	var country_id = document.getElementById("not_find_product_form").elements.namedItem("country_id");
	var message = document.getElementById("not_find_product_form").elements.namedItem("message");
	
	if(name.value == '')
	{
		err = 'Name Should Not Be Empty';
		count++;
		name.focus();
	}
	else if(!name_only(name.value))
	{
		err = 'Name Should Only Alphabets';
		count++;
		name.focus();
	}
	
	else if(email.value == '')
	{
		err = 'Email Should Not Be Empty';
		count++;
		email.focus();
	}
	else if(!ValidateEmail(email.value))
	{
		err = 'Please Enter Valid Email Id';
		count++;
		email.focus();
	}
	
	else if(country_id.value == '')
	{
		err = 'Please Select Country';
		count++;
		contact.focus();
	}
	else if(contact.value == '')
	{
		err = 'Contact Number Should Not Be Empty';
		count++;
		contact.focus();
	}
	else if(contact.value.length != 10)
	{
		err = 'Please Enter 10 Digit Mobile Number';
		count++;
		contact.focus();
	}
	else if(!number_only(contact.value))
	{
		err = 'Please Enter Valid Email Id';
		count++;
		contact.focus();
	}
	
	else if(message.value == '')
	{
		err = 'Message Should Not Be Empty';
		count++;
		message.focus();
	}
	
	if(count>0)
	{
		$('#loader').hide();
		$('#not_find_product_form_err').show();
		$('#not_find_product_form_err').html(err);
		return false;
	}   
	else
	{
		$('#loader').show();
		var Form_obj = $('#not_find_product_form');
		$.ajax({
			type: Form_obj.attr('method'),
			url: Form_obj.attr('action'),
			data: Form_obj.serialize(),
			dataType: "json",
			success: function (data) {
				if(data.status=='true')
				{
					$('#not_find_product_form_msg').html(data.message);
					name.value='';
					email.value='';
					contact.value='';
					message.value='';
				}
				else
				{
					$('#not_find_product_form_msg').html(data.message);
					
				}
				$('#loader').hide();
			},
			error: function (data) {
				$('#loader').hide();
				alert('Unknown error occurred.');
			},
		});
	}
}

</script>

	

<script>

/*new Drift(document.querySelector('.drift-demo-trigger'), {

	paneContainer: document.querySelector('.detail'),

	inlinePane: 40,

	inlineOffsetY: -55,

	containInline: true,

	hoverBoundingBox: true

});*/

</script>

