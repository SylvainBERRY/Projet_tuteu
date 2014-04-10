<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page fonctions_importation.php
*
*Page modele pour l'administrateur
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions données)
*
*Liste des fonctions :
*--------------------------
*lectureExcel($url) [Lit le fichier Excel renseigné]
*rechercheColonne($feuille) []
*sauvgEtudBd($tab_noms,$tab_prenoms,$tab_mails1,$tab_mails2) []
*sauvgNoteBd($tab_noms,$tab_prenoms,$tab_notes,$type_notes) []
*effacerContenuTable($table) []
*lireColonne($feuille,$coord_cell) []
*erreurUpload($nom_fichier) []
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function lectureExcel($url)
{
	require_once CHEMIN_LIB.'PHPExcel/IOFactory.php';
	$fichier_excel = PHPExcel_IOFactory::load($url);
	$feuille = $fichier_excel->getSheet(0);
	return $feuille;
}

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
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

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function sauvgEtudBd($tab_noms,$tab_prenoms,$tab_mails1,$tab_mails2)
{
	global $bdd;

	$nb_etud=count($tab_noms);

	for ($i=0; $i < $nb_etud ; $i++) 
	{ 
		$bdd->query('INSERT INTO etudiant VALUES ("","'.$tab_noms[$i].'","'.$tab_prenoms[$i].'","'.$tab_mails1[$i].'","'.$tab_mails2[$i].'","'.$_SESSION['id_user'].'")');
	}
}

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function sauvgNoteBd($tab_noms,$tab_prenoms,$tab_notes,$type_notes)
{
	global $bdd;

	$nb_etud=count($tab_noms);

	for ($i=0; $i < $nb_etud ; $i++)
	{ 
		$resultat=$bdd->query('SELECT id_etud FROM etudiant WHERE nom="'.$tab_noms[$i].'" AND prenom="'.$tab_prenoms[$i].'" AND uti_id = "'.$_SESSION['id_user'].'"');
		$id_etud=$resultat->fetch()[0]; // A revoir à la fin du fetch()[0] erreur de parseur
		for ($j=0; $j < count($type_notes) ; $j++)
		{
			$bdd->query('INSERT INTO note VALUES ('.$id_etud.',"'.$type_notes[$j].'","'.$tab_notes[$j][$i].'","'.$_SESSION['id_user'].'")');
		}
	}
}

/**
 * @todo : commenter la fonction
 * @return array | $feuille
 */
function effacerContenuTable($table)
{
	global $bdd;

	$bdd->query('DELETE FROM '.$table.' WHERE uti_id ='.$_SESSION['id_user']);
}

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
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

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function erreurUpload($nom_fichier,$type)
{
	$extensions_valides = array( 'xls' , 'xlsx');
    $extension_upload = strtolower(substr(strrchr($_FILES[$nom_fichier]['name'], '.'),1));
    $taille_max=2097152;

	if ($_FILES[$nom_fichier]['error'])
	{
		switch ($_FILES[$nom_fichier]['error'])
		{
			case 1: // UPLOAD_ERR_INI_SIZE	taille autorisée par le serveur
				setMessageFlash($type." : La taille du fichier dépasse la limite autorisée par le serveur !","upload");
			break;
			case 2: // UPLOAD_ERR_FORM_SIZE	taille autorisée dans formulaire
				setMessageFlash($type." : La taille du fichier dépasse la limite autorisée par le formulaire !","upload");
			break;
			case 3: // UPLOAD_ERR_PARTIAL
				setMessageFlash($type." : L'envoi du fichier a été interrompu pendant le transfert !","upload");
			break;
			case 4: // UPLOAD_ERR_NO_FILE
				setMessageFlash($type." : Le fichier que vous avez envoyé a une taille nulle !","upload");
			break;
		}
		return true;
 	}
 	elseif($_FILES[$nom_fichier]['size'] > $taille_max)
 	{
 		setMessageFlash($type." : Le fichier dépasse la limite autorisée !","upload");
 		return true;
 	}
 	elseif (!in_array($extension_upload,$extensions_valides))
 	{
 		setMessageFlash($type." : Extension incorrecte !","upload");
 		return true;
 	}

 	return false;
}
?>
