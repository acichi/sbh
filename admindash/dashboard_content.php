<?php
session_start();
require '../properties/connection.php';

// Ensure user is logged in and is admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit;
}

$username = isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username']) : 'Admin';

/* ======================= FETCH STAT CARDS ======================= */
$resQuery = $conn->query("SELECT COUNT(*) AS count FROM reservations");
$totalReservations = $resQuery ? $resQuery->fetch_assoc()['count'] : 0;

$guestQuery = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role='customer'");
$totalGuests = $guestQuery ? $guestQuery->fetch_assoc()['count'] : 0;

$salesQuery = $conn->query("SELECT IFNULL(SUM(amount), 0) AS total FROM reservations");
$totalSales = $salesQuery ? $salesQuery->fetch_assoc()['total'] : 0;

/* ======================= FETCH RESERVATIONS ======================= */
$allReservations = $conn->query("
    SELECT r.reservee, u.email, r.facility_name, r.date_booked, r.date_start, r.date_end, 
           r.payment_type, r.amount, r.status
    FROM reservations r
    LEFT JOIN users u ON u.username = r.reservee
    ORDER BY r.date_start DESC
");

/* ======================= FETCH ACCOUNTS ======================= */
$allAccounts = $conn->query("
    SELECT username, fullname, email, role, date_added
    FROM users
    ORDER BY date_added DESC
");

/* ======================= FETCH FEEDBACKS ======================= */
$allFeedbacks = $conn->query("
    SELECT id, fullname, facility_name, feedback, rate, timestamp, IFNULL(is_hidden,0) AS is_hidden
    FROM feedback
    ORDER BY timestamp DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shelton Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- DataTables & Responsive -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

  <link rel="stylesheet" href="styles.css">
  <style>
    .btn { padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 14px; }
    .hide-btn { background: #e08f5f; color: #fff; border: none; text-decoration: none; }
    .unhide-btn { background: #7ab4a1; color: #fff; border: none; text-decoration: none; }
    .hidden-row { background: #fce4e4; }

    /* Mobile Improvements */
    @media (max-width: 768px) {
        .btn {
            font-size: 12px;
            padding: 4px 8px;
        }
        table.dataTable td {
            white-space: normal !important;
        }
        .box-info {
            display: flex;
            flex-direction: column;
        }
        .box-info li {
            width: 100%;
            margin-bottom: 10px;
        }
        .table-data {
            flex-direction: column !important;
        }
    }
  </style>
</head>
<body>

<!-- HEADER -->
<div class="head-title">
  <div class="left">
    <h1>Dashboard</h1>
    <ul class="breadcrumb">
      <li><a class="active">Welcome back, <?php echo $username; ?>!</a></li>
    </ul>
  </div>
</div>

<!-- STAT CARDS -->
<ul class="box-info">
  <li>
    <i class='bx bxs-calendar-check'></i>
    <span class="text">
      <h3><?php echo $totalReservations; ?></h3>
      <p>Total Reservations</p>
    </span>
  </li>
  <li>
    <i class='bx bxs-group'></i>
    <span class="text">
      <h3><?php echo $totalGuests; ?></h3>
      <p>Total Guests</p>
    </span>
  </li>
  <li>
    <i class='bx bxs-dollar-circle'></i>
    <span class="text">
      <h3 id="salesCount">$<?php echo number_format($totalSales,2); ?></h3>
      <p>Total Sales</p>
    </span>
  </li>
</ul>

<!-- CHARTS -->
<div class="table-data" style="display:flex; gap:24px; flex-wrap:wrap; margin-bottom:24px;">
  <!-- Sales Chart -->
  <div id="reports" class="todo" style="flex:1; min-width:300px;">
    <div class="head">
      <h3>Sales Overview</h3>
      <select id="salesRangeSelect" style="margin-left:auto; padding:5px 10px; border:1px solid #ccc;">
        <option value="weekly">Weekly</option>
        <option value="monthly" selected>Monthly</option>
        <option value="yearly">Yearly</option>
      </select>
    </div>
    <div id="totalSales" style="margin:10px 0; font-weight:bold; color:#4bc0c0;">
      Total Sales: $<?php echo number_format($totalSales,2); ?>
    </div>
    <canvas id="salesChart" width="400" height="300"></canvas>
  </div>

  <!-- Feedback Chart -->
  <div class="todo" style="flex:1; min-width:300px;">
    <div class="head">
      <h3>Feedback Overview</h3>
      <select id="feedbackRangeSelect" style="margin-left:auto; padding:5px 10px; border:1px solid #ccc;">
        <option value="weekly">Weekly</option>
        <option value="monthly" selected>Monthly</option>
        <option value="yearly">Yearly</option>
      </select>
    </div>
    <canvas id="feedbackChart" width="400" height="300"></canvas>
  </div>
</div>

<!-- RESERVATIONS TABLE -->
<div class="table-data">
  <div class="order" style="width:100%; margin-bottom:20px;">
    <div class="head"><h3 id="reservations" >All Reservations</h3></div>
    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
      <thead>
        <tr>
          <th>Reservee</th><th>Email</th><th>Facility</th><th>Date Booked</th>
          <th>Start Date</th><th>End Date</th><th>Payment</th><th>Amount</th><th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if($allReservations && $allReservations->num_rows>0) {
          while($row=$allReservations->fetch_assoc()) { ?>
          <tr>
            <td><?php echo htmlspecialchars($row['reservee']); ?></td>
            <td><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($row['facility_name']); ?></td>
            <td><?php echo date('m-d-Y', strtotime($row['date_booked'])); ?></td>
            <td><?php echo date('m-d-Y H:i', strtotime($row['date_start'])); ?></td>
            <td><?php echo date('m-d-Y H:i', strtotime($row['date_end'])); ?></td>
            <td><?php echo htmlspecialchars($row['payment_type']); ?></td>
            <td>$<?php echo number_format($row['amount'], 2); ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
          </tr>
        <?php } } else { ?>
          <tr><td colspan="9">No reservations found.</td></tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <!-- ACCOUNTS TABLE -->
  <div class="order" style="width:100%; margin-bottom:20px;">
    <div class="head"><h3>All Accounts</h3></div>
    <table id="accountsTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
      <thead>
        <tr>
          <th>Username</th><th>Full Name</th><th>Email</th><th>Role</th><th>Date Added</th>
        </tr>
      </thead>
      <tbody>
        <?php if($allAccounts && $allAccounts->num_rows>0) {
          while($row=$allAccounts->fetch_assoc()) { ?>
          <tr>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo ucfirst($row['role']); ?></td>
            <td><?php echo date('m-d-Y', strtotime($row['date_added'])); ?></td>
          </tr>
        <?php } } else { ?>
          <tr><td colspan="5">No accounts found.</td></tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <<!-- FEEDBACK MANAGEMENT -->
<div class="order" style="width:100%;" id="feedback">
  <div class="head"><h3>Manage Feedbacks</h3></div>
  <table id="feedbackTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
    <thead>
      <tr>
        <th>User</th><th>Facility</th><th>Rating</th><th>Comment</th><th>Date</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if($allFeedbacks && $allFeedbacks->num_rows>0) {
        while($row=$allFeedbacks->fetch_assoc()) { ?>
        <tr class="<?php echo $row['is_hidden'] ? 'hidden-row' : ''; ?>">
          <td><?php echo htmlspecialchars($row['fullname']); ?></td>
          <td><?php echo htmlspecialchars($row['facility_name']); ?></td>
          <td><?php for($i=0; $i<$row['rate']; $i++) echo "⭐"; ?></td>
          <td><?php echo htmlspecialchars($row['feedback']); ?></td>
          <td><?php echo date('m-d-Y', strtotime($row['timestamp'])); ?></td>
          <td>
            <?php if($row['is_hidden'] == 0) { ?>
              <button class="btn hide-btn toggle-feedback" data-id="<?php echo $row['id']; ?>" data-action="hide">Hide</button>
            <?php } else { ?>
              <span style="color:red; font-weight:bold; margin-right:5px;">(Hidden)</span>
              <button class="btn unhide-btn toggle-feedback" data-id="<?php echo $row['id']; ?>" data-action="unhide">Unhide</button>
            <?php } ?>
          </td>
        </tr>
      <?php } } else { ?>
        <tr><td colspan="6">No feedbacks found.</td></tr>
      <?php } ?>
    </tbody>
  </table>
</div>


<!-- ================== JS ================== -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
/* DataTables Init */
$('#reservationsTable').DataTable({
    order: [[3, "desc"]],
    pageLength: 5,
    responsive: true
});
$('#accountsTable').DataTable({
    order: [[4, "desc"]],
    pageLength: 5,
    responsive: true
});
$('#feedbackTable').DataTable({
    order: [[4, "desc"]],
    pageLength: 5,
    responsive: true
});

/* Sales Chart */
let salesChart = null;
function loadSalesChart(range = 'monthly') {
    fetch('fetch_sales_chart.php?range=' + range)
        .then(res => res.json())
        .then(data => {
            const ctx = document.getElementById('salesChart').getContext('2d');
            if (salesChart) salesChart.destroy();
            document.getElementById('totalSales').innerText = 'Total Sales: $' + data.total;
            salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Total Sales',
                        data: data.counts,
                        borderColor: '#4bc0c0',
                        backgroundColor: 'rgba(75,192,192,0.2)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#4bc0c0'
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false }}, scales: { y: { beginAtZero: true }} }
            });
        });
}
loadSalesChart('monthly');
document.getElementById('salesRangeSelect').addEventListener('change', (e) => loadSalesChart(e.target.value));

/* Feedback Chart */
let feedbackChart = null;
function loadFeedbackChart(range = 'monthly') {
    fetch('fetch_feedback_chart.php?range=' + range)
        .then(res => res.json())
        .then(data => {
            const ctx = document.getElementById('feedbackChart').getContext('2d');
            if (feedbackChart) feedbackChart.destroy();
            feedbackChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Feedback Count',
                        data: data.counts,
                        backgroundColor: '#e08f5f',
                        borderRadius: 6
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false }}, scales: { y: { beginAtZero: true }} }
            });
        });
}
loadFeedbackChart('monthly');
document.getElementById('feedbackRangeSelect').addEventListener('change', (e) => loadFeedbackChart(e.target.value));
/* Toggle Feedback Hide/Unhide with SweetAlert */
$(document).on('click', '.toggle-feedback', function () {
    const id = $(this).data('id');
    const action = $(this).data('action');

    fetch(`hide_feedback.php?id=${id}&action=${action}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: `Feedback ${action === 'hide' ? 'hidden' : 'unhidden'}!`,
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(err => {
            Swal.fire('Error', 'Something went wrong!', 'error');
        });
});


</script>
</body>
</html>
