<?php
class Product_Attribute_Model extends CI_Model
{
	public $session_uid = '';
	public $session_name = '';
	public $session_email = '';
	
	function __construct()
    {
		$this->load->database();
		$this->model_data = array();
		$this->db->query("SET sql_mode = ''");	
		$this->session_uid=$this->session->userdata('sess_psts_uid');
		$this->session_name=$this->session->userdata('sess_psts_name');
		$this->session_email=$this->session->userdata('sess_psts_email');
		
	}
	
	function get_product_attribute($params = array())
	{
		$result='';
		if(!empty($params['search_for']))
		{
			$this->db->select("count(aau.product_attribute_id) as counts");
		}
		else
		{
			$this->db->select("aau.product_attribute_id, aau.attributes_input_id, aau.name, aau.condition_per_product, aau.status, aau.added_on, aau.added_by, aau.updated_on, aau.updated_by, aau.search, aau.list_page, aau.details_page , ai.name as attribute_name");
			
			$this->db->select(" (select count(pav.product_attribute_value_id) from product_attribute_value as pav where pav.product_attribute_id = aau.product_attribute_id) as product_attribute_value_count");
			
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.added_by) as added_by_name ");
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.updated_by) as updated_by_name ");
		}
		
		$this->db->from("product_attribute as aau");
		$this->db->join("attributes_input as ai" , "ai.attributes_input_id = aau.attributes_input_id");
		//$this->db->join("product_attribute_value as pav" , "pav.product_attribute_id = aau.product_attribute_id");

		if(!empty($params['order_by'])){
			$this->db->order_by($params['order_by']);
		}
		else {
			$this->db->order_by("aau.product_attribute_id desc");
		}
		
		if(!empty($params['product_attribute_id']))	
		{
			$this->db->where("aau.product_attribute_id" ,  $params['product_attribute_id']);
		}
		if(!empty($params['admin_user_id']))	
		{
			$this->db->where("aau.admin_user_id" ,  $params['admin_user_id']);
		}
		
		if(!empty($params['start_date']))
		{
			$temp_date = date('Y-m-d' , strtotime($params['start_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}
		
		if(!empty($params['end_date']))
		{
			$temp_date = date('Y-m-d' , strtotime($params['end_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}

		if(!empty($params['record_status']))
		{
			if($params['record_status']=='zero')
			{
				$this->db->where("aau.status = 0");
			}
			else
			{
				$this->db->where("aau.status" ,  $params['record_status']);
			}
		}

		if(!empty($params['limit']) && !empty($params['offset'])){
			$this->db->limit($params['limit'] , $params['offset']);
		}
		else if(!empty($params['limit'])){
			$this->db->limit($params['limit']);
		}

		$query_get_list = $this->db->get();
		//echo $this->db->last_query();
		$result = $query_get_list->result();
		
		if(!empty($result))
		{
			if(!empty($params['details']))
			{
				foreach($result as $r)
				{
					$this->db->select("aur.* , emp.name");
					$this->db->from("product_attribute as aur");
					$this->db->join("admin_user as emp" , "emp.admin_user_id = aur.updated_by", "left");
					$this->db->where("aur.product_attribute_id" , $r->product_attribute_id);
					$r->roles = $this->db->get()->result();
					
					
				}
			}
			
		}
		return $result;
	}
	
	function get_product_attribute_active($params = array())
	{
		$result='';
		if(!empty($params['search_for']))
		{
			$this->db->select("count(aau.product_attribute_id) as counts");
		}
		else
		{
			$this->db->select("aau.product_attribute_id, aau.attributes_input_id, aau.name, aau.condition_per_product, aau.status, aau.added_on, aau.added_by, aau.updated_on, aau.updated_by, aau.search, aau.list_page, aau.details_page , ai.name as attribute_name");
			
			$this->db->select(" (select count(pav.product_attribute_value_id) from product_attribute_value as pav where pav.product_attribute_id = aau.product_attribute_id) as product_attribute_value_count");
			
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.added_by) as added_by_name ");
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.updated_by) as updated_by_name ");
		}
		
		$this->db->from("product_attribute as aau");
		$this->db->join("attributes_input as ai" , "ai.attributes_input_id = aau.attributes_input_id");
		$this->db->where("aau.status" ,  1);
		//$this->db->join("product_attribute_value as pav" , "pav.product_attribute_id = aau.product_attribute_id");

		if(!empty($params['order_by'])){
			$this->db->order_by($params['order_by']);
		}
		else {
			$this->db->order_by("aau.name asc");
		}
		
		if(!empty($params['product_attribute_id']))	
		{
			$this->db->where("aau.product_attribute_id" ,  $params['product_attribute_id']);
		}
		if(!empty($params['admin_user_id']))	
		{
			$this->db->where("aau.admin_user_id" ,  $params['admin_user_id']);
		}
		
		if(!empty($params['start_date']))
		{
			$temp_date = date('Y-m-d' , strtotime($params['start_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}
		
		if(!empty($params['end_date']))
		{
			$temp_date = date('Y-m-d' , strtotime($params['end_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}

		if(!empty($params['record_status']))
		{
			if($params['record_status']=='zero')
			{
				$this->db->where("aau.status = 0");
			}
			else
			{
				$this->db->where("aau.status" ,  $params['record_status']);
			}
		}

		if(!empty($params['limit']) && !empty($params['offset'])){
			$this->db->limit($params['limit'] , $params['offset']);
		}
		else if(!empty($params['limit'])){
			$this->db->limit($params['limit']);
		}

		$query_get_list = $this->db->get();
		//echo $this->db->last_query();
		$result = $query_get_list->result();
		
		if(!empty($result))
		{
			if(!empty($params['details']))
			{
				foreach($result as $r)
				{
					$this->db->select("aur.* , emp.name");
					$this->db->from("product_attribute as aur");
					$this->db->join("admin_user as emp" , "emp.admin_user_id = aur.updated_by", "left");
					$this->db->where("aur.product_attribute_id" , $r->product_attribute_id);
					$r->roles = $this->db->get()->result();
					
					
				}
			}
			
		}
		return $result;
	}
	
	function get_attribute_input_list($params = array())
	{
		$result='';
		if(!empty($params['search_for']))
		{
			$this->db->select("count(aau.attributes_input_id) as counts");
		}
		else
		{
			$this->db->select("aau.*");
		}
		
		$this->db->from("attributes_input as aau");

		if(!empty($params['order_by'])){
			$this->db->order_by($params['order_by']);
		}
		else {
			$this->db->order_by("attributes_input_id desc");
		}
		
		if(!empty($params['attributes_input_id']))	
		{
			$this->db->where("aau.attributes_input_id" ,  $params['attributes_input_id']);
		}
		

		if(!empty($params['limit']) && !empty($params['offset'])){
			$this->db->limit($params['limit'] , $params['offset']);
		}
		else if(!empty($params['limit'])){
			$this->db->limit($params['limit']);
		}

		$query_get_list = $this->db->get();
		//echo $this->db->last_query();
		$result = $query_get_list->result();
		
		if(!empty($result))
		{
			if(!empty($params['details']))
			{
				foreach($result as $r)
				{
					$this->db->select("aur.* ");
					$this->db->from("attributes_input as aur");
					$this->db->where("aur.attributes_input_id" , $r->attributes_input_id);
					$r->roles = $this->db->get()->result();
					
					
				}
			}
			
		}
		return $result;
	}
		
	function get_product_attribute_value($params = array())
	{
		$result='';
		if(!empty($params['search_for']))
		{
			$this->db->select("count(aau.product_attribute_value_id) as counts");
		}
		else
		{
			$this->db->select("aau.product_attribute_value_id, aau.product_attribute_id, aau.name, aau.color_name, aau.position, aau.added_on, aau.added_by, aau.updated_on, aau.updated_by, aau.status, pa.name as attribute_name");
			//$this->db->select("aau.*, pa.name as attribute_name ");
			
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.added_by) as added_by_name ");
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.updated_by) as updated_by_name ");
		}
		
		$this->db->from("product_attribute_value as aau");
		$this->db->join("product_attribute as pa" , "pa.product_attribute_id = aau.product_attribute_id","left");
		
		
		//$this->db->select('ai.*,pa.name as attribute_name ');
			//$this->db->from("$this->product_attribute_table_name AS pa");
			//$this->db->join("$this->product_attribute_value_table_name as ai", 'ai.product_attribute_id = pa.product_attribute_id');
			
		//$this->db->join("product_attribute_value as pav" , "pav.product_attribute_id = aau.product_attribute_id");

		if(!empty($params['order_by'])){
			$this->db->order_by($params['order_by']);
		}
		else {
			$this->db->order_by("aau.product_attribute_value_id desc");
		}
		
		if(!empty($params['product_attribute_value_id']))	
		{
			$this->db->where("aau.product_attribute_value_id" ,  $params['product_attribute_value_id']);
		}
		if(!empty($params['product_attribute_id']))	
		{
			$this->db->where("aau.product_attribute_id" ,  $params['product_attribute_id']);
		}
		if(!empty($params['admin_user_id']))	
		{
			$this->db->where("aau.admin_user_id" ,  $params['admin_user_id']);
		}
		
		if(!empty($params['start_date']))
		{
			$temp_date = date('Y-m-d' , strtotime($params['start_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}
		
		if(!empty($params['end_date']))
		{
			$temp_date = date('Y-m-d' , strtotime($params['end_date']));
			$this->db->where("DATE_FORMAT(aau.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}

		if(!empty($params['record_status']))
		{
			if($params['record_status']=='zero')
			{
				$this->db->where("aau.status = 0");
			}
			else
			{
				$this->db->where("aau.status" ,  $params['record_status']);
			}
		}

		if(!empty($params['limit']) && !empty($params['offset'])){
			$this->db->limit($params['limit'] , $params['offset']);
		}
		else if(!empty($params['limit'])){
			$this->db->limit($params['limit']);
		}

		$query_get_list = $this->db->get();
		//echo $this->db->last_query();
		$result = $query_get_list->result();
		
		if(!empty($result))
		{
			if(!empty($params['details']))
			{
				foreach($result as $r)
				{
					$this->db->select("aur.* , emp.name, pa.name as attribute_name");
					$this->db->from("product_attribute_value as aur");
					$this->db->join("admin_user as emp" , "emp.admin_user_id = aur.updated_by", "left");
					$this->db->join("product_attribute as pa" , "pa.product_attribute_id = aur.product_attribute_id", "left");
					$this->db->where("aur.product_attribute_value_id" , $r->product_attribute_value_id);
					$r->roles = $this->db->get()->result();
					
					
				}
			}
			
		}
		return $result;
	}
}

?>
