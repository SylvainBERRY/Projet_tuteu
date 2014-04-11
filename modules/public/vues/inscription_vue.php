<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page inscription_vue.php
*
*Page vue d'inscription par defaut.
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
?>

<!-- Formulaire d'inscription -->
<section>
	<br/>
	<div id="contenu">
		<h1>Formulaire d'inscription</h1>
		Merci de remplir ces champs pour continuer.</p>
		<form class="remplir inscription" name="inscription" id="inscription" action="index.php?action=inscription" method="post">
				<fieldset>
				<label for="login" class="float">Login :</label> <input type="text" name="login" id="login" size="30" /><br/><em>(3 à 32 caractères)</em>
				<label for="nom" class="float">Nom :</label> <input type="text" name="nom" id="nom" size="30" /><br />
				<label for="prenom" class="float">Prénom :</label> <input type="text" name="prenom" id="prenom" size="30" /><br/>
				<label for="mdp" class="float">Mot de passe :</label> <input type="password" name="mdp" id="mdp" size="30" /><br/><em>(8 caractères)</em>
				<label for="mdp_verif" class="float">Vérification :</label> <input type="password" name="mdp_verif" id="mdp_verif" size="30" /><br />
				<label for="mail" class="float">Adresse mail :</label> <input type="text" name="mail" id="mail" size="30" /> <br />
				<label for="mail_verif" class="float">Vérification :</label> <input type="text" name="mail_verif" id="mail_verif" size="30" /><br />
				</fieldset>
				<br/>
				<table name="tableauUE" id="tableauUE">
				<label>Nom des modules :<label>
				<thead><tr><th></th><th></th></tr></thead>
				<tbody>
				<?php
				$reponse = lectureUE();
				$compteur = 1;

				foreach ($reponse as $donnees) {
				?>
				<tr>
					<td><input type="checkbox" name="<?php echo $compteur ?>"/></td>
					<td><label for="ue" class="float"><?php echo $donnees['ue_nom']; ?></label></td>
				</tr>
				<?php
				$compteur ++;
				}
				?>
				</tbody>
				</table>
				<div class="center"><input type="submit" value="Inscription" /></div>
				<br/>
		<a href="index.php?action=connexion" >Retourner à la page de connexion</a>
		</form>
	</div>
<br/>
</section>
