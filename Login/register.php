<?php
session_start();
include 'config.php'; // Make sure this connects to your DB

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['Email']);

    if (empty($username) || empty($password) || empty($email)) {
        $errors['register'] = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors['register'] = "Username already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashedPassword, $email);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Account created successfully!";
                header("Location: index.php");
                exit();
            } else {
                $errors['register'] = "Registration failed. Please try again.";
            }
        }

        $stmt->close();
    }
}

$_SESSION['errors'] = $errors;
header("Location: index.php");
exit();
?>
