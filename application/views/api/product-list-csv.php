<?
/*echo "<pre>";
print_r($products_list[0]);
echo "</pre>";*/

?>



<table cellpadding="2" cellspacing="2" border="1">
    <thead>
    	<tr>
            <th>id</th>
            <th>Product Name</th>
            <th>Weight</th>
            <th>Brand Name</th>
            <th>HSN Code</th>
            <th>GST Rate (%)</th>
            <th>link</th>
            <th>Parent Category</th>
            <th>Sub Category</th>
            <th>Child Category</th>
            <th>Image Ref</th>
            <th>Reference ID (Code)</th>
            <th>Combination</th>
            <th>MRP</th>
            <th>Discount</th>
            <th>Final Price</th>
            <th>Status (Active/Block)</th>
            <th>Shipping Weight</th>
            
        </tr>
    </thead>
    <tbody>
<?

if(!empty($_POST['offset'])){$offset = $_POST['offset'];}
$display_product_count = 0;
 if(!empty($products_list)){ ?>
<?
$load_img_class='';
if(!empty($callFor)){if($callFor=='loadMore'){$load_img_class = 'lazy_product';}}
?>
<?
    $CI = &get_instance();
	$page_count = 0;
    foreach ($products_list as $col) {
		
		$page_count++;
        $product_name = $col['name'];
		//$all_images =  $col['all_images'];
        $ps_slug_url = $col['ps_slug_url'];
        $product_id = $col['product_id'];
		
		$m_category = '';
		$s_category = '';
		$ss_category = '';
		
		$query_get_list = $this->db->query("SELECT c.name , c.slug_url , c.category_id , c.super_category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and super_category_id = 0 and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1 ");
			//echo "SELECT c.name , c.slug_url , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and super_category_id = 0 and pc.product_id = ".$product_id . " and status =1 limit 1 <br>";
			$query_data = $query_get_list->result();
			if(!empty($query_data))
			{
				$qd = $query_data[0];
				//echo "<pre>";print_r($qd );echo "</pre>";
				//$this->data['breadcrumbs'].='<li><a href="'.base_url().$qd->slug_url.'">'.$qd->name.'</a></li><li><span><i class="fa fa-angle-right"></i></span></li> ';
				$m_category = $qd->name;
				//$this->data['gtm_product_category'].= $qd->name;
				
				$query_get_list = $this->db->query("SELECT c.name , c.slug_url , c.super_category_id , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd->category_id."  and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1  ");
				//echo "SELECT c.name , c.slug_url , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd->category_id."  and pc.product_id = ".$product_id . " and status =1 limit 1 <br>";
				$query_data1 = $query_get_list->result();
				if($query_data1)
				{
					$qd1 = $query_data1[0];
					//echo "<pre>";print_r($qd1);echo "</pre>";
					//$this->data['breadcrumbs'].='<li><a href="'.base_url().$qd->slug_url.'/'.$qd1->slug_url.'">'.$qd1->name.'</a></li><li><span><i class="fa fa-angle-right"></i></span></li> ';
					//$this->data['gtm_product_category'].= ' -> '.$qd1->name;
					$s_category = $qd1->name;
					$query_get_list = $this->db->query("SELECT c.name , c.super_category_id , c.slug_url , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd1->category_id." and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1  ");
					//echo "SELECT c.name , c.slug_url , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd1->category_id." and pc.product_id = ".$product_id . " and status =1 limit 1 <br>";
					$query_data2 = $query_get_list->result();
					if($query_data2)
					{
						$qd2 = $query_data2[0];
						//echo "<pre>";print_r($qd2);echo "</pre>";
						//$this->data['gtm_product_category'].= ' -> '.$qd2->name;
						//$this->data['breadcrumbs'].='<li><a href="'.base_url().base_url().$qd->slug_url.'/'.$qd1->slug_url.'/'.$qd2->slug_url.'">'.$qd2->name.'</a></li><li><span><i class="fa fa-angle-right"></i></span></li> ';
						$ss_category = $qd2->name;
					}
				}
			}
		
		
        $short_description = $col['short_description'];
        $manufacturer_name = $col['manufacturer_name'];
        $totalrating = $col['totalrating'];
        $totalreview = $col['totalreview'];
		$avgrating = $col['avgrating'];
        $combi_ref_code = $col['pc_ref_code'];
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
        if (!empty($product_display_name)) {
            $product_name = $product_display_name;
        } else {
            $product_name = $product_name;// . '<br>' . $combi;
        }
        unset($attribute);
		$display_status='Block';
        $status = $col['status'];
		if($status==1)
		{
			$display_status='Active';
		}
        $product_weight = $col['product_weight'];
        $tax_providers_percentage = $col['tax_providers_percentage'];
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
		
		
		$short_description =  str_replace( '/(<([^>]+)>)/ig', '' ,$short_description);
		if(empty($combi_ref_code)){$combi_ref_code = $product_combination_id;}
		$short_description = $short_description;
        ?>
     <tr>
    	<td><?=$product_combination_id?></td>
    	<td><?=$product_name?></td>
        <td><?=$product_weight?></td>
        <td><?=$manufacturer_name?></td>
        <td></td>
        <td><?=$tax_providers_percentage?></td>
    	<td><?=$product_link?></td>
        <td><?=$m_category?></td>
        <td><?=$s_category?></td>
        <td><?=$ss_category?></td>
    	<td><?= base_url() ?>assets/uploads/product/medium/<? echo $product_image_name; ?></td>
    	<td><?=$combi_ref_code?></td>
        <td><?=$combi?></td>
        <td><?=number_format((float)$price, 2, '.', '');?> INR</td>
        <td><?=$discount?> </td>
        <td><?=number_format((float)$final_price, 2, '.', '');?> INR</td>
        <td><?=$display_status?></td>
        <td><?=$product_weight?></td>
        
    </tr>
	<?
	}}
?>
<?
exit;
//header('Content-type: application/ms-excel');
//header('Content-Disposition: attachment; filename=sample.xls');

error_reporting(E_ALL);
$csv_hdr = "id, title, description, availability, condition, price, link, image_link, brand, Additional_image_link, sale_price, age_group, color, gender, item_group_id, google_product_category, material, pattern, product_type, sale_price_effective, shipping, shipping_weight, size, custom_label_0, custom_label_1, custom_label_2, custom_label_3, custom_label_4";

$csv_head_arr = array ( 'id' , 'title' , 'description' , 'availability' , 'condition' , 'price' , 'link' , 'image_link' , 'brand' , 'Additional_image_link' , 'sale_price' , 'age_group' , 'color' , 'gender' , 'item_group_id' , 'google_product_category' , 'material' , 'pattern' , 'product_type' , 'sale_price_effective' , 'shipping' , 'shipping_weight' , 'size' , 'custom_label_0' , 'custom_label_1' , 'custom_label_2' , 'custom_label_3' , 'custom_label_4' );
$csv_body='';
?>
<?

if(!empty($_POST['offset'])){$offset = $_POST['offset'];}
$display_product_count = 0;
 if(!empty($products_list)){ ?>
<?
$load_img_class='';
if(!empty($callFor)){if($callFor=='loadMore'){$load_img_class = 'lazy_product';}}
?>
<?
    $CI = &get_instance();
	$page_count = 0;
    foreach ($products_list as $col) {
		$page_count++;
        $product_name = $col['name'];
		$all_images =  $col['all_images'];
        $ps_slug_url = $col['ps_slug_url'];
        $product_id = $col['product_id'];
        $short_description = $col['short_description'];
        $manufacturer_name = $col['manufacturer_name'];
        $totalrating = $col['totalrating'];
        $totalreview = $col['totalreview'];
		$avgrating = $col['avgrating'];
        $combi_ref_code = $col['combi_ref_code'];
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
		foreach($all_images as $ai)
		{
			$additional_images[] = base_url().'assets/uploads/product/medium/'.$ai->product_image_name;
		}
		$main_image = base_url()."assets/uploads/product/medium/".$product_image_name;
		
		
		$short_description =  str_replace( '/(<([^>]+)>)/ig', '' ,$short_description);
		if(empty($combi_ref_code)){$combi_ref_code = $product_combination_id;}
		/*$short_description =  str_replace( ',', '', $short_description);
		$short_description =  str_replace( '\n', '', $short_description);
		$short_description =  str_replace( '<br />', '', $short_description);
		$short_description =  str_replace( '<br>', '', $short_description);
		$short_description = nl2br($short_description);
		$short_description = strip_tags($short_description);
		$short_description = preg_replace( "/\r|\n/", "", $short_description );*/
		$short_description = $short_description;
		//$csv_body.=$combi_ref_code.", ".$product_name.", ".$short_description.", ".$product_availability.", new,  ".number_format((float)$price, 2, '.', '')." INR, ".$product_link.", ".$base_url()."assets/uploads/product/medium/".$product_image_name.", ".$manufacturer_name.", ".implode(',' , $additional_images).", ".number_format((float)$final_price, 2, '.', '')." INR, , , , ".$product_combination_id.", , , , , , , , ".$combi.", , , , ";
		
		$csv_body.=$combi_ref_code.", ".str_replace(',' , '',  $product_name).", ".$short_description.", ".$product_availability.", new,  ".number_format((float)$price, 2, '.', '')." INR, ".$product_link.", ".$main_image.", ".$manufacturer_name.", ".implode(';' , $additional_images).", ".number_format((float)$final_price, 2, '.', '')." INR, , , , ".$product_combination_id.", , , , , , , , ".$combi.", , , , ";
		$csv_body .= "\n";
$csv_body_arr[] = array ($combi_ref_code , $product_name , $short_description , $product_availability , "new" , number_format((float)$price, 2, '.', '')." INR" , $product_link , $main_image , $manufacturer_name , implode(',' , $additional_images) , number_format((float)$final_price, 2, '.', '')." INR" , "", "", "", "", $product_combination_id,"" ,"" ,"" ,"" ,"" ,"" ,"" ,$combi,"","" ,"" ,"");
//echo "<pre>"; print_r($csv_head_arr);
//echo "<pre>"; print_r($csv_body_arr);
//echo count($csv_head_arr[0]);exit;
        ?>
 <?php /*?>    <tr>
    	<td><?=$combi_ref_code?></td>
    	<td><?=$product_name?></td>
    	<td><?=$short_description?></td>
    	<td><?=$product_availability?></td>
    	<td>new</td>
    	<td><?=number_format((float)$price, 2, '.', '');?> INR</td>
    	<td><?=$product_link?></td>
    	<td><?= base_url() ?>assets/uploads/product/medium/<? echo $product_image_name; ?></td>
    	<td><?=$manufacturer_name?></td>
    	<td><?=implode(',' , $additional_images)?></td>
    	<td><?=number_format((float)$final_price, 2, '.', '');?> INR</td>
    	<td><?php #age_group<?php ?></td>
    	<td><?php #color<?php ?></td>
    	<td><?php #gender<?php ?></td>
    	<td><?=$product_combination_id?></td>
    	<td><?php #google_product_category<?php ?></td>
    	<td><?php #material<?php ?></td>
    	<td><?php #pattern<?php ?></td>
    	<td><?php #product_type<?php ?></td>
    	<td><?php #sale_price_effective<?php ?></td>
    	<td><?php #shipping<?php ?></td>
    	<td><?php #shipping_weight<?php ?></td>
    	<td><?php #size<?php ?></td>
    	<td><?=$combi?></td>
    	<td><?php #custom_label_1<?php ?></td>
    	<td><?php #custom_label_2<?php ?></td>
    	<td><?php #custom_label_3<?php ?></td>
    	<td><?php #custom_label_4<?php ?></td>
    </tr><?php */?>
	<?
	}}
/*?>
	</tbody>
</table>



<?*/


//exit;
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


exit;


/*
 This file will generate our CSV table. There is nothing to display on this page, it is simply used
 to generate our CSV file and then exit. That way we won't be re-directed after pressing the export
 to CSV button on the previous page.
*/

//First we'll generate an output variable called out. It'll have all of our text for the CSV file.
$out = '';

//Next let's initialize a variable for our filename prefix (optional).
$filename_prefix = 'csv';

//Next we'll check to see if our variables posted and if they did we'll simply append them to out.
$out .= $csv_hdr;
//$out .= "\n";

$out .= $csv_body;


//Now we're ready to create a file. This method generates a filename based on the current date & time.
$filename = $filename_prefix."_".date("Y-m-d_H-i",time());

//Generate the CSV file header
/*header("Content-type: application/vnd.ms-excel");
header("Content-Encoding: UTF-8");
header("Content-type: text/csv; charset=UTF-8");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header("Content-disposition: filename=".$filename.".csv");*/
//echo "\xEF\xBB\xBF"; // UTF-8 BOM
//Print the contents of out to the generated file.
print $out;

//Exit the script
exit;
?>