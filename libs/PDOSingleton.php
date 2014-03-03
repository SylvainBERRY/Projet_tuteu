<?php

/**
 * Classe implémentant le singleton pour PDO
 */
class PDOSingleton extends PDO {

  // Instance unique
  private static $_instance;

  // Constructeur : héritage public obligatoire par héritage de PDO
  // Ne pas appeler en dehors de cette classe
  public function __construct() {
  }

  // Méthode pour récupérer la seule instance - Singleton
  public static function getInstance() {

    // Si premier appel, créer l'instance
    if (!isset(self::$_instance)) {

      try {

        self::$_instance = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);

      } catch (PDOException $e) {

        if ($e->getMessage()=='SQLSTATE[08006] [7] could not translate host name "tuxa.sme.utc" to address: nodename nor servname provided, or not known'){
          echo "Echec de la connexion avec la BDD !</br>";
          die ('Erreur : ' .$e->getMessage());
        } else {
          die ('Erreur : ' .$e->getMessage());
        }
      }
    }

    // Retourner l'instace
    return self::$_instance;
  }
}

?>
