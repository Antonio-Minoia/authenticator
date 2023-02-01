const tableBody = document.querySelector("#tBody");
const form = document.querySelector("form");
// const sendButtonSedi = document.querySelector("#sendButtonSedi");

const DataTableOptions = {
  scrollX: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Italian.json",
  },
  pageLength: 50,
};

function renderTabellaOrari(action) {
  if (action == "rimuovi") {
    setTimeout(
      () => { },

      1000
    );
    $("#tableOrari").html("Rimosso!");
  } else {
    $("#tableOrari").html("Attendi...");
  }

  setTimeout(() => { }, 3000);
  $("#tableOrari").load("./tabellaorari.php", () => {
    $("#datatable-2").DataTable(DataTableOptions);
    sendWithEnter();
  });
}

function rinizializza_header() {
  var table = $("#datatable-2").DataTable();
  table.columns.adjust().draw();
}

$("#burger_tasto").click(function () {
  setTimeout(rinizializza_header, 200);
});



$(document).ready(function () {
  renderTabellaOrari();
});
