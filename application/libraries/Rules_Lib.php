<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rules_Lib
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
	
	function check_Password($params=array())
	{
		if(empty($params))
		{
			$this->form_validation->set_message('check_Password', 'please reenter the password');
			return FALSE;
		}
		$errors='';
		$response = array(
			'success' => '',
			'errors' => '',
		);
		if (strlen($params['password']) < 8)
		{
			$errors .= "Password too short!<br>";
		}
	
		if (!preg_match("#[0-9]+#", $params['password']))
		{
			$errors .= "Password must include at least one number!<br>";
		}
	
		if (!preg_match("#[a-z]+#", $params['password']))
		{
			$errors .= "Password must include at least one small letter!<br>";
		}
		
		if (!preg_match("#[A-Z]+#", $params['password']))
		{
			$errors .= "Password must include at least one capital letter!<br>";
		}
		$whiteListed = '\$\@\#\^\|\!\~\=\+\-\_\.';
		if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $params['password']))
		{
			$errors .= "Password must include at least one special character!<br>";
		}
		$if_dollar=$if_s_comma=$if_d_comma=$if_f_slash=$if_b_slash=true;
		for($i=0 ; $i<strlen($params['password']) ; $i++)
		{
			//echo ord($params['password'][$i]).' '.$params['password'][$i].'<br>';
			if(ord($params['password'][$i])==39 && $if_s_comma)
			{
				$if_s_comma = false;
				$errors .= "Password should not have single inverted comma!<br>";
			}
			if(ord($params['password'][$i])==34 && $if_d_comma)
			{
				$if_d_comma = false;
				$errors .= "Password should not have double inverted comma!<br>";
			}
			if(ord($params['password'][$i])==47 && $if_f_slash)
			{
				$if_f_slash = false;
				$errors .= "Password should not have foreward slash!<br>";
			}
			if(ord($params['password'][$i])==92 && $if_b_slash)
			{
				$if_b_slash = false;
				$errors .= "Password should not have backward slash!<br>";
			}
			if(ord($params['password'][$i])==36 && $if_dollar)
			{
				$if_dollar = false;
				$errors .= "Password should not have Dollar sign!<br>";
			}
		}
		
		
		
		if(empty($errors))
		{
			$response = array(
				'success' => TRUE,
				'errors' => '',
			);
			return $response;
		}
		else
		{
			$response = array(
				'success' => FALSE,
				'errors' => $errors,
			);
			return $response;
		}
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
