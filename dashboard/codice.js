var x = document.getElementById("location");
var divx = document.getElementById("div-location");
var authentication = document.getElementById("auth");
var form = document.getElementById("auth-form");
var session = document.getElementById("session");
var sessVal = document.getElementById("session-value");
var idsmartphone = document.getElementById("idsm");
var idsm = "";
var getlocation = document.getElementById("getLocation");


const options = {
  enableHighAccuracy: true,
  timeout: 60000,
  maximumAge: 0
};

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError, options);
  } else {
    divx.removeAttribute("style");
    x.innerHTML = "La geolocalizzazione non è consentita in questo browser.";
  }
}

window.addEventListener('load', (event) => {
  idsm = idsmartphone.textContent;
  getLocation();

  // alert(JSON.stringify(idsm))
});


function setFavourite() {
  var navigator_info = window.navigator;
  var screen_info = window.screen;
  var uid = navigator_info.mimeTypes.length;
  uid += navigator_info.userAgent.replace(/\D+/g, '');
  uid += navigator_info.plugins.length;
  uid += screen_info.height || '';
  uid += screen_info.width || '';
  uid += screen_info.pixelDepth || '';
  console.log(uid);
  idsmartphone.innerHTML = uid;

  $.post(
    "../api/setfavdev.php", {
    dispositivo: uid,
    value: "smartphone"
  },
    function (data) {
      if (data == "successo") {
        location.reload();
        getLocation.removeAttribute("style");
      }
    })
}


var posizione;
function showPosition(position) {
  document.cookie = "latitude=" + position.coords.latitude;
  document.cookie = "longitude=" + position.coords.longitude;
  value = position.coords.latitude + " " + position.coords.longitude;
  posizione = value;
  // session.removeAttribute("style");
  if (session == null) {
    showCode('exist')
  } else {
    session.removeAttribute("style");
    console.log(session)
  }
  // x.innerHTML = value;
}

setInterval(function () {
  location.reload();
  // authentication.removeAttribute("style");
  showCode()
}, 30000);


function showCode(parameter) {
  console.log(posizione)
  console.log(parameter)
  if (navigator.geolocation) {
    // navigator.geolocation.getCurrentPosition(showPosition, showError, options);
    // posizione = showPosition()
    // x.innerHTML = posizione
    var navigator_info = window.navigator;
    var screen_info = window.screen;
    var uid = navigator_info.mimeTypes.length;
    uid += navigator_info.userAgent.replace(/\D+/g, '');
    uid += navigator_info.plugins.length;
    uid += screen_info.height || '';
    uid += screen_info.width || '';
    uid += screen_info.pixelDepth || '';
    console.log(uid);
    // alert(uid)
    console.log(idsm);
    if (uid.toString().trim() == idsm.toString().trim()) {

      // document.write(uid);

      const ua = navigator.userAgent;
      console.log(ua);
      // document.write(ua)

      if (parameter == "show") {
        $.post(
          "../api/letturacodice.php", {
          // posizione: "40.89459426359942 17.209889152267515",
          posizione: posizione,
          dispositivo: uid,
          value: "insert"
        },
          function (data) {
            if (data == "successo") {
              authentication.removeAttribute("style");
              getlocation.setAttribute("style", "visibility: hidden");
            }
          })
      }

      if (parameter == "exist") {
        $.post(
          "../api/letturacodice.php", {
          // posizione: "40.89459426359942 17.209889152267515",
          posizione: posizione,
          dispositivo: uid,
          value: "update"
        },
          function (data) {
            if (data == "successo") {
              authentication.removeAttribute("style");
              getlocation.setAttribute("style", "visibility: hidden");
            } else {
              divx.removeAttribute("style");
              x.innerHTML = "Qualcosa e andato storto!"
            }
          })
      }
    } else {
      divx.removeAttribute("style");
      x.innerHTML = "Puoi utilizzare solo il dispositivo preferito.<br>Contatta un amministratore per cambiare il tuo dispositivo preferito."
    }
  } else {
    divx.removeAttribute("style");
    x.innerHTML = "Devi mantenere la posizione attiva per continuare."
  }
}

function showError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      divx.removeAttribute("style");
      x.innerHTML = "Non hai accettato il consenso alla lettura della posizione, perciò non potrai continuare."
      break;
    case error.POSITION_UNAVAILABLE:
      divx.removeAttribute("style");
      x.innerHTML = "La tua posizione non è raggiungibile, segui il tutorial per annullare e riconfermare il consenso alla posizione."
      break;
    case error.TIMEOUT:
      divx.removeAttribute("style");
      x.innerHTML = "L'operazione ha richiesto troppo tempo, segui il tutorial per annullare e riconfermare il consenso alla posizione."
      break;
    case error.UNKNOWN_ERROR:
      divx.removeAttribute("style");
      x.innerHTML = "C'è stato un errore prova a rieseguire il Login."
      break;
  }
}

const FULL_DASH_ARRAY = 283;
const WARNING_THRESHOLD = 10;
const ALERT_THRESHOLD = 5;

const COLOR_CODES = {
  info: {
    color: "green"
  },
  warning: {
    color: "orange",
    threshold: WARNING_THRESHOLD
  },
  alert: {
    color: "red",
    threshold: ALERT_THRESHOLD
  }
};

const TIME_LIMIT = 32;
let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;
let remainingPathColor = COLOR_CODES.info.color;

document.getElementById("app").innerHTML = `
<div class="base-timer">
  <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <g class="base-timer__circle">
      <circle class="base-timer__path-elapsed" cx="500" cy="500" r="0"></circle>
      <path
        id="base-timer-path-remaining"
        stroke-dasharray="283"
        class="base-timer__path-remaining ${remainingPathColor}"
        d="
          M 50, 50
          m -45, 0
          a 45,45 0 1,0 90,0
          a 45,45 0 1,0 -90,0
        "
      ></path>
    </g>
  </svg>
  <span id="base-timer-label" class="base-timer__label">${formatTime(
  timeLeft
)}</span>
</div>
`;

startTimer();

function onTimesUp() {
  clearInterval(timerInterval);
}

function startTimer() {
  timerInterval = setInterval(() => {
    timePassed = timePassed += 1;
    timeLeft = TIME_LIMIT - timePassed;
    document.getElementById("base-timer-label").innerHTML = formatTime(
      timeLeft
    );
    setCircleDasharray();
    setRemainingPathColor(timeLeft);

    if (timeLeft === 0) {
      onTimesUp();
    }
  }, 950);
}

function formatTime(time) {
  const minutes = Math.floor(time / 60);
  let seconds = time % 60;

  if (seconds < 10) {
    seconds = `0${seconds}`;
  }

  return `${minutes}:${seconds}`;
}

function setRemainingPathColor(timeLeft) {
  const { alert, warning, info } = COLOR_CODES;
  if (timeLeft <= alert.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(warning.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(alert.color);
  } else if (timeLeft <= warning.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(info.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(warning.color);
  }
}

function calculateTimeFraction() {
  const rawTimeFraction = timeLeft / TIME_LIMIT;
  return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
}

function setCircleDasharray() {
  const circleDasharray = `${(
    calculateTimeFraction() * FULL_DASH_ARRAY
  ).toFixed(0)} 283`;
  document
    .getElementById("base-timer-path-remaining")
    .setAttribute("stroke-dasharray", circleDasharray);
}