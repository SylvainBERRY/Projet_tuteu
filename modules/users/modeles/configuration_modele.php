<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page configuration_modele.php
*
*Page modele pour la configuration utilisateur
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
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=getnotes', 'root', '');
}
catch (Exception $exp)
{
    die('Erreur : ' . $exp->getMessage());
}
// @todo : modifier en récupérant l'instance PDO
//$bdd = PDOSingleton::getInstance();
$info_etudiants = $bdd->query('SELECT id_etud, nom, prenom, mail1, mail2  FROM etudiant');
$types_notes = $bdd->query('SELECT DISTINCT type_note FROM note');

?>