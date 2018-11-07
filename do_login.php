<?php
session_start();

include_once "userdata.php";

if (isset($_POST["login"])) {

    $name = $_POST["name"];
    $passwort = $_POST["passwort"];

    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

    $pdo=new PDO($dsn, $dbuser, $dbpass, $options);


    $statement = $pdo->prepare("SELECT * FROM Anmeldung WHERE name=:name AND passwort=:passwort");
    $statement->execute(array(':name' => $name, ':passwort' => $passwort));
    $user = $statement->fetch();

    $_SESSION["angemeldet"]=$user["id"];

    if ($user !== false) {
        header("location: home.php");
    } else {
        echo "E-Mail oder Passwort war ungültig";
    }
}