<?php
if (!isset($_SESSION)) {
  session_start();
}

/**
 * fonction qui permet de se rediriger
 * sur une autre page par rapport au chemin du fichier 
 *
 * @param [string] $chemin
 * @return void
 */
function redirection($chemin)
{
  header("Location: $chemin");
  exit();
}


/**
 * Retourne l'id et le nom des surfaces dans la table surfaces
 *
 * @return array
 */
function getSurface()
{
  static $ps = null;
  $sql = 'SELECT idSurface, nom';
  $sql .= ' FROM tennis_tpi.surfaces';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}

/**
 * Retourne les différents types de tournois
 *
 * @return array
 */
function getTournoisType()
{
  static $ps = null;
  $sql = 'SELECT idType, nom';
  $sql .= ' FROM tennis_tpi.types';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}


/**
 * Insert dans la table categories tous les inputs de la page crétion
 *
 * @param [bool] $genre
 * @param [int] $dotation
 * @param [bool] $jeuDecisif
 * @param [int] $nbSet
 * @param [int] $nbParticipant
 * @param [int] $surface
 * @param [int] $typeTournois
 * @return void
 */
function insertCategorie($genre, $dotation, $surface, $typeTournois, $jeuDecisif, $nbSet, $nbParticipant)
{
  static $ps = null;
  $sql = "INSERT INTO `tennis_tpi`.`categories` (`genre`, `dotation`, `idSurface`, `idType`, `jeuDecisif`, `nbSets`, `nbParticipants`) ";
  $sql .= "VALUES (:GENRE, :DOTATION, :ID_SURFACE, :ID_TYPE, :JEU_DECISIF, :NB_SET, :NB_PARTICIPANT)";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':GENRE', $genre, PDO::PARAM_BOOL);
    $ps->bindParam(':DOTATION', $dotation, PDO::PARAM_INT);
    $ps->bindParam(':ID_SURFACE', $surface, PDO::PARAM_INT);
    $ps->bindParam(':ID_TYPE', $typeTournois, PDO::PARAM_INT);
    $ps->bindParam(':JEU_DECISIF', $jeuDecisif, PDO::PARAM_BOOL);
    $ps->bindParam(':NB_SET', $nbSet, PDO::PARAM_INT);
    $ps->bindParam(':NB_PARTICIPANT', $nbParticipant, PDO::PARAM_INT);

    $answer = $ps->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}

/**
 * Récupère l'id de la dernière catégorie
 *
 * @return array
 */
function recupIdCategorie()
{
  static $ps = null;
  $sql = 'SELECT idCategorie ';
  $sql .= 'FROM tennis_tpi.categories ';
  $sql .= 'ORDER BY idCategorie ';
  $sql .= 'DESC LIMIT 1';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    if ($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}


/**
 * Insert dans la table tournois tous les inputs de la page création
 *
 * @param [int] $idCategorie
 * @param [string] $nom
 * @param [string] $pays
 * @param [string] $ville
 * @param [string] $dateDebut
 * @param [string] $dateFin
 * @return void
 */
function insertTournois($nom, $pays, $ville, $dateDebut, $dateFin, $idCategorie)
{
  static $ps = null;
  $sql = "INSERT INTO `tennis_tpi`.`tournois` (`nom`, `pays`, `ville`, `dateDebut`, `dateFin`, `idCategorie`) ";
  $sql .= "VALUES (:NOM, :PAYS, :VILLE, :DATE_DEBUT, :DATE_FIN, :ID_CATEGORIE)";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':NOM', $nom, PDO::PARAM_STR);
    $ps->bindParam(':PAYS', $pays, PDO::PARAM_STR);
    $ps->bindParam(':VILLE', $ville, PDO::PARAM_STR);
    $ps->bindParam(':DATE_DEBUT', $dateDebut, PDO::PARAM_STR);
    $ps->bindParam(':DATE_FIN', $dateFin, PDO::PARAM_STR);
    $ps->bindParam(':ID_CATEGORIE', intval($idCategorie), PDO::PARAM_INT);

    $answer = $ps->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}


/**
 * Récupère les infos du dernier tournois créé
 *
 * @return array
 */
function recupTournoisInfo()
{
  static $ps = null;
  $sql = 'SELECT idTournois, nom, pays, ville, dateDebut, dateFin, idCategorie ';
  $sql .= 'FROM tennis_tpi.tournois ';
  $sql .= 'ORDER BY idCategorie ';
  $sql .= 'DESC';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}



/**
 * Supprime une catégorie par rapport à l'id en paramètre
 *
 * @param [int] $idCategorie
 * @return void
 */
function deleteCategorie($idCategorie)
{
  static $ps = null;
  $sql = "DELETE FROM `tennis_tpi`.`categories` WHERE (`idCategorie` = :ID_CATEGORIE);";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':ID_CATEGORIE', intval($idCategorie), PDO::PARAM_INT);
    $ps->execute();
    $answer = ($ps->rowCount() > 0);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}


/**
 * Supprime un tournois par rapport à l'id en paramètre
 *
 * @param [int] $idTournois
 * @return void
 */
function deleteTournois($idTournois)
{
  static $ps = null;
  $sql = "DELETE FROM `tennis_tpi`.`tournois` WHERE (`idTournois` = :ID_TOURNOIS);";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':ID_TOURNOIS', intval($idTournois), PDO::PARAM_INT);
    $ps->execute();
    $answer = ($ps->rowCount() > 0);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}


/**
 * Retourne les valeurs d'une categorie par rapport à son id
 *
 * @return array
 */
function recupCategorieInfoById($idCategorie)
{
  static $ps = null;
  $sql = 'SELECT idCategorie, genre, dotation, idSurface, idType, jeuDecisif, nbSets, nbParticipants FROM tennis_tpi.categories';
  $sql .= ' WHERE idCategorie = :ID_CATEGORIE';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':ID_CATEGORIE', $idCategorie, PDO::PARAM_INT);

    if ($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}



/**
 * Retourne les valeurs d'un tournois par rapport à son id
 *
 * @return array
 */
function recupTournoisInfoById($idTournois)
{
  static $ps = null;
  $sql = 'SELECT idTournois, nom, pays, ville, dateDebut, dateFin, idCategorie FROM tennis_tpi.tournois';
  $sql .= ' WHERE idTournois = :ID_TOURNOIS';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':ID_TOURNOIS', $idTournois, PDO::PARAM_INT);

    if ($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}



/**
 * Met à jour les données de la table categorie
 *
 * @param [int] $genre
 * @param [int] $dotation
 * @param [int] $idSurface
 * @param [int] $idType
 * @param [int] $jeuDecisif
 * @param [int] $nbSet
 * @param [int] $nbParticipant
 * @param [int] $idCategorie
 * @return array
 */
function updateCategorie($genre, $dotation, $idSurface, $idType, $jeuDecisif, $nbSet, $nbParticipant, $idCategorie)
{
  static $ps = null;

  $sql = "UPDATE `tennis_tpi`.`categories` SET ";
  $sql .= "`genre` = :GENRE, ";
  $sql .= "`dotation` = :DOTATION, ";
  $sql .= "`idSurface` = :ID_SURFACE, ";
  $sql .= "`idType` = :ID_TYPE, ";
  $sql .= "`jeuDecisif` = :JEU_DECISIF, ";
  $sql .= "`nbSets` = :NB_SET, ";
  $sql .= "`nbParticipants` = :NB_PARTICIPANT ";
  $sql .= "WHERE (`idCategorie` = :ID_CATEGORIE)";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':GENRE', intval($genre), PDO::PARAM_INT);
    $ps->bindParam(':DOTATION', intval($dotation), PDO::PARAM_INT);
    $ps->bindParam(':ID_SURFACE', intval($idSurface), PDO::PARAM_INT);
    $ps->bindParam(':ID_TYPE', intval($idType), PDO::PARAM_INT);
    $ps->bindParam(':JEU_DECISIF', intval($jeuDecisif), PDO::PARAM_INT);
    $ps->bindParam(':NB_SET', intval($nbSet), PDO::PARAM_INT);
    $ps->bindParam(':NB_PARTICIPANT', intval($nbParticipant), PDO::PARAM_INT);
    $ps->bindParam(':ID_CATEGORIE', intval($idCategorie), PDO::PARAM_INT);
    $ps->execute();
    $answer = ($ps->rowCount() > 0);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}



/**
 * Met à jour les données de la table tournois
 *
 * @param [string] $pays
 * @param [string] $nom
 * @param [string] $ville
 * @param [string] $dateDebut
 * @param [string] $dateFin
 * @param [int] $idCategorie
 * @param [int] $idTournois
 * @return array
 */
function updateTournois($nom, $pays, $ville, $dateDebut, $dateFin, $idCategorie, $idTournois)
{
  static $ps = null;

  $sql = "UPDATE `tennis_tpi`.`tournois` SET ";
  $sql .= "`nom` = :NOM, ";
  $sql .= "`pays` = :PAYS, ";
  $sql .= "`ville` = :VILLE, ";
  $sql .= "`dateDebut` = :DATE_DEBUT, ";
  $sql .= "`dateFin` = :DATE_FIN, ";
  $sql .= "`idCategorie` = :ID_CATEGORIE ";
  $sql .= "WHERE (`idTournois` = :ID_TOURNOIS)";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':NOM', $nom, PDO::PARAM_STR);
    $ps->bindParam(':PAYS', $pays, PDO::PARAM_STR);
    $ps->bindParam(':VILLE', $ville, PDO::PARAM_STR);
    $ps->bindParam(':DATE_DEBUT', $dateDebut, PDO::PARAM_STR);
    $ps->bindParam(':DATE_FIN', $dateFin, PDO::PARAM_STR);
    $ps->bindParam(':ID_CATEGORIE', intval($idCategorie), PDO::PARAM_INT);
    $ps->bindParam(':ID_TOURNOIS', intval($idTournois), PDO::PARAM_INT);
    $ps->execute();
    $answer = ($ps->rowCount() > 0);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}


/**
 * Effectue une recherche de mot en ayant pour paramètre un ou plusieurs mot(s) entré par l'utilisateur
 *
 * @param [string] $word
 * @return array
 */
function recherche($motRecherche)
{
  static $ps = null;
  $sql = "SELECT * FROM tournois WHERE nom LIKE :SEARCH";

  $answer = false;
  try {
    if ($ps == null) {
      $ps = tennis_database()->prepare($sql);
    }
    $motRecherche = "%$motRecherche%";
    $ps->bindParam(':SEARCH', $motRecherche, PDO::PARAM_STR);
    $ps->execute();

    $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    $answer = array();
    echo $e->getMessage();
  }
  return $answer;
}


/**
 * Récupère tous les joueurs de la table joueurs
 *
 * @return array
 */
function getPlayer()
{
  static $ps = null;
  $sql = 'SELECT idJoueur, prenom, nom, dateNaissance, nationalite, genre, classementATP';
  $sql .= ' FROM tennis_tpi.joueurs';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}


/**
 * Trie les joueurs et les ajoutes dans un tableau en fonction de leur genre et de leur classement
 *
 * @param [array] $tableauJoueurs
 * @return void
 */
function trieJoueur($tableauJoueurs)
{
  $joueurPairHomme = [];
  $joueurImpairHomme = [];
  $joueusePairFemme = [];
  $joueuseImpairFemme = [];

  foreach ($tableauJoueurs as $unJoueur) {
    if ($unJoueur['genre'] == 1) {
      if (fmod($unJoueur['classementATP'], 2) == 0) {
        array_push($joueurPairHomme, $unJoueur);
        $_SESSION['joueursPairHomme'] = $joueurPairHomme;
      } else {
        array_push($joueurImpairHomme, $unJoueur);
        $_SESSION['joueursImpairHomme'] = $joueurImpairHomme;
      }
    } else {
      if (fmod($unJoueur['classementATP'], 2) == 0) {
        array_push($joueusePairFemme, $unJoueur);
        $_SESSION['joueusesPairFemme'] = $joueusePairFemme;
      } else {
        array_push($joueuseImpairFemme, $unJoueur);
        $_SESSION['joueusesImpairFemme'] = $joueuseImpairFemme;
      }
    }
  }
}


/**
 * Organisation des en fonctions des classements pairs et impairs
 *
 * @param [] $joueursImpair
 * @param [] $joueursPair
 * @param [int] $nbJoueurs
 * @return void
 */
function organisationMatch($joueursPair, $joueursImpair, $nbJoueurs)
{
  //Création des variables 
  $tableauPairTemp = [];
  $tableauImpairTemp = [];
  $tableauPair = [];
  $tableauImpair = [];

  //Vérifie le nombre de joueurs par tournois
  if ($nbJoueurs == 16) {

    $longueur = count($joueursImpair) / 4;
    //compte le nombre de joueurs dont le numéro de classement est
    //un chiffre pair
    for ($i = 0; $i < $longueur; $i++) {
      $pair = [];
      array_push($pair, $joueursPair[$i], end($joueursPair));
      unset($joueursPair[$i], $joueursPair[array_key_last($joueursPair)]);
      array_push($tableauPairTemp, $pair);
      unset($pair);
    }

    array_push($tableauPair, $tableauPairTemp[0]);
    array_push($tableauPair, $tableauPairTemp[3]);
    array_push($tableauPair, $tableauPairTemp[2]);
    array_push($tableauPair, $tableauPairTemp[1]);
  

    //compte le nombre de joueurs dont le numéro de classement est
    //un chiffre impair
    for ($i = 0; $i < $longueur; $i++) {
      $impair = [];
      array_push($impair, $joueursImpair[$i], end($joueursImpair));
      unset($joueursImpair[array_key_last($joueursImpair)]);
      unset($joueursImpair[$i]);
      array_push($tableauImpairTemp, $impair);
      unset($impair);
    }
    array_push($tableauImpair, $tableauImpairTemp[0]);
    array_push($tableauImpair, $tableauImpairTemp[3]);
    array_push($tableauImpair, $tableauImpairTemp[2]);
    array_push($tableauImpair, $tableauImpairTemp[1]);


  } else {
    $longueur = count($joueursImpair) / 2;
    //compte le nombre de joueurs dont le numéro de classement est
    //un chiffre pair
    for ($i = 0; $i < $longueur; $i++) {
      $pair = [];
      array_push($pair, $joueursPair[$i], end($joueursPair));
      unset($joueursPair[$i], $joueursPair[array_key_last($joueursPair)]);
      array_push($tableauPairTemp, $pair);
      unset($pair);
    }

    array_push($tableauPair, $tableauPairTemp[0]);
    array_push($tableauPair, $tableauPairTemp[7]);
    array_push($tableauPair, $tableauPairTemp[4]);
    array_push($tableauPair, $tableauPairTemp[3]);
    array_push($tableauPair, $tableauPairTemp[5]);
    array_push($tableauPair, $tableauPairTemp[2]);
    array_push($tableauPair, $tableauPairTemp[6]);
    array_push($tableauPair, $tableauPairTemp[1]);


    //compte le nombre de joueurs dont le numéro de classement est
    //un chiffre impair
    for ($i = 0; $i < $longueur; $i++) {
      $impair = [];
      array_push($impair, $joueursImpair[$i], end($joueursImpair));
      unset($joueursImpair[$i], $joueursImpair[array_key_last($joueursImpair)]);
      array_push($tableauImpairTemp, $impair);
      unset($impair);
    }

    array_push($tableauImpair, $tableauImpairTemp[0]);
    array_push($tableauImpair, $tableauImpairTemp[7]);
    array_push($tableauImpair, $tableauImpairTemp[4]);
    array_push($tableauImpair, $tableauImpairTemp[3]);
    array_push($tableauImpair, $tableauImpairTemp[5]);
    array_push($tableauImpair, $tableauImpairTemp[2]);
    array_push($tableauImpair, $tableauImpairTemp[6]);
    array_push($tableauImpair, $tableauImpairTemp[1]);

  }
  $_SESSION['tableauPair'] = $tableauPair;
  $_SESSION['tableauImpair'] = $tableauImpair;
}

/**
 * Récupère les données de la table tours
 *
 * @return array
 */
function getTour()
{
  static $ps = null;
  $sql = 'SELECT idTour, nom';
  $sql .= ' FROM tennis_tpi.tours';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}


/**
 * Récupère les données de la table terrains
 *
 * @return array
 */
function getTerrain()
{
  static $ps = null;
  $sql = 'SELECT idTerrain, nom, lieu';
  $sql .= ' FROM tennis_tpi.terrains';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}


/**
 * Récupère les joueurs et leurs informations en ayant pour paramètre le genre et le nombre de joueur du tournois
 * 
 * @param [bool] $genre
 * @param [int] $gnbJoueurs
 * @return array 
 */
function getPlayerByParameter($genre, $nbJoueurs)
{
  static $ps = null;
  $sql = 'SELECT idJoueur, prenom, nom, dateNaissance, nationalite, genre, classementATP FROM tennis_tpi.joueurs';
  $sql .= ' WHERE genre = :GENRE';
  $sql .= ' LIMIT :NB_JOUEURS';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':GENRE', $genre, PDO::PARAM_INT);
    $ps->bindParam(':NB_JOUEURS', $nbJoueurs, PDO::PARAM_INT);

    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}



/**
 * Effectue une recherche de mot en ayant pour paramètre le mot entré par l'utilisateur, le genre et le nombre de joueur au tournois
 *
 * @param [string] $word
 * @param [bool] $genre
 * @param [int] $nbJoueurs
 * @return array
 */
function rechercheJoueur($motRecherche, $nbJoueurs, $genre)
{
  static $ps = null;
  $sql = "SELECT * FROM joueurs WHERE nom LIKE :SEARCH AND genre = :GENRE OR prenom LIKE :SEARCH AND genre = :GENRE LIMIT :NB_JOUEURS";

  $answer = false;
  try {
    if ($ps == null) {
      $ps = tennis_database()->prepare($sql);
    }
    $motRecherche = "%$motRecherche%";
    $ps->bindParam(':SEARCH', $motRecherche, PDO::PARAM_STR);
    $ps->bindParam(':GENRE', $genre, PDO::PARAM_BOOL);
    $ps->bindParam(':NB_JOUEURS', $nbJoueurs, PDO::PARAM_INT);
    $ps->execute();

    $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    $answer = array();
    echo $e->getMessage();
  }
  return $answer;
}


/**
 * Insert les informations d'un match dans la tables matches
 *
 * @param [int] $choixTerrain
 * @param [string] $dateMatch
 * @param [string] $heureMatch
 * @param [int] $idTournois
 * @param [int] $idMatch
 * @param [int] $idTour
 * @param [int] $vainqueur
 * @return array
 */
function insertMatch($choixTerrain, $dateMatch, $heureMatch, $idMatch, $vainqueur)
{
  static $ps = null;
  $sql = "UPDATE `tennis_tpi`.`matches` SET ";
  $sql .= "`idTerrain` = :ID_TERRAIN , ";
  $sql .= "`date` = :DATE_MATCH , ";
  $sql .= "`heure` = :HEURE_MATCH , ";
  $sql .= "`vainqueur` = :VAINQUEUR ";
  $sql .= "WHERE (`idMatch` = :ID_MATCH)";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':ID_TERRAIN', $choixTerrain, PDO::PARAM_INT);
    $ps->bindParam(':DATE_MATCH', $dateMatch, PDO::PARAM_STR);
    $ps->bindParam(':HEURE_MATCH', $heureMatch, PDO::PARAM_STR);
    $ps->bindParam(':ID_MATCH', $idMatch, PDO::PARAM_INT);
    $ps->bindParam(':VAINQUEUR', $vainqueur, PDO::PARAM_INT);

    $answer = $ps->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}



function recupIdMatch($idJoueur1, $idJoueur2, $idTour)
{
  static $ps = null;
  $sql = 'SELECT idMatch FROM tennis_tpi.matches ';
  $sql .= 'WHERE idJoueur1 = :ID_JOUEUR1 AND idJoueur2 = :ID_JOUEUR2 AND idTour = :ID_TOUR';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':ID_JOUEUR1', $idJoueur1, PDO::PARAM_INT);
    $ps->bindParam(':ID_JOUEUR2', $idJoueur2, PDO::PARAM_INT);
    $ps->bindParam(':ID_TOUR', $idTour, PDO::PARAM_INT);
    if ($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}



/**
 * Insert la valeur des sets dans la table set
 *
 * @param [int] $score1
 * @param [int] $score2
 * @return array
 */
function insertSets($score1, $score2)
{
  static $ps = null;
  $sql = "INSERT INTO `tennis_tpi`.`sets` (`score1`, `score2`) ";
  $sql .= "VALUES (:SCORE1, :SCORE2)";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':SCORE1', $score1, PDO::PARAM_BOOL);
    $ps->bindParam(':SCORE2', $score2, PDO::PARAM_INT);

    $answer = $ps->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}






/**
 * Insert l'id des joueurs dans la table matches
 *
 * @param [int] $idJoueur1
 * @param [int] $idJoueur2
 * @param [int] $idTour
 * @return array
 */
function insertJoueurMatch($idJoueur1, $idJoueur2, $idTour, $idTournois)
{
  static $ps = null;
  $sql = "INSERT INTO `tennis_tpi`.`matches` (`idJoueur1`, `idJoueur2`, `idTour`, `idTournois`) ";
  $sql .= "VALUES (:ID_JOUEUR1, :ID_JOUEUR2, :ID_TOUR, :ID_TOURNOIS)";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':ID_JOUEUR1', $idJoueur1, PDO::PARAM_INT);
    $ps->bindParam(':ID_JOUEUR2', $idJoueur2, PDO::PARAM_INT);
    $ps->bindParam(':ID_TOUR', $idTour, PDO::PARAM_INT);
    $ps->bindParam(':ID_TOURNOIS', $idTournois, PDO::PARAM_INT);

    $answer = $ps->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}



/**
 * Vérifie que les joueurs existent dans la table matches
 *
 * @param [int] $idJoueur1
 * @param [int] $idJoueur2
 * @param [int] $idTour
 * @return array
 */
function verifJoueurExist($idJoueur1, $idJoueur2, $idTour, $idTournois)
{
  static $ps = null;
  $sql = 'SELECT idJoueur1, idJoueur2, idTour, idTournois FROM tennis_tpi.matches';
  $sql .= ' WHERE idJoueur1 = :ID_JOUEUR1 AND idJoueur2 = :ID_JOUEUR2 AND idTour = :ID_TOUR AND idTournois = :ID_TOURNOIS';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':ID_JOUEUR1', $idJoueur1, PDO::PARAM_INT);
    $ps->bindParam(':ID_JOUEUR2', $idJoueur2, PDO::PARAM_INT);
    $ps->bindParam(':ID_TOUR', $idTour, PDO::PARAM_INT);
    $ps->bindParam(':ID_TOURNOIS', $idTournois, PDO::PARAM_INT);

    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}




/**
 * Fonction qui retourne tous les joueurs vainqueurs des huitième
 *
 * @return array
 */
function recupVainqueurHuitieme()
{
  static $ps = null;
  $sql = 'SELECT vainqueur FROM tennis_tpi.matches';
  $sql .= ' WHERE idJoueur1 = vainqueur AND idTour = 2 OR idJoueur2 = vainqueur AND idTour = 2';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {

    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}
