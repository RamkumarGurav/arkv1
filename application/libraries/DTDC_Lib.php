<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class DTDC_Lib
{
    private $CI;
	function __construct() 
	{
		$this->CI =& get_instance();
    	$this->CI->load->database();
		$this->CI->load->library('session');
		$this->staging = "http://dtdcstagingapi.dtdc.com/dtdc-api/";
		$this->production = "https://firstmileapi.dtdc.com/dtdc-api/";
		$this->curr_url = $this->production;
		$this->dtdc_key = $this->get_dtdc_auth_key();
		
	}
	
	function get_dtdc_auth_key()
	{
		$url = $this->curr_url."intlapi/splcustomer/authenticate?username=QF993_QF993001_trk&password=xuRDAPGX9V36Jzn";
		//echo $url.'<br><br><br>';
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		$key = $result = curl_exec($ch);
		return $key;
	}
	
	function getServiceTypes($pincode)
	{
		
		$destination_pincode = $pincode; // Mandatory

		$source_pin = "560069";
		$destination_pin = $destination_pincode;
		$url = $this->curr_url."api/custOrder/service/getServiceTypes/$source_pin/$destination_pin";
		//echo $key."<br>";
		//echo $url;
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			"X-Access-Token: $this->dtdc_key"
		  ),
		));
		
		$response = curl_exec($curl);
		
		//echo $response;
		//print_r($response);
		// close the connection, release resources used
		curl_close($curl);
		return $response;
	}
	
}
