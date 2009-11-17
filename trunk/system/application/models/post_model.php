<?php

class Post_model extends Base_model {

	public function getTableName(){return 'posts';}
	
	/**
	 * Constructor
	 *
	 * @return Post_model
	 */
	function Post_model()
	{
		parent::Base_model();
		$this->load->model('Post_pictures_model');
		$this->load->model('Post_videos_model');

	}
	
	/**
	 * Insert new post into DB
	 *
	 * @param string $user_id
	 * @param string $site_id
	 * @param string $post_date
	 * @param string $post_type
	 * @param string $pic_url
	 * @param string $vid_url
	 * @param string $message
	 * @return int
	 */
	function insert($user_id = NULL, $site_id = NULL, $post_date = NULL, $post_type = NULL, $pic_url = NULL, $vid_url = NULL, $message = NULL)
	{
		$data = array(
			'user_id' => $user_id,
			'site_id' => $site_id,
			'post_date' => $post_date,
			'post_type' => $post_type,
			'message' => $message
		);

		$postId = $this->insert_array($data);

		if($post_type == 'picture'){

			$this->Post_pictures_model->insert($postId, $pic_url);

		}

		if($post_type == 'video'){

			$this->Post_videos_model->insert($postId,$vid_url);

		}

		return $postId;
	}

	/**
	 * Update existing post in the DB
	 *
	 * @param int $id
	 * @param string $username
	 * @param string $email
	 * @param string $provider
	 * @param string $last_login_date
	 * @return int
	 */
	function update($id, $user_id = NULL, $site_id = NULL, $post_date = NULL, $post_type = 'message', $message = NULL)
	{
		$data = array(
			'user_id' => $user_id,
			'site_id' => $site_id,
			'post_date' => $post_date,
			'post_type' => $post_type,
			'message' => $message
		);
		return $this->update_array($id, $data);
	}
	function newPost($data,$user)
	{
		//$userdata = $this->Site_model->getWhere(array('owner_id'=>22));
		$userdata = $this->Site_model->getWhere(array('owner_id'=>$user));
		return $this->insert($userdata[0]['owner_id'], $userdata[0]['id'], date('Y-m-d H:i:s'), 'message', NULL, NULL, $data['message']);
	}

	function getPosts($limit, $offset, $where, $order)
	{
		$posts = $this->getList($limit, $offset, $where, $order, array('table' => 'users', 'field1' => 'id', 'field2' => 'user_id'), $select='posts.*, users.username');
		foreach ($posts as $k => $v) {

			if($v['post_type'] == 'video') {
				$posts[$k]['videos'] = $this->Post_videos_model->getWhere(array('post_id' => $v['id']));

			}

			if($v['post_type'] == 'picture') {
				$posts[$k]['pictures'] = $this->Post_pictures_model->getWhere(array('post_id' => $v['id']));
			}

		}

		return $posts;
	}


}


