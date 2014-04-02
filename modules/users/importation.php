<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page importation.php
*
*Page d'accueil de l'utilisateur.
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
// Inclusion du modèle utilisateur, importation et des fonctions d'importation
include_once (CHEMIN_MODULE.CHEMIN_PUBLIC.CHEMIN_MODELE.'users_modele.php');

include_once ('fonctions_importation.php');

include_once (CHEMIN_MODELE.'importation_modele.php');


if(isset($_POST['valider'])) {
    header('Location:index.php?module=users&action=configuration');
}

include_once CHEMIN_VUE.'importation_vue.php';

?>
