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
