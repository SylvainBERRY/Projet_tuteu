<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page apercu_modele.php
*
*Page modele pour l'aperçu utilisateur
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

$bdd = PDOSingleton::getInstance();

foreach (array_keys($_POST) as $checkbox) 
{
    if(preg_match("/checkbox/", $checkbox))    $checkboxs[]=preg_replace("/checkbox_/","",$checkbox);
}

$num_etud='(';

foreach($checkboxs as $num)
{
    $num_etud.=$num.',';
}

$num_etud=trim($num_etud,',');

$num_etud.=')';

$etudiants=$bdd->query('SELECT * FROM etudiant WHERE id_etud IN '.$num_etud);

$notes=$bdd->query('SELECT * FROM note WHERE id_etud IN '.$num_etud);

?>