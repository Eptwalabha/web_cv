<section>
	<div class="row">
		<div class="span4 offset4">
			<h3>Authentification</h3>
			<form action="<?php echo WEBROOT."admin"?>" method="post">
		
				<label for="id_login">Login</label>
				<input type="text" id="id_login" name="login" required />
				<label for="id_psw">Mot de passe</label>
				<input type="password" id="id_pws" name="password" required /><br />
				<input type="submit" value="Se connecter">	
				
			</form>
		</div>
	</div>
</section>