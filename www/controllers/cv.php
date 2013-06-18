<?php
require_once ("./models/domain.php");
require_once ("./models/field.php");
require_once ("./models/user.php");

class cv extends controller {
	
	public function main() {
		
		$var['active_menu'] = MENU_CV;
		
		
		$domain = new domain();
		$field = new field();
		$user = new user();
		
		$liste_domain = $domain->getAllDomains();
		
		$var['domains'] = $liste_domain;
		// on récupère les informations du propriétaire du site.
		if ($user->readFromID(1)){
			$var['user'] = $user;
		}
		
		$this->setData($var);
		$this->render("cv");
		
	}
	
	public function addNewDomain() {
		
		if (isset($_POST['title'])) {
			
			$domain = new domain();
			$domain->setDomainTitle($_POST['title']);
			if (isset($_POST['text'])) $domain->setDomainText($_POST['text']);
				
		
		}
		
	}
	
	public function addNewFields() {
		
		
		
	}
	
	public function getCVMenu() {
		
		$domain = new domain();
		
		$liste_domain = $domain->getAllDomains();
		$var['domains'] = $liste_domain;
		
		$this->setData($var);
		
		$this->render("menu", false);
	}
	
	/**
	 * Retourne le boutton 'Nouveau domaine'.
	 */
	public function buttonNewDomain() {
	
?>
<button type="button" class="btn btn-primary add_domain" id="id_new_domain">Nouveau domaine</button>
<button type="button" class="btn order_domain" id="id_order_domain_0">Modifier l'ordre</button>
<?php
	
	}
	
	/**
	 * Retourne le formulaire pour la création de domaine.
	 */
	public function formForNewDomain() {
	
	
		$domain = new domain();
		$liste = $domain->getAllDomains();
	
		$data = '[';
		$first = true;
	
		foreach ($liste as $d) {
				
			if(!$first) $data .= ',';
			$data .= '"'.$d->getDomainTitle().'"';
			$first = false;
				
		}
	
		$data .= ']';
		$var['auto_complete'] = $data;
		
		$this->setData($var);
		$this->render('new_domain_form', false);
					
	}
	
	/**
	 * Enregistre le nouveau domaine.
	 */
	public function saveNewDomain() {
	
		if (isset($_POST['domain_title']) && isset($_SESSION['admin_en_ligne'])) {
			
			if (strlen($_POST['domain_title']) > 0) {

				$domain = new domain();
				$domain->setDomainTitle($_POST['domain_title']);
				if (isset($_POST['domain_text'])) $domain->setDomainText($_POST['domain_text']);
				$domain->insertDomain();
		
				$id = $domain->getDomainID();
		
				$var['domains'][] = $domain;
				$this->setData($var);
				
				$this->render('domain', false);
				
				exit(0);
				
			}
		}

		// erreur.
		echo "error"; 

	}
	
	/**
	 * Supprime le domaine dont l'id est passé en paramètre.
	 */
	public function deleteDomain() {

		if (isset($_POST['domain_id']) && isset($_SESSION['admin_en_ligne'])) {
			
			$id = $_POST['domain_id'];
			
			if ($id > 0) {

				$domain = new domain();
				$domain->setDomainID($id);
				
				if ($domain->deleteDomain()) {
					echo "success";
					exit(0);
				}
			}
		}
		
		echo "fail";
	}
	
	
	public function toggleDomainVisibility() {
		
		if(isset($_POST['domain_id']) && isset($_SESSION['admin_en_ligne'])) {

			$id = $_POST['domain_id'];
				
			if ($id > 0) {

				$domain = new domain();

				if($domain->readFromID($id)) {

					$domain->setDomainVisibility(!$domain->isDomainVisible());
					$domain->updateDomain();
					
					echo "success";
					exit(0);
				}
			}
		}
		
		echo "fail";
	}
	
	public function loadDomain() {

		if (isset($_POST['domain_id'])) {
			$domain = new domain();
			
			if ($domain->readFromID($_POST['domain_id'])) {
				
				$var['domains'][] = $domain;
				$this->setData($var);
				$this->render("domain", false);
			}
		}
	}
	
	/**
	 * Retourne le formulaire pour la création de domaine.
	 */
	public function formForNewField() {

		if (isset($_POST['domain_id'])) {
			$domain = new domain();
			
			if ($domain->readFromID($_POST['domain_id'])) {

				$var['domain'] = $domain;
				$this->setData($var);
				$this->render("new_field_form", false);
			}
		}
	}
	
	public function saveNewField() {

		if (isset($_POST['domain_id']) && isset($_POST['field_title']) && isset($_SESSION['admin_en_ligne'])) {
		
			$field = new field();
			$field->setFieldTitle($_POST['field_title']);
			$field->setFieldDomainID($_POST['domain_id']);
			if (isset($_POST['field_text'])) $field->setFieldText($_POST['field_text']);
			if (isset($_POST['field_level'])) $field->setFieldLevel($_POST['field_level']);
				
			$field->insertField();
		
		}
		
	}	
}
	