/******************************************************************************************************** */
function secondsToTime2(secondsT) {
  let secs = Math.round(secondsT);

  let hours = Math.floor(secs / (60 * 60));

  let divisor_for_minutes = secs % (60 * 60);
  let minutes = Math.floor(divisor_for_minutes / 60);

  let divisor_for_seconds = divisor_for_minutes % 60;
  let seconds = Math.ceil(divisor_for_seconds);

  let b = secondsT % Math.trunc(secondsT);
  let mseconds = b.toFixed(2);

  if (mseconds >= 0.5) seconds = seconds - 1;

  let text = mseconds.toString();
  let s = text.split(".")[1];

  if (hours < 10) hours = "0" + hours;
  if (minutes < 10) minutes = "0" + minutes;
  if (seconds < 10) seconds = "0" + seconds;

  if (s.length == 1) s = s + "0";

  let res = hours + ":" + minutes + ":" + seconds + "." + s;
  return res;
}

let nameInput = null;
let audioV = document.getElementById("myaudio");

const cango = ["acceuil", "monprofil", "utilisateurs", "deconnexion"];

let viewVideo = true;

/******************************************************************************************************** */

function checkIdAuthor() {
  if (document.getElementById("authorName").value == "") {
    event.preventDefault();
    document.getElementById("addAuthorIsEmpty").innerHTML =
      '<div class="alert alert-info" role="alert">L\'identifiant locuteur est vide!</div>';
    return false;
  } else return true;
}

/******************************************************************************************************** */

function viewHideVideo() {
  viewVideo = !viewVideo;

  if (viewVideo) {
    document.getElementById("contentMenue").style =
      "max-height: 80%; max-width:5%; float: left";
    document.getElementById("contentText").style =
      "max-height: 80%; max-width:70%; float: left";

    document.getElementById("contentVideo").style.display = "block";
    document.getElementById("contentVideo").style =
      "max-height: 80%; max-width:25%;  float: left";
  } else {
    document.getElementById("contentMenue").style =
      "max-height: 80%; max-width:5%; float: left";
    document.getElementById("contentText").style =
      "max-height: 80%; max-width:95%; float: left";

    document.getElementById("contentVideo").style.display = "none";
  }
}

/******************************************************************************************************** */

document.addEventListener("focusin", () => {
  nameInput = document.activeElement.getAttribute("msok");
});

window.onbeforeunload = function () {
  let msg = "Are you sure you want to leave?";

  if (nameInput == "yes") return;
  else {
    return msg;
  }
};

let scrollpos = localStorage.getItem("scrollpos");
if (scrollpos) document.getElementById("contentText").scrollTo(0, scrollpos);

/************************************************************************************************************** */
// document.getElementById("MyTextarea[4849]").focus();

/************************************************************************************************************** */

function getCheckedList() {
  let cont;
  let date;
  let dates = [];
  let res = "";
  let count = 0;
  let checkboxes = document.getElementsByName("ListCheked");
  let first = "";
  let last = "";

  let result = "";
  document.getElementById("afusionner").innerHTML = "";
  for (let i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      count++;

      let name = "MyTextarea[" + checkboxes[i].value + "]";
      let time = "MyDates[" + checkboxes[i].value + "]";

      cont = document.getElementById(name);
      date = document.getElementById(time);
      dates.push(date.value);

      document.getElementById("afusionner").innerHTML +=
        '<input type="hidden" name="choixFusion[' +
        checkboxes[i].value +
        ']" value="' +
        checkboxes[i].value +
        '"><div class="alert alert-primary" role="alert"><b>' +
        date.value +
        "</b><br>" +
        cont.value +
        "</div>";
      res += cont.value + "&nbsp;";
    }
  }
  if (dates.length > 0) {
    first = dates[0].split(" / ")[0];
    last = dates[dates.length - 1].split(" / ")[1];
  }

  if (count >= 2)
    document.getElementById("afusionner").innerHTML +=
      '<div class="alert alert-info" role="alert"><b>Résultat attendu : </b><br><b>' +
      first +
      " / " +
      last +
      "</b><br>" +
      res +
      "</div>";
  else
    document.getElementById("afusionner").innerHTML +=
      '<div class="alert alert-info" role="alert">Sélectionner au moins deux paroles à fusionner</div>';
}
/******************************************************************************************************** */

function checkListTodelete() {
  let count = 0;
  let checkboxes = document.getElementsByName("ListCheked");
  document.getElementById("asupprimer").innerHTML = "";

  for (let i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) count++;
  }

  if (count == 0)
    document.getElementById(
      "asupprimer"
    ).innerHTML = `<div class="modal-body">Selectionnez au moins une parole à supprimer</div>`;
  else
    document.getElementById("asupprimer").innerHTML = `   
                <div class="modal-body">Voulez-vous vraiment supprimer les paroles sélectionnées

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <input msok="yes" class="btn btn-primary" type="submit" name="DeleteParole" value="Supprimer"></button>
                </div>`;
}
/************************************************************************************************************** */

function getCheckedListEclater() {
  let cont;
  let date;
  let dates = [];
  let count = 0;

  document.getElementById("eclaterTexte1").value = "";
  document.getElementById("eclaterTexte2").value = "";
  let checkboxes = document.getElementsByName("ListCheked");
  let result = "";
  for (let i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      count++;

      // recuperer le texte depuis curseur
      let name = "MyTextarea[" + checkboxes[i].value + "]";
      let time = "MyDates[" + checkboxes[i].value + "]";

      cont = document.getElementById(name);
      date = document.getElementById(time);
      dates.push(date.value);

      document.getElementById("aeclater2").value = cont.value;

      document.getElementById("aeclater").innerHTML = "";

      document.getElementById("aeclater").innerHTML +=
        '<input type="hidden" name="choixFusion[' +
        checkboxes[i].value +
        ']" value="' +
        checkboxes[i].value +
        '"><div class="alert alert-primary" role="alert">' +
        cont.value +
        "</div>";
    }
  }

  if (count != 1) {
    document.getElementById("aeclater").innerHTML =
      '<div class="alert alert-primary" role="alert">Aucune parole à éclater: Sélectionner une seule parole à éclater</div>';
    document.getElementById("aeclater2").value = "";
  }
  if (count == 1) {
    console.log(dates);
    let first = dates[0].split(" / ")[0];
    let last = dates[dates.length - 1].split(" / ")[1];

    let med = audioV.currentTime;
    document.getElementById("Time1").value =
      first + " / " + secondsToTime2(med);

    document.getElementById("Time2").value = secondsToTime2(med) + " / " + last;
  }
}

/************************************************************************************************************** */

function initSelectedList() {
  let checkboxes = document.getElementsByName("ListCheked");
  document.getElementById("aeclater").innerHTML = "";

  for (let i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      document.getElementById("authorList").innerHTML +=
        '<input type="hidden" name="authorListCheched[' +
        checkboxes[i].value +
        ']" value="' +
        checkboxes[i].value +
        '">';
    }
  }
}

/************************************************************************************************************** */

let checks = document.getElementsByName("ListCheked");

function stopPosition() {
  let audio = document.getElementById("myaudio");

  audio.pause();
}

function updateText() {
  const activeTextarea = document.activeElement;

  let position = document.getElementById("contentTextScroll1").scrollTop;
  localStorage.setItem("scrollpos", position);
}

function getFocuced() {
  const focusedElement = document.activeElement;
  return false;
}
