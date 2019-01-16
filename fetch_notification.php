<?php

session_start();

include_once "userdata.php";

$followerid=$_SESSION["angemeldet"];



    // Finde heraus ob Benachichtigungen vorhanden sind
    //$fetch_notification = $pdo->prepare("SELECT * FROM notification WHERE receiverid = '$followerid' ORDER BY notid DESC LIMIT 5");
    $fetch_notification = $pdo->prepare("SELECT * FROM notification AS n LEFT JOIN posts AS p ON p.post_id = n.post_id LEFT JOIN userdata AS u ON u.userid = p.userid WHERE n.receiverid = '$followerid' ORDER BY n.notid DESC LIMIT 5");
    $fetch_notification->execute();
    $output = '';
    $count_notification = $fetch_notification->rowCount();

    if ($count_notification > 0) {

        while ($row = $fetch_notification->fetch()) {

            $post_id = $row["post_id"];
            $editor_id = $row["userid"];

                $output .= '
   <li id="notification">
    <a href="single_post.php?post_id=' . $row['post_id'] . ';">
     <strong>' . $row["headline"] . '</strong><br />
    </a>
    
     <small>By <a href="profile.php?userid=' . $editor_id . '">' . $row["username"] . '</a> on ' . $row["date"] . '</small>
     
     <!--<a href="#">Clear</a>--> 
     <br />
     <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id ?>" />
     
   <!-- <a class="clear" data-pid=' . $row['notid'] . ' href="javascript:void(0)">Delete</a>-->
    <hr />
   </li>
   <li class="divider"></li>

   ';
 //           }
        }
    } else {
        $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
    }

    echo $output;


?>
<script>
  $(document).ready(function() {
        $('.clear').on('click', function () {


            var pid = $(this).data('pid');

            $.post("delete_notification.php", {pid: pid})

                .done(function (data) {

                    if (data > 0) {

                        $('.success').show(3000).html("Record deleted successfully.").delay(3200).fadeOut(6000);

                    } else {

                        $('.error').show(3000).html("Record could not be deleted. Please try again.").delay(3200).fadeOut(6000);

                    }

                    setTimeout(function () {
                        window.location.reload(1);
                    }, 5000);

                });

        });
    });
</script>
