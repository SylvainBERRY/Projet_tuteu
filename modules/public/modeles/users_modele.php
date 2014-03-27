<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page users_modele.php
*
*Page modele pour l'inscription
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions données)
*
*Liste des fonctions :
*--------------------------
*get_information_user($id_user) [Retourne les informaitons de l'utilisateur avec l'id donné en paramètre]
*get_user($login) [Retourne l'id et le rang (admin ou non) d'un utilisateur]
*couple_login_mdp_valide($login,$mdp) [Vérifie si le couple login/mdp est valide]
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

/**
 * Retourne les informations sur un utilisateur donné
 * @return array | bool
 */
function get_information_user($id_user) {

  $pdo = PDOSingleton::getInstance();

  $requete = $pdo->prepare("SELECT uti_id, uti_nom, uti_prenom, uti_login, uti_mail, uti_is_valide, uti_ue_id FROM utilisateurs WHERE uti_id = :uti_id");

  $requete->bindValue(':uti_id', $id_user);

  $requete->execute();

  if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
    $requete->closeCursor();
    return $result;
  }

  return false;
}

/**
 * Retourne l'id et le rang (admin ou non) d'un utilisateur.
 * Retourne faux si l'utilisateur n'est pas trouvé.
 * @return array | bool
 */
function get_user($login) {

  $pdo = PDOSingleton::getInstance();

  $requete = $pdo->prepare("SELECT uti_id, uti_is_admin, uti_is_valide FROM utilisateurs WHERE uti_login = :uti_login");

  $requete->bindValue(':uti_login', $login);

  $requete->execute();

  if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
    $requete->closeCursor();
    return $result;
  }

  return false;
}
/**
 * Vérifie si le couple login/mdp est valide.
 * @param  string $login [identification de l'utilisateur]
 * @param  string $mdp   [mot de passe (non chiffré) de l'utilisateur]
 * @return bool
 */
function couple_login_mdp_valide($login,$mdp) {

  $pdo = PDOSingleton::getInstance();

  $requete = $pdo->prepare("SELECT uti_id FROM utilisateurs WHERE uti_login = :uti_login AND uti_mdp = :uti_mdp AND uti_is_valide = :uti_is_valide");

  $requete->bindValue(':uti_login', $login);
  $requete->bindValue(':uti_mdp', password($mdp));
  $requete->bindValue(':uti_is_valide', true);

  $requete->execute();

  $result = $requete->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    return true;
  }

  return false;
}

?>
