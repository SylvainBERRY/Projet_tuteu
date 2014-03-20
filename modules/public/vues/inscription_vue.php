<!-- Formulaire d'inscription -->
	<div id="contenu">
		<h1>Formulaire d'inscription</h1>
		<p>Bienvenue sur la page d'inscription de mon site !<br/>
		Merci de remplir ces champs pour continuer.</p>
		<form name="inscription" id="inscription" action="index.php?action=connexion" method="post">
			<fieldset><legend>Identifiants</legend>
				<label for="login" class="float">Login :</label> <input type="text" name="login" id="login" size="30" /> <em>(3 à 32 caractères)</em><br />
				<label for="nom" class="float">Nom :</label> <input type="text" name="nom" id="nom" size="30" /><br />
				<label for="prenom" class="float">Prenom :</label> <input type="text" name="prenom" id="prenom" size="30" /><br />
				<label for="mdp" class="float">Mot de passe :</label> <input type="password" name="mdp" id="mdp" size="30" /> <em>(8 caractères)</em><br />
				<label for="mdp_verif" class="float">Mot de passe (vérification) :</label> <input type="password" name="mdp_verif" id="mdp_verif" size="30" /><br />
				<label for="mail" class="float">Mail :</label> <input type="text" name="mail" id="mail" size="30" /> <br />
				<label for="mail_verif" class="float">Mail (vérification) :</label> <input type="text" name="mail_verif" id="mail_verif" size="30" /><br />
				<div class="center"><input type="submit" value="Inscription" /></div>
			</fieldset>
		</form>
	</div>