<?php
require_once 'asset/php/inc.all.php';

// création des variables
$cheminIndex = "index.php";
$idTournois = "";
$tournois = "";
$word = "";
$joueurs = "";
$categorie = "";


// filtrage des inputs
$idTournois = filter_input(INPUT_GET, 'idTournois', FILTER_VALIDATE_INT);
$word = filter_input(INPUT_POST, 'word', FILTER_SANITIZE_STRING);


// utilisation de méthode
$tournois = recupTournoisInfoById($idTournois);
$categorie = recupCategorieInfoById($tournois['idCategorie']);
$joueurs = getPlayerByParameter($categorie['genre'], $categorie['nbParticipants']);

if (isset($_POST['creer'])) {
    redirection($cheminCreer);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tennis tournament creator</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="asset/image/logo.png" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="asset/css/styles.css" rel="stylesheet" />
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href=<?= $cheminIndex ?>>Tennis</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">

                </ul>
            </div>
        </div>
    </nav>
    <!-- Page content-->
    <div class="container">

        <div class="row">
            <div class="col-lg-8">
                <h1 class="mt-4">Tournois</h1>
                <div class="mainTable">
                    <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Classement</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Date de naissance</th>
                            <th scope="col">Nationalité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (isset($_POST['recherche'])) {
                                $joueurs = rechercheJoueur($word, $categorie['nbParticipants'], $categorie['genre']);
                                foreach ($joueurs as $unJoueur ) {
                                    echo '<tr>
                                    <th scope="row">'.$unJoueur['classementATP'].'</th>
                                    <td>'.$unJoueur['prenom'].'</td>
                                    <td>'.$unJoueur['nom'].'</td>
                                    <td>'.$unJoueur['dateNaissance'].'</td>
                                    <td>'.$unJoueur['nationalite'].'</td>
                                  </tr>';
                                }
                                unset($_POST['recherche']);
                            }
                            else
                            {
                                foreach ($joueurs as $unJoueur ) {
                                    echo '<tr>
                                    <th scope="row">'.$unJoueur['classementATP'].'</th>
                                    <td>'.$unJoueur['prenom'].'</td>
                                    <td>'.$unJoueur['nom'].'</td>
                                    <td>'.$unJoueur['dateNaissance'].'</td>
                                    <td>'.$unJoueur['nationalite'].'</td>
                                  </tr>';
                                }
                            }
                    ?>
                    </tbody>
                    <?php
                   

                    ?>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card my-4">
                    <h5 class="card-header">Search</h5>
                    <div class="card-body">
                        <div class="input-group">
                            <form method="POST" action>
                                <div class="input-group">
                                    <div class="form-outline">
                                        <input type="search" id="form1" class="form-control" name="word" />
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="Go!" name="recherche">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
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