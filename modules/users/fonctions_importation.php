<?php

function lectureExcel($url)
{
	require_once CHEMIN_LIB.'PHPExcel/IOFactory.php';
	$fichier_excel = PHPExcel_IOFactory::load($url);
	$feuille = $fichier_excel->getSheet(0);
	return $feuille;
}

function rechercheColonne($feuille)
{
	foreach($feuille->getRowIterator() as $ligne) 
	{
		foreach ($ligne->getCellIterator() as $cell) 
		{
			if(preg_match('#^nom$#i', trim($cell->getValue())))
			{
				$coord_cell=$cell->getColumn().($cell->getRow()+1);
				goto quitter;
			}

		}
	}
	quitter:
	return $coord_cell;
}

function sauvgEtudBd($tab_noms,$tab_prenoms,$tab_mails1,$tab_mails2)
{
	global $bdd;

	$nb_etud=count($tab_noms);

	for ($i=0; $i < $nb_etud ; $i++) 
	{ 
		$bdd->query('INSERT INTO etudiant VALUES ("","'.$tab_noms[$i].'","'.$tab_prenoms[$i].'","'.$tab_mails1[$i].'","'.$tab_mails2[$i].'")');
	}
}

function sauvgNoteBd($tab_noms,$tab_prenoms,$tab_notes,$type_notes)
{
	global $bdd;

	$nb_etud=count($tab_noms);

	for ($i=0; $i < $nb_etud ; $i++)
	{ 
		$resultat=$bdd->query('SELECT id_etud FROM etudiant WHERE nom="'.$tab_noms[$i].'" and prenom="'.$tab_prenoms[$i].'"');
		$id_etud=$resultat->fetch()[0];
		
		for ($j=0; $j < count($type_notes) ; $j++)
		{
			$bdd->query('INSERT INTO note VALUES ('.$id_etud.',"'.$type_notes[$j].'",'.intval($tab_notes[$j][$i]).')');
		}
	}
}


function effacerContenuTable($table)
{
	global $bdd;

	$bdd->query('DELETE FROM '.$table);
}

function lireColonne($feuille,$coord_cell)
{
	$index_col=$coord_cell[0];
	$num_ligne=intval($coord_cell[1]);
	$tab=array();
	while (trim($cell_valeur=$feuille->getCell($index_col.$num_ligne)->getValue())!='')
	{ 
		$tab[]=$cell_valeur;
		$num_ligne++;
	}
	return $tab;
}

function erreurUpload($nom_fichier)
{
	$extensions_valides = array( 'xls' , 'xlsx');
    $extension_upload = strtolower(substr(strrchr($_FILES['excel_mails']['name'], '.'),1));
    $taille_max=2097152;

	if ($_FILES[$nom_fichier]['error']) 
	{     
		switch ($_FILES[$nom_fichier]['error'])
		{     
			case 1: // UPLOAD_ERR_INI_SIZE	taille autorisée par le serveur 
				echo "La taille du fichier dépasse la limite autorisée par le serveur !"; 
			break;       
			case 2: // UPLOAD_ERR_FORM_SIZE	taille autorisée dans formulaire   
				echo "La taille du fichier dépasse la limite autorisée par le formulaire !"; 
			break;     
			case 3: // UPLOAD_ERR_PARTIAL     
				echo "L'envoi du fichier a été interrompu pendant le transfert !";     
			break;     
			case 4: // UPLOAD_ERR_NO_FILE     
				echo "Le fichier que vous avez envoyé a une taille nulle !"; 
			break;
		}
		return true;
 	}
 	elseif($_FILES[$nom_fichier]['size'] > $taille_max)
 	{
 		echo "Le fichier dépasse la limite autorisée !"; 
 		return true;
 	}
 	elseif (!in_array($extension_upload,$extensions_valides))
 	{
 		echo "Extension incorrecte !";
 		return true;
 	}

 	return false;
}  

?>