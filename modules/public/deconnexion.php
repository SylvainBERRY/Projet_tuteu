<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page deconnexion.php
*
*Page de deconnexion par defaut.
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

// Fait une déconnexion de l'utilisateur
logout();

// Message flash de succès vous avez bien été déconnecté
setMessageFlash('Vous avez bien été déconnecté(e).');

// Redirection sur la page d'accueil
header( 'Location: '.LOGOUT_REDIRECT ) ;
?>