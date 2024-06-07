<?php
class Enquiry_Model extends CI_Model
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
	
	function get_enquiry($params = array())
	{
		$result='';
		if(!empty($params['search_for']))
		{
			$this->db->select("count(aau.enquiry_id) as counts");
		}
		else
		{
			$this->db->select("aau.*");
			$this->db->select("(select au.name from admin_user as au where au.admin_user_id = aau.updated_by) as updated_by_name ");
		}
		
		$this->db->from("enquiry as aau");
		//$this->db->join("users_role_master as  urm" , "urm.user_role_id = aau.user_role_id");
		$this->db->join("admin_user as  au1" , "au1.admin_user_id = aau.updated_by", "left");
		
		
		if(!empty($params['order_by'])){
			$this->db->order_by($params['order_by']);
		}
		else {
			$this->db->order_by("enquiry_id desc");
		}
		
		if(!empty($params['enquiry_id']))	
		{
			$this->db->where("aau.enquiry_id" ,  $params['enquiry_id']);
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
					$this->db->from("enquiry as aur");
					$this->db->join("admin_user as emp" , "emp.admin_user_id = aur.updated_by", "left");
					$this->db->where("aur.enquiry_id" , $r->enquiry_id);
					$r->roles = $this->db->get()->result();
					
					
				}
			}
			
		}
		return $result;
	}
		
}

?>
