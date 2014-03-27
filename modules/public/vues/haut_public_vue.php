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
        <link rel="stylesheet" type="text/css" href="<?php echo CHEMIN_STYLE ?>jquery.dataTables.css">
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>configuration.css" />
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables_config.js"></script>
        <title> <?php echo $titre_head; ?> </title>
    </head>
    <body>
		<header>
			<h1> <?php echo $titre_head; ?> </h1>
		</header>