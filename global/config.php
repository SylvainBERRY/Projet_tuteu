<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page config.php
*
*Définit les variables de bases qui vont être utilisé dans toutes l'application
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions donn?es)
*
*Liste des fonctions :
*--------------------------
*Aucune fonction
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

// Confgiuration developpement
define('DEBUG_SESSION', false);
define('DEBUG_POST', false);
define('DEBUG_GET', false);
define('DEBUG_AUTO_UTI', false);

// Informations relatives au site
define('ROOTPATH', 'http://'.$_SERVER['HTTP_HOST'].'/GitHub/Projet_tuteu', true);
define('TITRESITE', 'Gestion note', true);
$titre_head = 'GetNote';

// Chemins d'accès
define('CHEMIN_MODELE', 'modeles/');
define('CHEMIN_VUE', 'vues/');
define('CHEMIN_MODULE', 'modules/');
define('CHEMIN_LIB', 'libs/');
define('CHEMIN_JS', 'js/');
define('CHEMIN_STYLE', 'styles/');
define('CHEMIN_IMAGE', 'images/');
define('CHEMIN_USERS', 'users/');
define('CHEMIN_PUBLIC', 'public/');
define('CHEMIN_ADMINISTRATORS', 'administrators/');
define('CHEMIN_EXCEL', 'excels/');


// Configuration de la base de données
define('DB_NAME', 'getnotes');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');

// Configuration redirections
define('LOGIN_REDIRECT','index.php?module=users&action=importation');
define('INSCRIPTION_REDIRECT', 'index.php?module=public&action=inscription');
define('LOGIN_REDIRECT_ADMIN','index.php?module=administrators&action=accueil_administrators');
define('LOGOUT_REDIRECT','index.php?module=public&action=connexion');
define('LOGIN_REDIRECT_INSCRIPTION','index.php?module=public&action=inscription');
define('LOGIN_REDIRECT_PROFIL','index.php?module=public&action=profil');
define('LOGOUT','index.php?module=public&action=deconnexion');

// Sécurité
// Modifier lors de l'installation (différent du git) et ne plus le toucher
define ('SALT1', 'lkjedazLKNg24gtr6e54z');
define ('SALT2', 'mnkerz65khUCvz');

// Message flash (session)
define ('MESSAGE_FLASH', 'Message_flash');
define ('MESSAGE_FLASH_DEFAULT', 'default');
define ('MESSAGE_FLASH_ERREUR', 'erreur');

//Configuration variable de test pour l'inscription
define ('TOOSHORT','tooshort');
define ('TOOLONG','toolong');
define ('VIDE','vide');
define ('EXISTS', 'exists');
define ('OK','ok');
define ('NOFIGURE', 'nofigure');
define ('NOUPCAP', 'noupcap');
define ('DIFFERENT', 'different');
define ('ISNT', 'isnt');

// Configuration page par défaut
define ('DEFAULT_ACTION','connexion');
define ('DEFAULT_MODULE','public');
define ('DEFAULT_ACTION_ADMIN','accueil_administrators');

?>
