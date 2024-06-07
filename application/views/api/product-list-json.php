<?
error_reporting(E_ALL);

$csv_hdr = "id , title , description , link , condition , price , availability , image_link , gtin , mpn , brand , google_product_category , sale_price , additional_image_link , item_group_id , product_type , canonical_link , custom_label_0";

 $csv_head_arr = array ( 'id' , 'title' , 'description' , 'link' , 'condition' , 'price' , 'availability' , 'image_link' , 'gtin' , 'mpn' , 'brand' , 'google_product_category' , 'sale_price' , 'additional_image_link' , 'item_group_id' , 'product_type' , 'canonical_link' , 'custom_label_0' , 'custom_label_1' , 'custom_label_2' , 'custom_label_3' , 'custom_label_4' , 'promotion_id');
$csv_body='';

if(!empty($_POST['offset'])){$offset = $_POST['offset'];}
$display_product_count = 0;
 if(!empty($products_list)){ ?>
<?
$load_img_class='';
if(!empty($callFor)){if($callFor=='loadMore'){$load_img_class = 'lazy_product';}}
?>
<?
$remove[] = "'";
$remove[] = '"';

    $CI = &get_instance();
	$page_count = 0;
    foreach ($products_list as $col) {
		$page_count++;
        $product_name = $col['name'];
		$all_images='';
		$custom_label_0 = '';
		$custom_label_1 = '';
		$custom_label_2 = '';
		$additional_image_link='';
		$product_type = '';
		//$all_images =  $col['all_images'];
		$pc_ref_code = $col['pc_ref_code'];
		$product_combination_id = $col['product_combination_id'];
        $ps_slug_url = $col['ps_slug_url'];
        $product_id = $col['product_id'];
        $short_description = $col['short_description'];
        $brand_name = $col['brand_name'];
        $totalrating = $col['totalrating'];
        $totalreview = $col['totalreview'];
		$avgrating = $col['avgrating'];
		$product_image_id = $col['product_image_id'];
		$combi_ref_code = '';
		
		$custom_label_0_list = $this->db->query("SELECT c.name , c.slug_url , c.category_id , c.super_category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and super_category_id = 0 and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1 ");
		
		$custom_label_0_data = $custom_label_0_list->result();
		if(!empty($custom_label_0_data))
		{
			$qd = $custom_label_0_data[0];
			$custom_label_0 = $qd->name;
		}
		
		$additional_image_link_list = $this->db->query("SELECT * from product_image where product_id = ".$product_id . " and product_image_id != ".$product_image_id . " and status =1 order by position ASC ");
		
		$additional_image_link_data = $additional_image_link_list->result();
		if(!empty($additional_image_link_data))
		{
			$img_arr = array();
			foreach($additional_image_link_data as $img_data)
			{
				$img_arr[] = base_url()."assets/uploads/product/medium/".$img_data->product_image_name;
			}
			//print_r($img_arr);
			//$qd = $additional_image_link_data[0];
			$additional_image_link = implode(",",$img_arr);
		}
		
		
		$query_get_list = $this->db->query("SELECT c.name , c.slug_url , c.category_id , c.super_category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and super_category_id = 0 and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1 ");
		$query_data = $query_get_list->result();
		if(!empty($query_data))
		{
			$qd = $query_data[0];
			$product_type.= $qd->name;
			
			$query_get_list = $this->db->query("SELECT c.name , c.slug_url , c.super_category_id , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd->category_id."  and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1  ");
			$query_data1 = $query_get_list->result();
			if($query_data1)
			{
				$qd1 = $query_data1[0];
				$custom_label_1 = $qd1->name;
				$product_type.= ' > '.$qd1->name;
				$query_get_list = $this->db->query("SELECT c.name , c.super_category_id , c.slug_url , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd1->category_id." and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1  ");
				$query_data2 = $query_get_list->result();
				if($query_data2)
				{
					$qd2 = $query_data2[0];
					$product_type.= ' > '.$qd2->name;
					$custom_label_2 = $qd2->name;
				}
			}
		}
		
		
		
       // $combi_ref_code = $col['combi_ref_code'];
        if ($col['discount_var'] == 'Rs') {
            $discount = $currency->symbol . ' ' . $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $col['discount']));
            $discount = trim($discount);
        } else {
            $discount = round($col['discount']) . ' ' . $col['discount_var'];
            $discount = trim($discount);
        }
        $price = $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $col['price']));
        $final_price = $CI->getCurrencyPrice(array('obj' => $this->data, 'amount' => $col['final_price']));
        $product_image_name = $col['product_image_name'];
        $combi = $col['combi'];
        $product_display_name = $col['product_display_name'];
        $gtin = $col['gtin'];
        if (!empty($product_display_name)) {
            $product_name = $product_display_name;
        } else {
            $product_name = $product_name;// . '<br>' . $combi;
        }
        unset($attribute);
        $attribute = $col['attribute'];
        $product_in_store_id = $col['product_in_store_id'];
        $product_combination_id = $col['product_combination_id'];
        $prod_in_cart = $col['prod_in_cart'];
        $prod_in_wishList = $col['prod_in_wishList'];
        $in_store_quantity = $col['quantity'];
        $stock_out_msg = $col['stock_out_msg'];
        $product_link = base_url() . 'products-details/' . $product_id;
        if (!empty($ps_slug_url)) {
            $product_link = '';
            $product_link .= base_url();
            if (!empty($pre_url_product)) {
                $product_link .= $pre_url_product;
            }
            $product_link .= $ps_slug_url;
        }
		$product_availability = 'in stock';
		if ($in_store_quantity <= 0) {
			$product_availability = 'out of stock';
		}
		$additional_images = array();
		/*foreach($all_images as $ai)
		{
			$additional_images[] = base_url().'assets/uploads/product/medium/'.$ai->product_image_name;
		}*/
		$main_image = base_url()."assets/uploads/product/medium/".$product_image_name;
		
		$short_description = str_replace($remove , '' , $short_description);
		$short_description = str_replace('"' , '' , $short_description);
		$short_description = str_replace("'" , '' , $short_description);
		$short_description = preg_replace("/'/", "", $short_description);
		$short_description = preg_replace('/"/', "", $short_description);
		
		$short_description = str_replace("'" , '~~~' , $short_description);
		$short_description = str_replace('"' , '~~~' , $short_description);
		
		$short_description =  str_replace( '/(<([^>]+)>)/ig', '' ,$short_description);
		if(empty($combi_ref_code)){$combi_ref_code = $product_combination_id;}
		/*$short_description =  str_replace( ',', '', $short_description);
		$short_description =  str_replace( '\n', '', $short_description);
		$short_description =  str_replace( '<br />', '', $short_description);
		$short_description =  str_replace( '<br>', '', $short_description);
		$short_description = nl2br($short_description);
		$short_description = strip_tags($short_description);
		$short_description = preg_replace( "/\r|\n/", "", $short_description );*/
		
		
		
		$short_description = str_replace($remove , '' , $short_description);
		$brand_name = str_replace($remove , '' , $brand_name);
		$product_name = str_replace($remove , '' , $product_name);

		
		$short_description = $short_description;
		$short_description = str_replace('"' , '' , $short_description);
		$short_description = str_replace("'" , '' , $short_description);
		if(empty($short_description))
		{
			$short_description = $product_name_uc;
		}
		$brand_name = str_replace('"' , '' , $brand_name);
		$brand_name = str_replace("'" , '' , $brand_name);

		//$csv_body.=$combi_ref_code.", ".$product_name.", ".$short_description.", ".$product_availability.", new,  ".number_format((float)$price, 2, '.', '')." INR, ".$product_link.", ".$base_url()."assets/uploads/product/medium/".$product_image_name.", ".$brand_name.", ".implode(',' , $additional_images).", ".number_format((float)$final_price, 2, '.', '')." INR, , , , ".$product_combination_id.", , , , , , , , ".$combi.", , , , ";
		
		$csv_body.=$combi_ref_code.", ".str_replace(',' , '',  $product_name).", ".$short_description.", ".$product_availability.", new,  ".number_format((float)$price, 2, '.', '')." INR, ".$product_link.", ".$main_image.", ".$brand_name.", ".implode(';' , $additional_images).", ".number_format((float)$final_price, 2, '.', '')." INR, , , , ".$product_combination_id.", , , , , , , , ".$combi.", , , , ";
		$csv_body .= "\n";
		// product_combination_id
		$columnA = trim($pc_ref_code);
		if(empty($columnA)) { $columnA = $product_combination_id; }
		$product_name = strtolower($product_name);
		$product_name_uc = ucwords($product_name);
		
		
		$short_description = str_replace($remove , '' , $short_description);
		$brand_name = str_replace($remove , '' , $brand_name);
		$product_name = str_replace($remove , '' , $product_name);
		
		$product_name = str_replace('"' , '' , $product_name);
		$product_name = str_replace("'" , '' , $product_name);
		
		$short_description = str_replace('"' , '' , $short_description);
		$short_description = str_replace("'" , '' , $short_description);
		
		$brand_name = str_replace('"' , '' , $brand_name);
		$brand_name = str_replace("'" , '' , $brand_name);
		
		$brand_name = html_entity_decode($brand_name);
		$short_description = html_entity_decode($short_description);
		$product_name = html_entity_decode($product_name);
$promotion_id='';
if($columnA=='TSM00737')
{
	$promotion_id = 'TSM05';
}
//.'?utm_source=test_merchant_center&utm_medium=merchant_center' 
$index_count = 0;
$csv_body_arr[] = array (
	$csv_head_arr[0]=>$columnA.'-'.$product_combination_id , 
	$csv_head_arr[1]=>trim($product_name_uc), 
	$csv_head_arr[2]=>trim($short_description) , 
	$csv_head_arr[3]=>$product_link.'/', 
	$csv_head_arr[4]=>'new', 
	$csv_head_arr[5]=>number_format((float)$price, 2, '.', '')." INR" , 
	$csv_head_arr[6]=>$product_availability , 
	$csv_head_arr[7]=>$main_image, 
	$csv_head_arr[8]=>"$gtin " , 
	$csv_head_arr[9]=>" " , 
	$csv_head_arr[10]=>trim($brand_name) , 
	$csv_head_arr[11]=>" ",
	$csv_head_arr[12]=>number_format((float)$final_price, 2, '.', '')." INR" , 
//	$csv_head_arr[13]=>$additional_image_link,
	$csv_head_arr[13]=>" ",
	$csv_head_arr[14]=>$product_id,
//	$csv_head_arr[15]=>$product_type,
	$csv_head_arr[15]=>" ",
	$csv_head_arr[16]=>" ",
	$csv_head_arr[17]=>$custom_label_0,
	$csv_head_arr[18]=>$custom_label_1,
	$csv_head_arr[19]=>$custom_label_2,
	$csv_head_arr[20]=>'Genuine Products',
	$csv_head_arr[21]=>'Hygiene Products',
	$csv_head_arr[22]=>$promotion_id
	//$csv_head_arr[18]=>"TS"
	);
	}
	
 }
 $csv_head_arr = array ( 'id' , 'title' , 'description' , 'link' , 'condition' , 'price' , 'availability' , 'image_link' , 'gtin' , 'mpn' , 'brand' , 'google_product_category' , 'sale_price' , 'additional_image_link' , 'item_group_id' , 'product_type' , 'canonical_link' , 'custom_label_0' , 'custom_label_1' , 'custom_label_2' , 'custom_label_3' , 'custom_label_4' , 'promotion_id');
 /*echo "<pre>";
 print_r($csv_body_arr);
 exit;*/
 
$this->response['status'] = 'true';
$this->response['message'] = 'success';
$this->response['data'] = $csv_body_arr;
echo json_encode($this->response);
/*
$file_name = product_.time();
 $data = $csv_body_arr;
	header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=\"$file_name".".csv\"");
	header("Pragma: no-cache");
	header("Expires: 0");

	$handle = fopen('php://output', 'w');
	fputcsv($handle, $csv_head_arr);
	$cnt=1;
	foreach ($data as $key) {
		//$narray=array($cnt,$key["f_name"],$key["l_name"]);
		fputcsv($handle, $key);
	}
		fclose($handle);


exit;*/

?>