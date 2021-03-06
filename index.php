<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/webprojekt/CSS/bootstrap.min.css" rel="stylesheet">
    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <title>Login</title>

</head>
<body style="background-color: white">

<div>

<?php
session_start();

require_once "userdata.php";

if (!isset($_SESSION["angemeldet"])){

if (isset($_POST['login'])) {

    // hierbei wir überprüft ob alle Felder ausgefüllt sind
    if(empty($_POST["email"]) OR empty($_POST["password"])){
        ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Please fill in all fields!
        </div>
        <?php
    }


    $email = $_POST["email"];
    $password = $_POST["password"];

    // Überprüfung ob Email und Passwort übereinstimmen
    $statement = $pdo->prepare("SELECT * FROM userdata WHERE email=:email");
    if ($statement->execute(array(':email' => $email))) {
        if ($row = $statement->fetch()) {
            if (password_verify($password, $row["password"])) {
                $_SESSION["angemeldet"] = $row["userid"];
                header("Location: feed.php");
            } else {
                ?>
                <!-- Fehlermeldung wenn das Passwort falsch ist -->
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Info!</strong> Wrong password!
                </div>


                <?php
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

        <!-- Login Formular -->
        <form action="index.php" method="post">

            <input class="form_space_around_boxes" type="text" name="email" placeholder="E-mail"/><br>
            <input class="form_space_around_boxes" type="password" name="password" placeholder="Password"/><br><br>
            <input type="submit" name="login" class="btn btn-info" value="Log In"><br>
            <br>
            <hr />
            Not have an account yet? Create your own profile <a href="register.php">here</a>!
        </form>

    </div>
</div>
</div>

</body>
</html>

<?php
}
else {
    ?>
    <!-- Meldung - Bereits eingeloggt -->
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Info!</strong> You are already logged in. Head back to <a href=feed.php>home</a>.
    </div>
    <?php
}


include_once "footer.php";
?>

