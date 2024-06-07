<style type="text/css">
.spinner-border {
    display: inline-block;
    width: 5rem;
    height: 5rem;
    vertical-align: text-bottom;
    border: .25em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    -webkit-animation: spinner-border .75s linear infinite;
    animation: spinner-border .75s linear infinite; position:fixed; z-index:2000; top:50%; left:50%; }
	.text-primary {
    color: #007bff!important;
}
@keyframes spinner-border {
  to { transform: rotate(360deg); }
}
@keyframes spinner-grow {
  0% {
    transform: scale(0);
  }
  50% {
    opacity: 1;
  }
}
.loader{background-color: rgba(0, 0, 0, 0.3); width:100%; height:100%; position:fixed; top:0; left:0; z-index:20000000;}
</style>


    <!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="easebuzz/assets/css/style.css">
        <title>Initiate Payment API</title>
    </head>
    <body >
    <div class="loader" style="display:none" >
    <div class="spinner-border text-primary spinner-grow" role="status">
      <!--<span class="sr-only">Loading...</span>-->
    </div>
</div>
        <div class="grid-container" style="display:">
            
            
            <div class="form-container">
                <h2>INITIATE PAYMENT API</h2>
                <hr>
                <form method="POST" name="redirect" id="redirect" action="<?=base_url()?>easebuzz/easebuzz.php?api_name=initiate_payment">
                
                    <div class="main-form">
                        <h3>Mandatory Parameters</h3>
                        <hr>
                        <div class="mandatory-data">
                            <div class="form-field">
                                <label for="txnid">Transaction ID<sup>*</sup></label>
                                <input id="txnid" class="txnid" name="txnid" value="<?=$payment_gateway_data['Order_Id']?>" placeholder="T31Q6JT8HB">
                            </div>
                            
                            <div class="form-field">
                            <? //$payment_gateway_data['Amount']='1.00'; ?>
                                <label for="amount">Amount<sup>(should be float)*</sup></label>
                                <input id="amount" class="amount" name="amount" value="<?=$payment_gateway_data['Amount']?>" placeholder="125.25">
                            </div>  

                            <div class="form-field">
                                <label for="firstname">First Name<sup>*</sup></label>
                                <input id="firstname" class="firstname" name="firstname" value="<?=$payment_gateway_data['name']?>" placeholder="Easebuzz Pvt. Ltd.">
                            </div>
                    
                            <div class="form-field">
                                <label for="email">Email ID<sup>*</sup></label>
                                <input id="email" class="email" name="email" value="<?=$payment_gateway_data['email']?>"
                                placeholder="initiate.payment@easebuzz.in">
                            </div>
                    
                            <div class="form-field">
                                <label for="phone">Phone<sup>*</sup></label>
                                <input id="phone" class="phone" name="phone" value="<?=$payment_gateway_data['number']?>"
                                placeholder="0123456789">
                            </div>
                            
                            <div class="form-field">
                                <label for="productinfo">Product Information<sup>*</sup></label>
                                <input id="productinfo" class="productinfo" name="productinfo" value="Test" placeholder="Apple Laptop">
                            </div>
                    
                            <div class="form-field">
                                <label for="surl">Success URL<sup>*</sup></label>
                                <input id="surl" class="surl" name="surl" value="<?=$payment_gateway_data['Redirect_Url']?>" placeholder="http://localhost:3000/response.php">
                            </div>
                            
                            <div class="form-field">
                                <label for="furl">Failure URL<sup>*</sup></label>
                                <input id="furl" class="furl" name="furl" value="<?=$payment_gateway_data['Redirect_Url']?>"
                                placeholder="http://localhost:3000/response.php">
                            </div>

                        </div>

                        <h3>Optional Parameters</h3>
                        <hr>
                        <div class="optional-data">

                            <!--<div class="form-field">
                                <label for="udf1">UDF1</label>
                                <input id="udf1" class="udf1" name="udf1" value="" placeholder="User description1">
                            </div>
                        
                            <div class="form-field">
                                <label for="udf2">UDF2</label>
                                <input id="udf2" class="udf2" name="udf2" value="" placeholder="User description2">
                            </div>
                    
                            <div class="form-field">
                                <label for="udf3">UDF3</label>
                                <input id="udf3" class="udf3" name="udf3" value="" placeholder="User description3">
                            </div>
                    
                            <div class="form-field">
                                <label for="udf4">UDF4</label>
                                <input id="udf4" class="udf4" name="udf4" value="" placeholder="User description4">
                            </div>
                    
                            <div class="form-field">
                                <label for="udf5">UDF5</label>
                                <input id="udf5" class="udf5" name="udf5" value="" placeholder="User description5">
                            </div>-->
                            
                            <div class="form-field">
                                <label for="address1">Address 1</label>
                                <input id="address1" class="address1" name="address1" value="<? //=$payment_gateway_data['address']?>" placeholder="#250, Main 5th cross,">
                            </div>
                    
                            <!--<div class="form-field">
                                <label for="address2">Address 2</label>
                                <input id="address2" class="address2" name="address2" value="" 
                                placeholder="Saket nagar, Pune">
                            </div>-->
                            
                            <div class="form-field">
                                <label for="city">City</label>
                                <input id="city" class="city" name="city" value="<? //=$payment_gateway_data['city']?>" placeholder="Pune">
                            </div>
                    
                            <div class="form-field">
                                <label for="state">State</label>
                                <input id="state" class="state" name="state" value="<? //=$payment_gateway_data['state']?>" placeholder="Maharashtra">
                            </div>
                    
                            <div class="form-field">
                                <label for="country">Country</label>
                                <input id="country" class="country" name="country" value="<? //=$payment_gateway_data['country']?>" placeholder="India">
                            </div>
                            
                            <div class="form-field">
                                <label for="zipcode">Zip-Code</label>
                                <input id="zipcode" class="zipcode" name="zipcode" value="<? //=$payment_gateway_data['pincode']?>" placeholder="123456">
                            </div>

                               <!--<div class="form-field">
                                <label for="sub_merchant_id">Sub-Merchant ID</label>
                                <input id="sub_merchant_id" class="sub_merchant_id" name="sub_merchant_id" value="" placeholder="123456">
                            </div>

                             <div class="form-field">
                                <label for="unique_id">Unique Id</label>
                                <input id="unique_id" class="unique_id" name="unique_id" value="" placeholder="Customer unique Id">
                            </div>

                             <div class="form-field">
                                <label for="split_payments">Split payment</label>
                                <input id="split_payments" class="split_payments" name="split_payments" value="" placeholder='{ "axisaccount" : 100, "hdfcaccount" : 100}'>
                            </div>-->

                              <div class="form-field">
                                <label for="show_payment_mode">Show Payment Mode</label>
                                <input id="show_payment_mode" class="show_payment_mode" name="show_payment_mode" value="" placeholder='NB,DC,CC,Debit+ATM Pin,MW,UPI,OM,EMI'>
                            </div>


                        </div>
                
                        <!--<input type="hidden" name="api_name" value="initiate_payment"> -->
                        <div class="btn-submit">
                            <button type="submit">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </body>
</html>
<script language='javascript'>//document.redirect.submit();</script>
<? exit; ?>