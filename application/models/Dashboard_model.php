<?php
class Dashboard_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
    }
	
	function profileOrdersCount($params = array())
	{
		$this->db
		->select('count(customers_id) as counts')
		->from('orders')
		->where('customers_id' , $params['customers_id']);
		$result = $this->db->get();
		$result = $result->result();
		$result = $result[0];
		return $result;
	}
	
	function profileWishlistCount($params = array())
	{
		$this->db
		->select('count(temp_wishlist_id) as counts')
		->from('temp_wishlist')
		->where('application_sess_temp_id' , $params['customers_id']);
		$result = $this->db->get();
		$result = $result->result();
		$result = $result[0];
		return $result;
	}
	
	function getProfile($params = array())
	{
		$this->db
		->select('c.* , cc.country_code , cc.country_name , cc.country_short_name')
		->from('customers as c')
		->join('country as cc' , 'c.country_id=cc.country_id')
		->where('customers_id' , $params['customers_id'])
		->limit(1);
		$result = $this->db->get();
		if($result->num_rows() > 0 )
		{
			$result = $result->result();
			return $result[0];
		}
		else
		{
			return 'error';
		}
		
	}
	
	function getCountry($params = array())
	{
		$this->db
		->select('c.country_id , c.country_name , country_short_name , c.country_code')
		->from('country as c')
		->where('c.status' , 1)
		->order_by('c.country_name ASC');
		$result = $this->db->get();
		if($result->num_rows() > 0)
			return $result->result();
		else
			return false;
	}
	
	function changeUserPassword($params = array())
	{
		$status = true;
		$old_password = base64_encode($_POST['old_password']);
		$reg_data['password'] = base64_encode($_POST['password']);
		$reg_data['show_password'] = $_POST['password'];
		
		$this->db
		->select('count(customers_id) as counts')
		->from('customers')
		->where('password' , $old_password)
		->where('customers_id' , $params['customers_id']);
		$result = $this->db->get();
		$result = $result->result();
		$result = $result[0];
		if($result->counts==0)
		{
			$status = false;
			return 'wrongPassword';
		}
		
		if($status)
		{
			return $this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$reg_data , 'condition'=>"customers_id = $params[customers_id]" ));
		}
	}
	
	function doUpdateUser($params = array())
	{//customers_id
		$status = false;
		if(!empty($_POST['first_name']))
		{
			$status = true;
			if(!empty($_POST['last_name']))
				$reg_data['name'] = $_POST['first_name'].' '.$_POST['last_name'];
			else
				$reg_data['name'] = $_POST['first_name'];
				
			$reg_data['first_name'] = $_POST['first_name'];
			
			if(!empty($_POST['last_name']))
				$reg_data['last_name'] = $_POST['last_name'];
		}
		
		$reg_data['updated_on'] = date('Y-m-d H:i:s');
		if(!empty($_POST['email']))
		{
			$status = true;
			$reg_data['email'] = $_POST['email'];
			$this->db
			->select('count(customers_id) as counts')
			->from('customers')
			->where('email' , $_POST['email'])
			->where("customers_id != $params[customers_id]");
			$result = $this->db->get();
			$result = $result->result();
			$result = $result[0];
			if($result->counts>0)
			{
				$status = false;
				return 'emailExist';
			}
		}
		if(!empty($_POST['country_id']) && !empty($_POST['number']))
		{
			$status = true;
			$reg_data['country_id'] = $_POST['country_id'];
			$reg_data['number'] = $_POST['number'];
			$this->db
			->select('count(customers_id) as counts')
			->from('customers')
			->where('number' , $_POST['number'])
			->where('country_id' , $_POST['country_id'])
			->where("customers_id != $params[customers_id]");;
			$result = $this->db->get();
			$result = $result->result();
			$result = $result[0];
			if($result->counts>0)
			{
				$status = false;
				return 'numberExist';
			}
		}
		
		if($status)
		{
			return $this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$reg_data , 'condition'=>"customers_id = $params[customers_id]" ));
		}
	}
	
	function getOrder($params = array())
	{
		$this->db
		->select('o.*, os.order_status_display_user, os.order_status_color_class, os.order_status as order_status_name')
		->from('orders as o')
		->join('order_status as os' , "o.order_status_id = os.order_status_id")
		->order_by('o.orders_id DESC')
		->where('o.customers_id' , $params['customers_id']);
		if(!empty($params['orders_id']))
			$this->db->where('o.orders_id' , $params['orders_id']);
		
		$result = $this->db->get();
		if($result->num_rows() > 0 )
		{
			$result = $result->result();
			//$result = $result[0];
			$count=0;
			foreach($result as $r)
			{
				/*$this->db
				->select('op.*')
				->from('orders_details as op')
				->where('op.orders_id' , $r->orders_id);
				$result[$count]->details = $this->db->get()->result();
				
				$this->db
				->select('s.*')
				->from('stores as s')
				->where('s.stores_id' , $r->stores_id);
				$result[$count]->store_data = $this->db->get()->result();*/
				
				
				$this->db
				->select('oh.* , os.order_status')
				->from('orders_history as oh')
				->join('order_status as os' , "oh.order_status_id = os.order_status_id and is_display_to_user = 1")
				->where('oh.orders_id' , $r->orders_id);
				$result[$count]->history = $this->db->get()->result();
				
				
				$this->db
				->select('op.*')
				->select("(SELECT product_image_name FROM product_combination as pc JOIN product_image as c ON pc.product_image_id = c.product_image_id where op.product_id = pc.product_id LIMIT 1) as product_image_name")
				->from('orders_details as op')
				->where('op.orders_id' , $r->orders_id);
				$result[$count]->details = $this->db->get()->result();
				//echo $this->db->last_query();
				foreach($result[$count]->details as $od)
				{
					
					if(!empty($params['for_reorder']))
					{
						$this->db
						->select('pis.*')
						->select("(select quantity from temp_cart as tc where tc.application_sess_temp_id =$r->customers_id and tc.product_in_store_id = pis.product_in_store_id) as cart_qty")
						->from('product_in_store as pis')
						->where('pis.store_id' , $r->stores_id)
						->where('pis.product_combination_id' , $od->product_combination_id)
						->limit(1);
						$product_store_data = $this->db->get()->result();
						if(!empty($product_store_data))
						{
							$product_store_data = $product_store_data[0];
						}
						$od->product_store_data = $product_store_data;
					}
					
					$this->db
					->select('c.category_id , c.name')
					->from('product_category as pc')
					->join('category as c' , "pc.category_id = c.category_id")
					->where('pc.product_id' , $od->product_id)
					->limit(1);
					$c_detail = $this->db->get()->result();
					
					if(!empty($c_detail))
					{
						$od->category_name = $c_detail[0]->name;
						$od->category_id = $c_detail[0]->category_id;
					}
					else
					{
						$od->category_name = 'Others';
						$od->category_id = 0;
					}
				}
				
				$this->db
				->select('s.*')
				->from('stores as s')
				->where('s.stores_id' , $r->stores_id);
				$result[$count]->store_data = $this->db->get()->result();
				
			
				$count++;
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	function doUpdateUserGST($params = array())
	{//customers_id
		$status = false;
		if(!empty($_POST['company_name']) && !empty($_POST['gst_number']))
		{
			$status = true;
			$reg_data['company_name'] = $_POST['company_name'];
			$reg_data['gst_number'] = $_POST['gst_number'];
		}
		
		$reg_data['updated_on'] = date('Y-m-d H:i:s');
		if(!empty($_POST['gst_number']))
		{
			$status = true;
			$reg_data['gst_number'] = $_POST['gst_number'];
			$this->db
			->select('count(customers_id) as counts')
			->from('customers')
			->where("customers_id != $params[customers_id]")
			->where('gst_number' , $_POST['gst_number']);
			$result = $this->db->get();
			$result = $result->result();
			$result = $result[0];
			if($result->counts>0)
			{
				$status = false;
				return 'gstExist';
			}
		}
		
		if($status)
		{
			return $this->Common_model->update_operation(array('table'=>'customers' , 'data'=>$reg_data , 'condition'=>"customers_id = $params[customers_id]" ));
		}
	}
	
}

?>