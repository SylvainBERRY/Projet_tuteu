<?php

session_start();

require_once('fonctions_users.php');

if(!(isset($_SESSION['emails_valides']) AND isset($_SESSION['charger'])))
{
    $_SESSION['emails_valides']=false;
    $_SESSION['notes_valides']=false;
}


if(isset($_FILES['excel_mails']) and (!erreurUpload('excel_mails')))
{
    $feuille_mails=lectureExcel($_FILES['excel_mails']['tmp_name']);

    $colonne_nom=rechercheColonne($feuille_mails);
    $tab_noms=lireColonne($feuille_mails,$colonne_nom);


    $colonne_prenom=chr(ord($colonne_nom)+1).$colonne_nom[1];
    $tab_prenoms=lireColonne($feuille_mails,$colonne_prenom);


    $colonne_mail1=chr(ord($colonne_nom)+2).$colonne_nom[1];
    $tab_mails1=lireColonne($feuille_mails,$colonne_mail1);


    $colonne_mail2=chr(ord($colonne_nom)+3).$colonne_nom[1];
    $tab_mails2=lireColonne($feuille_mails,$colonne_mail2);

    effacerContenuTable('note');
    effacerContenuTable('etudiant');
    sauvgEtudBd($tab_noms,$tab_prenoms,$tab_mails1,$tab_mails2);

    $_SESSION['emails_valides']=true;
}



if(isset($_FILES['excel_notes']) and (!erreurUpload('excel_notes')))
{
    $feuille_notes=lectureExcel($_FILES['excel_notes']['tmp_name']);

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
        
    effacerContenuTable('note');
    sauvgNoteBd1($tab_noms,$tab_prenoms,$tab_notes,$type_notes);

    $_SESSION['notes_valides']=true;
}

if(isset($_POST['valider']))
    header('Location:configuration.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../../styles/globale.css" />
        <link rel="stylesheet" type="text/css" href="../../styles/jquery.dataTables.css">
        <link rel="stylesheet" href="../../styles/importation.css" />
        <script type="text/javascript" charset="utf8" src="../../js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../../js/tables_import.js"></script>
        <title>Importation</title>
    </head>
    <body>

        <header>

        </header>
    
        <section>
            <h1>Importation fichier Excel</h1>
            <form action="importation.php" method="post" enctype="multipart/form-data" >
                <label for="info" >Emails étudiants :</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152">  
                <input type="file" id="excel_mails" name="excel_mails" value="ddd" />
                <br/>
                <label for="Notes" >Notes des étudiants :</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152">  
                <input type="file" id="excel_notes" name="excel_notes" />
                <br/>
                <input name="charger" type="submit" value="Charger" />
                <input name="valider" type="submit" value="Valider" <?php if(!($_SESSION['emails_valides'] AND $_SESSION['notes_valides'])) echo "disabled" ?> />
            </form>

<?php

if($_SESSION['emails_valides']) afficherEtudiant($tab_noms,$tab_prenoms,$tab_mails1,$tab_mails2);
if($_SESSION['notes_valides']) afficherNote1($tab_noms,$tab_prenoms,$tab_notes,$type_notes);


?>

        </section>

        <footer>

        </footer>

    </body>
</html>