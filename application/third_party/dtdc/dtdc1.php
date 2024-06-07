
<?

$post = array(
    'trkType' => '120768641721',
    'strcnno' => 'B68110490',
    'addtnlDtl'   => 'Y',
);
$post = json_encode($post);
//$ch = curl_init('http://ctbsplusapi.dtdc.com/dtdc-staging-api/rest/JSONCnTrk/getTrackDetails'); # Staging
$ch = curl_init('http://ctbsplusapi.dtdc.com/dtdc-api/rest/JSONCnTrk/getTrackDetails'); # Production
//$url = "https://blktracksvc.dtdc.com/dtdc-api/rest/XMLCnTrk/getDetails?strcnno=B68110490&TrkType=120768641721&addtnlDtl=Y&apikey=BL10753_trk:88797730c1a4b6c84eb44e1903b1a3b1";
//$ch = curl_init($url); # Production
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
//curl_setopt($ch, CURLOPT_POSTFIELDS, "trkType=120768641721&strcnno=B68110490&addtnlDtl=Y");

$url = "https://blktracksvc.dtdc.com/dtdc-api/api/dtdc/authenticate?username=BL10753_trk&password=y2bjsG26wachwws";
$result = file_get_contents("$url");
		//print('<code>');
		print($result);
		//print('</code>');

$headers = array(
    'X-Access-Token: BL10753_trk:88797730c1a4b6c84eb44e1903b1a3b1'
);

/*$headers = array(
    'X-Access-Token: '.$result
);*/

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);



// execute!
$response = curl_exec($ch);
//print_r($response);
// close the connection, release resources used
curl_close($ch);

// do anything you want with your response
//var_dump($response);



		
$url = "https://blktracksvc.dtdc.com/dtdc-api/rest/XMLCnTrk/getDetails?strcnno=B68110490&TrkType=120768641721&addtnlDtl=Y&apikey=".$result;
$result = file_get_contents("$url");
$xml = simplexml_load_string($result);
		$json = json_encode($xml);
		$json = json_decode($json);
		//print_r($json);
		//return $result;

?>
<pre>
<h1>Post Data</h1>
<? //print_r($post); ?>
<h1>Response</h1>
<? print_r($response); ?>

<h1>Response Json</h1>
<? print_r($json); ?>


</pre>