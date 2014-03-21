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
function createUti($mdp, $nom, $prenom, $login, $mail)
{	
	$pdo = PDOSingleton::getInstance();
	
	$requete = $pdo->prepare("INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail, uti_is_admin)
				VALUES (:uti_nom, :uti_prenom, :uti_login, :uti_mdp, :uti_mail, 0)");

	$requete->bindValue(':uti_mdp', $mdp);
	$requete->bindValue(':uti_nom', $nom);
	$requete->bindValue(':uti_prenom', $prenom);
	$requete->bindValue(':uti_login', $login);
	$requete->bindValue(':uti_mail', $mail);
	
	$requete->execute();

	//@todo : test execution � revoir
	// if ($result = $requete->fetch(PDO::FETCH_BOTH)) {
	// 	$requete->closeCursor();
	// 	$retour = true;
	// 	// @todo : cr�er une fonction qui envoie un mail de notification � l'administrateur
	// 	return $retour;
	// } else {
	// 	$retour = false;
	// 	return $retour;
	// }
	
	return true; //temporaire
}
?>