<?php

class Post_pictures_model extends Base_model {

	public function getTableName(){return 'post_pictures';}
	
	/**
	 * Constructor
	 *
	 * @return Post_pictures_model
	 */
	function Post_pictures_model()
	{
		parent::Base_model();
	}
	
	/**
	 * Insert new post into DB
	 *
	 * @param string $post_id
	 * @param string $pic_url
	 */
	function insert($post_id = NULL, $pic_url)
	{
		$data = array(
			'post_id' => $post_id,
			'pic_url' => $pic_url,
			'created' => date('Y-m-d H:i')
		);
		return $this->insert_array($data);
	}


} 

