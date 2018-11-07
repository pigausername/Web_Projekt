<?php
session_start();


include_once "userdata.php";

if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $pdo=new PDO($dsn, $dbuser, $dbpass, $options);


    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

    $statement = $pdo->prepare("SELECT * FROM userdata WHERE email=:email AND password=:password");
    $statement->execute(array(':email' => $email, ':password' => $password));
    $user = $statement->fetch();

    $_SESSION["angemeldet"]=$user["id"];

    if ($user !== false) {
        header("location: home1.php");
    } else {
        echo "E-Mail oder Passwort war ungültig";
    }
}