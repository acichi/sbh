Marker Container
<div class="svg-container">
  <svg id="map" viewBox="0 0 900 500" preserveAspectRatio="xMidYMid meet">
    <image href="../pics/map.png" width="900" height="500" />
    <!-- Markers will be added here via JS -->
  </svg>
</div>

<!-- Save Pin Modal -->
<!-- <div class="modal fade" id="facilityModal" tabindex="-1" aria-labelledby="savePinModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="facilityForm" method="POST" enctype="multipart/form-data" action="map_save.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="savePinModalLabel">Save Facility</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <input type="text" name="pin_x" id="pin_x">
          <input type="text" name="pin_y" id="pin_y">

          <div class="mb-3">
            <label for="facilityName" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="facilityName" required>
          </div>

          <div class="mb-3">
            <label for="facilityDetails" class="form-label">Details</label>
            <textarea class="form-control" name="details" id="facilityDetails" required></textarea>
          </div>

          <div class="mb-3">
            <label for="facilityStatus" class="form-label" required>Status</label>
            <select class="form-select" name="status" id="facilityStatus">
              <option value="Available">Available</option>
              <option value="Unavailable">Unavailable</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="facilityPrice" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" id="facilityPrice" required>
          </div>

          <div class="mb-3">
            <label for="facilityImage" class="form-label">Image</label>
            <input type="file" class="form-control" name="image" id="facilityImage" accept="image/*" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="facilityModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Facility Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="facility-modal-body">
        <!-- Content gets filled by JS -->
      </div>
    </div>
  </div>
</div> -->


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="js/retrieve_facility.js"></script>