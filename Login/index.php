<?php
include('config.php');
session_start(); // Start the session

// Login Logic
if(isset($_POST['login'])) {
    $username = $con->real_escape_string($_POST['username']);
    $password = $con->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = $con->query($sql);

    if($result->num_rows > 0) {
        // Save the username in the session
        $_SESSION['username'] = $username;
        echo "<script>window.open('user.php','_self')</script>";
    } else {
        echo "<script>alert('Invalid username or password!')</script>";
    }
}

// Register Logic
if(isset($_POST['register'])) {
    $fullname = $con->real_escape_string($_POST['fullname']);
    $email = $con->real_escape_string($_POST['email']);
    $mobile = $con->real_escape_string($_POST['mobile_number']);
    $username = $con->real_escape_string($_POST['username']);
    $password = $con->real_escape_string($_POST['password']);

    // Using prepared statement to avoid SQL injection
    $sql = $con->prepare("INSERT INTO user (fullname, email, username, password, mobile_number) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sssss", $fullname, $email, $username, $password, $mobile);
    
    if($sql->execute()) {
        echo "<script>alert('Successfully Registered!')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    } else {
        echo "<script>alert('Error: " . $sql->error . "')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Corpus Christi Parish</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/main-login.css">
    <link rel="stylesheet" href="styles/design-main.css">
</head>
<body>

<!-- Login Section -->
<div class="login-form" id="login-section">
    <h1>Login</h1>
    <div class="container">
        <div class="main">
            <div class="content active" id="login-form">
                <h2>Log In</h2>
                <form method="POST">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <button class="btn" type="submit" name="login">Login</button>
                </form>
                <p class="account">Don't have an account? <a href="#" onclick="showForm('register')">Register</a></p>
                <a href="index.php">Home</a>
            </div>
            <div class="form-img">
                <img src="includes/logo.jpg" class="img">
            </div>
        </div>
    </div>
</div>

<!-- Register Section -->
<div class="login-form" id="register-section" style="display: none;">
    <h1>Create Account</h1>
    <div class="container">
        <div class="main">
            <div class="content">
                <h2>Create Account</h2>
                <form method="POST">
                    <input type="text" name="fullname" placeholder="Full Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="mobile_number" placeholder="Mobile Number" required>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button class="btn" type="submit" name="register">Create</button>
                </form>
                <p class="account">Already have an account? <a href="#" onclick="showForm('login')">Login</a></p>
                <a href="index.php">Home</a>
            </div>
            <div class="form-img">
                <img src="includes/logo.jpg" class="img">
            </div>
        </div>
    </div>
</div>

<!-- JS Form Toggle -->
<script>
    function showForm(form) {
        const login = document.getElementById('login-section');
        const register = document.getElementById('register-section');

        if (form === 'register') {
            login.style.display = 'none';
            register.style.display = 'block';
        } else {
            login.style.display = 'block';
            register.style.display = 'none';
        }
    }
</script>

</body>
</html>
