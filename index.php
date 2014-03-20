<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page index.php
*
*Index du site.
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions donn?es)
*
*Liste des fonctions :
*--------------------------
*Aucune fonction
*--------------------------
*
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

////////////////////
// Initialisation //
////////////////////

include_once('global/init.php');

//////////////////////////
// Affichage pour debug //
//////////////////////////

// Affichage SESSION si debug niveau 1 actif
if (DEBUG_SESSION) {
	echo 'Tableau des variables de session <br>';
	var_dump($_SESSION);
}
// Affichage POST si debug niveau 2 actif
if (DEBUG_POST) {
	echo '<br> Tableau des variables de post <br>';
	var_dump($_POST);
}
// Affichage GET si debug niveau 3 actif
if (DEBUG_GET) {
	echo '<br> Tableau des variables de get <br>';
	var_dump($_GET);
}

//////////////////////////////////////
// Récupération de la page demandée //
//////////////////////////////////////

// Module à prendre en compte (dossier)
$module = DEFAULT_MODULE;

// Action du module à inclure (fichier)
$action = DEFAULT_ACTION;

// Récupération du module
if (!empty($_GET['module'])) {
	$module = $_GET['module'];
}

// Récupération de l'action
if (!empty($_GET['action'])) {
	$action = $_GET['action'];
}

// @todo : déplacer ou vous le voulez
// Afficher les messages flash
var_dump(getMessageFlash());

// Calcul du chemin de la page
$chemin_page = 	dirname(__FILE__).'/'.CHEMIN_MODULE.$module.'/'.$action.'.php';

// Vérification de l'existance de la page
if (is_file($chemin_page)) {

		// Tentative d'accès à l'administration
		if ($module == 'administrators') {
		
			//Vérification de l'authentification de l'administrateur
			if (administrateur_est_connecte()) {

				// Inclusion de la page
				modifTitre('Administration');
				include_once (CHEMIN_MODULE.'administrators/haut_administrators.php');
				include_once ($chemin_page);
				include_once (CHEMIN_MODULE.'administrators/bas_administrators.php');
			}
			else{
				if (utilisateur_est_connecte()) {
				
					// Inclusion de la page de connexion
					modifTitre('Accès interdit');
					include_once (CHEMIN_MODULE.'public/haut_public.php');
					include_once (CHEMIN_MODULE.'public/acces_interdit.php');
					include_once (CHEMIN_MODULE.'public/bas_public.php');
				}
				else {
				
					// Inclusion de la page de connexion
					modifTitre('Connexion');
					include_once (CHEMIN_MODULE.'public/haut_public.php');
					include_once (CHEMIN_MODULE.'public/connexion.php');
					include_once (CHEMIN_MODULE.'public/bas_public.php');
				}
			}
		}

		// Tentative d'accès à l'espace membre
		else if ($module == 'users') {

			//Vérification de l'authentification de l'utilisateur
			if (utilisateur_est_connecte()) {
			
				// Inclusion de la page
				modifTitre('Importation');
				include_once (CHEMIN_MODULE.'users/haut_users.php');
				include_once ($chemin_page);
				include_once (CHEMIN_MODULE.'users/haut_users.php');
			}
			else{
			
				// Inclusion de la page de connexion
				modifTitre('Connexion');
				include_once (CHEMIN_MODULE.'public/haut_public.php');
				include_once (CHEMIN_MODULE.'public/connexion.php');
				include_once (CHEMIN_MODULE.'public/bas_public.php');
			}

		// Tentative d'accès à l'espace public
		} else {

			// Inclusion de la page
			modifTitre('Connexion');
			include_once (CHEMIN_MODULE.'public/haut_public.php');
			include_once ($chemin_page);
			include_once (CHEMIN_MODULE.'public/bas_public.php');

		}

// Sinon, on affiche la page d'erreur 404 !
} else {

	// Inclusion erreur 404
	modifTitre('Erreur 404');
	include_once (CHEMIN_MODULE.'public/haut_public.php');
	include_once (CHEMIN_MODULE.'public/erreur404.php');
	include_once (CHEMIN_MODULE.'public/bas_public.php');
}
?>
