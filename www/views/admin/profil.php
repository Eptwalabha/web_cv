<?php 

?>
<div id="respond_profil">
</div>
<div class="row">
	<div class="span8">
		<h3>Profil publique</h3>
		
		<form action="<?php echo WEBROOT."admin/updatePublicProfil"; ?>" method="post">
		
			<label for="form_last_name" >NOM Pr&eacute;nom</label>
			<input type="text" name="last_name" id="form_last_name" placeholder="Nom de famille" value="<?php echo isset($user)? strtoupper($user->getUserField('usr_last_name')) : ''; ?>" class="span4" />
			<input type="text" name="first_name" id="form_first_name" placeholder="Pr&eacute;nom" value="<?php echo isset($user)? $user->getUserField('usr_first_name') : ''; ?>" class="span4" />
			
			<label for="form_phone" >T&eacute;l&eacute;phones</label>
			<input type="tel" name="phone" id="form_phone" placeholder="n&deg; de t&eacute;l&eacute;phone fix" value="<?php echo isset($user)? $user->getUserField('usr_phone') : ''; ?>" class="span4" />
			<input type="tel" name="cell" id="form_cell" placeholder="n&deg; de portable" value="<?php echo isset($user)? $user->getUserField('usr_cell') : ''; ?>" class="span4" />
			
			<label for="form_mail" >E-mail</label>
			<input type="email" name="mail" id="form_mail" placeholder="adresse e-mail" value="<?php echo isset($user)? $user->getUserField('usr_mail') : ''; ?>" class="span4" />
			
			<label for="form_address_line_1" >Adresse</label>
			<input type="text" name="adresse_line_1" id="form_address_line_1" placeholder="ligne 1" value="<?php echo isset($user)? $user->getUserField('usr_address_line1') : ''; ?>"  class="span6" />
			<input type="text" name="adresse_line_2" id="form_address_line_2" placeholder="ligne 2" value="<?php echo isset($user)? $user->getUserField('usr_address_line2') : ''; ?>"  class="span6" />
			<input type="text" name="adresse_line_3" id="form_address_line_3" placeholder="ligne 3" value="<?php echo isset($user)? $user->getUserField('usr_address_line3') : ''; ?>"  class="span6" />
			
			<label for="form_zip_code" >Localit&eacute;</label>
			<input type="text" name="zip_code" id="form_zip_code" placeholder="code postal" value="<?php echo isset($user)? $user->getUserField('usr_zip_code') : ''; ?>" class="span4" />
			<input type="text" name="town" id="form_town" placeholder="nom de votre ville" value="<?php echo isset($user)? strtoupper($user->getUserField('usr_town')) : ''; ?>" class="span4" />
			
			<label for="form_description_text" >Description</label>
			<textarea id="form_description_text" rows="8" name="description" placeholder="Votre description" class="span8"><?php echo isset($user)? $user->getUserField('usr_text') : ''; ?></textarea><br />
			
			<button id="b_update_public" class="btn btn-success" type="button" title="mettre votre profil &agrave; jour!"><i class="icon-white icon-thumbs-up"></i> Enregistrer</button>
		
		</form>
	</div>
	<div class="span4">
		<h3>Photo</h3>
		<img alt="photo de <?php echo isset($user)? $user->getUserField('usr_login') : ''; ?>" src="<?php	echo (isset($user))? WEBROOT."img/private/".$user->getUserPicture() : WEBROOT."img/private/default.png"; ?>" class="img-polaroid span3" />
		
	</div>
	<div class="span4">
		<h3>Profil administrateur</h3>
	
		<form action="<?php echo WEBROOT."admin/updateAdminProfil"?>" method="post">
			
			<label for="form_first_name" >Mot de passe</label>
			<input type="password" name="password" id="form_pswd" placeholder="Votre mot de passe" required="required" class="span4" />
			<label for="form_login" >Login</label>
			<input type="text" name="login" id="form_new_login" placeholder="login / pseudo" value="<?php echo isset($user)? $user->getUserField('usr_login') : ''; ?>" class="span4" />
			<label for="form_first_pswd" >Nouveau mot de passe</label>
			<input type="password" name="new_password" id="form_first_pswd" placeholder="nouveau mot de passe" class="span4" />
			<label for="form_conf_pswd" >Confirmer nouveau mot de passe</label>
			<input type="password" name="conf_password" id="form_conf_pswd" placeholder="confirmation" class="span4" /><br />
			
			<button id="b_update_admin" class="btn btn-success" type="button" title="mettre votre profil &agrave; jour!"><i class="icon-white icon-thumbs-up"></i> Enregistrer</button>
			
		</form>
	</div>
</div>
<script>

	$('#b_update_public').on('click', updatePublicProfil);
	$('#b_update_admin').on('click', updateAdminProfil);


	function updatePublicProfil() {
		
		$.ajax({
			url: "<?php echo WEBROOT."admin/updatePublicProfil"; ?>",
			data: {
				first_name : $('#form_first_name').val(),
				last_name : $('#form_last_name').val(),
				phone : $('#form_phone').val(),
				cell : $('#form_cell').val(),
				mail : $('#form_mail').val(),
				adresse_line_1 : $('#form_address_line_1').val(),
				adresse_line_2 : $('#form_address_line_2').val(),
				adresse_line_3 : $('#form_address_line_3').val(),
				zip_code : $('#form_zip_code').val(),
				town : $('#form_town').val(),
				description : $('#form_description_text').val()
			},
			type : 'POST'	
		}).done( function(data) {
			$('#respond_profil').html(data);
		}).fail( function(data) {
			console.log('fail');
			console.log(data);
		});
	}


	function updateAdminProfil() {

		if ( $('#form_first_pswd').val() ==  $('#form_first_pswd').val()) {
		
			$.ajax({
				url: "<?php echo WEBROOT."admin/updateAdminProfil"; ?>",
				data: {
					password : $('#form_pswd').val(),
					new_login : $('#form_new_login').val(),
					new_password : $('#form_first_pswd').val(),
					conf_password : $('#form_conf_pswd').val()
				},
				type : 'POST'	
			}).done( function(data) {
				$('#respond_profil').html(data);
			}).fail( function(data) {
				console.log('fail');
				console.log(data);
			});

		} else {
			alert("les mots de passe doivent être identiques!");
		}
	}

</script>