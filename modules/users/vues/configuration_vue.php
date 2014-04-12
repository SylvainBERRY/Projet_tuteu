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

echo '<script type="text/javascript">';
echo 'var nb_etud_totale='; 
echo '</script>';
?>  
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
            <h3>Aperçu type</h3>
            <p id="ap_objet" >Note du module genie logicle </p>
            <p id="ap_de" ><span>De : </span>Sandrine LANQUETIN</p>
            <p id="ap_a" ><span>&Agrave; : </span>hoctac@hotmail.fr</p>
            <p id="ap_text" >Bonjour,
                Ci-dessous vos notes du module Culture d’entreprise - Anglais.
                Cordialement
                Sylvain BERRY
                Cordialement
                Sylvain BERRY
                Ci-dessous vos notes du module Culture d’entreprise - Anglais.
                Cordialement
                Sylvain BERRY
            </p>
        </div>
    <br/><br/>
    <h3 id="select_etu" >Selectionnez les étudinats</h3>
    <hr/>
    <p id="nb" >Tous les etudiants sont sélectionnés</p>
<?php
    
    echo '<table border="1">';
    echo '<thead><tr>';
    echo '<th><input type="checkbox" id="select_tout" checked /></th><th>Nom</th><th>Prénom</th><th>Emails</th>';

    while ($type_note = $types_notes->fetch())
    {
    echo '<th>'.$type_note[0].'</th>';
    }

    echo '</tr></thead>';
    echo '<tbody>';

    while ($etudiant = $info_etudiants->fetch())
    {
    echo '<tr>';
    echo '<td><input type="checkbox" class="select" checked name="checkbox_'.$etudiant['id_etud'].'" value="'.$etudiant['id_etud'].'" /></td>';
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
            <input type="submit" value="envoyer les mails" />
    </form>
</section>