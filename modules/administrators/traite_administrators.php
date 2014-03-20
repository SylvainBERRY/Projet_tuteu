<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page traite_administrators.php
*
*Page effectuant les traitement sur la table utilisateurs 
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions données)
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

// Traitement des utilisateurs:
include_once (CHEMIN_MODELE.'administrators_modele.php');
$retour = false;
// Si ajout utilisateur:
if ($_POST['modif_uti'] == 'Nouveau')
{
	$retour = createUti();
	// Création d'un message flash de succes ou d'echec et appel de la fonction de création utilisateur
	if ($retour) {
		setMessageFlash("Vous avez bien créé l'utilisateur ".$_POST['Nom']);
		// Redirection sur la page d'accueil (page de connexion)
		header( 'Location: '.LOGIN_REDIRECT_ADMIN ) ;
	} else {
		setMessageFlash("La création de l'utilisateur ".$_POST['Nom'].' a échoué.');
		// Redirection sur la page d'accueil (page de connexion)
		header( 'Location: '.LOGIN_REDIRECT_ADMIN ) ;
	}
}else {
	// Si modification utilisateur:
	if ($_POST['modif_uti'] == 'Modifier')
	{
		if (modifUti()) {
			setMessageFlash("Vous avez bien modifié l'utilisateur ".$_POST['Nom']);
			// Redirection sur la page d'accueil (page de connexion)
			header( 'Location: '.LOGIN_REDIRECT_ADMIN ) ;
		} else {
			setMessageFlash("La modification de l'utilisateur ".$_POST['Nom'].' a échoué.');
			// Redirection sur la page d'accueil (page de connexion)
			header( 'Location: '.LOGIN_REDIRECT_ADMIN ) ;
		}
	} else {
		// Si suppression utilisateur:
		if ($_POST['modif_uti'] == 'Supprimer')
		{
			if (supprUti()) {
				setMessageFlash("Vous avez bien supprimé l'utilisateur ".$_POST['Nom']);
				// Redirection sur la page d'accueil (page de connexion)
				header( 'Location: '.LOGIN_REDIRECT_ADMIN ) ;
			} else {
				setMessageFlash("La suppression de l'utilisateur ".$_POST['Nom'].' a échoué.');
				// Redirection sur la page d'accueil (page de connexion)
				header( 'Location: '.LOGIN_REDIRECT_ADMIN ) ;
			}
		}
	}
}
?>