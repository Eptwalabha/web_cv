<?php
require_once ('./models/blog_type.php');
require_once ('./models/blog_post.php');
require_once ('./models/user.php');

class admin extends controller {
		
	private $message;
	
	public function main() {

		$var['active_menu'] = MENU_ADMIN;
		$this->setData($var);
		
		if (isset($_POST['login']) && isset($_POST['password']))
			$this->authentifier($_POST['login'], $_POST['password']);
		
		if (isset($_SESSION['admin_en_ligne'])) {
			
			if ($_SESSION['admin_en_ligne'] == true) {
				
				$user = new user();
				
				if ($user->readFromID(1)){
					$var['user'] = $user;
				}
				
				$this->setData($var);
				
				$this->render("accueil");
				
			} else {
				
				$this->error404();
				
			}
			
		} else {

			$this->render("login");
		}
	}
	
	public function authentifier($login, $psw) {
		
		$user = new user();
		
		if ($user->signIn($login, $psw)) {
			
			$_SESSION['admin_en_ligne'] = $user->getUserLogin();
			$_SESSION['utilisateur_id'] = $user->getUserID();
			
			$msg_type = MSG_SUCCESS;
			$msg_title = "Bonjour ".$user->getUserLogin();
			$msg_text = "Vous &ecirc;tes maintenant connect&eacute; en tant qu'administrateur du site.";
			
			$this->addMessage($msg_type, $msg_title, $msg_text, true);
							
		}else{
			
			$msg_type = MSG_ERROR;
			$msg_title = "Impossible de se connecter";
			$msg_text = "L'identifiant utilis&eacute; ou le  mot de passe n'est pas bon!</p>";
			
			$this->addMessage($msg_type, $msg_title, $msg_text);
			
		}
			
		
	}
	
	public function deconnexion() {
		
		session_destroy();
		session_start();
		
		$msg_type = MSG_WARNING;
		$msg_title = "D&eacute;connexion";
		$msg_text = "Vous &ecirc;tes maintenant d&eacute;connect&eacute; de votre session.";
		
		$this->addMessage($msg_type, $msg_title, $msg_text, true);
		
		$this->main();
		
	}
	
	public function publishPost() {
	
		$messages = array();
	
		if ($this->isAnAdmin()) {
			
			if (isset($_POST['post_title']) && isset($_POST['post_text']) && isset($_POST['post_type']) && isset($_POST['post_state'])) {
	
	
				$post = new blog_post();
	
				$post->setBlogPostAuthor($_SESSION['utilisateur_id']);
				$post->setBlogPostType($_POST['post_type']);
				$post->setBlogPostState($_POST['post_state']);
				$post->setBlogPostTitle($_POST['post_title']);
				$post->setBlogPostText($_POST['post_text']);
	
				if ($post->insertBlogPost()) {
						
					$this->message['title'] = "Impeccable!";
						
					switch ($_POST['post_state']) {
						case 1:
							$this->message['text'] = "Votre post a bien &eacute;t&eacute; publi&eacute;!";
							break;
						case 2:
							$this->message['text'] = "Votre post a bien &eacute;t&eacute; enregistr&eacute;!";
							break;
						default :
							$this->message['text'] = "Votre post a bien &eacute;t&eacute; enregistr&eacute;!";
							break;
					}
						
					$this->message['type'] = MSG_SUCCESS;
	
				} else {
						
					$this->message['title'] = "Attention!";
					$this->message['text'] = "Un probl&egrave;me est survenu lors de l'insertion dans la base de donn&eacute;es...";
					$this->message['type'] = MSG_ERROR;
	
				}
	
			} else {
	
				$this->message['title'] = "Attention!";
				$this->message['text'] = "Il manque des &eacute;l&eacute;ments au formulaire, impossible de terminer l'enregistrement.";
				$this->message['type'] = MSG_WARNING;
	
			}
				
		}
		
		$this->displayMessage();
		
	}
	
	public function listeSavedBlogPost() {
	
		if ($this->isAnAdmin()) {
				
			$post = new blog_post();

			$var['list_posts'] = $post->getAllSavedBlogPost();
			
			$this->setData($var);
			
			$this->render('saved_post_panel', false);
				
		}
	}
	
	public function getListSavedPost() {
	
	
	
	
	
	}
	
	public function savePost() {
	
	
	}
	
	public function deletePost() {

		if ($this->isAnAdmin()) {
			
			if (isset($_POST['post_id'])) {
				
				$post = new blog_post();
				$post->setBlogPostID($_POST['post_id']);
				$post->deleteBlogPost();
				
				$this->message['title'] = "Supprim&eacute;!";
				$this->message['text'] = "Le post a bien &eacute;t&eacute; supprim&eacute;.";
				$this->message['type'] = MSG_SUCCESS;
				
				
			} else {
	
				$this->message['title'] = "Attention!";
				$this->message['text'] = "Il manque des &eacute;l&eacute;ments au formulaire, impossible de terminer l'enregistrement.";
				$this->message['type'] = MSG_WARNING;
	
			}
			
		}
		
		$this->displayMessage();
		
	}
	
	public function updatePublicProfil() {
		
		if ($this->isAnAdmin()) {
			
			
			$user = new user();
			$user->readFromID(1);
			
			if (isset($_POST['first_name'])) $user->setUserFirstName($_POST['first_name']);
			if (isset($_POST['last_name'])) $user->setUserLastName($_POST['last_name']);
			
			if (isset($_POST['phone'])) $user->setUserPhone($_POST['phone']);
			if (isset($_POST['cell'])) $user->setUserCell($_POST['cell']);
			
			if (isset($_POST['mail'])) $user->setUserMail($_POST['mail']);
			
			if (isset($_POST['adresse_line_1'])) $user->setUserAddress1($_POST['adresse_line_1']);
			if (isset($_POST['adresse_line_2'])) $user->setUserAddress2($_POST['adresse_line_2']);
			if (isset($_POST['adresse_line_3'])) $user->setUserAddress3($_POST['adresse_line_3']);
				
			if (isset($_POST['zip_code'])) $user->setUserZipCode($_POST['zip_code']);
			if (isset($_POST['town'])) $user->setUserTown($_POST['town']);
				
			if (isset($_POST['description'])) $user->setUserDescription($_POST['description']);
			
			if ($user->updateProfil()) {
				
				$this->message['title'] = "Modifi&eacute;!";
				$this->message['text'] = "Les informations ont bien &eacute;t&eacute; enregistr&eacute;.<br />";
				$this->message['type'] = MSG_SUCCESS;
				
			} else {
				
				$this->message['title'] = "Attention!";
				$this->message['text'] = "Une erreur est survenue lors de l'insertion dans la base de donn&eacute;.";
				$this->message['type'] = MSG_WARNING;
				
			}
			
		}
		
		$this->displayMessage();
		
	}
	
	public function updateAdminProfil() {

		if ($this->isAnAdmin()) {
			
			if (isset($_POST['password'])) {
				
				$user = new user();
				$user->readFromID(1);
				
				// check if the password is ok.
				if ($user->checkPassword($user->getUserLogin(), $_POST['password'])) {
					
					$new_login_valid = true;
					$new_password_valid = true;
						
					if (isset($_POST['new_password']) && isset($_POST['conf_password'])) {
						
						if (strlen($_POST['new_password']) > 0) {
							
							if ($_POST['new_password'] == $_POST['conf_password'] && strlen($_POST['new_password']) >= 4) {
								
								$user->setUserPassword($_POST['new_password']);
							} else {
								$new_password_valid = false;
							}
						}
					}
					
					if (isset($_POST['new_login'])) {
						
						$new_login = trim($_POST['new_login']);
						
						if (strlen($new_login) >= 4) {
							
							$user->setUserLogin($_POST['new_login']);
						} else {
							$new_login_valid = false;
						}
					}
					
					if ($new_login_valid && $new_password_valid) {
						
						if ($user->updateAdminProfil()) {
							
							$this->message['title'] = "Modifi&eacute;!";
							$this->message['text'] = "Les informations ont bien &eacute;t&eacute; enregistr&eacute;.<br />";
							$this->message['type'] = MSG_SUCCESS;
							
						} else {
							
							$this->message['title'] = "Attention!";
							$this->message['text'] = "Une erreur est survenue lors de l'insertion dans la base de donn&eacute;.";
							$this->message['type'] = MSG_WARNING;
						}
						
					} else {
						
						$this->message['title'] = "Attention!";
						$this->message['text'] = "";
						
						if (!$new_login_valid) {
							$this->message['text'] .= "Le nouveau login n'est pas valide!";
						}
						
						if (!$new_password_valid) {
							
							if (!$new_login_valid) $this->message['text'] .= "<br />";
							
							$this->message['text'] .= "Le nouveau mot de passe n'est pas valide!";
						}
						
						
						$this->message['type'] = MSG_WARNING;
					}
					
				} else {
					
					$this->message['title'] = "Attention!";
					$this->message['text'] = "Le mot de passe entr&eacute; est incorrect!";
					$this->message['type'] = MSG_WARNING;
				}
				
			} else {
	
				$this->message['title'] = "Attention!";
				$this->message['text'] = "Pour que les modifications soient prises en compte, le mot de passe administrateur doit &ecirc;tre renseign&eacute;";
				$this->message['type'] = MSG_WARNING;
	
			}
			
		}
		
		$this->displayMessage();
		
	}
	
	/**
	 * Permet de vérifier que l'utilisateur de la session est bien un administrateur.
	 * @return boolean
	 */
	private function isAnAdmin() {
		if (isset($_SESSION['admin_en_ligne'])) {
				
			return true;
		}
		
		// TODO informer HAL de la tentative d'accès à cette méthode sans les droits administratifs.
				
		$this->message['title'] = "Attention!";
		$this->message['text'] = 	"Vous n'avez pas les droits n&eacute;cessaires pour acc&eacute;der &agrave; cette partie du site.<br />".
									"Cet incident a &eacute;t&eacute; report&eacute; &agrave; l'administrateur principal.";
		$this->message['type'] = MSG_WARNING;
		$this->message['closable'] = false;
	
		return false;
	}
	
	private function displayMessage() {
		
		if (!isset($this->message['closable'])) $this->message['closable'] = true;
		
		$messages[] = $this->message;
		
		require (ROOT."views/commun/message.php");
		
	}
	
}