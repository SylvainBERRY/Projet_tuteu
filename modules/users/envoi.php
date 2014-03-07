<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="styles/globale.css" />
        <script type="text/javascript" charset="utf8" src="scripts/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="scripts/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="scripts/tables.js"></script>
        <title>Envoi</title>
    </head>
    <body>

        <header>

        </header>
    
        <section>

        <?php

            require_once('fonctions_users.php');

            
           
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

            $objet = $_POST['objet'];
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $message_globale='';

            while($etudiant=$etudiants->fetch()) 
            {
                $message = $_POST['message'];

                for ($i=1; $i<=2; $i++) 
                {
                    $note=$notes->fetch();
                    $message.=$note['valeur'].' : '. $note['valeur'].'<br/>';
                }

                mail($etudiant['mail1'], $objet, $message, $headers);
                mail($etudiant['mail2'], $objet, $message, $headers);

                $message_globale.=$message;
            }

            $objet='Recapitulatif des message envoyé';

            mail($_SESSION['mail'], $objet, $message_globale, $headers);
        ?>

        </section>

        <footer>

        </footer>

    </body>
</html>