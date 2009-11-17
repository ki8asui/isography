<?php

class Post_videos_model extends Base_model {

	public function getTableName(){return 'post_videos';}
	
	/**
	 * Constructor
	 *
	 * @return Post_videos_model
	 */
	function Post_videos_model()
	{
		parent::Base_model();
	}
	
	/**
	 * Insert new post into DB
	 *
	 * @param string $post_id
	 * @param string $vid_url
	 */


	function insert($post_id = NULL, $vid_url)
	{
		$data = array(
			'post_id' => $post_id,
			'vid_url' => $vid_url,
			'created' => date('Y-m-d H:i')
		);

		return $this->insert_array($data);
	}


} 