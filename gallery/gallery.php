<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Gallery Upload - Shelton Beach Haven</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="pics/logo2.png" type="image/png">
  <style>
    :root {
      --aqua: #7ab4a1;
      --orange: #e08f5f;
      --pink: #e19985;
    }
    body {
      background: url('bg.png') no-repeat center center/cover;
      font-family: 'Playfair Display', serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .container-box {
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      padding: 2rem;
      max-width: 600px;
      width: 100%;
      position: relative;
    }
    .header-bar {
      background: #ffffff;
      border-bottom: 2px solid var(--aqua);
      padding: 12px 15px;
      border-radius: 12px 12px 0 0;
      color: var(--aqua);
      font-size: 1.3rem;
      font-weight: 600;
      text-align: center;
      margin: -2rem -2rem 1.5rem -2rem;
      position: relative;
    }
    .btn-back {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: var(--orange);
      border: none;
      font-size: 0.9rem;
      font-weight: 500;
      color: #fff;
      padding: 5px 12px;
      border-radius: 8px;
      text-decoration: none;
    }
    .btn-back:hover {
      background: #c87649;
      text-decoration: none;
    }
    #drop-area {
      cursor: pointer;
      transition: background 0.3s ease, border-color 0.3s ease;
    }
    #drop-area.dragover {
      background: #f6fdfb;
      border-color: var(--aqua);
    }
    #fileList .file-item {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 8px 12px;
      margin-bottom: 6px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-left: 4px solid var(--orange);
      font-size: 0.9rem;
    }
    .btn-remove {
      border: none;
      background: none;
      color: var(--orange);
      font-size: 1.2rem;
      cursor: pointer;
    }
    .btn-success {
      background: var(--aqua);
      border: none;
      font-weight: 600;
    }
    .btn-success:hover {
      background: #629d8b;
    }
  </style>
</head>
<body>

<div class="container-box">
  <div class="header-bar">
    <a href="../admindash/admindash.php" class="btn-back">← Back</a>
    Gallery Upload
  </div>

  <form id="uploadForm" enctype="multipart/form-data">
    <!-- Description -->
    <div class="mb-3">
      <label for="description" class="form-label fw-bold">Description</label>
      <textarea class="form-control" id="description" name="description" rows="3" placeholder="Write a short description..." required></textarea>
    </div>

    <!-- Drop Area -->
    <div class="mb-3">
      <label class="form-label fw-bold">Select Files</label>
      <div id="drop-area" class="border border-2 border-primary rounded p-4 text-center bg-white">
        <p class="mb-0">Drag & Drop files here or <span class="text-primary fw-bold">Click to Browse</span></p>
        <input type="file" id="files" name="files[]" multiple hidden>
      </div>
      <div id="fileList" class="mt-3"></div>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-success px-4 py-2">Upload</button>
    </div>
  </form>
</div>

<script>
const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('files');
const fileList = document.getElementById('fileList');
let selectedFiles = [];

// Drop Area Logic
dropArea.addEventListener('click', () => fileInput.click());
dropArea.addEventListener('dragover', (e) => {
  e.preventDefault();
  dropArea.classList.add('dragover');
});
dropArea.addEventListener('dragleave', () => dropArea.classList.remove('dragover'));
dropArea.addEventListener('drop', (e) => {
  e.preventDefault();
  dropArea.classList.remove('dragover');
  addFiles(e.dataTransfer.files);
});
fileInput.addEventListener('change', () => addFiles(fileInput.files));

function addFiles(files) {
  for (const file of files) {
    selectedFiles.push(file);
  }
  renderFileList();
}

function renderFileList() {
  fileList.innerHTML = '';
  selectedFiles.forEach((file, index) => {
    const div = document.createElement('div');
    div.className = 'file-item';
    div.innerHTML = `
      <span>${file.name} (${(file.size/1024).toFixed(1)} KB)</span>
      <button type="button" class="btn-remove" onclick="removeFile(${index})">&times;</button>
    `;
    fileList.appendChild(div);
  });
}

function removeFile(index) {
  selectedFiles.splice(index, 1);
  renderFileList();
}

// Submit Handler
document.getElementById('uploadForm').addEventListener('submit', async function(e){
  e.preventDefault();
  if(selectedFiles.length === 0){
    Swal.fire('No Files', 'Please select at least one file!', 'warning');
    return;
  }

  const formData = new FormData();
  formData.append('description', document.getElementById('description').value);
  selectedFiles.forEach(file => formData.append('files[]', file));

  try {
    // Replace with your backend handler
    const response = await fetch('upload_handler.php', {
      method: 'POST',
      body: formData
    });
    const result = await response.text();

    Swal.fire('Success!', 'Files uploaded successfully.', 'success');
    document.getElementById('uploadForm').reset();
    selectedFiles = [];
    fileList.innerHTML = '';
  } catch (error) {
    Swal.fire('Error', 'Something went wrong. Try again.', 'error');
  }
});

$(document).ready(function() {
  $('[data-fancybox="gallery"]').fancybox({
    buttons: ["zoom", "slideShow", "thumbs", "close"],
    caption: function(instance, item) {
      return $(this).data('caption') || '';
    }
  });
});

</script>
</body>
</html>
