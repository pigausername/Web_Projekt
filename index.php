<?php
session_start();

include_once "header.php";

if (isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $statement = $pdo->prepare("SELECT * FROM userdata WHERE email=:email AND password=:password");
    if($statement->execute (array(':email' => $email, ':password' => $password))) {
        if ($row = $statement->fetch()) {
            //echo "angemeldet";
            $_SESSION["angemeldet"] = $row["userid"];
            header("Location: home1.php");
        } else {
            echo "No authorization.";
        }
    }
    else {
        echo "blabla";
    }
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
    <table>
        <tr>
            <td>Email: </td> <td><input type="text" name="email" placeholder="Email"/></td>
        </tr>
        <tr>
            <td>Passwort: </td> <td><input type="password" name="password" placeholder="Password"/></td>
        </tr>
        <tr>
            <td><input type="submit" name="login" value="Anmeldung"></td>
        </tr>
    </table>
</form>

<a href="register.php">Register</a><br>

</body>
</html>
<?php

include_once "footer.php";
?>


