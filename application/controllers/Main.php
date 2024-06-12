<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Main extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		//$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->session->set_userdata('application_sess_store_id', 1);
		$this->data['temp_name'] = $this->session->userdata('application_sess_temp_name');
		$this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');
		$this->data['store_id'] = $this->session->userdata('application_sess_store_id');
		$this->data['store_id'] = 1;
		$this->data['cart_count'] = $this->session->userdata('application_sess_cart_count');
		$this->data['active_left_menu'] = '';

		$this->data['csrf'] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->session->set_userdata('application_sess_currency_id', 1);
		$this->session->set_userdata('application_sess_country_id', __const_country_id__);
		$app_sess_currency_id = $this->session->userdata('application_sess_currency_id');
		if (empty($app_sess_currency_id) && false) {
			$user_ip = getenv('REMOTE_ADDR');
			//$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
			if (!empty($geo["geoplugin_countryName"])) {
				if ($geo["geoplugin_countryName"] == 'India') {

					$this->session->set_userdata('application_sess_currency_id', 1);
					$this->session->set_userdata('application_sess_country_id', __const_country_id__);
				} else {
					$country_name = $geo["geoplugin_countryName"];
					$getCountry_data = $this->Common_Model->getName(array('select' => '*', 'from' => 'country', 'where' => "(country_name like '$country_name' and status=1)"));
					if (!empty($getCountry_data)) {
						$getCountry_data = $getCountry_data[0];
						$this->session->set_userdata('application_sess_currency_id', 2);
						$this->session->set_userdata('application_sess_country_id', $getCountry_data->country_id);
					} else {
						$this->session->set_userdata('application_sess_currency_id', 1);
						$this->session->set_userdata('application_sess_country_id', __const_country_id__);
					}

				}
			} else {
				$this->session->set_userdata('application_sess_currency_id', 1);
				$this->session->set_userdata('application_sess_country_id', __const_country_id__);
			}
		}

		$this->Common_Model->getWishlistItemCount();
		$this->data['wishlist_count'] = $this->session->userdata('application_sess_wishlist_count');

		if (empty($this->data['temp_id'])) {
			$sess_temp_id = date("dmYhis");
			if (empty($_COOKIE["application_user"])) {
				setcookie("application_user", $sess_temp_id, time() + (86400 * 365), "/");
				$this->session->set_userdata('application_sess_temp_id', $sess_temp_id);
			} else {
				$this->session->set_userdata('application_sess_temp_id', $_COOKIE["application_user"]);
			}
		}

		$this->Common_Model->getCartItemCount();

		$this->data['cart_coupon_code'] = $this->session->userdata('application_sess_coupon_code');
		$this->data['cart_coupon_discount'] = $this->session->userdata('application_sess_discount');
		$this->data['cart_discount_in'] = $this->session->userdata('application_sess_discount_in');
		$this->data['cart_discount_variable'] = $this->session->userdata('application_sess_discount_variable');
		$this->data['cart_discount_on_cart_value'] = $this->session->userdata('application_sess_discount_on_cart_value');
		$this->data['cart_discount_cart_value_message'] = $this->session->userdata('application_sess_discount_cart_value_message');
	}


	public function getHeader($pageName, $data)
	{
		$this->data = $data;
		if (empty($this->data['js'])) {
			$this->data['js'] = array();
		}
		//$this->data['js'] = array_merge(array( 'js/product.js'), $this->data['js']);
		$this->data['check_screen'] = $this->Common_Model->checkScreen();
		$this->data['runningLines'] = $this->Common_Model->getRunningLines();
		$this->data['menu'] = $this->Common_Model->getMenu();
		$this->load->view("inc/$pageName", $this->data);
	}

	public function getFooter($pageName, $data)
	{
		$this->data = $data;
		$this->data['js'] = array_merge(array('js/product.js'), $this->data['js']);
		$this->load->view("inc/$pageName", $this->data);
	}

	public function setCurrency($params = array())
	{
		if (empty($this->data['setCurency'])) {
			$this->data['setCurency'] = $this->Common_Model->setCurency();
		}
		return $this->data['setCurency'];
	}

	public function getCurrencyPrice($params = array())
	{
		//return $params['obj']['setCurency']->currency_rate*$params['amount'];
		return round($params['amount']);
		//echo $params['obj']['setCurency']->currency_rate;
		//echo $params['amount'];
	}

	public function getDeliveryPrice($params = array())
	{

		//include( APPPATH."third_party/shiprocket/auth.php");
		include (APPPATH . "third_party/shiprocket/auth.php");
		$shipping_charges_arr['cod_charges'] = 0;
		$shipping_charges_arr['shipping_charges'] = 0;
		$shipping_charges_arr['shipping_discount'] = 0;
		$shipping_charges_arr['total_shipping_charges'] = 0;
		$store_delivery_pincodes = array();
		$shipping_charges_arr['is_delivery_available'] = $is_delivery_available = false;
		$shipping_charges_arr['is_cod_available'] = $is_delivery_available = 0;
		$is_tsm_delivery = false;
		$is_shiprocket_delivery = false;
		$is_shiprocket = true;


		$store_data = $this->Common_Model->getData(array('select' => '*', 'from' => 'stores', 'where' => "stores_id =1"));
		if (!empty($store_data)) {
			$store_data = $store_data[0];
			if (!empty($store_data->store_delivery_pincodes)) {
				$store_delivery_pincodes = explode(',', $store_data->store_delivery_pincodes);
				for ($i = 0; $i < count($store_delivery_pincodes); $i++) {
					$store_delivery_pincodes[$i] = trim($store_delivery_pincodes[$i]);
					if ($store_delivery_pincodes[$i] == $params['delivery_pin_code']) {
						$is_tsm_delivery = true;
						$is_delivery_available = true;
						$shipping_charges_arr['is_cod_available'] = 1;
						break;
					}
				}
			}
		}


		include_once (APPPATH . "third_party/shiprocket/auth.php");

		$order_api_data = array(
			"pickup_postcode" => 502101,
			"delivery_postcode" => $params['delivery_pin_code'],
			//"delivery_postcode"=> 110006,
			"cod" => 1,
			'declared_value' => $params['order_total'],
			"weight" => round(($params['total_weight'] / 1000), 3)
		);

		$order_api_data_json = $post_json_data = json_encode($order_api_data);

		$request_url = 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/?pickup_postcode=502101&delivery_postcode=' . $params['delivery_pin_code'] . '&is_return=0&weight=' . $order_api_data['weight'] . '&cod=1&declared_value=' . $params['order_total'] . '';

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_POSTFIELDS => $post_json_data,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				"Authorization: Bearer $token"
			),
		)
		);

		$responsejson = $response = curl_exec($curl);

		curl_close($curl);
		$response = json_decode($response);


		$postcode_api_data = array("postcode" => $params['delivery_pin_code']);
		// print_r(	$postcode_api_data);
		// die;
		//$postcode_api_data = array("postcode"=> 532421);
		$postcode_api_data_json = json_encode($postcode_api_data);
		$postcode_curl = curl_init();
		curl_setopt_array($postcode_curl, array(
			CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/open/postcode/details',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_POSTFIELDS => $postcode_api_data_json,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				"Authorization: Bearer $token"
			),
		)
		);

		$postcode_responsejson = curl_exec($postcode_curl);

		curl_close($postcode_curl);
		$postcode_response = json_decode($postcode_responsejson);

		//	echo "<pre>";
		//print_r($order_api_data);
		//	print_r($response);
		//print_r($postcode_response);
		//	echo "</pre>";
		//die;
		$is_free_delivery = 1;
		$not_free_delivery_states = array('Tripura', 'Mizoram', 'Nagaland', 'Manipur', 'Meghalaya', 'Jammu and Kashmir', 'Himachal Pradesh');
		$post_code_state = '';
		if (!empty($postcode_response->postcode_details->state)) {
			$post_code_state = $postcode_response->postcode_details->state;
		}
		if (in_array($post_code_state, $not_free_delivery_states)) {
			$is_free_delivery = 0;
		}
		//echo $post_code_state;
		$fright_charges = 0;
		$cod_charges = 100;

		if (!empty($response)) {
			if (!empty($response->status)) {
				if ($response->status == 200) {
					$is_shiprocket_delivery = true;
					$shiprocket_recommended_courier_id = $response->data->shiprocket_recommended_courier_id;
					$recommended_courier_company_id = $response->data->recommended_courier_company_id;
					if (!empty($response->data->available_courier_companies)) {
						foreach ($response->data->available_courier_companies as $acc) {
							if ($acc->courier_company_id == $recommended_courier_company_id) {
								//print_r($acc);
								$is_delivery_available = true;
								$ship_rocket_delivery_charges = $acc->rate;
								$fright_charges = $acc->freight_charge;
								//$fright_charges = 75;
								//$cod_charges = $acc->cod_charges;
							}

							if ($acc->cod == 1) {
								$is_delivery_available = true;
								$shipping_charges_arr['is_cod_available'] = 1;
							}
						}
					}
				}
			}
		}

		if (!$is_shiprocket_delivery) {
			//$fright_charges = 75;
			$fright_charges = 90;
			//$cod_charges = 20;
		}

		if ($params['order_total'] > __free_shipping_above__ && $is_free_delivery) {
			$shipping_charges_arr['cod_charges'] = $cod_charges;
			$shipping_charges_arr['shipping_charges'] = 0;
			$shipping_charges_arr['shipping_discount'] = 0;
		} else {
			$shipping_charges_arr['cod_charges'] = $cod_charges;
			$shipping_charges_arr['shipping_charges'] = 90;
			$shipping_charges_arr['shipping_discount'] = 0;
		}

		$shipping_charges_arr['is_delivery_available'] = $is_delivery_available;
		if (!$is_delivery_available) {
			$is_redirect = true;
			if (!empty($params['is_redirect'])) {
				$is_redirect = false;
			}

			$msg = "The pin code (" . $params['delivery_pin_code'] . ") is not serviceable.";
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">' . $msg . '</div>');
			if ($is_redirect) {
				REDIRECT(base_url() . __cart__);
			} else {
				//return '<div class=" alert alert-warning">'.$msg.'</div>';
			}
		}
		$shipping_charges_arr['total_shipping_charges'] = $shipping_charges_arr['cod_charges'] + $shipping_charges_arr['shipping_charges'] - $shipping_charges_arr['shipping_discount'];
		/*echo "<pre>";
			print_r($params);
			print_r($shipping_charges_arr);
			 echo "</pre>";*/

		$t1 = json_encode($shipping_charges_arr);
		$t = json_decode($t1);

		return $t;
	}

}
