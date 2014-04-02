<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page apercu_vue.php
*
*Page vue de l'aperçu utilisateur.
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
<title>Aperçu</title>
<section>
<?php

$objet = $_POST['objet'];
$message = $_POST['message'];

while($etudiant=$etudiants->fetch()) 
{
    
    echo 'Etudiant : '.$etudiant['nom'].' '.$etudiant['prenom'].' - < '.$etudiant['mail1'].' > < '.$etudiant['mail2'].' > <br/>';
    echo 'Objet : '.$objet.'<br/>';

    echo 'Message : <br/>';
    echo $message.'<br/>';
    echo 'Notes : <br/>';

    for ($i=1; $i <=2 ; $i++) 
    {
        $note=$notes->fetch();
        echo 'Note '.$i.' :'. $note['valeur'].'<br/>';
    }
    echo '<br/><br/>';
}
?>
</section>