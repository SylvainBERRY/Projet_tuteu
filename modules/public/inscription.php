<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page inscription.php
*
*Page d'inscription par defaut.
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
	
	// Inclusion du modèle nécessaire
	include_once CHEMIN_MODELE.'inscription_modele.php';

	// Initialisation de la variable erreur pour les catégories de message flash
	if (isset($_SESSION['login'])) {

		if($_SESSION['login'] == $_POST['login'] && trim($_POST['login']) != '')
		{
			// Création message flash utilisateur déjà inscrit et connecté avec le login
			setMessageFlash('Vous êtes déjà connecté(e) '.$_POST['login'].'.');

			// Redirection si administrateur ou utilisateur
			if (administrateur_est_connecte()) {
					  // Si administrateur redirection page d'administration
					  header( 'Location: '.LOGIN_REDIRECT_ADMIN);
				  }
				  else {
					
					  // Redirection page utilisateur
					  header( 'Location: '.LOGIN_REDIRECT );
				  }
		}

	}

	// Erreur retroubées
	$errors_array = array();

	//Login
	if(isset($_POST['login']))
	{
		$login = trim($_POST['login']);
		// Appel fonction de vérification utilisation login correcte
		$login_result = check_login($login);
		if($login_result == TOOSHORT)
		{
			// Ajout de l'erreur login trop court en message flash
			$errors_array[] = 'Le login renseigné est trop court !';
		}

		else if($login_result == TOOLONG)
		{
			// Ajout de l'erreur login trop long en message flash
			$errors_array[] = 'Le login renseigné est trop long !';
		}

		else if($login_result == EXISTS)
		{
			// Ajout de l'erreur login déjà utilisé en message flash
			$errors_array[] = 'Le login renseigné est déjà utilisé !';
		}

		else if($login_result == OK)
		{
			//Login ok pas de message d'erreur en flash
			setMessageFlash('Login validé');
		}

		else if($login_result == VIDE)
		{
			// Ajout de l'erreur vous n'avez pas rentré de login en message flash
			$errors_array[] = 'Vous devez renseigner un login !';
		}
	}
	else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner un login !';
	}


	//Prenom
	if(isset($_POST['prenom']))
	{
		$prenom = trim($_POST['prenom']);
		// Appel fonction de vérification utilisation prénom correcte
		$prenom_result = check_nom_prenom($prenom);
		if($prenom_result == TOOSHORT)
		{
			// Ajout de l'erreur prénom trop court en message flash
			$errors_array[] = 'Le prénom renseigné est trop court !';
		}

		else if($prenom_result == TOOLONG)
		{
			// Ajout de l'erreur prénom trop long en message flash
			$errors_array[] = 'Le prénom renseigné est trop long !';
		}

		else if($prenom_result == OK)
		{
			//Prénom ok pas de message d'erreur en flash
			setMessageFlash('Prénom validé');
		}

		else if($prenom_result == VIDE)
		{
			// Ajout de l'erreur vous n'avez pas rentré de prénom en message flash
			$errors_array[] = 'Vous devez renseigner un prénom !';
		}
	}
	else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner un prénom !';
	}


	//Nom
	if(isset($_POST['nom']))
	{
		$nom = trim($_POST['nom']);
		// Appel fonction de vérification utilisation nom correcte
		$nom_result = check_nom_prenom($nom);
		if($nom_result == TOOSHORT)
		{
			// Ajout de l'erreur nom trop court en message flash
			$errors_array[] = 'Le nom renseigné est trop court !';
		}

		else if($nom_result == TOOLONG)
		{
			// Ajout de l'erreur nom trop long en message flash
			$errors_array[] = 'Le nom renseigné est trop long !';
		}

		else if($nom_result == OK)
		{
			// Nom ok pas de message d'erreur en flash
			setMessageFlash('Nom validé');
		}

		else if($nom_result == VIDE)
		{
			// Ajout de l'erreur vous n'avez pas rentré de nom en message flash
			$errors_array[] = 'Vous devez renseigner un nom !';
		}
	}
	else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner un nom !';
	}

	//Mot de passe
	if(isset($_POST['mdp']))
	{
		$mdp = trim($_POST['mdp']);
		$mdp_result = check_mdp($mdp, '');
		if($mdp_result == TOOSHORT)
		{
			// Ajout de l'erreur mdp trop court en message flash
			$errors_array[] = 'Le mot de passe renseigné est trop court !';
		}

		else if($mdp_result == TOOLONG)
		{
			// Ajout de l'erreur mdp trop long en message flash
			$errors_array[] = 'Le mot de passe renseigné est trop long !';
		}

		else if($mdp_result == NOFIGURE)
		{
			// Ajout de l'erreur votre mot de passe doit contenir au moins un chiffre
			$errors_array[] = 'Votre mot de passe doit contenir au moins 1 chiffre !';
		}

		else if($mdp_result == NOUPCAP)
		{
			// Ajout de l'erreur votre mot de passe doit contenir au moins une majuscule
			$errors_array[] = 'Votre mot de passe doit contenir au moins 1 majuscule !';
		}

		else if($mdp_result == OK)
		{
			// Mdp ok pas de message d'erreur en flash
			setMessageFlash('Mot de passe validé');
		}

		else if($mdp_result == VIDE)
		{
			// Ajout de l'erreur vous n'avez pas rentré de mdp en message flash
			$errors_array[] = 'Vous devez renseigner un mot de passe !';

		}
	}
	else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner un mot de passe !';
	}

	//Mot de passe confirmation
	if(isset($_POST['mdp_verif']))
	{
		$mdp_verif = trim($_POST['mdp_verif']);
		$mdp_verif_result = check_mdp_conf($mdp_verif, $mdp);
		if($mdp_verif_result == DIFFERENT)
		{
			// Ajout de l'erreur mot de passe de confirmation différent du mot de passe initial
			$errors_array[] = 'Le mot de passe de confirmation est différent du mot de passe initial !';
		}

		else
		{
			if($mdp_verif_result == OK)
			{
				// Mdp de vérification ok pas de message d'erreur en flash
				setMessageFlash('Mot de passe de confirmation validé');
			}

			else
			{
				// Ajout erreur $mdp_verif_result trop court, trop long ...
				$errors_array[] = 'Mot de passe de confiration incorrecte';
			}
		}
	}
	else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner un mot de passe de vérification !';
	}

	//Adresse mail
	if(isset($_POST['mail']))
	{
		$mail = trim($_POST['mail']);
		$mail_result = checkmail($mail);
		if($mail_result == ISNT)
		{
			// Ajout de l'erreur adresse mail invalide
			$errors_array[] = 'Adresse mail invalide !';
		}

		else if($mail_result == EXISTS)
		{
			// Ajout de l'erreur adresse mail déjà utilisé
			$errors_array[] = 'Adresse mail déjà utilisé !';
		}

		else if($mail_result == OK)
		{
			// Adresse mail ok pas de message d'erreur en flash
			setMessageFlash('Adresse mail validé');
		}

		else if($mail_result == VIDE)
		{
			// Ajout de l'erreur adresse mail non renseigné
			$errors_array[] = 'Adresse mail non renseigné !';
		}
	}
	else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner une adresse mail !';
	}

	//Mail suite
	if(isset($_POST['mail_verif']))
	{
		$mail_verif = trim($_POST['mail_verif']);
		$mail_verif_result = checkmailS($mail_verif, $mail);
		if($mail_verif_result == DIFFERENT)
		{
			// Ajout de l'erreur adresse mail de vérification différente de la première adresse mail
			$errors_array[] = 'Adresse mail de vérification différente de la première adresse mail !';
		}

		else
		{
			if($mail_result == OK)
			{
				// Adresse mail de vérification ok pas de message d'erreur en flash
				setMessageFlash('Adresse mail de vérification validé');
			}

			else
			{
				// Adresse mail de vérification incorrecte
				$errors_array[] = 'Adresse mail de vérification incorrecte !';
			}
		}
	}
	else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner une adresse mail de vérification !';
	}
	
	// Si aucune erreur n'est trouvée
	if (empty($errors_array)) {

		// Inscription base de données
		if (createUti($_POST['mdp'], $_POST['nom'],$_POST['prenom'],$_POST['login'],$_POST['mail'])) {

			// Création de l'utilisateur et ajout d'un message flash de succès
			setMessageFlash("L'inscription a été effectuée avec succès.");

			// Envoie d'un mail de notification à l'administrateur pour validation de l'utilisateur
		//	$email_from = 'berry.sylvain@free.fr'; // @todo: définir l'expéditeur du mail (l'application GetNote)
		//	$email_to = getMailAdmin(); // @todo: faire la fonction de récupération du mail de l'administrateur pour l'envoi.
		//	$objet = "Mail de notification de l'application GetNote pour validation d'inscription.";
		//	$message = "Une inscription a été effectué sur l'application GetNote. Veuillé valide ou supprimer l'utilisateur nouvellement inscrit".$_POST['login'];
		//	envoiMail($email_from,$email_to,$email_replay,$objet,$message);

			// Redirection connexion
			header( 'Location: '.LOGOUT_REDIRECT ) ;
		}
		else {

			$errors_array[] = 'Une erreur est survenue. Merci de réessayer ultérieurement.';
		
		}
	}
	else {
		
		// Ajouter les messages du tableau en message flash
		setMessageFlash($errors_array,MESSAGE_FLASH_ERREUR);

		// Redirection vers la page d'inscription
		header( 'Location: '.INSCRIPTION_REDIRECT);
	}


}

// Inclusion de la vue d'inscription
include_once (CHEMIN_VUE.'inscription_vue.php');
?>