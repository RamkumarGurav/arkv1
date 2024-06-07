<?
include( APPPATH."third_party/shiprocket/auth.php");
$od = $orders_detail[0];


$order_api_data = array(
"ids"=> array($od->courier_order_id));
$awb_number = $od->docket_no;


$order_api_data_json = $post_json_data = json_encode($order_api_data);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/track/awb/'.$awb_number,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
//  CURLOPT_POSTFIELDS =>$post_json_data,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    "Authorization: Bearer $token"
  ),
));

$responsejson = $response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response);
/*echo "<h1>RESPONSE</h1>";

echo "<pre>";
print_r($response);

print_r($auth_response);*/
//exit;
$result = $response;
//$auth_response = json_decode($response, true);
/*echo "<h1>RESPONSE</h1>";
echo "<xmp>";
print_r($response);
exit;*/
if(!empty($response->tracking_data))
{
	if($response->tracking_data==true )
	{
		// echo "<h1>RESPONSE</h1>";
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
		// echo "FINISH";

	}
	else{
		// echo "<h1>RESPONSE</h1>";
		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
	}
}
else{
	// echo "<h1>RESPONSE</h1>";
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
}



?>
<?
if(!empty($response->tracking_data))
{
	if($response->tracking_data==true )
	{
    ?>
    <style media="screen">
    @font-face {
    font-family: 'GoogleSans';
    src: url('../fonts/GoogleSans-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
    }
    @font-face {
    font-family: 'GoogleSans';
    src: url('../fonts/GoogleSans-Bold.ttf') format('truetype');
    font-weight: bold;
    font-style: normal;
    }
    @font-face {
    font-family: 'GoogleSans';
    src: url('../fonts/GoogleSans-Medium.ttf') format('truetype');
    font-weight: medium;
    font-style: normal;
    }

    body{
    	font-family: 'GoogleSans';
    }

    ul{
    	padding-left: 0;
    }
    .ml-20{
    	margin-left: -20px !important;
    }
    .logo,.logo:hover,.logo:focus{
    	text-decoration: none;
    	font-size: 25px;
    	color: #000;
    }
    .logo span{
    	line-height: 50px;
    }
    .primary_header{
     	padding: 15px 0;
    	min-height: 80px;
    }
    .secondary_header .navbar-default .navbar-nav > li > a{
    	color: #fff;
    	text-transform: capitalize;
    }
    .secondary_header .navbar-default{
    	border: none;
    	background: transparent;
    	margin: 0;
    }
    .secondary_header .navbar-default .navbar-nav > li > a:focus, .secondary_header .navbar-default .navbar-nav > li > a:hover{
    	color: #fff;
    }
    .secondary_header .navbar-default .navbar-nav > li > a{
    	font-size: 18px;
    	padding: 0;
    }
    .secondary_header .navbar-nav > li{
    	margin-right: 80px;
    	float: none;
    	display: inline-block;
    }
    .secondary_header .navbar-nav > li:last-child{
    	margin-right: 0px;
    }
    .secondary_header .navbar-nav {
    	margin: 15px 0;
    	text-align: center;
    	float: none;

    }
    .post_order_wrap{
    	padding: 24px 0 48px;
    }
    .post_order_wrap > a{
    	font-size: 18px;
    	margin-bottom: 35px;
    	display: block;
    	color: #285ddb;
    	padding-left: 4px;
    }
    .post_order_wrap > a i{
    	font-size: 32px;
    	position: relative;
    	top: 3px;
    	left: -5px;
    	color: #285ddb;
    }
    .post_order_wrap a:hover,.post_order_wrap a:focus{
    	text-decoration: none;
    	color: #004989;
    }
    .content{
    	background: #ededed;
    }
    .post_order_info{
    	background: #fff;
    	padding: 30px;
    	border-radius: 15px;
    	-webkit-border-radius: 15px;
    }
    .post_order_info .title{
    	font-size: 17px;
    	margin-bottom: 32px;
    	display: block;
    	border-bottom: 1px solid #CFD4D6;
    	padding-bottom: 25px;
    	color: #555;
    }
    .radio_box li{
    	float: left;
    	width: 14%;
    	list-style: none;
    }
    .radio_box span{
    	margin-left: 17px;
    	color: #555;
    }
    .radio_icon{
    	height: 22px;
    	width: 22px;
    	border: 1px solid  #CFD4D6;
    	display: block;
    	border-radius: 50%;
    	-webkit-border-radius: 50%;
    	position: absolute;
    	top: 9px;
    	left: -20px;
    }
    .radio_icon:before{
    	height: 10px;
    	width: 10px;
    	border-radius: 50%;
    	background: #000;
    	position: absolute;
    	content: "";
    	left: 0;
    	right: 0;
    	display: block;
    	margin:0 auto;
    	top: 5px;
    	display: none;
    }
    .radio_box {
    	padding-left: 18px;
        margin-bottom: 25px;
    }
    .error{
    	color: red;
    	display: block;
    	margin-bottom: 25px;
    }
    .success{
    	color: green;
    	display: block;
    }
    .radio_box input[type="radio"]{
    	height: 22px;
    	width: 22px;
    	position: relative;
    	top: 5px;
    	z-index: 9;
    	opacity: 0;
    }
    .radio_box input[type="radio"]:checked + .radio_icon:before{
    	display: block;
    }
    .post_order_info  label{
    	margin-bottom: 12px;
    	display: block;
    }
    .contact_input{
    	padding: 0;
    	margin-bottom: 34px;
    }
    .contact_input li{
    	float: left;
    	list-style: none;
    	width: 47.5%;
    	margin-right: 5%;
    }
    .contact_input li:last-child{
    	margin-right: 0;
    }
    .contact_input input{
    	width: 100%;
    	line-height: 50px;
    	height: 50px;
    	padding: 0 23px;
    	border-radius: 5px;
        -webkit-border-radius: 5px;
        border: 1px solid #CFD4D6;
    }
    .date_info{
    	padding: 0;
    	margin-bottom: 74px;
    }
    .date_info li{
     	float: left;
    	list-style: none;
    	margin-right: 3%;
    	border-radius: 5px;
    	cursor: pointer;
    	transition: 0.3s;
    	-webkit-transition: 0.3s;
    	color: #555;
    }
    #refused_resons li{
    	width: 25%;
    }
    #others_resons li{
    	width: 33.33%;
    }
    .mb-30{
    	margin-bottom: 30px !important;
    }
    .date_info li:hover,.date_info li:focus{
    	border-color: #4EA24A;
    }
    .post_order_info .contact_input + label{
    	margin-bottom: 37px;
    }
    .drop_down_select .panel-default{
    	float: left;
    	width: 47.5%;
    	margin-right: 5%;
    	margin-top: 0 !important;
    	margin-bottom: 60px;
    }
    .post_order_info .panel-default > .panel-heading{
    	background: transparent;
    }
    .drop_down_select .panel-default:nth-child(2n){
    	margin-right: 0;
    }
    .post_order_info  .panel-heading{
    	padding: 0;
    	border-radius: 5px;
    	-webkit-border-radius: 5px;
    }
    .post_order_info .panel-default > .panel-heading  a:focus, .post_order_info .panel-default > .panel-heading a:hover{
    	color: #fff;
    	background: #000;
    	outline: none;
    }
    .post_order_info .submit_btn{
    	display: block;
    	min-width: 270px;
    	line-height: 50px;
    	height: 50px;
    	color: #fff;
    	padding: 0;
    	font-size: 18px;
    	border-radius: 5px;
    	-webkit-border-radius: 5px;
    	margin-bottom: 30px;
    }
    .post_order_info .submit_btn:hover{
    }
    @media  (min-width: 912px) and (max-width: 912px){
    	footer{
    	/* position: fixed; */
    	}
    }
    footer{
    	padding: 15px 0 15px;

    }
    footer a{
    	color: #555;
    }
    footer a:hover,footer a:focus{
    	text-decoration: none;
    }
    .contact_detail{
    	margin-top: 9px;
    }

    .social-media{
    	margin-left: 8px;
    }

    .logo img {
    	max-width: 60%;
    	max-height: 100px;
    }
    @media  (max-width: 450px){
    	.logo img {
    		max-width: 40%;
    		max-height: 100px;
    	}
    }
    .bg-request-btn.button{
    	border: 1px solid #2960db;
    	background-color: #FFFFFF;
    	color: #2960db;

    	width: 173px;
    	height: 48px;
    	border-radius: 6px;
    	font: normal normal medium 16px/19px SF Pro;
    }

    .foot_logo a{
    	vertical-align: 4px;
    }
    .post_order_info .panel-title > a {
    	display: block;
    	padding: 18px 25px;
    	position: relative;
    	color: #555;
    }
    .post_order_info .panel-title > a i{
    	position: absolute;
        right: 11px;
        font-size: 32px;
        top: 12px;
    }
    .panel-heading a[aria-expanded = "true"] .fa-angle-down::before{
    	content: "\f106" ;
    }
    .post_order_info .panel-body .radio_box li{
    	float: none;
    	width: 100%;
    }
    .post_order_info .panel-body .radio_box {
    	margin-bottom: 12px;
    }
    .post_order_info .panel-body {
    	padding: 20px 40px;
    }
    .post_order_info .panel-title > a[aria-expanded = "true"]{
    	background: #000;
    	color: #fff;
    }
    .post_order_info .panel-group {
        margin-bottom: 0;
    }



    /*Innerpage Css Start*/

    .inner_page .hp_cards{
    	margin-top: 42px;
    }
    .inner_page .hp_cards_info h5{
     	font-size: 15px;
        margin: 9px 0 0;
    	border-bottom: 1px solid #CFD4D6;
    	/*color: #000;*/
    	padding-bottom: 21px;
    	padding-left: 35px;
    	font-weight: 400;
    }
    .inner_page .hp_cards_info{
    	padding: 17px 15px 1px;
    	background: #fff;
    	border-radius: 10px 10px 0px 0px;
    	-webkit-border-radius: 10px 10px 0px 0px;
    }
    .inner_page .hp_cards_info h5 i.fa-cube,.inner_page .hp_cards_info h5 i{
    	margin-right: 8px;
    	font-size: 22px;
    }
    .inner_page .hp_cards_info h5 a i{
    	margin-right: 5px;
    	font-size: 25px;
    	margin-top: 1px;
    	position: relative;
    	top: 2px;
    }
    .inner_page .hp_cards_info h5 a{
    	font-size: 16px;
    	color: #285ddb;
    }
    .inner_page .hp_cards_info h5 a:hover,.inner_page .hp_cards_info h5 a:focus{
    	text-decoration: none;
    	color: #285ddb;
    }
    .inner_page .hp_cards_info .mb-20{
    	margin-top: 20px;
    	margin-bottom: 20px;
    }
    .right_info{
    	width: 65%;
    	word-break: break-word;
    	color: #737373;
    }
    .orange_text{
    	color: #F28419;
    }
    .courier_info span,.courier_info a{
    	display: block;
    }
    .courier_info{
    	background: #fff;
    	padding: 23px 23px 0px 18px;
    }
    .courier_logo{
    	/* background-color: #ddd; */
    	background-size: contain;
    	-webkit-background-size: contain;
    	border-radius: 5px;
        width: 75px;
        height: 65px;
    	margin-right: 15px;
    }
    .courier_info span:first-child{
    	margin-bottom: 5px;
    	margin-top: 18px;
    }
    .tracking_id{
    	color: #285ddb;
    }
    .courier_info a,.courier_info a:focus,.courier_info a:hover{
    	text-decoration: none;
    	color: #285ddb;
    }
    .delievery_info{
    	padding: 25px 15px 25px;
    	position: relative;
    	background: #fff;
    	overflow: hidden;
    	border-radius: 0 0 10px 10px;
    	-webkit-border-radius: 0 0 10px 10px;
    	margin-bottom: 45px;
    }
    .delievery_info ul{
    	padding: 0;
    	width: 76%;
    	float: right;
    	margin: 0;
    }
    .delievery_info li{
    	list-style: none;
    	background: #fff;
    	padding: 24px 0px;
    	/* border-bottom: 1px solid #e8e8e8; */
    	position: relative;
    	margin-right: 10px;
    }
    .delievery_info li:last-child{
    	margin-bottom: 0;
    }
    .delievery_info li span:first-child{
    	display: block;
    	margin-bottom:12px;
    }
    .delievery_info li span span{
    	display: inline;
    }
    .status_cont {
    max-width: 100%;
    display: flex;
    align-items: center;
    column-gap: 10px;
}
    .date_info_wrap{
    	position: absolute;
    	left: -170px;
    	top: 28px;
    	text-align: right;
    	font-size: 13px;
    }
    .date_info_wrap .date{
    	color: #434343;
    	font-weight: bold;
    	font-size: 14px;
    	text-transform: uppercase;
    }
    .date_info_wrap .time{
    	color: #454545;
    }

    /*.delievery_info li:before{.delievery_info li:after
    	content: '';
    	display: inline-block;
    	position: absolute;
    	left: -25px;
    	top: 32px;
    	background-image: url(../img/card_arrow.png);
    	background-repeat: no-repeat;
    	height: 35px;
    	width: 33px;
    }*/
    .delievery_info li .date_info_wrap span:first-child{
    	margin-bottom:1px;
    }
    /* .delievery_list_wrap{
    	max-height: 220px;
        overflow-y: auto;
    } */
    .delievery_info li activity{
    	color: #737373;
    }

	.delievery_info li:after {
    content: '';
    height: 100%;
    width: 2px;
    display: block;
    position: absolute;
    left: -36px;
    top: 59px;
    z-index: 0;
    border: 1px dashed #0e9804;
}
    .delievery_info li.active .circle_icon{
    	border: 3px solid white;
    }
    .delievery_info li:last-child:after{
    	display: none;
    }
    .circle_icon {
    height: 16px;
    width: 16px;
    position: absolute;
    left: 0;
    border: 3px solid #0e9804;
    box-shadow: 0 0 2px #a8a8a8;
    display: block;
    left: -43px;
    border-radius: 50%;
    background: #fd8903;
    z-index: 0;
    top: 42px;
}
    .delievery_info li.active .circle_icon{
    	background: #18F040;
    }
    .delievery_info li.active span span{
    	color: #1EA231;
    }
    .check_delievery{
        font-size: 46px;
        color: #1EA231;
        width: 34px;
        height: 40px;
        display: inline-block;
        background: url(../img/sprite.png?v=1) no-repeat;
        background-position: -135px -1px;
        vertical-align: middle;
    }
    /*.delievery_info li.active .check_delievery{
    	opacity: 1;
    }*/
    .error_delivery{
        font-size: 46px;
        color: #1EA231;
        width: 34px;
        height: 40px;
        display: inline-block;
    	color: #1EA231;
    	background: url(../img/sprite.png?v=1) no-repeat;
    	background-position: -181px -2px;
    	vertical-align: middle;
    }
    .recommend_info{
    	background: #fff;
    	padding: 18px 16px 25px;
    	border-radius: 10px;
    	-webkit-border-radius: 10px;
    	margin-bottom: 30px;
    	margin-top: 30px;
    }
    .recommend_info p{
    	font-size: 15px;
    	line-height: 1.2;
    	margin-bottom: 3px;
    	font-weight: 400;
    }
    .recommend_info .pagination li a{
    	background: #fff;
    	border-radius: 50%;
    	font-size: 16px;
    	padding: 7px;
    	color: #000;
    	width: 35px;
    	height: 35px;
    	display: block;
    	text-align: center;
    	-webkit-transition: width 0.3s; /* Safari */
        transition: width 0.3s;
    }
    .recommend_info .pagination li a.red{
    	border-color: #cc3a29;
    }
    .recommend_info .pagination li.active a.red,.recommend_info .pagination li a.red:hover{
    	border-color: #cc3a29;
    	background: #cc3a29;
    	color: #fff;
    }


    .recommend_info .pagination li a.yellow{
    	border-color: #f7b336;
    }
    .recommend_info .pagination li.active a.yellow,.recommend_info .pagination li a.yellow:hover{
    	border-color: #f7b336;
    	background: #f7b336;
    	color: #fff;
    }

    .recommend_info .pagination li a.green{
    	border-color: #71d53a;
    }
    .recommend_info .pagination li.active a.green,.recommend_info .pagination li a.green:hover{
    	border-color: #71d53a;
    	background: #71d53a;
    	color: #fff;
    }

    /*.recommend_info .pagination li.active a,.recommend_info .pagination li a:hover,.recommend_info .pagination li a:focus
    {
    	background:#000;
    	color: #fff;
    }*/
    .recommend_info .pagination li {
    	margin-right: 10px;
    	display: inline-block;

    }
    .recommend_info .pagination li:last-child{
    	margin-right: 0;
    }
    .extremely_arrow i,.likely_arrow i{
    	display: block;
    	font-size: 26px;
    	padding-left: 10px;
    	margin-bottom: 5px;
    }
    .extremely_arrow,.likely_arrow{
    	color: #555;
    	display: inline-block;
    	cursor: default;
    	/*margin: 0 15%;*/
    }
    .likely_arrow{
    	float: right;
    	text-align: right;
    }
    .nps_pagination .arrow_wrap_pagination a.extremely_arrow {
        float: left;
        text-align: left;
    }
    .extremely_arrow:hover,.likely_arrow:hover{
    	text-decoration: none;
    	color: #555;
    }
    .likely_arrow i{
    	padding-right: 7px;
    }
    .recommend_info .pagination{
    	margin-bottom: 0;
    }
    .arrow_wrap_pagination{
    	margin-bottom: 12px;
    	margin-top: 5px;
    }
    .recommend_info label{
    	font-weight: 700;
    	display: block;
    	margin-bottom: 7px;
    }
    .recommend_info  input {
       width: 100%;
       height: 40px;
       line-height: 40px;
    	padding: 0 20px;
    	background: #f2f2f2;
    	border: none;
    	border-radius: 10px;
    	-webkit-border-radius: 10px;
    	margin-bottom: 27px;
    	color: #a4a4a4;
    }
    .recommend_info  button{
    	font-size: 16px;
    	min-width: 200px;
    	height: 45px;
    	line-height: 45px;
    	font-weight: 700;
    	padding: 0;
    	color: #fff;
    	border-radius: 5px;
    }
    .recommend_info  button:hover{
    }
    .recommend_info  button:hover,.recommend_info  button:focus,.signup_now  button:hover,.signup_now  button:focus{
    	color: #fff;
    }
    .signup_now{
    	padding: 20px 20px 17px;
    	background: #fff;
    	border-radius: 10px;
    	-webkit-border-radius: 10px;
    	margin-bottom: 45px;
    }
    .signup_now i.fa-mobile{
    	font-size: 0px;
    	background: url(../img/sprite.png?v=1) no-repeat;
    	background-position: 0px 0px;
    	width: 39px;
    	height: 42px;
    	position: absolute;
    	left: 29px;
    	top: 27px;
    }
    .share{
    	background: url(../img/sprite.png?v=1) no-repeat;
    	background-position: -47px 0px;
    	width: 30px;
    	height: 35px;
    	display: block;
    }
    .share_icon_wrap{
    	margin: 5px 9px 0;
    }
    .signup_now  span{
    	font-size: 16px;
    	margin-left: 40px;
    	color: #000;
    	margin-top: 16px;
    	display: inline-block;
    }
    .signup_now  button{
       font-size: 16px;
    	min-width: 200px;
    	height: 47px;
    	line-height: 47px;
    	font-weight: 700;
    	padding: 0;
    	color: #fff;
    	border-radius: 5px;
    	margin-top: -3px;
    }
    .signup_now  button:hover{
    }

    .signup_now  label{
    	background: #f2f2f2;
    	padding: 10px 15px;
    	border-radius: 5px;
    	margin-right: 20px;
    }
    .signup_now  label i{
    	font-style: normal;
    	color: #555;
    	font-size: 18px;
    	font-weight: 400;
    }
    .signup_now  label input{
    	background: transparent;
    	border: none;
    	width: 190px;
    }
    .signup_now label i.plus{
    	font-weight: 700;
    	vertical-align: 1px;
    }
    .banner_section{
    	margin-bottom: 20px;
    }
    .banner_section img{
    	width: 100%;
    	border-radius: 10px;
    	-webkit-border-radius: 10px;
    }
    .delievery_status span,.delievery_status strong{
    	display: block;
    }
    .delievery_status span{
    	margin-bottom: 10px;
    	font-weight: normal;
    	font-size: 14px;
    }

    .delievery_status strong{

    }
    .delievery_status .edd_day{
        font-weight: bold;
        font-size: 20px;
    }
    .delievery_status .edd_date{
    	font-size: 100px;
        line-height: 100px;
        font-weight: normal;
    }
    .delievery_status .edd_month_new{
    	display: inline;
    	font-size: 22px;
    	padding-left: 5px;
    	vertical-align: text-bottom;
    }
    .delievery_status .edd_month{
        font-size: 16px;
    }
    @media   (max-width: 912px){
    	.delievery_status #shipment_status{
    		font-size: 30px !important;
    	}
    }
    @media   (max-width: 280px){
    	.delievery_status #shipment_status{
    		font-size: 22px !important;
    	}
    }
	.delievery_status #shipment_status {
    font-size: 38px;
    font-weight: normal;
    margin-top: 10px;
    margin: 0px 0px;
    line-height: 38px;
}

    .delievery_status strong + span{
    	font-size: 20px;
    	color: #000;
    }
    .active_delivery{
    	color: #1EA231 !important;
    }
    .red_color{
    	color: #c81717 !important;
    }
    .info_color{
    	color: #e8ac1a !important;
    }

    .delievery_status{
    	border-bottom: 1px solid #CFD4D6;
    	padding-bottom: 21px;
    	margin-bottom: 0 !important;
    }
    .information_block .hp_cards_info{
    	border-radius:10px;
    	-webkit-border-radius: 10px;
    	position: relative;
    	padding-bottom: 2px;
    }
    .information_block .hp_cards_info span,.information_block .hp_cards_info strong{
    	font-size: 13px;
    }

    .order_detail_icon{
    	width: 25px;
    	height: 27px;
    	background: url(../img/Box.png) no-repeat;
    	display: inline-block;
    	position: absolute;
    	left: 16px;
    	top: 21px;
    }
    .cta_btn_wrap{
    	float: left;
        display: block;
        width: 100%;
        /*margin: 16px 0 13px;*/
     }
     .cta_btn_wrap a{
     	font-size: 18px;
     	color: white;
     }
    .cta_btn_wrap button{
    	font-size: 16px;
    	width: 100%;
    	height: 45px;
    	line-height: 45px;
    	font-weight: 700;
    	padding: 0;
    	color: #fff;
    	border-radius: 5px;
    	border: none;
    }
    .cta_btn_wrap button:hover,.cta_btn_wrap button:focus{
    	color: #fff;
    }
    .success_icon{
    	background: url(../img/spritee.png?v=1) no-repeat;
    	background-position: -232px -3px;
    	width: 55px;
    	height: 64px;
    	display: block;
    	margin:0 auto 20px;
    }
    .success_info strong{
    	display: block;
    	font-size: 38px;
    	margin-bottom: 15px;
    	font-weight: 500;
    }
    .success_info{
    	padding: 81px 20px 83px;
    }
    .success_info span{
    	font-size: 16px;
    	color: #737373;
    }
    .foot_logo img{
     	width: 50%;
     	margin-top: 4px;
    }
    #shipment_status_label {
    margin-bottom: 0px !important;
    margin-top: 0px !important;
}

    .nps_pagination .arrow_wrap_pagination{
    	width: 507.84px;
        margin: 0 auto;
    }
    .edd_info{
    	float: left;
        width: 173px;
        position: relative;
        margin-right: 55px;
    }
    .edd_info:last-child{
    	margin-right: 0;
    }
    .divider_date{
    	background: #000;
        height: 3px;
        width: 20px;
        display: block;
        position: absolute;
        top: 65%;
        right: -10px;
    }
    .delievery_status span.year_txt{
    	display: inline-block;
    	line-height: 0px;
    	color: #333333;
    }
    .mt-15{
    	margin-top:15px;
    }
    .db{
    	display: block;
    }
    @media(max-width: 506px){
    	.multiple_date .edd_info {
        	width: 111px;
        	margin-right: 12px;
    	}
    	.multiple_date .edd_date{
    		font-size: 60px;
    	}
    	.multiple_date .edd_info:last-child{
    		margin-right: 0;
    	}
    	.multiple_date .divider_date{
    		top: 60%;
        	right: -1px;
    	}
    }
    @media (min-width: 768px) and (max-width: 1200px){
    	.multiple_date .edd_info {
        	width: 126px;
        	margin-right: 30px;
    	}
    	.multiple_date .edd_info:last-child{
    		margin-right: 0;
    	}
    	.multiple_date .edd_date{
    		font-size: 72px;
    	}
    	.multiple_date .divider_date{
        	right: -16px;
    	}

    }

    .rushedtwgt{
    	display: flex;
    	align-items: center;
    	min-height: 80px;
    	margin: -1% 0 15px;
    	padding: 0 40px 0 0;
    	color: #FFFFFF;
    	background: #361E74;
    	border-radius: 15px;
    	-webkit-border-radius: 15px;
    }
    @media (max-width: 768px){
    	.rushedtwgt{
    		margin: 0 0 10px 0;
    	}
    }

    .loader{
    	background: rgba(0,0,0,0.6);
    	position: fixed;
    	width: 100%;
    	height: 100%;
    	left: 0;
    	top: 0;
    	z-index: 9;
    	display:-webkit-flex;
    	display: -webkit-flexbox;
        display:-webkit-box;
        display:-moz-flex;
        display:-moz-box;
        display:-ms-flexbox;
        display:flex;
    	align-items: center;
    	justify-content: center;
    	color: #fff;
    	display: none;
    }
    .loader-container{
    	padding: 15px;
    	background: #000;
    	border-radius: 4px;
    }
    .loader-container img{
    	margin-right: 5px;
    }

    .rushedtspan {
    	display: table-cell !important;
    	vertical-align: middle !important;
    	font-size: 18px !important;
    	white-space: pre;
    }
    @media(max-width: 1200px){
    	.rushedtspan {
    		display: table-cell !important;
    		vertical-align: middle !important;
    		font-size: 18px !important;
    		white-space: normal;
    	}
    }

    .rushedtlogo{
    	margin: 0 15px;
    	max-height: 30px !important;
    }
    @media(max-width: 506px){
    	.rushedtlogo{
    		margin: 0 10px;
    		max-width: 80px !important;
    	}
    	.rushedtspan {
    		font-size: 15px !important;
    	}
    }

    .status_calendar_image {
    	background-color: #fff;
        padding: 8px;
        border-radius: 7px;
        margin-right: 24px;
    }
    </style>
    <div class="row">
    				<!-- tracking card -->
    				<div class="col-12">
    					
    					<div class="">





    																			<div class="delievery_info pt-0 ulli_border">

    							<div class="delievery_list_wrap clearfix" style="margin-top: -18px">
    								<ul>
                      <?
                      if(isset($response->tracking_data->shipment_track_activities)){
                        foreach ($response->tracking_data->shipment_track_activities as $shipment_track_activities) {
                          	   ?>
                        <li>
          <span class="fs-12px SFProMedium"><b>Activity : </b>  <activity><?=$shipment_track_activities->activity?></activity></span>
            <span class="fs-12px SFProMedium"><b>Location : </b>  <activity><?=$shipment_track_activities->location?></activity></span>
            <!-- Delivered or RTO delivered -->
            <!-- undelivered -->
            <div style="padding-left: 5px;" class="date_info_wrap fs-12px SFProMedium">
              <?
               $time=strtotime($shipment_track_activities->date);
               $month=date("F",$time);
               $day=date("d",$time);
              $d_time =date("h:i a",$time);
              ?>
                  <span class="date"><?=$day?> <?=$month?></span>
    <span class="time"><?=$d_time?></span>
              </div>

    <i class="circle_icon"></i>

    </li>
                        <?
                        }
                     
                      }
                      ?>




    																																		</ul>
    							</div>


    						</div>
    																								</div>
    				</div>
    				<!-- tracking card end-->


    					</div>

    <?
  }else{
    ?>
    <h5 style="color:Red">Shipping Activity Not Found</h5>
    <?
  }
}
else{
  ?>
  <h5 style="color:Red">Shipping Activity Not Found</h5>
  <?
}
?>
