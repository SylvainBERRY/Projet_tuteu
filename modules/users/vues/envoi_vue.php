<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page envoi_vue.php
*
*Page vue pour l'envoi des mails.
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
<section>
	<br/><br/><br/><br/>
<?php
echo '<script type="text/javascript">$("nav").css("background-image", "url('.CHEMIN_IMAGE.'prog_'.$_SESSION['etape'].'.png)"); </script>';
?>

<h1 class="succes">
	<img src="<?php echo CHEMIN_IMAGE ?>succes.png" alt="icone succes"/>
	L'envoi des mails est réalisé avec succés
</h2>
<p>
<br/>
	Vous avez reçu un mail récapitulatif sur votre boite mail 
	<br/>Merci
</p>
<br/>
</section>