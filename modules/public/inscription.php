<?php

// Si des données sont postées
if (!empty($_POST)) {

	// Inclusion du modèle nécessaire
  // include_once CHEMIN_MODELE.'inscription_modele.php';
  include_once CHEMIN_MODELE.'inscription_modele.php';

if($_SESSION['login'] == $_POST['login'] && trim($_POST['login']) != '')
{
	// Créer message flash et redirection utilisateur déjà inscrit et connecté avec le login $_POST['login']
	// Redirection accueil
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
		//$_SESSION['message_info'] = '<span class="erreur">Le login '.htmlspecialchars($login, ENT_QUOTES).' est trop court, vous devez en choisir un plus long (minimum 3 caractères).</span><br/>';
	}

	else if($login_result == TOOLONG)
	{
		// Ajout de l'erreur login trop long en message flash
		//$_SESSION['message_info'] = '<span class="erreur">Le login '.htmlspecialchars($login, ENT_QUOTES).' est trop long, vous devez en choisir un plus court (maximum 32 caractères).</span><br/>';
	}

	else if($login_result == EXISTS)
	{
		// Ajout de l'erreur login déjà utiliséen message flash
		//$_SESSION['message_info'] = '<span class="erreur">Le login '.htmlspecialchars($login, ENT_QUOTES).' est déjà pris, choisissez-en un autre.</span><br/>';
	}

	else if($login_result == OK)
	{
		//Login ok pas de message d'erreur en flash
		//$_SESSION['message_info'] = '';
	}

	else if($login_result == VIDE)
	{
		// Ajout de l'erreur vous n'avez pas rentré de login en message flash
		//$_SESSION['message_info'] = '<span class="erreur">Vous n\'avez pas entré de login.</span><br/>';
	}
}

else
{
	// Réaffichage du formulaire d'inscription erreur survenu
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
		//$_SESSION['message_info'] = '<span class="erreur">Le prénom '.htmlspecialchars($login, ENT_QUOTES).' est trop court, vous devez en choisir un plus long (minimum 3 caractères).</span><br/>';
	}

	else if($prenom_result == TOOLONG)
	{
		// Ajout de l'erreur prénom trop long en message flash
		//$_SESSION['message_info'] = '<span class="erreur">Le prénom '.htmlspecialchars($login, ENT_QUOTES).' est trop long, vous devez en choisir un plus court (maximum 32 caractères).</span><br/>';
	}

	else if($prenom_result == OK)
	{
		//Prénom ok pas de message d'erreur en flash
		//$_SESSION['message_info'] = '';
	}

	else if($prenom_result == VIDE)
	{
		// Ajout de l'erreur vous n'avez pas rentré de prénom en message flash
		//$_SESSION['message_info'] = '<span class="erreur">Vous n\'avez pas entré de prénom.</span><br/>';
	}
}

else
{
	// Réaffichage du formulaire d'inscription erreur survenu
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
		//$_SESSION['message_info'] = '<span class="erreur">Le nom '.htmlspecialchars($login, ENT_QUOTES).' est trop court, vous devez en choisir un plus long (minimum 3 caractères).</span><br/>';
	}

	else if($nom_result == TOOLONG)
	{
		// Ajout de l'erreur nom trop long en message flash
		//$_SESSION['message_info'] = '<span class="erreur">Le nom '.htmlspecialchars($login, ENT_QUOTES).' est trop long, vous devez en choisir un plus court (maximum 32 caractères).</span><br/>';
	}

	else if($nom_result == OK)
	{
		// Nom ok pas de message d'erreur en flash
		//$_SESSION['message_info'] = '';
	}

	else if($nom_result == VIDE)
	{
		// Ajout de l'erreur vous n'avez pas rentré de nom en message flash
		//$_SESSION['message_info'] = '<span class="erreur">Vous n\'avez pas entré de nom.</span><br/>';
	}
}

else
{
	// Réaffichage du formulaire d'inscription erreur survenu
}

//Mot de passe
if(isset($_POST['mdp']))
{
	$mdp = trim($_POST['mdp']);
	$mdp_result = check_mdp($mdp, '');
	if($mdp_result == TOOSHORT)
	{
		// Ajout de l'erreur mdp trop court en message flash
		//$_SESSION['message_info'] = '<span class="erreur">Le mot de passe '.htmlspecialchars($login, ENT_QUOTES).' est trop court, vous devez en choisir un plus long (minimum 3 caractères).</span><br/>';
	}

	else if($mdp_result == TOOLONG)
	{
		// Ajout de l'erreur mdp trop long en message flash
		//$_SESSION['message_info'] = '<span class="erreur">Le mot de passe '.htmlspecialchars($login, ENT_QUOTES).' est trop long, vous devez en choisir un plus court (maximum 32 caractères).</span><br/>';
	}

	else if($mdp_result == NOFIGURE)
	{
		// Ajout de l'erreur votre mot de passe doit contenir au moins un chiffre
		//$_SESSION['mdp_info'] = '<span class="erreur">Votre mot de passe doit contenir au moins un chiffre.</span><br/>';
	}

	else if($mdp_result == NOUPCAP)
	{
		// Ajout de l'erreur votre mot de passe doit contenir au moins une majuscule
		//$_SESSION['mdp_info'] = '<span class="erreur">Votre mot de passe doit contenir au moins une majuscule.</span><br/>';
	}

	else if($mdp_result == OK)
	{
		// Mdp ok pas de message d'erreur en flash
		//$_SESSION['message_info'] = '';
	}

	else if($mdp_result == VIDE)
	{
		// Ajout de l'erreur vous n'avez pas rentré de mdp en message flash
		//$_SESSION['message_info'] = '<span class="erreur">Vous n\'avez pas entré de not de passe.</span><br/>';

	}
}

else
{
	// Réaffichage du formulaire d'inscription erreur survenu
}

//Mot de passe confirmation
if(isset($_POST['mdp_verif']))
{
	$mdp_verif = trim($_POST['mdp_verif']);
	$mdp_verif_result = check_mdp_conf($mdp_verif, $mdp);
	if($mdp_verif_result == DIFFERENT)
	{
		// Ajout de l'erreur mot de passe de confirmation différent du mot de passe initial
		//$_SESSION['mdp_verif_info'] = '<span class="erreur">Le mot de passe de vérification diffère du mot de passe.</span><br/>';
	}

	else
	{
		if($mdp_verif_result == OK)
		{
			// Mdp de vérification ok pas de message d'erreur en flash
			//$_SESSION['message_info'] = '';
		}

		else
		{
			// Ajout erreur $mdp_verif_result trop court, trop long ...
			//$_SESSION['message_info'] = $mdp_verif_result;
		}
	}
}

else
{
	// Réaffichage du formulaire d'inscription erreur survenu
}

//mail
if(isset($_POST['mail']))
{
	$mail = trim($_POST['mail']);
	$mail_result = checkmail($mail);
	if($mail_result == 'isnt')
	{
		$_SESSION['mail_info'] = '<span class="erreur">Le mail '.htmlspecialchars($mail, ENT_QUOTES).' n\'est pas valide.</span><br/>';
		$_SESSION['form_mail'] = '';
		$_SESSION['erreurs']++;
	}

	else if($mail_result == 'exists')
	{
		$_SESSION['mail_info'] = '<span class="erreur">Le mail '.htmlspecialchars($mail, ENT_QUOTES).' est déjà pris, <a href="../contact.php">contactez-nous</a> si vous pensez à une erreur.</span><br/>';
		$_SESSION['form_mail'] = '';
		$_SESSION['erreurs']++;
	}

	else if($mail_result == 'ok')
	{
		$_SESSION['mail_info'] = '';
		$_SESSION['form_mail'] = $mail;
	}

	else if($mail_result == 'empty')
	{
		$_SESSION['mail_info'] = '<span class="erreur">Vous n\'avez pas entré de mail.</span><br/>';
		$_SESSION['form_mail'] = '';
		$_SESSION['erreurs']++;
	}
}

else
{
	header('Location: ../index.php');
	exit();
}

//mail suite
if(isset($_POST['mail_verif']))
{
	$mail_verif = trim($_POST['mail_verif']);
	$mail_verif_result = checkmailS($mail_verif, $mail);
	if($mail_verif_result == 'different')
	{
		$_SESSION['mail_verif_info'] = '<span class="erreur">Le mail de vérification diffère du mail.</span><br/>';
		$_SESSION['form_mail_verif'] = '';
		$_SESSION['erreurs']++;
	}

	else
	{
		if($mail_result == 'ok')
		{
			$_SESSION['mail_verif_info'] = '';
			$_SESSION['form_mail_verif'] = $mail_verif;
		}

		else
		{
			$_SESSION['mail_verif_info'] = str_replace(' mail', ' mail de vérification', $_SESSION['mail_info']);
			$_SESSION['form_mail_verif'] = '';
			$_SESSION['erreurs']++;
		}
	}
}

else
{
	header('Location: ../index.php');
	exit();
}

?>

<?php
	if($_SESSION['erreurs'] == 0)
{
		$insertion = "INSERT INTO utilisateurs (uti_nom, uti_prenom, uti_login, uti_mdp, uti_mail) VALUES('".mysql_real_escape_string($nom)."', '".mysql_real_escape_string($prenom)."', '".mysql_real_escape_string($login)."', '".md5($mdp)."', '".mysql_real_escape_string($mail)."');'";
			if(mysql_query($insertion))
			{
				$queries++;
				vidersession();
				$_SESSION['inscrit'] = $login;
				/*informe qu'il s'est déjà inscrit s'il actualise, si son navigateur
				bugue avant l'affichage de la page et qu'il recharge la page, etc.*/
?>
	<h1>Inscription validée !</h1>
	<p>Nous vous remercions de vous être inscrit sur notre site, votre inscription a été validée !<br/>
	Vous pouvez vous connecter avec vos identifiants <a href="connexion.php">ici</a>.
	</p>
<?php
			}

	else
	{
		if(stripos(mysql_error(), $_SESSION['form_login']) !== FALSE) // recherche du login
		{
			unset($_SESSION['form_login']);
			$_SESSION['login_info'] = '<span class="erreur">Le login '.htmlspecialchars($login, ENT_QUOTES).' est déjà pris, choisissez-en un autre.</span><br/>';
			$_SESSION['erreurs']++;
		}

		if(stripos(mysql_error(), $_SESSION['form_mail']) !== FALSE) //recherche du mail
		{
			unset($_SESSION['form_mail']);
			unset($_SESSION['form_mail_verif']);
			$_SESSION['mail_info'] = '<span class="erreur">Le mail '.htmlspecialchars($mail, ENT_QUOTES).' est déjà pris, <a href="../contact.php">contactez-nous</a> si vous pensez à une erreur.</span><br/>';
			$_SESSION['mail_verif_info'] = str_replace('mail', 'mail de vérification', $_SESSION['mail_info']);
			$_SESSION['erreurs']++;
			$_SESSION['erreurs']++;
		}

		if($_SESSION['erreurs'] == 0)
		{
			$sqlbug = true; //plantage SQL.
			$_SESSION['erreurs']++;
		}
	}
}
?>
<?php
		if($_SESSION['erreurs'] > 0)
		{
			if($_SESSION['erreurs'] == 1) $_SESSION['nb_erreurs'] = '<span class="erreur">Il y a eu 1 erreur.</span><br/>';
			else $_SESSION['nb_erreurs'] = '<span class="erreur">Il y a eu '.$_SESSION['erreurs'].' erreurs.</span><br/>';
?>
		<h1>Inscription non validée.</h1>
		<p>Vous avez rempli le formulaire d'inscription du site et nous vous en remercions, cependant, nous n'avons
		pas pu valider votre inscription, en voici les raisons :<br/>
<?php
		echo $_SESSION['nb_erreurs'];
		echo $_SESSION['nom_info'];
		echo $_SESSION['login_info'];
		echo $_SESSION['prenom_info'];
		echo $_SESSION['mdp_info'];
		echo $_SESSION['mdp_verif_info'];
		echo $_SESSION['mail_info'];
		echo $_SESSION['mail_verif_info'];
	}
?>
