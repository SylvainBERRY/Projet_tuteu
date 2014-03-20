<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page connexion.php
*
*Page de connexion par defaut.
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions données)
*
*Liste des fonctions :
*--------------------------
*Aucune fonction
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/
// Si des données sont postées
if (!empty($_POST)) {

  // On regarde si les données postées sont valides
  if (isset($_POST['login']) && isset($_POST['mdp'])) {

    // Récupération des données
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    // Inclusion du modèle nécessaire
    include_once CHEMIN_MODELE.'users_modele.php';

    // On vérifie si le login existe
    if (couple_login_mdp_valide($login,$mdp)) {

      // Ajout de l'utilisateur en session
      if (login($login)) {

          // Création message flash de succès
          setMessageFlash('Vous avez bien été connecté(e).');
          
          if (administrateur_est_connecte()) {
              // Si administrateur redirection page d'administration
              header( 'Location: '.LOGIN_REDIRECT_ADMIN);
          }
          else {
            
              // Redirection
              header( 'Location: '.LOGIN_REDIRECT );
          }
      }

    }

  }
}

// Inclusion de la vue du formulaire
include_once CHEMIN_VUE.'connexion_vue.php';

?>
