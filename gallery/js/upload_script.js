const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('files');
const fileList = document.getElementById('fileList');
const uploadForm = document.getElementById('uploadForm');

// Open file dialog on click
dropArea.addEventListener('click', () => fileInput.click());

// Show files in preview
fileInput.addEventListener('change', () => {
  fileList.innerHTML = '';
  Array.from(fileInput.files).forEach(file => {
    fileList.innerHTML += `<div>${file.name}</div>`;
  });
});

// Drag & drop styling
dropArea.addEventListener('dragover', (e) => {
  e.preventDefault();
  dropArea.classList.add('bg-info-subtle');
});
dropArea.addEventListener('dragleave', () => {
  dropArea.classList.remove('bg-info-subtle');
});
dropArea.addEventListener('drop', (e) => {
  e.preventDefault();
  fileInput.files = e.dataTransfer.files;
  dropArea.classList.remove('bg-info-subtle');
  fileList.innerHTML = '';
  Array.from(fileInput.files).forEach(file => {
    fileList.innerHTML += `<div>${file.name}</div>`;
  });
});

// Submit form via Ajax
uploadForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(uploadForm);

  const res = await fetch('gallery_upload.php', {
    method: 'POST',
    body: formData
  });
  const data = await res.json();

  if (data.status === 'success') {
    Swal.fire('Success!', data.message, 'success');
    uploadForm.reset();
    fileList.innerHTML = '';
  } else {
    Swal.fire('Error!', data.message, 'error');
  }
});
