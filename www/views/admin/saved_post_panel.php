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

			$raw_date = $post->getRawBlogPostDate();
			
			$liste = explode(' ', $raw_date);
			$dates = explode('-', $liste[0]);
			
			$date = $dates[2].'-'.$dates[1].'-'.$dates[0];
			
			$heures = isset($liste[1])? explode(':', $liste[1]) :  explode(':', '00:00:00');
			$heure = $heures[0].'h'.$heures[1];
?>
		<tr>
			<td title="<?php echo $heure; ?>">
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