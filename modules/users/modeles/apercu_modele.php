<?php

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=getnotes', 'root', '');
}
catch (Exception $exp)
{
    die('Erreur : ' . $exp->getMessage());
}

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