<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="styles/test-admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="side-header">
      <img src="includes/logo.jpg" alt="logo">
      <h2 class="title-a">Corpus Christi Parish</h2>
    </div>

    <ul class="sidebar-links">
      <h4><span>Book Request</span></h4>
      <li><a href="wedding.admin.php"><span class="material-symbols-outlined">concierge</span>Wedding</a></li>
      <li><a href="baptismal.admin.php"><span class="material-symbols-outlined">concierge</span>Baptismal</a></li>
      <li><a href="burial.admin.php"><span class="material-symbols-outlined">concierge</span>Burial</a></li>
      <h4><span>Menu</span></h4>
      <li><a href="pending.book.admin.php"><span class="material-symbols-outlined">pending_actions</span>Pending Booked</a></li>
      <li><a href="Scheduled.admin.php"><span class="material-symbols-outlined">event</span>Events Schedule</a></li>
      <li><a href="index.php"><span class="material-symbols-outlined">logout</span>Logout</a></li>
    </ul>

    <div class="user-account">
      <div class="user-profile">
        <img src="includes/profile.jpg" alt="profile-img">
        <div class="user-detail">
          <h3>Escobido, Kim L.</h3>
          <span>Admin</span>
        </div>
      </div>
    </div>
  </aside>

  <!-- Top Bar -->
  <div class="top1"></div>

  <!-- Main Content -->
  <div class="client-requests">
    <h2>Wedding Book Request List</h2>

    <div class="request-card">
      <h3>John Doe</h3>
      <p><strong>Service:</strong> Wedding</p>
      <p><strong>Date:</strong> May 5, 2025</p>
      <p><strong>Status:</strong> Pending</p>
      <p><strong>MBL:</strong> 09095267296</p>
      <button class="view-more-btn">View More</button>
    </div>

    <div class="request-card">
      <h3>Jane Smith</h3>
      <p><strong>Service:</strong> Baptismal</p>
      <p><strong>Date:</strong> June 10, 2025</p>
      <p><strong>Status:</strong> Approved</p>
      <p><strong>MBL:</strong> 09917398085</p>
      <button class="view-more-btn">View More</button>
    </div>

    

  </div>

  <!-- Popup Modal -->
  <div class="modal" id="infoModal">
    <div class="modal-content">
      <span class="close-button" id="closeModal">&times;</span>
      <h2 id="modalClientName">Client Name</h2>
      <p><strong>Service:</strong> <span id="modalService"></span></p>
      <p><strong>Date:</strong> <span id="modalDate"></span></p>
      <p><strong>Status:</strong> <span id="modalStatus"></span></p>
      <p><strong>MBL:</strong> <span id="modalNumber"></span></p>
      <p><strong>Additional Info:</strong> <span id="modalAdditional"></span></p>
      <button class="confirm">Confirm</button>
      <button class="delete">Delete</button>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    const modal = document.getElementById('infoModal');
    const closeModal = document.getElementById('closeModal');

    const viewButtons = document.querySelectorAll('.view-more-btn');

    viewButtons.forEach(button => {
      button.addEventListener('click', function() {
        const card = button.parentElement;
        document.getElementById('modalClientName').textContent = card.querySelector('h3').textContent;
        document.getElementById('modalService').textContent = card.querySelector('p:nth-of-type(1)').textContent.replace('Service: ', '');
        document.getElementById('modalDate').textContent = card.querySelector('p:nth-of-type(2)').textContent.replace('Date: ', '');
        document.getElementById('modalStatus').textContent = card.querySelector('p:nth-of-type(3)').textContent.replace('Status: ', '');
        document.getElementById('modalNumber').textContent = card.querySelector('p:nth-of-type(4)').textContent.replace('MBL: ', '');
        document.getElementById('modalAdditional').textContent = "Additional details about the client request..."; // You can update this part

        modal.style.display = "block";
      });
    });

    closeModal.addEventListener('click', function() {
      modal.style.display = "none";
    });

    window.addEventListener('click', function(event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });
  </script>

</body>
</html>
