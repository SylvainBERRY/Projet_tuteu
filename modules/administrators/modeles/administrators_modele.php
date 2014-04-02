<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page administrators_modele.php
*
*Page modele pour l'administrateur
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions donn?es)
*
*Liste des fonctions :
*--------------------------
*lectureUti() [Lit la totalit? de la table utilisateurs et la retourne]
*createUti($auto_mdp, $nom, $prenom, $login, $mail, $ue_id, $uti_is_valide) [Cr?? un nouvel utilisateur avec les donn?es du formulaire fournit]
*supprUti($tableau_id_uti) [Supprime l'utilisateur s?lectionn?]
*modifUti($nom, $prenom, $login, $mail, $id) [Modifie l'utilisateur s?lectionn?]
*lectureUE() [Renvoi le nom de tous les UE]
*valideUti($id_uti) [Valide l'utilisateur en param?tre et retourne un boolean]
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
 * Cr?ation d'un nouvel utilisateur en base de donn?es
 * @return boolean // true si la cr?ation c'est bien pass? false dans le cas contraire
 */
function createUti($auto_mdp, $nom, $prenom, $login, $mail, $ue_id, $uti_is_valide)
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    //Commencer une transaction
	    $pdo->beginTransaction();

		$requete = $pdo->prepare("INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail, uti_is_admin, uti_is_valide, uti_ue_id)
					VALUES (:uti_nom, :uti_prenom, :uti_login, :uti_mdp, :uti_mail, 0, 1, :uti_ue_id)");

		$requete->bindValue(':uti_mdp', $auto_mdp);
		$requete->bindValue(':uti_nom', $nom);
		$requete->bindValue(':uti_prenom', $prenom);
		$requete->bindValue(':uti_login', $login);
		$requete->bindValue(':uti_mail', $mail);
		$requete->bindValue(':uti_ue_id', $ue_id);

		$requete->execute();

		$pdo->commit();

	//Gestion des erreurs caus?es par les requ?tes PDO
	} catch (PDOException $e) {

		//Annuler la transaction
	    if ($pdo) $pdo->rollBack();

	    //Ajoute l'erreur dans les message flash et retourne false
		setMessageFlash($e->getMessage(),MESSAGE_FLASH_ERREUR);
		return false;
	}

	// Envoi d'un mail de notification ? l'utilisateur avec son mot de passe g?n?r? al?atoirement
	//@todo: envoi de mail ? l'utilisateur

	// L'insertion c'est bien d?roul? retourne true
	return true;
}

/**
 * Supprime le ou les utilisateur(s) selectionn? dans le formulaire
 * @return boolean [true si la suppression c'est bien d?roul? false dans le cas contraire]
 */
function deleteUti($id_uti)
{
	$pdo = PDOSingleton::getInstance();

	try {
		// Initialisation des variable d'erreur PDO pour le cath
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    //Commencer une transaction
	    $pdo->beginTransaction();

	    //Supprimer l'utilisateur de la base de données
		$requete = $pdo->prepare("DELETE FROM utilisateurs
					WHERE uti_id = :uti_id");

		$requete->bindValue(':uti_id', $id_uti);

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
 * Modifie l'utilisateur s?lectionn? ? l'aide de la checkbox aavec les donn?es utilisateur renseign? dans le formulaire
 * @return boolean [true si la modification c'est bien d?roul? false dans le cas contraire]
 */
function modifUti($nom, $prenom, $login, $mail, $id)
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//Commencer une transaction
		$pdo->beginTransaction();

		$requete = $pdo->prepare("UPDATE utilisateurs SET :uti_nom, :uti_prenom, :uti_login, :uti_mail
										WHERE uti_id = :uti_id");

		$requete->bondValue(':uti_id', $id);
		$requete->bindValue(':uti_nom', $nom);
		$requete->bindValue(':uti_prenom', $prenom);
		$requete->bindValue(':uti_login', $login);
		$requete->bindValue(':uti_mail', $mail);

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
 * Retourne l'enseignements de l'utilisateur donn?e en param?tre
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
/**
 * Prend en param?tre l'id d'un utilisateur pour le valider
 * @return boolean | $valide
 */
function valideUti($id_uti)
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//Commencer une transaction
		$pdo->beginTransaction();

		$requete = $pdo->prepare("UPDATE utilisateurs SET uti_is_valide = :uti_is_valide
										WHERE uti_id = :uti_id");

		$requete->bindValue(':uti_id', $id_uti);
		$requete->bindValue(':uti_is_valide', true);

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
?>
