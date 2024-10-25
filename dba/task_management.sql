-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc38
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 24 juil. 2024 à 16:03
-- Version du serveur : 10.5.22-MariaDB
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `task_management`
--

-- --------------------------------------------------------

--
-- Structure de la table `manage`
--

CREATE TABLE `manage` (
  `id` int(11) NOT NULL,
  `status` enum('Ouvert','Complet','Annule') NOT NULL,
  `priority` enum('Faible','Moyen','Important') NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `due_date` date NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `manage`
--

INSERT INTO `manage` (`id`, `status`, `priority`, `name`, `description`, `due_date`, `user_id`) VALUES
(97, 'Ouvert', 'Faible', 'ret', 'ret', '2024-07-25', 10),
(100, 'Complet', 'Moyen', 'jyjy', 'jy', '2024-07-24', 12),
(101, 'Ouvert', 'Faible', 'err', 'er', '2024-07-24', 12),
(102, 'Ouvert', 'Faible', 'ezez', 'ert', '2024-07-25', 10),
(104, 'Complet', 'Faible', 'Fabio', 'fabio', '2024-07-24', 14),
(106, 'Complet', 'Faible', 'test', 'test', '2024-07-19', 5),
(107, 'Ouvert', 'Important', 'test', 'test', '2024-07-26', 5),
(109, 'Ouvert', 'Faible', 'test', 'test', '2024-07-26', 12),
(110, 'Ouvert', 'Moyen', 'task 0', 'task 0', '2024-07-25', 12),
(111, 'Ouvert', 'Faible', 'test 0', 'rin', '2024-07-27', 15),
(114, 'Ouvert', 'Important', 'ranga be ', 'ranga be', '2024-07-27', 12),
(115, 'Complet', 'Faible', 'rdv', 'entretiens', '2024-07-24', 5),
(116, 'Ouvert', 'Moyen', 'test 3', 'test', '2024-07-18', 12),
(117, 'Ouvert', 'Faible', 'Test de niveau', 'FranÃ§ais', '2024-07-26', 16);

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `title`, `start_date`, `end_date`) VALUES
(7, 'proj1', '2024-06-27', '2024-06-28');

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `title`, `completed`) VALUES
(11, 7, 'a', 1),
(12, 7, 'b', 0),
(13, 7, 'c', 0),
(14, 7, 'd', 0),
(15, 7, 'e', 0);

-- --------------------------------------------------------

--
-- Structure de la table `taskss`
--

CREATE TABLE `taskss` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `email`, `password`, `profile_image`) VALUES
(1, 0, 'momo', 'momo@gmail.com', '$2y$10$iXJjRYYmH9VapfxYeEVhrulD9HYjnzawTFhURx.DJShOnLrwX2SVq', 'code-stupid-tv-shows-scorpion-tv-show-wallpaper-preview.jpg'),
(2, 0, 'kiki', 'kiki@gmail.com', '$2y$10$sKqOTOd05AHszwPEGS4UFOPmiqIQuHQYJydXrGl5M86Umgl9vNl3u', 'code-stupid-tv-shows-scorpion-tv-show-wallpaper-preview.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `manage`
--
ALTER TABLE `manage`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Index pour la table `taskss`
--
ALTER TABLE `taskss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `manage`
--
ALTER TABLE `manage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `taskss`
--
ALTER TABLE `taskss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Contraintes pour la table `taskss`
--
ALTER TABLE `taskss`
  ADD CONSTRAINT `taskss_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
