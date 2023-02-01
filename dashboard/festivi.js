const tableBody = document.querySelector("#tBody");
const form = document.querySelector("form");
const sendButtonSedi = document.querySelector("#sendButtonSedi");

const DataTableOptions = {
  scrollX: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Italian.json",
  },
  pageLength: 50,
};

function renderTabellaSedi(action) {
  if (action == "rimuovi") {
    setTimeout(
      () => { },

      1000
    );
    $("#tableSedi").html("Rimosso!");
  } else {
    $("#tableSedi").html("Attendi...");
  }

  setTimeout(() => { }, 3000);
  $("#tableSedi").load("./tabellafestivi.php", () => {
    $("#datatable-2").DataTable(DataTableOptions);
    sendWithEnter();
  });
}

function nuovaSede() {

  const citta = $("#citta2").val();
  const indirizzo = $("#indirizzo2").val();
  const attiva = $("#attiva2").val();
  
  $.post(
    "../api/nuovasede.php",
    {
      citta: citta,
      indirizzo: indirizzo,
      attiva: attiva,
      },
    function (data) {
      renderTabellaSedi();
      if (data == 'successo') {
        Swal.fire(
          'Sede aggiunta',
          'Una nuova sede è stata aggiunta',
          'success'
        )
      } else if(data== 'err_sede_exist') {
        Swal.fire(
          'Errore',
          'Esiste già una sede in questa città',
          'error'
        )
      } else {
        Swal.fire(
          'Errore',
          'La nuova sede non è stata aggiunta',
          'error'
        )

      }
    }
  );
};

function handleModificaSede (el, id) {
  const input = el.previousElementSibling;
  if (input.hasAttribute("disabled")) {
    input.toggleAttribute("disabled");
    if (input.hasAttribute("hidden")) {
      input.removeAttribute("hidden");
    }
    el.children[0].classList.remove("fa-edit");
    el.children[0].classList.add("fa-check");
    return;
  } else {
    const newValue = input.value;
    if (newValue.trim() == "") {
      Swal.fire(
        'Non valido!',
        'Il campo non può essere vuoto.',
        'error'
      )
    } else {
      const valueToChange = input.name;
      console.log('id: '+ id + '   campo: '+ valueToChange + '   valore NEW:' + newValue)
      modificaSede(id, valueToChange, newValue);
      return;
    }
  }
};

function modificaSede (id, valoreDaAggiornare, valoreAggiornato) {
  $.post(
    "../api/modifica.php",
    {
      Id: id,
      valoreDaAggiornare: valoreDaAggiornare,
      valoreAggiornato: valoreAggiornato.trim(),
    },

    function (data) {
      // check errori, se il campo è esistente data == errore
      // se tutto funziona data == successo
      // se c'è un errore di qualche altro tipo data == altro
      console.log(data)
      if (data == "successo") {
        renderTabellaSedi()
        Swal.fire('Successo!', 'Il campo è stato aggiornato!', 'success');
      } else if (data == "errore") {
        Swal.fire('Attenzione!', 'Esiste già una sede a' + valoreDaAggiornare.toLowerCase() + '.', 'error');
      } else if (data == "err_ins_agg") {
        Swal.fire('Ops!', "Qualcosa è andato storto nell'aggiornare il dato, riprova.", 'error');
      } else if (data == "err_ins") {
        Swal.fire('Ops!', "Errore nell'aggiornare il dato, riprova.", 'error');
      } else if (data == "err_ins_pw") {
        Swal.fire('Ops!', "Errore nell'aggiornare la password, riprova.", 'error');
      }
    }
  );
};

const eliminaSede = (citta, codice) => {
  console.log("citta: "+ citta + " codice: "+codice)
  Swal.fire({
    title: "Sei sicuro?",
    text: "Vuoi veramente disattivare la sede di " + citta +"?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((result) => {
    if (result.isConfirmed) {
      $("#" + codice).addClass("remove");

      $.post(
        "../api/elimina.php",
        {
          id: codice,
          tipo: "sede"
        },
        function (data) {
          console.log(data)
          if(data == "successo"){
            renderTabellaSedi("rimuovi");
            // Swal.fire('Successo!', 'La sede è stata disattivata!', 'success');
            return;
          }
          if(data == "err_disattiva"){
            Swal.fire('Ops!', "Errore nel disattivare la sede, riprova.", 'error');
            return;
          } else {
            Swal.fire('Ops!', "Errore nel disattivare la sede, riprova. Err_in_elimina.php", 'error');
            return;
          }
        }
      );
    } else {
      Swal.close();
    }
  });
};

// .then((result) => {
//   if (result.isConfirmed) {
//     Swal.fire(
//       'Deleted!',
//       'Your file has been deleted.',
//       'success'
//     )
//   }
// })

const sendWithEnter = () => {
  $("input").each((index, el) => {
    $(el).on("keypress", function (e) {
      if (e.which === 13) {
        //Disable textbox to prevent multiple submit
        $(el).attr("disabled", "disabled");

        //Do Stuff, submit, etc..
        const newValue = $(el).val();
        const valueToChange = $(el).attr("name");
        const id = $(el).attr("idope");

        if(valueToChange == "submitnuovasede"){
          nuovaSede()
        }
        console.log("id: "+id + "  valueToChange: " + valueToChange + " newValue: " + newValue)
        modificaSede(id, valueToChange, newValue);
        return;
      }
    });
  });
};

const handleModificaTipo = (el, id) => {
  let tar = el.previousElementSibling;
  if (tar.hasAttribute("disabled")) {
    tar.toggleAttribute("disabled");
    el.children[0].classList.remove("fa-edit");
    el.children[0].classList.add("fa-check");
    return;
  } else {
    const newValue = tar.value;
    modificaSede(id, "Tipologia", newValue);
  }
};

const attivaSede = (nome, codice) => {
  Swal.fire({
    title: "Sei sicuro?",
    text: "Vuoi veramente attivare la sede " + nome,
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "../api/attiva.php",
        {
          id: codice,
          tipo: "sede"
        },
        function (data) {
          console.log(data)
          if(data == "successo"){
            renderTabellaSedi();
            // Swal.fire('Successo!', 'La sede è stata disattivata!', 'success');
            return;
          }
          if(data == "err_disattiva"){
            Swal.fire('Ops!', "Errore nel disattivare la sede, riprova.", 'error');
            return;
          } else {
            Swal.fire('Ops!', "Errore nel disattivare la sede, riprova. Err_in_elimina.php", 'error');
            return;
          }
        }
      );
    } else {
      Swal.close();
    }
  });
};

function rinizializza_header() {
  var table = $("#datatable-2").DataTable();
  table.columns.adjust().draw();
}

$("#burger_tasto").click(function () {
  setTimeout(rinizializza_header, 200);
});


$(document).ready(function () {
  renderTabellaSedi();
});
