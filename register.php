<?php

session_start();

include_once "userdata.php";

$pdo=new PDO($dsn, $dbuser, $dbpass);

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeatpassword = $_POST['repeatpassword'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    if ($_POST['password'] == $_POST['repeatpassword']) {
        $password = md5($password);
        $sql = "INSERT INTO userdata (`password`, `email`, `username`, `firstname`, `lastname`)
                VALUES ('$password', '$email', '$username', '$firstname', '$lastname')";
        $pdo->exec($sql);
        echo "New record created successfully";
    } if ($_POST['password'] != $_POST['repeatpassword']){
          echo "Bestätigen Sie Ihr Passwort.";
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>"Name" | Registrierung</title>
</head>
<body>
<h1>Registrieren Sie sich.</h1>
<form action="register.php" method="post">
    <label> <b>Username</b></label>
    <input type="text" name="username" placeholder="Username" required>
    <br>
    <label> <b>Password</b></label>
    <input type="password" name="password" placeholder="Password" required>
    <br>
    <label> <b>Please repeat your password</b></label>
    <input type="password" name="repeatpassword" placeholder="Repeat your password" required>
    <br>
    <label> <b>E-Mail</b></label>
    <input type="text" name="email" placeholder="E-mail" required>
    <br>
    <label> <b>First name</b></label>
    <input type="text" name="firstname" placeholder="First name" required>
    <br>
    <label> <b>Last name</b></label>
    <input type="text" name="lastname" placeholder="Last name" required>
    <br>
    <button type="submit" name="register" class="btn">Register</button>
    <br>
    <p>Already have an account? <a href="login.html">Sign in</a>.</p>
</form>
</body>
</html>
