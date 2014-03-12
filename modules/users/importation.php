<?php

include_once 'fonctions_importation.php';

include_once CHEMIN_MODELE.'importation_modele.php';

if(isset($_POST['valider'])) {
    header('Location:index.php?module=users&action=configuration');
}

include_once CHEMIN_VUE.'importation_vue.php';

?>
