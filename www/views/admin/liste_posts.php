<tr>
	<td>
	<?php 
		$date = $post->getBlogPostDate();
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