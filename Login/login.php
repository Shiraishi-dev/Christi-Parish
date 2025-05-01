<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Please enter both username and password.";
        exit();
    }

    // Query the user by username
    $stmt = $conn->prepare("SELECT password, user_type_id FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Redirect based on user_type_id
            if ($user['user_type_id'] == 1) {
                header("Location: wedding.admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "Incorrect password.";
            exit();
        }
    } else {
        echo "User not found.";
        exit();
    }
}
?>
