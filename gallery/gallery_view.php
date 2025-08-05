<?php
require __DIR__ . "/../properties/connection.php";

$query = $conn->query("SELECT * FROM gallery ORDER BY date_added DESC");

if(!$query || $query->num_rows == 0): ?>
  <div class="text-center w-100">
    <p class="text-muted">No photos yet. Upload from admin dashboard.</p>
  </div>
<?php else: ?>
  <div class="gallery-flex">
  <?php while ($row = $query->fetch_assoc()):
    $imagePath = htmlspecialchars($row['location']);
    $description = htmlspecialchars($row['description']);
  ?>
    <div class="gallery-item">
      <a href="<?php echo $imagePath; ?>" 
         data-fancybox="gallery" 
         data-caption="<?php echo $description; ?>">
        <img src="<?php echo $imagePath; ?>" alt="<?php echo $description; ?>">
      </a>
      <p class="caption"><?php echo $description; ?></p>
    </div>
  <?php endwhile; ?>
  </div>
<?php endif; ?>
