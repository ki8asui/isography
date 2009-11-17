<?php
/*
	Base Model class for all classes
*/
class Base_model extends Model {
	/*
		Return primary key for this model
	*/
	public function getPrimaryKey(){return 'id';}

	/*
		Return table name to use for all operations
	*/
	public function getTableName(){return null;}

	/*
		Return field to use it as name in breadcrumbs, lists, etc.
	*/
	public function getNameField(){return null;}

	/*
		Return default order to sort rows
	*/
	public function getDefaultOrder() { return null; }

	/*
		Return default header to display on list pages
	*/
	function getTblDefaultHeading(){return null;}

	/*
		Return default columns to display on list pages
	*/
	function getTblDefaultColumns(){return null;}

	protected $crumbsName = NULL;
	protected $crumbsLink = NULL;

    function Base_model()
    {
        parent::Model();
    }

	/*
		Return crumbs name to display on pages
	*/
    function getCrumbsName()
    {
    	return $this->crumbsName;
    }
    
	/*
		Return base link to object controller 
	*/
    function getCrumbsLink()
    {
    	return $this->crumbsLink;
    }
    
    
	/*
		Insert new row to current table
		Parameter $data - key/value field pairs 
		Return inserted row id
	*/
    function insert_array($data)
    {
	/*
		if ($this->db->insert($this->getTableName(), $data) ) {
			return $this->db->insert_id();
			//$this->db->simple_query('COMMIT');
		} else {
			throw new Exception("Can't insert new row to " + $this->getTableName());
		}
	*/

	try{
		$this->db->insert($this->getTableName(), $data);
		return $this->db->insert_id();

	} catch (Exception $ex) {

		return FALSE;
	}


    }

	/*
		Update row in current table
		Parameter $id - row id 
		$data - key/value field pairs 
		Return affected rows number
	*/
    function update_array($id, $data)
    {
    	if(is_numeric($id))  $this->db->where($this->getPrimaryKey(), $id);
    	elseif(is_array($id))
    		foreach($id as $key=>$value)
    			$this->db->where($key, $value);
		if ( $this->db->update($this->getTableName(), $data) ) {
			return $this->db->affected_rows();
			//$this->db->simple_query('COMMIT');
		} else {
			throw new Exception("Can't update row[id=$id] in " + $this->getTableName());
		}
    }
    
    
	/*
		Delete row in current table
		Parameter $id - row id 
		Return affected rows number
	*/
	function delete($id)
    {
    	$key = $this->getPrimaryKey();
    	$where = array();
    	if(is_array($key))  foreach($key as $k)  $where[$k] = $id[$k];
    	else  $where[$key] = $id;
		if ( $this->db->delete($this->getTableName(), $where) ) {
			return $this->db->affected_rows();
		} else {
			throw new Exception("Can't delete row[id=$id] in " + $this->getTableName());
		}
    }
    

	/*
		Delete row in current table
		Parameter $where  - SQL clause
		$limit - delete rows limit  
		Return affected rows number
	*/
	function deleteWhere($where, $limit=0)
    {
    	if(!$where)  return FALSE;
    	if((int)$limit>0)  $this->db->limit((int)$limit);
    	if ( $this->db->delete($this->getTableName(), $where) ) {
			return $this->db->affected_rows();
		} else {
			throw new Exception("Can't delete row[id=$id] in " + $this->getTableName());
		}
    }


	/*
		Retrive row by id
		Parameter $id - row id 
		Return row array or false if row not found
	*/
	function getById($id)
    {
    	$key = $this->getPrimaryKey();
    	$where = array();
    	if(is_array($key))  foreach($key as $k)  $where[$k] = $id[$k];
    	else  $where[$key] = $id;
    	$query = $this->db->get_where($this->getTableName(), $where, 1);
		if ($query->num_rows() > 0)
		{
   			//return $query->row();
   			return $query->row_array();
		} else {
			return false;
		}
    }
    
    /*
		Return rows array for specified parameters
	*/
    function getWhere($where, $limit=0, $offset=0, $order='')
    {
    	return $this->getList($limit, $offset, $where, $order);
    }

    /*
		Return rows array for specified parameters
		$join = array('table'=>$tablename, 'field1'=> $join1, 'field2'=> $join2); produces JOIN 'table' ON 'table'.'field1' = getTableName().'field2'

	*/
    function getList($limit=0, $offset=0, $where='', $order='', $join='', $select='')
    {
    	if($limit>0)  $this->db->limit($limit, $offset);
    	if($where)	$this->db->where($where);
	if($select)	$this->db->select($select);
	if($join)
	{
		if (isset($join['table'])) //array has one default join
		{
		$this->db->join($join['table'], $join['table'] . '.' . $join['field1'] . ' = ' . $this->getTableName() . '.' . $join['field2']);
		}
		else  //multiple foins
		{
			foreach ($join as $joins) {$this->db->join($joins['table'], $joins['table'] . '.' . $joins['field1'] . ' = ' . $this->getTableName() . '.' . $joins['field2']);}
		}
	}
    	if($order)	$this->db->order_by($order);
    	elseif($this->getDefaultOrder()) $this->db->order_by($this->getDefaultOrder());
		elseif(is_array($this->getPrimaryKey()))  foreach($this->getPrimaryKey() as $k)  $this->db->order_by($k, 'ASC');
		else  $this->db->order_by(sprintf("%s ASC", $this->getTableName().'.'.$this->getPrimaryKey()));

    	$query = $this->db->get($this->getTableName());
    	return $query->result_array();
    }

    /*
		Calculate number of rows in current table
		Parameter $where - SQL clause to filter rows
		Return rows count
	*/

    function getListCount($where='')
    {
    	if($where)  $this->db->where($where);
		$this->db->from($this->getTableName());
		return  $this->db->count_all_results();
    }
    
    function getRandomKey()
    {
    	$count = $this->getListCount();
    	if(!$count)  return FALSE;
    	srand ((float) microtime() * 10000000);
    	$offset = rand(0, $count-1);
		$item = $this->getList(1, $offset);
		$key = $this->getPrimaryKey();
		if($item AND !is_array($key))  return $item[0][$key];
		else return FALSE;
    }
}
 