<?php
session_start();
include_once "userdata.php";

$myid = $_SESSION["angemeldet"];

if ($getpostid = $pdo->prepare("SELECT * FROM posts WHERE userid = $myid ORDER BY post_id DESC LIMIT 1")) {

    if ($getpostid->execute()) {

        if ($row = $getpostid->fetch()) {


            $post_id = $row['post_id'];
        }
    }
}

$display_follower = $pdo->prepare("SELECT * FROM followers WHERE userid= $myid");
if ($display_follower->execute()) {
    while ($row3 = $display_follower->fetch()) {
        $followerid = $row3['followerid'];

        $set_notification = $pdo->prepare("INSERT INTO notification (notificationerid, post_id, receiverid) VALUES (:myid, :post_id, :followerid)");
        $set_notification->bindParam(':myid', $myid);
        $set_notification->bindParam(':post_id', $post_id);
        $set_notification->bindParam(':followerid', $followerid);
        $set_notification->execute();

        echo '<script>window.location.href="home1.php"</script>';
    }

}
