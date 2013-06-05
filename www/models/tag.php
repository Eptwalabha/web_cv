<?php
// include_once (ROOT."models/tagged.php");
include_once (ROOT."models/blog_post.php");

class tag extends model{
	
	private $table_name = "tag";
	
	public function tag() { }
	
	/**
	 * Retourne le titre du tag en cours.
	 * @param true pour un affichage HTLM.
	 * @return string $tag_title le titre du tag.
	 */
	public function getTagTitle($html = true) {
		
		if ($html) {
			return isset($this->tag_title)? htmlentities($this->tag_title, ENT_QUOTES, "UTF-8") : "";
		} else {
			return isset($this->tag_title)? $this->tag_title : "";
		}
	}
	
	/**
	 * Retourne l'id du tag en cours.
	 * retourn false, si l'instance n'est pas renseignée.
	 * @return int $tag_id
	 */
	public function getTagID() {
	
		return isset($this->tag_id)? $this->tag_id : false;
	}
	
	/**
	 * Renseigne le titre du tag en cours.
	 * @param string $tag_title
	 */
	public function setTagTitle($title) {
		$this->tag_title = $title;
	}
	
	/**
	 * Retourne la liste des tags enregistrés dans la base de données.
	 * @return array $liste une liste d'instance de tag.
	 */
	public function getAllTag() {
	
		$sql = 	"select * ".
				"from ".$this->table_name;
	
		
		$result = connection::getConnection()->doQuery($sql);
	
		$list = array();
	
		foreach ($result as $tuple) {
				
			$tag = new tag();
			$tag->readFromStatement($tuple);
				
			$list[] = $tag;

		}
	
		return $list;
	
	}
	
	
	/**
	 * Retourne la liste des posts qui ont le tag dont le nom est passé en paramètre.
	 * @return array $list liste d'instances de la classe "post"
	 */
	public function getPostFromTagName($tag_title = "") {
		
		if (!strlen($tag_title)) {
			$tag_title = isset($this->tag_title)? $this->tag_title : "";
		}
		
		if (strlen($tag_title)) {
			
			$sql = 	"select p.* ".
					"from blog_post as p, tagged, ".$this->table_name." ".
					"where p.bp_id = tag_bp_id ".
					"and tag_tag_id = tag_id ".
					"and tag_title = '".$tag_title;

			
			$result = connection::getConnection()->doQuery($sql);
			
			$list = array();
			
			foreach ($result as $tuple) {
			
				$blog_post = new blog_post();
				$blog_post->readFromStatement($tuple);
			
				$list[] = $blog_post;
			
			}
			
			return $list;
							
		}
		
		return false;
		
		
	}
	
	/**
	 * TODO mettre en place une fonction comme mysqli_real_escape(); mais pour PDO.
	 */
	public function insert() {
	
		if (isset($this->tag_title)) {
		
			$sql = 	"insert into ".$this->table_name." (tag_title) ".
					"values ('".$this->tag_title.")";
			
			connection::getConnection()->doExec($sql);
		
			$this->tag_id = connection::getConnection()->lastInsertID();
		}
	}
	
	/**
	 * Permet de ne récupérer que les éléments qui appartiennent à la table "tag"
	 * @param PDOStatment $sql_statement
	 */
	public function readFromStatement($statement) {
	
		$this->tag_id = isset($statement['tag_id']) ? (int) $statement['tag_id'] : null;
		$this->tag_title = isset($statement['tag_title']) ? (string) $statement['tag_title'] : null;
		
	}
	
}
