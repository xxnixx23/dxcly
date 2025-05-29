$(document).ready(function () {
  fetchData();
});

function fetchData() {
  //users
  let usersReq = new XMLHttpRequest();

  usersReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let users = JSON.parse(this.responseText);

      let totalUsers = users.length;

      $("#users").text(totalUsers);
    }
  };

  usersReq.open("GET", "api/users/fetch.php", true);
  usersReq.send();

  //orders & sales
  let ordersReq = new XMLHttpRequest();

  ordersReq.onreadystatechange = async function () {
    if (this.readyState == 4 && this.status == 200) {
      let orders = JSON.parse(this.responseText);

      let numberOfOrders = orders.length;

      $("#orders").text(numberOfOrders);

      sales = getSales(orders);

      $("#date").on("change", () => {
        getSalesByDate(sales);
      });
    }
  };

  ordersReq.open("GET", "api/carts/fetch_sales.php", true);
  ordersReq.send();
}

function getSalesByDate(sales) {
  // Create an empty array to store the sales
  let salesArray = [];

  // Iterate over the sales object and push each sale into the array
  for (let sale in sales) {
    salesArray.push(sales[sale]);
  }

  let date = new Date($("#date").val());

  // Get the year and month from the date
  let year = new Date(date).getFullYear();
  let month = new Date(date).getMonth() + 1; // Months are zero-based

  // Filter the sales array to get sales for the selected month
  let monthlySales = salesArray
    .filter((sale) => {
      let saleYear = new Date(sale.date).getFullYear();
      let saleMonth = new Date(sale.date).getMonth() + 1;
      return saleYear === year && saleMonth === month;
    })
    .map((sale) => sale.income);

  // Calculate the total income for the month
  let totalMonthlyIncome = monthlySales.reduce(
    (total, income) => total + income,
    0
  );

  // Filter the sales array to get sales for the selected day
  let dailySales = salesArray
    .filter((sale) => {
      let saleYear = new Date(sale.date).getFullYear();
      let saleMonth = new Date(sale.date).getMonth() + 1;
      let saleDay = new Date(sale.date).getDate();
      return (
        saleYear === year &&
        saleMonth === month &&
        saleDay === new Date(date).getDate()
      );
    })
    .map((sale) => sale.income);

  // Calculate the total income for the day
  let totalDailyIncome = dailySales.reduce(
    (total, income) => total + income,
    0
  );

  // Display the results
  $("#monthly-sales").text("₱ " + totalMonthlyIncome.toLocaleString("en-US"));
  $("#daily-sales").text("₱ " + totalDailyIncome.toLocaleString("en-US"));
}

function getSales(orders) {
  let sales = orders.map((order) => ({
    income: 0,
    date: order.received_date,
  }));

  orders.forEach((order, index) => {
    let productReq = new XMLHttpRequest();

    productReq.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let product = JSON.parse(this.responseText);

        let productPrice = product.price;

        sales[index].income = order.cart_quantity * productPrice;
      }
    };

    productReq.open("POST", "api/products/fetch_id.php");
    productReq.send(JSON.stringify({ id: order.product_id }));
  });

  return sales;
}

function monthlySales(sales) {}
