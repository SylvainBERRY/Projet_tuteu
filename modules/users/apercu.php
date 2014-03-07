<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../../styles/globale.css" />
        <script type="text/javascript" charset="utf8" src="../../js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../../js/tables.js"></script>
        <title>Aperçu</title>
    </head>
    <body>

        <header>

        </header>
    
        <section>

        <?php

            require_once('fonctions_users.php');

            $objet = $_POST['objet'];
            $message = $_POST['message'];

            foreach (array_keys($_POST) as $checkbox) 
            {
                if(preg_match("/checkbox/", $checkbox))    $checkboxs[]=preg_replace("/checkbox_/","",$checkbox);
            }

            $num_etud='(';

            foreach($checkboxs as $num)
            {
                $num_etud.=$num.',';
            }

            $num_etud=trim($num_etud,',');

            $num_etud.=')';

            $etudiants=$bdd->query('SELECT * FROM etudiant 
                WHERE id_etud IN '.$num_etud);

            $notes=$bdd->query('SELECT * FROM note
                WHERE id_etud IN '.$num_etud);

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