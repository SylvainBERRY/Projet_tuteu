<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page global_functions.php
*
*Page contenant les fonctions globales qui vont être utilisées par l'application
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions donn?es)
*
*Liste des fonctions :
*--------------------------
*modifTitre($new_titre)
*administrateur_est_connecte()
*utilisateur_est_connecte()
*password($mdp)
*login($login)
*logout()
*setMessageFlash($message = "", $category = MESSAGE_FLASH_DEFAULT)
*getMessageFlash($category = MESSAGE_FLASH_DEFAULT)
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

// Inclusion du modèle pour récupérer les données utilisateur
include_once (CHEMIN_MODULE.'public/'.CHEMIN_MODELE.'users_modele.php');

/**
 * Modifie la variable $titre_head du fichier de configuration pour nommer une nouvelle page
 */
function modifTitre($new_titre) {
  $titre_head = $new_titre;
}

/**
 * Vérifie si un utilisateur est connecté en tant qu'administrateur
 * @return bool [vrai si l'utilisateur est connecté en tant qu'administrateur, faux sinon
 */
function administrateur_est_connecte() {
  return !empty($_SESSION['id_user']) && $_SESSION['is_admin'];
}

/**
 * Vérifie si un utilisateur est connecté
 * @return bool [vrai si l'utilisateur est connecté, faux sinon
 */
function utilisateur_est_connecte() {
  return !empty($_SESSION['id_user']);
}

/**
 * Fonction de cryptage utilisée pour les mots de passe utilisateur
 * @param  string $mdp
 * @return string $mdp en md5
 */
function password($mdp) {
  return $mdp;
  //return md5(SALT1.$mdp.SALT2);
}

/**
 * Connecte l'utilisateur.
 * @return bool [vrai en cas de succès, faux sinon]
 */
function login($login) {

  // Récupérer l'utilisateur en base de données
  $user_information = get_user($login);

  // Si l'utilisateur existe => connecte
  if ($user_information) {

    // Inscrire l'utilisateur dans $_SESSION['id_user']
    $_SESSION['id_user'] = $user_information['uti_id'];

    // Si l'utilisateur est super administration, inscrire dans $_SESSION['is_admin']
    if ($user_information['uti_is_admin']) {
      $_SESSION['is_admin'] = true;
    }
    else {
      $_SESSION['is_admin'] = false;
    }

    return true;
  }

  return false;
}

/**
 * Déconnexion de l'utilisateur courant
 */
function logout() {

  // Clean is admin
  if (isset($_SESSION['is_admin'])) {
    unset($_SESSION['is_admin']);
  }
  // Clean user id
  if (isset($_SESSION['id_user'])) {
    unset($_SESSION['id_user']);
  }
}

//////////////////////////
// Fonctions de service //
//////////////////////////

//@todo : faire une fonction de redirect

/**
 * Ajoute un message flash en session dans une catégorie donnée.
 * @param string $message  [Message à ajouter]
 * @param string $category [Catégorie dans laquelle ajouter le message.]
 */
function setMessageFlash($message = "", $category = MESSAGE_FLASH_DEFAULT) {
  $_SESSION[MESSAGE_FLASH][$category][] = $message;
}

/**
 * Lit et retourne les messages enregistrés en session dans la catégorie donnée.
 * @param  string $category [Catégorie contenant les messages que l'on souhaite récupérer]
 * @return array           [Messages de cette catégorie]
 */
function getMessageFlash($category = MESSAGE_FLASH_DEFAULT) {

  // On regarde si la category demandée existe
  if (isset($_SESSION[MESSAGE_FLASH][$category])) {

    // On récupère le/les messages
    $message = $_SESSION[MESSAGE_FLASH][$category];
    // On le retire de la session
    unset($_SESSION[MESSAGE_FLASH][$category]);
    // On le retourne
    return $message;
  }

  // Sinon on retourn un tableau vide
  return array();
}
?>