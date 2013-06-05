<?php

define('WEBROOT', str_replace("index.php", "", $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']));

define('DB_DNS', 'localhost');
define('DB_NAME', 'wcv');
define('DB_LOGIN', 'wcv_admin');
define('DB_PSW', 'xzKLsANSN8GeWdH3');

define('MENU_ACCUEIL', 0);
define('MENU_CV', 1);
define('MENU_CONTACT', 2);
define('MENU_BLOG', 3);
define('MENU_ADMIN', 4);

define('MSG_ERROR', 0);
define('MSG_SUCCESS', 1);
define('MSG_INFO', 2);
define('MSG_WARNING', 3);

// mettre l'email de l'utilisateur.
define('EMAIL', 'damien.gabrielle@epsi.fr');
