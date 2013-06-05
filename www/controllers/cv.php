<?php

class cv extends controller {
	
	public function main() {
		
		$var['active_menu'] = MENU_CV;
		
		require_once ("./models/domain.php");
		require_once ("./models/field.php");
		require_once ("./models/user.php");
		
		$domain = new domain();
		$field = new field();
		$user = new user();
		
		$liste_domain = $domain->getAllDomains();
		
		// on récupère les informations du propriétaire du site.
		if ($user->readFromID(1)){
			$var['user'] = $user;
		}
		
		$this->setData($var);
		$this->render("cv");
		
	}
	
	public function addNewDomain() {
		
		if (isset($_POST['dom_name']) && isset($_POST['dom_description'])) {
			
			
			require_once ("./models/domain.php");
			
			$domain = new domain();
			$domain->setDomainTitle($_POST['dom_title']);
			$domain->setDomainDescription($_POST['dom_description']);
				
		
		}
		
	}
	
	public function addNewFields() {
		
		require_once ("./models/field.php");
		
	}
	
	
}