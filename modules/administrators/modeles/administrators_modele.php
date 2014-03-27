<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page administrators_modele.php
*
*Page modele pour l'administrateur
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions données)
*
*Liste des fonctions :
*--------------------------
*lectureUti() [Lit la totalité de la table utilisateurs et la retourne]
*createUti() [Créé un nouvel utilisateur avec les données du formulaire fournit]
*supprUti() [Supprime l'utilisateur sélectionné]
*modifUti() [Modifie l'utilisateur sélectionné]
*lectureUE() [Renvoi le nom de tous les UE]
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

/**
 * Retourne un tableau de tous les utilisateurs contenu dans la table utilisateurs
 * @return array | $result
 */
function lectureUti()
{
	$pdo = PDOSingleton::getInstance();
	
	$requete = $pdo->prepare("SELECT uti_id, uti_nom, uti_prenom, uti_login, uti_mail, uti_is_valide, uti_ue_id FROM utilisateurs");
	$requete->execute();

	if ($result = $requete->fetchall(PDO::FETCH_ASSOC)) {
		$requete->closeCursor();
	return $result;
	}
}

/**
 * Création d'un nouvel utilisateur en base de données
 * @return boolean // true si la création c'est bien passé false dans le cas contraire
 */
function createUti($nom, $prenom, $login, $mail, $ue_id)
{	
	$pdo = PDOSingleton::getInstance();
	
	try {

		// Initialisation des variable d'erreur PDO pour le cath
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    //Commencer une transaction
	    $pdo->beginTransaction();	

		$requete = $pdo->prepare("INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail, uti_is_admin, uti_is_valide, uti_ue_id)
					VALUES (:uti_nom, :uti_prenom, :uti_login, :uti_mdp, :uti_mail, 0, 1, :uti_ue_id)");

		$mdp_random = getMdpRandom();
		$requete->bindValue(':uti_mdp', $mdp_random);
		$requete->bindValue(':uti_nom', $nom);
		$requete->bindValue(':uti_prenom', $prenom);
		$requete->bindValue(':uti_login', $login);
		$requete->bindValue(':uti_mail', $mail);
		$requete->bindValue(':uti_ue_id', $ue_id);

		$requete->execute();

		$pdo->commit();

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
 * Supprime l'utilisateur selectionné dans le formulaire
 * @return boolean [true si la suppression c'est bien déroulé false dans le cas contraire]
 */
function supprUti()
{
	$pdo = PDOSingleton::getInstance();

	try {
		// Initialisation des variable d'erreur PDO pour le cath
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    //Commencer une transaction
	    $pdo->beginTransaction();	

		$requete = $pdo->prepare("DELETE FROM utilisateurs
					WHERE uti_login = :uti_login");

		$requete->bindValue(':uti_login', $_POST['login']);

		$requete->execute();

		$pdo->commit();

	} catch (PDOException $e) {  

		//Annuler la transaction
	    if ($pdo) $pdo->rollBack();

	    //Ajoute l'erreur dans les message flash et retourne false
		setMessageFlash($e->getMessage(),MESSAGE_FLASH_ERREUR);

		return false;
	}
	return true;
}

/**
 * Modifie l'utilisateur sélectionné à l'aide de la checkbox aavec les données utilisateur renseigné dans le formulaire
 * @return boolean [true si la modification c'est bien déroulé false dans le cas contraire]
 */
function modifUti()
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//Commencer une transaction
		$pdo->beginTransaction();	

		$requete = $pdo->prepare("UPDATE utilisateurs SET :uti_nom, :uti_prenom, :uti_login, :uti_mail
										WHERE uti_id = :uti_id");

		// Permet de récupérer l'id de l'utilisateur avec son login
		// A revoir si le login est modifier dans le formulaire il n'apparaitra pas dans la bd
		$id = get_user($_POST['Login']);
		$requete->bondValue(':uti_id', $id['uti_id']);

		$requete->bindValue(':uti_nom', $_POST['Nom']);
		$requete->bindValue(':uti_prenom', $_POST['Prenom']);
		$requete->bindValue(':uti_login', $_POST['Login']);
		$requete->bindValue(':uti_mail', $_POST['Email']);

		$requete->execute();

		$pdo->commit();

	} catch (PDOException $e) {  

		//Annuler la transaction
	    if ($pdo) $pdo->rollBack();

	    //Ajoute l'erreur dans les message flash et retourne false
		setMessageFlash($e->getMessage(),MESSAGE_FLASH_ERREUR);

		return false;
	}
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
 * Retourne l'enseignements de l'utilisateur donnée en paramètre
 * @return array | $result
 */
function lectureUEUti($ue_id)
{
	$pdo = PDOSingleton::getInstance();

   	$requete = $pdo->prepare("SELECT ue_id, ue_nom FROM enseignement WHERE ue_id = :ue_id");

   	$requete->bindValue(':ue_id', $ue_id);

  	$requete->execute();

	if ($result = $requete->fetchall(PDO::FETCH_ASSOC)) {
		$requete->closeCursor();
	return $result;
	}

}
?>