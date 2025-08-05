<?php
// feedbacks.php
?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Customer Feedback - Shelton Beach Resort</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS Links -->
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
    <link rel="icon" href="pics/logo2.png" type="image/png">

    <style>
      .feedback-card {
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        min-height: 220px;
      }
      .feedback-name {
        font-weight: bold;
        font-size: 1.2rem;
        color: #e08f5f;
      }
      .feedback-stars {
        color: #ffc107;
        margin: 5px 0;
      }
      .feedback-text {
        margin-top: 10px;
        color: #444;
        font-style: italic;
      }
      .feedback-meta {
        font-size: 0.9rem;
        color: #999;
        margin-top: 10px;
      }
      .rating-summary {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        text-align: center;
      }
      .rating-summary .stars {
        color: #ffc107;
        font-size: 1.3rem;
      }
      .rating-summary h3 {
        margin-top: 10px;
        font-size: 1.3rem;
        color: #444;
      }
    </style>
  </head>
  <body>

    <?php include 'navbar.php'; ?>

    <!-- HERO SECTION -->
    <section class="site-hero overlay" style="background-image: url(pics/bg.png)" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
          <div class="col-md-10 text-center" data-aos="fade-up">
            <span class="custom-caption text-uppercase text-white d-block mb-3">Real Stories, Real Smiles</span>
            <h1 class="heading text-white">What Our Customers Say</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- FEEDBACKS SECTION -->
    <section class="section bg-light">
      <div class="container">
        <div class="row mb-5 text-center">
          <div class="col-md-8 mx-auto">
            <h2 class="heading mb-4" data-aos="fade-up">Guest Feedback</h2>
            <p data-aos="fade-up" data-aos-delay="100">
              Here are some of the kind words and honest reviews from our wonderful guests.
            </p>
          </div>
        </div>

        <?php
          // Database connection
          $conn = new mysqli('localhost', 'root', '', 'shelton');

          if ($conn->connect_error) {
            echo "<div class='col-12 text-center text-danger'><p>Database connection failed: " . $conn->connect_error . "</p></div>";
          } else {
            // Fetch average rating & total reviews (only visible feedback)
            $avgSql = "SELECT AVG(rate) AS avg_rating, COUNT(*) AS total_reviews 
                       FROM feedback 
                       WHERE is_hidden = 0";
            $avgResult = $conn->query($avgSql);
            $avgData = $avgResult->fetch_assoc();
            $averageRating = round($avgData['avg_rating'], 1);
            $totalReviews = $avgData['total_reviews'];

            if ($totalReviews > 0) {
              echo "<div class='rating-summary' data-aos='fade-up'>
                      <div class='stars'>";
                        $filledStars = floor($averageRating);
                        $emptyStars = 5 - $filledStars;
                        for ($i = 0; $i < $filledStars; $i++) echo "<i class='fa fa-star'></i>";
                        if ($averageRating - $filledStars >= 0.5) {
                          echo "<i class='fa fa-star-half-o'></i>";
                          $emptyStars--;
                        }
                        for ($i = 0; $i < $emptyStars; $i++) echo "<i class='fa fa-star-o'></i>";
              echo    "</div>
                      <h3>$averageRating / 5 based on $totalReviews reviews</h3>
                    </div>";
            }
        ?>

        <div class="row">
          <?php
              // Fetch all visible feedbacks
              $sql = "SELECT fullname, facility_name, feedback, rate, timestamp 
                      FROM feedback 
                      WHERE is_hidden = 0
                      ORDER BY timestamp DESC";
              $result = $conn->query($sql);

              if (!$result) {
                echo "<div class='col-12 text-center text-danger'><p>SQL error: " . $conn->error . "</p></div>";
              } else if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $fullname = htmlspecialchars($row['fullname']);
                  $facility = htmlspecialchars($row['facility_name']);
                  $feedback = nl2br(htmlspecialchars($row['feedback']));
                  $rate = intval($row['rate']);
                  $timestamp = date("F j, Y", strtotime($row['timestamp']));

                  echo '<div class="col-md-6 col-lg-4" data-aos="fade-up">';
                    echo '<div class="feedback-card">';
                      echo "<div class='feedback-name'>$fullname</div>";
                      echo "<div class='feedback-stars'>";
                        for ($i = 0; $i < $rate; $i++) echo "<i class='fa fa-star'></i>";
                        for ($i = $rate; $i < 5; $i++) echo "<i class='fa fa-star-o'></i>";
                      echo "</div>";
                      echo "<div class='feedback-text'>\"$feedback\"</div>";
                      echo "<div class='feedback-meta'>Facility: $facility <br> Date: $timestamp</div>";
                    echo '</div>';
                  echo '</div>';
                }
              } else {
                echo '<div class="col-12 text-center"><p>No feedback available yet. Be the first to share your experience!</p></div>';
              }

              $conn->close();
            }
          ?>
        </div>
      </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- JS Scripts -->
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
