<?php

class Admin6_model extends Base_model
{
	public function getTableName(){return 'sites';}
	function Admin6_model()
	{
		parent::Base_model();
	}
	function getSiteList($count,$sort)
	{
		$join = array(
			'table' => $this->User_model->getTablename(),
			'field1' => $this->User_model->getPrimaryKey(),
			'field2' => 'owner_id'
		);
		if ($sort=='') $sort='id DESC';
		$select='`'.$this->getTablename().'`.*, `'.$this->User_model->getTablename().'`.`username`, `'.$this->User_model->getTablename().'`.`email`';
		return $this->getList(100, $count, '', $sort, $join, $select);
	}	
}

?>