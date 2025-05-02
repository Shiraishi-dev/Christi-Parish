<?php
include('config.php'); // DB connection

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

// Safely retrieve POST data
$deceased_name   = $_POST['deceased_name'];
$date_of_death   = $_POST['date_of_death'];
$place_of_death  = $_POST['place_of_death'];
$date_of_burial  = $_POST['date_of_burial'];
$funeral_home    = $_POST['funeral_home'];

// Upload attachments
$death_certificate    = uploadFile("death_certificate");
$barangay_clearance   = uploadFile("barangay_clearance");
$valid_id             = uploadFile("valid_id");
$event_type = "burial";

// Insert into database if all required fields are present
if ($deceased_name, $date_of_death, $place_of_death, $date_of_burial, $funeral_home, $event_type) {
    if ($conn) {
        $sql = "INSERT INTO burial_requirements (
                    deceased_name, date_of_death, place_of_death,
                    date_of_burial, funeral_home,
                    death_certificate, barangay_clearance, valid_id, event_type
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssssss",
            $deceased_name, $date_of_death, $place_of_death,
            $date_of_burial, $funeral_home,
            $death_certificate, $barangay_clearance, $valid_id
        );

        if ($stmt->execute()) {
            $submissionMessage = "Burial request submitted successfully!";
        } else {
            $submissionMessage = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        $submissionMessage = "Database connection failed.";
    }
} else {
    $submissionMessage = "Please complete all required fields.";
}
?>
