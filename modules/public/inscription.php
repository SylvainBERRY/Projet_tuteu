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
	$erreur = "DEFAULT_ERREUR";
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

	//Login
	if(isset($_POST['login']))
	{
		$login = trim($_POST['login']);
		// Appel fonction de vérification utilisation login correcte
		$login_result = check_login($login);
		if($login_result == TOOSHORT)
		{
			// Ajout de l'erreur login trop court en message flash
			setMessageFlash('Le login renseigné est trop court !', $erreur);
		}

		else if($login_result == TOOLONG)
		{
			// Ajout de l'erreur login trop long en message flash
			setMessageFlash('Le login renseigné est trop long !', $erreur);
		}

		else if($login_result == EXISTS)
		{
			// Ajout de l'erreur login déjà utilisé en message flash
			setMessageFlash('Le login renseigné est déjà utilisé !', $erreur);
		}

		else if($login_result == OK)
		{
			//Login ok pas de message d'erreur en flash
			setMessageFlash('Login validé');
		}

		else if($login_result == VIDE)
		{
			// Ajout de l'erreur vous n'avez pas rentré de login en message flash
			setMessageFlash('Vous devez renseigner un login !', $erreur);
		}
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
			setMessageFlash('Le prénom renseigné est trop court !', $erreur);
		}

		else if($prenom_result == TOOLONG)
		{
			// Ajout de l'erreur prénom trop long en message flash
			setMessageFlash('Le prénom renseigné est trop long !', $erreur);
		}

		else if($prenom_result == OK)
		{
			//Prénom ok pas de message d'erreur en flash
			setMessageFlash('Prénom validé');
		}

		else if($prenom_result == VIDE)
		{
			// Ajout de l'erreur vous n'avez pas rentré de prénom en message flash
			setMessageFlash('Vous devez renseigner un prénom !', $erreur);
		}
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
			setMessageFlash('Le nom renseigné est trop court !', $erreur);
		}

		else if($nom_result == TOOLONG)
		{
			// Ajout de l'erreur nom trop long en message flash
			setMessageFlash('Le nom renseigné est trop long !', $erreur);
		}

		else if($nom_result == OK)
		{
			// Nom ok pas de message d'erreur en flash
			setMessageFlash('Nom validé');
		}

		else if($nom_result == VIDE)
		{
			// Ajout de l'erreur vous n'avez pas rentré de nom en message flash
			setMessageFlash('Vous devez renseigner un nom !', $erreur);
		}
	}

	//Mot de passe
	if(isset($_POST['mdp']))
	{
		$mdp = trim($_POST['mdp']);
		$mdp_result = check_mdp($mdp, '');
		if($mdp_result == TOOSHORT)
		{
			// Ajout de l'erreur mdp trop court en message flash
			setMessageFlash('Le mot de passe renseigné est trop court !', $erreur);
		}

		else if($mdp_result == TOOLONG)
		{
			// Ajout de l'erreur mdp trop long en message flash
			setMessageFlash('Le mot de passe renseigné est trop long !', $erreur);
		}

		else if($mdp_result == NOFIGURE)
		{
			// Ajout de l'erreur votre mot de passe doit contenir au moins un chiffre
			setMessageFlash('Votre mot de passe doit contenir au moins 1 chiffre !', $erreur);
		}

		else if($mdp_result == NOUPCAP)
		{
			// Ajout de l'erreur votre mot de passe doit contenir au moins une majuscule
			setMessageFlash('Votre mot de passe doit contenir au moins 1 majuscule !', $erreur);
		}

		else if($mdp_result == OK)
		{
			// Mdp ok pas de message d'erreur en flash
			setMessageFlash('Mot de passe validé');
		}

		else if($mdp_result == VIDE)
		{
			// Ajout de l'erreur vous n'avez pas rentré de mdp en message flash
			setMessageFlash('Vous devez renseigner un mot de passe !', $erreur);

		}
	}

	//Mot de passe confirmation
	if(isset($_POST['mdp_verif']))
	{
		$mdp_verif = trim($_POST['mdp_verif']);
		$mdp_verif_result = check_mdp_conf($mdp_verif, $mdp);
		if($mdp_verif_result == DIFFERENT)
		{
			// Ajout de l'erreur mot de passe de confirmation différent du mot de passe initial
			setMessageFlash('Le mot de passe de confirmation est différent du mot de passe initial !', $erreur);
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
				setMessageFlash('Mot de passe de confiration incorrecte');
			}
		}
	}

	//Adresse mail
	if(isset($_POST['mail']))
	{
		$mail = trim($_POST['mail']);
		$mail_result = checkmail($mail);
		if($mail_result == 'ISNT')
		{
			// Ajout de l'erreur adresse mail invalide
			setMessageFlash('Adresse mail invalide !', $erreur);
		}

		else if($mail_result == 'EXIST')
		{
			// Ajout de l'erreur adresse mail déjà utilisé
			setMessageFlash('Adresse mail déjà utilisé !', $erreur);
		}

		else if($mail_result == 'OK')
		{
			// Adresse mail ok pas de message d'erreur en flash
			setMessageFlash('Adresse mail validé');
		}

		else if($mail_result == 'VIDE')
		{
			// Ajout de l'erreur adresse mail non renseigné
			setMessageFlash('Adresse mail non renseigné !', $erreur);
		}
	}

	//Mail suite
	if(isset($_POST['mail_verif']))
	{
		$mail_verif = trim($_POST['mail_verif']);
		$mail_verif_result = checkmailS($mail_verif, $mail);
		if($mail_verif_result == 'DIFFERENT')
		{
			// Ajout de l'erreur adresse mail de vérification différente de la première adresse mail
			setMessageFlash('Adresse mail de vérification différente de la première adresse mail !', $erreur);
		}

		else
		{
			if($mail_result == 'ok')
			{
				// Adresse mail de vérification ok pas de message d'erreur en flash
				setMessageFlash('Adresse mail de vérification validé');
			}

			else
			{
				// Adresse mail de vérification incorrecte
				setMessageFlash('Adresse mail de vérification incorrecte !', $erreur);
			}
		}
	}
//@todo : vérifier les messages flash et lancer l'inscription si ok sinon afficher les erreurs a l'utilisateur
}
// Inclusion de la vue d'inscription
include_once (CHEMIN_VUE.'inscription_vue.php');
?>