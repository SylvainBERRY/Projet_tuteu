<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page envoi.php
*
*Page pour l'envoi des mails.
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
if($_SESSION['etape']<3) {
    header('Location:index.php?module=users&action=importation');
}

// Inclusion du modele pour l'envoi
include_once CHEMIN_MODELE.'envoi_modele.php';

// Inclusion de la vue pour l'envoi
include_once CHEMIN_VUE.'envoi_vue.php';
?>