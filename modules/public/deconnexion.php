<?php
// Faire une déconnexion de l'utilisateur
logout();
// @todo mettre un message flash
// Redirection sur la page d'accueil
header( 'Location: '.LOGOUT_REDIRECT ) ;
?>
