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
echo $_SESSION['etape'];
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
        <?php 
           }elseif ($_GET['action']=='configuration') {
        ?>
        <!-- Importation fichiers pour configuration -->
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>configuration.css" />
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables_config.js"></script>
        <?php } ?>
        <title><?php echo $_GET['action'] ?></title>
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>table_ue.js"></script>
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>table_ue.css" />
    </head>
    <body>
        <header>
            <a href="index.php?module=users&amp;action=importation"><img id="logo" src="images/logo_pf.png" alt="Logo" /></a>

            <nav style="background: url('<?php echo CHEMIN_IMAGE.'prog_'.$_SESSION['etape'] ?>.png') no-repeat bottom;" ><!-- Menu -->
                <ul>
                    <li><a <?php if($_GET['action']=='importation') echo 'id="ici"' ?> href="index.php?module=users&amp;action=importation">IMPORTATION</a></li>
                    <li><a <?php if($_GET['action']=='configuration') echo 'id="ici"' ?> <?php echo ($_SESSION['etape']>1)?'href="index.php?module=users&amp;action=configuration"':'class="none"' ?> >CONFIGURATION</a></li>
                    <li><a <?php if($_GET['action']=='envoi') echo 'id="ici"' ?> <?php echo ($_SESSION['etape']>2)?'href="index.php?module=users&amp;action=envoi':'class="none"' ?> >ENVOI EMAIL</a></li>
                </ul>
            </nav>
            <p>
                <a href="index.php?action=deconnexion"><img src="images/logout.png" /><br/><span class="">LOGOUT</span></a>
                <a href="<?php echo LOGIN_REDIRECT_PROFIL ?>"><img src="images/profile.png" /><br/><span class="">PROFIL</span></a>
            <?php if ($_SESSION['is_admin']) { ?>
                <a href="<?php echo LOGIN_REDIRECT_ADMIN ?>" ><img src="images/admin.png" /><br/><span class="">ADMIN</span></a>
            <?php } ?>
            </p>
            <?php $user_information = get_information_user($_SESSION['id_user']); ?>
            <h3>Utilisateur : <?php echo $user_information['uti_prenom'].' '.strtoupper($user_information['uti_nom']) ?></h3>
        </header>