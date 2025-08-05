<!-- Footer -->
<footer style="text-align: center; padding: 30px 15px; background: linear-gradient(to top, #e19985, #e08f5f); color: white; position: relative;">
    <p>&copy; 2025 Shelton Beach Haven. All Rights Reserved.</p>

    <!-- Social Text Links -->
    <div style="margin-top: 15px;">
        <a href="https://www.facebook.com/SheltonBeachHavenResortPuntaTayTayBC" target="_blank" style="color: white; margin: 0 12px; text-decoration: none;">Facebook</a>
        <a href="mailto:shelton@gmail.com" style="color: white; margin: 0 12px; text-decoration: none;">Email</a>
        <a href="tel:+917483358199" style="color: white; margin: 0 12px; text-decoration: none;">Call</a>
        <a href="#" data-toggle="modal" data-target="#locationModal" style="color: white; margin: 0 12px; text-decoration: none;">Map</a>
    </div>

    <!-- Back to Top Button -->
    <button onclick="scrollToTop()" style="
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #7ab4a1;
        border: none;
        border-radius: 50%;
        padding: 12px 16px;
        font-weight: bold;
        color: white;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        z-index: 1000;
        transition: background 0.3s ease;
    ">↑</button>
</footer>

<!-- Modal for Location -->
<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel">
  <div class="modal-dialog modal-dialog-centered animate__animated animate__fadeInUp" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border: none;">
        <h5 class="modal-title">Location Map</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <iframe src="https://www.google.com/maps/place/SHELTON+BEACH+HAVEN/@10.6020865,122.9069255,17z/data=!3m1!4b1!4m6!3m5!1s0x33aecf7a15acf601:0x7226652524a1c46c!8m2!3d10.6020812!4d122.9095004!16s%2Fg%2F1tj559hg?hl=en&entry=ttu"
          frameborder="0" style="width:100%; height: 400px; border: none;"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Scroll-to-Top Script -->
<script>
  function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
</script>

<!-- Animate.css CDN for fadeInUp modal -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
