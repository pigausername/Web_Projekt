<?php
/**
 * Created by PhpStorm.
 * User: anni
 * Date: 04.12.18
 * Time: 19:19
 */

include_once "userdata.php";
$profile_id=$_GET['userid'];
$followerid=$_SESSION["angemeldet"];



// Check ob es ein fremdes Profil ist
if ($profile_id!=$_SESSION["angemeldet"]) {

    // check ob wir dem Nutzer schon folgen
    $checkfollow=$pdo->prepare("SELECT followerid FROM followers WHERE userid=$profile_id");
    $checkfollow->execute();

    $no=$checkfollow->rowCount();
    if(!$no > 0){

// check ob ein User etwas gepostet hat
$checkpost=$pdo->prepare("SELECT post_id FROM posts WHERE userid=$followerid");
$checkpost->execute();
