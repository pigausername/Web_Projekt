<?php

session_start();

include_once "userdata.php";
$profile_id=$_GET['userid'];
$followerid=$_SESSION["angemeldet"];




//if(isset($_POST["view"])) {


    // Finde heraus ob Benachichtigungen vorhanden sind
    $fetch_notification = $pdo->prepare ("SELECT * FROM notification WHERE receiverid = $followerid ORDER BY notid DESC LIMIT 5");
    $fetch_notification->execute();
    $output = '';

    $count_notification = $fetch_notification->rowCount();


    if (!$count_notification > 0) {

        while($row = $fetch_notification->fetch()) {

            $post_id = $row["post_id"];

            $getposts = $pdo->prepare("SELECT * FROM posts WHERE post_id = $post_id");
            $getposts->execute();

            $row2 = $getposts->fetch();


            $output .= '
   <li>
    <a href="#">
     <strong>'.$row2["headline"].'</strong><br />
    </a>
   </li>
   <li class="divider"></li>
   ';
        }
    }
    else
    {
        $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
    }

    $data = array(
        'notification'   => $output,
    );
    echo json_encode($data);
//}

/*
if($_POST["clear"] != '')
{
    $delete_notification = $pdo->prepare ("DELETE * FROM notification WHERE receiverid = $followerid");
    $delete_notification->execute();
}*/
?>