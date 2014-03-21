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
<h1>Page de connexion</h1>

<form name="connexion" id="connexion" method="post" action="index.php?action=connexion">
  <fieldset>
    <legend>Connexion</legend>
    <label for="login" class="float">Login :</label>
    <input type="text" name="login" id="login"/><br/>
    <label for="mdp" class="float">Mot de passe :</label>
    <input type="password" name="mdp" id="mdp"/><br/>
    <div class="authentification"><input type="submit" value="Connexion" />
						<a href="index.php?module=public&action=inscription" title="inscription">Inscription</a> </div>
  </fieldset>
</form>
