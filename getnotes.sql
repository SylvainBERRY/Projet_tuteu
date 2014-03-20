-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 20 Mars 2014 à 15:23
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `getnotes`
--
CREATE DATABASE IF NOT EXISTS `getnotes` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `getnotes`;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE IF NOT EXISTS `etudiant` (
  `id_etud` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail1` varchar(255) DEFAULT NULL,
  `mail2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_etud`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18471 ;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`id_etud`, `nom`, `prenom`, `mail1`, `mail2`) VALUES
(18466, 'Vance', 'Lucian', 'hoctac@gmail.com', 'hoctac@hotmail.fr'),
(18467, 'Nguyen', 'Raja', 'takouert.elhocine@gmail.com', 'takouert.elhocine@hotmail.fr'),
(18468, 'Patel', 'Geoffrey', 'takouert.elhocine@gmail.com', 'hoctac@hotmail.fr'),
(18469, 'Head', 'Sebastian', 'hoctac@gmail.com', 'takouert.elhocine@hotmail.fr'),
(18470, 'Prince', 'Allen', 'takouert.elhocine@hotmail.fr', 'hoctac@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id_etud` int(11) NOT NULL,
  `type_note` varchar(255) NOT NULL,
  `valeur` float(4,2) NOT NULL,
  PRIMARY KEY (`id_etud`,`type_note`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `note`
--

INSERT INTO `note` (`id_etud`, `type_note`, `valeur`) VALUES
(18466, 'NOTE CC1', 13.00),
(18466, 'NOTE CC2', 10.00),
(18466, 'NOTE Exam', 4.00),
(18466, 'NOTE projet', 16.00),
(18467, 'NOTE CC1', 9.00),
(18467, 'NOTE CC2', 5.00),
(18467, 'NOTE Exam', 17.00),
(18467, 'NOTE projet', 7.00),
(18468, 'NOTE CC1', 14.00),
(18468, 'NOTE CC2', 0.00),
(18468, 'NOTE Exam', 2.00),
(18468, 'NOTE projet', 0.00),
(18469, 'NOTE CC1', 2.00),
(18469, 'NOTE CC2', 3.00),
(18469, 'NOTE Exam', 20.00),
(18469, 'NOTE projet', 5.00),
(18470, 'NOTE CC1', 15.00),
(18470, 'NOTE CC2', 14.00),
(18470, 'NOTE Exam', 13.00),
(18470, 'NOTE projet', 10.00);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `uti_id` int(11) NOT NULL AUTO_INCREMENT,
  `uti_nom` varchar(32) NOT NULL,
  `uti_prenom` varchar(32) NOT NULL,
  `uti_login` varchar(32) NOT NULL,
  `uti_mdp` varchar(40) NOT NULL,
  `uti_mail` varchar(100) NOT NULL,
  `uti_is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uti_id`),
  UNIQUE KEY `uti_login` (`uti_login`),
  UNIQUE KEY `uti_mail` (`uti_mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`uti_id`, `uti_nom`, `uti_prenom`, `uti_login`, `uti_mdp`, `uti_mail`, `uti_is_admin`) VALUES
(1, 'Lanquetin', 'Sandrine', 's.lanquetin', '0000', 'mail_sandrine@u-bourgogne.fr', 1),
(2, 'Savonnet', 'Marinette', 'm.savonnet', '0000', 'mail_marinette@u-bourgogne.fr', 0);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`id_etud`) REFERENCES `etudiant` (`id_etud`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
