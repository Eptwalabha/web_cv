<?php
require_once ("./models/user.php");


class blog extends controller{


	public function main(){


		$var['active_menu'] = MENU_BLOG;

		$this->setData($var);
		$this->render("accueil");

	}

}