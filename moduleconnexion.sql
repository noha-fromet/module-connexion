-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 14 juin 2023 à 06:28
-- Version du serveur : 8.0.33
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `moduleconnexion`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `prenom`, `nom`, `password`, `email`) VALUES
(1, 'admin', 'admin', 'admin', '$2y$10$M5wO1qFlgLt37HhXfMl1yu0wK7vMqVmK4dVzythfmwemlOOY7gzuq', 'admin'),
(2, 'paul12', 'paul', 'rec', '$2y$10$dXFICZVOXjkdSEnJxY6ITeVZ/p8IQyl9mV0OLfh.LCljr2z3uzrKW', 'paul11@gmail.com'),
(5, 'karl', 'karl', 'lock', '$2y$10$rVY3511UA3HA5ujCqt/J7e8vUk9BYQ8loz.SUnVL85wpAhAst1zI.', 'karl@gmail.com'),
(6, 'mike', 'mike', 'pole', '$2y$10$X2RMD0Yv.TfKxR28TxYxuOmjM3ipHEGg22fUE6h8NTSgqoG8UUeWq', 'mike@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
