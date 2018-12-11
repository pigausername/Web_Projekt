<?php
session_start();
include_once "userdata.php";

$profile_id = $_GET['userid'];

$showfollowers = $pdo->prepare("SELECT * FROM followers WHERE userid = $profile_id");
$showfollowers->execute();
$no_followers = $showfollowers->rowCount();
echo '<h3>Followers:</h3>';
echo '<h4>'.$no_followers.'</h4>';




