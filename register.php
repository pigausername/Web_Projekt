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

    <title>Registrierung</title>

</head>
<body style="background-color: white">
<div class="place_content">

    <?php
    session_start();

    include_once "userdata.php";

    //Prüfung, ob User schon angemeldet ist
    if (!isset($_SESSION["angemeldet"])) {

        if (isset($_POST['register'])) {

            //Prüfung, ob die Felder ausgefüllt sind
            if(empty($_POST['username']) OR empty($_POST['password']) OR empty($_POST['repeatpassword']) OR empty($_POST['email']) OR empty($_POST['firstname']) OR empty($_POST['lastname'])){
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

                    //Passwort-Hash
                    $options = ['cost' => 5];

                    $hash = password_hash($password, PASSWORD_DEFAULT, $options);

                    // check ob es den User schon gibt
                    $checkregister = $pdo->prepare("SELECT * FROM userdata WHERE username='$username' OR email='$email'");
                    $checkregister->execute();
                    $no = $checkregister->rowCount();
                    if (!$no > 0) {

                        // Insert Daten in Datenbank
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
                        <!-- Fehlermeldung - wenn Username oder Email bereits verwendet wird -->
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Info!</strong> Username or email already taken!
                        </div>
                        <?php
                    }

                } else {

                    ?>
                    <!-- Fehlermeldung - wenn Passwort nicht bestätigt wurde -->
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

        <!-- Registrierungsformular -->
        <form action="register.php" method="post">
                <input class="form_space_around_boxes" type="text" name="username" placeholder="Username" ><br>
                <input class="form_space_around_boxes" type="password" name="password" placeholder="Password" ><br>
                <input class="form_space_around_boxes" type="password" name="repeatpassword" placeholder="Repeat your password" ><br>
                <input class="form_space_around_boxes" type="email" name="email" placeholder="E-mail"><br>
                <input class="form_space_around_boxes" type="text" name="firstname" placeholder="First name"><br>
                <input class="form_space_around_boxes" type="text" name="lastname" placeholder="Last name"><br><br>
                <button type="submit" name="register" class="btn btn-info" id="register" >Register</button><br>
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
        echo "You already have an account! Head back to ".'<a href=feed.php>'."here".'</a>'."!";
    }


include_once "footer.php";
?>
</body>