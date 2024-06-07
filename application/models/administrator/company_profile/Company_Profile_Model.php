<?php
# Same Model we are using for Reports section
class Company_Profile_Model extends CI_Model
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
	
	function get_company_profile($params = array())
	{
		$result='';
		if(!empty($params['search_for']))
		{
			$this->db->select("count(aau.company_profile_id) as counts");
		}
		else
		{
			$this->db->select("aau.* , ci.city_name , s.state_name , c.country_name , c.country_short_name , c.dial_code ");
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.added_by) as added_by_name ");
			$this->db->select("(select au.name from admin_user as  au where au.admin_user_id = aau.updated_by) as updated_by_name ");
		}
		
		$this->db->from("company_profile as aau");
		$this->db->join("country as  c" , "c.country_id = aau.country_id");
		$this->db->join("state as  s" , "s.state_id = aau.state_id");
		$this->db->join("city as  ci" , "ci.city_id = aau.city_id");
		$this->db->order_by("company_profile_id desc");
		
		if(!empty($params['company_profile_id']))	
		{
			$this->db->where("aau.company_profile_id" ,  $params['company_profile_id']);
		}
		if(!empty($params['country_id']))	
		{
			$this->db->where("aau.country_id" ,  $params['country_id']);
		}

		if(!empty($params['state_id']))	
		{
			$this->db->where("aau.state_id" ,  $params['state_id']);
		}

		if(!empty($params['city_id']))	
		{
			$this->db->where("aau.city_id" ,  $params['city_id']);
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
				$this->db->where("aau.company_profile_id" ,  $params['record_status']);
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
		
		return $result;
	}
}

?>
