<?php

class user extends Model {
	
	private $table_name = "user";
	
	public function user() {}
	
	public function getUserID() {
		if (isset($this->usr_id)) return $this->usr_id;
	}
	
	public function getUserFirstName($html = true) {
		
		if (isset($this->usr_first_name)) {
			return ($html) ? htmlentities($this->usr_first_name, ENT_QUOTES, "utf-8") : $this->usr_first_name;
		}
		
		return false;
	}
	
	public function getUserLastName($html = true) {
	
		if (isset($this->usr_last_name)) {
			return ($html) ? htmlentities($this->usr_last_name, ENT_QUOTES, "utf-8") : $this->usr_last_name;
		}
	
		return false;
	}

	public function getUserDescription($html = true) {
	
		if (isset($this->usr_text)) {
			return ($html) ? htmlentities($this->usr_text, ENT_QUOTES, "utf-8") : $this->usr_text;
		}
	
		return false;
	}

	public function getUserAddress1($html = true) {
	
		if (isset($this->usr_address_line1)) {
			return ($html) ? htmlentities($this->usr_address_line1, ENT_QUOTES, "utf-8") : $this->usr_address_line1;
		}
	
		return "";
	}
	
	public function getUserAddress2($html = true) {
	
		if (isset($this->usr_address_line2)) {
			return ($html) ? htmlentities($this->usr_address_line2, ENT_QUOTES, "utf-8") : $this->usr_address_line2;
		}
	
		return "";
	}
	
	public function getUserAddress3($html = true) {
	
		if (isset($this->usr_address_line3)) {
			return ($html) ? htmlentities($this->usr_address_line3, ENT_QUOTES, "utf-8") : $this->usr_address_line3;
		}
	
		return "";
	}
	
	public function getUserMail() {
		return isset($this->usr_mail)? $this->usr_mail : "";
	}
	
	public function getUserLogin() {
		return isset($this->usr_login)? $this->usr_login : "";
	}
	
	public function getUserPhone() {
		return isset($this->usr_phone)? $this->usr_phone : "";
	}
	
	public function getUserCell() {
		return isset($this->usr_cell)? $this->usr_cell : "";
	}
	
	public function getUserZipCode() {
		return isset($this->usr_zip_code)? $this->usr_zip_code : "";
	}
	
	public function getUserTown() {
		return isset($this->usr_town)? $this->usr_town : "";
	}
	
	/**
	 * Charge l'utilisateur de la base de données en fonction du login et du mot de passe.
	 * Retourne false si le couple login/mot de passe n'est pas correcte.
	 * @param string $login
	 * @param string $password
	 * @return boolean $find
	 */
	public function signIn($login, $password) {
		
		$login_size = strlen($login);
		
		if ($login_size > 4 && $login_size <= 20) {
			
			$sql = 	"select * ".
					"from ".$this->table_name." ".
					"where usr_login = :login and usr_passwd = :passwd";
			
			$fields = array();
			
			$fields[':login'] = $login;
			$fields[':passwd'] = hash("sha256", $password);

			$result = connection::getConnection()->doExecPDO($sql, $fields);
			$statement = $result->fetch();
			
			if ($statement) {
				$this->readFromStatement($statement);
				return true;
			}
			
		}
		
		return false;
	}
	
	/**
	 * Charge les données du possésseur du site.
	 * @deprecated préférez la méthode readFromStatement.
	 * @deprecated utiliser la méthode readFromID()
	 */
	public function getData() {
		
		
		$fields = 	"usr_login as 'login', usr_first_name as 'first_name', usr_last_name as 'last_name', ".
					"usr_mail as 'mail', usr_phone as 'phone', usr_cell as 'cell', ". 
					"usr_address_line1 as 'address1', usr_address_line2 as 'address2', usr_address_line3 as 'address3', ".
					"usr_cp as 'cp', usr_town as 'town', usr_description as 'description'";
		
		$result = $this->read($fields, $this->table_name);
		
		$tuple = $result->fetch();
		
		foreach ($tuple as $k => $v) {
			$this->$k = $v;
		}
		
		return $tuple;
	}
	
	/**
	 * Récupère les informations de l'utilisateur dont l'id est passé en paramètre.
	 * @param int $id
	 * @return boolean $exists
	 */
	public function readFromID($id) {
		
		if ($id > 0) {
			
			$sql = 	"select * ".
					"from ".$this->table_name." ".
					"where usr_id = $id";
			
			$result = connection::getConnection()->doQuery($sql);
			
			$statement = $result->fetch();
			
			if($statement) {
				$this->readFromStatement($statement);
				return true;
			}
			
		}
		
		return false;
	}
	
	/**
	 * Permet de ne récupérer que les éléments qui appartiennent à la table "user"
	 * @param PDOStatment $sql_statement
	 */
	public function readFromStatement($statement, $usr_passwd = false) {
	
		$this->usr_id = isset($statement['usr_id']) ? (int) $statement['usr_id'] : null;
		
		$this->usr_mail = isset($statement['usr_mail']) ? (string) $statement['usr_mail'] : null;
		$this->usr_login = isset($statement['usr_login']) ? (string) $statement['usr_login'] : null;
		$this->usr_text = isset($statement['usr_text']) ? (string) $statement['usr_text'] : null;
		$this->usr_last_name = isset($statement['usr_last_name']) ? (string) $statement['usr_last_name'] : null;
		$this->usr_first_name = isset($statement['usr_first_name']) ? (string) $statement['usr_first_name'] : null;
		
		$this->usr_phone = isset($statement['usr_phone']) ? (string) $statement['usr_phone'] : null;
		$this->usr_cell = isset($statement['usr_cell']) ? (string) $statement['usr_cell'] : null;
		$this->usr_address_line1 = isset($statement['usr_address_line1']) ? (string) $statement['usr_address_line1'] : null;
		$this->usr_address_line2 = isset($statement['usr_address_line2']) ? (string) $statement['usr_address_line2'] : null;
		$this->usr_address_line3 = isset($statement['usr_address_line3']) ? (string) $statement['usr_address_line3'] : null;
		$this->usr_zip_code = isset($statement['usr_zip_code']) ? (string) $statement['usr_zip_code'] : null;
		$this->usr_town = isset($statement['usr_town']) ? (string) $statement['usr_town'] : null;
		
		if ($usr_passwd) {
			$this->usr_passwd = isset($statement['usr_passwd']) ? (string) $statement['usr_passwd'] : null;
		}
		
	}
	
	
}
