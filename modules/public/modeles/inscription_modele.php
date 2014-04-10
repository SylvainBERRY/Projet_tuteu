<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page inscription_modele.php
*
*Page modele pour l'inscription
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions donn?es)
*
*Liste des fonctions :
*--------------------------
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
 * Cr?ation d'un nouvel utilisateur en base de donn?es
 * @return boolean // true si la cr?ation c'est bien pass? false dans le cas contraire
 */
function createUti($mdp, $nom, $prenom, $login, $mail, $ue_id)
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    //Commencer une transaction
	    $pdo->beginTransaction();

		$requete = $pdo->prepare("INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail, uti_is_admin, uti_is_valide)
					VALUES (:uti_nom, :uti_prenom, :uti_login, :uti_mdp, :uti_mail, 0, 0)");

		$requete->bindValue(':uti_mdp', password($mdp));
		$requete->bindValue(':uti_nom', $nom);
		$requete->bindValue(':uti_prenom', $prenom);
		$requete->bindValue(':uti_login', $login);
		$requete->bindValue(':uti_mail', $mail);
		$requete->execute();
		$pdo->commit();

		/// Récupérer id du nouvelle utilisateur
		$user_id = get_user($login);

		/// Ajout des liens pour UE
		foreach ($ue_id as $aUeId) {
			createUtiUE($user_id['uti_id'],$aUeId);
		}

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
?>
