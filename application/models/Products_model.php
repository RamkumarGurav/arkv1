<?php
include('database_tables.php');
class Products_model extends database_tables
{
	function __construct()
    {
        parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->library('session');
		$this->db->query("SET sql_mode = ''");
	}

	function getIndexCategory($params = array())
	{
		$this->db
		->select('c.category_id , c.super_category_id, c.cover_image , c.name , c.slug_url , short_description ')
		->from('category as c')
		->where('c.status' , 1)
		->where('c.is_display_home_page' , 1)
		->order_by('c.position ASC');

		if(!empty($params['super_category_id']))
		$this->db->where('c.super_category_id' , $params['super_category_id']);

		if(!empty($params['category_id']))
		$this->db->where('c.category_id' , $params['category_id']);

		$result = $this->db->get()->result();

		if(!empty($result))
		{
			foreach($result as $r)
			{
				$this->db
				->select('c.category_id , c.super_category_id , c.name , c.slug_url , short_description ')
				->from('category as c')
				->where('c.super_category_id' , $r->category_id)
				->limit(5);
				$r->sub_category = $this->db->get()->result();
				if(!empty($r->sub_category))
				{
					foreach($r->sub_category as $r2)
					{
						$pre_url='';
						$pre_url.=$r->slug_url.'/';
						$pre_url =$pre_url.$r2->slug_url;
						$r2->pre_url = $pre_url;
					}
				}
			}
		}

		return $result;
	}

	function getCategory($params = array())
	{
		$this->db
		->DISTINCT()
		->select('c.category_id , c.super_category_id , c.name , c.position , c.url , c.slug_url ')
		->from('category as c')
		->join('product_category as pcat' , 'pcat.category_id=c.category_id')
		->join('product as p' , 'pcat.product_id=p.product_id')
		->join('product_combination as pc' , 'pc.product_id=p.product_id')
		->join('product_in_store as pis' , 'pis.product_id=p.product_id')

		->where('c.status' , 1)
		->where('p.status' , 1)
		->where('pc.status' , 1)
		->where('pis.status' , 1);

		/*if(__is_location_wise_product__)
		{
			$this->db->where("p.is_sell_local  in (".__app_is_sell_local__.")");
		}*/

		if(!empty($params['super_category_id']))
		$this->db->where('c.super_category_id' , $params['super_category_id']);

		if(!empty($params['category_id']))
		$this->db->where('c.category_id' , $params['category_id']);

		$result = $this->db->get();
		if($result->num_rows()>0)
		{
			return $result->result();
		}
	}

	function temp_cart($category, $id, $status='', $search1='', $search2='', $search3='', $search4='', $search5='', $search6='')
	{
		$pg_content = array();
		if($category == 'search_product_in_cart')
		{
			$sql_get_list="select tc.quantity, tc.temp_cart_id from temp_cart as tc left join product as p ON p.product_id = tc.product_id where temp_cart_id ";
			if(!empty($search4))
				$sql_get_list.=" and tc.application_sess_temp_id = '$search4' ";
			if(!empty($search1))
				$sql_get_list.=" and tc.product_in_store_id = '$search1' ";
			if(!empty($search5))
				$sql_get_list.=" and tc.store_id = '$search5' ";
			if(!empty($search2))
				$sql_get_list.=" and tc.product_id = '$search2' ";
			if(!empty($search3))
				$sql_get_list.=" and tc.product_combination_id = '$search3' ";

			/*if(__is_location_wise_product__)
			{
				$sql_get_list .= " and p.is_sell_local in (".__app_is_sell_local__.") ";
			}*/

			$query_get_list=$this->db->query($sql_get_list);
			{
				if($query_get_list->num_rows() > 0 )
				{
					foreach($query_get_list->result() as $row_get_list)
					{
						$pg_content[]=array("quantity"=>$row_get_list->quantity,"temp_cart_id"=>$row_get_list->temp_cart_id);
					}
				}
		    }
			return $pg_content;
		}

		if($category == 'distinct_product_id_in_cart')
		{
			$sql_get_list="select DISTINCT(tc.product_combination_id), tc.product_id , tc.product_combination_id from temp_cart as tc left join product as p ON p.product_id = tc.product_id where temp_cart_id ";
			if(!empty($search4))
				$sql_get_list.=" and tc.application_sess_temp_id = '$search4' ";
			if(!empty($search1))
				$sql_get_list.=" and tc.product_in_store_id = '$search1' ";
			if(!empty($search5))
				$sql_get_list.=" and tc.store_id = '$search5' ";
			if(!empty($search2))
				$sql_get_list.=" and tc.product_id = '$search2' ";
			if(!empty($search3))
				$sql_get_list.=" and tc.product_combination_id = '$search3' ";

			/*if(__is_location_wise_product__)
			{
				$sql_get_list .= " and p.is_sell_local in (".__app_is_sell_local__.") ";
			}*/

			$query_get_list=$this->db->query($sql_get_list);
			{
				if($query_get_list->num_rows() > 0 )
				{
					foreach($query_get_list->result() as $row_get_list)
					{
						$pg_content[]=array("product_id"=>$row_get_list->product_id , "product_combination_id"=>$row_get_list->product_combination_id);
					}
				}
		    }
			return $pg_content;
		}

		if ($category == 'distinct_product_id_in_wishlist') {
			$sql_get_list = "select tw.product_id , tw.product_combination_id from temp_wishlist as tw left join product as p ON p.product_id = tw.product_id where temp_wishlist_id ";
			if (!empty($search4))
				$sql_get_list .= " and tw.application_sess_temp_id = '$search4' ";
			if (!empty($search1))
				$sql_get_list .= " and tw.product_in_store_id = '$search1' ";
			if (!empty($search5))
				$sql_get_list .= " and tw.store_id = '$search5' ";
			if (!empty($search2))
				$sql_get_list .= " and tw.product_id = '$search2' ";
			if (!empty($search3))
				$sql_get_list .= " and tw.product_combination_id = '$search3' ";

			/*if(__is_location_wise_product__)
			{
				$sql_get_list .= " and p.is_sell_local in (".__app_is_sell_local__.") ";
			}*/

			$query_get_list = $this->db->query($sql_get_list);
			{
				if ($query_get_list->num_rows() > 0) {
					foreach ($query_get_list->result() as $row_get_list) {
						$pg_content[] = array("product_id" => $row_get_list->product_id, "product_combination_id" => $row_get_list->product_combination_id);
					}
				}
			}
			return $pg_content;
		}
	}

	function productsSearch($category, $id, $status='', $search1='', $search2='', $search3='', $search4='', $search5='', $search6=''  , $limit='' , $offset='' , $orderby='' , $params = array())
	{

		$pg_content = array();
		 if($category == 'products_list_count')
		{
		//print_r($params);
			$sql_get_list="select pc.product_combination_id ";

			$sql_get_list .= " from product as p  ";

			//$sql_get_list .= "  left join product_tag_value as ptv ON p.product_id = ptv.product_id left join product_tag as pt on pt.product_tag_id = ptv.product_tag_id  ";

			$sql_get_list .= ", brand_master as m, product_in_store as pis, product_category as pcat, product_combination as pc JOIN product_combination_attribute as pca ON pca.product_combination_id=pc.product_combination_id  , product_image as pi   ";

			$sql_get_list .= " ,  category as c   ";

			$sql_get_list .= " where m.brand_id=p.brand_id and p.status=1 and pis.product_id=p.product_id and pis.store_id=$search2 and pis.status=1 and pcat.product_id = p.product_id ";

			$sql_get_list .= " and pc.product_id=p.product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1 and  c.category_id = pcat.category_id and c.status=1 ";

			/*if(__is_location_wise_product__)
			{
				$sql_get_list .= " and p.is_sell_local in (".__app_is_sell_local__.") ";
			}*/


			$sql_get_list.=" and pis.store_id =$search2 ";
			if(!empty($search3))
				$sql_get_list.=" and p.product_id in ($search3) ";
			if(!empty($params['cat_search']))
			{
				//echo "<br>cat_search: ";echo $params['cat_search'];echo "<br>";
				$sql_get_list.=" and pcat.category_id in ($params[cat_search]) ";
			}
			if(!empty($params['search']))
			{
				$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and (p.name like ('%$params[search]%') or pc.product_display_name like ('%$params[search]%') ";
				//$sql_get_list.=" or pt.content like ('%$params[search]%')) ";
				//$sql_get_list.=" or p.product_tags like ('%$params[search]%')) ";

					/*
					$sql_get_list.=" and (p.name like ('%$params[search]%') or pc.product_display_name like ('%$params[search]%') or cat.name like ('%$params[search]%') or  m.brand_name like ('%$params[search]%') ";

				$sql_get_list.=" or pt.content like ('%$params[search]%') ";

				$sql_get_list.=" ) ";
					*/
			}
			if(!empty($params['trending_now']))
			{
				$sql_get_list.=" and pc.trending_now = 1 ";
			}
			if(!empty($params['hot_selling_now']))
			{
				$sql_get_list.=" and pc.hot_selling_now = 1 ";
			}
			if(!empty($params['best_sellers']))
			{
				$sql_get_list.=" and pc.best_sellers = 1 ";
			}
			if(!empty($params['new_product']))
			{
				$sql_get_list.=" and pc.new_product = 1 ";
			}
			if(!empty($params['min_price']))
			{
				$min_price = $params['min_price'];
				$sql_get_list.=" and pc.final_price >= $min_price ";
			}
			if(!empty($params['max_price']))
			{
				$max_price = $params['max_price'];
				$sql_get_list.=" and pc.final_price <= $max_price ";
			}
			if(!empty($params['is_related']))
			{
				$sql_get_list.=" and pc.product_combination_id != $params[product_combination_id] ";
				//$sql_get_list.=" and p.product_id != $params[product_id] ";
			}
			if(!empty($params['in_stock']))
			{
				$sql_get_list.=" and pis.quantity > 0 ";
			}

			//$sql_get_list.=" group by p.product_id ";
//			new_product best_sellers hot_selling_now trending_now
			if(!empty($params['Qsearch']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['Qsearch'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					//$sql_get_list .= " pca.product_attribute_value_id = $q ";
					$sql_get_list .= " ( pca.product_attribute_value_id = $q[product_attribute_value_id] and pca.combination_value = '$q[combination_value]' ) ";


				}
				$sql_get_list .= " ) ";

			}
			if(!empty($params['brand_id']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['brand_id'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					$sql_get_list .= " p.brand_id = $q ";
				}
				$sql_get_list .= " ) ";

			}

			if(!empty($search4))
				$sql_get_list.=" and pc.product_combination_id in ($search4) ";
			//if(!empty($orderby))
				//$sql_get_list1.=" order by FIELD(pc.product_combination_id, '$orderby') DESC ";

			$sql_get_list .= " group by pc.product_combination_id  ";

			/*if(!empty($limit) && empty($offset))
				$sql_get_list.=" LIMIT $limit ";
			if(!empty($offset))
				$sql_get_list.=" LIMIT $limit OFFSET $offset ";*/

			//echo $sql_get_list.'<br>';
				$query_get_list=$this->db->query($sql_get_list);
				{
					//echo $sql_get_list.'<br>';
					if($query_get_list->num_rows() > 0 )
					{
						$pg_content[]=array("counts"=>count($query_get_list->result()));
					}
					else
					{
						$pg_content[]=array("counts"=>0);
					}

				}

			return $pg_content;

//			select count(p.product_id) as counts  from product p , brand_master as m where m.brand_id=p.brand_id and m.status=1 and p.status=1
			$sql_get_list="select pc.product_combination_id from product p , brand_master as m, product_in_store as pis, product_category as pcat, category as cat, product_combination as pc JOIN product_combination_attribute as pca ON pca.product_combination_id=pc.product_combination_id  , product_image as pi  where m.brand_id=p.brand_id and p.status=1 and pis.product_id=p.product_id and pis.store_id=$search2 and pis.status=1 and pcat.product_id = p.product_id and cat.category_id = pcat.category_id and cat.status=1 ";
			$sql_get_list .= " and pc.product_id=p.product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1  ";
			$sql_get_list.=" and pis.store_id =$search2 ";
			if(!empty($search3))
				$sql_get_list.=" and p.product_id in ($search3) ";
			if(!empty($params['cat_search']))
			{
				$sql_get_list.=" and pcat.category_id in ($params[cat_search]) ";
			}
			if(!empty($params['search']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and (p.name like ('%$params[search]%') or pc.product_display_name like ('%$params[search]%')) ";
			}

			if(!empty($params['flash_sale']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and pc.flash_sale =1 ";
			}
			if(!empty($params['trending_now']))
			{
				$sql_get_list.=" and pc.trending_now = 1 ";
			}
			if(!empty($params['hot_selling_now']))
			{
				$sql_get_list.=" and pc.hot_selling_now = 1 ";
			}
			if(!empty($params['best_sellers']))
			{
				$sql_get_list.=" and pc.best_sellers = 1 ";
			}
			if(!empty($params['new_product']))
			{
				$sql_get_list.=" and pc.new_product = 1 ";
			}
			if(!empty($params['is_related']))
			{
				$sql_get_list.=" and pc.product_combination_id != $params[product_combination_id] ";
				//$sql_get_list.=" and p.product_id != $params[product_id] ";
			}
			//$sql_get_list.=" group by p.product_id ";
//			new_product best_sellers hot_selling_now trending_now
			if(!empty($params['Qsearch']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['Qsearch'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					//$sql_get_list .= " pca.product_attribute_value_id = $q ";
					$sql_get_list .= " ( pca.product_attribute_value_id = $q[product_attribute_value_id] and pca.combination_value = '$q[combination_value]' ) ";
				}
				$sql_get_list .= " ) ";

			}
			if(!empty($params['brand_id']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['brand_id'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					$sql_get_list .= " p.brand_id = $q ";
				}
				$sql_get_list .= " ) ";

			}

			if(!empty($params['author_id']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['author_id'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					$sql_get_list .= " p.author_id = $q ";
				}
				$sql_get_list .= " ) ";

			}

			if(!empty($search4))
				$sql_get_list.=" and pc.product_combination_id in ($search4) ";
			//if(!empty($orderby))
				$sql_get_list.=" group by pc.product_combination_id ";

				$group = false;

				$query_get_list=$this->db->query($sql_get_list);
				{
					//echo $sql_get_list.'<br>';
					if($query_get_list->num_rows() > 0 )
					{
						$pg_content[]=array("counts"=>count($query_get_list->result()));
					}
					else
					{
						$pg_content[]=array("counts"=>0);
					}
				}

			return $pg_content;

			$sql_get_list="select count(p.product_id) as counts  from product p , brand_master as m where m.brand_id=p.brand_id and m.status=1 and p.status=1 ";
			if(!empty($search3))
				$sql_get_list.=" and p.product_id in ($search3) ";

			if(!empty($limit))
				$sql_get_list.=" LIMIT $limit ";
			if(!empty($offset))
				$sql_get_list.=" LIMIT $limit , $offset ";
		//	echo $sql_get_list;
				$query_get_list=$this->db->query($sql_get_list);
				{
					if($query_get_list->num_rows() > 0 )
					{
						foreach($query_get_list->result() as $row_get_list)
						{
							$pg_content[]=array("counts"=>$row_get_list->counts);
						}
					}
				}

			return $pg_content;
		}

		if($category == 'category_for_search')
		{
			$sql_get_list="select c.category_id , c.name , c.super_category_id , c.slug_url from category as c where c.status=1  ";
			if(!empty($params['search']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and (c.name like ('%$params[search]%')) ";
			}
			if(!empty($limit) && empty($offset))
			{
				$sql_get_list.=" LIMIT $limit ";
			}
				$query_get_list=$this->db->query($sql_get_list);
				{
					if($query_get_list->num_rows() > 0 )
					{
						$mcCount=-1;
						$pg_content=$query_get_list->result();
						foreach($query_get_list->result() as $row_get_list)
						{
							$mcCount++;
							$caturl=base_url();
							$super_cat = '';
							if($row_get_list->super_category_id>0)
							{
								$sql_get_list1="select c.category_id , c.name , c.super_category_id , c.slug_url from category as c where  c.category_id =$row_get_list->super_category_id ";
								$query_get_list1=$this->db->query($sql_get_list1);
								$result_get_list1 = $query_get_list1->result();
								if(!empty($result_get_list1))
								{
									$result_get_list1 = $result_get_list1[0];
									$super_cat = $result_get_list1->name;
									if($result_get_list1->super_category_id>0)
									{
										$sql_get_list2="select c.category_id , c.name , c.super_category_id , c.slug_url from category as c where  c.category_id =$result_get_list1->super_category_id ";
										$query_get_list2=$this->db->query($sql_get_list2);
										$result_get_list2 = $query_get_list2->result();
										if(!empty($result_get_list2))
										{
											$result_get_list2 = $result_get_list2[0];
											$caturl .= $result_get_list2->slug_url.'/';
											//$super_cat = $result_get_list2->slug_url;
										}
									}
									$caturl .= $result_get_list1->slug_url.'/';
								}
							}

							$caturl .= $row_get_list->slug_url;
							$pg_content[$mcCount]->caturl = $caturl;
							$pg_content[$mcCount]->super_cat = $super_cat;

						}
					}
				}

			return $pg_content;
		}

		if($category == 'products_list_for_search')
		{//
			$sql_get_list = "select DISTINCT(pc.product_combination_id),pis.* , cat.name as cat_name , cat.slug_url as cat_slug_url , cat.category_id as cat_category_id , cat.super_category_id as cat_super_category_id , pc.product_display_name , pc.delivery_charges , pc.trending_now , pc.hot_selling_now , pc.best_sellers , pc.new_product , pc.default_combination , pc.product_combination_id , pc.comb_slug_url , pc.product_image_id , pc.ref_code , pc.product_weight , pc.product_dimension , pi.product_image_name , p.product_id , p.brand_id , p.name , p.ref_code , p.short_description, m.brand_name, (select ps.slug_url from product_seo as ps where ps.product_id = p.product_id and  ps.product_combination_id = pc.product_combination_id limit 1) as ps_slug_url  ";

			//$sql_get_list .= " ,(select count(ptv.product_tag_id) from product_tag_value as ptv where p.product_id = ptv.product_id ) as tags_count  ";

			$sql_get_list .= " from product p , brand_master as m, product_in_store as pis, product_category as pcat , category as cat, product_combination as pc ";

			//$sql_get_list .= "  left join product_tag_value as ptv ON pc.product_id = ptv.product_id left join product_tag as pt on pt.product_tag_id = ptv.product_tag_id  ";

			$sql_get_list .= " JOIN product_combination_attribute as pca ON pca.product_combination_id=pc.product_combination_id  , product_image as pi  where m.brand_id=p.brand_id and m.status=1 and p.status=1 and pis.product_id=p.product_id and pis.store_id=$search2 and pis.status=1 and pcat.product_id = p.product_id and cat.category_id = pcat.category_id and cat.status=1 ";

			$sql_get_list .= " and pc.product_id=p.product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1  ";
			$sql_get_list.=" and pis.store_id =$search2 ";

			/*if(__is_location_wise_product__)
			{
				$sql_get_list .= " and p.is_sell_local  in (".__app_is_sell_local__.") ";
			}*/

			if(!empty($search3))
				$sql_get_list.=" and p.product_id in ($search3) ";
			if(!empty($params['cat_search']))
			{
				$sql_get_list.=" and pcat.category_id in ($params[cat_search]) ";
			}
			if(!empty($params['search']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and (p.name like ('%$params[search]%') or pc.product_display_name like ('%$params[search]%') or cat.name like ('%$params[search]%') or  m.brand_name like ('%$params[search]%') ";

				//$sql_get_list.=" or pt.content like ('%$params[search]%') ";
				//$sql_get_list.=" or p.product_tags like ('%$params[search]%') ";

				$sql_get_list.=" ) ";
			}
			if(!empty($params['trending_now']))
			{
				$sql_get_list.=" and pc.trending_now = 1 ";
			}
			if(!empty($params['hot_selling_now']))
			{
				$sql_get_list.=" and pc.hot_selling_now = 1 ";
			}
			if(!empty($params['best_sellers']))
			{
				$sql_get_list.=" and pc.best_sellers = 1 ";
			}
			if(!empty($params['new_product']))
			{
				$sql_get_list.=" and pc.new_product = 1 ";
			}
			//$sql_get_list.=" group by p.product_id ";
//			new_product best_sellers hot_selling_now trending_now
			if(!empty($params['Qsearch']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['Qsearch'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					$sql_get_list .= " ( pca.product_attribute_value_id = $q[product_attribute_value_id] and pca.combination_value = '$q[combination_value]' ) ";
				}

				$sql_get_list .= " ) ";

			}

			if(!empty($search4))
				$sql_get_list.=" and pc.product_combination_id in ($search4) ";
			//if(!empty($orderby))
				//$sql_get_list1.=" order by FIELD(pc.product_combination_id, '$orderby') DESC ";

			if(!empty($params['order']))
			{
				$group = false;
				$temp_currency_id = $this->session->userdata('application_sess_currency_id');
				if(empty($temp_currency_id) || $temp_currency_id==1)
				{
					if($params['order']==1)
					$sql_get_list .= " group by pc.product_id order by pis.final_price ASC ";
					if($params['order']==2)
					$sql_get_list .= " group by pc.product_id order by pis.final_price DESC ";
					if($params['order']=='random')
					$sql_get_list .= " group by pc.product_id order by RAND()  ";
				}
				else
				{
					if($params['order']==1)
					$sql_get_list .= " group by pc.product_id order by pis.other_final_price ASC ";
					if($params['order']==2)
					$sql_get_list .= " group by pc.product_id order by pis.other_final_price DESC ";
					if($params['order']=='random')
					$sql_get_list .= " group by pc.product_id order by RAND()  ";
				}
			}
			else
			{
				$sql_get_list .= " group by pc.product_id order by pc.default_combination DESC ";
				$group = false;
			}


			if(!empty($limit) && empty($offset))
				$sql_get_list.=" LIMIT $limit ";
			if(!empty($offset))
				$sql_get_list.=" LIMIT $limit OFFSET $offset ";

			//echo $sql_get_list;
				$query_get_list=$this->db->query($sql_get_list);
				{
					//echo $sql_get_list.'<br>';
						if($query_get_list->num_rows() > 0 )
						{

							$pg_content = $query_get_list->result();
							//foreach($pg_content as $pc){echo $pc->content.'<br>';}
								/*foreach($query_get_list->result() as $row_get_list)
								{
									$content_product_combination=array();
									$row_get_list1 = $row_get_list;
										$pg_content[]=array("product_id"=>$row_get_list->product_id,"ps_slug_url"=>$row_get_list->ps_slug_url,"brand_id"=>$row_get_list->brand_id,"short_description"=>$row_get_list->short_description,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"slug_url"=>$row_get_list->slug_url,"short_description"=>$row_get_list->short_description,"brand_name"=>$row_get_list->brand_name,"product_combination_id"=>$row_get_list1->product_combination_id,"product_id"=>$row_get_list1->product_id	,"ref_code"=>$row_get_list1->ref_code,"quantity"=>$row_get_list1->quantity,"price"=>$row_get_list1->price,"discount"=>$row_get_list1->discount,"discount_var"=>$row_get_list1->discount_var,"final_price"=>$row_get_list1->final_price,"status"=>$row_get_list1->status,"added_on"=>$row_get_list1->added_on,"updated_on"=>$row_get_list1->updated_on,"product_image_id"=>$row_get_list1->product_image_id,"default_combination"=>$row_get_list1->default_combination,"comb_slug_url"=>$row_get_list1->comb_slug_url,"product_image_name"=>$row_get_list1->product_image_name, "product_in_store_id"=>$row_get_list1->product_in_store_id,  "quantity_per_order"=>$row_get_list1->quantity_per_order, "stock_out_msg"=>$row_get_list1->stock_out_msg, "product_weight"=>$row_get_list1->product_weight, "product_dimension"=>$row_get_list1->product_dimension,"trending_now"=>$row_get_list1->trending_now,"hot_selling_now"=>$row_get_list1->hot_selling_now,"best_sellers"=>$row_get_list1->best_sellers,"new_product"=>$row_get_list1->new_product,"product_display_name"=>$row_get_list1->product_display_name,"delivery_charges"=>$row_get_list1->delivery_charges);


								}*/
						}
				}

			return $pg_content;
		}

		if($category == 'products_min_max_price')
		{
			$sql_get_list="select MIN(pc.final_price) as min_final_price ,  MAX(pc.final_price) as max_final_price from product p , product_in_store as pis, product_category as pcat, category as cat, product_combination as pc JOIN product_combination_attribute as pca ON pca.product_combination_id=pc.product_combination_id  , product_image as pi  where p.status=1 and pis.product_id=p.product_id and pis.store_id=$search2 and pis.status=1 and pcat.product_id = p.product_id and cat.category_id = pcat.category_id and cat.status=1 ";
			$sql_get_list .= " and pc.product_id=p.product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1  ";
			$sql_get_list.=" and pis.store_id =$search2 ";

			/*if(__is_location_wise_product__)
			{
				$sql_get_list .= " and p.is_sell_local  in (".__app_is_sell_local__.") ";
			}*/

			if(!empty($search3))
				$sql_get_list.=" and p.product_id in ($search3) ";
			if(!empty($params['cat_search']))
			{
				$sql_get_list.=" and pcat.category_id in ($params[cat_search]) ";
			}
			if(!empty($params['search']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and (p.name like ('%$params[search]%') or pc.product_display_name like ('%$params[search]%')) ";
			}

			if(!empty($params['flash_sale']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and pc.flash_sale =1 ";
			}
			if(!empty($params['trending_now']))
			{
				$sql_get_list.=" and pc.trending_now = 1 ";
			}
			if(!empty($params['hot_selling_now']))
			{
				$sql_get_list.=" and pc.hot_selling_now = 1 ";
			}
			if(!empty($params['best_sellers']))
			{
				$sql_get_list.=" and pc.best_sellers = 1 ";
			}
			if(!empty($params['new_product']))
			{
				$sql_get_list.=" and pc.new_product = 1 ";
			}
			if(!empty($params['is_related']))
			{
				$sql_get_list.=" and pc.product_combination_id != $params[product_combination_id] ";
				//$sql_get_list.=" and p.product_id != $params[product_id] ";
			}
			//$sql_get_list.=" group by p.product_id ";
//			new_product best_sellers hot_selling_now trending_now
			if(!empty($params['Qsearch']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['Qsearch'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					//$sql_get_list .= " pca.product_attribute_value_id = $q ";
					$sql_get_list .= " ( pca.product_attribute_value_id = $q[product_attribute_value_id] and pca.combination_value = '$q[combination_value]' ) ";
				}
				$sql_get_list .= " ) ";

			}

			if(!empty($params['author_id']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['author_id'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					$sql_get_list .= " p.author_id = $q ";
				}
				$sql_get_list .= " ) ";

			}

			if(!empty($search4))
				$sql_get_list.=" and pc.product_combination_id in ($search4) ";
			//if(!empty($orderby))
				//$sql_get_list1.=" order by FIELD(pc.product_combination_id, '$orderby') DESC ";
				$group = false;

				$query_get_list=$this->db->query($sql_get_list);
				{
					//echo $sql_get_list.'<br>';
					if($query_get_list->num_rows() > 0 )
					{
						foreach($query_get_list->result() as $row_get_list)
						{
							$pg_content[]=array("min_final_price"=>$row_get_list->min_final_price,"max_final_price"=>$row_get_list->max_final_price);
						}
					}
				}

			return $pg_content;
		}

		if($category == 'products_list')
		{
			$sql_get_list="select DISTINCT(pc.product_combination_id),pis.* , pc.product_display_name , pc.delivery_charges , pc.trending_now , pc.hot_selling_now , pc.best_sellers , pc.new_product , pc.default_combination , pc.product_combination_id , pc.comb_slug_url , pc.product_image_id , pc.ref_code as pc_ref_code , pc.product_weight , pc.product_dimension , pi.product_image_name , (select tc.quantity from temp_cart as tc where tc.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_cart , (select count(tw.temp_wishlist_id) from temp_wishlist as tw where tw.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_wishList, p.product_id , p.short_description , p.name , p.ref_code , p.short_description, (select tc.tax_name from tax as tc where p.tax_id = tc.tax_id limit 1) as tax_categories_name , (select tp.tax_percentage from tax as tp where p.tax_id = tp.tax_id limit 1) as tax_percentage , (select ps.slug_url from product_seo as ps where ps.product_id = p.product_id and  ps.product_combination_id = pc.product_combination_id limit 1) as ps_slug_url  ";

			$sql_get_list .= " from product p  , ";

			//$sql_get_list .= "  left join product_tag_value as ptv ON p.product_id = ptv.product_id left join product_tag as pt on pt.product_tag_id = ptv.product_tag_id , ";

			$sql_get_list .= "  product_in_store as pis, product_category as pcat, product_combination as pc JOIN product_combination_attribute as pca ON pca.product_combination_id=pc.product_combination_id  , product_image as pi   ";

			$sql_get_list .= " ,  category as c   ";


			$sql_get_list .= "   where p.status=1 and pis.product_id=p.product_id and pis.store_id=$search2 and pis.status=1 and pcat.product_id = p.product_id ";

			$sql_get_list .= " and pc.product_id=p.product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1 and  c.category_id = pcat.category_id and c.status=1  ";

			/*if(__is_location_wise_product__)
			{
				$sql_get_list .= " and p.is_sell_local  in (".__app_is_sell_local__.") ";
			}*/

			if(!empty($params['in_stock']))
			{
				$sql_get_list.=" and pis.quantity > 0 ";
			}
			$sql_get_list.=" and pis.store_id =$search2 ";
			if(!empty($search3))
				$sql_get_list.=" and p.product_id in ($search3) ";
			if(!empty($params['cat_search']))
			{
				$sql_get_list.=" and pcat.category_id in ($params[cat_search]) ";
			}
			if(!empty($params['search']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and (p.name like ('%$params[search]%') or pc.product_display_name like ('%$params[search]%') ";
				//$sql_get_list.=" or pt.content like ('%$params[search]%') ";
				//$sql_get_list.=" or p.product_tags like ('%$params[search]%') ";
				$sql_get_list.=" ) ";


			}
			if(!empty($params['trending_now']))
			{
				$sql_get_list.=" and pc.trending_now = 1 ";
			}
			if(!empty($params['hot_selling_now']))
			{
				$sql_get_list.=" and pc.hot_selling_now = 1 ";
			}
			if(!empty($params['best_sellers']))
			{
				$sql_get_list.=" and pc.best_sellers = 1 ";
			}
			if(!empty($params['new_product']))
			{
				$sql_get_list.=" and pc.new_product = 1 ";
			}
			if(!empty($params['min_price']))
			{
				$min_price = $params['min_price'];
				$sql_get_list.=" and pc.final_price >= $min_price ";
			}
			if(!empty($params['max_price']))
			{
				$max_price = $params['max_price'];
				$sql_get_list.=" and pc.final_price <= $max_price ";
			}
			if(!empty($params['is_related']))
			{
				$sql_get_list.=" and pc.product_combination_id != $params[product_combination_id] ";
				//$sql_get_list.=" and p.product_id != $params[product_id] ";
			}
			//$sql_get_list.=" group by p.product_id ";
//			new_product best_sellers hot_selling_now trending_now
			if(!empty($params['Qsearch']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['Qsearch'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					//$sql_get_list .= " pca.product_attribute_value_id = $q ";
					$sql_get_list .= " ( pca.product_attribute_value_id = $q[product_attribute_value_id] and pca.combination_value = '$q[combination_value]' ) ";


				}
				$sql_get_list .= " ) ";

			}

			if(!empty($search4))
				$sql_get_list.=" and pc.product_combination_id in ($search4) ";
			//if(!empty($orderby))
				//$sql_get_list1.=" order by FIELD(pc.product_combination_id, '$orderby') DESC ";

			if(!empty($params['order']))
			{
				$temp_currency_id = $this->session->userdata('application_sess_currency_id');
				$group = false;

				if($params['order']==1)
				{

					if(empty($temp_currency_id) || $temp_currency_id==1)
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.final_price ASC ";
					}
					else
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.other_final_price ASC ";
					}
				}
				if($params['order']==2)
				{
					if(empty($temp_currency_id) || $temp_currency_id==1)
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.final_price DESC ";
					}
					else
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.other_final_price DESC ";
					}
				}
				if($params['order']==3)
				$sql_get_list .= " group by pc.product_combination_id order by pc.trending_now DESC , pc.position ASC ";
				if($params['order']==4)
				$sql_get_list .= " group by pc.product_combination_id order by pc.hot_selling_now DESC , pc.position ASC ";
				if($params['order']==5)
				$sql_get_list .= " group by pc.product_combination_id order by pc.best_sellers DESC , pc.position ASC ";
				if($params['order']==6)
				$sql_get_list .= " group by pc.product_combination_id order by pc.new_product DESC , pc.position ASC ";
				if($params['order']==7)
				{
					if(empty($temp_currency_id) || $temp_currency_id==1)
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.discount DESC , FIELD(pis.discount_var, '%')";
					}
					else
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.other_discount DESC , FIELD(pis.other_discount_var, '%')";
					}
				}
				if($params['order']==8)
				{
					$sql_get_list .= " group by pc.product_combination_id order by pc.product_display_name ASC , pc.position ASC ";
					//$sql_get_list .= " group by pc.product_combination_id order by pc.product_combination_id ASC , pc.position ASC ";
				}
				if($params['order']==9)
				$sql_get_list .= " group by pc.product_combination_id order by pc.product_display_name DESC , pc.position ASC ";
				if($params['order']=='random')
				$sql_get_list .= " group by pc.product_combination_id order by RAND()  ";
			}
			else
			{
				$sql_get_list .= " group by pc.product_combination_id order by pc.default_combination DESC  , pc.position ASC ";
				$group = false;
			}
			/*if(empty($offset))$offset = 0;
			else $offset--;*/
			if(!empty($limit) && empty($offset))
				$sql_get_list.=" LIMIT $limit ";
			else if(!empty($offset) )
				$sql_get_list.=" LIMIT $limit OFFSET $offset ";
			//unset($sql_get_list);

				$query_get_list=$this->db->query($sql_get_list);
				//$query_get_list=$this->db->get();
				{
					//echo $sql_get_list.'<br>';
						if($query_get_list->num_rows() > 0 )
						{
								foreach($query_get_list->result() as $row_get_list)
								{
									$content_product_combination=array();
									if(!empty($row_get_list->product_id))
									{

										$this->db->select('avg(rating) as avgrating');
										$this->db->where('product_id', $row_get_list->product_id);
										$this->db->where('status', 1);
										$query_get_avgrating = $this->db->get($this->product_reviews_table_name);
										if($query_get_avgrating->num_rows() > 0 )
										{
											$row_get_avgrating = $query_get_avgrating->row();
											$avgrating = $row_get_avgrating->avgrating;
										}
									}else{$avgrating = 0;}

										$row_get_list1 = $row_get_list;
											$sql_get_list2="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";
											$all_possible_combination="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";
											//echo $all_possible_combination.'<br>';
												$query_get_list2=$this->db->query($sql_get_list2);
												{
													$combi="";
													if($query_get_list2->num_rows() > 0 )
													{
														foreach($query_get_list2->result() as $row_get_list2)
														{
															if(!empty($row_get_list2->combination_value))
																$combi .= "$row_get_list2->combination_value";
															if(!empty($row_get_list2->v_name))
																$combi .= "&nbsp;$row_get_list2->v_name";

															$combi .= ", ";
														}
													}
												}

											$product_id_for_attribute=$row_get_list->product_id;



											$attribute = $this->getAttribute(array("product_id"=>$product_id_for_attribute ));
											$combi = trim($combi , ', ');

										if(!empty($row_get_list->product_id))
										{

											$this->db->select(' count(rating) as totalrating');
											$this->db->where('product_id', $row_get_list->product_id);
											$this->db->where('rating !=0');
											$this->db->where('status', 1);
											$query_get_rating = $this->db->get($this->product_reviews_table_name);
											if($query_get_rating->num_rows() > 0 )
											{
												$row_get_rating = $query_get_rating->row();
												$totalrating = $row_get_rating->totalrating;
											}
										}else{$totalrating = 0;}

										if(!empty($row_get_list->product_id))
										{

											$this->db->select(' count(review_id) as totalreview');
											$this->db->where("status = 1");
											$this->db->where("product_id", $row_get_list->product_id);
											$query_get_review = $this->db->get($this->product_reviews_table_name);
											if($query_get_review->num_rows() > 0 )
											{
												$row_get_review = $query_get_review->row();
												$totalreview = $row_get_review->totalreview;
											}
										}else{$totalreview = 0;}

										$pg_content[]=array("product_id"=>$row_get_list->product_id,"ps_slug_url"=>$row_get_list->ps_slug_url,"short_description"=>$row_get_list->short_description,"tax_categories_name"=>$row_get_list->tax_categories_name,"tax_percentage"=>$row_get_list->tax_percentage,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"pc_ref_code"=>$row_get_list->pc_ref_code,"short_description"=>$row_get_list->short_description,"totalrating"=>$totalrating,"product_combination_id"=>$row_get_list1->product_combination_id,"product_id"=>$row_get_list1->product_id	,"ref_code"=>$row_get_list1->ref_code,"quantity"=>$row_get_list1->quantity,"price"=>$row_get_list1->price,"discount"=>$row_get_list1->discount,"discount_var"=>$row_get_list1->discount_var,"final_price"=>$row_get_list1->final_price,"status"=>$row_get_list1->status,"added_on"=>$row_get_list1->added_on,"updated_on"=>$row_get_list1->updated_on,"product_image_id"=>$row_get_list1->product_image_id,"default_combination"=>$row_get_list1->default_combination,"comb_slug_url"=>$row_get_list1->comb_slug_url,"product_image_name"=>$row_get_list1->product_image_name,"combi"=>$combi , "product_in_store_id"=>$row_get_list1->product_in_store_id, "prod_in_wishList" => $row_get_list1->prod_in_wishList, "prod_in_cart"=>$row_get_list1->prod_in_cart, "quantity_per_order"=>$row_get_list1->quantity_per_order, "stock_out_msg"=>$row_get_list1->stock_out_msg, "product_weight"=>$row_get_list1->product_weight, "product_dimension"=>$row_get_list1->product_dimension ,"attribute"=>$attribute,"trending_now"=>$row_get_list1->trending_now,"hot_selling_now"=>$row_get_list1->hot_selling_now,"best_sellers"=>$row_get_list1->best_sellers,"new_product"=>$row_get_list1->new_product,"product_display_name"=>$row_get_list1->product_display_name,"delivery_charges"=>$row_get_list1->delivery_charges,"totalreview"=>$totalreview,"avgrating"=>$avgrating,"other_price"=>$row_get_list1->other_price,"other_final_price"=>$row_get_list1->other_final_price,"other_discount"=>$row_get_list1->other_discount,"other_discount_var"=>$row_get_list1->other_discount_var);


								}
						}
				}

			return $pg_content;
		}

		if($category == 'products_list_group')
		{
			$sql_get_list="select p.product_id , p.brand_id , p.short_description , p.name , p.ref_code , m.brand_name , (select tc.tax_name from tax as tc where p.tax_id = tc.tax_id) as tax_categories_name , (select tp.tax_percentage from tax as tp where p.tax_id = tp.tax_id) as tax_providers_percentage from product p , product_in_store as pis, brand_master as m, product_category as pc,  category as c where m.brand_id=p.brand_id and m.status=1 and p.status=1 and pis.product_id=p.product_id and pis.store_id=$search2 and pis.status=1 and pc.product_id = p.product_id and  c.category_id = pc.category_id and c.status=1 ";

			/*if(__is_location_wise_product__)
			{
				$sql_get_list .= " and p.is_sell_local  in (".__app_is_sell_local__.") ";
			}*/

			if(!empty($search3))
				$sql_get_list.=" and p.product_id in ($search3) ";
			if(!empty($params['cat_search']))
			{
				$sql_get_list.=" and pc.category_id in ($params[cat_search]) ";
			}
			if(!empty($params['search']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and p.name like ('%$params[search]%') ";
			}
			$sql_get_list.=" group by p.product_id ";
			if(!empty($params['order']))
			{
				$group = false;
				$temp_currency_id = $this->session->userdata('application_sess_currency_id');
				if(empty($temp_currency_id) || $temp_currency_id==1)
				{
					if($params['order']==1)
					$sql_get_list .= " order by pis.final_price ASC ";
					if($params['order']==2)
					$sql_get_list .= " order by pis.final_price DESC ";
				}
				else
				{
					if($params['order']==1)
					$sql_get_list .= " order by pis.other_final_price ASC ";
					if($params['order']==2)
					$sql_get_list .= " order by pis.other_final_price DESC ";
				}
			}


			if(!empty($limit) && empty($offset))
				$sql_get_list.=" LIMIT $limit ";
			if(!empty($offset))
				$sql_get_list.=" LIMIT $limit OFFSET $offset ";


				$query_get_list=$this->db->query($sql_get_list);
				{
					//echo $sql_get_list.'<br>';
						if($query_get_list->num_rows() > 0 )
						{
								foreach($query_get_list->result() as $row_get_list)
								{
									$content_product_combination=array();
								//$sql_get_list1="select pis.* , pc.default_combination , pc.comb_slug_url , pc.product_image_id , pc.ref_code , pc.product_weight , pc.product_dimension , pi.product_image_name , (select tc.quantity from temp_cart as tc where tc.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_cart ,  (select count(tw.temp_wishlist_id) from temp_wishlist as tw where tw.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_wishList ";
								//$sql_get_list1.=" from product_combination as pc , product_image as pi , product_in_store as pis  ";
								//$sql_get_list1.=" where pc.product_id=$row_get_list->product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1 ";
								//$sql_get_list1.=" and pis.store_id =$search2 ";

								$sql_get_list1 = "select DISTINCT(pc.product_combination_id), pis.* , pc.default_combination , pc.product_display_name , pc.model_number , pc.current_viewers_msg , pc.current_sold_msg , pc.is_msg_dynamic , pc.delivery_charges ,pc.product_combination_id , pc.comb_slug_url , pc.product_image_id , pc.ref_code , pc.product_weight , pc.product_dimension , pi.product_image_name , (select ps.slug_url from product_seo as ps where ps.product_id = pc.product_id and ps.product_combination_id = pc.product_combination_id  limit 1) as ps_slug_url , (select tc.quantity from temp_cart as tc where tc.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_cart , (select tc.comment from temp_cart as tc where tc.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_comment , (select tc.comment from temp_cart as tc where tc.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as cart_comment , (select count(tw.temp_wishlist_id) from temp_wishlist as tw where tw.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_wishList ";
						$sql_get_list1 .= " from product_combination as pc JOIN product_combination_attribute as pca ON pca.product_combination_id=pc.product_combination_id  , product_image as pi , product_in_store as pis
						";
						$sql_get_list1 .= " where pc.product_id=$row_get_list->product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1  ";
						$sql_get_list1.=" and pis.store_id =$search2 ";

								if(!empty($params['Qsearch']))
								{
									$qcount=0;
									$sql_get_list1 .= " and ( ";
									foreach($params['Qsearch'] as $q){$qcount++;
										if($qcount>1)
										$sql_get_list1 .= " or ";
										//$sql_get_list1 .= " pca.product_attribute_value_id = $q ";
										$sql_get_list .= " ( pca.product_attribute_value_id = $q[product_attribute_value_id] and pca.combination_value = '$q[combination_value]' ) ";
									}
									$sql_get_list1 .= " ) ";

								}

								if(!empty($params['trending_now']))
								{
									$sql_get_list.=" and pc.trending_now = 1 ";
								}
								if(!empty($params['hot_selling_now']))
								{
									$sql_get_list.=" and pc.hot_selling_now = 1 ";
								}
								if(!empty($params['best_sellers']))
								{
									$sql_get_list.=" and pc.best_sellers = 1 ";
								}
								if(!empty($params['new_product']))
								{
									$sql_get_list.=" and pc.new_product = 1 ";
								}

								if(!empty($search4))
									$sql_get_list1.=" and pc.product_combination_id in ($search4) ";
								//if(!empty($orderby))
									//$sql_get_list1.=" order by FIELD(pc.product_combination_id, '$orderby') DESC ";

								else
								if(!empty($params['order']))
								{
									$group = false;
									$temp_currency_id = $this->session->userdata('application_sess_currency_id');
									if(empty($temp_currency_id) || $temp_currency_id==1)
									{
										if($params['order']==1)
										$sql_get_list1 .= " group by pc.product_combination_id order by pis.final_price ASC ";
										if($params['order']==2)
										$sql_get_list1 .= " group by pc.product_combination_id order by pis.final_price DESC ";
									}
									else
									{
										if($params['order']==1)
										$sql_get_list1 .= " group by pc.product_combination_id order by pis.other_final_price ASC ";
										if($params['order']==2)
										$sql_get_list1 .= " group by pc.product_combination_id order by pis.other_final_price DESC ";
									}
								}
								else
								{
									$sql_get_list1 .= " group by pc.product_combination_id order by pc.default_combination DESC ";
									$group = false;
								}
								//else
								//$sql_get_list1.=" order by pc.default_combination DESC ";
								//echo "<br>".$sql_get_list1."<br>";
								$query_get_list1=$this->db->query($sql_get_list1);
									if($query_get_list1->num_rows() > 0 )
									{
										foreach($query_get_list1->result() as $row_get_list1)
										{
											$sql_get_list2="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";
											$all_possible_combination="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";
											//echo $all_possible_combination.'<br>';
												$query_get_list2=$this->db->query($sql_get_list2);
												{
													$combi="";
													if($query_get_list2->num_rows() > 0 )
													{
														foreach($query_get_list2->result() as $row_get_list2)
														{
															if(!empty($row_get_list2->combination_value))
																$combi .= "$row_get_list2->combination_value";
															if(!empty($row_get_list2->v_name))
																$combi .= "&nbsp;$row_get_list2->v_name";

															$combi .= ", ";
														}
													}
												}

											$product_id_for_attribute=$row_get_list->product_id;

											/*if(!empty($search2))
												if($search2>1)
												$product_id_for_attribute = $search2;
											else if(!empty($row_get_list->product_id))
												$product_id_for_attribute = $row_get_list->product_id;*/

											$attribute = $this->getAttribute(array("product_id"=>$product_id_for_attribute ));
											$combi = trim($combi , ', ');


											$content_product_combination[]=array("product_combination_id"=>$row_get_list1->product_combination_id,"product_display_name"=>$row_get_list1->product_display_name,"model_number"=>$row_get_list1->model_number,"delivery_charges"=>$row_get_list1->delivery_charges,"current_viewers_msg"=>$row_get_list1->current_viewers_msg,"current_sold_msg"=>$row_get_list1->current_sold_msg,"is_msg_dynamic"=>$row_get_list1->is_msg_dynamic,"product_id"=>$row_get_list1->product_id	,"ref_code"=>$row_get_list1->ref_code,"quantity"=>$row_get_list1->quantity,"price"=>$row_get_list1->price,"discount"=>$row_get_list1->discount,"discount_var"=>$row_get_list1->discount_var,"final_price"=>$row_get_list1->final_price,"status"=>$row_get_list1->status,"added_on"=>$row_get_list1->added_on,"updated_on"=>$row_get_list1->updated_on,"product_image_id"=>$row_get_list1->product_image_id,"default_combination"=>$row_get_list1->default_combination,"comb_slug_url"=>$row_get_list1->comb_slug_url,"product_image_name"=>$row_get_list1->product_image_name,"combi"=>$combi , "product_in_store_id"=>$row_get_list1->product_in_store_id, "prod_in_wishList" => $row_get_list1->prod_in_wishList, "prod_in_cart"=>$row_get_list1->prod_in_cart, "prod_comment"=>$row_get_list1->prod_comment, "cart_comment"=>$row_get_list1->cart_comment, "quantity_per_order"=>$row_get_list1->quantity_per_order, "stock_out_msg"=>$row_get_list1->stock_out_msg, "product_weight"=>$row_get_list1->product_weight, "ps_slug_url"=>$row_get_list1->ps_slug_url, "product_dimension"=>$row_get_list1->product_dimension ,"attribute"=>$attribute,"other_price"=>$row_get_list1->other_price,"other_final_price"=>$row_get_list1->other_final_price,"other_discount"=>$row_get_list1->other_discount,"other_discount_var"=>$row_get_list1->other_discount_var);
										}

										if(!empty($row_get_list->product_id))
										{

											$this->db->select(' count(rating) as totalrating');
											$this->db->where('product_id', $row_get_list->product_id);
											$this->db->where('rating !=0');
											$this->db->where('status', 1);
											$query_get_rating = $this->db->get($this->product_reviews_table_name);
											if($query_get_rating->num_rows() > 0 )
											{
												$row_get_rating = $query_get_rating->row();
												$totalrating = $row_get_rating->totalrating;
											}
										}else{$totalrating = 0;}

										if(!empty($row_get_list->product_id))
										{

											$this->db->select(' count(review_id) as totalreview');
											$this->db->where("status = 1");
											$this->db->where("product_id", $id);
											$this->db->where('status', 1);
											$query_get_review = $this->db->get($this->product_reviews_table_name);
											if($query_get_review->num_rows() > 0 )
											{
												$row_get_review = $query_get_review->row();
												$totalreview = $row_get_review->totalreview;
											}
										}else{$totalreview = 0;}
										$row_get_list->tax_percentage = $row_get_list->tax_providers_percentage;
										$row_get_list->tax_name = $row_get_list->tax_categories_name ;

										if(empty($row_get_list->tax_name)){ $row_get_list->tax_name = ''; }
										if(empty($row_get_list->tax_percentage)){ $row_get_list->tax_percentage = 0; }
										if(empty($row_get_list->slug_url)){ $row_get_list->slug_url = ''; }
										$pg_content[]=array("product_id"=>$row_get_list->product_id,"brand_id"=>$row_get_list->brand_id,"short_description"=>$row_get_list->short_description,"tax_name"=>$row_get_list->tax_name,"tax_percentage"=>$row_get_list->tax_percentage,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"slug_url"=>$row_get_list->slug_url,"short_description"=>$row_get_list->short_description,"brand_name"=>$row_get_list->brand_name,"product_combination"=>$content_product_combination,"totalrating"=>$totalrating,"totalreview"=>$totalreview);

									}
								}
						}
				}

			return $pg_content;
		}

		 if($category == 'product_detail')
		{
			$sql_get_list="select p.* , (select Un.login_id from ks_login_detail as Un where p.updated_by != 0 and p.updated_by = Un.user_id) as updated_by_name , (select Un.login_id from ks_login_detail as Un where p.added_by != 0 and p.added_by = Un.user_id) as added_by_name from product p where 1  ";
			if(!empty($id)){
				$sql_get_list.= " and p.product_id=$id ";
			}
			$query_get_list=$this->db->query($sql_get_list);
			{
				if($query_get_list->num_rows() > 0 )
				{
					foreach($query_get_list->result() as $row_get_list)
					{
						$pg_content[]=array("product_id"=>$row_get_list->product_id,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"slug_url"=>$row_get_list->slug_url,"short_description"=>$row_get_list->short_description,"description"=>$row_get_list->description,"how_to_use"=>$row_get_list->how_to_use,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"added_by"=>$row_get_list->added_by,"updated_by"=>$row_get_list->updated_by,"status"=>$row_get_list->status,"updated_by_name"=>$row_get_list->updated_by_name,"added_by_name"=>$row_get_list->added_by_name);
					}
				}
		    }
			return $pg_content;
		}

		if($category == 'product_category_detail')
		{
			$sql_get_list="select * from product_category where product_id=$id ";
			$query_get_list=$this->db->query($sql_get_list);
			{
				if($query_get_list->num_rows() > 0 )
				{
					foreach($query_get_list->result() as $row_get_list)
					{
						$pg_content[]=array("product_category_id"=>$row_get_list->product_category_id,"product_id"=>$row_get_list->product_id	,"category_id"=>$row_get_list->category_id);
					}
				}
		    }
			return $pg_content;
		}

		if($category == 'product_image_detail')
		{
			$sql_get_list="select * from product_image where product_id=$id order by position ASC";
			$query_get_list=$this->db->query($sql_get_list);
			{
				if($query_get_list->num_rows() > 0 )
				{
					foreach($query_get_list->result() as $row_get_list)
					{
						$pg_content[]=array("product_image_id"=>$row_get_list->product_image_id,"product_id"=>$row_get_list->product_id	,"product_image_name"=>$row_get_list->product_image_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"default_image"=>$row_get_list->default_image,"position"=>$row_get_list->position);
					}
				}
		    }
			return $pg_content;
		}

		if($category == 'product_combination_detail')
		{
			$sql_get_list="select * from product_combination where product_id=$id ";
			$query_get_list=$this->db->query($sql_get_list);
			{
				if($query_get_list->num_rows() > 0 )
				{
					foreach($query_get_list->result() as $row_get_list)
					{
						$pg_content[]=array("product_combination_id"=>$row_get_list->product_combination_id,"product_id"=>$row_get_list->product_id	,"ref_code"=>$row_get_list->ref_code,"quantity"=>$row_get_list->quantity,"price"=>$row_get_list->price,"discount"=>$row_get_list->discount,"discount_var"=>$row_get_list->discount_var,"final_price"=>$row_get_list->final_price,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"product_image_id"=>$row_get_list->product_image_id,"default_combination"=>$row_get_list->default_combination,"comb_slug_url"=>$row_get_list->comb_slug_url,"other_price"=>$row_get_list->other_price,"other_final_price"=>$row_get_list->other_final_price,"other_discount"=>$row_get_list->other_discount,"other_discount_var"=>$row_get_list->other_discount_var);
					}
				}
		    }
			return $pg_content;
		}

		if($category == 'product_combination_attribute_detail')
		{
			$sql_get_list="select * from product_combination_attribute where product_id=$id ";
			$query_get_list=$this->db->query($sql_get_list);
			{
				if($query_get_list->num_rows() > 0 )
				{
					foreach($query_get_list->result() as $row_get_list)
					{
						$pg_content[]=array("product_combination_attribute_id"=>$row_get_list->product_combination_attribute_id,"product_id"=>$row_get_list->product_id	,"product_combination_id"=>$row_get_list->product_combination_id,"product_attribute_id"=>$row_get_list->product_attribute_id,"product_attribute_value_id"=>$row_get_list->product_attribute_value_id,"combination_value"=>$row_get_list->combination_value);
					}
				}
		    }
			return $pg_content;
		}

		if($category == 'products_list_google')
		{
			$sql_get_list="select DISTINCT(pc.product_combination_id),pis.* , pc.product_display_name , pc.delivery_charges , pc.trending_now , pc.hot_selling_now , pc.best_sellers , pc.new_product , pc.default_combination , pc.product_combination_id , pc.comb_slug_url , pc.product_image_id, pc.gtin , pc.ref_code as pc_ref_code , pc.product_weight , pc.product_dimension , pi.product_image_name, bm.brand_name , (select tc.quantity from temp_cart as tc where tc.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_cart , (select count(tw.temp_wishlist_id) from temp_wishlist as tw where tw.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_wishList, p.product_id , p.short_description , p.name , p.ref_code , p.short_description, (select tc.tax_name from tax as tc where p.tax_id = tc.tax_id limit 1) as tax_categories_name , (select tp.tax_percentage from tax as tp where p.tax_id = tp.tax_id limit 1) as tax_percentage , (select ps.slug_url from product_seo as ps where ps.product_id = p.product_id and  ps.product_combination_id = pc.product_combination_id limit 1) as ps_slug_url  ";

			$sql_get_list .= " from product p  , ";

			//$sql_get_list .= "  left join product_tag_value as ptv ON p.product_id = ptv.product_id left join product_tag as pt on pt.product_tag_id = ptv.product_tag_id , ";

			$sql_get_list .= "  product_in_store as pis, product_category as pcat, product_combination as pc JOIN product_combination_attribute as pca ON pca.product_combination_id=pc.product_combination_id  , product_image as pi   ";

			$sql_get_list .= " ,  category as c ";

			//$sql_get_list .= " ";


			$sql_get_list .= "   , brand_master as bm where bm.brand_id=p.brand_id and p.status=1 and pis.product_id=p.product_id and pis.store_id=$search2 and pis.status=1 and pcat.product_id = p.product_id ";

			$sql_get_list .= " and pc.product_id=p.product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1 and  c.category_id = pcat.category_id and c.status=1  ";

			/*if(__is_location_wise_product__)
			{
				$sql_get_list .= " and p.is_sell_local  in (".__app_is_sell_local__.") ";
			}*/

			if(!empty($params['in_stock']))
			{
				$sql_get_list.=" and pis.quantity > 0 ";
			}
			$sql_get_list.=" and pis.store_id =$search2 ";
			if(!empty($search3))
				$sql_get_list.=" and p.product_id in ($search3) ";
			if(!empty($params['cat_search']))
			{
				$sql_get_list.=" and pcat.category_id in ($params[cat_search]) ";
			}
			if(!empty($params['search']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and (p.name like ('%$params[search]%') or pc.product_display_name like ('%$params[search]%') ";
				//$sql_get_list.=" or pt.content like ('%$params[search]%') ";
				//$sql_get_list.=" or p.product_tags like ('%$params[search]%') ";
				$sql_get_list.=" ) ";


			}

			if(!empty($params['is_google_product']))
			{
				$sql_get_list.=" and p.is_google_product = 1 ";
			}

			if(!empty($params['trending_now']))
			{
				$sql_get_list.=" and pc.trending_now = 1 ";
			}
			if(!empty($params['hot_selling_now']))
			{
				$sql_get_list.=" and pc.hot_selling_now = 1 ";
			}
			if(!empty($params['best_sellers']))
			{
				$sql_get_list.=" and pc.best_sellers = 1 ";
			}
			if(!empty($params['new_product']))
			{
				$sql_get_list.=" and pc.new_product = 1 ";
			}
			if(!empty($params['min_price']))
			{
				$min_price = $params['min_price'];
				$sql_get_list.=" and pc.final_price >= $min_price ";
			}
			if(!empty($params['max_price']))
			{
				$max_price = $params['max_price'];
				$sql_get_list.=" and pc.final_price <= $max_price ";
			}
			if(!empty($params['is_related']))
			{
				$sql_get_list.=" and pc.product_combination_id != $params[product_combination_id] ";
				//$sql_get_list.=" and p.product_id != $params[product_id] ";
			}
			//$sql_get_list.=" group by p.product_id ";
//			new_product best_sellers hot_selling_now trending_now
			if(!empty($params['Qsearch']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['Qsearch'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					//$sql_get_list .= " pca.product_attribute_value_id = $q ";
					$sql_get_list .= " ( pca.product_attribute_value_id = $q[product_attribute_value_id] and pca.combination_value = '$q[combination_value]' ) ";


				}
				$sql_get_list .= " ) ";

			}

			if(!empty($search4))
				$sql_get_list.=" and pc.product_combination_id in ($search4) ";
			//if(!empty($orderby))
				//$sql_get_list1.=" order by FIELD(pc.product_combination_id, '$orderby') DESC ";

			if(!empty($params['order']))
			{
				$temp_currency_id = $this->session->userdata('application_sess_currency_id');
				$group = false;

				if($params['order']==1)
				{

					if(empty($temp_currency_id) || $temp_currency_id==1)
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.final_price ASC ";
					}
					else
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.other_final_price ASC ";
					}
				}
				if($params['order']==2)
				{
					if(empty($temp_currency_id) || $temp_currency_id==1)
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.final_price DESC ";
					}
					else
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.other_final_price DESC ";
					}
				}
				if($params['order']==3)
				$sql_get_list .= " group by pc.product_combination_id order by pc.trending_now DESC , pc.position ASC ";
				if($params['order']==4)
				$sql_get_list .= " group by pc.product_combination_id order by pc.hot_selling_now DESC , pc.position ASC ";
				if($params['order']==5)
				$sql_get_list .= " group by pc.product_combination_id order by pc.best_sellers DESC , pc.position ASC ";
				if($params['order']==6)
				$sql_get_list .= " group by pc.product_combination_id order by pc.new_product DESC , pc.position ASC ";
				if($params['order']==7)
				{
					if(empty($temp_currency_id) || $temp_currency_id==1)
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.discount DESC , FIELD(pis.discount_var, '%')";
					}
					else
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.other_discount DESC , FIELD(pis.other_discount_var, '%')";
					}
				}
				if($params['order']==8)
				{
					$sql_get_list .= " group by pc.product_combination_id order by pc.product_display_name ASC , pc.position ASC ";
					//$sql_get_list .= " group by pc.product_combination_id order by pc.product_combination_id ASC , pc.position ASC ";
				}
				if($params['order']==9)
				$sql_get_list .= " group by pc.product_combination_id order by pc.product_display_name DESC , pc.position ASC ";
				if($params['order']=='random')
				$sql_get_list .= " group by pc.product_combination_id order by RAND()  ";
			}
			else
			{
				$sql_get_list .= " group by pc.product_combination_id order by pc.default_combination DESC  , pc.position ASC ";
				$group = false;
			}
			/*if(empty($offset))$offset = 0;
			else $offset--;*/
			if(!empty($limit) && empty($offset))
				$sql_get_list.=" LIMIT $limit ";
			else if(!empty($offset) )
				$sql_get_list.=" LIMIT $limit OFFSET $offset ";
			//unset($sql_get_list);
			//echo $sql_get_list.'<br><br><br>';
				$query_get_list=$this->db->query($sql_get_list);
				//$query_get_list=$this->db->get();
				{
					//echo $sql_get_list.'<br>';
						if($query_get_list->num_rows() > 0 )
						{
								foreach($query_get_list->result() as $row_get_list)
								{
									$content_product_combination=array();
									if(!empty($row_get_list->product_id))
									{

										$this->db->select('avg(rating) as avgrating');
										$this->db->where('product_id', $row_get_list->product_id);
										$this->db->where('status', 1);
										$query_get_avgrating = $this->db->get($this->product_reviews_table_name);
										if($query_get_avgrating->num_rows() > 0 )
										{
											$row_get_avgrating = $query_get_avgrating->row();
											$avgrating = $row_get_avgrating->avgrating;
										}
									}else{$avgrating = 0;}

										$row_get_list1 = $row_get_list;
											$sql_get_list2="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";
											$all_possible_combination="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";
											//echo $all_possible_combination.'<br>';
												$query_get_list2=$this->db->query($sql_get_list2);
												{
													$combi="";
													if($query_get_list2->num_rows() > 0 )
													{
														foreach($query_get_list2->result() as $row_get_list2)
														{
															if(!empty($row_get_list2->combination_value))
																$combi .= "$row_get_list2->combination_value";
															if(!empty($row_get_list2->v_name))
																$combi .= "&nbsp;$row_get_list2->v_name";

															$combi .= ", ";
														}
													}
												}

											$product_id_for_attribute=$row_get_list->product_id;



											$attribute = $this->getAttribute(array("product_id"=>$product_id_for_attribute ));
											$combi = trim($combi , ', ');

										if(!empty($row_get_list->product_id))
										{

											$this->db->select(' count(rating) as totalrating');
											$this->db->where('product_id', $row_get_list->product_id);
											$this->db->where('rating !=0');
											$this->db->where('status', 1);
											$query_get_rating = $this->db->get($this->product_reviews_table_name);
											if($query_get_rating->num_rows() > 0 )
											{
												$row_get_rating = $query_get_rating->row();
												$totalrating = $row_get_rating->totalrating;
											}
										}else{$totalrating = 0;}

										if(!empty($row_get_list->product_id))
										{

											$this->db->select(' count(review_id) as totalreview');
											$this->db->where("status = 1");
											$this->db->where("product_id", $row_get_list->product_id);
											$query_get_review = $this->db->get($this->product_reviews_table_name);
											if($query_get_review->num_rows() > 0 )
											{
												$row_get_review = $query_get_review->row();
												$totalreview = $row_get_review->totalreview;
											}
										}else{$totalreview = 0;}

										$pg_content[]=array("product_id"=>$row_get_list->product_id,"ps_slug_url"=>$row_get_list->ps_slug_url,"short_description"=>$row_get_list->short_description,"tax_categories_name"=>$row_get_list->tax_categories_name,"tax_percentage"=>$row_get_list->tax_percentage,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"pc_ref_code"=>$row_get_list->pc_ref_code,"short_description"=>$row_get_list->short_description,"brand_name"=>$row_get_list->brand_name,"totalrating"=>$totalrating,"product_combination_id"=>$row_get_list1->product_combination_id,"product_id"=>$row_get_list1->product_id	,"ref_code"=>$row_get_list1->ref_code,"quantity"=>$row_get_list1->quantity,"price"=>$row_get_list1->price,"discount"=>$row_get_list1->discount,"discount_var"=>$row_get_list1->discount_var,"final_price"=>$row_get_list1->final_price,"status"=>$row_get_list1->status,"added_on"=>$row_get_list1->added_on,"updated_on"=>$row_get_list1->updated_on,"product_image_id"=>$row_get_list1->product_image_id,"gtin"=>$row_get_list1->gtin,"default_combination"=>$row_get_list1->default_combination,"comb_slug_url"=>$row_get_list1->comb_slug_url,"product_image_name"=>$row_get_list1->product_image_name,"combi"=>$combi , "product_in_store_id"=>$row_get_list1->product_in_store_id, "prod_in_wishList" => $row_get_list1->prod_in_wishList, "prod_in_cart"=>$row_get_list1->prod_in_cart, "quantity_per_order"=>$row_get_list1->quantity_per_order, "stock_out_msg"=>$row_get_list1->stock_out_msg, "product_weight"=>$row_get_list1->product_weight, "product_dimension"=>$row_get_list1->product_dimension ,"attribute"=>$attribute,"trending_now"=>$row_get_list1->trending_now,"hot_selling_now"=>$row_get_list1->hot_selling_now,"best_sellers"=>$row_get_list1->best_sellers,"new_product"=>$row_get_list1->new_product,"product_display_name"=>$row_get_list1->product_display_name,"delivery_charges"=>$row_get_list1->delivery_charges,"totalreview"=>$totalreview,"avgrating"=>$avgrating,"other_price"=>$row_get_list1->other_price,"other_final_price"=>$row_get_list1->other_final_price,"other_discount"=>$row_get_list1->other_discount,"other_discount_var"=>$row_get_list1->other_discount_var);


								}
						}
				}

			return $pg_content;
		}
	}

	function productsDetails($category, $id, $status='', $search1='', $search2='', $search3='', $search4='', $search5='', $search6='' , $limit='' , $offset='' , $orderby='')
	{
		$pg_content = array();

		if($category == 'products_list')
		{
			$sql_get_list="select p.*, bm.brand_name from product p ,  brand_master as bm, category as c,  product_category as pcat where p.brand_id = bm.brand_id and p.status=1 and  p.product_id = pcat.product_id and  c.category_id = pcat.category_id and c.status=1";

			if(!empty($search3))
				$sql_get_list.=" and p.product_id in ($search3) ";

			if(!empty($limit))
				$sql_get_list.=" LIMIT $limit ";
			if(!empty($offset))
				$sql_get_list.=" , $offset ";
				$query_get_list=$this->db->query($sql_get_list);
				{
						if($query_get_list->num_rows() > 0 )
						{
								foreach($query_get_list->result() as $row_get_list)
								{

									$product_use_info_value_arr = array();
									/*$this->db
									->select('pui.* , puiv.*')
									->from('product_use_info_value as puiv')
									->join('product_use_info as pui' , 'pui.product_use_info_id = puiv.product_use_info_id')
									->where('puiv.product_id' , $row_get_list->product_id)
									->where('pui.status' , 1);
									$product_use_info_value_arr = $this->db->get()->result();*/

									$content_product_combination=array();
								$sql_get_list1="select pis.* , pc.default_combination ,pc.product_display_name , pc.model_number , pc.delivery_charges , pc.current_sold_msg ,pc.product_weight, pc.current_viewers_msg , pc.is_msg_dynamic , pc.comb_slug_url , pc.product_image_id , pc.ref_code, pc.product_l, pc.product_b, pc.product_h , pi.product_image_name , (select tc.quantity from temp_cart as tc where tc.product_in_store_id=pis.product_in_store_id and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_cart , (select count(tw.temp_wishlist_id) from temp_wishlist as tw where tw.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_wishList ,  (select ps.slug_url from product_seo as ps where ps.product_id = pc.product_id and  ps.product_combination_id = pc.product_combination_id limit 1) as ps_slug_url";
								$sql_get_list1.=" from product_combination as pc , product_image as pi , product_in_store as pis  ";
								$sql_get_list1.=" where pc.product_id=$row_get_list->product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1 ";
								$sql_get_list1.=" and pis.store_id =1 ";
								if(!empty($search4))
									$sql_get_list1.=" and pc.product_combination_id in ($search4) ";
								if(!empty($orderby))
								{
									//$sql_get_list1.=" order by FIELD(pc.product_combination_id, '$orderby') DESC ";
									//$sql_get_list1.=" order by pc.position ASC ";
									$sql_get_list1.=" order by pc.position ASC ";
								}
								else
								{
								$sql_get_list1.=" order by pc.position ASC ";
								//$sql_get_list1.=" order by pc.default_combination DESC ";
								}
								//echo $sql_get_list1;
								$query_get_list1=$this->db->query($sql_get_list1);
								$content_product_combination_attribute=array();
									if($query_get_list1->num_rows() > 0 )
									{
										foreach($query_get_list1->result() as $row_get_list1)
										{
											$sql_get_list2="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";
											//echo $sql_get_list2;



												$query_get_list2=$this->db->query($sql_get_list2);
												{
													$combi="";
													if($query_get_list2->num_rows() > 0 )
													{
														foreach($query_get_list2->result() as $row_get_list2)
														{
															if(!empty($row_get_list2->combination_value))
																$combi .= "$row_get_list2->combination_value";
															/*if(!empty($row_get_list2->a_name))
																$combi .= "&nbsp;$row_get_list2->a_name";*/
															if(!empty($row_get_list2->v_name))
																$combi .= "&nbsp;$row_get_list2->v_name";

															$combi .= ", ";
															$content_product_combination_attribute[]=array("a_name"=>$row_get_list2->a_name,"v_name"=>$row_get_list2->v_name);
														}
													}
												}


											$combi = trim($combi , ', ');


											$content_product_combination[]=array("product_combination_id"=>$row_get_list1->product_combination_id,"product_id"=>$row_get_list1->product_id	,"ref_code"=>$row_get_list1->ref_code,"product_l"=>$row_get_list1->product_l,"product_b"=>$row_get_list1->product_b,"product_h"=>$row_get_list1->product_h,"quantity"=>$row_get_list1->quantity,"price"=>$row_get_list1->price,"discount"=>$row_get_list1->discount,"discount_var"=>$row_get_list1->discount_var,"final_price"=>$row_get_list1->final_price,'product_weight'=>$row_get_list1->product_weight,"status"=>$row_get_list1->status,"added_on"=>$row_get_list1->added_on,"updated_on"=>$row_get_list1->updated_on,"product_image_id"=>$row_get_list1->product_image_id,"default_combination"=>$row_get_list1->default_combination,"comb_slug_url"=>$row_get_list1->comb_slug_url,"product_image_name"=>$row_get_list1->product_image_name,"combi"=>$combi , "product_in_store_id"=>$row_get_list1->product_in_store_id, "prod_in_wishList" => $row_get_list1->prod_in_wishList, "prod_in_cart"=>$row_get_list1->prod_in_cart, "quantity_per_order"=>$row_get_list1->quantity_per_order, "product_display_name"=>$row_get_list1->product_display_name,"model_number"=>$row_get_list1->model_number,"delivery_charges"=>$row_get_list1->delivery_charges,"stock_out_msg"=>$row_get_list1->stock_out_msg,"current_viewers_msg"=>$row_get_list1->current_viewers_msg,"current_sold_msg"=>$row_get_list1->current_sold_msg,"is_msg_dynamic"=>$row_get_list1->is_msg_dynamic,"other_price"=>$row_get_list1->other_price,"other_final_price"=>$row_get_list1->other_final_price,"other_discount"=>$row_get_list1->other_discount,"other_discount_var"=>$row_get_list1->other_discount_var,"ps_slug_url"=>$row_get_list1->ps_slug_url);
										}

										$totalrating=0;$totalreview=0; $avgrating=0; $onerating=0; $tworating=0; $threerating=0; $fourrating=0; $fiverating=0;
					if(!empty($row_get_list->product_id))
					{

						$this->db->select('avg(rating) as avgrating');
						$this->db->where('product_id', $row_get_list->product_id);
						$this->db->where('status', 1);
						$query_get_avgrating = $this->db->get($this->product_reviews_table_name);
						if($query_get_avgrating->num_rows() > 0 )
						{
							$row_get_avgrating = $query_get_avgrating->row();
							$avgrating = $row_get_avgrating->avgrating;
						}
					}else{$avgrating = 0;}

					if(!empty($row_get_list->product_id))
					{

						$this->db->select(' count(rating) as onerating');
						$this->db->where('product_id', $row_get_list->product_id);
						$this->db->where('rating = 1');
						$this->db->where('status', 1);
						$query_get_onerating = $this->db->get($this->product_reviews_table_name);
						if($query_get_onerating->num_rows() > 0 )
						{
							$row_get_onerating = $query_get_onerating->row();
							$onerating = $row_get_onerating->onerating;
						}
					}else{$onerating = 0;}

					if(!empty($row_get_list->product_id))
					{

						$this->db->select(' count(rating) as tworating');
						$this->db->where('product_id', $row_get_list->product_id);
						$this->db->where('rating = 2');
						$this->db->where('status', 1);
						$query_get_tworating = $this->db->get($this->product_reviews_table_name);
						if($query_get_tworating->num_rows() > 0 )
						{
							$row_get_tworating = $query_get_tworating->row();
							$tworating = $row_get_tworating->tworating;
						}
					}else{$tworating = 0;}

					if(!empty($row_get_list->product_id))
					{

						$this->db->select(' count(rating) as threerating');
						$this->db->where('product_id', $row_get_list->product_id);
						$this->db->where('rating = 3');
						$this->db->where('status', 1);
						$query_get_threerating = $this->db->get($this->product_reviews_table_name);
						if($query_get_threerating->num_rows() > 0 )
						{
							$row_get_threerating = $query_get_threerating->row();
							$threerating = $row_get_threerating->threerating;
						}
					}else{$threerating = 0;}

					if(!empty($row_get_list->product_id))
					{

						$this->db->select(' count(rating) as fourrating');
						$this->db->where('product_id', $row_get_list->product_id);
						$this->db->where('rating = 4');
						$this->db->where('status', 1);
						$query_get_fourrating = $this->db->get($this->product_reviews_table_name);
						if($query_get_fourrating->num_rows() > 0 )
						{
							$row_get_fourrating = $query_get_fourrating->row();
							$fourrating = $row_get_fourrating->fourrating;
						}
					}else{$fourrating = 0;}

					if(!empty($row_get_list->product_id))
					{

						$this->db->select(' count(rating) as fiverating');
						$this->db->where('product_id', $row_get_list->product_id);
						$this->db->where('rating = 5');
						$this->db->where('status', 1);
						$query_get_fiverating = $this->db->get($this->product_reviews_table_name);
						if($query_get_fiverating->num_rows() > 0 )
						{
							$row_get_fiverating = $query_get_fiverating->row();
							$fiverating = $row_get_fiverating->fiverating;
						}
					}else{$fiverating = 0;}

					if(!empty($row_get_list->product_id))
					{

						$this->db->select(' count(rating) as totalrating');
						$this->db->where('product_id', $row_get_list->product_id);
						$this->db->where('rating !=0');
						$this->db->where('status', 1);
						$query_get_rating = $this->db->get($this->product_reviews_table_name);
						if($query_get_rating->num_rows() > 0 )
						{
							$row_get_rating = $query_get_rating->row();
							$totalrating = $row_get_rating->totalrating;
						}
					}else{$totalrating = 0;}

					if(!empty($row_get_list->product_id))
					{

						$this->db->select(' count(review_title) as totalreview');
						$this->db->where('product_id', $row_get_list->product_id);
						$this->db->where('review_title !="" ');
						$this->db->where('status', 1);
						$query_get_review = $this->db->get($this->product_reviews_table_name);
						//echo $this->db->last_query();
						if($query_get_review->num_rows() > 0 )
						{
							$row_get_review = $query_get_review->row();
							$totalreview = $row_get_review->totalreview;
						}
					}else{$totalreview = 0;}

										$pg_content[]=array("product_id"=>$row_get_list->product_id,"is_bulk_enquiry"=>$row_get_list->is_bulk_enquiry,"name"=>$row_get_list->name,"brand_name"=>$row_get_list->brand_name,"ref_code"=>$row_get_list->ref_code,"short_description"=>$row_get_list->short_description,"product_combination"=>$content_product_combination,"description"=>$row_get_list->description,"application"=>$row_get_list->application, "totalreview"=>$totalreview, "totalrating"=>$totalrating, "avgrating"=>$avgrating, "onerating"=>$onerating, "tworating"=>$tworating, "threerating"=>$threerating, "fourrating"=>$fourrating, "fiverating"=>$fiverating,"product_use_info"=>$product_use_info_value_arr,"attribute_data"=>$content_product_combination_attribute);

									}
								}
						}
				}

			return $pg_content;
		}

		if($category == 'product_specification')
		{/*
			$sql_get_list="select * from product_specification where product_id=$search3 and product_combination_id=0 order by product_specification_id asc";
			$query_get_list=$this->db->query($sql_get_list);
			{
				if($query_get_list->num_rows() > 0 )
				{
					foreach($query_get_list->result() as $row_get_list)
					{
						$pg_content[]=array("product_specification_id"=>$row_get_list->product_specification_id,"product_id"=>$row_get_list->product_id	,"product_combination_id"=>$row_get_list->product_combination_id,"info_title"=>$row_get_list->info_title,"info"=>$row_get_list->info,"added_on"=>$row_get_list->added_on,"added_by"=>$row_get_list->added_by,"updated_by"=>$row_get_list->updated_by,"updated_on"=>$row_get_list->updated_on);
					}
				}
		    }
			if(!empty($orderby))
			{
				$sql_get_list="select product_id, product_combination_id, info_title , info , product_specification_id from product_specification where product_id=$search3 and product_combination_id=$orderby order by product_specification_id asc";
				$query_get_list=$this->db->query($sql_get_list);
				{
					if($query_get_list->num_rows() > 0 )
					{
						foreach($query_get_list->result() as $row_get_list)
						{
							$pg_content[]=array("product_specification_id"=>$row_get_list->product_specification_id,"product_id"=>$row_get_list->product_id	,"product_combination_id"=>$row_get_list->product_combination_id,"info_title"=>$row_get_list->info_title,"info"=>$row_get_list->info);
						}
					}
				}
			}


			return $pg_content;
		*/}
	}

	function menucount($tablename , $tablePrimaryKey , $status , $search1 , $search2)
	{
		$total_count=0;
		$tablename = $tablename."_table_name";
		$tablePrimaryKey = !empty($tablePrimaryKey)?$tablePrimaryKey:'*';
	    $this->db->select("count($tablePrimaryKey) as total");
		$query_get_count = $this->db->get($this->$tablename);

		if($query_get_count->num_rows() > 0 )
		{
			$row_get_count = $query_get_count->row();
			$total_count = $row_get_count->total;
		}
		return $total_count;
	}


	function totalcount($id,$ctg)
	{
		if($ctg=='registered_users'){
	    $this->db->select('count(user_id) as total');
		$this->db->where('login_status = 1');
		$query_get_count = $this->db->get($this->employee_table_name);}

		if($query_get_count->num_rows() > 0 )
		{
			$row_get_count = $query_get_count->row();
			$total_count = $row_get_count->total;
		}
		return $total_count;
	}

	function totalCountSearch($id,$ctg,$data)
	{
		/*if($ctg=='category'){
	    $this->db->select('count(category_id) as total');
		$this->db->where("category_name like '%$data%'");
		$query_get_count = $this->db->get($this->category_table_name);}

		if($query_get_count->num_rows() > 0 )
		{
			$row_get_count = $query_get_count->row();
			$total_count = $row_get_count->total;
		}*/
		return $total_count;
	}

	function getListSearch($category, $id, $num, $offset, $search1, $search2, $search3, $search4, $search5, $status='')
	{
		$pg_content = array();
		if($category == 'country_list')
		{
			$query_get_list = $this->db->get($this->country_table_name);
			if($query_get_list->num_rows() > 0 )
			{
				foreach($query_get_list->result() as $row_get_list)
				{
					$pg_content[]=array("country_id"=>$row_get_list->country_id, "country_name"=>$row_get_list->country_name, "status"=>$row_get_list->status, "added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);
				}
			}
		}


		return $pg_content;
	}

	function deleteRows($category, $id)
	   {
			if( empty($id) || empty($category)) return -1;

			if($category == 'temp_cart_delete')
			{
				$this->db->where(array('temp_cart_id' => $id));
				$status = $this->db->delete($this->temp_cart_table_name);
			}

			if($category == 'temp_cart_empty')
			{
				$this->db->where(array('application_sess_temp_id' => $id));
				$status = $this->db->delete($this->temp_cart_table_name);
			}


			return $status;
	   }

   function update($data = array(),$category, $id , $condition)
   {
   		if(empty($data) || empty($condition) || empty($category)) return -1;
		$table_id = $category."_id";
		unset($data[$table_id]);
		unset($data['added_on']);
		unset($data['added_by']);
		$table_name = $category."_table_name";
		$this->db->where($condition);
		$status = $this->db->update($this->$table_name, $data);
		return $status;
   }

	function add($data = array(),$table_name)
	{
    	if(empty($data)) return -1;
		$table_name = $table_name.'_table_name';
		$status = $this->db->insert($this->$table_name, $data);
		if($status){$status = $status = $this->db->insert_id();}
		return $status;
    }

	function getMaxid($id,$table_name)
	{
		$sql_get_maxID = $this->db->select_max($id,'max_id');

			if($table_name == 'register_customer'){
			$query_get_maxID = $this->db->get($this->employee_table_name);}

			if($table_name == 'product_image'){
			$query_get_maxID = $this->db->get($this->product_image_table_name);}


			$row_get_maxID = $query_get_maxID->row();
				//$row_get_maxID = $query_get_maxID[0];
			$maxid = $row_get_maxID->max_id;
			if($maxid == "")
			$maxid = 1;
			else
			$maxid = $maxid+1;
			return  $maxid;
	}

	function getMaxPosition($id,$table_name , $where)
	{
		//$sql_get_maxID = $this->db->select_max($id,'max_id');
		$sql_get_maxID = $this->db->select_max($id,'max_id');

		if($table_name == 'product_image_position'){
			$sql_get_maxID = $this->db->where('product_id', $where);
			$query_get_maxID = $this->db->get($this->product_image_table_name);}

		if($table_name == 'category_position'){
			$sql_get_maxID = $this->db->where('super_category_id', $where);
			$query_get_maxID = $this->db->get($this->category_table_name);}


			$row_get_maxID = $query_get_maxID->row();
				//$row_get_maxID = $query_get_maxID[0];
			$maxid = $row_get_maxID->max_id;
			if($maxid == "")
			$maxid = 1;
			else
			$maxid = $maxid+1;
			return  $maxid;
	}

	function getName($id , $table_name)
	{
		$data = '';
		if($table_name == 'product_image')
		{
			$sql_get_list="select product_image_name from product_image where product_image_id = $id";
			$query_get_list=$this->db->query($sql_get_list);
			foreach($query_get_list->result() as $row_get_list)
			{
				$data = $row_get_list->product_image_name;
			}

		}
		return $data;
	}

	function delete($id,$category)
	{
		if(empty($id) || empty($category)) return -1;


		if($category == 'delete_unit'){
			$this->db->where('unit_id', $id);
			$status = $this->db->delete($this->unit_table_name);
		}

		return $status;
	}

	function random_password()
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$password = array();
		$alpha_length = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++)
		{
			$n = rand(0, $alpha_length);
			$password[] = $alphabet[$n];
		}
		return implode($password);
	}

	// function getproductName() created by Anushri on 18-01-2019 . This function get the name.
	function getproductName($product_id)
	{
		$this->db->select('name');
		$this->db->where('product_id', $product_id);

		$query_chk = $this->db->get($this->product_table_name);
		//echo "sddfdf".$query_chk_login->num_rows();
		$product_name='';
		if($query_chk->num_rows() > 0 )
		{
			$row_chk = $query_chk->row();
			$product_name = $row_chk->name;


		}
		return $product_name;
	}

	//
	function getList($category, $id, $num, $offset)
	{
		$pg_content=array();

		 if($category == 'product_reviews_list')
		{
			$this->db->distinct('pr.review_id');
			$this->db->select('pr.review_title, pr.customer_name , pr.customers_id, pr.added_on, pr.review, pr.rating, pr.added_on, pr.liked_by');
			$this->db->from('product_reviews as pr');

			$this->db->where("pr.review_title != ''");
			$this->db->where("pr.status = 1");
			$this->db->where("pr.product_id", $id);
			if(!empty($num))
			$this->db->limit($num);
			if(!empty($offset))
			$this->db->offset($offset);

			$this->db->order_by('pr.added_on DESC');

			$query_get_list = $this->db->get($this->product_reviews_table_name);
			//echo $this->db->last_query();
//			$this->db->join('customers as c' , 'c.customers_id = pr.customers_id');c.name as customer_name,
			if($query_get_list->num_rows() > 0 )
			{
				foreach($query_get_list->result() as $row_get_list)
				{
					if(!empty($row_get_list->customers_id))
					{
						$customers = $this->Common_model->getName(array('select'=>'c.* ' , 'from'=>'customers as c' , 'where'=>"c.customers_id=".$row_get_list->customers_id ));
						if(!empty($customers))
						{
							$customers = $customers[0];
							$customer_name = $customers->name;
						}
						else
						{
							$customer_name = $row_get_list->customer_name;
						}
					}else
					{
						$customer_name = $row_get_list->customer_name;
					}

					$pg_content[]=array("customer_name"=>$customer_name, "review_title"=>$row_get_list->review_title, "review"=>$row_get_list->review, "rating"=>$row_get_list->rating, "added_on"=>$row_get_list->added_on, "liked_by"=>$row_get_list->liked_by, "added_on"=>$row_get_list->added_on);
				}
			}
		}
		//

		else if($category == 'product_seo_list')
		{
			$this->db->select('*');
			$this->db->where("product_id", $id);
			if(! empty($num))
				$this->db->where("product_combination_id", $num);
			$query_get_list = $this->db->get('product_seo');
			//echo $this->db->last_query();
			if($query_get_list->num_rows() > 0 )
			{
				$pg_content = $query_get_list->result();
			}
		}
		//
		return $pg_content;

	}

	function getAttribute($params = array())
	{
		$this->db
			->distinct()
			->select('pa.* , ai.type ')
			->from('product_attribute as pa')
			->join('attributes_input as ai' , "pa.attributes_input_id = ai.attributes_input_id")
			->where('pa.status', 1);
			if(!empty($params['search_given']))
			{
				$this->db->where('pa.search', $params['search_given']);
			}
		if(!empty($params['product_id'])){
			$this->db
				//->select('pis.quantity')
				->join('product_combination_attribute as pca' , "pa.product_attribute_id = pca.product_attribute_id")
				->join('product_combination as pc' , "pc.product_combination_id = pca.product_combination_id")
				->join('product_in_store as pis' , "pc.product_combination_id = pis.product_combination_id")//combination_id store_id
				->where('pc.status', 1)
				->where('pis.status', 1)
				->where('pca.product_id' , $params['product_id']);
				if(!empty($params['store_id']))
					$this->db->where('pis.store_id', $params['store_id']);
		}
		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			$result = $result->result();
			//$result = $result[0];
			$count = 0;
			foreach ($result as $r) {
				$this->db
					->distinct('pav.product_attribute_value_id')
					->select('pav.*')
					->from('product_attribute_value as pav')
					->where('pav.product_attribute_id', $r->product_attribute_id)
					->where('pav.status', 1);
				if(!empty($params['product_id'])){
					$this->db
						->select("pca.combination_value , pca.product_combination_id , pis.quantity,(select ps.slug_url from product_seo as ps where ps.product_id = $params[product_id] and ps.product_combination_id = pca.product_combination_id limit 1 ) as ps_slug_url ")
						->join('product_combination_attribute as pca' , "pav.product_attribute_value_id = pca.product_attribute_value_id")
						->join('product_combination as pc' , "pc.product_combination_id = pca.product_combination_id")
						->join('product_in_store as pis' , "pc.product_combination_id = pis.product_combination_id")//combination_id store_id
						->where('pc.status', 1)
						->where('pis.status', 1)
						//->where('pca.product_attribute_id' , 'pav.product_attribute_id')
						->where('pca.product_id' , $params['product_id'])
						->where('pis.product_id' , $params['product_id']);
						if(!empty($params['store_id']))
							$this->db->where('pis.store_id', $params['store_id']);
				}
				$result[$count]->attributeVal = $this->db->get()->result();
				//echo $this->db->last_query().'<br>';
				$count++;
			}
//print_r($result);
			return $result;
		} else {
			return false;
		}
	}

	function getAttributeList($params = array())
	{
		$this->db
			->distinct()
			->select('pa.* , ai.type ')
			->from('product_attribute as pa')
			->join('attributes_input as ai' , "pa.attributes_input_id = ai.attributes_input_id")
			->join('product_combination_attribute as pca' , "pa.product_attribute_id = pca.product_attribute_id")
			->join('product_combination as pc' , "pc.product_combination_id = pca.product_combination_id")
			->join('product_in_store as pis' , "pc.product_combination_id = pis.product_combination_id")
			->join('product as p' , "p.product_id = pis.product_id")
			->join('product_category as pcat' , "pcat.product_id = pc.product_id")
			->where('pa.status', 1)
			->where('p.status', 1)
			->where('pis.status', 1)
			->where('pc.status', 1)
			;
			if(!empty($params['search_given']))
			{
				$this->db->where('pa.search', $params['search_given']);
			}
			if(!empty($params['attribute_cat']))
			{
				$this->db->where("pcat.category_id in ($params[attribute_cat])");
				//$this->db->where('pcat.category_id', $params['attribute_cat']);
			}
			if(!empty($params['min_price']))
			{
				$min_price = $params['min_price'];
				$this->db->where("pc.final_price >= $min_price");
			}
			if(!empty($params['max_price']))
			{
				$max_price = $params['max_price'];
				$this->db->where("pc.final_price <= $max_price");
			}
		if(!empty($params['product_id'])){
			$this->db
				//->select('pis.quantity')
				->join('product_combination_attribute as pca' , "pa.product_attribute_id = pca.product_attribute_id")
				->join('product_combination as pc' , "pc.product_combination_id = pca.product_combination_id")
				->join('product_in_store as pis' , "pc.product_combination_id = pis.product_combination_id")//combination_id store_id
				->where('pc.status', 1)
				->where('pis.status', 1)
				->where('pca.product_id' , $params['product_id']);
				if(!empty($params['min_price']))
				{
					$min_price = $params['min_price'];
					$this->db->where("pc.final_price >= $min_price");
				}
				if(!empty($params['max_price']))
				{
					$max_price = $params['max_price'];
					$this->db->where("pc.final_price <= $max_price");
				}
				if(!empty($params['store_id']))
					$this->db->where('pis.store_id', $params['store_id']);
		}
		$result = $this->db->get();
		//echo $this->db->last_query().'<br><br><br><br><br>';
		if ($result->num_rows() > 0) {
			$result = $result->result();
			//$result = $result[0];
			$count = 0;
			foreach ($result as $r) {
				$this->db
					->distinct('pav.product_attribute_value_id')
					->select('pav.* , pca.combination_value')
					->from('product_attribute_value as pav')
					->where('pav.product_attribute_id', $r->product_attribute_id)
					->where('pav.status', 1)
				->join('product_combination_attribute as pca' , "pav.product_attribute_value_id = pca.product_attribute_value_id")
						->join('product_combination as pc' , "pc.product_combination_id = pca.product_combination_id")
						->join('product_in_store as pis' , "pc.product_combination_id = pis.product_combination_id")//combination_id store_id
						->join('product as p' , "p.product_id = pis.product_id")
						->join('product_category as pcat' , "pcat.product_id = pc.product_id")
						->where('p.status', 1)
						->where('pis.status', 1)
						->where('pc.status', 1)
						->order_by('pav.position ASC , ABS(pca.combination_value) ASC')
						->order_by('pav.name ASC');
						if(!empty($params['store_id']))
							$this->db->where('pis.store_id', $params['store_id']);
						if(!empty($params['attribute_cat']))
						{
							$this->db->where('pcat.category_id', $params['attribute_cat']);
						}
						if(!empty($params['min_price']))
						{
							$min_price = $params['min_price'];
							$this->db->where("pc.final_price >= $min_price");
						}
						if(!empty($params['max_price']))
						{
							$max_price = $params['max_price'];
							$this->db->where("pc.final_price <= $max_price");
						}
				if(!empty($params['product_id'])){}
				$result[$count]->attributeVal = $this->db->get()->result();
				//echo $this->db->last_query().'<br>';
				$count++;
			}
//print_r($result);
			return $result;
		} else {
			return false;
		}
	}

	function getAttributeList_f_cl($params = array())
	{
		$this->db
			->distinct()
			->select('pa.* , ai.type ')
			->from('product_attribute as pa')
			->join('attributes_input as ai' , "pa.attributes_input_id = ai.attributes_input_id")
			->join('product_combination_attribute as pca' , "pa.product_attribute_id = pca.product_attribute_id")
			->join('product_combination as pc' , "pc.product_combination_id = pca.product_combination_id")
			->join('product as p' , "p.product_id = pc.product_id")
			->join('product_in_store as pis' , "pc.product_combination_id = pis.product_combination_id")
			->join('product_category as pcat' , "pcat.product_id = pc.product_id")
			->where('pa.status', 1);
			if(!empty($params['search_given']))
			{
				$this->db->where('pa.search', $params['search_given']);
			}
			if(!empty($params['attribute_cat']))
			{
				$this->db->where('pcat.category_id', $params['attribute_cat']);
			}
			if(!empty($params['min_price']))
			{
				$min_price = $params['min_price'];
				$this->db->where("pc.final_price >= $min_price");
			}
			if(!empty($params['max_price']))
			{
				$max_price = $params['max_price'];
				$this->db->where("pc.final_price <= $max_price");
			}
			//echo $params['brand_id'];
			//print_r($params['brand_id']);
		if(!empty($params['product_id'])){
			$this->db
				//->select('pis.quantity')
				->join('product_combination_attribute as pca' , "pa.product_attribute_id = pca.product_attribute_id")
				->join('product_combination as pc' , "pc.product_combination_id = pca.product_combination_id")
				->join('product_in_store as pis' , "pc.product_combination_id = pis.product_combination_id")//combination_id store_id
				->where('pc.status', 1)
				->where('pis.status', 1)
				->where('pca.product_id' , $params['product_id']);
				if(!empty($params['store_id']))
					$this->db->where('pis.store_id', $params['store_id']);
		}
		$result = $this->db->get();
		//echo $this->db->last_query().'<br><br><br><br><br>';
		if ($result->num_rows() > 0) {
			$result = $result->result();
			//$result = $result[0];
			$count = 0;
			foreach ($result as $r) {
				$this->db
					->distinct('pav.product_attribute_value_id')
					->select('pav.* , pca.combination_value')
					->from('product_attribute_value as pav')
					->where('pav.product_attribute_id', $r->product_attribute_id)
					->where('pav.status', 1)
				->join('product_combination_attribute as pca' , "pav.product_attribute_value_id = pca.product_attribute_value_id")
						->join('product_combination as pc' , "pc.product_combination_id = pca.product_combination_id")
						->join('product as p' , "p.product_id = pc.product_id")
						->join('product_in_store as pis' , "pc.product_combination_id = pis.product_combination_id")//combination_id store_id
						->join('product_category as pcat' , "pcat.product_id = pc.product_id")
						->where('pc.status', 1)
						->where('pis.status', 1);
						if(!empty($params['store_id']))
							$this->db->where('pis.store_id', $params['store_id']);
						if(!empty($params['attribute_cat']))
						{
							$this->db->where('pcat.category_id', $params['attribute_cat']);
						}
						if(!empty($params['min_price']))
						{
							$min_price = $params['min_price'];
							$this->db->where("pc.final_price >= $min_price");
						}
						if(!empty($params['max_price']))
						{
							$max_price = $params['max_price'];
							$this->db->where("pc.final_price <= $max_price");
						}
				if(!empty($params['product_id'])){}
				$result[$count]->attributeVal = $this->db->get()->result();
				//echo $this->db->last_query().'<br>';
				$count++;
			}
//print_r($result);
			return $result;
		} else {
			return false;
		}
	}

	function getManufacturerList_f_cl($category, $id, $status='', $search1='', $search2='', $search3='', $search4='', $search5='', $search6=''  , $limit='' , $offset='' , $orderby='' , $params = array())
	{
		$pg_content = array();
			$sql_get_list="select distinct m.* from product p , brand_master as m, product_in_store as pis, product_category as pcat, category as cat, product_combination as pc JOIN product_combination_attribute as pca ON pca.product_combination_id=pc.product_combination_id  , product_image as pi  where m.brand_id=p.brand_id and m.status=1 and p.status=1 and pis.product_id=p.product_id and pis.store_id=$search2 and pis.status=1 and pcat.product_id = p.product_id and cat.category_id = pcat.category_id and cat.status=1 ";
			$sql_get_list .= " and pc.product_id=p.product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1  ";
			$sql_get_list.=" and pis.store_id =$search2 ";
			if(!empty($search3))
				$sql_get_list.=" and p.product_id in ($search3) ";
			if(!empty($params['cat_search']))
			{
				$sql_get_list.=" and pcat.category_id in ($params[cat_search]) ";
			}
			if(!empty($params['search']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and (p.name like ('%$params[search]%') or pc.product_display_name like ('%$params[search]%')) ";
			}

			if(!empty($params['flash_sale']))
			{
				//$sql_get_list.=" and ( m.brand_name like ('%$params[search]%') ";
				$sql_get_list.=" and pc.flash_sale =1 ";
			}
			if(!empty($params['trending_now']))
			{
				$sql_get_list.=" and pc.trending_now = 1 ";
			}
			if(!empty($params['hot_selling_now']))
			{
				$sql_get_list.=" and pc.hot_selling_now = 1 ";
			}
			if(!empty($params['best_sellers']))
			{
				$sql_get_list.=" and pc.best_sellers = 1 ";
			}
			if(!empty($params['new_product']))
			{
				$sql_get_list.=" and pc.new_product = 1 ";
			}
			if(!empty($params['is_related']))
			{
				$sql_get_list.=" and pc.product_combination_id != $params[product_combination_id] ";
				//$sql_get_list.=" and p.product_id != $params[product_id] ";
			}

			if(!empty($params['min_price']))
			{
				$min_price = $params['min_price'];
				$sql_get_list.=" and pc.final_price >= $min_price ";
			}
			if(!empty($params['max_price']))
			{
				$max_price = $params['max_price'];
				$sql_get_list.=" and pc.final_price <= $max_price ";
			}

			//$sql_get_list.=" group by p.product_id ";
//			new_product best_sellers hot_selling_now trending_now
			if(!empty($params['Qsearch']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['Qsearch'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					//$sql_get_list .= " pca.product_attribute_value_id = $q ";
					$sql_get_list .= " ( pca.product_attribute_value_id = $q[product_attribute_value_id] and pca.combination_value = '$q[combination_value]' ) ";
				}
				$sql_get_list .= " ) ";

			}
			if(!empty($params['brand_id']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['brand_id'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					$sql_get_list .= " p.brand_id = $q ";
				}
				$sql_get_list .= " ) ";

			}

			if(!empty($params['author_id']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['author_id'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					$sql_get_list .= " p.author_id = $q ";
				}
				$sql_get_list .= " ) ";

			}

			if(!empty($search4))
				$sql_get_list.=" and pc.product_combination_id in ($search4) ";
			//if(!empty($orderby))
				//$sql_get_list1.=" order by FIELD(pc.product_combination_id, '$orderby') DESC ";

			$sql_get_list.=" order by m.brand_name ASC ";
				$group = false;

				$query_get_list=$this->db->query($sql_get_list);
				{
					//echo $sql_get_list.'<br>';
					if($query_get_list->num_rows() > 0 )
					{
						$pg_content = $query_get_list->result();
						/*foreach($query_get_list->result() as $row_get_list)
						{
							$pg_content[]=array("brand_name"=>$row_get_list->brand_name,"brand_id"=>$row_get_list->brand_id);
						}*/
					}
				}

			return $pg_content;



	}

}

?>
