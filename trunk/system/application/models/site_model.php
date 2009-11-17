<?php

class Site_model extends Base_model {
	
	public function getTableName(){return 'sites';}
	
	/**
	 * Constructor
	 *
	 * @return Site_model
	 */
	function Site_model()
	{
		parent::Base_model();
	}
	
	/**
	 * Add new site into DB
	 *
	 * @param int $owner_id
	 * @param string $name
	 * @param string $subdomain
	 * @param char $active_y_n
	 * @return int
	 */
	function insert($owner_id = NULL, $name = NULL, $subdomain = NULL, $active_y_n = NULL, $created = NULL)
	{
		$data = array(
			'owner_id' => $owner_id,
			'name' => $name,
			'created' => $created,
			'subdomain' => $subdomain,
			'active_y_n' => $active_y_n
		);
		return $this->insert_array($data);
	}

	/**
	 * Update existing site in the DB
	 *
	 * @param int $id
	 * @param int $owner_id
	 * @param string $name
	 * @param string $subdomain
	 * @param char $active_y_n
	 * @return int
	 */
	function update($id, $owner_id = NULL, $name = NULL, $subdomain = NULL, $active_y_n = NULL, $created = NULL)
	{
		$data = array(
			'owner_id' => $owner_id,
			'created' => $created,
			'name' => $name,
			'subdomain' => $subdomain,
			'active_y_n' => $active_y_n
		);
		return $this->update_array($id, $data);
	}
} 