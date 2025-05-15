<?php
include('config.php');
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>window.open('login.php','_self')</script>";
    exit();
}

$username = $_SESSION['username'];
$submissionMessage = '';
$errors = [];

// Fetch approved burial dates
$approvedDates = [];
$result = $conn->query("SELECT date_of_burial FROM burial_requirements WHERE status = 'approved'");
while ($row = $result->fetch_assoc()) {
    $approvedDates[] = $row['date_of_burial'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chosen_date = $_POST['date_of_burial'];
    $dayOfWeek = date('w', strtotime($chosen_date));

    if ($dayOfWeek == 0 || $dayOfWeek == 6) {
        $errors[] = "Weekends are not allowed.";
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM burial_requirements WHERE date_of_burial = ? AND status = 'approved'");
    $stmt->bind_param("s", $chosen_date);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $errors[] = "This date is already booked.";
    }

    if (empty($errors)) {
        include('upload_burial_files.php');
        $submissionMessage = "Burial request submitted successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Burial Form</title>
    <link rel="stylesheet" href="styles/Wedding.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <a href="index1.php" class="go-back">GO BACK</a>
    <h1 class="title">Burial Request Form</h1>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($submissionMessage)): ?>
        <div class="submission-message" style="color: green;"><?= htmlspecialchars($submissionMessage) ?></div>
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
                    <span>Date of Death: </span><br><input type="text" id="death_date" name="date_of_death" required>
                    <span>Place of Death: </span><br><input type="text" name="place_of_death" placeholder="Place of Death" required>
                    <span>Date of Funeral: </span><br><input type="text" id="burial_date" name="date_of_burial" required>
                    <span>Funeral Home: </span><br><input type="text" name="funeral_home" placeholder="Funeral Home Name" required>
                </div>
                <button type="submit" class="submit-btn">SUBMIT</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    const approvedDates = <?= json_encode($approvedDates); ?>;

    // Funeral Date Picker with validation
    flatpickr("#burial_date", {
        minDate: "today",
        dateFormat: "Y-m-d",
        disable: [
            function(date) {
                const day = date.getDay();
                const localDate = date.toLocaleDateString('en-CA'); // Ensures YYYY-MM-DD format
                return (day === 0 || day === 6 || approvedDates.includes(localDate));
            }
        ],
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            const dateStr = dayElem.dateObj.toLocaleDateString('en-CA');
            const day = dayElem.dateObj.getDay();

            if (day === 0 || day === 6) {
                dayElem.classList.add("weekend");
            }

            if (approvedDates.includes(dateStr)) {
                dayElem.classList.add("approved-date");
            }
        }
    });

    // Death Date Picker (just styled)
    flatpickr("#death_date", {
        maxDate: "today",
        dateFormat: "Y-m-d"
    });
</script>
