<?php
session_start();

require_once "userdata.php";
include_once "header.php";


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
    <label><input type="checkbox" name="angemeldet_bleiben" value="1"> Angemeldet bleiben</label>
    <br>
    <input type="submit" name="login" value="Anmeldung">
</form>

<a href="register.php">Register</a><br>

</body>
</html>
<?php
include_once "footer.php";
?>


