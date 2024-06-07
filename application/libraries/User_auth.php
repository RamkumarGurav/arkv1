<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_auth
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
		$this->CI->load->model('administrator/Admin_Common_Model');

		$this->session_uid=$this->CI->session->userdata('sess_psts_uid');
		$this->session_name=$this->CI->session->userdata('sess_psts_name');
		$this->session_email=$this->CI->session->userdata('sess_psts_email');
		$this->sess_company_profile_id=$this->CI->session->userdata('sess_company_profile_id');
	}

	function check_user_status()
	{
		$this->data['user_data']='';		
		if($this->session_uid > 0 && !empty($this->session_name)){
			$this->data['user_data'] = $this->CI->Admin_Common_Model->get_admin_user_data(array());			
			if(!empty($this->data['user_data']))
			{
				if($this->data['user_data']->status!=1)
				{
					$this->unset_only();
					$this->CI->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> You are blocked by Management.
					</div>');
					$this->CI->session->unset_userdata('sess_psts_uid');	
					$this->CI->session->unset_userdata('sess_psts_uid');	
					REDIRECT(MAINSITE_Admin.'login');
				}
			}
			else
			{
				$this->unset_only();
				$this->CI->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again.
				</div>');
				$this->CI->session->unset_userdata('sess_psts_uid');	
				REDIRECT(MAINSITE_Admin.'login');
			}
			
		}
		else
		{
			$this->unset_only();
			$this->CI->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<i class="icon fas fa-ban"></i> Session Out Please Try Again.
			</div>');
			$this->CI->session->unset_userdata('sess_psts_uid');	
			REDIRECT(MAINSITE_Admin.'login');
		}

		$screen_lock = $this->CI->session->userdata('screen_lock');
		if(!empty($screen_lock))
		{
			REDIRECT(MAINSITE_Admin.'Screen-Lock');
		}
		

		return $this->data['user_data'];
	}

	function unset_only() {
		$user_data = $this->CI->session->all_userdata();
		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->CI->session->unset_userdata($key);
			}
		}
	}

	function get_left_menu($is_master , $params = array() , $module_id=0)
	{
		if(!empty($is_master) || true)
		{
			$menu = $this->CI->Admin_Common_Model->get_left_menu(array("is_master"=>$is_master , "module_id"=>$module_id));
			//$menu[] = $menu[0]->submenu;
			$display_menu="";

			foreach($menu as $m)
			{
				if(!empty($m->submenu))
				{
					$display_menu.=$this->get_main_menu_html($m , $params);
				}
				else
				{
					$display_menu.=$this->get_sub_menu_html($m , $params);
				}
			}

			return $display_menu;
		}
		else
		{
			return false;
		}
	}

	function get_main_menu_html($obj , $params){
		$active = "";
		$is_menu = '';
		//if() menu-open active
		$link = MAINSITE_Admin.$obj->class_name.'/'.$obj->function_name;

		$html ='<li class="nav-item has-treeview '.$is_menu.'">
			<a href="#" class="nav-link '.$active.'">
				<i class="nav-icon fas fa-circle"></i>
				<p>
				'.$obj->module_name;
		$html .='<i class="right fas fa-angle-left"></i>';
		if(!empty($obj->data_count))
		{
			$html .='<span class="badge badge-info right">'.$obj->data_count.'</span>';
		}
		$html .='</p></a><ul class="nav nav-treeview">';
			foreach($obj->submenu as $s)
			{
				$html .= $this->get_sub_menu_html($s , $params);
			}
		$html .= "</ul></li>";
		return $html;
	}

	function get_sub_menu_html($obj , $params){
		$active = "";
		if(!empty($params['page_module_id']))
		{
			if($params['page_module_id'] == $obj->module_id)
			{
				$active = "active";
			}
		}
		$link = MAINSITE_Admin.$obj->class_name.'/'.$obj->function_name;
		$html = '<li class="nav-item"><a href="'.$link.'" class="nav-link '.$active.'">';
		if(!empty($obj->icon))
		{
			$nav_icon = $obj->icon;
			$nav_icon = str_replace('#mainsite#' , base_url() , $nav_icon);
			$html .= $nav_icon;
		}
		else
			{$html .= '<i class="far fa-circle nav-icon"></i>';}
		$html .= '<p>'.$obj->module_name; 
		if(!empty($obj->data_count))
		{
			$html .='<span class="badge badge-info right">'.$obj->data_count.'</span>';
		}
		$html .="</p></a></li>";
		return $html;
	}

	function check_user_access($params = array())
	{
		if(!empty($params))
		{
			$menu = $this->CI->Admin_Common_Model->check_user_access($params);
			return $menu;
		}
		else
		{
			return false;
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

		$work_year = date('Y');
        $result['work_year'] = $work_year;
		$result['start'] = $start;
		$result['end'] = $end;
		$result['short_start'] = $s_start;
		$result['short_end'] = $s_end;
		$result['financial_year'] = $work_year;
		$result['short_financial_year'] = $s_start.'-'.$s_end;
		
        return (object)$result;
	}
	
	// $mydate = new fiscalYear();    // will default to the current date time
	// $mydate->setDate(2011, 3, 31); //if you don't do this
	// $result = $mydate->getFiscalYear();
	// var_dump(date(DATE_RFC3339, $result['start']));
	// var_dump(date(DATE_RFC3339, $result['end']));
}
