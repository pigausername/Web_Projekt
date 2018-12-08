<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- hier ist der Link aus deinem Webspace https://mars.iuk.hdm-stuttgart.de/~ab238/css/stylesheet.css -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/webprojekt/CSS/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->

    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->


    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->

    <!--    <link rel="stylesheet" type="text/css" href="stylesheet.css"> -->
    <link rel="stylesheet" type="text/css" href="stylesheet.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>


    <title>Registrierung</title>
</head>
<body>

<?php
session_start();

include_once "userdata.php";

if (!isset($_SESSION["angemeldet"])) {

    if (isset($_POST['register'])) {

        if(empty($username) OR empty($password) OR empty($repeatpassword) OR empty($email) OR empty($firstname) OR empty($lastname)){
            ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Info!</strong> Please fill in all fields!
            </div>
            <?php
        }
        else {
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
                $checkregister = $pdo->prepare("SELECT * FROM userdata WHERE username='$username' OR email='$email'");
                $checkregister->execute();
                $no = $checkregister->rowCount();
                if (!$no > 0) {

                    /* $register = $pdo->prepare("INSERT INTO userdata (`password`, `email`, `username`, `firstname`, `lastname`)
                     VALUES ('$password', '$email', '$username', '$firstname', '$lastname')");
                    */
                    $register = $pdo->prepare("INSERT INTO userdata (password, email, username, firstname, lastname)
                VALUES (:password, :email, :username, :firstname, :lastname)");
                    $register->bindParam(':password', $hash);
                    $register->bindParam(':email', $email);
                    $register->bindParam(':username', $username);
                    $register->bindParam(':firstname', $firstname);
                    $register->bindParam(':lastname', $lastname);

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
                } else {

                    ?>

                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Info!</strong> User name or email already taken!
                    </div>

                    <?php
                }

            } else {

                ?>

                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Info!</strong> Please confirm your password!
                </div>
                <?php
            }
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
            <input type="text" name="username" placeholder="Username" ><br>
            <input type="password" name="password" placeholder="Password" ><br>
            <input type="password" name="repeatpassword" placeholder="Repeat your password" ><br>
            <input type="email" name="email" placeholder="E-mail"><br>
            <input type="text" name="firstname" placeholder="First name"><br>
            <input type="text" name="lastname" placeholder="Last name"><br><br>
            <button type="submit" name="register" class="btn" id="register" >Register</button><br>
        <br>
    </form>
    <hr />
    Already have an account? <a href="index.php">Sign in</a>.
</div>
    <?php
}
    else
    {
        echo "You already have an account! Head back to ".'<a href=home1.php>'."here".'</a>'."!";
    }


include_once "footer.php";
?>