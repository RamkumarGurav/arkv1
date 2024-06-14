<?php

class Screen_Lock_model extends CI_Model
{
	// A protected variable to store the search query
	protected $search_query;

	// Constructor method that initializes the search query and loads the database
	function __construct($search_query = '')
	{
		// Call the parent constructor (commented out, possibly not needed)
		// parent::__construct();

		// Load the database library
		$this->load->database();

		// Set the search query to the provided value (default is an empty string)
		$this->search_query = $search_query;

		// Disable the SQL strict mode
		$this->db->query("SET sql_mode = ''");
	}

	// Method to sign in the user
	function doSignInUser($params = array())
	{
		// Initialize the status variable to true (though it's not used in the function)
		$status = true;

		// Get the session user ID from the data array
		$session_uid = $this->data['session_uid'];

		// Hash the provided password using MD5
		$password = md5($_POST['password']);

		// Build the query to select the user from the 'admin_user' table
		$this->db
			->select('u.*') // Select all columns from the 'admin_user' table
			->from('admin_user as u ') // From the 'admin_user' table aliased as 'u'
			->where('admin_user_id', $session_uid) // Where the 'admin_user_id' matches the session user ID
			->where('password', $password) // And the 'password' matches the provided hashed password
			->limit(1); // Limit the results to 1 row

		// Execute the query
		$result = $this->db->get();

		// Check if the query returned any rows
		if ($result->num_rows() > 0) {
			// Get the result as an array
			$result = $result->result();
			// Get the first (and only) element of the array
			$result = $result[0];

			// Check if the user status is active (1)
			if ($result->status == 1) {
				// Get the client's IP address
				$client_ip = $this->Common_Model->get_client_ip();

				// Prepare an array to update the user's last login details
				$update_login['last_login'] = date('Y-m-d H:i:s');
				$update_login['last_loginip'] = $client_ip;

				// Update the user's last login details in the database
				$response = $this->Common_Model->update_operation(
					array(
						'table' => "admin_user", // Specify the table to update
						'data' => $update_login, // Specify the data to update
						'condition' => "(admin_user_id = $result->admin_user_id)" // Specify the condition for the update
					)
				);
			}
			// Return the user result
			return $result;
		} else {
			// Return false if no user was found
			return false;
		}
	}
}

?>