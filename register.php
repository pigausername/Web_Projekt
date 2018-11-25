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
            $register = $pdo->prepare("INSERT INTO userdata (`password`, `email`, `username`, `firstname`, `lastname`)
                VALUES ('$password', '$email', '$username', '$firstname', '$lastname')");

            if ($register->execute()) {
                $login = $pdo->prepare("SELECT * FROM userdata WHERE email='$email' AND password='$password'");

                if ($login->execute()) {
                    while ($row = $login->fetch()) {
                        $_SESSION["angemeldet"] = $row["userid"];
                        header("Location: profile_edit.php");

                    }
                }
            } else {
                echo "Bestätigen Sie Ihr Passwort.";
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <script src="jquery-migrate-1.4.1.min.js"></script>
        <meta charset="UTF-8">
        <title>RAM| Registrierung</title>
    </head>
    <body>
    <h1>Welcome to RAM!</h1>

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
                <td>Please repeat your password:</td>
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
    </body>
    </html>
    <?php
}
    else
    {
        echo "You already have an account! Head back to ".'<a href=home1.php>'."here".'</a>'."!";
    }


include_once "footer.php";
?>
