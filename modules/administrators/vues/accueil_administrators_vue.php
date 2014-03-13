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
		<tr><th>Nom</th> <th>Pr&egrave;nom</th> <th>Email</th> <th>Login</th> </tr>
		<?php
		$reponse = lectureUti();
		while ($donnees = $reponse->fetch())
		{
		?>
			<tr><td>
			<input type="checkbox" name="<?php echo $donnees['id']; ?>" checked="checked" onclick="afficherLigne("<?php echo $donnees['id']; ?>");"></td>
			<td>
			<?php echo $donnees['nom']; ?></td>
			<td>
			<?php echo $donnees['prenom']; ?></td>
			<td>
			<?php echo $donnees['email']; ?></td>
			<td>
			<?php echo $donnees['login']; ?></td>
			</tr>
			<?php
		}
		?>
	</table> 
</p>
<p class="gestionUti">
	<form id="dataUti" method="post" action="traitDataUti.php">
		<p class="showDataUti">
		<!-- Affichage des donn&egrave;es de l'utilisateur s&egrave;lectionn&egrave; -->
			Nom
			<input type="text" id="nom" name="Nom" value="" size="15" />
			<br>
			Pr&egrave;nom
			<input type="text" id="prenom" name="Pr&egrave;nom" value="" size="15" />
			<br>
			Email
			<input type="text" id="email"name="Email" value="" size="15" />
			<br>
			Login
			<input type="text" id="login" name="Login" value="" size="15" />
		</p>
		<h1>
		<!-- Bouton de gestion utilisateur -->
			<input type="button" name="Modifier" value="Modifier l&apos;utilisateur" onclick="index.php?module=public&amp;action=modif_admin"/>
			<br>
			<input type="button" name="Supprimer" value="Supprimer l&apos;utilisateur" onclick="index.php?module=public&amp;action=suppr_admin" />
			<br>
			<input type="button" name="Creer" value="Nouveau utilisateur" onclick="index.php?module=public&amp;action=new_admin"  />
		</h1>
	</form>
</p>