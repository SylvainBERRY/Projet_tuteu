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
 * Création d'un nouvel utilisateur en base de données
 * @return boolean // true si la création c'est bien passé false dans le cas contraire
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

		$requete->bindValue(':uti_mdp', password($mdp));
		$requete->bindValue(':uti_nom', $nom);
		$requete->bindValue(':uti_prenom', $prenom);
		$requete->bindValue(':uti_login', $login);
		$requete->bindValue(':uti_mail', $mail);
		$requete->bindValue(':uti_ue_id', $ue_id);
		
		$requete->execute();
    
		$pdo->commit();
	}
	//Gestion des erreurs causées par les requêtes PDO
	catch (PDOException $e) {  

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