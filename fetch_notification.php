<?php

session_start();

include_once "userdata.php";

$followerid=$_SESSION["angemeldet"];



if(isset($_POST["view"])) {


    // Finde heraus ob Benachichtigungen vorhanden sind
    $fetch_notification = $pdo->prepare("SELECT * FROM notification WHERE receiverid = $followerid ORDER BY notid DESC LIMIT 5");
    $fetch_notification->execute();
    $output = '';
    $count_notification = $fetch_notification->rowCount();


    if ($count_notification > 0) {
        while ($row = $fetch_notification->fetch()) {
            $post_id = $row["post_id"];

            $getposts = $pdo->prepare("SELECT * FROM posts WHERE post_id = $post_id");
            $getposts->execute();

            $row2 = $getposts->fetch();

            $editor_id = $row2["userid"];

            $display_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid='$editor_id'");
            $display_editor->execute();
            while ($row3 = $display_editor->fetch()) {

                $output .= '
   <li id="notification">
    <a href="single_post.php?post_id=' . $row2['post_id'] . ';">
     <strong>' . $row2["headline"] . '</strong><br />
    </a>
     <small>By <a href="profile.php?userid='.$editor_id.'">' . $row3["username"] . '</a> on ' . $row2["date"] . '</small>
     <a href="#">Clear</a> 
     <br />
     <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id ?>" />
    <a class="clear" data-pid='.$row['notid'].' href="javascript:void(0)">Delete</a>
    <hr />
   </li>
   <li class="divider"></li>

   ';
            }
        }
    }

            else {
                $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
            }

            $data = array(
                'notification' => $output,
            );
            echo json_encode($data);

    }

?>
<script>
  /*  $(document).ready(function() {
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
    });*/
</script>
