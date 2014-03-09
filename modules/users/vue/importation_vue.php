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

if($_SESSION['emails_valides']) 
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

if($_SESSION['notes_valides'])
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

?>

        </section>

        <footer>

        </footer>

    </body>
</html>