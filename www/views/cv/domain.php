<section id="domaine_<?php echo $domain['id']; ?>">

	<div class="well well-small">
	<?php
	
		if (isset($_SESSION['admin_en_ligne'])) {

	?>
		<button type="button" class="btn" title="ajouter une comp&eacute;tance" ><i class="icon-plus"></i></button>
		<button type="button" class="btn" title="modifier le nom du domaine" ><i class="icon-pencil"></i></button>
	<?php
	 
		}
		
	?>
		<strong><?php echo $domaine['nom'];?></strong>
	</div>
	<?php 
	
		foreach ($domaine['liste_competences'] as $competence) {
			
			include(WEBROOT."views/cv/field.php");
	
		}
		
	?>
</section>