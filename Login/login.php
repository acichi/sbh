<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Shelton Beach Haven</title>

  <!-- Fonts & Core Styles -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" href="pics/logo2.png" type="image/png">

  <style>
    :root {
      --primary-color: #e08f5f;
      --primary-dark: #d27c49;
      --secondary-color: #7ab4a1;
      --secondary-dark: #65a291;
      --glass-bg: rgba(255, 255, 255, 0.1);
      --glass-border: rgba(255, 255, 255, 0.2);
      --text-light: #ffffff;
      --text-muted: rgba(255, 255, 255, 0.8);
      --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      --blur: blur(10px);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('../pics/bg.png') no-repeat center center;
      background-size: cover;
      opacity: 0.3;
      z-index: -1;
    }

    .floating-shapes {
      position: absolute;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1;
    }

    .shape {
      position: absolute;
      opacity: 0.1;
      animation: float 20s infinite ease-in-out;
    }

    .shape:nth-child(1) {
      width: 80px;
      height: 80px;
      background: var(--primary-color);
      border-radius: 50%;
      top: 20%;
      left: 10%;
      animation-delay: 0s;
    }

    .shape:nth-child(2) {
      width: 120px;
      height: 120px;
      background: var(--secondary-color);
      border-radius: 30%;
      top: 60%;
      right: 10%;
      animation-delay: 5s;
    }

    .shape:nth-child(3) {
      width: 60px;
      height: 60px;
      background: var(--text-light);
      border-radius: 50%;
      bottom: 20%;
      left: 30%;
      animation-delay: 10s;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(180deg); }
    }

    .login-container {
      width: 100%;
      max-width: 1200px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 40px;
    }

    .login-card {
      background: var(--glass-bg);
      backdrop-filter: var(--blur);
      border: 1px solid var(--glass-border);
      border-radius: 24px;
      padding: 48px;
      width: 100%;
      max-width: 450px;
      box-shadow: var(--shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .brand-section {
      text-align: center;
      margin-bottom: 40px;
    }

    .brand-logo {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      margin-bottom: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .brand-logo:hover {
      transform: scale(1.05);
    }

    .brand-title {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--text-light);
      margin-bottom: 8px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .brand-subtitle {
      font-size: 1.1rem;
      color: var(--text-muted);
      font-weight: 300;
    }

    .form-group {
      margin-bottom: 24px;
      position: relative;
    }

    .form-label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--text-light);
      font-size: 0.95rem;
    }

    .input-wrapper {
      position: relative;
    }

    .form-control {
      width: 100%;
      padding: 16px 20px 16px 50px;
      background: rgba(255, 255, 255, 0.9);
      border: 2px solid transparent;
      border-radius: 12px;
      font-size: 1rem;
      transition: all 0.3s ease;
      color: #333;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary-color);
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 0 0 3px rgba(224, 143, 95, 0.2);
    }

    .input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
      font-size: 1.1rem;
    }

    .password-toggle {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #666;
      font-size: 1.1rem;
      transition: color 0.3s ease;
    }

    .password-toggle:hover {
      color: var(--primary-color);
    }

    .checkbox-wrapper {
      display: flex;
      align-items: center;
      margin-bottom: 24px;
    }

    .form-check-input {
      margin-right: 8px;
      accent-color: var(--primary-color);
    }

    .form-check-label {
      color: var(--text-light);
      font-size: 0.9rem;
      cursor: pointer;
    }

    .form-check-label a {
      color: var(--primary-color);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .form-check-label a:hover {
      color: var(--primary-dark);
    }

    .btn-primary {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      border: none;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: 600;
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(224, 143, 95, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(224, 143, 95, 0.4);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .btn-secondary {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, var(--secondary-color), var(--secondary-dark));
      border: none;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: 600;
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(122, 180, 161, 0.3);
    }

    .btn-secondary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(122, 180, 161, 0.4);
    }

    .auth-links {
      text-align: center;
      margin-top: 24px;
    }

    .auth-links p {
      color: var(--text-muted);
      margin-bottom: 8px;
    }

    .auth-links a {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .auth-links a:hover {
      color: var(--primary-dark);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 24px 0;
      color: var(--text-muted);
      font-size: 0.9rem;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--glass-border);
      margin: 0 12px;
    }

    .back-home {
      position: absolute;
      top: 30px;
      left: 30px;
      background: var(--glass-bg);
      backdrop-filter: var(--blur);
      border: 1px solid var(--glass-border);
      border-radius: 50px;
      padding: 12px 24px;
      color: var(--text-light);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      z-index: 10;
    }

    .back-home:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-2px);
    }

    .form-section {
      display: none;
    }

    .form-section.active {
      display: block;
      animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      .login-card {
        padding: 32px;
        margin: 10px;
      }
      
      .brand-title {
        font-size: 2rem;
      }
      
      .back-home {
        top: 20px;
        left: 20px;
        padding: 10px 20px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
  </div>

  <a href="../index.php" class="back-home">
    <i class="fas fa-arrow-left me-2"></i>Back to Home
  </a>

  <div class="login-container">
    <div class="login-card">
      <div class="brand-section">
        <img src="../pics/profile.png" alt="Profile" class="brand-logo">
        <h1 class="brand-title">Welcome Back</h1>
        <p class="brand-subtitle">Sign in to your account</p>
      </div>

      <!-- Login Form -->
      <div class="form-section active" id="login-section">
        <form method="POST" action="login_logic.php">
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <div class="input-wrapper">
              <i class="fas fa-envelope input-icon"></i>
              <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Password</label>
            <div class="input-wrapper">
              <i class="fas fa-lock input-icon"></i>
              <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
              <i class="fas fa-eye password-toggle" onclick="togglePassword(this)"></i>
            </div>
          </div>

          <div class="checkbox-wrapper">
            <input type="checkbox" class="form-check-input" id="agreeLogin" disabled>
            <label class="form-check-label" for="agreeLogin">
              I agree to the <a href="#" onclick="showTerms()">Terms and Conditions</a>
            </label>
          </div>

          <button type="submit" class="btn-primary">
            <i class="fas fa-sign-in-alt me-2"></i>Sign In
          </button>

          <div class="divider">or</div>

          <div class="auth-links">
            <p>Don't have an account?</p>
            <a href="#" onclick="showRegister()">Create an account</a>
          </div>
        </form>
      </div>

      <!-- Register Form -->
      <div class="form-section" id="register-section">
        <form method="POST" action="register_logic.php">
          <div class="form-group">
            <label class="form-label">Full Name</label>
            <div class="input-wrapper">
              <i class="fas fa-user input-icon"></i>
              <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Email Address</label>
            <div class="input-wrapper">
              <i class="fas fa-envelope input-icon"></i>
              <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Username</label>
            <div class="input-wrapper">
              <i class="fas fa-user-circle input-icon"></i>
              <input type="text" name="user" class="form-control" placeholder="Choose a username" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Password</label>
            <div class="input-wrapper">
              <i class="fas fa-lock input-icon"></i>
              <input type="password" name="password" class="form-control" placeholder="Create a password" required>
              <i class="fas fa-eye password-toggle" onclick="togglePassword(this)"></i>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Mobile Number</label>
            <div class="input-wrapper">
              <i class="fas fa-phone input-icon"></i>
              <input type="tel" name="mobile" class="form-control" placeholder="Enter your mobile number" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Address</label>
            <div class="input-wrapper">
              <i class="fas fa-map-marker-alt input-icon"></i>
              <input type="text" name="address" class="form-control" placeholder="Enter your address" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-control" required>
              <option value="">Select your gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
          </div>

          <button type="submit" class="btn-secondary">
            <i class="fas fa-user-plus me-2"></i>Create Account
          </button>

          <div class="auth-links">
            <p>Already have an account?</p>
            <a href="#" onclick="showLogin()">Sign in instead</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function togglePassword(icon) {
      const input = icon.previousElementSibling;
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

    function showRegister() {
      document.getElementById('login-section').classList.remove('active');
      document.getElementById('register-section').classList.add('active');
    }

    function showLogin() {
      document.getElementById('register-section').classList.remove('active');
      document.getElementById('login-section').classList.add('active');
    }

    function showTerms() {
      Swal.fire({
        title: 'Terms & Conditions',
        width: '90%',
        maxWidth: '600px',
        html: `
          <div style="text-align: left; font-size: 14px; line-height: 1.6;">
            <h6 style="color: #e08f5f; margin-bottom: 15px;">Shelton Beach Resort – Bacolod, Negros Occidental</h6>
            <p style="margin-bottom: 15px;">By signing in or creating an account, you agree to the following:</p>
            
            <div style="margin-bottom: 20px;">
              <strong style="color: #7ab4a1;">1. Account Usage</strong>
              <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Provide accurate personal information when registering</li>
                <li>Do not share your login credentials with others</li>
                <li>We may suspend accounts that violate our rules</li>
              </ul>
            </div>
            
            <div style="margin-bottom: 20px;">
              <strong style="color: #7ab4a1;">2. Guest Conduct</strong>
              <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Respect resort staff, guests, and property at all times</li>
                <li>Guests are responsible for any damages caused</li>
                <li>We reserve the right to deny service for misconduct</li>
              </ul>
            </div>
            
            <div style="margin-bottom: 20px;">
              <strong style="color: #7ab4a1;">3. Privacy</strong>
              <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Your data is used for booking and communication only</li>
                <li>We do not share your personal info with third parties</li>
              </ul>
            </div>
            
            <div>
              <strong style="color: #7ab4a1;">4. Availability & Liability</strong>
              <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Access to facilities is subject to availability</li>
                <li>We are not liable for system issues or disruptions</li>
              </ul>
            </div>
          </div>
        `,
        background: 'linear-gradient(135deg, #fff 0%, #f8f9fa 100%)',
        color: '#333',
        confirmButtonText: 'I Agree',
        confirmButtonColor: '#e08f5f',
        customClass: {
          popup: 'rounded-4 shadow-lg',
          title: 'fw-bold',
          confirmButton: 'btn btn-primary px-4 py-2',
        }
      }).then((result) => {
        if (result.isConfirmed) {
          const checkbox = document.getElementById('agreeLogin');
          checkbox.checked = true;
          checkbox.disabled = false;
        }
      });
    }

    // Form validation
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function(e) {
        const agreeCheckbox = this.querySelector('#agreeLogin');
        if (agreeCheckbox && !agreeCheckbox.checked) {
          e.preventDefault();
          Swal.fire({
            icon: 'warning',
            title: 'Agreement Required',
            text: 'Please agree to the Terms and Conditions to continue.',
            confirmButtonColor: '#e08f5f'
          });
        }
      });
    });
  </script>
</body>
</html>
