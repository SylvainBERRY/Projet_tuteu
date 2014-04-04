<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page insert_auto_uti.php
*
*Page de génération automatique d'utilisateur pour test
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions donn?es)
*
*Liste des fonctions :
*--------------------------
*createUti($auto_mdp, $nom, $prenom, $login, $mail, $ue_id, $uti_is_valide) [Cr?? un nouvel utilisateur avec les donn?es du formulaire fournit]
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

/**
 * Cr?ation d'utilisateur en base de donn?es
 * @return boolean // true si la cr?ation c'est bien pass? false dans le cas contraire
 */
function createUti($nbUti)
{
	$pdo = PDOSingleton::getInstance();

	try {
		// Initialisation des variable d'information des utilisateurs un compteur leur sera concaténé
		$chaine = 'test';
		
		$auto_mdp = password('Az00');
		$nom = $chaine;
		$prenom = $chaine;
		$login = $chaine;
		$mail = $chaine.'@'.$chaine.'.'.$chaine;

		// Initialisation des variable d'erreur PDO pour le cath
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    //Commencer une transaction
	    $pdo->beginTransaction();
		for($i = 0; $i < $nbUti ; $i++)
		{
			$requete = $pdo->prepare("INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail, uti_is_admin, uti_is_valide)
						VALUES (:uti_nom, :uti_prenom, :uti_login, :uti_mdp, :uti_mail, 0, 0)");

			$requete->bindValue(':uti_mdp', $auto_mdp.$i);
			$requete->bindValue(':uti_nom', $nom.$i);
			$requete->bindValue(':uti_prenom', $prenom.$i);
			$requete->bindValue(':uti_login', $login.$i);
			$requete->bindValue(':uti_mail', $mail.$i);

			$requete->execute();
		}
		$pdo->commit();

	//Gestion des erreurs caus?es par les requ?tes PDO
	} catch (PDOException $e) {

		//Annuler la transaction
	    if ($pdo) $pdo->rollBack();

	    //Ajoute l'erreur dans les message flash et retourne false
		setMessageFlash($e->getMessage(),MESSAGE_FLASH_ERREUR);
		return false;
	}

	// L'insertion c'est bien d?roul? retourne true
	return true;
}

// Si des données sont postées
if (!empty($_POST)) {
	echo ($_POST['Nb_Uti']);
	createUti($_POST['Nb_Uti']);
}
// Redirection accueil administrators
header( 'Location: '.LOGIN_REDIRECT_ADMIN) ;
?>