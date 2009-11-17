<?php

class User_model extends Base_model {

	public function getTableName(){return 'users';}
	
	/**
	 * Constructor
	 *
	 * @return User_model
	 */
	function User_model()
	{
		parent::Base_model();
	}
	
	/**
	 * Insert new user into DB
	 *
	 * @param string $username
	 * @param string $email
	 * @param string $provider
	 * @param string $last_login_date
	 * @return int
	 */
	function insert($username = NULL, $email = NULL, $provider = NULL, $last_login_date = NULL, $fb_user_id = NULL)
	{
		$data = array(
			'username' => $username,
			'email' => $email,
			'provider' => $provider,
			'last_login_date' => $last_login_date,
			'fb_user_id' => $fb_user_id
		);
		return $this->insert_array($data);
	}

	/**
	 * Update existing user in the DB
	 *
	 * @param int $id
	 * @param string $username
	 * @param string $email
	 * @param string $provider
	 * @param string $last_login_date
	 * @return int
	 */
	function update($id, $username = NULL, $email = NULL, $provider = NULL, $last_login_date = NULL, $fb_user_id = NULL)
	{
		$data = array(
			'username' => $username,
			'email' => $email,
			'provider' => $provider,
			'last_login_date' => $last_login_date,
			'fb_user_id' => $fb_user_id
		);
		return $this->update_array($id, $data);
	}
} 