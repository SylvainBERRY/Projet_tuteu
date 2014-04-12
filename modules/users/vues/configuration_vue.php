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

$nom_prenom=$user_information['uti_prenom'].' '.strtoupper($user_information['uti_nom']);
$text ='Bonjour,

Ci-dessous vos notes du module '.$_SESSION['ue'].'.

Cordialement
'.$nom_prenom;


?>
<script type="text/javascript">
    var nb_etud_totale = <?php echo $info_etudiants->rowCount(); ?>;
</script>
<section>
    <br/>
    <h1>Configuration des mails</h1>

     <form action="index.php?module=users&amp;action=envoi" method="post" >
        <fieldset>
            <h3>Message</h3>
            <label for="objet" >Objet :</label>
            <input id="objet" type="text" name="objet" value="Note du module <?php echo $_SESSION['ue'] ?>" />
            <br/>
            <label for="message" >Texte :</label>
            <br/>
            <textarea id="message" name="message" ><?php echo $text ?></textarea>
        </fieldset>
        <div id="apercu">
            <p id="ap_objet" >Note du module <?php echo $_SESSION['ue'] ?></p>
            <p id="ap_de" ><span>De : </span><?php echo $nom_prenom ?></p>
            <p id="ap_text"><?php echo nl2br($text) ?></p>
            <p id="ap_note">
            <?php 
                while ($type_note = $types_notes->fetch())
                {
                    $tab_type_note[]=$type_note[0];
                    echo '<span>'.$type_note[0].' : </span>##.##<br/>';
                }
            ?></p>
        </div>
    <br/><br/>
    <h3 id="select_etu" >Sélectionnez les étudinats</h3>
    <hr/>
    <p id="nb" >Aucun étudiant sélectionné</p>
<?php
    
    echo '<table border="1">';
    echo '<thead><tr>';
    echo '<th><input type="checkbox" id="select_tout" /></th><th>Nom</th><th>Prénom</th><th>Emails</th>';

    foreach ($tab_type_note as $type_note) 
    {
    echo '<th>'.$type_note.'</th>';
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
<br/><br/><br/>
<hr/>
            <input type="submit" value="Envoyer les mails" id="envoyer" disabled="true" />
    </form>
</section>