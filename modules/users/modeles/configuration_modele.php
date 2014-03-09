<?php

  try
  {
      $bdd = new PDO('mysql:host=localhost;dbname=getnotes', 'root', '');
  }
  catch (Exception $exp)
  {
      die('Erreur : ' . $exp->getMessage());
  }

  $info_etudiants = $bdd->query('SELECT id_etud, nom, prenom, mail1, mail2  FROM etudiant');
  $types_notes = $bdd->query('SELECT DISTINCT type_note FROM note');

?>
