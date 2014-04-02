<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page profil_vue.php
*
*Page vue de la gestion de profil par defaut.
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

<!-- Formulaire de modification de profil -->
<div id="contenu">
	<h1>Gestion de profil</h1>
	<p>Bienvenue sur la page de gestion de votre profil<br/></p>
	<form name="modifProfil" id="modifProfil" action="index.php?action=profil" method="post">
		<fieldset><legend>Identifiants</legend>
			<?php
				$reponse = lectureUti();
				$tableauUE = "";
				foreach ($reponse as $donnees) {
				$tableauUE = $donnees['uti_ue_id'];
			?>
			<label for="login" class="float">Login :</label> 
			<input type="text" name="login" id="login" size="30" value="<?php echo $donnees['uti_login']; ?>"/> <em>(3 à 32 caractères)</em><br />
			<label for="nom" class="float">Nom :</label> 
			<input type="text" name="nom" id="nom" size="30" value="<?php echo $donnees['uti_nom']; ?>" /><br />
			<label for="prenom" class="float">Prenom :</label> 
			<input type="text" name="prenom" id="prenom" size="30" value="<?php echo $donnees['uti_prenom']; ?>" /><br />
			<label for="mdp" class="float">Mot de passe :</label> 
			<input type="password" name="mdp" id="mdp" size="30" /> <em>(8 caractères)</em><br />
			<label for="mdp_verif" class="float">Mot de passe (vérification) :</label> <input type="password" name="mdp_verif" id="mdp_verif" size="30" /><br />
			<label for="mail" class="float">Mail :</label> 
			<input type="text" name="mail" id="mail" size="30" value="<?php echo $donnees['uti_mail']; ?>"/> <br />
			<label for="mail_verif" class="float">Mail (vérification) :</label> 
			<input type="text" name="mail_verif" id="mail_verif" size="30" value="<?php echo $donnees['uti_mail']; ?>" /><br />
			<?php
			}
			?>
			<table name="tableauUE">
			<thead><tr><th></th><th>Nom UE</th></tr></thead>
			<tbody>
			<?php
			$reponse = lectureUE();
			$compteur = 1;

			foreach ($reponse as $donnees) {
			?>
			<tr>
				<td><input type="checkbox" name="<?php echo $compteur ?>" "
					<?php  
					if (!empty($tableauUE) && strpbrk($tableauUE, $compteur) != false)
					{ 
						echo "checked = true";
					} else {
						echo "";
					} 
					?>"/></td>
				<td><label for="ue" class="float"><?php echo $donnees['ue_nom']; ?></label></td>
			</tr>
			<?php
			$compteur ++;
			}
			?>
			</tbody>
			</table> 
			<div class="center"><input type="submit" value="Modifier" /></div>
		</fieldset>
	</form>
</div>