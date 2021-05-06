<?php
require_once "asset/php/inc.all.php";

//création des variables
$cheminIndex = "index.php";
$idTournois = "";
$nom = "";
$pays = "";
$ville = "";
$dateDebut = "";
$dateFin = "";
$idCategorie = "";

$nbJoueurs = [16, 32];
$nbSets = [2, 3];
$getSurface = getSurface();
$getTournoisType = getTournoisType();

//filtrage des inputs
$idTournois = filter_input(INPUT_GET, 'idTournois', FILTER_VALIDATE_INT);
$nom = filter_input(INPUT_GET, 'nom', FILTER_SANITIZE_STRING);
$pays = filter_input(INPUT_GET, 'pays', FILTER_SANITIZE_STRING);
$ville = filter_input(INPUT_GET, 'ville', FILTER_SANITIZE_STRING);
$dateDebut = filter_input(INPUT_GET, 'dateDebut', FILTER_SANITIZE_STRING);
$dateFin = filter_input(INPUT_GET, 'dateFin', FILTER_SANITIZE_STRING);
$idCategorie = filter_input(INPUT_GET, 'idCategorie', FILTER_VALIDATE_INT);

$categorie = recupCategorieInfoById($idCategorie);


if (isset($_POST['modification'])) {

    //filtrage des inputs
    $nomTournois = filter_input(INPUT_POST, 'nomTournois', FILTER_SANITIZE_STRING);
    $nomPays = filter_input(INPUT_POST, 'nomPays', FILTER_SANITIZE_STRING);
    $nomVille = filter_input(INPUT_POST, 'nomVille', FILTER_SANITIZE_STRING);
    $dateDebut = filter_input(INPUT_POST, 'dateDebut', FILTER_SANITIZE_STRING);
    $dateFin = filter_input(INPUT_POST, 'dateFin', FILTER_SANITIZE_STRING);
    $genre = filter_input(INPUT_POST, 'genreTournois', FILTER_SANITIZE_STRING);
    $dotation = filter_input(INPUT_POST, 'dotation', FILTER_VALIDATE_INT);
    $nbJoueursFiltre = filter_input(INPUT_POST, 'nbJoueurs', FILTER_SANITIZE_STRING);
    $nbSetsFiltre = filter_input(INPUT_POST, 'nbSets', FILTER_SANITIZE_STRING);
    $jeuDecisif = filter_input(INPUT_POST, 'jeuDecisif', FILTER_SANITIZE_STRING);
    if ($jeuDecisif != 1)
    {
        $jeuDecisif = 0;
    }
    $surface = filter_input(INPUT_POST, 'surface', FILTER_SANITIZE_STRING);
    $typeTournois = filter_input(INPUT_POST, 'typeTournois', FILTER_SANITIZE_STRING);

    $idCategorie = recupIdCategorie();
    updateCategorie($genre, $dotation, $surface, $typeTournois, $jeuDecisif, $nbSetsFiltre, $nbJoueursFiltre, $idCategorie['idCategorie']);
    updateTournois($nomTournois, $nomPays, $nomVille, $dateDebut, $dateFin, $idCategorie['idCategorie'], $idTournois);
    redirection($cheminIndex);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>tennis tournament creator</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/image/" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="asset/css/styles.css" rel="stylesheet" />

</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#!">Tennis</a>
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

        <div class="row">
            <div class="col-lg-8">
                <h1 class="mt-4">Tournois</h1>
                <div class="mainCreate">
                    <form action method="POST">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Nom du tournois</label>
                            <input type="text" class="form-control" name="nomTournois" placeholder="Geneva Open" value="<?= $nom ?>" required >
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Pays</label>
                            <input type="text" class="form-control" name="nomPays" placeholder="Suisse" value=<?= $pays ?> required>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Ville</label>
                            <input type="text" class="form-control" name="nomVille" placeholder="Genève" value=<?= $ville ?> required>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Date de debut</label>
                            <input class="form-control" type="date" name="dateDebut" value=<?= $dateDebut?>>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Date de fin</label>
                            <input class="form-control" type="date" name="dateFin" value=<?= $dateFin?>>
                        </div>
                        <fieldset class="form-group ">
                            <legend class="col-form-legend col-sm-2">Genre</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="genreTournois" value="1" <?= $categorie['genre'] == '1' ? "checked" : "" ?>>
                                        Homme
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="genreTournois" value="0" <?= $categorie['genre'] == '0' ? "checked" : "" ?> required>
                                        Femme
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Dotation</label>
                            <input class="form-control" type="dotation" value=<?= $categorie['dotation']?> name="dotation">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Nombre de joueurs</label>
                            <select class="form-control" name="nbJoueurs">
                                <?php 
                                foreach ($nbJoueurs as $joueurs) {
                                    echo "<option value='$joueurs'". ($categorie['nbParticipant'] == $joueurs ? "selected=''" : " ") .">$joueurs</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Nombre de sets gagnants</label>
                            <select class="form-control" name="nbSets">
                            <?php 
                                foreach ($nbSets as $sets) {
                                    echo "<option value='$sets'". (intval($categorie['nbSet']) == $sets ? "selected=''" : " ") .">$sets</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Type de terrains</label>
                            <select class="form-control" name="surface">
                                <?php
                                foreach ($getSurface as $surface) {
                                    echo "<option value='" . $surface['idSurface'] . "'". ($categorie['idSurface'] == $surface['idSurface'] ? "selected=''" : " ") .">" . $surface["nom"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">type de tournois</label>
                            <select class="form-control" name="typeTournois">
                                <?php
                                foreach ($getTournoisType as $tournoisType) {
                                    echo "<option value='" . $tournoisType["idType"] . "'" . ($categorie['idType'] == $tournoisType['idType'] ? " selected=''" : " ") .">" . $tournoisType["nom"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="jeuDecisif" value="1" <?php echo $categorie['jeuDecisif'] == '1' ? "checked" : "" ?>>
                                Jeu décisif
                            </label>
                        </div>
                        <input class="btn btn-primary" type="submit" name="modification" value="Mofifier">
                    </form>
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

</html>