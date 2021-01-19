-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 19 jan. 2021 à 16:39
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `3a22`
--

-- --------------------------------------------------------

--
-- Structure de la table `classroom`
--

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE IF NOT EXISTS `classroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classroom`
--

INSERT INTO `classroom` (`id`, `name`) VALUES
(1, '3A21'),
(2, '3A21'),
(3, '3A22');

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

DROP TABLE IF EXISTS `club`;
CREATE TABLE IF NOT EXISTS `club` (
  `ref` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` date NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `fees` double NOT NULL,
  PRIMARY KEY (`ref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `club`
--

INSERT INTO `club` (`ref`, `creation_date`, `enabled`, `fees`) VALUES
('club1', '2020-11-02', 0, 5),
('club3', '2020-12-10', 1, 3),
('club4', '2020-12-16', 0, 1),
('club5', '2020-12-19', 1, 4),
('club6', '2021-01-01', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201104135351', '2020-11-04 13:54:10', 895),
('DoctrineMigrations\\Version20201104142226', '2020-11-04 14:22:46', 2795),
('DoctrineMigrations\\Version20201105081952', '2020-11-05 08:20:13', 1069),
('DoctrineMigrations\\Version20201105083335', '2020-11-05 08:33:59', 2113),
('DoctrineMigrations\\Version20201223202640', '2020-12-23 20:26:50', 2090),
('DoctrineMigrations\\Version20210112132301', '2021-01-12 13:23:23', 4068);

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `nsc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classroom_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`nsc`),
  KEY `IDX_B723AF336278D5A8` (`classroom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`nsc`, `email`, `classroom_id`) VALUES
('123456', 'test.test@gmail.com', 1),
('12345670', 'test.test@gmail.com', 1),
('12345678', 'test123@gmail.com', 2),
('123456783', 'test@esprit.tn', 1),
('12345679', 'test@gmail.com', 3),
('12345698', 'foulenbenfoulen@gmail.com', 1),
('123459', 'test.test@esprit.tn', 3);

-- --------------------------------------------------------

--
-- Structure de la table `students_clubs`
--

DROP TABLE IF EXISTS `students_clubs`;
CREATE TABLE IF NOT EXISTS `students_clubs` (
  `student_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `club_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`student_id`,`club_id`),
  KEY `IDX_A9AE56D7CB944F1A` (`student_id`),
  KEY `IDX_A9AE56D761190A32` (`club_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `students_clubs`
--

INSERT INTO `students_clubs` (`student_id`, `club_id`) VALUES
('123456', 'club1'),
('123456', 'club3'),
('12345678', 'club1'),
('12345678', 'club3'),
('12345678', 'club4'),
('123459', 'club1'),
('123459', 'club3');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_B723AF336278D5A8` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`id`);

--
-- Contraintes pour la table `students_clubs`
--
ALTER TABLE `students_clubs`
  ADD CONSTRAINT `FK_A9AE56D761190A32` FOREIGN KEY (`club_id`) REFERENCES `club` (`ref`),
  ADD CONSTRAINT `FK_A9AE56D7CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`nsc`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
