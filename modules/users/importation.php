<?php

  // Inclusion du modèle importation
  include_once CHEMIN_MODELE.'importation_modele.php';

  //Récupération login utilisateur
  $info_user = get_information_user($_SESSION['id_user']);

  // Appel de la vue
  include_once CHEMIN_VUE.'importation_vue.php';


?>
