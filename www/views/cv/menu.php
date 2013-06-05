<div class="span3 bs-docs-sidebar" >
	<ul class="nav nav-list bs-docs-sidenav" data-spy="affix" data-offset-top="200" id="cv_side_menu" >
		<li>
			<a href="#telechargements">
				<i class="icon-download-alt"></i>T&eacute;l&eacute;chargements
			</a>
		</li>
		<?php
		if (isset($domain)) {
				
			foreach ($domains as $domain) {
				$id = $domain['id_domain'];
				$nom = $domain['nom_domain'];
		?>
		<li>
			<a href="#domain_<?php echo $id; ?>">
				<i class="icon-chevron-right"></i> <?php echo $nom; ?>
			</a>
		</li>
		<?php 
			}
			
		}
		?>
	</ul>
</div>