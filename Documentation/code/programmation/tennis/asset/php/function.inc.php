<?php
session_start();

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
  $sql = "INSERT INTO `tennis_tpi`.`categories` (`genre`, `dotation`, `idSurface`, `idType`, `jeuDecisif`, `nbSet`, `nbParticipant`) ";
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
  $sql = 'SELECT idCategorie, genre, dotation, idSurface, idType, jeuDecisif, nbSet, nbParticipant FROM tennis_tpi.categories';
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
  $sql .= "`nbSet` = :NB_SET, ";
  $sql .= "`nbParticipant` = :NB_PARTICIPANT ";
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
 * Effectue une recherche de mot du plus au moins pertinent, en utilisant un système de score
 *
 * @param [string] $word
 * @return void
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
      array_push($tableauPair, $pair);
      unset($pair);
    }

    //compte le nombre de joueurs dont le numéro de classement est
    //un chiffre impair
    for ($i = 0; $i < $longueur; $i++) {
      $impair = [];
      array_push($impair, $joueursImpair[$i], end($joueursImpair));
      unset($joueursImpair[array_key_last($joueursImpair)]);
      unset($joueursImpair[$i]);
      array_push($tableauImpair, $impair);
      unset($impair); 
    }


  } 
  else {

    //compte le nombre de joueurs dont le numéro de classement est
    //un chiffre pair
    for ($i = 0; $i < count($joueursPair); $i++) {
      $pair = [];
      array_push($pair, $joueursPair[$i], end($joueursPair));
      if (count($joueursImpair) == 16) {
      }
      unset($joueursPair[$i], $joueursPair[count($joueursPair)]);
      array_push($tableauPair, $pair);
      unset($pair);
    }

    //compte le nombre de joueurs dont le numéro de classement est
    //un chiffre impair
    for ($i = 0; $i < count($joueursImpair); $i++) {
      $impair = [];
      array_push($impair, $joueursImpair[$i], end($joueursImpair));
      unset($joueursImpair[$i], $joueursImpair[count($joueursImpair)]);
      array_push($tableauImpair, $impair);
      unset($impair);
    }
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