<?php
class Client_Group_Model extends CI_Model
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
	
	function get_clientgroup($params = array())
	{
		$result='';
		if(!empty($params['search_for']))
		{
			$this->db->select("count(urm.group_id) as counts");
		}
		else
		{
			//$this->db->select("urm.* , s.state_name , c.country_name , c.country_short_name , c.dial_code ");
			$this->db->select("urm.* ");
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = urm.added_by) as added_by_name ");
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = urm.updated_by) as updated_by_name ");
		}
		
		$this->db->from("client_group as urm");
//		$this->db->join("category as  c" , "c.category_id = urm.category_id","left");
		//$this->db->join("state as  s" , "s.state_id = urm.state_id");
		$this->db->order_by("group_id desc");
		
		if(!empty($params['group_id']))	
		{
			$this->db->where("urm.group_id" ,  $params['group_id']);
		}
		if(!empty($params['start_date']))
		{
			$temp_date = date('Y-m-d' , strtotime($params['start_date']));
			$this->db->where("DATE_FORMAT(urm.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}
		
		if(!empty($params['end_date']))
		{
			$temp_date = date('Y-m-d' , strtotime($params['end_date']));
			$this->db->where("DATE_FORMAT(urm.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
		}

		if(!empty($params['record_status']))
		{
			if($params['record_status']=='zero')
			{
				$this->db->where("urm.status = 0");
			}
			else
			{
				$this->db->where("urm.group_id" ,  $params['record_status']);
			}
		}

		

		if(!empty($params['field_value']) && !empty($params['field_name']))
		{
			$this->db->where("$params[field_name] like ('%$params[field_value]%')");
		}

		if(!empty($params['limit']) && !empty($params['offset'])){
			$this->db->limit($params['limit'] , $params['offset']);
		}
		else if(!empty($params['limit'])){
			$this->db->limit($params['limit']);
		}

		$query_get_list = $this->db->get();
		$result = $query_get_list->result();
		//echo $this->db->last_query();
		if(!empty($result))
		{
			if(!empty($params['details']))
			{
				foreach($result as $r)
				{
					//$this->db->select("cgc.* , ctg1.name as category_name , if(ctg1.super_category_id = 0, ctg1.status, ctg2.status) as status");
					$this->db->select("cgc.* , ctg1.name as category_name , ctg1.status as status");
					$this->db->from("category as ctg1");
					$this->db->join("client_group_category as cgc" , "ctg1.category_id = cgc.category_id and cgc.group_id = ".$r->group_id, "left");
					//$this->db->join("category as ctg2" , "ctg1.super_category_id = ctg2.category_id", "left");
					//$this->db->where("cgc.group_id" , $r->group_id);
					$this->db->where("ctg1.super_category_id" , 0);
					$this->db->group_by("ctg1.category_id");
					$r->client_group_category_data = $this->db->get()->result();
					
/*					
					$this->db->select("auf.*");
					$this->db->from("admin_user_file as auf");
					$this->db->where("auf.admin_user_id" , $r->admin_user_id);
					$r->files = $this->db->get()->result();
					*/
				}
			}
			
		}
		return $result;
	}
	
}

?>
