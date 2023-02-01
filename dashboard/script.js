$(document).ready(function () {
  $("#tabella_ordini").DataTable({
    scrollX: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Italian.json",
    },
    pageLength: 50,
  });
});
