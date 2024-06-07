<?php

include_once(APPPATH.'models/administrator/Database_Tables.php');

class Admin_model extends Database_Tables

{

	function __construct()

    {

        //parent::__construct();
		$this->db->query("SET sql_mode = ''");

  	}

	var $product_image_table_name = 'product_image';
	var $gallery_table_name = 'gallery';

	var $product_category_table_name = 'product_category';



	function getAdminDetails($params = array())

	{

		$this->db

		->select("a.*")

		->from($this->db->dbprefix."ans_admin_login_details as a")

		->where("a.admin_login_details_id" , $params['admin_login_details_id']);

		$data = $this->db->get()->result();

		$data = $data[0];

		return $data;

	}





	function getDashboardCount()

	{

		$data = array();

		$this->db

		->select('count(orders_id) as counts')

		->from('orders');

		$result = $this->db->get()->result();

		$data['orders'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders');

		$this->db->where("added_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)");

		$result = $this->db->get()->result();

		$data['orders_new'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders')

		->where('order_status' , 2);

		$result = $this->db->get()->result();

		$data['inprocess'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders')

		->where('order_status' , 2)

		->where("added_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)");

		$result = $this->db->get()->result();

		$data['inprocess_new'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders')

		->where('order_status' , 3);

		$result = $this->db->get()->result();

		$data['OutForDelivery'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders')

		->where('order_status' , 3)

		->where("added_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)");

		$result = $this->db->get()->result();

		$data['OutForDelivery_new'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders')

		->where('order_status' , 4);

		$result = $this->db->get()->result();

		$data['Delivered'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders')

		->where('order_status' , 4)

		->where("added_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)");

		$result = $this->db->get()->result();

		$data['Delivered_new'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders')

		->where('order_status' , 5);

		$result = $this->db->get()->result();

		$data['NotDelivered'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders')

		->where('order_status' , 5)

		->where("added_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)");

		$result = $this->db->get()->result();

		$data['NotDelivered_new'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders')

		->where('order_status' , 6);

		$result = $this->db->get()->result();

		$data['cancle'] = $result[0]->counts;



		$this->db

		->select('count(orders_id) as counts')

		->from('orders')

		->where('order_status' , 6)

		->where("added_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)");

		$result = $this->db->get()->result();

		$data['cancle_new'] = $result[0]->counts;



		$this->db

		->select('count(customers_id) as counts')

		->from('customers');

		$result = $this->db->get()->result();

		$data['customers'] = $result[0]->counts;



		$this->db

		->select('count(customers_id) as counts')

		->from('customers');

		$this->db->where("added_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)");

		$result = $this->db->get()->result();

		$data['customers_new'] = $result[0]->counts;



		return $data;

	}



	function chkLogin($params = array())

	{	//echo $user_pwd;

		//$this->db->where('user_status', '1');

		$this->db->where('username', $_POST['username']);

		$this->db->where('password', base64_encode($_POST['password']));

		$query_chk_login = $this->db->get($this->db->dbprefix."ans_admin_login_details");

		//echo "sddfdf".$query_chk_login->num_rows();

		$chkLogin=0;

		$first_name="";

		if($query_chk_login->num_rows() > 0 )

		{

			$row_chk_login = $query_chk_login->row();

			$admin_login_details_id = $row_chk_login->admin_login_details_id;

			$admin_name = $row_chk_login->admin_name;

			$username = $row_chk_login->username;

			$email = $row_chk_login->email;

			$status = $row_chk_login->status;

			$user_type = $row_chk_login->user_type;



			if($status=='Block')

			{

				return 'Block';

			}



			//$this->db->where('user_id', $user_id);

			//$query_get_user_details = $this->db->get($this->ks_login_detail_table_name);

			//$row_get_name = $query_get_user_details->row();

			//$sess_temp_cust_id=$this->session->userdata('sess_temp_cust_id'); //echo "sddfdf".$sess_temp_cust_id;

			$this->session->set_userdata('sess_user_id',$admin_login_details_id);

			$this->session->set_userdata('sess_user_name',$admin_name);

			$this->session->set_userdata('sess_user_status',$status);

			$this->session->set_userdata('sess_user_type',$user_type);

			$chkLogin = 1;



		}

		return $chkLogin;

	}



	function changePassword($admin_user_id,$admin_user_name,$password,$new_password,$new_admname)

	{

		$this->db->where('user_id', '1');

		$this->db->where('login_id', $admin_user_name);

		$this->db->where('password', $password);

		$query_chk_login = $this->db->get($this->ks_login_detail_table_name);





		$msg="";

		if($query_chk_login->num_rows() > 0 )

		{

			$data = array('password' => $new_password, 'login_id'=>$new_admname);

			$this->db->where('user_id', $admin_user_id);

			$this->db->where('login_id', $admin_user_name);

			$status = $this->db->update($this->ks_login_detail_table_name, $data);



			if($status == 1){

			$msg="Password Change Successfully";}else{$msg="error in updating this input";}



		}else{$msg="You have entered wrong current password";}

		return $msg;

	}





	function changeUserPassword($customer_user_id,$customer_user_name,$password,$new_password)

	{

		$this->db->where('user_id', $customer_user_id);

		$this->db->where('login_id', $customer_user_name);

		$this->db->where('password', $password);

		$query_chk_login = $this->db->get($this->login_table_name);





		$msg="";

		if($query_chk_login->num_rows() > 0 )

		{

			$data = array('password' => $new_password);

			$this->db->where('user_id', $customer_user_id);

			$this->db->where('login_id', $customer_user_name);

			$status = $this->db->update($this->login_table_name, $data);



			if($status == 1){

			$msg="Password Change Successfully";}else{$msg="error in updating this input";}



		}else{$msg="You have entered wrong current password";}

		return $msg;

	}





	function menucount($tablename , $tablePrimaryKey , $status , $search1 , $search2)

	{

		$total_count=0;

		$tablename = $tablename."_table_name";

		$tablePrimaryKey = !empty($tablePrimaryKey)?$tablePrimaryKey:'*';

	    $this->db->select("count($tablePrimaryKey) as total");

		$query_get_count = $this->db->get($this->$tablename);



		if($query_get_count->num_rows() > 0 )

		{

			$row_get_count = $query_get_count->row();

			$total_count = $row_get_count->total;

		}

		return $total_count;

	}





	function totalcount($id,$ctg)

	{

		if($ctg=='registered_users'){

	    $this->db->select('count(user_id) as total');

		$this->db->where('login_status = 1');

		$query_get_count = $this->db->get($this->employee_table_name);}



		if($query_get_count->num_rows() > 0 )

		{

			$row_get_count = $query_get_count->row();

			$total_count = $row_get_count->total;

		}

		return $total_count;

	}



	function totalCountSearch($id,$ctg,$data)

	{

		/*if($ctg=='category'){

	    $this->db->select('count(category_id) as total');

		$this->db->where("category_name like '%$data%'");

		$query_get_count = $this->db->get($this->category_table_name);}



		if($query_get_count->num_rows() > 0 )

		{

			$row_get_count = $query_get_count->row();

			$total_count = $row_get_count->total;

		}*/

		return $total_count;

	}



	function getListSearch_to_delete($category, $id, $num, $offset, $search1='', $search2='', $search3='', $search4='', $search5='', $status='')

	{

		$pg_content = array();

		if($category == 'country_list')

		{

			$query_get_list = $this->db->get($this->country_table_name);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("country_id"=>$row_get_list->country_id, "country_name"=>$row_get_list->country_name, "status"=>$row_get_list->status, "added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'all_country_list')

		{

			$this->db->limit($num, $offset);

			$this->db->order_by('country_id desc');

			$query_get_list = $this->db->get($this->country_table_name);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("country_id"=>$row_get_list->country_id,"country_name"=>$row_get_list->country_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'country_details')

		{

			$this->db->where('country_id', $id);

			$query_get_list = $this->db->get($this->country_table_name);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("country_id"=>$row_get_list->country_id,"country_name"=>$row_get_list->country_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'attributes_input_list')

		{

			$query_get_list = $this->db->get($this->attributes_input_table_name);

			//echo $this->db->last_query();

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("attributes_input_id"=>$row_get_list->attributes_input_id, "name"=>$row_get_list->name,"type"=>$row_get_list->type);

				}

			}

		}



		else if($category == 'country_names_list')

		{

			$this->db->where('status', 1);

			$this->db->order_by('country_name asc');

			$query_get_list = $this->db->get($this->country_table_name);

			//echo $this->db->last_query();

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("country_id"=>$row_get_list->country_id, "country_name"=>$row_get_list->country_name,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on,"status"=>$row_get_list->status);

				}

			}

		}

		else if($category == 'state_list')

		{

			$sql_get_list="SELECT p.state_id, p.country_id, p.state_name, p.status, p.added_on, p.updated_on,  p.added_by, p.updated_by, c.country_name from state p, country c where p.country_id=c.country_id order by p.state_id desc";



			$query_get_list=$this->db->query($sql_get_list);



			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("state_id"=>$row_get_list->state_id, "country_id"=>$row_get_list->country_id, "state_name"=>$row_get_list->state_name, "status"=>$row_get_list->status, "added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'all_state_list')

		{

			$sql_get_list="SELECT p.state_id, p.country_id, p.state_name, p.status, p.added_on, p.updated_on,  p.added_by, p.updated_by, c.country_name from state p, country c where p.country_id=c.country_id and p.state_id ";

			if(!empty($search1))

			{

				$sql_get_list.=" and p.status = $search1 ";

			}

			$sql_get_list.=" order by p.state_id desc ";

$query_get_list=$this->db->query($sql_get_list);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("state_id"=>$row_get_list->state_id,"country_id"=>$row_get_list->country_id,"country_name"=>$row_get_list->country_name,"state_name"=>$row_get_list->state_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'state_details')

		{

			//$this->db->where('state_id', $id);

			$sql_get_list="select p.* , c.country_name as country_name from state p, country c where p.country_id=c.country_id and p.state_id = $id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("state_id"=>$row_get_list->state_id,"state_name"=>$row_get_list->state_name,"country_id"=>$row_get_list->country_id,"country_name"=>$row_get_list->country_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		    }

		}

		else if($category == 'product_attribute_details' && !empty($id))

		{

			$this->db->distinct();

			$this->db->select('pa.*,ai.name as ai_name , (select Un.login_id from ks_login_detail as Un where pa.updated_by != 0 and pa.updated_by = Un.user_id) as updated_by_name , (select Un.login_id from ks_login_detail as Un where pa.added_by != 0 and pa.added_by = Un.user_id) as added_by_name ');//,  as updated_by_name, An.login_id as added_by_name

			$this->db->from("$this->product_attribute_table_name AS pa");

			$this->db->join("$this->attributes_input_table_name as ai", 'ai.attributes_input_id = pa.attributes_input_id');

			if(!empty($id)){

				$whr_clause="pa.product_attribute_id = '$id' ";

				$this->db->where($whr_clause);

			}

			$query_get_list = $this->db->get();

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

				$pg_content[]=array("product_attribute_id"=>$row_get_list->product_attribute_id,"attributes_input_id"=>$row_get_list->attributes_input_id,"name"=>$row_get_list->name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"ai_name"=>$row_get_list->ai_name,"added_by"=>$row_get_list->added_by,"updated_by"=>$row_get_list->updated_by,"updated_by_name"=>$row_get_list->updated_by_name,"added_by_name"=>$row_get_list->added_by_name,"condition_per_product"=>$row_get_list->condition_per_product);

				}

			}

		}



		else if($category == 'all_product_attribute_list')

		{

			$this->db->distinct();

			$this->db->select('pa.*,ai.name as ai_name,ai.type , (select count(product_attribute_value_id) from product_attribute_value as pav where pav.product_attribute_id=pa.product_attribute_id) as product_attribute_value_count');

			$this->db->from("$this->product_attribute_table_name AS pa");

			$this->db->join("$this->attributes_input_table_name as ai", 'ai.attributes_input_id = pa.attributes_input_id');

			if(!empty($status)){

				$whr_clause="pa.status = '$status'  ";

				$this->db->where($whr_clause);

			}

			//$this->db->where('country_id', $id);

			$query_get_list = $this->db->get();

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

				$pg_content[]=array("product_attribute_id"=>$row_get_list->product_attribute_id,"attributes_input_id"=>$row_get_list->attributes_input_id,"name"=>$row_get_list->name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"ai_name"=>$row_get_list->ai_name,"type"=>$row_get_list->type,"product_attribute_value_count"=>$row_get_list->product_attribute_value_count,"condition_per_product"=>$row_get_list->condition_per_product);

				}

			}

		}



		else if($category == 'attribute_value_details' && !empty($id))

		{

			$this->db->distinct();

			$this->db->select('ai.*,pa.name as attribute_name , (select Un.login_id from ks_login_detail as Un where ai.updated_by != 0 and ai.updated_by = Un.user_id) as updated_by_name , (select Un.login_id from ks_login_detail as Un where ai.added_by != 0 and ai.added_by = Un.user_id) as added_by_name ');

			$this->db->from("$this->product_attribute_table_name AS pa");

			$this->db->join("$this->product_attribute_value_table_name as ai", 'ai.product_attribute_id = pa.product_attribute_id');

				$whr_clause="ai.product_attribute_value_id = '$id' ";

				$this->db->where($whr_clause);

			//$this->db->where('country_id', $id);

			$query_get_list = $this->db->get();

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

				$pg_content[]=array("product_attribute_id"=>$row_get_list->product_attribute_id,"product_attribute_value_id"=>$row_get_list->product_attribute_value_id,"name"=>$row_get_list->name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"attribute_name"=>$row_get_list->attribute_name,"color_name"=>$row_get_list->color_name,"added_by"=>$row_get_list->added_by,"updated_by"=>$row_get_list->updated_by,"updated_by_name"=>$row_get_list->updated_by_name,"added_by_name"=>$row_get_list->added_by_name);

				}

			}

		}



		else if($category == 'all_attribute_value_list')

		{

			$this->db->distinct();

			$this->db->select('ai.*,pa.name as attribute_name ');

			$this->db->from("$this->product_attribute_table_name AS pa");

			$this->db->join("$this->product_attribute_value_table_name as ai", 'ai.product_attribute_id = pa.product_attribute_id');

			if(!empty($id)){

				$whr_clause="ai.product_attribute_id = '$id' ";

				$this->db->where($whr_clause);

			}

			if(!empty($status)){

				$whr_clause="ai.status = '$status' ";

				$this->db->where($whr_clause);

			}

			//$this->db->where('country_id', $id);

			$query_get_list = $this->db->get();

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

				$pg_content[]=array("product_attribute_id"=>$row_get_list->product_attribute_id,"product_attribute_value_id"=>$row_get_list->product_attribute_value_id,"name"=>$row_get_list->name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"attribute_name"=>$row_get_list->attribute_name,"color_name"=>$row_get_list->color_name);

				}

			}

		}



		else if($category == 'register_state_list')

		{

			$this->db->distinct();

			$this->db->select('cou.country_id,cou.status,s.state_id,s.country_id,s.state_name,s.status');

			$this->db->from("$this->country_table_name AS cou");

			$this->db->join("$this->state_table_name as s", 'cou.country_id = s.country_id');

			$whr_clause="cou.country_id = '$id' and cou.status=1 and s.status=1";

			$this->db->where($whr_clause);

			//$this->db->where('country_id', $id);

			$query_get_list = $this->db->get();

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

				$pg_content[]=array("state_id"=>$row_get_list->state_id,"country_id"=>$row_get_list->country_id,"state_name"=>$row_get_list->state_name	,"status"=>$row_get_list->status);

				}

			}

		}



		else if($category == 'city_list')

		{

			$sql_get_list="SELECT p.city_id, p.state_id, p.country_id, p.city_name, p.status, p.added_on, p.updated_on,  p.added_by, p.updated_by, c.country_name ,s.state_name from city p, state s, country c where p.country_id=c.country_id and p.city_id order by p.city_id desc";



			$query_get_list=$this->db->query($sql_get_list);



			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("city_id"=>$row_get_list->city_id, "country_id"=>$row_get_list->country_id, "city_name"=>$row_get_list->city_name,"state_name"=>$row_get_list->state_name, "status"=>$row_get_list->status, "added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'all_city_list')

		{

			$sql_get_list="SELECT p.city_id, p.state_id, p.country_id, p.city_name, p.status, p.added_on, p.updated_on,  p.added_by, p.updated_by, c.country_name, s.state_name from city p, state s, country c where p.country_id=c.country_id and p.state_id=s.state_id and p.city_id order by p.city_id desc ";

			$query_get_list=$this->db->query($sql_get_list);



			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("city_id"=>$row_get_list->city_id,"state_id"=>$row_get_list->state_id,"country_id"=>$row_get_list->country_id,"country_name"=>$row_get_list->country_name,"city_name"=>$row_get_list->city_name,"state_name"=>$row_get_list->state_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'city_details')

		{

			//$this->db->where('city_id', $id);

			$sql_get_list="select p.* , c.country_name as country_name, s.state_name as state_name from city p, state s, country c where p.country_id=c.country_id and p.city_id = $id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("city_id"=>$row_get_list->city_id,"country_id"=>$row_get_list->country_id,"country_name"=>$row_get_list->country_name,"state_id"=>$row_get_list->state_id,"city_name"=>$row_get_list->city_name,"state_name"=>$row_get_list->state_name,"status"=>$row_get_list->status,"image"=>$row_get_list->image);

				}

			}

		    }

		}

		else if($category == 'state_names_list')

		{

			$this->db->where('status = 1');

			$this->db->order_by('state_name asc');

			$query_get_list = $this->db->get($this->state_table_name);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("state_id"=>$row_get_list->state_id, "state_name"=>$row_get_list->state_name,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on,"status"=>$row_get_list->status);

				}

			}

		}

		else if($category == 'location_list')

		{

			$sql_get_list="SELECT p.location_id, p.city_id, p.state_id, p.country_id, p.location_name, p.status, p.added_on, p.updated_on,  p.added_by, p.updated_by, c.country_name, s.state_name, ci.city_name from location p, state s, country c, city ci where p.country_id=c.country_id and p.location_id order by p.location_id desc";



			$query_get_list=$this->db->query($sql_get_list);



			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("location_id"=>$row_get_list->location_id, "state_id"=>$row_get_list->state_id, "city_id"=>$row_get_list->city_id, "country_id"=>$row_get_list->country_id, "location_name"=>$row_get_list->location_name, "city_name"=>$row_get_list->city_name,"state_name"=>$row_get_list->state_name, "status"=>$row_get_list->status, "added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'all_location_list')

		{

			$sql_get_list="SELECT p.location_id, p.city_id, p.state_id, p.country_id, p.location_name, p.location_pincode, p.status, p.added_on, p.updated_on,  p.added_by, p.updated_by, c.country_name, s.state_name, ci.city_name from location p, state s, country c, city ci where p.country_id=c.country_id and p.state_id=s.state_id  and p.city_id=ci.city_id and p.location_id";

			if(!empty($search1))

			{

				$sql_get_list.=" and p.city_id=$search1 ";

			}

			$sql_get_list.=" order by p.location_id desc ";

			$query_get_list=$this->db->query($sql_get_list);



			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("location_id"=>$row_get_list->location_id,"city_id"=>$row_get_list->city_id,"state_id"=>$row_get_list->state_id,"country_id"=>$row_get_list->country_id,"country_name"=>$row_get_list->country_name,"location_name"=>$row_get_list->location_name,"location_pincode"=>$row_get_list->location_pincode,"city_name"=>$row_get_list->city_name,"state_name"=>$row_get_list->state_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'location_details')

		{

			//$this->db->where('city_id', $id);

			$sql_get_list="select p.* , c.country_name as country_name, s.state_name as state_name, ci.city_name as city_name from location p, state s, country c, city ci where p.country_id=c.country_id and p.location_id = $id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("location_id"=>$row_get_list->location_id,"city_id"=>$row_get_list->city_id,"country_id"=>$row_get_list->country_id,"country_name"=>$row_get_list->country_name,"state_id"=>$row_get_list->state_id,"city_name"=>$row_get_list->city_name,"location_name"=>$row_get_list->location_name,"location_pincode"=>$row_get_list->location_pincode,"state_name"=>$row_get_list->state_name,"status"=>$row_get_list->status);

				}

			}

		    }

		}

		else if($category == 'city_names_list')

		{

			$this->db->where('status = 1');

			$this->db->order_by('city_name asc');

			$query_get_list = $this->db->get($this->city_table_name);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("city_id"=>$row_get_list->city_id, "city_name"=>$row_get_list->city_name,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on,"status"=>$row_get_list->status);

				}

			}

		}

		else if($category == 'register_city_list')

		{

			//echo "id : $id </br>";

			$this->db->distinct();

			$this->db->select('s.state_id,s.state_name,s.status,ci.city_id,ci.city_name,ci.status');

			$this->db->from("$this->city_table_name AS ci");

			$this->db->join("$this->state_table_name as s", 'ci.state_id = s.state_id');

			$whr_clause="s.state_id = '$id' and s.status=1 and ci.status=1";

			$this->db->where($whr_clause);

			//$this->db->where('country_id', $id);

			$query_get_list = $this->db->get();

			//echo $this->db->last_query();

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

				$pg_content[]=array("city_id"=>$row_get_list->city_id,"state_id"=>$row_get_list->state_id,"country_id"=>$row_get_list->country_id,"city_name"=>$row_get_list->city_name,"status"=>$row_get_list->status);

				}

			}

		}



		else if($category == 'all_tax_categories_list')

		{

			$sql_get_list="SELECT p.* from tax_categories p order by p.tax_categories_id desc ";

$query_get_list=$this->db->query($sql_get_list);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("tax_categories_id"=>$row_get_list->tax_categories_id,"tax_categories_name"=>$row_get_list->tax_categories_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'tax_categories_details')

		{

			$sql_get_list="select p.* from tax_categories p where p.tax_categories_id = $id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("tax_categories_id"=>$row_get_list->tax_categories_id,"tax_categories_name"=>$row_get_list->tax_categories_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		    }

		}

		else if($category == 'all_tax_providers_list')

		{

			$sql_get_list="SELECT p.tax_providers_id, p.tax_categories_id, p.tax_providers_percentage, p.status, p.added_on, p.updated_on,  p.added_by, p.updated_by, c.tax_categories_name from tax_providers p, tax_categories c where p.tax_categories_id=c.tax_categories_id order by p.tax_providers_id desc ";

			$query_get_list=$this->db->query($sql_get_list);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("tax_providers_id"=>$row_get_list->tax_providers_id,"tax_categories_id"=>$row_get_list->tax_categories_id,"tax_providers_percentage"=>$row_get_list->tax_providers_percentage,"tax_categories_name"=>$row_get_list->tax_categories_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'tax_providers_details')

		{

			//$this->db->where('state_id', $id);

			$sql_get_list="select p.* , c.tax_categories_name as tax_categories_name from tax_providers p, tax_categories c where p.tax_categories_id=c.tax_categories_id and p.tax_providers_id = $id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("tax_providers_id"=>$row_get_list->tax_providers_id,"tax_categories_name"=>$row_get_list->tax_categories_name,"tax_categories_id"=>$row_get_list->tax_categories_id,"tax_providers_percentage"=>$row_get_list->tax_providers_percentage,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		    }

		}

		else if($category == 'all_manufacturer_list')

		{

			$sql_get_list="SELECT p.* from manufacturer p order by p.manufacturer_id desc ";

$query_get_list=$this->db->query($sql_get_list);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("manufacturer_id"=>$row_get_list->manufacturer_id,"manufacturer_name"=>$row_get_list->manufacturer_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'manufacturer_details')

		{

			$sql_get_list="select p.* from manufacturer p where p.manufacturer_id = $id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("manufacturer_id"=>$row_get_list->manufacturer_id,"manufacturer_name"=>$row_get_list->manufacturer_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		    }

		}

		else if($category == 'all_main_category_list')

		{

			$sql_get_list="SELECT p.* from main_category p order by p.main_category_id desc ";

$query_get_list=$this->db->query($sql_get_list);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("main_category_id"=>$row_get_list->main_category_id,"main_category_name"=>$row_get_list->main_category_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'main_category_details')

		{

			$sql_get_list="select p.* from main_category p where p.main_category_id = $id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("main_category_id"=>$row_get_list->main_category_id,"main_category_name"=>$row_get_list->main_category_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		    }

		}

		else if($category == 'all_sub_category_list')

		{

			$sql_get_list="SELECT p.sub_category_id, p.main_category_id, p.sub_category_name, p.sub_category_image, p.status, p.added_on, p.updated_on,  p.added_by, p.updated_by, c.main_category_name from sub_category p, main_category c where p.main_category_id=c.main_category_id and p.sub_category_id order by p.sub_category_id desc ";

$query_get_list=$this->db->query($sql_get_list);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("sub_category_id"=>$row_get_list->sub_category_id,"main_category_id"=>$row_get_list->main_category_id,"main_category_name"=>$row_get_list->main_category_name,"sub_category_name"=>$row_get_list->sub_category_name,"sub_category_image"=>$row_get_list->sub_category_image,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'sub_category_details')

		{

			$sql_get_list="select p.* , c.main_category_name as main_category_name from sub_category p, main_category c where p.main_category_id=c.main_category_id and p.sub_category_id = $id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("sub_category_id"=>$row_get_list->sub_category_id,"sub_category_name"=>$row_get_list->sub_category_name,"sub_category_image"=>$row_get_list->sub_category_image,"main_category_id"=>$row_get_list->main_category_id,"main_category_name"=>$row_get_list->main_category_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		    }

		}

		else if($category == 'main_category_names_list')

		{

			$this->db->where('status', 1);

			$this->db->order_by('main_category_name asc');

			$query_get_list = $this->db->get($this->main_category_table_name);

			//echo $this->db->last_query();

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("main_category_id"=>$row_get_list->main_category_id, "main_category_name"=>$row_get_list->main_category_name,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on,"status"=>$row_get_list->status);

				}

			}

		}

		else if($category == 'all_super_sub_category_list')

		{

			$sql_get_list="SELECT p.super_sub_category_id, p.sub_category_id, p.main_category_id, p.super_sub_category_name, p.status, p.added_on, p.updated_on,  p.added_by, p.updated_by, c.main_category_name, s.sub_category_name from super_sub_category p, sub_category s, main_category c where p.main_category_id=c.main_category_id and p.sub_category_id=s.sub_category_id and p.super_sub_category_id order by p.super_sub_category_id desc ";

			$query_get_list=$this->db->query($sql_get_list);



			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("super_sub_category_id"=>$row_get_list->super_sub_category_id,"sub_category_id"=>$row_get_list->sub_category_id,"main_category_id"=>$row_get_list->main_category_id,"main_category_name"=>$row_get_list->main_category_name,"super_sub_category_name"=>$row_get_list->super_sub_category_name,"sub_category_name"=>$row_get_list->sub_category_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on);

				}

			}

		}

		else if($category == 'super_sub_category_details')

		{

			//$this->db->where('super_sub_category_id', $id);

			$sql_get_list="select p.* , c.main_category_name as main_category_name, s.sub_category_name as sub_category_name from super_sub_category p, sub_category s, main_category c where p.main_category_id=c.main_category_id and p.super_sub_category_id = $id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("super_sub_category_id"=>$row_get_list->super_sub_category_id,"main_category_id"=>$row_get_list->main_category_id,"main_category_name"=>$row_get_list->main_category_name,"sub_category_id"=>$row_get_list->sub_category_id,"super_sub_category_name"=>$row_get_list->super_sub_category_name,"sub_category_name"=>$row_get_list->sub_category_name,"status"=>$row_get_list->status);

				}

			}

		    }

		}

		else if($category == 'register_sub_category_list')

		{

			$this->db->distinct();

			$this->db->select('cou.main_category_id,cou.status,s.sub_category_id,s.main_category_id,s.sub_category_name,s.status');

			$this->db->from("$this->main_category_table_name AS cou");

			$this->db->join("$this->sub_category_table_name as s", 'cou.main_category_id = s.main_category_id');

			$whr_clause="cou.main_category_id = '$id' and cou.status=1 and s.status=1";

			$this->db->where($whr_clause);

			//$this->db->where('main_category_id', $id);

			$query_get_list = $this->db->get();

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

				$pg_content[]=array("sub_category_id"=>$row_get_list->sub_category_id,"main_category_id"=>$row_get_list->main_category_id,"sub_category_name"=>$row_get_list->sub_category_name	,"status"=>$row_get_list->status);

				}

			}

		}

		else if($category == 'sub_category_names_list')

		{

			$this->db->where('status = 1');

			$this->db->order_by('sub_category_name asc');

			$query_get_list = $this->db->get($this->sub_category_table_name);

			if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("sub_category_id"=>$row_get_list->sub_category_id, "sub_category_name"=>$row_get_list->sub_category_name,"added_on"=>$row_get_list->added_on, "updated_on"=>$row_get_list->updated_on,"status"=>$row_get_list->status);

				}

			}

		}





		return $pg_content;

	}



	function deleteRows($category, $id)

   {

   		if( empty($id) || empty($category)) return -1;



		if($category == 'product_category')

		{

			$this->db->where(array('product_id' => $id));

			$status = $this->db->delete($this->product_category_table_name);

		}



		if($category == 'additional_information')

		{

			$this->db->where(array('product_id' => $id));

			$status = $this->db->delete($this->additional_information_table_name);

		}



		if($category == 'product_combination_attribute')

		{

			$this->db->where(array('product_combination_id' => $id));

			$status = $this->db->delete($this->product_combination_attribute_table_name);

		}



		if($category == 'stores_location')

		{

			$this->db->where(array('stores_id' => $id));

			$status = $this->db->delete($this->stores_location_table_name);

		}



		return $status;

   }



   function update($data = array(),$category, $id , $condition)

   {

   		if(empty($data) || empty($condition) || empty($category)) return -1;

		$table_id = $category."_id";

		unset($data[$table_id]);

		unset($data['added_on']);

		unset($data['added_by']);

		$table_name = $category."_table_name";

		$this->db->where($condition);

		$status = $this->db->update($this->$table_name, $data);

		return $status;

   }



	function add($data = array(),$table_name)

	{

    	if(empty($data)) return -1;

		$table_name = $table_name.'_table_name';

		$status = $this->db->insert($this->$table_name, $data);

		if($status){$status = $status = $this->db->insert_id();}

		return $status;

    }



	function getMaxid($id,$table_name)

	{

		$sql_get_maxID = $this->db->select_max($id,'max_id');



			if($table_name == 'register_customer'){

			$query_get_maxID = $this->db->get($this->employee_table_name);}



			if($table_name == 'product_image'){

			$query_get_maxID = $this->db->get($this->product_image_table_name);}

			if($table_name == 'gallery_image')
			{
				$query_get_maxID = $this->db->get($this->gallery_table_name);
			}





			$row_get_maxID = $query_get_maxID->row();

				//$row_get_maxID = $query_get_maxID[0];

			$maxid = $row_get_maxID->max_id;

			if($maxid == "")

			$maxid = 1;

			else

			$maxid = $maxid+1;

			return  $maxid;

	}



	function getMaxPosition($id,$table_name , $where)

	{

		//$sql_get_maxID = $this->db->select_max($id,'max_id');

		$sql_get_maxID = $this->db->select_max($id,'max_id');



		if($table_name == 'product_image_position'){

			$sql_get_maxID = $this->db->where('product_id', $where);

			$query_get_maxID = $this->db->get($this->product_image_table_name);}

		if($table_name == 'gallery_image_position'){

			$sql_get_maxID = $this->db->where('id', $where);

			$query_get_maxID = $this->db->get($this->gallery_table_name);}



		if($table_name == 'category_position'){

			$sql_get_maxID = $this->db->where('super_category_id', $where);

			$query_get_maxID = $this->db->get($this->category_table_name);}





			$row_get_maxID = $query_get_maxID->row();

				//$row_get_maxID = $query_get_maxID[0];

			$maxid = $row_get_maxID->max_id;

			if($maxid == "")

			$maxid = 1;

			else

			$maxid = $maxid+1;

			return  $maxid;

	}



	function getName($id , $table_name)

	{

		$data = '';

		if($table_name == 'product_image')

		{

			$sql_get_list="select product_image_name from product_image where product_image_id = $id";

			$query_get_list=$this->db->query($sql_get_list);

			foreach($query_get_list->result() as $row_get_list)

			{

				$data = $row_get_list->product_image_name;

			}



		}

		return $data;

	}



	function delete($id,$category)

	{

		if(empty($id) || empty($category)) return -1;





		if($category == 'delete_unit'){

			$this->db->where('unit_id', $id);

			$status = $this->db->delete($this->unit_table_name);

		}



		return $status;

	}



	function random_password()

	{

		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

		$password = array();

		$alpha_length = strlen($alphabet) - 1;

		for ($i = 0; $i < 8; $i++)

		{

			$n = rand(0, $alpha_length);

			$password[] = $alphabet[$n];

		}

		return implode($password);

	}



	function getTaxDetails($category, $id='', $status='', $search1='', $search2='', $search3='', $search4='', $search5='', $search6='')

	{

		$pg_content = array();

		if($category == 'tax_categories')

		{

			$sql_get_list="select tc.* from tax_categories as tc where 1 ";

			if(!empty($status))

			{//echo $search1;

				$sql_get_list.= " and tc.status=$status ";

			}

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("tax_categories_id"=>$row_get_list->tax_categories_id,"tax_categories_name"=>$row_get_list->tax_categories_name	,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"added_by"=>$row_get_list->added_by,"updated_on"=>$row_get_list->updated_on,"updated_by"=>$row_get_list->updated_by);

					}

				}

		    }

		}

		if($category == 'tax_providers')

		{

			$sql_get_list="select tp.* from tax_providers as tp where 1 ";

			if(!empty($status))

			{//echo $search1;

				$sql_get_list.= " and tp.status=$status ";

			}

			if(!empty($search1))

			{//echo $search1;

				$sql_get_list.= " and tp.tax_categories_id=$search1 ";

			}

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("tax_providers_id"=>$row_get_list->tax_providers_id,"tax_categories_id"=>$row_get_list->tax_categories_id,"tax_providers_percentage"=>$row_get_list->tax_providers_percentage,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"added_by"=>$row_get_list->added_by,"updated_on"=>$row_get_list->updated_on,"updated_by"=>$row_get_list->updated_by);

					}

				}

		    }

		}

		return $pg_content;

	}



	function category_to_delete($category, $id, $status='', $search1='', $search2='', $search3='', $search4='', $search5='', $search6='')

	{

		$pg_content = array();

		 if($category == 'category_list')

		{

			$sql_get_list="select c.* , (select ca.name from category ca where c.super_category_id=ca.category_id) as super_category_name from category c where 1  ";

			if(!empty($id) && $id != 'parents'){

				$sql_get_list.= " and c.category_id=$id ";

			}

			if(!empty($search1) &&$search1== 'parents')

			{//echo $search1;

				$sql_get_list.= " and c.super_category_id=0 ";

			}

			if(!empty($search1) && $search1 != 'parents'){

				$sql_get_list.= " and c.super_category_id=$search1 ";

			}

			if($search6==1)

			$sql_get_list.= " order by position ASC ";



			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("category_id"=>$row_get_list->category_id,"super_category_id"=>$row_get_list->super_category_id	,"name"=>$row_get_list->name,"cover_image"=>$row_get_list->cover_image,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"added_by"=>$row_get_list->added_by,"updated_by"=>$row_get_list->updated_by,"status"=>$row_get_list->status,"super_category_name"=>$row_get_list->super_category_name,"position"=>$row_get_list->position);

				}

			}

		    }

			return $pg_content;

		}



		if($category == 'category_detail')

		{

			$sql_get_list="select c.* , (select Un.login_id from ks_login_detail as Un where c.updated_by != 0 and c.updated_by = Un.user_id) as updated_by_name , (select Un.login_id from ks_login_detail as Un where c.added_by != 0 and c.added_by = Un.user_id) as added_by_name , (select ca.name from category ca where c.super_category_id=ca.category_id) as super_category_name from category c where 1  ";

			if(!empty($id) && $id != 'parents'){

				$sql_get_list.= " and c.category_id=$id ";

			}

			if($id== 'parents')

			{

				$pg_content[]=array("category_id"=>'parents',"super_category_id"=>'parents',"name"=>'Parent',"cover_image"=>'N/A',"added_on"=>'N/A',"updated_on"=>'N/A',"added_by"=>'N/A',"updated_by"=>'N/A',"status"=>'N/A',"super_category_name"=>'N/A',"updated_by_name"=>'N/A',"added_by_name"=>'N/A');

			}

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0  && $id != 'parents')

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("category_id"=>$row_get_list->category_id,"super_category_id"=>$row_get_list->super_category_id	,"name"=>$row_get_list->name,"cover_image"=>$row_get_list->cover_image,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"added_by"=>$row_get_list->added_by,"updated_by"=>$row_get_list->updated_by,"status"=>$row_get_list->status,"super_category_name"=>$row_get_list->super_category_name,"updated_by_name"=>$row_get_list->updated_by_name,"added_by_name"=>$row_get_list->added_by_name);

					}

				}

		    }

			return $pg_content;

		}



	}



	function products_to_delete($category, $id, $status='', $search1='', $search2='', $search3='', $search4='', $search5='', $search6='')

	{

		$pg_content = array();



		if($category == 'products_list')

		{

			/*$this->db->where("status = 1 ");

			if(!empty($id))

			$this->db->where("product_id = '$id'");

			$query_get_list = $this->db->get($this->product_table_name);*/



			$sql_get_list="select p.product_id , p.manufacturer_id , p.name, p.status , p.ref_code , p.slug_url , p.short_description, p.added_on, m.manufacturer_name from product p , manufacturer as m where m.manufacturer_id=p.manufacturer_id   ";

				$query_get_list=$this->db->query($sql_get_list);

				{

						if($query_get_list->num_rows() > 0 )

						{

								foreach($query_get_list->result() as $row_get_list)

								{

									$content_product_combination=array();

								$sql_get_list1="select pc.* , pi.product_image_name  from product_combination as pc , product_image as pi  where pc.product_id=$row_get_list->product_id and pi.product_image_id = pc.product_image_id order by pc.default_combination DESC ";//echo $sql_get_list1."<br>";

								$query_get_list1=$this->db->query($sql_get_list1);

									if($query_get_list1->num_rows() > 0 )

									{

										foreach($query_get_list1->result() as $row_get_list1)

										{









											$sql_get_list2="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";

												$query_get_list2=$this->db->query($sql_get_list2);

												{

													$combi="";

													if($query_get_list2->num_rows() > 0 )

													{

														foreach($query_get_list2->result() as $row_get_list2)

														{

															//$pg_content[]=array("product_combination_attribute_id"=>$row_get_list->product_combination_attribute_id,"product_id"=>$row_get_list->product_id	,"product_combination_id"=>$row_get_list->product_combination_id,"product_attribute_id"=>$row_get_list->product_attribute_id,"product_attribute_value_id"=>$row_get_list->product_attribute_value_id,"combination_value"=>$row_get_list->combination_value);

															if(!empty($row_get_list2->combination_value))

																$combi .= "$row_get_list2->combination_value";

															if(!empty($row_get_list2->v_name))

																$combi .= "&nbsp;$row_get_list2->v_name";



															$combi .= ", ";

															//echo $combi.'<br>';

														}

													}

												}





											$combi = trim($combi , ', ');





											$content_product_combination[]=array("product_combination_id"=>$row_get_list1->product_combination_id,"product_id"=>$row_get_list1->product_id	,"ref_code"=>$row_get_list1->ref_code,"quantity"=>$row_get_list1->quantity,"price"=>$row_get_list1->price,"discount"=>$row_get_list1->discount,"discount_var"=>$row_get_list1->discount_var,"final_price"=>$row_get_list1->final_price,"status"=>$row_get_list1->status,"added_on"=>$row_get_list1->added_on,"updated_on"=>$row_get_list1->updated_on,"product_image_id"=>$row_get_list1->product_image_id,"default_combination"=>$row_get_list1->default_combination,"comb_slug_url"=>$row_get_list1->comb_slug_url,"product_image_name"=>$row_get_list1->product_image_name,"combi"=>$combi);

										}



										$pg_content[]=array("product_id"=>$row_get_list->product_id,"manufacturer_id"=>$row_get_list->manufacturer_id	,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"slug_url"=>$row_get_list->slug_url,"short_description"=>$row_get_list->short_description,"manufacturer_name"=>$row_get_list->manufacturer_name,"product_combination"=>$content_product_combination,"added_on"=>$row_get_list->added_on,"status"=>$row_get_list->status);



									}

								}

						}

				}



			return $pg_content;

		}

		 if($category == 'product_detail')

		{

			$sql_get_list="select p.* , (select Un.login_id from ks_login_detail as Un where p.updated_by != 0 and p.updated_by = Un.user_id) as updated_by_name , (select Un.login_id from ks_login_detail as Un where p.added_by != 0 and p.added_by = Un.user_id) as added_by_name from product p where 1  ";

			if(!empty($id)){

				$sql_get_list.= " and p.product_id=$id ";

			}

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("product_id"=>$row_get_list->product_id,"manufacturer_id"=>$row_get_list->manufacturer_id	,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"slug_url"=>$row_get_list->slug_url,"short_description"=>$row_get_list->short_description,"description"=>$row_get_list->description,"how_to_use"=>$row_get_list->how_to_use,"tax_categories_id"=>$row_get_list->tax_categories_id,"tax_providers_id"=>$row_get_list->tax_providers_id

						,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"added_by"=>$row_get_list->added_by,"updated_by"=>$row_get_list->updated_by,"status"=>$row_get_list->status,"updated_by_name"=>$row_get_list->updated_by_name,"added_by_name"=>$row_get_list->added_by_name);

					}

				}

		    }

			return $pg_content;

		}



		if($category == 'product_category_detail')

		{

			$sql_get_list="select * from product_category where product_id=$id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("product_category_id"=>$row_get_list->product_category_id,"product_id"=>$row_get_list->product_id	,"category_id"=>$row_get_list->category_id);

					}

				}

		    }

			return $pg_content;

		}



		if($category == 'product_image_detail')

		{

			$sql_get_list="select * from product_image where product_id=$id order by position ASC";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("product_image_id"=>$row_get_list->product_image_id,"product_id"=>$row_get_list->product_id	,"product_image_name"=>$row_get_list->product_image_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"default_image"=>$row_get_list->default_image,"position"=>$row_get_list->position);

					}

				}

		    }

			return $pg_content;

		}



		if($category == 'product_combination_detail')

		{

			$sql_get_list="select * from product_combination where product_id=$id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("product_combination_id"=>$row_get_list->product_combination_id,"product_id"=>$row_get_list->product_id	,"ref_code"=>$row_get_list->ref_code,"quantity"=>$row_get_list->quantity,"price"=>$row_get_list->price,"discount"=>$row_get_list->discount,"discount_var"=>$row_get_list->discount_var,"final_price"=>$row_get_list->final_price,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"product_image_id"=>$row_get_list->product_image_id,"default_combination"=>$row_get_list->default_combination,"comb_slug_url"=>$row_get_list->comb_slug_url);

					}

				}

		    }

			return $pg_content;

		}



		if($category == 'product_combination_attribute_detail')

		{

			$sql_get_list="select * from product_combination_attribute where product_id=$id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("product_combination_attribute_id"=>$row_get_list->product_combination_attribute_id,"product_id"=>$row_get_list->product_id	,"product_combination_id"=>$row_get_list->product_combination_id,"product_attribute_id"=>$row_get_list->product_attribute_id,"product_attribute_value_id"=>$row_get_list->product_attribute_value_id,"combination_value"=>$row_get_list->combination_value);

					}

				}

		    }

			return $pg_content;

		}

	}



	function stores_to_delete($category, $id, $status='', $search1='', $search2='', $search3='', $search4='', $search5='', $search6='')

	{

		$pg_content = array();

		 if($category == 'stores_list')

		{

			$sql_get_list="select s.stores_id , s.name , s.address , s.status , s.added_on , s.person_contact_name , s.person_contact_email , s.person_contact_number , s.person_contact_alt_number , (select state_name from state where s.state_id=state_id) as state  , (select city_name from city where s.city_id=city_id) as city from stores as s where stores_id ";



			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

			{

				foreach($query_get_list->result() as $row_get_list)

				{

					$pg_content[]=array("stores_id"=>$row_get_list->stores_id,"name"=>$row_get_list->name	,"address"=>$row_get_list->address,"person_contact_name"=>$row_get_list->person_contact_name,"person_contact_email"=>$row_get_list->person_contact_email,"person_contact_number"=>$row_get_list->person_contact_number,"person_contact_alt_number"=>$row_get_list->person_contact_alt_number,"added_on"=>$row_get_list->added_on,"status"=>$row_get_list->status,"state"=>$row_get_list->state,"city"=>$row_get_list->city);

				}

			}

		    }

			return $pg_content;

		}



		if($category == 'store_detail')

		{

			$sql_get_list="select s.* , (select Un.login_id from ks_login_detail as Un where s.updated_by != 0 and s.updated_by = Un.user_id) as updated_by_name , (select Un.login_id from ks_login_detail as Un where s.added_by != 0 and s.added_by = Un.user_id) as added_by_name , (select state_name from state where s.state_id=state_id) as state  , (select city_name from city where s.city_id=city_id) as city from stores s where 1  ";

			if(!empty($id)){

				$sql_get_list.= " and s.stores_id=$id ";

			}

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("stores_id"=>$row_get_list->stores_id,"name"=>$row_get_list->name	,"address"=>$row_get_list->address,"person_contact_name"=>$row_get_list->person_contact_name,"person_contact_email"=>$row_get_list->person_contact_email,"person_contact_number"=>$row_get_list->person_contact_number,"person_contact_alt_number"=>$row_get_list->person_contact_alt_number,"store_username"=>$row_get_list->store_username,"store_password"=>$row_get_list->store_password,"store_contact_number"=>$row_get_list->store_contact_number,"state_id"=>$row_get_list->state_id,"city_id"=>$row_get_list->city_id,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"added_by"=>$row_get_list->added_by,"updated_by"=>$row_get_list->updated_by,"status"=>$row_get_list->status,"updated_by_name"=>$row_get_list->updated_by_name,"added_by_name"=>$row_get_list->added_by_name,"state"=>$row_get_list->state,"city"=>$row_get_list->city);

					}

				}

		    }

			return $pg_content;

		}



		if($category == 'store_location')

		{

			$sql_get_list="select l.location_name , l.location_pincode , l.location_id from stores_location as sl , location as l where l.location_id=sl.location_id ";

			if(!empty($id)){

				$sql_get_list.= " and sl.stores_id=$id ";

			}

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("location_id"=>$row_get_list->location_id,"location_name"=>$row_get_list->location_name	,"location_pincode"=>$row_get_list->location_pincode);

					}

				}

		    }

			return $pg_content;

		}



	}



	function productsSearch_to_delete($category, $id, $status='', $search1='', $search2='', $search3='', $search4='', $search5='', $search6='')

	{

		$pg_content = array();

		 if($category == 'products_list_in_store')

		{

			/*$this->db->where("status = 1 ");

			if(!empty($id))

			$this->db->where("product_id = '$id'");

			$query_get_list = $this->db->get($this->product_table_name);*/



			$sql_get_list="select p.product_id , p.manufacturer_id , p.name , p.ref_code , p.slug_url , p.short_description, m.manufacturer_name from product p , manufacturer as m where m.manufacturer_id=p.manufacturer_id and m.status=1 and p.status=1  ";

				$query_get_list=$this->db->query($sql_get_list);

				{

						if($query_get_list->num_rows() > 0 )

						{

								foreach($query_get_list->result() as $row_get_list)

								{

									$content_product_combination=array();

								$sql_get_list1="select pc.* , pi.product_image_name , pis.quantity as s_quantity , pis.price as s_price , pis.discount as s_discount , pis.discount_var  as s_discount_var, pis.final_price as s_final_price  , pis.status as s_status  , pis.admin_status as s_admin_status , pis.added_on as s_added_on , pis.updated_on as s_updated_on from product_combination as pc , product_image as pi , product_in_store as pis  where pc.product_id=$row_get_list->product_id and pi.product_image_id = pc.product_image_id and pis.product_id=pc.product_id and pis.product_combination_id=pc.product_combination_id and pis.store_id=$search1 order by pc.default_combination DESC ";//echo $sql_get_list1."<br>";

								$query_get_list1=$this->db->query($sql_get_list1);

									if($query_get_list1->num_rows() > 0 )

									{

										foreach($query_get_list1->result() as $row_get_list1)

										{



											$sql_get_list2="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";

												$query_get_list2=$this->db->query($sql_get_list2);

												{

													$combi="";

													if($query_get_list2->num_rows() > 0 )

													{

														foreach($query_get_list2->result() as $row_get_list2)

														{

															//$pg_content[]=array("product_combination_attribute_id"=>$row_get_list->product_combination_attribute_id,"product_id"=>$row_get_list->product_id	,"product_combination_id"=>$row_get_list->product_combination_id,"product_attribute_id"=>$row_get_list->product_attribute_id,"product_attribute_value_id"=>$row_get_list->product_attribute_value_id,"combination_value"=>$row_get_list->combination_value);

															if(!empty($row_get_list2->combination_value))

																$combi .= "$row_get_list2->combination_value";

															if(!empty($row_get_list2->v_name))

																$combi .= "&nbsp;$row_get_list2->v_name";



															$combi .= ", ";

															//echo $combi.'<br>';

														}

													}

												}





											$combi = trim($combi , ', ');





											$content_product_combination[]=array("product_combination_id"=>$row_get_list1->product_combination_id,"product_id"=>$row_get_list1->product_id	,"ref_code"=>$row_get_list1->ref_code,"product_image_id"=>$row_get_list1->product_image_id,"default_combination"=>$row_get_list1->default_combination,"comb_slug_url"=>$row_get_list1->comb_slug_url,"product_image_name"=>$row_get_list1->product_image_name,"combi"=>$combi,"quantity"=>$row_get_list1->s_quantity, "price"=>$row_get_list1->s_price, "discount"=>$row_get_list1->s_discount, "discount_var"=>$row_get_list1->s_discount_var, "final_price"=>$row_get_list1->s_final_price, "status"=>$row_get_list1->s_status, "admin_status"=>$row_get_list1->s_admin_status, "added_on"=>$row_get_list1->s_added_on, "updated_on"=>$row_get_list1->s_updated_on);

										}



										$pg_content[]=array("product_id"=>$row_get_list->product_id,"manufacturer_id"=>$row_get_list->manufacturer_id	,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"slug_url"=>$row_get_list->slug_url,"short_description"=>$row_get_list->short_description,"manufacturer_name"=>$row_get_list->manufacturer_name,"product_combination"=>$content_product_combination);



									}

								}

						}

				}



			return $pg_content;

		}



		if($category == 'products_list_to_add_in_store')

		{

			/*$this->db->where("status = 1 ");

			if(!empty($id))

			$this->db->where("product_id = '$id'");

			$query_get_list = $this->db->get($this->product_table_name);*/



			$sql_get_list="select p.product_id , p.manufacturer_id , p.name , p.ref_code , p.slug_url , p.short_description, m.manufacturer_name from product p , manufacturer as m where m.manufacturer_id=p.manufacturer_id and m.status=1 and p.status=1  ";

				$query_get_list=$this->db->query($sql_get_list);

				{

						if($query_get_list->num_rows() > 0 )

						{

								foreach($query_get_list->result() as $row_get_list)

								{

									$content_product_combination=array();

								$sql_get_list1="select pc.* , pi.product_image_name , (select count(product_in_store_id) from product_in_store as pis where pis.product_id=pc.product_id and pis.product_combination_id=pc.product_combination_id and pis.store_id=$search1) as in_store from product_combination as pc , product_image as pi  where pc.product_id=$row_get_list->product_id and pi.product_image_id = pc.product_image_id order by pc.default_combination DESC ";//echo $sql_get_list1."<br>";

								$query_get_list1=$this->db->query($sql_get_list1);

									if($query_get_list1->num_rows() > 0 )

									{

										foreach($query_get_list1->result() as $row_get_list1)

										{









											$sql_get_list2="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";

												$query_get_list2=$this->db->query($sql_get_list2);

												{

													$combi="";

													if($query_get_list2->num_rows() > 0 )

													{

														foreach($query_get_list2->result() as $row_get_list2)

														{

															//$pg_content[]=array("product_combination_attribute_id"=>$row_get_list->product_combination_attribute_id,"product_id"=>$row_get_list->product_id	,"product_combination_id"=>$row_get_list->product_combination_id,"product_attribute_id"=>$row_get_list->product_attribute_id,"product_attribute_value_id"=>$row_get_list->product_attribute_value_id,"combination_value"=>$row_get_list->combination_value);

															if(!empty($row_get_list2->combination_value))

																$combi .= "$row_get_list2->combination_value";

															if(!empty($row_get_list2->v_name))

																$combi .= "&nbsp;$row_get_list2->v_name";



															$combi .= ", ";

															//echo $combi.'<br>';

														}

													}

												}





											$combi = trim($combi , ', ');





											$content_product_combination[]=array("product_combination_id"=>$row_get_list1->product_combination_id,"product_id"=>$row_get_list1->product_id	,"ref_code"=>$row_get_list1->ref_code,"quantity"=>$row_get_list1->quantity,"price"=>$row_get_list1->price,"discount"=>$row_get_list1->discount,"discount_var"=>$row_get_list1->discount_var,"final_price"=>$row_get_list1->final_price,"status"=>$row_get_list1->status,"added_on"=>$row_get_list1->added_on,"updated_on"=>$row_get_list1->updated_on,"product_image_id"=>$row_get_list1->product_image_id,"default_combination"=>$row_get_list1->default_combination,"comb_slug_url"=>$row_get_list1->comb_slug_url,"product_image_name"=>$row_get_list1->product_image_name,"combi"=>$combi,"in_store"=>$row_get_list1->in_store);

										}



										$pg_content[]=array("product_id"=>$row_get_list->product_id,"manufacturer_id"=>$row_get_list->manufacturer_id	,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"slug_url"=>$row_get_list->slug_url,"short_description"=>$row_get_list->short_description,"manufacturer_name"=>$row_get_list->manufacturer_name,"product_combination"=>$content_product_combination);



									}

								}

						}

				}



			return $pg_content;

		}



		if($category == 'products_list')

		{

			/*$this->db->where("status = 1 ");

			if(!empty($id))

			$this->db->where("product_id = '$id'");

			$query_get_list = $this->db->get($this->product_table_name);*/



			$sql_get_list="select p.product_id , p.manufacturer_id , p.name , p.ref_code , p.slug_url , p.short_description, m.manufacturer_name from product p , manufacturer as m where m.manufacturer_id=p.manufacturer_id and m.status=1 and p.status=1 ";

				$query_get_list=$this->db->query($sql_get_list);

				{

						if($query_get_list->num_rows() > 0 )

						{

								foreach($query_get_list->result() as $row_get_list)

								{

									$content_product_combination=array();

								$sql_get_list1="select pc.* , pi.product_image_name from product_combination as pc , product_image as pi where pc.product_id=$row_get_list->product_id and pi.product_image_id = pc.product_image_id order by pc.default_combination DESC ";//echo $sql_get_list1."<br>";

								$query_get_list1=$this->db->query($sql_get_list1);

									if($query_get_list1->num_rows() > 0 )

									{

										foreach($query_get_list1->result() as $row_get_list1)

										{









											$sql_get_list2="select pca.* , pa.name as a_name , pav.name as v_name from product_combination_attribute as pca , product_attribute as pa , product_attribute_value pav where product_combination_id=$row_get_list1->product_combination_id and pca.product_attribute_id=pa.product_attribute_id and pca.product_attribute_value_id =pav.product_attribute_value_id and pav.product_attribute_id=pa.product_attribute_id ";

												$query_get_list2=$this->db->query($sql_get_list2);

												{

													$combi="";

													if($query_get_list2->num_rows() > 0 )

													{

														foreach($query_get_list2->result() as $row_get_list2)

														{

															//$pg_content[]=array("product_combination_attribute_id"=>$row_get_list->product_combination_attribute_id,"product_id"=>$row_get_list->product_id	,"product_combination_id"=>$row_get_list->product_combination_id,"product_attribute_id"=>$row_get_list->product_attribute_id,"product_attribute_value_id"=>$row_get_list->product_attribute_value_id,"combination_value"=>$row_get_list->combination_value);

															if(!empty($row_get_list2->combination_value))

																$combi .= "$row_get_list2->combination_value";

															if(!empty($row_get_list2->v_name))

																$combi .= "&nbsp;$row_get_list2->v_name";



															$combi .= ", ";

															//echo $combi.'<br>';

														}

													}

												}





											$combi = trim($combi , ', ');





											$content_product_combination[]=array("product_combination_id"=>$row_get_list1->product_combination_id,"product_id"=>$row_get_list1->product_id	,"ref_code"=>$row_get_list1->ref_code,"quantity"=>$row_get_list1->quantity,"price"=>$row_get_list1->price,"discount"=>$row_get_list1->discount,"discount_var"=>$row_get_list1->discount_var,"final_price"=>$row_get_list1->final_price,"status"=>$row_get_list1->status,"added_on"=>$row_get_list1->added_on,"updated_on"=>$row_get_list1->updated_on,"product_image_id"=>$row_get_list1->product_image_id,"default_combination"=>$row_get_list1->default_combination,"comb_slug_url"=>$row_get_list1->comb_slug_url,"product_image_name"=>$row_get_list1->product_image_name,"combi"=>$combi);

										}



										$pg_content[]=array("product_id"=>$row_get_list->product_id,"manufacturer_id"=>$row_get_list->manufacturer_id	,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"slug_url"=>$row_get_list->slug_url,"short_description"=>$row_get_list->short_description,"manufacturer_name"=>$row_get_list->manufacturer_name,"product_combination"=>$content_product_combination);



									}

								}

						}

				}



			return $pg_content;

		}



		 if($category == 'product_detail')

		{

			$sql_get_list="select p.* , (select Un.login_id from ks_login_detail as Un where p.updated_by != 0 and p.updated_by = Un.user_id) as updated_by_name , (select Un.login_id from ks_login_detail as Un where p.added_by != 0 and p.added_by = Un.user_id) as added_by_name from product p where 1  ";

			if(!empty($id)){

				$sql_get_list.= " and p.product_id=$id ";

			}

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("product_id"=>$row_get_list->product_id,"manufacturer_id"=>$row_get_list->manufacturer_id	,"name"=>$row_get_list->name,"ref_code"=>$row_get_list->ref_code,"slug_url"=>$row_get_list->slug_url,"short_description"=>$row_get_list->short_description,"description"=>$row_get_list->description,"how_to_use"=>$row_get_list->how_to_use

						,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"added_by"=>$row_get_list->added_by,"updated_by"=>$row_get_list->updated_by,"status"=>$row_get_list->status,"updated_by_name"=>$row_get_list->updated_by_name,"added_by_name"=>$row_get_list->added_by_name);

					}

				}

		    }

			return $pg_content;

		}



		if($category == 'product_category_detail')

		{

			$sql_get_list="select * from product_category where product_id=$id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("product_category_id"=>$row_get_list->product_category_id,"product_id"=>$row_get_list->product_id	,"category_id"=>$row_get_list->category_id);

					}

				}

		    }

			return $pg_content;

		}



		if($category == 'product_image_detail')

		{

			$sql_get_list="select * from product_image where product_id=$id order by position ASC";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("product_image_id"=>$row_get_list->product_image_id,"product_id"=>$row_get_list->product_id	,"product_image_name"=>$row_get_list->product_image_name,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"default_image"=>$row_get_list->default_image,"position"=>$row_get_list->position);

					}

				}

		    }

			return $pg_content;

		}



		if($category == 'product_combination_detail')

		{

			$sql_get_list="select * from product_combination where product_id=$id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("product_combination_id"=>$row_get_list->product_combination_id,"product_id"=>$row_get_list->product_id	,"ref_code"=>$row_get_list->ref_code,"quantity"=>$row_get_list->quantity,"price"=>$row_get_list->price,"discount"=>$row_get_list->discount,"discount_var"=>$row_get_list->discount_var,"final_price"=>$row_get_list->final_price,"status"=>$row_get_list->status,"added_on"=>$row_get_list->added_on,"updated_on"=>$row_get_list->updated_on,"product_image_id"=>$row_get_list->product_image_id,"default_combination"=>$row_get_list->default_combination,"comb_slug_url"=>$row_get_list->comb_slug_url);

					}

				}

		    }

			return $pg_content;

		}



		if($category == 'product_combination_attribute_detail')

		{

			$sql_get_list="select * from product_combination_attribute where product_id=$id ";

			$query_get_list=$this->db->query($sql_get_list);

			{

				if($query_get_list->num_rows() > 0 )

				{

					foreach($query_get_list->result() as $row_get_list)

					{

						$pg_content[]=array("product_combination_attribute_id"=>$row_get_list->product_combination_attribute_id,"product_id"=>$row_get_list->product_id	,"product_combination_id"=>$row_get_list->product_combination_id,"product_attribute_id"=>$row_get_list->product_attribute_id,"product_attribute_value_id"=>$row_get_list->product_attribute_value_id,"combination_value"=>$row_get_list->combination_value);

					}

				}

		    }

			return $pg_content;

		}

	}

	function checkSlugUrl($pos,$ctg,$id , $ids='')
	{
		if($ctg == 'product'){
		$this->db->where('slug_url', $pos);
		if(!empty($id))
			$this->db->where("id not in ($id)");
			//$this->db->where("product_id !=", $id);
		$query_chk_pos = $this->db->get('product');}

		if($ctg == 'product_ref_code'){
		$this->db->where('ref_code', $pos);
		if(!empty($id))
			$this->db->where("id not in ($id)");
			//$this->db->where("product_id !=", $id);
		$query_chk_pos = $this->db->get('product');}

		if($ctg == 'product_combination_ref_code'){
		$this->db->where('ref_code', $pos);
		//if(!empty($id))
		//	$this->db->where('product_id', $id);
		if(!empty($ids))
			$this->db->where("product_combination_id not in ($ids)");
//			$this->db->where_not_in('product_combination_id', $ids);
		$query_chk_pos = $this->db->get('product_combination');}

		if($ctg == 'product_combination'){
		$this->db->where('comb_slug_url', $pos);
		if(!empty($id))
			$this->db->where('product_id', $id);
		if(!empty($ids))
			$this->db->where("product_combination_id not in ($ids)");
			//$this->db->where_not_in('product_combination_id', $ids);
		$query_chk_pos = $this->db->get('product_combination');}

		if($ctg == 'category'){
		$this->db->where('slug_url', $pos);
		if(!empty($id))
			$this->db->where("category_id not in ($id)");
			//$this->db->where_not_in('category_id', $id);
		$query_chk_pos = $this->db->get('category');}

		if($ctg == 'manufacturer'){
		$this->db->where('slug_url', $pos);
		if(!empty($id))
			$this->db->where("manufacturer_id not in ($id)");
			//$this->db->where_not_in('manufacturer_id', $id);
		$query_chk_pos = $this->db->get('manufacturer');}

		if($ctg == 'product_seo'){
		$this->db->where('slug_url', $pos);
		if(!empty($id))
			$this->db->where("product_seo_id not in ($id)");
//			$this->db->where_not_in('product_seo_id', $id);
		$query_chk_pos = $this->db->get('product_seo');}

		/*if($ctg == 'product_seo'){
		$this->db->where('slug_url', $pos);
		if(!empty($id))
			$this->db->where('product_id', $id);
		if(!empty($ids))
			$this->db->where_not_in('product_combination_id', $ids);
		$query_chk_pos = $this->db->get('product_seo');}*/

		//echo $this->db->last_query();
		$msg="";
		if($query_chk_pos->num_rows() > 0 )
		{
			$msg = "exist";
		}
		else
		{
			//$msg = "fail";
		}
		return $msg;
	}

	function checkSlugUrl_to_delete($pos,$ctg,$id , $ids='')

	{

		if($ctg == 'product'){

		$this->db->where('slug_url', $pos);

		if(!empty($id))

			$this->db->where_not_in('product_id', $id);

		$query_chk_pos = $this->db->get('product');}



		if($ctg == 'product_combination'){

		$this->db->where('comb_slug_url', $pos);

		if(!empty($id))

			$this->db->where('product_id', $id);

		if(!empty($ids))

			$this->db->where_not_in('product_combination_id', $ids);

		$query_chk_pos = $this->db->get('product_combination');}



		//echo $this->db->last_query();

		$msg="";

		if($query_chk_pos->num_rows() > 0 )

		{

			$msg = "exist";

		}

		else

		{

			//$msg = "fail";

		}

		return $msg;

	}

}
