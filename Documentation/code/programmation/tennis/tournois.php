<?php
require_once "asset/php/inc.all.php";

$idTournois = filter_input(INPUT_GET, 'idTournois', FILTER_VALIDATE_INT);
$joueurs = getPlayer();
trieJoueur($joueurs);
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
        <h1>2013 NCAA Tournament - Midwest Bracket</h1>
        <main id="tournament">
            <ul class="round round-1">
                <li class="spacer">&nbsp;</li>
                <a data-target="#myModal" data-toggle="modal" href="#">
                    <li class="game game-top winner">Lousville <span>79</span></li>
                    <li class="game game-spacer">&nbsp;</li>
                    <li class="game game-bottom ">NC A&T <span>48</span></li>
                </a>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner">Colo St <span>84</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom ">Missouri <span>72</span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top ">Oklahoma St <span>55</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom winner">Oregon <span>68</span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner">Saint Louis <span>64</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom ">New Mexico St <span>44</span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner">Memphis <span>54</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom ">St Mary's <span>52</span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner">Mich St <span>65</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom ">Valparaiso <span>54</span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner">Creighton <span>67</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom ">Cincinnati <span>63</span></li>

                <li class="spacer">&nbsp;</li>

                <li class="game game-top winner">Duke <span>73</span></li>
                <li class="game game-spacer">&nbsp;</li>
                <li class="game game-bottom ">Albany <span>61</span></li>

                <li class="spacer">&nbsp;</li>
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
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
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

</html>