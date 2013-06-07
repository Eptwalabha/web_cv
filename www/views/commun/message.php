<?php

if (isset($messages)) {
	
	foreach ($messages as $message) {
		
		$title = strlen($message['title']) ? "<h4>".$message['title']."</h4>" : "";
		$text = strlen($message['text']) ? "<p>".$message['text']."</p>" : "";
		
		switch ($message['type']) {
			
			case MSG_ERROR:
				$type = "alert-error ";
				break;
			case MSG_INFO:
				$type = "alert-info ";
				break;
			case MSG_SUCCESS:
				$type = "alert-success ";
				break;
			default:
				$type = "";
		}
		
		?>
<div class="alert <?php echo $type; ?>alert-block">
	<?php
		if ($message['closable']) {
	?>
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<?php 
		}
		
		echo $title;
		
		echo $text;
		
	?>
</div>
	<?php
	}
	
}