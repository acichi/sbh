<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet' />
  <!-- My CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/reservation.css"/>
  <title>Admin Dashboard</title>
</head>
<body>
  <!-- SIDEBAR -->
  <?php include("menu.php")?>
  <!-- SIDEBAR -->

  <!-- CONTENT -->
  <section id="content">
    <!-- NAVBAR -->
    <nav>
      <i class='bx bx-menu'></i>
      <a href="#" class="nav-link">Shelton Beach</a>
      <form action="#">
        <div class="form-input">
          <input type="search" placeholder="Search..." />
          <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
      </form>
      <input type="checkbox" id="switch-mode" hidden />
      <label for="switch-mode" class="switch-mode"></label>
      <a href="#" class="notification">
        <i class='bx bxs-bell'></i>
        <span class="num">8</span>
      </a>
      <a href="#" class="profile">
        <img src="prof.png"/>
      </a>
    </nav>
    <!-- NAVBAR -->

    <!-- MAIN -->
    <main id="main-content">
        <?php include("dashboard_content.php");?>
    </main>
    <!-- MAIN -->
  </section>
  <!-- CONTENT -->

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  <script src="js/page_loader.js"></script>

  <script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const totalSalesEl = document.getElementById('totalSales');
    const timeRangeSelect = document.getElementById('timeRangeSelect');

    const dataSets = {
      weekly: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        data: [300, 400, 350, 450, 500, 600, 550]
      },
      monthly: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        data: [1200, 1500, 1800, 2100, 1900, 2200, 2543]
      },
      yearly: {
        labels: ['2019', '2020', '2021', '2022', '2023'],
        data: [15000, 18000, 20000, 22000, 25430]
      }
    };

    function formatCurrency(value) {
      return '$' + value.toLocaleString();
    }

    let currentView = 'monthly';

    const salesChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: dataSets[currentView].labels,
        datasets: [{
          label: 'Total Sales',
          data: dataSets[currentView].data,
          fill: true,
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: '#4bc0c0',
          borderWidth: 2,
          tension: 0.3,
          pointRadius: 4,
          pointHoverRadius: 7,
        }]
      },
      options: {
        responsive: true,
        animation: {
          duration: 500,
          easing: 'easeInOutQuad'
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: context => formatCurrency(context.parsed.y)
            }
          },
          legend: {
            labels: {
              font: {
                size: 14,
                weight: '600'
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return formatCurrency(value);
              }
            },
            grid: {
              color: '#eee'
            }
          },
          x: {
            grid: {
              color: '#eee'
            }
          }
        }
      }
    });

    function updateChart(view) {
      currentView = view;
      salesChart.data.labels = dataSets[view].labels;
      salesChart.data.datasets[0].data = dataSets[view].data;
      salesChart.update();

      // Calculate total sales for the selected range and update text
      const total = dataSets[view].data.reduce((a, b) => a + b, 0);
      totalSalesEl.textContent = `Total Sales: ${formatCurrency(total)}`;
    }

    timeRangeSelect.addEventListener('change', (e) => {
      updateChart(e.target.value);
    });

    // Initialize total sales text on load
    updateChart(currentView);
  </script>
  <script src="js/script.js"></script>
</body>
</html>