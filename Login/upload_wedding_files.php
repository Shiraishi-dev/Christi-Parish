<?php
include('config.php'); // Make sure DB connection is here

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
$wife_first = $_POST['wife_first_name'];
$wife_middle = $_POST['wife_middle_name'];
$wife_last = $_POST['wife_last_name'];
$wife_age = $_POST['wife_age'];

$husband_first = $_POST['husband_first_name'];
$husband_middle = $_POST['husband_middle_name'];
$husband_last = $_POST['husband_last_name'];
$husband_age = $_POST['husband_age'];

// Upload files
$marriage_license = uploadFile("marriage_license");
$application_form = uploadFile("application_form");
$birth_certificates = uploadFile("birth_certificates");
$certificate_of_no_marriage = uploadFile("certificate_of_no_marriage");
$community_tax_certificate = uploadFile("community_tax_certificate");
$parental_consent_advice = uploadFile("parental_consent_advice");
$valid_ids = uploadFile("valid_ids");
$barangay_certificate = uploadFile("barangay_certificate");
$canonical_interview = uploadFile("canonical_interview");

$event_type = "Wedding"; 

// Save to database
if ($conn) {
    $sql = "INSERT INTO wedding_applications (
        wife_first_name, wife_middle_name, wife_last_name, wife_age,
        husband_first_name, husband_middle_name, husband_last_name, husband_age,
        marriage_license, application_form, birth_certificates, certificate_of_no_marriage,
        community_tax_certificate, parental_consent_advice, valid_ids,
        barangay_certificate, canonical_interview, event_type
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissssssssssssss",
        $wife_first, $wife_middle, $wife_last, $wife_age,
        $husband_first, $husband_middle, $husband_last, $husband_age,
        $marriage_license, $application_form, $birth_certificates, $certificate_of_no_marriage,
        $community_tax_certificate, $parental_consent_advice, $valid_ids,
        $barangay_certificate, $canonical_interview, $event_type
    );

    global $submissionMessage;
    if ($stmt->execute()) {
        $submissionMessage = "Application submitted successfully!";
    } else {
        $submissionMessage = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $submissionMessage = "Database connection failed.";
}
?>
