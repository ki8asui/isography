<?php
require_once APPPATH.'controllers/base_controller.php';

class Base_test extends Base_controller {
	var $cur_model = NULL;
	function _get_model(){return $this->cur_model;}
    function _get_data() {return array();}

	function Base_test()
	{
		parent::Base_controller();
		$this->load->library('unit_test');
	}//function
    
    function index(){
    	$this->getList_test();
    	$this->getListCount_test();
    	$item_id = $this->insert_test();
    	if($item_id)
    	{
		   	$this->update_test($item_id);
		   	$this->getById_test($item_id);
		   	$this->delete_test($item_id);
    	}
    }//function
    
	function getById_test($item_id)
	{
		$key = $this->cur_model->getPrimaryKey();
		$row = $this->cur_model->getById($item_id);
		//echo '<pre>';print_r($row);echo '</pre>';
	
		$where = array();
		if(!is_array($key))  $where[$key] = $item_id;
		else foreach($key as $k)  $where[$k] = $item_id[$k];
		
		$query = $this->db->get_where($this->cur_model->getTableName(), $where);
		//echo '<pre>';print_r($query->row_array());echo '</pre>';
		echo $this->unit->run($query->row_array(), $row, $this->cur_model->getTableName().'_getById_test');
	}//function
	
	function getList_test()
	{
		$key = $this->_get_model()->getPrimaryKey();
		$rows = $this->cur_model->getList(20);
		//echo '<pre>GetList ROWS:';print_r($rows);echo '</pre>';
		if(is_numeric($key))  $this->db->order_by("$key ASC");
		elseif(is_array($key))
			foreach($key as $k)  $this->db->order_by($k, 'ASC');
		$query = $this->db->get_where($this->cur_model->getTableName(),null,20);
		//echo '<pre>GetList Query:';print_r($query->result_array());echo '</pre>';
		echo $this->unit->run($query->result_array(), $rows, $this->cur_model->getTableName().'_getList_test');
	}//function

	function getListCount_test()
	{
		$rows = $this->cur_model->getListCount();
		$resnum = $this->db->count_all_results($this->cur_model->getTableName());
		echo $this->unit->run($resnum, $rows, $this->cur_model->getTableName().'_getListCount_test');
	}//function
    
	function insert_test()
	{
		$model = $this->_get_model();
		$data = $this->_get_data();
    	$table = $model->getTableName();
    	$key = $model->getPrimaryKey();
    	
		//$data[$key] = $model->insert_array($data);
		//echo 'INSERT: <pre>';print_r($data);echo '</pre>';
		if(!is_array($key))  $data[$key] = $this->call_insert($data);
		else  $this->call_insert($data);
		//$this->db->simple_query('COMMIT');
		//echo 'GET WHERE: ';print_r(array($key => $data[$key]));
		$where = array();
		if(!is_array($key))  $where[$key] = $data[$key];
		else foreach($key as $k)  $where[$k] = $data[$k];

		$query = $this->db->get_where($table, $where);
		//echo 'GOT: <pre>';print_r($query->row_array());echo '</pre>';
		echo $this->unit->run($query->row_array(), $data, $table.'_insert_test');
		if(!is_array($key))  return $data[$key];
		else
		{
			$return = array();
			foreach($key as $k)  $return[$k] = $data[$k];
			return $return;
		}
	}//function
	
    function call_insert($data)
    {
		$d = array();
		foreach($data as $item)  $d[] = $item;
		//echo '->insert('.join(',',$d).');';
		return call_user_func_array(array($this->cur_model, 'insert'), $d);
    }//function
	
	function update_test($item_id)
	{
		$model = $this->_get_model();
		$data = $this->_get_data();
    	$table = $model->getTableName();
    	$key = $model->getPrimaryKey();
		//echo 'UPDATE:<pre>';print_r($data);echo '</pre>WHERE '; var_dump($item_id);
		//Do not allow to update primary keys!
		if(is_array($key)) foreach($key as $k)  $data[$k] = $item_id[$k];
		else  $data[$key] = $item_id; 
		$res = $this->call_update($item_id, $data);
		$where = array();
		if(!is_array($key))  $where[$key] = $item_id;
		else foreach($key as $k)  $where[$k] = $item_id[$k];
		$query = $this->db->get_where($table, $where);
		//echo 'GOT:<pre>';print_r($query->row_array());echo '</pre>';
		echo $this->unit->run($query->row_array(), $data, $table.'_update_test');
	}//function
	
    function call_update($id, $data)
    {
		$d = array();
		if(!is_array($id))  $d[] = $id;
		foreach($data as $item)  $d[] = $item;
		//echo '->update('.join(',',$d).');';
		return call_user_func_array(array($this->cur_model, 'update'), $d);
    }//function
	
	function delete_test($item_id)
	{
		$key = $this->cur_model->getPrimaryKey();
		$affected_rows = $this->cur_model->delete($item_id);
		$where = array();
		if(!is_array($key))  $where[$key] = $item_id;
		else foreach($key as $k)  $where[$k] = $item_id[$k];
		$query = $this->db->get_where($this->cur_model->getTableName(), $where);
		echo $this->unit->run($query->row_array(), null, $this->cur_model->getTableName().'_delete_test');
	}//function
	
    /*function getRandomItem() {
    	$model = $this->_get_model();
		$data = $this->_get_data();
    	$table = $model->getTableName();
    	$key = $model->getPrimaryKey();
		// get random id
		if(!is_array($key))  $this->db->select($key);
		else $this->db->select(join(',',$key));
		$req = $this->db->get($table);
		if ($req->num_rows() > 0) {
			$result = $req->result();
			$index = rand(0, count($result)-1);
			return $result[$index];
		}
		return null;
    }*/
	
	function _rword($length=6, $base=null)
    {
      $text = "";
      $abc = "abcdefghijklmnopqrstuvwxyz_";
      for($i=0; $i<$length; $i++) {
        $text .= $abc[rand(0, strlen($abc)-1)];
      }
      $prefix = ($base !== null)? $base : $this->cur_model->getTableName() . ' ';
      return $prefix . $text;
    }//function
    
    function _rdigit($max=10000, $min=1)
    {
    	return rand($min, $max);
    }
    
    function _rstamp($is_past = TRUE, $sql_format = TRUE, $datetime_format = TRUE)
    {
    	$ts = time();
    	$offset = 0;
    	$offset += rand(0, 2)*31556926;//years
    	$offset += rand(0, 12)*2629744;//monthes
    	$offset += rand(0, 30)*86400;//days
    	$offset += rand(0, 24)*3600;//hours
    	$offset += rand(0, 60)*60;//minutes
    	$offset += rand(0, 60)*1;//seconds
    	if(!$is_past)	$ts += $offset;
    	else			$ts -= $offset;
    	if($sql_format)
    		if($datetime_format)  $ts = date('Y-m-d H:i:s', $ts);
    		else  $ts = date('Y-m-d', $ts);
    	return $ts;
    }

    function _rmac()
    {
    	$abc = '0123456789ABCDEF';
    	$mac = '';
    	for($i=0; $i<6*2; $i++)
    		$mac .= $abc[rand(0, 15)];
		return $mac;
    }
    
    function _rmail()
    {
    	$zones = array('com','org','biz','edu');//just an examples
    	return $this->_rword(6, FALSE).'@'.$this->_rword(6, FALSE).'.'.$zones[array_rand($zones)];
    }
    
    function _rbool()
    {
    	return $this->_rdigit(1,0);
    }
}//class
