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
*modifUti() [Modifie l'utilisateur connecté]
*lectureUE() [Renvoi le nom de tous les UE]
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
	
	$requete = $pdo->prepare("SELECT uti_id, uti_nom, uti_prenom, uti_login, uti_mail, uti_ue_id FROM utilisateurs
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
function modifUti($nom, $prenom, $login, $mail, $mdp, $ue_id)
{
	$pdo = PDOSingleton::getInstance();

	try {

		// Initialisation des variable d'erreur PDO pour le cath
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//Commencer une transaction
		$pdo->beginTransaction();	

		if (empty($mdp))
		{
			$requete = $pdo->prepare("UPDATE utilisateurs SET :uti_nom, :uti_prenom, :uti_login, :uti_mail, :uit_ue_id
										WHERE uti_id = :uti_id");

			$requete->bindValue(':uti_id', $_SESSION['id_user']);
			$requete->bindValue(':uti_nom', $nom);
			$requete->bindValue(':uti_prenom', $prenom);
			$requete->bindValue(':uti_login', $login);
			$requete->bindValue(':uti_mail', $mail);
			$requete->bindValue(':uti_ue_id', $ue_id);
		} else {
			$requete = $pdo->prepare("UPDATE utilisateurs SET :uti_nom, :uti_prenom, :uti_login, :uti_mail, :uti_mdp, :uit_ue_id
										WHERE uti_id = :uti_id");

			$requete->bindValue(':uti_id', $_SESSION['id_user']);
			$requete->bindValue(':uti_nom', $nom);
			$requete->bindValue(':uti_prenom', $prenom);
			$requete->bindValue(':uti_login', $login);
			$requete->bindValue(':uti_mail', $mail);
			$requete->bindValue(':uti_mdp', password($mdp));
			$requete->bindValue(':uti_ue_id', $ue_id);
		}
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
?>