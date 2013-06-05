<?php


?>

<div id="respond_profil">
</div>
<div class="row">

	<div class="span12">
		<h3>Mon profil</h3>
		
		<form action="<?php echo WEBROOT."admin/updateProfil"; ?>" method="post">
		
			<label for="form_first_name" >NOM Pr&eacute;nom</label>
			<input type="text" name="first_name" id="form_first_name" placeholder="Pr&eacute;nom" value="Damien" />
			<input type="text" name="last_name" id="form_last_name" placeholder="Nom de famille" value="GABRIELLE" />
			
			<label for="form_phone" >T&eacute;l&eacute;phones</label>
			<input type="text" name="phone" id="form_phone" placeholder="n&deg; de t&eacute;l&eacute;phone fix" value="<?php ?>" />
			<input type="text" name="cell" id="form_cell" placeholder="n&deg; de portable" value="<?php ?>" />
			
			<label for="form_mail" >E-mail</label>
			<input type="text" name="mail" id="form_mail" placeholder="adresse e-mail" value="<?php ?>" />
			
			<label for="form_addresse_line_1" >Adresse</label>
			<input type="text" name="addresse_line_1" id="form_addresse_line_1" placeholder="ligne 1" value="Adresse ligne 1" />
			<input type="text" name="addresse_line_2" id="form_addresse_line_2" placeholder="ligne 2" value="Adresse ligne 2" />
			<input type="text" name="addresse_line_3" id="form_addresse_line_3" placeholder="ligne 3" value="Adresse ligne 3" />
			
			<label for="form_zip_code" >Localit&eacute;</label>
			<input type="text" name="zip_code" id="form_zip_code" placeholder="code postal" value="33200" />
			<input type="text" name="town" id="form_town" placeholder="nom de votre ville" value="BORDEAUX" />
			
			<label for="form_description_text" >Description</label>
			<textarea id="form_description_text" rows="8" name="description" placeholder="Votre description" class="span7"></textarea><br />
			
			<button id="b_update" class="btn btn-success" type="button" title="mettre votre profil &agrave jour!"><i class="icon-white icon-thumbs-up"></i> Enregistrer</button>
		
		</form>
	</div>
</div>
