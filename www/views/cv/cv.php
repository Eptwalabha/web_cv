<div class="row">
	<?php
	include (ROOT."views/cv/menu.php");
	?>
	<div class="span9">
		<div class="row-fluid" id="telechargements">
			<h3>T&eacute;l&eacute;charger le CV</h3>
			<ul class="thumbnails text-center">
				<li class="thumbnail span3 disabled">
					<a href="#"><img alt="cv au format pdf" src="img/dl_pdf.png" /></a>
					<div class="caption">
						<h4>PDF</h4>
					</div>
				</li>
				<li class="thumbnail span3">
					<a href="#"><img alt="cv au format Word" src="img/dl_word.png" /></a>
					<div class="caption">
						<h4>Word</h4>
					</div>
				</li>
				<li class="thumbnail span3">
					<a href="#"><img alt="cv au format LibreOffice" src="img/dl_lo.png" /></a>
					<div class="caption">
						<h4>LibreOffice</h4>
					</div>
				</li>
			</ul>
		</div>
		<div class="row-fluid" id="presentation">
			<div class="row-fluid">
				<div class="span4">
					<?php 
						include (ROOT."views/commun/address.php");
					?>
				</div>
				<div class="span3 offset5 text-right">
					<img alt="GABRIELLE Damien" src="img/public/<?php echo isset($user) ? $user->getUserPicture() : "default.png"; ?>">
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<h2 class="text-center">D&eacute;veloppeur, chef de projet junior</h2>
			</div>
		</div>
		<div class="row-fluid">
			<h3>Comp&eacute;tences</h3>
		<?php 
		
			if (isset($_SESSION['admin_en_ligne'])) {

		?>
			<div id="div_add_domain" class="row-fluid">
				<div class="span12">
					<button type="button" class="btn btn-primary add_domain" id="id_new_domain_0">Nouveau domaine</button>
					<button type="button" class="btn order_domain" id="id_order_domain_0">Modifier l'ordre</button>
				</div>
			</div>
		<?php
			}
		?>
			<div class="row-fluid">
				<ul id="section_cv">
						<?php 
							include(ROOT."views/cv/domain.php");
						?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php 
		
	if (isset($_SESSION['admin_en_ligne'])) {

?>
<script>

	$('.add_domain').on('click', getFormForNewDomain);
	$('.add_field').on('click', getFormForNewField);
	$('.sppr_domain').on('click', deleteDomain);
	$('.toggle_visibility').on('click', toggleDomainVisibility);

	$('#id_order_domain_0').on('click', toggleSortable);
	
	$('#section_cv').sortable({
		axis: "y",
		update: function(event, ui) { saveDomainsOrder(); },
		disabled : true,
		containment : "parent"
	});
	
	/**
	 * Récupère le formulaire pour la création d'un nouveau domaine de compétence. AJAX
	 */
	function getFormForNewDomain() {
	
		$parent = $(this).parent();
		
		$.ajax("<?php echo WEBROOT."cv/formForNewDomain"?>").done( function (data) {
	
			// on remplace 
			$parent.html(data);
	
			$parent.find(':submit').on('click', saveNewDomain)
			$parent.find(':text').focus();
			
		});
	}
	
	
	/**
	 * Enregistre le nouveau domaine de compétence. AJAX
	 */
	function saveNewDomain() {
	
		$div = $('#div_add_domain');
		$form = $('#form_new_domain');
		
		var domain_title = $('#id_txt_domain_title').val();
		var domain_text = $('#id_txt_domain_text').val();

		// on ajoute le nouveau domaine.
		$.post("<?php echo WEBROOT."cv/saveNewDomain"?>", {
			'domain_title' : domain_title,
			'domain_text' : domain_text
			
		}).done( function (data) {
			
			// si ajax retourne des données.
			if (data.length > 0) {
				
				// si le nouveau domaine de compétence est enregistré.
				if (data != "error") {
					
					// si elle existe, on retire la balise 'no_domaine'
					$('.no_domain').remove();
	
					var new_section = $(data);
					
					$('#section_cv').append(new_section);

					// new_section.find('.add_field').on('click', getFormForNewField);
					// new_section.find('.sppr_domain').on('click', deleteDomain);

					activeButtonsAdmin(new_section);
					
					// on met à jour le menu latéral.
					updateSideMenu();
	
					getButtonForNewDomain();
					
				} else {
					
					// on affiche un message pour l'utilisateur.
					
					$message = $('<div>').addClass("alert alert-error alert-block").html('<a href="#" class="close" data-dismiss="alert">&times;</a>' + 
						  	'<h4>Erreur!</h4>' +
						  	'<p>Le serveur n\'a pas r&eacute;ussit &aacute; enregistrer le nouveau domaine de comp&eacute;tence...</p>');
					
					$div.after($message);
					
				}
				
			}
			
		});
	
		
	
		return false;
		
	}

	function saveDomainsOrder() {
		
		var ordre = new Array();
		var i = 0;
		
		$('#section_cv').children('li').each(function () {
			ordre[i] = $(this).data('domain-id');
			i++;
		});

		console.log(ordre);

		// on met le menu à jour.
		updateSideMenu();
	}

	/*
	 * Supprime le domaine.
	 */
	function deleteDomain() {

		var li_domain = $(this).parents('li').eq(0);
		var domain_id = li_domain.data('domain-id');
		console.log(domain_id);
		
		$.post("<?php echo WEBROOT."cv/deleteDomain"?>", {'domain_id' : domain_id }).done( function (data) {

			console.log(data);
			if (data == "success") {
				li_domain.remove();

				// on met à jour le menu latéral.
				updateSideMenu();
				
			}
		});
		
	}

	function toggleDomainVisibility() {

		var button = $(this);
		var li_domain = button.parents('li').eq(0);
		var domain_id = li_domain.data('domain-id');
		console.log(domain_id);
		
		$.post("<?php echo WEBROOT."cv/toggleDomainVisibility"?>", {'domain_id' : domain_id }).done( function (data) {
			
			$.post("<?php echo WEBROOT."cv/loadDomain"?>", {'domain_id' : domain_id }).done( function (data) {

				var id_li = li_domain.attr('id');
				li_domain.replaceWith(data);
				activeButtonsAdmin($('#' + id_li));
			});
		});
		
	}
	
	function getButtonForNewDomain() {

		// on remet le boutton de création de nouveau domaine de compétence
		$.ajax("<?php echo WEBROOT."cv/buttonNewDomain"?>").done( function (data) {
	
			$div.html(data);
			$div.find('.add_domain').on('click', getFormForNewDomain);
						
		});
		
	}
	
	function activeButtonsAdmin(li) {

		console.log(li);
		li.find('.add_field').on('click', getFormForNewField);
		li.find('.sppr_domain').on('click', deleteDomain);
		li.find('.toggle_visibility').on('click', toggleDomainVisibility);
		
	}
	
	/**
	 * Récupère le formulaire pour la création d'une nouvelle compétence. AJAX
	 */
	function getFormForNewField() {
	
		var button = $(this);
		var section = button.parents('.section_domain').eq(0);
	
		var domain_id = button.data('domain-id');
		
		console.log(domain_id);
		
		if (domain_id > 0) {
			
			$.post("<?php echo WEBROOT."cv/formForNewField"?>", {'domain_id' : domain_id}).done( function (data) {
		
				if (data.length > 0) {
	
					var form = $(data);
					
					section.find('.form_container').eq(0).html(form);
					
					form.find(':submit').on('click', saveNewField);
					button.addClass('disabled');
	
				} else {
		
				}
			});
	
		}
	
	}
	
	
	/**
	 * Enregistre le nouveau domaine de compétence. AJAX
	 */
	function saveNewField() {
	
		var form = $(this).parent('form');
		var domain_id = form.data('domain-id');
		var li_domain = $('#domain_' + domain_id);  
			
		var field_title = $('#id_txt_field_title_' + domain_id).val();
		var field_text = $('#id_field_text_' + domain_id).val();
		var field_level = $('#id_sel_field_lvl_' + domain_id + ' option:selected').val();

		console.log(field_title + " - " + field_text + " - " + field_level);
		
		$.post('<?php echo WEBROOT."cv/saveNewField"?>', {
								'domain_id' : domain_id,
								'field_title' : field_title,
								'field_text' : field_text,
								'field_level' : field_level
		}).done( function (data) {

			$.post("<?php echo WEBROOT."cv/loadDomain"?>", {'domain_id' : domain_id }).done( function (data) {

				li_domain.replaceWith(data);
				activeButtonsAdmin($('#domain_' + domain_id));
			});
			
			// form.remove();
			
			// .find('.add_domain').on('click', getFormForNewDomain);
						
		});
		
		return false;
	}

	function updateSideMenu() {

		$.ajax("<?php echo WEBROOT."cv/getCVMenu"?>").done( function (new_menu) {
			
			$('#cv_side_menu').parent('div').replaceWith(new_menu);
			$('#cv_side_menu').affix();
		});
	}

	function toggleSortable() {

		var domain_list = $('#section_cv');

		var enable = domain_list.hasClass('sort_domain');
		var option = "enable";
		
		if (enable) {

			domain_list.removeClass('sort_domain');
			option = "disable";
		} else {
		
			domain_list.addClass('sort_domain');
		}

		domain_list.sortable(option);
	}
	
</script>
<?php 
}
