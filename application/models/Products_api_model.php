<?php
include_once('database_tables.php');
class Products_api_model extends database_tables
{
	function __construct()
    {
        parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->library('session');
		$this->db->query("SET sql_mode = ''");	
    }
	
	function productsSearch($category, $id, $status='', $search1='', $search2='', $search3='', $search4='', $search5='', $search6=''  , $limit='' , $offset='' , $orderby='' , $params = array())
	{
		$pg_content = array();
		
		if($category == 'products_list')
		{
			$sql_get_list="select DISTINCT(pc.product_combination_id),pis.*, p.ref_code as p_ref_code , pc.ref_code as pc_ref_code , pc.product_display_name  , pc.gtin , pc.delivery_charges , pc.trending_now , pc.hot_selling_now , pc.best_sellers , pc.new_product , pc.default_combination , pc.product_combination_id , pc.comb_slug_url , pc.product_image_id , pc.ref_code , pc.product_weight , pc.product_dimension , pi.product_image_name , (select tc.quantity from temp_cart as tc where tc.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_cart , (select count(tw.temp_wishlist_id) from temp_wishlist as tw where tw.product_in_store_id=pis.product_in_store_id and pis.store_id=$search2 and store_id = $search2 and  application_sess_temp_id = '$search1' limit 1) as prod_in_wishList, p.product_id , p.brand_id , p.short_description , p.name , p.ref_code , p.slug_url , p.short_description, m.brand_name , (select tc.tax_categories_name from tax_categories as tc where p.tax_categories_id = tc.tax_categories_id limit 1) as tax_categories_name , (select tp.tax_providers_percentage from tax_providers as tp where p.tax_providers_id = tp.tax_providers_id limit 1) as tax_providers_percentage , (select ps.slug_url from product_seo as ps where ps.product_id = p.product_id and  ps.product_combination_id = pc.product_combination_id limit 1) as ps_slug_url  from product p , brand as m, product_in_store as pis,  category as c , product_category as pcat, product_combination as pc JOIN product_combination_attribute as pca ON pca.product_combination_id=pc.product_combination_id  , product_image as pi  where m.brand_id=p.brand_id and m.status=1 and p.status=1 and pis.product_id=p.product_id and pis.store_id=$search2 and pis.status=1 and pcat.product_id = p.product_id ";
			
//			$sql_get_list .= " and pc.product_id=p.product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1  ";
			$sql_get_list .= " and pc.product_id=p.product_id and pi.product_image_id = pc.product_image_id and pc.product_combination_id=pis.product_combination_id and pc.product_id = pis.product_id and pis.final_price !='' and pis.status=1 and pc.status=1 and  c.category_id = pcat.category_id and c.status=1  ";
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
			/*if(!empty($params['Qsearch']))
			{
				$qcount=0;
				$sql_get_list .= " and ( ";
				foreach($params['Qsearch'] as $q){$qcount++;
					if($qcount>1)
					$sql_get_list .= " or ";
					$sql_get_list .= " pca.product_attribute_value_id = $q ";
				}
				$sql_get_list .= " ) ";
				
			}*/
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
				
			 
			if(!empty($params['order']))
			{
				if($params['order'] == 'getsuggestion')
				{
					$sql_get_list .= " group by p.product_id order by pc.default_combination DESC ";
					$group = false;
				}
				else
				{
					$temp_currency_id = $this->session->userdata('application_sess_currency_id');
					$group = false;
					if($params['order']==1)
					{
						$sql_get_list .= " group by pc.product_combination_id order by pis.product_combination_id ASC ";
						if(empty($temp_currency_id) || $temp_currency_id==1)
						{
							//$sql_get_list .= " group by pc.product_combination_id order by pis.final_price ASC ";
						}
						else
						{
							//$sql_get_list .= " group by pc.product_combination_id order by pis.other_final_price ASC ";
						}
					}
					if($params['order']==2)
					{
						if(empty($temp_currency_id) || $temp_currency_id==1)
						{
							$sql_get_list .= " group by pc.product_combination_id order by pis.other_final_price DESC ";
						}
						else
						{
							$sql_get_list .= " group by pc.product_combination_id order by pis.other_final_price DESC ";
						}
					}
					if($params['order']==3)
					$sql_get_list .= " group by pc.product_combination_id order by pc.trending_now DESC ";
					if($params['order']==4)
					$sql_get_list .= " group by pc.product_combination_id order by pc.hot_selling_now DESC ";
					if($params['order']==5)
					$sql_get_list .= " group by pc.product_combination_id order by pc.best_sellers DESC ";
					if($params['order']==6)
					$sql_get_list .= " group by pc.product_combination_id order by pc.new_product DESC ";
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
					if($params['order']=='random')
					$sql_get_list .= " group by pc.product_combination_id order by RAND()  ";
				}
			}
			else
			{
				$sql_get_list .= " group by pc.product_combination_id order by pc.default_combination DESC ";
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
											
											/*if(!empty($search2))
												if($search2>1)
												$product_id_for_attribute = $search2;
											else if(!empty($row_get_list->product_id))
												$product_id_for_attribute = $row_get_list->product_id;*/
												
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
									
										$pg_content[]=array("product_id"=>$row_get_list->product_id,"ps_slug_url"=>$row_get_list->ps_slug_url,"brand_id"=>$row_get_list->brand_id,"short_description"=>$row_get_list->short_description,"tax_categories_name"=>$row_get_list->tax_categories_name,"tax_providers_percentage"=>$row_get_list->tax_providers_percentage,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"slug_url"=>$row_get_list->slug_url,"short_description"=>$row_get_list->short_description,"brand_name"=>$row_get_list->brand_name,"totalrating"=>$totalrating,"product_combination_id"=>$row_get_list1->product_combination_id,"product_id"=>$row_get_list1->product_id	,"ref_code"=>$row_get_list1->ref_code,"quantity"=>$row_get_list1->quantity,"price"=>$row_get_list1->price,"discount"=>$row_get_list1->discount,"discount_var"=>$row_get_list1->discount_var,"final_price"=>$row_get_list1->final_price,"status"=>$row_get_list1->status,"added_on"=>$row_get_list1->added_on,"updated_on"=>$row_get_list1->updated_on,"product_image_id"=>$row_get_list1->product_image_id,"default_combination"=>$row_get_list1->default_combination,"comb_slug_url"=>$row_get_list1->comb_slug_url,"product_image_name"=>$row_get_list1->product_image_name,"combi"=>$combi , "product_in_store_id"=>$row_get_list1->product_in_store_id, "prod_in_wishList" => $row_get_list1->prod_in_wishList, "prod_in_cart"=>$row_get_list1->prod_in_cart, "quantity_per_order"=>$row_get_list1->quantity_per_order, "stock_out_msg"=>$row_get_list1->stock_out_msg, "product_weight"=>$row_get_list1->product_weight, "product_dimension"=>$row_get_list1->product_dimension ,"attribute"=>$attribute,"trending_now"=>$row_get_list1->trending_now,"hot_selling_now"=>$row_get_list1->hot_selling_now,"best_sellers"=>$row_get_list1->best_sellers,"new_product"=>$row_get_list1->new_product,"product_display_name"=>$row_get_list1->product_display_name,"gtin"=>$row_get_list1->gtin,"delivery_charges"=>$row_get_list1->delivery_charges,"totalreview"=>$totalreview,"avgrating"=>$avgrating,"other_price"=>$row_get_list1->other_price,"other_final_price"=>$row_get_list1->other_final_price,"other_discount"=>$row_get_list1->other_discount,"other_discount_var"=>$row_get_list1->other_discount_var,"p_ref_code"=>$row_get_list->p_ref_code ,"pc_ref_code"=>$row_get_list->pc_ref_code,"product_combination_id"=>$row_get_list->product_combination_id);

										
								}
						}
				}
		    
			return $pg_content;
		}		
	}
}
?>