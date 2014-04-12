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

foreach (array_keys($_POST) as $checkbox) 
{
    if(preg_match("/checkbox/", $checkbox))    $checkboxs[]=preg_replace("/checkbox_/","",$checkbox);
}

if (!isset($checkboxs)) 
{
	header('Location:index.php?module=users&action=configuration');
}

// Inclusion du modele pour l'envoi
include_once CHEMIN_MODELE.'envoi_modele.php';

// Inclusion de la vue pour l'envoi
include_once CHEMIN_VUE.'envoi_vue.php';
?>