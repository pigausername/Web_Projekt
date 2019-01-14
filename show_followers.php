<?php
session_start();
include_once "userdata.php";

$profile_id = $_GET['userid'];

$showfollowers = $pdo->prepare("SELECT * FROM followers WHERE userid = $profile_id");
$showfollowers->execute();
$no_followers = $showfollowers->rowCount();
echo '<h5>Followers:</h5>';
echo '<h5>'.$no_followers.'</h5>';
