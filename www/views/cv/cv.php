<div class="row">
	<?php
	include (ROOT."views/cv/menu.php");
	?>
	<div class="span9">
		<section id="telechargements">
			<h3>T&eacute;l&eacute;charger le CV</h3>
			<ul class="thumbnails text-center">
				<li class="thumbnail span2 disabled">
					<a href="#"><img alt="cv au format pdf" src="img/dl_pdf.png" /></a>
					<div class="caption">
						<h4>PDF</h4>
					</div>
				</li>
				<li class="thumbnail span2">
					<a href="#"><img alt="cv au format Word" src="img/dl_word.png" /></a>
					<div class="caption">
						<h4>Word</h4>
					</div>
				</li>
				<li class="thumbnail span2">
					<a href="#"><img alt="cv au format LibreOffice" src="img/dl_lo.png" /></a>
					<div class="caption">
						<h4>LibreOffice</h4>
					</div>
				</li>
			</ul>
		</section>
		<section id="presentation">
			<div class="row-fluid">
				<div class="span4">
					<?php 
						include (ROOT."views/commun/address.php");
					?>
				</div>
				<div class="span3 offset5 text-right">
					<img alt="GABRIELLE Damien" src="img/defaut.png">
				</div>
			</div>
		</section>
		<?php 
		
			if (isset($_SESSION['admin_en_ligne'])) {

				include (ROOT."views/cv/new_domain.php");
			}
		?>
		<section id="section_cv">
			<?php
				if (isset($domain)) {
			
					foreach ($domains as $domain) {
	
						include(ROOT."views/cv/domain.php");
						
					}
				} else {
			?>
			<section class="no_domain">
				<p>
					Rien dans cette section pour le moment.
				</p>
			</section>
			<?php 
				}
			?>
		</section>
	</div>
</div>
