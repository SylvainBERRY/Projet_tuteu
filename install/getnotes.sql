-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 11 Avril 2014 à 13:59
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
-- Structure de la table `enseignement`
--

CREATE TABLE IF NOT EXISTS `enseignement` (
  `ue_id` int(11) NOT NULL AUTO_INCREMENT,
  `ue_nom` varchar(30) NOT NULL,
  PRIMARY KEY (`ue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Contenu de la table `enseignement`
--

INSERT INTO `enseignement` (`ue_id`, `ue_nom`) VALUES
(1, 'Systèmes, réseaux et sécurité '),
(2, 'Bases de données, persistance '),
(3, 'Génie logiciel et modélisation'),
(4, 'Langages pour le web '),
(5, 'Programmation orientée objet e'),
(6, 'Culture d’entreprise - Anglais'),
(7, 'Projet tuteuré - Gestion de pr'),
(8, 'Stage en entreprise '),
(9, 'Systèmes, réseaux et sécurité '),
(10, 'Bases de données, persistance '),
(11, 'Génie logiciel et modélisation'),
(12, 'Langages pour le web '),
(13, 'Programmation orientée objet e'),
(14, 'Culture d’entreprise - Anglais'),
(15, 'Projet tuteuré - Gestion de pr'),
(16, 'Stage en entreprise '),
(17, 'Systèmes, réseaux et sécurité '),
(18, 'Bases de données, persistance '),
(19, 'Génie logiciel et modélisation'),
(20, 'Langages pour le web '),
(21, 'Programmation orientée objet e'),
(22, 'Culture d’entreprise - Anglais'),
(23, 'Projet tuteuré - Gestion de pr'),
(24, 'Stage en entreprise '),
(25, 'Systèmes, réseaux et sécurité '),
(26, 'Bases de données, persistance '),
(27, 'Génie logiciel et modélisation'),
(28, 'Langages pour le web '),
(29, 'Programmation orientée objet e'),
(30, 'Culture d’entreprise - Anglais'),
(31, 'Projet tuteuré - Gestion de pr'),
(32, 'Stage en entreprise ');

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
  `uti_id` int(11) NOT NULL,
  PRIMARY KEY (`id_etud`),
  KEY `uti_id` (`uti_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20961 ;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`id_etud`, `nom`, `prenom`, `mail1`, `mail2`, `uti_id`) VALUES
(20956, 'Vance', 'Lucian', 'hoctac@gmail.com', 'hoctac@hotmail.fr', 9),
(20957, 'Nguyen', 'Raja', 'takouert.elhocine@gmail.com', 'takouert.elhocine@hotmail.fr', 9),
(20958, 'Patel', 'Geoffrey', 'takouert.elhocine@gmail.com', 'hoctac@hotmail.fr', 9),
(20959, 'Head', 'Sebastian', 'hoctac@gmail.com', 'takouert.elhocine@hotmail.fr', 9),
(20960, 'Prince', 'Allen', 'takouert.elhocine@hotmail.fr', 'hoctac@gmail.com', 9);

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id_etud` int(11) NOT NULL,
  `type_note` varchar(255) NOT NULL,
  `valeur` varchar(10) NOT NULL,
  `uti_id` int(11) NOT NULL,
  PRIMARY KEY (`id_etud`,`type_note`),
  KEY `uti_id` (`uti_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `uti_is_valide` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uti_id`),
  UNIQUE KEY `uti_login` (`uti_login`),
  UNIQUE KEY `uti_mail` (`uti_mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`uti_id`, `uti_nom`, `uti_prenom`, `uti_login`, `uti_mdp`, `uti_mail`, `uti_is_admin`, `uti_is_valide`) VALUES
(9, 'BERRY', 'Sylvain', 'Sylvain', '51b3998dd7ac7235e0160661dbcaa706', 'berry.sylvain@free.fr', 1, 1),
(48, 'test0', 'test0', 'test0', '51b3998dd7ac7235e0160661dbcaa706', 'test@test.test0', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_ue`
--

CREATE TABLE IF NOT EXISTS `utilisateurs_ue` (
  `uti_id` int(4) NOT NULL,
  `ue_id` int(11) NOT NULL,
  PRIMARY KEY (`uti_id`,`ue_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateurs_ue`
--

INSERT INTO `utilisateurs_ue` (`uti_id`, `ue_id`) VALUES
(9, 6),
(9, 7),
(48, 1);

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
