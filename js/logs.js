$(document).ready(function () {
  $(".dashboard-container").hide();

  fetchLogs();
});

let logs = [];

function fetchLogs() {
  let logsReq = new XMLHttpRequest();
  logsReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      logs = JSON.parse(this.responseText);

      displayLogs();
    }
  };

  logsReq.open("GET", "api/logs/fetch.php", true);
  logsReq.send();
}

function downloadPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  let date = $("#date").val();
  const selectedDate = new Date(date);

  // Calculate the margin for the image
  const imageMargin = 10;

  // Calculate the width and height of the image
  const imageWidth = 50;
  const imageHeight = 20;

  // Calculate the x and y positions for the image
  const imageX = (doc.internal.pageSize.width - imageWidth) / 2;
  const imageY = 10 + (imageHeight - imageMargin) / 2;

  doc.addImage(
    "assets/logo.png",
    "PNG",
    imageX,
    imageY,
    imageWidth,
    imageHeight
  );

  // Add a margin between the table and the image
  const tableMargin = 10;

  // Calculate the y position for the header
  const headerY = imageY + imageHeight + tableMargin;

  // Set the font size and style for the header
  doc.setFontSize(16);
  doc.setFont("helvetica", "bold");

  // Calculate the width of the header text
  const headerTextWidth = doc.getTextWidth("Logs Reports");

  // Calculate the x position for the header to center it
  const headerX = (doc.internal.pageSize.width - headerTextWidth) / 2;

  // Add the header text
  doc.text("Logs Reports", headerX, headerY);

  // Calculate the y position for the date
  const dateY = headerY + 10;

  // Set the font size and style for the date
  doc.setFontSize(12);
  doc.setFont("helvetica", "normal");

  // Add the selected date below the header, centered and smaller
  if (date) {
    const dateText = `${selectedDate.toLocaleDateString()}`;
    const dateTextWidth = doc.getTextWidth(dateText);
    const dateX = (doc.internal.pageSize.width - dateTextWidth) / 2;
    doc.text(dateText, dateX, dateY);
  }

  $("#logs-body tr").show();

  // Calculate the x and y position for the total sales
  doc.autoTable({
    html: "#logs-table",
    startY: dateY + 10, // Add a margin below the header
    headStyles: { fillColor: [0, 0, 0] },
  });

  if (date) {
    doc.save(
      `Monthly and Yearly Logs Reports (${
        selectedDate.getMonth() + 1
      }-${selectedDate.getFullYear()}).pdf`
    );
  } else {
    doc.save("Overall Logs Reports.pdf");
  }

  // Restore pagination
  $("#logs-body tr").slice(6).hide();
  $("#pagination").pagination("redraw");
}

function displayLogs() {
  $("#logs-body").empty();

  let searchVal = $("#search").val().toLowerCase();

  let filterTerm = $("#filter").val();

  let date = $("#date").val();
  const selectedDate = new Date(date);

  let results = 0;
  logs.forEach((log) => {
    const logDate = new Date(log.log_date);

    if (log.user_name.toLowerCase().includes(searchVal) || !searchVal) {
      if (filterTerm == log.action || !filterTerm) {
        if (
          (logDate.getMonth() === selectedDate.getMonth() &&
            logDate.getFullYear() === selectedDate.getFullYear()) ||
          !date
        ) {
          let logsTableRow = $("<tr></tr>");
          logsTableRow.append($("<td></td>").text(log.id));
          logsTableRow.append($("<td></td>").text(log.user_id));
          logsTableRow.append($("<td></td>").text(log.user_name));
          logsTableRow.append($("<td></td>").text(log.action));
          logsTableRow.append($("<td></td>").text(log.log_date));

          $("#logs-body").append(logsTableRow);
          results++;
        }
      }
    }
  });

  $("#logs-body tr").slice(6).hide();
  $("#pagination").pagination({
    items: results,
    itemsOnPage: 6,
    cssStyle: "dark-theme",
    onPageClick: function (pageNumber) {
      $("#logs-body tr").hide();
      $("#logs-body tr")
        .slice((pageNumber - 1) * 6, pageNumber * 6)
        .show();
    },
  });
}
