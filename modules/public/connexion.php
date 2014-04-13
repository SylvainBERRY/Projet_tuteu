<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page connexion.php
*
*Page de connexion par defaut.
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions données)
*
*Liste des fonctions :
*--------------------------
*Aucune fonction
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/
// Si des données sont postées
if (!empty($_POST)) {

	// On regarde si les données postées sont valides
	if (isset($_POST['login']) && isset($_POST['mdp'])) {

		// Récupération des données
		$login = $_POST['login'];
		$mdp = $_POST['mdp'];

		// Inclusion du modèle nécessaire
		include_once CHEMIN_MODELE.'users_modele.php';

		// On vérifie si le login existe
		if (couple_login_mdp_valide($login,$mdp) && !check_uti_is_co($login)) {

			// Ajout de l'utilisateur en session
			if (login($login)) {
				// Ajout variable pour ne faire qu'une connection à la fois
				$bdd = PDOSingleton::getInstance();
				$bdd->query('UPDATE utilisateurs SET uti_is_co = true WHERE uti_id = '.$_SESSION['id_user']);
				
				if(DEBUG_FLASH_SUCCESS){
					// Message flash de succès vous avez bien été connecté
					setMessageFlash('Vous avez bien été connecté(e).');
				}
				$_SESSION['etape']=0;
				$_SESSION['emails_valides']=false;
				$_SESSION['notes_valides']=false;

				if (administrateur_est_connecte()) {
					// Si administrateur redirection page d'administration
					header( 'Location: '.LOGIN_REDIRECT_ADMIN);
				}
				else {

					// Redirection
					header( 'Location: '.LOGIN_REDIRECT );
				}
			}
		} else {
			if (check_uti_is_co($login))
			{
				// Ajout message erreur vous êtez déjà connecté
				setMessageFlash('Vous êtez déjà connecté.',MESSAGE_FLASH_ERREUR);
			} else {
					if(isset($_SESSION['is_valide']) && !$_SESSION['is_valide'])
					{
						// Ajout message erreur compte non validé
						setMessageFlash("Votre compte n'est pas encore validé.",MESSAGE_FLASH_ERREUR);
					} else {
						// Ajout message erreur mot de passe, login incorrecte
						setMessageFlash('Votre mot de passe ou votre login est incorrecte.',MESSAGE_FLASH_ERREUR);
					}
			}
			// Redirection
			header( 'Location: '.LOGOUT_REDIRECT );
		}
	}
}

// Inclusion de la vue du formulaire
include_once (CHEMIN_VUE.'connexion_vue.php');
?>
