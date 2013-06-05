<?php

class contact extends controller {
	
	public function main() {
	
		$var['active_menu'] = MENU_CONTACT;
		
		require_once ("./models/user.php");
		
		$user = new user();
		
		// on récupère les informations.
		if ($user->readFromID(1)) $var['user'] = $user;
		
		$this->setData($var);
		$this->render("contact");
	}
	
	public function envoyer() {
		
		$var['active_menu'] = MENU_CONTACT;
		$conforme = true;
		
		// on vérifie que les données sont conformes.
		
		// tous les champs sont renseignés.
		if( isset($_POST['nom']) && isset($_POST['mail']) && isset($_POST['message']) && isset($_POST['captcha_code']) ){
		
			$nom = $_POST['nom'];
			$mail = $_POST['mail'];
			$objet = isset($_POST['objet'])? $_POST['objet'] : "";
			$message = $_POST['message'];
			$captcha = $_POST['captcha_code'];
				
			// le nom
			if(strlen($nom) < 3) $conforme = false;
			
			// le mail
			if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)) $conforme = false;
			
			// le message
			if(strlen($message) < 3) $conforme = false;
			
			// le captcha
			if(strlen($captcha) != 6) $conforme = false;
			
			// si tous les champs sont conformes, on teste le captcha
			if($conforme){
				
				require("./securimage/securimage.php");
				$securimage = new Securimage();
				
				if($securimage->check($_POST['captcha_code'])){
					
					// on envoie le mail.
					// mail(EMAIL, $_POST['objet'], $_POST['nom'].'<br />'.$_POST['mail'].'<br />'.$_POST['message']);
					
					// on affiche un message pour l'utilisateur.
					$this->render("message_envoye");
					
					exit;
				}
			}
			
		}
		
		$this->setData($var);
		// on affiche un message d'erreur.
		$this->render("erreur_message");
		
		
	}
}