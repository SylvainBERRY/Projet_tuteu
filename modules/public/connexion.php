<?php

  // Si des données sont postées
  if (!empty($_POST)) {

    // On regarde si les données postées sont valides
    if (isset($_POST['login']) && isset($_POST['mdp'])) {

      // Récupération des données
      $login = $_POST['login'];
      $mdp = $_POST['mdp'];

      // Inclusion du modèle nécessaire
      include_once CHEMIN_MODELE.'users.php';

      // On vérifie si le login existe
      if (couple_login_mdp_valide($login,$mdp)) {

        // Ajout de l'utilisateur en session
        if (login($login)) {

          // @todo : Mettre message flash de succès
          // Redirection
          header( 'Location: '.LOGIN_REDIRECT );
        }

      }

    }
  }

  // Inclusion de la vue du formulaire
  include_once 'vue/connexion.php';

?>
