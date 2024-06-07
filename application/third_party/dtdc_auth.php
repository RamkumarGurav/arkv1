<?
$staging = "http://dtdcstagingapi.dtdc.com/dtdc-api/";
$production = "https://firstmileapi.dtdc.com/dtdc-api/";
$curr_url = $production;
$url = $curr_url."intlapi/splcustomer/authenticate?username=QF993_QF993001_trk&password=xuRDAPGX9V36Jzn";
//echo $url.'<br><br><br>';
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
$key = $result = curl_exec($ch);
//echo $key;
//$key = $result = file_get_contents("$url");