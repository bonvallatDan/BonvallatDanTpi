<?php
require_once "asset/php/inc.all.php";

//creation de la seesion
session_start();

// creation des variables
$cheminIndex = "index.php";
$joueurs = getPlayer();
$idTournois = "";
$tournois = "";
$categorie = "";
$joueursPair = "";
$joueursImpair = "";

//filtage des données
$idTournois = filter_input(INPUT_GET, 'idTournois', FILTER_VALIDATE_INT);

// Instanciation des variables en utilisant des variables de session
$joueursPairHomme = $_SESSION['joueursPairHomme'];
$joueursImpairHomme = $_SESSION['joueursImpairHomme'];
$joueusesPairFemme = $_SESSION['joueusesPairFemme'];
$joueusesImpairFemme = $_SESSION['joueusesImpairFemme'];

//utilisation de méthode
trieJoueur($joueurs);
$tournois = recupTournoisInfoById($idTournois);
$categorie = recupCategorieInfoById($tournois['idCategorie']);
if ($categorie['genre'] == 1) {
    organisationMatch($joueursPairHomme, $joueursImpairHomme, intval($categorie['nbParticipant']));
} else {
    organisationMatch($joueursPairFemme, $joueursImpairFemme, intval($categorie['nbParticipant']));
}

//instanciation des variables, necessitant des varibles de session, après l'utilisation de méthode 
$joueursPair = $_SESSION['tableauPair'];
$joueursImpair = $_SESSION['tableauImpair'];
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
                    echo
                    '<a data-target=#myModal data-toggle=modal href=#>' .
                        '<li class="game game-top winner">' . $joueur['0']['nom'] . ' <span>79</span></li>' .
                        '<li class="game game-spacer">&nbsp;</li>' .
                        '<li class="game game-bottom">' . $joueur['1']['nom'] . '<span>48</span></li>' .
                        '</a>' .
                        '<script> var joueursRencontre = ' . json_encode($joueur) . '</script>' .
                        '<li class=spacer>&nbsp;</li>';
                }
                foreach ($joueursPair as $joueur) {
                    echo
                    '<a data-target=#myModal data-toggle=modal href=#>' .
                        '<li class="game game-top winner">' . $joueur['0']['nom'] . ' <span>79</span></li>' .
                        '<li class="game game-spacer">&nbsp;</li>' .
                        '<li class="game game-bottom">' . $joueur['1']['nom'] . '<span>48</span></li>' .
                        '</a>' .
                        '<li class=spacer>&nbsp;</li>';
                }
                ?>

            </ul>
            <ul class="round round-2">
                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner">Lousville <span>82</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom ">Colo St <span>56</span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner">Oregon <span>74</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom ">Saint Louis <span>57</span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top ">Memphis <span>48</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom winner">Mich St <span>70</span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top ">Creighton <span>50</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom winner">Duke <span>66</span></li>

                <li class="spacer">&nbsp;</li>
            </ul>
            <ul class="round round-3">
                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner">Lousville <span>77</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom ">Oregon <span>69</span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top ">Mich St <span>61</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom winner">Duke <span>71</span></li>

                <li class="spacer">&nbsp;</li>
            </ul>
            <ul class="round round-4">
                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner">Lousville <span>85</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom ">Duke <span>63</span></li>

                <li class="spacer">&nbsp;</li>
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
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="asset/js/scripts.js"></script>
</body>
<script src="asset/js/scripts.js"></script>

</html>