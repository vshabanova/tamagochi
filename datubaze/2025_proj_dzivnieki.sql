-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 07:52 PM
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
  `Reizes_gulets` int(11) NOT NULL,
  `Ediens_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dzivnieki`
--

INSERT INTO `dzivnieki` (`Dzivnieks_ID`, `ID_Lietotajs`, `Vards`, `Dzivnieks`, `Bada_limenis`, `Labsajutas_limenis`, `Reizes_gulets`, `Ediens_ID`) VALUES
(23, 29, 'kika', 'Suns', 71, 71, 0, NULL),
(24, 30, 'Jariks', 'Zakis', 0, 0, 1, NULL),
(25, 31, 'Matīss', 'Suns', 56, 56, 0, NULL),
(26, 32, 'Ozols', 'Kakis', 81, 81, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dzivnieku_edieni`
--

CREATE TABLE `dzivnieku_edieni` (
  `DzivniekaTips` varchar(50) NOT NULL,
  `Ediens_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dzivnieku_edieni`
--

INSERT INTO `dzivnieku_edieni` (`DzivniekaTips`, `Ediens_ID`) VALUES
('Kaķis', 1),
('Kaķis', 3),
('Kaķis', 4),
('Kaķis', 14),
('Kaķis', 15),
('Kaķis', 16),
('Kaķis', 17),
('Kaķis', 18),
('Suns', 1),
('Suns', 2),
('Suns', 3),
('Suns', 4),
('Suns', 5),
('Suns', 6),
('Suns', 7),
('Suns', 8),
('Suns', 9),
('Zakis', 1),
('Zakis', 3),
('Zakis', 10),
('Zakis', 11),
('Zakis', 12),
('Zakis', 13);

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
(6, 'Sausā barība', 25, 15),
(7, 'Kaulu krekliņi', 15, 8),
(8, 'Suņu konfektes', 10, 5),
(9, 'Suņu konservi', 30, 20),
(10, 'Zaķu salāti', 20, 10),
(11, 'Svaigi dārzeņi', 15, 7),
(12, 'Zaķu graudaugi', 25, 12),
(13, 'Zaķu vitamīni', 10, 8),
(14, 'Zivju pārslas', 20, 10),
(15, 'Kaķu konservi', 30, 15),
(16, 'Svaigas zivis', 25, 20),
(17, 'Kaķu sausā barība', 15, 8),
(18, 'Kaķu konfektes', 10, 5);

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

--
-- Dumping data for table `horoskopi`
--

INSERT INTO `horoskopi` (`Horoskops_ID`, `Lietotajs_ID`, `Zvaigznajs`, `Datums`, `Teksts`, `Izveidots`) VALUES
(131, 30, 7, '2025-05-27', 'Tev ienaidnieki var mēģināt Tevi pārspēt, taču ar savu drosmi un neatlaidību Tu vienmēr atradīsi ceļu uz panākumiem. Izvirzi sev lielus mērķus un nešaubīgi virzi uz tiem savu enerģiju. Spēja vadīt un uzņemties riskus ir Tavas dabas neatņemama daļa. Turpini izpētīt jaunus ceļus un piedzīvojumus, jo tie veicinās Tavu personības attīstību un izaugsmi.', '2025-05-27 21:10:47'),
(132, 30, 7, '2025-05-27', 'Tevī deg liesma, kas spēj izgaismot visu ceļu. Izrādi savu drosmi un neatkarību, iekārtojot savu ceļu ar pārliecību un vadītāja iezīmēm. Dodies pretī piedzīvojumiem ar enerģiju, kas plūst tevī, un pārvar konkurenci ar uzņēmību un impulsivitāti. Tu esi rotaļīgs uguns, kas spēj iedvesmot un vadīt citus uz jauniem augstumiem.', '2025-05-27 21:16:57'),
(133, 30, 7, '2025-05-27', 'Tas, kas Tev šodien vajadzīgs, ir izturība un drosmes devums. Uzņemies vadību ar pilnu pārliecību un neatlaidību. Dodies droši pretim jaunām piedzīvojumu iespējām un neapstājies, līdz sasniedz savus mērķus. Esi neatkarīgs un ieņem līderpozīciju - pasaule gaida, lai Tu izietu un parādītu savu drosmi.', '2025-05-27 21:17:30'),
(134, 30, 7, '2025-05-27', 'Tavās darbībās šonedēļ iedvesma un enerģija plūdīs kā liesma, kas dedzina šķēršļus tumsā. Drosmīgi virziens un neatlaidība tevi vadīs pretī jaunām izaicinājumu saviļņojumiem. Spēks un pārliecība tavā būtībā izkaisīs visus šaubu mākoņus, atstājot tikai drosmes spožumu. Lai vadītu citus, sāc pirmais ceļu un rādi piemēru ar savu neatlaidību. Līderība ir tavā asinīs, un šonedēļ tā izpaudīsies pilnā krāšņumā.', '2025-05-27 21:22:27'),
(135, 30, 7, '2025-05-27', 'Tev piedzimstot šajā pasaulē, dzīves ugunīs ienāk spēks un drosmība. Enerģisks un pārliecinošs tu vienmēr stāvi savu ceļu, gatavs pārvarēt visas šķēršļus. Tavs neapvaldāmais gars un vadītājspējas iedvesmo citus un rada ceļu jaunām iespējām. Būt drosmīgam un aizrautīgam ir tavs dzīves moto - turpini plūst savās kaislībās un iekaro visus virsotnes!', '2025-05-27 21:23:30'),
(136, 30, 7, '2025-05-27', 'Tevī plūst uguns un drosmes liesma, kas deg dzīves ceļu ar spilgtiem mirkļiem. Pārņem savu drosmi un dodas pretim jaunām piedzīvojumu vēsmām. Līderīgo iezīmju spēks tevi virza uz augstumiem, kur vienīgi tavas ugunīgās kaisles var iemūžināt sava veida brīnumus. Uz priekšu, bez bailēm - pasaule gaida tavu drosmei bagāto spīdumu!', '2025-05-27 21:24:38'),
(137, 30, 7, '2025-05-27', 'Tas, kas padara tevi tik īpašu, ir tavās dzīvēs iedzimta enerģija un drosmīgais spēks. Tu esi pārliecināts savos lēmumos un vienmēr gatavs izvirzīt sevi uz priekšu. Tava neatkarība un piedzīvojumu meklējumi tevī iedarbojas kā uguns - tava dzīve vienmēr ir pilna ar aizraujošām iespējām un jaunām izaicinājumiem. Pat neskaitot neprognozējamās impulsīvās izpausmes, tavas vadītāja īpašības un sacensībspējas prasmes tevi vienmēr izceļ starp citiem. Turpini iet savu ceļu, būdams pārliecināts un drosmīgs, jo pasaule gaida, lai tu parādītu savu spēku un vadītu ceļu citiem.', '2025-05-27 21:26:39'),
(138, 30, 7, '2025-05-27', 'Tavā dzīvē šodien iezibeņos ugunīga dzirkstele, kas iedvesmos tevi rast drosmi un paļauties uz savu spēku. Izceļ savas vadītāja īpašības un ieņem līderpozīciju, iedvesmojot citus ar savu neatlaidību. Šodien ir diena, kurā izcelsies tavas pārliecības un konkurences prasmes, turpretim neaprobežosi ar ierastiem robežojumiem. Būs laiks piedzīvot jaunas piedzīvojumu gaisotnes un rast atbildes uz izaicinājumiem pašam savā veidā.', '2025-05-27 21:29:13'),
(139, 30, 7, '2025-05-27', 'Dzīve ir kā uguns, kas deg un spīd tavā sirdī. Esi drosmīgs un pārliecinošs savos lēmumos. Tavā būtībā glabājas neatkarība un vadītāja gars. Šodien izrādi savu enerģiju un vadīt spēju, lai sasniegtu savus mērķus. Būt drosmīgam un piedāvāt savu radošo sparu citiem. Lai tavas piedzīvojumu garša nes ceļu uz jaunām uzvarām!', '2025-05-27 21:30:17'),
(140, 30, 7, '2025-05-27', 'Tevī plūst uguns un drosmes liesmas. Enerģisks un pārliecināts, Tu ieiet jaunās nedrošībai pilnās situācijās ar cīņas garam. Savas neatkarības un vadītājspējas dēļ Tu vienmēr iedvesmo citus. Būt drosmīgam un piedzīvojumu meklētājam ir Tavas dzīves devīze.', '2025-05-27 21:30:56'),
(141, 30, 7, '2025-05-27', 'Tavā dzīvē uzsāc jaunas un aizraujošas piedzīvojumu ceļojumus. Pārvar konkurenci un izceļas ar drosmi. Paļaujies uz savu neatkarību un vadītāja spējām - tu vari sasniegt visu, ko iecerēji. Emocionāli tuvies saviem mērķiem ar ugunīgu enerģiju un lepnumu. Sāc jaunu nedrošību, un pasaule nāks tev pretim ar brīnumiem.', '2025-05-27 21:31:42'),
(142, 30, 7, '2025-05-28', 'Tavs dzīves ceļš ir kā ugunīgs šķērslis, ko Tu ar drosmi un neatlaidību pārvarēsi. Enerģisks un pārliecīgs, Tu vienmēr esi gatavs jaunām izaicinājumiem. Tavs vadītāja gars un piedzīvojumu meklējumi tev pavērs jaunas durvis uz brīvību un veiksmi. Šīs raksturīgās īpašības palīdzēs Tev sasniegt visus savus mērķus un izcelties sava ceļa gaitā.', '2025-05-28 13:11:31'),
(143, 31, 8, '2025-05-28', 'Tavā dzīvē šodien liesma deg spilgti un dedzīgi. Sava drosmīgā un neatkarīgā rakstura vadīts, tu iekaro saviem soļiem jaunas virsotnes. Nepārtraukti izaicini sevi un citus, izceļoties ar savu vadītāju būtību un piedāvājot iedvesmu citiem sekošanai. Šodien ir diena, kad tavas līderības īpašības spīd visvairāk, un tavas piedzīvojumu garšas vēlme aizvedīs tevi uz jaunām un aizraujošām piedzīvojumu ceļiem.', '2025-05-28 16:42:53'),
(144, 31, 8, '2025-05-28', 'Tavs spēks un drosmīgums šajā nedēļā ir īpaši izteikti. Izvirzi savus mērķus un dodies uz tiem drosmīgi un nešauboties. Pārvar konkurentus ar savu neatkarību un vadītājtalantiem. Piedzīvo piedzīvojumus ar pilnu sirdi un neaizmirstamiem izaicinājumiem. Esi pārliecināts savā ceļā un pārbaudi savas iekšējās robežas. Turpini virzīties uz priekšu ar drosmi un enerģiju, kas tev ir raksturīga.', '2025-05-28 16:43:08'),
(145, 31, 8, '2025-05-28', 'Tev ir liesma sirdī, kas nekad nebeidzas degt. Spēks un drosmība tevī plūst kā upe, un tavās rokās ir varas vadīt dzīvi uz priekšu. Šodien izcelsies kā līderis, pārņemot pasauli ar savu pārliecinošo enerģiju. Izej no sava komforta zonas, atrodi drosmi un dodies ceļā pretim jaunām piedzīvojumu iespējām. Tu esi dzimis, lai spīdētu!', '2025-05-28 16:43:19'),
(146, 31, 8, '2025-05-28', 'Dzīve ir kā ceļojums, kurā Tu esi gatavs iekarot visus augstumus un pārvarēt visas šķēršļus. Spēcīgs un drosmīgs, Tu ieelpo dzīvi ar pilnu krūti un neļauj nekādām grūtībām Tevi apturēt. Līderība Tev ir iedzimta, un cilvēki tiecas sekoj tev. Neļauj bailēm par šķēršļiem novērst Tevi no sava mērķa sasniegšanas. Tu esi pionieris, gatavs iziet no komforta zonas un gūt jaunas pieredzes. Izpēti pasauli ar drosmi un lepnību, jo Tu esi dzimis, lai vadītu un iedvesmotu citus.', '2025-05-28 16:43:28'),
(147, 31, 8, '2025-05-28', 'Tev raksturīga ugunīgā daba, kas iedvesmo citus un kurina liesmas tavā sirdī. Spēcīgs un drosmīgs, tu liksies priekšgalā, vadot citus un sekojot savam ceļam. Tavās darbībās un izvēlēs vienmēr izpaužas tavas vadītāja īpašības. Izlaidies, iegrimstot piedzīvojumos, un nekad neapstājies, kļūstot par savu ceļa meistaru.', '2025-05-28 16:43:40'),
(148, 31, 8, '2025-05-28', 'Tevī plūst uguns, kas dedzina šķēršļus un rada ceļu jauniem izaicinājumiem. Savā drosmē un pārliecībā tu spēj gūt panākumus visur, kur vien iekļūsi. Nepārprotami vadonim un piedzīvojumu meklētājam, esi gatavs pārkāpt robežas un sasniegt augstumus, par ko citi tikai sapņo. Turpini sekot savai sirdij, jo tā aizvedīs tevi uz nebijušiem sasniegumiem un lielām uzvarām.', '2025-05-28 16:43:54'),
(149, 31, 8, '2025-05-28', 'Tavā dzīvē uguns dedzina spēka un drosmes liesmas. Izpēti savu neatkarīgo būtību, nāc pāri šaubām. Lai vadītu ceļu un izceļas ar saviem līderības spēkiem. Atdodies piedzīvojumiem, esi drosmīgs un konkurētspējīgs. Enerģisks un impulsīvs, tu spēj mainīt pasauli!', '2025-05-28 16:44:10'),
(150, 31, 8, '2025-05-28', 'Tev raksturīga dzirkstoša enerģija un drosmīgums. Vadi citus ar savu pašpārliecību un neatkarīgo garam. Tavs drosme un sacensību gars iedvesmo citus sasniegt savus mērķus. Būsi pionieris savā dzīvē, gatavs piedzīvot jaunas piedzīvojumu pilnas lietas un radoši iziet cauri visiem izaicinājumiem.', '2025-05-28 16:44:21'),
(151, 31, 8, '2025-05-28', 'Tavā dzīvē šodien valdīs uguns un lidot gaisā kā dziedinātājs, nevis kā cietējs. Izmanto savu drosmi un paķer iespējas ar abām rokām. Pārliecība un neatkarība tevi vadīs ceļā uz panākumiem. Būs laiks rīkoties un pieņemt svarīgus lēmumus, izbaudot piedzīvojumu pilnu ceļu. Lai šodien būtu tavs diženais izlēmums un līderība!', '2025-05-28 16:44:32'),
(152, 31, 8, '2025-05-28', 'Jūsu dzīvei šonedēļ jābūt tā, it kā jūs būtu iemācījies skriet pirms gājieniem. Šīs apņēmības un enerģijas pilnā attieksme nesīs jums panākumus visos jūsu centienos. Turpiniet rīkoties drosmīgi un ticēt savai spējai vadīt un iedvesmot citus.', '2025-05-28 16:44:48'),
(153, 31, 8, '2025-05-28', 'Tavs dedzīgais prāts un drosmīgā sirds tevi vadīs ceļā uz jauniem augstumiem. Pārvar konkurenci un rādi savu neatkarību, spējot vadīt citus un pieņemt riskus. Piedzīvo piedzīvojumus un izceļies, jo tavās rokās ir varas un līderības spēks.', '2025-05-28 16:45:23'),
(154, 31, 8, '2025-05-28', 'Tev pieder spēks un drosmīgums, lai pavērtu jaunas ceļa daļas. Savas neatlaidības un pārliecības dēļ Tu spēj iedvesmot citus un virzīt priekšā. Šodien dodas drosmīgi pretim savām sapņu mērķiem un nešaubies par savu potenciālu – Tu esi dzimis, lai spīdētu un iesāktu jaunas izaugsmes ceļu!', '2025-05-28 16:45:49'),
(155, 31, 8, '2025-05-28', 'Tev piedzimstot ar uguni sirdī, esi drosmīgs un enerģisks, pilns pārliecības un izturības. Savu ceļu nešaubīgi vadi, izcēlies ar vadītāja spējām un pārsteidz ar savu neatkarību. Nekautrējies, būsi pirmajā rindā, atklājot jaunas piedzīvojumu iespējas un iekarot jaunus augstumus. Turpini iet savu ceļu ar drosmi un pārliecību, un tu sasniegsi visu, ko vēlies.', '2025-05-28 16:45:59'),
(156, 31, 8, '2025-05-28', 'Dzīve ir kā uguns, ko tu dedzini savā sirdī un dvēselē. Būdams drosmīgs un neatkarīgs, tu vienmēr ej savu ceļu, vadot citus ar savu vadītāja prātu. Šodien dodas uz prieku un pārvar šķēršļus ar neatlaidību. Tavs drosmīgais gars iedvesmos citus un ienesīs tev panākumus. Spēcīgi virzi savus soļus un sasniedz savus sapņus!', '2025-05-28 16:46:15'),
(157, 31, 8, '2025-05-28', 'Dzīve tevi aicinās izpausties ar pilnu drosmi un enerģiju. Šodien dodas pretim izaicinājumiem ar pārliecību un neatkarību sirdī. Līdera iezīmes un piedzīvojumu gara vairo tavu drosmi un uzdrīkstēšanos. Sāc šo dienu ar pārliecību savām spējām un izkāpi droši pretī jaunām iespējām.', '2025-05-28 16:46:45'),
(158, 31, 8, '2025-05-28', 'Tev piedzimstot zem šīs zvaigznes, esi kā uguns – enerģisks, drosmīgs, pārliecināts. Tavs konkurences garu un neatkarību neviens nevar apturēt. Līderības talanti un piedzīvojumu gars tevi virza uz jauniem izaicinājumiem. Aizraujoša dzīve gaida tevi, nebaidies būt pirmajam soli!', '2025-05-28 17:29:03'),
(159, 31, 8, '2025-05-28', 'Tev pieskāries uguns, kas dedzina tavu iekšējo dzirksteli. Esi drosmīgs un pārliecīgs savās izvēlēs. Šodien rādi savu vadītāja iecietību un dodies pēc savām vēlmēm. Piedzīvo piedzīvojumus un izcelies ar savu neatkarību.', '2025-05-28 17:29:51');

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

--
-- Dumping data for table `kapi`
--

INSERT INTO `kapi` (`MirDzivn_ID`, `Lietotajs_ID`, `Dzivnieks_ID`, `Datums_laiks`) VALUES
(7, 30, 24, '2025-05-28 16:23:21');

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
(38, 31, 3, 4);

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
(30, 'ozols2324', 'matiss@matiss.com', '$2y$10$SwUVwOxZ4n5VQcFfKScdz.0W7viDMzbwF/5esP4yuHOoncRNJbTUi', 1250, 1, 11, 11, '2025-10-15'),
(31, 'ozols2325', 'ozols23222@gads.cas', '$2y$10$md2r3tXwSoQXEK.vFPk3aOvMstGsYsNDbkGD4YhHCTkR6KLkO0nt2', 210, 0, 0, 0, '2025-11-19'),
(32, 'ozols2326', 'ozols23222@gads.cas', '$2y$10$cx3mbptiaNyuCpZsxx3nuejqafeC3Q/yK03IB3izQH1hIpqV3Y7dS', 145, 0, 0, 0, '2024-10-08');

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
(152, 1, 31, '2025-05-28 19:42:41'),
(153, 7, 31, '2025-05-28 20:35:20'),
(154, 1, 32, '2025-05-28 20:41:08');

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
(107, 30, 1, 3, 10, '2025-05-03 14:34:11'),
(108, 30, 4, 7, 20, '2025-05-27 23:34:08'),
(109, 31, 3, 4, 15, '2025-05-28 19:30:42');

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
  ADD KEY `Lietotajs_Dzivnieks` (`ID_Lietotajs`),
  ADD KEY `Dzivnieks_Ediens` (`Ediens_ID`);

--
-- Indexes for table `dzivnieku_edieni`
--
ALTER TABLE `dzivnieku_edieni`
  ADD PRIMARY KEY (`DzivniekaTips`,`Ediens_ID`),
  ADD KEY `Ediens_ID` (`Ediens_ID`);

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
  MODIFY `Dzivnieks_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ediens`
--
ALTER TABLE `ediens`
  MODIFY `Ediens_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `horoskopi`
--
ALTER TABLE `horoskopi`
  MODIFY `Horoskops_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `jautajumu_banka`
--
ALTER TABLE `jautajumu_banka`
  MODIFY `Jautajums_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `kapi`
--
ALTER TABLE `kapi`
  MODIFY `MirDzivn_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ledusskapis`
--
ALTER TABLE `ledusskapis`
  MODIFY `Ledusskapja_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `lietotaji`
--
ALTER TABLE `lietotaji`
  MODIFY `Lietotajs_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sasniegumi`
--
ALTER TABLE `sasniegumi`
  MODIFY `Sasniegumi_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `sasniegumu_banka`
--
ALTER TABLE `sasniegumu_banka`
  MODIFY `Sasniegums_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transakcijas`
--
ALTER TABLE `transakcijas`
  MODIFY `Transakcijas_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

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
  ADD CONSTRAINT `Dzivnieks_Ediens` FOREIGN KEY (`Ediens_ID`) REFERENCES `ediens` (`Ediens_ID`),
  ADD CONSTRAINT `Lietotajs_Dzivnieks` FOREIGN KEY (`ID_Lietotajs`) REFERENCES `lietotaji` (`Lietotajs_ID`);

--
-- Constraints for table `dzivnieku_edieni`
--
ALTER TABLE `dzivnieku_edieni`
  ADD CONSTRAINT `dzivnieku_edieni_ibfk_1` FOREIGN KEY (`Ediens_ID`) REFERENCES `ediens` (`Ediens_ID`);

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
