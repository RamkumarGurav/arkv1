<?php
# Same Model we are using for Reports section
class Ajax_Model extends CI_Model
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
}

?>
