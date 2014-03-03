<?php
/*
BERRY Sylvain & El-Hocine Takouert
Page index.php

Index du site.

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

////////////////////
// Initialisation //
////////////////////
include_once('global/init.php');

// Affichage session si debug
if (DEBUG) {
	var_dump($_SESSION);
}

// include_once('includes/fonctions.php');
// connexionbdd();
// actualiser_session();
$titre = 'Accueil';

//////////////////////////////////////
// Récupération de la page demandée //
//////////////////////////////////////

// Module à prendre en compte (dossier)
$module = 'public';
// Action du module à inclure (fichier)
$action = 'accueil';

// Récupération du module
if (!empty($_GET['module'])) {
	$module = $_GET['module'];
}

// Récupération de l'action
if (!empty($_GET['action'])) {
	$action = $_GET['action'];
}

// Calcul du chemin de la page
$chemin_page = 	dirname(__FILE__).'/modules/'.$module.'/'.$action.'.php';

// Vérification de l'existance de la page
if (is_file($chemin_page)) {

		// Tentative d'accès à l'administration
		if ($module == 'administrators') {

			//Vérification de l'authentification de l'administrateur
			if (administrateur_est_connecte()) {
				// Inclusion de la page
				include_once 'global/haut.php';
				include_once $chemin_page;
				include_once 'global/bas.php';
			}
			else{

				if (utilisateur_est_connecte()) {
					// Inclusion de la page de connexion
					include_once 'global/haut.php';
					include_once 'modules/public/acces_interdit.php';
					include_once 'global/bas.php';
				}
				else {
					// Inclusion de la page de connexion
					include_once 'global/haut.php';
					include_once 'modules/public/connexion.php';
					include_once 'global/bas.php';
				}
			}
		}

		// Tentative d'accès à l'espace membre
		else if ($module == 'users') {

			//Vérification de l'authentification de l'utilisateur
			if (utilisateur_est_connecte()) {
				// Inclusion de la page
				include_once 'global/haut.php';
				include_once $chemin_page;
				include_once 'global/bas.php';
			}
			else{
				// Inclusion de la page de connexion
				include_once 'global/haut.php';
				include_once 'modules/public/connexion.php';
				include_once 'global/bas.php';
			}

		// Tentative d'accès à l'espace public
		} else {

			// Inclusion de la page
			include_once 'global/haut.php';
			include_once $chemin_page;
			include_once 'global/bas.php';

		}

// Sinon, on affiche la page d'erreur 404 !
} else {

	// Inclusion erreur 404
	include_once 'global/haut.php';
	include_once 'modules/public/erreur404.php';
	include_once 'global/bas.php';

}


//	Si page administrateur => vérifier session admin
//	Si page users => vérifier session users
//	Si page publique => pas de vérification
// 	inclue

/**********Fin ent?te et titre***********/
?>
<!-- 		<div id="contenu">
			<div id="map">
				<a href="index.php">Accueil</a>
			</div>

			<h1>Bienvenue sur l'application Gestion de Notes</h1>
			<p>
			Si se n'est pas encore fait il faut vous <a href="utilisateurs/inscription.php">inscrire</a>
			</p>
		</div>

 -->
<?php
		// mysql_close();
?>
