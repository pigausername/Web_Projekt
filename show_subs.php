<?php
session_start();
include_once "userdata.php";

$profile_id = $_GET['userid'];

$showsubs = $pdo->prepare("SELECT * FROM followers WHERE followerid = $profile_id");
$showsubs->execute();
$no_subs = $showsubs->rowCount();
echo '<h5>Subscriptions:</h5>';
echo '<h5>'.$no_subs.'</h5>';

