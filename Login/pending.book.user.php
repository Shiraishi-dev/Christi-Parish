<?php
include('config.php');
session_start(); // Start the session

if (!isset($_SESSION['username'])) {
    echo "<script>window.open('login.php','_self')</script>";
    exit(); 
}

$username = $_SESSION['username']; 
$results = [];

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
}

$stmt->close();
$conn->close();
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
      <img src="includes/logo.jpg" alt="Corpus Christi Parish Logo">
      <h2 class="title-a">Corpus Christi Parish</h2>
    </div>

    <ul class="sidebar-links">
      <h4><span>Menu</span></h4>
      <li><a href="pending.book.user.php"><span class="material-symbols-outlined">pending_actions</span>Pending</a></li>
      <li><a href="approved.book.user.php"><span class="material-symbols-outlined">done_all</span>Approved Events</a></li>
      <li><a href="user.php"><span class="material-symbols-outlined">home</span>Home</a></li>
      <li><a href="logout.php"><span class="material-symbols-outlined">logout</span>Logout</a></li>
    </ul>

    <div class="user-account">
      <div class="user-profile">
        <img src="includes/logo.jpg" alt="User Profile">
        <div class="user-detail">
          <h3><?php echo htmlspecialchars($username); ?></h3>
          <span>User</span>
        </div>
      </div>
    </div>
  </aside>

  <!-- Top Bar -->
  <div class="top1"></div>

  <!-- Main Content -->
  <div class="client-requests">
    <h2>Your Pending Wedding Applications</h2>

    <?php if (!empty($results)): ?>
      <?php foreach ($results as $row): ?>
        <div class="request-card">
          <h3>
            <?php
              echo htmlspecialchars($row['husband_first_name'] . ' ' . $row['husband_last_name']) . 
                   ' & ' . 
                   htmlspecialchars($row['wife_first_name'] . ' ' . $row['wife_last_name']);
            ?>
          </h3>
          <a href="wedding.details.php?id=<?= $row['id'] ?>" class="view-more-btn">View More</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No pending wedding applications found.</p>
    <?php endif; ?>
  </div>

</body>
</html>
