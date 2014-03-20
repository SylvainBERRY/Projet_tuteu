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
 // @todo: faire fonction de vérification mail
}
/**
 * Retourne le résultat des test sur l'adresse mail du formulaire d'inscription.
 * ISNT = l'adresse mail n'a pas une bonne structure
 * VIDE = adresse mail non renseigné
 * OK = l'adresse mail peut être utilisé pour l'inscription
 * EXIST = l'adresse mail est déjà utilisé par un autre utilisateur
 * @return string
 */
function checkmailS($mail_verif, $mail)
{
 // @todo: faire fonction comparaison mail et mail de vérification
}
/**
 * Création d'un nouvel utilisateur en base de données
 * @return boolean // true si la création c'est bien passé false dans le cas contraire
 */
function createUti()
{	
	$pdo = PDOSingleton::getInstance();
	
	$requete = $pdo->prepare("INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail, uti_is_admin)
				VALUES (uti_nom = :uti_nom, uit_prenom = :uti_prenom, uti_login = :uti_login, uti_mdp = :uti_mdp, uti_mail = :uti_mail, 0)");

	$requete->bindValue(':uti_mdp', $_POST['mdp']);
	$requete->bindValue(':uti_nom', $_POST['nom']);
	$requete->bindValue(':uti_prenom', $_POST['prenom']);
	$requete->bindValue(':uti_login', $_POST['login']);
	$requete->bindValue(':uti_mail', $_POST['mail']);
	
	$requete->execute();

	if ($result = $requete->fetch(PDO::FETCH_BOTH)) {
		$requete->closeCursor();
		$retour = true;
		// @todo : créer une fonction qui envoie un mail de notification à l'administrateur
		return $retour;
	} else {
		$retour = false;
		return $retour;
	}
	
}
?>