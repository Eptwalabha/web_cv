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
		
		if ($html) {
			return isset($this->dom_title)? htmlentities($this->dom_title, ENT_QUOTES, "UTF-8") : "";
		} else {
			return isset($this->dom_title)? $this->dom_title : "";
		}
	}
	
	/**
	 * Retourne la description du domaine en cours.
	 * @param true pour un affichage HTLM.
	 * @return string $dom_text la description du domaine.
	 */
	public function getDomainDescription($html = true) {
	
		if ($html) {
			return isset($this->dom_description)? htmlentities($this->dom_text, ENT_QUOTES, "UTF-8") : '';
		} else {
			return isset($this->dom_description)? $this->dom_text : '';
		}
	}
	
	/**
	 * Retourne l'id de l'instance en cours.
	 * retourn false, si l'instance n'est pas renseignée.
	 * @return int $dom_id
	 */
	public function getDomainID() {
	
		return isset($this->dom_id)? $this->dom_id : false;
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
	public function setDomainDescription($description) {
		$this->dom_description = $description;
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
	
	/**
	 * Permet de ne récupérer que les éléments qui appartiennent à la table "domain"
	 * @param PDOStatment $sql_statement
	 */
	public function readFromStatement($statement) {
	
		$this->dom_id = isset($statement['dom_id']) ? (int) $statement['dom_id'] : null;
		$this->dom_title = isset($statement['dom_title']) ? (string) $statement['dom_title'] : null;
		$this->dom_text = isset($statement['dom_text']) ? (string) $statement['dom_text'] : null;
	
	}
	
}
