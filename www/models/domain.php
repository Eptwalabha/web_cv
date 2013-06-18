<?php

class domain extends model{
	
	private $table_name = "domain";
	
	public function domain() { }
	
	/**
	 * Retourne le titre du domaine en cours.
	 * @param true pour un affichage HTLM.
	 * @return string $dom_title le titre du domaine.
	 */
	public function getDomainTitle($html = true) {
		
		if (isset($this->dom_title)) {
			return ($html) ? htmlentities($this->dom_title, ENT_QUOTES, "UTF-8") : $this->dom_title;
		}
		
		return "";
	}
	
	/**
	 * Retourne la description du domaine en cours.
	 * @param true pour un affichage HTLM.
	 * @return string $dom_text la description du domaine.
	 */
	public function getDomainText($html = true) {
	
		if (isset($this->dom_text)) {
			return ($html) ? htmlentities($this->dom_text, ENT_QUOTES, "UTF-8") : $this->dom_text;
		}
		
		return "";
	}
	
	/**
	 * Retourne l'id de l'instance en cours.
	 * retourn false, si l'instance n'est pas renseignée.
	 * @return int $dom_id
	 */
	public function getDomainID() {
	
		return isset($this->dom_id) ? $this->dom_id : false;
	}
	
	public function isDomainVisible() {
		
		return isset($this->dom_visible) ? $this->dom_visible : true;
	}
	
	/**
	 * Renseigne le titre du domaine en cours.
	 * @param string $dom_title
	 */
	public function setDomainTitle($title) {
		$this->dom_title = $title;
	}
	
	/**
	 * Renseigne la description du domaine en cours.
	 * @param string $dom_text
	 */
	public function setDomainText($dom_text) {
		$this->dom_text = $dom_text;
	}
	
	/**
	 * Renseigne l'id du domaine en cours.
	 * @param int $dom_id
	 */
	public function setDomainID($id) {
		$this->dom_id = $id;
	}
	
	/**
	 * Renseigne l'id du domaine en cours.
	 * @param int $dom_id
	 */
	public function setDomainVisibility($visible = true) {
		$this->dom_visible = $visible;
	}
	
	/**
	 * Retourne la liste des domaines de compétence.
	 * @return array $liste une liste d'instance de domain.
	 */
	public function getAllDomains() {
	
		$sql = 	"select * ".
				"from ".$this->table_name;
	
		$result = connection::getConnection()->doQuery($sql);
	
		$list = array();
	
		foreach ($result as $tuple) {
				
			$domain = new domain();
			$domain->readFromStatement($tuple);
				
			$list[] = $domain;

		}
	
		return $list;
	
	}
	
	public function updateDomain() {
		
		if (isset($this->dom_id)) {
			
			$fields = array();
			$sets = array();
			
			if (isset($this->dom_title)) {
				$sets[] = "dom_title = :dom_title";
				$fields[':dom_title'] = $this->dom_title;
			}
			if (isset($this->dom_text)) {
				$sets[] = "dom_text = :dom_text";
				$fields[':dom_text'] = $this->dom_text;
			}
			if (isset($this->dom_visible)) {
				$sets[] = "dom_visible = :dom_visible";
				$fields[':dom_visible'] = $this->dom_visible;
			}
			
			$set = implode(', ', $sets);
			
			$sql = 	"update ".$this->table_name." ".
					"set $set ".
					"where dom_id = ".$this->dom_id;
			
			if (count($sets) > 0) {
				return connection::getConnection()->doExecPDO($sql, $fields);
			}
			
		}
		
		return false;
	}

	public function insertDomain() {
	
		if (isset($this->dom_title)) {
			
			
			$fields = array();
			$fields[':title'] = $this->dom_title;
			$fields[':text'] = isset($this->dom_text) ? $this->dom_text : "";
			
			
			$exists = $this->readFromTitle($this->dom_title);
			
			if ($exists) {
				// cas où le domaine existe.
				
				$sql = 	"update ".$this->table_name." ".
						"set ".
						"dom_title = :title, dom_text = :text ".
						"where dom_id = ".$this->dom_id;
				
				connection::getConnection()->doExecPDO($sql, $fields);
					
				
			} else {
				// cas où le domaine n'existe pas déjà.
				
				echo "n'existe pas!";
				
				$sql = 	"insert into ".$this->table_name." ".
						"(dom_title, dom_text) ".
						"values (:title, :text)";
				
				connection::getConnection()->doExecPDO($sql, $fields);
			
				$this->dom_id = connection::getConnection()->lastInsertID();
			}
		}
	}
	
	public function deleteDomain() {
		
		if (isset($this->dom_id)) {
			
			$sql = 	"delete from ".$this->table_name." ".
					"where dom_id = ".$this->dom_id;
			
			return connection::getConnection()->doExecPDO($sql);
		}
		
	}
	
	public function readFromTitle($title) {
		
		$fields = array();
		$fields[':title'] = $title;
			
		$sql = 	"select * ".
				"from ".$this->table_name." ".
				"where dom_title = :title";
		
		$result = connection::getConnection()->doExecPDO($sql, $fields);
		
		$statement = $result->fetch();
			
		if($statement) {
			$this->readFromStatement($statement);
			return true;
		}
		
		return false;
	}
	
	public function readFromID($id) {
		
		$sql = 	"select * ".
				"from ".$this->table_name." ".
				"where dom_id = $id";
		
		$result = connection::getConnection()->doExecPDO($sql);
		
		$statement = $result->fetch();
			
		if($statement) {
			$this->readFromStatement($statement);
			return true;
		}
		
		return false;
		
	}
	
	/**
	 * Permet de ne récupérer que les éléments qui appartiennent à la table "domain"
	 * @param PDOStatment $sql_statement
	 */
	public function readFromStatement($statement) {
	
		$this->dom_id = isset($statement['dom_id']) ? (int) $statement['dom_id'] : null;
		$this->dom_title = isset($statement['dom_title']) ? (string) $statement['dom_title'] : null;
		$this->dom_text = isset($statement['dom_text']) ? (string) $statement['dom_text'] : null;
		$this->dom_visible = isset($statement['dom_visible']) ? (string) $statement['dom_visible'] : null;
		
	}
	
	public function getDomainFields() {
		
		$list = array();
		
		if (isset($this->dom_id)) {
			
			$field = new field();
			$list = $field->getAllFieldFromDomainID($this->dom_id);
		
		}
		
		return $list;
	}
	
}
