-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc38
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 24 juil. 2024 à 16:01
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
-- Base de données : `access`
--

-- --------------------------------------------------------

--
-- Structure de la table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `submissions`
--

INSERT INTO `submissions` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'azeraer', 'aze@gmail.com', 'azerazeaze', '2024-07-14 07:41:35'),
(2, 'Ethan', 'ethan@gmail.com', 'Votre site est cool', '2024-07-24 07:39:14');

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('ouvert','complet','reporté') NOT NULL,
  `priority` enum('faible','moyen','élevé') NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_image`) VALUES
(5, 'Momo', 'momo@gmail.com', '$2y$10$PdbK0wftg8Isw4/PbsGB0eaxuyKUMog0oAAJPa0PqcR5XRuH405BO', 'd-veloppeur-acharn-.jpg'),
(6, 'riri', 'man@gmail.com', '$2y$10$h6CnfjsxGrK.vTUdwZsyceTvNjXWD/Z7X8Z/wrXYNhYmzI8cNstou', 'wp3205204.jpg'),
(10, 'coco', 'bill1@gmail.com', '$2y$10$FOGMOSLLg0UmNfAYLmhQuOZ0Zlhj.F11xvwpU3f250WUzhp9GINhy', 'code-stupid-tv-shows-scorpion-tv-show-wallpaper-preview.jpg'),
(12, 'Rinho', 'manb@gmail.com', '$2y$10$RHYY5z6RJXmiB/IUXoXLLuwmhlWHv94tEwALHsPi0hIhlnM8ffq/u', 'pngegg (2).png'),
(13, 'Randy', '123@gmail.com', '$2y$10$i5Uuiq4S8Gf96S185sasI.MKHGzsIbPpAMP1NOUQHNVB0QVaP5UL.', 'css.png'),
(14, 'Tsiory', 'fabio@gmail.com', '$2y$10$rZLRktB9Z9JBMwHvvv4q3OxJVrAvHqwbhj4RolZZwg7H0S2.fhsPS', 'linusss.png'),
(15, 'richard', 'ri@mail.com', '$2y$10$/eVgOf1Ia7IG4FCtSOE/UOlYpJO6Glscj0XgPW8.Uo2cu/5F1jU8.', 'still-f1c0df70f1c15486b88334c0bda65b61.png'),
(16, 'kaizer', 'kaizer@gmail.com', '$2y$10$GtR2GUqxdLCmDsNK/9Y5TOL6uYAQDfjYXDd7uB790c1w3UQDxNpve', 'wepik-export-202402141108582EL8.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT pour la table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
