<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/dashboard.css" />
  <link rel="icon" href="assets/skull.png" sizes="32x32" type="image/png" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>DXCLY: Admin Dashboard</title>

  <style>
    .charts {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      margin-top: 40px;
    }

    .charts canvas {
      flex: 1 1 300px;
      max-width: 100%;
      min-width: 300px;
      height: 300px !important;
    }

    @media (max-width: 768px) {
      .charts {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- PHP session and includes here (unchanged) -->
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
  include 'templates/header_admin.php';
  ?>

  <div class="container">
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
  </div>

  <script>
    let cachedSales = [], cachedOrders = [];

    $(document).ready(function () {
      const today = new Date().toISOString().split('T')[0];
      $('#date').val(today);

      fetchData();

      $("#date").on("change", function () {
        if (cachedSales.length > 0) {
          getSalesByDate(cachedSales);
        }
      });
    });

    function fetchData() {
      $.get("api/users/fetch.php", function (data) {
        const users = JSON.parse(data);
        $("#users").text(users.length);
      });

      $.get("api/carts/fetch_sales.php", function (data) {
        const orders = JSON.parse(data);
        cachedOrders = orders;
        $("#orders").text(orders.length);
        computeSales(orders);
      });
    }

    function computeSales(orders) {
      let sales = [], count = 0;

      if (!orders.length) {
        cachedSales = [];
        updateSalesDisplay(0, 0);
        renderCharts([], []);
        return;
      }

      orders.forEach(o => {
        $.ajax({
          url: "api/products/fetch_id.php",
          method: "POST",
          contentType: "application/json",
          data: JSON.stringify({ id: o.product_id }),
          success: function (data) {
            const product = JSON.parse(data);
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
        });
      });
    }

    function getSalesByDate(sales) {
      let selectedDateStr = $("#date").val();
      if (!selectedDateStr) {
        updateSalesDisplay(0, 0);
        return;
      }

      let selectedDate = new Date(selectedDateStr);
      let y = selectedDate.getFullYear(), m = selectedDate.getMonth() + 1;

      let monthly = sales.filter(s => {
        let d = new Date(s.date);
        return d.getFullYear() === y && d.getMonth() + 1 === m;
      }).map(s => s.income);

      let daily = sales.filter(s => {
        let d = new Date(s.date);
        return d.getFullYear() === y && d.getMonth() + 1 === m && d.getDate() === selectedDate.getDate();
      }).map(s => s.income);

      updateSalesDisplay(
        monthly.reduce((a, b) => a + b, 0),
        daily.reduce((a, b) => a + b, 0)
      );
    }

    function updateSalesDisplay(monthlyTotal, dailyTotal) {
      $("#monthly-sales").text("₱ " + monthlyTotal.toLocaleString("en-US"));
      $("#daily-sales").text("₱ " + dailyTotal.toLocaleString("en-US"));
    }

    let lineChartInstance, barChartInstance, pieChartInstance;

    function renderCharts(sales, orders) {
      if (lineChartInstance) lineChartInstance.destroy();
      if (barChartInstance) barChartInstance.destroy();
      if (pieChartInstance) pieChartInstance.destroy();

      const lineData = {}, barData = {}, pieData = { "To Pay": 0, "To Receive": 0, "Completed": 0 };
      const today = new Date();
      const currentMonth = today.getMonth(), currentYear = today.getFullYear();

      sales.forEach(s => {
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

      const fontOptions = {
        plugins: {
          legend: {
            labels: {
              color: "#000", // ensures visibility
              font: { size: 16 }
            }
          },
          tooltip: {
            bodyFont: { size: 14 },
            titleFont: { size: 16 },
            backgroundColor: "#fff",
            titleColor: "#000",
            bodyColor: "#000",
            borderColor: "#ccc",
            borderWidth: 1
          }
        },
        scales: {
          x: {
            ticks: { color: "#000", font: { size: 14 } }
          },
          y: {
            ticks: { color: "#000", font: { size: 14 } }
          }
        },
        responsive: true,
        maintainAspectRatio: false
      };

      const lineCtx = document.getElementById("lineChart").getContext("2d");
      lineChartInstance = new Chart(lineCtx, {
        type: "line",
        data: {
          labels: Object.keys(lineData).map(d => `Day ${d}`),
          datasets: [{
            label: "Daily Sales",
            data: Object.values(lineData),
            borderColor: "#4e73df",
            tension: 0.4,
            fill: false,
          }],
        },
        options: fontOptions,
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
        options: fontOptions,
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
                color: "#000",
                font: { size: 16 }
              }
            },
            tooltip: {
              backgroundColor: "#fff",
              titleColor: "#000",
              bodyColor: "#000",
              borderColor: "#ccc",
              borderWidth: 1,
              titleFont: { size: 16 },
              bodyFont: { size: 14 }
            }
          }
        },
      });
    }
  </script>
</body>

</html>
