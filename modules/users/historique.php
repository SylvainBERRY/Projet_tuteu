<?php

  // Inclusion du modèle utilisateur
  // include_once CHEMIN_MODELE.'users.php';
  include_once 'modeles/users_modele.php';

  //Récupération login utilisateur
  $info_user = get_information_user( $_SESSION['id_user']);

  // Appel de la vue
  include_once '/vue/accueil_users_vue.php';


?>
