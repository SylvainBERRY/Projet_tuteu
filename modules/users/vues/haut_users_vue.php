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
        <link rel="shurtcut icon" href="images/ico.ico" />
        <!-- Importation fichiers globales -->
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>globale.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo CHEMIN_STYLE ?>jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery.dataTables.min.js"></script>
        <?php if($_GET['action']=='importation')
                {

        ?>
        <!-- Importation fichiers pour importation -->
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>importation.css" />
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables_import.js"></script>
        <title>Importation</title>
        <?php 
           }elseif ($_GET['action']=='configuration') {
        ?>
        <!-- Importation fichiers pour configuration -->
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>configuration.css" />
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables_config.js"></script>
        <title>Configuration</title>
        <?php        } ?>
        <!-- Importation fichiers pour l'apercu et l'envoi-->
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables.js"></script>
        <!-- Importation fichiers pour l'historique-->
    </head>
    <body>
        <header>
            <img id="logo" src="images/logo_pf.png" alt="Logo" />

            <nav style="background: url('<?php echo CHEMIN_IMAGE.'prog_'.$_GET['action'] ?>.png') no-repeat bottom;" ><!-- Menu -->
                <ul>
                    <li><a <?php if($_GET['action']=='importation') echo 'id="ici"' ?> href="index.php?module=users&amp;action=importation">IMPORTATION</a></li>
                    <li><a <?php if($_GET['action']=='configuration') echo 'id="ici"' ?> href="index.php?module=users&amp;action=configuration">CONFIGURATION</a></li>
                    <li><a <?php if($_GET['action']=='envoi') echo 'id="ici"' ?> href="index.php?module=users&amp;action=envoi">ENVOI EMAIL</a></li>
                </ul>
            </nav>
            <p>
                <a href="<?php echo LOGIN_REDIRECT_PROFIL ?>"><img src="images/logout.png" /><br/><span class="">LOGOUT</span></a>
                <a href="index.php?action=deconnexion"><img src="images/profile.png" /><br/><span class="">PROFILE</span></a>
            <?php if ($_SESSION['is_admin']) { ?>
                <a href="<?php echo LOGIN_REDIRECT_ADMIN ?>" ><img src="images/admin.png" /><br/><span class="">ADMIN</span></a>
            <?php } ?>
            </p>
            <?php $user_information = get_information_user($_SESSION['id_user']); ?>
            <h3><?php echo strtoupper($user_information['uti_nom']).' '.$user_information['uti_prenom'] ?></h3>
        </header>