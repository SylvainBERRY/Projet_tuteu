<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../../styles/globale.css" />
        <link rel="stylesheet" type="text/css" href="../../styles/jquery.dataTables.css">
        <link rel="stylesheet" href="../../styles/configuration.css" />
        <script type="text/javascript" charset="utf8" src="../../js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../../js/tables_config.js"></script>
        <title>Configuration</title>
    </head>
    <body>

        <header>

        </header>
    
        <section>
            <h1>Configuration des mails</h1>

             <form action="apercu.php" method="post" >
                <label for="ue" >UE :</label>
                <input id="ue" type="text" name="ue" />  
                <br/>
                <label for="enseignant" >Enseignant :</label>
                <input id="enseignant" type="text" name="enseignant" />
                <br/>
                <label for="objet" >Objet :</label>
                <input id="objet" type="text" name="objet" value="Note" />
                <br/>
                <label for="message" >Enseignant :</label>
                <br/>
                <textarea id="message" name="message" >Bonjour, Voici le note du :
                    
Cordialement</textarea>
                <br/>
                <input type="submit" value="envoyer" /><input type="submit" value="aperçu" /></br>
             
<?php

require_once('fonctions_users.php');

afficherTable1();

?>
            </form>
        </section>

        <footer>

        </footer>

    </body>
</html>