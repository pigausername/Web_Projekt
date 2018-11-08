<?php
session_start();

require_once "userdata.php";
if(!isset($_SESSION["angemeldet"]))
{
    echo"nicht angemeldet.";

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
              WHERE userid=:$userid";
        $pdo->exec($sql);
        //header("Location: index.html");
        echo "bla.";
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
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="username" placeholder="Username" required></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" placeholder="Password" required></td>
        </tr>
        <tr>
            <td>Please repeat your new password:</td>
            <td><input type="password" name="repeatpassword" placeholder="Repeat your password" required></td>
        </tr>
        <tr>
            <td>E-Mail:</td>
            <td><input type="text" name="email" placeholder="E-mail" required></td>
        </tr>
        <tr>
            <td>First name:</td>
            <td><input type="text" name="firstname" placeholder="First name" required></td>
        </tr>
        <tr>
            <td>Last name:</td>
            <td><input type="text" name="lastname" placeholder="Last name" required></td>
        </tr>
        <tr>
            <td>Profile picture:</td>
            <td><input type="file" name="pic"</td>
        </tr>
        <tr>
            <td><button type="submit" name="save" class="btn">Save changes</button></td>
        </tr>
    </table>
</form>
</body>
</html>