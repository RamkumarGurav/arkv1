<?php
defined('BASEPATH') or exit('No direct script access allowed');
include ('Main.php');
class Ajax extends main
{

	public function __construct()
	{
		parent::__construct();

		//db
		$this->load->database();

		//libraries
		$this->load->library('form_validation');

		//helpers
		$this->load->helper('url');
		$this->load->helper('form');

		//models
		$this->load->model('Ajax_model');
		$this->load->model('Common_Model');

		//page data
		$this->data['action'] = '';
		$this->data['message'] = '';
	}


	function getState()
	{
		$country_id = $_POST['country_id'];
		$state_id = '';
		if (!empty($_POST['state_id'])) {
			$state_id = $_POST['state_id'];
		}
		$state = $this->Ajax_model->getState(array("country_id" => $country_id));
		$show = "<option value=''>Select State</option>";
		if (!empty($country_id)) {
			if (!empty($state)) {
				foreach ($state as $s) {
					$selected = '';
					if ($s->state_id == $state_id)
						$selected = 'selected';
					$show .= "<option $selected value='$s->state_id'>$s->state_name</option>";
				}
			}
		}
		echo $show;
	}

	function getCity()
	{
		$state_id = $_POST['state_id'];
		$city_id = $_POST['city_id'];
		$city = $this->Ajax_model->getCity(array("state_id" => $state_id));
		$show = "<option value=''>Select City</option>";
		if (!empty($state_id)) {
			if (!empty($city)) {
				foreach ($city as $c) {
					$selected = '';
					if ($c->city_id == $city_id)
						$selected = 'selected';
					$show .= "<option $selected value='$c->city_id'>$c->city_name</option>";
				}
			}
		}
		echo $show;
	}

	function footer_category()
	{
		$this->output->cache('10');
		$this->data['footer_category'] = $this->Common_Model->getData(array('select' => 'category_id , position , name , slug_url ', 'from' => 'category', 'where' => "(super_category_id =0 and status=1)", "order_by" => "rand()", "limit" => 8));
		$this->load->view('template/footer_category', $this->data);
	}


}
