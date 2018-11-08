<?php
session_start();

require_once "userdata.php";
include_once "header.php";

if (isset($_POST["email"]) AND isset($_POST["password"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

$statement = $pdo->prepare("SELECT * FROM userdata WHERE email=:email 
                                    AND password=:password");

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
Passwort: <input type="password" name="password" placeholder="Password"/>
    <br>
    <input type="submit" name="login" value="Anmeldung">
</form>

<a href="register.php">Register</a><br>

</body>
</html>
<?php
include_once "footer.php";
?>


