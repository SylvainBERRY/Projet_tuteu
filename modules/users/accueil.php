<?php

  // Inclusion du modèle utilisateur
  include_once CHEMIN_MODELE.'users.php';

  //Récupération login utilisateur
  $info_user = get_information_user( $_SESSION['id_user']);

  // Appel de la vue
  include_once '/vue/accueil.php';


?>