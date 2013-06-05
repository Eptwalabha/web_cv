<div class="row">
	<div class="span6">
		<h3>Formulaire de contact</h3>
		<form action="<?php echo WEBROOT."contact/envoyer"?>" method="post">
			<label for="id_nom">Nom</label><input class="span4" type="text" placeholder="Votre nom ou celui de votre entreprise" id="id_nom" name="nom" required />
			<label for="id_mail">Mail</label><input class="span4" type="email" placeholder="Vorte mail" id="id_mail" name="mail" required />
			<label for="id_objet">Objet</label><input class="span4" type="text" placeholder="L'objet de votre message" id="id_objet" name="objet" required />
			<label for="id_message">Message</label><textarea class="span6" rows="7" placeholder="Votre message"  id="id_message" name="message" required></textarea><br />
			<img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
			<input type="text" name="captcha_code" size="10" maxlength="6" required />
			<a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false"><i class="icon-refresh"></i></a><br />
			<input type="submit" value="Envoyer!">
		</form>
	</div>
	<div class="span4">
		<h3>Adresse postale</h3>
		<?php 
			include_once (ROOT."views/commun/address.php");
		?>
	</div>
</div>