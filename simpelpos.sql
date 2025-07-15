-- MariaDB dump 10.19  Distrib 10.10.5-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: simpelpos
-- ------------------------------------------------------
-- Server version	10.10.5-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategoris`
--

DROP TABLE IF EXISTS `kategoris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategoris` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategoris_nama_unique` (`nama`),
  UNIQUE KEY `kategoris_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategoris`
--

LOCK TABLES `kategoris` WRITE;
/*!40000 ALTER TABLE `kategoris` DISABLE KEYS */;
INSERT INTO `kategoris` VALUES
(1,'maiores','maiores','Qui est reiciendis est molestiae quibusdam velit.','2025-05-30 00:54:43','2025-05-23 01:36:24',NULL),
(2,'odio','odio','Eius accusantium nostrum nobis quis.','2025-02-07 22:10:56','2025-01-21 00:06:41',NULL),
(3,'est','est','Provident ut deserunt saepe voluptatem et provident.','2025-06-14 02:56:13','2025-05-31 15:08:47',NULL),
(4,'harum','harum','Dolor et incidunt facere officia aut.','2025-05-12 01:20:29','2025-04-05 19:48:26',NULL),
(5,'vero','vero','Fugit dolorum veniam enim numquam facere.','2025-02-03 19:06:57','2025-01-10 06:24:32',NULL),
(6,'non','non','Officia enim aut laudantium.','2025-06-16 16:45:05','2025-02-03 13:37:15',NULL),
(7,'consequuntur','consequuntur','Voluptate sit quasi molestiae dolor.','2025-04-16 22:22:06','2025-07-12 10:12:51',NULL),
(8,'quia','quia','Reiciendis consequatur aut aut molestiae id.','2025-01-15 01:29:51','2025-06-02 00:34:05',NULL),
(9,'sit','sit','Pariatur veniam voluptas alias neque.','2025-06-12 08:13:40','2025-05-11 19:41:27',NULL),
(10,'in','in','Modi dolores facilis esse.','2025-04-05 02:07:10','2025-07-10 18:41:31',NULL);
/*!40000 ALTER TABLE `kategoris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mereks`
--

DROP TABLE IF EXISTS `mereks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mereks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mereks_nama_unique` (`nama`),
  UNIQUE KEY `mereks_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mereks`
--

LOCK TABLES `mereks` WRITE;
/*!40000 ALTER TABLE `mereks` DISABLE KEYS */;
INSERT INTO `mereks` VALUES
(1,'Huels Ltd','huels-ltd','Illum accusantium ipsa cupiditate id.','2025-05-04 03:21:12','2025-04-08 03:41:09',NULL),
(2,'Grant-Cormier','grant-cormier','Optio exercitationem ex ut eaque.','2025-06-20 03:29:37','2025-03-30 20:47:08',NULL),
(3,'Eichmann Inc','eichmann-inc','Perferendis aut atque non et aut et.','2025-02-21 23:32:01','2025-06-01 13:57:29',NULL),
(4,'Kihn PLC','kihn-plc','Pariatur aut dignissimos qui error.','2025-03-29 16:45:26','2025-03-06 02:37:05',NULL),
(5,'Heaney-Blanda','heaney-blanda','Dolores quis sunt et qui repellat et.','2025-06-25 12:30:28','2025-03-15 13:31:43',NULL),
(6,'Connelly, Berge and Hudson','connelly-berge-and-hudson','Sit harum vitae ut.','2025-06-05 20:08:24','2025-05-16 01:24:20',NULL),
(7,'Leuschke PLC','leuschke-plc','Aut recusandae cumque iusto temporibus.','2025-04-13 11:13:20','2025-03-31 13:03:08',NULL),
(8,'Kuphal-Littel','kuphal-littel','Ullam ut quidem laborum.','2025-06-23 19:06:45','2025-06-15 23:09:15',NULL),
(9,'Tremblay LLC','tremblay-llc','Sint et vel voluptates voluptates.','2025-01-24 21:54:46','2025-01-31 22:43:39',NULL),
(10,'Wuckert, Bruen and Kub','wuckert-bruen-and-kub','Doloribus repellat quo dolorem dolor porro.','2025-02-03 14:06:39','2025-02-22 19:07:44',NULL);
/*!40000 ALTER TABLE `mereks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_reset_tokens_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2025_07_13_082433_create_produks_table',1),
(6,'2025_07_14_002612_create_pelanggans_table',1),
(7,'create_kategori',1),
(8,'create_merek',1),
(9,'create_penjualans',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pelanggans`
--

DROP TABLE IF EXISTS `pelanggans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pelanggans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `no_ktp` varchar(20) DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pelanggans_email_unique` (`email`),
  UNIQUE KEY `pelanggans_no_ktp_unique` (`no_ktp`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelanggans`
--

LOCK TABLES `pelanggans` WRITE;
/*!40000 ALTER TABLE `pelanggans` DISABLE KEYS */;
INSERT INTO `pelanggans` VALUES
(1,'Cameron Schmidt','zraynor@example.org','+62990354112','9028 Kendall Tunnel Apt. 411\nBartonborough, IA 21367-0542','L','1972-08-13','Food Preparation','3266538843035033',1,'2025-07-03 08:49:16','2025-06-09 20:02:22',NULL),
(2,'Jakayla Legros','weissnat.gaston@example.net','+62135949795','2618 Gutkowski Pines Apt. 829\nEast Lempi, AL 15826','P','1973-04-24','Cartoonist','2018650269566555',0,'2025-05-03 05:18:08','2025-01-22 19:04:09',NULL),
(3,'Houston West','maurine82@example.net','+62460637047','2001 Karson Center\nMollieview, IL 91194','P','1992-08-16','Shipping and Receiving Clerk','2387930137698930',1,'2025-05-24 00:11:00','2025-04-02 08:06:40',NULL),
(4,'Mr. Sylvester Padberg','schneider.jordy@example.net','+62367842547','6581 Berge Field\nKatherynmouth, ME 40154-7461','P','1998-12-11','Mathematical Science Teacher','0777096421372924',1,'2025-06-13 11:46:21','2025-02-22 07:42:04',NULL),
(5,'Prof. Owen Stehr MD','leola.marks@example.org','+62822275575','87838 Carter Fort\nEast Margret, OK 72523-7028','L','1973-06-26','Producer','8037616655887985',1,'2025-04-15 06:38:49','2025-03-10 17:28:56',NULL),
(6,'Retta Wintheiser','tremblay.danielle@example.com','+62002806536','260 Bode Turnpike\nWest Salliefort, PA 14290-1974','L','1972-12-07','Database Administrator','7465904387959171',1,'2025-06-27 16:19:40','2025-05-23 14:11:19',NULL),
(7,'Mrs. Lyla Schimmel IV','gage.hickle@example.com','+62551308119','6249 Douglas Trace\nTadville, LA 63639-8206','L','1973-04-15','Human Resource Director','0672602887115317',1,'2025-05-15 17:56:09','2025-06-09 01:42:52',NULL),
(8,'Prof. Anibal Murray','kim.price@example.com','+62940681056','590 Rau Crescent\nNew Kathleenside, OH 86223','P','1971-02-24','Set and Exhibit Designer','5168770608806826',1,'2025-06-14 10:47:55','2025-02-28 04:40:49',NULL),
(9,'Prof. Luisa Thiel','quitzon.savannah@example.org','+62577934706','663 Bechtelar Highway Apt. 925\nHintzside, CT 27598-9769','P','1978-08-26','Refractory Materials Repairer','4997880209977481',1,'2025-07-12 01:31:06','2025-06-07 17:21:08',NULL),
(10,'Treva Langworth I','smitham.mazie@example.org','+62921749001','8976 Jana Walk\nPort Zachariahshire, ID 16839-3018','L','1997-12-26','Telecommunications Line Installer','4180315998628481',1,'2025-01-14 12:18:06','2025-05-07 10:43:57',NULL),
(11,'Therese Grant','joshuah.mitchell@example.net','+62166422292','108 Weber Island Suite 843\nNew Yasminetown, IN 35844-0898','P','1976-04-21','Painting Machine Operator','4701518108884824',1,'2025-05-29 21:33:53','2025-03-02 01:54:00',NULL),
(12,'Amani Schmidt','esther38@example.org','+62194753781','7340 Evelyn Springs\nNorth Sterlingstad, SD 86731','L','1995-05-08','Producer','8223237944753079',1,'2025-04-16 07:51:45','2025-04-04 03:31:30',NULL),
(13,'Mrs. Talia Weber DDS','omari.trantow@example.com','+62982093174','22781 Eichmann Spring Suite 669\nBerniermouth, MI 82283-9903','L','1973-01-28','Computer Operator','1561939724271582',1,'2025-03-21 22:34:54','2025-04-22 23:50:38',NULL),
(14,'Dr. Aric Swift I','wryan@example.net','+62215645066','81421 Weissnat Street Apt. 193\nNew Sofia, NC 46930','P','1997-06-08','Sales Person','1742198880135316',1,'2025-04-30 01:08:48','2025-07-12 00:54:15',NULL),
(15,'Ebba Schimmel','luciano.nienow@example.com','+62388352502','59799 Dannie Common\nSatterfieldstad, LA 26146','P','1977-06-17','Opticians','4047672543556054',0,'2025-04-12 21:16:24','2025-06-20 08:40:08',NULL),
(16,'Rebeca Mraz II','harmon.bartell@example.com','+62819945380','3707 Schmidt Oval\nYundtborough, ME 29735','P','1982-12-12','Marking Clerk','4305898627345316',1,'2025-07-06 09:09:48','2025-02-16 07:18:06',NULL),
(17,'Jan Cole','ryder52@example.com','+62052130942','7970 Alford Fall\nPearlland, WA 89525-1246','L','1971-03-16','Appliance Repairer','1332110911963491',1,'2025-03-24 06:06:42','2025-01-04 23:54:04',NULL),
(18,'Abbigail Huel','pietro78@example.org','+62334226769','261 Eloisa River\nSouth Abelside, IN 16887','P','1996-09-13','Manager of Food Preparation','4690552993859702',1,'2025-02-22 15:57:05','2025-06-19 22:28:18',NULL),
(19,'Velva Thompson','candido.nolan@example.org','+62782040915','447 Estell Motorway Apt. 191\nSouth Royalmouth, MS 44000','L','2003-09-25','Precious Stone Worker','3540463010754350',0,'2025-06-22 10:38:28','2025-01-30 16:11:28',NULL),
(20,'Mr. Chad Bode III','ljaskolski@example.com','+62309148573','64597 Elenora Crest Suite 763\nEast Akeem, CA 87966','P','1990-08-20','Forest and Conservation Technician','3078131134061601',0,'2025-07-12 06:25:48','2025-02-03 21:35:34',NULL),
(21,'Coralie Auer','mkuhlman@example.net','+62149391388','367 Neva Hill\nEdgarland, AK 44221','L','1991-02-17','Coroner','9200557434750611',1,'2025-03-10 18:11:17','2025-02-18 03:25:17',NULL),
(22,'Bertha Mills','florence.leffler@example.net','+62348624452','7849 Hipolito Gateway Apt. 040\nPort Eddiestad, GA 68357','L','1986-04-23','Purchasing Agent','3335561890937138',1,'2025-07-02 19:01:06','2025-03-12 14:26:38',NULL),
(23,'Dr. William Bergstrom','kenya74@example.org','+62223658819','9190 Schroeder Trail\nDavisside, SC 97461-4608','L','1966-11-24','Proofreaders and Copy Marker','2139790638319613',1,'2025-04-14 14:47:56','2025-06-11 07:42:59',NULL),
(24,'Dr. Roma Torp III','morar.margret@example.com','+62768536300','334 Riley Squares Apt. 188\nNew Charleyville, KY 89938-8689','P','1968-11-02','Taper','4691656198535059',1,'2025-02-09 00:46:10','2025-05-22 09:37:26',NULL),
(25,'Roberto Langosh V','sherwood.cassin@example.com','+62830781800','374 Gibson Road Apt. 271\nSouth Vernieside, HI 41803','L','1996-07-10','School Social Worker','9334993068407975',1,'2025-07-08 12:35:40','2025-07-04 10:04:07',NULL),
(26,'Asia Powlowski','abraham.beer@example.org','+62796547125','8775 Kessler Villages Suite 128\nPhoebeshire, NJ 08419-0611','L','1991-01-31','Medical Assistant','5721233136245853',1,'2025-02-24 01:33:05','2025-05-04 00:37:57',NULL),
(27,'Major Runolfsdottir','mgorczany@example.net','+62907158378','482 Boris Garden Suite 689\nNew Vernerburgh, DE 87313','P','2002-12-14','Radar Technician','2617718039147068',1,'2025-01-08 05:27:51','2025-04-23 10:29:48',NULL),
(28,'Maymie Goldner','lennie76@example.org','+62253559682','3425 Loma Keys\nVadatown, WA 14113','L','1993-03-12','Tree Trimmer','9759058814867997',1,'2025-06-04 03:27:19','2025-06-03 10:50:07',NULL),
(29,'Ms. Sophie Douglas Sr.','treva61@example.net','+62347203612','6706 Vandervort Divide Apt. 777\nRosemarymouth, VA 58208','L','1993-09-17','Self-Enrichment Education Teacher','0043752810703523',1,'2025-04-08 07:05:34','2025-04-26 14:53:44',NULL),
(30,'Dedrick Luettgen','nbrown@example.com','+62912280764','855 Littel Track Apt. 061\nBrakusburgh, WV 04800','P','2000-09-13','Legislator','5910597644841958',0,'2025-01-30 08:58:17','2025-05-14 13:52:41',NULL),
(31,'Delphia Upton','lakin.agnes@example.net','+62334792556','8677 Charlotte Junctions Apt. 155\nNorth Lexusborough, ID 60974-8340','P','1982-12-04','Casting Machine Set-Up Operator','6897080849112248',1,'2025-07-05 13:11:46','2025-07-05 07:47:56',NULL),
(32,'Prof. Alexie Walker','clara20@example.net','+62849407687','6317 Stoltenberg Haven Suite 590\nCharlieburgh, DE 15883-1010','L','1975-07-11','Electronics Engineer','4755839331889559',1,'2025-04-30 18:30:58','2025-02-01 17:21:48',NULL),
(33,'Willy Cruickshank','yundt.jameson@example.com','+62830786805','72662 Eulah Springs Apt. 897\nBednarville, ND 84225-7280','L','1991-10-12','Construction','1471328264191606',1,'2025-01-06 17:33:13','2025-03-14 05:27:48',NULL),
(34,'Coby Morar','ubalistreri@example.org','+62553237760','49284 Batz Courts Apt. 806\nDorcasside, NM 37638','L','2005-05-19','Broadcast News Analyst','3077740983802888',0,'2025-03-19 09:36:51','2025-05-19 22:55:14',NULL),
(35,'Aletha Batz','harold60@example.org','+62286960109','8432 Kub Orchard\nBerneicehaven, CO 10464','L','1979-10-01','Choreographer','6716333167121774',1,'2025-03-21 02:50:43','2025-04-23 18:59:55',NULL),
(36,'Miss Alexane Kreiger','qjakubowski@example.net','+62231747643','19222 Anabel Alley\nLake Kane, WA 14763-5486','P','1969-07-22','Marking Machine Operator','4962051102194433',0,'2025-06-19 09:33:28','2025-04-19 21:50:27',NULL),
(37,'Randi Stiedemann','zohara@example.net','+62459081127','1660 Lynch Cliff Apt. 735\nClairebury, WY 94267','L','1995-02-18','Kindergarten Teacher','1365377722870102',0,'2025-06-27 13:42:42','2025-03-16 16:11:18',NULL),
(38,'Dylan Rath','jany65@example.com','+62410720099','7456 Satterfield Loop\nNew Alfred, NY 68629-0904','P','2003-06-19','Agricultural Sales Representative','1234670583078733',1,'2025-01-20 09:31:19','2025-01-12 10:28:01',NULL),
(39,'Mrs. Samantha Rice','payton.kautzer@example.net','+62273935592','299 Wolf Pass\nOmerborough, RI 93093-9069','L','1980-11-18','Dispatcher','9702996161925516',1,'2025-05-22 10:42:51','2025-01-07 20:03:58',NULL),
(40,'Dr. Wellington Abernathy Jr.','dana35@example.org','+62116582454','37961 Tromp Squares\nLake Lonny, MA 99549','P','1973-11-15','History Teacher','3091388179688438',1,'2025-03-14 01:49:19','2025-04-12 19:15:57',NULL),
(41,'Willie Runte','alycia91@example.com','+62389076412','14430 Jordyn Streets\nLake Jesusshire, MO 33819-9910','L','1988-02-02','Library Science Teacher','1765788847567545',1,'2025-06-29 15:59:21','2025-01-18 08:49:27',NULL),
(42,'Oswald Stokes DDS','rau.gregoria@example.org','+62545822883','565 Carroll Points\nSantosfurt, RI 33648','P','1999-07-13','Paving Equipment Operator','5917495753575547',1,'2025-06-17 13:22:20','2025-01-15 18:55:21',NULL),
(43,'Mr. Andres Beahan','earline.lesch@example.org','+62160859961','168 Block Centers Suite 067\nLuettgenside, TN 80403-1960','L','2003-03-02','Social Science Research Assistant','8342137641852569',1,'2025-07-11 12:31:11','2025-02-24 12:41:08',NULL),
(44,'Timmy Predovic','kaylin.kohler@example.net','+62931622014','5403 Ludwig Shoals\nDonnellyborough, VA 75925','P','1983-11-18','Legislator','9683121040781560',1,'2025-02-01 04:36:46','2025-06-10 21:19:57',NULL),
(45,'Celestine Bernier','schamberger.mckenna@example.org','+62206566163','66167 Carrie Landing Apt. 976\nAlyshaland, VA 98981','P','1967-07-05','Precision Instrument Repairer','6509200460373293',1,'2025-06-17 23:57:01','2025-04-25 17:49:16',NULL),
(46,'Prof. Bartholome Pfannerstill III','ward.juliet@example.org','+62194498162','6512 Sylvester Crossroad Suite 982\nLake Miguel, NM 25876','L','1984-07-17','Engineering','8639798026222256',0,'2025-02-25 10:01:12','2025-06-07 22:40:00',NULL),
(47,'Mr. Mohammad Collier','renner.sally@example.org','+62482670279','551 Antone Fords Apt. 515\nEast Keelytown, ID 01933-3746','L','2007-03-16','Product Management Leader','4049812302307472',1,'2025-01-23 11:57:00','2025-05-05 16:31:58',NULL),
(48,'Geraldine Mante','trevion.schmeler@example.net','+62539022887','91725 Nadia Heights Apt. 222\nNew Emmitt, NV 75398','P','1988-11-19','Architectural Drafter OR Civil Drafter','9171052735145051',0,'2025-05-28 04:46:17','2025-02-16 08:09:04',NULL),
(49,'Dr. Imogene Jacobi MD','dmitchell@example.com','+62275008508','60389 Hettinger Spurs Suite 187\nKiehnland, WI 10142-1818','P','2001-04-19','Home','2080334723355785',1,'2025-04-13 16:17:04','2025-04-15 17:19:18',NULL),
(50,'Imogene Walker','olin.robel@example.com','+62082793776','357 Howe Club Apt. 191\nKathrynberg, NC 10268-6092','L','1973-02-04','Library Assistant','3386470462771814',1,'2025-02-21 14:10:16','2025-03-30 05:49:31',NULL);
/*!40000 ALTER TABLE `pelanggans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penjualan_produks`
--

DROP TABLE IF EXISTS `penjualan_produks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penjualan_produks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint(20) unsigned NOT NULL,
  `barang_id` bigint(20) unsigned NOT NULL,
  `kode_sku` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `harga_modal` decimal(15,2) DEFAULT NULL,
  `harga_jual` decimal(15,2) NOT NULL,
  `harga_jual_asli` decimal(15,2) NOT NULL,
  `jumlah` decimal(10,3) NOT NULL,
  `diskon_persen` decimal(5,2) NOT NULL,
  `diskon_nominal` decimal(15,2) NOT NULL,
  `harga_setelah_diskon` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `laba_per_item` decimal(15,2) NOT NULL,
  `berat` decimal(10,3) DEFAULT NULL,
  `catatan_item` text DEFAULT NULL,
  `is_promo` tinyint(1) NOT NULL DEFAULT 0,
  `jenis_promo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penjualan_produks_penjualan_id_foreign` (`penjualan_id`),
  KEY `penjualan_produks_barang_id_foreign` (`barang_id`),
  CONSTRAINT `penjualan_produks_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penjualan_produks_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan_produks`
--

LOCK TABLES `penjualan_produks` WRITE;
/*!40000 ALTER TABLE `penjualan_produks` DISABLE KEYS */;
INSERT INTO `penjualan_produks` VALUES
(16,8,1,'SKU-9134','deleniti voluptatem','pcs',60327.00,100000.00,977372.11,50.000,0.00,0.00,100000.00,5000000.00,1983650.00,0.140,'',0,NULL,'2025-07-14 18:53:48','2025-07-14 18:53:48'),
(17,9,47,'SKU-5433','sequi quos','pcs',322196.20,500000.00,77784.03,20.000,0.00,0.00,500000.00,10000000.00,3556076.00,4.640,'',0,NULL,'2025-07-14 18:54:54','2025-07-14 18:54:54'),
(18,10,22,'SKU-1067','reiciendis qui','liter',354333.50,1000000.00,477044.00,6.000,0.00,0.00,1000000.00,6000000.00,3873999.00,8.930,'',0,NULL,'2025-07-14 18:55:45','2025-07-14 18:55:45');
/*!40000 ALTER TABLE `penjualan_produks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penjualans`
--

DROP TABLE IF EXISTS `penjualans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penjualans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_penjualan` varchar(255) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `waktu_penjualan` time NOT NULL,
  `pelanggan_id` bigint(20) unsigned DEFAULT NULL,
  `nama_pelanggan` varchar(255) DEFAULT NULL,
  `telepon_pelanggan` varchar(255) DEFAULT NULL,
  `alamat_pelanggan` text DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `diskon_persen` decimal(5,2) NOT NULL,
  `diskon_nominal` decimal(15,2) NOT NULL,
  `pajak_persen` decimal(5,2) NOT NULL,
  `pajak_nominal` decimal(15,2) NOT NULL,
  `biaya_pengiriman` decimal(15,2) NOT NULL,
  `total_akhir` decimal(15,2) NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL,
  `jumlah_bayar` decimal(15,2) NOT NULL,
  `kembalian` decimal(15,2) NOT NULL,
  `status_pembayaran` varchar(255) NOT NULL,
  `status_pengiriman` varchar(255) NOT NULL,
  `catatan` text DEFAULT NULL,
  `referensi_pembayaran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `penjualans_kode_penjualan_unique` (`kode_penjualan`),
  KEY `penjualans_pelanggan_id_foreign` (`pelanggan_id`),
  KEY `penjualans_user_id_foreign` (`user_id`),
  CONSTRAINT `penjualans_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `penjualans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualans`
--

LOCK TABLES `penjualans` WRITE;
/*!40000 ALTER TABLE `penjualans` DISABLE KEYS */;
INSERT INTO `penjualans` VALUES
(8,'PJ-20250715-DZMJYM','2025-07-15','03:52:42',NULL,NULL,NULL,NULL,1,5000000.00,0.00,0.00,0.00,0.00,0.00,5000000.00,'tunai',0.00,-5000000.00,'belum_lunas','belum_dikirim',NULL,NULL,'2025-07-14 18:53:48','2025-07-14 18:53:48'),
(9,'PJ-20250715-ZSJAHX','2025-07-08','03:53:59',NULL,NULL,NULL,NULL,1,10000000.00,0.00,0.00,0.00,0.00,0.00,10000000.00,'tunai',0.00,-10000000.00,'belum_lunas','belum_dikirim',NULL,NULL,'2025-07-14 18:54:54','2025-07-14 18:54:54'),
(10,'PJ-20250715-FIJYXA','2025-07-15','03:55:27',NULL,NULL,NULL,NULL,1,6000000.00,0.00,0.00,0.00,0.00,0.00,6000000.00,'tunai',0.00,-6000000.00,'belum_lunas','belum_dikirim',NULL,NULL,'2025-07-14 18:55:45','2025-07-14 18:55:45');
/*!40000 ALTER TABLE `penjualans` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `insert_status_pembayaran` 
            BEFORE INSERT ON `penjualans`
            FOR EACH ROW 
            SET NEW.status_pembayaran = CASE
                WHEN NEW.kembalian >= 0 THEN 'lunas'
                ELSE 'belum_lunas'
            END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `update_status_pembayaran` 
            BEFORE UPDATE ON `penjualans`
            FOR EACH ROW 
            SET NEW.status_pembayaran = CASE
                WHEN NEW.kembalian >= 0 THEN 'lunas'
                ELSE 'belum_lunas'
            END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produks`
--

DROP TABLE IF EXISTS `produks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `harga_modal` decimal(10,2) DEFAULT NULL,
  `jumlah_stok` int(11) NOT NULL DEFAULT 0,
  `kode_sku` varchar(255) DEFAULT NULL,
  `kode_barcode` varchar(255) DEFAULT NULL,
  `id_kategori` bigint(20) unsigned NOT NULL,
  `id_merek` bigint(20) unsigned NOT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `berat` decimal(8,2) DEFAULT NULL,
  `panjang` decimal(8,2) DEFAULT NULL,
  `lebar` decimal(8,2) DEFAULT NULL,
  `tinggi` decimal(8,2) DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `stok_minimum` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `produks_nama_unique` (`nama`),
  UNIQUE KEY `produks_slug_unique` (`slug`),
  UNIQUE KEY `produks_kode_sku_unique` (`kode_sku`),
  UNIQUE KEY `produks_kode_barcode_unique` (`kode_barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produks`
--

LOCK TABLES `produks` WRITE;
/*!40000 ALTER TABLE `produks` DISABLE KEYS */;
INSERT INTO `produks` VALUES
(1,'deleniti voluptatem','deleniti-voluptatem','Officiis pariatur eos laboriosam nostrum sed nulla sunt ut fugit.',977372.11,60327.00,98,'SKU-9134','1302884081717',1,10,'pcs',0.14,87.75,89.46,46.90,0,11,'https://via.placeholder.com/640x480.png/008877?text=products+blanditiis','2025-06-17 07:24:09','2025-01-11 12:31:36',NULL),
(2,'reiciendis ut','reiciendis-ut','Qui dignissimos modi et eum hic velit eius.',522589.25,37601.21,77,'SKU-2327','8832823432087',7,9,'pcs',7.77,85.19,92.71,64.11,1,17,'https://via.placeholder.com/640x480.png/00bb11?text=products+est','2025-06-26 02:32:02','2025-04-19 01:46:05',NULL),
(3,'veritatis exercitationem','veritatis-exercitationem','Rerum sit velit dolor placeat sapiente tempore vero.',40433.27,482973.71,96,'SKU-1779','9246725501540',4,10,'liter',3.04,93.92,94.97,53.47,1,8,'https://via.placeholder.com/640x480.png/0088bb?text=products+distinctio','2025-05-18 06:49:27','2025-01-29 06:01:36',NULL),
(4,'sunt harum','sunt-harum','Optio culpa autem ex consectetur iusto repellat maxime.',937030.14,31390.07,37,'SKU-0825','9827009867509',7,2,'pcs',7.44,14.11,31.94,77.45,1,16,'https://via.placeholder.com/640x480.png/002277?text=products+rerum','2025-04-08 12:43:25','2025-02-19 00:52:45',NULL),
(5,'voluptate doloribus','voluptate-doloribus','Illo perspiciatis dolores doloribus temporibus magnam autem ipsa non quas nihil quaerat eum.',664310.52,167924.33,60,'SKU-5221','1170215642216',7,4,'pcs',6.07,74.20,87.14,73.75,1,20,'https://via.placeholder.com/640x480.png/00dd00?text=products+aut','2025-07-03 01:55:04','2025-04-13 17:22:48',NULL),
(6,'quae doloribus','quae-doloribus','Voluptatem eos enim deserunt alias repellat doloribus aut minima rerum sint in.',228168.24,240845.44,73,'SKU-1330','7505187476240',3,5,'pcs',1.97,93.99,50.06,66.76,1,15,'https://via.placeholder.com/640x480.png/0066bb?text=products+quaerat','2025-06-17 00:21:08','2025-01-18 19:43:37',NULL),
(7,'ullam iure','ullam-iure','Sequi voluptatibus eos quia recusandae facere doloribus officiis reiciendis assumenda sit est ut.',811895.44,455790.73,63,'SKU-6303','2219779126073',6,8,'liter',0.81,88.93,65.40,82.63,1,14,'https://via.placeholder.com/640x480.png/003388?text=products+molestias','2025-01-26 08:57:40','2025-02-12 08:15:47',NULL),
(8,'officiis est','officiis-est','Vitae ut pariatur non et tenetur commodi laborum minus sint.',276070.54,264438.19,30,'SKU-2001','2183330249665',5,9,'box',8.17,12.18,11.85,21.88,1,7,'https://via.placeholder.com/640x480.png/001199?text=products+minus','2025-07-01 14:41:56','2025-04-12 18:28:04',NULL),
(9,'accusamus vel','accusamus-vel','Ipsa eum exercitationem ipsum fuga iusto molestiae.',581848.63,404986.31,78,'SKU-3127','5630711926358',3,9,'liter',3.48,15.96,88.32,37.41,1,9,'https://via.placeholder.com/640x480.png/00ff33?text=products+facere','2025-03-16 19:02:31','2025-01-28 06:13:35',NULL),
(10,'non qui','non-qui','Est illo aut nulla suscipit perferendis perspiciatis velit voluptatem fuga molestiae eos illum.',487876.66,142499.57,27,'SKU-8468','1374018807135',2,6,'box',8.74,47.09,76.49,22.23,1,20,'https://via.placeholder.com/640x480.png/00ee11?text=products+porro','2025-06-06 08:05:31','2025-03-10 22:54:07',NULL),
(11,'qui consequuntur','qui-consequuntur','Eaque eius doloremque ratione aut commodi iusto ea molestiae dignissimos.',34449.77,169760.26,72,'SKU-5813','5394819496136',9,5,'box',3.65,47.84,13.77,37.77,1,18,'https://via.placeholder.com/640x480.png/0000cc?text=products+voluptas','2025-02-28 02:25:24','2025-05-29 11:18:12',NULL),
(12,'voluptatem pariatur','voluptatem-pariatur','Inventore neque delectus sequi non rem a optio labore facilis harum.',448715.47,94701.03,62,'SKU-7635','6898348066895',7,10,'liter',4.25,30.83,63.82,90.83,1,8,'https://via.placeholder.com/640x480.png/003355?text=products+eveniet','2025-05-24 06:51:16','2025-02-16 05:27:20',NULL),
(13,'architecto voluptates','architecto-voluptates','Est quam ex asperiores qui aut saepe aut et esse incidunt veniam possimus ab.',613216.07,191253.13,40,'SKU-9374','5151815570129',1,6,'kg',1.60,80.69,16.01,60.48,1,8,'https://via.placeholder.com/640x480.png/00ffdd?text=products+fuga','2025-06-23 19:29:06','2025-01-30 02:15:36',NULL),
(14,'est inventore','est-inventore','Odio saepe sequi quibusdam temporibus est voluptatem beatae impedit voluptatem odit nisi corrupti quia amet.',65376.89,220889.60,97,'SKU-5080','9154598090385',5,7,'box',6.98,7.45,65.58,68.71,1,18,'https://via.placeholder.com/640x480.png/00ddcc?text=products+maxime','2025-03-27 08:47:38','2025-05-19 23:24:32',NULL),
(15,'doloremque cumque','doloremque-cumque','Id ullam similique iste tempora tempora ratione sed.',116991.07,186588.18,91,'SKU-7056','7002236324076',3,5,'liter',1.18,44.31,80.63,15.49,1,1,'https://via.placeholder.com/640x480.png/008844?text=products+dolore','2025-01-11 16:01:25','2025-06-12 15:13:25',NULL),
(16,'culpa ad','culpa-ad','Aut architecto dolorem quaerat optio quibusdam id qui natus et.',725411.32,405172.05,72,'SKU-8445','1155257761668',7,5,'pcs',2.49,30.00,35.66,29.34,1,8,'https://via.placeholder.com/640x480.png/00ee77?text=products+autem','2025-05-18 23:34:24','2025-01-21 07:13:16',NULL),
(17,'reprehenderit iste','reprehenderit-iste','Totam est quod aliquid consequatur earum et.',992441.33,247522.95,1,'SKU-5976','9608086231472',10,4,'liter',2.92,84.94,18.78,82.73,1,2,'https://via.placeholder.com/640x480.png/0044ee?text=products+cum','2025-02-17 10:31:49','2025-07-05 15:26:20',NULL),
(18,'beatae molestiae','beatae-molestiae','Velit dolor inventore et odit est est molestias quo accusantium et enim voluptas.',131082.53,151524.41,95,'SKU-4478','3869329833891',6,4,'box',4.88,45.83,82.20,6.46,1,13,'https://via.placeholder.com/640x480.png/008877?text=products+laborum','2025-02-17 19:23:55','2025-05-19 11:45:30',NULL),
(19,'ut rem','ut-rem','Illum occaecati et cupiditate dolore ad sit aliquam doloremque accusantium quidem doloremque vel.',508973.34,216447.04,3,'SKU-1271','6083858222248',8,4,'box',7.73,64.74,69.17,10.07,1,8,'https://via.placeholder.com/640x480.png/008833?text=products+tempore','2025-05-10 11:47:44','2025-03-02 01:54:49',NULL),
(20,'eum quisquam','eum-quisquam','Totam neque reiciendis et quia dolor ut nobis adipisci velit et ullam id animi.',411849.13,437381.45,20,'SKU-8589','2266669511648',2,8,'pcs',5.48,36.99,12.24,93.72,1,11,'https://via.placeholder.com/640x480.png/00dd77?text=products+eum','2025-06-26 07:26:03','2025-06-10 12:47:01',NULL),
(21,'nemo voluptatem','nemo-voluptatem','Quibusdam non quia nisi minima iusto officia sequi sit iste consequatur nesciunt reiciendis.',825696.85,338235.85,79,'SKU-6176','1833797352460',2,6,'pcs',9.14,73.85,24.61,52.98,1,4,'https://via.placeholder.com/640x480.png/00bbee?text=products+corporis','2025-06-25 17:45:45','2025-01-17 12:10:33',NULL),
(22,'reiciendis qui','reiciendis-qui','Voluptatibus et nisi hic similique quis voluptatem id reprehenderit voluptates ut repudiandae.',477044.00,354333.50,8,'SKU-1067','7265593215016',9,10,'liter',8.93,5.63,19.62,16.63,1,20,'https://via.placeholder.com/640x480.png/00eeaa?text=products+dolorem','2025-02-15 02:28:13','2025-02-08 15:15:28',NULL),
(23,'officia commodi','officia-commodi','Veniam non corrupti voluptatibus assumenda eos labore error iste ratione ut iusto velit.',680844.55,481246.48,92,'SKU-2822','4122882151338',2,9,'liter',9.22,54.44,59.91,79.78,1,10,'https://via.placeholder.com/640x480.png/002277?text=products+alias','2025-03-27 22:53:34','2025-02-28 23:04:01',NULL),
(24,'sint quaerat','sint-quaerat','Tempore amet eos natus et dignissimos velit atque excepturi qui.',386865.29,42640.38,10,'SKU-0356','4619179417548',1,2,'pcs',9.39,23.47,60.28,65.45,1,19,'https://via.placeholder.com/640x480.png/00ffbb?text=products+nihil','2025-01-26 13:31:34','2025-02-26 21:47:15',NULL),
(25,'impedit velit','impedit-velit','Unde corrupti ab quia voluptatem recusandae architecto nostrum ut labore nemo velit.',35341.66,155654.30,15,'SKU-4307','0844295864141',1,2,'kg',0.77,48.94,91.20,52.15,1,15,'https://via.placeholder.com/640x480.png/002211?text=products+asperiores','2025-03-15 20:36:01','2025-02-05 22:39:19',NULL),
(26,'voluptas eum','voluptas-eum','Id est saepe quo fugit alias ad rerum doloremque aperiam.',937321.77,435738.54,92,'SKU-5343','8717690232162',6,9,'pcs',1.86,24.04,24.12,53.28,1,7,'https://via.placeholder.com/640x480.png/00ccee?text=products+possimus','2025-02-17 10:09:03','2025-03-04 02:56:35',NULL),
(27,'sed quos','sed-quos','At occaecati cumque qui eligendi quia quidem neque et.',895017.46,293341.92,78,'SKU-8030','8244293469836',7,6,'box',9.85,97.94,21.45,82.05,1,7,'https://via.placeholder.com/640x480.png/00aa11?text=products+aut','2025-01-09 22:08:33','2025-05-02 20:17:23',NULL),
(28,'numquam a','numquam-a','Placeat soluta exercitationem consequatur tempora autem blanditiis ipsam non dolorem neque soluta totam ipsam.',465947.93,196254.24,94,'SKU-3990','0457212334285',8,3,'box',9.89,76.09,10.84,56.43,0,16,'https://via.placeholder.com/640x480.png/0022cc?text=products+fuga','2025-06-25 16:19:18','2025-01-17 14:25:16',NULL),
(29,'sit minus','sit-minus','Alias pariatur dolorum fugiat aut sed tempore porro nulla quia totam officia ut.',990892.16,453760.16,30,'SKU-3350','8629765500550',6,8,'liter',3.03,26.24,23.65,10.86,1,12,'https://via.placeholder.com/640x480.png/00dd11?text=products+rem','2025-01-30 00:30:40','2025-07-01 19:15:28',NULL),
(30,'est aut','est-aut','Vitae dolores totam placeat ut vero ex voluptatibus commodi quaerat ullam iusto pariatur quam.',597563.65,125831.86,36,'SKU-9206','5531602854111',6,9,'kg',0.24,69.16,13.08,93.40,1,5,'https://via.placeholder.com/640x480.png/007722?text=products+dolores','2025-06-22 18:32:36','2025-06-09 02:28:49',NULL),
(31,'culpa nam','culpa-nam','Rerum voluptas fuga ipsum corporis nisi recusandae illo veniam quis quo voluptate veniam ab.',174572.71,489429.82,60,'SKU-2890','5036652245808',8,6,'pcs',9.29,36.27,61.69,90.60,1,17,'https://via.placeholder.com/640x480.png/007711?text=products+molestiae','2025-06-27 20:47:14','2025-04-22 02:44:00',NULL),
(32,'impedit est','impedit-est','Ut voluptas blanditiis voluptates tenetur in vitae quibusdam odit itaque voluptas magnam.',723992.26,225400.77,87,'SKU-5878','6586128043135',4,3,'kg',0.86,79.78,54.04,29.67,1,3,'https://via.placeholder.com/640x480.png/001100?text=products+illum','2025-04-19 13:16:25','2025-04-09 06:06:47',NULL),
(33,'aut dolor','aut-dolor','Ab esse est possimus autem unde ut sequi maxime laborum nulla laboriosam.',61415.45,466288.61,98,'SKU-8465','4815749557656',3,5,'kg',0.60,34.32,73.23,77.92,1,12,'https://via.placeholder.com/640x480.png/0022ee?text=products+vitae','2025-01-19 11:57:07','2025-03-26 02:42:12',NULL),
(34,'animi tempore','animi-tempore','Id placeat architecto aliquid sunt libero debitis amet dolor odio natus mollitia.',785711.57,11279.17,61,'SKU-8758','6322618385169',2,9,'kg',9.13,16.96,56.08,52.66,0,7,'https://via.placeholder.com/640x480.png/00dd88?text=products+dolorem','2025-01-13 10:17:11','2025-05-11 16:36:30',NULL),
(35,'veniam dolorum','veniam-dolorum','Eum in illo suscipit similique vel doloremque error ea quas.',343225.63,449896.39,10,'SKU-6455','4565212223822',9,7,'kg',9.68,99.60,74.49,43.47,1,17,'https://via.placeholder.com/640x480.png/00bb33?text=products+provident','2025-01-14 08:41:09','2025-02-21 06:59:53',NULL),
(36,'aut accusamus','aut-accusamus','Et distinctio ea sed non harum quia impedit.',846404.23,399075.00,6,'SKU-3941','4398078802043',8,8,'kg',1.67,62.55,14.11,23.43,1,16,'https://via.placeholder.com/640x480.png/008833?text=products+ullam','2025-06-28 23:32:10','2025-04-08 01:09:05',NULL),
(37,'iusto molestiae','iusto-molestiae','Omnis autem sunt alias odit et qui culpa eius quo aut.',845639.71,365671.26,27,'SKU-0518','9090963565105',6,1,'kg',1.09,87.54,31.49,52.85,1,20,'https://via.placeholder.com/640x480.png/0088cc?text=products+aliquam','2025-06-01 07:24:59','2025-03-26 03:38:41',NULL),
(38,'cum reprehenderit','cum-reprehenderit','Consequatur error sint ipsum necessitatibus eos nostrum perferendis ipsa consequuntur repudiandae voluptatem.',811076.08,232716.20,49,'SKU-1926','0206890815094',2,10,'box',7.01,25.42,75.64,35.23,1,1,'https://via.placeholder.com/640x480.png/008844?text=products+iusto','2025-07-03 04:34:40','2025-03-16 00:01:00',NULL),
(39,'sequi voluptatem','sequi-voluptatem','Dolores id cum veniam delectus aspernatur eos accusamus numquam.',201045.86,28314.74,56,'SKU-6014','3572264206940',6,6,'kg',1.00,51.60,28.62,29.29,1,0,'https://via.placeholder.com/640x480.png/002299?text=products+necessitatibus','2025-06-27 10:31:44','2025-06-01 21:52:31',NULL),
(40,'iure eum','iure-eum','Assumenda nesciunt veritatis voluptates facilis similique quaerat non enim eaque aut ratione dolorem impedit.',265155.05,130464.20,53,'SKU-0268','9690912663359',10,3,'pcs',7.47,31.00,12.77,66.36,1,9,'https://via.placeholder.com/640x480.png/00eedd?text=products+sit','2025-04-10 02:56:33','2025-04-13 20:52:21',NULL),
(41,'tenetur soluta','tenetur-soluta','Illum qui consequatur necessitatibus rerum unde deserunt quo ut.',588797.41,428248.10,8,'SKU-0761','7615360930473',6,7,'box',8.30,80.39,38.27,94.34,1,12,'https://via.placeholder.com/640x480.png/002277?text=products+ea','2025-03-11 23:58:01','2025-07-07 21:01:52',NULL),
(42,'nam ipsa','nam-ipsa','Sit ea dolor est est accusamus aut.',683112.38,179485.25,42,'SKU-9404','4739773106386',8,7,'liter',5.77,44.44,88.32,9.65,1,16,'https://via.placeholder.com/640x480.png/00bb00?text=products+quo','2025-06-06 21:51:54','2025-02-13 17:15:14',NULL),
(43,'ad velit','ad-velit','Ea veritatis dolores est exercitationem ipsam atque odit inventore repellendus dolorem dicta.',637103.98,98743.54,66,'SKU-9854','9053723624023',9,5,'box',8.35,12.23,84.09,71.45,1,4,'https://via.placeholder.com/640x480.png/0099dd?text=products+adipisci','2025-07-05 00:49:19','2025-06-07 00:24:50',NULL),
(44,'sit culpa','sit-culpa','Minus ut odit iusto delectus quibusdam et quis ducimus assumenda et quasi qui.',297747.00,157534.30,51,'SKU-0020','1827475878908',3,10,'kg',7.93,68.29,99.22,73.05,1,18,'https://via.placeholder.com/640x480.png/002288?text=products+vitae','2025-02-22 03:05:47','2025-04-07 16:29:27',NULL),
(45,'qui et','qui-et','Sunt magnam dolor sequi sequi dolore saepe temporibus iusto et qui.',210630.56,106316.67,89,'SKU-8372','2196401373664',9,6,'box',0.45,32.03,23.91,55.92,1,11,'https://via.placeholder.com/640x480.png/0088ee?text=products+et','2025-03-30 12:45:55','2025-07-02 14:47:15',NULL),
(46,'minima perspiciatis','minima-perspiciatis','Qui dolorem ea doloremque dolorem labore maiores et ipsum optio quaerat ut corrupti.',650050.75,245309.99,41,'SKU-7997','2788043861908',3,10,'kg',3.62,42.94,11.63,60.60,1,16,'https://via.placeholder.com/640x480.png/00cc44?text=products+velit','2025-04-30 10:08:19','2025-07-08 23:37:30',NULL),
(47,'sequi quos','sequi-quos','Vero quidem sint voluptatem ab omnis unde earum quisquam et amet.',77784.03,322196.20,66,'SKU-5433','2733706427717',6,4,'pcs',4.64,21.08,70.04,88.40,1,17,'https://via.placeholder.com/640x480.png/002211?text=products+nobis','2025-06-01 00:54:17','2025-01-19 02:10:55',NULL),
(48,'quisquam qui','quisquam-qui','Pariatur earum labore necessitatibus quis laborum incidunt.',763730.40,73621.84,59,'SKU-2353','5566578444226',3,2,'pcs',1.22,87.07,90.42,57.10,1,20,'https://via.placeholder.com/640x480.png/0011aa?text=products+ut','2025-05-15 23:36:04','2025-01-21 21:58:56',NULL),
(49,'praesentium dolor','praesentium-dolor','Nesciunt id atque non non tempora officiis aliquid mollitia.',277319.03,37218.35,22,'SKU-3510','0873368142589',6,5,'box',7.98,96.39,87.01,39.62,1,0,'https://via.placeholder.com/640x480.png/00dd66?text=products+aut','2025-07-05 04:30:27','2025-02-10 23:48:12',NULL),
(50,'et et','et-et','Ut enim nam ut quae voluptatem et.',202153.56,357549.11,56,'SKU-4970','5579187801540',2,5,'box',7.11,16.42,94.21,60.76,1,1,'https://via.placeholder.com/640x480.png/006644?text=products+aperiam','2025-04-03 11:53:23','2025-05-27 04:18:53',NULL);
/*!40000 ALTER TABLE `produks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `push_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `sms_notifications` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Test User','test@example.com','2025-07-14 18:15:24','$2y$12$pYix5XSd0wk1/kvGW9I5oOjWNVFZCM4M0fnS2/Cws6p1jZVVt7AU.','0EPQnNNFVU','2025-07-14 18:15:24','2025-07-14 18:15:24',NULL,NULL,NULL,NULL,1,1,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-15 14:50:02
