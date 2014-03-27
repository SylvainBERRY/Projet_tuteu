<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page accueil_administrators_vue.php
*
*Page d'accueil de l'administrateur.
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
<!-- Panneau de configuration utilisateurs -->
<p class="listeUti"> 
	<h1>
		Utilisateurs
	</h1>
	<!-- Affichage de la liste des utilisateurs avec choix possible -->
	 <table name="tableauUti">
		<thead><tr><th></th><th>Nom</th> <th>Pr&egrave;nom</th> <th>Email</th> <th>Login</th> <th>Valide</th> </tr></thead>
		<tbody>
		<?php
		$reponse = lectureUti();

		foreach ($reponse as $donnees) {
		?>
			<tr>
			<td>
			<!-- Effectuer le traitement AJAX pour afficher les données de la ligne coché dans le formulaire ci-dessous (dataUti) -->
			<input type="checkbox" name="<?php echo $donnees['uti_id']; ?>"/></td>
			<td>
			<?php echo $donnees['uti_nom']; ?></td>
			<td>
			<?php echo $donnees['uti_prenom']; ?></td>
			<td>
			<?php echo $donnees['uti_mail']; ?></td>
			<td>
			<?php echo $donnees['uti_login']; ?></td>
			<td>
			<?php 
			if ($donnees['uti_is_valide']) 
			{ echo 'Validé'; }
			else { echo 'Non validé';}
			?></td>
			</tr>
			
			<?php
		}
		?>
	</tbody>
	</table> 
</p>
<p class="gestionUti">
	<form id="dataUti" method="post" action="index.php?module=administrators&action=traite_administrators">
		<p>
		<!-- Affichage des donn&egrave;es de l'utilisateur s&egrave;lectionn&egrave; -->
			Nom
			<input type="text" name="Nom" value="" size="15" />
			<br>
			Pr&egrave;nom
			<input type="text" name="Prenom" value="" size="15" />
			<br>
			Email
			<input type="text" name="Email" value="" size="15" />
			<br>
			Login
			<input type="text" name="Login" value="" size="15" />

		<!-- Affichage les ue de l'utilisateur -->
			<table name="tableauUE">
			<thead><tr><th></th><th>Nom UE</th></tr></thead>
			<tbody>
			<?php
			$reponse = lectureUE();
			$compteur = 0;

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
		</p>
		<h1>
		<!-- Bouton de gestion utilisateur -->
			<input type="submit" name="modif_uti" value="Modifier" />
			<br>
			<input type="submit" name="modif_uti" value="Supprimer" />
			<br>
			<input type="submit" name="modif_uti" value="Nouveau" />
		</h1>
	</form>
</p>