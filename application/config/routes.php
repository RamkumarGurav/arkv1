<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'user';
$route['secureRegions'] = 'secureRegions/login';
$route['siprocket_tracking_response/v1'] = 'webhooks/Shiprocket_tracking_response/tracking_response';
$route['404_override'] = 'User/pageNotFound';
$route['translate_uri_dashes'] = TRUE;
$route[__contactUs__] = 'User/contact';
$route['doContact'] = "user/doContact";
$route[__thanks__] = 'user/thanks';
//$route['contact'] = "user/contact";
$route['about-us'] = "user/about";
$route['faq'] = "user/faq";
$route['doSubscribe'] = "user/doSubscribe";
$route[__privacy_policy__] = "user/privacy_policy";
$route[__terms_conditions__] = "user/terms_conditions";
//$route['servicesold'] = "user/services1";


$route['shipping-policy'] = "user/shipping_policy";
$route['return-policy'] = "user/return_policy";
//$route['cart'] = "user/cart";
$route[__cart__] = 'products/myCart';
$route[__payment__] = 'Payment_Checkout/payment';
$route['payment1'] = 'products/payment1';
$route['payment'] = 'Payment_Checkout/payment';
$route[__orderStatus__] = 'Payment_Checkout/order_status';

$route['do_payment_options'] = 'Payment_Checkout/do_payment_options';
$route['place-order-cod-verify'] = 'Payment_Checkout/place_order_cod_verify';
$route['place-cod-order'] = 'Payment_Checkout/place_cod_order';
$route['pay-now'] = 'Payment_Checkout/pay_now';
$route['pay-now-guest'] = 'Payment_Checkout/pay_now_guest';
$route['order_confirmation'] = 'Payment_Checkout/order_confirmation';
$route['order_confirmation_sc'] = 'Session_Check/order_confirmation_sc';
$route['order_confirmation_cod'] = 'Payment_Checkout/order_confirmation_cod';
$route['order_fail'] = 'Payment_Checkout/order_fail';
$route['payment_verify'] = "Payment_Checkout/payment_verify";
$route['payment_verify_form'] = "user/payment_verify_form";
$route['checkGuestDelivery'] = "Payment_Checkout/checkGuestDelivery";
$route[__removeCoupon__] = 'products/removeCoupon';

$route[__orderFail__] = 'User/orderFail';
$route[__orderAbort__] = 'User/orderAbort';
$route[__orderSuccess__] = 'User/orderSuccess';


$route[__changePassword__] = 'user/change_password';
//$route['dashboard'] = "user/dashboard";
$route[__dashboard__] = 'Dashboard';
$route[__orderDetails__.'/(:num)'] = 'Dashboard/orderDetails/$1';
$route['order_tracking'] = 'Dashboard/order_tracking';
$route[__ReOrder__.'/(:num)'] = 'Dashboard/ReOrder/$1';
$route[__orderHistory__] = 'Dashboard/orderHistory';
$route[__shippingAddress__] = 'Dashboard/shippingAddress';
$route[__reviewRatings__] = 'Dashboard/reviewRatings';
$route[__orderInvoice__.'/(:num)'] = 'Dashboard/orderInvoice/$1';
$route[__profileGSTInformation__] = 'Dashboard/profile_gst';

//$route['order-history'] = "user/order_history";
$route['profile'] = "user/profile";
//$route['shipping-address'] = "user/shipping_address";
$route[__forgotPassword__] = 'user/forgot-password';
//$route['product-list'] = "user/product_list";
//$route['product-details'] = "user/product_details";
$route['order-details'] = "user/order_details";

$route['products-details/(:any)'] = 'products/products_details/$1';
$route['products-details/(:any)/(:any)'] = 'products/products_details/$1/$2';
$route[__featuredProducts__] = 'products/featuredProducts';
$route[__bestSellers__] = 'products/bestSellers';
$route[__whatsNew__] = 'products/whatsNew';
$route['all-products'] = 'products/all_products';
$route['all-products/(:num)'] = 'products/all_products/$1';
$route['all-products/(:num)/(:num)'] = 'products/all_products/$1/$2';
$route['all-products/(:num)/(:num)/(:num)'] = 'products/all_products/$1/$2/$3';
//$route[__cart__] = 'products/myCart';
//$route[__wishlist__] = 'user/wishlist';
//$route[__profileInformation__] = 'Dashboard/profile';
$route[__wishlist__] = 'products/wishlist';
$route[__removeCoupon__] = 'products/removeCoupon';
$route[__all_category__] = 'products/all_category';
$route['404found'] = "user/found404";
$route['reviewnotfound'] = "user/reviewnotfound";
$route['morereviews'] = "user/morereviews";
$route['invoice'] = 'user/invoice';
$route[__signup__] = 'register';
$route[__signup__.'/auth'] = 'register/auth';
//$route[__login__] = 'user/signin';


$route['getState'] = 'Ajax/getState';
$route['getCity'] = 'Ajax/getCity';


$route[__login__] = 'Login';
$route[__login__.'/loginAuth'] = 'Login/loginAuth';

$route[__logout__] = 'user/logout';

$route['siprocket_tracking_response/v1'] = 'webhooks/Shiprocket_tracking_response/tracking_response';
$route['api/v1.0/(:any)'] = 'V1_api/$1';
$route['send_email'] = 'user/google_merchant_center';
global $DB_ROUTES;
if(!empty($DB_ROUTES)) $route = array_merge($route,$DB_ROUTES);
