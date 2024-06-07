<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Configuration
{
	private $CI;
	public $session_uid = '';
	public $session_name = '';
	public $session_email = '';
	function __construct() 
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->_set_configuration();
	}
	
	function _set_configuration($params = array())
	{
		$query = 'SELECT
			configuration.id,
			configuration.name,
			configuration.status,
			concat(\'{\', GROUP_CONCAT(concat(\'"\', configuration_data.name, \'":"\', configuration_data.value, \'"\')) ,\'}\') as config_data
		FROM
			configuration
		JOIN configuration_data ON configuration_data.configuration_id = configuration.id
		group by configuration.id';
		$query_data = $this->CI->db->query($query);
		$response = (array)$query_data->result();
		foreach($response as $key => $value)
		{
			defined($value->name)  OR define($value->name, $value->status);
			$config_data = json_decode($value->config_data, true);
			foreach($config_data as $cd_key => $cd_value)
			{
				defined($cd_key)  OR define($cd_key, $cd_value);
			}
			if($value->id == 1)
			{
				define('__sms_user_id__', _sms_userid);
				define('__sms_user_password__', _sms_password);
			}
			else if($value->id == 2)
			{
				define('__email_user_id__', _email_userid);
				define('__email_user_password__', _email_password);
			}
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

}
