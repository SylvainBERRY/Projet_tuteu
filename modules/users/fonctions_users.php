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
*sauvgNoteBd($tab_noms,$tab_prenoms,$tab_notes1,$tab_notes2) []
*sauvgNoteBd1($tab_noms,$tab_prenoms,$tab_notes,$type_notes) []
*effacerContenuTable($table) []
*afficherEtudiant($tab_noms,$tab_prenoms,$tab_mails1,$tab_mails2) []
*afficherNote($tab_noms,$tab_prenoms,$tab_notes1,$tab_notes2) []
*afficherNote1($tab_noms,$tab_prenoms,$tab_notes,$type_notes) []
*lireColonne($feuille,$coord_cell) []
*erreurUpload($nom_fichier) []
*afficherTable() []
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

// @todo : utilisation du PDO Singleton
//$bdd = PDOSingleton::getInstance();
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=getnotes', 'root', '');
}
catch (Exception $exp)
{
    die('Erreur : ' . $exp->getMessage());
}

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function lectureExcel($url)
{
	require_once '../../libs/PHPExcel/IOFactory.php';
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
		$bdd->query('INSERT INTO etudiant VALUES ("","'.$tab_noms[$i].'","'.$tab_prenoms[$i].'","'.$tab_mails1[$i].'","'.$tab_mails2[$i].'")');
	}
}

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function sauvgNoteBd($tab_noms,$tab_prenoms,$tab_notes1,$tab_notes2)
{
	global $bdd;

	$nb_etud=count($tab_noms);

	for ($i=0; $i < $nb_etud ; $i++)
	{ 
		$resultat=$bdd->query('SELECT id_etud FROM etudiant WHERE nom="'.$tab_noms[$i].'" and prenom="'.$tab_prenoms[$i].'"');
		$id_etud=$resultat->fetch()[0];
		$bdd->query('INSERT INTO note VALUES ('.$id_etud.',"note1",'.intval($tab_notes1[$i]).')');
		$bdd->query('INSERT INTO note VALUES ('.$id_etud.',"note2",'.intval($tab_notes2[$i]).')');
	}
}

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function sauvgNoteBd1($tab_noms,$tab_prenoms,$tab_notes,$type_notes)
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

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function effacerContenuTable($table)
{

	global $bdd;

	$bdd->query('DELETE FROM '.$table);
}

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function afficherEtudiant($tab_noms,$tab_prenoms,$tab_mails1,$tab_mails2)
{
	$nb_etud=count($tab_noms);

	echo '<table border="1">';
	echo '<thead><tr><th>Nom</th><th>Prenom</th><th>Mail 1</th><th>Mail 2</th></tr></thead>';
	echo '<tbody>';
	for ($i=0; $i < $nb_etud ; $i++)
	{
		echo '<tr>';
		echo '<td>'.$tab_noms[$i].'</td>';
		echo '<td>'.$tab_prenoms[$i].'</td>';
		echo '<td>'.$tab_mails1[$i].'</td>';
		echo '<td>'.$tab_mails2[$i].'</td>';
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
}

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function afficherNote($tab_noms,$tab_prenoms,$tab_notes1,$tab_notes2)
{
	$nb_etud=count($tab_noms);

	echo '<table border="1">';
	echo '<thead><tr><th>Nom</th><th>Prenom</th><th>Note CC</th><th>Note Examen</th></tr></thead>';
	echo '<tbody>';
	for ($i=0; $i < $nb_etud ; $i++) 
	{
		echo '<tr>';
		echo '<td>'.$tab_noms[$i].'</td>';
		echo '<td>'.$tab_prenoms[$i].'</td>';
		echo '<td>'.$tab_notes1[$i].'</td>';
		echo '<td>'.$tab_notes2[$i].'</td>';
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
}

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function afficherNote1($tab_noms,$tab_prenoms,$tab_notes,$type_notes)
{
	$nb_etud=count($tab_noms);

	echo '<table border="1">';
	echo '<thead><tr><th>Nom</th><th>Prenom</th>';
	foreach ($type_notes as $val) 
	{
		echo '<th>'.$val.'</th>';
	}
	echo '</thead>';
	echo '<tbody>';
	for ($i=0; $i < $nb_etud ; $i++) 
	{
		echo '<tr>';
		echo '<td>'.$tab_noms[$i].'</td>';
		echo '<td>'.$tab_prenoms[$i].'</td>';
		for($j=0;$j<count($type_notes);$j++) 
		{
			echo '<td>'.$tab_notes[$j][$i].'</td>';
		}
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
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

/**
 * @todo: commenter la fonction
 * @return array | $feuille
 */
function afficherTable()
{
	global $bdd;
	$info_etudiants = $bdd->query('SELECT id_etud, nom, prenom, mail1, mail2  FROM etudiant');
	$types_notes = $bdd->query('SELECT DISTINCT type_note FROM note');

	echo '<table border="1">';
	echo '<thead><tr>';
	echo '<th><input type="checkbox" id="select_tout" /></th><th>Nom</th><th>Prénom</th><th>email1</th><th>email2</th>';

	echo '<th>Note CC</th><th>Note Examen</th>';

	/*while ($type_note = $types_notes->fetch())
	{
		echo '<th>'.$type_note['type_note'].'</th>';
	}*/

	echo '</tr></thead>';
	echo '<tbody>';

	while ($etudiant = $info_etudiants->fetch())
	{
		echo '<tr>';
		echo '<td><input type="checkbox" name="'.$etudiant['id_etud'].'" /></td>';
		echo '<td>'.$etudiant['nom'].'</td>';
		echo '<td>'.$etudiant['prenom'].'</td>';
		echo '<td>'.$etudiant['mail1'].'</td>';
		echo '<td>'.$etudiant['mail2'].'</td>';

		$note_etudiant = $bdd->query('SELECT valeur FROM note WHERE id_etud="'.$etudiant['id_etud'].'"');

		while ($notes = $note_etudiant->fetch())
		{
			echo '<td>'.$notes[0].'</td>';
		}

		echo '</tr>';		
	}

	echo '</tbody>';
	echo '</table>';
}
?>