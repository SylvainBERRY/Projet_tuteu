<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page configuration_vue.php
*
*Page vue de configuration pour l'utilisateur.
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
$text ='Bonjour,

Ci-dessous vos notes du module '.$_SESSION['ue'].'.

Cordialement
'.$user_information['uti_prenom'].' '.strtoupper($user_information['uti_nom']);
?>  
<section>
    <br/>
    <h1>Configuration des mails</h1>

     <form action="index.php?module=users&amp;action=envoi" method="post" >
        <fieldset>
            <label for="objet" >Objet :</label>
            <input id="objet" type="text" name="objet" value="Note du module <?php echo $_SESSION['ue'] ?>" />
            <br/>
            <label for="message" >Texte :</label>
            <br/>
            <textarea id="message" name="message" ><?php echo $text ?></textarea>
            <br/>
            <input type="submit" value="envoyer" /><input type="submit" value="aperçu" /></br>
        </fieldset>

<?php

    echo '<table border="1">';
    echo '<thead><tr>';
    echo '<th><input type="checkbox" id="select_tout" /></th><th>Nom</th><th>Prénom</th><th>Emails</th>';

    while ($type_note = $types_notes->fetch())
    {
    echo '<th>'.$type_note[0].'</th>';
    }

    echo '</tr></thead>';
    echo '<tbody>';

    while ($etudiant = $info_etudiants->fetch())
    {
    echo '<tr>';
    echo '<td><input type="checkbox" class="select" name="checkbox_'.$etudiant['id_etud'].'" value="'.$etudiant['id_etud'].'" /></td>';
    echo '<td>'.$etudiant['nom'].'</td>';
    echo '<td>'.$etudiant['prenom'].'</td>';
    echo '<td>'.$etudiant['mail1'].'<br/>'.$etudiant['mail2'].'</td>';
   
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
    <br/>
</section>