<?php
class Checkout_model extends CI_Model
{

	function __construct()
    {
        parent::__construct();
		$this->load->database();
		date_default_timezone_set("Asia/Kolkata");
    }

	function getUser($params=array())
	{
		$this->db
		->select('c.*')
		->from('customers as c')
		->where('customers_id' , $params['customers_id'])
		->limit(1);
		$result = $this->db->get();
		if($result->num_rows() > 0 )
		{
			$result = $result->result();
			$result = $result[0];

			$this->db
			->select('ca.* , co.country_name , co.country_code , s.state_name , c.city_name')
			->from('customers_address as ca')
			->join('country as co' , 'co.country_id = ca.country_id')
			->join('state as s' , 's.state_id = ca.state_id')
			->join('city as c' , 'c.city_id = ca.city_id')
			->where('ca.customers_id' , $params['customers_id'])
			->where('ca.status' , 1);
			$result->address = $this->db->get()->result();

			$this->db
			->select('*')
			->from('gst_info')
			->where('customers_id' , $params['customers_id'])
			->where('status' , 1);
			$result->gst_info = $this->db->get()->result();

			return $result;
		}
		else
		{
			return 'error';
		}
	}

	function getCart($params = array())
	{
		$this->db
		->distinct('tc.temp_cart_id')
		->select('p.* , c.category_name , sc.sub_category_name ')
		->from('product as p')
		->join('category as c' , "c.category_id = p.category_id")
		->join('temp_cart as tc' , "tc.product_id = p.product_id")
		->join('sub_category as sc' , "sc.category_id = p.category_id")
		->where('tc.temp_session_id' , $params['temp_session_id'])
		->where('p.status' , 1)
		->where('c.status' , 1)
		->where('sc.status' , 1);
		if(!empty($params['slug_url']))
		{ $this->db->where('p.slug_url' , $params['slug_url']); }
		$result = $this->db->get();
		if($result->num_rows() > 0 )
		{
			$count=0;
			$result = $result->result();
			foreach($result as $r)
			{
				$this->db
				->select('pi.*')
				->from('product_image as pi')
				->where('pi.product_id' , $r->product_id);
				$result[$count]->image= $this->db->get()->result();

				$this->db
				->select('pp.* , w.weight_name , tc.image_name , tc.temp_cart_id')
				->from('product_price as pp')
				->join('weight as w' , "w.weight_id = pp.weight")
				->join('temp_cart as tc' , "tc.product_price_id = pp.product_price_id")
				->where('tc.temp_session_id' , $params['temp_session_id'])
				->where('pp.product_id' , $r->product_id);
				$result[$count]->price= $this->db->get()->result();

				$this->db
				->select('ai.*')
				->from('additional_information as ai')
				->where('ai.product_id' , $r->product_id);
				$result[$count]->info= $this->db->get()->result();

				$count++;
			}
			return $result;
		}
		else
		{ return false; }
	}

	function doUpdateUserDeliverAddress($params = array())
	{
		$reg_data['customers_id'] = $params['customers_id'];
		$customers_address_id = $_POST['customers_address_id'];
		if($customers_address_id>0)
		{
			$reg_data['delivery_status'] = 1;
			$update_data['delivery_status']=0;
			$this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$update_data , 'condition'=>"(customers_id=$params[customers_id])" ));

			//$reg_data['billing_status'] = 1;
			//$update_data['billing_status']=0;
			//$this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$update_data , 'condition'=>"(customers_id=$params[customers_id])" ));

			return $this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$reg_data , 'condition'=>"(customers_address_id=$params[customers_address_id] and customers_id=$params[customers_id])" ));
		}
	}

	function doUpdateUserBillingAddress($params = array())
	{
		$reg_data['customers_id'] = $params['customers_id'];
		$customers_address_id = $_POST['customers_address_id'];
		if($customers_address_id>0)
		{
			$reg_data['billing_status'] = 1;
			$update_data['billing_status']=0;
			$this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$update_data , 'condition'=>"(customers_id=$params[customers_id])" ));

			return $this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$reg_data , 'condition'=>"(customers_address_id=$params[customers_address_id] and customers_id=$params[customers_id])" ));
		}
	}

	function doAddUserDeliverHereAddress($params = array())
	{
		$reg_data['delivery_status'] = 1;
		$reg_data['billing_status'] = 1;
		$update_data['delivery_status']=0;
		$update_data['billing_status']=0;
		$this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$update_data , 'condition'=>"(customers_id=$params[customers_id])" ));
		return $this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$reg_data , 'condition'=>"(customers_address_id=$params[customers_address_id] and customers_id=$params[customers_id])" ));
	}

	function doAddUserSelectedGstInfo($params = array())
	{
		$reg_data['is_selected'] = 1;
		$reg_data['selected_for_order'] = 1;
		$update_data['is_selected']=0;
		$update_data['selected_for_order']=0;
		$this->Common_model->update_operation(array('table'=>'gst_info' , 'data'=>$update_data , 'condition'=>"(customers_id=$params[customers_id])" ));
		return $this->Common_model->update_operation(array('table'=>'gst_info' , 'data'=>$reg_data , 'condition'=>"(gst_info_id=$params[gst_info_id] and customers_id=$params[customers_id])" ));
	}

	function doAddUserAddress($params = array())
	{
		$reg_data['customers_id'] = $params['customers_id'];
		$customers_address_id = $_POST['customers_address_id'];
		$reg_data['name'] = $_POST['name'];
		$reg_data['number'] = $_POST['number'];
		$reg_data['address'] = $_POST['address'];
		$reg_data['country_id'] = $_POST['country_id'];
		$reg_data['state_id'] = $_POST['state_id'];
		$reg_data['city_id'] = $_POST['city_id'];
		$reg_data['zipcode'] = $_POST['pincode'];

		$reg_data['locality'] = $_POST['locality'];
		$reg_data['landmark'] = $_POST['landmark'];
		$reg_data['alternate_number'] = $_POST['alternate_number'];
		$reg_data['address_type'] = $_POST['address_type'];
		$reg_data['updated_on'] = date('Y-m-d H:i:s');
		$reg_data['added_on'] = date('Y-m-d H:i:s');
		$reg_data['status'] = 1;

		if($customers_address_id>0 )
		{
			if(!empty($params['do_update_deliver_here']))
			{
				$reg_data['delivery_status'] = 1;
				$reg_data['billing_status'] = 1;
				$update_data['delivery_status']=0;
				$update_data['billing_status']=0;
				return	$this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$update_data , 'condition'=>"(customers_id=$params[customers_id])" ));
			}

			//return $this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$reg_data , 'condition'=>"(customers_address_id=$params[customers_address_id] and customers_id=$params[customers_id])" ));
		}
		else
		{
			if(isset($_POST['AddressSaveBTN']))
			{
				$reg_data['delivery_status'] = 0;
				$reg_data['billing_status'] = 0;
			}
			else
			{
				$reg_data['delivery_status'] = 1;
				$reg_data['billing_status'] = 1;
				$update_data['delivery_status']=0;
				$update_data['billing_status']=0;
				$this->Common_model->update_operation(array('table'=>'customers_address' , 'data'=>$update_data , 'condition'=>"(customers_id=$params[customers_id])" ));
			}
			return $this->Common_model->add_operation(array('table'=>'customers_address' , 'data'=>$reg_data ));
		}
	}

	function doAddUserGSTInfo($params = array())
	{
		$reg_data['customers_id'] = $params['customers_id'];
		$gst_info_id = $_POST['gst_info_id'];
		$reg_data['gst_number'] = $_POST['gst_number'];
		$reg_data['company_name'] = $_POST['company_name'];
		$reg_data['updated_on'] = date('Y-m-d H:i:s');
		$reg_data['added_on'] = date('Y-m-d H:i:s');
		$reg_data['status'] = 1;

		if($gst_info_id>0 )
		{
			if(!empty($params['do_update_deliver_here']))
			{
				$reg_data['is_selected'] = 1;
				$update_data['is_selected']=0;
				$this->Common_model->update_operation(array('table'=>'gst_info' , 'data'=>$update_data , 'condition'=>"(customers_id=$params[customers_id])" ));
			}

			return $this->Common_model->update_operation(array('table'=>'gst_info' , 'data'=>$reg_data , 'condition'=>"(gst_info_id=$params[gst_info_id] and customers_id=$params[customers_id])" ));
		}
		else
		{
			if(isset($_POST['AddressSaveBTN']))
			{
				$reg_data['is_selected'] = 0;
			}
			else
			{
				$reg_data['is_selected'] = 1;
				$update_data['is_selected']=0;
				$update_data['selected_for_order']=0;
				$this->Common_model->update_operation(array('table'=>'gst_info' , 'data'=>$update_data , 'condition'=>"(customers_id=$params[customers_id])" ));
			}
			$reg_data['selected_for_order'] = 1;
			return $this->Common_model->add_operation(array('table'=>'gst_info' , 'data'=>$reg_data ));
		}
	}

	function getOrder($params = array())
	{

		$this->db
		->select('o.*')
		->from('orders as o')
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
				$this->db
				->select('op.*')
				->from('orders_details as op')
				->where('op.orders_id' , $r->orders_id);
				$r->details = $this->db->get()->result();
				$count++;
			}

			return $result;
		}
		else
		{
			return false;
		}
	}

}
?>
