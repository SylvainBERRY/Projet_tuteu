<?php

function envoiMail($email_from,$email_to,$email_replay,$objet,$message)
{

	$header = "From: \"WeaponsB\" ".$email_from.$passage_ligne;
	$header.= "Reply-to: \"WeaponsB\" ".$email_replay.$passage_ligne;
	$headers  .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    /*
    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = "Salut à tous, voici un e-mail envoyé par un script PHP.";
	$message_html = "<html><head></head><body><b>Salut à tous</b>, voici un e-mail envoyé par un <i>script PHP</i>.</body></html>";
	//==========
	 
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$objet = "salut !";
	//=========
	 
	//=====Création du header de l'e-mail.
	$header = "From: \"WeaponsB\"<hoctac@hotmail.fr>".$passage_ligne;
	$header.= "Reply-to: \"WeaponsB\" <hoctac@hotmail.fr>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//==========
	 
	//=====Création du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format texte.
	$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	//==========

	*/

    mail($email_to, $objet, $message, $headers);

}

?>