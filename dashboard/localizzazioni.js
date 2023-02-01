const tableBody = document.querySelector("#tBody");
const form = document.querySelector("form");
// const sendButtonSedi = document.querySelector("#sendButtonSedi");

const DataTableOptions = {
  order: [[3, 'asc']],
  // scrollX: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Italian.json",
  },
  pageLength: 50,
};

function renderTabellaOrari(action) {
  // console.log(month)
  if (action == "rimuovi") {
    
    $("#tableOrari").html("Seleziona una data!");
  } else {
      $("#datatable-posizioni").DataTable();
      sendWithEnter();
    }
}

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

function rinizializza_header() {
  var table = $("#datatable-posizioni").DataTable();
  table.columns.adjust().draw();
}

$("#burger_tasto").click(function () {
  setTimeout(rinizializza_header, 200);
});


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

// esportazione dati in EXCEL
function exportTableToExcel(tableID, filename = ''){
  var downloadLink;
  var dataType = 'application/vnd.ms-excel';
  var tableSelect = document.getElementById(tableID);
  var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
  
  // Specify file name
  filename = filename?filename+'.xls':'excel_data.xls';
  
  // Create download link element
  downloadLink = document.createElement("a");
  
  document.body.appendChild(downloadLink);
  
  if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
          type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
  }else{
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
  
      // Setting the file name
      downloadLink.download = filename;
      
      //triggering the function
      downloadLink.click();
  }
}
//fine esportazione EXCEL
$.noConflict();

$(document).ready(function () {
  $("#datatable-posizioni").DataTable();
  // renderTabellaOrari();
});
