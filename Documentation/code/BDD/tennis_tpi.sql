-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: tennis_tpi
-- ------------------------------------------------------
-- Server version	5.5.5-10.3.27-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `genre` tinyint(1) NOT NULL,
  `dotation` int(11) NOT NULL,
  `idSurface` int(11) NOT NULL,
  `idType` int(11) NOT NULL,
  `jeuDecisif` tinyint(1) NOT NULL,
  `nbSets` tinyint(4) NOT NULL,
  `nbParticipants` tinyint(4) NOT NULL,
  PRIMARY KEY (`idCategorie`),
  KEY `idSurface` (`idSurface`),
  KEY `idType` (`idType`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`idSurface`) REFERENCES `surfaces` (`idSurface`),
  CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`idType`) REFERENCES `types` (`idType`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (21,1,50001,1,6,1,3,16),(22,0,654,1,1,0,2,16),(23,0,0,1,1,0,2,16),(25,0,0,1,1,0,2,16),(27,0,5,1,1,0,2,16),(28,0,5,1,1,0,2,16),(29,1,6,1,1,1,3,16),(30,1,6,1,1,1,2,16),(31,1,0,1,1,0,2,32),(32,1,0,1,1,0,2,16),(33,1,0,1,1,0,2,16);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `joueurs`
--

DROP TABLE IF EXISTS `joueurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `joueurs` (
  `idJoueur` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `dateNaissance` date NOT NULL,
  `nationalite` varchar(100) NOT NULL,
  `genre` tinyint(1) NOT NULL,
  `classementATP` int(11) NOT NULL,
  PRIMARY KEY (`idJoueur`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joueurs`
--

LOCK TABLES `joueurs` WRITE;
/*!40000 ALTER TABLE `joueurs` DISABLE KEYS */;
INSERT INTO `joueurs` VALUES (36,'Novak','Djokovic','1987-05-22','SRB',1,1),(37,'Rafael','Nadal','1986-06-03','ESP',1,2),(38,'Daniil','Medvedev','1996-02-11','RUS',1,3),(39,'Dominic','Thiem','1993-09-03','AUT',1,4),(40,'Stefanos','Tsitsipas','1998-08-12','GRE',1,5),(41,'Alexander','Zverev','1997-04-20','GER',1,6),(42,'Andrey','Rublev','1997-10-20','RUS',1,7),(43,'Roger','Federer','1981-08-08','SUI',1,8),(44,'Diego Sebastian','Schwartzman','1992-08-16','ARG',1,9),(45,'Matteo','Berrettini','1996-04-12','ITA',1,10),(46,'Roberto','Bautista Agut','1988-04-14','ESP',1,11),(47,'Pablo','Carreno Busta','1991-07-12','ESP',1,12),(48,'David','Goffin','1990-12-07','BEL',1,13),(49,'Denis','Shapovalov','1999-04-15','CAN',1,14),(50,'Gael','Monfils','1986-09-01','FRA',1,15),(51,'Hubert','Hurkacz','1997-02-11','POL',1,16),(52,'Grigor','Dimitrov','1991-05-16','BUL',1,17),(53,'Jannik','Sinner','2001-08-16','ITA',1,18),(54,'Milos','Raonic','1990-12-27','CAN',1,19),(55,'Felix','Auger Aliassime','2000-08-08','CAN',1,20),(56,'Stanislas','Wawrinka','1985-03-28','SUI',1,21),(57,'Casper','Ruud','1998-12-22','NOR',1,22),(58,'Karen','Khachanov','1996-05-21','RUS',1,23),(59,'Alex','De Minaur','1999-02-17','AUS',1,24),(60,'Christian','Garin','1996-05-30','CHI',1,25),(61,'Daniel','Evans','1990-05-23','GBR',1,26),(62,'Aslan','Karatsev','1993-09-04','RUS',1,27),(63,'Fabio','Fognini','1987-05-24','ITA',1,28),(64,'Borna','Coric','1996-11-14','CRO',1,29),(65,'Taylor Harry','Fritz','1997-10-28','USA',1,30),(66,'Nikoloz','Basilashvili','1992-02-23','GEO',1,31),(67,'Ugo','Humbert','1998-06-26','FRA',1,32),(68,'Ashleigh','Barty','1996-04-24','AUS',0,1),(69,'Naomi','Osaka','1997-10-16','JPN',0,2),(70,'Simona','Halep','1991-09-27','ROU',0,3),(71,'Sofia','Kenin','1998-11-14','USA',0,4),(72,'Elina','Svitolina','1994-09-12','UKR',0,5),(73,'Bianca','Andreescu','2000-06-16','CAN',0,6),(74,'Aryna','Sabalenka','1998-05-05','BLR',0,7),(75,'Serena','Williams','1981-09-26','USA',0,8),(76,'Karolina','Pliskova','1992-03-21','CZE',0,9),(77,'Kiki','Bertens','1991-12-10','NED',0,10),(78,'Belinda','Bencic','1997-03-10','SUI',0,11),(79,'Petra','Kvitova','1990-03-08','CZE',0,12),(80,'Garbine','Muguruza','1993-10-08','ESP',0,13),(81,'Jennifer','Brady','1995-04-12','USA',0,14),(82,'Victoria','Azarenka','1989-07-31','BLR',0,15),(83,'Elise','Mertens','1995-11-17','BEL',0,16),(84,'Kiki','Bertens','1991-12-10','NED',0,17),(85,'Johanna','Konta','1991-05-17','GBR',0,18),(86,'Maria','Sakkari','1995-07-25','GRE',0,19),(87,'Karolina','Muchova','1996-08-21','CZE',0,20),(88,'Marketa','Vondrousova','1999-06-28','CZE',0,21),(89,'Elena','Rybakina','1999-06-17','KAZ',0,22),(90,'Madison','Keys','1995-02-17','USA',0,23),(91,'Ons','Jabeur','1994-08-28','TUN',0,24),(92,'Petra','Martic','1991-01-19','CRO',0,25),(93,'Angelique','Kerber','1988-01-18','GER',0,26),(94,'Alison','Riske','1990-07-03','USA',0,27),(95,'Veronika','Kudermetova','1997-04-24','RUS',0,28),(96,'Anett','Kontaveit','1995-12-24','EST',0,29),(97,'Anastasia','Pavlyuchenkova','1991-07-03','RUS',0,30),(98,'Jessica','Pegula','1994-02-24','USA',0,31),(99,'Dayana','Yastremska','2000-05-01','UKR',0,32);
/*!40000 ALTER TABLE `joueurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matches` (
  `idMatch` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `idTerrain` int(11) DEFAULT NULL,
  `idTournois` int(11) DEFAULT NULL,
  `idTour` int(11) DEFAULT NULL,
  `idJoueur1` int(11) NOT NULL,
  `idJoueur2` int(11) NOT NULL,
  `vainqueur` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMatch`),
  KEY `matches_FK` (`idTour`),
  KEY `matches_FK_1` (`idTerrain`),
  KEY `matches_FK_2` (`idTournois`),
  KEY `matches_FK_3` (`idJoueur1`),
  KEY `matches_FK_4` (`idJoueur2`),
  CONSTRAINT `matches_FK` FOREIGN KEY (`idTour`) REFERENCES `tours` (`idTour`),
  CONSTRAINT `matches_FK_1` FOREIGN KEY (`idTerrain`) REFERENCES `terrains` (`idTerrain`),
  CONSTRAINT `matches_FK_2` FOREIGN KEY (`idTournois`) REFERENCES `tournois` (`idTournois`),
  CONSTRAINT `matches_FK_3` FOREIGN KEY (`idJoueur1`) REFERENCES `joueurs` (`idJoueur`),
  CONSTRAINT `matches_FK_4` FOREIGN KEY (`idJoueur2`) REFERENCES `joueurs` (`idJoueur`)
) ENGINE=InnoDB AUTO_INCREMENT=1176 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches`
--

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
INSERT INTO `matches` VALUES (1161,NULL,NULL,NULL,24,2,36,66,NULL),(1162,NULL,NULL,NULL,24,2,42,60,NULL),(1163,NULL,NULL,NULL,24,2,40,62,NULL),(1164,NULL,NULL,NULL,24,2,38,64,NULL),(1165,NULL,NULL,NULL,24,2,37,67,NULL),(1166,NULL,NULL,NULL,24,2,43,61,NULL),(1167,NULL,NULL,NULL,24,2,41,63,NULL),(1168,NULL,NULL,NULL,24,2,39,65,NULL),(1169,NULL,NULL,NULL,24,3,36,42,NULL),(1170,NULL,NULL,NULL,24,3,40,38,NULL),(1171,NULL,NULL,NULL,24,3,37,43,NULL),(1172,NULL,NULL,NULL,24,3,41,39,NULL),(1173,NULL,NULL,NULL,24,4,36,40,NULL),(1174,NULL,NULL,NULL,24,4,37,41,NULL),(1175,NULL,NULL,NULL,24,5,36,37,NULL);
/*!40000 ALTER TABLE `matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scores` (
  `idMatch` int(11) NOT NULL,
  `idSet` int(11) NOT NULL,
  KEY `scores_FK` (`idSet`),
  KEY `scores_FK_1` (`idMatch`),
  CONSTRAINT `scores_FK` FOREIGN KEY (`idSet`) REFERENCES `sets` (`idSet`),
  CONSTRAINT `scores_FK_1` FOREIGN KEY (`idMatch`) REFERENCES `matches` (`idMatch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scores`
--

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;
/*!40000 ALTER TABLE `scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sets`
--

DROP TABLE IF EXISTS `sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sets` (
  `idSet` int(11) NOT NULL AUTO_INCREMENT,
  `score1` tinyint(4) NOT NULL,
  `score2` tinyint(4) NOT NULL,
  PRIMARY KEY (`idSet`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sets`
--

LOCK TABLES `sets` WRITE;
/*!40000 ALTER TABLE `sets` DISABLE KEYS */;
/*!40000 ALTER TABLE `sets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surfaces`
--

DROP TABLE IF EXISTS `surfaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surfaces` (
  `idSurface` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  PRIMARY KEY (`idSurface`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surfaces`
--

LOCK TABLES `surfaces` WRITE;
/*!40000 ALTER TABLE `surfaces` DISABLE KEYS */;
INSERT INTO `surfaces` VALUES (1,'terre battue'),(2,'gazon'),(3,'dur');
/*!40000 ALTER TABLE `surfaces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terrains`
--

DROP TABLE IF EXISTS `terrains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `terrains` (
  `idTerrain` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `lieu` varchar(100) NOT NULL,
  PRIMARY KEY (`idTerrain`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terrains`
--

LOCK TABLES `terrains` WRITE;
/*!40000 ALTER TABLE `terrains` DISABLE KEYS */;
INSERT INTO `terrains` VALUES (1,'terrain A','Nord'),(2,'terrain B','Nord-Est'),(3,'terrain C','Est'),(4,'terrain D','Sud-Est'),(5,'terrain E','Sud'),(6,'terrain F','Sud-Ouest'),(7,'terrain G','Ouest'),(8,'terrain H','Nord-Ouest');
/*!40000 ALTER TABLE `terrains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tournois`
--

DROP TABLE IF EXISTS `tournois`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tournois` (
  `idTournois` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `pays` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `idCategorie` int(11) NOT NULL,
  PRIMARY KEY (`idTournois`),
  KEY `idCategorie` (`idCategorie`),
  CONSTRAINT `tournois_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categories` (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tournois`
--

LOCK TABLES `tournois` WRITE;
/*!40000 ALTER TABLE `tournois` DISABLE KEYS */;
INSERT INTO `tournois` VALUES (14,'Geneva Open','Suisse','Genève','2011-08-19','2011-08-19',25),(16,'Geneva ODD','ss','sss','2011-08-28','2011-08-31',27),(17,'Geneva ODD','ss','sss','2011-08-31','2011-08-31',28),(18,'bob','Suisse','Genève','2011-08-19','2011-08-19',29),(19,'Oprn','Suisse','Genève','2021-05-20','2021-05-27',30),(21,'Geneva Open','Suisse','Genève','2011-08-19','2011-08-19',25),(22,'Ge','fe','fe','2021-05-21','2021-05-28',31),(23,'Geneva Open','Suisse','Genève','2011-08-19','2011-08-19',32),(24,'Geneva Open','ss','sss','2021-05-20','2021-05-27',33);
/*!40000 ALTER TABLE `tournois` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tours`
--

DROP TABLE IF EXISTS `tours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tours` (
  `idTour` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `nbParticipants` int(11) NOT NULL,
  PRIMARY KEY (`idTour`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tours`
--

LOCK TABLES `tours` WRITE;
/*!40000 ALTER TABLE `tours` DISABLE KEYS */;
INSERT INTO `tours` VALUES (1,'1er tour',32),(2,'Huitième de finale',16),(3,'Quart de finale',8),(4,'Demi-finale',4),(5,'Finale',2);
/*!40000 ALTER TABLE `tours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `idType` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) NOT NULL,
  PRIMARY KEY (`idType`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'Grand Chelem'),(2,'Masters'),(3,'Masters 1000'),(5,'ATP 500 Series'),(6,'ATP 250 Series');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tennis_tpi'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-19 15:22:02
