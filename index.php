<?php
session_start();

require_once "userdata.php";

if (isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $statement = $pdo->prepare("SELECT * FROM userdata WHERE email=:email AND password=:password");
    if($statement->execute (array(':email' => $email, ':password' => $password))) {
        if ($row = $statement->fetch()) {
            $_SESSION["angemeldet"] = $row["userid"];
            header("Location: home1.php");
        } else {
            echo "No authorization.";
        }
    }
    else {
        echo "blabla";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="jquery-migrate-1.4.1.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        /* Set black background color, white text and some padding
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }
        */
    </style>

</head>

<body>


Login:

<form action="index.php" method="post">
    <table>
        <tr>
            <td>Email: </td> <td><input type="text" name="email" placeholder="Email"/></td>
        </tr>
        <tr>
            <td>Passwort: </td> <td><input type="password" name="password" placeholder="Password"/></td>
        </tr>
        <tr>
            <td><input type="submit" name="login" value="Log In"></td>
        </tr>
    </table>
</form>

<a href="register.php">Register</a><br>



<?php
include_once "footer.php";
?>

</body>
</html>
