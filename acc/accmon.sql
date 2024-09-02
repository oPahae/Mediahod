-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 29 août 2024 à 16:06
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `accmon`
--

-- --------------------------------------------------------

--
-- Structure de la table `aboutus`
--

CREATE TABLE `aboutus` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `aboutus`
--

INSERT INTO `aboutus` (`id`, `content`) VALUES
(1, 'Welcome to our website! We are dedicated to providing top-notch services and products to our valued customers.\r\nOur mission is to innovate and deliver solutions that meet your needs. With a team of highly skilled professionals,\r\nwe are committed to excellence in everything we do.\r\nOur journey began with a passion for technology and a desire to make a difference. Over the years, we have grown\r\ninto a leading provider in our industry, known for our reliability, quality, and customer-centric approach.\r\nThank you for choosing us as your trusted partner. We look forward to serving you and helping you achieve your goals.                                                            ');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `login`, `password`, `email`) VALUES
(1, 'reda', '$2y$10$wCnA.urBmw1rJmWdUod5m.LQ8FgcfQkNxk4YyL5g20qGT9Msh1ccS', 'wafik.red.fst@uhp.ac.ma');

-- --------------------------------------------------------

--
-- Structure de la table `bonus`
--

CREATE TABLE `bonus` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `bonus`
--

INSERT INTO `bonus` (`id`, `description`) VALUES
(1, 'Bonus: Recharge $300 + $15; 500 + $25');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `image`) VALUES
(1, 'Facebook Accounts', '/acc/images/categories/66bfdbe55a58e-facebook.gif'),
(4, 'Business Manager', '/acc/images/categories/66c0d4e8356c8-google.gif'),
(5, 'Facebook Pages', '/acc/images/categories/66cfbe81c4ad1-flag.gif'),
(6, 'MICROSOFT ACCOUNTS', '/acc/images/categories/66cfbe60a461a-microsoft logo.png');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `idCom` int(11) NOT NULL,
  `dateCom` datetime NOT NULL DEFAULT current_timestamp(),
  `quantite` int(11) NOT NULL,
  `montant` double NOT NULL,
  `idUtilisateur` int(11) DEFAULT NULL,
  `idPro` int(11) DEFAULT NULL,
  `etat` enum('P','A','V') DEFAULT 'P'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`idCom`, `dateCom`, `quantite`, `montant`, `idUtilisateur`, `idPro`, `etat`) VALUES
(5, '2024-08-28 19:01:01', 1, 25.88, 1, 2, 'V'),
(6, '2024-08-28 21:50:22', 1, 25.88, 1, 2, 'V'),
(7, '2024-08-28 21:50:54', 1, 25.88, 1, 2, 'V'),
(8, '2024-08-28 22:34:04', 1, 25.88, 1, 2, 'A'),
(9, '2024-08-28 22:34:16', 1, 25.88, 1, 2, 'A'),
(10, '2024-08-29 01:11:41', 15, 388.2, 4, 2, 'V'),
(11, '2024-08-29 01:13:24', 1, 25.88, 1, 2, 'A'),
(12, '2024-08-29 01:49:39', 6, 155.28, 1, 2, 'V'),
(13, '2024-08-29 01:55:50', 3, 77.64, 4, 2, 'A'),
(14, '2024-08-29 01:56:19', 3, 77.64, 4, 2, 'P');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateEnv` datetime DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(15) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `contenu`, `email`, `dateEnv`, `image`, `whatsapp`, `username`) VALUES
(7, 'ccc', 'redawk7@gmail.com', '2024-08-28 17:53:48', '/acc/images/messages/message_66cf561cafee42.38289574.png', '0612345678', 'reda'),
(8, 'My ID : 4 / Account : 400$', 'wafik.red.fst@uhp.ac.ma', '2024-08-29 01:09:54', '/acc/images/messages/message_66cfbc5232fbe2.79449793.jpg', '0612345678', '4');

-- --------------------------------------------------------

--
-- Structure de la table `methodes`
--

CREATE TABLE `methodes` (
  `ID` int(11) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `Note` varchar(255) DEFAULT NULL,
  `Network` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `methodes`
--

INSERT INTO `methodes` (`ID`, `adresse`, `Note`, `Network`) VALUES
(1, 'TT2eV73eYUTTVQj5drJW1CDDmY531GTFMb', ' Minimum Send 5 USDT - We only accept USDT', 'RedotPay'),
(2, 'TT2eV73eYUTTVQj5drJW1CDDmY531GTFMb', 'Minimum Send 5 USDT - We only accept USDT', 'pyypl'),
(3, 'TT2eV73eYUTTVQj5drJW1CDDmY531GTFMb', ' Minimum Send 10 USDT - We only accept USDT', 'bitcoin'),
(4, 'TT2eV73eYUTTVQj5drJW1CDDmY531GTFMb', ' Minimum Send 10 USDT - We only accept USDT', 'cih'),
(5, 'TT2eV73eYUTTVQj5drJW1CDDmY531GTFMb', ' Minimum Send 10 USDT - We only accept USDT', 'paypal'),
(7, 'TT2eV73eYUTTVQj5drJW1CDDmY531GTFMb', ' Minimum Send 10 USDT - We only accept USDT', 'perfect money');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `disponibilite` tinyint(1) NOT NULL DEFAULT 1,
  `stock` int(11) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `idSousCategorie` int(11) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `libelle`, `prix`, `description`, `image`, `disponibilite`, `stock`, `date`, `idSousCategorie`, `logo`, `link`) VALUES
(1, 'Identity Verified Old Fb Account + Reinstated BM350 (Daily Limit 50$)', 15.00, 'Profile identity verified, 2 green line, 1 personal ad account limit 50$ available\r\nIntegrate reinstated unverified Business Manager limit 50$.', '/acc/images/produits/66bfc60c25e63-p1.png', 0, 20, '2024-08-16', NULL, '/acc/images/produits/66bfc60c2344b-facebookgold.png', 'https://web.facebook.com/profile.php?id=61555631822239'),
(2, 'Thailand Resistance Old Fb Accounts - Limit 25-50$', 25.88, 'Profile is successful ad resistance, 3 green line 902. (Hidden green tick)', NULL, 1, 9, '2024-08-16', 2, '/acc/images/produits/66bfc672312d4-resistanceAcc.png', ''),
(3, 'Brazil Identity Verified Old Fb Account - Limit 25-50$', 7.00, 'Profile is successful identity verification, 2 green line. (Hidden green tick).', NULL, 1, 0, '2024-08-16', 3, '/acc/images/produits/66bfc6bf9016b-resistanceAcc.png', ''),
(4, 'Google Ads Account, System Circumvention Violation - Reactivated + Verified Business', 15.00, 'The account that violated the system evasion policy has been reactivated (Country Vietnam, Currency VND)', NULL, 0, 10, '2024-08-16', NULL, '/acc/images/produits/66bfccf809f3d-googlAds.png', ''),
(5, 'Google Ads Account, System Circumvention Violation - Reactivated + Verified Business', 125.00, 'The account that violated the system evasion policy has been reactivated (Country Vietnam, Currency VND)', NULL, 0, 29, '2024-08-17', NULL, '/acc/images/produits/66bfda84cd52e-googlAds.png', '');

-- --------------------------------------------------------

--
-- Structure de la table `souscategories`
--

CREATE TABLE `souscategories` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `idCategorie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `souscategories`
--

INSERT INTO `souscategories` (`id`, `nom`, `idCategorie`) VALUES
(2, 'RESISTANCE ACCOUNTS', 1),
(3, 'IDENTITY VERIFIED', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `wallet` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `email`, `password`, `telephone`, `profile`, `wallet`) VALUES
(1, 'wafik', 'wafik.red.fst@uhp.ac.ma', '$2y$10$COeO817TsN83aaVnozrPdOZxSAyL4AVfsgxGDJlX52.XOGbd0enaS', '0643960418', '/acc/images/profiles/profile_66bfdd90ced038.01566781.jpg', 4.887010000000004),
(3, 'reda', 'redawk7@gmail.com', '$2y$10$V5UAsxZ23mhMSwg98ohJf.cs4K90C1s4wNAamByfcVLkr8iDrnBgi', '0612345678', NULL, 0),
(4, 'salma lady', 'salma@gmail.com', '$2y$10$m/Ye3BFEqPRU8stLhz.QmObsqGA2w6VgHh2TlzDdlhHNK3aYXXoO.', '0612345678', '/acc/images/profiles/profile_66cfba6a560863.32859772.png', 687.8);

-- --------------------------------------------------------

--
-- Structure de la table `wise`
--

CREATE TABLE `wise` (
  `id` int(11) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `holder_name` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_code` varchar(20) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wise`
--

INSERT INTO `wise` (`id`, `currency`, `email`, `holder_name`, `bank_name`, `bank_code`, `account_number`, `address`, `city`, `zipcode`) VALUES
(1, 'VND (VIETNAM DOX)', 'redawk7@gmail.com', 'LIEU MINH CHX', 'Tien Phong Commercial Joint Stock Bank', 'TPBVVNVXXXY', '03508789108', '19 RUE SANAA HAY TISSIR 01', 'Berrechid', '26100');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `aboutus`
--
ALTER TABLE `aboutus`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`idCom`),
  ADD KEY `idUtilisateur` (`idUtilisateur`),
  ADD KEY `fk_idPro` (`idPro`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `methodes`
--
ALTER TABLE `methodes`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSousCategorie` (`idSousCategorie`);

--
-- Index pour la table `souscategories`
--
ALTER TABLE `souscategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCategorie` (`idCategorie`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `wise`
--
ALTER TABLE `wise`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `aboutus`
--
ALTER TABLE `aboutus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `bonus`
--
ALTER TABLE `bonus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `idCom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `methodes`
--
ALTER TABLE `methodes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `souscategories`
--
ALTER TABLE `souscategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `wise`
--
ALTER TABLE `wise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `fk_idPro` FOREIGN KEY (`idPro`) REFERENCES `produits` (`id`);

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`idSousCategorie`) REFERENCES `souscategories` (`id`);

--
-- Contraintes pour la table `souscategories`
--
ALTER TABLE `souscategories`
  ADD CONSTRAINT `souscategories_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
