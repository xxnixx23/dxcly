$(document).ready(function () {
  $(".dashboard-container").hide();

  fetchOrders();
});

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
  const headerTextWidth = doc.getTextWidth("Sales / Orders Report");

  // Calculate the x position for the header to center it
  const headerX = (doc.internal.pageSize.width - headerTextWidth) / 2;

  // Add the header text
  doc.text("Sales / Orders Report", headerX, headerY);

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

  $("#orders-body tr").show();

  // Calculate the x and y position for the total sales
  doc.autoTable({
    html: "#orders-table",
    startY: dateY + 10, // Add a margin below the header
    headStyles: { fillColor: [0, 0, 0] },
  });

  let totalSalesText =
    "Total Sales: " + totalSales.toLocaleString("en-US") + " pesos";

  doc.autoTable({
    body: [[totalSalesText]],
    bodyStyles: {
      fillColor: [214, 202, 232],
      textColor: 0,
    },
    startY: doc.lastAutoTable.finalY + 10, // Add a margin below the table
  });

  if (date) {
    doc.save(
      `Monthly and Yearly Sales/Orders Reports (${
        selectedDate.getMonth() + 1
      }-${selectedDate.getFullYear()}).pdf`
    );
  } else {
    doc.save("Overall Sales/Orders Reports.pdf");
  }

  // Restore pagination
  $("#orders-body tr").slice(8).hide();
  $("#pagination").pagination("redraw");
}

let orderObjects = [];

function fetchOrders() {
  let orderReq = new XMLHttpRequest();

  orderReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let orders = JSON.parse(this.responseText);

      //create a new array of order objects
      orderObjects = orders.map((order) => ({
        id: order.cart_id,
        full_name: "",
        product_name: "",
        product_price: 0,
        quantity: order.cart_quantity,
        status: order.status,
        total_price: 0,
        date: order.received_date,
      }));

      let fullName;
      orders.forEach((order, index) => {
        let buyerReq = new XMLHttpRequest();

        buyerReq.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            let buyer = JSON.parse(this.responseText);

            orderObjects[index].full_name = buyer.full_name;

            let productReq = new XMLHttpRequest();

            productReq.onreadystatechange = function () {
              if (this.readyState == 4 && this.status == 200) {
                let product = JSON.parse(this.responseText);

                orderObjects[index].product_name = product.name;
                orderObjects[index].product_price = product.price;
                orderObjects[index].total_price =
                  product.price * order.cart_quantity;

                displayOrders();
              }
            };

            productReq.open("POST", "api/products/fetch_id.php", true);
            productReq.send(JSON.stringify({ id: order.product_id }));
          }
        };

        buyerReq.open("POST", "api/users/fetch_id.php", true);
        buyerReq.send(JSON.stringify({ id: order.user_id }));
      });
    }
  };

  orderReq.open("GET", "api/carts/fetch_all_orders.php", true);
  orderReq.send();
}

let totalSales;

function displayOrders() {
  $("#orders-body").empty();

  totalSales = 0;

  let searchVal = $("#search").val().toLowerCase();

  let filterTerm = $("#filter").val();

  let date = $("#date").val();
  const selectedDate = new Date(date);

  let results = 0;

  orderObjects.forEach((order) => {
    const orderDate = new Date(order.date);

    if (
      order.full_name.toLowerCase().includes(searchVal) ||
      order.product_name.toLowerCase().includes(searchVal) ||
      !searchVal
    ) {
      if (filterTerm == order.status || !filterTerm) {
        if (
          (orderDate.getMonth() === selectedDate.getMonth() &&
            orderDate.getFullYear() === selectedDate.getFullYear()) ||
          !date
        ) {
          if (order.status == "Completed") totalSales += order.total_price;

          let orderTableRow = $("<tr></tr>");
          orderTableRow.append($("<td></td>").text(order.id));
          orderTableRow.append($("<td></td>").text(order.full_name));
          orderTableRow.append($("<td></td>").text(order.product_name));
          orderTableRow.append($("<td></td>").text(order.product_price));
          orderTableRow.append($("<td></td>").text(order.quantity));
          orderTableRow.append($("<td></td>").text(order.total_price));
          orderTableRow.append($("<td></td>").text(order.status));
          $("#orders-body").append(orderTableRow);

          results++;
        }
      }
    }
  });

  $("#orders-body tr").slice(8).hide();
  $("#pagination").pagination({
    items: results,
    itemsOnPage: 8,
    cssStyle: "dark-theme",
    onPageClick: function (pageNumber) {
      $("#orders-body tr").hide();
      $("#orders-body tr")
        .slice((pageNumber - 1) * 8, pageNumber * 8)
        .show();
    },
  });
}
