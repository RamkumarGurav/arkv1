<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Add_Update_Data_Lib
{
	private $CI;
	public $session_uid = '';
	public $session_name = '';
	public $session_email = '';
	function __construct() 
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->library('session');
		$this->CI->load->helper('url');
	}
	
	function add_new_otp_log($params = array())
	{
		if(empty($params['contact'])||empty($params['otp'])){return false;}
		
		$contact='';			if(!empty($params['contact'])){$contact = $params['contact'];}
		$otp='';				if(!empty($params['otp'])){$otp = $params['otp'];}
		$otp_for='';			if(!empty($params['otp_for'])){$otp_for = $params['otp_for'];}
		$data_to_add['contact'] = $contact;
		$data_to_add['otp'] = $otp;
		$data_to_add['otp_for'] = $otp_for;
		$data_to_add['added_on'] = date('Y-m-d H:i:s');;
		$inserted_id= $this->add_operation(array('table'=>'otp_log' , 'data'=>$data_to_add));
		return $inserted_id;
	}
	
	function check_exist_otp($params = array())
	{
		$this->CI->db->select('sol.*');
		$this->CI->db->from('otp_log as sol');
		
		if(!empty($params['contact']))		{  $this->CI->db->where('sol.contact' , $params['contact']);  }
		if(!empty($params['otp_for']))		{  $this->CI->db->where('sol.otp_for' , $params['otp_for']);  }
		if(!empty($params['otp']))			{  $this->CI->db->where('sol.otp' , $params['otp']);  }
		
		$result = $this->CI->db->get();
		
		return $result->result();
	}
	
	function getData($params = array())
	{
		$this->CI->db->select($params['select']);
		$this->CI->db->from($params['from']);
		$this->CI->db->where("($params[where])");
		if(!empty($params['limit']))
		{
			$this->CI->db->limit($params['limit']);
		}
		if(!empty($params['order_by']))
		{
			$this->CI->db->order_by($params['order_by']);
		}
		$query_get_list = $this->CI->db->get();
		return $query_get_list->result();
	}

	function add_operation($params = array())
	{
		if(empty($params)) return false;   
		$status = $this->CI->db->insert($params['table'], $params['data']);
		if($status){$status = $status = $this->CI->db->insert_id();}
		return $status;   	
	}

    public function getFiscalYear()
    {
		$result = array();
        $start='';
        $end='';
		$s_start='';
        $s_end='';
		if (date('m') < 4) {//Upto march 
			$start=date('Y')-1;
       		$end=date('Y');
			$s_start=date('y')-1;
       		$s_end=date('y');
			//$financial_year = (date('Y')-1) . '-' . date('Y');
		} else {//form April 
			$start=date('Y');
       		$end=date('Y') + 1;
			$s_start=date('y');
       		$s_end=date('y') + 1;
			//$financial_year = date('Y') . '-' . (date('Y') + 1);
		}

        $result['start'] = $start;
		$result['end'] = $end;
		$result['short_start'] = $s_start;
		$result['short_end'] = $s_end;
		$result['financial_year'] = $start.'-'.$end;
		$result['short_financial_year'] = $s_start.'-'.$s_end;
        return (object)$result;
	}
	
	// $mydate = new fiscalYear();    // will default to the current date time
	// $mydate->setDate(2011, 3, 31); //if you don't do this
	// $result = $mydate->getFiscalYear();
	// var_dump(date(DATE_RFC3339, $result['start']));
	// var_dump(date(DATE_RFC3339, $result['end']));
}
