function showFacilityModal(facility) {
  const { name, price } = facility;

  const now = new Date().toISOString().slice(0, 16); // YYYY-MM-DDTHH:MM format for datetime-local

  const modalContent = `
    <!-- inject the new modal HTML here -->
    <!-- ... paste the reservation modal here as is -->
  `;

  const oldModal = document.getElementById('facilityModal');
  if (oldModal) oldModal.remove();

  document.body.insertAdjacentHTML('beforeend', modalContent);

  // Fill values
  document.getElementById('facilityName').value = name;
  document.getElementById('amount').value = price;
  document.getElementById('dateBooked').value = now;

  const modal = new bootstrap.Modal(document.getElementById('facilityModal'));
  modal.show();
}
