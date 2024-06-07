<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


     
      
      <div class="container">
        <nav  class="breadcrumb ">
  <ol>
      <li><a href="<?=base_url();?>"><span>Home </span></a><meta content="1"></li>
        <li><span> / Rating Reviews</span></li>
  </ol>
</nav>
         <div class="row ">
            <?php $this->load->view('template/left-menu', $this->data);?>
            <div class="col-md-9">
              <div class="pddnl-16">
                      <div class="min-heigt">
                        <div class="second-sec">
                          <div class="pddng-24-32">
                            <div class="pddng-bt-56">
                                <div class="pddng-bt-24 allAddressCl">
                                   




<div class="noAddressCl">
                                    <div id="hide1">
                                    <div class="shipping-address">
                                      <div class="shipping-address-inner">
                                         <div class="shipping-address-center">
                                          <img src="assets/front/images/myReviews.png">
                                          <span class="no-address">No Addresses found in your account!</span>
                                          <span class="add-delivery">Add a delivery address.</span>
                                          <button class="add-addr-btn manageAddress noAddress" type="button" data-id="0" id="hide">ADD REVIEWS</button>
                                         </div>
                                      </div>
                                    </div>
                                  </div>

                                 <div class="add_edit_address_0" id="show1" style="display:none">
                                   

<span class="m-address">Rate this product</span>
<div class="manage-address">
      <div class="manage-address-inner">
        <form action="http://mars-500/xampp/MARS1/greenfieldeco/shipping-address" method="post" id="ship_address" style="display:block;" class="shping-add" accept-charset="utf-8">
        <input type="hidden" name="customers_address_id" value="0" id="customers_address_id">
            <input type="hidden" name="country_id" value="1" id="country_id">
          <span class="manage-add">Review this product</span>
          <div class="manage-class-inner manage-class-inner2">
                    
                <div class="review-section">
                  <div class="review-desc-inner">
                    <div class="review-desc-content">
                      <span>Description cannot be empty</span>
                    </div>
                    <div class="review-span">
                      <span>Description</span>
                    </div>
                    <textarea rows="8" placeholder="Description..." class="review-textarea"></textarea>
                  </div>
                  <hr class="review-hr">
                  <div class="review-title-inner">
                    <div class="review-title-content"><span>Title (optional)</span>
                    </div>
                    <input placeholder="Review title..." class="review-input" value="">
                  </div>
                </div>

           
           
             
         
          <div class="save-btns">
            <button type="submit" id="submit" name="AddressSaveBTN" value="1" class="save-btn">Save </button> 
            </div>
          </div>
        </form>      </div>

     </div>
                                 </div>
</div>
                                  

                                
                                </div>
                                </div>

                            </div>
                          </div>
                        </div>

                    </div>
</div>

               
               
            </div>
         </div>
     
      <div id="smartblog_block" class="block products_block hb-animate-element bottom-to-top hb-in-viewport">
         <div class="container">
         </div>
         <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="editmodal_body"><form action="#" method="post" onSubmit="submitAddressForm()" id="user_address_form" name="user_address_form" style="display:block;" class="shping-add" accept-charset="utf-8">
<input type="hidden" id="customers_address_id" name="customers_address_id" value="0">

<div class="modal-body">
   <div class="row">
   <div class="col-md-6">
        <div class="form-floating mb-3">
        
        <input type="text" name="name" value="" id="name" placeholder="Full Name" class="form-control" autofocus="autofocus" required="required">
   
        <label for="name" class="">Full Name</label>
        
      </div>
      </div>
         <div class="col-md-6">
      <div class="form-floating mb-3">
      
        <input type="text" name="number" value="" id="number" class="form-control" placeholder="Contact Number" pattern="[0-9]{10,10}" title="Enter only number between 0-9" required="required">
   
        <label for="number" class="">Contact Number</label>
      </div>
      </div>
         <div class="col-md-6">
      <div class="form-floating mb-3">
        <input type="text" name="address" value="" id="address" class="form-control" placeholder="Address Line 1" required="required">
   
        <label for="address" class="">Address Line 1</label>
      </div>
        </div>
         <div class="col-md-6">
      <div class="form-floating mb-3">
        <input type="text" name="address2" value="" id="address2" class="form-control" placeholder="Address Line 2" required="required">
   
        <label for="address2" class="">Address Line 2</label>
      </div>
        </div>
         <div class="col-md-6">
      <div class="form-floating mb-3">
        <input type="text" name="address3" value="" id="address3" class="form-control" placeholder="Address Line 3" required="required">
   
        <label for="address3" class="">Address Line 3</label>
      </div>
      
        </div>
      
         <div class="col-md-6">
      <div class="form-floating mb-3">
        <select name="state_id" id="state_id" value="" class="form-control" type="text" onChange="getCity(this , 'city_id' , 0)" required="required">
<option value="" selected="selected">Select State</option>
<option value="1">Karnataka</option>
<option value="2">Andaman and Nicobar Islan</option>
<option value="3">Andhra Pradesh</option>
<option value="4">Arunachal Pradesh</option>
<option value="5">Assam</option>
<option value="6">Bihar</option>
<option value="7">Chandigarh</option>
<option value="8">Chhattisgarh</option>
<option value="10">Delhi</option>
<option value="11">Goa</option>
<option value="12">Gujarat</option>
<option value="13">Haryana</option>
<option value="14">Himachal Pradesh</option>
<option value="15">Jammu and Kashmir</option>
<option value="16">Jharkhand</option>
<option value="17">Kerala</option>
<option value="18">Madhya Pradesh</option>
<option value="19">Maharashtra</option>
<option value="20">Manipur</option>
<option value="21">Meghalaya</option>
<option value="22">Mizoram</option>
<option value="23">Nagaland</option>
<option value="24">Odisha</option>
<option value="25">Puducherry</option>
<option value="26">Punjab</option>
<option value="27">Rajasthan</option>
<option value="28">Tamil Nadu</option>
<option value="29">Telangana</option>
<option value="30">Tripura</option>
<option value="31">Uttar Pradesh</option>
<option value="32">Uttarakhand</option>
<option value="33">West Bengal</option>
</select>
   
        <label for="state_id" class="">State</label>
      </div>
        </div>
         <div class="col-md-6">
      <div class="form-floating mb-3">
        <select name="city_id" id="city_id" value="" class="form-control" type="text" required="required">
<option value="" selected="selected">Select City</option>
</select>
   
        <label for="city_id" class="">City</label>
      </div>
        </div>
         <div class="col-md-6">
      <div class="form-floating mb-3">
        <input type="text" name="zipcode" value="" id="zipcode" class="form-control" placeholder="Pincode" pattern="[0-9]{6,6}" title="Enter only number between 0-9" required="required">
   
        <label for="zipcode" class="">Pincode</label>
      </div>
        </div>
         
        </div>
        
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      
      <button type="submit" id="submit" name="AddressBTN" value="1" class="btn btn-warning">Update</button> 

    </div>
    
</div></form></div>
      </div>
     
    </div>
  </div>
</div>
<script>
function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>


  <script>
$(document).ready(function(){
$(document).on("click","#hide",function() {
  $(this).text('Cancel');
  $(this).attr('id','show');
     $('#show1').show();
      $('#hide1').hide();
  });
$(document).on("click","#show",function() {
    $(this).text('Edit');
  $(this).attr('id','hide');
  $('#show1').hide();
      $('#hide1').show();
  });
});
</script>
