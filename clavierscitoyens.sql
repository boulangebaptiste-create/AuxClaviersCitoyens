-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 08 jan. 2026 à 14:21
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `clavierscitoyens`
--

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

DROP TABLE IF EXISTS `match`;
CREATE TABLE IF NOT EXISTS `match` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team1Id` int NOT NULL,
  `team2Id` int NOT NULL,
  `team1Point` int NOT NULL DEFAULT '0',
  `team2Point` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_match_team1` (`team1Id`),
  KEY `fk_match_team2` (`team2Id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

DROP TABLE IF EXISTS `team`;
CREATE TABLE IF NOT EXISTS `team` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `points` int NOT NULL DEFAULT '0',
  `image` blob,
  `tournament_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_team_tournament` (`tournament_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tournament`
--

DROP TABLE IF EXISTS `tournament`;
CREATE TABLE IF NOT EXISTS `tournament` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `game` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `fk_match_team1` FOREIGN KEY (`team1Id`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_match_team2` FOREIGN KEY (`team2Id`) REFERENCES `team` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `fk_team_tournament` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
