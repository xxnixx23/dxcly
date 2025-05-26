<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/dashboard.css" />
  <link rel="icon" href="assets/skull.png" sizes="32x32" type="image/png" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>DXCLY: Admin Dashboard</title>

  <style>
   .charts {
  display: flex;
  flex-wrap: nowrap; /* Prevent wrapping to keep them in one row */
  justify-content: space-between;
  gap: 30px;
  margin-top: 40px;
  overflow-x: auto; /* Allows scrolling if screen is too small */
}

.charts canvas {
  flex: 1 1 0;
  min-width: 300px; /* Ensures each chart has a minimum width */
    width: 100% !important;
  max-width: 100%;
  height: 300px !important;
}

  </style>
</head>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <?php
  session_start();
  if (isset($_SESSION['logged_in']) && !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
  }
  if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == "buyer") {
    header("Location: index.php");
    exit();
  }
  ?>

  <?php include 'templates/header_admin.php' ?>

  <div class="container">
    <?php
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
      switch ($page) {
        case 'users':
          include 'templates/users.php';
          break;
        case 'view-products':
          include 'templates/products.php';
          break;
        case 'create-product':
          include 'templates/create-product.php';
          break;
        case 'edit-product':
          include 'templates/edit-product.php';
          break;
           case 'manage-categories': // ⬅️ new page added here
        include 'templates/manage-categories.php';
        break;
        case 'logs':
          include 'templates/logs.php';
          break;
        case 'orders':
          include 'templates/orders.php';
          break;
          
      }
    }
    ?>

   <?php if (!isset($_GET['page'])): ?>
  <div class="dashboard-container">
    <h2>Dashboard</h2>

    <div class="date-container">
      <label for="date">Select Date: </label>
      <input type="date" id="date" name="date" />
    </div>

    <div class="boxes">
      <div class="box">
        <span>Number of Users</span>
        <span id="users">0</span>
      </div>
      <div class="box">
        <span>Monthly Sales</span>
        <span id="monthly-sales">₱ 0</span>
      </div>
      <div class="box">
        <span>Daily Sales</span>
        <span id="daily-sales">₱ 0</span>
      </div>
      <div class="box">
        <span>Completed Orders</span>
        <span id="orders">0</span>
      </div>
    </div>

    <div class="charts">
      <canvas id="lineChart"></canvas>
      <canvas id="barChart"></canvas>
      <canvas id="pieChart"></canvas>
    </div>
  </div>
<?php endif; ?>


  <script>
    // Global cached sales data
    let cachedSales = [];
    let cachedOrders = [];

    $(document).ready(function () {
      // Set default date to today
      const today = new Date().toISOString().split('T')[0];
      $('#date').val(today);

      fetchData();

      // Recalculate sales when date changes
      $("#date").on("change", function () {
        if (cachedSales.length > 0) {
          getSalesByDate(cachedSales);
        }
      });
    });

    function fetchData() {
      // Fetch users count
      let usersReq = new XMLHttpRequest();
      usersReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let users = JSON.parse(this.responseText);
          $("#users").text(users.length);
        }
      };
      usersReq.open("GET", "api/users/fetch.php", true);
      usersReq.send();

      // Fetch orders and compute sales
      let ordersReq = new XMLHttpRequest();
      ordersReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let orders = JSON.parse(this.responseText);
          cachedOrders = orders;
          $("#orders").text(orders.length);
          computeSales(orders);
        }
      };
      ordersReq.open("GET", "api/carts/fetch_sales.php", true);
      ordersReq.send();
    }

    function computeSales(orders) {
      let sales = [];
      let count = 0;

      if (orders.length === 0) {
        cachedSales = [];
        updateSalesDisplay(0, 0);
        renderCharts([], []);
        return;
      }

      orders.forEach((o) => {
        let req = new XMLHttpRequest();
        req.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            let product = JSON.parse(this.responseText);
            sales.push({
              income: o.cart_quantity * product.price,
              date: o.received_date,
              status: o.status,
            });

            count++;
            if (count === orders.length) {
              cachedSales = sales;
              getSalesByDate(sales);
              renderCharts(sales, orders);
            }
          }
        };
        req.open("POST", "api/products/fetch_id.php");
        req.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        req.send(JSON.stringify({ id: o.product_id }));
      });
    }

    function getSalesByDate(sales) {
      let selectedDateStr = $("#date").val();
      if (!selectedDateStr) {
        updateSalesDisplay(0, 0);
        return;
      }
      let selectedDate = new Date(selectedDateStr);
      let y = selectedDate.getFullYear();
      let m = selectedDate.getMonth() + 1;

      let monthly = sales
        .filter((s) => {
          let d = new Date(s.date);
          return d.getFullYear() === y && d.getMonth() + 1 === m;
        })
        .map((s) => s.income);

      let daily = sales
        .filter((s) => {
          let d = new Date(s.date);
          return (
            d.getFullYear() === y &&
            d.getMonth() + 1 === m &&
            d.getDate() === selectedDate.getDate()
          );
        })
        .map((s) => s.income);

      updateSalesDisplay(
        monthly.reduce((a, b) => a + b, 0),
        daily.reduce((a, b) => a + b, 0)
      );
    }

    function updateSalesDisplay(monthlyTotal, dailyTotal) {
      $("#monthly-sales").text("₱ " + monthlyTotal.toLocaleString("en-US"));
      $("#daily-sales").text("₱ " + dailyTotal.toLocaleString("en-US"));
    }

    // Store chart instances to update them properly if needed
    let lineChartInstance, barChartInstance, pieChartInstance;

    function renderCharts(sales, orders) {
  // Clear old charts if exist
  if (lineChartInstance) lineChartInstance.destroy();
  if (barChartInstance) barChartInstance.destroy();
  if (pieChartInstance) pieChartInstance.destroy();

  const lineData = {};
  const barData = {};
  const pieData = { "To Pay": 0, "To Receive": 0, Completed: 0 };

  const today = new Date();
  const currentMonth = today.getMonth();
  const currentYear = today.getFullYear();

  sales.forEach((s) => {
    const d = new Date(s.date);
    const monthKey = `${d.getFullYear()}-${(d.getMonth() + 1).toString().padStart(2, "0")}`;
    const dayKey = `${d.getDate()}`;

    if (d.getMonth() === currentMonth && d.getFullYear() === currentYear) {
      lineData[dayKey] = (lineData[dayKey] || 0) + s.income;
    }

    barData[monthKey] = (barData[monthKey] || 0) + s.income;

    if (s.status && pieData.hasOwnProperty(s.status)) {
      pieData[s.status]++;
    }
  });

  const chartFontOptions = {
    plugins: {
      legend: {
        labels: {
          font: {
            size: 16
          }
        }
      },
      tooltip: {
        bodyFont: {
          size: 14
        },
        titleFont: {
          size: 16
        }
      }
    },
    scales: {
      x: {
        ticks: {
          font: {
            size: 14
          }
        }
      },
      y: {
        ticks: {
          font: {
            size: 14
          }
        }
      }
    },
    responsive: true,
    maintainAspectRatio: false
  };

  const lineCtx = document.getElementById("lineChart").getContext("2d");
  lineChartInstance = new Chart(lineCtx, {
    type: "line",
    data: {
      labels: Object.keys(lineData).map((d) => `Day ${d}`),
      datasets: [{
        label: "Daily Sales",
        data: Object.values(lineData),
        borderColor: "#4e73df",
        tension: 0.4,
        fill: false,
      }],
    },
    options: chartFontOptions,
  });

  const barCtx = document.getElementById("barChart").getContext("2d");
  barChartInstance = new Chart(barCtx, {
    type: "bar",
    data: {
      labels: Object.keys(barData),
      datasets: [{
        label: "Monthly Sales",
        data: Object.values(barData),
        backgroundColor: "#36b9cc",
      }],
    },
    options: chartFontOptions,
  });

  const pieCtx = document.getElementById("pieChart").getContext("2d");
  pieChartInstance = new Chart(pieCtx, {
    type: "pie",
    data: {
      labels: Object.keys(pieData),
      datasets: [{
        label: "Order Status",
        data: Object.values(pieData),
        backgroundColor: ["#ffc107", "#17a2b8", "#28a745"],
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          labels: {
            font: {
              size: 16
            }
          }
        },
        tooltip: {
          bodyFont: {
            size: 14
          },
          titleFont: {
            size: 16
          }
        }
      }
    },
  });
}

  </script>
</body>

</html>
