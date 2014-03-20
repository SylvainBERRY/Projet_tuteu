<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="<?php echo CHEMIN_STYLE ?>globale.css" />
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="<?php echo CHEMIN_JS ?>jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo CHEMIN_JS ?>tables.js"></script>
        <title>Aperçu</title>
    </head>
    <body>

        <header>

        </header>
    
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

        <footer>

        </footer>

    </body>
</html>