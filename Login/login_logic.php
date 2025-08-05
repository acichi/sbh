<?php
session_start();
require '../properties/connection.php';

function sanitize($data) {
    return htmlspecialchars(trim($data));
}

$email    = sanitize($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// ✅ SweetAlert2 Themed Function
function showSweetAlert($message, $redirectUrl, $type = 'success') {
    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Shelton Beach Haven</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background: url('../pics/bg.png') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Playfair Display', serif;
    }
    .swal2-popup {
      font-family: 'Playfair Display', serif;
      border-radius: 16px;
      padding: 1.5rem;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
    }
    .swal2-title {
      font-size: 1.5rem;
    }
  </style>
</head>
<body>

<script>
  Swal.fire({
    icon: '$type',
    title: `$message`,
    showConfirmButton: false,
    timer: 2500,
    background: '#ffffffee',
    color: '#333',
    timerProgressBar: true,
    didClose: () => {
      window.location.href = '$redirectUrl';
    }
  });
</script>

</body>
</html>
HTML;
    exit;
}

// ✅ Validation
if (empty($email) || empty($password)) {
    showSweetAlert('❌ Please fill in all fields.', './index.php', 'error');
}

// ✅ Check user
$stmt = $conn->prepare("SELECT id, fullname, email, number, username, password, gender, role, address FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id'       => $user['id'],
            'fullname' => $user['fullname'],
            'email'    => $user['email'],
            'username' => $user['username'],
            'role'     => $user['role'],
        ];
        $_SESSION['fullname'] = $user['fullname'];

        $welcomeMessage = "✅ Welcome back, " . htmlspecialchars($user['fullname']) . "!";

        if ($user['role'] === 'admin') {
            showSweetAlert($welcomeMessage, '../admindash/admindash.php', 'success');
        } else {
            showSweetAlert($welcomeMessage, '../cusdash/cusdash.php', 'success');
        }
    } else {
        showSweetAlert('❌ Incorrect password.', 'login.php', 'error');
    }
} else {
    showSweetAlert('❌ No account found with that email.', 'login.php', 'error');
}

$stmt->close();
$conn->close();
?>
