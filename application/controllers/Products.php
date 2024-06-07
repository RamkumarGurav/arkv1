<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Main.php');

class Products extends Main
{
	public function __construct()
	{
		parent::__construct();
        $this->load->database();
		//$this->load->library('session');
		/*$app_is_sell_local = $this->session->userdata('application_sess_is_sell_local');
		if(empty($app_is_sell_local))
		{
			$app_is_sell_local = 2;
		}
		$this->app_is_sell_local = $this->data['app_is_sell_local'] = $app_is_sell_local;*/
		$this->load->model('Products_model');
		$this->load->model('Dashboard_model');
		$this->load->model('Common_model');
		$this->load->helper('url');
		$this->data['message']='';
		$this->data['message1']='';
		$this->session->set_userdata('application_sess_store_id',1);
		$this->data['temp_name'] = $this->session->userdata('application_sess_temp_name');
		$this->data['login_type'] = $this->session->userdata('application_sess_login_type');
		$this->data['temp_email'] = $this->session->userdata('application_sess_temp_email');
		 $this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');

		//$this->data['store_id'] = $this->session->userdata('application_sess_store_id');
		$this->data['store_id'] = 1;
		$this->data['callFor'] = '';
		if(empty($this->data['temp_id']) || empty($this->data['store_id']))
		{
			$sess_temp_id = date("dmYhis");
			if(empty($_COOKIE["application_user"]))
			{
				setcookie("application_user", $sess_temp_id, time() + (86400 * 365), "/");
				$this->session->set_userdata('application_sess_temp_id',$sess_temp_id);
			}
			else
			{
				$this->session->set_userdata('application_sess_temp_id',$_COOKIE["application_user"]);
			}


		}
		/*-- Getting current delivery location --*/
		$this->data['temp_id'] = $this->session->userdata('application_sess_temp_id');
		$this->data['store_id'] = $this->session->userdata('application_sess_store_id');
		//echo $this->data['temp_id'];
		$this->data['currency'] = parent::setCurrency(array());
		$application_post_country_id='1';
		if($application_post_country_id == __const_country_id__)
		$this->session->set_userdata('application_sess_currency_id',1);
		else
		$this->session->set_userdata('application_sess_currency_id',2);
		//echo "application_sess_currency_id : $_SESSION[application_sess_currency_id] </br>";
		$this->data['coupon_code'] = $this->session->userdata('application_sess_coupon_code');
		$this->data['coupon_discount'] = $this->session->userdata('application_sess_discount');

		$this->data['customers']='';

		$this->data['check_screen'] = $this->Common_model->checkScreen();
		$this->data['per_page_limit'] = 25000;

	}


	function all_products($main_cat = "" , $sub_cat = "" , $super_sub_cat = "" ,  $main_cat_slug='' , $sub_cat_slug='' , $super_sub_cat_slug='' , $manufacturer_id='' , $manufacturer_slug='')
	{
		$this->data['l_main_cat'] = $main_cat;
		$this->data['l_sub_cat'] = $sub_cat;
		$this->data['l_super_sub_cat'] = $super_sub_cat;
		$list_heading_title = '';
		if(!empty($manufacturer_id))
		{
			$current_manufacture = $this->Common_model->getName(array('select'=>'*' , 'from'=>'manufacturer' , 'where'=>"manufacturer_id=$manufacturer_id" ));

			if(!empty($current_manufacture))
			{
				$list_heading_title = $current_manufacture[0]->manufacturer_name;
			}
		}
		$attribute_cat = '';
		if(!empty($super_sub_cat)){$attribute_cat = $super_sub_cat;}
		else if(!empty($sub_cat)){$attribute_cat = $sub_cat;}
		else if(!empty($main_cat)){$attribute_cat = $main_cat;}

		$this->data['search_manufacturer_data'] = array();

		if(!empty($manufacturer_id))
		{
			//$manufacturer_slug_id_arr[] = $manufacturer_slug_id;
			$this->data['search_manufacturer_data'][] = $manufacturer_id;
		}

		if(!empty($_POST['manufacturer_id']))
		{
			$this->data['search_manufacturer_data'][] = $_POST['manufacturer_id'];
		}
		if(!empty($_POST['order']))
		{
			if($_POST['order']==1) { $list_heading_title = "Low to High"; }
			if($_POST['order']==2) { $list_heading_title = "High to Low"; }
			if($_POST['order']==3) { $list_heading_title = "Featured Products"; }
			if($_POST['order']==4) { $list_heading_title = "Hot Selling Now"; }
			if($_POST['order']==5) { $list_heading_title = "Best Sellers"; }
			if($_POST['order']==6) { $list_heading_title = "What's New"; }
			if($_POST['order']==7) { $list_heading_title = "High to Low"; }
			if($_POST['order']==8) { $list_heading_title = "A to Z"; }
			if($_POST['order']==9) { $list_heading_title = "Z to A"; }
		}


		$this->data['main_cat']=$main_cat;
		$this->data['sub_cat']=$sub_cat;
		$this->data['super_sub_cat']=$super_sub_cat;
		$this->data['main_cat_slug']=$main_cat_slug;
		$this->data['sub_cat_slug']=$sub_cat_slug;
		$this->data['super_sub_cat_slug']=$super_sub_cat_slug;
		$this->data['breadcrumbs']='<li><a href="'.base_url().'">Home&nbsp;</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
		$cat_search = "";
		$this->data['left_nav_category']='';
		$this->data['current_category']='';
		$this->data['active_category']='';
		$this->data['pre_url']='';
		$this->data['pre_url_product']='';
		$Qsearch=array();
		$order = '8';

		if(!empty($_POST['order']))
		{
			$order = $this->data['order']=$_POST['order'];
		}

		if(!empty($_POST['callFor']))
		{
			$this->data['callFor']=$_POST['callFor'];
		}
		else
		{
			$this->data['callFor']='loadMore';
		}

		if(!empty($_GET['search']))
		{
			$Qsearch[] = $_GET['search'];
		}



		if(!empty($super_sub_cat)){
			//$this->data['current_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , slug_url , meta_title , meta_description , meta_keyword , others , super_category_id , header_1_img , header_1_url , footer_1_img , footer_1_url , footer_2_img , footer_2_url , footer_3_img , footer_3_url , left_1_img , left_1_url , left_2_img , left_2_url , left_3_img , left_3_url , left_4_img , left_4_url , left_5_img , left_5_url , left_6_img , left_6_url, description , short_description' , 'from'=>'category' , 'where'=>"category_id=$super_sub_cat" ));

			$this->db
				->DISTINCT()
				->select('c.*')
				->from('category as c')
				->join('product_category as pcat' , 'pcat.category_id=c.category_id')
				->join('product as p' , 'pcat.product_id=p.product_id')
				->join('product_combination as pc' , 'pc.product_id=p.product_id')
				->join('product_in_store as pis' , 'pis.product_id=p.product_id')

				->where('c.category_id' , $super_sub_cat)
				->where('c.status' , 1)
				->where('p.status' , 1)
				->where('pc.status' , 1)
				->where('pis.status' , 1)
				->order_by('c.position asc');
				/*if(__is_location_wise_product__)
				{
					$this->db->where("p.is_sell_local  in (".__app_is_sell_local__.")");
				}*/
				$this->data['current_category'] = $query_get_list = $this->db->get()->result();
				if(empty($this->data['current_category']))
				{
					$this->session->set_flashdata('alert_message', '<div class=" alert alert-info">You changed the location.</div>');
					REDIRECT(base_url().'all-products');
				}

			$this->data['current_category'] = $this->data['current_category'][0];
			$this->data['main_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$main_cat" ));
			$this->data['main_category'] = $this->data['main_category'][0];
			$this->data['sub_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$sub_cat" ));
			$this->data['sub_category'] = $this->data['sub_category'][0];
			$this->data['meta_title'] = $this->data['current_category']->meta_title;
			$this->data['meta_description'] = $this->data['current_category']->meta_description;
			$this->data['meta_keywords'] = $this->data['current_category']->meta_keyword;
			$this->data['meta_others'] = $this->data['current_category']->others;

			//$this->data['pre_url']=$main_cat_slug.'/'.$sub_cat_slug.'/';
			$this->data['pre_url']=$main_cat_slug.'/';
			$this->data['pre_url_product']=$main_cat_slug.'/'.$sub_cat_slug.'/'.$super_sub_cat_slug.'/';

			$this->data['breadcrumbs'].='<li><a href="'.base_url().$main_cat_slug.'" >'.$this->data['main_category']->name.'</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
			$this->data['breadcrumbs'].='<li><a href="'.base_url().$main_cat_slug.'/'.$sub_cat_slug.'" >'.$this->data['sub_category']->name.'</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
			$this->data['breadcrumbs'].='<li>'.$this->data['current_category']->name.'</li> ';



///			$params = array("super_category_id"=>$this->data['current_category']->super_category_id);
			$params = array("super_category_id"=>$main_cat);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);

			if(!empty($this->data['left_nav_category']))
			$cat_search=$super_sub_cat;
			$this->data['active_category'] = $super_sub_cat;
		}
		else if(!empty($sub_cat)){
			//$this->data['current_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , slug_url , meta_title , meta_description , meta_keyword , others , super_category_id , header_1_img , header_1_url , footer_1_img , footer_1_url , footer_2_img , footer_2_url , footer_3_img , footer_3_url , left_1_img , left_1_url , left_2_img , left_2_url , left_3_img , left_3_url , left_4_img , left_4_url , left_5_img , left_5_url , left_6_img , left_6_url, description , short_description' , 'from'=>'category' , 'where'=>"category_id=$sub_cat" ));

			$this->db
				->DISTINCT()
				->select('c.*')
				->from('category as c')
				->join('product_category as pcat' , 'pcat.category_id=c.category_id')
				->join('product as p' , 'pcat.product_id=p.product_id')
				->join('product_combination as pc' , 'pc.product_id=p.product_id')
				->join('product_in_store as pis' , 'pis.product_id=p.product_id')

				->where('c.category_id' , $sub_cat)
				->where('c.status' , 1)
				->where('p.status' , 1)
				->where('pc.status' , 1)
				->where('pis.status' , 1)
				->order_by('c.position asc');
				/*if(__is_location_wise_product__)
				{
					$this->db->where("p.is_sell_local  in (".__app_is_sell_local__.")");
				}*/
				$this->data['current_category'] = $query_get_list = $this->db->get()->result();
				if(empty($this->data['current_category']))
				{
					$this->session->set_flashdata('alert_message', '<div class=" alert alert-info">You changed the location.</div>');
					REDIRECT(base_url().'all-products');
				}

			$this->data['current_category'] = $this->data['current_category'][0];
			$this->data['main_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$main_cat" ));
			$this->data['main_category'] = $this->data['main_category'][0];
			//$this->data['pre_url']=$main_cat_slug.'/'.$sub_cat_slug.'/';
			$this->data['pre_url']=$main_cat_slug.'/';
			$this->data['pre_url_product']=$main_cat_slug.'/'.$sub_cat_slug.'/';

			$this->data['meta_title'] = $this->data['current_category']->meta_title;
			$this->data['meta_description'] = $this->data['current_category']->meta_description;
			$this->data['meta_keywords'] = $this->data['current_category']->meta_keyword;
			$this->data['meta_others'] = $this->data['current_category']->others;

			$this->data['breadcrumbs'].='<li><a href="'.base_url().$main_cat_slug.'" >'.$this->data['main_category']->name.'</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
			$this->data['breadcrumbs'].='<li>'.$this->data['current_category']->name.'</li>';

			//$this->data['breadcrumbs'].=$this->data['main_category']->name.' / '.$this->data['current_category']->name;


//			$params = array("super_category_id"=>$sub_cat);
			$params = array("super_category_id"=>$main_cat);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
			if(!empty($this->data['left_nav_category']))
			//foreach($this->data['left_nav_category'] as $cc){$cat_search.=$cc->category_id.',';}
			$cat_search.=$sub_cat;
			$this->data['active_category'] = $sub_cat;
		}
		else if(!empty($main_cat)){
			//$this->data['current_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url, slug_url , meta_title , meta_description , meta_keyword , others , super_category_id , header_1_img , header_1_url , footer_1_img , footer_1_url , footer_2_img , footer_2_url , footer_3_img , footer_3_url , left_1_img , left_1_url , left_2_img , left_2_url , left_3_img , left_3_url , left_4_img , left_4_url , left_5_img , left_5_url , left_6_img , left_6_url , description , short_description' , 'from'=>'category' , 'where'=>"category_id=$main_cat" ));

			$this->db
				->DISTINCT()
				->select('c.*')
				->from('category as c')
				->join('product_category as pcat' , 'pcat.category_id=c.category_id')
				->join('product as p' , 'pcat.product_id=p.product_id')
				->join('product_combination as pc' , 'pc.product_id=p.product_id')
				->join('product_in_store as pis' , 'pis.product_id=p.product_id')

				->where('c.category_id' , $main_cat)
				->where('c.status' , 1)
				->where('p.status' , 1)
				->where('pc.status' , 1)
				->where('pis.status' , 1)
				->order_by('c.position asc');
				/*if(__is_location_wise_product__)
				{
					$this->db->where("p.is_sell_local  in (".__app_is_sell_local__.")");
				}*/
				$this->data['current_category'] = $query_get_list = $this->db->get()->result();
				if(empty($this->data['current_category']))
				{
					$this->session->set_flashdata('alert_message', '<div class=" alert alert-info">You changed the location.</div>');
					REDIRECT(base_url().'all-products');
				}


			$this->data['current_category'] = $this->data['current_category'][0];
			//$this->data['breadcrumbs'].='<li><a href="'.base_url().$this->data['current_category']->slug_url.'">'.$this->data['current_category']->name.'</a></li> ';
			$this->data['breadcrumbs'].='<li>'.$this->data['current_category']->name.'</li> ';
			$this->data['pre_url']=$main_cat_slug.'/';
			$this->data['pre_url_product']=$main_cat_slug.'/';

			$this->data['meta_title'] = $this->data['current_category']->meta_title;
			$this->data['meta_description'] = $this->data['current_category']->meta_description;
			$this->data['meta_keywords'] = $this->data['current_category']->meta_keyword;
			$this->data['meta_others'] = $this->data['current_category']->others;

			$params = array("super_category_id"=>$main_cat);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
			if(empty($this->data['left_nav_category']))
			{
				$this->data['refine_by'] = $this->Common_model->getName(array('select'=>'name,category_id, slug_url','from'=>'category','where'=>"category_id=10"));
				$this->data['refine_by'] = $this->data['refine_by'][0];
				$params = array("super_category_id"=>10);
				$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
			}
			if(!empty($this->data['left_nav_category']))
			foreach($this->data['left_nav_category'] as $cc){
				$cat_search.=$cc->category_id.',';

				$params = array("super_category_id"=>$cc->category_id);
				$sub_category = $this->Products_model->getCategory($params);
				if(!empty($sub_category))
				foreach($sub_category as $sc){
					$cat_search.=$sc->category_id.',';
				}
			}

			$cat_search.=$main_cat;
			$this->data['active_category'] = $main_cat;
		}
		else{
			$params = array("super_category_id"=>0);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
		}

		$searchSugg = '';
		if(!empty($_REQUEST['searchSugg']))
		{
			$searchSugg = addslashes($_REQUEST['searchSugg']);
		}
		# Left category only by goal code start
		$this->data['refine_by'] = "";
//		$this->data['refine_by'] = $this->Common_model->getName(array('select'=>'name,category_id,slug_url','from'=>'category','where'=>"category_id=10"));
//		$this->data['refine_by'] = $this->data['refine_by'][0];
		$params = array("super_category_id"=>10);
		$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
		# Left category only by goal code end

		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');
		$limit=12;
		#
		$this->data['products_list_count']=$this->Products_model->productsSearch('products_list_count','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , '' , '' , '' , '','', array("cat_search"=>$cat_search , 'manufacturer_id' => $this->data['search_manufacturer_data'], 'search'=>$searchSugg, 'order'=>1 , 'Qsearch' => $Qsearch));


		$this->data['min_final_price'] = 0;
		$this->data['max_final_price'] = 0;

		$this->data['products_count_data']=$this->Products_model->productsSearch('products_count','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , '' , '' , '' , '','', array("cat_search"=>$cat_search , 'search'=>$searchSugg , 'Qsearch' => $Qsearch));
		if(!empty($this->data['products_count_data'])){
			$this->data['products_count'] = $this->data['products_count_data'][0]['products_count'];
		}

		/*$this->data['products_min_max_price']=$this->Products_model->productsSearch('products_min_max_price','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , '' , '' , '' , '','', array("cat_search"=>$cat_search , 'search'=>$searchSugg, 'Qsearch' => $Qsearch));
		//echo "<pre>";print_r($this->data['products_min_max_price']);echo "</pre>";

		if(!empty($this->data['products_min_max_price']))
		{
			$this->data['min_final_price'] = $this->data['products_min_max_price'][0]['min_final_price'];
			$this->data['max_final_price'] = $this->data['products_min_max_price'][0]['max_final_price'];
		}*/


		$this->data['products_list_count'] = $this->data['products_list_count'][0]['counts'];
		if(!empty($_REQUEST['offset'])){$offset = $_REQUEST['offset'];}else{$offset = '';}
		$this->data['offset'] = $offset;
		//print($cat_search);

		if(!empty($_GET['order']))
			$order = $_GET['order'];
		#


		$this->data['products_list']=$this->Products_model->productsSearch('products_list','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , "" , '' , $limit , $offset  , '', array("cat_search"=>$cat_search,	'manufacturer_id' => $this->data['search_manufacturer_data'] , 'search'=>$searchSugg, 'order'=>$order, 'Qsearch' => $Qsearch));

		$this->data['products_min_max_price']=$this->Products_model->productsSearch('products_min_max_price','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , '' , '' , '' , '','', array('manufacturer_id' => $this->data['search_manufacturer_data'],"cat_search"=>$cat_search , 'search'=>$searchSugg, 'Qsearch' => $Qsearch));

		if(!empty($this->data['products_min_max_price']))
		{
			$this->data['min_final_price'] = $this->data['products_min_max_price'][0]['min_final_price'];
			$this->data['max_final_price'] = $this->data['products_min_max_price'][0]['max_final_price'];
		}

		$getManufacturer = array(
			"select" => "manufacturer_id , manufacturer_name",
			"from" => "manufacturer",
			"where" => "status=1",
			"order_by" => "manufacturer_name ASC"
		);

		//$this->data['manufacturer_data'] = $this->Products_model->getManufacturerList(array("attribute_cat"=>$attribute_cat));

		$this->data['Qsearch'] = $Qsearch;
		$this->data['order'] = $order;
		$this->data['left_nav_category']=$this->Common_model->getMenu('menu','', '', $this->data['temp_id'], $this->data['store_id'] , '' , '' , '' , '' , '' , '' , '');

		$this->data['list_heading_title'] = $list_heading_title;

		$this->data['css'] = array('product-list.css');
		$this->data['js'] = array(  );
		// $this->data['direct_js'] = array('https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js');
		$this->data['attribute'] = $this->Products_model->getAttributeList(array('manufacturer_id'=>implode(', ',$this->data['search_manufacturer_data']), 'search_given'=>1, "search"=>1 , "attribute_cat"=>$attribute_cat));
		$this->data['php'] = array();
				 		//	  echo "<pre>"; print_r($this->data['left_nav_category']); echo "</pre>"; exit;
		parent::getHeader('header' , $this->data);
		$this->load->view('product-list' , $this->data);
		parent::getFooter('footer' , $this->data);
		//print_r($this->data);
		//print_r( $this->data['left_nav_category']);
	}


	public function products_details($product_id , $combination_id='' , $main_cat = "" , $sub_cat = "" , $super_sub_cat = "" ,  $main_cat_slug='' , $sub_cat_slug='' , $super_sub_cat_slug='')
	{

		if(!isset($_SESSION["lastviewed_product_id_"]))     {
			  $_SESSION["lastviewed_product_id_"] = array();
			  $_SESSION["lastviewed_cobination_id_"] = array();
			}

			$maxelements = 10;
			if (isset($product_id) && $product_id <> "" && $combination_id <> "") {// if we have url parameter

			if (in_array($product_id, $_SESSION["lastviewed_product_id_"])) { // if product id is already in the array
				$_SESSION["lastviewed_product_id_"] = array_diff($_SESSION["lastviewed_product_id_"],array($product_id)) ; // remove it
				$_SESSION["lastviewed_product_id_"] = array_values($_SESSION["lastviewed_product_id_"]); //optionally, re-index the array
			}
			if (in_array($combination_id, $_SESSION["lastviewed_cobination_id_"])) { // if product id is already in the array
				$_SESSION["lastviewed_cobination_id_"] = array_diff($_SESSION["lastviewed_cobination_id_"],array($combination_id)) ; // remove it
				$_SESSION["lastviewed_cobination_id_"] = array_values($_SESSION["lastviewed_cobination_id_"]); //optionally, re-index the array
			}

			if (count($_SESSION["lastviewed_product_id_"]) >= $maxelements) {//check the number of array elements
			$_SESSION["lastviewed_product_id_"] = array_slice($_SESSION["lastviewed_product_id_"],1); // remove the first element if we have 5 already
			array_push($_SESSION["lastviewed_product_id_"],$product_id);//add the current itemid to the array
			} else {

			array_push($_SESSION["lastviewed_product_id_"],$product_id);//add the current itemid to the array
			}

			if (count($_SESSION["lastviewed_cobination_id_"]) >= $maxelements) {//check the number of array elements
			$_SESSION["lastviewed_cobination_id_"] = array_slice($_SESSION["lastviewed_cobination_id_"],1); // remove the first element if we have 5 already
			array_push($_SESSION["lastviewed_cobination_id_"],$combination_id);//add the current itemid to the array
			} else {

			array_push($_SESSION["lastviewed_cobination_id_"],$combination_id);//add the current itemid to the array
			}

			}


		$this->data['products_list']=$this->Products_model->productsDetails('products_list','', '', $this->data['temp_id'], $this->data['store_id'] , $product_id , '' , '' , '' , 1 , '' , $combination_id);
		if(empty($this->data['products_list']))
		{
			show_404();
			exit;
		}
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['country'] = $this->Common_model->getCountry();
		$options = array();
		$options = array('' => 'Select Country');
		if(!empty($this->data['country']))
		{
			foreach($this->data['country'] as $c)
			{
				$options[$c->country_id]  = $c->country_name.'( '.$c->country_code.' )';
			}
		}
		$this->data['options'] = $options;

		$this->data['gtm_product_category']="";

		$this->data['selected_combination_id'] = $selected_combination_id = $combination_id;
		$this->data['currency'] = parent::setCurrency(array());
		$this->data['main_cat']=$main_cat;
		$this->data['sub_cat']=$sub_cat;
		$this->data['sub_cat']=$sub_cat;
		$this->data['main_cat_slug']=$main_cat_slug;
		$this->data['sub_cat_slug']=$sub_cat_slug;
		$this->data['super_sub_cat_slug']=$super_sub_cat_slug;
		$this->data['breadcrumbs']='<li><a href="'.base_url().'">Home&nbsp;</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
		$cat_search = "";
		$this->data['left_nav_category']='';
		$this->data['current_category']='';
		$this->data['active_category']='';
		$this->data['pre_url']='';
		$this->data['pre_url_product']='';
		if(!empty($super_sub_cat)){
			$this->data['current_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , slug_url ,  super_category_id ,' , 'from'=>'category' , 'where'=>"category_id=$super_sub_cat" ));
			$this->data['current_category'] = $this->data['current_category'][0];
			$this->data['main_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$main_cat" ));
			$this->data['main_category'] = $this->data['main_category'][0];
			$this->data['sub_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$sub_cat" ));
			$this->data['sub_category'] = $this->data['sub_category'][0];

			$this->data['pre_url']=$main_cat_slug.'/'.$sub_cat_slug.'/';
			$this->data['pre_url_product']=$main_cat_slug.'/'.$sub_cat_slug.'/'.$super_sub_cat_slug.'/';

			$this->data['breadcrumbs'].='<li><a href="'.base_url().$main_cat_slug.'"a> '.$this->data['main_category']->name.'</a></li><li><span>&nbsp;&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
			$this->data['gtm_product_category'].= $this->data['main_category']->name.' -> ';
			$this->data['breadcrumbs'].='<li><a href="'.base_url().$main_cat_slug.'/'.$sub_cat_slug.'" >'.$this->data['sub_category']->name.'</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
			$this->data['gtm_product_category'].= $this->data['sub_category']->name.' -> ';
			$this->data['breadcrumbs'].='<li><a href="'.base_url().$main_cat_slug.'/'.$sub_cat_slug.'/'.$super_sub_cat_slug.'" >'.$this->data['current_category']->name.'</a></li> ';
			$this->data['gtm_product_category'].= $this->data['current_category']->name;

		}
		else if(!empty($sub_cat)){
			$this->data['current_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , slug_url ,  super_category_id ' , 'from'=>'category' , 'where'=>"category_id=$sub_cat" ));
			$this->data['current_category'] = $this->data['current_category'][0];
			$this->data['main_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$main_cat" ));
			$this->data['main_category'] = $this->data['main_category'][0];
			$this->data['pre_url']=$main_cat_slug.'/'.$sub_cat_slug.'/';
			$this->data['pre_url_product']=$main_cat_slug.'/'.$sub_cat_slug.'/';

			$this->data['breadcrumbs'].='<li><a href="'.base_url().$main_cat_slug.'" >'.$this->data['main_category']->name.'</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
			$this->data['gtm_product_category'].= $this->data['main_category']->name.' -> ';
			$this->data['breadcrumbs'].='<li><a href="'.base_url().$main_cat_slug.'/'.$sub_cat_slug.'" >'.$this->data['current_category']->name.'</a></li>';
			$this->data['gtm_product_category'].= $this->data['current_category']->name;


		}
		else if(!empty($main_cat)){
			$this->data['current_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url, slug_url ,  super_category_id' , 'from'=>'category' , 'where'=>"category_id=$main_cat" ));
			$this->data['current_category'] = $this->data['current_category'][0];
			//$this->data['breadcrumbs'].='<li><a href="'.base_url().$this->data['current_category']->slug_url.'">'.$this->data['current_category']->name.'</a></li> ';
			$this->data['breadcrumbs'].='<li><a href="'.base_url().$main_cat_slug.'" >'.$this->data['current_category']->name.'</a></li> ';
			$this->data['gtm_product_category'].= $this->data['current_category']->name;
			$this->data['pre_url']=$main_cat_slug.'/';
			$this->data['pre_url_product']=$main_cat_slug.'/';

		}
		else
		{
			$query_get_list = $this->db->query("SELECT c.name , c.slug_url , c.category_id , c.super_category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and super_category_id = 0 and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1 ");
			//echo "SELECT c.name , c.slug_url , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and super_category_id = 0 and pc.product_id = ".$product_id . " and status =1 limit 1 <br>";
			$query_data = $query_get_list->result();
			if(!empty($query_data))
			{
				$qd = $query_data[0];
				//echo "<pre>";print_r($qd );echo "</pre>";
				$this->data['breadcrumbs'].='<li><a href="'.base_url().$qd->slug_url.'" >'.$qd->name.'</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';

				$this->data['gtm_product_category'].= $qd->name;

				$query_get_list = $this->db->query("SELECT c.name , c.slug_url , c.super_category_id , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd->category_id."  and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1  ");
				//echo "SELECT c.name , c.slug_url , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd->category_id."  and pc.product_id = ".$product_id . " and status =1 limit 1 <br>";
				$query_data1 = $query_get_list->result();
				if($query_data1)
				{
					$qd1 = $query_data1[0];
					//echo "<pre>";print_r($qd1);echo "</pre>";
					$this->data['breadcrumbs'].='<li><a href="'.base_url().$qd->slug_url.'/'.$qd1->slug_url.'" >'.$qd1->name.'</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
					$this->data['gtm_product_category'].= ' -> '.$qd1->name;
					$query_get_list = $this->db->query("SELECT c.name , c.super_category_id , c.slug_url , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd1->category_id." and pc.product_id = ".$product_id . " and status =1 order by c.category_id ASC limit 1  ");
					//echo "SELECT c.name , c.slug_url , c.category_id FROM `product_category` as pc join category as c ON c.category_id = pc.category_id and c.super_category_id = ".$qd1->category_id." and pc.product_id = ".$product_id . " and status =1 limit 1 <br>";
					$query_data2 = $query_get_list->result();
					if($query_data2)
					{
						$qd2 = $query_data2[0];
						//echo "<pre>";print_r($qd2);echo "</pre>";
						$this->data['gtm_product_category'].= ' -> '.$qd2->name;
						$this->data['breadcrumbs'].='<li><a href="'.base_url().base_url().$qd->slug_url.'/'.$qd1->slug_url.'/'.$qd2->slug_url.'" >'.$qd2->name.'</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
					}
				}

			}
			else
			{
				$this->data['breadcrumbs'].='<li><a href="'.base_url().'all-products">All Products</a></li><li><span>&nbsp;<i class="fa fa-angle-right"></i></span></li> ';
				$this->data['gtm_product_category'].= 'All Products';
			}


		}




		$this->data['product_specification']=$this->Products_model->productsDetails('product_specification','', '', $this->data['temp_id'], $this->data['store_id'] , $product_id , '' , '' , '' , 1 , '' , $combination_id);
		$this->data['products_image']=$this->Products_model->productsSearch('product_image_detail',$product_id, '', $this->data['temp_id'], $this->data['store_id'] , '' , '' , '' , '' , '' , '');
		$this->data['attribute'] = $this->Products_model->getAttribute(array("product_id"=>$product_id , "combination_id"=>$combination_id , "store_id"=>$this->data['store_id']));

		$this->data['product_reviews_list'] = $this->Products_model->getList('product_reviews_list', $product_id, "10", "");
		$this->data['product_seo_list'] = $this->Products_model->getList('product_seo_list', $product_id, $combination_id, "");
		//print_r($this->data['product_seo_list']);
		if(!empty($this->data['product_seo_list']))
		{
			$product_seo_data = $this->data['product_seo_list'][0];
			$this->data['meta_title'] = $product_seo_data->meta_title;
			$this->data['meta_description'] = $product_seo_data->meta_description;
			$this->data['meta_keywords'] = $product_seo_data->meta_keywords;
			$this->data['meta_others'] = $product_seo_data->others;
		}

		$this->data['country'] = $this->Common_model->getCountry();

		//$this->data['direct_js'] = array('https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js');
		//$this->data['php'] = array('script/product-details' );// ,'add-script/star-script'
		//echo "</pre>";print_r($this->data);echo "<pre>";
		$banners_condition = "b.status=1";
		$this->data['banners'] = $this->Common_Model->getData(array('select'=>'b.* ' , 'from'=>'banner as b' , 'where'=>$banners_condition , 'order_by'=>'position ASC' ));

		$this->data['index_category'] = $this->Products_model->getIndexCategory(array('select'=>'category_id , position , name , slug_url ' , 'from'=>'category' , 'where'=>"(category_id =1 and status=1)" ));

		$this->data['direct_css'] = array( 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css' );//, 'js/all-scripts.js'
		 $this->data['direct_js'] = array( 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js');//'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
		 $this->data['js'] = array( 'js/home.js'  );

		$this->data['php'] = array('script/topcategories' , 'script/whatsnew', 'script/product-details' );
	$this->data['css'] = array('product-list.css','product-detail.css','review.css');
		parent::getHeader('header' , $this->data);
		$this->load->view('product-detail' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	function loadProductIndex($main_cat = "" , $sub_cat = "" , $super_sub_cat = "")
	{
		$this->data['main_cat']=$main_cat;
		$this->data['sub_cat']=$sub_cat;
		$new_product = '';
		$best_sellers = '';
		$hot_selling_now = '';
		$trending_now = '';
		$recent_viewed_products = '';
		$is_related = '';
		$product_id = '';
		$product_combination_id = '';
		$cat_search = '';
		$searchSugg = '';
		$in_stock = '';
		$this->data['search_manufacturer_data'] = array();
		if(!empty($_POST['searchSugg']))
		{
			$searchSugg = addslashes($_POST['searchSugg']);
		}

		if(!empty($_POST['in_stock']))
			$in_stock = $_POST['in_stock'];
		if(!empty($_POST['new_product']))
			$new_product = $_POST['new_product'];
		if(!empty($_POST['best_sellers']))
			$best_sellers = $_POST['best_sellers'];
		if(!empty($_POST['hot_selling_now']))
			$hot_selling_now = $_POST['hot_selling_now'];
		if(!empty($_POST['trending_now']))
			$trending_now = $_POST['trending_now'];
		if(!empty($_POST['recent_viewed_products']))
			$recent_viewed_products = $_POST['recent_viewed_products'];
		if(!empty($_POST['is_related']))
			$is_related = $_POST['is_related'];
		if(!empty($_POST['product_id']))
			$product_id = $_POST['product_id'];
		if(!empty($_POST['product_combination_id']))
			$product_combination_id = $_POST['product_combination_id'];

		if(!empty($_POST['manufacturer_id']))
		{
			$this->data['search_manufacturer_data'] = $_POST['manufacturer_id'];
		}

		$this->data['min_price'] = $min_price = 0;
		$this->data['max_price'] = $max_price = 0;
		if(!empty($_POST['min_price'])){ $min_price = $this->data['min_price'] = $_POST['min_price'];}
		if(!empty($_POST['max_price'])){ $max_price = $this->data['max_price'] = $_POST['max_price'];}

		$search_category = array();
		if(!empty($_POST['main_cat_search'])){ $main_cat_search = $_POST['main_cat_search']; $search_category[] = $main_cat_search; }
		if(!empty($_POST['sub_cat_search'])){ $sub_cat_search = $_POST['sub_cat_search']; $search_category[] = $sub_cat_search; }
		if(!empty($_POST['super_sub_cat_search'])){ $super_sub_cat_search = $_POST['super_sub_cat_search']; $search_category[] = $super_sub_cat_search; }


		$Qsearch=array();
		$QsearchVal=array();

		$this->data['attribute'] = $this->Products_model->getAttribute(array('search_given'=>1, "search"=>1 , "attribute_cat"=>implode(',' , $search_category) , 'manufacturer_id'=>implode(', ',$this->data['search_manufacturer_data'])  , "min_price" => $min_price,	"max_price" => $max_price,	"in_stock" => $in_stock));
		foreach($this->data['attribute'] as $a)
		{
			if(!empty($_POST["search".$a->product_attribute_id]))
			{

				foreach($_POST["search".$a->product_attribute_id] as $q)
				{
					$q_val = json_decode($q);
					$Qsearch[] = array('product_attribute_value_id'=>$q_val->product_attribute_value_id , 'combination_value'=>$q_val->combination_value);
					$QsearchVal[] = $q_val->combination_value;
				}
			}

		}

		if(!empty($Qsearch))
		{
			//$Qsearch = implode(",",$Qsearch);
		}

		if(!empty($is_related) && !empty($product_id))
		{
			$this->data['category'] = $this->Common_model->getName(array('select'=>'category_id' , 'from'=>'product_category' , 'where'=>"product_id = $product_id" ));
			$temp = array();
			foreach($this->data['category'] as $cc)
			$temp[]= $cc->category_id;
			$cat_search = implode(',' , $temp);
			//print($cat_search);
		}

		$this->data['callFor'] = '';
		if(!empty($_POST['callFor']))
			$this->data['callFor'] = $_POST['callFor'];
		$this->data['breadcrumbs']='Products / ';

		$this->data['left_nav_category']='';
		$this->data['current_category']='';
		$this->data['active_category']='';
		$this->data['pre_url']='';
		if(!empty($super_sub_cat)){
			$this->data['current_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$super_sub_cat" ));
			$this->data['current_category'] = $this->data['current_category'][0];
			$this->data['main_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$main_cat" ));
			$this->data['main_category'] = $this->data['main_category'][0];
			$this->data['sub_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$sub_cat" ));
			$this->data['sub_category'] = $this->data['sub_category'][0];
			$this->data['breadcrumbs'].=$this->data['main_category']->name.' / '.$this->data['sub_category']->name.' / '.$this->data['current_category']->name;

			$this->data['pre_url']=$main_cat.'/'.$this->data['current_category']->super_category_id.'/';

			$params = array("super_category_id"=>$this->data['current_category']->super_category_id);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
			if(!empty($this->data['left_nav_category']))
			$cat_search=$super_sub_cat;
			$this->data['active_category'] = $super_sub_cat;
		}
		else if(!empty($sub_cat)){
			$this->data['current_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$sub_cat" ));
			$this->data['current_category'] = $this->data['current_category'][0];
			$this->data['main_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$main_cat" ));
			$this->data['main_category'] = $this->data['main_category'][0];
			$this->data['breadcrumbs'].=$this->data['main_category']->name.' / '.$this->data['current_category']->name;
			$this->data['pre_url']=$main_cat.'/'.$this->data['current_category']->category_id.'/';

			$params = array("super_category_id"=>$sub_cat);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
			$temp = array();
			if(!empty($this->data['left_nav_category']))
			foreach($this->data['left_nav_category'] as $cc){$cat_search.=$cc->category_id.',';}
			$temp[]=$sub_cat;
			$cat_search = implode(',' , $temp);
			$this->data['active_category'] = $sub_cat;
		}
		else if(!empty($main_cat)){
			$this->data['current_category'] = $this->Common_model->getName(array('select'=>'name , category_id , url , super_category_id' , 'from'=>'category' , 'where'=>"category_id=$main_cat" ));
			$this->data['current_category'] = $this->data['current_category'][0];
			$this->data['breadcrumbs'].=$this->data['current_category']->name;
			$this->data['pre_url']=$main_cat.'/';
			$params = array("super_category_id"=>$main_cat);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
			if(!empty($this->data['left_nav_category']))
			foreach($this->data['left_nav_category'] as $cc){
				$cat_search.=$cc->category_id.',';

				$params = array("super_category_id"=>$cc->category_id);
				$sub_category = $this->Products_model->getCategory($params);
				if(!empty($sub_category))
				foreach($sub_category as $sc){
					$cat_search.=$sc->category_id.',';
				}
			}

			$cat_search.=$main_cat;
			$this->data['active_category'] = $main_cat;
		}
		else{
			$params = array("super_category_id"=>0);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
		}
		$data = array();
		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');
		$limit=12;
		$search = array(
			'Qsearch' => $Qsearch
		);
		$order = '8';
		if(!empty($_POST['order']))
			$order = $_POST['order'];

		$search = array(
			'Qsearch' => $Qsearch,
			"cat_search" => $cat_search,
			"order" => $order,
			"new_product" => $new_product,
			"best_sellers" => $best_sellers,
			"hot_selling_now" => $hot_selling_now,
			"trending_now" => $trending_now,
			"is_related" => $is_related,
			"product_id" => $product_id,
			"product_combination_id" => $product_combination_id,
			"search" => $searchSugg,
			"min_price" => $min_price,
			"max_price" => $max_price,
			"in_stock" => $in_stock,
			'manufacturer_id' => $this->data['search_manufacturer_data']
		);

		$this->data['products_list_count']=$this->Products_model->productsSearch('products_list_count','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , '' , '' , '' , '' , '', $search);
		$this->data['products_list_count'] = $this->data['products_list_count'][0]['counts'];
		if(!empty($_POST['offset'])){$offset = $_POST['offset'];}else{$offset = '';}

		$this->data['display_qty'] = 0;
		if(!empty($offset)){$offset = $offset*$limit;

			$this->data['display_qty'] = $offset;
		}
		//$this->data['products_list']=$this->Products_model->productsSearch('products_list','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , "" , '' , $limit , $offset  , '', array("cat_search"=>$cat_search , 'Qsearch' => $Qsearch,"cat_search" => $cat_search,"order" => $order));
		if(isset($_SESSION['lastviewed_product_id_']) &&  !empty($_SESSION['lastviewed_product_id_']) && !empty($recent_viewed_products)){
			$lastviewed_product_id__ids = '';

			foreach ($_SESSION['lastviewed_product_id_'] as $lastviewed_product_id_ ) {
				$lastviewed_product_id__ids .= $lastviewed_product_id_.',';
			}
				$lastviewed_product_id__ids = rtrim($lastviewed_product_id__ids, ',');
			//	$lastviewed_product_id__ids = $_SESSION['lastviewed_product_id_'];
		}else{
			$lastviewed_product_id__ids = '';
		}

		if(isset($_SESSION['lastviewed_cobination_id_']) &&  !empty($_SESSION['lastviewed_cobination_id_']) && !empty($recent_viewed_products)){
			$lastviewed_cobination_id___ids = '';

			foreach ($_SESSION['lastviewed_cobination_id_'] as $lastviewed_cobination_id_ ) {
				$lastviewed_cobination_id___ids .= $lastviewed_cobination_id_.',';
			}
				$lastviewed_cobination_id___ids = rtrim($lastviewed_cobination_id___ids, ',');
			//	$lastviewed_product_id__ids = $_SESSION['lastviewed_product_id_'];
		}else{
			$lastviewed_cobination_id___ids = '';
		}

		$this->data['products_list']=$this->Products_model->productsSearch('products_list','', '', $application_sess_temp_id, $application_sess_store_id ,$lastviewed_product_id__ids ,$lastviewed_cobination_id___ids , "" , '' , $limit , $offset  , '', $search);

		if(empty($this->data['products_list']))
		{
			echo "NoMoreProducts";
			exit;
		}

		if(!empty($_POST['classOffset'])){$offset = $_POST['classOffset'];}
		$this->data['offset'] = $offset;
		$this->load->view('template/product-list',$this->data);

	}

	function loadMoreProduct($main_cat = "" , $sub_cat = "" , $super_sub_cat = "")
	{
		$this->loadProductIndex($main_cat  , $sub_cat , $super_sub_cat );
	}


	function all_products_search($main_cat = "", $sub_cat = "", $super_sub_cat = "")
	{
		$main_cat_search='';
		$sub_cat_search='';
		$super_sub_cat_search='';
		$search_category = array();
		if(!empty($_POST['main_cat_search'])){ $main_cat_search = $_POST['main_cat_search']; $search_category[] = $main_cat_search; }
		if(!empty($_POST['sub_cat_search'])){ $sub_cat_search = $_POST['sub_cat_search']; $search_category[] = $sub_cat_search; }
		if(!empty($_POST['super_sub_cat_search'])){ $super_sub_cat_search = $_POST['super_sub_cat_search']; $search_category[] = $super_sub_cat_search; }

		$in_stock=0;
		$this->data['min_price'] = $min_price = 0;
		$this->data['max_price'] = $max_price = 0;
		$this->data['search_author_data'] = array();
		$this->data['search_manufacturer_data'] = array();

		$this->data['p_search_by'] = $p_search_by = '';
		if(!empty($_POST['p_search_by']))
		{
			$this->data['p_search_by'] = $p_search_by = $_POST['p_search_by'];
		}

		$searchSugg = '';
		if(!empty($_POST['searchSugg']))
		{
			$searchSugg = addslashes($_POST['searchSugg']);
		}

		if(!empty($_POST['min_price'])){ $min_price = $this->data['min_price'] = $_POST['min_price'];}
		if(!empty($_POST['max_price'])){ $max_price = $this->data['max_price'] = $_POST['max_price'];}
		if(!empty($_POST['in_stock'])){ $in_stock = $this->data['in_stock'] = $_POST['in_stock'];}

		if(!empty($_POST['callFor'])){ $this->data['callFor']=$_POST['callFor'];}
		else{ $this->data['callFor']='loadMore'; }

		if(!empty($_POST['manufacturer_id']))
		{
			$this->data['search_manufacturer_data'] = $_POST['manufacturer_id'];
		}


		$this->data['Qsearch'] = $Qsearch=array();
		$this->data['f_attr_val'] = $f_attr_val=array();
		$this->data['QsearchVal'] = $QsearchVal=array();
		//$this->data['attribute'] = $this->Products_model->getAttribute();
		$this->data['attribute'] = $this->Products_model->getAttributeList(array('search_given'=>1, "search"=>1 , "attribute_cat"=>implode(',' , $search_category) , 'manufacturer_id'=>implode(', ',$this->data['search_manufacturer_data'])  , "min_price" => $min_price,	"max_price" => $max_price));
		if(!empty($this->data['attribute']))
		foreach($this->data['attribute'] as $a)
		{
			if(!empty($_POST["search".$a->product_attribute_id]))
			{

				foreach($_POST["search".$a->product_attribute_id] as $q)
				{
					$q_val = json_decode($q);
					$this->data['Qsearch'] = $Qsearch[] = array('product_attribute_value_id'=>$q_val->product_attribute_value_id , 'combination_value'=>$q_val->combination_value);
					$this->data['f_attr_val'][] = $f_attr_val[] = $q_val->product_attribute_value_id;
					$this->data['QsearchVal'][] = $QsearchVal[] = $q_val->combination_value;
				}
			}

		}


		//print_r($this->data['f_attr_val']);
		if(!empty($Qsearch))
		{
			//$Qsearch = implode(",",$Qsearch);
		}
		$this->data['main_cat']=$main_cat;
		$this->data['sub_cat']=$sub_cat;
		//$this->data['attribute'] = $this->Products_model->getAttribute();

		$this->data['breadcrumbs'] = "<a href='".base_url()."all-products'>Products </a>/ ";
		$cat_search = "";
		$this->data['left_nav_category'] = '';
		$this->data['current_category'] = '';
		$this->data['active_category'] = '';
		$this->data['pre_url'] = '';
		if (!empty($super_sub_cat)) {
			$this->data['current_category'] = $this->Common_model->getName(array('select' => 'name , category_id , url , slug_url , meta_title , meta_description , meta_keyword , others , super_category_id', 'from' => 'category', 'where' => "category_id=$super_sub_cat"));
			$this->data['current_category'] = $this->data['current_category'][0];

			$this->data['main_category'] = $this->Common_model->getName(array('select' => 'name , category_id , url, slug_url , super_category_id', 'from' => 'category', 'where' => "category_id=$main_cat"));
			$this->data['main_category'] = $this->data['main_category'][0];

			$this->data['sub_category'] = $this->Common_model->getName(array('select' => 'name , category_id , url, slug_url , super_category_id', 'from' => 'category', 'where' => "category_id=$sub_cat"));
			$this->data['sub_category'] = $this->data['sub_category'][0];

			$this->data['breadcrumbs'] .= $this->data['main_category']->name . ' / ' . $this->data['sub_category']->name . ' / ' . $this->data['current_category']->name;

			$this->data['pre_url'] = $main_cat . '/' . $this->data['current_category']->slug_url . '/';

			$params = array("super_category_id" => $this->data['current_category']->super_category_id);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
			if (!empty($this->data['left_nav_category']))
				$cat_search = $super_sub_cat;
			$this->data['active_category'] = $super_sub_cat;
		} else
		if (!empty($sub_cat)) {
			$this->data['current_category'] = $this->Common_model->getName(array('select' => 'name , category_id , url , super_category_id , url ', 'from' => 'category', 'where' => "category_id=$sub_cat"));
			$this->data['current_category'] = $this->data['current_category'][0];
//			$this->data['meta_title'] = $this->data['current_category']->meta_title;
//			$this->data['meta_description'] = $this->data['current_category']->meta_description;
//			$this->data['meta_keyword'] = $this->data['current_category']->meta_keyword;
//			$this->data['category_description'] = $this->data['current_category']->description;
			$this->data['main_category'] = $this->Common_model->getName(array('select' => 'name , category_id , url , super_category_id , url', 'from' => 'category', 'where' => "category_id=$main_cat"));
			$this->data['main_category'] = $this->data['main_category'][0];
//			$this->data['breadcrumbs'] .= "<a href='".base_url().$this->data['main_category']->slug_url."'>".$this->data['main_category']->name . "</a> / " . $this->data['current_category']->name;
//			$this->data['pre_url'] = $this->data['main_category']->slug_url . '/' . $this->data['current_category']->slug_url . '/';

			$params = array("super_category_id" => $sub_cat);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
			if (!empty($this->data['left_nav_category']))
				foreach ($this->data['left_nav_category'] as $cc) {
				$cat_search .= $cc->category_id . ',';
			}
			$cat_search .= $sub_cat;
			$this->data['active_category'] = $sub_cat;
		} else if (!empty($main_cat)) {
			$this->data['current_category'] = $this->Common_model->getName(array('select' => 'name , category_id , url , super_category_id , url', 'from' => 'category', 'where' => "category_id=$main_cat"));
			$this->data['current_category'] = $this->data['current_category'][0];
//			$this->data['meta_title'] = $this->data['current_category']->meta_title;
//			$this->data['meta_description'] = $this->data['current_category']->meta_description;
//			$this->data['meta_keyword'] = $this->data['current_category']->meta_keyword;
//			$this->data['category_description'] = $this->data['current_category']->description;
//			$this->data['breadcrumbs'] .= "<a href='".base_url().$this->data['current_category']->slug_url."'>".$this->data['current_category']->name."</a>";
//			$this->data['pre_url'] = $this->data['current_category']->slug_url . '/';
			$params = array("super_category_id" => $main_cat);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
			if (!empty($this->data['left_nav_category']))
				foreach ($this->data['left_nav_category'] as $cc) {
				$cat_search .= $cc->category_id . ',';

				$params = array("super_category_id" => $cc->category_id);
				$sub_category = $this->Products_model->getCategory($params);
				if(!empty($sub_category))
				foreach ($sub_category as $sc) {
					$cat_search .= $sc->category_id . ',';
				}
			}

			$cat_search .= $main_cat;
			$this->data['active_category'] = $main_cat;
		} else {
			$params = array("super_category_id" => 0);
			$this->data['left_nav_category'] = $this->Products_model->getCategory($params);
		}

		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');
		$limit = 12;

		$search = array(
			"cat_search"=>$cat_search ,
			'manufacturer_id' => $this->data['search_manufacturer_data'],
			'search' => $searchSugg,
			"min_price" => $min_price,
			"in_stock" => $in_stock,
			"max_price" => $max_price,
			//"cat_search" => implode(',' , $search_category),
			'Qsearch' => $Qsearch

		);
		$this->data['products_list_count'] = $this->Products_model->productsSearch('products_list_count', '', '', $application_sess_temp_id, $application_sess_store_id, '', '', '', '', '', '' , '' , $search);
		//echo "<pre>";print_r($this->data['products_list_count']);echo "</pre>";
		$this->data['products_list_count'] = $this->data['products_list_count'][0]['counts'];
		if (!empty($_REQUEST['offset'])) {
			$offset = $_REQUEST['offset'];
		} else {
			$offset = '';
		}
		$order = '';
		if(!empty($_POST['order']))
			$order = $_POST['order'];
		$search = array(
			"cat_search"=>$cat_search ,
			"in_stock" => $in_stock,
			'Qsearch' => $Qsearch,
			'manufacturer_id' => $this->data['search_manufacturer_data'],
			'search' => $searchSugg,
			"min_price" => $min_price,
			"max_price" => $max_price,
			"cat_search" => implode(',' , $search_category),
			"order" => $order
		);

		$this->data['offset'] = $offset;
		$this->data['products_list'] = $this->Products_model->productsSearch('products_list', '', '', $application_sess_temp_id, $application_sess_store_id, '', '', "", '', $limit, $offset, '', $search);

		$this->data['products_min_max_price']=$this->Products_model->productsSearch('products_min_max_price','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , '' , '' , '' , '','', $search);


		//$this->data['manufacturer_data'] = $this->Products_model->getManufacturerList(array("attribute_cat"=>$attribute_cat));

		$this->data['manufacturer_data'] = $this->Products_model->getManufacturerList_f_cl('','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , '' , '' , '' , '','', $search);

		//$this->data['attribute'] = $this->Products_model->getAttributeList(array('search_given'=>1, "search"=>1 , "attribute_cat"=>$attribute_cat));
		$AttributeList_params = $search;
		$AttributeList_params['search_given'] = 1;
		$AttributeList_params['search'] = 1;
		$AttributeList_params['attribute_cat'] = implode(',' , $search_category);
		//print_r($AttributeList_params);

		//$this->data['attribute'] = $this->Products_model->getAttributeList_f_cl($AttributeList_params);

		$this->data['attribute'] = $this->Products_model->getAttributeList(array('search_given'=>1,"in_stock" => $in_stock, "search"=>1,"min_price" => $min_price,	"max_price" => $max_price,  "attribute_cat"=>implode(',' , $search_category)));
		//, 'manufacturer_id'=>implode(', ',$this->data['search_manufacturer_data'])
		if(!empty($this->data['attribute']))
		foreach($this->data['attribute'] as $a)
		{
			if(!empty($_POST["search".$a->product_attribute_id]))
			{

				foreach($_POST["search".$a->product_attribute_id] as $q)
				{
					$q_val = json_decode($q);
					$this->data['Qsearch'] = $Qsearch[] = array('product_attribute_value_id'=>$q_val->product_attribute_value_id , 'combination_value'=>$q_val->combination_value);
					$this->data['f_attr_val'][] = $f_attr_val[] = $q_val->product_attribute_value_id;
					$this->data['QsearchVal'][] = $QsearchVal[] = $q_val->combination_value;
				}
			}

		}


		$this->load->view('template/product-list', $this->data);

		$this->load->view('template/product-list-search', $this->data);



		//print_r($this->data);
	}

	public function myCart()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');

		if(isset($_POST['CouponBTN']))
		{
			$coupon_code = $_POST['coupon'];
			$couponData = $this->Common_model->getName(array('select'=>'*' , 'from'=>"coupon" , 'where'=>"(name='$coupon_code' and status = 1)"));

			if(!empty($couponData))
			{
				if(count($couponData)>0)
				{
					$couponData = $couponData[0];
					//echo "<pre>";print_r($couponData);exit;
					//min_cart_value message
					$this->session->set_userdata('application_sess_coupon_code',$couponData->name);
					$this->session->set_userdata('application_sess_discount',$couponData->discount_value);
					$this->session->set_userdata('application_sess_discount_in',$couponData->discount_in);
					$this->session->set_userdata('application_sess_discount_on_cart_value',$couponData->min_cart_value);
					$this->session->set_userdata('application_sess_discount_cart_value_message',$couponData->message);
					$discount_variable = "%";
					if($couponData->discount_in==1)
					{
						$discount_variable = '<i class="fa fa-inr"></i>';
					}
					$this->session->set_userdata('application_sess_discount_variable',$discount_variable);

					$this->session->set_flashdata('message', '<div class=" alert alert-success">Coupon is successfully applied.</div>');
					//REDIRECT(base_url().__cart__);
					REDIRECT($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('message', '<div class=" alert alert-danger">This is invalid coupon code.</div>');
					//REDIRECT(base_url().__cart__);
					REDIRECT($_SERVER['HTTP_REFERER']);
				}

			}
			else
			{
				$this->session->set_flashdata('message', '<div class=" alert alert-danger">This is invalid coupon code.</div>');
				//REDIRECT(base_url().__cart__);
				REDIRECT($_SERVER['HTTP_REFERER']);
			}
		}

		if(isset($_POST['customerOrderNoteBTN']))
		{
			$customer_order_note = $_POST['customer_order_note'];

			if(!empty($customer_order_note))
			{
				$this->session->set_userdata('application_sess_customer_order_note',$customer_order_note);
				$this->session->set_flashdata('message', '<div class=" alert alert-success">Your Note saved.</div>');
				REDIRECT(base_url().__cart__);
			}
			else
			{
				$this->session->set_userdata('application_sess_customer_order_note','');
				$this->session->set_flashdata('message', '<div class=" alert alert-success">Your note is removed.</div>');
				REDIRECT(base_url().__cart__);
			}
		}

		if(isset($_POST['cartCommentBtn']))
		{
			$comment = $_POST['comment'];
			$product_in_store_id = $_POST['product_in_store_id'];
			$product_id = $_POST['product_id'];
			$product_combination_id = $_POST['product_combination_id'];

			$condition = "application_sess_temp_id = $application_sess_temp_id and product_in_store_id = $product_in_store_id and product_combination_id = $product_combination_id";
			$this->Common_model->update_operation(array("table"=>"temp_cart" , "data"=>array("comment"=>$comment ), "condition"=>$condition));


			$this->session->set_flashdata('message', '<div class=" alert alert-success">Comment Update Successfully.</div>');
					REDIRECT(base_url().__cart__);
		}


		$distinct_product_id_in_cart = $this->Products_model->temp_cart('distinct_product_id_in_cart','','' , '' , '', '', $application_sess_temp_id, $application_sess_store_id);
		if(count($distinct_product_id_in_cart)>0){
			$product_ids = '';
			$product_combination_ids = '';
			foreach($distinct_product_id_in_cart as $col){$product_ids.=$col['product_id'].',';$product_combination_ids.=$col['product_combination_id'].',';}
			$product_ids = trim($product_ids , ',');$product_combination_ids = trim($product_combination_ids , ',');
			$this->data['products_list']=$this->Products_model->productsSearch('products_list_group','', '', $application_sess_temp_id, $application_sess_store_id, $product_ids, $product_combination_ids);
			//print_r($products_list);
		}
		$this->data['is_cart_btn'] = '1';
		$this->data['cart_css'] = array('cart.css' );
		$this->data['php'] = array('script/cart' );
		$this->data['direct_js'] = array('https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js');
		$this->data['js'] = array(  );
		$this->data['isDisplayCart'] = 'no';

		$msg = $this->session->flashdata('message');
		if(!empty($msg))
		$this->data['message'] = $this->session->flashdata('message');
		//$this->data['cart_css'] = array('cart.css' );
		parent::getHeader('header' , $this->data);
		$this->load->view('cart' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	function cartTask()
	{
		if(!empty($_POST['qty'])){$qty = $_POST['qty'];}else{$qty = 1;}
		if(!empty($_POST['pis_id'])){$pis_id = $_POST['pis_id'];}else{$pis_id = '';}
		if(!empty($_POST['p_id'])){$p_id = $_POST['p_id'];}else{$p_id = '';}
		if(!empty($_POST['pc_id'])){$pc_id = $_POST['pc_id'];}else{$pc_id = '';}
		if(!empty($_POST['task'])){$task = $_POST['task'];} else{$task = '';}// 1= remove from cart , 2= add in cart
		$this->data['application_sess_temp_id'] = $application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$this->data['application_sess_store_id'] = $application_sess_store_id = $this->session->userdata('application_sess_store_id');
		$gtm_action = '';
		$gtm_updated_qty = '';

		$dataaddcart['application_sess_temp_id'] = $application_sess_temp_id;
		$this->data['pis_id'] = $dataaddcart['product_in_store_id'] = $pis_id;
		$dataaddcart['store_id'] = $application_sess_store_id;
		$this->data['p_id'] = $dataaddcart['product_id'] = $p_id;
		$this->data['pc_id'] = $dataaddcart['product_combination_id'] = $pc_id;
		$dataaddcart['quantity'] = $qty;
		$dataaddcart['updated_on'] = date('Y-m-d H:i:s');

		$redirect = '';
		$message_alert_type = '';

		$in_cart = false;
		$in_cart_qty = 0;
		$temp_cart_id = '';
		$if_products_list=$this->Products_model->temp_cart('search_product_in_cart','','' , $pis_id , $p_id, $pc_id, $application_sess_temp_id, $application_sess_store_id);
		if(count($if_products_list)>0)
		{
			$in_cart = true;
			foreach($if_products_list as $col){
				$in_cart_qty = $col['quantity'];
				$temp_cart_id = $col['temp_cart_id'];
			}
		}

		$this->data['products_list'] = $products_list=$this->Products_model->productsSearch('products_list_group','', '', $application_sess_temp_id, $application_sess_store_id, $p_id, $pc_id);

		foreach($products_list as $col){
		$product_name = $col['name'];
		$product_id = $col['product_id'];
		if(empty($col['manufacturer_name'])){ $col['manufacturer_name'] = ''; }
		$manufacturer_name = $col['manufacturer_name'];
		//Default combination details
		$product_display_name = $col['product_combination'][0]['product_display_name'];
		if (!empty($product_display_name)) {
			$product_name = $product_display_name;
		} else {
			$product_name = $product_name;
		}
		$discount = $col['product_combination'][0]['discount'].' '.$col['product_combination'][0]['discount_var'];$discount = trim($discount);
		$price = $col['product_combination'][0]['price'];
		$final_price = $col['product_combination'][0]['final_price'];
		$product_image_name = $col['product_combination'][0]['product_image_name'];
		$combi = $col['product_combination'][0]['combi'];
		$product_in_store_id = $col['product_combination'][0]['product_in_store_id'];
		$product_combination_id = $col['product_combination'][0]['product_combination_id'];
		$prod_in_cart = $col['product_combination'][0]['prod_in_cart'];
		$in_store_quantity = $col['product_combination'][0]['quantity'];
		$stock_out_msg = $col['product_combination'][0]['stock_out_msg'];
		$quantity_per_order = $col['product_combination'][0]['quantity_per_order'];

		}
		$max_qty = 0;
		if($quantity_per_order<=$in_store_quantity)
			$max_qty = $quantity_per_order;
		else
			$max_qty = $in_store_quantity;
		$product_complete_name = $manufacturer_name.' '.$product_name.' -: '.$combi;

		//echo $task.'<br>';
		if($task==1)
		{//remove
			$dataaddcart['quantity']=$in_cart_qty;
//			$dataaddcart['quantity']=$dataaddcart['quantity']-1;
				if($in_cart_qty==$qty)
				{
					$qty-=1;
				}
			$dataaddcart['quantity']=$qty;
			$gtm_updated_qty = $qty;
			//echo $dataaddcart['quantity'];
			if($dataaddcart['quantity']<=0){
				$insertStatus = $this->Products_model->deleteRows('temp_cart_delete' , $temp_cart_id);$msg="$product_complete_name is Remove from Cart";
			}
			else{
				$condition="(temp_cart_id = '$temp_cart_id')";
				$insertStatus = $this->Products_model->update($dataaddcart,'temp_cart',$temp_cart_id , $condition);$msg="$product_complete_name, $dataaddcart[quantity] in Basket";
			}
			$gtm_action = 'remove';
		}
		if($task==2)
		{//add/increase
		$gtm_action = 'remove';
			$gtm_updated_qty = $qty;
			if($in_cart){
				//$dataaddcart['quantity']=$in_cart_qty;
//				$dataaddcart['quantity']+=1;
				if($in_cart_qty==$qty)
				{
					$qty+=1;
				}
				//echo "$in_cart_qty : $qty";

				$dataaddcart['quantity']=$qty;
				$condition="(temp_cart_id = '$temp_cart_id')";
				if($max_qty>=$dataaddcart['quantity']){
					$insertStatus = $this->Products_model->update($dataaddcart,'temp_cart',$temp_cart_id , $condition); $msg="$product_complete_name, $dataaddcart[quantity] in Basket";
					$gtm_action = 'add';
				}
				else{
					$insertStatus = 'max reached'; $msg="Max Quantity Reached of $product_complete_name";$dataaddcart['quantity']-=1;
					$message_alert_type = 'danger';
				}
			}
			else{
				//$dataaddcart['quantity']+=1;
				if($max_qty>=$dataaddcart['quantity']){
					$insertStatus = $this->Products_model->add($dataaddcart,'temp_cart');$msg="$product_complete_name, $dataaddcart[quantity] in Basket";
					$gtm_action = 'add';
				}
				else{
					$insertStatus = 'max reached';$msg="Max Quantity Reached of $product_complete_name ";
					$message_alert_type = 'danger';
				}
			}
		}
		if($task==3)
		{//delete
			$dataaddcart['quantity']=0;
			$insertStatus = $this->Products_model->deleteRows('temp_cart_delete' , $temp_cart_id);$msg="$product_complete_name is Delete from Cart";
			$gtm_action = 'remove';
		}

		if($task==8)
		{//Buy Now empty the cart and insert product in cart
			$insertStatus = $this->Products_model->deleteRows('temp_cart_empty' , $application_sess_temp_id);$msg="";
			$dataaddcart['quantity']=1;
			$insertStatus = $this->Products_model->add($dataaddcart,'temp_cart');$msg="$product_complete_name, $dataaddcart[quantity] in Basket";
			$redirect = base_url().__payment__;
		}

		$this->data['gtm_action'] = $gtm_action;
		$this->data['gtm_updated_qty'] = $gtm_updated_qty;

		$getCartItemCount = $this->Common_model->getCartItemCount();
		if(_switch_google_ecom_ ==1)
		{
			$gtm_cart_script = $this->load->view('templates/gtm_cart_script' , $this->data , true);
		}
		else
		{
			$gtm_cart_script='';
		}

		if($insertStatus>0)
		{
			echo json_encode(array("msg"=>$msg,"cart_qty"=>$dataaddcart['quantity'],"status"=>true,"task"=>$task , "getCartItemCount"=>$getCartItemCount, "redirect"=>$redirect, "message_alert_type"=>$message_alert_type, "script"=>$gtm_cart_script));
		}
		else if($insertStatus=='max reached')
		{
			echo json_encode(array("msg"=>$msg,"cart_qty"=>$dataaddcart['quantity'],"status"=>true,"task"=>$task, "getCartItemCount"=>$getCartItemCount, "redirect"=>$redirect, "message_alert_type"=>$message_alert_type, "script"=>$gtm_cart_script));
		}
		else
		{
			$msg = "Error Please Try Again";
			echo json_encode(array("msg"=>$msg,"cart_qty"=>$qty,"status"=>false,"task"=>$task, "getCartItemCount"=>$getCartItemCount, "redirect"=>$redirect, "message_alert_type"=>$message_alert_type, "script"=>$gtm_cart_script));
		}

	}

	function wishlistTask()
	{
		if (!empty($_POST['qty'])) {
			$qty = $_POST['qty'];
		} else {
			$qty = 1;
		}
		if (!empty($_POST['pis_id'])) {
			$pis_id = $_POST['pis_id'];
		} else {
			$pis_id = '';
		}
		if (!empty($_POST['p_id'])) {
			$p_id = $_POST['p_id'];
		} else {
			$p_id = '';
		}
		if (!empty($_POST['pc_id'])) {
			$pc_id = $_POST['pc_id'];
		} else {
			$pc_id = '';
		}
		if (!empty($_POST['task'])) {
			$task = $_POST['task'];
		} else {
			$task = '';
		}// 1= add to wishlist , 2= remove from wishlist , 3=add to wishlist remove from cart , 4= remove from wishlist move to cart
		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');

		$dataaddcart['application_sess_temp_id'] = $application_sess_temp_id;
		$dataaddcart['product_in_store_id'] = $pis_id;
		$dataaddcart['store_id'] = $application_sess_store_id;
		$dataaddcart['product_id'] = $p_id;
		$dataaddcart['product_combination_id'] = $pc_id;
		$dataaddcart['updated_on'] = date('Y-m-d H:i:s');
		$msg = "Something went wrong. Please try again";
		$status = false;

		$getNameArr = array(
			"select" => "*",
			"from" => "temp_wishlist",
			"where" => "(application_sess_temp_id='$application_sess_temp_id' and product_in_store_id='$pis_id' and store_id = '$application_sess_store_id' and product_id = '$p_id' and product_combination_id = $pc_id)"
		);
		$in_wishlist = $this->Common_model->getName($getNameArr);
		//print_r($dataaddcart);
		//print_r($in_wishlist);
		$products_list = $this->Products_model->productsSearch('products_list_group', '', '', $application_sess_temp_id, $application_sess_store_id, $p_id, $pc_id);
		foreach ($products_list as $col) {
			$product_name = $col['name'];
			$product_id = $col['product_id'];
			if(empty($col['manufacturer_name'])){ $col['manufacturer_name'] = ''; }
			$manufacturer_name = $col['manufacturer_name'];
		//Default combination details
			$discount = $col['product_combination'][0]['discount'] . ' ' . $col['product_combination'][0]['discount_var'];
			$discount = trim($discount);
			$price = $col['product_combination'][0]['price'];
			$final_price = $col['product_combination'][0]['final_price'];
			$product_image_name = $col['product_combination'][0]['product_image_name'];
			$combi = $col['product_combination'][0]['combi'];
			$product_in_store_id = $col['product_combination'][0]['product_in_store_id'];
			$product_combination_id = $col['product_combination'][0]['product_combination_id'];
			$prod_in_cart = $col['product_combination'][0]['prod_in_cart'];
			$in_store_quantity = $col['product_combination'][0]['quantity'];
			$stock_out_msg = $col['product_combination'][0]['stock_out_msg'];
			$quantity_per_order = $col['product_combination'][0]['quantity_per_order'];
		}
		$max_qty = 0;
		if ($quantity_per_order <= $in_store_quantity)
			$max_qty = $quantity_per_order;
		else
			$max_qty = $in_store_quantity;
		$product_complete_name = $manufacturer_name . ' ' . $product_name . ' -: ' . $combi;
		if ($task == 1) {
			if (count($in_wishlist) > 0) {
				$msg = $product_complete_name . " already in your wishlist";
				$status = true;
			} else {
				$in_wishlist = $this->Common_model->add_operation(array("data" => $dataaddcart, "table" => "temp_wishlist"));
				if ($in_wishlist > 0) {
					$msg = $product_complete_name . " added in your wishlist";
					$status = true;
				} else {
					$status = false;
				}
			}

		} else if ($task == 2) {
			$delete_operationArr = array(
				"table" => "temp_wishlist",
				"where" => "(application_sess_temp_id='$application_sess_temp_id' and product_in_store_id='$pis_id' and store_id = '$application_sess_store_id' and product_id = '$p_id' and product_combination_id = $pc_id)"
			);
			$response = $this->Common_model->delete_operation($delete_operationArr);
			if ($response) {
				$msg = $product_complete_name . " remove from your wishlist";
				$status = true;
			} else {
				$status = false;
			}
		}
		else if ($task == 3) {
			$delete_operationArr = array(
				"table" => "temp_cart",
				"where" => "(application_sess_temp_id='$application_sess_temp_id' and product_in_store_id='$pis_id' and store_id = '$application_sess_store_id' and product_id = '$p_id' and product_combination_id = $pc_id)"
			);
			$response = $this->Common_model->delete_operation($delete_operationArr);
			if (count($in_wishlist) > 0) {
				$msg = $product_complete_name . " already in your wishlist";
				$status = true;
			} else {
				$in_wishlist = $this->Common_model->add_operation(array("data" => $dataaddcart, "table" => "temp_wishlist"));
				if ($in_wishlist > 0) {
					$msg = $product_complete_name . " successfully move to wishlist";
					$status = true;
				} else {
					$status = false;
				}
			}
		}
		else if ($task == 4) {

			$in_cart = false;
			$in_cart_qty = 0;
			$temp_cart_id = '';
			$if_products_list = $this->Products_model->temp_cart('search_product_in_cart', '', '', $pis_id, $p_id, $pc_id, $application_sess_temp_id, $application_sess_store_id);
			//echo $this->db->last_query();
			if (!empty($if_products_list) && count($if_products_list) > 0) {
			//print_r($if_products_list);
				foreach ($if_products_list as $col) {
					$in_cart = true;
					$in_cart_qty = $col['quantity'];
					$temp_cart_id = $col['temp_cart_id'];
				}
			}
			$delete_operationArr = array(
				"table" => "temp_wishlist",
				"where" => "(application_sess_temp_id='$application_sess_temp_id' and product_in_store_id='$pis_id' and store_id = '$application_sess_store_id' and product_id = '$p_id' and product_combination_id = $pc_id)"
			);
			$response = $this->Common_model->delete_operation($delete_operationArr);
			if ($in_cart) {
				$msg = $product_complete_name . " already in your Cart";
				$status = true;
			} else {
				$dataaddcart['quantity'] = 1;
				if ($max_qty >= $dataaddcart['quantity']) {
					$insertStatus = $this->Products_model->add($dataaddcart, 'temp_cart');
					$msg = "$product_complete_name, $dataaddcart[quantity] in Basket";

				} else {
					$insertStatus = 'max reached';
					$msg = "Max Quantity Reached of $product_complete_name ";
				}
			}
		}

		$in_wishlist = $this->Common_model->getWishlistItemCount();
		$in_cart = $this->Common_model->getCartItemCount();
		echo json_encode(array("msg" => $msg, "status" => $status, "task" => $task, "in_wishlist" => $in_wishlist, "in_cart" => $in_cart));

		//temp_wishlist
	}


	public function wishlist()
	{
		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');
		$this->load->model('Products_model');
		$this->data['active_left_menu'] = 'wishlist';
		$distinct_product_id_in_wishlist = $this->Products_model->temp_cart('distinct_product_id_in_wishlist', '', '', '', '', '', $application_sess_temp_id, $application_sess_store_id);
		if (count($distinct_product_id_in_wishlist) > 0) {
			$product_ids = '';
			$product_combination_ids = '';
			foreach ($distinct_product_id_in_wishlist as $col) {
				$product_ids .= $col['product_id'] . ',';
				$product_combination_ids .= $col['product_combination_id'] . ',';
			}
			$product_ids = trim($product_ids, ',');
			$product_combination_ids = trim($product_combination_ids, ',');
			$this->data['products_list'] = $this->Products_model->productsSearch('products_list_group', '', '', $application_sess_temp_id, $application_sess_store_id, $product_ids, $product_combination_ids);
			//print_r($this->data['products_list']);
		}
		$this->data['profileWishlistCount'] = $this->Dashboard_model->profileWishlistCount(array('customers_id'=>$this->data['temp_id']));
		$this->data['wishlist_css'] = array('wishlist.css' );
		$this->data['css'] = array();
		// $this->data['direct_js'] = array('https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js');
		$this->data['js'] = array(  );
		parent::getHeader('header' , $this->data);
		$this->load->view('wishlist' , $this->data);
		parent::getFooter('footer' , $this->data);
	}

	public function my_cart_page_detail()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');
		$distinct_product_id_in_cart = $this->Products_model->temp_cart('distinct_product_id_in_cart','','' , '' , '', '', $application_sess_temp_id, $application_sess_store_id);
		if(count($distinct_product_id_in_cart)>0){
			$product_ids = '';
			$product_combination_ids = '';
			foreach($distinct_product_id_in_cart as $col){$product_ids.=$col['product_id'].',';$product_combination_ids.=$col['product_combination_id'].',';}
			$product_ids = trim($product_ids , ',');$product_combination_ids = trim($product_combination_ids , ',');
			$this->data['products_list']=$this->Products_model->productsSearch('products_list_group','', '', $application_sess_temp_id, $application_sess_store_id, $product_ids, $product_combination_ids);
			//print_r($products_list);
		}
		$this->data['css'] = array();
		$this->data['js'] = array('js/sticky-kit.js' );
		//parent::getHeader('header' , $this->data);
		$this->load->view('template/cart' , $this->data);
		//parent::getFooter('footer' , $this->data);
	}

	public function my_wishlist_page_detail()
	{
		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');
		$this->load->model('Products_model');
		$distinct_product_id_in_wishlist = $this->Products_model->temp_cart('distinct_product_id_in_wishlist', '', '', '', '', '', $application_sess_temp_id, $application_sess_store_id);
		if (count($distinct_product_id_in_wishlist) > 0) {
			$product_ids = '';
			$product_combination_ids = '';
			foreach ($distinct_product_id_in_wishlist as $col) {
				$product_ids .= $col['product_id'] . ',';
				$product_combination_ids .= $col['product_combination_id'] . ',';
			}
			$product_ids = trim($product_ids, ',');
			$product_combination_ids = trim($product_combination_ids, ',');
			$this->data['products_list'] = $this->Products_model->productsSearch('products_list_group', '', '', $application_sess_temp_id, $application_sess_store_id, $product_ids, $product_combination_ids);
			//print_r($this->data['products_list']);
		}
		$this->data['css'] = array();
		$this->data['js'] = array();
		$this->load->view('template/wishlist' , $this->data);
	}

	public function product_detail_quick_view($product_id='' , $combination_id=''  , $main_cat = "" , $sub_cat = "" , $super_sub_cat = "" ,  $main_cat_slug='' , $sub_cat_slug='' , $super_sub_cat_slug='')
	{
		$product_id = $_POST['product_id'];
		$combination_id = $_POST['product_combination_id'];
		$this->data['selected_combination_id'] = $selected_combination_id = $combination_id;

		$this->data['main_cat']=$main_cat;
		$this->data['sub_cat']=$sub_cat;
		$this->data['sub_cat']=$sub_cat;
		$this->data['main_cat_slug']=$main_cat_slug;
		$this->data['sub_cat_slug']=$sub_cat_slug;
		$this->data['super_sub_cat_slug']=$super_sub_cat_slug;
		$this->data['breadcrumbs']='<li><a href="'.base_url().'">Home</a></li><li><span><i class="fa fa-angle-right"></i></span></li> ';
		$cat_search = "";
		$this->data['left_nav_category']='';
		$this->data['current_category']='';
		$this->data['active_category']='';
		$this->data['pre_url']='';
		$this->data['pre_url_product']='';

		$this->data['products_list']=$this->Products_model->productsDetails('products_list','', '', $this->data['temp_id'], $this->data['store_id'] , $product_id , '' , '' , '' , 1 , '' , $combination_id);
		$this->data['product_specification']=$this->Products_model->productsDetails('product_specification','', '', $this->data['temp_id'], $this->data['store_id'] , $product_id , '' , '' , '' , 1 , '' , $combination_id);
		$this->data['products_image']=$this->Products_model->productsSearch('product_image_detail',$product_id, '', $this->data['temp_id'], $this->data['store_id'] , '' , '' , '' , '' , '' , '');
		$this->data['attribute'] = $this->Products_model->getAttribute(array("product_id"=>$product_id , "combination_id"=>$combination_id , "store_id"=>$this->data['store_id']));

		$this->data['product_reviews_list'] = $this->Products_model->getList('product_reviews_list', $product_id, "10", "");
		$this->data['product_questions_list'] = $this->Products_model->getList('product_questions_list', $product_id, "5", "");
		$this->data['product_questions_list_most_liked'] = $this->Products_model->getList('product_questions_list_most_liked', $product_id, "5", "");
		$this->data['product_answers_list'] = $this->Products_model->getList('product_answers_list', $product_id, "", "");
		$this->data['product_seo_list'] = $this->Products_model->getList('product_seo_list', $product_id, $combination_id, "");
		//print_r($this->data['product_seo_list']);
		if(!empty($this->data['product_seo_list']))
		{
			$product_seo_data = $this->data['product_seo_list'][0];
			$this->data['meta_title'] = $product_seo_data->meta_title;
			$this->data['meta_description'] = $product_seo_data->meta_description;
			$this->data['meta_keywords'] = $product_seo_data->meta_keywords;
			$this->data['meta_others'] = $product_seo_data->others;
		}
		$this->data['country'] = $this->Common_model->getCountry();
		//$this->data['css'] = array('css/drift-basic.css' );
		$this->data['js'] = array( 'js/Drift.min.js' , 'js/owl.carousel.min.js' );//, 'js/all-scripts.js'
		$this->data['php'] = array('script1/product-details' );// ,'add-script/star-script'
		//echo "</pre>";print_r($this->data);echo "<pre>";

		$this->load->view('product_detail_quick_view' , $this->data);
	}

	function getsuggestion()
	{
		$this->load->helper('text');
		$this->data['q']=$search = '';
		if(!empty($_POST['q']))
			$this->data['q']=$search = $_POST['q'];

		$search = addslashes($search);

		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');
		$limit=12;
		$this->data['products_list_count']=$this->Products_model->productsSearch('products_list_count','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , '' , '' , '' , '', '', array("in_stock"=>1));
		$this->data['products_list_count'] = $this->data['products_list_count'][0]['counts'];
		if(!empty($_REQUEST['offset'])){$offset = $_REQUEST['offset'];}else{$offset = '';}
		$this->data['offset'] = 'SS';
		if(empty($this->data['q']))
		{
			$this->data['trending_now'] = 1;
		}
		else
		{
			$this->data['trending_now'] = '';
		}

		$this->data['products_list']=$this->Products_model->productsSearch('products_list','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , "" , '' , $limit , $offset  , '', array("search"=>$search , 'trending_now'=>$this->data['trending_now'] , 'order'=>'random', 'in_stock'=>1));

		if(empty($this->data['products_list']))
		{
			$this->data['trending_now'] = 1;
			$this->data['products_list']=$this->Products_model->productsSearch('products_list','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , "" , '' , $limit , $offset  , '', array("search"=>'' , 'trending_now'=>1 , 'order'=>'random', 'in_stock'=>1));
		}

		if(!empty($this->data['q'])){
			//$this->data['category_for_search']=$this->Products_model->productsSearch('category_for_search','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , "" , '' , 9 , $offset  , '', array("search"=>$search  , 'order'=>'random' ));
			//$r_limit=9-count($this->data['category_for_search']);

			//if($r_limit>0)
			{
				$this->data['products_list_search']=$this->Products_model->productsSearch('products_list_for_search','', '', $application_sess_temp_id, $application_sess_store_id , '' , '' , "" , '' , $limit , $offset  , '', array("search"=>$search  , 'order'=>'random', 'in_stock'=>1 ));
			}

			if(empty($this->data['products_list_search']) && empty($this->data['products_list_search']))
			{
				//$this->data['trending_p'] = $this->Common_model->getName(array('select'=>'c.category_id , name , slug_url ' , 'from'=>'category as c' , 'where'=>"c.category_id=1"));
				//$this->data['trending_c'] = $this->Common_model->getName(array('select'=>'c.category_id , name , slug_url ' , 'from'=>'category as c' , 'where'=>"c.super_category_id in (1)"));
			}

		}
		else
		{
			//$this->data['trending_p'] = $this->Common_model->getName(array('select'=>'c.category_id , name , slug_url ' , 'from'=>'category as c' , 'where'=>"c.super_category_id=0 and status=1"));
			//$this->data['trending_c'] = $this->Common_model->getName(array('select'=>'c.category_id , name , slug_url ' , 'from'=>'category as c' , 'where'=>"c.super_category_id in (0) and status=1"));
		}
		//echo "<pre>";print_r($this->data);echo "</pre>";
		$this->data['callFor']='loadMore';
		$this->data['callFrom']='headerSearch';
		$this->load->view('template/head_search',$this->data);
	}

	function getCartpageAddress()
	{
		$this->load->model('Checkout_model');
		$this->data['customer_address_data'] = $this->Checkout_model->getUser(array('customers_id'=>$this->data['temp_id']));
		$this->load->view('getCartpageAddress' , $this->data);
	}

	function getPincodeDetail()
	{
		$this->data['pincode'] = $_POST['pincode'];
		$this->data['total_weight'] = $_POST['total_weight'];
		$this->data['page'] = '';
		if(!empty($_POST['page']))
		{
			$this->data['page'] = $_POST['page'];
		}
		//$this->data['orders_detail']=$this->Orders_Model->getOrdersDetails(array("orders_id"=>$orders_id , "stores_id"=>$this->data['backend_sess_id']));
		//print_r($this->data['orders_detail']);
		$pageData['currentPageName']=$uriid=$this->uri->segment(1);
		$this->load->view('getPincodeDetail' , $this->data);
	}

	public function removeCoupon()
	{
		//$this->session->sess_destroy();
		//$this->load->library('session');
		$alert_message = '<div class=" alert alert-success">Coupon is successfully removed.</div>';
		if(!empty($_REQUEST['total_mismatch']))
		{
			$alert_message = '<div class=" alert alert-danger">'.$this->data['cart_discount_cart_value_message'].'</div>';
		}
		$this->session->set_userdata('application_sess_coupon_code','');
		$this->session->set_userdata('application_sess_discount','');
		$this->session->set_userdata('application_sess_discount_in','');
		$this->session->set_userdata('application_sess_discount_variable','');
		$this->session->set_userdata('application_sess_discount_on_cart_value','');
		$this->session->set_userdata('application_sess_discount_cart_value_message','');

		$this->session->set_flashdata('message', $alert_message);
		REDIRECT(base_url().__cart__);
	}

	function getCartDetail()
	{
		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');
		$distinct_product_id_in_cart = $this->Products_model->temp_cart('distinct_product_id_in_cart','','' , '' , '', '', $application_sess_temp_id, $application_sess_store_id);
		$sub_total=0;

		if(count($distinct_product_id_in_cart)>0){
			//print_r($distinct_product_id_in_cart);
			$product_ids = '';
			$product_combination_ids = '';
			foreach($distinct_product_id_in_cart as $col){$product_ids.=$col['product_id'].',';$product_combination_ids.=$col['product_combination_id'].',';}
			$product_ids = trim($product_ids , ',');$product_combination_ids = trim($product_combination_ids , ',');
			$this->data['products_list']=$this->Products_model->productsSearch('products_list_group','', '', $application_sess_temp_id, $application_sess_store_id, $product_ids, $product_combination_ids);

		}
		/*else
		{
			$display_header = "<div class='cartRightSlideInner'><h3>My cart (0)</h3><a class='cartSideClosebut' onclick='cartSideClose()' ><span class='lnr lnr-cross'></span></a><div class='slideSubtotals'><ul class='total-sub-totle'><li><span>Sub Total</span><span> ".$this->data['currency']->symbol."  0.00 </span></li>";
			//$display_header .= "<li><span>Delivery Charges </span><span class='green'> ".$this->data['currency']->symbol."  0.00 </span></li>";
			$display_header .= "</ul><ul class='total-sub-totle'><li><span>Your total savings</span><span class='red'> ".$this->data['currency']->symbol."  0.00 (0%) </span></li></ul><span class='hrLine'></span><ul class='slideProductLsting'>";
			$display_body = "Your Cart is Empty";
			$showFooter = "</ul><div class='slideproceedButton'><ul><li><a href='".base_url(__payment__)."' ><span>Proceed To Checkout </span><span>".$this->data['currency']->symbol."  $sub_total</span></a></li></ul></div></div></div>";
			//echo $display_header;
			//echo $display_body;
			//echo $showFooter;
		}*/
		$this->load->view('template/side-cart' , $this->data);
	}

	function addNoteToOrder()
	{
		$customer_order_note = $_POST['customer_order_note'];
		$this->session->set_userdata('application_sess_customer_order_note',$customer_order_note);
	}

	function payment1()
	{
		$product_combination_ids = $product_ids = '';
		$this->data['distinct_product_id_in_cart'] = $this->Common_Model->temp_cart('distinct_product_id_in_cart','','' , '' , '', '', $this->data['temp_id'], $this->data['store_id']);

		if(empty($this->data['distinct_product_id_in_cart']))
		{
			$this->session->set_flashdata('message', '<div class=" alert alert-warning">Yout cart is empty.</div>');
			REDIRECT(base_url().__cart__);
		}
		//print_r($this->data['distinct_product_id_in_cart']);
		foreach($this->data['distinct_product_id_in_cart'] as $col){$product_ids.=$col['product_id'].',';$product_combination_ids.=$col['product_combination_id'].',';}
		$product_ids = trim($product_ids , ',');$product_combination_ids = trim($product_combination_ids , ',');

		$this->data['products_list']=$this->Products_model->productsSearch('products_list_group','', '', $this->data['temp_id'], $this->data['store_id'], $product_ids, $product_combination_ids);

		$this->data['css'] = array('product-list.css');
		$this->data['js'] = array(  );

		parent::getHeader('header' , $this->data);
		$this->load->view('payment1',$this->data);
		parent::getFooter('footer' , $this->data);
	}

	function all_category()
	{
		$this->data['categories'] = $this->data['left_nav_category']=$this->Common_model->getMenu('menu','', '', $this->data['temp_id'], $this->data['store_id'] , '' , '' , '' , '' , '' , '' , '');
		$this->data['php'] = array();
		parent::getHeader('header' , $this->data);
		$this->load->view('all_category' , $this->data);
		parent::getFooter('footer' , $this->data);
		//print_r($this->data);
		//print_r( $this->data['left_nav_category']);
	}
}
