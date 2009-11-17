<?php

class User_is_member_of_site_model extends Base_model {

	public function getTableName(){return 'user_is_member_of_site';}
	public function getPrimaryKey()
	{
		return array('user_id', 'site_id');
	}
	
	/**
	 * Constructor
	 *
	 * @return User_is_member_of_site_model
	 */
	function User_is_member_of_site_model()
	{
		parent::Base_model();
	}
	
	/**
	 * Insert new relation into the DB
	 *
	 * @param int $user_id
	 * @param int $site_id
	 * @param char $subscribe_y_n
	 * @param char $facebook_pics_y_n
	 * @param char $facebook_vids_y_n
	 * @param char $member_y_n
	 * @param string $facebook_infinite_key
	 * @return int
	 */
	function insert($user_id, $site_id, $subscribe_y_n = NULL, $facebook_pics_y_n = NULL, $facebook_vids_y_n = NULL, $member_y_n = NULL, $facebook_infinite_key = NULL)
	{
		$data = array(
			'user_id' => $user_id,
			'site_id' => $site_id,
			'subscribe_y_n' => $subscribe_y_n,
			'facebook_pics_y_n' => $facebook_pics_y_n,
			'facebook_vids_y_n' => $facebook_vids_y_n,
			'member_y_n' => $member_y_n,
			'facebook_infinite_key' => $facebook_infinite_key,
			'created' => date("Y-m-d H:i")
		);
		return $this->insert_array($data);
	}

	/**
	 * Update existing relation in the DB
	 *
	 * @param int $user_id
	 * @param int $site_id
	 * @param char $subscribe_y_n
	 * @param char $facebook_pics_y_n
	 * @param char $facebook_vids_y_n
	 * @param char $member_y_n
	 * @param string $facebook_infinite_key
	 * @return int
	 */
	function update($user_id, $site_id, $subscribe_y_n = NULL, $facebook_pics_y_n = NULL, $facebook_vids_y_n = NULL, $member_y_n = NULL, $facebook_infinite_key = NULL)
	{
		$data = array(
			'user_id' => $user_id,
			'subscribe_y_n' => $subscribe_y_n,
			'facebook_pics_y_n' => $facebook_pics_y_n,
			'facebook_vids_y_n' => $facebook_vids_y_n,
			'member_y_n' => $member_y_n,
			'facebook_infinite_key' => $facebook_infinite_key
		);
		$id = array(
			'user_id' => $user_id,
			'site_id' => $site_id
		);
		return $this->update_array($id, $data);
	}
} 