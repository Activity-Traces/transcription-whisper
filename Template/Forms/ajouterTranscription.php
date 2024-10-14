<form action="Controller/newTranscriptionController.php" name="TranscriptionForm" method="post" enctype="multipart/form-data" onsubmit="return verifierSaisie();">

  <div class="modal fade" id="ajouterTranscription" tabindex="-1" aria-labelledby="ajouterTranscriptionLabel" aria-hidden="true">

    <div class="modal-dialog  modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ajouterTranscriptionLabel">Nouvelle Transcription</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card">

            <div class="row">
              <div class="col-6">
                <br>
                <h6>&nbsp;Charger le fichier multimedia :</h6>


                <div class="input-group">


                  &nbsp; <input class="form-control" type="file" accept=".wav,.mp3,.mp4" name="fichierMedia" id="fichierMedia">
                  <input type="hidden" name="MAX_FILE_SIZE" value="1000000000" />
                  &nbsp;

                </div>
                <br>

              </div>
              <div class="col-6">
                <br>

                <h6> &nbsp; Charger le fichier de transcription :</h6>

                <div class="input-group">


                  <input class="form-control" type="file" name="fichiersrt" id="fichiersrt" accept=".srt">

                  &nbsp;

                </div>&nbsp;

                <div class="input-group">


                  &nbsp;<input class="form-check-input" type="checkbox" role="switch" checked id="diarisation" name="diarisation">&nbsp; Fichier de transcription diarisé
                  &nbsp;
                </div>
                <br>

              </div>
            </div>


            <br>

            <div class="card-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
              <input class="btn btn-primary" type="submit" name="AjouterTranscription" value="Ajouter la transcription"></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</form>
<p id="info"> </p>

<p id="infoSuite"> </p>

<script>
  //********************************************************************************************************** */

  function verifierSaisie() {

    send = true;
    //********************************************************************************************************** */


    if (conversion[0].checked == true) {
      if (document.getElementById("fichierMedia").files.length == 0) {

        document.getElementById("info").innerHTML = " <div class='alert alert-warning alert-dismissible fade show' role='alert'> <strong> Info: </strong>Fichier multimedia: Aucun fichier n'est selectionné<button type = 'button' class = 'btn-close' data-bs-dismiss = 'alert' aria-label = 'Close'> </button> </div>";

        send = false;

      } else {
        emp = document.getElementById("fichierMedia").files[0].name;
        extension = emp.split('.');


        var pets = ['wav', 'mp3', 'mp4'];


        if (pets.includes(emp) == false) {

          document.getElementById("info").innerHTML = " <div class='alert alert-warning alert-dismissible fade show' role='alert'> <strong> Info: </strong>Fichier multimedia: le format du fichier n'est pas autorisé <button type = 'button' class = 'btn-close' data-bs-dismiss = 'alert' aria-label = 'Close'> </button> </div>";

          send = false;
        }

      }
    }

    //********************************************************************************************************** */


    if (document.getElementById("fichiersrt").files.length == 0) {
      document.getElementById("infoSuite").innerHTML = " <div class='alert alert-warning alert-dismissible fade show' role='alert'> <strong> Info: </strong>Fichier de transcription: Aucun fichier n'est selectionné <button type = 'button' class = 'btn-close' data-bs-dismiss = 'alert' aria-label = 'Close'> </button> </div>";


      send = false;

    } else {

      emp = document.getElementById("fichiersrt").files[0].name;
      extension = emp.split('.');


      var pets2 = ['srt'];


      if (pets2.includes(emp) == false) {
        document.getElementById("infoSuite").innerHTML = " <div class='alert alert-warning alert-dismissible fade show' role='alert'> <strong> Info: </strong>Fichier de transcription: le format du fichier n'est pas autorisé  <button type = 'button' class = 'btn-close' data-bs-dismiss = 'alert' aria-label = 'Close'> </button> </div>";

        send = false;
      }

    }

    //********************************************************************************************************** */

    return (send);

  }
</script>