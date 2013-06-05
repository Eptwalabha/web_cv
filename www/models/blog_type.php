<?php

class blog_type extends model{
	
	private $table_name = "blog_type";
	
	public function blog_type() { }
	
	/**
	 * Retourne le titre du type de blog en cours.
	 * @param true pour un affichage HTLM.
	 * @return string $bt_title le titre du domaine.
	 */
	public function getBlogTypeTitle($html = true) {
		
		if ($html) {
			return isset($this->bt_title)? htmlentities($this->bt_title, ENT_QUOTES, "UTF-8") : "";
		} else {
			return isset($this->bt_title)? $this->bt_title : "";
		}
	}
	
	/**
	 * Retourne l'id du type en cours.
	 * retourn false, si l'instance n'est pas renseignée.
	 * @return int $bt_id
	 */
	public function getBlogTypeID() {
	
		return isset($this->bt_id)? $this->bt_id : false;
	}
	
	/**
	 * Renseigne le titre du type de blog en cours.
	 * @param string $bt_title
	 */
	public function setBlogTypeTitle($title) {
		$this->bt_title = $title;
	}
	
	/**
	 * Retourne la liste des types de blog.
	 * @return array $liste une liste d'instance de blog_type.
	 */
	public function getAllBlogType() {
	
		$sql = 	"select * ".
				"from ".$this->table_name;
	
		$result = connection::getConnection()->doQuery($sql);
	
		$list = array();
	
		foreach ($result as $tuple) {
				
			$blog_type = new blog_type();
			$blog_type->readFromStatement($tuple);
				
			$list[] = $blog_type;

		}
	
		return $list;
	
	}
	
	
	/**
	 * Récupère les informations du type de post dont l'id est passé en paramètre.
	 * @param int $id
	 * @return boolean $exists
	 */
	public function readFromID($id) {
	
		if ($id > 0) {
				
			$slq = 	"select * ".
					"from ".$this->table_name." ".
					"where bt_id = $id";
				
			$result = connection::getConnection()->doQuery($sql);
			$statement = $result->fetch();
				
			if($statement) {
				$this->readFromStatement($statement);
				return true;
			}
				
		}
	
		return false;
	}

	public function insert() {
	
		if (isset($this->bt_title)) {
		
			$sql = 	"insert into ".$this->table_name." (bt_title) ".
					"values ('".$this->bt_title.")";
			
			connection::getConnection()->doExec($sql);
		
			$this->bt_id = connection::getConnection()->lastInsertID();
		}
	}
	
	/**
	 * Permet de ne récupérer que les éléments qui appartiennent à la table "blog_type"
	 * @param PDOStatment $sql_statement
	 */
	public function readFromStatement($statement) {
	
		$this->bt_id = isset($statement['bt_id']) ? (int) $statement['bt_id'] : null;
		$this->bt_title = isset($statement['bt_title']) ? (string) $statement['bt_title'] : null;
		
	}
	
}
