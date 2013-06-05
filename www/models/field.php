<?php
class field extends Model {
	
	private $table_name = "field";
	
	public function field() { }
	
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
	
	public function setVisible($visible = true) {
		$this->fie_visible = $visible ? 1 : 0;
		
		if (isset($this->fie_id)) {
				
			$sql = 	"update ".$this->table_name." ".
					"set fie_visible = ".$this->fie_visible." ".
					"where fie_id = ".$this->fie_id;
				
			$this->connection->doExec($sql);
				
		}
		
	}
	
	// TODO voir pour le format de date à choisir.
	public function setDateStart($date_start) {
		$this->fie_date_start = $date_start;		
	}
	
	public function setDateEnd($date_end = null) {
		$this->fie_date_end = $date_end;
	}
	
	public function setFieldUser($user) {
		if (is_a($user, user)) $this->fie_user = $user; 
	}
	public function setFieldDomain($domain) {
		if (is_a($domain, domain)) $this->fie_domain = $domain;
	}
	
	/**
	 * TODO mettre en place.
	 */
	public function updateField() {
		
		
	}
	
}