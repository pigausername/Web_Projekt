<?php
session_start();

require_once "userdata.php";
if(!isset($_SESSION["angemeldet"]))
{
    echo"nicht angemeldet.";
    die();
}


$userid=$_GET["userid"];

if (isset($_POST['save'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeatpassword = $_POST['repeatpassword'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    if ($_POST['password'] == $_POST['repeatpassword']) {
        $password = md5($password);
        $sql = "UPDATE users SET password='$password', email='$email', username='$username', firstname='$firstname', lastname='$lastname'
              WHERE userid=:userid";
        $pdo->exec($sql);
        header("Location: index.html");
    }
    }   if ($_POST['password'] != $_POST['repeatpassword']){
        echo "Bestätigen Sie Ihr Passwort.";
}
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