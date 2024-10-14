<?php

/*************************************************************************************************************************************************** */

include "baseIndex.php";
include "Template/Forms/ajouterTranscription.php";
require "Classes/html.php";
require "Classes/sql.php";

/*************************************************************************************************************************************************** */


$voir = new html;
$sql = new sql;
$condition = "";

$mediaFolder = "uploads/media/" .  $_SESSION['username'] . '/';
/*************************************************************************************************************************************************** */


if (isset($_GET['delete'])) { {


        $cond =  " where Id = " . $_GET['delete'];

        $res = $sql->SelectFromTable('TRANSCRIPTION', " Nom, TransExtension, AudioExtension ", $cond);
        if ($res->num_rows > 0) {
            $obj = $res->fetch_object();

            if (file_exists("uploads/media/" .  $_SESSION['username'] . '/' . $obj->Nom . '.' . $obj->AudioExtension))
                unlink("uploads/media/" .  $_SESSION['username'] . '/' . $obj->Nom . '.' . $obj->AudioExtension);
            if (file_exists("uploads/transcriptions/" .  $_SESSION['username'] . '/' . $obj->Nom . '.' . $obj->TransExtension))
                unlink("uploads/transcriptions/" .  $_SESSION['username'] . '/' . $obj->Nom . '.' . $obj->TransExtension);

            $sql->DeleteFromTable('TRANSCRIPTION', 'Id', $_GET['delete']);
            $sql->DeleteFromTable('TRANSTEXTE', 'TransId', $_GET['delete']);
            $sql->DeleteFromTable('AUTEUR', 'TransId', $_GET['delete']);

            // supprimer les fichiers de sauvegardes
            $cond =  " where TransId = " . $_GET['delete'];

            $res2 = $sql->SelectFromTable('SAUVEGARDES', " FileName ", $cond);
            if ($res2->num_rows > 0) {
                while ($obj = $res2->fetch_object()) {
                    if (file_exists("uploads/saved/" .  $_SESSION['username'] . '/' . $obj->FileName . '.srt'))
                        unlink("uploads/saved/" .  $_SESSION['username'] . '/' .  $obj->FileName . '.srt');
                }
            }
            $sql->DeleteFromTable('SAUVEGARDES', 'TransId', $_GET['delete']);
        }
    }
}
$condition = " where UserId = " . $_SESSION['userid'];
if (isset($_POST['rechercher']) && ($_POST['rechercher'] != ""))
    $condition .=  " and Nom like '%" . $_POST['rechercher'] . "%'";


$result = $sql->SelectFromTable('TRANSCRIPTION', " Id,  Nom, description, AudioExtension, CreatedAt ", $condition);





?>

<div class="container-fluid">
    <?php


    if (isset($_GET['tn']) && ($_GET['tn'] == 'true'))
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'> 
    <strong> Info: </strong>Transcription: Cette transcription existe. Merci de choisir un autre nom <button type = 'button' class = 'btn-close' data-bs-dismiss = 'alert' aria-label = 'Close'> </button> </div>";

    ?>
    <div class="alert">
        <br>

        <form method="POST">

            <div class="row">
                <div class="col-3">

                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ajouterTranscription" title="Ajouter une nouvelle transcription"><i class="fa-solid fa-plus" style="color: #7FB3D5;"></i>&ensp;Ajouter une nouvelle transcription</button>
                </div>

                <div class="col-9">
                    <div class="input-group">
                        <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                        <input type="text" name="rechercher" id="rechercher" class="form-control" placeholder="Rechercher une transcription par Nom" pattern="[a-zA-Z0-9-_. ]{1,20}">
                    </div>
                </div>


            </div>
        </form>
        <br>



        <?php

        $voir->TranscrptionTable(
            'Transformation',
            ['#', 'Nom', 'Crée le', 'Déscription', ''],
            $result,
            'VoirTransformation',
            $mediaFolder
        ); ?>


    </div>






    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel">Source Multimedia</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small">
            <video id='my-audio' src="" controls playsinline style="width: 100%; max-width: 400px;height: 100%; max-height: 400px; margin: 0 auto; display: block"></video>


        </div>
    </div>




    <script>
        var player = document.getElementById("my-audio");


        function play(music, but) {
            var button = document.getElementById(but);

            button.value = "pause";
            if (player.isplayed)
                player.stop();
            player.setAttribute('src', music);
            player.load();
            player.play();

        }

        const myOffcanvas =
            document.getElementById('offcanvasBottom')

        myOffcanvas.addEventListener('hide.bs.offcanvas', () => {
            var player1 = document.getElementById("my-audio");

            player1.load();
            player1.stop();

        })
    </script>