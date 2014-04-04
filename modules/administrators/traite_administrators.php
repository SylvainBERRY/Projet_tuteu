<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page traite_administrators.php
*
*Page effectuant les traitement sur la table utilisateurs
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

// Traitement des utilisateurs:
include_once (CHEMIN_MODELE.'administrators_modele.php');

// Si des données sont postées
if (!empty($_POST)) {

	// Erreur retroubées
	$errors_array = array();
	
	// Récupération donnée utilisateur actuel
	$uti_update = get_information_user($_POST['Uti_id']);

	if (empty($_POST['Uti_id']))
	{
		//Login
		if(isset($_POST['Login']))
		{
			$login = trim($_POST['Login']);
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
		else {

			// Doit être renseigné
			$errors_array[] = 'Vous devez renseigner un login !';
		}


		//Prenom
		if(isset($_POST['Prenom']))
		{
			$prenom = trim($_POST['Prenom']);
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
		else {

			// Doit être renseigné
			$errors_array[] = 'Vous devez renseigner un prénom !';
		}


		//Nom
		if(isset($_POST['Nom']))
		{
			$nom = trim($_POST['Nom']);
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
		else {

			// Doit être renseigné
			$errors_array[] = 'Vous devez renseigner un nom !';
		}

		//Génération mot de passe aléatoire et automatique
		// @todo: créer une fonction de génération de mot de passe

		//Adresse mail
		if(isset($_POST['Email']))
		{
			$mail = trim($_POST['Email']);
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
		else {

			// Doit être renseigné
			$errors_array[] = 'Vous devez renseigner une adresse mail !';
		}

		//Mail suite
		if(isset($_POST['EmailVerif']))
		{
			$mail_verif = trim($_POST['EmailVerif']);
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

			// Initialisation du tableau d'ue
			$reponse = lectureUE();
			$tableau_ue = array();
			$i = 1;

			// Remplissage du tableau d'ue avec les id ue
			foreach ($reponse as $donnees) {
				if (isset($_POST[$i])) {
					$tableau_ue[] = $donnees['ue_id'];
				}
				$i++;
			}
			// Inscription base de données
			$auto_mdp=ramdomMdp();
			if (createUti($auto_mdp, $_POST['Nom'],$_POST['Prenom'],$_POST['Login'],$_POST['Email'],$tableau_ue)) {

				// Création de l'utilisateur et ajout d'un message flash de succès
				setMessageFlash("L'utilisateur ".$_POST['Login']." a été créé avec succès.");

				// // Envoie d'un mail de notification à l'utilisateur avec son login et $auto_mdp
				// $email_from = 'berry.sylvain@free.fr'; // @todo: définir l'expéditeur du mail (l'application GetNote)
				// $email_to = $_POST['Email']; // @todo: getMailAdmin() faire la fonction de récupération du mail de l'administrateur pour l'envoi.

				// //@todo : temporaire
				// $mail_admin = getMailAdmin();
				// $email_to = $mail_admin; // @todo: getMailAdmin() faire la fonction de récupération du mail de l'administrateur pour l'envoi.

				// $objet = "Mail de notification de l'application GetNote pour validation d'inscription.";
				// $message = "Une inscription a été effectué sur l'application GetNote. Veuillé valide ou supprimer l'utilisateur nouvellement inscrit".$_POST['login']." (mot de passe : ".$auto_mdp.").";
				// envoiMail($email_from,$email_to,$email_replay,$objet,$message);

			}
			else {

				$errors_array[] = 'Une erreur est survenue. Merci de réessayer ultérieurement.';

			}
		}
		else {

			// Ajouter les messages du tableau en message flash
			setMessageFlash($errors_array,MESSAGE_FLASH_ERREUR);

		}
	} else {
		// Erreur retroubées
		$errors_array = array();

		//Login
		if(isset($_POST['Login']))
		{
			$login = trim($_POST['Login']);
			if ($uti_update['uti_login'] != $_POST['Login'])
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
				else
				 {
					// Doit être renseigné
					$errors_array[] = 'Vous devez renseigner un login !';
				}
			}
		}


		//Prenom
		if(isset($_POST['Prenom']))
		{
			$prenom = trim($_POST['Prenom']);

			if ($uti_update['uti_prenom'] != $_POST['Prenom'])
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
				else {
				// Doit être renseigné
				$errors_array[] = 'Vous devez renseigner un prénom !';
				}
			}
		}


		//Nom
		if(isset($_POST['Nom']))
		{
			$nom = trim($_POST['Nom']);

			if ($uti_update['uti_nom'] != $_POST['Nom'])
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
				} else
				{
					// Doit être renseigné
					$errors_array[] = 'Vous devez renseigner un nom !';
				}
			}
		}

		//Adresse mail
		if(isset($_POST['Email']))
		{
			$mail = trim($_POST['Email']);

			if ($uti_update['uti_mail'] != $_POST['Email'])
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
				else {

					// Doit être renseigné
					$errors_array[] = 'Vous devez renseigner une adresse mail !';
				}
			}
		}


		//Mail suite
		if(isset($_POST['Email']))
		{
			$mail_verif = trim($_POST['Email']);

			if ($uti_update['uti_mail'] != $_POST['Email'])
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


		// Si aucune erreur n'est trouvée
		if (empty($errors_array)) {

			// Initialisation du tableau d'ue
			$reponse = lectureUE();
			$tableau_ue = array();
			$i = 1;

			// Remplissage du tableau d'ue avec les id ue
			foreach ($reponse as $donnees) {
				if (isset($_POST[$i])) {
					$tableau_ue[$i] = $donnees['ue_id'];
				}
				$i++;
			}

			// Inscription base de données
			if (modifUti($uti_update, $_POST['Nom'],$_POST['Prenom'],$_POST['Login'],$_POST['Email'],$tableau_ue)) {

				// Modification de l'utilisateur et ajout d'un message flash de succès
				setMessageFlash("La modification de votre profil a été effectuée avec succès.");

				// Envoie d'un mail de notification à l'utilisateur pour la modification de son profil
				//$email_from = 'berry.sylvain@free.fr';  // @todo: définir l'expéditeur du mail.
				//$email_to = $_POST['mail'];
				//$objet = "Mail de notification suite à la modification de votre profil.";
				//$message = "Une modification de votre profil a été effectué sur l'application GetNote. Voici le résumé de cette modification: Nom: ".$_POST['nom']." Prenom: ".$_POST['prenom']." Login: ".$_POST['login']." Mail: ".$_POST['mail']." Mot de passe: ".$_POST['mdp']." Enseignement: ".$tableau_ue;
				//envoiMail($email_from,$email_to,$email_replay,$objet,$message);

				// Redirection connexion
				header( 'Location: '.LOGOUT ) ;
			}
			else {

				$errors_array[] = 'Une erreur est survenue. Merci de réessayer ultérieurement.';

			}
		}
		else {

			// Ajouter les messages du tableau en message flash
			setMessageFlash($errors_array,MESSAGE_FLASH_ERREUR);

		}

	}
}
	
// Redirection accueil administrators
header( 'Location: '.LOGIN_REDIRECT_ADMIN) ;
?>
