<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- hier ist der Link aus deinem Webspace https://mars.iuk.hdm-stuttgart.de/~ab238/css/stylesheet.css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/webprojekt/CSS/bootstrap.min.css" rel="stylesheet">
    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.css" rel="stylesheet">
    <!--    <link rel="stylesheet" type="text/css" href="stylesheet.css"> -->
    <link rel="stylesheet" type="text/css" href="stylesheet.css">

    <title>Registrierung</title>

    <style>
        body {
            background-image: url("pictures/treppe_hdm.jpg");
            background-position: center;
            background-repeat: no-repeat;
    </style>
</head>
<body>
<div class="place_content">

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

            $options = ['cost' => 5];

            $hash = password_hash($password, PASSWORD_DEFAULT, $options);

            // check ob es den User schon gibt
            $checkregister=$pdo->prepare("SELECT * FROM userdata WHERE username='$username' OR email='$email'");
            $checkregister->execute();
            $no=$checkregister->rowCount();
            if(!$no > 0) {

               /* $register = $pdo->prepare("INSERT INTO userdata (`password`, `email`, `username`, `firstname`, `lastname`)
                VALUES ('$password', '$email', '$username', '$firstname', '$lastname')");
               */
                $register = $pdo->prepare("INSERT INTO userdata (password, email, username, firstname, lastname)
                VALUES (:password, :email, :username, :firstname, :lastname)");
                $register->bindParam(':password',$hash);
                $register->bindParam(':email',$email);
                $register->bindParam(':username',$username);
                $register->bindParam(':firstname',$firstname);
                $register->bindParam(':lastname',$lastname);

                if ($register->execute()) {

                    $login = $pdo->prepare("SELECT * FROM userdata WHERE email=:email");
                    if ($login->execute(array(':email' => $email))) {
                        if ($row = $login->fetch()) {
                            if (password_verify($password, $row["password"])) {
                                $_SESSION["angemeldet"] = $row["userid"];
                                echo '<script>window.location.href="profile_edit.php"</script>';

                            }
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

    <div class="register_page">
        <h1>Welcome to RAM!</h1>
        <hr />

        <br>
    <h2>Create your own profile</h2>
        <br>


    <form action="register.php" method="post">
            <input class="form_space_around_boxes" type="text" name="username" placeholder="Username" required><br>
            <input class="form_space_around_boxes" type="password" name="password" placeholder="Password" required><br>
            <input class="form_space_around_boxes" type="password" name="repeatpassword" placeholder="Repeat your password" required><br>
            <input class="form_space_around_boxes" type="email" name="email" placeholder="E-mail" required><br>
            <input class="form_space_around_boxes" type="text" name="firstname" placeholder="First name" required><br>
            <input class="form_space_around_boxes" type="text" name="lastname" placeholder="Last name" required><br><br>
            <button type="submit" name="register" class="btn">Register</button><br>
        <br>
    </form>
    <hr />
    Already have an account? <a href="index.php">Sign in</a>.
</div>

</div>
    <?php
}
    else
    {
        echo "You already have an account! Head back to ".'<a href=home1.php>'."here".'</a>'."!";
    }


include_once "footer.php";
?>
</body>