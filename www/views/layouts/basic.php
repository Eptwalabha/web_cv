<!doctype html>
<html lang="fr">
	<head>
	
		<title>Hello!</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="icon" type="image/png" href="<?php echo WEBROOT; ?>img/en_travaux.png">
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo WEBROOT; ?>js/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
		
		<link type="text/css" rel="Stylesheet" href="<?php echo WEBROOT; ?>js/jquery-ui-1.9.1.custom.css">
		<link type="text/css" rel="Stylesheet" href="<?php echo WEBROOT; ?>css/main.css">
		
	</head>
	
	<body data-spy="scroll" data-target=".bs-docs-sidebar" >
		<?php 
			include("./views/commun/menu.php");
			include("./views/commun/title.php");
		?>
		<div class="container">
		<?php
			
			include("./views/commun/message.php");
		?>
		<?php 
			echo $layout_content;
		?>
		</div>
		<?php
			include("./views/commun/footer.php");
		?>
	</body>
</html>
