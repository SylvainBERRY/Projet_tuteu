<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page importation_vue.php
*
*Page d'accueil de l'utilisateur.
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

?>   
<section>
    <br/>
    <h1>Importation fichier Excel</h1>
    <form action="index.php?module=users&amp;action=importation" method="post" enctype="multipart/form-data" >
        <label for="info" >Emails étudiants :</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="2097152">  
        <input type="file" id="excel_mails" name="excel_mails" value="ddd" />
        <br/>
        <label for="Notes" >Notes des étudiants :</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="2097152">  
        <input type="file" id="excel_notes" name="excel_notes" />
        <br/>
        <label for="ue" >Choisissez l'UE :</label>
        <select name="ue" >
            <option>Genie logiciel</option>
            <option>UML</option>
        </select>
        <br/>
        <input name="charger" type="submit" value="Charger" />
        <input name="valider" type="submit" value="Valider" <?php if(!($_SESSION['emails_valides'] AND $_SESSION['notes_valides'])) echo "disabled" ?> />
        <br/>
    </form>

<?php

$tab_erreur=getMessageFlash("upload");

if (!empty($tab_erreur)) 
{
    echo '<p id="erreur_message" class="erreur">';
    foreach ($tab_erreur as $erreur) {
        echo '<img src="'.CHEMIN_IMAGE.'erreur.png" alt="icone Erreur"/>';
        echo $erreur;
        echo '<br/>';
    }
    echo '</p>';
}

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
<br/>
</section>