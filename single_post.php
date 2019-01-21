<?php
session_start();
include_once "header.php";



$userid = $_SESSION["angemeldet"];
$post_id = $_GET["post_id"];

// Delete Notifications if existing
$check_notify_stat = $pdo->prepare("DELETE FROM notification WHERE post_id='$post_id' AND receiverid='$userid'");
$check_notify_stat->execute();

// Get Posts from Database and fetch to row
$display_post = $pdo->prepare("SELECT * FROM posts WHERE post_id='$post_id'");
$display_post->execute();
$row = $display_post->fetch();

$editor_id = $row["userid"];

// Get Userdata from Database
$display_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid='$editor_id'");
$display_editor->execute();
$row2 = $display_editor->fetch();

?>
<title><?php echo $row["headline"] ?></title>

<body>
<div id="place_content" style="border-radius: .25rem;">
    <div class="place_content_inside" style="min-width: 100%">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">

                    <!--Zeige Profilbild der Person die den Post geschrieben hat-->
                    <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic" src="pictures/<?php echo $row2['profilepic'] ?>"></a>
                    <br>
                    <!--Zeige Profilbild der Person die den Post geschrieben hat-->
                    <strong><a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo $row2['username'] ?></a></strong>
                    <br>
                    <?php echo $row["date"]?>



                    <h2><?php echo $row["headline"] ?></h2>
                    <br>
                      <?php

                      // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhält --> Unovllständig
                      $nopic = "NULL";

                      if ($row['filename'] !== $nopic)
                      {
                          ?>
                          <img class="postpic" src="pictures/<?php echo $row['filename'] ?>">
                          <br>
                          <?php
                      }
                    ?>
                    <?php echo nl2br ('<p>'.$row['content'].'</p>'); ?><br>

                    <br>
                    <br>
                    <hr/>

                    <?php include "comment.php" ?>

                </div>
                <div class="col-md-2"></div>
            </div>

</div>

<?php
include_once "footer.php";



?>


</body>





