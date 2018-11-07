<?php
session_start();

include_once "userdata.php";

$pdo=new PDO($dsn, $dbuser, $dbpass);

$sql = "UPDATE users SET password='$password', email='$email', username='$username', firstname='$firstname', lastname='$lastname'
WHERE userid=2";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit your profile</title>
</head>
<body>
<h1>Here you can edit your profile.</h1>
<form action="profile_edit.php" method="post">
    <label> <b>Username</b></label>
    <input type="text" name="username" placeholder="Username" required>
    <br>
    <label> <b>Password</b></label>
    <input type="password" name="password" placeholder="Password" required>
    <br>
    <label> <b>Please repeat your new password</b></label>
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
    <button type="submit" name="save" class="btn">Save changes</button>
</form>
</body>
</html>