
// function modificaMisurazioni(idMis) {
//   $.get("./dettagli_misurazioni.php",
//     { idMis: idMis }
//   )
//   location.href = "./dettagli_misurazioni.php";
// }
const DataTableOptions = {
  scrollX: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Italian.json",
  },
  pageLength: 50,
};

const handleModificaMisurazione = (el, codice) => {
  if (el.previousElementSibling.hasAttribute("disabled")) {
    el.previousElementSibling.toggleAttribute("disabled");
    el.children[0].classList.remove("fa-edit");
    el.children[0].classList.add("fa-check");
    return;
  } else {
    const newValue = el.previousElementSibling.value;
    if (newValue.trim() == "") {
      Swal.fire('Non valido!', 'Il campo non può essere vuoto.', 'error')
    } else {
      const valueToChange = el.previousElementSibling.name;
      modificaMisurazione(codice, valueToChange, newValue);
      return;
    }
  }
};

const modificaMisurazione = (codice, valoreDaAggiornare, valoreAggiornato) => {
  $.post(
    "../api/modificaMisurazione.php",
    {
      codice: codice,
      valoreDaAggiornare: valoreDaAggiornare,
      valoreAggiornato: valoreAggiornato.trim(),
    },
    function (data) {
      data == '"successo"' ? renderTabellaClienti() : Swal.fire('Ops', 'Qualcosa è andato storto :/ riprova!', 'error');
    }
  );
};

const eliminaMisurazione = (id_misurazione) => {

  Swal.fire({
    title: 'Sei sicuro?',
    text: "Questa azione sarà irreversibile!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, cancella!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "../api/eliminamisurazione.php",
        {
          id_misurazione: id_misurazione
        },
        function(data) {
          if(data == 'successo') { Swal.fire('Eliminata', 'La misurazione è stata elminata!', 'success')
        }else{
          Swal.fire('Ops', 'Qualcosa è andato storto :/ riprova!', 'error');}
        }
        )
        setTimeout(location.reload(), 6000);
      
    }
  })


}

$(document).ready(function() {
  $("#datatable-2").DataTable({
      order: [
          [0, "asc"]
      ],
      pageLength: 25,
      orderCellsTop: true,
      //fixedHeader: true,
      scrollX: true
  })
});