
<?
/*$t_=0;
for($i=0 ; $i<5 ; $i++)
{
	${"t_" . $i}=$i*$i;
}
for($i=0 ; $i<5 ; $i++)
{
	echo ${"t_" . $i}.'<br>';
}*/

function file_get_contents_curl($url) { 
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
			echo $url;
			$data = ''; 
			echo $httpCode.'test2';
		}
		//echo $data;
		//echo $httpCode;
		curl_close($ch); 

		$http_codes = array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			102 => 'Processing',
			103 => 'Checkpoint',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			207 => 'Multi-Status',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => 'Switch Proxy',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			418 => 'I\'m a teapot',
			422 => 'Unprocessable Entity',
			423 => 'Locked',
			424 => 'Failed Dependency',
			425 => 'Unordered Collection',
			426 => 'Upgrade Required',
			449 => 'Retry With',
			450 => 'Blocked by Windows Parental Controls',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			506 => 'Variant Also Negotiates',
			507 => 'Insufficient Storage',
			509 => 'Bandwidth Limit Exceeded',
			510 => 'Not Extended'
		);
		$status='Bad Request';
		foreach($http_codes as $key=>$value)
		{
			if($key==$httpCode)
			{
				$status=$value;
			}
		}

		
	  
		return array("data"=>$data , "status"=>$status); 
	} 
	
function put_data_old($arr1 , $arr2 )
{
	$arr1 = (array)$arr1;
	$arr2 = (array)$arr2;

	
	$final_array = array();
	foreach($arr1 as $key1=>$value1)
	{
		foreach($arr2 as $key2=>$value2)
		{
			if($value1 == $key2)
			{
				$final_array[$value1] = $value2;
			}
		}
	}
	return $final_array;
}

function put_data($arr1 , $arr2 )
{
	$arr1 = (array)$arr1;
	$arr2 = (array)$arr2;

	
	$final_array = array();
	foreach($arr1 as $key1=>$value1)
	{
		$final_array[$key1] = $value1;
	}
	return $final_array;
}
//echo "<h1>Fields</h1>";
//print_r($this->Admin_Model->product_fields);
//print_r($this->data);
//exit;
$product_detail = $product_detail[0];
/*echo "<h1>DATA</h1>";
print_r($product_detail);*/



//echo "<h1>Product Final Data</h1>";
$product_detail_data = put_data($product_detail , $product_detail);

$product_detail_data['ref_code'] = $product_detail_data['ref_code'].'-'.time();
$product_detail_data['product_id'] = 0;
//print_r($product_detail_data);
$product_id = $this->Common_Model->add_operation(array('table'=>'product' , 'data'=>$product_detail_data));


$i_count=0;
foreach($product_category_detail as $pcd)
{
	$i_count++;
	//echo "<h1>Product Category Detail DATA</h1>";
	$product_category_detail_data = put_data($pcd , $pcd);
	$product_category_detail_data['product_id'] = $product_id;
	$t_p_pc_id = $product_category_detail_data['product_category_id'];
	$product_category_detail_data['product_category_id'] = 0;
	//print_r($product_category_detail_data);
	$product_category_id = $this->Common_Model->add_operation(array('table'=>'product_category' , 'data'=>$product_category_detail_data));
	${"product_category_id_" . $t_p_pc_id}=$product_category_id;

}

$i_count=0;
foreach($product_image_detail as $pi_img)
{
	$i_count++;
	//echo "<h1>Image DATA</h1>";
	$product_image_detail_data = put_data($pi_img , $pi_img);
	$product_image_detail_data['product_id'] = $product_id;
	$t_p_image_id = $product_image_detail_data['product_image_id'];
	$product_image_detail_data['product_image_id'] = 0;
	//print_r($product_image_detail_data);
	$product_image_id = $this->Common_Model->add_operation(array('table'=>'product_image' , 'data'=>$product_image_detail_data));
	${"product_image_id_" . $t_p_image_id}=$product_image_id;
	$temp_ext_arr = explode("." , $product_image_detail_data['product_image_name']);
	$temp_image_ext = end($temp_ext_arr);
	
	$image_url = _uploaded_files_.'product/small/'.$product_image_detail_data['product_image_name'];
	$result = file_get_contents_curl( $image_url); 
	$image_name = 'product_'.$product_id.'_'.$i_count.'.'.$temp_image_ext;
	file_put_contents( _uploaded_temp_files_.'product/small/'.$image_name, $result['data'] );
	
	$image_url = _uploaded_files_.'product/medium/'.$product_image_detail_data['product_image_name'];
	$result = file_get_contents_curl( $image_url); 
	$image_name = 'product_'.$product_id.'_'.$i_count.'.'.$temp_image_ext;
	file_put_contents( _uploaded_temp_files_.'product/medium/'.$image_name, $result['data'] );
	
	$image_url = _uploaded_files_.'product/large/'.$product_image_detail_data['product_image_name'];
	$result = file_get_contents_curl( $image_url); 
	$image_name = 'product_'.$product_id.'_'.$i_count.'.'.$temp_image_ext;
	file_put_contents( _uploaded_temp_files_.'product/large/'.$image_name, $result['data'] );
	
	$this->Common_Model->update_operation(array('table'=>'product_image' , 'data'=>array('product_image_name'=>$image_name) , 'condition'=>"(product_image_id=$product_image_id)"));
}



$i_count=0;
foreach($product_combination_detail as $pcd)
{
	$i_count++;
	//echo "<h1>Product Combination Detail DATA</h1>";
	$product_combination_detail_data = put_data($pcd , $pcd);
	$product_combination_detail_data['product_id'] = $product_id;
	$t_p_pc_id = $product_combination_detail_data['product_combination_id'];
	$product_combination_detail_data['product_combination_id'] = 0;
	$product_combination_detail_data['ref_code'] = $product_combination_detail_data['ref_code'].'-'.$i_count.'-'.time();
	$product_combination_detail_data['product_image_id'] = ${"product_image_id_" . $product_combination_detail_data['product_image_id']};
	//print_r($product_combination_detail_data);
	$product_combination_id = $this->Common_Model->add_operation(array('table'=>'product_combination' , 'data'=>$product_combination_detail_data));
	${"product_combination_id_" . $t_p_pc_id}=$product_combination_id;
	
	
	//$this->Admin_Model->update_operation(array('table'=>'product_combination' , 'data'=>array('product_image_name'=>$image_name) , 'condition'=>"(product_image_id=$product_image_id)"));
}

$i_count=0;
foreach($product_combination_attribute_detail as $pcd)
{
	$i_count++;
	//echo "<h1>Product Combination attribute Detail DATA</h1>";
	$product_combination_attribute_detail_data = put_data($pcd , $pcd);
	$product_combination_attribute_detail_data['product_id'] = $product_id;
	$t_p_pc_id = $product_combination_attribute_detail_data['product_combination_attribute_id'];
	$product_combination_attribute_detail_data['product_combination_attribute_id'] = 0;
//	$product_combination_attribute_detail_data['product_combination_id'] = $product_combination_attribute_detail_data['ref_code'].'-'.$i_count.'-'.time();
	$product_combination_attribute_detail_data['product_combination_id'] = ${"product_combination_id_" . $product_combination_attribute_detail_data['product_combination_id']};
	//print_r($product_combination_attribute_detail_data);
	$product_combination_attribute_id = $this->Common_Model->add_operation(array('table'=>'product_combination_attribute' , 'data'=>$product_combination_attribute_detail_data));
	${"product_combination_attribute_id_" . $t_p_pc_id}=$product_combination_attribute_id;
	
}

$i_count=0;
foreach($product_use_info_value_detail as $pcd)
{
	$i_count++;
	//echo "<h1>Product Use Info Detail DATA</h1>";
	$product_use_info_value_detail_data = put_data($pcd , $pcd);
	$product_use_info_value_detail_data['product_id'] = $product_id;
	$t_p_pc_id = $product_use_info_value_detail_data['product_use_info_value_id'];
	$product_use_info_value_detail_data['product_use_info_value_id'] = 0;
	//print_r($product_use_info_value_detail_data);
	$product_use_info_value_id = $this->Common_Model->add_operation(array('table'=>'product_use_info_value' , 'data'=>$product_use_info_value_detail_data));
	${"product_use_info_value_id_" . $t_p_pc_id}=$product_use_info_value_id;
	
}


$i_count=0;
foreach($product_seo_detail as $pcd)
{
	$i_count++;
	//echo "<h1>Product SEO Detail DATA</h1>";
	$product_seo_detail_data = put_data($pcd , $pcd);
	$product_seo_detail_data['product_id'] = $product_id;
	$t_p_pc_id = $product_seo_detail_data['product_seo_id'];
	$product_seo_detail_data['product_seo_id'] = 0;
	$product_seo_detail_data['product_combination_id'] = ${"product_combination_id_" . $product_seo_detail_data['product_combination_id']};
	$product_seo_detail_data['slug_url'] = $product_seo_detail_data['slug_url'].'-'.$i_count.'-'.time();
	//print_r($product_seo_detail_data);
	$product_seo_id = $this->Common_Model->add_operation(array('table'=>'product_seo' , 'data'=>$product_seo_detail_data));
	${"product_seo_id_" . $t_p_pc_id}=$product_seo_id;
	
}

$i_count=0;
foreach($product_specification_detail as $pcd)
{
	$i_count++;
	//echo "<h1>Product Specification Detail DATA</h1>";
	//print_r($pcd);
	$product_specification_detail_data = put_data($pcd , $pcd);
	$product_specification_detail_data['product_id'] = $product_id;
	$t_p_pc_id = $product_specification_detail_data['product_specification_id'];
	$product_specification_detail_data['product_specification_id'] = 0;
	if(!empty(${"product_combination_id_" . $product_specification_detail_data['product_combination_id']}))
		$product_specification_detail_data['product_combination_id'] = ${"product_combination_id_" . $product_specification_detail_data['product_combination_id']};
	else
		$product_specification_detail_data['product_combination_id'] = 0;
	//$product_specification_detail_data['slug_url'] = $product_specification_detail_data['slug_url'].'-'.$i_count.'-'.time();
	//print_r($product_specification_detail_data);
	$product_specification_id = $this->Common_Model->add_operation(array('table'=>'product_specification' , 'data'=>$product_specification_detail_data));
	${"product_specification_id_" . $t_p_pc_id}=$product_specification_id;
	
}


$i_count=0;
foreach($product_in_store_detail as $pcd)
{
	$i_count++;
	//echo "<h1>Product Specification Detail DATA</h1>";
	//print_r($pcd);
	$product_in_store_detail_data = put_data($pcd , $pcd);
	$product_in_store_detail_data['product_id'] = $product_id;
	$t_p_pc_id = $product_in_store_detail_data['product_in_store_id'];
	$product_in_store_detail_data['product_in_store_id'] = 0;
	$product_in_store_detail_data['product_combination_id'] = ${"product_combination_id_" . $product_in_store_detail_data['product_combination_id']};
	//$product_in_store_detail_data['slug_url'] = $product_in_store_detail_data['slug_url'].'-'.$i_count.'-'.time();
	//print_r($product_in_store_detail_data);
	$product_in_store_id = $this->Common_Model->add_operation(array('table'=>'product_in_store' , 'data'=>$product_in_store_detail_data));
	${"product_in_store_id_" . $t_p_pc_id}=$product_in_store_id;
	
}



$this->session->set_flashdata('alert_message', '<div class="alert alert-success"><strong>Success!</strong> Clone Created Successfully. This is the cloned product you created.</div>');
REDIRECT(MAINSITE_Admin."catalog/Product-Module/edit/".$product_id);



?>