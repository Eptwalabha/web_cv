<?php
require_once ('./models/blog_type.php');
require_once ('./models/blog_post.php');
require_once ('./models/user.php');

class admin extends controller {
		
	public function main() {

		$var['active_menu'] = MENU_ADMIN;
		$this->setData($var);
		
		if (isset($_POST['login']) && isset($_POST['password']))
			$this->authentifier($_POST['login'], $_POST['password']);
		
		if (isset($_SESSION['admin_en_ligne'])) {
			
			if ($_SESSION['admin_en_ligne'] == true) {
				
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
			$msg_text = "L'identifiant utilisé ou le  mot de passe n'est pas bon!</p>";
			
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
						
					$message['title'] = "Impeccable!";
						
					switch ($_POST['post_state']) {
						case 1:
							$message['text'] = "Votre post a bien &eacute;t&eacute; publi&eacute;!";
							break;
						case 2:
							$message['text'] = "Votre post a bien &eacute;t&eacute; enregistr&eacute;!";
							break;
						default :
							$message['text'] = "Votre post a bien &eacute;t&eacute; enregistr&eacute;!";
							break;
					}
						
					$message['type'] = MSG_SUCCESS;
	
				} else {
						
					$message['title'] = "Attention!";
					$message['text'] = "Un probl&egrave;me est survenu lors de l'insertion dans la base de donn&eacute;es...";
					$message['type'] = MSG_ERROR;
	
				}
	
			} else {
	
				$message['title'] = "Attention!";
				$message['text'] = "Il manque des &eacute;l&eacute;ments au formulaire, impossible de terminer l'enregistrement.";
				$message['type'] = MSG_WARNING;
	
			}
				
		} else {
				
			// TODO informer HAL de la tentative d'accès à cette méthode sans les droits administratifs.
				
			$message['title'] = "Attention!";
			$message['text'] = 	"Vous n'avez pas les droits n&eacute;cessaires pour acc&eacute;der &agrave; cette partie du site.<br />".
					"Cet incident a &eacute;t&eacute; report&eacute; &agrave; l'administrateur principal.";
			$message['type'] = MSG_WARNING;
			$message['closable'] = false;
				
		}
	
		if (!isset($message['closable'])) $message['closable'] = true;
	
		$messages[] = $message;
	
		require (ROOT."views/commun/message.php");
	
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
				
				$message['title'] = "Supprim&eacute;!";
				$message['text'] = "Le post a bien &eacute;t&eacute; supprim&eacute;.";
				$message['type'] = MSG_SUCCESS;
				
				
			} else {
	
				$message['title'] = "Attention!";
				$message['text'] = "Il manque des &eacute;l&eacute;ments au formulaire, impossible de terminer l'enregistrement.";
				$message['type'] = MSG_WARNING;
	
			}
			
			
		} else {
				
			// TODO informer HAL de la tentative d'accès à cette méthode sans les droits administratifs.
				
			$message['title'] = "Attention!";
			$message['text'] = 	"Vous n'avez pas les droits n&eacute;cessaires pour acc&eacute;der &agrave; cette partie du site.<br />".
								"Cet incident a &eacute;t&eacute; report&eacute; &agrave; l'administrateur principal.";
			$message['type'] = MSG_WARNING;
			$message['closable'] = false;
				
		}
		
		if (!isset($message['closable'])) $message['closable'] = true;
		$messages[] = $message;
		
		require (ROOT."views/commun/message.php");
		
	}
	
	
	/**
	 * Permet de vérifier que l'utilisateur de la session est bien un administrateur.
	 * @return boolean
	 */
	private function isAnAdmin() {
		if (isset($_SESSION['admin_en_ligne'])) {
				
			return true;
		}
	
		return false;
	}
	
}