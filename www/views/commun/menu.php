<?php 

	$menu = isset($active_menu)? $active_menu : 'nope';
?>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="brand" href="<?php echo WEBROOT; ?>">GABRIELLE Damien</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li<?php if($menu == MENU_ACCUEIL) echo " class=\"active\""; ?> title="accueil du site"><a href="<?php echo WEBROOT."accueil" ?>">Accueil</a></li>
					<li<?php if($menu == MENU_CV) echo " class=\"active\""; ?> title="mon curriculum vit&aelig;"><a href="<?php echo WEBROOT."cv" ?>">CV</a></li>
					<li<?php if($menu == MENU_CONTACT) echo " class=\"active\""; ?> title="je ne mords pas"><a href="<?php echo WEBROOT."contact" ?>">Me contacter</a></li>
<?php 
if (isset($_SESSION['admin_en_ligne'])) {
?>
					<li<?php if($menu == MENU_ADMIN) echo " class=\"active\""; ?> title="administration"><a href="<?php echo WEBROOT."admin" ?>">Administration</a></li>
<?php 
}
?>
				</ul>
			</div>
		</div>
	</div>
</div>
