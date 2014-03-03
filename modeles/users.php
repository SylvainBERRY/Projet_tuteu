<?php

/**
 * Retourne les informations sur un utilisateur donné
 * @return array | bool
 */
function get_information_user($id_user) {

  $pdo = PDOSingleton::getInstance();

  $requete = $pdo->prepare("SELECT uti_id, uti_nom, uti_prenom, uti_login, uti_mail FROM utilisateurs WHERE uti_id = :uti_id");

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

  $requete = $pdo->prepare("SELECT uti_id, uti_is_admin FROM utilisateurs WHERE uti_login = :uti_login");

  $requete->bindValue(':uti_login', $login);

  $requete->execute();

  if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
    $requete->closeCursor();
    return $result;
  }

  return false;
}
/**
 * Retourne le résultat de la requete en fonction du login du formulaire d'inscription.
 * tooshort = login trop court
 * toolong = login trop long
 * exists = login existe déjà en BD
 * empty = login existe déjà en BD
 * ok = le login peut être utilisé pour l'inscription
 * @return string
 */
function check_login($login)
{
  if($login == '') return 'empty';
  else if(strlen($login) < 3) return 'tooshort';
  else if(strlen($login) > 32) return 'toolong';
  
  else
  {
    $pdo = PDOSingleton::getInstance();

    $requete = $pdo->prepare("SELECT COUNT(*) AS nbr FROM utilisateurs WHERE uti_login = :uti_login");

    $requete->bindValue(':uti_login', $login);

    $requete->execute();
    
    if($result = $requete->fetch(PDO::FETCH_ASSOC)) {
    $requete->closeCursor();
    }
    if($result['nbr'] > 0) return 'exists';
    else return 'ok';
  }
}
/**
 * Retourne l'id et le rang (admin ou non) d'un utilisateur.
 * Retourne faux si l'utilisateur n'est pas trouvé.
 * @return array | bool
 */
function check_prenom($prenom) {

  $pdo = PDOSingleton::getInstance();

  $requete = $pdo->prepare("SELECT uti_id, uti_is_admin FROM utilisateurs WHERE uti_login = :uti_login");

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

  $requete = $pdo->prepare("SELECT uti_id FROM utilisateurs WHERE uti_login = :uti_login AND uti_mdp = :uti_mdp");

  $requete->bindValue(':uti_login', $login);
  $requete->bindValue(':uti_mdp', password($mdp));

  $requete->execute();

  $result = $requete->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    return true;
  }

  return false;
}

?>
