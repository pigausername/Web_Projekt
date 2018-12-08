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

    <style>
        body {
            background-image: url("pictures/treppe_hdm.jpg");
            background-size: 100%;





    </style>
</head>
<body>

<?php
session_start();

require_once "userdata.php";

if (!isset($_SESSION["angemeldet"])){

if (isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $statement = $pdo->prepare("SELECT * FROM userdata WHERE email=:email");
    if ($statement->execute(array(':email' => $email))) {
        if ($row = $statement->fetch()) {
            if (password_verify($password, $row["password"])) {
                $_SESSION["angemeldet"] = $row["userid"];
                header("Location: home1.php");
            } else {
                echo "No authorization.";
            }
        }
    }
}

?>

<div class="login_page">
    <h1>Welcome to RAM!</h1>
    <hr />
<div>
    <br>
<h2>Sign in</h2>
    <br>

<form action="index.php" method="post">

    <input type="text" name="email" placeholder="Email"/><br>
    <input type="password" name="password" placeholder="Password"/><br><br>
    <input type="submit" name="login" class=btn value="Log In"><br>
    <br>
    <hr />
    Not have an account yet? Create your own profile <a href="register.php">here</a>!
</form>

</div>
</div>

</body>
</html>

<?php
}
else {
    echo "You are already logged in! Head back to ".'<a href=home1.php>home</a>'."!";
}


include_once "footer.php";
?>

