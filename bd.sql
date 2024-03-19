-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 19, 2024 at 09:45 PM
-- Server version: 11.2.2-MariaDB-1:11.2.2+maria~ubu2204
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `Abonnements`
--

CREATE TABLE `Abonnements` (
  `id_abonnement` int(11) NOT NULL,
  `id_abonne` int(11) DEFAULT NULL,
  `id_abonnement_de` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Categorie`
--

CREATE TABLE `Categorie` (
  `id_categorie` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Categorie`
--

INSERT INTO `Categorie` (`id_categorie`, `nom`) VALUES
(1, 'Électroniques'),
(2, 'Voitures'),
(3, 'Meubles'),
(4, 'Électroménagers'),
(5, 'Vêtements'),
(6, 'Livres'),
(7, 'Sports'),
(8, 'Jouets'),
(9, 'Logements'),
(10, 'Services');

-- --------------------------------------------------------

--
-- Table structure for table `Paiement`
--

CREATE TABLE `Paiement` (
  `id_paiement` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `info_methode_paiement` varchar(255) NOT NULL,
  `date_paiement` date NOT NULL,
  `id_profil` int(11) NOT NULL,
  `id_publication` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Panier`
--

CREATE TABLE `Panier` (
  `id_panier` int(11) NOT NULL,
  `montant_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Panier_Publication`
--

CREATE TABLE `Panier_Publication` (
  `id_panier` int(11) NOT NULL,
  `id_publication` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Profil`
--

CREATE TABLE `Profil` (
  `id_profil` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `info_paiement` varchar(255) DEFAULT NULL,
  `date_naissance` date NOT NULL,
  `photo_profil` blob DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `montant_balance` decimal(10,2) NOT NULL,
  `nb_rating` int(11) DEFAULT NULL,
  `rating_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

- --------------------------------------------------------

--
-- Table structure for table `Publication`
--

CREATE TABLE `Publication` (
  `id_publication` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` blob NOT NULL,
  `id_profil` int(11) DEFAULT NULL,
  `id_categorie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Indexes for dumped tables
--

--
-- Indexes for table `Abonnements`
--
ALTER TABLE `Abonnements`
  ADD PRIMARY KEY (`id_abonnement`),
  ADD KEY `id_abonne` (`id_abonne`),
  ADD KEY `id_abonnement_de` (`id_abonnement_de`);

--
-- Indexes for table `Categorie`
--
ALTER TABLE `Categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `Paiement`
--
ALTER TABLE `Paiement`
  ADD PRIMARY KEY (`id_paiement`),
  ADD KEY `id_profil` (`id_profil`),
  ADD KEY `id_publication` (`id_publication`);

--
-- Indexes for table `Panier`
--
ALTER TABLE `Panier`
  ADD PRIMARY KEY (`id_panier`);

--
-- Indexes for table `Panier_Publication`
--
ALTER TABLE `Panier_Publication`
  ADD PRIMARY KEY (`id_panier`,`id_publication`),
  ADD KEY `id_publication` (`id_publication`);

--
-- Indexes for table `Profil`
--
ALTER TABLE `Profil`
  ADD PRIMARY KEY (`id_profil`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Publication`
--
ALTER TABLE `Publication`
  ADD PRIMARY KEY (`id_publication`),
  ADD KEY `id_profil` (`id_profil`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Abonnements`
--
ALTER TABLE `Abonnements`
  MODIFY `id_abonnement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Categorie`
--
ALTER TABLE `Categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Paiement`
--
ALTER TABLE `Paiement`
  MODIFY `id_paiement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Profil`
--
ALTER TABLE `Profil`
  MODIFY `id_profil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Publication`
--
ALTER TABLE `Publication`
  MODIFY `id_publication` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Abonnements`
--
ALTER TABLE `Abonnements`
  ADD CONSTRAINT `Abonnements_ibfk_1` FOREIGN KEY (`id_abonne`) REFERENCES `Profil` (`id_profil`),
  ADD CONSTRAINT `Abonnements_ibfk_2` FOREIGN KEY (`id_abonnement_de`) REFERENCES `Profil` (`id_profil`);

--
-- Constraints for table `Paiement`
--
ALTER TABLE `Paiement`
  ADD CONSTRAINT `Paiement_ibfk_1` FOREIGN KEY (`id_profil`) REFERENCES `Profil` (`id_profil`) ON DELETE CASCADE,
  ADD CONSTRAINT `Paiement_ibfk_2` FOREIGN KEY (`id_publication`) REFERENCES `Publication` (`id_publication`) ON DELETE CASCADE;

--
-- Constraints for table `Panier`
--
ALTER TABLE `Panier`
  ADD CONSTRAINT `Panier_ibfk_1` FOREIGN KEY (`id_panier`) REFERENCES `Profil` (`id_profil`) ON DELETE CASCADE;

--
-- Constraints for table `Panier_Publication`
--
ALTER TABLE `Panier_Publication`
  ADD CONSTRAINT `Panier_Publication_ibfk_1` FOREIGN KEY (`id_panier`) REFERENCES `Panier` (`id_panier`) ON DELETE CASCADE,
  ADD CONSTRAINT `Panier_Publication_ibfk_2` FOREIGN KEY (`id_publication`) REFERENCES `Publication` (`id_publication`) ON DELETE CASCADE;

--
-- Constraints for table `Publication`
--
ALTER TABLE `Publication`
  ADD CONSTRAINT `Publication_ibfk_1` FOREIGN KEY (`id_profil`) REFERENCES `Profil` (`id_profil`) ON DELETE CASCADE,
  ADD CONSTRAINT `Publication_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `Categorie` (`id_categorie`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
