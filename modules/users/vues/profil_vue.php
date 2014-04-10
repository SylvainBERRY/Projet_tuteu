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
<section>
	<br/>
<div id="contenu">
	<h1>Gestion de profil</h1>
	<p>Bienvenue sur la page de gestion de votre profil<br/></p>

	<form name="modifProfil" id="modifProfil" action="index.php?action=profil" method="post">
			<?php
				$reponse = lectureUti();
				foreach ($reponse as $key => $donnees) {
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
			<br/>
			<table id="tableauUE">
				<label>Nom des modules :<label>
				<thead><tr><th></th><th></th></tr></thead>
				<tbody>
					<?php

					// Liste toutes les UE
					$reponseUE = lectureUE();
					// Liste toutes les UE de l'utilisateur
					$tab_ue_uti_origin = lectureUEUti($_SESSION['id_user']);

					// Récupération des ids
					$tab_ue_uti = array();
					if ($tab_ue_uti_origin) {
						foreach ($tab_ue_uti_origin as $uneLigne) {
							array_push($tab_ue_uti, $uneLigne['ue_id']);
						}
					}

					foreach ($reponseUE as $key => $donneesUE) {
					?>
					<tr>
						<td><input name="<?php echo $donneesUE['ue_id']; ?>" type="checkbox" id="<?php echo $donneesUE['ue_id']; ?>"
							<?php


							if (in_array($donneesUE['ue_id'],$tab_ue_uti))
							{
								echo "checked";
							} else {
								echo "";
							}
							?>/></td>
						<td><label for="ue" class="float"><?php echo $donneesUE['ue_nom']; ?></label></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<div class="center"><input type="submit" value="Modifier" /></div>
	</form>
</div>
<br/>
</section>