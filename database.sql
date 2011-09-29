-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 29 Septembre 2011 à 16:22
-- Version du serveur: 5.5.9
-- Version de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données
--

-- --------------------------------------------------------

--
-- Structure de la table `key_data`
--

CREATE TABLE `key_data` (
  `key_id` int(11) NOT NULL AUTO_INCREMENT,
  `key_usr_id` int(11) NOT NULL,
  `key_title` text NOT NULL,
  `key_blop` text NOT NULL,
  PRIMARY KEY (`key_id`),
  KEY `key_usr_id` (`key_usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `key_data`
--


-- --------------------------------------------------------

--
-- Structure de la table `key_user`
--

CREATE TABLE `key_user` (
  `usr_user` varchar(255) NOT NULL,
  `usr_password` text NOT NULL,
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `key_user`
--

INSERT INTO `key_user` VALUES('admin', 'N8Hv0jK9Q5InD0jP+YkHo3LD60E=', 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `key_data`
--
ALTER TABLE `key_data`
  ADD CONSTRAINT `key_data_ibfk_1` FOREIGN KEY (`key_usr_id`) REFERENCES `key_user` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
