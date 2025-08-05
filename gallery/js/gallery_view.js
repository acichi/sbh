document.addEventListener("DOMContentLoaded", () => {
  const gallery = document.getElementById("gallery");
  const pagination = document.getElementById("pagination");
  const limit = 6;

  let currentPage = 1;

  function loadGallery(page = 1) {
    fetch(`gallery/gallery_data.php?page=${page}&limit=${limit}`)
      .then(res => res.json())
      .then(data => {
        gallery.innerHTML = "";
        pagination.innerHTML = "";
        currentPage = page;

        data.items.forEach(item => {
          const col = document.createElement("div");
          col.className = "col-md-4";

          const card = document.createElement("div");
          card.className = "card gallery-card shadow-sm";

          const isImage = /\.(jpg|jpeg|png|gif|webp)$/i.test(item.location);
          const content = isImage
            ? `<img src="gallery/${item.location}" class="card-img-top" alt="Preview">`
            : `<div class="text-center py-5 text-secondary">No preview</div>`;

          card.innerHTML = `
            ${content}
            <div class="card-body">
              <p class="card-text">${item.description}</p>
              <small class="text-muted">Uploaded: ${item.date_added}</small>
            </div>
          `;

          col.appendChild(card);
          gallery.appendChild(col);
        });

        // Pagination
        for (let i = 1; i <= data.totalPages; i++) {
          const li = document.createElement("li");
          li.className = `page-item ${i === currentPage ? "active" : ""}`;
          li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
          li.addEventListener("click", (e) => {
            e.preventDefault();
            loadGallery(i);
          });
          pagination.appendChild(li);
        }
      })
      .catch(err => {
        gallery.innerHTML = "<p class='text-danger'>Failed to load gallery.</p>";
      });
  }

  loadGallery(currentPage);
});
