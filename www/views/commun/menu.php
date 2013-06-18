<?php 

	$menu = isset($active_menu)? $active_menu : "";
	
	$name = "<inconnu>";
	
	$user_menu = new user();
	$user_menu->readFromID(1);
	
	$first_name = "";
	$list_first_name = explode("-", $user_menu->getUserFirstName());
	$first = true;
	foreach ($list_first_name as $part_first_name) {
	
		if (!$first) $first_name .= "-";
		$first_name .= ucwords($part_first_name);
		$first = false;
	}
	
	$last_name = strtoupper($user_menu->getUserLastName());
	$name = $last_name." ".$first_name;
	
?>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="brand" href="<?php echo WEBROOT; ?>"><?php echo $name;?></a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li<?php if($menu == MENU_ACCUEIL) echo " class=\"active\""; ?> title="accueil du site"><a href="<?php echo WEBROOT."accueil" ?>">Accueil</a></li>
					<li<?php if($menu == MENU_BLOG) echo " class=\"active\""; ?> title="mon blog"><a href="<?php echo WEBROOT."blog" ?>">Blog</a></li>
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
