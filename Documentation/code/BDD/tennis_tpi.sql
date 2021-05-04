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
  `nbParticipants` tinyint(4) NOT NULL,
  `nbSets` tinyint(4) NOT NULL,
  `idSurface` int(11) NOT NULL,
  `idType` int(11) NOT NULL,
  PRIMARY KEY (`idCategorie`),
  KEY `idSurface` (`idSurface`),
  KEY `idType` (`idType`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`idSurface`) REFERENCES `surfaces` (`idSurface`),
  CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`idType`) REFERENCES `types` (`idType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jeu_decisif`
--

DROP TABLE IF EXISTS `jeu_decisif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jeu_decisif` (
  `idJeuDecisif` int(11) NOT NULL AUTO_INCREMENT,
  `nbPoint1` tinyint(4) NOT NULL,
  `nbPoint2` tinyint(4) NOT NULL,
  PRIMARY KEY (`idJeuDecisif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jeu_decisif`
--

LOCK TABLES `jeu_decisif` WRITE;
/*!40000 ALTER TABLE `jeu_decisif` DISABLE KEYS */;
/*!40000 ALTER TABLE `jeu_decisif` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `joue`
--

DROP TABLE IF EXISTS `joue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `joue` (
  `idJoueur` int(11) NOT NULL,
  `idMatch` int(11) NOT NULL,
  KEY `joue_FK` (`idMatch`),
  KEY `joue_FK_1` (`idJoueur`),
  CONSTRAINT `joue_FK` FOREIGN KEY (`idMatch`) REFERENCES `matches` (`idMatch`),
  CONSTRAINT `joue_FK_1` FOREIGN KEY (`idJoueur`) REFERENCES `joueurs` (`idJoueur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joue`
--

LOCK TABLES `joue` WRITE;
/*!40000 ALTER TABLE `joue` DISABLE KEYS */;
/*!40000 ALTER TABLE `joue` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joueurs`
--

LOCK TABLES `joueurs` WRITE;
/*!40000 ALTER TABLE `joueurs` DISABLE KEYS */;
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
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `duree` datetime NOT NULL,
  `idTerrain` int(11) NOT NULL,
  `idTournois` int(11) NOT NULL,
  `idTour` int(11) NOT NULL,
  PRIMARY KEY (`idMatch`),
  KEY `matches_FK` (`idTour`),
  KEY `matches_FK_1` (`idTerrain`),
  KEY `matches_FK_2` (`idTournois`),
  CONSTRAINT `matches_FK` FOREIGN KEY (`idTour`) REFERENCES `tours` (`idTour`),
  CONSTRAINT `matches_FK_1` FOREIGN KEY (`idTerrain`) REFERENCES `terrains` (`idTerrain`),
  CONSTRAINT `matches_FK_2` FOREIGN KEY (`idTournois`) REFERENCES `tournois` (`idTournois`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches`
--

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
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
  `idJeuDecisif` int(11) NOT NULL,
  `score1` tinyint(4) NOT NULL,
  `score2` tinyint(4) NOT NULL,
  PRIMARY KEY (`idSet`),
  KEY `sets_FK` (`idJeuDecisif`),
  CONSTRAINT `sets_FK` FOREIGN KEY (`idJeuDecisif`) REFERENCES `jeu_decisif` (`idJeuDecisif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surfaces`
--

LOCK TABLES `surfaces` WRITE;
/*!40000 ALTER TABLE `surfaces` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terrains`
--

LOCK TABLES `terrains` WRITE;
/*!40000 ALTER TABLE `terrains` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tournois`
--

LOCK TABLES `tournois` WRITE;
/*!40000 ALTER TABLE `tournois` DISABLE KEYS */;
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
  PRIMARY KEY (`idTour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tours`
--

LOCK TABLES `tours` WRITE;
/*!40000 ALTER TABLE `tours` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
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

-- Dump completed on 2021-05-04 11:31:41
