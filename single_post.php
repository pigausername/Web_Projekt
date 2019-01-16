<?php
session_start();
include_once "header.php";


$post_id = $_GET["post_id"];

$display_post = $pdo->prepare("SELECT * FROM posts WHERE post_id='$post_id'");
$display_post->execute();
$row = $display_post->fetch();

$editor_id = $row["userid"];

$display_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid='$editor_id'");
$display_editor->execute();
$row2 = $display_editor->fetch();

?>


<body>
<div id="place_content" style="border-radius: .25rem;">
    <div class="place_content_inside" style="min-width: 100%">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">


                <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic" src="pictures/<?php echo $row2['profilepic'] ?>"></a>
        <br>

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

        <?php echo $row["content"] ?>

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





