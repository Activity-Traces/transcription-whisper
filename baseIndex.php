<?php

require "Requires/session.php";

$user = $_SESSION['username'];

?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Transcription des données multimedia</title>

<link href="/transcripteur/Template/Css/bootstrap.min.css" rel="stylesheet">
<link href="/transcripteur/Template/Css/style.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">


<script src="/transcripteur/Template/JS/popper.min.js"></script>
<script src="/transcripteur/Template/JS/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>



<body style="background-color: white">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-sucess" style="background-color: #34495E;">
        <div class="col-4">
            <?php if (isset($bar) && ($bar == true)) : ?>
                <label style="color: white; font-size:12px">

                    <?php if (isset($_SESSION['transcriptionName'])) echo 'Transcription : ' . $_SESSION['transcriptionName'] . '&nbsp;/&nbsp;';


                    ?>

                    <?php if (isset($_SESSION['lastSaved'])) echo '  Dernière sauvegarde: ' . $_SESSION['lastSaved'] . '<br>';


                    ?>
                </label>

            <?php endif ?>
        </div>
        <div class="col-4"></div>
        <div class="col-4">
            <!-- Icons -->
            <div class="d-flex justify-content-end">


                <ul class="navbar-nav d-flex flex-row me-1 ms-auto">

                    <a href="/transcripteur/index.php" type="button" class="btn btn-outline-dark" title="Acceuil">
                        <i class="fa-solid fa-house" style="color: white;"></i>
                    </a>
                    &nbsp;

                    <a href="/transcripteur/Template/Utilisateurs/monProfil.php" type="button" class="btn btn-outline-dark" title="Mon profil">
                        <i class="fa-solid fa-user" style="color: white;"></i>
                    </a>
                    &nbsp;

                    <?php
                    if ($type == 'ADM') : ?>

                        <a href="/transcripteur/Template/Utilisateurs/utilisateurs.php" type="button" class="btn btn-outline-dark" title="Paramètres">
                            <i class="fa-solid fa-gear" style="color: white;"></i>
                        </a>
                    <?php endif; ?>
                    &nbsp;

                    <a href="/transcripteur/Template/Connexion/logout.php" type="button" class="btn btn-outline-dark" title="Déconnexion">
                        <i class="fa-solid fa-right-from-bracket" style="color: white;"></i>
                    </a>
                </ul>
            </div>

        </div>
        <!-- Container wrapper -->
    </nav>
    <div class="container-fluid">