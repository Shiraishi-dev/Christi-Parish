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
    include('upload_baptismal_files.php'); // Make sure this file handles the logic correctly
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Baptismal Form</title>
    <link rel="stylesheet" href="styles/Wedding.css" />
    <style>
        /* Additional styling to help layout if not present in Wedding.css */
        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }

        .form-section, .attachment-section {
            margin-bottom: 30px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .form-row input {
            flex: 1;
            min-width: 200px;
        }

        .attachments label {
            display: block;
            margin-bottom: 10px;
        }

        .submit-btn {
            margin-top: 20px;
            padding: 10px 20px;
        }

        h2, h3 {
            margin-bottom: 10px;
        }

        .go-back {
            display: inline-block;
            margin: 15px;
            text-decoration: none;
        }

    </style>
</head>
<body>
    <a href="index1.php" class="go-back">GO BACK</a>
    <h1 class="title">Baptismal</h1>

    <div class="container">
        <form method="POST" enctype="multipart/form-data">

            <!-- Attachments -->
            <div class="attachment-section">
                <h2>Attachment Requirements</h2>
                <div class="attachments">
                    <label>Birth Certificate<br><input type="file" name="birth_certificate" required></label>
                    <label>Marriage Certificate of Parents<br><input type="file" name="marriage_certificate_of_parents" required></label>
                    <label>Baptismal Seminar Certificate<br><input type="file" name="baptismal_seminar_certificate" required></label>
                    <label>Sponsor List<br><input type="file" name="sponsor_list" required></label>
                    <label>Valid IDs<br><input type="file" name="valid_ids" required></label>
                    <label>Barangay Certificate<br><input type="file" name="barangay_certificate" required></label>
                    <label>Canonical Interview<br><input type="file" name="canonical_interview" required></label>
                </div>
            </div>

            <!-- Form -->
            <div class="form-section">
                <h2>Fill up this form</h2>

                <!-- Child Info -->
                <h3>Child Information</h3>
                <div class="form-row">
                    <input type="text" name="child_first_name" placeholder="Child's First Name" required>
                    <input type="text" name="child_middle_name" placeholder="Child's Middle Name">
                    <input type="text" name="child_last_name" placeholder="Child's Last Name" required>
                </div>
                <div class="form-row">
                    <input type="date" name="child_birth_date" required>
                </div>

                <!-- Father's Info -->
                <h3>Father's Information</h3>
                <div class="form-row">
                   <input type="text" name="father_first_name" placeholder="Father's First Name" required>
                   <input type="text" name="father_middle_name" placeholder="Father's First Name" required>
                   <input type="text" name="father_last_name" placeholder="Father's First Name" required>
                </div>
                <h3>Mother's Information</h3>
                <div class="form-row">
                   <input type="text" name="mother_first_name" placeholder="Father's First Name" required>
                   <input type="text" name="mother_middle_name" placeholder="Father's First Name" required>
                   <input type="text" name="mother_last_name" placeholder="Father's First Name" required>
                </div>
                <button type="submit" class="submit-btn">SUBMIT</button>
    </div>
</body>
</html>
                   
                    
