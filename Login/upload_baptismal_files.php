<?php
include('config.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function uploadFile($field) {
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === 0) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $uniqueId = uniqid('', true); // More unique than time()
        $filename = $uniqueId . '_' . basename($_FILES[$field]["name"]);
        $targetFile = $targetDir . $filename;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Allow only specific file types
        $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array($fileType, $allowedTypes)) {
            return null;
        }

        if (move_uploaded_file($_FILES[$field]["tmp_name"], $targetFile)) {
            return $targetFile;
        }
    }
    return null;
}

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('User not logged in.'); window.location.href='index.php';</script>";
    exit();
}

$username = $_SESSION['username'];

// Fetch user_id
$userQuery = $conn->prepare("SELECT user_id FROM user WHERE username = ?");
$userQuery->bind_param("s", $username);
$userQuery->execute();
$result = $userQuery->get_result();
$user = $result->fetch_assoc();
$userQuery->close();

if (!$user) {
    echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $user['user_id'];

// Collect form data
$child_first        = $_POST['child_first_name'];
$child_middle       = $_POST['child_middle_name'];
$child_last         = $_POST['child_last_name'];
$child_birth_date   = $_POST['child_birth_date'];
$date_of_baptism    = $_POST['date_of_baptism'];

$father_first       = $_POST['father_first_name'];
$father_middle      = $_POST['father_middle_name'];
$father_last        = $_POST['father_last_name'];

$mother_first       = $_POST['mother_first_name'];
$mother_middle      = $_POST['mother_middle_name'];
$mother_last        = $_POST['mother_last_name'];

// Upload attachments
$birth_certificate                = uploadFile("birth_certificate");
$marriage_certificate_of_parents = uploadFile("marriage_certificate_of_parents");
$baptismal_seminar_certificate   = uploadFile("baptismal_seminar_certificate");
$sponsor_list                    = uploadFile("sponsor_list");
$valid_ids                       = uploadFile("valid_ids");
$barangay_certificate            = uploadFile("barangay_certificate");
$canonical_interview             = uploadFile("canonical_interview");

// Check if all required files were uploaded
if (!$birth_certificate || !$marriage_certificate_of_parents || !$baptismal_seminar_certificate ||
    !$sponsor_list || !$valid_ids || !$barangay_certificate || !$canonical_interview) {
    echo "<script>alert('Please ensure all required files are uploaded successfully.'); window.history.back();</script>";
    exit();
}

$event_type = "baptism";

// Insert into database
if ($conn) {
    $sql = "INSERT INTO baptismal_bookings (
                child_first_name, child_middle_name, child_last_name, child_birth_date,
                father_first_name, father_middle_name, father_last_name,
                mother_first_name, mother_middle_name, mother_last_name,
                birth_certificate, marriage_certificate_of_parents, baptismal_seminar_certificate,
                sponsor_list, valid_ids, barangay_certificate, canonical_interview,
                event_type, user_id, date_of_baptism, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssssssssis",
        $child_first, $child_middle, $child_last, $child_birth_date,
        $father_first, $father_middle, $father_last,
        $mother_first, $mother_middle, $mother_last,
        $birth_certificate, $marriage_certificate_of_parents, $baptismal_seminar_certificate,
        $sponsor_list, $valid_ids, $barangay_certificate, $canonical_interview,
        $event_type, $user_id, $date_of_baptism
    );

    if ($stmt->execute()) {
        echo "<script>alert('Baptismal request submitted successfully!'); window.location.href='index1.php';</script>";
    } else {
        error_log("Database error on baptism submission: " . $stmt->error);
        echo "<script>alert('An unexpected error occurred. Please try again later.');</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Database connection failed.');</script>";
}
?>
