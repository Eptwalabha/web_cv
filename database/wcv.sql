-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 05 Juin 2013 à 09:50
-- Version du serveur: 5.6.11-log
-- Version de PHP: 5.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `wcv`
--
CREATE DATABASE IF NOT EXISTS `wcv` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `wcv`;

-- --------------------------------------------------------

--
-- Structure de la table `blog_post`
--

CREATE TABLE IF NOT EXISTS `blog_post` (
  `bp_id` int(11) NOT NULL AUTO_INCREMENT,
  `bp_title` varchar(50) COLLATE utf8_bin NOT NULL,
  `bp_text` text COLLATE utf8_bin NOT NULL,
  `bp_date` datetime NOT NULL,
  `bp_date_edit` datetime DEFAULT NULL,
  `bp_state` tinyint(4) NOT NULL DEFAULT '1',
  `bp_bt_id` int(11) NOT NULL,
  `bp_usr_id` int(11) NOT NULL,
  PRIMARY KEY (`bp_id`),
  KEY `bp_bt_id` (`bp_bt_id`,`bp_usr_id`),
  KEY `bp_usr_id` (`bp_usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `blog_type`
--

CREATE TABLE IF NOT EXISTS `blog_type` (
  `bt_id` int(11) NOT NULL AUTO_INCREMENT,
  `bt_title` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`bt_id`),
  UNIQUE KEY `bt_title` (`bt_title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `blog_type`
--

INSERT INTO `blog_type` (`bt_id`, `bt_title`) VALUES
(1, 'Blog'),
(2, 'Information'),
(3, 'MAJ');

-- --------------------------------------------------------

--
-- Structure de la table `domain`
--

CREATE TABLE IF NOT EXISTS `domain` (
  `dom_id` int(11) NOT NULL AUTO_INCREMENT,
  `dom_title` varchar(50) COLLATE utf8_bin NOT NULL,
  `dom_text` text COLLATE utf8_bin,
  PRIMARY KEY (`dom_id`),
  UNIQUE KEY `dom_title` (`dom_title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `domain`
--

INSERT INTO `domain` (`dom_id`, `dom_title`, `dom_text`) VALUES
(1, 'test', ''),
(2, 'c''est la fÃªte BiBi!', ''),
(3, '<strong>T-T</strong>', '');

-- --------------------------------------------------------

--
-- Structure de la table `field`
--

CREATE TABLE IF NOT EXISTS `field` (
  `fie_id` int(11) NOT NULL AUTO_INCREMENT,
  `fie_title` varchar(50) COLLATE utf8_bin NOT NULL,
  `fie_text` text COLLATE utf8_bin NOT NULL,
  `fie_lvl` int(11) NOT NULL DEFAULT '50',
  `fie_date_start` datetime NOT NULL,
  `fie_date_end` datetime DEFAULT NULL,
  `fie_visible` tinyint(4) NOT NULL DEFAULT '1',
  `fie_dom_id` int(11) NOT NULL,
  `fie_usr_id` int(11) NOT NULL,
  PRIMARY KEY (`fie_id`),
  KEY `fie_dom_id` (`fie_dom_id`,`fie_usr_id`),
  KEY `fie_usr_id` (`fie_usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `pos_usr_id` int(11) NOT NULL,
  `pos_dom_id` int(11) NOT NULL,
  `pos_position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pos_usr_id`,`pos_dom_id`),
  KEY `pos_dom_id` (`pos_dom_id`),
  KEY `pos_usr_id` (`pos_usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_title` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_title` (`tag_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tagged`
--

CREATE TABLE IF NOT EXISTS `tagged` (
  `tag_tag_id` int(11) NOT NULL,
  `tag_bp_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_tag_id`,`tag_bp_id`),
  KEY `tag_bp_id` (`tag_bp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_first_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `usr_last_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `usr_mail` varchar(100) COLLATE utf8_bin NOT NULL,
  `usr_login` varchar(50) COLLATE utf8_bin NOT NULL,
  `usr_text` text COLLATE utf8_bin,
  `usr_address_line1` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `usr_address_line2` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `usr_address_line3` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `usr_phone` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `usr_cell` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `usr_zip_code` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `usr_town` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `usr_passwd` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_mail` (`usr_mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`usr_id`, `usr_first_name`, `usr_last_name`, `usr_mail`, `usr_login`, `usr_text`, `usr_address_line1`, `usr_address_line2`, `usr_address_line3`, `usr_phone`, `usr_cell`, `usr_zip_code`, `usr_town`, `usr_passwd`) VALUES
(1, 'damien', 'gabrielle', 'damien.gabrielle@epsi.fr', 'damien', 'no description to give right now', 'apt 17 residence SQUARE PRIMEROSE', '221-225 avenue de la REPUBLIQUE', '', '', '0648743356', '33200', 'bordeaux', '31f7a65e315586ac198bd798b6629ce4903d0899476d5741a9f32e2e521b6a66');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `blog_post`
--
ALTER TABLE `blog_post`
  ADD CONSTRAINT `blog_post_ibfk_1` FOREIGN KEY (`bp_bt_id`) REFERENCES `blog_type` (`bt_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `blog_post_ibfk_2` FOREIGN KEY (`bp_usr_id`) REFERENCES `user` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `field`
--
ALTER TABLE `field`
  ADD CONSTRAINT `field_ibfk_1` FOREIGN KEY (`fie_dom_id`) REFERENCES `domain` (`dom_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `field_ibfk_2` FOREIGN KEY (`fie_usr_id`) REFERENCES `user` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `position`
--
ALTER TABLE `position`
  ADD CONSTRAINT `position_ibfk_1` FOREIGN KEY (`pos_usr_id`) REFERENCES `user` (`usr_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `position_ibfk_2` FOREIGN KEY (`pos_dom_id`) REFERENCES `domain` (`dom_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tagged`
--
ALTER TABLE `tagged`
  ADD CONSTRAINT `tagged_ibfk_1` FOREIGN KEY (`tag_tag_id`) REFERENCES `tag` (`tag_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `tagged_ibfk_2` FOREIGN KEY (`tag_bp_id`) REFERENCES `blog_post` (`bp_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
