// === SweetAlert2 ===
const svg = document.getElementById("map");
let selectedPin = null;
let offset = { x: 0, y: 0 };
let isDragging = false;
let dragStart = null;
let currentPin = null;
let pinSaved = false;

// Convert client coords to SVG coords
function getSVGCoords(e) {
  const pt = svg.createSVGPoint();
  pt.x = e.clientX;
  pt.y = e.clientY;
  return pt.matrixTransform(svg.getScreenCTM().inverse());
}

// Show modal and populate fields
function openFacilityModal(x, y, pin) {
  document.getElementById("pin_x").value = x.toFixed(2);
  document.getElementById("pin_y").value = y.toFixed(2);
  pinSaved = false;
  currentPin = pin;

  const modal = new bootstrap.Modal(document.getElementById("facilityModal"));
  modal.show();
}

// Ask user to save or discard the pin
function confirmSave(pin) {
  const x = parseFloat(pin.getAttribute("cx"));
  const y = parseFloat(pin.getAttribute("cy"));

  Swal.fire({
    title: "Save this pin?",
    text: `X: ${x.toFixed(2)}, Y: ${y.toFixed(2)}`,
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Save",
    cancelButtonText: "Discard"
  }).then((result) => {
    if (result.isConfirmed) {
      openFacilityModal(x, y, pin);
    } else {
      pin.remove();
    }
  });
}

// Add pin on map click
svg.addEventListener("click", (e) => {
  if (e.target.tagName === 'circle') return;

  const svgP = getSVGCoords(e);
  const pin = document.createElementNS("http://www.w3.org/2000/svg", "circle");
  pin.setAttribute("cx", svgP.x);
  pin.setAttribute("cy", svgP.y);
  pin.setAttribute("r", "10");
  pin.setAttribute("fill", "green");
  pin.style.cursor = "pointer";
  pin.classList.add("draggable-pin");

  svg.appendChild(pin);
  confirmSave(pin);
});

// Drag start
svg.addEventListener("mousedown", (e) => {
  if (e.target.tagName === "circle") {
    selectedPin = e.target;
    dragStart = getSVGCoords(e);
    const cx = parseFloat(selectedPin.getAttribute("cx"));
    const cy = parseFloat(selectedPin.getAttribute("cy"));
    offset.x = dragStart.x - cx;
    offset.y = dragStart.y - cy;
    isDragging = false;
  }
});

// Drag move
svg.addEventListener("mousemove", (e) => {
  if (selectedPin) {
    const svgP = getSVGCoords(e);
    const dx = svgP.x - dragStart.x;
    const dy = svgP.y - dragStart.y;

    if (Math.abs(dx) > 2 || Math.abs(dy) > 2) {
      isDragging = true;
      selectedPin.setAttribute("cx", svgP.x - offset.x);
      selectedPin.setAttribute("cy", svgP.y - offset.y);
    }
  }
});

// Drag end
svg.addEventListener("mouseup", () => {
  if (selectedPin && isDragging) {
    confirmSave(selectedPin);
  }
  selectedPin = null;
  isDragging = false;
});

svg.addEventListener("mouseleave", () => {
  selectedPin = null;
  isDragging = false;
});

// Cleanup pin if modal is closed without saving
document.getElementById("facilityModal").addEventListener("hidden.bs.modal", function () {
  if (!pinSaved && currentPin) {
    currentPin.remove();
    currentPin = null;
  }
});

// Handle AJAX save
document.getElementById("facilityForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Stop default form submission

  const form = e.target;
  const formData = new FormData(form);

  fetch('save_facility.php', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    if (!response.ok) throw new Error("Network error");
    return response.text();
  })
  .then(data => {
    pinSaved = true;

    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: 'Facility saved successfully',
      showConfirmButton: false,
      timer: 2000
    });

    const modal = bootstrap.Modal.getInstance(document.getElementById("facilityModal"));
    modal.hide();
    form.reset();
  })
  .catch(err => {
    console.error(err);

    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Failed to save the facility. Pin will be removed.',
    });

    pinSaved = false;
    if (currentPin) {
      currentPin.remove();
      currentPin = null;
    }

    const modal = bootstrap.Modal.getInstance(document.getElementById("facilityModal"));
    modal.hide();
  });
});