-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 11:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2025_proj_dzivnieki`
--

-- --------------------------------------------------------

--
-- Table structure for table `atbildes`
--

CREATE TABLE `atbildes` (
  `Atbilde_ID` int(11) NOT NULL,
  `Jautajums_ID` int(11) NOT NULL,
  `Atbilde` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `atbildes`
--

INSERT INTO `atbildes` (`Atbilde_ID`, `Jautajums_ID`, `Atbilde`) VALUES
(1, 1, 'Madride'),
(2, 2, 'Nepāla'),
(3, 3, '8'),
(4, 4, 'Mocarts'),
(5, 5, '1237'),
(6, 6, '296'),
(8, 8, 'Ādažu'),
(9, 9, 'Klusais'),
(10, 10, 'Indija'),
(11, 11, '4'),
(12, 12, 'Nē');

-- --------------------------------------------------------

--
-- Table structure for table `dzivnieki`
--

CREATE TABLE `dzivnieki` (
  `Dzivnieks_ID` int(11) NOT NULL,
  `ID_Lietotajs` int(11) NOT NULL,
  `Vards` varchar(50) NOT NULL,
  `Dzivnieks` varchar(50) NOT NULL,
  `Bada_limenis` int(3) NOT NULL,
  `Labsajutas_limenis` int(3) NOT NULL,
  `Reizes_gulets` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dzivnieki`
--

INSERT INTO `dzivnieki` (`Dzivnieks_ID`, `ID_Lietotajs`, `Vards`, `Dzivnieks`, `Bada_limenis`, `Labsajutas_limenis`, `Reizes_gulets`) VALUES
(23, 29, 'kika', 'Suns', 71, 71, 0),
(24, 30, 'Jariks', 'Zakis', 33, 67, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ediens`
--

CREATE TABLE `ediens` (
  `Ediens_ID` int(11) NOT NULL,
  `Nosaukums` varchar(255) NOT NULL,
  `Vertiba` int(3) NOT NULL,
  `Cena` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ediens`
--

INSERT INTO `ediens` (`Ediens_ID`, `Nosaukums`, `Vertiba`, `Cena`) VALUES
(1, 'Burkans', 10, 5),
(2, 'Burger', 30, 12),
(3, 'Ola', 15, 6),
(4, 'Piens', 20, 7),
(5, 'Pica', 25, 10);

-- --------------------------------------------------------

--
-- Table structure for table `horoskopi`
--

CREATE TABLE `horoskopi` (
  `Horoskops_ID` int(11) NOT NULL,
  `Lietotajs_ID` int(11) NOT NULL,
  `Zvaigznajs` int(11) DEFAULT NULL,
  `Datums` date DEFAULT NULL,
  `Teksts` text NOT NULL,
  `Izveidots` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jautajumu_banka`
--

CREATE TABLE `jautajumu_banka` (
  `Jautajums_ID` int(11) NOT NULL,
  `Jautajums` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jautajumu_banka`
--

INSERT INTO `jautajumu_banka` (`Jautajums_ID`, `Jautajums`) VALUES
(1, 'Kas ir Spānijas galvaspilsēta?'),
(2, 'Kur atrodas Everests?'),
(3, 'Cik zirnekļiem ir kājas?'),
(4, 'Kurš uzrakstīja skaņdarbu Elīzei?'),
(5, '752 + 485 = ?'),
(6, '74*4 = ?'),
(8, 'Latvijas nacionālo čipsu nosaukums?'),
(9, 'Kas ir vislielākais okeāns?'),
(10, 'Kura ir visapdzīvotākā valsts pasaulē?'),
(11, 'Cik gadalaiku pastāv Latvijā?'),
(12, 'Vai Lietuva bija daļa no Livonijas ordeņa?');

-- --------------------------------------------------------

--
-- Table structure for table `kapi`
--

CREATE TABLE `kapi` (
  `MirDzivn_ID` int(11) NOT NULL,
  `Lietotajs_ID` int(11) NOT NULL,
  `Dzivnieks_ID` int(11) NOT NULL,
  `Datums_laiks` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ledusskapis`
--

CREATE TABLE `ledusskapis` (
  `Ledusskapja_ID` int(11) NOT NULL,
  `Lietotajs_ID` int(11) NOT NULL,
  `Ediens_ID` int(11) NOT NULL,
  `Daudzums` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ledusskapis`
--

INSERT INTO `ledusskapis` (`Ledusskapja_ID`, `Lietotajs_ID`, `Ediens_ID`, `Daudzums`) VALUES
(36, 30, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `lietotaji`
--

CREATE TABLE `lietotaji` (
  `Lietotajs_ID` int(11) NOT NULL,
  `Lietotajvards` varchar(255) NOT NULL,
  `Epasts` varchar(255) NOT NULL,
  `Parole` varchar(255) NOT NULL,
  `Nauda` int(11) NOT NULL,
  `Viktorina_pabeigta` tinyint(1) DEFAULT 0,
  `Viktorina_Pareizas_Atbildes` int(11) NOT NULL,
  `Viktorina_Kopskaits` int(11) NOT NULL,
  `Dzim_dat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lietotaji`
--

INSERT INTO `lietotaji` (`Lietotajs_ID`, `Lietotajvards`, `Epasts`, `Parole`, `Nauda`, `Viktorina_pabeigta`, `Viktorina_Pareizas_Atbildes`, `Viktorina_Kopskaits`, `Dzim_dat`) VALUES
(29, 'ozols2323', 'matiss@matiss.com', '$2y$10$fve/8jPEmi2.6Of1ZlDkvO6xE4tWXxmnzniRj.yy2DVuNdHuVXex2', 195, 0, 0, 0, '2025-04-03'),
(30, 'ozols2324', 'matiss@matiss.com', '$2y$10$SwUVwOxZ4n5VQcFfKScdz.0W7viDMzbwF/5esP4yuHOoncRNJbTUi', 450, 1, 11, 11, '2025-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `sasniegumi`
--

CREATE TABLE `sasniegumi` (
  `Sasniegumi_ID` int(11) NOT NULL,
  `Sasniegums_ID` int(11) NOT NULL,
  `Lietotajs_ID` int(11) NOT NULL,
  `Datums_laiks` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sasniegumi`
--

INSERT INTO `sasniegumi` (`Sasniegumi_ID`, `Sasniegums_ID`, `Lietotajs_ID`, `Datums_laiks`) VALUES
(145, 1, 29, '2025-04-30 21:25:36'),
(146, 1, 30, '2025-04-30 21:29:36'),
(147, 3, 30, '2025-05-03 15:34:22'),
(148, 8, 30, '2025-05-03 15:34:49'),
(149, 2, 30, '2025-05-03 15:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `sasniegumu_banka`
--

CREATE TABLE `sasniegumu_banka` (
  `Sasniegums_ID` int(11) NOT NULL,
  `Nosaukums` varchar(255) NOT NULL,
  `Apraksts` text NOT NULL,
  `Vertiba` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `sasniegumu_banka`
--

INSERT INTO `sasniegumu_banka` (`Sasniegums_ID`, `Nosaukums`, `Apraksts`, `Vertiba`) VALUES
(1, 'Tavs jaunais draugs!', 'Iepazīstināt mājdzīvnieku ar jaunām mājām', 50),
(2, 'Pirmais sapnis...', 'Aizvest mājdzīvnieku gulēt', 25),
(3, 'Es taču neesmu zaķis!', 'Mājdzīvniekam iedot apēst burkānu', 15),
(4, 'Tikko nosapņoju par Itāliju...', 'Mājdzīvnieks ir aizgājis gulēt 5 reizes', 20),
(5, 'Tik taukains... Bet tik ļoti sātīgs!', 'Mājdzīvniekam iedot apēst burgeri', 25),
(6, 'Tā kā no mammas bērnības!', 'Mājdzīvniekam iedot padzerties pienu', 10),
(7, 'Nelabvēlīga atmosfēra...', 'Mājdzīvnieka labsajūtas līmenim jānokrītās zem 70%', 5),
(8, 'Einšteins!', 'Atbildēt uz visiem viktorīnas jautājumiem', 50);

-- --------------------------------------------------------

--
-- Table structure for table `transakcijas`
--

CREATE TABLE `transakcijas` (
  `Transakcijas_ID` int(11) NOT NULL,
  `Lietotajs_ID` int(11) NOT NULL,
  `Ediens_ID` int(11) NOT NULL,
  `Daudzums` int(2) NOT NULL,
  `Nauda` int(11) NOT NULL,
  `Datums_laiks` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transakcijas`
--

INSERT INTO `transakcijas` (`Transakcijas_ID`, `Lietotajs_ID`, `Ediens_ID`, `Daudzums`, `Nauda`, `Datums_laiks`) VALUES
(107, 30, 1, 3, 10, '2025-05-03 14:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `zvaigznaji`
--

CREATE TABLE `zvaigznaji` (
  `Zvaigznajs_ID` int(11) NOT NULL,
  `Nosaukums` varchar(50) NOT NULL,
  `Datums_no` date NOT NULL,
  `Datums_lidz` date NOT NULL,
  `Apraksts` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zvaigznaji`
--

INSERT INTO `zvaigznaji` (`Zvaigznajs_ID`, `Nosaukums`, `Datums_no`, `Datums_lidz`, `Apraksts`) VALUES
(1, 'Auns', '2025-03-21', '2025-04-19', NULL),
(2, 'Vērsis', '2025-04-20', '2025-05-20', NULL),
(3, 'Dvīņi', '2025-05-21', '2025-06-20', NULL),
(4, 'Vēzis', '2025-06-21', '2025-07-22', NULL),
(5, 'Lauva', '2025-07-23', '2025-08-22', NULL),
(6, 'Jaunava', '2025-08-23', '2025-09-22', NULL),
(7, 'Svari', '2025-09-23', '2025-10-22', NULL),
(8, 'Skorpions', '2025-10-23', '2025-11-21', NULL),
(9, 'Strēlnieks', '2025-11-22', '2025-12-21', NULL),
(10, 'Mežāzis', '2025-12-22', '2025-01-19', NULL),
(11, 'Ūdensvīrs', '2025-01-20', '2025-02-18', NULL),
(12, 'Zivis', '2025-02-19', '2025-03-20', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atbildes`
--
ALTER TABLE `atbildes`
  ADD PRIMARY KEY (`Atbilde_ID`),
  ADD KEY `Atbilde_Jautajums` (`Jautajums_ID`);

--
-- Indexes for table `dzivnieki`
--
ALTER TABLE `dzivnieki`
  ADD PRIMARY KEY (`Dzivnieks_ID`),
  ADD KEY `Lietotajs_Dzivnieks` (`ID_Lietotajs`);

--
-- Indexes for table `ediens`
--
ALTER TABLE `ediens`
  ADD PRIMARY KEY (`Ediens_ID`);

--
-- Indexes for table `horoskopi`
--
ALTER TABLE `horoskopi`
  ADD PRIMARY KEY (`Horoskops_ID`),
  ADD KEY `Lietotajs_Horoskopi` (`Lietotajs_ID`),
  ADD KEY `Zvaigznajs_Horoskops` (`Zvaigznajs`);

--
-- Indexes for table `jautajumu_banka`
--
ALTER TABLE `jautajumu_banka`
  ADD PRIMARY KEY (`Jautajums_ID`);

--
-- Indexes for table `kapi`
--
ALTER TABLE `kapi`
  ADD PRIMARY KEY (`MirDzivn_ID`),
  ADD KEY `Lietotajs_Kapi` (`Lietotajs_ID`),
  ADD KEY `Dzivnieks_Kapi` (`Dzivnieks_ID`);

--
-- Indexes for table `ledusskapis`
--
ALTER TABLE `ledusskapis`
  ADD PRIMARY KEY (`Ledusskapja_ID`),
  ADD KEY `Lietotajs_Ledusskapis` (`Lietotajs_ID`),
  ADD KEY `Ediens_Ledusskapis` (`Ediens_ID`);

--
-- Indexes for table `lietotaji`
--
ALTER TABLE `lietotaji`
  ADD PRIMARY KEY (`Lietotajs_ID`);

--
-- Indexes for table `sasniegumi`
--
ALTER TABLE `sasniegumi`
  ADD PRIMARY KEY (`Sasniegumi_ID`),
  ADD KEY `Lietotajs_Sasniegumi` (`Lietotajs_ID`),
  ADD KEY `Sasniegums_Sasniegumi` (`Sasniegums_ID`);

--
-- Indexes for table `sasniegumu_banka`
--
ALTER TABLE `sasniegumu_banka`
  ADD PRIMARY KEY (`Sasniegums_ID`);

--
-- Indexes for table `transakcijas`
--
ALTER TABLE `transakcijas`
  ADD PRIMARY KEY (`Transakcijas_ID`),
  ADD KEY `Lietotajs_Transakcijas` (`Lietotajs_ID`),
  ADD KEY `Ediens_Transakcijas` (`Ediens_ID`);

--
-- Indexes for table `zvaigznaji`
--
ALTER TABLE `zvaigznaji`
  ADD PRIMARY KEY (`Zvaigznajs_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atbildes`
--
ALTER TABLE `atbildes`
  MODIFY `Atbilde_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dzivnieki`
--
ALTER TABLE `dzivnieki`
  MODIFY `Dzivnieks_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ediens`
--
ALTER TABLE `ediens`
  MODIFY `Ediens_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `horoskopi`
--
ALTER TABLE `horoskopi`
  MODIFY `Horoskops_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `jautajumu_banka`
--
ALTER TABLE `jautajumu_banka`
  MODIFY `Jautajums_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `kapi`
--
ALTER TABLE `kapi`
  MODIFY `MirDzivn_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ledusskapis`
--
ALTER TABLE `ledusskapis`
  MODIFY `Ledusskapja_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `lietotaji`
--
ALTER TABLE `lietotaji`
  MODIFY `Lietotajs_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sasniegumi`
--
ALTER TABLE `sasniegumi`
  MODIFY `Sasniegumi_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `sasniegumu_banka`
--
ALTER TABLE `sasniegumu_banka`
  MODIFY `Sasniegums_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transakcijas`
--
ALTER TABLE `transakcijas`
  MODIFY `Transakcijas_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `zvaigznaji`
--
ALTER TABLE `zvaigznaji`
  MODIFY `Zvaigznajs_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `atbildes`
--
ALTER TABLE `atbildes`
  ADD CONSTRAINT `Atbilde_Jautajums` FOREIGN KEY (`Jautajums_ID`) REFERENCES `jautajumu_banka` (`Jautajums_ID`);

--
-- Constraints for table `dzivnieki`
--
ALTER TABLE `dzivnieki`
  ADD CONSTRAINT `Lietotajs_Dzivnieks` FOREIGN KEY (`ID_Lietotajs`) REFERENCES `lietotaji` (`Lietotajs_ID`);

--
-- Constraints for table `horoskopi`
--
ALTER TABLE `horoskopi`
  ADD CONSTRAINT `Zvaigznajs_Horoskops` FOREIGN KEY (`Zvaigznajs`) REFERENCES `zvaigznaji` (`Zvaigznajs_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `kapi`
--
ALTER TABLE `kapi`
  ADD CONSTRAINT `Dzivnieks_Kapi` FOREIGN KEY (`Dzivnieks_ID`) REFERENCES `dzivnieki` (`Dzivnieks_ID`),
  ADD CONSTRAINT `Lietotajs_Kapi` FOREIGN KEY (`Lietotajs_ID`) REFERENCES `lietotaji` (`Lietotajs_ID`);

--
-- Constraints for table `ledusskapis`
--
ALTER TABLE `ledusskapis`
  ADD CONSTRAINT `Ediens_Ledusskapis` FOREIGN KEY (`Ediens_ID`) REFERENCES `ediens` (`Ediens_ID`),
  ADD CONSTRAINT `Lietotajs_Ledusskapis` FOREIGN KEY (`Lietotajs_ID`) REFERENCES `lietotaji` (`Lietotajs_ID`);

--
-- Constraints for table `sasniegumi`
--
ALTER TABLE `sasniegumi`
  ADD CONSTRAINT `Lietotajs_Sasniegumi` FOREIGN KEY (`Lietotajs_ID`) REFERENCES `lietotaji` (`Lietotajs_ID`),
  ADD CONSTRAINT `Sasniegums_Sasniegumi` FOREIGN KEY (`Sasniegums_ID`) REFERENCES `sasniegumu_banka` (`Sasniegums_ID`);

--
-- Constraints for table `transakcijas`
--
ALTER TABLE `transakcijas`
  ADD CONSTRAINT `Ediens_Transakcijas` FOREIGN KEY (`Ediens_ID`) REFERENCES `ediens` (`Ediens_ID`),
  ADD CONSTRAINT `Lietotajs_Transakcijas` FOREIGN KEY (`Lietotajs_ID`) REFERENCES `lietotaji` (`Lietotajs_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
