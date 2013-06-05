<?php

class connection {
	
	private $connection;
	
	// -----------------------------------------------------
	//   CONSTRUCTEUR
	// -----------------------------------------------------
	
	public function connection($db_dns, $db_name, $db_login, $db_psw, $debug = false) {
		
		$this->db_dns = $db_dns;
		$this->db_name = $db_name;
		$this->db_login = $db_login;
		$this->db_psw = $db_psw;
		
		$this->debug = $debug;
		$this->connect();
		
	}
	
	/**
	 * Retourne l'instance de connexion de PDO sur la base de données.
	 * @return PDO
	 */
	public function getConnection() {
		return $this->connection;
	}
	
	// -----------------------------------------------------
	//   FONCTIONS PDO
	// -----------------------------------------------------
	
	/**
	 * Etablit la connexion avec la base de données.
	 */
	private function connect() {
		
		try {
			
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			
			$this->connection = new PDO('mysql:host='.$this->db_dns.';dbname='.$this->db_name, $this->db_login, $this->db_psw , $pdo_options);
			
			if($this->debug) echo "Connexion à la base de données... OK!<br />";
			
		} catch (Exception $e) {
			
			if($this->debug) echo "Connexion à la base de données... FAIL!<br />";
			
			die('Erreur : ' . $e->getMessage());
		}
	}
	
	/**
	 * Exécute les requêtes de type INSERT, UPDATE, DELETE
	 * @param string $sql la requête SQL à executer
	 * @return PDOStatement PDO::query returns a PDOStatement object, or false on failure.
	 */
	public function doExec($sql) {
		
		if($this->debug) echo "<code>$sql</code>";
		
		// prépare la requête pour éviter l'injection.
		$stat = $this->connection->prepare($sql);
		return $stat->execute();
	}
	
	/**
	 * voir PDO::execute() sur htpp://www.php.net
	 * @param unknown_type $sql
	 * @param unknown_type $fields
	 */
	public function doExecPDO($sql, $fields) {
		
		if($this->debug) echo "<code>$sql</code>";
		
		// prépare la requête pour éviter l'injection.
		$stat = $this->connection->prepare($sql);
		
		if ($stat->execute($fields)) {
			return $stat;
		}
		
		return false;
	}
	
	/**
	 * Exécute les requêtes de type SELECT
	 * @param string $sql la requête SQL à executer
	 * @return PDOStatement PDO::query returns a PDOStatement object, or false on failure.
	 */
	public function doQuery($sql) {
		
		if($this->debug) echo "$sql<br />";
		
		return $this->connection->query($sql);
	}
	
	/**
	 * Retourne l'id du dernier tuple entré dans la base de données.
	 * @return int $last_id le dernier champs inseré dans table
	 */
	public function lastInsertID() {
		
		return $this->connection->lastInsertId();
	}
	
	
}

