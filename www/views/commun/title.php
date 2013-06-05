<?php 

	$menu = isset($active_menu)? $active_menu : '';

	switch ($menu) {
		
		case MENU_ACCUEIL:

			$title = "Bonjour! <small>Et bienvenue sur mon site.</small>";
			break;
			
		case MENU_CV:

			$title = "Curriculum vit&aelig;";
			break;
			
		case MENU_CONTACT:
			
			$title = "Me contacter";
			break;
			
		case MENU_ADMIN:

			$title = "Administration";
			break;
			
		default:
			$title = "Ooops!";
	}

?>
<header>
	<div class="container">
		<div class="page-header">
			<h1><?php echo $title; ?></h1>
		</div>
		<?php
		
			$menu = isset($active_menu) ? $active_menu : MENU_ACCUEIL;
			if ($menu == MENU_ACCUEIL || $menu == MENU_CV) {
		?>
		<div class="alert alert-info alert-block">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
		  	Je suis actuellement à la recherche d'un <a href="http://travail-emploi.gouv.fr/informations-pratiques,89/fiches-pratiques,91/contrats,109/le-contrat-de-professionnalisation,992.html">contrat de professionnalisation</a> sur Bordeaux<br />
		  	Si mon profil à retenu votre attention, n'hésitez pas à <a href="<?php echo WEBROOT."contact"; ?>">prendre contact</a>!
		</div>
		<?php 
			}
		?>
	</div>
</header>