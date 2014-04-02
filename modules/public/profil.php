<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page profil.php
*
*Page de gestion de profil par defaut.
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
// Inclusion page modele profil
include_once (CHEMIN_MODELE.'profil_modele.php');

// Si des données sont postées
if (!empty($_POST)) {

	// Erreur retroubées
	$errors_array = array();

	// Récupération donnée utilisateur actuel
	$uti_update = get_information_user($_SESSION['id_user']);

	//Login
	if(isset($_POST['login']))
	{
		$login = trim($_POST['login']);
		if ($uti_update['uti_login'] != $_POST['login'])
		{
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
		}
	} else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner un login !';
	}


	//Prenom
	if(isset($_POST['prenom']))
	{
		$prenom = trim($_POST['prenom']);

		if ($uti_update['uti_prenom'] != $_POST['prenom'])
		{
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
		}
	}else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner un prénom !';
	}


	//Nom
	if(isset($_POST['nom']))
	{
		$nom = trim($_POST['nom']);

		if ($uti_update['uti_nom'] != $_POST['nom'])
		{
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
		}
	}else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner un nom !';
	}

	//Mot de passe
	if(!empty($_POST['mdp']))
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
	}

	//Mot de passe confirmation
	if(!empty($_POST['mdp_verif']) && !empty($_POST['mdp']))
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
	else if (!empty($_POST['mdp']) || !empty($_POST['mdp_verif'])){

		// Un des deux mot de passe est vide
		$errors_array[] = 'Vous devez renseigner un mot de passe et un mot de passe de vérification ou laisser vide si vous ne souhaitez pas changer de mot de passe !';
	}

	//Adresse mail
	if(isset($_POST['mail']))
	{
		$mail = trim($_POST['mail']);

		if ($uti_update['uti_mail'] != $_POST['mail'])
		{

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

		if ($uti_update['uti_mail'] != $_POST['mail_verif'])
		{

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
	}
	else {

		// Doit être renseigné
		$errors_array[] = 'Vous devez renseigner une adresse mail de vérification !';
	}
	
	// Si aucune erreur n'est trouvée
	if (empty($errors_array)) {

		// Initialisation du tableau d'ue
		$reponse = lectureUE();
		$tableau_ue = "";
		$i = 1;

		// Remplissage du tableau d'ue avec les id ue
		foreach ($reponse as $donnees) {
			if (isset($_POST[$i])) {
				$tableau_ue .= $donnees['ue_id'];
				$tableau_ue .= ',';
			}
			$i++;
		}
		$mdp = $_POST['mdp'];
		
		// Inscription base de données
		if (modifUti($_POST['nom'],$_POST['prenom'],$_POST['login'],$_POST['mail'],$mdp,$tableau_ue)) {

			// Modification de l'utilisateur et ajout d'un message flash de succès
			setMessageFlash("La modification de votre profil a été effectuée avec succès.");

			// Envoie d'un mail de notification à l'utilisateur pour la modification de son profil
			//$email_from = 'berry.sylvain@free.fr';  // @todo: définir l'expéditeur du mail.
			//$email_to = $_POST['mail'];
			//$objet = "Mail de notification suite à la modification de votre profil.";
			//$message = '"'"Une modification de votre profil a été effectué sur l'application GetNote. Voici le résumé de cette //modification: Nom: ".$_POST['nom']." Prenom: ".$_POST['prenom']." Login: ".$_POST['login']." Mail: ".$_POST['mail']. //" Mot de passe: ".$tableau_ue,$_POST['mdp'].'"';
			//envoiMail($email_from,$email_to,$email_replay,$objet,$message);

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

		// Redirection vers la page de gestion de profil
		header( 'Location: '.LOGIN_REDIRECT_PROFIL);
	}


}

// Inclusion page vue profil
include_once (CHEMIN_VUE.'profil_vue.php');
?>