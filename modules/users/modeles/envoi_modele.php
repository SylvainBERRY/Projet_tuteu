<?php
   
    $bdd = PDOSingleton::getInstance();
    
    foreach (array_keys($_POST) as $checkbox) 
    {
        if(preg_match("/checkbox/", $checkbox))    $checkboxs[]=preg_replace("/checkbox_/","",$checkbox);
    }

    $num_etud='(';

    foreach($checkboxs as $num)
    {
        $num_etud.=$num.',';
    }

    $num_etud=trim($num_etud,',');

    $num_etud.=')';

    $etudiants=$bdd->query('SELECT * FROM etudiant 
        WHERE id_etud IN '.$num_etud);

    $notes=$bdd->query('SELECT * FROM note
        WHERE id_etud IN '.$num_etud);

    $types_notes = $bdd->query('SELECT DISTINCT type_note FROM note');

    while($type=$types_notes->fetch())
    {
        $tab_type_note[]=$type[0];
    }

    $message_globale='';

    $objet = $_POST['objet'];
    $email_from = 'getnotes';
    $email_replay = 'no_replay';

    // L'envoi des mail etudiant
    while($etudiant=$etudiants->fetch()) 
    {
        $message = $_POST['message'].'<br/>';

        foreach ($tab_type_note as $type)
        {
            $note=$notes->fetch();
            $message.=$type.' : '. $note['valeur'].'<br/>';
        }
 
        $email_to = $etudiant['mail1'];
        envoiMail($email_from,$email_to,$email_replay,$objet,$message);

        $email_to = $etudiant['mail2'];
        envoiMail($email_from,$email_to,$email_replay,$objet,$message);
        
        $message_globale.=$message;
    }

    // L'envoi du mail recapitulatif au prof
    $objet='Recapitulatif des message envoyé';
    $email_to = $_SESSION['mail_prof'];
    envoiMail($email_from,$email_to,$email_replay,$objet,$message_globale);

?>