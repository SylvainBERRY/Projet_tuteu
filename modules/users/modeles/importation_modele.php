<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page importation_modele.php
*
*Page modele pour l'utilisateur
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

// @todo : A commenter ^^

if(!(isset($_SESSION['emails_valides']) AND isset($_SESSION['charger'])))
{
    $_SESSION['emails_valides']=false;
    $_SESSION['notes_valides']=false;
}

if(isset($_FILES['excel_mails']) and (!erreurUpload('excel_mails')))
{  
	echo $_FILES['excel_mails']['tmp_name'];
    move_uploaded_file($_FILES['excel_mails']['tmp_name'], CHEMIN_EXCEL.$_FILES['excel_mails']['name']);
	$_SESSION['upload_mails']= CHEMIN_EXCEL.$_FILES['excel_mails']['name'];
}

if(isset($_SESSION['upload_mails']))
{  
    $feuille_mails=lectureExcel($_SESSION['upload_mails']);

    $colonne_nom=rechercheColonne($feuille_mails);
    $tab_noms=lireColonne($feuille_mails,$colonne_nom);


    $colonne_prenom=chr(ord($colonne_nom)+1).$colonne_nom[1];
    $tab_prenoms=lireColonne($feuille_mails,$colonne_prenom);


    $colonne_mail1=chr(ord($colonne_nom)+2).$colonne_nom[1];
    $tab_mails1=lireColonne($feuille_mails,$colonne_mail1);


    $colonne_mail2=chr(ord($colonne_nom)+3).$colonne_nom[1];
    $tab_mails2=lireColonne($feuille_mails,$colonne_mail2);

    if(isset($_POST['valider']))
    {
	    effacerContenuTable('note');
	    effacerContenuTable('etudiant');
	    sauvgEtudBd($tab_noms,$tab_prenoms,$tab_mails1,$tab_mails2);
	}

    $_SESSION['emails_valides']=true;
}


if(isset($_FILES['excel_notes']) and (!erreurUpload('excel_notes')))
{  
	move_uploaded_file($_FILES['excel_notes']['tmp_name'], CHEMIN_EXCEL.$_FILES['excel_notes']['name']);
	$_SESSION['upload_notes']= CHEMIN_EXCEL.$_FILES['excel_notes']['name'];
}

if(isset($_SESSION['upload_notes']))
{
    $feuille_notes=lectureExcel($_SESSION['upload_notes']);

    $colonne_nom=rechercheColonne($feuille_notes);
    $tab_noms=lireColonne($feuille_notes,$colonne_nom);

    $colonne_prenom=chr(ord($colonne_nom)+1).$colonne_nom[1];
    $tab_prenoms=lireColonne($feuille_notes,$colonne_prenom);

    $i=2;
    $colonne_notes=chr(ord($colonne_nom)+$i).$colonne_nom[1];
    $tab=lireColonne($feuille_notes,$colonne_notes);

    while(!empty($tab))
    {
        $index_col=$colonne_notes[0];
        $num_ligne=intval($colonne_notes[1])-1;
        $type_notes[]=$feuille_notes->getCell($index_col.$num_ligne)->getValue();

        $tab_notes[]=$tab;
        $i++;
        $colonne_notes=chr(ord($colonne_nom)+$i).$colonne_nom[1];
        $tab=lireColonne($feuille_notes,$colonne_notes);
    }
        
    if(isset($_POST['valider']))
    {
    	$echo="dddddd";
        effacerContenuTable('note');
    	sauvgNoteBd($tab_noms,$tab_prenoms,$tab_notes,$type_notes);
    }

    $_SESSION['notes_valides']=true;
}
?>