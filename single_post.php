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
<div class="place_content">
<table>
    <tr>
        <td><h1><?php echo $row["headline"] ?></h1></td>
    </tr>
    <tr>
        <td><a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic" src="pictures/<?php echo $row2['profilepic'] ?>"></a>By <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo $row2['username'] ?></a></td>
    </tr>
    <tr>
        <td>

            <?php
            // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhält --> Unovllständig

            $checkpic=$pdo->prepare("SELECT filename FROM posts WHERE post_id= $post_id");
            $checkpic->execute();

            $no=$checkpic->rowCount();
            if($no > 0){
            ?>
            <img src="pictures/<?php echo $row['filename'] ?>"></td>
        <?php
        }
        ?>
    </tr>
    <tr>
        <td>Content:</td><td><?php echo $row["content"] ?></td>
    </tr>
    <tr>
        <td><?php include "comment.php" ?></td>
    </tr>
</table>
</div>


</body>





