<?php

session_start();

include_once "userdata.php";

$followerid=$_SESSION["angemeldet"];

// Finde heraus ob Benachichtigungen vorhanden sind
$fetch_notification = $pdo->prepare("SELECT * FROM notification AS n LEFT JOIN posts AS p ON p.post_id = n.post_id LEFT JOIN userdata AS u ON u.userid = p.userid WHERE n.receiverid = '$followerid' ORDER BY n.notid DESC");
$fetch_notification->execute();
$output = '';
$count_notification = $fetch_notification->rowCount();

echo $count_notification;