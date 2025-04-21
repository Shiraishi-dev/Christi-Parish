<?php

include "connect.php"

if($_SERVER["REQUES_METHOD"]=="POST") {

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$email = mysqli_real_escape_string($conn, $_POST['Email']);

$checkEmail = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($checkEmail)

if($result->num_rows > 0) {
    echo "Email already has a account";
}

else {
    echo "Create account now";
}


$hashed_password = password_hash($password, PASSWORD_BCRYPT);


$sql = "INSERT INTO user_account(username,password,Email) VALUES ('$username','$password'.'$email'");






}

?>