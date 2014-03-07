<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="styles/globale.css" />
        <link rel="stylesheet" type="text/css" href="styles/jquery.dataTables.css">
        <link rel="stylesheet" href="styles/importation.css" />
        <script type="text/javascript" charset="utf8" src="scripts/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="scripts/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="scripts/tables_import.js"></script>
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
if($_SESSION['notes_valides']) afficherNote($tab_noms,$tab_prenoms,$tab_notes1,$tab_notes2);


?>

        </section>

        <footer>

        </footer>

    </body>
</html>