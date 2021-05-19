<?php
require_once "asset/php/inc.all.php";

//creation de la seesion
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['quart'] = null;
    $_SESSION['demi'] = null;
    $_SESSION['final'] = null;
}


// creation des variables
$cheminIndex = "index.php";
$joueurs = getPlayer();
$idTournois = "";
$tournois = "";
$categorie = "";
$joueursPair = "";
$joueursImpair = "";
$tours = "";
$terrains = "";
$choixTerrain = "";
$dateMatch = "";
$heureMatch = "";
$score1 = "";
$score2 = "";


//filtage des données
$idTournois = filter_input(INPUT_GET, 'idTournois', FILTER_VALIDATE_INT);

// Instanciation des variables en utilisant des variables de session
$joueursPairHomme = $_SESSION['joueursPairHomme'];
$joueursImpairHomme = $_SESSION['joueursImpairHomme'];
$joueusesPairFemme = $_SESSION['joueusesPairFemme'];
$joueusesImpairFemme = $_SESSION['joueusesImpairFemme'];
$_SESSION['modal'] = 1;
$modal = $_SESSION['modal'];

//utilisation de méthode
trieJoueur($joueurs);




$tournois = recupTournoisInfoById($idTournois);
$categorie = recupCategorieInfoById($tournois['idCategorie']);
if ($categorie['genre'] == 1) {
    organisationMatch($joueursPairHomme, $joueursImpairHomme, intval($categorie['nbParticipants']));
} else {
    organisationMatch($joueusesPairFemme, $joueusesImpairFemme, intval($categorie['nbParticipants']));
}

$terrains = getTerrain();


//instanciation des variables, necessitant des varibles de session, après l'utilisation de méthode 
$joueursPair = $_SESSION['tableauPair'];
$joueursImpair = $_SESSION['tableauImpair'];



//vérifie que le bouton est set
if (isset($_POST['ajouter'])) {
    //filtrage des données
    $choixTerrain = filter_input(INPUT_POST, 'terrains', FILTER_SANITIZE_STRING);
    $dateMatch = filter_input(INPUT_POST, 'dateMatch', FILTER_SANITIZE_STRING);
    $heureMatch = filter_input(INPUT_POST, 'heureMatch', FILTER_SANITIZE_STRING);
    $idMatch = filter_input(INPUT_POST, 'idMatch', FILTER_VALIDATE_INT);
    $joueur1 = filter_input(INPUT_POST, 'joueur1', FILTER_VALIDATE_INT);
    $joueur2 = filter_input(INPUT_POST, 'joueur2', FILTER_VALIDATE_INT);
    insertMatch(intval($choixTerrain), $dateMatch, $heureMatch, intval($tournois['idTournois']), intval($idMatch), intval($joueur1));
    
}
$vainqueurs = [];

//Récupère les vainqueurs en fonction de l'id du tournoi et de l'id du tour
$vainqueurs = recupVainqueur(intval($tournois['idTournois']), $_SESSION['idTour']);

// Vérifie que la dernière valeur du tableau est pas null et que le tableau est pas vide
if ($vainqueurs[count($vainqueurs) - 1]['vainqueur'] != null && $vainqueurs != array()) {
    $prochainTour = prochainTour($vainqueurs);

    if (count($prochainTour) == 4) {
        $prochainTour = prochainTour($vainqueurs);
        $tableauQuart = $prochainTour;
        $_SESSION['quart'] = $tableauQuart;
        $idTourSuite = 3;
        $_SESSION['idTour'] = $idTourSuite;
    } else if (count($prochainTour) == 2) {

        $prochainTour = prochainTour($vainqueurs);

        $tableauDemi = $prochainTour;
        $_SESSION['demi'] = $tableauDemi;
        $idTourSuite = 4;
        $_SESSION['idTour'] = $idTourSuite;
    } else if (count($prochainTour) == 1) {

        $prochainTour = prochainTour($vainqueurs);

        $tableauFinal = $prochainTour;
        $_SESSION['final'] = $tableauFinal;
        $idTourSuite = 5;
        $_SESSION['idTour'] = $idTourSuite;
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tournament Management</title>
    <!-- Favicon-->
    <link rel="icon" href="asset/image/logo.png" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="asset/css/styles.css" rel="stylesheet" />
    <link href="asset/css/tournois.css" rel="stylesheet" />

</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= $cheminIndex ?>">Tennis</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#!">
                            Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Page content-->
    <div class="container">
        <h1>2013 NCAA Tournament - Midwest Bracket</h1>
        <main id="tournament">
            <ul class="round round-1">
                <?php
                foreach ($joueursImpair as $joueur) {
                    if (empty(verifMatchNotNull(intval($joueur['0']['idJoueur']), intval($joueur['1']['idJoueur']), $tournois['idTournois'], $idTour = 2))) {
                        insertJoueurMatch($joueur['0']['idJoueur'], $joueur['1']['idJoueur'], $tournois['idTournois'], $idTour = 2);
                    }

                    $idMatch = recupIdMatch($joueur['0']['idJoueur'], $joueur['1']['idJoueur'], $idTour = 2);
                    echo
                    '<a data-target=#myModal' . $modal . ' data-toggle=modal href=#>' .
                        '<li class="game game-top winner">' . $joueur['0']['nom'] . ' <span>79</span></li>' .
                        '<li class="game game-spacer">&nbsp;</li>' .
                        '<li class="game game-bottom">' . $joueur['1']['nom'] . '<span>48</span></li>' .
                        '</a>' .
                        '<li class=spacer>&nbsp;</li>' .
                        '<div class="modal fade" id="myModal' . $modal . '" role="dialog">' .
                        '<div class="modal-dialog">' .
                        '<div class="modal-content">' .
                        '<div class="modal-header">' .
                        '<h4 class="modal-title">' . $joueur['0']['prenom'] . ' ' . $joueur['0']['nom'] . ' vs ' . $joueur['1']['prenom'] . ' ' . $joueur['1']['nom'] . '</h4>' .
                        '<button type="button" class="close" data-dismiss="modal">&times;</button>' .
                        '</div>' .
                        '<form action method="POST">' .
                        '<div class="modal-body">' .
                        '<input  type="text" name="joueur1" style="visibility:hidden" value="' . $joueur['0']['idJoueur'] . '">' .
                        '<input  type="text" name="joueur2" style="visibility:hidden" value="' . $joueur['1']['idJoueur'] . '">' .
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
                foreach ($joueursPair as $joueur) {
                    if (empty(verifMatchNotNull(intval($joueur['0']['idJoueur']), intval($joueur['1']['idJoueur']), $tournois['idTournois'], $idTour))) {
                        insertJoueurMatch($joueur['0']['idJoueur'], $joueur['1']['idJoueur'], $tournois['idTournois'], $idTour = 2);
                    }

                    $idMatch = recupIdMatch($joueur['0']['idJoueur'], $joueur['1']['idJoueur'], $idTour = 2);
                    echo
                    '<a data-target=#myModal' . $modal . ' data-toggle=modal href=#>' .
                        '<li class="game game-top winner">' . $joueur['0']['nom'] . ' <span>79</span></li>' .
                        '<li class="game game-spacer">&nbsp;</li>' .
                        '<li class="game game-bottom">' . $joueur['1']['nom'] . '<span>48</span></li>' .
                        '</a>' .
                        '<li class=spacer>&nbsp;</li>' .
                        '<div class="modal fade" id="myModal' . $modal . '" role="dialog">' .
                        '<div class="modal-dialog">' .
                        '<div class="modal-content">' .
                        '<div class="modal-header">' .
                        '<h4 class="modal-title">' . $joueur['0']['prenom'] . ' ' . $joueur['0']['nom'] . ' vs ' . $joueur['1']['prenom'] . ' ' . $joueur['1']['nom'] . '</h4>' .
                        '<button type="button" class="close" data-dismiss="modal">&times;</button>' .
                        '</div>' .
                        '<div class="modal-body">' .
                        '<form action method="POST">' .
                        '<input  type="text" name="joueur1" style="visibility:hidden" value="' . $joueur['0']['idJoueur'] . '">' .
                        '<input  type="text" name="joueur2" style="visibility:hidden" value="' . $joueur['1']['idJoueur'] . '">' .
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
                        '<input class="form-control" type="date" name="dateMatch" required min="' . $tournois['dateDebut'] . '" max="' . $tournois['dateFin'] . '" >' .
                        '</div>' .
                        '<div class"form-group">' .
                        '<label for="formGroupExampleInput2">Heure du match</label>' .
                        '<input class="form-control" type="time" name="heureMatch" required>' .
                        '</div>';
                    if ($categorie['nbSets'] == 2) {
                        if ($categorie['jeuDecisif']) {
                            echo '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">1er set</label>' .
                                '<input  type="number" name="premierSetGauche" required min="0" max="7"><span> - </span><input  type="number" name="premierSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">2e set</label>' .
                                '<input  type="number" name="deuxiemeSetGauche" required min="0" max="7"><span> - </span><input  type="number" name="deuxiemeSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">3e set</label>' .
                                '<input  type="number" name="troisiemeSetGauche" required min="0" max="7"><span> - </span><input  type="number" name="troisiemeSetDroite" min="0" max="7" required>' .
                                '</div>';
                        } else {
                            echo '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">1er set</label>' .
                                '<input  type="number" name="premierSetGauche" required min="0" ><span> - </span><input  type="number" name="premierSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">2e set</label>' .
                                '<input  type="number" name="deuxiemeSetGauche" required min="0" ><span> - </span><input  type="number" name="deuxiemeSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">3e set</label>' .
                                '<input  type="number" name="troisiemeSetGauche" required min="0" ><span> - </span><input  type="number" name="troisiemeSetDroite" min="0" max="7" required>' .
                                '</div>';
                        }
                    } else {
                        if ($categorie['jeuDecisif']) {
                            echo '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">1er set</label>' .
                                '<input  type="number" name="premierSetGauche" required min="0" max="7"><span> - </span><input  type="number" name="premierSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">2e set</label>' .
                                '<input  type="number" name="deuxiemeSetGauche" required min="0" max="7"><span> - </span><input  type="number" name="deuxiemeSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">3e set</label>' .
                                '<input  type="number" name="troisiemeSetGauche" required min="0" max="7"><span> - </span><input  type="number" name="troisiemeSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">4e set</label>' .
                                '<input  type="number" name="quatriemeSetGauche" required min="0" max="7"><span> - </span><input  type="number" name="quatriemeSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">5e set</label>' .
                                '<input  type="number" name="cinquiemeSetGauche" required min="0" max="7"><span> - </span><input  type="number" name="cinquiemeSetDroite" min="0" max="7" required>' .
                                '</div>';
                        } else {
                            echo '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">1er set</label>' .
                                '<input  type="number" name="premierSetGauche" required min="0" ><span> - </span><input  type="number" name="premierSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">2e set</label>' .
                                '<input  type="number" name="deuxiemeSetGauche" required min="0" ><span> - </span><input  type="number" name="deuxiemeSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">3e set</label>' .
                                '<input  type="number" name="troisiemeSetGauche" required min="0" ><span> - </span><input  type="number" name="troisiemeSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">4e set</label>' .
                                '<input  type="number" name="quatriemeSetGauche" required min="0" ><span> - </span><input  type="number" name="quatriemeSetDroite" min="0" max="7" required>' .
                                '</div>' .
                                '<div class"form-group">' .
                                '<label for="formGroupExampleInput2">5e set</label>' .
                                '<input  type="number" name="cinquiemeSetGauche" required min="0" ><span> - </span><input  type="number" name="cinquiemeSetDroite" min="0" max="7" required>' .
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
                ?>

            </ul>
            <ul class="round round-2">
                <?php
                    quart($_SESSION['quart'], $_SESSION['idTour'], $terrains, $tournois, $categorie, $modal);
                ?>

            </ul>
            <ul class="round round-3">
                <?php
                    demi($_SESSION['demi'], $_SESSION['idTour'], $terrains, $tournois, $categorie, $modal);
                ?>
            </ul>
            <ul class="round round-4">
            <?php
                finale($_SESSION['final'], $_SESSION['idTour'], $terrains, $tournois, $categorie, $modal);
            ?>
            </ul>
        </main>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Header</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Footer-->

    <!-- Bootstrap core JS-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="asset/js/scripts.js"></script>
</body>

</html>
<?php
?>