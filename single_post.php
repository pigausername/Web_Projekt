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
<div id="place_content">
    <div class="place_content_inside">

        <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic" src="pictures/<?php echo $row2['profilepic'] ?>"></a>
        <br>

        <strong><a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo $row2['username'] ?></a></strong>
        <br>
        <?php echo $row["date"]?>
        <h1><strong><?php echo $row["headline"] ?></strong></h1>
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

        <?php include "comment.php" ?>
</div>
</div>


</body>





