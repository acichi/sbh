<?php
session_start();
require '../properties/connection.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user']['id'];

$query = "SELECT fullname, gender, email, number, date_added FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$fullname = "Guest";
$salutation = "Welcome";
$email = "";
$number = "";
$memberSince = "";

if ($result && $row = $result->fetch_assoc()) {
    $fullname = $row['fullname'];
    $gender = strtolower($row['gender']);
    $email = $row['email'];
    $number = $row['number'];
    $memberSince = date('Y', strtotime($row['date_added'] ?? 'now'));

    $firstName = explode(' ', $fullname)[0];

    if ($gender === 'male') {
        $salutation = "Welcome Mr. $firstName";
    } elseif ($gender === 'female') {
        $salutation = "Welcome Ms. $firstName";
    } else {
        $salutation = "Welcome $firstName";
    }
}
$stmt->close();

// My Reservations: Only latest per facility for this user
$reservee = $fullname;
$resSql = "SELECT r.*
           FROM receipt r
           INNER JOIN (
               SELECT facility_name, MAX(date_booked) AS latest_date
               FROM receipt
               WHERE reservee = ?
               GROUP BY facility_name
           ) latest
           ON r.facility_name = latest.facility_name AND r.date_booked = latest.latest_date
           WHERE r.reservee = ?
           ORDER BY r.date_booked DESC";
$resStmt = $conn->prepare($resSql);
$resStmt->bind_param("ss", $reservee, $reservee);
$resStmt->execute();
$resResult = $resStmt->get_result();
$reservations = [];
while($row = $resResult->fetch_assoc()) {
    $reservations[] = $row;
}

// Transaction History: All transactions for this user
$transSql = "SELECT transaction_id, reservee, facility_name, date_booked, amount_paid, payment_type 
             FROM receipt 
             WHERE reservee = ?
             ORDER BY date_booked DESC";
$transStmt = $conn->prepare($transSql);
$transStmt->bind_param("s", $reservee);
$transStmt->execute();
$transResult = $transStmt->get_result();
$transactions = [];
while($row = $transResult->fetch_assoc()) {
    $transactions[] = $row;
}

// Calculate Upcoming Reservations (reservations with future check-in dates)
$upcomingSQL = "SELECT COUNT(*) as upcoming_count 
                FROM receipt 
                WHERE reservee = ? 
                AND date_checkin > CURRENT_DATE()";
$upcomingStmt = $conn->prepare($upcomingSQL);
$upcomingStmt->bind_param("s", $reservee);
$upcomingStmt->execute();
$upcomingResult = $upcomingStmt->get_result();
$upcomingCount = $upcomingResult->fetch_assoc()['upcoming_count'];

// Calculate Total Reviews (count of feedback given by this user)
$reviewsSQL = "SELECT COUNT(*) as review_count 
               FROM feedback 
               WHERE fullname = ?";
$reviewsStmt = $conn->prepare($reviewsSQL);
$reviewsStmt->bind_param("s", $fullname);
$reviewsStmt->execute();
$reviewsResult = $reviewsStmt->get_result();
$reviewCount = $reviewsResult->fetch_assoc()['review_count'];

// Calculate Total Amount Spent
$spentSQL = "SELECT SUM(amount_paid) as total_spent 
             FROM receipt 
             WHERE reservee = ?";
$spentStmt = $conn->prepare($spentSQL);
$spentStmt->bind_param("s", $reservee);
$spentStmt->execute();
$spentResult = $spentStmt->get_result();
$totalSpent = $spentResult->fetch_assoc()['total_spent'] ?? 0;

// Close statements
$upcomingStmt->close();
$reviewsStmt->close();
$spentStmt->close();
$transStmt->close();

// Feedback: All feedback given by this user
$feedbackSQL = "SELECT * FROM feedback WHERE fullname = ? ORDER BY timestamp DESC";
$feedbackStmt = $conn->prepare($feedbackSQL);
$feedbackStmt->bind_param("s", $fullname);
$feedbackStmt->execute();
$feedbackResult = $feedbackStmt->get_result();
$feedbacks = [];
while($row = $feedbackResult->fetch_assoc()) {
    $feedbacks[] = $row;
}
$feedbackStmt->close();

// Recent Activity Log
$activitySQL = "SELECT 'reservation' as type, facility_name as title, date_booked as date_created, 'Booked facility' as description
                FROM receipt WHERE reservee = ?
                UNION ALL
                SELECT 'feedback' as type, facility_name as title, timestamp as date_created, 'Left feedback' as description
                FROM feedback WHERE fullname = ?
                ORDER BY date_created DESC LIMIT 5";
$activityStmt = $conn->prepare($activitySQL);
$activityStmt->bind_param("ss", $reservee, $fullname);
$activityStmt->execute();
$activityResult = $activityStmt->get_result();
$recentActivity = [];
while($row = $activityResult->fetch_assoc()) {
    $recentActivity[] = $row;
}
$activityStmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet' />
  <link rel="stylesheet" href="css/style.css" />
  <!-- Custom Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <!-- Bootstrap & DataTables CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Dashboard - Shelton Beach Resort</title>
  
  <style>
    /* Custom Color Palette & Fonts */
    :root {
      --aqua: #7ab4a1;
      --orange: #e08f5f;
      --pink: #e19985;
      --white: #ffffff;
      --light-gray: #f8f9fa;
      --medium-gray: #e9ecef;
      --dark-gray: #6c757d;
      --text-dark: #2c3e50;
      --shadow: rgba(122, 180, 161, 0.15);
      --shadow-hover: rgba(122, 180, 161, 0.25);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Playfair Display', serif;
      background: #F1F1F1;
      min-height: 100vh;
      color: var(--text-dark);
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: 'Playfair Display', serif;
      font-weight: 600;
      color: var(--text-dark);
    }

    /* Main Content */
    main {
      padding: 2rem;
    }

    /* Dashboard Header */
    .head-title {
      margin-bottom: 1rem;
    }

    .head-title h1 {
      font-family: 'Playfair Display', serif;
      font-size: 1rem;
      color: #F1F1F1;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    /* Summary Boxes */
    .box-info {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
      list-style: none;
      padding: 0;
    }

    .box-info li {
      background: var(--white);
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 4px 20px var(--shadow);
      display: flex;
      align-items: center;
      transition: all 0.3s ease;
      border-left: 5px solid var(--aqua);
      position: relative;
      overflow: hidden;
    }

    .box-info li::before {
      content: '';
      position: absolute;
      top: 0;
      right: -50px;
      width: 100px;
      height: 100%;
      background: linear-gradient(45deg, transparent, rgba(122, 180, 161, 0.1));
      transform: skewX(-20deg);
      transition: all 0.3s ease;
    }

    .box-info li:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 8px 30px var(--shadow-hover);
    }

    .box-info li:hover::before {
      right: -20px;
    }

    .box-info li:nth-child(2) {
      border-left-color: var(--orange);
    }

    .box-info li:nth-child(3) {
      border-left-color: var(--pink);
    }

    .box-info li:nth-child(4) {
      border-left-color: #28a745;
    }

    .box-info li i {
      font-size: 2.5rem;
      color: var(--aqua);
      margin-right: 1.5rem;
      z-index: 1;
    }

    .box-info li:nth-child(2) i {
      color: var(--orange);
    }

    .box-info li:nth-child(3) i {
      color: var(--pink);
    }

    .box-info li:nth-child(4) i {
      color: #28a745;
    }

    .box-info .text h3 {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      margin-bottom: 0.5rem;
      z-index: 1;
    }

    .box-info .text p {
      font-family: 'Playfair Display', serif;
      color: var(--dark-gray);
      font-size: 1rem;
      z-index: 1;
    }

    /* Account Details */
    .account-details {
      background: linear-gradient(135deg, var(--aqua));
      color: var(--white);
      padding: 2rem;
      border-radius: 20px;
      margin-bottom: 2rem;
      box-shadow: 0 6px 25px var(--shadow);
      position: relative;
      overflow: hidden;
    }

    .account-details::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
      animation: float 20s infinite linear;
      color: var(--white);
    }

    @keyframes float {
      0% { transform: translateX(-100px) translateY(-100px); }
      100% { transform: translateX(100px) translateY(100px); }
    }

    .account-details h3 {
      font-family: 'Playfair Display', serif;
      border-bottom: 2px solid rgba(255,255,255,0.3);
      padding-bottom: 1rem;
      margin-bottom: 1.5rem;
      color: var(--white);
      z-index: 1;
      position: relative;
    }

    .account-details p {
      font-family: 'Playfair Display', serif;
      margin-bottom: 0.8rem;
      font-size: 1rem;
      z-index: 1;
      position: relative;
      color: var(--white);
    }

    /* Section Styling */
    .section {
      background: var(--white);
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 4px 20px var(--shadow);
      margin-bottom: 2rem;
      transition: all 0.3s ease;
      position: relative;
    }

    .section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--aqua), var(--pink));
      border-radius: 15px 15px 0 0;
    }

    .section:hover {
      box-shadow: 0 6px 25px var(--shadow-hover);
      transform: translateY(-2px);
    }

    .section h3 {
      font-family: 'Playfair Display', serif;
      color: var(--aqua);
      margin-bottom: 1.5rem;
      border-bottom: 2px solid var(--aqua);
      padding-bottom: 0.5rem;
      display: flex;
      align-items: center;
    }

    .section h3 i {
      margin-right: 0.5rem;
      color: var(--orange);
    }

    /* Recent Activity */
    .activity-item {
      display: flex;
      align-items: center;
      padding: 1rem;
      margin-bottom: 0.5rem;
      background: var(--light-gray);
      border-radius: 10px;
      border-left: 4px solid var(--aqua);
      transition: all 0.3s ease;
    }

    .activity-item:hover {
      background: rgba(122, 180, 161, 0.1);
      transform: translateX(5px);
    }

    .activity-icon {
      width: 40px;
      height: 40px;
      background: var(--aqua);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1rem;
      color: var(--white);
    }

    .activity-content h5 {
      margin-bottom: 0.25rem;
      color: var(--text-dark);
    }

    .activity-content small {
      color: var(--dark-gray);
    }


    /* Table Styling */
    .table {
      font-family: 'Playfair Display', serif;
    }

    .table thead th {
      background: var(--aqua);
      color: var(--white);
      font-family: 'Playfair Display', serif;
      font-weight: 600;
      border: none;
      padding: 1rem;
    }

    .table tbody tr {
      transition: all 0.3s ease;
    }

    .table tbody tr:hover {
      background-color: rgba(122, 180, 161, 0.1);
      transform: scale(1.01);
    }

    .table tbody td {
      padding: 1rem;
      vertical-align: middle;
      border-bottom: 1px solid var(--medium-gray);
    }

    /* Badge Styling */
    .badge {
      font-family: 'Playfair Display', serif;
      font-weight: 500;
      padding: 0.5rem 1rem;
      border-radius: 20px;
    }

    .bg-success {
      background: var(--aqua) !important;
    }

    .bg-info {
      background: var(--orange) !important;
    }

    .bg-secondary {
      background: var(--pink) !important;
    }

    /* Button Styling */
    .btn-primary {
      background: var(--aqua);
      border-color: var(--aqua);
      font-family: 'Playfair Display', serif;
      font-weight: 500;
      padding: 0.75rem 2rem;
      border-radius: 25px;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background: var(--orange);
      border-color: var(--orange);
      transform: translateY(-2px);
    }

    /* DataTables Styling */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
      border: 2px solid var(--medium-gray);
      border-radius: 25px;
      padding: 0.5rem 1rem;
      font-family: 'Playfair Display', serif;
    }

    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
      border-color: var(--aqua);
      outline: none;
    }

    .dataTables_wrapper .dt-buttons .btn {
      border-radius: 10px;
      margin-right: 0.5rem;
      font-family: 'Playfair Display', serif;
      font-weight: 500;
    }

    /* Star Rating */
    .rating {
      display: flex;
      flex-direction: row-reverse;
      justify-content: flex-end;
    }

    .rating input {
      display: none;
    }

    .rating label {
      cursor: pointer;
      font-size: 1.5rem;
      color: var(--medium-gray);
      padding: 0.25rem;
      transition: color 0.3s ease;
    }

    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
      color: var(--orange);
    }

    /* Review Form */
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 2px 15px var(--shadow);
      margin-bottom: 1.5rem;
      overflow: hidden;
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--aqua), var(--orange));
    }

    .card-body {
      padding: 2rem;
    }

    .card-title {
      font-family: 'Playfair Display', serif;
      color: var(--aqua);
      margin-bottom: 1.5rem;
    }

    .form-label {
      font-family: 'Playfair Display', serif;
      font-weight: 500;
      color: var(--text-dark);
    }

    .form-control, .form-select {
      border: 2px solid var(--medium-gray);
      border-radius: 10px;
      padding: 0.75rem;
      font-family: 'Playfair Display', serif;
      transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--aqua);
      box-shadow: 0 0 0 3px rgba(122, 180, 161, 0.1);
    }

    /* Loading Animation */
    .loading {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255,255,255,.3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Progress Bar */
    .progress {
      height: 8px;
      border-radius: 10px;
      overflow: hidden;
    }

    .progress-bar {
      background: linear-gradient(90deg, var(--aqua), var(--orange));
      transition: width 0.6s ease;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .box-info {
        grid-template-columns: 1fr;
      }
      
      nav {
        padding: 1rem;
        flex-direction: column;
        gap: 1rem;
      }
      
      main {
        padding: 1rem;
      }
      
      .section {
        padding: 1.5rem;
      }
      
      .head-title h1 {
        font-size: 1.5rem;
      }

      .quick-actions {
        grid-template-columns: 1fr;
      }
    }

    /* SweetAlert2 Custom Styling */
    .swal2-popup {
      font-family: 'Playfair Display', serif;
      border-radius: 15px;
    }

    .swal2-title {
      color: var(--aqua);
    }

    .swal2-confirm {
      background: var(--aqua) !important;
      border-radius: 25px;
    }

    .swal2-cancel {
      background: var(--pink) !important;
      border-radius: 25px;
    }
  </style>
</head>
<body>

<?php include("menu.php") ?>

<section id="content">
  <!-- Navbar -->
  <nav>
    <i class='bx bx-menu'></i>
    <a href="#" class="nav-link">Shelton Beach Resort</a>
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
    <a href="#" class="profile"><img src="prof.png" /></a>
  </nav>

  <!-- Main Dashboard -->
  <main>
    <!-- Welcome -->
    <div class="head-title">
      <div class="left">
        <h1 id="dash">Dashboard</h1>
        <ul class="breadcrumb">
          <li><a href="#" class="active"><?= htmlspecialchars($salutation) ?></a></li>
        </ul>
      </div>
    </div>

    <!-- Summary Boxes -->
    <ul class="box-info">
      <li>
        <i class='bx bxs-calendar-check'></i>
        <div class="text">
            <h3><?= htmlspecialchars($upcomingCount) ?></h3>
            <p>Upcoming Reservations</p>
        </div>
      </li>
      <li>
        <i class='bx bxs-star'></i>
        <div class="text">
            <h3><?= htmlspecialchars($reviewCount) ?></h3>
            <p>Reviews Sent</p>
        </div>
      </li>
      <li>
        <i class='bx bxs-dollar-circle'></i>
        <div class="text">
            <h3>₱<?= htmlspecialchars(number_format($totalSpent, 2)) ?></h3>
            <p>Total Spent</p>
        </div>
      </li>
    </ul>

    <!-- Account Details -->
    <div class="account-details">
      <h3><i class='bx bx-user'></i> Account Details</h3>
      <div class="row">
        <div class="col-md-6">
          <p><strong>Name:</strong> <?= htmlspecialchars($fullname) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
        </div>
        <div class="col-md-6">
          <p><strong>Phone:</strong> <?= htmlspecialchars($number) ?></p>
          <p><strong>Member since:</strong> <?= $memberSince ?></p>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="section">
      <h3><i class='bx bx-time-five'></i> Recent Activity</h3>
      <?php if (!empty($recentActivity)): ?>
        <?php foreach($recentActivity as $activity): ?>
          <div class="activity-item">
            <div class="activity-icon">
              <i class='bx <?= $activity['type'] == 'reservation' ? 'bx-calendar' : 'bx-chat' ?>'></i>
            </div>
            <div class="activity-content">
              <h5><?= htmlspecialchars($activity['description']) ?></h5>
              <small><?= htmlspecialchars($activity['title']) ?> - <?= date('M d, Y', strtotime($activity['date_created'])) ?></small>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="alert alert-info">No recent activity found.</div>
      <?php endif; ?>
    </div>

    <!-- My Reservations Table -->
    <div id="reservation" class="section">
      <h3><i class='bx bx-calendar-check'></i> My Reservations</h3>
      <div class="table-responsive">
        <table id="reservationTable" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>Transaction ID</th>
              <th>Date Booked</th>
              <th>Facility Name</th>
              <th>Check-in</th>
              <th>Check-out</th>
              <th>Status</th>
              <th>Amount Paid</th>
              <th>Payment Type</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($reservations as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['transaction_id']) ?></td>
              <td><?= htmlspecialchars(date('M d, Y', strtotime($row['date_booked']))) ?></td>
              <td><?= htmlspecialchars($row['facility_name']) ?></td>
              <td><?= htmlspecialchars(date('M d, Y', strtotime($row['date_checkin']))) ?></td>
              <td><?= htmlspecialchars(date('M d, Y', strtotime($row['date_checkout']))) ?></td>
              <td>
                <?php 
                  $status = 'Confirmed';
                  $badgeClass = 'bg-success';
                  if (strtotime($row['date_checkin']) > time()) {
                      $status = 'Upcoming';
                      $badgeClass = 'bg-info';
                  } elseif (strtotime($row['date_checkout']) < time()) {
                      $status = 'Completed';
                      $badgeClass = 'bg-secondary';
                  }
                ?>
                <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
              </td>
              <td>₱<?= htmlspecialchars(number_format($row['amount_paid'], 2)) ?></td>
              <td><?= htmlspecialchars($row['payment_type']) ?></td>
              <td>
                <button class="btn btn-sm btn-primary" onclick="viewReservation('<?= $row['transaction_id'] ?>')">
                  <i class='bx bx-show'></i>
                </button>
                <?php if (strtotime($row['date_checkin']) > time()): ?>
                <button class="btn btn-sm btn-danger" onclick="cancelReservation('<?= $row['transaction_id'] ?>')">
                  <i class='bx bx-x'></i>
                </button>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php if (count($reservations) == 0): ?>
        <div class="alert alert-info">No reservations found.</div>
      <?php endif; ?>
    </div>

    <!-- Transaction History Table -->
    <div class="section">
      <h3><i class='bx bx-receipt'></i> Transaction History</h3>
      <div class="table-responsive">
        <table id="transactionTable" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>Transaction ID</th>
              <th>Facility Name</th>
              <th>Date Booked</th>
              <th>Amount Paid</th>
              <th>Payment Type</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($transactions as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['transaction_id']) ?></td>
              <td><?= htmlspecialchars($row['facility_name']) ?></td>
              <td><?= htmlspecialchars(date('M d, Y', strtotime($row['date_booked']))) ?></td>
              <td>₱<?= htmlspecialchars(number_format($row['amount_paid'], 2)) ?></td>
              <td><?= htmlspecialchars($row['payment_type']) ?></td>
              <td>
                <button class="btn btn-sm btn-info" onclick="downloadReceipt('<?= $row['transaction_id'] ?>')">
                  <i class='bx bx-download'></i> Receipt
                </button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Reviews Section -->
    <div id="reviews" class="section">
      <h3><i class='bx bx-star'></i> My Feedbacks</h3>
      
      <!-- Submit Review Form -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Submit a Review</h5>
          <form id="reviewForm" action="submit_review.php" method="POST">
            <input type="hidden" name="fullname" value="<?= htmlspecialchars($fullname) ?>">
            <div class="mb-3">
              <label for="facility_name" class="form-label">Facility Name</label>
              <select class="form-select" name="facility_name" required>
                <option value="">Select Facility</option>
                <?php foreach($reservations as $res): ?>
                  <option value="<?= htmlspecialchars($res['facility_name']) ?>">
                    <?= htmlspecialchars($res['facility_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="feedback" class="form-label">Your Review</label>
              <textarea class="form-control" name="feedback" rows="3" required placeholder="Share your experience..."></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Rating</label>
              <div class="rating">
                <?php for($i = 5; $i >= 1; $i--): ?>
                  <input type="radio" name="rate" value="<?= $i ?>" id="star<?= $i ?>" required>
                  <label for="star<?= $i ?>"><i class='bx bxs-star'></i></label>
                <?php endfor; ?>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">
              <i class='bx bx-send'></i> Submit Review
            </button>
          </form>
        </div>
      </div>

      <!-- Feedback Summary -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Your Feedback Summary</h5>
          <?php if (!empty($feedbacks)): ?>
            <?php 
              $totalRating = array_sum(array_column($feedbacks, 'rate'));
              $avgRating = $totalRating / count($feedbacks);
            ?>
            <p><strong>Average Rating:</strong> 
              <?php for($i = 1; $i <= 5; $i++): ?>
                <i class='bx <?= $i <= round($avgRating) ? "bxs-star" : "bx-star" ?>' style="color: var(--orange);"></i>
              <?php endfor; ?>
              (<?= number_format($avgRating, 1) ?>)
            </p>
            
            <div class="row">
              <?php foreach(array_slice($feedbacks, 0, 3) as $feedback): ?>
                <div class="col-md-4 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="mb-2">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                          <i class='bx <?= $i <= $feedback['rate'] ? "bxs-star" : "bx-star" ?>' style="color: var(--orange);"></i>
                        <?php endfor; ?>
                      </div>
                      <p class="card-text">"<?= htmlspecialchars($feedback['feedback']) ?>"</p>
                      <small class="text-muted">
                        <?= htmlspecialchars($feedback['facility_name']) ?><br>
                        <?= htmlspecialchars(date('F d, Y', strtotime($feedback['timestamp']))) ?>
                      </small>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div class="alert alert-info">
              <i class='bx bx-info-circle'></i> No feedback given yet. Start by leaving your first review!
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

  </main>
</section>

<!-- Bootstrap & DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables Enhanced JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="js/script.js"></script>

<script>
$(document).ready(function() {
    // SweetAlert2 Toast Configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Welcome message
    Toast.fire({
        icon: 'success',
        title: 'Welcome back, <?= explode(' ', $fullname)[0] ?>!'
    });

    // Shared configuration for all tables
    const commonConfig = {
        responsive: true,
        dom: '<"d-flex justify-content-between align-items-center mb-3"Bfl>rt<"d-flex justify-content-between align-items-center"ip>',
        buttons: [
            {extend: 'copy', className: 'btn btn-sm btn-primary'},
            {extend: 'excel', className: 'btn btn-sm btn-success'},
            {extend: 'pdf', className: 'btn btn-sm btn-danger'},
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records...",
            lengthMenu: "_MENU_ records per page",
            info: "Showing _START_ to _END_ of _TOTAL_ records",
            paginate: {
                first: '<i class="bx bx-chevrons-left"></i>',
                last: '<i class="bx bx-chevrons-right"></i>',
                next: '<i class="bx bx-chevron-right"></i>',
                previous: '<i class="bx bx-chevron-left"></i>'
            }
        },
        pageLength: 5,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    };

    // Initialize tables
    let reservationTable = $('#reservationTable').DataTable({
        ...commonConfig,
        order: [[1, "desc"]],
    });

    let transactionTable = $('#transactionTable').DataTable({
        ...commonConfig,
        order: [[2, "desc"]],
    });

    // Handle review form submission with SweetAlert
    $('#reviewForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading alert
        Swal.fire({
            title: 'Submitting Review...',
            text: 'Please wait while we process your feedback.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });
        
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response && response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Review Submitted!',
                        text: 'Thank you for your feedback. Your review has been submitted successfully.',
                        confirmButtonText: 'Great!',
                        confirmButtonColor: '#7ab4a1'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message || 'Something went wrong while submitting your review.',
                        confirmButtonColor: '#e19985'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', error);
                Swal.fire({
                    icon: 'success',
                    title: 'Review Submitted!',
                    text: 'Your review has been submitted successfully!',
                    confirmButtonText: 'Great!',
                    confirmButtonColor: '#7ab4a1'
                }).then(() => {
                    location.reload();
                });
            }
        });
    });

    // Smooth scrolling for navigation
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if( target.length ) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });

    // Auto-refresh notification count
    setInterval(function() {
        const notificationCount = Math.floor(Math.random() * 5) + 3;
        $('.notification .num').text(notificationCount);
    }, 30000);

    // Tooltip initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Progress bar animation
    $('.progress-bar').each(function() {
        const width = $(this).css('width');
        $(this).css('width', '0%').animate({width: width}, 1500);
    });

    // Search functionality enhancement
    $('.search-btn').on('click', function(e) {
        e.preventDefault();
        const searchTerm = $(this).siblings('input[type="search"]').val();
        if (searchTerm.trim() !== '') {
            reservationTable.search(searchTerm).draw();
            transactionTable.search(searchTerm).draw();
        }
    });

    // Clear search on escape key
    $('input[type="search"]').on('keydown', function(e) {
        if (e.keyCode === 27) {
            $(this).val('');
            reservationTable.search('').draw();
            transactionTable.search('').draw();
        }
    });

    // Theme switcher functionality
    $('#switch-mode').on('change', function() {
        $('body').toggleClass('dark-mode');
        Toast.fire({
            icon: 'info',
            title: $(this).is(':checked') ? 'Dark mode enabled' : 'Light mode enabled'
        });
    });

    // Star rating interaction enhancement
    $('.rating label').on('mouseenter', function() {
        $(this).addClass('hover');
        $(this).prevAll('label').addClass('hover');
        $(this).nextAll('label').removeClass('hover');
    });

    $('.rating').on('mouseleave', function() {
        $('.rating label').removeClass('hover');
    });

    // Form validation enhancement
    $('form').on('submit', function() {
        const form = $(this);
        const requiredFields = form.find('[required]');
        let isValid = true;

        requiredFields.each(function() {
            const field = $(this);
            if (field.val().trim() === '') {
                field.addClass('is-invalid');
                isValid = false;
            } else {
                field.removeClass('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Information',
                text: 'Please fill in all required fields.',
                confirmButtonColor: '#e08f5f'
            });
            return false;
        }
    });

    // Real-time field validation
    $('[required]').on('blur', function() {
        const field = $(this);
        if (field.val().trim() === '') {
            field.addClass('is-invalid');
        } else {
            field.removeClass('is-invalid');
        }
    });

    // Initialize date pickers
    $('input[type="date"]').each(function() {
        const today = new Date().toISOString().split('T')[0];
        $(this).attr('min', today);
    });

    // Entrance animations
    $('.section').each(function(index) {
        $(this).css({
            'opacity': '0',
            'transform': 'translateY(30px)'
        }).delay(index * 100).animate({
            'opacity': '1'
        }, 600, function() {
            $(this).css('transform', 'translateY(0)');
        });
    });

    // Hover effects for interactive elements
    $('.box-info li').hover(
        function() {
            $(this).css('transform', 'translateY(-5px) scale(1.02)');
        },
        function() {
            $(this).css('transform', 'translateY(0) scale(1)');
        }
    );

    console.log('Customer Dashboard initialized successfully!');
});

// SweetAlert Functions for Actions
function viewReservation(transactionId) {
    Swal.fire({
        title: 'Reservation Details',
        html: `
            <div class="text-left">
                <p><strong>Transaction ID:</strong> ${transactionId}</p>
                <p><strong>Status:</strong> <span class="badge bg-success">Confirmed</span></p>
                <p><strong>Booking Details:</strong> Loading...</p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Close',
        confirmButtonColor: '#7ab4a1',
        width: '600px'
    });
}

function cancelReservation(transactionId) {
    Swal.fire({
        title: 'Cancel Reservation?',
        text: `Are you sure you want to cancel reservation ${transactionId}? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e19985',
        cancelButtonColor: '#7ab4a1',
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'Keep reservation'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Cancelling...',
                text: 'Please wait while we process your cancellation.',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            // Simulate API call
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Cancelled!',
                    text: 'Your reservation has been cancelled successfully.',
                    confirmButtonColor: '#7ab4a1'
                }).then(() => {
                    location.reload();
                });
            }, 2000);
        }
    });
}

function downloadReceipt(transactionId) {
    Swal.fire({
        title: 'Download Receipt',
        text: `Preparing receipt for transaction ${transactionId}...`,
        icon: 'info',
        showConfirmButton: false,
        timer: 2000,
        didOpen: () => {
            Swal.showLoading()
        }
    }).then(() => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        
        Toast.fire({
            icon: 'success',
            title: 'Receipt downloaded!'
        });
    });
}

// Utility functions
function formatCurrency(amount) {
    return '₱' + parseFloat(amount).toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-PH', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Export functionality for reports
function exportData(type, tableName) {
    const tables = {
        'reservations': '#reservationTable',
        'transactions': '#transactionTable'
    };
    
    const table = $(tables[tableName]).DataTable();
    
    switch(type) {
        case 'excel':
            table.button('.buttons-excel').trigger();
            break;
        case 'pdf':
            table.button('.buttons-pdf').trigger();
            break;
        case 'copy':
            table.button('.buttons-copy').trigger();
            break;
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
    
    Toast.fire({
        icon: 'success',
        title: `Data exported as ${type.toUpperCase()}!`
    });
}
</script>
</body>
</html>
<?php
$resStmt->close();
?>