<?php
require_once ("./models/user.php");

class accueil extends controller{

	
	public function main(){
		
		
		$var['active_menu'] = MENU_ACCUEIL;
		
		$this->setData($var);
		$this->render("accueil");
		
	}
	
	public function test() {
		
		$this->render("test");
	}
}