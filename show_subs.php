<?php
session_start();
include_once "userdata.php";

$profile_id = $_GET['userid'];

$showsubs = $pdo->prepare("SELECT * FROM followers WHERE followerid = $profile_id");
$showsubs->execute();
$no_subs = $showsubs->rowCount();
echo '<h3>Subscriptions:</h3>';
echo '<h4>'.$no_subs.'</h4>';

