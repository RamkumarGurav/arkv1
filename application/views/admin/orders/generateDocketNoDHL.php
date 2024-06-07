<?

function str_limit($value , $start=0, $limit = 100, $end = '...')
{
	$limit = $limit - mb_strlen($end); // Take into account $end string into the limit
	$valuelen = mb_strlen($value);
	//echo "<br>limit : $limit <br>";
	//echo "<br>valuelen : $valuelen <br>";
	return mb_substr($value, $start, mb_strrpos($value, ' ', $limit - $valuelen));
    //return $limit < $valuelen ? mb_substr($value, $start, mb_strrpos($value, ' ', $limit - $valuelen)) . $end : $value;
}
$is_docket_assign = false;
echo "<pre>";
$post_json = json_encode($_POST);
//print_r($_POST);
//print_r($od = $orders_detail[0]);
//exit;
$boxNo = $_POST['boxNo'];
$od = $orders_detail[0];
//$od->total=150;
//header("Content-type: text/xml");
 //Data, connection, auth
// $dataFromTheForm = $_POST['fieldName']; // request data from the form
$destination_pincode = $od->d_zipcode; // Mandatory
$vendor_address = 'Shop No. 3,4,5';
$vendor_address2 = 'Deol Nagar';
$vendor_address3 = 'Near Coca Cola Agency,';
$vendor_city = 'Jalandhar';
$vendor_state = 'Punjab';
$vendor_country = 'INDIA';
$vendor_name = 'The Dentist Shop';
$vendor_company_name = 'The Dentist Shop';
$vendor_phone = '8026544144';
$vendor_pin = '144003';
$vendor_email = 'anubhav.gupta@marswebsolutions.com';
$vendor_country_code = 'IN';

$box_l=0;
$box_b=0;
$box_h=0;
$service_type='';
if(!empty($_POST['box_l']))
{ $box_l = $_POST['box_l']; }

if(!empty($_POST['box_b']))
{ $box_b = $_POST['box_b']; }

if(!empty($_POST['box_h']))
{ $box_h = $_POST['box_h']; }

if(!empty($_POST['service_type']))
{ $service_type = $_POST['service_type']; }


$total_product_weight = 0;

if(!empty($_POST['total_package_weight']))
{
	$total_product_weight = round($_POST['total_package_weight'] , 2);
}


//$limit = $limit - mb_strlen($end); // Take into account $end string into the limit
$d_address = $od->d_address;
$valuelen = strlen($d_address);
$valuelen1 = $valuelen/3;
//print( str_limit($d_address , $start , $limit , ''));

$d_address1 = str_limit($d_address , 0 , 35, '');
if(strlen($d_address)>35)
	$d_address2 = str_limit($d_address , $valuelen1 , 35 , '');
if(strlen($d_address)>70)
	$d_address3 = str_limit($d_address , ($valuelen1*2) , 35 , '');

if(empty($d_address1)){$d_address1 = "     ";};
if(empty($d_address2)){$d_address2 = "     ";};
if(empty($d_address3)){$d_address3 = "     ";};

/*$d_address1 = '1204, 1st Floor, Ashva Building';
$d_address2 = '1204, 1st Floor, Ashva Building';
$d_address3 = '1204, 1st Floor, Ashva Building';*/

$order_products = array();

$IsUnderMEISScheme = array();
$FOBValue = array();
$Qty = array();
$HSCode = array();
$CommodityType = array();
$InvoiceRatePerUnit = array();
$ShipPieceUOM = array();
$ShipPieceCESS = array();
$ShipPieceIGST = array();
$ShipPieceTaxableValue = array();
$Description = array();
$SerialNumber = array();

$ShipPieceWt = array();
$ShipPieceDepth = array();
$ShipPieceWidth = array();
$ShipPieceHeight = array();
foreach($boxNo as $bn)
{
	$ShipPieceDepth[] = $_POST['box_l_'.$bn];
	$ShipPieceWidth[] = $_POST['box_b_'.$bn];
	$ShipPieceHeight[] = $_POST['box_h_'.$bn];
	$ShipPieceWt[] = round(($_POST['total_package_weight_'.$bn]/1000) , 2);
}


foreach($od->details as $odd){
	//$bni = $odd;
	$bni = $odd->orders_details_id;
	foreach($boxNo as $bn)
		{
			$box_count = '';
			$box_count_fd = '1';
			if(count($boxNo)>1)
			{
				$box_count = $bn.' ';
				$box_count_fd = $bn.'';
			}
			//foreach($orders_details_ids as $bni)
			{
				if(!empty($_POST['item_'. $bn . '_i_'.$bni]))
				{
					//if($odd->orders_details_id == $bni)
					{
						//$pending_item_for_packing = $pending_item_for_packing - $_POST['item_'. $bn . '_i_'.$bni];
					
						$qty_in_box = $_POST['item_'. $bn . '_i_'.$bni];
						//echo "qty_in_box ; $qty_in_box<br>";
						
						$product_weight = $odd->product_weight;
						if(empty($product_weight)){$product_weight='0.100';}
						$p_name = $odd->product_name .', '.$odd->combi;
						$p_name = strip_tags($p_name);
						$p_name = str_replace( '&nbsp;' , ' ' , $p_name);
						$p_name = str_replace( ',' , '-' , $p_name);
						$p_name = str_replace( '&' , 'and' , $p_name);
						//$p_name = substr($p_name,1);
						$p_name = '_'.$p_name;
						$IsUnderMEISScheme[] = 0;
						//$FOBValue[] = 1;
						$SerialNumber[] = $bn;
						$FOBValue[] = $odd->final_price * $qty_in_box;
						$Qty[] = $qty_in_box;
						$HSCode[] = $odd->hsn_code;
						$CommodityType[] = 'OTHERS';
						$InvoiceRatePerUnit[] = $odd->final_price  * $qty_in_box;
						$ShipPieceUOM[] = 'PCS';
						$ShipPieceCESS[] = 0;
						//$ShipPieceIGST[] = round(($odd->total_gst/$odd->prod_in_cart) , 2);
						$ShipPieceIGST[] = 0;
						//$ShipPieceTaxableValue[] = $box_count.round(($odd->total_gst/$odd->prod_in_cart) );
						$ShipPieceTaxableValue[] = $odd->final_price * $qty_in_box;
						$Description[] = $box_count_fd.$p_name;
					}
				}
			}
		}

	
	
	//$first_l = substr($p_name,0 , 1);
	$order_products[] = array(
		"skuNumber"=> '',
		"description"=> $p_name,
		"itemValue"=> $odd->final_price,
		"itemQuantity"=> $odd->prod_in_cart,
		"grossWeight"=> $product_weight,
		"contentIndicator"=> '',
		"countryOfOrigin"=> "IN",
		"hsCode"=> '',
		"height"=> 10,
		"length"=> 10,
		"width"=> 10,
		"volumetricWeight"=> 10 * 10 * 10
	
	);
}


function formatXmlString($xml) {

  // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
  $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);

  // now indent the tags
  $token      = strtok($xml, "\n");
  $result     = ''; // holds formatted version as it is built
  $pad        = 0; // initial indent
  $matches    = array(); // returns from preg_matches()

  // scan each line and adjust indent based on opening/closing tags
  while ($token !== false) :

    // test for the various tag states

    // 1. open and closing tags on same line - no change
    if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) :
      $indent=0;
    // 2. closing tag - outdent now
    elseif (preg_match('/^<\/\w/', $token, $matches)) :
      $pad--;
    // 3. opening tag - don't pad this one, only subsequent tags
    elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
      $indent=1;
    // 4. no indentation needed
    else :
      $indent = 0;
    endif;

    // pad the line with the required number of leading spaces
    $line    = str_pad($token, strlen($token)+$pad, ' ', STR_PAD_LEFT);
    $result .= $line . "\n"; // add to the cumulative result, with linefeed
    $token   = strtok("\n"); // get the next token
    $pad    += $indent; // update the pad size for subsequent lines
  endwhile;

  return $result;
}
 $soapUrl = "http://dhlindiaplugin.com/DHLWCFService_V6/DHLService.svc?wsdl"; // asmx URL of WSDL
 $soapUser = "username";  //  username
 $soapPassword = "password"; // password

 // xml post structure

 $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:PostShipmentWithSpecialService3CMPMLNew_V6>
         <tem:ShippingPaymentType>S</tem:ShippingPaymentType>
         <tem:ShipperAccNumber>531291612</tem:ShipperAccNumber>
         <tem:BillingAccNumber>531291612</tem:BillingAccNumber>
         <tem:DutyPaymentType>R</tem:DutyPaymentType>
         <tem:DutyAccNumber></tem:DutyAccNumber>
         <tem:ConsigneeCompName>'.$od->d_name.'</tem:ConsigneeCompName>
         <tem:ConsigneeAddLine1>'.$d_address1.'</tem:ConsigneeAddLine1>
         <tem:ConsigneeAddLine2>'.$d_address2.'</tem:ConsigneeAddLine2>
         <tem:ConsigneeAddLine3>'.$d_address3.'</tem:ConsigneeAddLine3>
         <tem:ConsigneeCity>'.$od->d_city_name.'</tem:ConsigneeCity>
         <tem:ConsigneeDivCode>'.$od->division_code.'</tem:ConsigneeDivCode>
         <tem:PostalCode>'.$od->d_zipcode.'</tem:PostalCode>
         <tem:ConsigneeCountryCode>'.$od->country_short_name.'</tem:ConsigneeCountryCode>
         <tem:ConsigneeCountryName>'.$od->d_country_name.'</tem:ConsigneeCountryName>
         <tem:ConsigneeName>'.$od->d_name.'</tem:ConsigneeName>
         <tem:ConsigneePh>'.$od->d_number.'</tem:ConsigneePh>
         <tem:DutiableDeclaredvalue>'.$od->total.'</tem:DutiableDeclaredvalue>
         <tem:DutiableDeclaredCurrency>USD</tem:DutiableDeclaredCurrency>
         <tem:ShipNumberOfPieces>'.count($boxNo).'</tem:ShipNumberOfPieces>
         <tem:ShipCurrencyCode>USD</tem:ShipCurrencyCode>
         <tem:ShipPieceWt>'.implode(',' , $ShipPieceWt).'</tem:ShipPieceWt>
         <tem:ShipPieceDepth>'.implode(',' , $ShipPieceDepth).'</tem:ShipPieceDepth>
         <tem:ShipPieceWidth>'.implode(',' , $ShipPieceWidth).'</tem:ShipPieceWidth>
         <tem:ShipPieceHeight>'.implode(',' , $ShipPieceHeight).'</tem:ShipPieceHeight>
         <tem:ShipGlobalProductCode>P</tem:ShipGlobalProductCode>
         <tem:ShipLocalProductCode>P</tem:ShipLocalProductCode>
         <tem:ShipContents>Equipment</tem:ShipContents>
         <tem:ShipperId>531291612</tem:ShipperId>
         <tem:ShipperCompName>'.$vendor_company_name.'</tem:ShipperCompName>
         <tem:ShipperAddress1>'.$vendor_address.'</tem:ShipperAddress1>
         <tem:ShipperAddress2>'.$vendor_address2.'</tem:ShipperAddress2>
         <tem:ShipperAddress3>'.$vendor_address3.'</tem:ShipperAddress3>
         <tem:ShipperCountryCode>'.$vendor_country_code.'</tem:ShipperCountryCode>
         <tem:ShipperCountryName>'.$vendor_country.'</tem:ShipperCountryName>
         <tem:ShipperCity>'.$vendor_city.'</tem:ShipperCity>
         <tem:ShipperPostalCode>'.$vendor_pin.'</tem:ShipperPostalCode>
         <tem:ShipperPhoneNumber>'.$vendor_phone.'</tem:ShipperPhoneNumber>
         <tem:SiteId>v62_zPpyi3oyLK</tem:SiteId>
         <tem:Password>vNWvgnBSSI</tem:Password>
         <tem:ShipperName>'.$vendor_name.'</tem:ShipperName>
         <tem:ShipperRef>NA</tem:ShipperRef>
         <tem:IsResponseRequired>N</tem:IsResponseRequired>
         <tem:LabelReq>N</tem:LabelReq>
         <tem:SpecialService>DS</tem:SpecialService>
         <tem:IECNo>0612008622</tem:IECNo>
         <tem:TermsOfTrade>DAP</tem:TermsOfTrade>
         <tem:Usingecommerce>1</tem:Usingecommerce>
         <tem:IsUnderMEISScheme>'.implode(',' , $IsUnderMEISScheme).'</tem:IsUnderMEISScheme>
         <tem:SerialNumber>'.implode(',' , $SerialNumber).'</tem:SerialNumber>
         <tem:FOBValue>'.implode(',' , $FOBValue).'</tem:FOBValue>
         <tem:Description>'.implode(',' , $Description).'</tem:Description>
         <tem:Qty>'.implode(',' , $Qty).'</tem:Qty>
         <tem:HSCode>'.implode(',' , $HSCode).'</tem:HSCode>
         <tem:InsuredAmount></tem:InsuredAmount>
         <tem:CommodityType>'.implode(',' , $CommodityType).'</tem:CommodityType>
         <tem:GSTIN>27AAHCM4763C1ZH</tem:GSTIN>
         <tem:GSTInvNo>1</tem:GSTInvNo>
         <tem:GSTInvNoDate>2021-02-22</tem:GSTInvNoDate>
         <tem:NonGSTInvNo>NA</tem:NonGSTInvNo>
         <tem:NonGSTInvDate>2021-02-10</tem:NonGSTInvDate>
         <tem:TotalIGST>NA</tem:TotalIGST>
         <tem:IsUsingIGST>NO</tem:IsUsingIGST>
         <tem:UsingBondorUT>Yes</tem:UsingBondorUT>
         <tem:isIndemnityClauseRead>YES</tem:isIndemnityClauseRead>
         <tem:ConsigneeEmail>'.$od->email.'</tem:ConsigneeEmail>
         <tem:InvoiceRatePerUnit>'.implode(',' , $InvoiceRatePerUnit).'</tem:InvoiceRatePerUnit>
         <tem:BankADCode>63904993200008</tem:BankADCode>
         <tem:ShipPieceUOM>'.implode(',' , $ShipPieceUOM).'</tem:ShipPieceUOM>
         <tem:ShipPieceCESS>'.implode(',' , $ShipPieceCESS).'</tem:ShipPieceCESS>
         <tem:ShipPieceIGST>'.implode(',' , $ShipPieceIGST).'</tem:ShipPieceIGST>
         <tem:ShipPieceTaxableValue>'.implode(',' , $ShipPieceTaxableValue).'</tem:ShipPieceTaxableValue>
      </tem:PostShipmentWithSpecialService3CMPMLNew_V6>
   </soapenv:Body>
</soapenv:Envelope>';   // data from the form, e.g. some ID number
/*$xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:PostShipmentWithSpecialService3CMPMLNew_V6>
         <tem:ShippingPaymentType>S</tem:ShippingPaymentType>
         <tem:ShipperAccNumber>531291612</tem:ShipperAccNumber>
         <tem:BillingAccNumber>531291612</tem:BillingAccNumber>
         <tem:DutyPaymentType>R</tem:DutyPaymentType>
         <tem:DutyAccNumber></tem:DutyAccNumber>
         <tem:ConsigneeCompName>. .</tem:ConsigneeCompName>
         <tem:ConsigneeAddLine1>1204, 1st Floor, Ashva Building</tem:ConsigneeAddLine1>
         <tem:ConsigneeAddLine2>lding, 26th Main, 41st Cross</tem:ConsigneeAddLine2>
         <tem:ConsigneeAddLine3>ross, Jaya Nagar 9th Block</tem:ConsigneeAddLine3>
         <tem:ConsigneeCity>New York</tem:ConsigneeCity>
         <tem:ConsigneeDivCode>NY</tem:ConsigneeDivCode>
         <tem:PostalCode>02130</tem:PostalCode>
         <tem:ConsigneeCountryCode>US</tem:ConsigneeCountryCode>
         <tem:ConsigneeCountryName>United States of America</tem:ConsigneeCountryName>
         <tem:ConsigneeName>Anubhav</tem:ConsigneeName>
         <tem:ConsigneePh>8950801168</tem:ConsigneePh>
         <tem:DutiableDeclaredvalue>150</tem:DutiableDeclaredvalue>
         <tem:DutiableDeclaredCurrency>USD</tem:DutiableDeclaredCurrency>
         <tem:ShipNumberOfPieces>1</tem:ShipNumberOfPieces>
         <tem:ShipCurrencyCode>USD</tem:ShipCurrencyCode>
         <tem:ShipPieceWt>15</tem:ShipPieceWt>
         <tem:ShipPieceDepth>15</tem:ShipPieceDepth>
         <tem:ShipPieceWidth>15</tem:ShipPieceWidth>
         <tem:ShipPieceHeight>15</tem:ShipPieceHeight>
         <tem:ShipGlobalProductCode>P</tem:ShipGlobalProductCode>
         <tem:ShipLocalProductCode>P</tem:ShipLocalProductCode>
         <tem:ShipContents>Equipment</tem:ShipContents>
         <tem:ShipperId>531291612</tem:ShipperId>
         <tem:ShipperCompName>The Dentist Shop</tem:ShipperCompName>
         <tem:ShipperAddress1>Shop No. 3,4,5</tem:ShipperAddress1>
         <tem:ShipperAddress2>Deol Nagar</tem:ShipperAddress2>
         <tem:ShipperAddress3>Near Coca Cola Agency</tem:ShipperAddress3>
         <tem:ShipperCountryCode>IN</tem:ShipperCountryCode>
         <tem:ShipperCountryName>INDIA</tem:ShipperCountryName>
         <tem:ShipperCity>Jalandhar</tem:ShipperCity>
         <tem:ShipperPostalCode>144003</tem:ShipperPostalCode>
         <tem:ShipperPhoneNumber>8026544144</tem:ShipperPhoneNumber>
         <tem:SiteId>v62_zPpyi3oyLK</tem:SiteId>
         <tem:Password>vNWvgnBSSI</tem:Password>
         <tem:ShipperName>The Dentist Shop</tem:ShipperName>
         <tem:ShipperRef>NA</tem:ShipperRef>
         <tem:IsResponseRequired>N</tem:IsResponseRequired>
         <tem:LabelReq>N</tem:LabelReq>
         <tem:SpecialService>DS</tem:SpecialService>
         <tem:IECNo>0612008622</tem:IECNo>
         <tem:TermsOfTrade>DAP</tem:TermsOfTrade>
         <tem:Usingecommerce>1</tem:Usingecommerce>
         <tem:IsUnderMEISScheme>0,0,0</tem:IsUnderMEISScheme>
         <tem:SerialNumber>1,1,1</tem:SerialNumber>
         <tem:FOBValue>50,50,50</tem:FOBValue>
         <tem:Description>1M ESPE Disposable Applicator Tips- 1 Unit,1revest Denpro Hiflex Impression Composition 200g- 1 Unit,1codent Fixer  Developer Powder- 1 Unit</tem:Description>
         <tem:Qty>3,4,4</tem:Qty>
         <tem:HSCode>74199990,74199990,74199990</tem:HSCode>
         <tem:InsuredAmount></tem:InsuredAmount>
         <tem:CommodityType>OTHERS,OTHERS,OTHERS</tem:CommodityType>
         <tem:GSTIN>27AAHCM4763C1ZH</tem:GSTIN>
         <tem:GSTInvNo>1</tem:GSTInvNo>
         <tem:GSTInvNoDate>2021-02-22</tem:GSTInvNoDate>
         <tem:NonGSTInvNo>NA</tem:NonGSTInvNo>
         <tem:NonGSTInvDate>2021-02-10</tem:NonGSTInvDate>
         <tem:TotalIGST>NA</tem:TotalIGST>
         <tem:IsUsingIGST>NO</tem:IsUsingIGST>
         <tem:UsingBondorUT>YES</tem:UsingBondorUT>
         <tem:isIndemnityClauseRead>YES</tem:isIndemnityClauseRead>
         <tem:ConsigneeEmail>ABC@ABC.COM</tem:ConsigneeEmail>
         <tem:InvoiceRatePerUnit>50,50,50</tem:InvoiceRatePerUnit>
         <tem:BankADCode>00000000000009</tem:BankADCode>
         <tem:ShipPieceUOM>PCS,PCS,PCS</tem:ShipPieceUOM>
         <tem:ShipPieceCESS>0,0,0</tem:ShipPieceCESS>
         <tem:ShipPieceIGST>0,0,0</tem:ShipPieceIGST>
         <tem:ShipPieceTaxableValue>50,50,50</tem:ShipPieceTaxableValue>
      </tem:PostShipmentWithSpecialService3CMPMLNew_V6>
   </soapenv:Body>
</soapenv:Envelope>';*/
    $headers = array(
	
                 "Content-type: text/xml;charset=\"utf-8\"",
                 "Accept: text/xml",
                 "Cache-Control: no-cache",
                 "Pragma: no-cache",
                 //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                 "Content-length: ".strlen($xml_post_string),
             ); //SOAPAction: your op URL
			 
	$headers = array(//"Accept-Encoding: gzip,deflate",
'Content-Type: text/xml;charset=UTF-8',
'SOAPAction: "http://tempuri.org/IDHLService/PostShipmentWithSpecialService3CMPMLNew_V6"',
'Content-Length: '.strlen($xml_post_string),
'Host: dhlindiaplugin.com',
'Connection: Keep-Alive',
'User-Agent: Apache-HttpClient/4.5.2 (Java/15)'
);
echo "<pre>";	 
echo "<h1>Posted Data</h1>";
echo "<xmp>";
//echo formatXmlString(html_entity_decode($xml_post_string)); 
echo $xml_post_string;

echo "</xmp>";
//exit;
     $url = $soapUrl;

     // PHP cURL  for https connection with auth
     $ch = curl_init();
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
     //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
     curl_setopt($ch, CURLOPT_TIMEOUT, 30);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

     // converting
     $response = curl_exec($ch); 
     curl_close($ch);

/*echo "<pre>";	 
echo "<h1>Posted Data</h1>";
echo "<xmp>";
//echo formatXmlString(html_entity_decode($xml_post_string)); 
echo $xml_post_string;
echo "</xmp>";*/

echo "<h1>Response</h1>";
echo "<xmp>";
//print_r($response);
echo formatXmlString(html_entity_decode($response)); echo "</xmp>";
//exit;
$xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
$xml = simplexml_load_string($xml);
$json = json_encode($xml);
$responseArray = json_decode($json,true);

$add_new_order_docket_history_params = array('orders_id'=>$od->orders_id , 'courier_name'=>"DTDC", 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'posted_data'=>$xml_post_string , 'updated_by'=>$this->session->userdata("sess_user_id"));
$orders_docket_history_id = $_sosl->add_new_order_docket_history($add_new_order_docket_history_params);

$this->Common_Model->update_operation(array('table'=>'orders_docket_history' , 'data'=>array('response'=>$response) , 'condition'=>"(orders_docket_history_id = $orders_docket_history_id)"));
//print_r($responseArray);

$add_new_order_history_params = array('orders_id'=>$od->orders_id , 'order_status_id'=>7 , 'caption'=>"Assign Docket No." , 'remarks'=>'' , 'updated_by'=>$this->session->userdata("sess_user_id"));
$orders_history_id = $_sosl->add_new_order_history($add_new_order_history_params);

if(!empty($responseArray['sBody']))
{
	if(!empty($responseArray['sBody']['PostShipmentWithSpecialService3CMPMLNew_V6Response']))
	{
		if(!empty($responseArray['sBody']['PostShipmentWithSpecialService3CMPMLNew_V6Response']['PostShipmentWithSpecialService3CMPMLNew_V6Result']))
		{
			$url = $file_url = $responseArray['sBody']['PostShipmentWithSpecialService3CMPMLNew_V6Response']['PostShipmentWithSpecialService3CMPMLNew_V6Result'];
			$docket_number='';
			$temp = explode('/' , $file_url);
			$file_name = $temp = end($temp);
			$temp = explode('_' , $temp);
			$docket_number = $temp[0];
			echo "<br>$docket_number<br>";
			$url = str_replace(' ' , '%20' , $url);
			$ch = curl_init(); 
			
			curl_setopt($ch, CURLOPT_HEADER, 0); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch , CURLOPT_FAILONERROR , false);
			//curl_setopt($ch , CURLOPT_ENCODING , '');
			
			$data = curl_exec($ch); 
	
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			//echo $httpCode;
			if($httpCode !=200)
			{
				//Do Nothing...
			}
			else
			{
				file_put_contents( 'assets/docket/'.$file_name, $data );
				$this->Common_Model->update_operation(array('table'=>'orders_docket_history' , 'data'=>array('docket_no'=>$docket_number , 'courier_name'=>"DHL" , 'file_link'=>$file_name , 'post_json'=>$post_json) , 'condition'=>"(orders_docket_history_id = $orders_docket_history_id)"));
				
				$h_description = "Docket Number Assign With DHL. Docket No. Is : $docket_number";
				$this->Common_Model->update_operation(array('table'=>'orders_history' , 'data'=>array('description'=>$h_description) , 'condition'=>"(orders_history_id = $orders_history_id)"));
				
				$this->Common_Model->update_operation(array('table'=>'orders' , 'data'=>array('file_link'=>$file_name , 'docket_no'=>$docket_number , 'courier_name'=>"DHL" , 'post_json'=>$post_json) , 'condition'=>"(orders_id = $od->orders_id )"));
				//echo $this->db->last_query();
				$is_docket_assign = true;
				$this->session->set_flashdata('message', "<div class=' alert alert-success'>Docket No. Assigned Successfully</div>");
			}
			//echo $data;
			//echo $httpCode;
			curl_close($ch); 
			
			
		}
	}

}
if($is_docket_assign)
{
?>
<script>

window.location.reload();
</script>

<?
}
?>
 