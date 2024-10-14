<style>
  textarea.form-control {
    color: #1F618D;
    background-color: #F8F9F9;
  }
</style>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

<?php

if (isset($_GET['open'])) {


  // activer l'affichage du message "deniière modification 

  $bar = true;

  $transcriptionId = $_GET['open'];
  include('../../baseIndex.php');
  require('../../Classes/sql.php');
  require('../../Classes/html.php');

  $sql = new sql;
  $voir = new html;


  $show = ['', '', '', '', '', '', ''];
  if (isset($_SESSION['action'])) {
    $show[$_SESSION['action']] = 'show';
    $_SESSION['action'] = -1;
  }

  $userid = $_SESSION['username'];

  $cond = " where Id = " . $_GET['open'];
  $res = $sql->SelectFromTable('TRANSCRIPTION', " Nom, TransExtension, AudioExtension ", $cond);

  if ($res->num_rows > 0) {

    $obj = $res->fetch_object();

    $_SESSION['transcriptionName'] =  $obj->Nom;

    $mediafile = "../../uploads/media/" . $_SESSION['username'] . '/' . $obj->Nom . '.' . $obj->AudioExtension;
  }


  $result = $sql->getTranscriptionText($transcriptionId);

  $savedList = $sql->SelectFromTable('SAUVEGARDES', 'Id, TransId, FileName', " Where TransId = '" . $transcriptionId . "'");
}


if (isset($_GET['add']) && $_GET['add'] == 'true') {
  $voir->Message("Mise à jour effectuée avec success");
}

?>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->


<form id="UpdateTextForm" action="../../Controller/editTranscriptionController.php" method="Post" onsubmit="getFocuced();">

  <?php

  include "../../Template/Forms/Sauvegardes.php";
  include "../../Template/Forms/ajouterAuteur.php";
  include "../../Template/Forms/editerAuteur.php";
  include "../../Template/Forms/editerLesAuteurs.php";
  include "../../Template/Forms/fusionner.php";
  include "../../Template/Forms/eclater.php";
  include "../../Template/Forms/ajouterParole.php";
  include "../../Template/Forms/supprimerParole.php";

  ?>
  <input type="hidden" id="debutRegion" name="debutRegion" value="<?php if (isset($_SESSION['debutRegion'])) echo $_SESSION['debutRegion'];
                                                                  else echo 0; ?>">
  <input type="hidden" id="finRegion" name="finRegion" value="<?php if (isset($_SESSION['finRegion'])) echo $_SESSION['finRegion'];
                                                              else echo 0; ?>">

  <input type="hidden" id="positionLecture" name="positionLecture" value="<?php if (isset($_SESSION['positionLecture'])) echo $_SESSION['positionLecture'];
                                                                          else echo 0; ?>">
  <input type="hidden" id="positionLectureScroll" name="positionLectureScroll" value="<?php if (isset($_SESSION['positionLectureScroll'])) echo $_SESSION['positionLectureScroll'];
                                                                                      else echo 0; ?>">

  <input type="hidden" id="TransId" name="TransId" value="<?php echo $transcriptionId ?>">


  <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
  <span class="border-1">

    <div class="overflow-auto" id="contentTextScroll1" style="height: 65%; width:75%; float: left">
      <div class="alert alert-light  text-center" role="alert">
        <?php


        $res = $sql->getAuthorsLists($transcriptionId);
        while ($row = $res->fetch_row()) {
          $rows[] = $row;
        }
        $voir->OuvrirTranscription($result, $rows, true);


        ?>


      </div>
    </div>
  </span>

  <div class="overflow" id="contentVideo" style="  height: 55%; width:25%;  float: left">

    <div class="alert alert-light  text-center" role="alert" style="background-color:black">

      <label class="form-label text-right " style="color: white"> Transcription : <?php echo  $obj->Nom ?></label>
      <video id='myaudio' src="<?php echo $mediafile; ?>" controls playsinline style="width: 100%; height: 100%;  margin: 0 auto; display: inline"></video>
    </div>


  </div>


  <!------------------------------------------------------------------------------------------------------------------------>



  <div class="footer fixed-bottom" style="position: fixed; max-height: 40%; bottom: 0;">


    <div class="overflow" style="background-color: #EEEBF1;">


      <div class="row">

        <div id="waveform">

        </div>


      </div>
    </div>


    <div class="row">
      <div class="alert text-left" style="background-color: black" role="alert">


        <!-------------------------------------------------------------------------------------------------------------------------- -->


        <div class="btn-group" role="group">

          <button msok='yes' style="background-color:   #73c6b6  " Id="vald" href="" type="submit" class="btn btn-sm" style="background-color: white" title="Enregistrer les modifications" onclick="updateText()">
            <i class="fa-solid fa-floppy-disk"></i>
          </button>

          <button id='editerA' style="background-color:    #73c6b6   " data-bs-toggle='offcanvas' data-bs-target='#offcanevashistorics' href="" float-right type="button" class="btn btn-sm" style="background-color: white" title="Ajouter un locuteur">
            <i class="fa-solid fa-folder-tree" title="Historique des sauvegardes"></i>
          </button>

          <a class="btn btn-sm" style="background-color:  
           #73c6b6  " msok='yes' href='../../Controller/downloadController.php?download="<?php echo $transcriptionId ?>"' title='Télecharger la transcription' style="background-color: white"><i class='fa-solid fa-download'></i></a>
        </div>

        <!-------------------------------------------------------------------------------------------------------------------------- -->

        <div class="btn-group" role="group">

          <button id='ajouterA' style="background-color:    #85c1e9   " data-bs-toggle='offcanvas' data-bs-target='#offtools' href="" type="button" class="btn btn-sm" style="background-color: white" title="Editer un locuteur">
            <i class="fa-solid fa-user-plus" title="ajouter un locuteur"></i>
          </button>

          <button id='editerA' style="background-color:    #85c1e9   " data-bs-toggle='offcanvas' data-bs-target='#offtoolsEditerAuteur' href="" float-right type="button" class="btn btn-sm" style="background-color: white" title="Ajouter un locuteur">
            <i class="fa-solid fa-user-pen" title="Editer un locuteur"></i>
          </button>

          <button id="editerAs" style="background-color:    #85c1e9   " href="" float-right data-bs-toggle='offcanvas' data-bs-target='#offtoolsEditerAuteurs' type="button" class="btn btn-sm" style="background-color: white" title="Mettre à jour les locuteurs">
            <i class="fa-solid fa-users"></i>

          </button>
        </div>
        <!-------------------------------------------------------------------------------------------------------------------------- -->
        <div class="btn-group" role="group">

          <button msok='yes' style="background-color:    #f1c40f   " id='AjouterP' href="" float-right data-bs-toggle='offcanvas' data-bs-target='#offNewParole' type="button" class="btn btn-sm" style="background-color: white" title="Ajouter une nouvelle parole">
            <i class="fa-solid fa-plus"></i>
          </button>

          <button msok='yes' style="background-color:    #f1c40f   " id="SupprimerP" data-bs-toggle="modal" href="" float-right data-bs-target="#SupprimerParole" type="button" class="btn btn-sm" style="background-color: white" title="Supprimer les paroles sélectionnées" onclick="checkListTodelete()">
            <i class="fa-solid fa-minus"></i>
          </button>

          <button msok='yes' style="background-color:    #f1c40f   " id="Fus" href="" float-right data-bs-toggle='offcanvas' data-bs-target="#offfusionner" type="button" class="btn btn-sm" style="background-color: white" title="Fusionner les paroles sélectionnées" onclick="getCheckedList()">
            <i class="fa-solid fa-paste"></i> </button>

          <button msok='yes' style="background-color:    #f1c40f   " id="Eclat" href="" float-right data-bs-toggle='offcanvas' data-bs-target="#offEclater" type="button" class="btn btn-sm" style="background-color: white" title="" onclick="getCheckedListEclater()">
            <i class="fa-solid fa-scissors"></i>
          </button>
        </div>

        <div class="btn-group" role="group">

          <button id="init" style="background-color:     #d4e6f1    " disabled type="button" data-bs-toggle="modal" type="button" class="btn btn-sm" style="background-color: white" title="Réecouter le texte sélectionné ">
            <i class="fa-solid fa-backward-fast"></i></button>
          <button id="play" style="background-color:     #d4e6f1    " disabled type="button" class="btn btn-sm" style="background-color: white" title="Lire"><i class="fa-solid fa-play"></i></button>

          <button id="pause" style="background-color:     #d4e6f1    " disabled type="button" class="btn btn-sm" style="background-color: white" title="Pause"><i class="fa-solid fa-pause"></i></button>
          <div class="vr"></div>

          <button id="backward" style="background-color:     #d4e6f1    " disabled type="button" class="btn btn-sm" style="background-color: white" title="Retourner de 5S"><i class="fa-solid fa-angles-left"></i></button>
          <button id="forward" style="background-color:     #d4e6f1    " disabled type="button" class="btn btn-sm" style="background-color: white" title="avancer de 5S"><i class="fa-solid fa-angles-right"></i></button>
          <button id="backward2" style="background-color:     #d4e6f1    " disabled type="button" class="btn btn-sm" style="background-color: white" title="Retourner de 2S"><i class="fa-solid fa-angle-left"></i></button>
          <button id="forward2" style="background-color:     #d4e6f1    " disabled type="button" class="btn btn-sm" style="background-color: white" title="avancer de 2S"><i class="fa-solid fa-angle-right"></i></button>

          <div class="vr"></div>

          <button id="refreshTime" style="background-color:     #d4e6f1    " disabled type="button" class="btn btn-sm" style="background-color: white" title="Mettre à jour la durée sélectionnée"><i class="fa-solid fa-retweet"></i></button>
        </div>
        &nbsp;
        <span class="badge text-bg-secondary" id="timeevol">00:00:00.00</span>
        &nbsp;
        <span class="badge text-bg-secondary" id="RegionValue">00:00:00.00/00:00:00.00</span>

        &nbsp;
        <div class="btn-group" role="group">
          <div class="form-check form-switch">

            <input class="form-check-input" type="checkbox" id="lireContinue" checked title="Lire la sélection / Mode continue">

          </div>
          &nbsp;

          <span class="badge text-bg-info" id="rate">Vitese: 1.x</span>
          &nbsp;

          <input type="range" class="form-range" id="rangeralentir" style="width : 75px;" min="0" max="5" step="1" value="3">

          &nbsp;
          <span class="badge text-bg-info" id="zoomer">Zoom : 100%</span>
          &nbsp;

          <input type="range" class="form-range" id="rangeZoom" style="width : 150px;" min="50" max="500" value="0">



        </div>


        <button id="initAll" style="background-color:#A04000" type="button" class="btn btn-sm" title="Initialiser tous les paramètres"> <i class="fa-solid fa-rotate-right" style="color:white"></i></button>

      </div>
    </div>
  </div>



</form>


<!------------------------------------------------------------------------------------------------------------------------>

</div>

<script type="module" src="../JS/wavesurferBar.js">

</script>


<script src="../JS/content.js">
  var pth = <?php echo '"' . $mediafile . '"' ?>;
</script>

<script src="../JS/auto-resize-textarea.js"></script>
<script>
  autoResizeTextarea(document.querySelectorAll("textarea.auto-resize"), {
    maxHeight: 320
  })
</script>