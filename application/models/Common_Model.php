<?php
//require_once(APPPATH.'views/mail/class.smtp.php');
//require_once(APPPATH.'views/mail/class.phpmailer.php');
require_once (APPPATH . 'third_party/mail/class.phpmailer.php');
require (APPPATH . 'third_party/mail/class.smtp.php');




class Common_Model extends CI_Model
{

	var $category_table_name = 'category';
	var $product_attribute_value_table_name = 'product_attribute_value';

	function __construct()
	{
		$this->load->database();
		date_default_timezone_set("Asia/Kolkata");
		$this->db->query("SET sql_mode = ''");
	}



	/****************************************************************
	 *GENERAL DB OPERATIONS
	 ****************************************************************/




	/**
	 * Function to get names /records from tables without limit and orderby 
	 *
	 * @param array $params Associative array containing:
	 *                      - 'select': Columns to select
	 *                      - 'from': Table to select from
	 *                      - 'where': Condition for the selection
	 * @return array List of results from the query as array of objects
	 */
	function getName($params = array())
	{
		// Set the columns to select
		$this->db->select($params['select']);

		// Set the table to select from
		$this->db->from($params['from']);

		// Set the WHERE condition for the selection
		$this->db->where("($params[where])");

		// Execute the query and store the result
		$query_get_list = $this->db->get();

		// Return the result of the query as an array of objects
		return $query_get_list->result();
	}



	/**
	 * Common method for getting array of objects data from Table records
	 * @param array $params An associative array containing the following keys:
	 *                      - 'select': A string specifying the fields to select
	 *                      - 'from': A string specifying the table to select from
	 *                      - 'where': A string specifying the WHERE condition
	 *                      - 'limit': (Optional) An integer specifying the number of records to return
	 *                      - 'order_by': (Optional) A string specifying the ORDER BY clause
	 * @return array The result of the query as an array of objects
	 */
	function getData($params = array())
	{
		// Set the SELECT part of the SQL query using the 'select' value from the $params array
		$this->db->select($params['select']);

		// Set the FROM part of the SQL query using the 'from' value from the $params array
		$this->db->from($params['from']);

		// Set the WHERE condition of the SQL query using the 'where' value from the $params array
		$this->db->where("($params[where])");

		// If a 'limit' value is provided in the $params array, set the LIMIT part of the SQL query
		if (!empty($params['limit'])) {
			$this->db->limit($params['limit']);
		}

		// If an 'order_by' value is provided in the $params array, set the ORDER BY part of the SQL query
		if (!empty($params['order_by'])) {
			$this->db->order_by($params['order_by']);
		}

		// Execute the query and store the result in $query_get_list
		$query_get_list = $this->db->get();

		// Return the result of the query as an array of objects
		return $query_get_list->result();

	}

	/**
	 * Function to add a new record to the database which gives inserted record Id if success otherwise false
	 *
	 * @param array $params Associative array containing:
	 *                      - 'table': Table to insert into
	 *                      - 'data': Data to insert
	 * @return mixed Insert ID if successful, false otherwise
	 */
	function add_operation($params = array())
	{
		// Check if $params is empty, return false if true
		if (empty($params))
			return false;

		// Insert data into specified table
		$status = $this->db->insert($params['table'], $params['data']);

		// If insert is successful, get the insert ID
		if ($status) {
			$status = $this->db->insert_id();
		}

		// Return the status (insert ID or false)
		return $status;
	}

	/**
	 * Function to update an existing record in the database, if there are no params then it returns -1 if necessary params provided returns true or false based on update operation success and failure
	 * 
	 *
	 * @param array $params Associative array containing:
	 * 											- 'condition': Condition for the update
	 *                      - 'table': Table to update
	 *                      - 'data': Data to update
	 *                      
	 * @return bool True if update is successful, false otherwise
	 */
	function update_operation($params = array())
	{
		// Check if $params is empty, return -1 if true
		if (empty($params))
			return -1;

		// Set the WHERE condition for the update
		$this->db->where($params['condition']);

		// Update the specified table with the provided data
		$status = $this->db->update($params['table'], $params['data']);

		// Return the status (true if update is successful, false otherwise)
		return $status;
	}


	/**
	 * Function to delete a record from the database 
	 *
	 * @param array $params Associative array containing:
	 *                      - 'table': Table to delete from
	 *                      - 'where': Condition for the delete
	 * @return bool True if delete is successful, false otherwise
	 */
	function delete_operation($params = array())
	{
		// Set the WHERE condition for the delete
		$this->db->where($params['where']);

		// Delete the record from the specified table and store the status of the operation
		$status = $this->db->delete($params['table']);

		// Optionally, you can uncomment the next line to print the last executed query for debugging
		// echo $this->db->last_query();

		// Return the status (true if delete is successful, false otherwise)
		return $status;
	}
	/****************************************************************
	 *****************************************************************/




	/****************************************************************
	 * HELPERS			
	 *****************************************************************/

	/**
	 * Method to get client IP address
	 */
	function get_client_ip()
	{
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if (isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	/****************************************************************
																															 
	 ****************************************************************/

	/****************************************************************
	 ****************************************************************
	 *****************************************************************/
	function getCartItemCount()
	{
		$cart_count = 0;
		$temp_id = $this->session->userdata('application_sess_temp_id');
		if (!empty($temp_id)) {
			$this->db
				->select('SUM(tc.quantity) as Squantity')
				->from('temp_cart as tc')
				->join('product as p', "p.product_id = tc.product_id")
				->where('tc.application_sess_temp_id', $temp_id);

			$result = $this->db->get();
			if ($result->num_rows() > 0) {
				$result = $result->result();
				$result = $result[0];
				$cart_count = $result->Squantity;
			}
		}
		if (empty($cart_count)) {
			$cart_count = 0;
		}
		$this->session->set_userdata('application_sess_cart_count', $cart_count);
		return $cart_count;
	}

	function getRunningLines()
	{
		$this->db
			->select('id, running_line_title, running_line_link')
			->from('running_line')
			->where('status = 1')
			->order_by('position ASC');
		$result = $this->db->get();
		$result = $result->result();
		return $result;
	}

	function getWishlistItemCount()
	{
		$wishlist_count = 0;
		$temp_id = $this->session->userdata('application_sess_temp_id');
		if (!empty($temp_id)) {
			$this->db
				->select('COUNT(tc.temp_wishlist_id) as counts')
				->from('temp_wishlist as tc')
				->join('product as p', "p.product_id = tc.product_id")
				->where('tc.application_sess_temp_id', $temp_id);
			$result = $this->db->get();
			if ($result->num_rows() > 0) {
				$result = $result->result();
				$result = $result[0];
				$wishlist_count = $result->counts;
			}
		}
		if (empty($wishlist_count)) {
			$wishlist_count = 0;
		}
		$this->session->set_userdata('application_sess_wishlist_count', $wishlist_count);
		return $wishlist_count;
	}

	/**
	 * The method checks if a currency ID is stored in the session. If a currency ID is found, it fetches the corresponding currency from the database and updates the session with the fetched currency ID. If no currency ID is found in the session, it fetches the default currency from the database and updates the session with the fetched default currency ID. The method returns the currency data if found; otherwise, it returns false
	 */
	function setCurency($params = array())
	{
		// Get the currently set currency ID from the session
		$temp_currency_id = $this->session->userdata('application_sess_currency_id');

		// Check if there is a currency ID in the session
		if (!empty($temp_currency_id)) {
			// Build a database query to select the currency data with the currency ID from the session
			$this->db
				->select('c.*') // Select all columns from the currency table
				->from('currency as c') // From the currency table aliased as 'c'
				->where('status', 1) // Where the status column is 1 (indicating active currency)
				->where('currency_id', $temp_currency_id) // And where the currency_id matches the ID from the session
				->limit(1); // Limit the query to return only one row

			// Execute the query and store the result
			$result = $this->db->get();

			// Check if the query returned any rows
			if ($result->num_rows() > 0) {
				// Fetch the result as an array of objects
				$result = $result->result();
				// Get the first (and only) element from the result array
				$result = $result[0];
				// Update the session with the currency ID from the result
				$this->session->set_userdata('application_sess_currency_id', $result->currency_id);
				// Return the currency data
				return $result;
			} else {
				// If no rows were returned, return false
				return false;
			}
		} else {
			// If there is no currency ID in the session, select the default currency
			$this->db
				->select('c.*') // Select all columns from the currency table
				->from('currency as c') // From the currency table aliased as 'c'
				->where('status', 1) // Where the status column is 1 (indicating active currency)
				->where('defaults', 1) // And where the defaults column is 1 (indicating default currency)
				->limit(1); // Limit the query to return only one row

			// Execute the query and store the result
			$result = $this->db->get();

			// Check if the query returned any rows
			if ($result->num_rows() > 0) {
				// Fetch the result as an array of objects
				$result = $result->result();
				// Get the first (and only) element from the result array
				$result = $result[0];
				// Update the session with the currency ID from the result
				$this->session->set_userdata('application_sess_currency_id', $result->currency_id);
				// Return the currency data
				return $result;
			} else {
				// If no rows were returned, return false
				return false;
			}
		}
	}


	function getMenu($params = array())
	{
		$pg_content = array();
		$application_sess_temp_id = $this->session->userdata('application_sess_temp_id');
		$application_sess_store_id = $this->session->userdata('application_sess_store_id');
		$sql_get_list = "select c.category_id , c.ads_image, c.ads_image_url, c.ads_image_sub_cat_url, c.ads_image_super_sub_cat_url, c.ads_image_lower, c.ads_image_lower_url , c.ads_image_sub_cat , c.ads_image_super_sub_cat , c.name , c.category_icon , c.slug_url , c.cover_image , c.super_category_id, c.is_dropdown from category as c where c.status=1 and c.super_category_id =0 order by c.position asc	";
		//echo $sql_get_list;
		//$query_get_list=$this->db->query($sql_get_list);

		$this->db
			->DISTINCT()
			->select('c.category_id , c.ads_image, c.ads_image_url, c.ads_image_sub_cat_url, c.ads_image_super_sub_cat_url, c.ads_image_lower, c.ads_image_lower_url  , c.ads_image_sub_cat , c.ads_image_super_sub_cat, c.name , c.category_icon , c.slug_url , c.cover_image , c.super_category_id, c.is_dropdown')
			->from('category as c')
			//->join('product_category as pcat' , 'pcat.category_id=c.category_id')
			//->join('product as p' , 'pcat.product_id=p.product_id')
			//->join('product_combination as pc' , 'pc.product_id=p.product_id')
			//->join('product_in_store as pis' , 'pis.product_id=p.product_id')

			->where('c.super_category_id', 0)
			->where('c.is_outer_menu', 1)
			->where('c.status', 1)
			//->where('p.status' , 1)
			//	->where('pc.status' , 1)
			//->where('pis.status' , 1)
			->order_by('c.position asc');
		if (!empty($params['is_outer_menu'])) {
			$this->db->where("c.is_outer_menu", $params['is_outer_menu']);
		}
		/*if(__is_location_wise_product__)
																																																																							{
																																																																								$this->db->where("p.is_sell_local  in (".__app_is_sell_local__.")");
																																																																							}*/
		/*if($this->client_type==2)
																																																																							{
																																																																								$this->db->where("p.product_sell_to  in (1,3)");
																																																																							}
																																																																							else
																																																																							{
																																																																								$this->db->where("p.product_sell_to  in (1,2)");
																																																																							}*/

		$query_get_list = $this->db->get(); {

			if ($query_get_list->num_rows() > 0) {
				$mcCount = -1;
				$pg_content = $query_get_list->result();
				foreach ($query_get_list->result() as $row_get_list) {
					$mcCount++;
					$scCount = -1;
					//$sql_get_list1="select c.category_id  , c.ads_image, c.name , c.slug_url, c.cover_image , c.super_category_id from category as c where c.status=1 and c.super_category_id =$row_get_list->category_id order by c.position asc";
					//echo '<br>'.$sql_get_list1.'<br>';
					//$query_get_list1=$this->db->query($sql_get_list1);


					$this->db
						->DISTINCT()
						->select('c.category_id , c.ads_image , c.name , c.category_icon , c.slug_url , c.cover_image , c.super_category_id, c.is_dropdown')
						->from('category as c')
						//->join('product_category as pcat' , 'pcat.category_id=c.category_id')
						//->join('product as p' , 'pcat.product_id=p.product_id')
						//->join('product_combination as pc' , 'pc.product_id=p.product_id')
						//->join('product_in_store as pis' , 'pis.product_id=p.product_id')

						->where('c.super_category_id', $row_get_list->category_id)
						->where('c.status', 1)
						//->where('p.status' , 1)
						//->where('pc.status' , 1)
						//->where('pis.status' , 1)
						->order_by('c.position asc');
					/*if(__is_location_wise_product__)
																																																																																																																																																																																{
																																																																																																																																																																																	$this->db->where("p.is_sell_local  in (".__app_is_sell_local__.")");
																																																																																																																																																																																}
																																																																																																																																																																																if($this->client_type==2)
																																																																																																																																																																																{
																																																																																																																																																																																	$this->db->where("p.product_sell_to  in (1,3)");
																																																																																																																																																																																}
																																																																																																																																																																																else
																																																																																																																																																																																{
																																																																																																																																																																																	$this->db->where("p.product_sell_to  in (1,2)");
																																																																																																																																																																																}*/
					$query_get_list1 = $this->db->get();
					//echo $this->db->last_query();
					{

						if ($query_get_list1->num_rows() > 0) {
							$pg_content[$mcCount]->sub_category = $query_get_list1->result();
							foreach ($query_get_list1->result() as $row_get_list1) {
								$scCount++;
								//$sql_get_list2="select c.category_id  , c.ads_image, c.name, c.slug_url , c.cover_image , c.super_category_id from category as c where c.status=1 and c.super_category_id =$row_get_list1->category_id order by c.position asc";

								//$query_get_list2=$this->db->query($sql_get_list2);

								$this->db
									->DISTINCT()
									->select('c.category_id , c.ads_image , c.name , c.category_icon , c.slug_url , c.cover_image , c.super_category_id, c.is_dropdown')
									->from('category as c')
									->join('product_category as pcat', 'pcat.category_id=c.category_id')
									//->join('product as p' , 'pcat.product_id=p.product_id')
									//->join('product_combination as pc' , 'pc.product_id=p.product_id')
									//->join('product_in_store as pis' , 'pis.product_id=p.product_id')

									->where('c.super_category_id', $row_get_list1->category_id)
									->where('c.status', 1)
									//->where('p.status' , 1)
									//->where('pc.status' , 1)
									//	->where('pis.status' , 1)
									->order_by('c.position asc');
								/*if(__is_location_wise_product__)
																																																																																																																																																																																																																																																																																									{
																																																																																																																																																																																																																																																																																										$this->db->where("p.is_sell_local  in (".__app_is_sell_local__.")");
																																																																																																																																																																																																																																																																																									}
																																																																																																																																																																																																																																																																																									if($this->client_type==2)
																																																																																																																																																																																																																																																																																									{
																																																																																																																																																																																																																																																																																										$this->db->where("p.product_sell_to  in (1,3)");
																																																																																																																																																																																																																																																																																									}
																																																																																																																																																																																																																																																																																									else
																																																																																																																																																																																																																																																																																									{
																																																																																																																																																																																																																																																																																										$this->db->where("p.product_sell_to  in (1,2)");
																																																																																																																																																																																																																																																																																									}*/
								$query_get_list2 = $this->db->get(); {
									if ($query_get_list2->num_rows() > 0) {
										$sscCount = -1;
										$pg_content[$mcCount]->sub_category[$scCount]->super_sub_category = $query_get_list2->result();
										foreach ($query_get_list2->result() as $row_get_list3) {
											$sscCount++;
											$search = array(
												"cat_search" => $row_get_list3->category_id
											);
											//$products_list = $this->Products_model->productsSearch('products_list', '', '', $application_sess_temp_id, $application_sess_store_id, '', '', "", '', '', '', '', $search);
											//if(!empty($products_list))
											//$pg_content[$mcCount]->sub_category[$scCount]->super_sub_category[$sscCount]->products=$products_list;
										}
									} else {
										$search = array(
											"cat_search" => $row_get_list1->category_id
										);
										//$products_list = $this->Products_model->productsSearch('products_list', '', '', $application_sess_temp_id, $application_sess_store_id, '', '', "", '', '', '', '', $search);
										//$pg_content[$mcCount]->sub_category[$scCount]->products=$products_list;
									}
								}

							}
						} else {
							$search = array(
								"cat_search" => $row_get_list->category_id
							);
							//$products_list = $this->Products_model->productsSearch('products_list', '', '', $application_sess_temp_id, $application_sess_store_id, '', '', "", '', '', '', '', $search);
							//$pg_content[$mcCount]->products=$products_list;
						}
					}
				}
			}
		}

		return $pg_content;

	}

	function getProductByCategory($params = array())
	{
		$this->db
			->select("p.product_id, p.name as product_name, p.hsn_code, p.tax_id, p.ref_code, uom.unit_of_measurement_name as uom_name, tax.tax_percentage")
			->select("pcat.product_combination_id, pcat.product_display_name, pcat.final_price")
			->select("GROUP_CONCAT(DISTINCT(CONCAT(pa.name, ': ', pca.combination_value, ' ', pav.name ))) as combi")
			->select("c.category_id")
			->from("product as p")
			->join("product_category as pc", "pc.product_id = p.product_id")
			->join("category as c", "pc.category_id = c.category_id")
			->join("product_combination as pcat", "pcat.product_id = p.product_id")
			->join("product_combination_attribute as pca", "pca.product_combination_id = pcat.product_combination_id")
			->join("product_attribute as pa", "pa.product_attribute_id = pca.product_attribute_id")
			->join("product_attribute_value as pav", "pav.product_attribute_value_id = pca.product_attribute_value_id")
			->join("unit_of_measurement_master as uom", "pcat.uom_id = uom.unit_of_measurement_id")
			->join("tax as tax", "p.tax_id = tax.tax_id")
			->where("p.status", 1)
			->where("pcat.status", 1)
			->where("c.status", 1)
			->group_by("pcat.product_combination_id")
		;

		if (!empty($params['product_id'])) {
			$this->db->where("pcat.product_combination_id", $params['product_id']);
		}

		if (!empty($params['category_id'])) {
			$this->db->where("c.category_id", $params['category_id']);
		}

		return $this->db->get()->result();

	}

	function getUserDiscount($params = array())
	{
		$this->db
			->select()
			->from("client_group as cg")
			->join("client_group_category as cgc", "cgc.group_id = cg.group_id")
			//		->join("client_group_category as cgc", "cgc.group_id = cg.group_id")
		;

		if (!empty($params['category_id'])) {
			$this->db->where("cgc.category_id", $params['category_id']);
		}

		$this->db->where("cg.group_id", 1);

		return $this->db->get()->result();
	}

	function checkScreen()
	{
		$tablet_browser = 0;
		$mobile_browser = 0;

		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$tablet_browser++;
		}

		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$mobile_browser++;
		}

		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
			$mobile_browser++;
		}

		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
		$mobile_agents = array(
			'w3c ',
			'acs-',
			'alav',
			'alca',
			'amoi',
			'audi',
			'avan',
			'benq',
			'bird',
			'blac',
			'blaz',
			'brew',
			'cell',
			'cldc',
			'cmd-',
			'dang',
			'doco',
			'eric',
			'hipt',
			'inno',
			'ipaq',
			'java',
			'jigs',
			'kddi',
			'keji',
			'leno',
			'lg-c',
			'lg-d',
			'lg-g',
			'lge-',
			'maui',
			'maxo',
			'midp',
			'mits',
			'mmef',
			'mobi',
			'mot-',
			'moto',
			'mwbp',
			'nec-',
			'newt',
			'noki',
			'palm',
			'pana',
			'pant',
			'phil',
			'play',
			'port',
			'prox',
			'qwap',
			'sage',
			'sams',
			'sany',
			'sch-',
			'sec-',
			'send',
			'seri',
			'sgh-',
			'shar',
			'sie-',
			'siem',
			'smal',
			'smar',
			'sony',
			'sph-',
			'symb',
			't-mo',
			'teli',
			'tim-',
			'tosh',
			'tsm-',
			'upg1',
			'upsi',
			'vk-v',
			'voda',
			'wap-',
			'wapa',
			'wapi',
			'wapp',
			'wapr',
			'webc',
			'winw',
			'winw',
			'xda ',
			'xda-'
		);

		if (in_array($mobile_ua, $mobile_agents)) {
			$mobile_browser++;
		}

		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
			$mobile_browser++;
			//Check for tablets on opera mini alternative headers
			$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
				$tablet_browser++;
			}
		}

		if ($tablet_browser > 0) {
			// do something for tablet devices
			//print 'is tablet';
			return 'ismobile';
		} else if ($mobile_browser > 0) {
			// do something for mobile devices
			//print 'is mobile';
			return 'ismobile';
		} else {
			// do something for everything else
			//print 'is desktop';
			return 'isdesktop';
		}
	}


	function allPageData($params = array())
	{
		$user_id = $this->session->userdata('sess_answercart_uid');
		$data = array();

		$property = $this->Common_Model->getData(array('from' => 'ans_property', 'select' => '*', 'where' => "user_id = $user_id  "));//and  config_complete=1
		$data['property'] = $property;

		return $data;
	}









	function random_password($password_length = 8, $type = 'both')
	{
		if ($type == 'number')
			$alphabet = '1234567890';
		else if ($type == 'alphabet')
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		else
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$password = array();
		$alpha_length = strlen($alphabet) - 1;
		for ($i = 0; $i < $password_length; $i++) {
			$n = rand(0, $alpha_length);
			$password[] = $alphabet[$n];
		}
		return implode($password);
	}


	function getMaxPosition($id, $table_name, $where)
	{
		//$sql_get_maxID = $this->db->select_max($id,'max_id');

		$sql_get_maxID = $this->db->select_max($id, 'max_id');

		if ($table_name == 'product_image_position') {
			$sql_get_maxID = $this->db->where('product_id', $where);
			$query_get_maxID = $this->db->get($this->product_image_table_name);
		}

		if ($table_name == 'category_position') {
			$sql_get_maxID = $this->db->where('super_category_id', $where);
			$query_get_maxID = $this->db->get($this->category_table_name);
		}

		if ($table_name == 'attribute_position') {
			$sql_get_maxID = $this->db->where('product_attribute_id', $where);
			$query_get_maxID = $this->db->get($this->product_attribute_value_table_name);
		}
		//echo $this->db->last_query();
		if ($table_name == 'running_line_position') {
			$sql_get_maxID = $this->db->where('running_line_id', $where);
			$query_get_maxID = $this->db->get($this->running_line_table_name);
		}


		$row_get_maxID = $query_get_maxID->row();
		//$row_get_maxID = $query_get_maxID[0];
		$maxid = $row_get_maxID->max_id;
		if ($maxid == "")
			$maxid = 1;
		else
			$maxid = $maxid + 1;
		return $maxid;
	}


	function temp_cart($category, $id, $status = '', $search1 = '', $search2 = '', $search3 = '', $search4 = '', $search5 = '', $search6 = '')
	{
		$pg_content = array();
		if ($category == 'search_product_in_cart') {
			$sql_get_list = "select quantity, temp_cart_id from temp_cart where temp_cart_id ";
			if (!empty($search4))
				$sql_get_list .= " and application_sess_temp_id = '$search4' ";
			if (!empty($search1))
				$sql_get_list .= " and product_in_store_id = '$search1' ";
			if (!empty($search5))
				$sql_get_list .= " and store_id = '$search5' ";
			if (!empty($search2))
				$sql_get_list .= " and product_id = '$search2' ";
			if (!empty($search3))
				$sql_get_list .= " and product_combination_id = '$search3' ";

			$query_get_list = $this->db->query($sql_get_list); {
				if ($query_get_list->num_rows() > 0) {
					foreach ($query_get_list->result() as $row_get_list) {
						$pg_content[] = array("quantity" => $row_get_list->quantity, "temp_cart_id" => $row_get_list->temp_cart_id);
					}
				}
			}
			return $pg_content;
		}

		if ($category == 'distinct_product_id_in_cart') {
			$sql_get_list = "select product_id , product_combination_id from temp_cart where temp_cart_id ";
			if (!empty($search4))
				$sql_get_list .= " and application_sess_temp_id = '$search4' ";
			if (!empty($search1))
				$sql_get_list .= " and product_in_store_id = '$search1' ";
			if (!empty($search5))
				$sql_get_list .= " and store_id = '$search5' ";
			if (!empty($search2))
				$sql_get_list .= " and product_id = '$search2' ";
			if (!empty($search3))
				$sql_get_list .= " and product_combination_id = '$search3' ";

			$query_get_list = $this->db->query($sql_get_list); {
				if ($query_get_list->num_rows() > 0) {
					foreach ($query_get_list->result() as $row_get_list) {
						$pg_content[] = array("product_id" => $row_get_list->product_id, "product_combination_id" => $row_get_list->product_combination_id);
					}
				}
			}
			return $pg_content;
		}
	}



	function send_mail($params = array())
	{
		if (_is_email != 1) {
			return false;
		}
		//echo "<pre>";print_r($params);
		$template = $params['template'];
		$subject = $params['subject'];
		$to = $params['to'];
		$name = $params['name'];
		$email_header_category = '';

		//echo $template;exit;
		$entereddatamaillog['subject'] = $subject;
		$entereddatamaillog['template'] = $template;
		$entereddatamaillog['to'] = $to;
		$entereddatamaillog['added_on'] = date('Y-m-d H:i:s');

		$email_header_category = '';

		$main_category = $this->getData(array('select' => '*', 'from' => 'category', 'where' => "(super_category_id =0 and status=1)"));
		if (!empty($main_category)) {
			$c_count = 0;
			foreach ($main_category as $mc) {
				$c_count++;
				$email_header_category .= '<td style="padding-left:7px;padding-right:8px;text-align:center;border-right:1px solid #fff;"><a style="font-size:14px;color:#000;text-decoration:none;text-align:center;display:inline-block;font-family:Tahoma, Geneva, sans-serif;font-weight:500;" href="' . base_url() . $mc->slug_url . '">' . $mc->name . '</a></td>';

				if ($c_count == 6) {
					break;
				}
			}
		}
		$template = str_replace("#email_header_category#", $email_header_category, $template);

		$from_email = __from_email__;
		$from_name = _project_complete_name_;

		$request = $error_info = "";
		$GATEWAYAPI = 'https://enterprise.webaroo.com/GatewayAPI/rest';
		$post_data['method'] = "EMS_POST_CAMPAIGN";
		$post_data['userid'] = __email_user_id__;
		$post_data['password'] = __email_user_password__;
		$post_data['recipients'] = $to;
		$post_data['email_id'] = $from_email;
		$post_data['subject'] = $subject;
		$post_data['content'] = $template;
		$post_data['content_type'] = "text/html";
		$post_data['name'] = $from_name;
		$post_data['v'] = "1.1";
		$post_data['check_duplicate_post'] = "true";
		$post_data['bccEmailId'] = "abhishek.khandelwal@marswebsolution.com";
		//$post_data['ccEmailId'] = "pankaj@marswebsolutions.com";
		$post_data['replyToEmailId'] = __adminemail__;





		foreach ($post_data as $key => $val) {
			$request .= $key . "=" . urlencode($val);
			$request .= "&";
		}
		$request = substr($request, 0, strlen($request) - 1);
		//$check_url = "https://tsms.marswebhosting.com/GatewayAPI/rest?".$request;
		//echo $check_url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $GATEWAYAPI);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		$res = curl_exec($ch);
		if ($res === false) {
			$error_info = curl_error($ch);
			$mailMessageStatus = "OOPS !! Mail Delivery Failed. Please Try Again.";
			$message = "mailnotsent";
			$mail_status = 'Not Sent';
			$mailMessageStatus = "OOPS !! Mail Delivery Failed. Please Try Again."; //echo "Message delivery failed...";
			//$error_info=$mail->ErrorInfo;
			$msg = 'psfail';
			$entereddatamaillog['status'] = 2;
			$entereddatamaillog['error_info'] = $error_info;
		} else {
			$error_info = curl_error($ch);
			$mailMessageStatus = "sent";
			$message = "mailsent";
			$mail_status = 'Sent';
			$mailMessageStatus = "sent"; //echo "Message successfully sent!";
			$msg = 'psuccess';
			$entereddatamaillog['status'] = 1;
			$entereddatamaillog['error_info'] = $error_info;
			//$this->set_message('forgot_password_successful');
		}
		//echo "<pre>";print_r($res);echo "</pre>";
		$entereddatamaillog['response'] = $res;
		//	curl_close($ch);
		//	echo $mail_status;


		$insertStatus = $this->add_operation(array('table' => 'email_log', 'data' => $entereddatamaillog));
		//exit;
		/*$params['to'] = 'abhishek.khandelwal@marswebsolution.com';
																																																																						$params['name'] = 'Abhishek Khandelwal';
																																																																						$this->re_send_mail($params);*/
	}

	function re_send_mail($params = array())
	{
		$template = $params['template'];
		$subject = $params['subject'];
		$to = $params['to'];
		$name = $params['name'];

		$entereddatamaillog['subject'] = $subject;
		$entereddatamaillog['template'] = $template;
		$entereddatamaillog['to'] = $to;
		$entereddatamaillog['added_on'] = date('Y-m-d H:i:s');

		$email_header_category = '';

		//$main_category = $this->Common_Model->getData(array('select'=>'*' , 'from'=>'category' , 'where'=>"(super_category_id =0 and status=1)" ));
		$main_category = $this->getData(array('select' => '*', 'from' => 'category', 'where' => "(super_category_id =0 and status=1)"));
		if (!empty($main_category)) {
			$c_count = 0;
			foreach ($main_category as $mc) {
				$c_count++;
				$email_header_category .= '<td style="padding-left:7px;padding-right:8px;text-align:center;border-right:1px solid #fff;"><a style="font-size:14px;color:#000;text-decoration:none;text-align:center;display:inline-block;font-family:Tahoma, Geneva, sans-serif;font-weight:500;" href="' . base_url() . $mc->slug_url . '">' . $mc->name . '</a></td>';

				if ($c_count == 6) {
					break;
				}
			}
		}
		$template = str_replace("#email_header_category#", $email_header_category, $template);

		$from_email = __from_email__;
		$from_name = _project_complete_name_;

		$request = $error_info = "";
		$GATEWAYAPI = 'https://enterprise.webaroo.com/GatewayAPI/rest';
		$post_data['method'] = "EMS_POST_CAMPAIGN";
		$post_data['userid'] = __email_user_id__;
		$post_data['password'] = __email_user_password__;
		$post_data['recipients'] = $to;
		$post_data['email_id'] = $from_email;
		$post_data['subject'] = $subject;
		$post_data['content'] = $template;
		$post_data['content_type'] = "text/html";
		$post_data['name'] = $from_name;
		$post_data['v'] = "1.1";
		$post_data['check_duplicate_post'] = "true";
		foreach ($post_data as $key => $val) {
			$request .= $key . "=" . urlencode($val);
			$request .= "&";
		}
		$request = substr($request, 0, strlen($request) - 1);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $GATEWAYAPI);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		if ($res = curl_exec($ch) === false) {
			$error_info = curl_error($ch);
			$mailMessageStatus = "OOPS !! Mail Delivery Failed. Please Try Again.";
			$message = "mailnotsent";
			$mail_status = 'Not Sent';
			$mailMessageStatus = "OOPS !! Mail Delivery Failed. Please Try Again."; //echo "Message delivery failed...";
			//$error_info=$mail->ErrorInfo;
			$msg = 'psfail';
			$entereddatamaillog['status'] = 2;
			$entereddatamaillog['error_info'] = $error_info;
		} else {
			$error_info = curl_error($ch);
			$mailMessageStatus = "sent";
			$message = "mailsent";
			$mail_status = 'Sent';
			$mailMessageStatus = "sent"; //echo "Message successfully sent!";
			$msg = 'psuccess';
			$entereddatamaillog['status'] = 1;
			$entereddatamaillog['error_info'] = $error_info;
			//$this->set_message('forgot_password_successful');
		}
		curl_close($ch);
		//	echo $mail_status;

		$entereddatamaillog['response'] = $res;
		$insertStatus = $this->add_operation(array('table' => 'email_log', 'data' => $entereddatamaillog));
	}

	function send_sms($mobile, $template)
	{
		if (_is_sms != 1) {
			return false;
		}
		$request = ""; //initialise the request variable
		$param['method'] = "sendMessage";
		$param['send_to'] = $mobile;
		$param['msg'] = $template;
		$param['loginid'] = __sms_user_id__;
		$param['password'] = __sms_user_password__;
		$param['v'] = "1.1";
		$param['msg_type'] = "TEXT"; //Can be "FLASH"/"UNICODE_TEXT"/"BINARY"
		$param['auth_scheme'] = "PLAIN";
		$param['override_dnd'] = "true";
		//Have to URL encode the values
		foreach ($param as $key => $val) {
			$request .= $key . "=" . urlencode($val);
			//we have to urlencode the values
			$request .= "&";
			//append the ampersand (&) sign after each parameter/value pair
		}
		$request = substr($request, 0, strlen($request) - 1);
		//remove final (&) sign from the request
		//echo $request; echo "</br>";
		$GATEWAYAPI = "http://tsms.marswebhosting.com/GatewayAPI/rest?" . $request;
		//echo $GATEWAYAPI; echo "</br>";
		//$ch = curl_init($GATEWAYAPI);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $GATEWAYAPI);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//$curl_scraped_page = curl_exec($ch);
		$resp = curl_exec($ch);
		if (($resp === false)) {
			$response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$error_info = curl_error($ch);
			$smsMessageStatus = "OOPS !! SMS Delivery Failed. Please Try Again.";
			$message = "smsnotsent";
			$sms_status = false;
			$smsMessageStatus = "OOPS !! SMS Delivery Failed. Please Try Again."; //echo "Message delivery failed...";
			$msg = 'psfail';
			$entereddatasmslog['error_info'] = $error_info;
			$entereddatasmslog['status'] = 2;
			//echo "response1 </br>";
			//print_r($response);
		} else {
			//$response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$error_info = curl_error($ch);
			//echo "<pre>";print_r($res);echo "</pre>";
			$smsMessageStatus = "sent";
			$message = "smssent";
			$sms_status = true;
			$smsMessageStatus = "sent"; //echo "Message successfully sent!";
			$msg = 'psuccess';
			$entereddatasmslog['error_info'] = $error_info;
			$entereddatasmslog['status'] = 1;
			//echo "response2 </br>";
			//print_r($response);
			//$this->set_message('forgot_password_successful');
		}
		curl_close($ch);
		$entereddatasmslog['template'] = $template;
		$entereddatasmslog['to'] = $mobile;
		$entereddatasmslog['added_on'] = date('Y-m-d H:i:s');
		$entereddatasmslog['response'] = $resp;

		$id = $this->add_operation(array('table' => 'sms_log', 'data' => $entereddatasmslog));
		//exit;
	}




	///CURRENTLY NOT USING METHODS
	/****************************************************************
	 *SPECIFIC DB TABLE DATA OPERATIONS
	 *****************************************************************/


	/**
	 * Function to retrieve country data from the database
	 *
	 * @param array $params Optional parameters
	 * @return mixed Array containing country data if found, otherwise false
	 */
	//not using
	function getCountry($params = array())
	{
		// Select specific columns from the 'country' table
		$this->db
			->select('c.country_id, c.country_name, c.country_short_name, c.country_code')
			->from('country as c')
			->where('status', 1); // Filter by status = 1 (assuming 1 represents active)

		// Execute the query
		$result = $this->db->get();

		// Check if there are rows returned
		if ($result->num_rows() > 0) {
			// If rows are found, retrieve the result as an array of objects
			$result = $result->result();
			// Optionally, you can remove the following line as it does not modify the result
			$result = $result;



			// Return the result
			return $result;
		} else {
			// If no rows are found, return false
			return false;
		}
	}
	/****************************************************************
	 ****************************************************************/

}

?>