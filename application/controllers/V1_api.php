<?php
header('Access-Control-Allow-Origin: *');
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

include('Main.php');
$response = array();
//header('Access-Control-Allow-Origin: *');
class V1_api extends Main {
	public function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->library('session');
		$this->load->model('Products_model');
		//$this->load->model('Api_model');
		$this->load->model('Common_Model');
		$this->load->helper('url');
		$this->data['message']='';
		$this->data['message1']='';
		$this->session->set_userdata('application_sess_store_id',1);
		$this->data['temp_name'] = $this->session->userdata('application_sess_temp_name');
		$this->data['temp_email'] = $this->session->userdata('application_sess_temp_email');
		$this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');
		$this->data['store_id'] = $this->session->userdata('application_sess_store_id');
		$this->data['store_id'] = 1;
		$this->data['callFor'] = '';
		
		
		$this->response['status'] = 'false';
		$this->response['message'] = 'fail';
		
		$is_api_key = false;
		
		$api_key[] = '3566569955816956634';
		$api_key[] = 'YCfrBDbanSf3fIRz'; #for internal use do not change,
		
		if(!empty($_SERVER['HTTP_X_API_KEY']))
		{
//			if($_SERVER['HTTP_X_API_KEY']=='3566569955816956634')
			if(in_array($_SERVER['HTTP_X_API_KEY'] , $api_key))
			{
				$is_api_key = true;
			}
		}
		$is_api_key = true;
		if(!$is_api_key)
		{
			$this->response['status'] = 'false';
			$this->response['message'] = 'invalid authentication';
			echo json_encode($this->response);
			exit;
		}
		
		$is_method = false;
		if(!empty($_SERVER['REQUEST_METHOD']))
		{
			if($_SERVER['REQUEST_METHOD']=='POST' || $_SERVER['REQUEST_METHOD']=='GET')
			{
				$is_method = true;
			}
		}
		if(!$is_method)
		{
			$this->response['status'] = 'false';
			$this->response['message'] = 'invalid request method';
			echo json_encode($this->response);
			exit;
		}
		//echo json_encode($_SERVER);exit;
		//$this->output->enable_profiler(TRUE); 
	}
	
	function index()
	{
		$this->response['status'] = 'true';
		$this->response['message'] = 'success';
		echo json_encode(array('a'=>$this->response , "b"=>$_SERVER));
	}
	
	
	function googleProducts()
	{
		//for external API
		$fp = fopen('php://input', 'r');
		$limit=0;
		$offset=0;
		$application_sess_temp_id=0;
		$application_sess_store_id=1;
		$cat_search=''; # Seperated by comma
		$searchSugg = array();
		
		$this->data['products_list'] = $this->Products_model->productsSearch('products_list_google','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , "" , '' , $limit , $offset  , '', array("cat_search"=>$cat_search , 'search'=>$searchSugg, 'order'=>1, 'is_google_product'=>0));
		/*$this->response['status'] = 'true';
		$this->response['message'] = 'success';
		$this->response['data'] = $products_list;*/
		$this->load->view('api/product-list-json' , $this->data);
		//echo json_encode($this->response);
	}
	
	function products_csv()
	{
		$fp = fopen('php://input', 'r');
		$limit=0;
		$offset=0;
		$application_sess_temp_id=0;
		$application_sess_store_id=1;
		$cat_search=''; # Seperated by comma
		$searchSugg = array();
		
		$products_list = $this->Products_model->productsSearch('products_list','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , "" , '' , $limit , $offset  , '', array("cat_search"=>$cat_search , 'search'=>$searchSugg, 'order'=>1));
		
		$this->response['status'] = 'true';
		$this->response['message'] = 'success';
		$this->response['products_list'] = $products_list;
		//echo json_encode($this->response);
		$this->load->view('api/product-list-csv' , $this->response);
	}
	
	

}
