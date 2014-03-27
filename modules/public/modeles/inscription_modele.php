<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page inscription_modele.php
*
*Page modele pour l'inscription
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions donn�es)
*
*Liste des fonctions :
*--------------------------
*check_login($login) [Test le login renseign� dans le formulaire d'inscription]
*check_nom_prenom($nom_prenom) [Test le nom ou pr�nom renseign� dans le formulaire d'inscription]
*check_mdp($mdp) [Test le mot de passe renseign� dans le formulaire]
*check_mdp_conf($mdp_verif, $mdp2) [Test le mot de passe de confirmation renseign� dans le formulaire]
*createUti() [Ajoute l'utilisateur nouvellement inscrit dans la table utilisateurs]
*lectureUE() [Renvoi le nom de tous les UE]
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

/**
 * Retourne le r�sultat de la requete en fonction du login du formulaire d'inscription.
 * TOOSHORT = login trop court
 * TOOLONG = login trop long
 * EXISTS = login existe d�j� en BD
 * VIDE = login non renseign�
 * OK = le login peut �tre utilis� pour l'inscription
 * @return string
 */
function check_login($login) {

  if($login == '') return VIDE;
  
  else if(strlen($login) < 3) return TOOSHORT;
  
  else if(strlen($login) > 32) return TOOLONG;
  
  else
  {
    $pdo = PDOSingleton::getInstance();

    $requete = $pdo->prepare("SELECT COUNT(*) AS nbr FROM utilisateurs WHERE uti_login = :uti_login");

    $requete->bindValue(':uti_login', $login);

    $requete->execute();
    
    if($result = $requete->fetch(PDO::FETCH_ASSOC)) {
  	  $requete->closeCursor();
    }
    
	if($result['nbr'] > 0) return EXISTS;
   
	else return OK;
  }
}
/**
 * Retourne le r�sultat des test sur le prenom ou le nom du formulaire d'inscription.
 * TOOSHORT = prenom ou nom est trop court
 * TOOLONG = prenom ou nom est trop long
 * VIDE = prenom ou nom est non renseign�
 * OK = prenom ou nom peut �tre utilis� pour l'inscription
 * @return string
 */
function check_nom_prenom($nom_prenom) {

  if($nom_prenom == '') return VIDE;
  
  else if(strlen($nom_prenom) < 3) return TOOSHORT;
  
  else if(strlen($nom_prenom) > 32) return TOOLONG;

  else return OK;
}
/**
 * Retourne le r�sultat des test sur le mdp du formulaire d'inscription.
 * TOOSHORT = mdp est trop court
 * TOOLONG = mdp est trop long
 * VIDE = mdp est non renseign�
 * OK = mdp peut �tre utilis� pour l'inscription
 * @return string
 */
function check_mdp($mdp)
{
	if($mdp == '') return VIDE;
	else if(strlen($mdp) < 4) return TOOSHORT;
	else if(strlen($mdp) > 50) return TOOLONG;
	
	else
	{
		if(!preg_match('#[0-9]{1,}#', $mdp)) return NOFIGURE;
		else if(!preg_match('#[A-Z]{1,}#', $mdp)) return NOUPCAP;
		else return OK;
	}
}
/**
 * Retourne le r�sultat des test sur le mdp et le mdp de confirmation du formulaire d'inscription.
 * TOOSHORT = mdp est trop court
 * TOOLONG = mdp est trop long
 * VIDE = mdp est non renseign�
 * OK = mdp peut �tre utilis� pour l'inscription
 * DIFFERENT = mdp et mdp2 de confirmation diff�rent
 * @return string
 */
function check_mdp_conf($mdp_verif, $mdp2)
{
	if($mdp_verif != $mdp2 && $mdp_verif != '' && $mdp2 != '') return DIFFERENT;
	else return check_mdp($mdp_verif);
}
/**
 * Retourne le r�sultat des test sur l'adresse mail du formulaire d'inscription.
 * ISNT = l'adresse mail n'a pas une bonne structure
 * VIDE = adresse mail non renseign�
 * OK = l'adresse mail peut �tre utilis� pour l'inscription
 * EXIST = l'adresse mail est d�j� utilis� par un autre utilisateur
 * @return string
 */
function checkmail($mail)
{
	if($mail == '') return VIDE;
	else if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $mail)) return ISNT;
	
	else
	{
		$pdo = PDOSingleton::getInstance();

	    $requete = $pdo->prepare("SELECT COUNT(*) AS nbr FROM utilisateurs WHERE uti_mail = :uti_mail");

	    $requete->bindValue(':uti_mail', $mail);

	    $requete->execute();
	    
	    if($result = $requete->fetch(PDO::FETCH_ASSOC)) {
	    	$requete->closeCursor();
	    }
    
		if($result['nbr'] > 0) return EXISTS;
			else return OK;
	}
}
/**
 * Retourne le r�sultat des test sur l'adresse mail de v�rification du formulaire d'inscription.
 * OK = l'adresse mail peut �tre utilis� pour l'inscription
 * DIFFERENT = l'adresse mail de v�rification est diff�rente de l'adresse 1er adresse mail
 * @return string
 */
function checkmailS($mail_verif, $mail)
{
	if($mail_verif != $mail && $mail != '' && $mail_verif != '') return DIFFERENT;
	else return OK;
}
/**
 * Cr�ation d'un nouvel utilisateur en base de donn�es
 * @return boolean // true si la cr�ation c'est bien pass� false dans le cas contraire
 */
function createUti($mdp, $nom, $prenom, $login, $mail, $ue_id)
{	
	$pdo = PDOSingleton::getInstance();
	
	try {

		// Initialisation des variable d'erreur PDO pour le cath
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    //Commencer une transaction
	    $pdo->beginTransaction();

		$requete = $pdo->prepare("INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail, uti_is_admin, uti_is_valide, uti_ue_id)
					VALUES (:uti_nom, :uti_prenom, :uti_login, :uti_mdp, :uti_mail, 0, 0, :uti_ue_id)");

		$requete->bindValue(':uti_mdp', $mdp);
		$requete->bindValue(':uti_nom', $nom);
		$requete->bindValue(':uti_prenom', $prenom);
		$requete->bindValue(':uti_login', $login);
		$requete->bindValue(':uti_mail', $mail);
		$requete->bindValue(':uti_ue_id', $ue_id);
		
		$requete->execute();
    
		$pdo->commit();
	}
	//Gestion des erreurs caus�es par les requ�tes PDO
	catch (PDOException $e) {  

		//Annuler la transaction
	    if ($pdo) $pdo->rollBack();

	    //Ajoute l'erreur dans les message flash et retourne false
		setMessageFlash($e->getMessage(),MESSAGE_FLASH_ERREUR);
		return false;
	}
	// L'insertion c'est bien d�roul� retourne true
	return true; 
}
/**
 * Retourne un tableau de tous les enseignements contenu dans la table enseignement
 * @return array | $result
 */
function lectureUE()
{
	$pdo = PDOSingleton::getInstance();

   	$requete = $pdo->prepare("SELECT ue_id, ue_nom FROM enseignement");

  	$requete->execute();

	if ($result = $requete->fetchall(PDO::FETCH_ASSOC)) {
		$requete->closeCursor();
	return $result;
	}

}
/**
 * Envoie d'un mail de notification
 */
function envoiMail($email_from,$email_to,$email_replay,$objet,$message)
{
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bug.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	
	$header = "From: \"WeaponsB\" ".$email_from.$passage_ligne;
	$header.= "Reply-to: \"WeaponsB\" ".$email_replay.$passage_ligne;
	$headers  .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    /*
    
	//=====D�claration des messages au format texte et au format HTML.
	$message_txt = "Salut � tous, voici un e-mail envoy� par un script PHP.";
	$message_html = "<html><head></head><body><b>Salut � tous</b>, voici un e-mail envoy� par un <i>script PHP</i>.</body></html>";
	//==========
	 
	//=====Cr�ation de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====D�finition du sujet.
	$objet = "salut !";
	//=========
	 
	//=====Cr�ation du header de l'e-mail.
	$header = "From: \"WeaponsB\"<hoctac@hotmail.fr>".$passage_ligne;
	$header.= "Reply-to: \"WeaponsB\" <hoctac@hotmail.fr>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//==========
	 
	//=====Cr�ation du message.
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