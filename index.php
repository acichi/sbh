<php>
<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shelton Beach Resort</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=|Roboto+Sans:400,700|Playfair+Display:400,700">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/fancybox.min.css">
    
    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    
    <link rel="icon" href="pics/logo2.jpg" type="image/png">

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
  <?php include 'navbar.php'; ?>

    <section class="site-hero overlay" style="background-image: url(pics/bg.png)" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
          <div class="col-md-10 text-center" data-aos="fade-up">
            <span class="custom-caption text-uppercase text-white d-block  mb-3">Navigate your stay with precision</span>
            <h1 class="heading">Welcome to Shelton Beach Resort</h1>
          </div>
        </div>
      </div>

      <a class="mouse smoothscroll" href="#next">
        <div class="mouse-icon">
          <span class="mouse-wheel"></span>
        </div>
      </a>
    </section>
    <!-- END section -->

    <section class="section bg-light pb-0"  >
      <div class="container">
       
        <div class="row check-availabilty" id="next">
          <div class="block-32" data-aos="fade-up" data-aos-offset="-200">

            <form action="#">
              <div class="row">
                <div class="col-md-6 mb-3 mb-lg-0 col-lg-3">
                  <label for="checkin_date" class="font-weight-bold text-black">Check In</label>
                  <div class="field-icon-wrap">
                    <div class="icon"><span class="icon-calendar"></span></div>
                    <input type="text" id="checkin_date" class="form-control">
                  </div>
                </div>
                <div class="col-md-6 mb-3 mb-lg-0 col-lg-3">
                  <label for="checkout_date" class="font-weight-bold text-black">Check Out</label>
                  <div class="field-icon-wrap">
                    <div class="icon"><span class="icon-calendar"></span></div>
                    <input type="text" id="checkout_date" class="form-control">
                  </div>
                </div>
                <div class="col-md-6 mb-3 mb-md-0 col-lg-3">
                  <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                      <label for="adults" class="font-weight-bold text-black">Adults</label>
                      <div class="field-icon-wrap">
                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                        <select name="" id="adults" class="form-control">
                          <option value="">1</option>
                          <option value="">2</option>
                          <option value="">3</option>
                          <option value="">4+</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3 mb-md-0">
                      <label for="children" class="font-weight-bold text-black">Children</label>
                      <div class="field-icon-wrap">
                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                        <select name="" id="children" class="form-control">
                          <option value="">1</option>
                          <option value="">2</option>
                          <option value="">3</option>
                          <option value="">4+</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-3 align-self-end">
                  <button class="btn btn-primary btn-block text-white">Check Availabilty</button>
                </div>
              </div>
            </form>
          </div>


        </div>
      </div>
    </section>

    <section class="py-5 bg-light">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-12 col-lg-7 ml-auto order-lg-2 position-relative mb-5" data-aos="fade-up">
            <figure class="img-absolute">
              <img src="pics/logo2.png" alt="Image" class="img-fluid">
            </figure>
            <img src="pics/one.png" alt="Image" class="img-fluid rounded">
          </div>
          <div class="col-md-12 col-lg-4 order-lg-1" data-aos="fade-up">
            <h2 class="heading">Welcome!</h2>
            <p class="mb-4">Tucked along the shores of Negros Occidental, Shelton Beach Resort is more than a destination — it's a place where families come together, friends reconnect, and the ocean becomes part of every memory.</p>
            <p><a href="cusdash/map_settings.php" class="btn btn-primary text-white py-2 mr-3">Book Now!</a> <span class="mr-3 font-family-serif"><em>but</em></span> <a href="Login/login.php"  data-fancybox class="text-uppercase letter-spacing-1">Log-in first!</a></p>
          </div>
          
        </div>
      </div>
    </section>

    
    <section class="section slider-section bg-light">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-7">
            <h2 class="heading" data-aos="fade-up">Photos</h2>
            <p data-aos="fade-up" data-aos-delay="100">Browse our cozy cottages, scenic views, and relaxing amenities. Your perfect getaway starts here.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="home-slider major-caousel owl-carousel mb-5" data-aos="fade-up" data-aos-delay="200">
              <div class="slider-item">
                <a href="images/slider-1.jpg" data-fancybox="images" data-caption="Cottage 2"><img src="pics/one.png" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-2.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="pics/1.png" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-3.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="pics/2.png" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-4.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="pics/3.png" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-5.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="pics/4.png" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-6.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="pics/5.png" alt="Image placeholder" class="img-fluid"></a>
              </div>
              <div class="slider-item">
                <a href="images/slider-7.jpg" data-fancybox="images" data-caption="Caption for this image"><img src="pics/6.png" alt="Image placeholder" class="img-fluid"></a>
              </div>
            </div>
            <!-- END slider -->
          </div>
        
        </div>
      </div>
    </section>
    <!-- END section -->


    

 <section class="section blog-post-entry bg-light">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-md-7">
        <h2 class="heading" data-aos="fade-up">Shelton Beach Haven in the News</h2>
        <p data-aos="fade-up">
          Shelton Beach Haven has been featured on trusted travel sites and continues to receive love from the local community. Check out these real online listings and reviews!
        </p>
      </div>
    </div>
    <div class="row">
      
      <!-- Negrosfindr Feature -->
      <div class="col-lg-4 col-md-6 col-sm-6 col-12 post" data-aos="fade-up" data-aos-delay="100">
        <div class="media media-custom d-block mb-4 h-100">
          <a href="https://negrosfindr.com/listings/shelton-beach-resort-bacolod/" class="mb-4 d-block" target="_blank">
            <img src="pics/neg.png" alt="NegrosFindr Listing" class="img-fluid">
          </a>
          <div class="media-body">
            <span class="meta-post">November 6, 2018</span>
            <h2 class="mt-0 mb-3">
              <a href="https://negrosfindr.com/listings/shelton-beach-resort-bacolod/" target="_blank">
                Featured on Negrosfindr
              </a>
            </h2>
            <p>
              Listed as a top destination in Punta Taytay, Bacolod City, Shelton Beach Haven stands out on NegrosFindr for its amenities and local charm.
            </p>
          </div>
        </div>
      </div>

      <!-- AttractTour Feature -->
      <div class="col-lg-4 col-md-6 col-sm-6 col-12 post" data-aos="fade-up" data-aos-delay="200">
        <div class="media media-custom d-block mb-4 h-100">
          <a href="https://attracttour.com/2016/04/full-details-of-shelton-beach-resort-punta-taytay-bacolod-city-photos-videos/" class="mb-4 d-block" target="_blank">
            <img src="pics/news.png" alt="AttractTour Feature" class="img-fluid">
          </a>
          <div class="media-body">
            <span class="meta-post">April 18, 2016</span>
            <h2 class="mt-0 mb-3">
              <a href="https://attracttour.com/2016/04/full-details-of-shelton-beach-resort-punta-taytay-bacolod-city-photos-videos/" target="_blank">
                Full Details on AttractTour
              </a>
            </h2>
            <p>
              A blog post featuring Shelton's entrance fees, pool access, cottage rates, and a gallery of photos and videos showcasing the beach haven experience.
            </p>
          </div>
        </div>
      </div>

      <!-- Facebook Page -->
      <div class="col-lg-4 col-md-6 col-sm-6 col-12 post" data-aos="fade-up" data-aos-delay="300">
        <div class="media media-custom d-block mb-4 h-100">
          <a href="https://www.facebook.com/SheltonBeachHavenResortPuntaTayTayBC/" class="mb-4 d-block" target="_blank">
            <img src="pics/second.png" alt="Facebook Page" class="img-fluid">
          </a>
          <div class="media-body">
            <span class="meta-post">Updated Weekly</span>
            <h2 class="mt-0 mb-3">
              <a href="https://www.facebook.com/SheltonBeachHavenResortPuntaTayTayBC/" target="_blank">
                Official Facebook Page
              </a>
            </h2>
            <p>
              Stay up-to-date with Shelton's latest promos, announcements, and guest feedback. Follow us on Facebook and join our growing community.
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


    <section class="section bg-image overlay" style="background-image: url('pics/5.png');">
        <div class="container" >
          <div class="row align-items-center">
            <div class="col-12 col-md-6 text-center mb-4 mb-md-0 text-md-left" data-aos="fade-up">
              <h2 class="text-white font-weight-bold">A Best Place To Stay. Reserve Now!</h2>
            </div>
            <div class="col-12 col-md-6 text-center text-md-right" data-aos="fade-up" data-aos-delay="200">
              <a href="reservation.html" class="btn btn-outline-white-primary py-3 text-white px-5">Reserve Now</a>
            </div>
          </div>
        </div>
      </section>

      <?php include 'footer.php'; ?>

    
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
</php>