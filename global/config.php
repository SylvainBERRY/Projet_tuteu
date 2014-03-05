<?php
/*
BERRY Sylvain & El-Hocine Takouert
Page config.php

Deux define et la variable de queries.

Quelques indications : (utiliser l'outil de recherche et rechercher les mentions donn?es)

Liste des fonctions :
--------------------------
Aucune fonction
--------------------------


Liste des informations/erreurs :
--------------------------
Aucune information/erreur
--------------------------
*/

// Confgiuration developpement
define('DEBUG', true);

// Informations relatives au site
define('ROOTPATH', 'http://'.$_SERVER['HTTP_HOST'].'/GitHub/Projet_tuteu', true);
define('TITRESITE', 'Gestion note', true);

// Chemins d'accès
define('CHEMIN_MODELE', 'modeles/');

// Configuration de la base de données
define('DB_NAME', 'getnotes');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');

// Configuration redirections
define('LOGIN_REDIRECT','index.php?module=users&action=accueil');
define('LOGOUT_REDIRECT','index.php');

// Sécurité
// Modifier lors de l'installation (différent du git) et ne plus le toucher
define ('SALT1', 'lkjedazLKNg24gtr6e54z');
define ('SALT2', 'mnkerz65khUCvz');

// Message flash (session)
define ('MESSAGE_FLASH', 'Message_flash');
define ('MESSAGE_FLASH_DEFAULT', 'default');

//Configuration variable de test pour l'inscription
define ('TOOSHORT','tooshort');
define ('TOOLONG','toolong');
define ('VIDE','vide');
define ('EXISTS', 'exists');
define ('OK','ok');
define ('NOFIGURE', 'nofigure');
define ('NOUPCAP', 'noupcap');
define ('DIFFERENT', 'different');

$queries = 0;

?>
