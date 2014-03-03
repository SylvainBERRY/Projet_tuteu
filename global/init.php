<?php

// Inclusion du fichier de configuration (qui définit des constantes)
include_once 'global/config.php';

// Header
header('Content-type: text/html; charset=utf-8');

// Inclusion du singleton PDO
include_once('libs/PDOSingleton.php');

// Inclusion des fonctions communes et fréquement utilisées
include_once('global/global_functions.php');

// Démarrage de la session
session_start();

?>
