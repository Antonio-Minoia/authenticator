var x = document.getElementById("location");
var getloc = document.getElementById("getloc");
var authentication = document.getElementById("auth");
var form = document.getElementById("auth-form");
var session = document.getElementById("session");
var sessVal = document.getElementById("session-value");

const options = {
  enableHighAccuracy: true,
  timeout: 60000,
  maximumAge: 0
};

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError, options);
  } else { 
    x.innerHTML = "La geolocalizzazione non è consentita in questo browser.";
  }
}

window.addEventListener('load', (event) => {
  getLocation();
  
});

function showPosition(position) {
  document.cookie="latitude="+position.coords.latitude;
  document.cookie="longitude="+position.coords.longitude;
  session.removeAttribute("style");
}

function handlesession(parameter) {
  authentication.removeAttribute("style");
   
  if(parameter == "start") {
    sessVal.setAttribute("value", "start");
    getloc.setAttribute("style", "visibility: hidden");
    session.setAttribute("style", "visibility: hidden");
    // alert("start")
    
  }
  if(parameter == "stop") {
    sessVal.setAttribute("value", "stop");
    getloc.setAttribute("style", "visibility: hidden");
    session.setAttribute("style", "visibility: hidden");
    // alert("stop")
  }
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      x.innerHTML = "Non hai accettato il consenso alla lettura della posizione, perciò non potrai continuare."
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML = "La tua posizione non è raggiungibile, segui il tutorial per annullare e riconfermare il consenso alla posizione."
      break;
    case error.TIMEOUT:
      x.innerHTML = "L'operazione ha richiesto troppo tempo, segui il tutorial per annullare e riconfermare il consenso alla posizione."
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML = "C'è stato un errore prova a rieseguire il Login."
      break;
  }
}

