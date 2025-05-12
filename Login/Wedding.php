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
    include('upload_wedding_files.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Wedding Form</title>
    <link rel="stylesheet" href="styles/Wedding.css" />
</head>
<body>
    <a href="index1.php" class="go-back">GO BACK</a>
    <h1 class="title">Wedding</h1>

    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <div class="attachment-section">
                <h2>Attachment Requirements</h2>
                <div class="attachments">
                    <label>Marriage License<br /><input type="file" name="marriage_license" required /></label>
                    <label>Application Form<br /><input type="file" name="application_form" required /></label>
                    <label>Birth Certificates<br /><input type="file" name="birth_certificates" required /></label>
                    <label>Certificate of No Marriage<br /><input type="file" name="certificate_of_no_marriage" required /></label>
                    <label>Community Tax Certificate<br /><input type="file" name="community_tax_certificate" required /></label>
                    <label>Parental Consent/Advice<br /><input type="file" name="parental_consent_advice" /></label>
                    <label>Valid IDs<br /><input type="file" name="valid_ids" required /></label>
                    <label>Barangay Certificate<br /><input type="file" name="barangay_certificate" required /></label>
                    <label>Canonical Interview<br /><input type="file" name="canonical_interview" required /></label>
                </div>
            </div>

            <div class="form-section">
                <h2>Fill up this form</h2>
                <h3>Wife Information</h3>
                <div class="form-row">
                   <input type="text" name="wife_first_name" placeholder="Wife's First Name" required>
                   <input type="text" name="wife_middle_name" placeholder="Wife's First Name" required>
                   <input type="text" name="wife_last_name" placeholder="Wife's First Name" required>
                   <input type="number" name="wife_age" placeholder="Wife Age" required>
                </div>
                <h3>Husband Information</h3>
                <div class="form-row">
                   <input type="text" name="husband_first_name" placeholder="Husband's First Name" required>
                   <input type="text" name="husband_middle_name" placeholder="Husband's First Name" required>
                   <input type="text" name="husband_last_name" placeholder="Husband's First Name" required>
                   <input type="number" name="husband_age" placeholder="Husband Age" required>
                </div>
                <button type="submit" class="submit-btn">SUBMIT</button>
        </form>
    </div>
</body>
</html>
<?php if (!empty($submissionMessage)): ?>
<script>
    alert("<?php echo addslashes($submissionMessage); ?>");
</script>
<?php endif; ?>
