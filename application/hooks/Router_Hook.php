<? 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Router_Hook
{
        /**
         * Loads routes from database.
         *
         * @access public
         * @params array : hostname, username, password, database, db_prefix
         * @return void
         */
    function get_routes($params)
    {
        global $DB_ROUTES;
		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		$urlarr = explode('?' , $url);
		if(!empty($urlarr[1]))
		{
			if(strpos($url,"/?")!== false)
			{
				//$url = str_replace('?' , '/?' , $url);
				//echo '1';
			}
			else
			{
				$url = str_replace('?' , '/?' , $url);
				//echo '2';
			}
			
			/*$url = $urlarr[0];
			$url = trim($url , '?');
			echo "<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-52666738-1', 'auto');
ga('send', 'pageview');location.href='$url';</script>";*/
		}

        $con = mysqli_connect($params[0], $params[1], $params[2]);


       $aa= mysqli_select_db($con , $params[3]);
	  
	  $sql_mode_query = "SET sql_mode = ''";
        mysqli_query($con , $sql_mode_query);
		
        $category_id = $category_id1 = $category_id2 = 0;
		$slug_url = $slug_url1 = $slug_url2 = '';

        $routes = array();
	
		$url = trim($url , '/');
		$url = str_replace(MAINSITE , '' , $url);
		$segments = explode('/', $url);
	//	print_r($segments);
		if(!empty($segments[0]))
		{
			if(strpos($segments[0],"search?")!== false)
			{
				//echo $segments[0];
				$routes[$segments[0]] = "products/search_query";
				//echo "<pre>";print_r($routes);
			}
			
			/*$sql = "SELECT manufacturer_id ,slug_url FROM manufacturer where status=1 and slug_url like '$segments[0]'  "; // MAIN brand / manufacturer
	        $query = mysqli_query($con , $sql);
			while ($route = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				
				$manufacturer_id = $route['manufacturer_id'];
				$slug_url = $route['slug_url'];
				
				$routes["$slug_url"] = "products/all_products/0/0/0/0/0/0/$manufacturer_id/$slug_url";
			}*/
			
			$sql = "SELECT category_id ,slug_url FROM category where status=1 and slug_url like '$segments[0]' and super_category_id = 0 "; // MAIN CATEGORY
	        $query = mysqli_query($con , $sql);
			while ($route = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				
				$category_id = $route['category_id'];
				$slug_url = $route['slug_url'];
				
				$routes["$slug_url"] = "products/all_products/$category_id/0/0/$slug_url/0/0";
			}
			
			if(!empty($segments[1]))
			{
				$isProduct = true;
				$sql = "SELECT category_id ,slug_url FROM category where status=1 and slug_url like '$segments[1]' and super_category_id = $category_id ";  // SUB MAIN CATEGORY
				$query = mysqli_query($con , $sql);
				while ($route = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					$isProduct = false;
					$category_id1 = $route['category_id'];
					$slug_url1 = $route['slug_url'];
					
					$routes["$slug_url/$slug_url1"] = "products/all_products/$category_id/$category_id1/0/$slug_url/$slug_url1/0";
				}
				
				if($isProduct)
				{
					$sql = "SELECT product_seo.product_id , product_seo.product_combination_id , product_seo.store_id , product_seo.product_in_store_id	 ,product_seo.slug_url FROM product_seo , product , product_combination where product_seo.slug_url like '$segments[1]' and product.product_id = product_seo.product_id  and product.product_id = product_seo.product_id and product_combination.product_combination_id = product_seo.product_combination_id and product.status=1 and product_combination.status=1 ";
					$query = mysqli_query($con , $sql);
					while ($route = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
						
						$product_id = $route['product_id'];
						$product_combination_id = $route['product_combination_id'];
						$store_id = $route['store_id'];
						$product_in_store_id = $route['product_in_store_id'];
						$pslug_url = $route['slug_url'];
						
						$routes["$slug_url/$pslug_url"] = "products/products_details/$product_id/$product_combination_id/$category_id/0/0/$slug_url/0/0";
					}
				}
			}
			
			if(!empty($segments[2]))
			{
				$isProduct = true;
				$sql = "SELECT category_id ,slug_url FROM category where status=1 and slug_url like '$segments[2]' and super_category_id = $category_id1 ";  // SUPER SUB MAIN CATEGORY
				$query = mysqli_query($con , $sql);
				while ($route = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					$isProduct = false;
					$category_id2 = $route['category_id'];
					$slug_url2 = $route['slug_url'];
					
					$routes["$slug_url/$slug_url1/$slug_url2"] = "products/all_products/$category_id/$category_id1/$category_id2/$slug_url/$slug_url1/$slug_url2";
				}
				if($isProduct)
				{
					//$sql = "SELECT product_id , product_combination_id , store_id , product_in_store_id	 ,slug_url FROM product_seo where slug_url like '$segments[2]' ";
					$sql = "SELECT product_seo.product_id , product_seo.product_combination_id , product_seo.store_id , product_seo.product_in_store_id	 ,product_seo.slug_url FROM product_seo , product , product_combination where product_seo.slug_url like '$segments[2]' and product.product_id = product_seo.product_id  and product.product_id = product_seo.product_id and product_combination.product_combination_id = product_seo.product_combination_id and product.status=1 and product_combination.status=1 ";
					$query = mysqli_query($con , $sql);
					while ($route = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
						
						$product_id = $route['product_id'];
						$product_combination_id = $route['product_combination_id'];
						$store_id = $route['store_id'];
						$product_in_store_id = $route['product_in_store_id'];
						$pslug_url = $route['slug_url'];
						
						$routes["$slug_url/$slug_url1/$pslug_url"] = "products/products_details/$product_id/$product_combination_id/$category_id/$category_id1/0/$slug_url/$slug_url1/0";
					}
				}
			}
			
			if(!empty($segments[3]))
			{
				//$sql = "SELECT product_id , product_combination_id , store_id , product_in_store_id	 ,slug_url FROM product_seo where slug_url like '$segments[3]' ";
				$sql = "SELECT product_seo.product_id , product_seo.product_combination_id , product_seo.store_id , product_seo.product_in_store_id	 ,product_seo.slug_url FROM product_seo , product , product_combination where product_seo.slug_url like '$segments[3]' and product.product_id = product_seo.product_id  and product.product_id = product_seo.product_id and product_combination.product_combination_id = product_seo.product_combination_id and product.status=1 and product_combination.status=1 ";
				$query = mysqli_query($con , $sql);
				while ($route = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					
					$product_id = $route['product_id'];
					$product_combination_id = $route['product_combination_id'];
					$store_id = $route['store_id'];
					$product_in_store_id = $route['product_in_store_id'];
					$pslug_url = $route['slug_url'];
					
					$routes["$slug_url/$slug_url1/$slug_url2/$pslug_url"] = "products/products_details/$product_id/$product_combination_id/$category_id/$category_id1/$category_id2/$slug_url/$slug_url1/$slug_url2";
				}
				
			}
			
			
			
			//$sql = "SELECT product_id , product_combination_id , store_id , product_in_store_id	 ,slug_url FROM product_seo where slug_url like '$segments[0]' ";
			$sql = "SELECT product_seo.product_id , product_seo.product_combination_id , product_seo.store_id , product_seo.product_in_store_id	 ,product_seo.slug_url FROM product_seo , product , product_combination where product_seo.slug_url like '$segments[0]' and product.product_id = product_seo.product_id  and product.product_id = product_seo.product_id and product_combination.product_combination_id = product_seo.product_combination_id and product.status=1 and product_combination.status=1 ";
			//echo $sql;
	        $query = mysqli_query($con , $sql);
			while ($route = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				
				$product_id = $route['product_id'];
				$product_combination_id = $route['product_combination_id'];
				$store_id = $route['store_id'];
				$product_in_store_id = $route['product_in_store_id'];
				$slug_url = $route['slug_url'];
				
				$routes["$slug_url"] = "products/products_details/$product_id/$product_combination_id";
			}
		}
		
		//'products/all_products/$1';
		
		/*$sql = "select sub_category_name , sub_category_id , category_id , (select c.category_name from category as c where c.category_id=sc.category_id) as category_name from sub_category as sc where sc.status=1";
        $query = mysqli_query($con , $sql);

        while ($route = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			
			$route1 = str_replace(' ' , '-', $route['category_name']);
			$route2 = str_replace(' ' , '-', $route['sub_category_name']);
			
			$c_route1 = $route['category_id'];
			$c_route2 = $route['sub_category_id'];
			
            $routes["$route1/$route2"] = "user/all_products1/$c_route1/$c_route2";
        }
		
		$sql = "select p.product_name , p.product_id  , (SELECT c.category_name FROM category as c where c.status=1 and c.category_id = pc.main_category_id) as category_name , (SELECT c.category_id FROM category as c where c.status=1 and c.category_id = pc.main_category_id) as category_id , (SELECT sc.sub_category_name FROM sub_category as sc where sc.status=1 and sc.sub_category_id = pc.sub_category_id) as sub_category_name , (SELECT sc.sub_category_id FROM sub_category as sc where sc.status=1 and sc.sub_category_id = pc.sub_category_id) as sub_category_id from product as p , product_category as pc where p.status=1 and pc.product_id=p.product_id ";
		//echo $sql;
        $query = mysqli_query($con , $sql);

        while ($route = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			
			$route1 = str_replace(' ' , '-', $route['category_name']);
			$route2 = str_replace(' ' , '-', $route['sub_category_name']);
			$route3 = str_replace(' ' , '-', $route['product_name']);
			
			$c_route1 = $route['category_id'];
			$c_route2 = $route['sub_category_id'];
			$c_route3 = $route['product_id'];
			
			if($route2==NULL)
			{
				$routes["$route1/$route3"] = "user/product_detail1/$c_route1/0/$route3";
			}
			else
			{
            	$routes["$route1/$route2/$route3"] = "user/product_detail2/$c_route1/$c_route2/$c_route3";
			}
        }*/
		/*echo "<pre>";
		print_r($routes);
		echo "</pre>";*/
        mysqli_free_result($query);
        mysqli_close($con);
        $DB_ROUTES = $routes;
		/*echo "<pre>";
		print_r($DB_ROUTES);
		exit;*/
		
    }
}

?>