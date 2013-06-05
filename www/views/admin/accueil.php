<div>

</div>
<p class="text-right">
	<a class="btn btn-small btn-inverse text-right" href="<?php echo WEBROOT."admin/deconnexion"; ?>" title="se d&eacute;connecter">d&eacute;connexion</a>
</p>
<div>
	<ul class="nav nav-tabs" id="tab_admin">
		<li class="active" title="r&eacute;diger un post">
			<a href="#new_post" data-toggle="new_post">Nouveau post</a>
		</li>
		<li title="&eacute;diter mon profil">
			<a href="#my_profil" data-toggle="my_profil">Mon profil</a>
		</li>
		<li class="disabled" title="consulter les rapports de HAL">
			<a href="#report" data-toggle="report">Rapport</a>
		</li>
	</ul>
	<div class="tab-content">
		<div id="new_post" class="tab-pane active">
			<?php 
				include("./views/admin/nouveau_post.php");
			?>
		</div>
		<div id="my_profil" class="tab-pane">
			<?php 
				include("./views/admin/profil.php");
			?>
		</div>
		<div id="report" class="tab-pane">
			<h3>Rapport</h3>
			<p>
			<?php 
			
				for ($i = 0; $i < 100; $i++) {
					echo "still not ready d: ";
				}
			
			?>
			</p>
		</div>
	</div>
</div>
<script>

	$('#tab_admin a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	})
	
</script>