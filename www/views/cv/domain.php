<?php 
$count_domain = 0;

if (isset($domains)) {
	
	foreach ($domains as $domain) {
		
		$dom_id = $domain->getDomainID();
		$dom_visible = $domain->isDomainVisible();
		$admin = isset($_SESSION['admin_en_ligne']) ? $_SESSION['admin_en_ligne'] : false;
		
		if ($dom_visible || $admin) {
?>
<li id="domain_<?php echo $dom_id; ?>" class="section_domain" data-domain-id="<?php echo $dom_id; ?>">

	<div class="domain_title<?php echo (!$dom_visible) ? " non_visible" : ""; ?> row">
		<div class="span8">
			<h4><?php echo $domain->getDomainTitle();?></h4>
		</div>
	<?php
	
			if (isset($_SESSION['admin_en_ligne'])) {

	?>
		<div class="span4" >
			<p class="text-right">
				<button type="button" class="btn btn-mini toggle_visibility" title="<?php echo ($dom_visible) ? "masquer" : "afficher"; ?> le domaine" data-domain-id="<?php echo $dom_id; ?>"><i class="icon-eye-<?php echo ($dom_visible) ? "close" : "open"; ?>"></i></button>
				<button type="button" class="btn btn-mini add_field" title="ajouter une exp&eacute;rience" data-domain-id="<?php echo $dom_id; ?>"><i class="icon-plus"></i></button>
				<button type="button" class="btn btn-mini" title="modifier le nom du domaine" ><i class="icon-pencil"></i></button>
				<button type="button" class="btn btn-mini btn-danger sppr_domain" title="supprimer le domaine" ><i class="icon-remove icon-white"></i></button>
			</p>
		</div>
	<?php
	
			}
			
	?>
	</div>
	<div class="form_container row-fluid"></div>
	<div class="domain_containt row-fluid">
		<div class="span12">
			<div class="row">
				<div class="description_domain span12">
					<p><?php echo $domain->getDomainText(); ?></p>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<ul>
					<?php 
					
			$list_fields = $domain->getDomainFields();
			
			foreach ($list_fields as $field) {
				
				include(ROOT."views/cv/field.php");
		
			}
						
					?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</li>
<?php 
			$count_domain++;
		}
	}
}

if ($count_domain == 0) {
?>
<li class="no_domain">
	<p>
		Rien dans cette section pour le moment.
	</p>
</li>
<?php 
}