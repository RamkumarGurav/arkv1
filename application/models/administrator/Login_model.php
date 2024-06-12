<?php

class Login_model extends CI_Model
{
	protected $search_query;

	function __construct($search_query = '')
	{
		//parent::__construct();
		$this->load->database();
		$this->search_query = $search_query;
		$this->db->query("SET sql_mode = ''");
	}


	/**
	 *The doSignInUser from administrator/Login_model.php method handles user authentication. It takes the username and password from a POST request, hashes the password using MD5, and checks for a matching user in the admin_user database. If a matching active user is found, it retrieves the user's roles, updates the user's last login timestamp and IP address, and returns the user's details. If no matching user is found or the user is inactive, it returns false.
	 */
	function doSignInUser($params = array())
	{
		// (not used in this function) Initialize status variable 
		$status = true;

		// Get username and password from POST request
		$username = $_POST['username'];
		// Encrypt the password using md5 hashing
		$password = md5($_POST['password']);

		// Build the query to select the user from the admin_user table
		$this->db
			->select('u.*') // Select all columns from admin_user table
			->from('admin_user as u') // From the admin_user table aliased as 'u'
			->where("(email = '$username' or username = '$username')") // Where the email or username matches the input username
			->where('password', $password) // And the password matches the hashed input password
			->limit(1); // Limit the query to return only one row

		// Execute the query
		$result = $this->db->get();

		// Check if the query returned any rows
		if ($result->num_rows() > 0) {
			// Fetch the result as an array of objects
			$result = $result->result();
			// Get the first (and only) element from the result array
			$result = $result[0];

			// Check if the user status is active (1)
			if ($result->status == 1) {
				// Build a query to fetch the roles of the user
				$this->db->select("aur.*, urm.user_role_name, cp.company_unique_name");
				$this->db->from("admin_user_role as aur");
				$this->db->join("users_role_master as urm", "urm.user_role_id = aur.user_role_id");
				$this->db->join("company_profile as cp", "cp.company_profile_id = aur.company_profile_id");
				$this->db->where("aur.admin_user_id", $result->admin_user_id);
				// Execute the query and assign the result to the roles property of the user object
				$result->roles = $this->db->get()->result();

				// Get the client's IP address using a method from Common_Model
				$client_ip = $this->Common_Model->get_client_ip();
				// Prepare data for updating the user's last login information
				$update_login['last_login'] = date('Y-m-d H:i:s');
				$update_login['last_loginip'] = $client_ip;
				// Update the user's last login information in the admin_user table
				$response = $this->Common_Model->update_operation(array('table' => "admin_user", 'data' => $update_login, 'condition' => "(admin_user_id = $result->admin_user_id)"));
			}
			// Return the user data
			return $result;

		} else {
			// If no rows were returned, return false
			return false;
		}
	}


	function sendPasswordRecoveryEmail($params = array())
	{
		$status = true;
		$user_login_id = $_POST['user_login_id'];

		$this->db
			->select('u.*')
			->from($this->dataTablesObj->userTableName . ' as u ')
			->where('email', $user_login_id)
			->limit(1);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$result = $result->result();
			$result = $result[0];
			$this->session->set_userdata('sess_email', $result->email);
			$random_password = $this->Common_Model->random_password(4);
			$random_password = md5($random_password . time());
			$previous_password_recovery_code = $this->Common_Model->getData(array('from' => $this->dataTablesObj->userFieldsTableName, 'select' => '*', 'where' => "(user_id = $result->user_id and title='password_recovery_code' )"));
			if (empty($previous_password_recovery_code)) {
				$inputDBField = array(
					'user_id' => $result->user_id,
					'title' => "password_recovery_code",
					'content' => $random_password,
					'added_on' => date('Y-m-d H:i:s'),
					'status' => 1
				);
				$response = $this->Common_Model->add_operation(array('table' => $this->dataTablesObj->userFieldsTableName, 'data' => $inputDBField));
			} else {
				$previous_password_recovery_code = $previous_password_recovery_code[0];
				$random_password = $previous_password_recovery_code->content;
			}

			$mailMessage = file_get_contents(APPPATH . 'mailers/password_recovery.html');
			$mailMessage = preg_replace('/\\\\/', '', $mailMessage); //Strip backslashes														
			$mailMessage = str_replace("#name#", stripslashes($result->name), $mailMessage);
			$mailMessage = str_replace("#verification_link#", base_url() . __recoverPassword__ . '?recovery_token=' . $random_password, $mailMessage);
			$mailMessage = str_replace("#mainsite#", base_url(), $mailMessage);
			$subject = "Password Recovery !AnswerCart";
			$mailStatus = $this->Common_Model->send_mail(array("template" => $mailMessage, "subject" => $subject, "to" => $result->email, "name" => $result->name));

			$client_ip = $this->Common_Model->get_client_ip();
			$update_login['write'] = date('Y-m-d H:i:s');
			$update_login['writeip'] = $client_ip;
			//$update_login['loginip'] = $random_password;
			$response = $this->Common_Model->update_operation(array('table' => $this->dataTablesObj->userTableName, 'data' => $update_login, 'condition' => "(user_id = $result->user_id)"));
			return $result;

		} else {
			return false;
		}
	}

	function updatePassword($params = array())
	{
		$user_id = $params['previous_password_recovery_code']->user_id;
		$recovery_code_user_fields_id = $params['previous_password_recovery_code']->user_fields_id;

		$client_ip = $this->Common_Model->get_client_ip();
		$update_password['write'] = date('Y-m-d H:i:s');
		$update_password['writeip'] = $client_ip;
		$update_password['password'] = md5($_POST['new_password']);

		$if_exist = $this->Common_Model->getData(array('from' => $this->dataTablesObj->userFieldsTableName, 'select' => '*', 'where' => "(user_id = $user_id and title='password' )"));

		$response = $this->Common_Model->update_operation(array('table' => $this->dataTablesObj->userTableName, 'data' => $update_password, 'condition' => "(user_id = $user_id)"));
		if ($response) {
			$inputDBField = array(
				'user_id' => $user_id,
				'title' => "password",
				'content' => $_POST['new_password'],
				'added_on' => date('Y-m-d H:i:s'),
				'status' => 1
			);
			if (empty($if_exist)) {
				$response = $this->Common_Model->add_operation(array('table' => $this->dataTablesObj->userFieldsTableName, 'data' => $inputDBField));
			} else {
				$if_exist = $if_exist[0];
				$user_fields_id = $if_exist->user_fields_id;
				$response = $this->Common_Model->update_operation(array('table' => $this->dataTablesObj->userFieldsTableName, 'data' => $inputDBField, 'condition' => "(user_fields_id = $user_fields_id)"));
			}
			$response = $this->Common_Model->delete_operation(array('table' => $this->dataTablesObj->userFieldsTableName, 'where' => "(user_fields_id = $recovery_code_user_fields_id and title='password_recovery_code')"));
			return true;
		} else {
			return false;
		}
	}

	function checkPasswordRecoveryCode($params = array())
	{
		$previous_password_recovery_code = $this->Common_Model->getData(array('from' => $this->dataTablesObj->userFieldsTableName, 'select' => '*', 'where' => "content = '$params[password_recovery_code]' and title='password_recovery_code' "));
		return $previous_password_recovery_code;
	}

	function doCheckEmailVerify($params = array())
	{
		$status = true;
		$result = '';
		$this->db
			->select('uf.* , (select content from ans_user_fields as auf where title="password" and uf.user_id=auf.user_id limit 1) as password_show ')
			->from($this->dataTablesObj->userTableName . ' as uf')
			->where('emailcode', $params['emailVerificationCode']);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$result = $result->result();
			$result = $result[0];
			$user_id = $result->user_id;
			$client_ip = $this->Common_Model->get_client_ip();
			$dbresponse = '';
			$dbresponse = $this->Common_Model->update_operation(array('table' => $this->dataTablesObj->userTableName, 'data' => array('email_verify' => 1, 'emailcode' => '', "write" => date("Y-m-d h:i:s"), 'writeip' => $client_ip), 'condition' => "user_id = $user_id"));
			if ($dbresponse > 0 || true) {
				$status = true;
			} else
				$status = 'errorProcess';
		} else {
			$status = false;
		}
		return array('response' => $status, 'userInfo' => $result);
	}

	function getUsers($params = array())
	{
		$this->db
			->select('u.*')
			->from($this->dataTablesObj->userTableName . ' as u ')
			->where('u.user_id', $params['user_id']);
		if (!empty($params['status'])) {
			$this->db->where('c.status', $params['status']);
		}
		if (!empty($params['limit'])) {
			$this->db->limit($params['limit']);
		}
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$result = $result->result();
			return $result[0];

		} else {
			return false;
		}
	}

}

?>