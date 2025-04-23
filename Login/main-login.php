<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corpus Christi Parish</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="main-login.css">
    <link rel="stylesheet" href="design-main.css">
</head>
<body>
    <!-- Login Section -->
    <div class="login-form <?= isActiveForm('login',$activeForm); ?>" id="login-section">
        <h1>Login</h1>
        <div class="container">
            <div class="main">
                <div class="content active" id="login-form">
                    <h2>Log In</h2>
                    <form action="register.php" method="POST">
                        <?= showError($errors['login']); ?>
                        <input type="text" name="username" placeholder="Username" required autofocus>
                        <input type="password" name="password" placeholder="Password" required>
                        <button class="btn" type="submit" name="login">Login</button>
                    </form>
                    <p class="account">Don't have an account? <a href="#" onclick="showForm('register')">Register</a></p>
                    <a href="index.php">Home</a>
                </div>
                <div class="form-img">
                    <img src="logo.jpg" class="img">
                </div>
            </div>
        </div>
    </div>

    <!-- Register Section -->
    <div class="login-form <?= isActiveForm('register',$activeForm); ?>" id="register-section" style="display: none;">
        <h1>Create Account</h1>
        <div class="container">
            <div class="main">
                <div class="content">
                    <h2>Create Account</h2>
                    <form action="login_register.php" method="POST">
                        <?= showError($errors['register']); ?>
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="email" name="Email" placeholder="Email" required>
                        <button class="btn" type="submit" name="register">Create</button>
                    </form>
                    <p class="account">Already have an account? <a href="#" onclick="showForm('login')">Login</a></p>
                    <a href="index.php">Home</a>
                </div>
                <div class="form-img">
                    <img src="logo.jpg" class="img">
                </div>
            </div>
        </div>
    </div>

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
