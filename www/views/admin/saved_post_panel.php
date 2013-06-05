<?php

	$nbr_saved_post = isset($list_posts)? count($list_posts) : 0;
	if ($nbr_saved_post) {
?>
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>date</th>
			<th>titre</th>
			<th>action</th>
		<tr>
	</thead>
	<tbody>
<?php
		
		foreach ($list_posts as $post) {
?>
		<tr>
			<td>
			<?php
				echo $post->getBlogPostDate();
			?>
			</td>
			<td>
			<?php
				$title = $post->getBlogPostTitle();
				if (strlen($title) > 30)
					$title = substr($title, 0, 30)."...";
		
				echo $title;
			?>
			</td>
			<td>
			<?php 
				$id = $post->getBlogPostId();
			?>
				<button class="btn btn-mini btn_edit" type="button" data-post-id="<?php echo $id; ?>" title="&eacute;diter"><i class="icon-pencil"></i></button>
				<button class="btn btn-mini btn_publish" type="button" data-post-id="<?php echo $id; ?>" title="publier"><i class="icon-share"></i></button> 
				<button class="btn btn-mini btn_delete" type="button" data-post-id="<?php echo $id; ?>" title="supprimer"><i class="icon-trash"></i></button>
			</td>
		</tr>
<?php
		}
?>
	</tbody>
</table>
<?php 
	} else {
?>
<p>Pas de sauvegarde pour le moment.</p>
<?php 
	}
?>