const tableBody = document.querySelector("#tBody");
const form = document.querySelector("form");
const sendButtonOperatori = document.querySelector("#sendButtonOperatori");

const DataTableOptions = {
  scrollX: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Italian.json",
  },
  pageLength: 50,
};


function nuovoOperatore() {

  const cognome = $("#cognome2").val();
  const nome = $("#nome2").val();
  const user = $("#user2").val();
  const pass = $("#pass2").val();
  const tipo = $("#tipologia2").val();
  const sede = $("#sede2").val();
  const qrvisibilita = $("#qrvisibilita2").val();
  const preavviso = $("#preavviso2").val();
  const tolleranza = $("#tolleranza2").val();
  console.log("tolleranza:" + tolleranza)
  let l1 = "0", l2 = "0", l3 = "0", l4 = "0", m1 = "0", m2 = "0", m3 = "0", m4 = "0", w1 = "0", w2 = "0", w3 = "0", w4 = "0", g1 = "0", g2 = "0", g3 = "0", g4 = "0", v1 = "0", v2 = "0", v3 = "0", v4 = "0", s1 = "0", s2 = "0", s3 = "0", s4 = "0", d1 = "0", d2 = "0", d3 = "0", d4 = "0";


  if ($("#11").val() !== undefined) { l1 = $("#11").val(); };
  if ($("#12").val() !== undefined) { l2 = $("#12").val() };
  if ($("#13").val() !== undefined) { l3 = $("#13").val() };
  if ($("#14").val() !== undefined) { l4 = $("#14").val() };

  if ($("#21").val() !== undefined) { m1 = $("#21").val() };
  if ($("#22").val() !== undefined) { m2 = $("#22").val() };
  if ($("#23").val() !== undefined) { m3 = $("#23").val() };
  if ($("#24").val() !== undefined) { m4 = $("#24").val() };

  if ($("#31").val() !== undefined) { w1 = $("#31").val() };
  if ($("#32").val() !== undefined) { w2 = $("#32").val() };
  if ($("#33").val() !== undefined) { w3 = $("#33").val() };
  if ($("#34").val() !== undefined) { w4 = $("#34").val() };

  if ($("#41").val() !== undefined) { g1 = $("#41").val() };
  if ($("#42").val() !== undefined) { g2 = $("#42").val() };
  if ($("#43").val() !== undefined) { g3 = $("#43").val() };
  if ($("#44").val() !== undefined) { g4 = $("#44").val() };

  if ($("#51").val() !== undefined) { v1 = $("#51").val() };
  if ($("#52").val() !== undefined) { v2 = $("#52").val() };
  if ($("#53").val() !== undefined) { v3 = $("#53").val() };
  if ($("#54").val() !== undefined) { v4 = $("#54").val() };

  if ($("#61").val() !== undefined) { s1 = $("#61").val() };
  if ($("#62").val() !== undefined) { s2 = $("#62").val() };
  if ($("#63").val() !== undefined) { s3 = $("#63").val() };
  if ($("#64").val() !== undefined) { s4 = $("#64").val() };

  if ($("#71").val() !== undefined) { d1 = $("#71").val() };
  if ($("#72").val() !== undefined) { d2 = $("#72").val() };
  if ($("#73").val() !== undefined) { d3 = $("#73").val() };
  if ($("#74").val() !== undefined) { d4 = $("#74").val() };

  console.log(l1 + l2 + l3 + l4 + m1 + m2 + m3 + m4 + w1 + w2 + w3 + w4 + g1 + g2 + g3 + g4 + v1 + v2 + v3 + v4 + s1 + s2 + s3 + s4 + d1 + d2 + d3 + d4)

  $.post(
    "../api/nuovooperatore.php",
    {
      cognome: cognome,
      nome: nome,
      user: user,
      pass: pass,
      sede: sede,
      tipo: tipo,
      qrvisibilita: qrvisibilita,
      preavviso: preavviso,
      tolleranza: tolleranza,
      l1: l1,
      l2: l2,
      l3: l3,
      l4: l4,

      m1: m1,
      m2: m2,
      m3: m3,
      m4: m4,

      w1: w1,
      w2: w2,
      w3: w3,
      w4: w4,

      g1: g1,
      g2: g2,
      g3: g3,
      g4: g4,

      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4,

      s1: s1,
      s2: s2,
      s3: s3,
      s4: s4,

      d1: d1,
      d2: d2,
      d3: d3,
      d4: d4,
    },
    function (data) {
      console.log(data)
      renderTabellaOperatori();
      if (data == 'successo') {
        Swal.fire(
          'Account aggiunto',
          'Un nuovo account è stato aggiunto',
          'success'
        )
      }
    }
  );
};

// function buttonModificaOperatore(id) {
//   $('#modalModifyOperatore').modal('show');
// }
function check(el, id) {
  Swal.fire({
    title: 'Sei sicuro di voler resettare questo campo?',
    icon: 'warning',
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: 'Si, resetta',
    cancelButtonText: `No, annulla`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      handleModificaOperatore(el, id)
    } else if (result.isDenied) {
      return
    }
  })
}

function handleModificaOperatore(el, id) {
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
    if (newValue.trim() == "" && input.name != "idsm" && input.name != "idpc") {
      Swal.fire('Non valido!', 'Il campo non può essere vuoto.', 'error')
    } else {
      const valueToChange = input.name;
      console.log('id: ' + id + '   campo: ' + valueToChange + '   valore NEW:' + newValue)
      modificaOperatore(id, valueToChange, newValue);
      return;
    }
  }
};

function modificaOperatore(id, valoreDaAggiornare, valoreAggiornato) {
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
        // renderTabellaOperatori()
        Swal.fire('Successo!', 'Il campo è stato aggiornato!', 'success');
      } else if (data == "errore") {
        Swal.fire('Attenzione!', 'Esiste già un utente con ' + valoreDaAggiornare.toLowerCase() + ' uguale.', 'error');
      } else if (data == "err_ins_agg") {
        Swal.fire('Ops!', 'Qualcosa è andato storto, riprova.', 'error');
      } else if (data == "err_ins") {
        Swal.fire('Ops!', "Errore nell'aggiornare il dato, riprova.", 'error');
      } else if (data == "err_ins_pw") {
        Swal.fire('Ops!', "Errore nell'aggiornare la password, riprova.", 'error');
      } else if (data == "err_ins_idsm") {
        Swal.fire('Ops!', "Errore nel resettare l'id, riprova.", 'error');
      }
    }
  );
};

const eliminaOperatore = (nome, codice) => {
  console.log(nome + codice)
  Swal.fire({
    title: "Sei sicuro?",
    text: "Vuoi veramente disattivare l'operatore " + nome,
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
          tipo: "operatore"
        },

        function (data) {
          if (data == "successo") {
            renderTabellaOperatori("rimuovi");
            // Swal.fire('Successo!', "L'operatore è stato disattivato!", 'success');
            return;
          }
          if (data == "err_disattiva") {
            Swal.fire('Ops!', "Errore nel disattivare l'operatore, riprova.", 'error');
            return;
          } else {
            Swal.fire('Ops!', "Errore nel disattivare l'operatore, riprova. Err_in_elimina.php", 'error');
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
        modificaOperatore(id, valueToChange, newValue);
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
    modificaOperatore(id, "Tipologia", newValue);
  }
};

const attivaOperatore = (nome, codice) => {
  Swal.fire({
    title: "Sei sicuro?",
    text: "Vuoi veramente attivare l'operatore " + nome,
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "../api/attiva.php",
        {
          id: codice,
          tipo: "operatore"
        },
        function (data) {
          if (data == "successo") {
            renderTabellaOperatori();
            // Swal.fire('Successo!', "L'operatore è stato disattivat!", 'success');
            return;
          }
          if (data == "err_disattiva") {
            Swal.fire('Ops!', "Errore nel disattivare l'operatore, riprova.", 'error');
            return;
          } else {
            Swal.fire('Ops!', "Errore nel disattivare l'operatore, riprova. Err_in_elimina.php", 'error');
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

function autofilldatas(value1, value2, value3, value4) {
  $("#21").val(value1)
  $("#31").val(value1)
  $("#41").val(value1)
  $("#51").val(value1)
  $("#61").val(value1)

  $("#22").val(value2)
  $("#32").val(value2)
  $("#42").val(value2)
  $("#52").val(value2)
  $("#62").val(value2)

  $("#23").val(value3)
  $("#33").val(value3)
  $("#43").val(value3)
  $("#53").val(value3)


  $("#24").val(value4)
  $("#34").val(value4)
  $("#44").val(value4)
  $("#54").val(value4)
}

$("#14").on("change", () => {

  value1 = $("#11").val()
  value2 = $("#12").val()
  value3 = $("#13").val()
  value4 = $("#14").val()


  autofilldatas(value1, value2, value3, value4)
  console.log(value1 + " " + value2 + " " + value3 + " " + value4)
  console.log($('#71').val())

})
// formNewOperatore.addEventListener(, handleInput);



$(document).ready(function () {
  // renderTabellaOperatori();
  // Swal.fire({
  //   icon: 'info',
  //   title: "Per visualizzare le proprie modifiche, l'utente modificato dovrà uscire dal suo account e rieffettuare il login",
  //   showConfirmButton: false,
  // })


  // $('.add').click(function () {
  //   $(".list").append(
  //     '<div class="mb-2 row justify-content-between px-3 mt-4">' +
  //     '<select class="mob mb-2 form-control">' +
  //     '<option value="opt1">Mon-Fri</option>' +
  //     '<option value="opt2">Sat-Sun</option>' +
  //     '</select>' +
  //     '<div class="mob ">' +
  //     '<label class="text-grey mr-1">From</label>' +
  //     '<input class="ml-1 form-control" type="time" name="from">' +
  //     '</div>' +
  //     '<div class="mob mb-2">' +
  //     '<label class="text-grey mr-4">To</label>' +
  //     '<input class="ml-1 form-control" type="time" name="to">' +
  //     '</div>' +
  //     '<div class="mt-1 cancel fa fa-times text-danger">' +
  //     '</div>' +
  //     '</div>');
  // });

  // $(".list").on('click', '.cancel', function () {
  //   $(this).parent().remove();
  // });


});
