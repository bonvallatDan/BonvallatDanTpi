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
  $tableauPair = [];
  $tableauPairTemp = [];
  $tableauImpair = [];
  $tableauImpairTemp = [];

  //Vérifie le nombre de joueurs par tournois
  if ($nbJoueurs == 16) {



    $longueur = $nbJoueurs / 4;
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
 * Insert les données dans la table matches
 *
 * @param [int] $choixTerrain
 * @param [string] $dateMatch
 * @param [string] $heureMatch
 * @return array
 */
function insertMatch($choixTerrain, $dateMatch, $heureMatch, $idTournois, $idMatch, $vainqueur)
{
  static $ps = null;
  $sql = "UPDATE `tennis_tpi`.`matches` SET ";
  $sql .= "`idTerrain` = :CHOIX_TERRAIN , ";
  $sql .= "`date` = :DATE_MATCH , ";
  $sql .= "`heure` = :HEURE_MATCH , ";
  $sql .= "`vainqueur` = :VAINQUEUR ";
  $sql .= "WHERE `idTournois` = :ID_TOURNOIS AND `idMatch` = :ID_MATCH";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':CHOIX_TERRAIN', $choixTerrain, PDO::PARAM_INT);
    $ps->bindParam(':DATE_MATCH', $dateMatch, PDO::PARAM_STR);
    $ps->bindParam(':HEURE_MATCH', $heureMatch, PDO::PARAM_STR);
    $ps->bindParam(':ID_TOURNOIS', $idTournois, PDO::PARAM_INT);
    $ps->bindParam(':ID_MATCH', $idMatch, PDO::PARAM_INT);
    $ps->bindParam(':VAINQUEUR', $vainqueur, PDO::PARAM_INT);

    $answer = $ps->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}


/**
 * Retourne le dernier id des matches
 * @return array
 */
function recupIdMatch($joueur1, $joueur2, $idTour)
{
  static $ps = null;
  $sql = 'SELECT idMatch FROM tennis_tpi.matches';
  $sql .= ' WHERE idJoueur1 = :JOUEUR1 AND idJoueur2 = :JOUEUR2 AND idTour = :ID_TOUR';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':JOUEUR1', $joueur1, PDO::PARAM_INT);
    $ps->bindParam(':JOUEUR2', $joueur2, PDO::PARAM_INT);
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
 * Récupère les joueurs et le gangant du tour qui est en paramètre
 *
 * @param int $idTournois
 * @param int $idTour
 * @return array
 */
function recupVainqueur($idTournois, $idTour)
{
  if ($idTour == null)
    $idTour = 2;
  static $ps = null;
  $sql = 'SELECT vainqueur FROM tennis_tpi.matches';
  $sql .= ' WHERE idTournois = :ID_TOURNOIS AND idTour = :ID_TOUR ORDER BY idMatch ASC';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':ID_TOURNOIS', $idTournois, PDO::PARAM_INT);
    $ps->bindParam(':ID_TOUR', $idTour, PDO::PARAM_INT);

    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}


/**
 * Insert les id des joueurs ainsi que du tournois et du tour dans un match
 *
 * @param int $joueur1
 * @param int $joueur2
 * @param int $idTournois
 * @param int $idTour
 * @return array
 */
function insertJoueurMatch($joueur1, $joueur2, $idTournois, $idTour)
{
  static $ps = null;
  $sql = "INSERT INTO `tennis_tpi`.`matches` (`idJoueur1`, `idJoueur2`, `idTournois`, `idTour`) ";
  $sql .= "VALUES (:JOUEUR1, :JOUEUR2, :ID_TOURNOIS, :ID_TOUR)";
  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':JOUEUR1', $joueur1, PDO::PARAM_INT);
    $ps->bindParam(':JOUEUR2', $joueur2, PDO::PARAM_INT);
    $ps->bindParam(':ID_TOURNOIS', $idTournois, PDO::PARAM_INT);
    $ps->bindParam(':ID_TOUR', $idTour, PDO::PARAM_INT);

    $answer = $ps->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}


/**
 * Effectue un select pour voir s'il y a des éléments dans la table en fonction des id des joueurs, du tournois et du tour
 *
 * @param int $joueur1
 * @param int $joueur2
 * @param int $idTournois
 * @param int $idTour
 * @return array
 */
function verifMatchNotNull($joueur1, $joueur2, $idTournois, $idTour)
{
  static $ps = null;
  $sql = 'SELECT idJoueur1, idJoueur2, idTour FROM tennis_tpi.matches';
  $sql .= ' WHERE idJoueur1 = :JOUEUR1 AND idJoueur2 = :JOUEUR2 AND idTournois = :ID_TOURNOIS AND idTour = :ID_TOUR';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':JOUEUR1', $joueur1, PDO::PARAM_INT);
    $ps->bindParam(':JOUEUR2', $joueur2, PDO::PARAM_INT);
    $ps->bindParam(':ID_TOURNOIS', $idTournois, PDO::PARAM_INT);
    $ps->bindParam(':ID_TOUR', $idTour, PDO::PARAM_INT);

    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}


function recupPlayerById($joueur)
{
  static $ps = null;
  $sql = 'SELECT * FROM tennis_tpi.joueurs';
  $sql .= ' WHERE idJoueur = :JOUEUR';

  if ($ps == null) {
    $ps = tennis_database()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':JOUEUR', $joueur, PDO::PARAM_INT);

    if ($ps->execute())
      $answer = $ps->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}


/**
 * Rentre les joueurs dans le prochain tour
 *
 * @param array $vainqueurs
 * @return array
 */
function prochainTour($vainqueurs)
{
  $tableauProchainTour = [];
  for ($i = 0; $i < count($vainqueurs); $i += 2) {
    $joueur1 = recupPlayerById($vainqueurs[$i]['vainqueur']);
    $joueur2 = recupPlayerById($vainqueurs[$i + 1]['vainqueur']);
    array_push($tableauProchainTour, array($joueur1, $joueur2));
  }
  return $tableauProchainTour;
}


/**
 * Effectue graphiquement les quarts
 *
 * @param array $tableauQuart
 * @param int $idTour
 * @param array $terrains
 * @param array $tournois
 * @param array $categorie
 * @param int $modal
 * @return void
 */
function quart($tableauQuart, $idTour, $terrains, $tournois, $categorie, $modal)
{
  if ($tableauQuart == null || count($tableauQuart) != 4 || $tableauQuart['3']['1'] == null) {
    echo '
    <li class="spacer">&nbsp;</li>

                <li class="game game-top winner"> <span></span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom "> <span></span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner"> <span></span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom "> <span></span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top "> <span></span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom winner"> <span></span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top "> <span></span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom winner"> <span></span></li>

                <li class="spacer">&nbsp;</li>
    ';
  } else {
    foreach ($tableauQuart as $matchQuart) {
      if (empty(verifMatchNotNull(intval($matchQuart['0']['idJoueur']), intval($matchQuart['1']['idJoueur']), $tournois['idTournois'], $idTour))) {
        insertJoueurMatch($matchQuart['0']['idJoueur'], $matchQuart['1']['idJoueur'], $tournois['idTournois'], $idTour);
      }

      $idMatch = recupIdMatch($matchQuart['0']['idJoueur'], $matchQuart['1']['idJoueur'], $idTour);
      echo
      '<a data-target=#myModal' . $modal . ' data-toggle=modal href=#>' .
        '<li class="game game-top winner">' . $matchQuart['0']['nom'] . ' <span>79</span></li>' .
        '<li class="game game-spacer">&nbsp;</li>' .
        '<li class="game game-bottom">' . $matchQuart['1']['nom'] . '<span>48</span></li>' .
        '</a>' .
        '<li class=spacer>&nbsp;</li>' .
        '<div class="modal fade" id="myModal' . $modal . '" role="dialog">' .
        '<div class="modal-dialog">' .
        '<div class="modal-content">' .
        '<div class="modal-header">' .
        '<h4 class="modal-title">' . $matchQuart['0']['prenom'] . ' ' . $matchQuart['0']['nom'] . ' vs ' . $matchQuart['1']['prenom'] . ' ' . $matchQuart['1']['nom'] . '</h4>' .
        '<button type="button" class="close" data-dismiss="modal">&times;</button>' .
        '</div>' .
        '<form action method="POST">' .
        '<div class="modal-body">' .
        '<input  type="text" name="joueur1" style="visibility:hidden" value="' . $matchQuart['0']['idJoueur'] . '">' .
        '<input  type="text" name="joueur2" style="visibility:hidden" value="' . $matchQuart['1']['idJoueur'] . '">' .
        '<input  type="text" name="idMatch" style="visibility:hidden" value="' . $idMatch['idMatch'] . '">' .
        '<div class="form-group">' .
        '<label for="exampleSelect1">Choix Terrain</label>' .
        '<select class="form-control" name="terrains">';
      foreach ($terrains as $unTerrain) {
        echo "<option value=" . $unTerrain['idTerrain'] . ">" . $unTerrain['nom'] . " - " . $unTerrain['lieu'] . "</option>";
      }
      echo '</select>' .
        '</div>' .
        '<div class="form-group">' .
        '<label for="formGroupExampleInput2">Date du match</label>' .
        '<input class="form-control" type="date" name="dateMatch" required " >' .
        '</div>' .
        '<div class"form-group">' .
        '<label for="formGroupExampleInput2">Heure du match</label>' .
        '<input class="form-control" type="time" name="heureMatch" required>' .
        '</div>';
      if ($categorie['nbSets'] == 2) {
        if ($categorie['jeuDecisif']) {
          echo '<div class"form-group">' .
            '<label for="formGroupExampleInput2">1er set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">2e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">3e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>';
        } else {
          echo '<div class"form-group">' .
            '<label for="formGroupExampleInput2">1er set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">2e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">3e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>';
        }
      } else {
        if ($categorie['jeuDecisif']) {
          echo '<div class"form-group">' .
            '<label for="formGroupExampleInput2">1er set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">2e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">3e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">4e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">5e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>';
        } else {
          echo '<div class"form-group">' .
            '<label for="formGroupExampleInput2">1er set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">2e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">3e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">4e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">5e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>';
        }
      }
      echo '</div>' .
        '<div class="modal-footer">' .
        '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' .
        '<input class="btn btn-primary" type="submit" name="ajouter" value="Ajouter">' .
        '</form>' .
        '</div>' .
        '</div>' .

        '</div>' .
        '</div>';
      $modal++;
    }
  }
}





/**
 * Effectue graphiquement les demis
 *
 * @param array $tableauDemi
 * @param int $idTour
 * @param array $terrains
 * @param array $tournois
 * @param array $categorie
 * @param int $modal
 * @return void
 */
function demi($tableauDemi, $idTour, $terrains, $tournois, $categorie, $modal)
{
  if ($tableauDemi == null || count($tableauDemi) != 2 || $tableauDemi['1']['1'] == null) {
    echo '
      <li class="spacer">&nbsp;</li>
  
                  <li class="game game-top winner"> <span></span></li>
                  <li class="game game-spacer">&nbsp;</li>
                  <li class="game game-bottom "> <span></span></li>
  
                  <li class="spacer">&nbsp;</li>
  
                  <li class="game game-top winner"> <span></span></li>
                  <li class="game game-spacer">&nbsp;</li>
                  <li class="game game-bottom "> <span></span></li>
  
                  <li class="spacer">&nbsp;</li>
  
                  <li class="game game-top "> <span></span></li>
                  <li class="game game-spacer">&nbsp;</li>
                  <li class="game game-bottom winner"> <span></span></li>
  
                  <li class="spacer">&nbsp;</li>
  
                  <li class="game game-top "> <span></span></li>
                  <li class="game game-spacer">&nbsp;</li>
                  <li class="game game-bottom winner"> <span></span></li>
  
                  <li class="spacer">&nbsp;</li>
      ';
  } else {
    foreach ($tableauDemi as $matchDemi) {
      if (empty(verifMatchNotNull(intval($matchDemi['0']['idJoueur']), intval($matchDemi['1']['idJoueur']), $tournois['idTournois'], $idTour))) {
        insertJoueurMatch($matchDemi['0']['idJoueur'], $matchDemi['1']['idJoueur'], $tournois['idTournois'], $idTour);
      }

      $idMatch = recupIdMatch($matchDemi['0']['idJoueur'], $matchDemi['1']['idJoueur'], $idTour);
      echo
      '<a data-target=#myModal' . $modal . ' data-toggle=modal href=#>' .
        '<li class="game game-top winner">' . $matchDemi['0']['nom'] . ' <span>79</span></li>' .
        '<li class="game game-spacer">&nbsp;</li>' .
        '<li class="game game-bottom">' . $matchDemi['1']['nom'] . '<span>48</span></li>' .
        '</a>' .
        '<li class=spacer>&nbsp;</li>' .
        '<div class="modal fade" id="myModal' . $modal . '" role="dialog">' .
        '<div class="modal-dialog">' .
        '<div class="modal-content">' .
        '<div class="modal-header">' .
        '<h4 class="modal-title">' . $matchDemi['0']['prenom'] . ' ' . $matchDemi['0']['nom'] . ' vs ' . $matchDemi['1']['prenom'] . ' ' . $matchDemi['1']['nom'] . '</h4>' .
        '<button type="button" class="close" data-dismiss="modal">&times;</button>' .
        '</div>' .
        '<form action method="POST">' .
        '<div class="modal-body">' .
        '<input  type="text" name="joueur1" style="visibility:hidden" value="' . $matchDemi['0']['idJoueur'] . '">' .
        '<input  type="text" name="joueur2" style="visibility:hidden" value="' . $matchDemi['1']['idJoueur'] . '">' .
        '<input  type="text" name="idMatch" style="visibility:hidden" value="' . $idMatch['idMatch'] . '">' .
        '<div class="form-group">' .
        '<label for="exampleSelect1">Choix Terrain</label>' .
        '<select class="form-control" name="terrains">';
      foreach ($terrains as $unTerrain) {
        echo "<option value=" . $unTerrain['idTerrain'] . ">" . $unTerrain['nom'] . " - " . $unTerrain['lieu'] . "</option>";
      }
      echo '</select>' .
        '</div>' .
        '<div class="form-group">' .
        '<label for="formGroupExampleInput2">Date du match</label>' .
        '<input class="form-control" type="date" name="dateMatch" required " >' .
        '</div>' .
        '<div class"form-group">' .
        '<label for="formGroupExampleInput2">Heure du match</label>' .
        '<input class="form-control" type="time" name="heureMatch" required>' .
        '</div>';
      if ($categorie['nbSets'] == 2) {
        if ($categorie['jeuDecisif']) {
          echo '<div class"form-group">' .
            '<label for="formGroupExampleInput2">1er set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">2e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">3e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>';
        } else {
          echo '<div class"form-group">' .
            '<label for="formGroupExampleInput2">1er set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">2e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">3e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>';
        }
      } else {
        if ($categorie['jeuDecisif']) {
          echo '<div class"form-group">' .
            '<label for="formGroupExampleInput2">1er set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">2e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">3e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">4e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">5e set</label>' .
            '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>';
        } else {
          echo '<div class"form-group">' .
            '<label for="formGroupExampleInput2">1er set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">2e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">3e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">4e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>' .
            '<div class"form-group">' .
            '<label for="formGroupExampleInput2">5e set</label>' .
            '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
            '</div>';
        }
      }
      echo '</div>' .
        '<div class="modal-footer">' .
        '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' .
        '<input class="btn btn-primary" type="submit" name="ajouter" value="Ajouter">' .
        '</form>' .
        '</div>' .
        '</div>' .

        '</div>' .
        '</div>';
      $modal++;
    }
  }
}


/**
 * Effectue graphiquement la final
 *
 * @param array $tableauFinal
 * @param int $idTour
 * @param array $terrains
 * @param array $tournois
 * @param array $categorie
 * @param int $modal
 * @return void
 */
function finale($tableauFinal, $idTour, $terrains, $tournois, $categorie, $modal)
{
  foreach ($tableauFinal as $matchFinal) {
    if (empty(verifMatchNotNull(intval($matchFinal['0']['idJoueur']), intval($matchFinal['1']['idJoueur']), $tournois['idTournois'], $idTour))) {
      insertJoueurMatch($matchFinal['0']['idJoueur'], $matchFinal['1']['idJoueur'], $tournois['idTournois'], $idTour);
    }

    $idMatch = recupIdMatch($matchFinal['0']['idJoueur'], $matchFinal['1']['idJoueur'], $idTour);
    echo
    '<a data-target=#myModal' . $modal . ' data-toggle=modal href=#>' .
      '<li class="game game-top winner">' . $matchFinal['0']['nom'] . ' <span>79</span></li>' .
      '<li class="game game-spacer">&nbsp;</li>' .
      '<li class="game game-bottom">' . $matchFinal['1']['nom'] . '<span>48</span></li>' .
      '</a>' .
      '<li class=spacer>&nbsp;</li>' .
      '<div class="modal fade" id="myModal' . $modal . '" role="dialog">' .
      '<div class="modal-dialog">' .
      '<div class="modal-content">' .
      '<div class="modal-header">' .
      '<h4 class="modal-title">' . $matchFinal['0']['prenom'] . ' ' . $matchFinal['0']['nom'] . ' vs ' . $matchFinal['1']['prenom'] . ' ' . $matchFinal['1']['nom'] . '</h4>' .
      '<button type="button" class="close" data-dismiss="modal">&times;</button>' .
      '</div>' .
      '<form action method="POST">' .
      '<div class="modal-body">' .
      '<input  type="text" name="joueur1" style="visibility:hidden" value="' . $matchFinal['0']['idJoueur'] . '">' .
      '<input  type="text" name="joueur2" style="visibility:hidden" value="' . $matchFinal['1']['idJoueur'] . '">' .
      '<input  type="text" name="idMatch" style="visibility:hidden" value="' . $idMatch['idMatch'] . '">' .
      '<div class="form-group">' .
      '<label for="exampleSelect1">Choix Terrain</label>' .
      '<select class="form-control" name="terrains">';
    foreach ($terrains as $unTerrain) {
      echo "<option value=" . $unTerrain['idTerrain'] . ">" . $unTerrain['nom'] . " - " . $unTerrain['lieu'] . "</option>";
    }
    echo '</select>' .
      '</div>' .
      '<div class="form-group">' .
      '<label for="formGroupExampleInput2">Date du match</label>' .
      '<input class="form-control" type="date" name="dateMatch" required " >' .
      '</div>' .
      '<div class"form-group">' .
      '<label for="formGroupExampleInput2">Heure du match</label>' .
      '<input class="form-control" type="time" name="heureMatch" required>' .
      '</div>';
    if ($categorie['nbSets'] == 2) {
      if ($categorie['jeuDecisif']) {
        echo '<div class"form-group">' .
          '<label for="formGroupExampleInput2">1er set</label>' .
          '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">2e set</label>' .
          '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">3e set</label>' .
          '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>';
      } else {
        echo '<div class"form-group">' .
          '<label for="formGroupExampleInput2">1er set</label>' .
          '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">2e set</label>' .
          '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">3e set</label>' .
          '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>';
      }
    } else {
      if ($categorie['jeuDecisif']) {
        echo '<div class"form-group">' .
          '<label for="formGroupExampleInput2">1er set</label>' .
          '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">2e set</label>' .
          '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">3e set</label>' .
          '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">4e set</label>' .
          '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">5e set</label>' .
          '<input  type="number" name="score1" required min="0" max="7"><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>';
      } else {
        echo '<div class"form-group">' .
          '<label for="formGroupExampleInput2">1er set</label>' .
          '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">2e set</label>' .
          '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">3e set</label>' .
          '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">4e set</label>' .
          '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>' .
          '<div class"form-group">' .
          '<label for="formGroupExampleInput2">5e set</label>' .
          '<input  type="number" name="score1" required min="0" ><span> - </span><input  type="number" name="score2" min="0" max="7" required>' .
          '</div>';
      }
    }
    echo '</div>' .
      '<div class="modal-footer">' .
      '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' .
      '<input class="btn btn-primary" type="submit" name="ajouter" value="Ajouter">' .
      '</form>' .
      '</div>' .
      '</div>' .

      '</div>' .
      '</div>';
    $modal++;
  }
}
