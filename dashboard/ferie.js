const tableBody = document.querySelector("#tBody");
const form = document.querySelector("form");

const DataTableOptions = {
  scrollX: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Italian.json",
  },
  pageLength: 25,
};
const DataTableOptions3 = {
  scrollX: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Italian.json",
  },
  pageLength: 5,
};
const DataTableOptions4 = {
  scrollX: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Italian.json",
  },
  pageLength: 5,
};

// form.addEventListener("submit",
//   nuoveFerie()
// );

// sendButtonFerie.addEventListener("click",nuoveFerie());

function renderTabellaFerie(action) {
  if (action == "rimuovi") {
    setTimeout(
      () => { },

      1000
    );
    $("#tableFerie").html("Rimosso!");
  } else {
    $("#tableFerie").html("Attendi...");
  }

  setTimeout(() => { }, 3000);
  $("#tableFerie").load("./tabellaferie.php", () => {
    $("#datatable-2").DataTable(DataTableOptions);
    sendWithEnter();
  });
  $("#tableFerie2").load("./tabellaferieurgenti.php", () => {
    $("#datatable-3").DataTable(DataTableOptions3);
    sendWithEnter();
  });
  $("#tableFerie3").load("./tabellapermessi.php", () => {
    $("#datatable-4").DataTable(DataTableOptions4);
    sendWithEnter();
  });
}


function nuovoPermesso() {

  const natura = $("#natura").val();
  const inizio = $("#inputInizio").val();
  const fine = $("#inputFine").val();
  var urgente = "0";
  if ($("#urgente").is(":checked")) {
    urgente = "1";
  }
  console.log(urgente)

  $.post(
    "../api/nuoveferie.php",
    {
      inizio: inizio,
      fine: fine,
      urgente: urgente,
      natura : natura
    },
    function (data) {
      console.log(data)
      renderTabellaFerie();
      if (data == 'successo') {
        Swal.fire(
          'Richiesta inviata',
          'Ora attendi la risposta di un amministratore',
          'success'
        )
      } else if (data == 'err_ferie_exist') {
        Swal.fire(
          'Errore',
          'Le ferie/permessi che hai richiesto si incrociano già con altre ferie/permessi',
          'error'
        )
      } else {
        Swal.fire(
          'Errore',
          "C'è stato un'errore nel richiedere le ferie",
          'error'
        )

      }
    }
  );
};

function nuoveFerie() {

  const natura = $("#natura").val();
  const inizio = $("#inputInizio2").val();
  const fine = $("#inputFine2").val();
  var urgente = "0";

  $.post(
    "../api/nuoveferie.php",
    {
      inizio: inizio +  ' ' + '00:00:00',
      fine: fine+  ' ' + '23:59:00',
      urgente: 0,
      natura: 0
    },
    function (data) {
      console.log(data)
      renderTabellaFerie();
      if (data == 'successo') {
        Swal.fire(
          'Richiesta ferie inviata',
          'Ora attendi la risposta di un amministratore',
          'success'
        )
      } else if (data == 'err_ferie_exist') {
        Swal.fire(
          'Errore',
          'Le ferie/permessi che hai richiesto si incrociano già con altre ferie/permessi',
          'error'
        )
      } else {
        Swal.fire(
          'Errore',
          "C'è stato un'errore nel richiedere le ferie",
          'error'
        )

      }
    }
  );
};



function handleModificaFerie(el, id) {
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
      console.log('id: ' + id + '   campo: ' + valueToChange + '   valore NEW:' + newValue)
      modificaFerie(id, valueToChange, newValue);
      return;
    }
  }
};

function modificaFerie(id, valoreDaAggiornare, valoreAggiornato) {
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
        renderTabellaFerie()
        Swal.fire('Successo!', 'Il campo è stato aggiornato!', 'success');
      } else if (data == "errore") {
        Swal.fire('Attenzione!', 'Esiste già una sede a ' + valoreDaAggiornare.toLowerCase() + '.', 'error');
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

const eliminaFerie = (codice) => {
  console.log("id: " + codice)
  Swal.fire({
    title: "Sei sicuro?",
    text: "Vuoi veramente eliminare questa richiesta?",
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
          tipo: "ferie"
        },
        function (data) {
          console.log(data)
          if (data == "successo") {
            renderTabellaFerie("rimuovi");
            // Swal.fire('Successo!', 'La sede è stata disattivata!', 'success');
            return;
          }
          if (data == "err_disattiva") {
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

        if (valueToChange == "submitnuoveFerie") {
          nuoveFerie()
        }
        console.log("id: " + id + "  valueToChange: " + valueToChange + " newValue: " + newValue)
        modificaFerie(id, valueToChange, newValue);
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
    modificaFerie(id, "Tipologia", newValue);
  }
};

const attivaFerie = (nome, codice) => {
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
          tipo: "ferie"
        },
        function (data) {
          console.log(data)
          if (data == "successo") {
            renderTabellaFerie();
            // Swal.fire('Successo!', 'La sede è stata disattivata!', 'success');
            return;
          }
          if (data == "err_disattiva") {
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



function getDateTime() {
  var now = new Date();
  var year = now.getFullYear();
  var month = now.getMonth() + 1;
  var day = now.getDate();
  var hour = now.getHours();
  var minute = now.getMinutes();
  var second = now.getSeconds();
  if (month.toString().length == 1) {
    month = '0' + month;
  }
  if (day.toString().length == 1) {
    day = '0' + day;
  }
  if (hour.toString().length == 1) {
    hour = '0' + hour;
  }
  if (minute.toString().length == 1) {
    minute = '0' + minute;
  }
  if (second.toString().length == 1) {
    second = '0' + second;
  }
  var dateTime = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
  return dateTime;
}

function getOnlyDate(date) {
  var date = new Date(date);
  var year = date.getFullYear();
  var month = date.getMonth();
  var day = date.getDate();
  var date = year + '-' + month + '-' + day;
  return date;
}

// datetime picker
var today = new Date();
var minDate = getDateTime();
var inizioFerie = minDate;
var fineFerie = minDate;
var preavvisoferie = "0";
// $('#inizioFerie').datetimepicker({
//   useCurrent: false,
//   format: "yyyy-mm-dd hh:ii:ss"
// });
// $('#fineFerie').datetimepicker({
//   useCurrent: false,
//   format: "yyyy-mm-dd hh:ii:ss",
// });

$("#urgente").on("change", () => {
  preavvisoferie = $("#preavvisoferie").val();
  $("#richiedi-ferie").attr("disabled", "disabled");
  if (!$("#urgente").is(":checked")) {
    $("#inputInizio").val("");
    $("#inputFine").val("");
  }
})

// INIZIO PERMESSO
$("#inizioFerie").on("change", () => {
  preavvisoferie = $("#preavvisoferie").val();
  if ($("#urgente").is(":checked")) {
    preavvisoferie = "0"
    $("#richiedi-ferie").attr("disabled", "disabled");
  } else {
    preavvisoferie = $("#preavvisoferie").val();
  }

  inizioFerie = $("#inputInizio").val();

  console.log("inizio Ferie: " + addDays(inizioFerie, 0));
  console.log("preavviso: " + JSON.stringify(preavvisoferie));


  function addDays(theDate, days) {
    date = new Date(theDate)
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate()  + parseInt(days);
    // date.setDate(date.getDate() + parseInt(days));
    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = date.getSeconds();
    if (month.toString().length == 1) {
      month = '0' + month;
    }
    if (day.toString().length == 1) {
      day = '0' + day;
    }
    if (hour.toString().length == 1) {
      hour = '0' + hour;
    }
    if (minute.toString().length == 1) {
      minute = '0' + minute;
    }
    if (second.toString().length == 1) {
      second = '0' + second;
    }
    var addedDaysData = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
    return addedDaysData;

  }

  console.log("fine: " + getDateTime() + " addDays" + addDays(inizioFerie, preavvisoferie))

  //check se è una data già passata
  if (inizioFerie < (minDate + preavvisoferie)) {
    Swal.fire('Ops!', "La data selezionata corrisponde ad una data/ora già passata!", 'error');
    $("#inputInizio").val("");
    return;
  }

  //check del preavviso ferie
  if (addDays(inizioFerie, 0) <= addDays(getDateTime(), preavvisoferie)) {
    Swal.fire('Ops!', "Il tuo preavviso per ferie e/o permessi è di minimo " + preavvisoferie + " giorni/o.", 'error');
    $("#inputInizio").val("");
    return;
  }

  //check se la data di fine è precedente a quella d'inizio
  if (inizioFerie >= fineFerie && $("#inputFine").val() != "") {
    Swal.fire('Ops!', "La data/ora di fine è precedente a quella d'inizio!", 'error');
    $("#inputFine").val("");
    return;
  }
})

// RICHIESTA FERIE
$("#inizioFerie2").on("change", () => {
  preavvisoferie = $("#preavvisoferie2").val();
  if ($("#urgente").is(":checked")) {
    preavvisoferie = "0"
    $("#richiedi-ferie2").attr("disabled", "disabled");
  } else {
    preavvisoferie = $("#preavvisoferie2").val();
  }

  inizioFerie = $("#inputInizio2").val();

  console.log("inizio Ferie: " + addDays(inizioFerie, 0));
  console.log("preavviso: " + JSON.stringify(preavvisoferie));


  function addDays(theDate, days) {
    date = new Date(theDate)
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    date.setDate(date.getDate() + parseInt(days));
    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = date.getSeconds();
    if (month.toString().length == 1) {
      month = '0' + month;
    }
    // if (day.toString().length == 1) {
    //   day = '0' + day;
    // }
    if (hour.toString().length == 1) {
      hour = '0' + hour;
    }
    if (minute.toString().length == 1) {
      minute = '0' + minute;
    }
    if (second.toString().length == 1) {
      second = '0' + second;
    }
    var addedDaysData = year + '-' + month + '-' + date.getDate() + ' ' + hour + ':' + minute + ':' + second;
    return addedDaysData;

  }

  console.log("fine: " + getDateTime() + " addDays" + addDays(inizioFerie, preavvisoferie))

  //check se è una data già passata
  if (inizioFerie < (minDate + preavvisoferie)) {
    Swal.fire('Ops!', "La data selezionata corrisponde ad una data/ora già passata!", 'error');
    $("#inputInizio").val("");
    return;
  }

  //check del preavviso ferie
  if (addDays(inizioFerie, 0) <= addDays(getDateTime(), preavvisoferie)) {
    Swal.fire('Ops!', "Il tuo preavviso per ferie e/o permessi è di minimo " + preavvisoferie + " giorni/o.", 'error');
    $("#inputInizio").val("");
    return;
  }

  //check se la data di fine è precedente a quella d'inizio
  if (inizioFerie >= fineFerie && $("#inputFine").val() != "") {
    Swal.fire('Ops!', "La data/ora di fine è precedente a quella d'inizio!", 'error');
    $("#inputFine").val("");
    return;
  }
})

// FINE PERMESSO
$("#fineFerie").on("change", () => {
  fineFerie = $("#inputFine").val();

  if (inizioFerie == (minDate + preavvisoferie)) {
    Swal.fire('Ops!', "Seleziona prima la data/ora di inizio!", 'error');
    $("#inputFine").val("");
    return;
  }
  if (inizioFerie >= fineFerie) {
    Swal.fire('Ops!', "La data/ora di fine è precedente a quella d'inizio!", 'error');
    $("#inputFine").val("");
    return;
  }
  // check se la data dei due giorni è uguale
  if(getOnlyDate(inizioFerie) != getOnlyDate(fineFerie)) {
    Swal.fire('Ops!', "La data/ora di fine è diversa da quella d'inizio!", 'error');
    $("#inputFine").val("");
    return;
  }

  $("#richiedi-ferie").removeAttr("disabled")
  console.log("fine Ferie: " + fineFerie);
})

// FINE FERIE
$("#fineFerie2").on("change", () => {
  fineFerie = $("#inputFine2").val();

  if (inizioFerie == (minDate + preavvisoferie)) {
    Swal.fire('Ops!', "Seleziona prima la data/ora di inizio!", 'error');
    $("#inputFine2").val("");
    return;
  }
  if (inizioFerie >= fineFerie) {
    Swal.fire('Ops!', "La data/ora di fine è precedente a quella d'inizio!", 'error');
    $("#inputFine2").val("");
    return;
  }

  $("#richiedi-ferie2").removeAttr("disabled")
  console.log("fine Ferie: " + fineFerie);
})


function scalcolaOre(id) {
  $.post(
    "./api/scalcola.php",
    {
      id: id
    }, function (data) {

    }
  )
}

function abbuonaOre(id) {

}

// esportazione dati in EXCEL
function exportTableToExcel(tableID, filename = '') {
  var downloadLink;
  var dataType = 'application/vnd.ms-excel';
  var tableSelect = document.getElementById(tableID);
  var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

  // Specify file name
  filename = filename ? filename + '.xls' : 'excel_data.xls';

  // Create download link element
  downloadLink = document.createElement("a");

  document.body.appendChild(downloadLink);

  if (navigator.msSaveOrOpenBlob) {
    var blob = new Blob(['\ufeff', tableHTML], {
      type: dataType
    });
    navigator.msSaveOrOpenBlob(blob, filename);
  } else {
    // Create a link to the file
    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

    // Setting the file name
    downloadLink.download = filename;

    //triggering the function
    downloadLink.click();
  }
}
//fine esportazione EXCEL

function rinizializza_header() {
  var table = $("#datatable-2").DataTable();
  var table1 = $("#datatable-3").DataTable();
  table.columns.adjust().draw();
  table1.columns.adjust().draw();
}


$("#burger_tasto").click(function () {
  setTimeout(rinizializza_header, 200);
});

$(document).ready(function () {
  renderTabellaFerie();
});


