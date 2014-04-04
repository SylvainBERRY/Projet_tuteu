<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page profil_modele.php
*
*Page modele pour la gestion du profil
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions données)
*
*Liste des fonctions :
*--------------------------
*lectureUti() [Lit les données de l'utilisateur connecté]
*modifUti($nom, $prenom, $login, $mail, $mdp, $tab_ue_id) [Modifie l'utilisateur connecté]
*lectureUE() [Renvoi le nom de tous les UE]
*lectureUEUti($uti_id) [Renvoi le nom de tous les UE]
*createUtiUE($uti_id, $ue_id) [Create les UE de l'uti correspondant]
*purgeUtiUE($uti_id) [Purge les UE de l'utilisateur fournit]
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

/**
 * Retourne un tableau contenant les données de l'utilisateur connecté
 * @return array | $result
 */
function lectureUti()
{
	$pdo = PDOSingleton::getInstance();

	$requete = $pdo->prepare("SELECT uti_id, uti_nom, uti_prenom, uti_login, uti_mail FROM utilisateurs
							WHERE uti_id = :uti_id");
	$requete->bindValue(':uti_id', $_SESSION['id_user']);
	$requete->execute();

	if ($result = $requete->fetchall(PDO::FETCH_ASSOC)) {
		$requete->closeCursor();
	return $result;
	}
}

/**
 * Modifie les données de l'utilisateur
 * @return boolean [true si la modification c'est bien déroulé false dans le cas contraire]
 */
function modifUti($nom, $prenom, $login, $mail, $mdp, $tab_ue_id)
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//Commencer une transaction
		$pdo->beginTransaction();

		if (empty($mdp))
		{
			$requete = $pdo->prepare("UPDATE utilisateurs SET uti_nom = :uti_nom, uti_prenom = :uti_prenom, uti_login = :uti_login, uti_mail = :uti_mail
										WHERE uti_id = :uti_id");

			$requete->bindValue(':uti_id', $_SESSION['id_user']);
			$requete->bindValue(':uti_nom', $nom);
			$requete->bindValue(':uti_prenom', $prenom);
			$requete->bindValue(':uti_login', $login);
			$requete->bindValue(':uti_mail', $mail);

			$requete->execute();

		}
		else {
			$requete2 = $pdo->prepare("UPDATE utilisateurs SET uti_nom = :uti_nom, uti_prenom = :uti_prenom, uti_login = :uti_login, uti_mail = :uti_mail, uti_mdp = :uti_mdp
										WHERE uti_id = :uti_id");

			$requete2->bindValue(':uti_id', $_SESSION['id_user']);
			$requete2->bindValue(':uti_nom', $nom);
			$requete2->bindValue(':uti_prenom', $prenom);
			$requete2->bindValue(':uti_login', $login);
			$requete2->bindValue(':uti_mail', $mail);
			$requete2->bindValue(':uti_mdp', password($mdp));

			$requete2->execute();
		}
		$pdo->commit();
	} catch (PDOException $e) {

		//Annuler la transaction
	    if ($pdo) $pdo->rollBack();

	    //Ajoute l'erreur dans les message flash et retourne false
		setMessageFlash($e->getMessage(),MESSAGE_FLASH_ERREUR);

		return false;
	}
	if (purgeUtiUE($_SESSION['id_user']))
	{
		//Cr?ation des couples uti_id et ue_id
		foreach($tab_ue_id as $key => $ue_id)
		{
				if(!createUtiUE($_SESSION['id_user'], $ue_id))
				{
					//Ajoute l'erreur dans les message flash
					setMessageFlash("Une erreur est survenu lors de la cr?ation des ue pour l'utilisateur",MESSAGE_FLASH_ERREUR);
				}
		}
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

	return false;

}
/**
 * Retourne l'enseignements de l'utilisateur donn?e en param?tre
 * @return array | $result
 */
function lectureUEUti($uti_id)
{
	$pdo = PDOSingleton::getInstance();

   	$requete = $pdo->prepare("SELECT ue_id FROM utilisateurs_ue WHERE uti_id = :uti_id");

   	$requete->bindValue(':uti_id', $uti_id);

  	$requete->execute();


	if ($result = $requete->fetchall(PDO::FETCH_ASSOC)) {
		$requete->closeCursor();
		return $result;
	}
	return false;

}
/**
 * Prend en param?tre l'id d'un utilisateur et l'id d'un ue pour cr?er le couple correspondant dans la table de jointure
 * @return boolean | true or false En fonction du resultat de l'insertion en bd
 */
function createUtiUE($uti_id, $ue_id)
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
	  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	  //Commencer une transaction
	  $pdo->beginTransaction();
		// Prepare la requete pour l'insertion enseignement/utilisateur
		$requete2 = $pdo->prepare("INSERT INTO utilisateurs_ue (uti_id, ue_id)
					VALUES (:uti_id, :ue_id)");

		$requete2->bindValue(':uti_id', $uti_id);
		$requete2->bindValue(':ue_id', $ue_id);

		$requete2->execute();
		$pdo->commit();
	}
	//Gestion des erreurs caus?es par les requ?tes PDO
	catch (PDOException $e) {

		//Annuler la transaction
	    if ($pdo) $pdo->rollBack();

	    //Ajoute l'erreur dans les message flash et retourne false
		setMessageFlash($e->getMessage(),MESSAGE_FLASH_ERREUR);
		return false;
	}

	// L'insertion c'est bien d?roul? retourne true
	return true;
}

function purgeUtiUE($uti_id)
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
	  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	  //Commencer une transaction
	  $pdo->beginTransaction();
	  //Supprimer l'utilisateur de la base de donn?es
		$requete = $pdo->prepare("DELETE FROM utilisateurs_ue
					WHERE uti_id = :uti_id");
		$requete->bindValue(':uti_id', $uti_id);

		$requete->execute();
		$pdo->commit();
	}
	//Gestion des erreurs caus?es par les requ?tes PDO
	catch (PDOException $e) {

		//Annuler la transaction
	    if ($pdo) $pdo->rollBack();

	    //Ajoute l'erreur dans les message flash et retourne false
		setMessageFlash($e->getMessage(),MESSAGE_FLASH_ERREUR);
		return false;
	}

	// L'insertion c'est bien d?roul? retourne true
	return true;
}
?>
