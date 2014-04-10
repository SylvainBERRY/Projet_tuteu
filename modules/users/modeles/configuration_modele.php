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

$bdd = PDOSingleton::getInstance();

// @todo : modifier en récupérant l'instance PDO
//$bdd = PDOSingleton::getInstance();
$info_etudiants = $bdd->query('SELECT id_etud, nom, prenom, mail1, mail2  FROM etudiant WHERE uti_id = '.$_SESSION['id_user']);
$types_notes = $bdd->query('SELECT DISTINCT type_note FROM note WHERE uti_id = '.$_SESSION['id_user']);

echo $_SESSION['upload_mails'];
?>