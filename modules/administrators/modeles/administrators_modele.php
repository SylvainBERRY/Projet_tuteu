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
	
	$requete = $pdo->prepare("SELECT uti_id, uti_nom, uti_prenom, uti_login, uti_mail FROM utilisateurs");
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
function createUti()
{	
	echo ('test');
	$pdo = PDOSingleton::getInstance();
	
	$requete = $pdo->prepare("INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail, uti_is_admin)
				VALUES (uti_nom = :uti_nom, uit_prenom = :uti_prenom, uti_login = :uti_login, uti_mdp = :uti_mdp, uti_mail = :uti_mail, 0)");

	// @todo : générer mot de passe aléatoire
	$requete->bindValue(':uti_mdp', '0000');
	$requete->bindValue(':uti_nom', $_POST['Nom']);
	$requete->bindValue(':uti_prenom', $_POST['Prenom']);
	$requete->bindValue(':uti_login', $_POST['Login']);
	$requete->bindValue(':uti_mail', $_POST['Email']);
	var_dump($requete);
	$requete->execute();

	if ($result = $requete->fetchall(PDO::FETCH_BOTH)) {
		$requete->closeCursor();
		$retour = true;
		// @todo : créer une fonction qui envoie un mail de notification à l'utilisateur nouvellement créé avec le mot de passe généré et à l'administrateur
	return $retour;
	} else {
		$retour = false;
		return $retour;
	}
	
}

/**
 * Supprime l'utilisateur selectionné dans le formulaire
 * @return boolean [true si la suppression c'est bien déroulé false dans le cas contraire]
 */
function supprUti()
{
	$pdo = PDOSingleton::getInstance();
	
	$requete = $pdo->prepare("DELETE FROM utilisateurs
				WHERE uti_login = :uti_login");

	$requete->bindValue(':uti_login', $_POST['login']);

	$requete->execute();

	if ($result = $requete->fetchall(PDO::FETCH_BOTH)) {
		$requete->closeCursor();
		$retour = true;
	return $retour;
	} else {
		$retour = false;
		return $retour;
	}
}

/**
 * Modifie l'utilisateur sélectionné à l'aide de la checkbox aavec les données utilisateur renseigné dans le formulaire
 * @return boolean [true si la modification c'est bien déroulé false dans le cas contraire]
 */
function modifUti()
{
	$pdo = PDOSingleton::getInstance();
	
	$requete = $pdo->prepare("UPDATE utilisateurs SET uti_nom = :uti_nom, uit_prenom = :uti_prenom, uti_login = :uti_login, uti_mail = :uti_mail
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

	if ($result = $requete->fetchall(PDO::FETCH_BOTH)) {
		$requete->closeCursor();
		$retour = true;
	return $retour;
	} else {
		$retour = false;
		return $retour;
	}
}
?>