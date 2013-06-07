<div id="respond">
</div>
<div class="row">
	<div class="span7">
		<h3>Nouveau post</h3>
		<form action="<?php echo WEBROOT."admin/publishPost"; ?>" method="post" data-id-post="" id="form_new_post">
			<div>
				<input id="form_new_post_title" type="text" name="post_title" placeholder="Titre du post" class="span4"/>
				<select id="form_new_post_type" class="span4" >
				<?php 

					$blog_type = new blog_type();
					$blog_list = $blog_type->getAllBlogType();
				
					foreach ($blog_list as $type) {
				?>
					<option value="<?php echo $type->getBlogTypeID(); ?>"><?php echo $type->getBlogTypeTitle(); ?></option>
				<?php
					}
				?>
				</select>
				<textarea id="form_new_post_text" rows="8" name="post_text" placeholder="Votre texte" class="span7"></textarea><br />
			</div>
			<div class="input-append">
				<input id="form_new_tag_text" type="text" name="tag_name" placeholder="nom du tag"  class="span4" />
				<button id="b_new_tag" class="btn" type="button" title="ajouter le tag"><i class="icon-tags"></i> <i class="icon-plus"></i></button>
			</div>
			<div>
				<p id="tag_info"></p>
				<p id="tags_list"></p>
			</div>
			<div>
				<button id="b_publish" class="btn btn-success" type="button" title="publier le post!"><i class="icon-white icon-thumbs-up"></i> Publier!</button>
				<button id="b_save" class="btn" type="button" title="enregistrer le post"><i class="icon-inbox"></i> Sauvegarder</button>
			</div>
		</form>
	</div>
	<div class="span5">
		<h3>Sauvegardes</h3>
		<div id="saved_post_panel">
			<?php 
			include("./views/admin/saved_post_panel.php");
			?>
		</div>
	</div>
</div>
<script>

	$( function() {

		majSavedPostPanel();
		$('#b_new_tag').on('click', ajouterTag);
		$('#b_publish').on('click', sendPost);
		$('#b_save').on('click', sendPost);
		
	});

	function supprimerTag() {
		$(this).remove();
		if ($('#tags_list span').size() == 0) $('#tag_info').html('');
	}

	function ajouterTag() {
		
		var tag_name = $('#form_new_tag_text').val().toLowerCase().trim();
		if (tag_name.length > 0) {
			var liste_tag = $('#tags_list span');
			var exists = false;
			
			liste_tag.each( function () {
				if ($(this).data('tag-name').toLowerCase().trim() == tag_name) exists = true;
			});
			
			if (!exists) {
	
				var tag = $("<span>").addClass('label label-info').attr('title', tag_name).data('tag-name', tag_name).html(tag_name);
				$('#tags_list').append(tag).append(' ');
				$('#form_new_tag_text').val('');
				tag.on('dblclick', supprimerTag);
			}
	
			if ($('#tags_list span').size() > 0) $('#tag_info').html('Pour supprimer un tag, double-cliquer le.');
		}
	}
		
	function sendPost() {

		var titre = $('#form_new_post_title').val();
		var texte = $('#form_new_post_text').val();
		var type = $('#form_new_post_type option:selected').val();
		var state;

		switch($(this).attr('id')) {
			case 'b_publish':
				state = 1;
				break;
			case 'b_save' :
				state = 2;
				break;
			default :
				state = 2;
				break;	
		}
		
		if (titre.length > 0 && texte.length > 0 ) {
			
			$.ajax({
				type: 'POST',
				url: '<?php echo 'http://localhost'.WEBROOT.'admin/publishPost'; ?>',
				data: {
					post_title : titre,
					post_text : texte,
					post_type : type,
					post_state : state
				} 
			}).done( function(data) {
				$('#respond').html(data);
				majSavedPostPanel();
				
			}).fail( function(data) {
				console.log('fail');
				console.log(data);
			});

		} else {
			$('#respond').html("un des champs est vide");
		}
	}

	function majSavedPostPanel() {


		$.ajax({
			type: 'POST',
			url: '<?php echo WEBROOT.'admin/listeSavedBlogPost'; ?>' 
		}).done( function(data) {
			$('#saved_post_panel').html(data);
			$('.btn_delete').on('click', deletePost);
			
		}).fail( function(data) {
			console.log('fail');
			console.log(data);
		});

	}

	function deletePost() {
		
		var id = $(this).data('post-id');

		if (id > 0) {
			
			$.ajax({
				type: 'POST',
				url: '<?php echo 'http://localhost'.WEBROOT.'admin/deletePost'; ?>',
				data: { post_id : id }
			}).done( function(data) {
				$('#respond').html(data);
				majSavedPostPanel();
				
			}).fail( function(data) {
				console.log('fail');
				console.log(data);
			});

		} else {
			alert('prob');
		}
		
	}

</script>