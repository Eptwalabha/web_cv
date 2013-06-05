<?php

if (isset($user)) {
	
	$address = "";
	
	// pourquoi faire simple lorsqu'on peut faire compliqué... ;)
	for ($i = 1; $i < 4; $i++) {
		
		$methode = "getUserAddress$i";
		if(method_exists($user, $methode)) {
			$address .= strlen($user->$methode()) > 0 ? $user->$methode()."<br />" : "";
		}
	}
	
	$phones = strlen($user->getUserPhone()) > 0 ? "<i class=\"icon-ok\"></i> <abbr title=\"fixe\">tel</abbr>: ".$user->getUserPhone()."<br />" : "";
	$phones .= strlen($user->getUserCell()) > 0 ? "<i class=\"icon-ok\"></i> <abbr title=\"portable\">tel</abbr>: ".$user->getUserCell()."<br />" : "";
	
	// Met en majuscule les premières lettres des noms composés
	// exemple: "raymond-jean jean de la maison-neuve-lol" deviendra "Raymond-Jean Jean De La Maison-Neuve-Lol" 
	$first_name = "";
	$list_first_name = explode("-", $user->getUserFirstName());
	$first = true;
	foreach ($list_first_name as $part_first_name) {
		
		if (!$first) $first_name .= "-";
		$first_name .= ucwords($part_first_name);
		$first = false;
	}
	
	$last_name = strtoupper($user->getUserLastName());
?>

<address>
	<strong><?php echo $first_name." ".$last_name; ?></strong><br />
	<?php echo $address; ?>
	<?php echo $phones; ?>
	<strong><?php echo $user->getUserZipCode()." "; ?><?php echo strtoupper($user->getUserTown()); ?></strong><br />
</address>
<?php

} else {
?>
<p>
Pas d'adresse disponible.
</p>
<?php 
}
?>