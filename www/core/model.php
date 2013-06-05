<?php

abstract class Model{

	public $connection;

	public function read($fields, $table, $where = ""){
		
		$where = (strlen($where))? "where $where" : "" ;
		
		$sql = "select $fields from $table $where";
		
		$result = $this->connection->doQuery($sql);
		
		return $result;
	}

	public function readFromData($data) {
		
		foreach ($data as $k => $v){
			$this->$k = $v;
		}
		
	}
		
	public function getField($field) {
		
		return isset($this->$field) ? $this->$field : "";
	}
	
	public function update($data = array()) {
		
		$sql = "update $table set";
		foreach ($data as $k => $v){
			if($k != $this->ab_table."_id") {
				$sql .= " $k = '$v',";
			}
		}
		$sql = substr($sql, 0, -1);
		
		$sql .= " where ".$this->ab_table."_id=".$data[$this->ab_table."id"];
		
		$this->connection->doExec($sql);
	}

	public function delete($id = "") {
		
		$sql = "delete from $table where ".$this->ab_table."_id=$id;";
		
		$this->connection->doExec($sql);
	}
	
}