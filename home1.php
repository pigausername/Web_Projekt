<?php

include_once "header.php";
?>
    <!doctype html>
    <html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>


    </head>

    <div class="place_content">
    <!-- Hierbei hat der eingeloggte User die Möglichkeit einen Post zu schreiben -->
   <div class="content col-lg-10">
    <h2>Create a post</h2>
<br>
    <form action="uploads.php" method="post" enctype="multipart/form-data">
        <br>
                <textarea name="headline" placeholder="Titel" rows="2" cols="30"></textarea>
            <br>
                <textarea name="content" placeholder="Type your text here" rows="10" cols="30"></textarea>
           <br>
        <br>
                Select a file: <input type="file" name="file" id="file" value="File">
           <br>
        <br>
                <button type="submit" value="post" name="post">Post</button>

    </form>

<br>

    <h2>Feed</h2>

    <!-- hole Content aus Datenbank -->
<?php

$headline= $_POST ["headline"];
$file= $_POST ["file"];
$content= $_POST["content"];
$filename= $_POST['filename'];
$myid= $_SESSION["angemeldet"];
$feedid = '';


$checkfollow=$pdo->prepare("SELECT * FROM followers WHERE followerid=$myid");
$checkfollow->execute();

$no=$checkfollow->rowCount();
if(!$no > 0) {
    //Wenn man niemandem folgt
    $display_user = $pdo->prepare("SELECT * FROM userdata WHERE userid= $myid");
    if ($display_user->execute()) {
        $row2 = $display_user->fetch();
        //Posts des angemeldeten Nutzers anzeigen
        $sql = $pdo->prepare("SELECT * FROM posts WHERE userid= $myid ORDER BY date DESC");
        if ($sql->execute()) {
            while ($row = $sql->fetch()) {
                ?>
                    <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic post"
                                src="pictures/<?php echo $row2['profilepic'] ?>"></a>

                    <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo $row2['username'] ?></a><br>
                    <small><?php echo $row['date'] ?></small>
                    <br>
                    <strong><a href="single_post.php?post_id=<?php echo $row["post_id"] ?>"><?php echo $row['headline'] ?></a></strong><br>
                    <?php echo $row['content'] ?><br>
                    <a href="single_post.php?post_id=<?php echo $row["post_id"] ?>">Comment</a>
                <hr />

                </div>
                </div>
                <?php
            }
        }
    }
}
else {
    //Wenn man jemandem folgt

    while ($row = $checkfollow->fetch()) {
        $editor_id = $row['userid'];



                $display_post = $pdo->prepare("SELECT * FROM posts WHERE userid= $editor_id OR userid= $myid ORDER BY date DESC");
                $display_post->execute();
                while ($row3 = $display_post->fetch()){
                    $editor = $row3['userid'];
                    $display_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid= $editor");
                    $display_editor->execute();
                    $row2 = $display_editor->fetch();
                ?>
                <div class="profilepic rounded-circle">
                <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic post"
                            src="pictures/<?php echo $row2['profilepic'] ?>"></a>
                <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo " " . $row2['username'] ?></a><br>
                <small><?php echo $row3['date'] ?></small>
                <br>
                <strong><a href="single_post.php?post_id=<?php echo $row3["post_id"] ?>"><?php echo $row3['headline'] ?></a></strong>
                <br>
                <?php
                // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhält --> Unovllständig

                $checkpic = $pdo->prepare("SELECT filename FROM posts WHERE userid= $myid");
                $checkpic->execute();

                $no = $checkpic->rowCount();
                if ($no > 0) {
                    ?>
                    <img class="postpic" src="pictures/<?php echo $row3['filename'] ?>">
                    <br>
                    <?php
                }
                ?>
                <p><?php echo $row3['content'] ?></p>
                <br>
                <a href="single_post.php?post_id=<?php echo $row3["post_id"] ?>">Comment</a>
                <hr/>
                <?php
            }
        }

}
include_once "footer.php";
?>