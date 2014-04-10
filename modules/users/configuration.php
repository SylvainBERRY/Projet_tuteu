<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page configuration.php
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
if($_SESSION['etape']<2) {
    header('Location:index.php?module=users&action=importation');
}
// Inclusion du modele
include_once CHEMIN_MODELE.'configuration_modele.php';

// Inclusion de la vue
include_once CHEMIN_VUE.'configuration_vue.php';
?>