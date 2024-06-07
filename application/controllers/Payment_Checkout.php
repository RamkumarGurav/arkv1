<?php
include('Main.php');
//$this->data['temp_name'] = $this->session->userdata('application_sess_temp_name');
//$this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');
//$this->data['store_id'] = $this->session->userdata('application_sess_store_id');

class Payment_Checkout extends Main {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();

		//$this->load->library('session');
		$this->load->library('Set_Order_Status_Lib');
		$this->load->library('Add_Update_Data_Lib');
		$this->load->model('Checkout_model');
		$this->load->model('Common_Model');
		$this->load->model('Products_model');
		$this->load->model('Dashboard_model');
		$this->load->helper('common_functions_helper');
		$this->load->helper('url');
		$this->data['message']='';
		$this->data['message1']='';
		$this->session->set_userdata('application_sess_store_id',1);
		 $this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');

		$this->data['login_type'] = $this->session->userdata('application_sess_login_type');
		$redirect=$uriid=$this->uri->segment(1);
		if($redirect!='payment_verify' && $redirect!='pay-now' )
		{
				$this->session->set_userdata('application_sess_redirect' , $redirect);
		}

		//print_r($this->session->userdata());

		//exit;

		if(empty($this->data['temp_id']))
		{
			$sess_temp_id = date("dmYhis");
			if(empty($_COOKIE["application_user"]))
			{
				setcookie("application_user", $sess_temp_id, time() + (86400 * 365), "/");
				$this->session->set_userdata('application_sess_temp_id',$sess_temp_id);
			}
			else
			{
				$this->session->set_userdata('application_sess_temp_id',$_COOKIE["application_user"]);
			}
		}

		$this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');
		$this->data['temp_name'] = $this->session->userdata('application_sess_temp_name');
		$this->data['temp_number'] = $this->session->userdata('application_sess_temp_number');
		$this->data['temp_email'] = $this->session->userdata('application_sess_temp_email');
		$this->data['coupon_code'] = $this->session->userdata('application_sess_coupon_code');
		$this->data['discount'] = $this->session->userdata('application_sess_discount');
		$this->data['store_id'] = $this->session->userdata('application_sess_store_id');
		$this->data['login_type'] = $this->session->userdata('application_sess_login_type');
		$this->data['store_id'] = 1;

		if(!empty($_POST['name']))
		{
			$this->data['temp_name'] = $_POST['name'];
			$this->session->set_userdata('application_sess_temp_name',$_POST['name']);
		}
		if(!empty($_POST['number']))
		{
			$this->data['temp_number'] = $_POST['number'];
			$this->session->set_userdata('application_sess_temp_number',$_POST['number']);
		}
		if(!empty($_POST['email']))
		{
			$this->data['temp_email'] = $_POST['email'];
			$this->session->set_userdata('application_sess_temp_email',$_POST['email']);
		}


		if( empty($this->data['temp_name']) || empty($this->data['temp_id']) )
		{
		    if(!empty($_POST["udf1"]))
		    {
		        $temp_orders_id =$_POST["udf1"];
		    }

			if(!empty($temp_orders_id))
			{
				$page_data = array();
				$tempOrdersDataarr = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"(temp_orders_id=$temp_orders_id and status=0)"));
				//print_r($tempOrdersDataarr);
				if(!empty($tempOrdersDataarr))
				{
					$tempOrderData = $tempOrdersDataarr[0];

					if($tempOrderData->login_type==1)
					{
						$temp_cus_id = $tempOrderData->customers_id;
						$register = $this->Checkout_model->getUser(array('customers_id'=>$temp_cus_id));
						if(!empty($register))
						{
							$this->session->set_userdata('pg_amount',$tempOrderData->total);
							$this->session->set_userdata('pg_temp_orders_id',$tempOrderData->temp_orders_id);

							$this->session->set_userdata('application_sess_temp_id',$register->customers_id);
							$this->session->set_userdata('application_sess_temp_name',$register->name);
							$this->session->set_userdata('application_sess_temp_email',$register->email);
							$this->session->set_userdata('application_sess_login_type','');
							$this->data['temp_id'] = $register->customers_id;
							$this->data['temp_name'] = $register->name;
							$this->data['login_type'] = '';

							$this->data['customers_del_address'] = $this->Common_Model->getName(array('select'=>'c.* ' , 'from'=>'customers_address as c' , 'where'=>"c.delivery_status=1 and  c.customers_id=".$this->data['temp_id'] ));

							$application_post_country_id='';
							$this->data['customers_del_address'] = $this->Common_Model->getName(array('select'=>'c.* ' , 'from'=>'customers_address as c' , 'where'=>"c.delivery_status=1 and  c.customers_id=".$this->data['temp_id'] ));
							if(!empty($this->data['customers_del_address']))
							{
								$this->data['customers_del_address'] = $this->data['customers_del_address'][0];

								$application_post_country_id = $this->data['customers_del_address']->country_id;
								$this->session->set_userdata('application_sess_country_id',$application_post_country_id);
							}
							else
							{
								$application_post_country_id == __const_country_id__;
								$this->session->set_userdata('application_sess_country_id',$application_post_country_id);
							}
							if($application_post_country_id == __const_country_id__)
							$this->session->set_userdata('application_sess_currency_id',1);
							else
							$this->session->set_userdata('application_sess_currency_id',2);
						}
					}
					else
					{
						$this->session->set_userdata('application_sess_temp_id',$tempOrderData->customers_id);
						$this->session->set_userdata('application_sess_temp_name',$tempOrderData->name);
						$this->session->set_userdata('application_sess_temp_email',$tempOrderData->email);
						$this->session->set_userdata('application_sess_temp_number',$tempOrderData->number);
						$this->session->set_userdata('application_sess_login_type','guest');

						$this->data['temp_id'] = $tempOrderData->customers_id;
						$this->data['temp_name'] = $tempOrderData->name;
						$this->data['temp_number'] = $tempOrderData->number;
						$this->data['temp_email'] = $tempOrderData->email;
						$this->data['login_type'] = 'guest';

						$application_post_country_id = $tempOrderData->d_country_id;
						$this->session->set_userdata('application_sess_country_id',$application_post_country_id);

						if($application_post_country_id == __const_country_id__)
						$this->session->set_userdata('application_sess_currency_id',1);
						else
						$this->session->set_userdata('application_sess_currency_id',2);
					}
				}

			}
		}

		if( !empty($this->data['temp_name']) && !empty($this->data['temp_id']) )
		{
			$this->data['user'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));
		//	print_r($this->data['user']);

			if($this->data['user']=='error' && $this->data['login_type'] != 'guest')
			{
				$redirect=$uriid=$this->uri->segment(1);
				$this->session->set_userdata('application_sess_redirect' , $redirect);
				$this->session->set_userdata('application_sess_temp_id','');
				$this->session->set_userdata('application_sess_temp_name','');
				$this->session->set_userdata('application_sess_coupon_code','');
				$this->session->set_userdata('application_sess_discount','');
				$this->session->set_userdata('application_sess_temp_number','');
				$this->session->set_userdata('application_sess_login_type','');

				$this->session->set_flashdata('message', '<div class=" alert alert-success">Please Sign in to continue.</div>');
				REDIRECT(base_url().__login__);

			}
		}
		else
		{
			/*$this->session->set_userdata('application_sess_temp_id','');
			$this->session->set_userdata('application_sess_temp_name','');
			$this->session->set_userdata('application_sess_coupon_code','');
			$this->session->set_userdata('application_sess_discount','');
			$this->session->set_userdata('application_sess_temp_number','');
			$this->session->set_userdata('application_sess_login_type','');

			$this->session->set_flashdata('message', '<div class=" alert alert-success">Please Sign in to continue.</div>');
			REDIRECT(base_url().__login__);*/
		}


		$this->method_name = 'payment';
		if(empty($this->data['user']->address) && $this->data['login_type'] != 'guest')
		{
			if($this->method_name!='payment')
			{
				$this->session->set_flashdata('message1', '<div class=" alert alert-warning">You have not entered any address.</div>');
				REDIRECT(base_url().__shippingAddress__);
			}
		}

		$this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');
		$this->data['temp_name'] = $this->session->userdata('application_sess_temp_name');
		$this->data['coupon_code'] = $this->session->userdata('application_sess_coupon_code');
		$this->data['discount'] = $this->session->userdata('application_sess_discount');
		$this->data['store_id'] = $this->session->userdata('application_sess_store_id');
		$this->data['coupon_code'] = $this->session->userdata('application_sess_coupon_code');
		$this->data['discount'] = $this->session->userdata('application_sess_discount');
		//$this->session->set_userdata('application_sess_coupon_code','qwerty');
		//this->session->set_userdata('application_sess_discount','10');

		//$this->data['merchant_key'] = "2PBP7IABZ2";
		//$this->data['merchant_salt'] = "DAH88E3UWQ";

		$this->data['merchant_key'] = "0KEWA850BU";
		$this->data['merchant_salt'] = "E28O3BINEE";

		if($this->data['login_type'] != 'guest')
		{
			$this->data['customers_del_address'] = $this->Common_Model->getName(array('select'=>'c.* ' , 'from'=>'customers_address as c' , 'where'=>"c.delivery_status=1 and  c.customers_id=".$this->data['temp_id'] ));
			if(!empty($this->data['customers_del_address']))
			{
				$this->data['customers_del_address'] = $this->data['customers_del_address'][0];
			}
		}
		$this->session->set_userdata('application_sess_currency_id',1);
		$this->session->set_userdata('application_sess_country_id',__const_country_id__);
		/*$application_post_country_id = $this->data['customers_del_address']->country_id;
		$this->session->set_userdata('application_sess_country_id',$application_post_country_id);
		if($application_post_country_id == __const_country_id__)
		$this->session->set_userdata('application_sess_currency_id',1);
		else
		$this->session->set_userdata('application_sess_currency_id',2);*/

		if(empty($this->data['coupon_code'])){$this->data['coupon_code']=0;}
		if(empty($this->data['discount'])){$this->data['discount']=0;}
		$this->data['currency'] = parent::setCurrency(array());
		//print_r($this->data['currency']);
		//print_r($this->data['user']);
		$current_delivery_country = '';
		if($this->data['login_type'] != 'guest' && !empty($this->data['user']))
		{
			foreach($this->data['user']->address as $add){
				if($add->delivery_status==1){
					$current_delivery_country = $add->country_id;
				}
			}
		}


		$this->_sosl = $this->data['_sosl'] = new Set_Order_Status_Lib();
		$this->_audl = $this->data['_audl'] = new Add_Update_Data_Lib();
		$this->is_order_cod = $this->data['is_order_cod'] = false;


		if($this->data['login_type'] != 'guest' && false)
		{
			if($this->data['user']->is_email_verify != 1 || $this->data['user']->is_contact_verify != 1)
			{
				REDIRECT(base_url().__contact_email_verify__);
			}
		}

		$this->load->helper('form');
		$this->load->library('form_validation');


	}

	function order_status()
	{
		//$orders_id = (!empty($this->session->flashdata('orders_id')))?$this->session->flashdata('orders_id'):5;
		$orders_id = $this->session->flashdata('orders_id');
//		$orders_id = 37;

		if(empty($orders_id))
		{
			REDIRECT(base_url());
		}
		$this->session->set_flashdata('orders_id', $orders_id);
		$this->session->flashdata('orders_id');
		//echo $orders_id;

		$this->data['orders'] = $this->Checkout_model->getOrder(array("orders_id"=>$orders_id, "customers_id"=>$this->data['temp_id']));
		if(empty($this->data['orders']))
		{
			REDIRECT(base_url());
		}
			//echo $this->db->last_query();
			//print_r($this->data['orders']);

			$o=$this->data['orders'] = $this->data['orders'][0];

		parent::getHeader('header' , $this->data);
			$this->load->view('order_confirmation',$this->data);
			parent::getFooter('footer' , $this->data);
	}

	function checkGuestDelivery()
	{
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/

		$product_ids = '';
		$product_combination_ids = '';

		$this->data['distinct_product_id_in_cart'] = $this->Common_Model->temp_cart('distinct_product_id_in_cart','','' , '' , '', '', $this->data['temp_id'], $this->data['store_id']);

		if(empty($this->data['distinct_product_id_in_cart']))
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Yout cart is empty.</div>');
			echo '<div class=" alert alert-warning">Yout cart is empty.</div>';
			exit;
			//REDIRECT(base_url().__cart__);
		}
		//print_r($this->data['distinct_product_id_in_cart']);
		foreach($this->data['distinct_product_id_in_cart'] as $col){$product_ids.=$col['product_id'].',';$product_combination_ids.=$col['product_combination_id'].',';}
		$product_ids = trim($product_ids , ',');$product_combination_ids = trim($product_combination_ids , ',');

		$this->data['products_list']=$this->Products_model->productsSearch('products_list_group','', '', $this->data['temp_id'], $this->data['store_id'], $product_ids, $product_combination_ids);

	//	print_r($this->data);
		$this->load->view('templates/checkGuestDelivery',$this->data);
	}

	function payment()
	{
		if($this->data['login_type'] == 'guest')
		{



			$this->paymentGuestClient();
		}
		else
		{



			$this->paymentAppClient();
		}
	}

	function paymentAppClient()
	{
		$this->data['country'] = $this->Common_Model->getCountry();
		$options = array();
		$options = array('' => 'Select Country');
		if(!empty($this->data['country']))
		{
			foreach($this->data['country'] as $c)
			{
				$options[$c->country_id]  = $c->country_name.'( '.$c->country_code.' )';
			}
		}
		$this->data['options'] = $options;
		$this->data['isDisplayCart'] = 'no';
		$product_ids = '';
		$product_combination_ids = '';
		/*if( empty($this->data['temp_name']) || empty($this->data['temp_id']) )
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Please login with your account to place the order.</div>');
			REDIRECT(base_url().__login__);
		}*/

		/*if(empty($this->data['user']->address))
		{
			$this->session->set_flashdata('message1', '<div class=" alert alert-warning">You have not entered any address.</div>');
			REDIRECT(base_url().__shippingAddress__);
		}*/

		$check_delivery_status = false;
		$check_billing_status = false;

		/*foreach($this->data['user']->address as $add)
		{
			if($add->delivery_status==1){ $check_delivery_status = true; }
			if($add->billing_status==1){ $check_billing_status = true; }
		}*/

		/*if(empty($this->data['user']->number))
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Please add contact number.</div>');
			REDIRECT(base_url().__profileInformation__);
		}

		if(!$check_delivery_status)
		{
			$this->session->set_flashdata('message1', '<div class=" alert alert-warning">You have not selected shipping address.</div>');
			REDIRECT(base_url().__shippingAddress__);
		}

		if(!$check_billing_status)
		{
			$this->session->set_flashdata('message1', '<div class=" alert alert-warning">You have not selected billing address.</div>');
			REDIRECT(base_url().__shippingAddress__);
		}*/

		$this->data['distinct_product_id_in_cart'] = $this->Common_Model->temp_cart('distinct_product_id_in_cart','','' , '' , '', '', $this->data['temp_id'], $this->data['store_id']);

		if(empty($this->data['distinct_product_id_in_cart']))
		{

			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Yout cart is empty.</div>');
			REDIRECT(base_url().__cart__);
		}

		//print_r($this->data['distinct_product_id_in_cart']);
		foreach($this->data['distinct_product_id_in_cart'] as $col){$product_ids.=$col['product_id'].',';$product_combination_ids.=$col['product_combination_id'].',';}
		$product_ids = trim($product_ids , ',');$product_combination_ids = trim($product_combination_ids , ',');

		$this->data['products_list']=$this->Products_model->productsSearch('products_list_group','', '', $this->data['temp_id'], $this->data['store_id'], $product_ids, $product_combination_ids);

		/*if(empty($this->data['user']->address))
		{
			$this->session->set_flashdata('message1', '<div class=" alert alert-warning">You have not entered any address.</div>');
			REDIRECT(base_url().__shippingAddress__);
		}*/
		$this->data['js'] = array(  );
	//	print_r($this->data);

		parent::getHeader('header' , $this->data);
		$this->load->view('payment2',$this->data);
		parent::getFooter('footer' , $this->data);
		/*parent::getHeader('header' , $this->data);
		$this->pay_now();
		parent::getFooter('footer' , $this->data);*/
	}
public function refreshCheckoutPrices()
{

	$product_ids = '';
	$product_combination_ids = '';
			$this->data['distinct_product_id_in_cart'] = $this->Common_Model->temp_cart('distinct_product_id_in_cart','','' , '' , '', '', $this->data['temp_id'], $this->data['store_id']);

			if(empty($this->data['distinct_product_id_in_cart']))
			{
				$this->session->set_flashdata('message', '<div class=" alert alert-warning">Yout cart is empty.</div>');
				REDIRECT(base_url().__cart__);
			}
			//print_r($this->data['distinct_product_id_in_cart']);
			foreach($this->data['distinct_product_id_in_cart'] as $col){$product_ids.=$col['product_id'].',';$product_combination_ids.=$col['product_combination_id'].',';}
			$product_ids = trim($product_ids , ',');$product_combination_ids = trim($product_combination_ids , ',');

			$ship_details = '';
			$Dcount=0;
			$delivery_pin_code='';
			$delivery_city_id='';

			if(!empty($this->data['user']->address))
			foreach($this->data['user']->address as $add){$Dcount++;


			if($add->delivery_status==1){

			  $delivery_pin_code = $add->zipcode;
			  $delivery_city_id = $add->city_id;
			  break;
			}}

			// if(!empty($delivery_pin_code))
			// {
			//
			//   //include(APPPATH.'controllers/Main.php');
			//   //$mainclass = new Main();
			//   $ship_details = parent::getDeliveryPrice(array('total_weight'=>$total_weight , 'delivery_pin_code'=>$delivery_pin_code , 'delivery_city_id'=>$delivery_city_id , 'order_total'=>$total));
			// }
			//print_r($ship_details);


			$this->data['products_list']=$this->Products_model->productsSearch('products_list_group','', '', $this->data['temp_id'], $this->data['store_id'], $product_ids, $product_combination_ids);
			$html  = $this->load->view('template/cart-summary-price',$this->data,true);
			$html2  = $this->load->view('template/payment-options',$this->data,true);

			echo json_encode(array('html'=>$html,'html2'=>$html2));
			die;
}
	function paymentGuestClient()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->data['country'] = $this->Dashboard_model->getCountry();
		$options = array();
		$options = array('' => 'Select Country  *');
		if(!empty($this->data['country']))
		{
			foreach($this->data['country'] as $c)
			{
				$options[$c->country_id]  = $c->country_name.'( '.$c->country_code.' )';
			}
		}
		$this->data['options'] = $options;
		$this->data['countryOptions'] = $options;
		$this->data['isDisplayCart'] = 'no';
		$product_ids = '';
		$product_combination_ids = '';
		if( empty($this->data['temp_name']) || empty($this->data['temp_id']) )
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Please login with your account to place the order.</div>');
			REDIRECT(base_url().__login__);
		}



		$this->data['distinct_product_id_in_cart'] = $this->Common_Model->temp_cart('distinct_product_id_in_cart','','' , '' , '', '', $this->data['temp_id'], $this->data['store_id']);

		if(empty($this->data['distinct_product_id_in_cart']))
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Yout cart is empty.</div>');
			REDIRECT(base_url().__cart__);
		}
		//print_r($this->data['distinct_product_id_in_cart']);
		foreach($this->data['distinct_product_id_in_cart'] as $col){$product_ids.=$col['product_id'].',';$product_combination_ids.=$col['product_combination_id'].',';}
		$product_ids = trim($product_ids , ',');$product_combination_ids = trim($product_combination_ids , ',');

		$this->data['products_list']=$this->Products_model->productsSearch('products_list_group','', '', $this->data['temp_id'], $this->data['store_id'], $product_ids, $product_combination_ids);

	//	print_r($this->data);
		parent::getHeader('header' , $this->data);
		$this->load->view('payment_guest',$this->data);
		parent::getFooter('footer' , $this->data);
		/*parent::getHeader('header' , $this->data);
		$this->pay_now();
		parent::getFooter('footer' , $this->data);*/
	}

	function resend_otp()
	{
		//application_sess_temp_name
		$contact = '';
		$name = '';
		if(!empty($this->data['user']) && $this->data['login_type'] != 'guest')
		{
			$contact = $this->data['user']->number;
			$name = $this->data['user']->name;
		}
		else if($this->data['login_type'] == 'guest')
		{
			$contact = $this->session->userdata('application_sess_temp_number');
			$name = $this->session->userdata('application_sess_temp_name');
		}



		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'order_cod'));
		if(!empty($is_exist_otp))
		{
			$exist_otp_data = $is_exist_otp[0];
			$otp = $exist_otp_data->otp;
		}
		else
		{
			$otp = $this->Common_Model->random_password(6 , 'number');
			$add_new_otp_log_params = array('otp'=>$otp , 'contact'=>$contact , 'otp_for'=>'order_cod');
			$this->_audl->add_new_otp_log($add_new_otp_log_params);
		}

		$template = "{$otp} is the verification code to log in to your "._brand_name_." account. DO NOT share this code with anyone including delivery agents. "._project_web_." #{$otp}";
		$this->Common_Model->send_sms($contact , $template);

	}

	function place_order_cod_verify()
	{
		//application_sess_temp_name
		$contact = '';
		$name = '';
		if(!empty($this->data['user']) && $this->data['login_type'] != 'guest')
		{
			$contact = $this->data['user']->number;
			$name = $this->data['user']->name;
		}
		else if($this->data['login_type'] == 'guest')
		{
			$contact = $this->session->userdata('application_sess_temp_number');
			$name = $this->session->userdata('application_sess_temp_name');
		}

		if(empty($contact))
		{
			//$this->load->library('session');
			$this->session->set_userdata('application_sess_temp_id','');
			$this->session->set_userdata('application_sess_temp_name','');
			$this->session->set_userdata('application_sess_login_type','');
			$this->session->set_userdata('application_sess_temp_number','');
			$this->session->set_userdata('application_sess_temp_email','');
			$this->session->set_userdata('application_sess_coupon_code','');
			$this->session->set_userdata('application_sess_discount','');
			$this->session->set_userdata('application_sess_redirect','');
			$this->session->set_flashdata('message', '<div class=" alert alert-success">Something went wrong. Please try again</div>');
			$this->session->set_userdata('application_sess_temp_id',$_COOKIE["application_user"]);
			REDIRECT(base_url(__login__));
		}
		$this->data['isDisplayCart'] = 'no';
		$product_ids = '';
		$product_combination_ids = '';
		if( empty($this->data['temp_name']) || empty($this->data['temp_id']) )
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Please login with your account to place the order.</div>');
			REDIRECT(base_url().__login__);
		}

		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'order_cod'));
		if(!empty($is_exist_otp))
		{
			$exist_otp_data = $is_exist_otp[0];
			$otp = $exist_otp_data->otp;
		}
		else
		{
			$otp = $this->Common_Model->random_password(6 , 'number');
			$add_new_otp_log_params = array('otp'=>$otp , 'contact'=>$contact , 'otp_for'=>'order_cod');
			$this->_audl->add_new_otp_log($add_new_otp_log_params);
		}


		//$contact = '8950801168';
		//$template = "Dear $name, your order is confirmed. Your order id is $otp. For more details login to your account "._SMS_BRAND_.".";
		//$template = "Dear user, Use code {$otp} to verify your mobile on "._SMS_BRAND_.".";
		$template = "{$otp} is the verification code to log in to your "._brand_name_." account. DO NOT share this code with anyone including delivery agents. "._project_web_." #{$otp}";
		$this->Common_Model->send_sms($contact , $template);
		//parent::getHeader('header' , $this->data);
		$this->load->view('order_cod_verify',$this->data);
		//parent::getFooter('footer' , $this->data);

	}

	// function place_cod_order()
	// {
	//
	// 	if(!empty($this->data['user']) && $this->data['login_type'] != 'guest')
	// 	{
	// 		$contact = $this->data['user']->number;
	// 		$name = $this->data['user']->name;
	// 	}
	// 	else if($this->data['login_type'] == 'guest')
	// 	{
	// 		$contact = $this->session->userdata('application_sess_temp_number');
	// 		$name = $this->session->userdata('application_sess_temp_name');
	// 	}
	// 	if(!empty($_POST['o_otp']))
	// 	{
	// 		$o_otp = $_POST['o_otp'];
	// 		$is_correct_otp = false;
	// 		$is_exist_otp = $this->_audl->check_exist_otp(array('contact'=>$contact , 'otp_for'=>'order_cod' , 'otp'=>$o_otp));
	// 		if(!empty($is_exist_otp))
	// 		{
	// 			$is_correct_otp = true;
	// 		}
	// 		else
	// 		{
	// 			$this->session->set_flashdata('message', '<div class=" alert alert-warning">You Entered wrong OTP.  Please try again.</div>');
	// 			$is_correct_otp = false;
	// 			//REDIRECT(base_url().__payment__);
	//
	// 		}
	//
	// 			if($this->data['login_type'] == 'guest')
	// 			{
	// 				echo 'sss';
	// 				die;
	//
	// 				$this->form_validation->set_rules('name', 'Name', 'trim|required');
	// 				//$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');
	// 				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
	//
	// 				$this->form_validation->set_rules('nameD', 'Delivery Name', 'trim|required');
	// 				//$this->form_validation->set_rules('numberD', 'Delivery Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');
	// 				$this->form_validation->set_rules('addressD', 'Delivery Address 1', 'trim|required');
	// 				$this->form_validation->set_rules('address2D', 'Delivery Address 2', 'trim');
	// 				$this->form_validation->set_rules('address3D', 'Delivery Address 3', 'trim');
	// 				$this->form_validation->set_rules('country_idD', 'Delivery Country', 'trim|required');
	// 				$this->form_validation->set_rules('state_idD', 'Delivery State', 'trim|required');
	// 				$this->form_validation->set_rules('city_idD', 'Delivery City', 'trim|required');
	// 				$this->form_validation->set_rules('pincodeD', 'Delivery Pincode', 'trim|required');
	//
	// 				$this->form_validation->set_rules('nameB', 'Billing Name', 'trim|required');
	// 				//$this->form_validation->set_rules('numberB', 'Billing Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');
	// 				$this->form_validation->set_rules('addressB', 'Billing Address 1', 'trim|required');
	// 				$this->form_validation->set_rules('address2B', 'Billing Address 2', 'trim');
	// 				$this->form_validation->set_rules('address3B', 'Billing Address 3', 'trim');
	// 				$this->form_validation->set_rules('country_idB', 'Billing Country', 'trim|required');
	// 				$this->form_validation->set_rules('state_idB', 'Billing State', 'trim|required');
	// 				$this->form_validation->set_rules('city_idB', 'Billing City', 'trim|required');
	// 				$this->form_validation->set_rules('pincodeB', 'Billing Pincode', 'trim|required');
	//
	// 				$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');
	//
	// 				if ($this->form_validation->run() == true && $is_correct_otp)
	// 				{
	//
	// 					$this->Common_Model->delete_operation(array("where"=>array('contact'=>$contact , 'otp_for'=>'order_cod' , 'otp'=>$o_otp) , "table"=>'otp_log' ));
	// 					$this->is_order_cod = $this->data['is_order_cod'] = true;
	//
	// 					$this->pay_now_guest();
	// 				}
	// 				else
	// 				{
	// 					echo 'dd';
	// 					die;
	//
	// 					$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	//
	// 					$this->paymentGuestClient();
	// 					return false;
	// 					exit;
	// 				}
	// 			}
	// 			else
	// 			{
	//
	// 				if($is_correct_otp)
	// 				{
	// 					$this->Common_Model->delete_operation(array("where"=>array('contact'=>$contact , 'otp_for'=>'order_cod' , 'otp'=>$o_otp) , "table"=>'otp_log' ));
	// 					$this->is_order_cod = $this->data['is_order_cod'] = true;
	// 					$this->pay_now();
	// 				}
	// 				else
	// 				{
	// 					REDIRECT(base_url().__payment__);
	//
	// 				}
	// 			}
	//
	// 	}
	// 	else
	// 	{
	// 		$this->session->set_flashdata('message', '<div class=" alert alert-danger">Something went wrong. Please try again.</div>');
	// 		REDIRECT(base_url().__cart__);
	// 	}
	// }
	function place_cod_order()
	{

		if(!empty($this->data['user']) && $this->data['login_type'] != 'guest')
		{
			$contact = $this->data['user']->number;
			$name = $this->data['user']->name;
		}
		else if($this->data['login_type'] == 'guest')
		{
			$contact = $this->session->userdata('application_sess_temp_number');
			$name = $this->session->userdata('application_sess_temp_name');
		}


				if($this->data['login_type'] == 'guest')
				{


					$this->form_validation->set_rules('name', 'Name', 'trim|required');
					//$this->form_validation->set_rules('number', 'Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');
					$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');

					$this->form_validation->set_rules('nameD', 'Delivery Name', 'trim|required');
					//$this->form_validation->set_rules('numberD', 'Delivery Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');
					$this->form_validation->set_rules('addressD', 'Delivery Address 1', 'trim|required');
					$this->form_validation->set_rules('address2D', 'Delivery Address 2', 'trim');
					$this->form_validation->set_rules('address3D', 'Delivery Address 3', 'trim');
					$this->form_validation->set_rules('country_idD', 'Delivery Country', 'trim|required');
					$this->form_validation->set_rules('state_idD', 'Delivery State', 'trim|required');
					$this->form_validation->set_rules('city_idD', 'Delivery City', 'trim|required');
					$this->form_validation->set_rules('pincodeD', 'Delivery Pincode', 'trim|required');

					$this->form_validation->set_rules('nameB', 'Billing Name', 'trim|required');
					//$this->form_validation->set_rules('numberB', 'Billing Contact Number', 'numeric|trim|required|min_length[10]|max_length[10]');
					$this->form_validation->set_rules('addressB', 'Billing Address 1', 'trim|required');
					$this->form_validation->set_rules('address2B', 'Billing Address 2', 'trim');
					$this->form_validation->set_rules('address3B', 'Billing Address 3', 'trim');
					$this->form_validation->set_rules('country_idB', 'Billing Country', 'trim|required');
					$this->form_validation->set_rules('state_idB', 'Billing State', 'trim|required');
					$this->form_validation->set_rules('city_idB', 'Billing City', 'trim|required');
					$this->form_validation->set_rules('pincodeB', 'Billing Pincode', 'trim|required');

					$this->form_validation->set_error_delimiters('<div class="error alert alert-danger">', '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="Close">&times;</a></div>');

					if ($this->form_validation->run() == true && $is_correct_otp)
					{

						$this->Common_Model->delete_operation(array("where"=>array('contact'=>$contact , 'otp_for'=>'order_cod' , 'otp'=>$o_otp) , "table"=>'otp_log' ));
						$this->is_order_cod = $this->data['is_order_cod'] = true;

						$this->pay_now_guest();
					}
					else
					{


						$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

						$this->paymentGuestClient();
						return false;
						exit;
					}
				}
				else
				{


						//$this->Common_Model->delete_operation(array("where"=>array('contact'=>$contact , 'otp_for'=>'order_cod' , 'otp'=>$o_otp) , "table"=>'otp_log' ));
						$this->is_order_cod = $this->data['is_order_cod'] = true;
						$this->pay_now();

				}


	}

	function pay_now_guest()
	{


		$this->data['isDisplayCart'] = 'no';
		if( empty($this->data['temp_name']) || empty($this->data['temp_id']) )
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Please login with your account to place the order.</div>');
			REDIRECT(base_url().__login__);
		}

		$this->data['distinct_product_id_in_cart'] = $this->Common_Model->temp_cart('distinct_product_id_in_cart','','' , '' , '', '', $this->data['temp_id'], $this->data['store_id']);
		if(empty($this->data['distinct_product_id_in_cart']))
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Yout cart is empty.</div>');
			REDIRECT(base_url().__cart__);
		}

		if(isset($_POST['orderBTN']) || true)
		{
			$product_ids = '';
			$product_combination_ids = '';

			//print_r($this->data['distinct_product_id_in_cart']);
			foreach($this->data['distinct_product_id_in_cart'] as $col){$product_ids.=$col['product_id'].',';$product_combination_ids.=$col['product_combination_id'].',';}
			$product_ids = trim($product_ids , ',');$product_combination_ids = trim($product_combination_ids , ',');

			$this->data['products_list']=$this->Products_model->productsSearch('products_list_group','', '', $this->data['temp_id'], $this->data['store_id'], $product_ids, $product_combination_ids);
			$stock_out_message='';

			foreach($this->data['products_list'] as $col){
			$product_name = $col['name'];
				foreach($col['product_combination'] as $row)
				{
					$combi = $row['combi'];
					$t_stock_out_msg='Sold Out';
					if(!empty($row['stock_out_msg']))
					{
						$t_stock_out_msg = $row['stock_out_msg'];
					}
					if($row['quantity']<=0)
					{
						$stock_out_message .= '<div class=" alert alert-warning">'.$product_name.' - '.$combi.' is '.$t_stock_out_msg.'</div>';
					}
					else if($row['quantity'] < $row['prod_in_cart'])
					{
						$stock_out_message .= '<div class=" alert alert-warning">We have only '.$row['quantity'].' unit of '.$product_name.' - '.$combi.'</div>';
					}
				}
			}
//			echo "<pre>";
//			print_r($this->data['products_list']);
			if(!empty($stock_out_message))
			{
				$this->session->set_flashdata('message', $stock_out_message);
				REDIRECT(base_url().__cart__);
				exit;
			}
			//exit;

			//print_r($this->data);
			$customer_order_note = $this->session->userdata('application_sess_customer_order_note');
			$temp_orders_data['customer_order_note'] = $customer_order_note;
			$temp_orders_data['stores_id'] = $this->data['store_id'];
			$temp_orders_data['id'] = $this->data['temp_id'];
			$payment_gateway_data['name'] =  $temp_orders_data['name'] = $this->data['temp_name'];
			$delivery_email = $billing_email = $payment_gateway_data['email'] = $temp_orders_data['email'] = $this->data['temp_email'];
			$payment_gateway_data['number'] = $temp_orders_data['number'] = $this->data['temp_number'];
			$temp_orders_data['login_type'] = 2;

			$temp_orders_data['currency_name'] = $this->data['currency']->currency_name;
			$payment_gateway_data['currency_name'] = $this->data['currency']->currency_name;
			$temp_orders_data['currency_code'] = $this->data['currency']->currency_code;
			$payment_gateway_data['currency_code'] = $this->data['currency']->currency_code;
			$temp_orders_data['currency_rate'] = $this->data['currency']->currency_rate;

			$temp_orders_data['symbol'] = $this->data['currency']->symbol;
			$temp_orders_data['currency_id'] = $this->data['currency']->currency_id;

			$t_country = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"country" , 'where'=>"country_id=".$_POST['country_idD']));
			$t_country = $t_country[0];

			$t_state = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"state" , 'where'=>"state_id=".$_POST['state_idD']));
			$t_state = $t_state[0];

			$t_city = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"city" , 'where'=>"city_id=".$_POST['city_idD']));
			$t_city = $t_city[0];


				$delivery_name 		= $temp_orders_data['d_name'] 			= trim($_POST['nameD']);
				$delivery_tel 		= $temp_orders_data['d_number'] 		= trim($_POST['numberD']);
				$delivery_address 	= $temp_orders_data['d_address'] 		= trim($_POST['addressD']);
				$delivery_address2 	= $temp_orders_data['d_address2'] 		= trim($_POST['address2D']);
				$delivery_address3 	= $temp_orders_data['d_address3'] 		= trim($_POST['address3D']);
				$delivery_city 		= $temp_orders_data['d_city_name'] 		= trim($t_city->city_name);
				$delivery_state 	= $temp_orders_data['d_state_name'] 	= trim($t_state->state_name);
				$delivery_country 	= $temp_orders_data['d_country_name'] 	= trim($t_country->country_name);
				$delivery_zip 		= $temp_orders_data['d_zipcode'] 		= trim($_POST['pincodeD']);
				$delivery_country_id= $temp_orders_data['d_country_id']		= trim($_POST['country_idD']);
				$delivery_state_id	= $temp_orders_data['d_state_id']		= trim($_POST['state_idD']);
				$delivery_city_id	= $temp_orders_data['d_city_id']		= trim($_POST['city_idD']);

			$t_country = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"country" , 'where'=>"country_id=".$_POST['country_idB']));
			$t_country = $t_country[0];

			$t_state = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"state" , 'where'=>"state_id=".$_POST['state_idB']));
			$t_state = $t_state[0];

			$t_city = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"city" , 'where'=>"city_id=".$_POST['city_idB']));
			$t_city = $t_city[0];


				$billing_name 		= $temp_orders_data['b_name'] 			= trim($_POST['nameB']);
				$billing_tel 		= $temp_orders_data['b_number'] 		= trim($_POST['numberB']);
				$billing_address 	= $temp_orders_data['b_address'] 		= trim($_POST['addressB']);
				$billing_address2 	= $temp_orders_data['b_address2'] 		= trim($_POST['address2B']);
				$billing_address3 	= $temp_orders_data['b_address3'] 		= trim($_POST['address3B']);
				$billing_city 		= $temp_orders_data['b_city_name'] 		= trim($t_city->city_name);
				$billing_state	 	= $temp_orders_data['b_state_name'] 	= trim($t_state->state_name);
				$billing_country 	= $temp_orders_data['b_country_name'] 	= trim($t_country->country_name);
				$billing_zip 		= $temp_orders_data['b_zipcode'] 		= trim($_POST['pincodeB']);
				$billing_country_id	= $temp_orders_data['b_country_id']		= trim($_POST['country_idB']);
				$billing_state_id	= $temp_orders_data['b_state_id']		= trim($_POST['state_idB']);
				$billing_city_id	= $temp_orders_data['b_city_id']		= trim($_POST['city_idB']);


			/*
			|--------------------------
			| Orderd Product List Start
			|--------------------------
			*/
			$total = 0;
			$sub_total = 0;
			$total_saving = 0;
			$total_prod = 0;
			$display_body='';
			$total_gst = 0;
			$total_weight = 0;
			$delivery_charges = 0;
			$total_packing_charges=0;
			foreach($this->data['products_list'] as $col){
			$product_name = $col['name'];
			$product_id = $col['product_id'];
			//$manufacturer_name = $col['manufacturer_name'];
			$tax_categories_name = $col['tax_categories_name'];
			$tax_percentage = $col['tax_percentage'];
			$this->data['currency'] = parent::setCurrency(array());
			$currency = $this->data['currency'];
			//Default combination details
			foreach($col['product_combination'] as $row){

			$temp_currency_id = $this->session->userdata('application_sess_currency_id');
			if(!empty($this->data['discount']) && !empty($this->data['coupon_code']) ){
				if(empty($temp_currency_id) || $temp_currency_id==1)
				{
					if ($row['discount_var'] == 'Rs') {
						$discount = $currency->symbol . ' ' . parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['discount']));
						$discount = trim($discount);
					} else {
						$discount = $row['discount'] . ' ' . $row['discount_var'];
						$discount = trim($discount);
					}
					$price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['price']));
					$final_price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['price']));
				}
				else
				{
					if ($row['other_discount_var'] == 'Rs') {
						$discount = $currency->symbol . ' ' . parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_discount']));
						$discount = trim($discount);
					} else {
						$discount = $row['other_discount'] . ' ' . $row['other_discount_var'];
						$discount = trim($discount);
					}
					$price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_price']));
					$final_price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_price']));
				}
			}
			else
			{
				if(empty($temp_currency_id) || $temp_currency_id==1)
				{
					if ($row['discount_var'] == 'Rs') {
						$discount = $currency->symbol . ' ' . parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['discount']));
						$discount = trim($discount);
					} else {
						$discount = $row['discount'] . ' ' . $row['discount_var'];
						$discount = trim($discount);
					}
					$price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['price']));
					$final_price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['final_price']));
				}
				else
				{
					if ($row['other_discount_var'] == 'Rs') {
						$discount = $currency->symbol . ' ' . parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_discount']));
						$discount = trim($discount);
					} else {
						$discount = $row['other_discount'] . ' ' . $row['other_discount_var'];
						$discount = trim($discount);
					}
					$price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_price']));
					$final_price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_final_price']));
				}
			}
			   /* if(!empty($this->data['discount']) && !empty($this->data['coupon_code']) ){
    				$discount = '';
    				$price = parent::getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['price']));
    				$final_price = $price;
    			}
    			else
			    {
			        $discount = $row['discount'].' '.$row['discount_var'];$discount = trim($discount);
    				$price = parent::getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['price']));
    				$final_price = parent::getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['final_price']));
			    }*/

				$product_image_name = $row['product_image_name'];
				$combi = $row['combi'];
				$ref_code = $row['ref_code'];
				$combi_ref_code = $ref_code = $row['ref_code'];
				$product_in_store_id = $row['product_in_store_id'];
				$product_combination_id = $row['product_combination_id'];
				$prod_in_cart = $row['prod_in_cart'];


				$in_store_quantity = $row['quantity'];
				$stock_out_msg = $row['stock_out_msg'];
				$quantity_per_order = $row['quantity_per_order'];
				$pc_delivery_charges = $row['delivery_charges'];
				$packing_charges = $row['delivery_charges'];

				$temp_delivery_charges = floatval($pc_delivery_charges)*$prod_in_cart;
				$delivery_charges+=$temp_delivery_charges;
				$total_packing_charges += $prod_in_cart*$packing_charges;

				$total_prod+=$prod_in_cart;
				$total+=$prod_in_cart*$final_price;
				$sub_total+=$prod_in_cart*$final_price;
				$total_saving+=$prod_in_cart*$price;

				if($tax_percentage<10)
				{
					$tax_percentage = ($tax_percentage/100);
					$tax_percentage = 1 + $tax_percentage;
				}
				else
				{
					$tax_percentage = ($tax_percentage/100);
					$tax_percentage = 1 + $tax_percentage;
				}
				//echo $tax_percentage.' - '.$tax_percentage.'<br>';
				//$total_gst += ($prod_in_cart*$final_price)*($tax_percentage/100);
				$total_gst += (($prod_in_cart*$final_price) - ($prod_in_cart*$final_price)/$tax_percentage);

				$total_weight += floatval($row['product_weight'])*$prod_in_cart;
				}
			}

			$sub_total-=$total_gst;

			if(!empty($this->data['discount']) && !empty($this->data['coupon_code']) ){
				$discount_price = (($this->data['discount']/100)*($total));
				$total -=(($this->data['discount']/100)*($total));
			}

			$total_saving_in_percent = round((($total_saving-$total)/$total_saving)*100 , 2);
			$total_saving_in_rs = round($total_saving-$total , 2);



			$delivery_pin_code = $delivery_zip;
			$delivery_city_id = $delivery_city_id;
			$delivery_charges = 0;
			$ship_details = '';
			if(!empty($delivery_pin_code))
			{
				$ship_details = parent::getDeliveryPrice(array('total_weight'=>$total_weight , 'delivery_pin_code'=>$delivery_pin_code , 'delivery_city_id'=>$delivery_city_id , 'order_total'=>$total));
			}
			//print_r($ship_details);
			if(!$ship_details->is_delivery_available)
			{
				$msg = "the pin code (".$params['delivery_pin_code'].") is not serviceable.";
				$this->session->set_flashdata('message', '<div class=" alert alert-warning">'.$msg.'</div>');
				REDIRECT(base_url().__cart__);
			}

			$delivery_charges = round($ship_details->shipping_charges - $ship_details->shipping_discount);

			$total = $total + $delivery_charges + $total_packing_charges;


			$payment_gateway_data['total'] = $total;
			/*
			|--------------------------
			| Orderd Product List End
			|--------------------------
			*/

			$temp_orders_data['sub_total'] = round($sub_total ,2);
			$temp_orders_data['total_prod'] = $total_prod;
			//$temp_orders_data['delivery_charges'] = $delivery_charges;

			$temp_orders_data['delivery_charges'] = $ship_details->shipping_charges;
			$temp_orders_data['shipping_discount'] = $ship_details->shipping_discount;

			if($this->is_order_cod)
			{
				$temp_orders_data['cod_charges'] = $ship_details->cod_charges;
				$total = $total + $ship_details->cod_charges;
			}
			else
			{
				$temp_orders_data['cod_charges'] = 0;
			}

			$temp_orders_data['total_packing_charges'] = round($total_packing_charges , 2);
			$temp_orders_data['total_gst'] = round($total_gst , 2);
			$temp_orders_data['total_weight'] = $total_weight;
			$temp_orders_data['discount'] = $this->data['discount'];
			$temp_orders_data['coupon_code'] = $this->data['coupon_code'];
			$temp_orders_data['total'] = $total;
			$temp_orders_data['added_on'] = date('Y-m-d H:i:s');
			$temp_orders_data['updated_on'] = date('Y-m-d H:i:s');
			$temp_orders_data['status'] = 0;
			$temp_orders_data['stuck_status ']=2;
			$temp_orders_id = $this->Common_Model->add_operation(array('table'=>'temp_orders' , 'data'=>$temp_orders_data));
			if($temp_orders_id>0)
			{
				$payment_gateway_data['temp_orders_id'] = $temp_orders_id;
				$payment_gateway_data['Order_Id'] = $temp_orders_id;
				/*
				|--------------------------
				| Orderd Product List Start
				|--------------------------
				*/
				$total = 0;
				$sub_total = 0;
				$total_saving = 0;
				$total_prod = 0;
				$display_body='';
				$total_gst = 0;
				$total_weight = 0;
				foreach($this->data['products_list'] as $col){
				$product_name = $col['name'];
				$product_id = $col['product_id'];
				//$manufacturer_name = $col['manufacturer_name'];
				$short_description = $col['short_description'];
				$tax_categories_name = $col['tax_categories_name'];
				$tax_percentage = $col['tax_percentage'];
				$p_ref_code = $col['ref_code'];

				//Default combination details
				foreach($col['product_combination'] as $row){
					$temp_currency_id = $this->session->userdata('application_sess_currency_id');
					if(empty($temp_currency_id) || $temp_currency_id==1)
					{
						if(!empty($this->data['discount']) && !empty($this->data['coupon_code']) ){
							$discount = '';
							$price = $row['price'];
							$final_price = $price;
						}
						else
						{
							$discount = $row['discount'].' '.$row['discount_var'];$discount = trim($discount);
							$price = $row['price'];
							$final_price = $row['final_price'];
						}
					}
					else
					{
						if(!empty($this->data['other_discount']) && !empty($this->data['coupon_code']) ){
							$discount = '';
							$price = $row['other_price'];
							$final_price = $price;
						}
						else
						{
							$discount = $row['other_discount'].' '.$row['other_discount_var'];$discount = trim($discount);
							$price = $row['other_price'];
							$final_price = $row['other_final_price'];
						}
					}

					$product_combination_id = $row['product_combination_id'];
					$product_display_name = $row['product_display_name'];
					$product_image_name = $row['product_image_name'];
					$combi = $row['combi'];
					$combi_ref_code = $ref_code = $row['ref_code'];
					$product_in_store_id = $row['product_in_store_id'];
					$product_combination_id = $row['product_combination_id'];
					$prod_in_cart = $row['prod_in_cart'];
					$prod_comment = $row['prod_comment'];
					$in_store_quantity = $row['quantity'];
					$stock_out_msg = $row['stock_out_msg'];
					$quantity_per_order = $row['quantity_per_order'];
					$product_weight = $row['product_weight'];
					$product_dimension = $row['product_dimension'];
					$pc_delivery_charges = $row['delivery_charges'];

					$temp_delivery_charges = floatval($pc_delivery_charges)*$prod_in_cart;

					$total_prod+=$prod_in_cart;
					$total+=$prod_in_cart*$final_price;
					$sub_total+=$prod_in_cart*$final_price;
					$total_saving+=$prod_in_cart*$price;

					if($tax_percentage<10)
					{
						$tax_percentage = ($tax_percentage/100);
						$tax_percentage = 1 + $tax_percentage;
					}
					else
					{
						$tax_percentage = ($tax_percentage/100);
						$tax_percentage = 1 + $tax_percentage;
					}
					//echo $tax_percentage.' - '.$tax_percentage.'<br>';
					//$total_gst += ($prod_in_cart*$final_price)*($tax_percentage/100);
					$total_gst += (($prod_in_cart*$final_price) - ($prod_in_cart*$final_price)/$tax_percentage);

					$total_weight += floatval($row['product_weight'])*$prod_in_cart;


					$temp_orders_details_data['temp_orders_id'] = $temp_orders_id;
					$temp_orders_details_data['product_combination_id'] = $product_combination_id;
					$temp_orders_details_data['product_id'] = $product_id;
					$temp_orders_details_data['p_name'] = $product_name;
					$temp_orders_details_data['product_name'] = $product_display_name;
					$temp_orders_details_data['ref_code'] = $combi_ref_code;
					$temp_orders_details_data['tax_categories_name'] = $tax_categories_name;
					$temp_orders_details_data['tax_percentage'] = $tax_percentage;
					$temp_orders_details_data['short_description'] = $short_description;
					$temp_orders_details_data['manufacturer_name'] = $manufacturer_name;
					$temp_orders_details_data['combi_ref_code'] = $ref_code;
					$temp_orders_details_data['price'] = $price;
					$temp_orders_details_data['discount_var	'] = $discount;
					$temp_orders_details_data['final_price'] = $final_price;
					$temp_orders_details_data['combi'] = $combi;
					$temp_orders_details_data['product_in_store_id'] = $product_in_store_id;
					$temp_orders_details_data['product_weight'] = $product_weight;
					$temp_orders_details_data['product_dimension'] = $product_dimension;
					$temp_orders_details_data['prod_in_cart'] = $prod_in_cart;
					$temp_orders_details_data['prod_comment'] = $prod_comment;
					$temp_orders_details_data['delivery_charges'] = $pc_delivery_charges;
					//$temp_orders_details_data['sub_total'] = ($prod_in_cart*$final_price)-($prod_in_cart*$final_price)*($tax_percentage/100);
					$temp_orders_details_data['sub_total'] = round(($prod_in_cart*$final_price)-(($prod_in_cart*$final_price) - ($prod_in_cart*$final_price)/$tax_percentage) , 2);
					$temp_orders_details_data['total_weight'] = floatval($row['product_weight'])*$prod_in_cart;
					//$temp_orders_details_data['total_gst'] = ($prod_in_cart*$final_price)*($tax_percentagetax_percentage/100);
					$temp_orders_details_data['total_gst'] = round((($prod_in_cart*$final_price) - ($prod_in_cart*$final_price)/$tax_percentage) , 2);
					$temp_orders_details_data['total'] = $prod_in_cart*$final_price;
					$temp_orders_details_id = $this->Common_Model->add_operation(array('table'=>'temp_orders_details' , 'data'=>$temp_orders_details_data));

					}
				}
				$delivery_charges = 0;
				$sub_total-=$total_gst;

				if(!empty($this->data['discount']) && !empty($this->data['coupon_code']) ){
					$discount_price = (($this->data['discount']/100)*($total));
					$total -=(($this->data['discount']/100)*($total));
				}

				$total_saving_in_percent = number_format((($total_saving-$total)/$total_saving)*100 , 2);
				$total_saving_in_rs = number_format($total_saving-$total , 2);
				$total+=$delivery_charges;
				/*
				|--------------------------
				| Orderd Product List End
				|--------------------------
				*/
				//$this->payment();

				$this->order_stock_minus($temp_orders_id);

				$payment_gateway_data['Merchant_Id'] = __pg_merchant_id__;
				$payment_gateway_data['total']=number_format($payment_gateway_data['total'],2 , '.', '');;
				$payment_gateway_data['Amount'] = number_format($payment_gateway_data['total'],2 , '.', '');
				//$payment_gateway_data['Amount'] = round(1,2);
				$payment_gateway_data['Currency'] = 'INR';
				$payment_gateway_data['Redirect_Url'] = base_url().'order_confirmation';
			//	$payment_gateway_data['Redirect_Url'] = base_url().'order_confirmation';

				$payment_gateway_data['total_prod'] = $total_prod;
				$payment_gateway_data['billing_name'] = $billing_name;
				$payment_gateway_data['billing_address'] = $billing_address;
				$payment_gateway_data['billing_city'] = $billing_city;
				$payment_gateway_data['billing_state'] = $billing_state;
				$payment_gateway_data['billing_zip'] = $billing_zip;
				$payment_gateway_data['billing_country'] = $billing_country;
				$payment_gateway_data['billing_tel'] = $billing_tel;
				$payment_gateway_data['billing_email'] = $billing_email;

				$payment_gateway_data['delivery_name'] = $delivery_name;
				$payment_gateway_data['delivery_address'] = $delivery_address;
				$payment_gateway_data['delivery_city'] = $delivery_city;
				$payment_gateway_data['delivery_state'] = $delivery_state;
				$payment_gateway_data['delivery_zip'] = $delivery_zip;
				$payment_gateway_data['delivery_country'] = $delivery_country;
				$payment_gateway_data['delivery_tel'] = $delivery_tel;
				$payment_gateway_data['delivery_email'] = $delivery_email;


				$this->data['payment_gateway_data'] = $payment_gateway_data;

				$this->data['payment_gateway_data'] = $payment_gateway_data;
				//return $this->data['payment_gateway_data'];
				//parent::getHeader('header' , $this->data);
				//$this->load->view('payment',$this->data);


				if($this->is_order_cod)
				{
					$this->load->view('cod_order',$this->data);
				}
				else
				{
					$this->load->view('go_to_payment',$this->data);
				}
				//parent::getFooter('footer' , $this->data);



			}
			else
			{
				$this->session->set_flashdata('message1', '<div class=" alert alert-error">Something Went Wrong. Please Try Again.</div>');
				REDIRECT(base_url().__shippingAddress__);
			}

		}
		else
		{
			REDIRECT(base_url());
		}
	}

	function pay_now()
	{

		//echo "<pre>"; print_r($this->data); echo "</pre>"; exit;
		$this->data['isDisplayCart'] = 'no';
		if( empty($this->data['temp_name']) || empty($this->data['temp_id']) )
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Please login with your account to place the order.</div>');
			REDIRECT(base_url().__login__);
		}
		if(empty($this->data['user']->address))
		{
			$this->session->set_flashdata('message1', '<div class=" alert alert-warning">You have not entered any address.</div>');
			REDIRECT(base_url().__shippingAddress__);
		}

		if(empty($this->data['user']->number))
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Please add contact number.</div>');
			REDIRECT(base_url().__profileInformation__);
		}

		$check_delivery_status = false;
		$check_billing_status = false;

		foreach($this->data['user']->address as $add)
		{
			if($add->delivery_status==1){ $check_delivery_status = true; }
			if($add->billing_status==1){ $check_billing_status = true; }
		}

		if(!$check_delivery_status)
		{
			$this->session->set_flashdata('message1', '<div class=" alert alert-warning">You have not selected shipping address.</div>');
			REDIRECT(base_url().__shippingAddress__);
		}

		if(!$check_billing_status)
		{
			$this->session->set_flashdata('message1', '<div class=" alert alert-warning">You have not selected billing address.</div>');
			REDIRECT(base_url().__shippingAddress__);
		}

		$this->data['distinct_product_id_in_cart'] = $this->Common_Model->temp_cart('distinct_product_id_in_cart','','' , '' , '', '', $this->data['temp_id'], $this->data['store_id']);
		if(empty($this->data['distinct_product_id_in_cart']))
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Yout cart is empty.</div>');
			REDIRECT(base_url().__cart__);
		}
		if(isset($_POST['orderBTN']) || true)
		{
			$product_ids = '';
			$product_combination_ids = '';

			//print_r($this->data['distinct_product_id_in_cart']);
			foreach($this->data['distinct_product_id_in_cart'] as $col){$product_ids.=$col['product_id'].',';$product_combination_ids.=$col['product_combination_id'].',';}
			$product_ids = trim($product_ids , ',');$product_combination_ids = trim($product_combination_ids , ',');

			$this->data['products_list']=$this->Products_model->productsSearch('products_list_group','', '', $this->data['temp_id'], $this->data['store_id'], $product_ids, $product_combination_ids);

			/*echo "<pre>";
			print_r($this->data['products_list']);
			exit;*/

			$stock_out_message='';
			foreach($this->data['products_list'] as $col){
			$product_name = $col['name'];
				foreach($col['product_combination'] as $row)
				{
					$combi = $row['combi'];
					$t_stock_out_msg='Sold Out';
					if(!empty($row['stock_out_msg']))
					{
						$t_stock_out_msg = $row['stock_out_msg'];
					}
					if($row['quantity']<=0)
					{
						$stock_out_message .= '<div class=" alert alert-warning">'.$product_name.' - '.$combi.' is '.$t_stock_out_msg.'</div>';
					}
					else if($row['quantity'] < $row['prod_in_cart'])
					{
						$stock_out_message .= '<div class=" alert alert-warning">We have only '.$row['quantity'].' unit of '.$product_name.' - '.$combi.'</div>';
					}
				}
			}
//			echo "<pre>";
//			print_r($this->data['products_list']);
/*
			if(!empty($stock_out_message))
			{
				$this->session->set_flashdata('message', $stock_out_message);
				REDIRECT(base_url().__cart__);
				exit;
			}*/
			//exit;

			//print_r($this->data);
			$customer_order_note = $this->session->userdata('application_sess_customer_order_note');
			$temp_orders_data['customer_order_note'] = $customer_order_note;
			$temp_orders_data['stores_id'] = $this->data['store_id'];
			$temp_orders_data['customers_id'] = $this->data['temp_id'];
			$payment_gateway_data['name'] = $temp_orders_data['name'] = $this->data['user']->name;
			$delivery_email = $billing_email = $payment_gateway_data['email'] = $temp_orders_data['email'] = $this->data['user']->email;
			$payment_gateway_data['number'] = $temp_orders_data['number'] = $this->data['user']->number;

			$temp_orders_data['currency_name'] = $this->data['currency']->currency_name;
			$payment_gateway_data['currency_name'] = $this->data['currency']->currency_name;
			$temp_orders_data['currency_code'] = $this->data['currency']->currency_code;
			$payment_gateway_data['currency_code'] = $this->data['currency']->currency_code;
			$temp_orders_data['currency_rate'] = $this->data['currency']->currency_rate;

			$temp_orders_data['symbol'] = $this->data['currency']->symbol;
			$temp_orders_data['currency_id'] = $this->data['currency']->currency_id;
			$user = $this->data['user'];
			if(!empty($user->gst_info))
			{
				foreach($user->gst_info as $gi)
				{
					if($gi->selected_for_order == 1){
						$payment_gateway_data['company_name'] = $temp_orders_data['company_name'] = $gi->company_name;
						$payment_gateway_data['gst_number'] = $temp_orders_data['gst_number'] = $gi->gst_number;
					}
				}
			}
			$is_gst_claimed = $this->session->userdata('is_gst_claimed');
			if($is_gst_claimed==1 && false)
			{
				$payment_gateway_data['company_name'] = $temp_orders_data['company_name'] = $this->data['user']->company_name;
				$payment_gateway_data['gst_number'] = $temp_orders_data['gst_number'] = $this->data['user']->gst_number;
			}

			$Dcount=0;foreach($this->data['user']->address as $add){$Dcount++;
			if($add->delivery_status==1){
				$delivery_name 		= $temp_orders_data['d_name'] 			= $add->name;
				$delivery_tel 		= $temp_orders_data['d_number'] 		= $add->number;
				$delivery_alternate_number 		= $temp_orders_data['d_alternate_number'] 		= $add->alternate_number;
				$delivery_address 	= $temp_orders_data['d_address'] 		= $add->address;
				$delivery_locality 	= $temp_orders_data['d_locality'] 		= $add->locality;
				$billing_landmark 	= $temp_orders_data['d_landmark'] 		= $add->landmark;
				$delivery_city 		= $temp_orders_data['d_city_name'] 		= $add->city_name;
				$delivery_zip 		= $temp_orders_data['d_zipcode'] 		= $add->zipcode;
				$delivery_state 	= $temp_orders_data['d_state_name'] 	= $add->state_name;
				$delivery_country 	= $temp_orders_data['d_country_name'] 	= $add->country_name;

				$delivery_country_id= $temp_orders_data['d_country_id']		= $add->country_id;
				$delivery_state_id	= $temp_orders_data['d_state_id']		= $add->state_id;
				$delivery_city_id	= $temp_orders_data['d_city_id']		= $add->city_id;
			}}
			$Dcount=0;foreach($this->data['user']->address as $add){$Dcount++;
			if($add->billing_status==1){
				$billing_name 		= $temp_orders_data['b_name'] 			= $add->name;
				$billing_tel 		= $temp_orders_data['b_number'] 		= $add->number;
				$billing_alternate_number 		= $temp_orders_data['b_alternate_number'] 		= $add->alternate_number;
				$billing_address 	= $temp_orders_data['b_address'] 		= $add->address;
				$billing_locality 	= $temp_orders_data['b_locality'] 		= $add->locality;
				$billing_landmark 	= $temp_orders_data['b_landmark'] 		= $add->landmark;
				$billing_city 		= $temp_orders_data['b_city_name'] 		= $add->city_name;
				$billing_zip 		= $temp_orders_data['b_zipcode'] 		= $add->zipcode;
				$billing_state 		= $temp_orders_data['b_state_name'] 	= $add->state_name;
				$billing_country 	= $temp_orders_data['b_country_name'] 	= $add->country_name;

				$billing_country_id	= $temp_orders_data['b_country_id']		= $add->country_id;
				$billing_state_id	= $temp_orders_data['b_state_id']		= $add->state_id;
				$billing_city_id	= $temp_orders_data['b_city_id']		= $add->city_id;
			}}

			$this->data['user']->name = trim($this->data['user']->name);
			if($this->data['user']->name == "user" || $this->data['user']->name == "User")
			{
			    $billing_name = trim($billing_name);
                $billing_name_arr = explode(" ", $billing_name, 2);
                $update_account_data["name"] = $billing_name;
			    $update_account_data["first_name"] = (!empty($billing_name_arr[0]))?$billing_name_arr[0]:"User";
			    $update_account_data["last_name"] = (!empty($billing_name_arr[1]))?$billing_name_arr[1]:"";
			    $this->Common_Model->update_operation(array('table'=>'customers' , 'data'=>$update_account_data , 'condition'=>"customers_id=".$this->data['temp_id']));
			    $this->data['user'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));
			    $payment_gateway_data['name'] = $temp_orders_data['name'] = $this->data['user']->name;
			}




			/*
			|--------------------------
			| Orderd Product List Start
			|--------------------------
			*/
			$total = 0;
			$sub_total = 0;
			$total_saving = 0;
			$total_prod = 0;
			$display_body='';
			$total_gst = 0;
			$total_weight = 0;
			$delivery_charges = 0;
			$total_packing_charges=0;
			$cart_coupon_code = $this->data['cart_coupon_code']; //echo "cart_coupon_code : $cart_coupon_code </br>";
			$cart_coupon_discount = $this->data['cart_coupon_discount']; //echo "cart_coupon_discount : $cart_coupon_discount </br>";
			$cart_discount_in = $this->data['cart_discount_in'];
			$cart_discount_variable = $this->data['cart_discount_variable'];
			$cart_discount_on_cart_value = $this->data['cart_discount_on_cart_value'];
			$cart_discount_cart_value_message = $this->data['cart_discount_cart_value_message'];


			//$payment_gateway_data['number'] = $temp_orders_data['number'] = $this->data['user']->number;


			foreach($this->data['products_list'] as $col){
			$product_name = $col['name'];
			$product_id = $col['product_id'];
			//$manufacturer_name = $col['manufacturer_name'];
			//$tax_categories_name = $col['tax_categories_name'];
			$tax_percentage = $col['tax_percentage'];
			$this->data['currency'] = parent::setCurrency(array());
			$currency = $this->data['currency'];
			//Default combination details
			foreach($col['product_combination'] as $row){

			$temp_currency_id = $this->session->userdata('application_sess_currency_id');

			if(!empty($cart_coupon_code) && !empty($cart_coupon_discount) && _is_coupon_applicable_on_mrp ==1 ){
				if(empty($temp_currency_id) || $temp_currency_id==1)
				{
					if ($row['discount_var'] == 'Rs') {
						$discount = $currency->symbol . ' ' . parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['discount']));
						$discount = trim($discount);
					} else {
						$discount = $row['discount'] . ' ' . $row['discount_var'];
						$discount = trim($discount);
					}
					$price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['price']));
					$final_price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['price']));
				}
				else
				{
					if ($row['other_discount_var'] == 'Rs') {
						$discount = $currency->symbol . ' ' . parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_discount']));
						$discount = trim($discount);
					} else {
						$discount = $row['other_discount'] . ' ' . $row['other_discount_var'];
						$discount = trim($discount);
					}
					$price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_price']));
					$final_price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_price']));
				}
			}
			else
			{
				if(empty($temp_currency_id) || $temp_currency_id==1)
				{
					if ($row['discount_var'] == 'Rs') {
						$discount = $currency->symbol . ' ' . parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['discount']));
						$discount = trim($discount);
					} else {
						$discount = $row['discount'] . ' ' . $row['discount_var'];
						$discount = trim($discount);
					}
					$price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['price']));
					$final_price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['final_price']));
				}
				else
				{
					if ($row['other_discount_var'] == 'Rs') {
						$discount = $currency->symbol . ' ' . parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_discount']));
						$discount = trim($discount);
					} else {
						$discount = $row['other_discount'] . ' ' . $row['other_discount_var'];
						$discount = trim($discount);
					}
					$price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_price']));
					$final_price = parent::getCurrencyPrice(array('obj' => $this->data, 'amount' => $row['other_final_price']));
				}
			}
			   /* if(!empty($this->data['discount']) && !empty($this->data['coupon_code']) ){
    				$discount = '';
    				$price = parent::getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['price']));
    				$final_price = $price;
    			}
    			else
			    {
			        $discount = $row['discount'].' '.$row['discount_var'];$discount = trim($discount);
    				$price = parent::getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['price']));
    				$final_price = parent::getCurrencyPrice(array('obj'=>$this->data , 'amount'=>$row['final_price']));
			    }*/

				$product_image_name = $row['product_image_name'];
				$combi = $row['combi'];
				$ref_code = $row['ref_code'];
				$product_in_store_id = $row['product_in_store_id'];
				$product_combination_id = $row['product_combination_id'];
				$prod_in_cart = $row['prod_in_cart'];


				$in_store_quantity = $row['quantity'];
				$stock_out_msg = $row['stock_out_msg'];
				$quantity_per_order = $row['quantity_per_order'];
				$pc_delivery_charges = $row['delivery_charges'];
				$packing_charges = $row['delivery_charges'];
				$total_packing_charges += $prod_in_cart*$packing_charges;

				$temp_delivery_charges = floatval($pc_delivery_charges)*$prod_in_cart;
				$delivery_charges+=$temp_delivery_charges;



				$total_prod+=$prod_in_cart;
				$total+=$prod_in_cart*$final_price;
				$sub_total+=$prod_in_cart*$final_price;
				$total_saving+=$prod_in_cart*$price;

				if($tax_percentage<10)
				{
					$tax_percentage = ($tax_percentage/100);
					$tax_percentage = 1 + $tax_percentage;
				}
				else
				{
					$tax_percentage = ($tax_percentage/100);
					$tax_percentage = 1 + $tax_percentage;
				}
				//echo $tax_percentage.' - '.$tax_percentage.'<br>';
				//$total_gst += ($prod_in_cart*$final_price)*($tax_percentage/100);
				$total_gst += (($prod_in_cart*$final_price) - ($prod_in_cart*$final_price)/$tax_percentage);

				$total_weight += floatval($row['product_weight'])*$prod_in_cart;
				}
			}

			$sub_total-=$total_gst;
			$cart_coupon_discount_value_var = '';
			$cart_discount_on_cart_value = 0;
			if(_is_coupon_required ==1){
				if(!empty($cart_coupon_discount) && !empty($cart_coupon_code) ){
					if($total <= $cart_discount_on_cart_value)
					{
						REDIRECT(base_url().__removeCoupon__.'?total_mismatch=1');
					}
					$cart_coupon_discount_value = 0;
					if($cart_discount_in==1)
					{
						$cart_coupon_discount_value = $cart_coupon_discount;
						$cart_coupon_discount_value_var = $cart_discount_variable.' '.$cart_coupon_discount;
					}
					else
					{
						$cart_coupon_discount_value = (($cart_coupon_discount/100)*($total));
						$cart_coupon_discount_value_var = $cart_coupon_discount.''.$cart_discount_variable;
					}
					$total_saving = $total_saving+$cart_coupon_discount_value;
					$total -=$cart_coupon_discount_value;
				}
			}

			$total_saving_in_percent = round((($total_saving-$total)/$total_saving)*100 , 2);
			$total_saving_in_rs = round($total_saving-$total , 2);



			$delivery_pin_code = $delivery_zip;
			$delivery_city_id = $delivery_city_id;
			//$delivery_charges = 0;
			$ship_details = (object)array();


			if(!empty($delivery_pin_code))
				{
					$ship_details = parent::getDeliveryPrice(array('total_weight'=>$total_weight , 'delivery_pin_code'=>$delivery_pin_code , 'delivery_city_id'=>$delivery_city_id , 'order_total'=>$total));
				}

				if(!$ship_details->is_delivery_available)
				{
					$msg = "the pin code (".$params['delivery_pin_code'].") is not serviceable.";
					$this->session->set_flashdata('message', '<div class=" alert alert-warning">'.$msg.'</div>');
					REDIRECT(base_url().__cart__);
				}
				$delivery_charges = round($ship_details->shipping_charges - $ship_details->shipping_discount);
				$delivery_charges = 0;

			$final_cart_value = $total + $total_packing_charges;
			if($final_cart_value <= __free_shipping_above__)
				$delivery_charges = 90;
			else
				$delivery_charges = 0;

			$total = $total + $delivery_charges + $total_packing_charges;



			$payment_gateway_data['total'] = $total;
			/*
			|--------------------------
			| Orderd Product List End
			|--------------------------
			*/

			$temp_orders_data['sub_total'] = round($sub_total ,2);
			$temp_orders_data['total_prod'] = $total_prod;
			//$temp_orders_data['delivery_charges'] = $ship_details->shipping_charges;
			$temp_orders_data['delivery_charges'] = $delivery_charges;
			//$temp_orders_data['shipping_discount'] = $ship_details->shipping_discount;
			$temp_orders_data['shipping_discount'] = 0;
			if($this->is_order_cod)
			{
				$temp_orders_data['cod_charges'] = $ship_details->cod_charges;
				$total = $total + $ship_details->cod_charges;
			}
			else
			{
				$temp_orders_data['cod_charges'] = 0;
			}
			$temp_orders_data['total_gst'] = round($total_gst , 2);
			$temp_orders_data['total_weight'] = $total_weight;
			$temp_orders_data['discount'] = trim($cart_coupon_discount_value_var);
			$temp_orders_data['coupon_code'] = $cart_coupon_code;
			$temp_orders_data['total'] = $total;
			$temp_orders_data['added_on'] = date('Y-m-d H:i:s');
			$temp_orders_data['updated_on'] = date('Y-m-d H:i:s');
			$temp_orders_data['total_packing_charges'] = $total_packing_charges;
			$temp_orders_data['status'] = 0;
			$temp_orders_data['stuck_status ']=2;
			$temp_orders_data['email'] = $this->session->userdata('application_sess_temp_email');



			$temp_orders_id = $this->Common_Model->add_operation(array('table'=>'temp_orders' , 'data'=>$temp_orders_data));
			//echo $this->db->last_query();
			//exit;
			if($temp_orders_id>0)
			{
				$payment_gateway_data['temp_orders_id'] = $temp_orders_id;
				$payment_gateway_data['Order_Id'] = $temp_orders_id;
				/*
				|--------------------------
				| Orderd Product List Start
				|--------------------------
				*/
				$total = 0;
				$sub_total = 0;
				$total_saving = 0;
				$total_prod = 0;
				$display_body='';
				$total_gst = 0;
				$total_weight = 0;
				//echo "<pre>";print_r($this->data['products_list']);echo "</pre>";
				foreach($this->data['products_list'] as $col){
				$product_name = $col['name'];
				$product_id = $col['product_id'];
				$brand_name = $col['brand_name'];
				$short_description = $col['short_description'];
				$tax_percentage = $col['tax_percentage'];
				$p_ref_code = $col['ref_code'];

				//Default combination details
				foreach($col['product_combination'] as $row){
					$temp_currency_id = $this->session->userdata('application_sess_currency_id');
					if(empty($temp_currency_id) || $temp_currency_id==1)
					{
						if(!empty($this->data['discount']) && !empty($this->data['coupon_code']) ){
							$discount = '';
							$price = $row['price'];
							$final_price = $price;
						}
						else
						{
							$discount = $row['discount'].' '.$row['discount_var'];$discount = trim($discount);
							$price = $row['price'];
							$final_price = $row['final_price'];
						}
					}
					else
					{
						if(!empty($this->data['other_discount']) && !empty($this->data['coupon_code']) ){
							$discount = '';
							$price = $row['other_price'];
							$final_price = $price;
						}
						else
						{
							$discount = $row['other_discount'].' '.$row['other_discount_var'];$discount = trim($discount);
							$price = $row['other_price'];
							$final_price = $row['other_final_price'];
						}
					}

					$product_combination_id = $row['product_combination_id'];
					$product_display_name = $row['product_display_name'];
					$product_image_name = $row['product_image_name'];
					$combi = $row['combi'];
					$combi_ref_code = $ref_code = $row['ref_code'];
					$product_in_store_id = $row['product_in_store_id'];
					$product_combination_id = $row['product_combination_id'];
					$prod_in_cart = $row['prod_in_cart'];
					$prod_comment = $row['prod_comment'];
					$in_store_quantity = $row['quantity'];
					$stock_out_msg = $row['stock_out_msg'];
					$quantity_per_order = $row['quantity_per_order'];
					$product_weight = $row['product_weight'];
					$product_dimension = $row['product_dimension'];
					$pc_delivery_charges = $row['delivery_charges'];

					$temp_delivery_charges = floatval($pc_delivery_charges)*$prod_in_cart;

					$total_prod+=$prod_in_cart;
					$total+=$prod_in_cart*$final_price;
					$sub_total+=$prod_in_cart*$final_price;
					$total_saving+=$prod_in_cart*$price;

					if($tax_percentage<10)
					{
						$tax_percentage = ($tax_percentage/100);
						$tax_percentage = 1 + $tax_percentage;
					}
					else
					{
						$tax_percentage = ($tax_percentage/100);
						$tax_percentage = 1 + $tax_percentage;
					}
					//echo $tax_percentage.' - '.$tax_percentage.'<br>';
					//$total_gst += ($prod_in_cart*$final_price)*($tax_percentage/100);
					$total_gst += (($prod_in_cart*$final_price) - ($prod_in_cart*$final_price)/$tax_percentage);

					$total_weight += floatval($row['product_weight'])*$prod_in_cart;


					$temp_orders_details_data['temp_orders_id'] = $temp_orders_id;
					$temp_orders_details_data['product_combination_id'] = $product_combination_id;
					$temp_orders_details_data['product_id'] = $product_id;
					$temp_orders_details_data['p_name'] = $product_name;
					$temp_orders_details_data['product_name'] = $product_display_name;
					$temp_orders_details_data['ref_code'] = $combi_ref_code;
					$temp_orders_details_data['tax_categories_name'] = $col['tax_name'];
					$temp_orders_details_data['tax_percentage'] = $col['tax_percentage'];
					$temp_orders_details_data['short_description'] = $short_description;
					$temp_orders_details_data['brand_name'] = $brand_name;
					$temp_orders_details_data['combi_ref_code'] = $ref_code;
					$temp_orders_details_data['price'] = $price;
					$temp_orders_details_data['discount_var	'] = $discount;
					$temp_orders_details_data['final_price'] = $final_price;
					$temp_orders_details_data['combi'] = $combi;
					$temp_orders_details_data['product_in_store_id'] = $product_in_store_id;
					$temp_orders_details_data['product_weight'] = $product_weight;
					$temp_orders_details_data['product_dimension'] = $product_dimension;
					$temp_orders_details_data['prod_in_cart'] = $prod_in_cart;
					$temp_orders_details_data['prod_comment'] = $prod_comment;
					$temp_orders_details_data['delivery_charges'] = $pc_delivery_charges;
					//$temp_orders_details_data['sub_total'] = ($prod_in_cart*$final_price)-($prod_in_cart*$final_price)*($tax_percentage/100);
					$temp_orders_details_data['sub_total'] = round(($prod_in_cart*$final_price)-(($prod_in_cart*$final_price) - ($prod_in_cart*$final_price)/$tax_percentage) , 2);
					$temp_orders_details_data['total_weight'] = floatval($row['product_weight'])*$prod_in_cart;
					//$temp_orders_details_data['total_gst'] = ($prod_in_cart*$final_price)*($tax_percentage/100);
					$temp_orders_details_data['total_gst'] = round((($prod_in_cart*$final_price) - ($prod_in_cart*$final_price)/$tax_percentage) , 2);
					$temp_orders_details_data['total'] = $prod_in_cart*$final_price;
					$temp_orders_details_id = $this->Common_Model->add_operation(array('table'=>'temp_orders_details' , 'data'=>$temp_orders_details_data));

					}
				}
				$delivery_charges = 0;
				$sub_total-=$total_gst;

				if(_is_coupon_required ==1){
					if(!empty($cart_coupon_discount) && !empty($cart_coupon_code) ){
						$cart_coupon_discount_value = 0;
						if($cart_discount_in==1)
						{
							$cart_coupon_discount_value = $cart_coupon_discount;
						}
						else
						{
							$cart_coupon_discount_value = (($cart_coupon_discount/100)*($total));
						}
						$total_saving = $total_saving+$cart_coupon_discount_value;
						$total -=$cart_coupon_discount_value;
					}
				}

				$total_saving_in_percent = number_format((($total_saving-$total)/$total_saving)*100 , 2);
				$total_saving_in_rs = number_format($total_saving-$total , 2);
				$total+=$delivery_charges;
				/*
				|--------------------------
				| Orderd Product List End
				|--------------------------
				*/
				//$this->payment();

				$this->order_stock_minus($temp_orders_id);

				//$payment_gateway_data['Merchant_Id'] = __pg_merchant_id__;
				$payment_gateway_data['total']=$payment_gateway_data['total'];
				$payment_gateway_data['Amount'] = number_format($payment_gateway_data['total'],2 , '.', '');
				//$payment_gateway_data['Amount'] = round(1,2);
				$payment_gateway_data['Currency'] = 'INR';
				$payment_gateway_data['Redirect_Url'] = base_url().'order_confirmation';
				$payment_gateway_data['Redirect_Url'] = base_url().'order_confirmation';

				$payment_gateway_data['total_prod'] = $total_prod;
				$payment_gateway_data['billing_name'] = $billing_name;
				$payment_gateway_data['billing_address'] = $billing_address;
				$payment_gateway_data['billing_city'] = $billing_city;
				$payment_gateway_data['billing_state'] = $billing_state;
				$payment_gateway_data['billing_zip'] = $billing_zip;
				$payment_gateway_data['billing_country'] = $billing_country;
				$payment_gateway_data['billing_tel'] = $billing_tel;
				$payment_gateway_data['billing_email'] = $billing_email;

				$payment_gateway_data['delivery_name'] = $delivery_name;
				$payment_gateway_data['delivery_address'] = $delivery_address;
				$payment_gateway_data['delivery_city'] = $delivery_city;
				$payment_gateway_data['delivery_state'] = $delivery_state;
				$payment_gateway_data['delivery_zip'] = $delivery_zip;
				$payment_gateway_data['delivery_country'] = $delivery_country;
				$payment_gateway_data['delivery_tel'] = $delivery_tel;
				$payment_gateway_data['delivery_email'] = $delivery_email;


				$this->data['payment_gateway_data'] = $payment_gateway_data;

				$this->data['payment_gateway_data'] = $payment_gateway_data;
				//return $this->data['payment_gateway_data'];
				//parent::getHeader('header' , $this->data);
				//$this->load->view('payment',$this->data);

				if($this->is_order_cod)
				{
					$this->load->view('cod_order',$this->data);
				}
				else
				{
					$payment_gateway_data['Amount'] = number_format($payment_gateway_data['Amount'],2 , '.', '');
					$payment_gateway_data['Currency'] = 'INR';
					$payment_gateway_data['Product'] = 'Product';
					$payment_gateway_data['Redirect_Url'] = base_url().'order_confirmation';
					$payment_gateway_data['Redirect_Url'] = base_url().'order_confirmation';
					$this->data['payment_gateway_data'] = $payment_gateway_data;

					$easebuz_data['txnid'] = $payment_gateway_data['Order_Id'];
					$easebuz_data['amount'] = $payment_gateway_data['Amount'];
					$easebuz_data['firstname'] = $payment_gateway_data['name'];
					$easebuz_data['email'] = (!empty($payment_gateway_data['email']))?$payment_gateway_data['email']:__adminemail__;
					$easebuz_data['phone'] = $payment_gateway_data['number'];
					$easebuz_data['productinfo'] = $payment_gateway_data['Product'];
					$easebuz_data['surl'] = $payment_gateway_data['Redirect_Url'];
					$easebuz_data['furl'] = $payment_gateway_data['Redirect_Url'];


					$easebuz_data['address1'] = $billing_address;
					$easebuz_data['city'] = $billing_city;
					$easebuz_data['state'] = $billing_state;
					$easebuz_data['country'] = $billing_country;
					$easebuz_data['zipcode'] = $billing_zip;
					$easebuz_data['show_payment_mode'] = '';
				//	$access_token = easebuzzAPIFunc($easebuz_data, 'initiate_payment');



					//echo json_encode($access_token);
					//exit;

//phonepay integration
// Replace these with your actual PhonePe API credentials

//$merchantId = 'PGTESTPAYUAT'; // sandbox or test merchantId
$merchantId = 'M15OM4UUWBBX'; // live
//$apiKey="099eb0cd-02cf-4e2a-8aca-3e6c6aff0399"; // sandbox
$apiKey="b6b49ce7-898b-46fb-84a4-55089212345e"; //  APIKEY Live
$redirectUrl = MAINSITE.'order_confirmation';
$Order_Id = $payment_gateway_data['Order_Id'];
// Set transaction details
$_SESSION['Order_Id'] = $Order_Id;


$paymentData = array(
		"udf1" => 	 $this->data['temp_id'],
    'merchantId' => $merchantId,
    'merchantTransactionId' => "$Order_Id", // test transactionID
    "merchantUserId"=>"marsweb",
    'amount' => $payment_gateway_data['Amount']*100,
    //'amount' => 1*100,
    'redirectUrl'=>$redirectUrl,
    'redirectMode'=>"REDIRECT",
    'callbackUrl'=>$redirectUrl,
    "merchantOrderId"=>$payment_gateway_data['Order_Id'],
   "mobileNumber"=>$payment_gateway_data['number'],
   "message"=>'Annadatha Payment Service',
   "email"=>(!empty($payment_gateway_data['email']))?$payment_gateway_data['email']:__adminemail__,
   "shortName"=>$payment_gateway_data['name'],
   "paymentInstrument"=> array(
    "type"=> "PAY_PAGE",
  )
);


 $jsonencode = json_encode($paymentData);
 $payloadMain = base64_encode($jsonencode);
 $salt_index = 1; //key index 1
 $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
 $sha256 = hash("sha256", $payload);
 $final_x_header = $sha256 . '###' . $salt_index;
 $request = json_encode(array('request'=>$payloadMain));

$curl = curl_init();

curl_setopt_array($curl, [
  //CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay", //test
  CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/pay", //live
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
   CURLOPT_POSTFIELDS => $request,
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
     "X-VERIFY: " . $final_x_header,
     "accept: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo json_encode(array('status'=>'0','message'=>$err));
	exit;
} else {
   $res = json_decode($response);

if(isset($res->success) && $res->success=='1'){
	// echo 'aaa';
	// die;
$paymentCode=$res->code;
$paymentMsg=$res->message;
$payUrl=$res->data->instrumentResponse->redirectInfo->url;
// echo $this->data['temp_id'];
// die;
// echo $payUrl;
// die;
// REDIRECT($payUrl);
// die;
echo json_encode(array('status'=>1,'url'=>$payUrl));
exit;

}else{
	echo json_encode(array('status'=>0,'message'=>'Payment Failed'));
	die;
}
}



					//$this->load->view('go_to_payment',$this->data);
				}
				//parent::getFooter('footer' , $this->data);



			}
			else
			{
				$this->session->set_flashdata('message1', '<div class=" alert alert-error">Something Went Wrong. Please Try Again.</div>');
				REDIRECT(base_url().__shippingAddress__);
			}

		}
		else
		{
			REDIRECT(base_url());
		}
	}

	function order_stock_minus($temp_orders_id=0)
	{
		//$this->data['orders'] = $this->Checkout_model->getOrder(array("orders_id"=>$orders_id, "customers_id"=>$this->data['temp_id']));
		//echo "<pre>";
		$tempOrdersData = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"temp_orders_id=$temp_orders_id"));
		$tempOrdersDetailsData = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders_details" , 'where'=>"temp_orders_id=$temp_orders_id"));
		if(!empty($tempOrdersDetailsData))
		{
			foreach($tempOrdersDetailsData as $tod)
			{
				//print_r($tod);
				$product_in_store_data = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"product_in_store" , 'where'=>"product_in_store_id=$tod->product_in_store_id"));
				if(!empty($product_in_store_data))
				{
					$product_in_store_data = $product_in_store_data[0];
					//print_r($product_in_store_data);
					$update_store_quantity['quantity'] = $product_in_store_data->quantity - $tod->prod_in_cart;
					$this->Common_Model->update_operation(array('table'=>'product_in_store' , 'data'=>$update_store_quantity , 'condition'=>"product_in_store_id=$tod->product_in_store_id"));
				}
			}
		}
	}

	function order_stock_plus($temp_orders_id=0)
	{
		//$this->data['orders'] = $this->Checkout_model->getOrder(array("orders_id"=>$orders_id, "customers_id"=>$this->data['temp_id']));
		//echo "<pre>";
		$tempOrdersData = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"temp_orders_id=$temp_orders_id and stock_status=2"));
		if(!empty($tempOrdersData))
		{
			$tempOrdersDetailsData = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders_details" , 'where'=>"temp_orders_id=$temp_orders_id"));

			if(!empty($tempOrdersDetailsData))
			{
				foreach($tempOrdersDetailsData as $tod)
				{
					//print_r($tod);
					$product_in_store_data = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"product_in_store" , 'where'=>"product_in_store_id=$tod->product_in_store_id"));
					if(!empty($product_in_store_data))
					{
						$product_in_store_data = $product_in_store_data[0];
						//print_r($product_in_store_data);
						$update_store_quantity['quantity'] = $product_in_store_data->quantity + $tod->prod_in_cart;
						$this->Common_Model->update_operation(array('table'=>'product_in_store' , 'data'=>$update_store_quantity , 'condition'=>"product_in_store_id=$tod->product_in_store_id"));
					}
				}
			}
			$this->Common_Model->update_operation(array('table'=>'temp_orders' , 'data'=>array("stock_status"=>1) , 'condition'=>"temp_orders_id=$temp_orders_id"));
		}
	}

	function do_payment_options()
	{
		if(!empty($_POST['merchant_id']) && !empty($_POST['amount']) && !empty($_POST['order_id']) && !empty($_POST['redirect_url']) && !empty($_POST['currency'])){
			$merchant_data='';
			$working_key=__pg_working_key__;//Shared by CCAVENUES
			$access_code=__pg_access_code__;//Shared by CCAVENUES

			require(APPPATH.'views/ccavenue/Crypto.php');
			foreach ($_POST as $key => $value){
				$merchant_data.=$key.'='.urlencode($value).'&';
			}

			$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
			$data['access_code']=$access_code;
			$data['encrypted_data']=$encrypted_data;
		//	print_r($_POST);
		//	print_r($_POST);
		//	exit;
			$this->load->view('do_payment_options', $data);
		}else{
			REDIRECT(MAINSITE);
		}
	}

	function payment_verify()
	{
		/*echo "<pre>";
		print_r($_POST);*/

		$this->load->view('payment_verify');
	}

	function order_confirmation_cod($o_data)
	{
		error_reporting(E_ALL);
		//echo "<pre>";	print_r($o_data);exit;
		$_POST = $o_data;
		$pg_r['post_response'] = $_POST;
		$pg_response_json = json_encode($pg_r);
		$orderData['status']='';
		if(!empty($_POST))
		{
			$orderData['status']=$_POST["status"];
			$orderData['mode']=$_POST["mode"];
			$orderData['mihpayid']=$_POST["mihpayid"];
			$orderData['firstname']=$_POST["udf2"];
			$orderData['amount']=$_POST["net_amount_debit"];
			$orderData['txnid']=$_POST["txnid"];
			$orderData['posted_hash']='';
			$orderData['key']='';
			$orderData['productinfo']='';
			$orderData['email']=$_POST["udf3"];
			$orderData['salt']='';
			$orderData['udf1'] = $_POST["udf1"];
			$orderData['udf2'] = $_POST["udf2"];
			$orderData['bank_ref_num'] = ''; if(!empty($_POST["bank_ref_num"]))  $orderData['bank_ref_num'] = $_POST["bank_ref_num"];
			$orderData['cardnum'] = ''; if(!empty($_POST["cardnum"]))  $orderData['cardnum'] = $_POST["cardnum"];
			$orderData['name_on_card'] = ''; if(!empty($_POST["name_on_card"]))  $orderData['name_on_card'] = $_POST["name_on_card"];
			$temp_order_id = $temp_orders_id =$_POST["udf1"];
		}
		//if($orderData['status']=='success' && $pv_status == 1 && $pv_txn_status == 'success')

		if($orderData['status']=='success' )
		{


			/*$r_payment_data['temp_order_id'] = $temp_order_id;
			$r_payment_data['orders_id'] = '';
			$r_payment_data['id'] = $cc_orderData["tracking_id"];
			$r_payment_data['entity'] = $cc_orderData["bank_ref_no"];
			$r_payment_data['amount'] = $cc_orderData["mer_amount"]*100;
			$r_payment_data['currency'] = 'INR';
			$r_payment_data['status'] = $cc_orderData["order_status"];
			$r_payment_data['order_id'] = '';
			$r_payment_data['invoice_id'] = '';
			$r_payment_data['international'] = '';
			$r_payment_data['method'] = $cc_orderData["payment_mode"];
			$r_payment_data['amount_refunded'] = '';
			$r_payment_data['refund_status'] = '';
			$r_payment_data['captured'] = '';
			$r_payment_data['description'] = '';
			$r_payment_data['card_id'] = '';
			$r_payment_data['bank'] = '';
			$r_payment_data['wallet'] = '';
			$r_payment_data['vpa'] = '';
			$r_payment_data['email'] = $cc_orderData["billing_email"];;
			$r_payment_data['contact'] = '';
			$r_payment_data['fee'] = '';
			$r_payment_data['tax'] = '';
			$r_payment_data['error_code'] = '';
			$r_payment_data['error_description'] = '';
			$r_payment_data['error_source'] = '';
			$r_payment_data['error_step'] = '';
			$r_payment_data['error_reason'] = '';
			$r_payment_data['created_at'] = time();
			$r_payment_data['stuck_order_status'] = 1;*/

			//$payment_response_id = $this->Common_Model->add_operation(array('table'=>'payment_response' , 'data'=>$r_payment_data));

			$page_data = array();
			$this->data['tempOrdersData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"(temp_orders_id=$orderData[udf1] and status=0)"));
			if(empty($this->data['tempOrdersData']))
				REDIRECT(base_url());
			$update_temp_orders_data['status']=1;
			$update_temp_orders_data['stuck_status']=1;
			$update_temp_orders_data['stock_status']=1;
			$this->Common_Model->update_operation(array('table'=>'temp_orders' , 'data'=>$update_temp_orders_data , 'condition'=>"(temp_orders_id=$orderData[udf1])"));
			$tempOrdersData = $this->data['tempOrdersData'][0];
			foreach($tempOrdersData as $key => $value)
			{
				$orderData[$key]=$value;
			}

			$orderData['is_cod'] = 1;
			$orderData['order_number'] = '';
			$orderData['order_status'] = 1;
			$orderData['order_status'] = 1;
			$orderData['pg_response_json'] = $pg_response_json;
			$orderData['status'] = 1;


			unset($orderData['tracking_id']);
			unset($orderData['bank_ref_num']);
			unset($orderData['order_status']);
			unset($orderData['failure_message']);
			//unset($orderData['payment_mode']);
			//unset($orderData['card_name']);
			unset($orderData['status_code']);
			unset($orderData['status_message']);
			unset($orderData['productinfo']);
			unset($orderData['salt']);
			unset($orderData['udf1']);
			unset($orderData['udf2']);
			unset($orderData['stuck_status']);
			unset($orderData['stock_status']);
			unset($orderData['bank_ref_no']);
			//$orderData['mode'] = $orderData['payment_mode'];
			unset($orderData['payment_mode']);

			unset($orderData['card_name']);

			$orderData['mihpayid'] = time().' - COD';
			$orderData['txnid'] = time().' - COD';
			$orderData['bank_ref_num'] = time().' - COD';

			$orders_id = $this->Common_Model->add_operation(array('table'=>'orders' , 'data'=>$orderData));

			$update_payment_response_data['orders_id']=$orders_id;
			//$this->Common_Model->update_operation(array('table'=>'payment_response' , 'data'=>$update_payment_response_data , 'condition'=>"(payment_response_id=$payment_response_id)"));

			if($orders_id>0)
			{

				$add_new_order_history_params = array('orders_id'=>$orders_id , 'order_status_id'=>1 , 'caption'=>'Order Placed');
				$orders_history_id = $this->_sosl->add_new_order_history($add_new_order_history_params);


				$this->data['tempOrdersDetailsData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders_details" , 'where'=>"temp_orders_id=$temp_orders_id"));
				foreach($this->data['tempOrdersDetailsData'] as $tpdd)
				{
					foreach($tpdd as $key => $value)
					{
						$orderDetailsData[$key]=$value;
					}
					unset($orderDetailsData['temp_orders_id']);
					unset($orderDetailsData['temp_orders_details_id']);
					$orderDetailsData['orders_id']=$orders_id;
					$orders_details_id = $this->Common_Model->add_operation(array('table'=>'orders_details' , 'data'=>$orderDetailsData));
				}

				$this->data['order_number'] = "#".__order_initial__."/".date('Y').'/'.date('m').'/'.date('d').'/'.$orders_id;
				$page_data['order_number'] = $this->data['order_number'];
				$page_data['date'] = date('M d Y');
				$page_data['txnid'] = $_POST["txnid"];
			}

			$update_orders_data['status']=$_POST["status"];

			$update_orders_data['mode']=$_POST["mode"];


			$update_orders_data['firstname']=$_POST["udf2"];
			$update_orders_data['amount']=$_POST["net_amount_debit"];
			$update_orders_data['txnid']=__order_initial__.'-T-'.$_POST["txnid"];
			$update_orders_data['posted_hash']='';
			$update_orders_data['key']='';
			$update_orders_data['productinfo']='';
			$update_orders_data['email']=$_POST["udf3"];
			$update_orders_data['salt']='';
			$update_orders_data['udf1'] = $_POST["udf1"];
			$update_orders_data['udf2'] = $_POST["udf1"];

			$temp_orders_id = $_POST["udf1"];
			$update_orders_data['customers_id'] = $this->data['temp_id'];
			$update_orders_data['stores_id']=$this->data['store_id'];

			unset($update_orders_data['productinfo']);
			unset($update_orders_data['salt']);
			unset($update_orders_data['udf1']);
			unset($update_orders_data['udf2']);
			unset($update_orders_data['tracking_id']);


			$update_orders_data['order_number']=$this->data['order_number'];
			$update_orders_data['order_status_id'] = 1;
			$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>$update_orders_data , 'condition'=>"(orders_id=$orders_id)"));
			$this->data['page_data'] = $page_data;
			$this->Common_Model->delete_operation(array("where"=>array('application_sess_temp_id' => $this->data['temp_id']) , "table"=>'temp_cart' ));
			$this->session->set_userdata('application_sess_cart_count' , '');
			$this->data['cart_count'] = '0';

			//mail and sms code start
			//print_r(array("orders_id"=>$orders_id , "customers_id"=>$this->data['temp_id']));
			$this->data['orders'] = $this->Checkout_model->getOrder(array("orders_id"=>$orders_id , "customers_id"=>$this->data['temp_id']));
			//print_r($this->data['orders']);

			$o=$this->data['orders'] = $this->data['orders'][0];
			//email sms code start
			//echo "<pre>";print_r($o);exit;
			$contact = $o->number;
			$template = "Dear $o->name, your order is confirmed. Your order id is $o->order_number. For more details login to your account "._SMS_BRAND_;
			//echo $template;
			$this->Common_Model->send_sms($contact , $template);

			//$template = "Dear Admin, your order is confirmed. Your order id is $o->order_number. For more details login to your account "._SMS_BRAND_.".";
			//echo $template;
			//$this->Common_Model->send_sms('9606580721' , $template);


			$mail_message = "Your "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> has been placed successfully.<br>We will update you the order processing action.";
			$shipping_address = $o->d_name.'<br>'.$o->d_number.'<br>'.$o->d_address.'<br>'.$o->d_city_name.' - '.$o->d_zipcode.'<br>'.$o->d_state_name.'<br>'.$o->d_country_name;
			$billing_address = $o->b_name.'<br>'.$o->b_number.'<br>'.$o->b_address.'<br>'.$o->b_city_name.' - '.$o->b_zipcode.'<br>'.$o->b_state_name.'<br>'.$o->b_country_name;
			$product_detail = "";
			foreach($o->details as $od)
			{
				$product_detail .="<tr>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$od->product_name ($od->combi)
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$od->prod_in_cart
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$o->symbol $od->final_price
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$o->symbol $od->sub_total
					</td>
				</tr>
				";
			}

			$ship_data='';
			if($o->shipping_discount>0)
			{
				$ship_data .= '<tr>
					<td colspan="3" style="font-family:Arial, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;border-collapse: collapse;">
					<strong>Shipping Discount</strong>
					</td>
					<td style="font-family:Arial, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;border-collapse: collapse;">-
						'.$o->symbol.' '.$o->shipping_discount.'
					</td>
				</tr>';
			}
			if($o->cod_charges>0)
			{
				$ship_data .= '<tr>
					<td colspan="3" style="font-family:Arial, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;border-collapse: collapse;">
					<strong>COD Charges</strong>
					</td>
					<td style="font-family:Arial, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;border-collapse: collapse;">
						'.$o->symbol.' '.$o->cod_charges.'
					</td>
				</tr>';
			}
			$mailMessage = file_get_contents(APPPATH.'mailer/orders.html');
			$mailMessage = str_replace("#name#",stripslashes($o->name),$mailMessage);
			$mailMessage = str_replace("#order_number#",stripslashes($o->order_number),$mailMessage);
			$mailMessage = str_replace("#mode#",stripslashes($o->mode),$mailMessage);
			$mailMessage = str_replace("#added_on#",stripslashes(date("d M y" , strtotime($o->added_on))),$mailMessage);
			$mailMessage = str_replace("#txnid#",stripslashes($o->mihpayid),$mailMessage);
			$mailMessage = str_replace("#shipping_address#",stripslashes($shipping_address),$mailMessage);
			$mailMessage = str_replace("#billing_address#",stripslashes($billing_address),$mailMessage);
			$mailMessage = str_replace("#order_status#",stripslashes("Order Placed"),$mailMessage);
			$mailMessage = str_replace("#mail_message#",stripslashes($mail_message),$mailMessage);
			$mailMessage = str_replace("#delivery_charges#",stripslashes($o->symbol.' '.$o->delivery_charges),$mailMessage);
			$mailMessage = str_replace("#total_packing_charges#",stripslashes($o->symbol.' '.$o->total_packing_charges),$mailMessage);
			$mailMessage = str_replace("#total#",stripslashes($o->symbol.' '.$o->total),$mailMessage);
			$mailMessage = str_replace("#product_detail#",$product_detail,$mailMessage);
			$mailMessage = str_replace("#ship_data#",$ship_data,$mailMessage);
			$mailMessage = str_replace("#total_gst#",stripslashes($o->symbol.' '.$o->total_gst),$mailMessage);

			$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
			//$mailMessage = str_replace("#mainsitepp#",base_url().__privacyPolicy__,$mailMessage);
			$mailMessage = str_replace("#mainsitecontact#",base_url().__contactUs__,$mailMessage);
			//$mailMessage = str_replace("#mainsitefaq#",base_url().__faq__,$mailMessage);
			$mailMessage = str_replace("#mainsiteaccount#",base_url().__dashboard__,$mailMessage);

			$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
			$mailMessage = str_replace("#social_media#","",$mailMessage);
			$mailMessage = str_replace("#project_contact#",_project_contact_,$mailMessage);
			$mailMessage = str_replace("#project_contact_without_space#",_project_contact_without_space_,$mailMessage);
			$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
			$mailMessage = str_replace("#project_website#",_project_web_,$mailMessage);
			$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);



			$subject = "Your Order Placed Successfully. Order No.: $o->order_number !"._brand_name_;
			$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$o->email , "name"=>$o->name ));

			$subject = "New Order Placed. Order No.: $o->order_number !"._brand_name_;
			$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>__adminemail__ , "name"=>'Admin' ));

			$this->data['order_success_g_tag'] = "";

			$this->data['order_success_amp_triggers'] = '';

			//echo $mailMessage;
			//email sms code end
			parent::getHeader('header' , $this->data);
			$this->load->view('order_confirmation',$this->data);
			parent::getFooter('footer' , $this->data);
		}
		else
		{
			//echo "<pre>";print_r($_POST);echo "</pre>";
			//echo "<pre>";print_r($orderData);echo "</pre>";
			//exit;

			if(!empty($orderData['udf1']))
			{
				/*if(!empty($_POST["status_message"]))
					$order_fail_data['status_message'] = $_POST["status_message"];
				if(!empty($_POST["error_Message"]))
					$order_fail_data['error_Message'] = $_POST["error_Message"];
				if(!empty($_POST["mihpayid"]))
					$order_fail_data['mihpayid'] = $_POST["mihpayid"];
				if(!empty($_POST["amount"]))
					$order_fail_data['amount'] = $_POST["amount"];
				if(!empty($_POST["txnid"]))
					$order_fail_data['txnid'] = $_POST["txnid"];*/

				if(!empty($_POST["error_Message"]))
					$update_temp_orders_data['status_message']=$_POST["error_Message"];;
				if(!empty($_POST["mihpayid"]))
					$update_temp_orders_data['tracking_id']=$_POST["mihpayid"];
				if(!empty($_POST["field8"]))
					$update_temp_orders_data['failure_message']=$_POST["field8"];


				$update_temp_orders_data['pg_response']=json_encode($_POST);

				/*$update_temp_orders_data['bank_ref_no']=$_POST["bank_ref_no"];
				$update_temp_orders_data['order_status']=$_POST["order_status"];
				$update_temp_orders_data['failure_message']=$_POST["failure_message"];
				$update_temp_orders_data['payment_mode']=$_POST["mode"];
				$update_temp_orders_data['card_name']=$_POST["card_name"];
				$update_temp_orders_data['status_code']=$_POST["status_code"];*/

				$update_temp_orders_data['stuck_status ']=3;
				$this->Common_Model->update_operation(array('table'=>'temp_orders' , 'data'=>$update_temp_orders_data , 'condition'=>"(temp_orders_id=$orderData[udf1])"));

				 $this->order_stock_plus($orderData['udf1']);

				$this->data['tempOrdersDetailsData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"temp_orders_id=$orderData[udf1]"));
				$this->data['tempOrdersDetailsData'] = $this->data['tempOrdersDetailsData'][0];
			}



			parent::getHeader('header' , $this->data);
			$this->load->view('order_fail',$this->data);
			parent::getFooter('footer' , $this->data);
		}
	}

	function order_confirmation()
	{


			//$merchantId = 'PGTESTPAYUAT'; // sandbox or test merchantId
			$merchantId = 'M15OM4UUWBBX'; // live
			//$apiKey="099eb0cd-02cf-4e2a-8aca-3e6c6aff0399"; // sandbox
			$apiKey="b6b49ce7-898b-46fb-84a4-55089212345e"; //  APIKEY Live
			 $salt_index = 1;


			 $transactionId = $_SESSION['Order_Id'];
			 //echo $_SESSION['Order_Id'];
			// $payload = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status" . $apiKey;
			 $payload = "/pg/v1/status/$merchantId/$transactionId".$apiKey;
			 $sha256 = hash("sha256", $payload);
			 $final_x_header = $sha256 . '###' . $salt_index;
			 $curl = curl_init();
			 curl_setopt_array($curl, [

				 //CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/$merchantId/$transactionId", //TEST
				 CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/status/$merchantId/$transactionId", //LIVE
				 CURLOPT_RETURNTRANSFER => true,
		 	 //  CURLOPT_ENCODING => "",
		 	 //  CURLOPT_MAXREDIRS => 10,
		 	 //  CURLOPT_TIMEOUT => 30,
		 	 // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		 	  CURLOPT_CUSTOMREQUEST => "GET",
		 	  CURLOPT_HTTPHEADER => [
		 	    "Content-Type: application/json",
		 	    "X-VERIFY: " . $final_x_header,
		 	    "X-MERCHANT-ID: " . $merchantId

		 	  ],
			 ]);

			 $response = curl_exec($curl);
			 $err = curl_error($curl);
			 /*echo 'ssss';
			 print_r($response);
			 die;*/
			 curl_close($curl);
			 if ($err) {
				 echo 'error';
				 print_r($err);
				exit;
			 } else {
					$res = json_decode($response);
					/*echo 'tesstt';
					 print_r($res);
					 die;*/
					if(isset($res->success) && $res->success=='1'){
					$orderData['status']='';
					$pv_status = '';
					$pv_txn_status = '';
					$pv_transaction_amount = '';
					$pv_udf1 = '';

					$orderData['status']='';
				//	print_r($_POST);

						$pv_status = $pv_txn_status = $orderData['status']=$res->success;
					//	$orderData['mode']=$_POST["mode"];
						$orderData['mihpayid']=$res->data->transactionId;
					//	$orderData['firstname']=$_POST["firstname"];
						$pv_transaction_amount = $orderData['amount']=(int)$res->data->amount/100;
						$orderData['txnid']=	$res->data->merchantTransactionId;

					 $orderData['udf1'] = $res->data->merchantTransactionId;
						 $orderData['udf2'] = $res->data->merchantTransactionId;
						// $orderData['cardnum'] = $_POST["cardnum"];
						// $orderData['name_on_card'] = $_POST["name_on_card"];
						$pv_udf1 = $temp_orders_id = $res->data->merchantTransactionId;




					 $sess__pg_amount = $this->session->userdata('pg_amount');
					 $sess__pg_temp_orders_id = $this->session->userdata('pg_temp_orders_id');


					if((empty($sess__pg_amount) || empty($sess__pg_temp_orders_id)) && !empty($pv_udf1))
					{

						$temp_o_data = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"(temp_orders_id=$pv_udf1)"));
						if(!empty($temp_o_data))
						{
							$temp_o_data = $temp_o_data[0];
							$sess__pg_amount = $temp_o_data->total;
							$sess__pg_temp_orders_id = $temp_o_data->temp_orders_id;
						}
					}




					$pv_transaction_amount = $sess__pg_amount;

					if($res->success){

							//create a order

										$page_data = array();
										$this->data['tempOrdersData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"(temp_orders_id=$orderData[udf1] and status=0)"));
										if(empty($this->data['tempOrdersData']))
											REDIRECT(base_url());
										$update_temp_orders_data['status']=1;
										$update_temp_orders_data['stuck_status']=1;
										$update_temp_orders_data['stock_status']=1;
										$this->Common_Model->update_operation(array('table'=>'temp_orders' , 'data'=>$update_temp_orders_data , 'condition'=>"(temp_orders_id=$orderData[udf1])"));
										$tempOrdersData = $this->data['tempOrdersData'][0];
										foreach($tempOrdersData as $key => $value)
										{
											$orderData[$key]=$value;
										}

										$orderData['order_number'] = '';
										$orderData['order_status'] = 1;
										$orderData['order_status'] = 1;
										$orderData['pg_response_json'] = $response;
										$orderData['status'] = 1;


										unset($orderData['tracking_id']);
										//unset($orderData['bank_ref_num']);
										unset($orderData['order_status']);
										unset($orderData['failure_message']);
										//unset($orderData['payment_mode']);
										//unset($orderData['card_name']);
										unset($orderData['status_code']);
										unset($orderData['status_message']);
										unset($orderData['productinfo']);
										unset($orderData['error']);
										unset($orderData['salt']);
										unset($orderData['udf1']);
										unset($orderData['udf2']);
										unset($orderData['stuck_status']);
										unset($orderData['stock_status']);
										unset($orderData['bank_ref_no']);
										//$orderData['mode'] = $orderData['payment_mode'];
										unset($orderData['payment_mode']);

										unset($orderData['card_name']);
										//$orderData['bank_ref_num'] = time().' - ONLINE';


										$orders_id = $this->Common_Model->add_operation(array('table'=>'orders' , 'data'=>$orderData));
										//echo $this->db->last_query();
										//exit;

										$update_payment_response_data['orders_id']=$orders_id;
										//$this->Common_Model->update_operation(array('table'=>'payment_response' , 'data'=>$update_payment_response_data , 'condition'=>"(payment_response_id=$payment_response_id)"));

										if($orders_id>0)
										{

											$add_new_order_history_params = array('orders_id'=>$orders_id , 'order_status_id'=>1 , 'caption'=>'Order Placed');
											$orders_history_id = $this->_sosl->add_new_order_history($add_new_order_history_params);


											$this->data['tempOrdersDetailsData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders_details" , 'where'=>"temp_orders_id=$temp_orders_id"));
											foreach($this->data['tempOrdersDetailsData'] as $tpdd)
											{
												foreach($tpdd as $key => $value)
												{
													$orderDetailsData[$key]=$value;
												}
												unset($orderDetailsData['temp_orders_id']);
												unset($orderDetailsData['temp_orders_details_id']);
												$orderDetailsData['orders_id']=$orders_id;
												$orders_details_id = $this->Common_Model->add_operation(array('table'=>'orders_details' , 'data'=>$orderDetailsData));
											}

											$this->data['order_number'] = "#".__order_initial__."/".date('Y').'/'.date('m').'/'.date('d').'/'.$orders_id;
											$page_data['order_number'] = $this->data['order_number'];
											$page_data['date'] = date('M d Y');
											$page_data['txnid'] = $res->data->merchantTransactionId;
										}

										$update_orders_data['status']=$res->data->responseCode;
										$update_orders_data['mode']=$res->data->paymentInstrument->type;
										$update_orders_data['mihpayid']=$res->data->merchantTransactionId;

										$update_orders_data['amount']=($res->data->amount)/100;
										$update_orders_data['txnid']=$res->data->merchantTransactionId;
										$update_orders_data['posted_hash']='';
										$update_orders_data['key']='';
										$update_orders_data['productinfo']='';
										//$update_orders_data['email']=$_POST["udf3"];
										$update_orders_data['salt']='';
										$update_orders_data['udf1'] = $res->data->merchantTransactionId;
										$update_orders_data['udf2'] = $res->data->merchantTransactionId;

										$temp_orders_id = $res->data->merchantTransactionId;
										$update_orders_data['customers_id'] = $this->data['temp_id'];
										$update_orders_data['stores_id']=$this->data['store_id'];

										unset($update_orders_data['productinfo']);
										unset($update_orders_data['salt']);
										unset($update_orders_data['udf1']);
										unset($update_orders_data['udf2']);
										unset($update_orders_data['tracking_id']);


										$update_orders_data['order_number']=$this->data['order_number'];
										$update_orders_data['order_status_id'] = 1;
										$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>$update_orders_data , 'condition'=>"(orders_id=$orders_id)"));
										$this->session->set_flashdata('orders_id', $orders_id);
										$this->data['page_data'] = $page_data;

										$this->Common_Model->delete_operation(array("where"=>array('application_sess_temp_id' => $this->data['temp_id']) , "table"=>'temp_cart' ));
										$this->session->set_userdata('application_sess_cart_count' , '');
										$this->data['cart_count'] = '0';

										//mail and sms code start
										$this->data['orders'] = $this->Checkout_model->getOrder(array("orders_id"=>$orders_id , "customers_id"=>$this->data['temp_id']));
										//print_r($this->data['orders']);

										$o=$this->data['orders'] = $this->data['orders'][0];

										//email sms code start
										$contact = $o->number;
										$template = "Dear $o->name, your order is confirmed. Your order id is $o->order_number. For more details login to your account "._SMS_BRAND_;
											$this->Common_Model->send_sms($contact , $template);
										$contact = $o->number;
										$template = "Dear $o->name, thank you for choosing "._SMS_BRAND_;
										//echo $template;
										$this->Common_Model->send_sms($contact , $template);

										$template = "Dear Admin, you have a new order. Order id is $o->order_number. For more details login to your account "._SMS_BRAND_;
										//echo $template;
										$this->Common_Model->send_sms(__adminsms__ , $template);

										if(!empty($o->email)){
											$mail_message = "Your "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> has been placed successfully.<br>We will update you the order processing action.";
											$shipping_address = $o->d_name.'<br>'.$o->d_number.'<br>'.$o->d_address.'<br>'.$o->d_city_name.' - '.$o->d_zipcode.'<br>'.$o->d_state_name.'<br>'.$o->d_country_name;
											$billing_address = $o->b_name.'<br>'.$o->b_number.'<br>'.$o->b_address.'<br>'.$o->b_city_name.' - '.$o->b_zipcode.'<br>'.$o->b_state_name.'<br>'.$o->b_country_name;
											$product_detail = "";
											foreach($o->details as $od)
											{
												$product_detail .="<tr>
													<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
														$od->product_name ($od->combi)
													</td>
													<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
														$od->prod_in_cart
													</td>
													<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
														$o->symbol $od->final_price
													</td>
													<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
														$o->symbol $od->sub_total
													</td>
												</tr>
												";
											}
											$ship_data = '';
											if($o->shipping_discount>0)
											{
												$ship_data .= '<tr>
													<td colspan="3" style="font-family:Arial, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;border-collapse: collapse;">
													<strong>Shipping Discount</strong>
													</td>
													<td style="font-family:Arial, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;border-collapse: collapse;">-
														'.$o->symbol.' '.$o->shipping_discount.'
													</td>
												</tr>';
											}
											if($o->cod_charges>0)
											{
												$ship_data .= '<tr>
													<td colspan="3" style="font-family:Arial, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;border-collapse: collapse;">
													<strong>COD Charges</strong>
													</td>
													<td style="font-family:Arial, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;border-collapse: collapse;">
														'.$o->symbol.' '.$o->cod_charges.'
													</td>
												</tr>';
											}

											$mailMessage = file_get_contents(APPPATH.'mailer/orders.html');
											$mailMessage = str_replace("#name#",stripslashes($o->name),$mailMessage);
											$mailMessage = str_replace("#order_number#",stripslashes($o->order_number),$mailMessage);
											$mailMessage = str_replace("#mode#",stripslashes($o->mode),$mailMessage);
											$mailMessage = str_replace("#added_on#",stripslashes(date("d M y" , strtotime($o->added_on))),$mailMessage);
											$mailMessage = str_replace("#txnid#",stripslashes($o->txnid),$mailMessage);
											$mailMessage = str_replace("#shipping_address#",stripslashes($shipping_address),$mailMessage);
											$mailMessage = str_replace("#billing_address#",stripslashes($billing_address),$mailMessage);
											$mailMessage = str_replace("#order_status#",stripslashes("Order Placed"),$mailMessage);
											$mailMessage = str_replace("#mail_message#",stripslashes($mail_message),$mailMessage);
											$mailMessage = str_replace("#delivery_charges#",stripslashes($o->symbol.' '.$o->delivery_charges),$mailMessage);
											$mailMessage = str_replace("#total_packing_charges#",stripslashes($o->symbol.' '.$o->total_packing_charges),$mailMessage);
											$mailMessage = str_replace("#total#",stripslashes($o->symbol.' '.$o->total),$mailMessage);
											$mailMessage = str_replace("#product_detail#",$product_detail,$mailMessage);
											$mailMessage = str_replace("#ship_data#",$ship_data,$mailMessage);
											$mailMessage = str_replace("#total_gst#",stripslashes($o->symbol.' '.$o->total_gst),$mailMessage);

											$mailMessage = str_replace("#project_contact#",_project_contact_,$mailMessage);
											$mailMessage = str_replace("#project_contact_without_space#",_project_contact_without_space_,$mailMessage);
											$mailMessage = str_replace("#project_complete_name#",_project_complete_name_,$mailMessage);
											$mailMessage = str_replace("#project_website#",_project_web_,$mailMessage);
											$mailMessage = str_replace("#project_email#",__adminemail__,$mailMessage);
											$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
											$social_media = '';
											if(_FACEBOOK_!='')
												$social_media = $social_media.'<a href="'._FACEBOOK_.'" target="_blank" ><img src="'.IMAGE.'email/facebook.png" width="25"></a>';
											if(_INSTAGRAM_!='')
												$social_media = $social_media.'<a href="'._INSTAGRAM_.'" target="_blank" ><img src="'.IMAGE.'email/instagram.png" width="25"></a>';
											if(_PINTEREST_!='')
												$social_media = $social_media.'<a href="'._PINTEREST_.'" target="_blank" ><img src="'.IMAGE.'email/pinterest.png" width="25"></a>';
											if(_TWITTER_!='')
												$social_media = $social_media.'<a href="'._TWITTER_.'" target="_blank" ><img src="'.IMAGE.'email/twitter.png" width="25"></a>';
											if(_LINKEDIN_!='')
												$social_media = $social_media.'<a href="'._LINKEDIN_.'" target="_blank" ><img src="'.IMAGE.'email/linkedin.png" width="25"></a>';
											if(_YOUTUBE_!='')
												$social_media = $social_media.'<a href="'._YOUTUBE_.'" target="_blank" ><img src="'.IMAGE.'email/youtube.png" width="25"></a>';
											$mailMessage = str_replace("#social_media#",$social_media,$mailMessage);
											$mailMessage = str_replace("#mainsiteaccount#",base_url().__dashboard__,$mailMessage);

											$subject = "Your Order Placed Successfully. Order No.: $o->order_number !"._brand_name_;
											$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$o->email , "name"=>$o->name ));
											//$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>'anil@marswebsolutions.com' , "name"=>$o->name ));

											$subject = "New Order Placed. Order No.: $o->order_number !"._brand_name_;
											$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>__adminemail__ , "name"=>'Admin' ));

										}

										$this->data['order_success_g_tag'] = "";
										$this->session->set_flashdata('orders_id', $orders_id);
										$this->data['order_success_amp_triggers'] = '';
										// echo '<pre>';
										// print_r($this->data['orders'] );
										// echo '<pre>';
										//die;

										// echo $mailMessage;
										// die;
									//	echo json_encode(array("status"=>1));
										//REDIRECT(base_url().__orderStatus__);
										//echo $mailMessage;
										//email sms code end

										parent::getHeader('header' , $this->data);
										$this->load->view('order_confirmation',$this->data);
										parent::getFooter('footer' , $this->data);





					}
				}else{


						//echo "<pre>";print_r($_POST);echo "</pre>";
						//echo "<pre>";print_r($orderData);echo "</pre>";
						//exit;


						if(!empty($orderData['udf1']))
						{
							/*if(!empty($_POST["status_message"]))
								$order_fail_data['status_message'] = $_POST["status_message"];
							if(!empty($_POST["error_Message"]))
								$order_fail_data['error_Message'] = $_POST["error_Message"];
							if(!empty($_POST["mihpayid"]))
								$order_fail_data['mihpayid'] = $_POST["mihpayid"];
							if(!empty($_POST["amount"]))
								$order_fail_data['amount'] = $_POST["amount"];
							if(!empty($_POST["txnid"]))
								$order_fail_data['txnid'] = $_POST["txnid"];*/

							if(!empty($_POST["error_Message"]))
								$update_temp_orders_data['status_message']=$_POST["error_Message"];;
							if(!empty($_POST["mihpayid"]))
								$update_temp_orders_data['tracking_id']=$_POST["mihpayid"];
							if(!empty($_POST["field8"]))
								$update_temp_orders_data['failure_message']=$_POST["field8"];


							$update_temp_orders_data['pg_response']=json_encode($_POST);

							/*$update_temp_orders_data['bank_ref_no']=$_POST["bank_ref_no"];
							$update_temp_orders_data['order_status']=$_POST["order_status"];
							$update_temp_orders_data['failure_message']=$_POST["failure_message"];
							$update_temp_orders_data['payment_mode']=$_POST["mode"];
							$update_temp_orders_data['card_name']=$_POST["card_name"];
							$update_temp_orders_data['status_code']=$_POST["status_code"];*/

							$update_temp_orders_data['stuck_status ']=3;
							$this->Common_Model->update_operation(array('table'=>'temp_orders' , 'data'=>$update_temp_orders_data , 'condition'=>"(temp_orders_id=$orderData[udf1])"));
							$this->order_stock_plus($orderData['udf1']);

							$this->data['tempOrdersDetailsData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"temp_orders_id=$orderData[udf1]"));
							$this->data['tempOrdersDetailsData'] = $this->data['tempOrdersDetailsData'][0];
						}

							echo json_encode(array("status"=>0,'message'=>'Payment Failed'));
							die;



						parent::getHeader('header' , $this->data);
						$this->load->view('order_fail',$this->data);
						parent::getFooter('footer' , $this->data);


					}

				}
				// echo "<pre>";
			  //  print_r($res);
				//  		echo "</pre>";
					//	die;
			// foreach ($res as $r) {
			// 	$success = 	$r->success;
			// }


	}

	function order_confirmation_old()
	{
		error_reporting(E_ALL);
		//echo "<pre>";	print_r($_POST);//exit;

		$orderData['status']='';
		error_reporting(0);

		$pv_status = '';
		$pv_txn_status = '';
		$pv_transaction_amount = '';
		$pv_udf1 = '';

		$orderData['status']='';
		if(!empty($orderData))
		{
			$pv_status = $pv_txn_status = $orderData['status']=$_POST["status"];
			$orderData['mode']=$_POST["mode"];
			$orderData['mihpayid']=$_POST["easepayid"];
			$orderData['firstname']=$_POST["firstname"];
			$pv_transaction_amount = $orderData['amount']=$_POST["net_amount_debit"];
			$orderData['txnid']=$_POST["txnid"];
			//$orderData['error_Message']=$_POST["error_Message"];
			$orderData['bank_ref_num']=$_POST["bank_ref_num"];
			$orderData['posted_hash']=$_POST["hash"];
			$orderData['key']=$_POST["key"];
			$orderData['productinfo']=$_POST["productinfo"];
			$orderData['email']=$_POST["email"];
			$orderData['error']=$_POST["error"];
			$orderData['salt']='';
			$orderData['udf1'] = $_POST["txnid"];
			$orderData['udf2'] = $_POST["txnid"];
			$orderData['cardnum'] = $_POST["cardnum"];
			$orderData['name_on_card'] = $_POST["name_on_card"];
			$pv_udf1 = $temp_orders_id = $_POST["txnid"];
		}


		$sess__pg_amount = $this->session->userdata('pg_amount');
		$sess__pg_temp_orders_id = $this->session->userdata('pg_temp_orders_id');

		if((empty($sess__pg_amount) || empty($sess__pg_temp_orders_id)) && !empty($pv_udf1))
		{
			$temp_o_data = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"(temp_orders_id=$pv_udf1)"));
			if(!empty($temp_o_data))
			{
				$temp_o_data = $temp_o_data[0];
				$sess__pg_amount = $temp_o_data->total;
				$sess__pg_temp_orders_id = $temp_o_data->temp_orders_id;
			}
		}

		/*if($orderData['status']=='success' && $pv_txn_status == 'success' && $pv_transaction_amount == $sess__pg_amount && $sess__pg_temp_orders_id == $pv_udf1)
		{
			echo "if";
		}
		else
		{
			echo "else";
		}
		echo "<br>";

		echo $orderData['status']."<br>";
		echo $pv_status."<br>";
		echo $pv_txn_status."<br>";
		echo $pv_transaction_amount."<br>";
		echo $pv_udf1."<br>";
		echo $sess__pg_amount."<br>";
		echo $sess__pg_temp_orders_id."<br>";
		echo $pv_udf1."<br>";*/

		//exit;

		/*echo $orderData['status']."<br>";
		echo $pv_status."<br>";
		echo $pv_txn_status."<br>";
		echo $pv_transaction_amount."<br>";
		echo $pv_udf1."<br>";
		echo $sess__pg_amount."<br>";
		echo $sess__pg_temp_orders_id."<br>";
		echo $pv_udf1."<br>";

		if(1==1.00)
		{

			echo "fer";
		}

		if($orderData['status']=='success' && $pv_status == 1 && $pv_txn_status == 'success' && $pv_transaction_amount == $sess__pg_amount && $sess__pg_temp_orders_id == $pv_udf1)
		{
			echo "if";
		}

		exit;*/



		$pv_transaction_amount = $sess__pg_amount;

		if($orderData['status']=='success' && $pv_txn_status == 'success' && $pv_transaction_amount == $sess__pg_amount && $sess__pg_temp_orders_id == $pv_udf1)
		{


			/*$r_payment_data['temp_order_id'] = $temp_order_id;
			$r_payment_data['orders_id'] = '';
			$r_payment_data['id'] = $cc_orderData["tracking_id"];
			$r_payment_data['entity'] = $cc_orderData["bank_ref_no"];
			$r_payment_data['amount'] = $cc_orderData["mer_amount"]*100;
			$r_payment_data['currency'] = 'INR';
			$r_payment_data['status'] = $cc_orderData["order_status"];
			$r_payment_data['order_id'] = '';
			$r_payment_data['invoice_id'] = '';
			$r_payment_data['international'] = '';
			$r_payment_data['method'] = $cc_orderData["payment_mode"];
			$r_payment_data['amount_refunded'] = '';
			$r_payment_data['refund_status'] = '';
			$r_payment_data['captured'] = '';
			$r_payment_data['description'] = '';
			$r_payment_data['card_id'] = '';
			$r_payment_data['bank'] = '';
			$r_payment_data['wallet'] = '';
			$r_payment_data['vpa'] = '';
			$r_payment_data['email'] = $cc_orderData["billing_email"];;
			$r_payment_data['contact'] = '';
			$r_payment_data['fee'] = '';
			$r_payment_data['tax'] = '';
			$r_payment_data['error_code'] = '';
			$r_payment_data['error_description'] = '';
			$r_payment_data['error_source'] = '';
			$r_payment_data['error_step'] = '';
			$r_payment_data['error_reason'] = '';
			$r_payment_data['created_at'] = time();
			$r_payment_data['stuck_order_status'] = 1;*/

			//$payment_response_id = $this->Common_Model->add_operation(array('table'=>'payment_response' , 'data'=>$r_payment_data));

			$page_data = array();
			$this->data['tempOrdersData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"(temp_orders_id=$orderData[udf1] and status=0)"));
			if(empty($this->data['tempOrdersData']))
				REDIRECT(base_url());
			$update_temp_orders_data['status']=1;
			$update_temp_orders_data['stuck_status']=1;
			$update_temp_orders_data['stock_status']=1;
			$this->Common_Model->update_operation(array('table'=>'temp_orders' , 'data'=>$update_temp_orders_data , 'condition'=>"(temp_orders_id=$orderData[udf1])"));
			$tempOrdersData = $this->data['tempOrdersData'][0];
			foreach($tempOrdersData as $key => $value)
			{
				$orderData[$key]=$value;
			}

			$orderData['order_number'] = '';
			$orderData['order_status'] = 1;
			$orderData['order_status'] = 1;
			$orderData['pg_response_json'] = json_encode($_POST);
			$orderData['status'] = 1;


			unset($orderData['tracking_id']);
			//unset($orderData['bank_ref_num']);
			unset($orderData['order_status']);
			unset($orderData['failure_message']);
			//unset($orderData['payment_mode']);
			//unset($orderData['card_name']);
			unset($orderData['status_code']);
			unset($orderData['status_message']);
			unset($orderData['productinfo']);
			unset($orderData['error']);
			unset($orderData['salt']);
			unset($orderData['udf1']);
			unset($orderData['udf2']);
			unset($orderData['stuck_status']);
			unset($orderData['stock_status']);
			unset($orderData['bank_ref_no']);
			//$orderData['mode'] = $orderData['payment_mode'];
			unset($orderData['payment_mode']);

			unset($orderData['card_name']);
			//$orderData['bank_ref_num'] = time().' - ONLINE';


			$orders_id = $this->Common_Model->add_operation(array('table'=>'orders' , 'data'=>$orderData));
			//echo $this->db->last_query();
			//exit;

			$update_payment_response_data['orders_id']=$orders_id;
			//$this->Common_Model->update_operation(array('table'=>'payment_response' , 'data'=>$update_payment_response_data , 'condition'=>"(payment_response_id=$payment_response_id)"));

			if($orders_id>0)
			{

				$add_new_order_history_params = array('orders_id'=>$orders_id , 'order_status_id'=>1 , 'caption'=>'Order Placed');
				$orders_history_id = $this->_sosl->add_new_order_history($add_new_order_history_params);


				$this->data['tempOrdersDetailsData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders_details" , 'where'=>"temp_orders_id=$temp_orders_id"));
				foreach($this->data['tempOrdersDetailsData'] as $tpdd)
				{
					foreach($tpdd as $key => $value)
					{
						$orderDetailsData[$key]=$value;
					}
					unset($orderDetailsData['temp_orders_id']);
					unset($orderDetailsData['temp_orders_details_id']);
					$orderDetailsData['orders_id']=$orders_id;
					$orders_details_id = $this->Common_Model->add_operation(array('table'=>'orders_details' , 'data'=>$orderDetailsData));
				}

				$this->data['order_number'] = "#".__order_initial__."/".date('Y').'/'.date('m').'/'.date('d').'/'.$orders_id;
				$page_data['order_number'] = $this->data['order_number'];
				$page_data['date'] = date('M d Y');
				$page_data['txnid'] = $_POST["txnid"];
			}

			$update_orders_data['status']=$_POST["status"];
			$update_orders_data['mode']=$_POST["mode"];
			$update_orders_data['mihpayid']=$_POST["mihpayid"];
			$update_orders_data['firstname']=$_POST["udf2"];
			$update_orders_data['amount']=$_POST["net_amount_debit"];
			$update_orders_data['txnid']=$_POST["txnid"];
			$update_orders_data['posted_hash']='';
			$update_orders_data['key']='';
			$update_orders_data['productinfo']='';
			$update_orders_data['email']=$_POST["udf3"];
			$update_orders_data['salt']='';
			$update_orders_data['udf1'] = $_POST["udf1"];
			$update_orders_data['udf2'] = $_POST["udf1"];

			$temp_orders_id = $_POST["udf1"];
			$update_orders_data['customers_id'] = $this->data['temp_id'];
			$update_orders_data['stores_id']=$this->data['store_id'];

			unset($update_orders_data['productinfo']);
			unset($update_orders_data['salt']);
			unset($update_orders_data['udf1']);
			unset($update_orders_data['udf2']);
			unset($update_orders_data['tracking_id']);


			$update_orders_data['order_number']=$this->data['order_number'];
			$update_orders_data['order_status_id'] = 1;
			$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>$update_orders_data , 'condition'=>"(orders_id=$orders_id)"));
			$this->data['page_data'] = $page_data;
			$this->Common_Model->delete_operation(array("where"=>array('application_sess_temp_id' => $this->data['temp_id']) , "table"=>'temp_cart' ));
			$this->session->set_userdata('application_sess_cart_count' , '');
			$this->data['cart_count'] = '0';

			//mail and sms code start
			$this->data['orders'] = $this->Checkout_model->getOrder(array("orders_id"=>$orders_id , "customers_id"=>$this->data['temp_id']));
			//print_r($this->data['orders']);

			$o=$this->data['orders'] = $this->data['orders'][0];

			//email sms code start
			$contact = $o->number;
			$template = "Dear $o->name, your order is confirmed. Your order id is $o->order_number. For more details login to your account "._SMS_BRAND_;
			//echo $template;
			$this->Common_Model->send_sms($contact , $template);

			//$template = "Dear Admin, your order is confirmed. Your order id is $o->order_number. For more details login to your account "._SMS_BRAND_;
			//echo $template;
			//$this->Common_Model->send_sms('9606580721' , $template);


			$mail_message = "Your "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> has been placed successfully.<br>We will update you the order processing action.";
			$shipping_address = $o->d_name.'<br>'.$o->d_number.'<br>'.$o->d_address.'<br>'.$o->d_city_name.' - '.$o->d_zipcode.'<br>'.$o->d_state_name.'<br>'.$o->d_country_name;
			$billing_address = $o->b_name.'<br>'.$o->b_number.'<br>'.$o->b_address.'<br>'.$o->b_city_name.' - '.$o->b_zipcode.'<br>'.$o->b_state_name.'<br>'.$o->b_country_name;
			$product_detail = "";
			foreach($o->details as $od)
			{
				$product_detail .="<tr>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$od->product_name ($od->combi)
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$od->prod_in_cart
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$o->symbol $od->final_price
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$o->symbol $od->sub_total
					</td>
				</tr>
				";
			}
			$ship_data = '';
			if($o->shipping_discount>0)
			{
				$ship_data .= '<tr>
					<td colspan="3" style="font-family:Arial, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;border-collapse: collapse;">
					<strong>Shipping Discount</strong>
					</td>
					<td style="font-family:Arial, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;border-collapse: collapse;">-
						'.$o->symbol.' '.$o->shipping_discount.'
					</td>
				</tr>';
			}
			if($o->cod_charges>0)
			{
				$ship_data .= '<tr>
					<td colspan="3" style="font-family:Arial, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;border-collapse: collapse;">
					<strong>COD Charges</strong>
					</td>
					<td style="font-family:Arial, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;border-collapse: collapse;">
						'.$o->symbol.' '.$o->cod_charges.'
					</td>
				</tr>';
			}

			$mailMessage = file_get_contents(APPPATH.'mailer/orders.html');
			$mailMessage = str_replace("#name#",stripslashes($o->name),$mailMessage);
			$mailMessage = str_replace("#order_number#",stripslashes($o->order_number),$mailMessage);
			$mailMessage = str_replace("#mode#",stripslashes($o->mode),$mailMessage);
			$mailMessage = str_replace("#added_on#",stripslashes(date("d M y" , strtotime($o->added_on))),$mailMessage);
			$mailMessage = str_replace("#txnid#",stripslashes($o->txnid),$mailMessage);
			$mailMessage = str_replace("#shipping_address#",stripslashes($shipping_address),$mailMessage);
			$mailMessage = str_replace("#billing_address#",stripslashes($billing_address),$mailMessage);
			$mailMessage = str_replace("#order_status#",stripslashes("Order Placed"),$mailMessage);
			$mailMessage = str_replace("#mail_message#",stripslashes($mail_message),$mailMessage);
			$mailMessage = str_replace("#delivery_charges#",stripslashes($o->symbol.' '.$o->delivery_charges),$mailMessage);
			$mailMessage = str_replace("#total_packing_charges#",stripslashes($o->symbol.' '.$o->total_packing_charges),$mailMessage);
			$mailMessage = str_replace("#total#",stripslashes($o->symbol.' '.$o->total),$mailMessage);
			$mailMessage = str_replace("#product_detail#",$product_detail,$mailMessage);
			$mailMessage = str_replace("#ship_data#",$ship_data,$mailMessage);
			$mailMessage = str_replace("#total_gst#",stripslashes($o->symbol.' '.$o->total_gst),$mailMessage);

			$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
			$mailMessage = str_replace("#mainsitepp#",base_url().__privacyPolicy__,$mailMessage);
			$mailMessage = str_replace("#mainsitecontact#",base_url().__contactUs__,$mailMessage);
			$mailMessage = str_replace("#mainsitefaq#",base_url().__faq__,$mailMessage);
			$mailMessage = str_replace("#mainsiteaccount#",base_url().__dashboard__,$mailMessage);
			$subject = "Your Order Placed Successfully. Order No.: $o->order_number !"._brand_name_;
			$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$o->email , "name"=>$o->name ));

			$subject = "New Order Placed. Order No.: $o->order_number !"._brand_name_;
			$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>__adminemail__ , "name"=>'Admin' ));

			$this->data['order_success_g_tag'] = "";

			$this->data['order_success_amp_triggers'] = '';

			//echo $mailMessage;
			//email sms code end
			parent::getHeader('header' , $this->data);
			$this->load->view('order_confirmation',$this->data);
			parent::getFooter('footer' , $this->data);
		}
		else
		{
			//echo "<pre>";print_r($_POST);echo "</pre>";
			//echo "<pre>";print_r($orderData);echo "</pre>";
			//exit;

			if(!empty($orderData['udf1']))
			{
				/*if(!empty($_POST["status_message"]))
					$order_fail_data['status_message'] = $_POST["status_message"];
				if(!empty($_POST["error_Message"]))
					$order_fail_data['error_Message'] = $_POST["error_Message"];
				if(!empty($_POST["mihpayid"]))
					$order_fail_data['mihpayid'] = $_POST["mihpayid"];
				if(!empty($_POST["amount"]))
					$order_fail_data['amount'] = $_POST["amount"];
				if(!empty($_POST["txnid"]))
					$order_fail_data['txnid'] = $_POST["txnid"];*/

				if(!empty($_POST["error_Message"]))
					$update_temp_orders_data['status_message']=$_POST["error_Message"];;
				if(!empty($_POST["mihpayid"]))
					$update_temp_orders_data['tracking_id']=$_POST["mihpayid"];
				if(!empty($_POST["field8"]))
					$update_temp_orders_data['failure_message']=$_POST["field8"];


				$update_temp_orders_data['pg_response']=json_encode($_POST);

				/*$update_temp_orders_data['bank_ref_no']=$_POST["bank_ref_no"];
				$update_temp_orders_data['order_status']=$_POST["order_status"];
				$update_temp_orders_data['failure_message']=$_POST["failure_message"];
				$update_temp_orders_data['payment_mode']=$_POST["mode"];
				$update_temp_orders_data['card_name']=$_POST["card_name"];
				$update_temp_orders_data['status_code']=$_POST["status_code"];*/

				$update_temp_orders_data['stuck_status ']=3;
				$this->Common_Model->update_operation(array('table'=>'temp_orders' , 'data'=>$update_temp_orders_data , 'condition'=>"(temp_orders_id=$orderData[udf1])"));
				$this->order_stock_plus($orderData['udf1']);

				$this->data['tempOrdersDetailsData'] = $this->Common_Model->getName(array('select'=>'*' , 'from'=>"temp_orders" , 'where'=>"temp_orders_id=$orderData[udf1]"));
				$this->data['tempOrdersDetailsData'] = $this->data['tempOrdersDetailsData'][0];
			}



			parent::getHeader('header' , $this->data);
			$this->load->view('order_fail',$this->data);
			parent::getFooter('footer' , $this->data);
		}
	}

	function order_test()
	{
		$orders_id = 0;
		if(!empty($_GET['orders_id']))
		{
			$orders_id = $_GET['orders_id'];
		}
		else
		{
			exit("order is missing");
		}
		$this->data['orders'] = $this->Checkout_model->getOrder(array("orders_id"=>$orders_id, "customers_id"=>$this->data['temp_id']));
		//echo $this->db->last_query();
		//print_r($this->data['orders']);
		//exit;
		$o=$this->data['orders'] = $this->data['orders'][0];
		$contact = $o->number;
		$template = "Dear $o->name, your order is confirmed. Your order id is $o->order_number. For more details login to your account "._SMS_BRAND_;
		//echo $template;
		//$this->Common_Model->send_sms($contact , $template);


		$mail_message = "Your "._brand_name_." <strong>Order</strong>&nbsp;<strong>$o->order_number</strong> has been placed successfully.<br>We will update you the order processing action.";
		$shipping_address = $o->d_name.'<br>'.$o->d_number.'<br>'.$o->d_address.'<br>'.$o->d_city_name.' - '.$o->d_zipcode.'<br>'.$o->d_state_name.'<br>'.$o->d_country_name;
		$billing_address = $o->b_name.'<br>'.$o->b_number.'<br>'.$o->b_address.'<br>'.$o->b_city_name.' - '.$o->b_zipcode.'<br>'.$o->b_state_name.'<br>'.$o->b_country_name;
		$product_detail = "";
		foreach($o->details as $od)
		{
			$product_detail .="<tr>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$od->product_name ($od->combi)
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$od->prod_in_cart
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$o->symbol $od->final_price
					</td>
					<td style='font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;'>
						$o->symbol $od->sub_total
					</td>
				</tr>
				";
		}

		$ship_data='';
		if($o->shipping_discount>0)
		{
			$ship_data .= '<tr>
				<td colspan="3" style="font-family:Arial, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;border-collapse: collapse;">
				<strong>Shipping Discount</strong>
				</td>
				<td style="font-family:Arial, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;border-collapse: collapse;">-
					'.$o->symbol.' '.$o->shipping_discount.'
				</td>
			</tr>';
		}
		if($o->cod_charges>0)
		{
			$ship_data .= '<tr>
				<td colspan="3" style="font-family:Arial, sans-serif; text-align:right; font-size:14px; color:#333; border-bottom:1px solid #ccc; line-height:20px; padding:5px 20px;border-collapse: collapse;">
				<strong>COD Charges</strong>
				</td>
				<td style="font-family:Arial, sans-serif; font-size:14px; color:#666; border-bottom:1px solid #ccc; line-height:20px; padding:5px 10px;border-collapse: collapse;">
					'.$o->symbol.' '.$o->cod_charges.'
				</td>
			</tr>';
		}


		$mailMessage = file_get_contents(APPPATH.'mailer/orders.html');
		$mailMessage = str_replace("#name#",stripslashes($o->name),$mailMessage);
		$mailMessage = str_replace("#order_number#",stripslashes($o->order_number),$mailMessage);
		$mailMessage = str_replace("#mode#",stripslashes($o->mode),$mailMessage);
		$mailMessage = str_replace("#added_on#",stripslashes(date("d M y" , strtotime($o->added_on))),$mailMessage);
		$mailMessage = str_replace("#txnid#",stripslashes($o->txnid),$mailMessage);
		$mailMessage = str_replace("#shipping_address#",stripslashes($shipping_address),$mailMessage);
		$mailMessage = str_replace("#billing_address#",stripslashes($billing_address),$mailMessage);
		$mailMessage = str_replace("#order_status#",stripslashes("Order Placed"),$mailMessage);
		$mailMessage = str_replace("#mail_message#",stripslashes($mail_message),$mailMessage);
		$mailMessage = str_replace("#total_gst#",stripslashes($o->symbol.' '.$o->total_gst),$mailMessage);
		$mailMessage = str_replace("#delivery_charges#",stripslashes($o->symbol.' '.$o->delivery_charges),$mailMessage);
		$mailMessage = str_replace("#total_packing_charges#",stripslashes($o->symbol.' '.$o->total_packing_charges),$mailMessage);
		$mailMessage = str_replace("#total#",stripslashes($o->symbol.' '.$o->total),$mailMessage);
		$mailMessage = str_replace("#product_detail#",$product_detail,$mailMessage);
		$mailMessage = str_replace("#ship_data#",$ship_data,$mailMessage);

		$mailMessage = str_replace("#mainsite#",base_url(),$mailMessage);
		//$mailMessage = str_replace("#mainsitepp#",base_url().__privacyPolicy__,$mailMessage);
		$mailMessage = str_replace("#mainsitecontact#",base_url().__contactUs__,$mailMessage);
		//$mailMessage = str_replace("#mainsitefaq#",base_url().__faq__,$mailMessage);
		$mailMessage = str_replace("#mainsiteaccount#",base_url().__dashboard__,$mailMessage);
		$subject = "Your Order Placed Successfully. Order No.: $o->order_number !"._brand_name_;
		//$mailStatus = $this->Common_Model->send_mail(array("template"=>$mailMessage , "subject"=>$subject , "to"=>$o->email , "name"=>$o->name ));

		$this->data['order_success_g_tag'] = "gtag('event', 'conversion', { 'send_to': 'AW-10785804854/k0QiCLuk6_0CELakiZco', 'value': '".$o->total."', 'currency': 'INR', 'transaction_id': '".$o->order_number."' }); ";

			$this->data['order_success_amp_triggers'] = '"C_qMyP4ROZupk": { "on": "visible", "vars": { "event_name": "conversion", "value": "'.$o->total.'", "currency": "INR", "transaction_id": "'.$o->order_number.'", "send_to": ["AW-10785804854/k0QiCLuk6_0CELakiZco"] } }';
		//echo $mailMessage;
		parent::getHeader('header' , $this->data);
		//$this->load->view('order-fail',$this->data);
		$this->load->view('order_confirmation',$this->data);
		parent::getFooter('footer' , $this->data);
	}

	function order_fail()
	{
		parent::getHeader('header' , $this->data);
		$this->load->view('order_fail',$this->data);
		parent::getFooter('footer' , $this->data);
	}


	function decrypt($encryptedText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

	function decrypt_old($encryptedText,$key)
	{
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText=$this->hextobin($encryptedText);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
		mcrypt_generic_init($openMode, $secretKey, $initVector);
		$decryptedText = mdecrypt_generic($openMode, $encryptedText);
		$decryptedText = rtrim($decryptedText, "\0");
	 	mcrypt_generic_deinit($openMode);
		return $decryptedText;

	}


	function hextobin($hexString)
   	 {
        	$length = strlen($hexString);
        	$binString="";
        	$count=0;
        	while($count < $length)
        	{
        	    $subString =substr($hexString,$count,2);
        	    $packedString = pack("H*",$subString);
        	    if ($count==0)
		    {
				$binString=$packedString;
		    }

		    else
		    {
				$binString.=$packedString;
		    }

		    $count+=2;
        	}
  	        return $binString;
    }
}
	/* End of file user.php */
/* Location: ./system/application/controllers/user.php */
