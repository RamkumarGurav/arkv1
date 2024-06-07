<?php
class Ajax_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
    }
	
	function getState($params=array())
	{
		$this->db
		->select('s.*')
		->from('state as s')
		->where('s.status' , 1)
		->order_by('s.state_name ASC');
		if(!empty($params['country_id']))
			$this->db->where('s.country_id' , $params['country_id']);
		$result = $this->db->get();
		if($result->num_rows() > 0 )
		{
			$result = $result->result();
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	function getCity($params=array())
	{
		$this->db
		->select('c.*')
		->from('city as c')
		->where('c.status' , 1)
		->order_by('c.city_name ASC');
		if(!empty($params['state_id']))
			$this->db->where('c.state_id' , $params['state_id']);
		$result = $this->db->get();
		if($result->num_rows() > 0 )
		{
			$result = $result->result();
			return $result;
		}
		else
		{
			return false;
		}
	}
}

?>