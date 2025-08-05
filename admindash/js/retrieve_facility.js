document.addEventListener('DOMContentLoaded', () => {
  const svg = document.getElementById('map');

  fetch('retrieve_facility.php')
    .then(response => response.json())
    .then(data => {
data.forEach(facility => {
  const { id, name, pin_x, pin_y, status, image, details, price } = facility;

  const normalizedStatus = status.trim().toLowerCase(); // Normalize casing and whitespace
  const color = normalizedStatus === 'available' ? 'green' :
                normalizedStatus === 'pending' ? 'yellow' : 'red';

  const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
  circle.setAttribute('cx', pin_x);
  circle.setAttribute('cy', pin_y);
  circle.setAttribute('r', 10);
  circle.setAttribute('fill', color);
  circle.setAttribute('data-id', id);
  circle.style.cursor = 'pointer';

  circle.setAttribute('title', name);

  circle.addEventListener('click', () => {
    showFacilityModal({
      name,
      details,
      status: normalizedStatus, // Optional: send normalized value
      image: `${image}`,
      price
    });
  });

  svg.appendChild(circle);
});

    })
    .catch(error => console.error('Error fetching facility data:', error));
});

function showFacilityModal(facility) {
  const { name, details, status, image, price } = facility;

  const modalContent = `
    <div class="modal fade" id="facilityModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">${name}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <img src="${image}" class="img-fluid mb-3" alt="${name}">
            <p><strong>Status:</strong> ${status}</p>
            <p><strong>Price:</strong> ₱${price}</p>
            <p>${details}</p>
          </div>
        </div>
      </div>
    </div>
  `;

  const oldModal = document.getElementById('facilityModal');
  if (oldModal) oldModal.remove();

  document.body.insertAdjacentHTML('beforeend', modalContent);
  const modal = new bootstrap.Modal(document.getElementById('facilityModal'));
  modal.show();
}

