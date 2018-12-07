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

    <title>Registrierung</title>

    <style>
        body {
            background-image: url("treppe_hdm.JPG");
            background-size: 100%;
        }

    </style>


</head>
<body>
<div class="content_register">
<h1>Welcome to RAM!</h1>

<?php
session_start();

include_once "userdata.php";

if (!isset($_SESSION["angemeldet"])) {

    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeatpassword = $_POST['repeatpassword'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        if ($_POST['password'] == $_POST['repeatpassword']) {
            //$password = md5($password);

            // check ob es den User schon gibt
            $checkregister=$pdo->prepare("SELECT * FROM userdata WHERE username='$username' OR email='$email'");
            $checkregister->execute();

            $no=$checkregister->rowCount();
            if(!$no > 0) {

               /* $register = $pdo->prepare("INSERT INTO userdata (`password`, `email`, `username`, `firstname`, `lastname`)
                VALUES ('$password', '$email', '$username', '$firstname', '$lastname')");
               */

                $register = $pdo->prepare("INSERT INTO userdata (`password`, `email`, `username`, `firstname`, `lastname`)
                VALUES (?,?,?,?,?)");
                $newregister=array($_POST["password"],$_POST["email"],$_POST["username"],$_POST["firstname"],$_POST["lastname"]);


                if ($register->execute($newregister)) {
                    $login = $pdo->prepare("SELECT * FROM userdata WHERE email='$email' AND password='$password'");

                    if ($login->execute()) {
                        while ($row = $login->fetch()) {
                            $_SESSION["angemeldet"] = $row["userid"];
                            echo '<script>window.location.href="profile_edit.php"</script>';

                        }
                    }
                }
            }
            else {
                echo "Username oder E-Mail schon vergeben.";
            }

            } else {
                echo "Bestätigen Sie Ihr Passwort.";
            }

        }

    ?>

<br>
    <h2>Create your own profile.</h2>

    <form action="register.php" method="post">
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
                <td>Password repeat:</td>
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
                <td>
                    <button type="submit" name="register" class="btn">Register</button>
                </td>
            </tr>
        </table>
        <p>Already have an account? <a href="index.php">Sign in</a>.</p>
    </form>
</div>
    <?php
}
    else
    {
        echo "You already have an account! Head back to ".'<a href=home1.php>'."here".'</a>'."!";
    }


include_once "footer.php";
?>
