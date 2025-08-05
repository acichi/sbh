// document.getElementById("reservation-link").addEventListener("click", function(e) {
//   e.preventDefault(); // Stop hash navigation

//   fetch('reservation_content.php')
//     .then(response => {
//       if (!response.ok) {
//         throw new Error('Network error while loading reservations.');
//       }
//       return response.text();
//     })
//     .then(html => {
//       const container = document.getElementById("main-content");
//       container.innerHTML = html;

//       // Handle and re-run <script> tags
//       const scripts = container.querySelectorAll("script");
//       scripts.forEach(oldScript => {
//         const newScript = document.createElement("script");
//         if (oldScript.src) {
//           // External script
//           newScript.src = oldScript.src;
//         } else {
//           // Inline script
//           newScript.textContent = oldScript.textContent;
//         }
//         document.body.appendChild(newScript);
//         oldScript.remove();
//       });
      
//     })
//     .catch(error => {
//       console.error('Error:', error);
//       alert("Failed to load reservation content.");
//     });
// });


// document.getElementById("dashboard-link").addEventListener("click", function(e) {
//   e.preventDefault(); // Stop the hash navigation

//   fetch('dashboard_content.php')
//     .then(response => {
//       if (!response.ok) {
//         throw new Error('Network error while loading.');
//       }
//       return response.text();
//     })
//     .then(data => {
//       document.getElementById("main-content").innerHTML = data;
//     })
//     .catch(error => {
//       console.error('Error:', error);
//       alert("Failed to load reservation content.");
//     });
// });

