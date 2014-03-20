<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page haut_public_vue.php
*
*Haut de page public.
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
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE?>globale.css" />
        <title> <?php echo $titre_head; ?> </title>
    </head>
    <body>
		<header>
			<h1> <?php echo $titre_head; ?> </h1>
            <form id= "connexion" action="index.php?action=connexion" method="post">
                <p>
                    <input type="submit" value="Connexion" />
                </p>
            </form>
			<form id= "logout" action="index.php?action=deconnexion" method="post">
                <p>
                    <input type="submit" value="Logout" />
                </p>
            </form>
		</header>