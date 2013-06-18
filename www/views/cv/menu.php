<div class="span3 bs-docs-sidebar" >
	<ul class="nav nav-list bs-docs-sidenav" data-spy="affix" data-offset-top="200" id="cv_side_menu" >
		<li>
			<a href="#telechargements">
				<i class="icon-download-alt"></i>T&eacute;l&eacute;chargements
			</a>
		</li>
		<?php
		if (isset($domains)) {
				
			foreach ($domains as $domain) {

				$dom_visible = $domain->isDomainVisible();
				$admin = isset($_SESSION['admin_en_ligne']) ? $_SESSION['admin_en_ligne'] : false;
				
				if ($dom_visible || $admin) {
		?>
		<li>
			<a href="#domain_<?php echo $domain->getDomainID(); ?>">
				<i class="icon-chevron-right"></i> <?php echo $domain->getDomainTitle(); ?>
			</a>
		</li>
		<?php
				}
			}
		}
		?>
	</ul>
</div>