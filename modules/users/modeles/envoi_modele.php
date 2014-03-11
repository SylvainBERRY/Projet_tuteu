<?php
   
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

    $message_globale='';

    $objet = $_POST['objet'];
    $email_from = 'getnotes';
    $email_replay = 'no_replay';

    // L'envoi des mail etudiant
    while($etudiant=$etudiants->fetch()) 
    {
        $message = $_POST['message'];

        for ($i=1; $i<=2; $i++) 
        {
            $note=$notes->fetch();
            $message.=$note['valeur'].' : '. $note['valeur'].'<br/>';
        }
 
        $email_to = $etudiant['mail1']
        envoiMail($email_from,$email_to,$objet,$message);

        $email_to = $etudiant['mail2']
        envoiMail($email_from,$email_to,$email_replay,$objet,$message);
        
        $message_globale.=$message;
    }

    // L'envoi du mail recapitulatif au prof
    $objet='Recapitulatif des message envoyé';
    $email_to = $_SESSION['mail_prof'];
    envoiMail($email_from,$email_to,$email_replay,$objet,$message_globale);

?>