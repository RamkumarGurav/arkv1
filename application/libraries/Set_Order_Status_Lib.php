<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Set_Order_Status_Lib
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
	
	function add_new_order_history($params = array())
	{
		if(empty($params['order_status_id'])||empty($params['orders_id'])){return false;}
		
		$caption='';			if(!empty($params['caption'])){$caption = $params['caption'];}
		$description='';		if(!empty($params['description'])){$description = $params['description'];}
		$remarks='';			if(!empty($params['remarks'])){$remarks = $params['remarks'];}
		$long_description='';	if(!empty($params['long_description'])){$long_description = $params['long_description'];}
		$updated_by=0;			if(!empty($params['updated_by'])){$updated_by = $params['updated_by'];}
		$data_orders_history['caption'] = $caption;
		$data_orders_history['description'] = $description;
		$data_orders_history['order_status_id'] = $params['order_status_id'];
		$data_orders_history['orders_id'] = $params['orders_id'];
		$data_orders_history['remarks'] = $remarks;
		$data_orders_history['long_description'] = $long_description;
		$data_orders_history['updated_on'] = date('Y-m-d H:i:s');;
		$data_orders_history['updated_by'] = $updated_by;
		$orders_history_id=$insertStatus = $this->add_operation(array('table'=>'orders_history' , 'data'=>$data_orders_history));
		return $orders_history_id;
	}
	
	function add_new_order_docket_history($params = array())
	{
		if(empty($params['order_status_id'])||empty($params['orders_id'])){return false;}
		
		$caption='';			if(!empty($params['caption']))		{$caption = $params['caption'];}
		$description='';		if(!empty($params['description']))	{$description = $params['description'];}
		$remarks='';			if(!empty($params['remarks']))		{$remarks = $params['remarks'];}
		$posted_data='';		if(!empty($params['posted_data']))	{$posted_data = $params['posted_data'];}
		$response='';			if(!empty($params['response']))		{$response = $params['response'];}
		$docket_no='';			if(!empty($params['docket_no']))	{$docket_no = $params['docket_no'];}
		$courier_name='';		if(!empty($params['courier_name']))	{$courier_name = $params['courier_name'];}
		$updated_by=0;			if(!empty($params['updated_by']))	{$updated_by = $params['updated_by'];}
		$posted_data=0;			if(!empty($params['posted_data']))	{$posted_data = $params['posted_data'];}
		
		$data_order_docket_history['posted_data'] = $posted_data;
		$data_order_docket_history['caption'] = $caption;
		$data_order_docket_history['description'] = $description;
		$data_order_docket_history['order_status_id'] = $params['order_status_id'];
		$data_order_docket_history['orders_id'] = $params['orders_id'];
		$data_order_docket_history['remarks'] = $remarks;
		$data_order_docket_history['posted_data'] = $posted_data;
		$data_order_docket_history['response'] = $response;
		$data_order_docket_history['docket_no'] = $docket_no;
		$data_order_docket_history['courier_name'] = $courier_name;
		$data_order_docket_history['updated_on'] = date('Y-m-d H:i:s');;
		$data_order_docket_history['updated_by'] = $updated_by;
		$orders_docket_history_id= $this->add_operation(array('table'=>'orders_docket_history' , 'data'=>$data_order_docket_history));
		return $orders_docket_history_id;
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
