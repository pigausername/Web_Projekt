<?php
//Header wird eingefügt
include_once "header.php";

$notid = intval($_POST['pid']);

if(isset($_POST["clear"]))
{
    $delete_notification = $pdo->prepare ("DELETE * FROM notification WHERE notid = $notid");
    $delete_notification->execute();

}