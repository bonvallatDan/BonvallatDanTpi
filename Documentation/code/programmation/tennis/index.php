<?php
require_once 'asset/php/inc.all.php';

// création des variables
$creer = "";
$supprimer = "";
$modifier = "";
$cheminCreer = "creation.php";
$cheminModification = "modification.php";
$infoTournois = recupTournoisInfo();

// filtrage des inputs
$creer = filter_input(INPUT_POST, 'creer', FILTER_DEFAULT);
$supprimer = filter_input(INPUT_POST, 'supprimer', FILTER_DEFAULT);
$modifier = filter_input(INPUT_POST, 'modifier', FILTER_DEFAULT);

if(isset($creer))
{
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
    <link rel="icon" type="image/x-icon" href="assets/image/" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="asset/css/styles.css" rel="stylesheet" />
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#!">Tennis</a>
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
                <div class="main">
                    <?php 
                    foreach ($infoTournois as $tournois) {
                       echo "<div class=tournois><p>".$tournois['nom']."</p><p>".$tournois['dateDebut']."</p>
                       <a class=delete name=supprimer href=supprimer.php?idTournois=".(int)$tournois["idTournois"]."&idCategorie=".(int)$tournois["idCategorie"].">Supprimer</a>
                       <a class=edit name=modifier 
                       href=modification.php?idTournois=".(int)$tournois["idTournois"]." &nom=".$tournois['nom']." &pays=".$tournois['pays']." &ville=".$tournois['ville'].
                       " &dateDebut=".$tournois['dateDebut']." &dateFin=".$tournois['dateFin']." &idCategorie=".(int)$tournois["idCategorie"].">Modifier</a>
                       </div>";
                    }
                    
                    ?>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card my-4">
                    <h5 class="card-header">Search</h5>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Search for..." />
                            <span class="input-group-append"><button class="btn btn-secondary" type="button">Go!</button></span>
                        </div>
                    </div>
                </div>
                <div class="card my-4">
                    <h5 class="card-header">Categories</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form action method="POST">
                                    <ul class="list-unstyled mb-0">
                                        <li><input class="btn btn-primary" type="submit" value="Créer" name="creer"></li>
                                    </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-unstyled mb-0">
                                </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
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

</html>