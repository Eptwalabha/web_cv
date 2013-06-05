<?php
include_once (ROOT."models/tag.php");
// include_once (ROOT."models/tagged.php");
include_once (ROOT."models/user.php");
include_once (ROOT."models/blog_type.php");


class blog_post extends model{
	
	private $table_name = "blog_post";
	
	public function blog_post() { }
	
	/**
	 * Retourne le titre du post en cours.
	 * @param true pour un affichage HTLM.
	 * @return string $bp_title le titre du post.
	 */
	public function getBlogPostTitle($html = true) {
		
		if (isset($this->bp_title)) {
			return ($html) ? htmlentities($this->bp_title, ENT_QUOTES, "UTF-8") : $this->bp_title;
		}
		
		return "";
	}
	
	/**
	 * Retourne le texte du post en cours.
	 * @param true pour un affichage HTLM.
	 * @return string $bp_text le texte du post.
	 */
	public function getBlogPostText($html = true) {
	
		if ($html) {
			return isset($this->bp_text)? htmlentities($this->bp_text, ENT_QUOTES, "UTF-8") : "";
		} else {
			return isset($this->bp_text)? $this->bp_text : "";
		}
	}
	
	/**
	 * Retourne la date de création du post en cours.
	 * @return string $bp_date la date de création du post.
	 */
	public function getBlogPostDate($format = true, $afficher_heure = false) {
	
		$date_return = "";
		
		if (isset($this->bp_date)) {
			
			if ($format) {
				$liste = explode(' ', $this->bp_date);
				$date = explode('-', $liste[0]);
				
				$date_return = $date[2].'-'.$date[1].'-'.$date[0];
				
				if ($afficher_heure) {
					
					$heure = isset($liste[1])? explode(':', $liste[1]) :  explode(':', '00:00:00');
					$date_return .= ' '.$heure[0].'h'.$heure[1];
				}
				
			} else {
				
				return $this->bp_date;
			}
			
		}
		
		return $date_return;
	}
	
	/**
	 * Retourne la date de la dernière modification sur le post en cours.
	 * @return string $bp_date_edit la date de la dernière modification du post.
	 */
	public function getBlogPostDateEdit() {
	
		return isset($this->bp_date_edit)? $this->bp_date_edit : null;
	}
	
	/**
	 * Retourne l'id du post en cours.
	 * retourn 0, si l'id du post n'est pas renseigné.
	 * @return int $bp_id
	 */
	public function getBlogPostID() {
	
		return isset($this->bp_id)? $this->bp_id : 0;
	}
	
	/**
	 * Retourne l'id de l'auteur du post.
	 * @return user $author
	 */
	public function getBlogPostUserID() {
		return isset($this->bp_usr_id)? $this->bp_usr_id : 0;
	}
	
	/**
	 * Retourne l'id du type de post.
	 * @return int $type
	 */
	public function getBlogPostType() {
		return isset($this->bp_bt_id)? $this->bp_bt_id : 0;
	}
	
	/**
	 * Retourne l'état du post.
	 * 0 si le post n'est pas visible.
	 * 1 si le post est publié.
	 * 2 si le post est sauvegardé.
	 * @return boolean $state
	 */
	public function getBlogPostState() {
		return isset($this->bp_state)? (int) $this->bp_state : 0;
	}
	
	/**
	 * Renseigne l'id du post en cours.
	 * @param int $id
	 */
	public function setBlogPostID($id) {
		$this->bp_id = $id;
	}
	
	/**
	 * Renseigne le titre du post en cours.
	 * @param string $title
	 */
	public function setBlogPostTitle($title) {
		$this->bp_title = (string) $title;
	}
	
	/**
	 * Renseigne le texte du post en cours.
	 * @param string $text
	 */
	public function setBlogPostText($text) {
		$this->bp_text = (string) $text;
	}
	
	/**
	 * Renseigne l'id de l'auteur du post en cours.
	 * @param int $user_id
	 */
	public function setBlogPostAuthor($user_id) {
		$this->bp_usr_id = $user_id;
	}
	
	/**
	 * Renseigne l'id du type du post en cours.
	 * @param int $blog_type
	 */
	public function setBlogPostType($blog_type_id) {
		$this->bp_bt_id = $blog_type_id;
	}
	
	/**
	 * Change la visibilité du post.
	 * @param int $state
	 */
	public function setBlogPostState($state = 1) {
		
		$this->bp_state = $state;
		
		if (isset($this->bp_id)) {
			
			$sql = 	"update ".$this->table_name." ".
					"set bp_state = ".$this->bp_state." ".
					"where bp_id = ".$this->bp_id;
			
			connection::getConnection()->doExec($sql);
			
		}
	}
	
	/**
	 * TODO modifier pour que la requête se fasse directement après l'appel de cette méthode.
	 * Ajoute un tag au post en cours.
	 * @param tag $tag
	 */
	public function addTagToBlogPost($tag) {
		if (is_a($tag, tag)) $this->bp_tag_list[] = $tag;
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
	
		$this->bp_tag_list = $list;
		
		return $list;
	
	}
	
	/**
	 * Récupère la liste des tags du post en cours.
	 */
	public function getAllPostTags() {

		$list = array();
		
		if (isset($this->bp_id)) {
			
			$sql = 	"select t.* ".
					"from ".$this->table_name.", tagged, tag as t ".
					"where bp_id = tag_bp_id ".
					"and tag_tag_id = tag_id ".
					"and bp_id = ".$this->bp_id;
			
			$result = connection::getConnection()->doQuery($sql);
			
			foreach ($result as $tuple) {
			
				$tag = new tag();
				$tag->readFromStatement($tuple);
			
				$list[] = $tag;
			
			}
			
		}
		
		return $list;
		
	}
	
	/**
	 * Retourne la liste des posts publiés.
	 * @return array blog_post
	 */
	public function getAllPublishedBlogPost() {
		
		return $this->getAllBlogPostByType();
	}
	
	/**
	 * Retourne la liste des posts sauvegardés.
	 * @return array blog_post
	 */
	public function getAllSavedBlogPost() {
	
		return $this->getAllBlogPostByType(2);
	}
	
	/**
	 * Retourne la liste des posts qui ont le type passé en paramètre.
	 * @param int $type
	 * @return array blog_post
	 */
	public function getAllBlogPostByType($type = 1) {
		
		$sql = 	"select * ".
				"from ".$this->table_name." ".
				"where bp_state = $type ".
				"order by bp_date desc";
		
		$result = connection::getConnection()->doQuery($sql);
		$list = array();
		
		foreach ($result as $tuple) {
		
			$post = new blog_post();
			$post->readFromStatement($tuple);
		
			$list[] = $post;
		
		}
		
		return $list;
	}
	
	/**
	 * Insert un nouveau post dans la base de données.
	 */
	public function insertBlogPost() {
	
		if (isset($this->bp_title) && isset($this->bp_usr_id)) {
		
			// la dernière date de modification.
			date_default_timezone_set("Europe/Paris");
			$this->bp_date = date('Y-m-d H:i:s', time());
			$this->bp_date_edit = $this->bp_date;
				
			$fields = array();
			$fields[':title'] = $this->bp_title;
			$fields[':text'] = isset($this->bp_text) ? $this->bp_text : "";
				
			$user_id = $this->bp_usr_id;
			$type_id = isset($this->bp_bt_id)? $this->bp_bt_id : 1;
			
			$level = isset($this->bp_lvl) ? $this->bp_lvl : 0;
			$date = $this->bp_date;
			$date_edit = $this->bp_date;
			
			$state = isset($this->bp_state) ? $this->bp_state : 0;

			$sql = 	"insert into ".$this->table_name." ".
					"(bp_title, bp_text, bp_date, ".
					"bp_state, bp_bt_id, bp_usr_id) ".
					"values ".
					"(:title, :text, '$date', ".
					"$state, $type_id, $user_id )";
			
			connection::getConnection()->doExecPDO($sql, $fields);
		
			$this->bp_id = connection::getConnection()->lastInsertID();
			
			return true;
		}
		
		return false;
	}
	
	public function updateBlogPost() {
		
		if (isset($this->bp_id) && isset($this->bp_title) && isset($this->bp_usr_id) && isset($this->bp_bt_id)) {
		
			// la dernière date de modification.
			date_default_timezone_set("Europe/Paris");
			$this->bp_date_edit = date('Y-m-d H:i:s', time());
		
			$fields = array();
			$fields[':text'] = isset($this->bp_text) ? $this->bp_text : "";
			$fields[':title'] = $this->bp_title;
				
			$type_id = $this->bp_bt_id;
				
			$level = isset($this->bp_lvl) ? $this->bp_lvl : 0;
			$date_edit = $this->bp_date_edit;
				
			$state = isset($this->bp_state) ? $this->bp_state : 0;
		
			$sql = 	"update ".$this->table_name." ".
					"set ".
					"bp_title = :title, bp_text = :text, bp_date_edit = '$date_edit', ".
					"bp_lvl = $level, bp_bt_id = $type_id, bp_state = $state ".
					"where bp_id = ".$this->bp_id;
				
			connection::getConnection()->doExecPDO($sql, $fields);
		}
		
	}
	
	public function deleteBlogPost() {
	
		if (isset($this->bp_id)) {

			$sql = 	"delete from ".$this->table_name." ".
					"where bp_id = ".$this->bp_id;
	
			connection::getConnection()->doExecPDO($sql);
			
		}
	
	}
	
	/**
	 * Permet de ne récupérer que les éléments qui appartiennent à la table "blog_post"
	 * @param PDOStatement $sql_statement
	 * @param boolean $read_all
	 */
	public function readFromStatement($statement, $read_all = false) {
	
		$this->bp_id = isset($statement['bp_id']) ? (int) $statement['bp_id'] : null;
		$this->bp_title = isset($statement['bp_title']) ? (string) $statement['bp_title'] : null;
		$this->bp_text = isset($statement['bp_text']) ? (string) $statement['bp_text'] : null;
		$this->bp_date = isset($statement['bp_date']) ? (string) $statement['bp_date'] : null;
		$this->bp_date_edit = isset($statement['bp_date_edit']) ? (int) $statement['bp_date_edit'] : null;
		$this->bp_state = isset($statement['bp_state']) ? (int) $statement['bp_state'] : 0;
		
		// l'id de l'auteur du post.
		if (isset($statement['bp_usr_id']))
			$this->bp_usr_id = $statement['bp_usr_id'];
		
		// le type du post.
		if (isset($statement['bp_bt_id']))
			$this->bp_bt_id = $statement['bp_bt_id'];
			
		// la liste des tags du post.
		$this->bp_tag_list = $this->getAllPostTags();
		
	}
	
}
