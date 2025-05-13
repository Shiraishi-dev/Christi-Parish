<?php
include('config.php'); // DB connection

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>window.open('login.php','_self')</script>";
    exit();
}

// Fetch the username from session
$username = $_SESSION['username'];

// Get the user_id from the user table
$user_id = null;
$userQuery = $conn->prepare("SELECT user_id FROM user WHERE username = ?");
$userQuery->bind_param("s", $username);
$userQuery->execute();
$userResult = $userQuery->get_result();
if ($userRow = $userResult->fetch_assoc()) {
    $user_id = $userRow['user_id'];
}
$userQuery->close();

// If user_id is still null, stop the script
if (!$user_id) {
    die("User not found.");
}

function uploadFile($field) {
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === 0) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $filename = time() . '_' . basename($_FILES[$field]["name"]);
        $targetFile = $targetDir . $filename;
        if (move_uploaded_file($_FILES[$field]["tmp_name"], $targetFile)) {
            return $targetFile;
        }
    }
    return null;
}

// Collect form data
$deceased_name   = $_POST['deceased_name'];
$date_of_death   = $_POST['date_of_death'];
$place_of_death  = $_POST['place_of_death'];
$date_of_burial  = $_POST['date_of_burial'];
$funeral_home    = $_POST['funeral_home'];

$event_type = "burial";

// Upload attachments
$death_certificate    = uploadFile("death_certificate");
$barangay_clearance   = uploadFile("barangay_clearance");
$valid_id             = uploadFile("valid_id");

// Insert into database
if ($conn) {
    $sql = "INSERT INTO burial_requirements (
                user_id, deceased_name, date_of_death, place_of_death,
                date_of_burial, funeral_home,
                death_certificate, barangay_clearance, valid_id, event_type
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssssssss",
        $user_id, $deceased_name, $date_of_death, $place_of_death,
        $date_of_burial, $funeral_home,
        $death_certificate, $barangay_clearance, $valid_id, $event_type
    );
    
    if ($stmt->execute()) {
        echo "<script>alert('Burial request submitted successfully!')</script>";
    } else {
        $submissionMessage = "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    $submissionMessage = "Database connection failed.";
}
?>
