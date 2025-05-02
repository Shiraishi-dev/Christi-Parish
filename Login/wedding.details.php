<?php
include('config.php');

if (!isset($_GET['id'])) {
    echo "No application selected.";
    exit;
}

$id = intval($_GET['id']);
$data = null;

if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM wedding_applications WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}

if (!$data) {
    echo "Application not found.";
    exit;
}

function renderFileField($label, $path) {
    if (!$path) return;

    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    echo "<li><strong>$label:</strong><br>";

    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        echo "<img src=\"$path\" alt=\"$label\" style=\"max-width: 400px; height: auto; border: 1px solid #ccc; margin-bottom: 10px;\">";
    } else {
        echo "<a href=\"$path\" target=\"_blank\">View File</a>";
    }

    echo "</li>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Wedding Application Details</title>
  <link rel="stylesheet" href="styles/test-admin.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
    }

    h2 {
      margin-bottom: 20px;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    ul li {
      margin-bottom: 20px;
    }

    ul li img {
      display: block;
      margin-top: 10px;
      border-radius: 8px;
    }

    a.button {
      display: inline-block;
      background-color: #ba5d5d;
      color: #fff;
      padding: 8px 16px;
      border-radius: 5px;
      text-decoration: none;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <a href="wedding.admin.php" class="button">← Back to List</a>
  <h2>Wedding Application Details</h2>
  <ul>
    <li><strong>Wife:</strong> <?= htmlspecialchars($data['wife_first_name'] . ' ' . $data['wife_middle_name'] . ' ' . $data['wife_last_name']) ?></li>
    <li><strong>Husband:</strong> <?= htmlspecialchars($data['husband_first_name'] . ' ' . $data['husband_middle_name'] . ' ' . $data['husband_last_name']) ?></li>
    <li><strong>Wife Age:</strong> <?= htmlspecialchars($data['wife_age']) ?></li>
    <li><strong>Husband Age:</strong> <?= htmlspecialchars($data['husband_age']) ?></li>
    <li><strong>Event Type:</strong> <?= htmlspecialchars($data['event_type']) ?></li>
    <li><strong>Submitted At:</strong> <?= htmlspecialchars($data['submitted_at']) ?></li>

    <?php
      renderFileField('Marriage License', $data['marriage_license']);
      renderFileField('Application Form', $data['application_form']);
      renderFileField('Birth Certificates', $data['birth_certificates']);
      renderFileField('Certificate of No Marriage', $data['certificate_of_no_marriage']);
      renderFileField('Community Tax Certificate', $data['community_tax_certificate']);
      renderFileField('Parental Consent Advice', $data['parental_consent_advice']);
      renderFileField('Valid IDs', $data['valid_ids']);
      renderFileField('Barangay Certificate', $data['barangay_certificate']);
      renderFileField('Canonical Interview', $data['canonical_interview']);
    ?>
  </ul>

</body>
</html>
