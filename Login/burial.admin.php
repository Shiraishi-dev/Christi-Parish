<?php
include('config.php'); 
session_start(); // Start the session


if (!isset($_SESSION['username'])) {
    echo "<script>window.open(.php','_self')</script>";
    exit(); 
}

$username = $_SESSION['username']; 

$results = [];

if ($conn) {
    $sql = "SELECT id, deceased_name, date_of_death, place_of_death,date_of_burial, funeral_home, death_certificate, barangay_clearance, valid_id, created_at FROM burial_requirments WHERE event_type='burial'";
    $query = $conn->query($sql);

    if ($query && $query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $results[] = $row;
        }
    }

    $conn->close();
}
?>

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
      <li><a href="baptismal.admin.php" class="active"><span class="material-symbols-outlined">concierge</span>Baptismal</a></li>
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
          <h3><?php echo htmlspecialchars($username); ?></h3>
          <span>Admin</span>
        </div>
      </div>
    </div>
  </aside>

  <!-- Top Bar -->
  <div class="top1"></div>

  <!-- Main Content -->
  <div class="client-requests">
    <h2>Burial Book Request List</h2>

    <?php if (!empty($results)): ?>
      <?php foreach ($results as $row): ?>
        <div class="request-card">
          <h3>
            <?= htmlspecialchars($row['deceased_name']) ?>
        </h3>
        <a href="baptismal.details.php?id=<?= $row['id'] ?>" class="view-more-btn">View More</a>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>No baptismal applications found.</p>
<?php endif; ?>

  </div>

</body>
</html>
