<?php
/*
BERRY Sylvain & El-Hocine Takouert
Page haut.php

Page incluse cr?ant le doctype etc etc.

Quelques indications : (utiliser l'outil de recherche et rechercher les mentions donn?es)

Liste des fonctions :
--------------------------
Aucune fonction
--------------------------


Liste des informations/erreurs :
--------------------------
Aucune information/erreur
--------------------------
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
	<?php
	/**********V?rification du titre...*************/

	if(isset($titre) && trim($titre) != '')
	$titre = $titre.' : '.TITRESITE;

	else
	$titre = TITRESITE;

	/***********Fin v?rification titre...************/
	?>
		<title><?php echo $titre; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="language" content="fr" />
		<link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>includes/design.css" type="text/css" media="screen" />
	</head>


	<body>
		<div id="banniere">
			<a href="<?php echo ROOTPATH;?>/index.php"><img src="<?php echo ROOTPATH; ?>/images/banniere.jpg"/></a>
		</div>

		<div id="menu">
			<div id="menu_gauche">
			<!-- Vide, mettez-y les liens qui ne d?pendent pas du statut
			du membre (connect? ou non) -->
			</div>

			<div id="menu_droite">
			<?php
			if (utilisateur_est_connecte())
			{
			?>
				<a href="<?php echo ROOTPATH; ?>/utilisateurs/moncompte.php">Gérer mon compte</a>   <a href="index.php?module=public&action=deconnexion">Se déconnecter</a>
			<?php
			}

			else
			{
			?>
				<a href="index.php?module=public&action=inscription">Inscription</a>   <a href="index.php?module=public&action=connexion">Connexion</a>
			<?php
			}
			?>
			</div>
		</div>
