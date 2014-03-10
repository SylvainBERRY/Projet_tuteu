
-- Création de la table utilisateur
CREATE TABLE IF NOT EXISTS utilisateurs  (
  uti_id int(11) NOT NULL auto_increment,
  uti_nom varchar(32) NOT NULL,
  uti_prenom varchar(32) NOT NULL,
  uti_login varchar(32) NOT NULL,
  uti_mdp varchar(40) NOT NULL,
  uti_mail varchar(100) NOT NULL,
  uti_is_admin tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY uti_id (uti_id),
  UNIQUE (uti_login),
  UNIQUE (uti_mail)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;
