<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page haut_administrators_vue.php
*
*Haut de page administrateur.
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
<!--
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>globale.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo CHEMIN_STYLE ?>jquery.dataTables.css">
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>administrators.css" />
		<link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>configuration.css" />
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables_config.js"></script>
        <title> <?php echo $titre_head; ?> </title>
    </head>
    <body>
		<header>
			<h1> <?php echo $titre_head; ?> </h1>
            <form id= "logout" action="index.php?action=deconnexion" method="post">
                <p>
                    <input type="submit" value="Logout" />
                </p>
            </form>
            <form id= "importation" action="<?php echo LOGIN_REDIRECT; ?>" method="post">
                <p>
                    <input type="submit" value="Gestion des notes" />
                </p>
            </form>
            <form id= "profil" action="<?php echo LOGIN_REDIRECT_PROFIL; ?>" method="post">
                <p>
                    <input type="submit" value="Gestion profil" />
                </p>
            </form>
		</header>
-->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="shurtcut icon" href="images/ico.ico" />
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>globale.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo CHEMIN_STYLE ?>jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables_admin.js"></script>
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables.js"></script>
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>administrators.css" />
        <title>Gestion utilisateur</title>
    </head>
    <body>
        <header>
            <a href="index.php?module=users&amp;action=importation"><img id="logo" src="images/logo_pf.png" alt="Logo" /><a>
            <p>
                <a href="index.php?action=deconnexion"><img src="images/logout.png" /><br/><span class="">LOGOUT</span></a>
                <a href="<?php echo LOGIN_REDIRECT_PROFIL ?>"><img src="images/profile.png" /><br/><span class="">PROFILE</span></a>
            </p>
            <?php $user_information = get_information_user($_SESSION['id_user']); ?>
            <h3>Utilisateur : <?php echo $user_information['uti_prenom'].' '.strtoupper($user_information['uti_nom']) ?></h3>
        </header>