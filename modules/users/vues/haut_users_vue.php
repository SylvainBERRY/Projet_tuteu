<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page haut_users_vue.php
*
*Haut de page utilisateur.
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
        <!-- Importation fichiers globales -->
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>globale.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo CHEMIN_STYLE ?>jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery.dataTables.min.js"></script>
        <!-- Importation fichiers pour importation -->
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>importation.css" />
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables_import.js"></script>
        <!-- Importation fichiers pour configuration -->
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>configuration.css" />
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables_config.js"></script>
        <!-- Importation fichiers pour l'apercu et l'envoi-->
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables.js"></script>
        <!-- Importation fichiers pour l'historique-->
    </head>
    <body>
        <header>
            <h1> <?php echo $titre_head; ?> </h1>
            <form id= "logout" action="index.php?action=deconnexion" method="post">
                <p>
                    <input type="submit" value="Logout" />
                </p>
            </form>
            <form id= "profil" action="<?php echo LOGIN_REDIRECT_PROFIL; ?>" method="post">
                <p>
                    <input type="submit" value="Gestion profil" />
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
            ?>
        </header>