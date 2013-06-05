<?php

/**
 * Permet d'évaluer des paramètres avant une éventuelle insertion dans une base de données.
 * Le fait qu'elle soit singleton, ne sert à rien,
 * j'avais juste envie d'essayer ce pattern (Honteusement pompé sur wikipédia) :p
 * @author Eptwalabha
 */
class DataChecker {
	
	private static $singleton;
	
	private function __construct () {}
	
	private function __clone () {}
	
	public static function getInstance () {
		if (!(self::$singleton instanceof self))
			self::$singleton = new self();
	
		return self::$singleton;
	}
	
	/**
	 * Evalue la chaîne de caractères passé en paramètre.
	 * Si celle-ci a bien la structure d'un mail et qu'elle n'est pas déjà présente dans la base de données,
	 * alors la méthode retourne vrai.
	 * @param unknown $data
	 * @param unknown $connexion
	 * @return boolean
	 */
	public function isAValidMail($data, $connexion){
		
		$res = false;
		
		if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $data))
			return false;
			
		$sql = 	"select us_id ".
				"from user ".
				"where us_mail=\"$data\";";

		$result = $connexion->directSelect($sql);
		
		while ($tuple = $result->fetch()){
			return false;
		}
		
		return true;
		
	}
	
	/**
	 * Evalue la chaîne de caractères passé en paramètre.
	 * Si celle-ci fait une taille de 14 caractères, qu'elle n'est composée que de chiffre,
	 * qu'en multipliant ses chiffres de rang impair à partir de la droite par 1,
	 * ceux de rang pair par 2 et que la somme des chiffres obtenus est multiple de 10 (voir formule de Luhn),
	 * alors la méthode retourne vrai.
	 * @param string $data
	 * @return boolean
	 */
	public function isAValidSiret($data){
			
		if(!preg_match("#[0-9]{14}#", $data)){
			return false;
		}
		
		$tab = str_split($data);
		$check = 0;
		
		for($i = 13; $i >= 0; $i--){
			
			$tab[$i] = intval($tab[$i]) * (2 - $i % 2);
			
			while($tab[$i] >= 10){
				$tab[$i] = $tab[$i] - 10 + 1;
			}
			
			$check += $tab[$i];
		}
		
		return ($check % 10 == 0);
	
	}
	
	/**
	 * Evalue la chaîne de caractère passé en paramètre.
	 * Si celle-ci ne contient que des lettres ou des chiffres, que sa longueur est comprise entre 4 et 20 caractères,
	 * qu'elle ne commence pas par un nombre et que celle-ci n'existe pas déjà dans la base de données, alors la méthode retourne vrai.
	 * @param string $data
	 * @param mysql_connection $connexion
	 * @param int $size
	 * @return boolean
	 */
	public function isAValidPseudo($data, $connexion, $size = 0) {
		
		if(!preg_match("#^[^0-9][a-zA-Z0-9_]{4,20}$#i", $data))
			return false;
		
		// si la taille maximale est renseignée.
		if ($size > 0) {
			
			if (strlen($data) > $size) {
				return false;
			}
			
		}
		
		$sql = 	"select us_id ".
				"from user ".
				"where us_pseudo=\"$data\"";
		
		$result = $connexion->directSelect($sql);
		
		while ($tuple = $result->fetch()){
			return false;
		}
		
		
		return true;
	}
	
	/**
	 * Evalue la chaîne de caractère passé en paramètre.
	 * Si celle-ci ne contient que des lettres ou des chiffres, et que sa longueur est de 6 caractères minimum, la méthode retourne vrai.
	 * @param string $data
	 * @return boolean
	 */
	public function isAValidPassWord($data){

		if(preg_match("#^[a-zA-Z0-9_]{6,}$#", $data))
			return true;
		
		return false;
	}
	
	/**
	 * Modifie la chaîne de caractères pour éviter l'injection SQL.
	 * @param string $text
	 * @param int $size
	 */
	public function normalizeTextForSQL($text, $size = 0) {
		
		// TODO compléter la normalisation de la chaîne.

		
		
		// retaille la chaîne de caractères si la taille est renseignée.
		return ($size > 0) ? substr($text, 0, $size) : $text;
	}
	
}