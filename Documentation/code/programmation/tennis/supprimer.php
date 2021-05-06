<?php
require_once "asset/php/inc.all.php";

$idTournois = filter_input(INPUT_GET, 'idTournois', FILTER_VALIDATE_INT);
$idCategorie = filter_input(INPUT_GET, 'idCategorie', FILTER_VALIDATE_INT);
$cheminIndex = "index.php";

deleteTournois($idTournois);
deleteCategorie($idCategorie);
redirection($cheminIndex);

?>