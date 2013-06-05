<div class="div_ajax">
	<button type="button" class="btn btn-primary add_domain" id="id_new_domain_0">Nouveau domaine</button>
</div>
<script>

	$('.add_domain').on('click', getFormForNewDomain);
	$('.add_field').on('click', getFormForNewField);

	/**
	 * Récupère le formulaire pour la création d'un nouveau domaine de compétence. AJAX
	 */
	function getFormForNewDomain() {

		$parent = $(this).parent();
		
		$.ajax("<?php echo WEBROOT."ajax_domain/formForNewDomain"?>").done( function (data) {

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

		$div = $(this).closest('.div_ajax');
		$form = $(this).closest('form');
		
		var domain_title = $form.find(':text').val();
		
		// on ajoute le nouveau domaine.
		$.post("<?php echo WEBROOT."ajax_domain/saveNewDomain"?>", {'domain_title' : domain_title}).done( function (data) {

			// si ajax retourne des données.
			if (data.length > 0) {

				// si le nouveau domaine de compétence est enregistré.
				if (data != "error") {
					
					// si elle existe, on retire la balise 'no_domaine'
					$('.no_domain').remove();
	
					$new_section = $(data);
					
					// on met à jour le menu latéral.
					$('#section_cv').append($new_section);
	
					$new_section.find('.add_field').on('click', getFormForNewField);
					
				
					$.ajax("<?php echo WEBROOT."ajax_domain/getUpdatedMenu"?>").done( function (data2) {
		
						$('#cv_side_menu').html(data2);
						
					});


				} else {
					
					// on affiche un message pour l'utilisateur.
					
					$message = $('<div>').addClass("alert alert-error alert-block").html('<a href="#" class="close" data-dismiss="alert">&times;</a>' + 
						  	'<h4>Erreur!</h4>' +
						  	'<p>Le serveur n\'a pas r&eacute;ussit &aacute; enregistrer le nouveau domaine de comp&eacute;tence...</p>');
					
					$div.after($message);
					
				}

			}
			
		});

		// on remet le boutton de création de nouveau domaine de compétence
		$.ajax("<?php echo WEBROOT."ajax_domain/buttonNewDomain"?>").done( function (data) {

			$div.html(data);
			$div.find('.add_domain').on('click', getFormForNewDomain);
						
		});

		return false;
		
	}


	/**
	 * Récupère le formulaire pour la création d'une nouvelle compétence. AJAX
	 */
	function getFormForNewField() {

		$button = $(this);
		$section = $(this).closest('section');

		var domain_id = $button.data('domain-id');

		console.log(domain_id);
		
		if (domain_id > 0) {
			
			$.post("<?php echo WEBROOT."ajax_field/formForNewField"?>", {'domain_id' : domain_id}).done( function (data) {
		
				if (data.length > 0) {

					$form = $(data);
					
					$section.append($form);
					
					$form.find(':submit').on('click', saveNewField);
					$button.addClass('disabled');

					
				} else {
		
				}
			});

		}

	}

	
	/**
	 * Enregistre le nouveau domaine de compétence. AJAX
	 */
	function saveNewField() {

		alert("save");
		

		false;
	}
	
</script>