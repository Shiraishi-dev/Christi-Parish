<?php
include('config.php');
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not, redirect them to the login page
    echo "<script>window.open(.php','_self')</script>";
    exit(); // Ensure the rest of the page doesn't load
}

// Get the logged-in username
$username = $_SESSION['username'];

$submissionMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('upload_burial_files.php'); // This script will handle DB insert and file upload
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Burial Form</title>
    <link rel="stylesheet" href="styles/Wedding.css" />
</head>
<body>
    <a href="index1.php" class="go-back">GO BACK</a>
    <h1 class="title">Burial Request Form</h1>

    <?php if (!empty($submissionMessage)): ?>
        <div class="submission-message"><?= htmlspecialchars($submissionMessage) ?></div>
    <?php endif; ?>

    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <div class="attachment-section">
                <h2>Attachment Requirements</h2>
                <div class="attachments">
                    <label>Death Certificate<br /><input type="file" name="death_certificate" required /></label>
                    <label>Barangay Clearance<br /><input type="file" name="barangay_clearance" required /></label>
                    <label>Valid ID of Informant<br /><input type="file" name="valid_id" required /></label>
                </div>
            </div>

            <div class="form-section">
                <h2>Deceased Information</h2>
                <div class="form-row">
                    <span>Deceased Name: </span><br><input type="text" name="deceased_name" placeholder="Full Name of Deceased" required>
                    <span>Date of Death: </span><br><input type="date" name="date_of_death" placeholder="Date of Death" required>
                    <span>Place of Death: </span><br><input type="text" name="place_of_death" placeholder="Place of Death" required>
                    <span>Date of Funeral: </span><br><input type="date" name="date_of_burial" placeholder="Date of Burial" required>
                    <span>Funeral Home: </span><br><input type="text" name="funeral_home" placeholder="Funeral Home Name" required>
                </div>
                <button type="submit" class="submit-btn">SUBMIT</button>
            </div>
        </form>
    </div>
</body>
</html>
