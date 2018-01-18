-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 16 Avril 2017 à 17:26
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `activfinddb`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE IF NOT EXISTS `avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_complet` varchar(100) NOT NULL,
  `e_mail` varchar(100) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `avis`
--

INSERT INTO `avis` (`id`, `nom_complet`, `e_mail`, `message`) VALUES
(1, 'Serigne Bodian', 'massebodian@gmail.com', 'Test avis #12\\''\\''Â°Ã–Ã”I'),
(2, 'zach', 'jjj@gmail.com', 'votre plateforme est merdique$\\r\\n'),
(3, 'qsdqsd', 'qqsd@gmail.com', 'qdqsdqsd');

-- --------------------------------------------------------

--
-- Structure de la table `cas`
--

CREATE TABLE IF NOT EXISTS `cas` (
  `id_cas` varchar(35) NOT NULL,
  `datenaiss_cas` timestamp NOT NULL,
  `dureevie_cas` date NOT NULL,
  `statut_cas` tinyint(1) NOT NULL,
  `id_finder` varchar(35) NOT NULL,
  `id_objet` varchar(35) NOT NULL,
  `id_owner` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id_cas`),
  KEY `id_finder` (`id_finder`,`id_objet`),
  KEY `id_objet` (`id_objet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cas`
--

INSERT INTO `cas` (`id_cas`, `datenaiss_cas`, `dureevie_cas`, `statut_cas`, `id_finder`, `id_objet`, `id_owner`) VALUES
('562b9688778b4', '2015-10-24 14:32:40', '2015-11-23', 0, '562b968850216', '562b968877891', NULL),
('562b96b9a70d0', '2015-10-24 14:33:29', '2015-11-23', 1, '562b96b998922', '562b96b9a70a9', NULL),
('562b96e6ed792', '2015-10-24 14:34:15', '2015-11-23', 0, '562b96e6d86aa', '562b96e6ed76d', NULL),
('562b973d04583', '2015-10-24 14:35:41', '2015-11-23', 1, '562b973ce371f', '562b973d0455f', NULL),
('563537448ad8d', '2015-10-31 21:48:52', '2015-11-30', 0, '5635374468c71', '563537448ad42', NULL),
('5636b75924fca', '2015-11-02 01:07:37', '2015-12-02', 0, '5636b6f99c2b0', '5636b75924faf', NULL),
('563a6bde702e2', '2015-11-04 20:34:38', '2015-12-04', 0, '563a6bde64843', '563a6bde7026c', NULL),
('563a6cba3c7ef', '2015-11-04 20:38:18', '2015-12-04', 0, '563a6cba2b375', '563a6cba3c74f', NULL),
('563a714cb1e4b', '2015-11-04 20:57:48', '2015-12-04', 0, '563a714ca7b31', '563a714cb1de6', NULL),
('563d2a426b396', '2015-11-06 22:31:30', '2015-12-06', 0, '562b968850216', '563d2a426b334', NULL),
('563d2b1b7e50a', '2015-11-06 22:35:07', '2015-12-06', 0, '563d2b1b76502', '563d2b1b7e49f', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `finder`
--

CREATE TABLE IF NOT EXISTS `finder` (
  `id_finder` varchar(35) NOT NULL,
  `nom_finder` text NOT NULL,
  `prenom_finder` text NOT NULL,
  `tel_finder` int(15) NOT NULL,
  `addr_finder` varchar(75) NOT NULL,
  `mail_finder` varchar(50) NOT NULL,
  `profil` char(1) NOT NULL,
  PRIMARY KEY (`id_finder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `finder`
--

INSERT INTO `finder` (`id_finder`, `nom_finder`, `prenom_finder`, `tel_finder`, `addr_finder`, `mail_finder`, `profil`) VALUES
('562b968850216', 'BODIAN', 'Serigne', 778116493, 'karack', 'mmm@gmail.com', 'F'),
('562b96b998922', 'Sadio', 'Balla Mmoussa', 772151867, 'Parcelles', 'bbb@gmail.com', 'F'),
('562b96e6d86aa', 'Gueye', 'Mame Hiba', 7777777, 'medina', 'yeug@gmail.com', 'F'),
('562b973ce371f', 'Djattah', 'Abdoulaye Siboudji', 771111111, 'Golf', 'asd@gmail.com', 'F'),
('5635374468c71', 'Seydi', 'Mouhamed', 701541020, 'VÃ©lingara', 'seydi91@gmail.com', 'F'),
('5636b6f99c2b0', 'dsd', 'sdf', 654654, 'sdfsdf', 'ssdfsd@dfsdf.cpÃ¹', 'F'),
('563a6bde64843', 'Massire', 'diedhiou', 778569632, 'kaolack', 'kl@gmail.com', 'F'),
('563a6cba2b375', 'sakho', 'moussa', 701451210, 'sipress', 'sakho12@yahoo.fr', 'F'),
('563a714ca7b31', 'qsdkqsml', 'mlskdfmlk', 65456465, 'mlkfmslqkdm', 'sdfsd@dfsdf.com', 'F'),
('563d2b1b76502', 'diatta', 'basile', 776528790, 'moulomp', 'basile@yahoo.fr', 'F');

-- --------------------------------------------------------

--
-- Structure de la table `objet`
--

CREATE TABLE IF NOT EXISTS `objet` (
  `id_objet` varchar(35) NOT NULL,
  `nature_objet` varchar(50) NOT NULL,
  `addr_objet` varchar(75) NOT NULL,
  `details_objet` text NOT NULL,
  PRIMARY KEY (`id_objet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `objet`
--

INSERT INTO `objet` (`id_objet`, `nature_objet`, `addr_objet`, `details_objet`) VALUES
('562b968877891', 'portable', 'iam', 'nokia lumia 520 couleur jaune tel 771254123'),
('562b96b9a70a9', 'chargeur', 'geule tape', 'blackberry curve'),
('562b96e6ed76d', 'pochette', 'marche tilene', 'pochette mauve avec 25000 argent'),
('562b973d0455f', 'montre', 'Bus tata 38', 'watch quart marque rolex grise fluorescent'),
('563537448ad42', 'sac &agrave; dos', 'marchÃ© tilÃ¨ne', 'Violet '),
('5636b75924faf', 'l''&eacute;l&eacute;ctricit&eacute;', 'qdqsd', 'qsd'),
('563a6bde7026c', 'T&eacute;l&eacute;phone', 'iam', 'samsung galaxy s6 gris Ã©cran cassÃ©'),
('563a6cba3c74f', 'Carte d''identit&eacute;', 'pcci', 'au nom de assane seck'),
('563a714cb1de6', 'l''&eacute;cole', 'sdlfksd', 'lkdlfksjdkf'),
('563d2a426b334', 'bracelet', 'jean de la fontaine', 'or '),
('563d2b1b7e49f', 'vetements', 'jean de la fontaine', 'vtt couleur rouge');

-- --------------------------------------------------------

--
-- Structure de la table `owner`
--

CREATE TABLE IF NOT EXISTS `owner` (
  `id_owner` varchar(35) NOT NULL,
  `nom_owner` text NOT NULL,
  `prenom_owner` text NOT NULL,
  `tel_owner` int(15) NOT NULL,
  `addr_owner` text NOT NULL,
  `mail_owner` varchar(35) NOT NULL,
  `profil` char(1) NOT NULL,
  PRIMARY KEY (`id_owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_util` varchar(13) NOT NULL,
  `util_login` varchar(50) NOT NULL,
  `util_password` varchar(30) NOT NULL,
  `util_statut` tinyint(1) DEFAULT NULL,
  `token` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_util`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_util`, `util_login`, `util_password`, `util_statut`, `token`) VALUES
('147852369', 'wouti@root', '123', NULL, NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `cas`
--
ALTER TABLE `cas`
  ADD CONSTRAINT `cas_ibfk_1` FOREIGN KEY (`id_finder`) REFERENCES `finder` (`id_finder`),
  ADD CONSTRAINT `cas_ibfk_2` FOREIGN KEY (`id_objet`) REFERENCES `objet` (`id_objet`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
