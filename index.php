<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- hier ist der Link aus deinem Webspace https://mars.iuk.hdm-stuttgart.de/~ab238/css/stylesheet.css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/webprojekt/CSS/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/webprojekt/CSS/navbar-top-fixed.css" rel="stylesheet">

    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/navbar-top-fixed.css" rel="stylesheet">


    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/navbar-top-fixed.css" rel="stylesheet">

    <!--    <link rel="stylesheet" type="text/css" href="stylesheet.css"> -->
    <link rel="stylesheet" type="text/css" href="stylesheet.css">

    <title>Login</title>

</head>
<body>

<div class="content">
    <h1>Welcome to RAM!</h1>

<?php
session_start();

require_once "userdata.php";

if (!isset($_SESSION["angemeldet"])){

if (isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $statement = $pdo->prepare("SELECT * FROM userdata WHERE email=:email AND password=:password");
    if ($statement->execute(array(':email' => $email, ':password' => $password))) {
        if ($row = $statement->fetch()) {
            $_SESSION["angemeldet"] = $row["userid"];
            header("Location: home1.php");
        } else {
            echo "No authorization.";
        }
    } else {
        echo "blabla";
    }
}

?>

<div id="login">
<h2>Log in to your profile:</h2>

<form action="index.php" method="post">
    <table>
        <tr>
            <td>Email:</td>
            <td><input type="text" name="email" placeholder="Email"/></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" placeholder="Password"/></td>
        </tr>
        <tr>
            <td><input type="submit" name="login" value="Log In"></td>
        </tr>
        <tr>
            <td>Not have an account yet? Create your own profile <a href="register.php">here</a>!</td>
        </tr>
    </table>
</form>

</div>


<?php
}
else {
    echo "You are already logged in! Head back to ".'<a href=home1.php>home</a>'."!";
}


include_once "footer.php";
?>
</div>
</body>
</html>
