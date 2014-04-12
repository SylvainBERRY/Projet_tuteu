<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page connexion_vue.php
*
*Page formulaire de connexion par defaut.
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
<section>
	<br/>
	<h1>Page de connexion</h1>

	<form class="remplir connexion" name="connexion" id="connexion" method="post" action="index.php?action=connexion">
	    <fieldset>
	    <label for="login" class="float">Login :</label>
	    <input type="text" name="login" id="login"/><br/>
	    <label for="mdp" class="float">Mot de passe :</label>
	    <input type="password" name="mdp" id="mdp"/><br/>
	    <div class="authentification"><input type="submit" value="Connexion" /><br/><br/>
		<a class="lien" href="index.php?module=public&amp;action=inscription" title="inscription">Nouveau ! Inscriver vous</a>
	</fieldset>
	</form>
	<br/>
</section>