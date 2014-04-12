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
*check_login($login) [Test le login renseigné dans le formulaire d'inscription]
*check_nom_prenom($nom_prenom) [Test le nom ou prénom renseigné dans le formulaire d'inscription]
*check_mdp($mdp) [Test le mot de passe renseigné dans le formulaire]
*check_mdp_conf($mdp_verif, $mdp2) [Test le mot de passe de confirmation renseigné dans le formulaire]
*checkmail($mail)
*checkmailS($mail_verif, $mail)
*envoiMail($email_from,$email_to,$email_replay,$objet,$message)
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
  if (!empty($_SESSION['id_user']) && $_SESSION['is_valide'])
    return true;
  else return false;
}

/**
 * Fonction de cryptage utilisée pour les mots de passe utilisateur
 * @param  string $mdp
 * @return string $mdp en md5
 */
function password($mdp) {
  //return $mdp;
  return md5(SALT1.$mdp.SALT2);
}

/**
 * Fonction de génération de mot de passe automatique utilisée pour les mots de passe utilisateur créé par l'administrateur
 * @return string $mdp
 */
function ramdomMdp() {
    // initialiser la variable $mdp
    $mdp = "";
  $longueur = 8;

    // Définir tout les caractères possibles dans le mot de passe,
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // obtenir le nombre de caractères dans la chaîne précédente
    $longueurMax = strlen($possible);

    if ($longueur > $longueurMax) {
        $longueur = $longueurMax;
    }

    // initialiser le compteur
    $i = 0;

    // ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
    while ($i < $longueur) {
        // prendre un caractère aléatoire
        $caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);

        // vérifier si le caractère est déjà utilisé dans $mdp
        if (!strstr($mdp, $caractere)) {
            // Si non, ajouter le caractère à $mdp et augmenter le compteur
            $mdp .= $caractere;
            $i++;
        }
    }
    return $mdp;
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
    if ($user_information['uti_is_valide']) {
      $_SESSION['is_valide'] = true;
    }
    else {
      $_SESSION['is_valide'] = false;
    }

    return true;
  }

  return false;
}

/**
 * Déconnexion de l'utilisateur courant
 */
function logout() {
  session_unset();
  session_destroy();
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


  //S'il y a plusieurs messages (tableau)
  if (is_array($message)) {
    foreach ($message as $aMessage) {
      $_SESSION[MESSAGE_FLASH][$category][] = $aMessage;
    }
  }
  else {

    // Si il n'y a qu'une message (string)
    $_SESSION[MESSAGE_FLASH][$category][] = $message;
  }

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

/**
 * Affiche les messages d'une catégorie (purge session catégorie)
 */
function printAllMessagesFlash() {

  $output = '';

  // Lister les catégories à afficher
  $output .= printAllMessagesCategorie();
  $output .= printAllMessagesCategorie(MESSAGE_FLASH_ERREUR);

  return $output;
}

/**
 * Affiche les messages d'une catégorie (purge session catégorie)
 */
function printAllMessagesCategorie($category = MESSAGE_FLASH_DEFAULT) {

  // Si des messages disponibles pour la catégorie
  if (isset($_SESSION[MESSAGE_FLASH][$category]) && is_array($_SESSION[MESSAGE_FLASH][$category]) && !empty($_SESSION[MESSAGE_FLASH][$category])) {

    // Purge categorie
    $data = getMessageFlash($category);

    // Chaine résultat
    $output = '<ul class="flash '.$category.'">';

    // Pour chaque message
    foreach ($data as $aData) {
      $output .= '<li>'.$aData.'</li>';
    }

    $output .= '</ul>';

    return $output;
  }

  // Return vide
  return '';
}

/**
 * Affiche les messages flashb souhaités.
 * @return [type] [description]
 */
function printHtmlFlashMessages() {

  $result = "";
  $result_errors = printAllMessagesCategorie(MESSAGE_FLASH_ERREUR);
  $result_success = printAllMessagesCategorie();

  if ($result_success != '') {
    $result = '<p class="success">';
    $result .= '<img src="'.CHEMIN_IMAGE.'success.png" alt="icone success"/>';
    $result .= $result_success;
    $result .= '</p>';
  }

  if ($result_errors != '') {
    $result .= '<p class="erreur">';
    $result .= '<img src="'.CHEMIN_IMAGE.'erreur.png" alt="icone Erreur"/>';
    $result .= $result_errors;
    $result .= '</p>';
  }

  return $result;
}

/**
 * Récupére le mail de l'administrateur
 */
function getMailAdmin(){

$pdo = PDOSingleton::getInstance();

$requete = $pdo->prepare("SELECT uti_mail FROM utilisateurs WHERE uti_is_admin = 1");

$requete->execute();

if($result = $requete->fetch(PDO::FETCH_ASSOC)) {
  $requete->closeCursor();
}
return $result;
}
/**
 * Retourne le résultat de la requete en fonction du login du formulaire d'inscription.
 * TOOSHORT = login trop court
 * TOOLONG = login trop long
 * EXISTS = login existe déjà en BD
 * VIDE = login non renseigné
 * OK = le login peut être utilisé pour l'inscription
 * @return string
 */
function check_login($login) {

  if($login == '') return VIDE;

  else if(strlen($login) < 3) return TOOSHORT;

  else if(strlen($login) > 32) return TOOLONG;

  else
  {
    $pdo = PDOSingleton::getInstance();

    $requete = $pdo->prepare("SELECT COUNT(*) AS nbr FROM utilisateurs WHERE uti_login = :uti_login");

    $requete->bindValue(':uti_login', $login);

    $requete->execute();

    if($result = $requete->fetch(PDO::FETCH_ASSOC)) {
      $requete->closeCursor();
    }

  if($result['nbr'] > 0) return EXISTS;

  else return OK;
  }
}
/**
 * Retourne le résultat des test sur le prenom ou le nom du formulaire d'inscription.
 * TOOSHORT = prenom ou nom est trop court
 * TOOLONG = prenom ou nom est trop long
 * VIDE = prenom ou nom est non renseigné
 * OK = prenom ou nom peut être utilisé pour l'inscription
 * @return string
 */
function check_nom_prenom($nom_prenom) {

  if($nom_prenom == '') return VIDE;

  else if(strlen($nom_prenom) < 3) return TOOSHORT;

  else if(strlen($nom_prenom) > 32) return TOOLONG;

  else return OK;
}
/**
 * Retourne le résultat des test sur le mdp du formulaire d'inscription.
 * TOOSHORT = mdp est trop court
 * TOOLONG = mdp est trop long
 * VIDE = mdp est non renseigné
 * OK = mdp peut être utilisé pour l'inscription
 * @return string
 */
function check_mdp($mdp)
{
  if($mdp == '') return VIDE;
  else if(strlen($mdp) < 4) return TOOSHORT;
  else if(strlen($mdp) > 50) return TOOLONG;

  else
  {
    if(!preg_match('#[0-9]{1,}#', $mdp)) return NOFIGURE;
    else if(!preg_match('#[A-Z]{1,}#', $mdp)) return NOUPCAP;
    else return OK;
  }
}
/**
 * Retourne le résultat des test sur le mdp et le mdp de confirmation du formulaire d'inscription.
 * TOOSHORT = mdp est trop court
 * TOOLONG = mdp est trop long
 * VIDE = mdp est non renseigné
 * OK = mdp peut être utilisé pour l'inscription
 * DIFFERENT = mdp et mdp2 de confirmation différent
 * @return string
 */
function check_mdp_conf($mdp_verif, $mdp2)
{
  if($mdp_verif != $mdp2 && $mdp_verif != '' && $mdp2 != '') return DIFFERENT;
  else return check_mdp($mdp_verif);
}
/**
 * Retourne le résultat des test sur l'adresse mail du formulaire d'inscription.
 * ISNT = l'adresse mail n'a pas une bonne structure
 * VIDE = adresse mail non renseigné
 * OK = l'adresse mail peut être utilisé pour l'inscription
 * EXIST = l'adresse mail est déjà utilisé par un autre utilisateur
 * @return string
 */
function checkmail($mail)
{
  if($mail == '') return VIDE;
  else if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $mail)) return ISNT;

  else
  {
    $pdo = PDOSingleton::getInstance();

      $requete = $pdo->prepare("SELECT COUNT(*) AS nbr FROM utilisateurs WHERE uti_mail = :uti_mail");

      $requete->bindValue(':uti_mail', $mail);

      $requete->execute();

      if($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
      }

    if($result['nbr'] > 0) return EXISTS;
      else return OK;
  }
}
/**
 * Retourne le résultat des test sur l'adresse mail de vérification du formulaire d'inscription.
 * OK = l'adresse mail peut être utilisé pour l'inscription
 * DIFFERENT = l'adresse mail de vérification est différente de l'adresse 1er adresse mail
 * @return string
 */
function checkmailS($mail_verif, $mail)
{
  if($mail_verif != $mail && $mail != '' && $mail_verif != '') return DIFFERENT;
  else return OK;
}
/**
 * Envoie d'un mail de notification
 */
function envoiMail($email_from,$name_from,$email_to,$email_replay,$objet,$message)
{
  if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $email_to)) // On filtre les serveurs qui rencontrent des bug.
  {
    $passage_ligne = "\r\n";
  }
  else
  {
    $passage_ligne = "\n";
  }

  $headers = "From: \"".$name_from."\" ".$email_from.$passage_ligne;
  $headers.= "Reply-to: \"".$name_from."\" ".$email_replay.$passage_ligne;
  $headers  .= 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    /*

  //=====Déclaration des messages au format texte et au format HTML.
  $message_txt = "Salut à tous, voici un e-mail envoyé par un script PHP.";
  $message_html = "<html><head></head><body><b>Salut à tous</b>, voici un e-mail envoyé par un <i>script PHP</i>.</body></html>";
  //==========

  //=====Création de la boundary
  $boundary = "-----=".md5(rand());
  //==========

  //=====Définition du sujet.
  $objet = "salut !";
  //=========

  //=====Création du header de l'e-mail.
  $header = "From: \"WeaponsB\"<hoctac@hotmail.fr>".$passage_ligne;
  $header.= "Reply-to: \"WeaponsB\" <hoctac@hotmail.fr>".$passage_ligne;
  $header.= "MIME-Version: 1.0".$passage_ligne;
  $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
  //==========

  //=====Création du message.
  $message = $passage_ligne."--".$boundary.$passage_ligne;
  //=====Ajout du message au format texte.
  $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
  $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
  $message.= $passage_ligne.$message_txt.$passage_ligne;
  //==========
  $message.= $passage_ligne."--".$boundary.$passage_ligne;
  //=====Ajout du message au format HTML
  $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
  $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
  $message.= $passage_ligne.$message_html.$passage_ligne;
  //==========
  $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
  $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
  //==========

  */

    //mail($email_to, $objet, $message, $headers);

}

/**
 * Retourne un tableau de tous les enseignements contenu dans la table enseignement
 * @return array | $result
 */
function lectureUENom($ue_id)
{
  $pdo = PDOSingleton::getInstance();

    $requete = $pdo->prepare("SELECT ue_nom FROM enseignement WHERE ue_id = :ue_id");

  $requete->bindValue(':ue_id', $ue_id);

    $requete->execute();

  if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
    $requete->closeCursor();
  return $result['ue_nom'];
  }
  return false;

}
/**
 * Retourne l'enseignements de l'utilisateur donn?e en param?tre
 * @return array | $result
 */
function lectureTabUEUti($uti_id)
{

  $pdo = PDOSingleton::getInstance();

    $requete = $pdo->prepare("SELECT ue_id FROM utilisateurs_ue WHERE uti_id = :uti_id");

    $requete->bindValue(':uti_id', $uti_id);

    $requete->execute();

    //get tableau vide
  while($result = $requete->fetch(PDO::FETCH_ASSOC))
  {
    $ue_uti[]=$result['ue_id'];
  }

  $requete->closeCursor();

  return $ue_uti;
}
/**
 * Retourne les enseignements de l'utilisateur donn?e en param?tre
 * @return array | $result
 */
function lectureUeUser($id)
{
    $tab_ue_uti = lectureTabUEUti($id);
    $tab_nom_ue = array();
    foreach ($tab_ue_uti as $id_tab => $value_id_ue) {
      $tab_nom_ue[] = lectureUENom($value_id_ue);
    }
  return $tab_nom_ue;
}
/**
 * Retourne le boolean qui montre si l'utilisateur est déjà connecté ou non
 * @return boolean | true si utilisateur déjà connecté ou false il peut se connecter 
 */
function check_uti_is_co($login)
{
  $pdo = PDOSingleton::getInstance();

  $requete = $pdo->prepare("SELECT uti_is_co FROM utilisateurs WHERE uti_login = :uti_login");
  $requete->bindValue(':uti_login', $login);
  $requete->execute();
  
  $result = $requete->fetch(PDO::FETCH_ASSOC);
  
  $is_co = $result['uti_is_co'];
  $requete->closeCursor();

  return $is_co;
}
?>
