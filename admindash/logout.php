<?php
session_start();
session_unset();
session_destroy();

echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logging Out...</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Playfair Display', serif;
      background: url('../pics/bg.png') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
  </style>
</head>
<body>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'You have been logged out!',
      text: 'Admin session ended. Returning to home...',
      confirmButtonText: 'OK',
      background: '#fffaf6',
      color: '#333',
      confirmButtonColor: '#e08f5f',
      customClass: {
        popup: 'rounded-xl',
        title: 'fw-bold'
      }
    }).then(() => {
      window.location.href = '../index.php';
    });
  </script>
</body>
</html>
HTML;
?>
