/************************************************************************************************************** */
/************************************************************************************************************** */

import WaveSurfer from "../../node_modules/wavesurfer.js/dist/wavesurfer.esm.js";
import TimelinePlugin from "../../node_modules/wavesurfer.js/dist/plugins/timeline.esm.js";
import Minimap from "../../node_modules/wavesurfer.js/dist/plugins/minimap.esm.js";
import RegionsPlugin from "../../node_modules/wavesurfer.js/dist/plugins/regions.esm.js";

/************************************************************************************************************** */

var verou = 0;
var TMDebut = 0;
var TMFin = 0;

var TimeEnd = 0;
var chekmedia = true;
var cmt;

var checks = document.getElementsByName("ListCheked");
var audio = document.getElementById("myaudio");
audio.position = 0;

var isfirstClick = true;
var isRegion = false;
const speeds = [0.25, 0.5, 0.75, 1, 1.5, 2];

/************************************************************************************************************** */

const initButton = document.querySelector("#init");
const playButton = document.querySelector("#play");
const PauseButton = document.querySelector("#pause");

const refreshTime = document.querySelector("#refreshTime");

const backButton = document.querySelector("#backward");
const forwardButton2 = document.querySelector("#forward2");
const backButton2 = document.querySelector("#backward2");
const forwardButton = document.querySelector("#forward");
const chechedMediaElement = document.querySelector("#lireContinue");
const initAll = document.querySelector("#initAll");


/************************************************************************************************************** */

const bottomTimline = TimelinePlugin.create({
  height: 15,
  timeInterval: 0.1,
  primaryLabelInterval: 1,
  style: {
    fontSize: "8px",
    color: "#6A3274",
  },
});

const ws = WaveSurfer.create({
  container: "#waveform",
  waveColor: "#3686c9",
  progressColor: "#C06C84",
  showTime: true,
  opacity: 1,
  cursorColor: "#C06C84",
  minPxPerSec: 100,
  dragToSeek: true,
  cursorWidth: 3,
  autoCenter: true,
  showTime: true,

  customShowTimeStyle: {
    "background-color": "#000",
    color: "#fff",
    padding: "2px",
    "font-size": "10px",
  },

  barWidth: 1,

  cursorColor: "transparent",
  media: document.querySelector("video"),
  minPxPerSec: 60,
  height: 30,

  plugins: [
    bottomTimline,

    Minimap.create({
      height: 20,
      waveColor: "#922B21",
      progressColor: "#21618C",
      startSeconds: 0,
      formatTime: "MM:SS",
    }),
  ],
});

/************************************************************************************************************** */

const wsRegions = ws.registerPlugin(RegionsPlugin.create());

/************************************************************************************************************** */
/************************************************************************************************************** */

// Les fonctions

/************************************************************************************************************** */
/************************************************************************************************************** */

function SelectText(debut, fin) {
  for (var i = 0; i < checks.length; i++) {
    if (
      parseInt(checks[i].getAttribute("iddebut")) >= debut &&
      parseInt(checks[i].getAttribute("iddebut")) < fin
    ) {
      checks[i].checked = true;
      var s = checks[i].getAttribute("value");

      document.getElementById("MyTextarea[" + s + "]").style.backgroundColor =
        "#D4E6F1";
      document.getElementById("MyTextarea[" + s + "]").focus();
    }
  }
}

/************************************************************************************************************** */

function SelectText2(debut, fin) {
  for (var i = 0; i < checks.length; i++) {
    if (
      checks[i].getAttribute("iddebut") >= debut &&
      checks[i].getAttribute("iddebut") <= fin
    ) {
      checks[i].checked = true;
      var s = checks[i].getAttribute("value");

      document.getElementById("MyTextarea[" + s + "]").style.backgroundColor =
        "#D4E6F1";
      document.getElementById("MyTextarea[" + s + "]").focus();
    }
  }
}

/************************************************************************************************************** */

function secondsToTime(secondsT) {
  var secs = Math.round(secondsT);

  var hours = Math.floor(secs / (60 * 60));

  var divisor_for_minutes = secs % (60 * 60);
  var minutes = Math.floor(divisor_for_minutes / 60);

  var divisor_for_seconds = divisor_for_minutes % 60;
  var seconds = Math.ceil(divisor_for_seconds);

  var b = secondsT % Math.trunc(secondsT);
  var mseconds = b.toFixed(2);

  if (mseconds >= 0.5) seconds = seconds - 1;

  var text = mseconds.toString();
  var s = text.split(".")[1];

  if (hours < 10) hours = "0" + hours;
  if (minutes < 10) minutes = "0" + minutes;
  if (seconds < 10) seconds = "0" + seconds;
  if (s.length == 1) s = s + "0";

  var res = hours + ":" + minutes + ":" + seconds + "." + s;
  return res;
}
/**************************************************************************************************************/

function UpdateSelectdText(debut, fin) {
  for (var i = 0; i < checks.length; i++) {
    if (checks[i].checked) {
      var s = checks[i].getAttribute("value");

      var deb = secondsToTime(debut);
      var fn = secondsToTime(fin);

      document.getElementById("MyDates[" + s + "]").value = deb + " / " + fn;
      document.getElementById("MyTextarea[" + s + "]").focus();
    }
  }
}

/**************************************************************************************************************/

function addNewRegion(debut, fin) {
  wsRegions.clearRegions();

  wsRegions.addRegion({
    id: "SelectRegion",
    start: debut,
    end: fin,
    color: "rgba(247, 220, 11, 0.3)",
    loop: false,
  });
  let deb = "00:00:00.00";
  if (debut != 0) deb = secondsToTime(debut);
  var fn = secondsToTime(fin);

  document.getElementById("RegionValue").innerHTML = deb + "/" + fn;
}

/**************************************************************************************************************/

function clearSelections() {
  for (var i = 0; i < checks.length; i++) {
    checks[i].checked = false;
    var s = checks[i].getAttribute("value");

    document.getElementById("MyTextarea[" + s + "]").style.backgroundColor =
      "white";
  }
}

/**************************************************************************************************************/
/**************************************************************************************************************/
// wavesurfer créer le timeline bar, la minmap :

/**************************************************************************************************************/

onsubmit = (event) => {
  document.getElementById("debutRegion").value = wsRegions.regions[0].start;
  document.getElementById("finRegion").value = wsRegions.regions[0].end;
  //  document.getElementById("lignecochee").value = wsRegions.regions[0].end;
  document.getElementById("positionLecture").value = audio.currentTime;

  document.getElementById("positionLectureScroll").value =
    ws.renderer.scrollContainer.scrollLeft;
};

addEventListener("load", (event) => {
  /*
  TMDebut=  document.getElementById("debutRegion").value;
  TMFin = document.getElementById("finRegion").value;

  // ws.renderer.scrollContainer.scrollTo(document.getElementById("positionLectureScroll").value);

  document.getElementById("timeevol").innerHTML= secondsToTime(document.getElementById("positionLecture").value);
  document.getElementById("RegionValue").innerHTML= secondsToTime(TMDebut)+'/'+secondsToTime(TMFin);
  
  ws.seekTo(TMDebut/ws.getDuration());

  audio.currentTime = document.getElementById("positionLecture").value;

  addNewRegion(TMDebut, TMFin);
  clearSelections();
  SelectText(TMDebut, TMFin);*/
});

/************************************************************************************************************** */
/************************************************************************************************************** */

const slider = document.querySelector("#rangeZoom");

slider.addEventListener("input", (e) => {
  const minPxPerSec = e.target.valueAsNumber;
  ws.zoom(minPxPerSec);
  document.querySelector("#zoomer").textContent = "Zoom: " + minPxPerSec + "%";
});

document.querySelector('input[type="range"]').addEventListener("input", (e) => {
  const speed = speeds[e.target.valueAsNumber];
  document.querySelector("#rate").textContent =
    "Vitesse: " + speed.toFixed(2) + ".x";
  ws.setPlaybackRate(speed, true);
});

/**************************************************************************************************************/

// L'évenement sur le bouton jouer

var btns = document.querySelectorAll("#playme");

[].forEach.call(btns, function (btn) {
  btn.addEventListener("click", function (event) {
    verou = 1;
    isRegion = false;

    document.getElementById("lireContinue").checked = true;

    document.getElementById("play").disabled = false;
    document.getElementById("init").disabled = false;
    document.getElementById("pause").disabled = false;

    document.getElementById("refreshTime").disabled = false;
    document.getElementById("backward").disabled = false;

    document.getElementById("forward").disabled = false;
    document.getElementById("backward2").disabled = false;
    document.getElementById("forward2").disabled = false;

    chekmedia = true;

    let p = this.getAttribute("TimeVal");
    let debuts = p.split(" / ")[0];
    let fins = p.split(" / ")[1];

    let tt = debuts.split(":");
    TMDebut = tt[0] * 3600 + tt[1] * 60 + tt[2] * 1;

    tt = "";
    tt = fins.split(":");
    TMFin = tt[0] * 3600 + tt[1] * 60 + tt[2] * 1;

    audio.currentTime = TMDebut;

    addNewRegion(TMDebut, TMFin);
    clearSelections();
    SelectText(TMDebut * 1000, TMFin * 1000);
    wsRegions.regions[0].play();
    TimeEnd = TMFin;
  });
});

/**************************************************************************************************************/

ws.once("decode", () => {
  /**************************************************************************************************************/

  audio.addEventListener("timeupdate", function () {
    var t = secondsToTime(this.currentTime);
    document.getElementById("timeevol").innerHTML = t;

    if (chekmedia) {
      if (this.currentTime >= TimeEnd) {
        this.pause();
        this.currentTime = TimeEnd;
      }
    } else {
      clearSelections();
      SelectText2(this.currentTime * 1000, (this.currentTime + 1) * 1000);
    }
  });

  /**************************************************************************************************************/

  chechedMediaElement.onclick = () => {
    var ch = !chechedMediaElement.checked;

    if (verou == 1) {
      document.getElementById("init").disabled = ch;

      document.getElementById("refreshTime").disabled = ch;
      document.getElementById("backward").disabled = ch;

      document.getElementById("forward").disabled = ch;
      document.getElementById("backward2").disabled = ch;
      document.getElementById("forward2").disabled = ch;
    }

    audio.pause();
  };

  /**************************************************************************************************************/

  playButton.onclick = () => {
    if (isRegion == true) {
      if (isfirstClick) {
        audio.currentTime = wsRegions.regions[0].start;
        isfirstClick = false;
      }
      TimeEnd = wsRegions.regions[0].end;
      document.getElementById("lireContinue").checked = true;
      chekmedia = true;
    } else chekmedia = document.getElementById("lireContinue").checked;
    audio.play();
  };

  /**************************************************************************************************************/

  refreshTime.onclick = () => {
    var DebutSelectionTime = wsRegions.regions[0].start;
    var FinSelectionTime = wsRegions.regions[0].end;

    UpdateSelectdText(DebutSelectionTime, FinSelectionTime);
    //ws.renderer.scrollContainer.scrollTo = 6000;
  };

  /**************************************************************************************************************/

  PauseButton.onclick = () => {
    ws.pause();
  };

  /**************************************************************************************************************/

  initButton.onclick = () => {
    document.getElementById("lireContinue").checked = true;
    chekmedia = true;

    addNewRegion(TMDebut, TMFin);
    clearSelections();
    SelectText(TMDebut * 1000, TMFin * 1000);

    audio.currentTime = TMDebut;
    TimeEnd = TMFin;
    audio.play();
  };

  /**************************************************************************************************************/

  forwardButton.onclick = () => {
    ws.skip(5);
    /*
    const { scrollLeft, scrollWidth, clientWidth } =
      bottomTimline.renderer.scrollContainer;
    const curentRelPos = (scrollLeft + clientWidth * 0.5) / scrollWidth;
    alert(
      scrollLeft,
      " - ",
      scrollWidth,
      " - ",
      clientWidth,
      " - ",
      curentRelPos
    );
    console.log(ws.scrollLeft, ws.render.scrollTop);
    //console.log(bottomTimline);*/
  };

  /**************************************************************************************************************/

  backButton.onclick = () => {
    ws.skip(-5);
  };

  /**************************************************************************************************************/

  forwardButton2.onclick = () => {
    ws.skip(2);
  };

  /**************************************************************************************************************/

  backButton2.onclick = () => {
    ws.skip(-2);
  };

  /**************************************************************************************************************/

  initAll.onclick = () => {
    ws.currentTime = 0;
    audio.position = 0;
    ws.seekTo(0);

    wsRegions.clearRegions();
    clearSelections();
    document.querySelector("#zoomer").textContent = "Zoom: ";
    document.querySelector("#rate").textContent = "Vitesse: .X";
    document.querySelector("#rangeZoom").value = 100;
    document.querySelector("#rate").value = 3;
    chechedMediaElement.checked = false;

    document.getElementById("RegionValue").innerHTML = "00:00:00.00";
    document.getElementById("timeevol").innerHTML = "00:00:00.00/00:00:00.00";

    var ch = chechedMediaElement.checked;

    document.getElementById("init").disabled = ch;

    document.getElementById("refreshTime").disabled = ch;
    document.getElementById("backward").disabled = ch;

    document.getElementById("forward").disabled = ch;
    document.getElementById("backward2").disabled = ch;
    document.getElementById("forward2").disabled = ch;
  };
});

/**************************************************************************************************************/

// mise à jour de la région : selection auto du texte

wsRegions.on("region-updated", function (region) {
  region.color = "rgba(222, 220, 11, 0.1)";

  var debut = region.start;
  var fin = region.end;

  document.getElementById("init").disabled = true;

  isRegion = true;
  isfirstClick = true;

  var deb = secondsToTime(debut);
  var fn = secondsToTime(fin);

  document.getElementById("RegionValue").innerHTML = deb + "/" + fn;

  clearSelections();

  debut = debut * 1000;
  fin = fin * 1000;

  for (var i = 0; i < checks.length; i++) {
    if (
      (checks[i].getAttribute("iddebut") > debut &&
        checks[i].getAttribute("iddebut") < fin) ||
      (debut > checks[i].getAttribute("iddebut") &&
        debut < checks[i].getAttribute("idfin")) ||
      (fin > checks[i].getAttribute("iddebut") &&
        fin < checks[i].getAttribute("idfin"))
    ) {
      checks[i].checked = true;
      var s = checks[i].getAttribute("value");
      document.getElementById("MyTextarea[" + s + "]").style.backgroundColor =
        "#D4E6F1";

      //document.getElementById("contentTextScroll1").focus({ preventScroll: true })

      document.getElementById("MyTextarea[" + s + "]").focus();
      //$(window).scrollTop($("#MyTextarea[" + s + "]").position());

      $("MyTextarea[" + s + "]").focus(function () {
        $("html, body").animate(
          {
            scrollTop: $(this).offset().top + 100 + "px",
          },
          "fast"
        );
      });
    }
  }
});

/**************************************************************************************************************/
ws.on("audioprocess", function () {
  cmt = Math.round(ws.getCurrentTime());
  document.getElementById("MyTextarea[" + cmt + "]").focus();
});

/**************************************************************************************************************/
/**************************************************************************************************************/
