<?php

/**
 * Cette class établie la connexion avec la base de données,
 * comme cette classe est un singleton, il faut l'initialiser 
 * @author Eptwalabha
 */
class connection {
	
	private static $singleton;
	private $connection;
	
	private function __construct () {}
	
	private function __clone () {}
	
	public static function getConnection () {
		if (!(self::$singleton instanceof self))
			self::$singleton = new self();
	
		return self::$singleton;
	}
	
	public function setParameters($db_dns, $db_name, $db_login, $db_psw, $debug = false) {
		
		$this->debug = $debug;
		
		try {
				
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				
			$this->connection = new PDO("mysql:host=$db_dns;dbname=$db_name", $db_login, $db_psw , $pdo_options);
						
			if($this->debug) $this->printRequest("Connexion à la base de données... OK!<br />");
				
		} catch (Exception $e) {
				
			if($this->debug) $this->printRequest("<code>Connexion à la base de données... FAIL!<br /></code>");
				
			die('Erreur : ' . $e->getMessage());
		}
		
	}
	
	// -----------------------------------------------------
	//   FONCTIONS PDO
	// -----------------------------------------------------
	
	/**
	 * Exécute les requêtes de type INSERT, UPDATE, DELETE
	 * @param string $sql la requête SQL à executer
	 * @return PDOStatement PDO::query returns a PDOStatement object, or false on failure.
	 */
	public function doExec($sql) {
		
		if($this->debug) $this->printRequest($sql);
		
		// prépare la requête pour éviter l'injection.
		$stat = $this->connection->prepare($sql);
		return $stat->execute();
	}
	
	/**
	 * voir PDO::execute() sur htpp://www.php.net
	 * @param unknown_type $sql
	 * @param unknown_type $fields
	 */
	public function doExecPDO($sql, $fields = array()) {
		
		if($this->debug) $this->printRequest($sql);
		
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
		
		if($this->debug) $this->printRequest($sql);
		
		return $this->connection->query($sql);
	}
	
	/**
	 * Retourne l'id du dernier tuple entré dans la base de données.
	 * @return int $last_id le dernier champs inseré dans table
	 */
	public function lastInsertID() {
		
		return $this->connection->lastInsertId();
	}
	
	public function printRequest($sql) {
		echo "<code>$sql</code><br />";
	}
	
	
}

