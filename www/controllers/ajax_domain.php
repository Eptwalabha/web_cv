<?php
include_once (ROOT."models/domain.php");
// include_once (ROOT."models/tagged.php");
include_once (ROOT."models/user.php");

class ajax_domain extends controller {
	
	/**
	 * Retourne le formulaire pour la création de domaine.
	 */
	public function formForNewDomain() {
		
		
		$domaine = new domain();
		$liste = $domaine->getAllDomains();
		
		$data = '[';
		$first = true;
		
		foreach ($liste as $d) {
			
			if(!$first) $data .= ',';
			$data .= '"'.$d->getDomainTitle().'"';
			$first = false;
			
		}
		
		$data .= ']';
		?>
<form action="" class="form-inline" id="form_new_domain" >
	<label for="id_txt_domain_title" >Nouveau domaine</label>
	<input type="text" id="id_txt_domain_title" placeholder="Le nom du nouveau domaine" data-provide="typeahead" autocomplete="off" data-source='<?php echo $data; ?>' required />
	<button type="submit" class="btn save_domain"><i class="icon-plus"></i></button>
</form>
		<?php
		
	}

	/**
	 * Enregistre le nouveau domaine.
	 */
	public function saveNewDomain() {

		if (isset($_POST['domain_title']) && isset($_SESSION['admin_en_ligne'])) {

			require_once ("./models/domain.php");
			require_once ("./core/datachecker.php");
			
			
			$domain = new domain();
			$domain->setDomainTitle($_POST['domain_title']);
			$domain->insertDomain();
		
			$id = $domain->getDomainID();

?>
<section id="domain_<?php echo $id; ?>" >
	<div class="well well-small">
		<button type="button" class="btn add_field" data-domain-id="<?php echo $id; ?>" title="ajouter une comp&eacute;tance" ><i class="icon-plus"></i></button>
		<button type="button" class="btn" data-domain-id="<?php echo $id; ?>" title="modifier le nom du domaine" ><i class="icon-pencil"></i></button>
		<strong><?php echo $domain->getDomainTitle(); ?></strong>
	</div>
</section>
<?php

		} else {

			// erreur.
			echo "error"; 
		}
	}
	
	/**
	 * Retourne le boutton 'Nouveau domaine'.
	 */
	public function buttonNewDomain() {

?>
<button type="button" class="btn btn-primary add_domain" id="id_new_domain">Nouveau domaine</button>
<?php

	}
	
	/**
	 * Retourne le contenu du menu mis à jour.
	 */
	public function getUpdatedMenu() {

		require_once ("./models/domain.php");
		
		$domain = new domain();
		
		$domains = $domain->getAllDomains();
		
?>
	<li><a href="#telechargements"><i class="icon-download-alt"></i>T&eacute;l&eacute;chargements</a></li>
<?php 		
		foreach ($domains as $d) {
			$id = $d->getDomainId();
			$nom = $d->getDomainTitle();
?>
	<li><a href="#domain_<?php echo $id; ?>"><i class="icon-chevron-right"></i> <?php echo $nom; ?></a></li>
<?php 
		}


	}
	
}