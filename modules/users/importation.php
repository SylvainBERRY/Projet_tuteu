<?php

include_once 'fonctions_importation.php';

include_once 'modeles/importation_modele.php';

if(isset($_POST['valider'])) {
    header('Location:configuration.php');
}

include_once 'vue/importation_vue.php';

?>
