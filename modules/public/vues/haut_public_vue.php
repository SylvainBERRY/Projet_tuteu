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
            <?php
            if (!empty($_SESSION['id_user'])) {
            ?>
                <form id= "logout" action="<?php echo LOGOUT; ?>" method="post">
                    <p>
                        <input type="submit" value="Logout" />
                    </p>
                </form>
                <form id= "importation" action="<?php echo LOGIN_REDIRECT; ?>" method="post">
                    <p>
                        <input type="submit" value="Gestion des notes" />
                    </p>
                </form>
                <?php
                if ($_SESSION['is_admin']) {
                ?>
                    <form id= "admin" action="<?php echo LOGIN_REDIRECT_ADMIN; ?>" method="post">
                        <p>
                            <input type="submit" value="Gestion des utilisateurs" />
                        </p>
                    </form>
                <?php
                }
            }
            ?>
            <?php
            if (!empty($_GET['action']))
            {
                $action = $_GET['action'];
                if ($action == 'inscription' || $action == 'acces_interdit' || $action == 'erreur404')
                {
                ?>
                    <form id= "connexion" action="<?php echo LOGOUT_REDIRECT; ?>" method="post">
                        <p>
                            <input type="submit" value="Connexion" />
                          </p>
                    </form>
                <?php
                }
            }
            ?>
		</header>
