<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page init.php
*
*Page d'initialisation qui inclué toutes les pages de base config.php ...
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

// Inclusion du fichier de configuration (qui définit des constantes)
include_once ('global/config.php');

// Header
header('Content-type: text/html; charset=utf-8');

// Inclusion du singleton PDO
include_once(CHEMIN_LIB.'PDOSingleton.php');

// Inclusion des fonctions communes et fréquement utilisées
include_once('global/global_functions.php');

// Démarrage de la session
session_start();

?>
