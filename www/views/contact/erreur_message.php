<?php 

	function getData($name_data) {
		return (isset($_POST[$name_data]))? $_POST[$name_data] : "";
	}

?>
<div class="alert alert-error alert-block">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<strong>Attention!</strong> Tous les champs ne sont pas conformes.
</div>
<div class="container">
	<div class="row">
		<div class="span6">
			<h3>Formulaire de contact</h3>
			<form action="<?php echo WEBROOT."contact/envoyer"?>" method="post">
				<label for="id_nom">Nom</label><input class="span4" type="text" placeholder="Votre nom ou celui de votre entreprise" id="id_nom" name="nom" value="<?php echo getData('nom');?>" required />
				<label for="id_mail">Mail</label><input class="span4" type="email" placeholder="Vorte mail" id="id_mail" name="mail" value="<?php echo getData('mail');?>" required />
				<label for="id_objet">Objet</label><input class="span4" type="text" placeholder="L'objet de votre message" id="id_objet" name="objet" value="<?php echo getData('objet');?>" required />
				<label for="id_message">Message</label><textarea class="span6" rows="6" placeholder="Votre message"  id="id_message" name="message" required><?php echo getData('message');?></textarea><br />
				<img id="captcha" src="<?php echo WEBROOT."securimage/securimage_show.php"; ?>" alt="CAPTCHA Image" />
				<input type="text" name="captcha_code" size="10" maxlength="6" required />
				<a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false"><i class="icon-refresh"></i></a><br />
				<input type="submit" value="Envoyer!">
			</form>
		</div>
		<div class="span4">
			<h3>Adresse postale</h3>
			<p><strong>GABRIELLE Damien</strong></p>
			<p>221-223 Avenue de la R&Eacute;PUBLIQUE</p>
			<p>Apt n&deg;17 r&eacute;sidence SQUARE PRIMEROSE</p>
			<p>33200 BORDEAUX</p>
		</div>
	</div>
</div>