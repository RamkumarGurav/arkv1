<?php
class Database_Tables extends CI_Model
{
	var $customers_table_name = 'customers';
	
	var $ks_login_detail_fields = array('user_id' , 'login_id' , 'password' , 'user_status' , 'user_type' );	
	var $ks_login_detail_table_name = 'ks_login_detail';
	
	var $banner_fields = array('banner_id' , 'banner_name' , 'image'  , 'link', 'image_alt' , 'image_size', 'title' , 'content' , 'added_on', 'added_by', 'updated_on', 'updated_by' , 'status' , 'is_app_location');	
	var $banner_table_name = 'banner';
	var $sop_document_table_name = 'sop_document';
	
	var $files_upload_table_name = 'files_upload';
	
	var $client_groups_fields = array('client_groups_id' , 'title' , 'description' , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by', 'discount', 'minimum_order_value', 'delivery_charges', 'minimum_free_delivery_order_value', 'minimum_monthly_order_value', 'minimum_order_value');	
	var $client_groups_table_name = 'client_groups';	
	
	var $country_fields = array('country_id' , 'country_name' , 'country_short_name' , 'country_code'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');	
	var $country_table_name = 'country';	
	
	var $state_fields = array('state_id' ,'country_id', 'state_name'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by' , 'state_gst_code');	
	var $state_table_name = 'state';	
	
	var $product_use_info_fields = array('product_use_info_id' , 'content'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');	
	var $product_use_info_table_name = 'product_use_info';
	
	var $product_tag_fields = array('product_tag_id' , 'content'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');	
	var $product_tag_table_name = 'product_tag';
	
	var $city_fields = array('city_id' ,'state_id','country_id', 'city_name'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');	
	var $city_table_name = 'city';
	
	var $location_fields = array('location_id' , 'city_id' , 'state_id'  , 'country_id', 'location_name', 'location_pincode', 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');	
	var $location_table_name = 'location';
	
	var $tax_categories_fields = array('tax_categories_id' , 'tax_categories_name'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');	
	var $tax_categories_table_name = 'tax_categories';	
	
	var $tax_providers_fields = array('tax_providers_id' ,'tax_categories_id', 'tax_providers_percentage'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');	
	var $tax_providers_table_name = 'tax_providers';	
	
	var $manufacturer_fields = array('manufacturer_id' , 'manufacturer_name'   , 'manufacturer_image'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by', 'slug_url', 'meta_title', 'meta_description', 'meta_keyword', 'others', 'logo');	
	var $manufacturer_table_name = 'manufacturer';	
	
	var $main_category_fields = array('main_category_id' , 'main_category_name'   , 'main_category_image'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');	
	var $main_category_table_name = 'main_category';	
	
	var $sub_category_fields = array('sub_category_id' ,'main_category_id', 'sub_category_name' , 'sub_category_image'   , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');	
	var $sub_category_table_name = 'sub_category';	
	
	var $super_sub_category_fields = array('super_sub_category_id' ,'sub_category_id','main_category_id', 'super_sub_category_name'  , 'super_sub_category_image'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');	
	var $super_sub_category_table_name = 'super_sub_category';
	
	var $attributes_input_fields = array('attributes_input_id' , 'name' , 'type'  , 'input');
	var $attributes_input_table_name = 'attributes_input';
	
	var $product_attribute_fields = array('product_attribute_id' , 'attributes_input_id' , 'name' , 'condition_per_product'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by' , 'search', 'list_page', 'details_page');
	var $product_attribute_table_name = 'product_attribute';
	
	var $product_attribute_value_fields = array('product_attribute_value_id' , 'product_attribute_id' , 'name'  , 'color_name', 'added_on', 'updated_on', 'added_by', 'updated_by', 'status');	
	var $product_attribute_value_table_name = 'product_attribute_value';
	
	var $category_fields = array('category_id' , 'super_category_id' , 'name' , 'position'  , 'cover_image', 'added_on', 'updated_on', 'added_by', 'updated_by' , 'status' , 'is_dropdown' , 'header_1_img' , 'header_1_url' , 'footer_1_img' , 'footer_1_url' , 'footer_2_img' , 'footer_2_url' , 'footer_3_img' , 'footer_3_url' , 'left_1_img' , 'left_1_url' , 'left_2_img' , 'left_2_url' , 'left_3_img' , 'left_3_url' , 'left_4_img' , 'left_4_url' , 'left_5_img' , 'left_5_url' , 'left_6_img' , 'left_6_url' , 'slug_url' , 'meta_title' , 'meta_description' , 'meta_keyword' , 'others' , 'is_outer_menu' , "description","short_description" , 'is_display_home_page');
	var $category_table_name = 'category';
	
	var $product_fields = array('product_id' , 'manufacturer_id' , 'name'  , 'ref_code', 'slug_url', 'short_description', 'description', 'how_to_use', 'status' , 'added_on'  , 'added_by', 'updated_on', 'updated_by', 'tax_categories_id', 'tax_providers_id' , 'hsn_code' , 'is_sell_local' , 'is_bulk_enquiry' , 'product_sell_to');
	var $product_table_name = 'product';
	
	var $product_category_fields = array('product_category_id' , 'product_id' , 'category_id');
	var $product_category_table_name = 'product_category';
	
	var $product_image_fields = array('product_image_id' , 'product_id' , 'product_image_name' , 'default_image'  , 'status', 'added_on', 'added_by', 'updated_on', 'updated_by');
	var $product_image_table_name = 'product_image';
	
	var $product_combination_attribute_fields = array('product_combination_attribute_id' , 'product_id' , 'product_combination_id' , 'product_attribute_id'  , 'product_attribute_value_id', 'combination_value');
	
	var $product_combination_attribute_table_name = 'product_combination_attribute';
	
	public $product_combination_fields = array('product_combination_id' , 'ref_code' , 'product_id'  , 'product_image_id', 'quantity', 'product_weight', 'product_dimension' , 'price', 'discount', 'discount_var', 'final_price' , 'comb_slug_url' , 'status'  , 'added_on', 'added_by', 'updated_on', 'updated_by', 'trending_now', 'hot_selling_now', 'best_sellers', 'new_product', 'product_weight', 'product_dimension', 'product_l', 'product_b', 'product_h', 'current_viewers_msg', 'current_sold_msg', 'is_msg_dynamic', 'product_display_name' , 'delivery_charges' , 'gtin' , 'is_google_product', 'uom_id');	
	public $product_combination_table_name = 'product_combination';	
	


	var $product_in_store_fields = array('product_in_store_id' , 'store_id' , 'product_id'  , 'product_combination_id', 'quantity' , 'quantity_per_order' , 'stock_out_msg', 'price', 'discount', 'discount_var', 'final_price' , 'status'  , 'admin_status', 'added_on', 'updated_on', 'added_by', 'updated_by');
	var $product_in_store_table_name = 'product_in_store';
	
	var $stores_fields = array('stores_id' , 'name' , 'address' , 'address2' , 'address3' , 'person_contact_name', 'person_contact_email', 'person_contact_number', 'person_contact_alt_number', 'store_username', 'store_password' , 'store_password_encode'  , 'state_id', 'city_id', 'status', 'added_by', 'added_on', 'updated_on' , 'updated_by'  , 'store_contact_number' , 'defaults', 'pan_no', 'gst_no', 'pincode' , 'store_delivery_pincodes');
	var $stores_table_name = 'stores';
	
	var $stores_location_fields = array('stores_location_id' , 'stores_id' , 'state_id'  , 'city_id', 'location_id');	
	var $stores_location_table_name = 'stores_location';

	var $temp_cart_fields = array('temp_cart_id' , 'ndairy_sess_temp_id' , 'product_in_store_id'  , 'store_id', 'product_id', 'product_combination_id', 'quantity');	
	var $temp_cart_table_name = 'temp_cart';
	
	var $coupan_fields = array('coupan_id' , 'coupan_code' , 'discount' , 'status' , 'added_on', 'added_by', 'updated_on' , 'updated_by');	
	var $coupan_table_name = 'coupan';
	
	var $currency_fields = array('currency_id' , 'country_id' , 'currency_name'  , 'currency_code', 'currency_rate', 'symbol', 'added_on', 'updated_on', 'added_by' , 'updated_by'  , 'status', 'defaults');
	var $currency_table_name = 'currency';
	
	var $product_reviews_fields = array('review_id' , 'product_id' , 'customer_name'  , 'review_title', 'review', 'rating' , 'status' , 'added_on'  , 'updated_on', 'updated_by');
	var $product_reviews_table_name = 'product_reviews';
	
	var $product_questions_fields = array('question_id' , 'product_id' , 'question', 'customer_name'  , 'customer_email', 'status' , 'liked_by', 'added_on'  , 'updated_on', 'updated_by');
	var $product_questions_table_name = 'product_questions';
	
	var $product_answers_fields = array('answer_id' , 'question_id', 'product_id' , 'answer', 'customer_name'  , 'customer_email', 'status' , 'liked_by', 'added_on'  , 'updated_on', 'updated_by');
	var $product_answers_table_name = 'product_answers';
	
	var $answer_fields = array('answer_id' , 'question_id', 'product_id' , 'answer', 'customer_name'  , 'customer_email', 'status' , 'liked_by', 'added_on'  , 'updated_on', 'updated_by');
	var $answer_table_name = 'product_answers';
	
	
	var $product_use_info_value_fields = array('product_use_info_value_id' , 'product_id'  , 'product_use_info_id');	
	var $product_use_info_value_table_name = 'product_use_info_value';	
	
	var $product_tag_value_fields = array('product_tag_value_id' , 'product_id'  , 'product_tag_id');	
	var $product_tag_value_table_name = 'product_tag_value';	
	
	
	var $product_seo_fields = array('product_seo_id' , 'product_id' , 'product_combination_id'  , 'store_id', 'product_in_store_id', 'slug_url', 'meta_title', 'meta_description', 'meta_keywords' , 'others');	
	var $product_seo_table_name = 'product_seo';
	
	var $running_line_fields = array('running_line_id' , 'running_line_title' , 'position' , 'added_on', 'updated_on', 'added_by', 'updated_by' , 'status' );
	var $running_line_table_name = 'running_line';
	
	var $xxx_fields = array('xxx' , 'xxx' , 'xxx'  , 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx' , 'xxx'  , 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx' , 'xxx'  , 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx' , 'xxx'  , 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx');	
	var $xxx_table_name = 'xxx';
	
	
	function __construct()
    {
        //parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->database();
		$this->db->query("SET sql_mode = ''");	
    }
}
