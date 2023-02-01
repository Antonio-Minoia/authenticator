const loginButton = document.getElementById("#accedi");
const loginForm = document.querySelector("form");
const errorText = document.querySelector("p");
const wrapper = document.querySelector(".wrapper");

loginForm.addEventListener("submit", (event) => {
  event.preventDefault();
});

loginButton.addEventListener("click", (event) => {
  event.preventDefault();
  accedi();
});

function seePass() {

  alert("aah")
}


const accedi = async () => {
  let username = document.querySelector("#username").value;
  let password = document.querySelector("#password").value;

  console.log(username, password);

  let errore = "";

  if (username && password) {

    $.post(
      "../api/login.php",
      { username: username, password: password },
      (res) => {
        switch (res) {
          case "err_no_user":
            errore = "Utente inesistente, prova a ricontrollare le credenziali";
            wrapper.classList.add("shake");
            wrapper.classList.remove("shake");
            errorText.innerHTML = errore;
            break;
          case "err_no_attivo":
            errore = "Utente inattivo, impossibile accedere";
            wrapper.classList.add("shake");
            wrapper.classList.remove("shake");
            errorText.innerHTML = errore;
            break;
          default:
            errorText.innerHTML = "";
            window.location.replace("../dashboard/index.php");
            break;
        }
      }
    );
  }
};

//toggle pass
function togglePassword() {
  if($('#password').attr("type") == "text") {
    $('#eye').attr("class","fas fa-eye-slash")
    $('#password').attr({
      type: "password"
    });
  } else {
    $('#eye').attr("class","fas fa-eye")
    $('#password').attr({
      type: "text"
    });
  }
  console.log($('#password').attr("type"))
}