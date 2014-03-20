<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>globale.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo CHEMIN_STYLE ?>jquery.dataTables.css">
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>configuration.css" />
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables_config.js"></script>
        <title>Configuration</title>
    </head>
    <body>

        <header>

        </header>

        <section>
            <h1>Configuration des mails</h1>

             <form action="index.php?module=users&amp;action=envoi" method="post" >
                <label for="ue" >UE :</label>
                <input id="ue" type="text" name="ue" />
                <br/>
                <label for="enseignant" >Enseignant :</label>
                <input id="enseignant" type="text" name="enseignant" />
                <br/>
                <label for="objet" >Objet :</label>
                <input id="objet" type="text" name="objet" value="Note" />
                <br/>
                <label for="message" >Enseignant :</label>
                <br/>
                <textarea id="message" name="message" >Bonjour, Voici le note du :

Cordialement</textarea>
                <br/>
                <input type="submit" value="envoyer" /><input type="submit" value="aperçu" /></br>

<?php

    echo '<table border="1">';
    echo '<thead><tr>';
    echo '<th><input type="checkbox" id="select_tout" /></th><th>Nom</th><th>Prénom</th><th>Email 1</th><th>Email 2</th>';

    while ($type_note = $types_notes->fetch())
    {
    echo '<th>'.$type_note[0].'</th>';
    }

    echo '</tr></thead>';
    echo '<tbody>';

    while ($etudiant = $info_etudiants->fetch())
    {
    echo '<tr>';
    echo '<td><input type="checkbox" name="checkbox_'.$etudiant['id_etud'].'" value="'.$etudiant['id_etud'].'" /></td>';
    echo '<td>'.$etudiant['nom'].'</td>';
    echo '<td>'.$etudiant['prenom'].'</td>';
    echo '<td>'.$etudiant['mail1'].'</td>';
    echo '<td>'.$etudiant['mail2'].'</td>';

    // @todo : - requêtes dans le controleur - utilisation de pdo (injection) - faire une fonction dans le modèle
    $note_etudiant = $bdd->query('SELECT valeur FROM note WHERE id_etud="'.$etudiant['id_etud'].'"');

    while ($notes = $note_etudiant->fetch())
    {
      echo '<td>'.$notes[0].'</td>';
    }

    echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
?>
            </form>
        </section>

        <footer>

        </footer>

    </body>
</html>
