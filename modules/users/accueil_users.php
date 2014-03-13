<?php

  // Inclusion du modèle utilisateur
  include_once (CHEMIN_MODULE.CHEMIN_PUBLIC.CHEMIN_MODELE.'users_modele.php');

  //Récupération login utilisateur
  $info_user = get_information_user( $_SESSION['id_user']);

  // Appel de la vue
  include_once (CHEMIN_VUE.'accueil_users_vue.php');


?>
