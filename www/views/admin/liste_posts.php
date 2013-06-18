<?php 
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
		echo $date;
	?>
	</td>
	<td>
	<?php
		$title = $post->getBlogPostTitle();
		if (strlen($title) > 20)
			$title = substr($title, 0, 20)."...";
		
		echo $title;
	?>
	</td>
	<td>
	<?php 
		$id = $post->getBlogPostId();
	?>
		<button class="btn btn-primary btn-mini btn_edit" type="button" data-post-id="<?php echo $id; ?>"><i class="icon-white icon-pencil"></i></button>
		<button class="btn btn-danger btn-mini btn_delete" type="button" data-post-id="<?php echo $id; ?>"><i class="icon-white icon-minus"></i></button>
		<?php 
	
	?>
	</td>
</tr>