<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page envoi_modele.php
*
*Page modele pour l'envoi de mail partie utilisateur
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
$bdd = PDOSingleton::getInstance();

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

$types_notes = $bdd->query('SELECT DISTINCT type_note FROM note WHERE uti_id = '.$_SESSION['id_user']);

while($type=$types_notes->fetch())
{
    $tab_type_note[]=$type[0];
}

setlocale(LC_TIME, 'fra_fra');
$message_globale='<h2>Recapitulatif des messages envoyés par Getnotes '.strftime('%A %d %B %Y, %H:%M',time()+3600).'</h2>';

$objet = $_POST['objet'];
$email_from = 'getnotes';
$user_information = get_information_user($_SESSION['id_user']);
$email_replay = $user_information['uti_mail'];
$name_from = $user_information['uti_prenom'].' '.strtoupper($user_information['uti_nom']);

$num_mail=1;
// L'envoi des mail etudiant
while($etudiant=$etudiants->fetch()) 
{
    $message = nl2br($_POST['message']).'<br/><br/>';

    foreach ($tab_type_note as $type)
    {
        $note=$notes->fetch();
        $message.=$type.' : '. $note['valeur'].'<br/>';
    }

    $message.='<br/> Ce mail est envoyer par l\'application Getnotes.<br/><br/>';

    $email_to = $etudiant['mail1'];
    envoiMail($email_from,$name_from,$email_to,$email_replay,$objet,$message);

    $email_to = $etudiant['mail2'];
    envoiMail($email_from,$name_from,$email_to,$email_replay,$objet,$message);
    
    $message_globale.='<h3>Email '.$num_mail.' à '.$etudiant['prenom'].' '.strtoupper($etudiant['nom']).' : &lt;'.$etudiant['mail1'].'&gt; &lt;'.$etudiant['mail2'].'&gt;</h3><br/>';
    $message_globale.=$message;
    $message_globale.='<br/>-------------------------<br/><br/>';
    $num_mail++;
}

// L'envoi du mail recapitulatif au prof
$objet='Recapitulatif des messages envoyés par Getnotes';
$name_from='Getnotes';
$email_to = 'timlepart@gmail.com'; // get_information_user($_SESSION['id_user'])['uti_mail'];
$email_replay='no-replay';
envoiMail($email_from,$name_from,$email_to,$email_replay,$objet,$message_globale);

$_SESSION['etape']=3;

?>