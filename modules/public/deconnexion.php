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

// Faire une déconnexion de l'utilisateur
logout();

// Création message flash de succès
setMessageFlash('Vous avez bien été déconnecté(e).');

// Redirection sur la page d'accueil (page de connexion)
header( 'Location: '.LOGOUT_REDIRECT ) ;
?>
