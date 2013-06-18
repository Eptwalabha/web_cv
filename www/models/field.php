<?php
class field extends Model {
	
	private $table_name = "field";
	
	public function field() { }
	
	public function getFieldTitle($html = true) {
	
		if (isset($this->fie_title)) {
			return ($html)? htmlentities($this->fie_title, ENT_QUOTES, "UTF-8") : $this->fie_title;
		}
	
		return "";
	}
	
	public function getFieldText($html = true) {
	
		if (isset($this->fie_text)) {
			return ($html)? htmlentities($this->fie_text, ENT_QUOTES, "UTF-8") : $this->fie_text;
		}
	
		return "";
	}
	
	public function getFieldRawDateBeginning($html = true) {
	
		return isset($this->fie_date_start)? $this->fie_date_start : 0;
	}
	
	public function getFieldRawDateEnding($html = true) {
	
		return isset($this->fie_date_end)? $this->fie_date_end : 0;
	}
	
	public function getFieldLevel() {
		
		return isset($this->fie_lvl)? $this->fie_lvl : "";
	}
	
	public function setFieldTitle($title) {
		$this->fie_title = $title;
	}
	
	public function setFieldText($text) {
		$this->fie_text = $text;
	}
	
	public function setFieldLevel($lvl) {
		if ($lvl > 100) $lvl = 100;
		if ($lvl < 0) $lvl = 0;
		
		$this->fie_lvl = $lvl;
	}
	
	public function setFieldVisible($visible = true) {
		$this->fie_visible = $visible ? 1 : 0;
	}
	
	public function setFieldDateBeginning($date_start) {
		$this->fie_date_start = $date_start;		
	}
	
	public function setFieldDateEnd($date_end = null) {
		$this->fie_date_end = $date_end;
	}
	
	public function setFieldUser($user_id) {
		$this->fie_user_id = $user_id; 
	}
	public function setFieldDomainID($domain_id) {
		$this->fie_dom_id = $domain_id;
	}
	

	public function updateField() {

		if (isset($this->fie_id)) {
			
			$fields = array();
			$sets = array();

			if (isset($this->fie_title)) {
				$sets[] = "fie_title = :fie_title";
				$fields[':fie_title'] = $this->fie_title;
			}
			if (isset($this->fie_text)) {
				$sets[] = "fie_text = :fie_text";
				$fields[':fie_text'] = $this->fie_text;
			}
			if (isset($this->fie_lvl)) {
				$sets[] = "fie_lvl = :fie_lvl";
				$fields[':fie_lvl'] = $this->fie_lvl;
			}
			if (isset($this->fie_date_start)) {
				$sets[] = "fie_date_start = :fie_date_start";
				$fields[':fie_date_start'] = $this->fie_date_start;
			}
			if (isset($this->fie_date_end)) {
				$sets[] = "fie_date_end = :fie_date_end";
				$fields[':fie_date_end'] = $this->fie_date_end;
			}
			if (isset($this->fie_visible)) {
				$sets[] = "fie_visible = :fie_visible";
				$fields[':fie_visible'] = $this->fie_visible;
			}
			if (isset($this->fie_dom_id)) {
				$sets[] = "fie_dom_id = :fie_dom_id";
				$fields[':fie_dom_id'] = $this->fie_dom_id;
			}
			if (isset($this->fie_usr_id)) {
				$sets[] = "fie_usr_id = :fie_usr_id";
				$fields[':fie_usr_id'] = $this->fie_usr_id;
			}
			
			$set = implode(', ', $sets);
			
			$sql = 	"update ".$this->table_name." ".
					"set $set ".
					"where fie_id = ".$this->fie_id;
			
			if (count($sets) > 0) {
				return connection::getConnection()->doExecPDO($sql, $fields);
			}
		}
		
		return false;
	}
	
	public function insertField() {
	
		if (isset($this->fie_title) && isset($this->fie_dom_id)) {
				
				
			$fields = array();
			$fields[':fie_title'] = $this->fie_title;
			$fields[':fie_text'] = isset($this->fie_text) ? $this->fie_text : "";
			$fields[':fie_lvl'] = isset($this->fie_lvl) ? $this->fie_lvl : 0;
			
			$sql = 	"insert into ".$this->table_name." ".
					"(fie_title, fie_text, fie_dom_id, fie_usr_id, fie_lvl) ".
					"values (:fie_title, :fie_text, ".$this->fie_dom_id.", 1, :fie_lvl)";

			connection::getConnection()->doExecPDO($sql, $fields);
				
			$this->fie_id = connection::getConnection()->lastInsertID();
			
		}
	}
	
	public function readFromID($id) {
	
		$sql = 	"select * ".
				"from ".$this->table_name." ".
				"where fie_id = $id";
	
		$result = connection::getConnection()->doExecPDO($sql);
	
		$statement = $result->fetch();
			
		if($statement) {
			$this->readFromStatement($statement);
			return true;
		}
	
		return false;
	
	}
	
	/**
	 * Permet de ne récupérer que les éléments qui appartiennent à la table "field"
	 * @param PDOStatment $sql_statement
	 */
	public function readFromStatement($statement) {
	
		$this->fie_id = isset($statement['fie_id']) ? (int) $statement['fie_id'] : null;
		$this->fie_title = isset($statement['fie_title']) ? (string) $statement['fie_title'] : null;
		$this->fie_text = isset($statement['fie_text']) ? (string) $statement['fie_text'] : null;
		$this->fie_lvl = isset($statement['fie_lvl']) ? (string) $statement['fie_lvl'] : null;
		
	}
	
	/**
	 * Retourne tous les compétences relatives à un domaine 
	 * @param id $dom_id
	 * @return array $list
	 */
	public function getAllFieldFromDomainID($dom_id) {
		
		$sql = 	"select * ".
				"from ".$this->table_name." ".
				"where fie_dom_id = $dom_id";
		
		$result = connection::getConnection()->doExecPDO($sql);
		
		$list = array();
		
		foreach ($result as $tuple) {
			
			$field = new field();
			$field->readFromStatement($tuple);
			
			$list[] = $field;
		}
		
		return $list;
	}
}