<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page inscription_modele.php
*
*Page modele pour l'inscription
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions données)
*
*Liste des fonctions :
*--------------------------
*check_login($login) [Test le login renseigné dans le formulaire d'inscription]
*check_nom_prenom($nom_prenom) [Test le nom ou prénom renseigné dans le formulaire d'inscription]
*check_mdp($mdp) [Test le mot de passe renseigné dans le formulaire]
*check_mdp_conf($mdp_verif, $mdp2) [Test le mot de passe de confirmation renseigné dans le formulaire]
*createUti() [Ajoute l'utilisateur nouvellement inscrit dans la table utilisateurs]
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

/**
 * Retourne le résultat de la requete en fonction du login du formulaire d'inscription.
 * TOOSHORT = login trop court
 * TOOLONG = login trop long
 * EXISTS = login existe déjà en BD
 * VIDE = login non renseigné
 * OK = le login peut être utilisé pour l'inscription
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
 * Retourne le résultat des test sur le prenom ou le nom du formulaire d'inscription.
 * TOOSHORT = prenom ou nom est trop court
 * TOOLONG = prenom ou nom est trop long
 * VIDE = prenom ou nom est non renseigné
 * OK = prenom ou nom peut être utilisé pour l'inscription
 * @return string
 */
function check_nom_prenom($nom_prenom) {

  if($nom_prenom == '') return VIDE;
  
  else if(strlen($nom_prenom) < 3) return TOOSHORT;
  
  else if(strlen($nom_prenom) > 32) return TOOLONG;

  else return OK;
}
/**
 * Retourne le résultat des test sur le mdp du formulaire d'inscription.
 * TOOSHORT = mdp est trop court
 * TOOLONG = mdp est trop long
 * VIDE = mdp est non renseigné
 * OK = mdp peut être utilisé pour l'inscription
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
 * Retourne le résultat des test sur le mdp et le mdp de confirmation du formulaire d'inscription.
 * TOOSHORT = mdp est trop court
 * TOOLONG = mdp est trop long
 * VIDE = mdp est non renseigné
 * OK = mdp peut être utilisé pour l'inscription
 * DIFFERENT = mdp et mdp2 de confirmation différent
 * @return string
 */
function check_mdp_conf($mdp_verif, $mdp2)
{
	if($mdp_verif != $mdp2 && $mdp_verif != '' && $mdp2 != '') return DIFFERENT;
	else return check_mdp($mdp_verif);
}
/**
 * Retourne le résultat des test sur l'adresse mail du formulaire d'inscription.
 * ISNT = l'adresse mail n'a pas une bonne structure
 * VIDE = adresse mail non renseigné
 * OK = l'adresse mail peut être utilisé pour l'inscription
 * EXIST = l'adresse mail est déjà utilisé par un autre utilisateur
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
 * Retourne le résultat des test sur l'adresse mail de vérification du formulaire d'inscription.
 * OK = l'adresse mail peut être utilisé pour l'inscription
 * DIFFERENT = l'adresse mail de vérification est différente de l'adresse 1er adresse mail
 * @return string
 */
function checkmailS($mail_verif, $mail)
{
	if($mail_verif != $mail && $mail != '' && $mail_verif != '') return DIFFERENT;
	else return OK;
}
/**
 * Création d'un nouvel utilisateur en base de données
 * @return boolean // true si la création c'est bien passé false dans le cas contraire
 */
function createUti($mdp, $nom, $prenom, $login, $mail)
{	
	$pdo = PDOSingleton::getInstance();
	
	try {

		// Initialisation des variable d'erreur PDO pour le cath
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    //Commencer une transaction
	    $pdo->beginTransaction();

		$requete = $pdo->prepare("INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail, uti_is_admin)
					VALUES (:uti_nom, :uti_prenom, :uti_login, :uti_mdp, :uti_mail, 0)");

		$requete->bindValue(':uti_mdp', $mdp);
		$requete->bindValue(':uti_nom', $nom);
		$requete->bindValue(':uti_prenom', $prenom);
		$requete->bindValue(':uti_login', $login);
		$requete->bindValue(':uti_mail', $mail);
		
		$requete->execute();
	}
	//Gestion des erreurs causées par les requêtes PDO
	} catch (PDOException $e) {  

		//Annuler la transaction
	    if ($pdo) $pdo->rollBack();

	    //Ajoute l'erreur dans les message flash et retourne false
		setMessageFlash($e->getMessage(),MESSAGE_FLASH_ERREUR);
		return false;
	}
	// L'insertion c'est bien déroulé retourne true
	return true; 
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