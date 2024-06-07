<?php
include_once('database_tables.php');
class Api_model extends database_tables
{
	function __construct()
    {
        parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->library('session');
		$this->db->query("SET sql_mode = ''");	
    }
	
	function getCustomers($params = array())
	{
		$customers = false;
		$this->db
		->select('c.name , c.first_name , c.last_name , c.email , c.number ')
		->from('customers as c')
		->where('c.status' , 1);
		
		if(!empty($offset))
			$sql_get_list.=" LIMIT $limit , $offset ";
		else if(!empty($limit))
			$sql_get_list.=" LIMIT $limit ";
		
		$result = $this->db->get();
		
		if($result->num_rows()>0)
		{
			$customers = $result->result();
		}
		return $customers;
	}
	
	function getMenu($params = array())
	{
	 $pg_content = array();
			$sql_get_list="select c.category_id , c.header_1_img, c.header_1_url , c.name , c.cover_image ,c.slug_url, c.super_category_id , c.is_dropdown from category as c where c.status=1 and c.super_category_id =0 order by c.position asc	";
				$query_get_list=$this->db->query($sql_get_list);	
				{
					if($query_get_list->num_rows() > 0 )
					{
						$mcCount=-1;
						$pg_content=$query_get_list->result();
						foreach($query_get_list->result() as $row_get_list)
						{
							$mcCount++;
							$sql_get_list1="select c.category_id , c.header_1_img, c.header_1_url , c.name , c.cover_image , c.super_category_id , c.is_dropdown from category as c where c.status=1 and c.super_category_id =$row_get_list->category_id order by c.position asc";
							$query_get_list1=$this->db->query($sql_get_list1);	
							{
								if($query_get_list1->num_rows() > 0 )
								{
									$pg_content[$mcCount]->sub_category=$query_get_list1->result();
									$scCount=-1;
									foreach($query_get_list1->result() as $row_get_list1)
									{
										$sql_get_list2="select c.category_id , c.header_1_img , c.header_1_url , c.name , c.cover_image , c.super_category_id , c.is_dropdown from category as c where c.status=1 and c.super_category_id =$row_get_list1->category_id order by c.position asc";
										$query_get_list2=$this->db->query($sql_get_list2);
										{
											if($query_get_list2->num_rows() > 0 )
											{
												$scCount++;
												$pg_content[$mcCount]->sub_category[$scCount]->super_sub_category=$query_get_list2->result();
											}
										}
										
									}
								}
							}
						}
					}
				}
		    
			return $pg_content;
	}

}

?>