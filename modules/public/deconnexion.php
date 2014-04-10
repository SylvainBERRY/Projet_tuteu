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

unlink(CHEMIN_EXCEL.'notes_'.$_SESSION['id_user'].'.xls');
unlink(CHEMIN_EXCEL.'notes_'.$_SESSION['id_user'].'.xlsx');
unlink(CHEMIN_EXCEL.'mails_'.$_SESSION['id_user'].'.xls');
unlink(CHEMIN_EXCEL.'mails_'.$_SESSION['id_user'].'.xlsx');

$bdd = PDOSingleton::getInstance();

$bdd->query('DELETE FROM note WHERE uti_id = '.$_SESSION['id_user']);
$bdd->query('DELETE FROM etdiant WHERE uti_id = '.$_SESSION['id_user']);

logout();

session_unset();
session_destroy();

// Message flash de succès vous avez bien été déconnecté
setMessageFlash('Vous avez bien été déconnecté(e).');

// Redirection sur la page d'accueil
header( 'Location: '.LOGOUT_REDIRECT ) ;
?>