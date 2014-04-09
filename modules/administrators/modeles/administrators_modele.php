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
*createUti($auto_mdp, $nom, $prenom, $login, $mail, $tab_ue_id) [Cr?? un nouvel utilisateur avec les donn?es du formulaire fournit]
*deleteUti($id_uti) [Supprime l'utilisateur s?lectionn?]
*modifUti($id_user, $nom, $prenom, $login, $mail, $tab_ue_id) [Modifie l'utilisateur s?lectionn?]
*lectureUE() [Renvoi le nom de tous les UE]
*valideUti($id_uti) [Valide l'utilisateur en param?tre et retourne un boolean]
*createUtiUE($uti_id, $ue_id) [Cr?? les ue de l'utilisateur correspondant]
*lectureUEUti($uti_id) [Lit les Ue de l'utilisateur correspondant]
*purgeUtiUE($uti_id) [Vide la table utilisateurs_ue pour l'utilisateur envoy? en param?tre]
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

	$requete = $pdo->prepare("SELECT uti_id, uti_nom, uti_prenom, uti_login, uti_mail, uti_is_valide FROM utilisateurs");
	$requete->execute();

	if ($result = $requete->fetchall(PDO::FETCH_ASSOC)) {
		$requete->closeCursor();
	return $result;
	}

	return false;
}

/**
 * Cr?ation d'un nouvel utilisateur en base de donn?es
 * @return boolean // true si la cr?ation c'est bien pass? false dans le cas contraire
 */
function createUti($auto_mdp, $nom, $prenom, $login, $mail, $tab_ue_id)
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    //Commencer une transaction
	    $pdo->beginTransaction();

		$requete = $pdo->prepare("INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail, uti_is_admin, uti_is_valide)
					VALUES (:uti_nom, :uti_prenom, :uti_login, :uti_mdp, :uti_mail, 0, 1)");

		$requete->bindValue(':uti_mdp', password($auto_mdp));
		$requete->bindValue(':uti_nom', $nom);
		$requete->bindValue(':uti_prenom', $prenom);
		$requete->bindValue(':uti_login', $login);
		$requete->bindValue(':uti_mail', $mail);

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

	//Recuperation de l'uti_id grace au login renseign?
	$info_user = get_user($login);
	$uti_id = $info_user['uti_id'];
	//Cr?ation des couples uti_id et ue_id
	
	foreach($tab_ue_id as $key => $ue_id)
	{
		if(!createUtiUE($uti_id, $ue_id))
		{
			//Ajoute l'erreur dans les message flash
			setMessageFlash("Une erreur est survenu lors de la cr?ation des ue pour l'utilisateur",MESSAGE_FLASH_ERREUR);
		}
		
	}

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

	    //Supprimer l'utilisateur de la base de donn?es
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
	purgeUtiUE($id_uti);
	return true;
}

/**
 * Modifie les donn?es de l'utilisateur
 * @return boolean [true si la modification c'est bien d?roul? false dans le cas contraire]
 */
function modifUti($id_user, $nom, $prenom, $login, $mail, $tab_ue_id)
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//Commencer une transaction
		$pdo->beginTransaction();

		$requete = $pdo->prepare("UPDATE utilisateurs SET uti_nom = :uti_nom, uti_prenom = :uti_prenom, uti_login = :uti_login, uti_mail = :uti_mail
									WHERE uti_id = :uti_id");

		$requete->bindValue(':uti_id', $id_user);
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
	if (purgeUtiUE($id_user))
	{
		//Cr?ation des couples uti_id et ue_id
		foreach($tab_ue_id as $key => $ue_id)
		{
				if(!createUtiUE($id_user, $ue_id))
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

  	//get tableau vide
  	$result = $requete->fetchall(PDO::FETCH_ASSOC);

  	// Check if no errors
		if (is_array($result)) {

			$requete->closeCursor();

			return $result;

		}

		return false;

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
