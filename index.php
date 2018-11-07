<?php
session_start();

require_once "userdata.php";

if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];
}

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

$statement = $pdo->prepare("SELECT * FROM userdata WHERE email=:email AND password=:password");

if($statement->execute(array(':email' => $email, ':password' => $password))) {
    if ($user = $statement->fetch()) {
        $_SESSION["angemeldet"] = $user["id"];
        header("Location: home1.php");
    } else {
        echo "No authorization.";
    }
}
else {
    echo "There is an error in the database.";
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
</head>
<body>
Login:

<form action="index.php" method="post">
    Email: <input type="text" name="email" placeholder="Email"/>
    <br>
Passwort: <input type="text" name="password" placeholder="Password"/>
    <br>
    <input type="submit" name="login" value="Anmeldung">
</form>

<a href="register.php">Register</a><br>

</body>
</html>


