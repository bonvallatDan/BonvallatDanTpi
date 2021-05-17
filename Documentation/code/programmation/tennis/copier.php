<?php
require_once 'asset/php/inc.all.php';

//Création des variables
$cheminIndex = "index.php";
$idCategorie = "";

//filtrage des inputs
$idTournois = filter_input(INPUT_GET, 'idTournois', FILTER_VALIDATE_INT);

//Utilisation de fonction
$tournois = recupTournoisInfoById($idTournois);
$categorie = recupCategorieInfoById($tournois['idCategorie']);

insertCategorie(intval($categorie['genre']), intval($categorie['dotation']), intval($categorie['idSurface']), intval($categorie['idType']), intval($categorie['jeuDecisif']), intval($categorie['nbSets']), intval($categorie['nbParticipants']));
$idCategorie = recupIdCategorie();
insertTournois($tournois['nom'], $tournois['pays'], $tournois['ville'], $tournois['dateDebut'], $tournois['dateFin'], $tournois['idCategorie']);
redirection($cheminIndex);
?>