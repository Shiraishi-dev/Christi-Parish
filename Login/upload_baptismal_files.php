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
        $filename = time() . '_' . basename($_FILES[$field]["name"]);
        $targetFile = $targetDir . $filename;
        if (move_uploaded_file($_FILES[$field]["tmp_name"], $targetFile)) {
            return $targetFile;
        }
    }
    return null;
}

// Get current logged-in username
if (!isset($_SESSION['username'])) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit();
}

$username = $_SESSION['username'];

// Fetch user_id from username
$userQuery = $conn->prepare("SELECT user_id FROM user WHERE username = ?");
$userQuery->bind_param("s", $username);
$userQuery->execute();
$result = $userQuery->get_result();
$user = $result->fetch_assoc();
$userQuery->close();

if (!$user) {
    echo "<script>alert('User not found.');</script>";
    exit();
}

$user_id = $user['user_id'];

// Collect form data
$child_first        = $_POST['child_first_name'];
$child_middle       = $_POST['child_middle_name'];
$child_last         = $_POST['child_last_name'];
$child_birth_date   = $_POST['child_birth_date'];

$father_first       = $_POST['father_first_name'];
$father_middle      = $_POST['father_middle_name'];
$father_last        = $_POST['father_last_name'];

$mother_first       = $_POST['mother_first_name'];
$mother_middle      = $_POST['mother_middle_name'];
$mother_last        = $_POST['mother_last_name'];

// Upload attachments
$birth_certificate               = uploadFile("birth_certificate");
$marriage_certificate_of_parents = uploadFile("marriage_certificate_of_parents");
$baptismal_seminar_certificate   = uploadFile("baptismal_seminar_certificate");
$sponsor_list                    = uploadFile("sponsor_list");
$valid_ids                       = uploadFile("valid_ids");
$barangay_certificate            = uploadFile("barangay_certificate");
$canonical_interview             = uploadFile("canonical_interview");

$event_type = "baptism";

// Insert into database (NOW includes user_id!)
if ($conn) {
    $sql = "INSERT INTO baptismal_bookings (
                child_first_name, child_middle_name, child_last_name, child_birth_date,
                father_first_name, father_middle_name, father_last_name,
                mother_first_name, mother_middle_name, mother_last_name,
                birth_certificate, marriage_certificate_of_parents, baptismal_seminar_certificate,
                sponsor_list, valid_ids, barangay_certificate, canonical_interview,
                event_type, user_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssssssssi",
        $child_first, $child_middle, $child_last, $child_birth_date,
        $father_first, $father_middle, $father_last,
        $mother_first, $mother_middle, $mother_last,
        $birth_certificate, $marriage_certificate_of_parents, $baptismal_seminar_certificate,
        $sponsor_list, $valid_ids, $barangay_certificate, $canonical_interview,
        $event_type, $user_id
    );

    if ($stmt->execute()) {
        echo "<script>alert('Baptismal request submitted successfully!')</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Database connection failed.');</script>";
}
?>
