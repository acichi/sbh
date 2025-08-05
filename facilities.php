<?php
// facility.php
?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shelton Beach Resort | Facilities Map</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Sans:400,700|Playfair+Display:400,700">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/fancybox.min.css">
    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="pics/logo2.jpg" type="image/png">
    
    <style>
      .map-responsive {
        overflow: hidden;
        padding-bottom: 56.25%;
        position: relative;
        height: 0;
      }
      .map-responsive iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
      }
    </style>
  </head>
  <body>
    
  <?php include 'navbar.php'; ?>

  <!-- Hero Section -->
  <section class="site-hero overlay" style="background-image: url(pics/bg.png)" data-stellar-background-ratio="0.5">
    <div class="container">
      <div class="row site-hero-inner justify-content-center align-items-center">
        <div class="col-md-10 text-center" data-aos="fade-up">
          <span class="custom-caption text-uppercase text-white d-block mb-3">See Our Layout</span>
          <h1 class="heading">Facility Map of Shelton Beach Resort</h1>
        </div>
      </div>
    </div>
    <a class="mouse smoothscroll" href="#map">
      <div class="mouse-icon">
        <span class="mouse-wheel"></span>
      </div>
    </a>
  </section>

  <!-- Map Section -->
  <section class="section bg-light" id="map">
    <div class="container">
      <div class="row justify-content-center text-center mb-5">
        <div class="col-md-8">
          <h2 class="heading" data-aos="fade-up">Explore Our Resort Layout</h2>
          <p data-aos="fade-up" data-aos-delay="100">
            Our interactive map helps you locate cottages, pools, and key resort features with ease.
          </p>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-10" data-aos="fade-up" data-aos-delay="200">
          <div class="map-responsive">
            <!-- Embed your Google Map here -->
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.7547760306496!2d122.99333331480088!3d10.315699092629957!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33aef64e934d4f5d%3A0x2c60da1047d3f1e2!2sShelton%20Beach%20Haven%20Resort!5e0!3m2!1sen!2sph!4v1691302649516!5m2!1sen!2sph" 
              width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="section bg-image overlay" style="background-image: url('pics/5.png');">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-md-6 text-center mb-4 mb-md-0 text-md-left" data-aos="fade-up">
          <h2 class="text-white font-weight-bold">Ready to Book a Cottage?</h2>
        </div>
        <div class="col-12 col-md-6 text-center text-md-right" data-aos="fade-up" data-aos-delay="200">
          <a href="Login/login.php" class="btn btn-outline-white-primary py-3 text-white px-5">Log In & Book Now</a>
        </div>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>

  <!-- Scripts -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/bootstrap-datepicker.js"></script> 
  <script src="js/jquery.timepicker.min.js"></script> 
  <script src="js/main.js"></script>
  </body>
</html>
