<!-- Viewport meta for responsive scaling -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Link fonts (place this in your <head>) -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  html, body {
    font-family: 'Roboto', sans-serif;
    background: transparent !important;
  }

  .navbar {
    background-color: rgba(247, 135, 71, 0.35);
    padding: 15px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 999;
    backdrop-filter: blur(6px);
    transition: background 0.3s ease;
  }

  .navbar .logo {
    display: flex;
    align-items: center;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #fff;
    text-decoration: none;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
  }

  .navbar .logo img {
    height: 40px;
    margin-right: 12px;
    vertical-align: middle;
  }

  .navbar ul {
    list-style: none;
    display: flex;
    gap: 22px;
    transition: all 0.3s ease;
    margin: 0;
    padding: 0;
  }

  .navbar ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 25px;
    transition: 0.3s ease;
    display: block;
  }

  .navbar ul li a:hover,
  .navbar ul li.active a {
    background-color: #fff;
    color: #e08f5f;
  }

  .menu-toggle {
    display: none;
    flex-direction: column;
    cursor: pointer;
    gap: 5px;
    z-index: 1001;
  }

  .menu-toggle span {
    height: 3px;
    width: 25px;
    background: #fff;
    border-radius: 3px;
    transition: 0.3s ease;
  }

  /* Mobile Styles */
  @media (max-width: 768px) {
    .navbar {
      padding: 15px 20px;
      flex-wrap: wrap;
    }

    .navbar .logo {
      font-size: 22px;
    }

    .navbar .logo img {
      height: 35px;
    }

    .menu-toggle {
      display: flex;
      position: relative;
      z-index: 1001;
    }

    .navbar ul {
      flex-direction: column;
      position: fixed;
      top: 60px;
      left: 0;
      right: 0;
      background-color: rgba(224, 143, 95, 0.98);
      max-height: 0;
      overflow: hidden;
      padding: 0;
      width: 100%;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: max-height 0.3s ease;
      z-index: 1000;
    }

    .navbar ul.show {
      max-height: 400px;
      padding: 10px 0;
    }

    .navbar ul li {
      width: 100%;
      text-align: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .navbar ul li:last-child {
      border-bottom: none;
    }

    .navbar ul li a {
      padding: 15px 20px;
      border-radius: 0;
      display: block;
      width: 100%;
    }

    .navbar ul li a:hover,
    .navbar ul li.active a {
      background-color: rgba(255, 255, 255, 0.2);
      color: #fff;
    }
  }

  /* Extra small devices */
  @media (max-width: 480px) {
    .navbar {
      padding: 10px 15px;
    }

    .navbar .logo {
      font-size: 18px;
    }

    .navbar .logo img {
      height: 30px;
      margin-right: 8px;
    }
  }
</style>

<!-- HTML Navbar -->
<nav class="navbar">
  <a class="logo" href="index.php">
    <img src="pics/logo2.png" alt="Shelton Logo" />
    Shelton Beach Haven
  </a>
  <div class="menu-toggle" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <ul id="menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="inquiries.php">Inquiries</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="gallery.php">Gallery</a></li>
    <li><a href="feedbacks.php">Feedbacks</a></li>
    <li><a href="Login/login.php">Log-in / Sign up</a></li>
  </ul>
</nav>

<!-- JavaScript -->
<script>
  function toggleMenu() {
    const menu = document.getElementById("menu");
    const isOpen = menu.classList.contains("show");
    
    // Toggle the menu
    menu.classList.toggle("show");
    
    // Animate hamburger to X
    const spans = document.querySelectorAll('.menu-toggle span');
    spans.forEach((span, index) => {
      if (!isOpen) {
        if (index === 0) span.style.transform = 'rotate(45deg) translate(5px, 5px)';
        if (index === 1) span.style.opacity = '0';
        if (index === 2) span.style.transform = 'rotate(-45deg) translate(7px, -6px)';
      } else {
        span.style.transform = '';
        span.style.opacity = '';
      }
    });
  }

  // Close menu when clicking outside
  document.addEventListener('click', function(event) {
    const navbar = document.querySelector('.navbar');
    const menu = document.getElementById('menu');
    
    if (!navbar.contains(event.target)) {
      menu.classList.remove('show');
      const spans = document.querySelectorAll('.menu-toggle span');
      spans.forEach(span => {
        span.style.transform = '';
        span.style.opacity = '';
      });
    }
  });

  // Close menu when clicking on a link
  document.querySelectorAll('.navbar ul li a').forEach(link => {
    link.addEventListener('click', function() {
      const menu = document.getElementById('menu');
      menu.classList.remove('show');
      const spans = document.querySelectorAll('.menu-toggle span');
      spans.forEach(span => {
        span.style.transform = '';
        span.style.opacity = '';
      });
    });
  });

  // Add "active" class to current page link
  document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll(".navbar ul li a");

    navLinks.forEach(link => {
      const linkHref = link.getAttribute("href");
      if (linkHref === currentUrl || (currentUrl === "" && linkHref === "index.php") || (currentUrl === "index.php" && linkHref === "index.php")) {
        link.parentElement.classList.add("active");
      } else {
        link.parentElement.classList.remove("active");
      }
    });
  });
</script>
