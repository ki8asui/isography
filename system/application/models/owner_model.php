<?php

class Owner_model extends Base_model {

	public function getTableName(){return 'posts';}
	
	/**
	 * Constructor
	 *
	 * @return Post_model
	 */
	function Owner_model()
	{
		parent::Base_model();
		$this->load->model('User_model');
	}
	
	/**
	 * Open specific post for editing;
	 * @param int $id
	 * return array - corresponding db entry
	 */
	function getPost($id)
	{
		return $this->getById($id);
	}

	/**
	 * @param int $count
	 * Return page of posts, in line with $count
	 */
	function getPostList($count,$sort,$siteid)
	{
		$where = array('site_id'=>$siteid);
		$join = array(
			'table' => $this->User_model->getTablename(),
			'field1' => $this->User_model->getPrimaryKey(),
			'field2' => 'user_id'
		);
		$select='`'.$this->getTablename().'`.*, `'.$this->User_model->getTablename().'`.`username`';
		$r = $this->getList(100, $count, $where, $sort, $join, $select);
		return $r;
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
	function updatePost($id,$data)
	{
		return $this->update_array($id, $data);
	}
	function deletepost($id)
	{
		return $this->delete($id);
	}
	function getAppUsers($count,$sort,$site_id)
	{
		
		$where=array('member_y_n'=>NULL,'site_id'=>$site_id);
		$select='`'.$this->User_is_member_of_site_model->getTablename().'`.*, `'.$this->User_model->getTablename().'`.`username`, `'.$this->User_model->getTablename().'.`email`';
		$join=array(
		'table' => $this->User_model->getTablename(),
		'field1' => $this->User_model->getPrimaryKey(),
		'field2' => 'user_id'
		);
		return $this->User_is_member_of_site_model->getList(20,$count,$where,$sort,$join,$select);
	}
	function getUsers($count,$sort,$site_id)
	{
		
		$where=array('member_y_n'=>1,'site_id'=>$site_id);
		$select='`'.$this->User_is_member_of_site_model->getTablename().'`.*, `'.$this->User_model->getTablename().'`.`username`, `'.$this->User_model->getTablename().'.`email`';
		$join=array(
		'table' => $this->User_model->getTablename(),
		'field1' => $this->User_model->getPrimaryKey(),
		'field2' => 'user_id'
		);
		return $this->User_is_member_of_site_model->getList(100,$count,$where,$sort,$join,$select);
	}
} 