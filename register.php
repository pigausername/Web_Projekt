<?php

session_start();

$pdo=new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-rk067',
    'rk067',
    'joB9Wahx5J',array('charset'=>'utf8'));

$statement = $pdo->prepare("INSERT INTO `*bla*` (`username`, `password`, `email`, `fist_name`,`last_name`) VALUES ('$username', '$password', '$firstname', '$lastname')");

if (isset($_POST['register_btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeatpassword = $_POST['repeatpassword'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    if ($_POST['password'] == $_POST['repeatpassword']) {
        $password = md5($password);
        $statement->execute();
        header("location: login.php");
    }
    else {
        echo "Please confirm your password.";
    }
}

?>
