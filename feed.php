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

<body>
<div id="place_content" style="border-radius: .25rem;">
    <div class="place_content_inside" style="border-radius: .25rem; min-width: 100%">

    <!-- Post schreiben - Formular-->
    <h2>Create a post</h2>
    <br>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
        <form action="uploads.php" method="post" enctype="multipart/form-data">
        <br>
            <textarea class="textareastyle" type="text" name="headline" placeholder="Titel"  rows="1"></textarea>
        <br>
            <textarea class="textareastyle" name="content" placeholder="Type your text here" rows="7"></textarea>
        <br>
        <br> <div class="content-right">
            Select an image: <input type="file" name="file" id="file" value="File">
            <br>
            <br>

            <button class="btn btn-info" type="submit" value="post" name="post">Post</button>
        </div>
    </form>
    </div>
        <div class="col-md-2"></div>
        </div>

    <br>



    <h2 style="text-align: center">Feed</h2>
    <hr><br>

    <!-- hole Content aus Datenbank -->
<?php
$headline= $_POST ["headline"];
$file= $_POST ["file"];
$content= $_POST["content"];
$filename= $_POST['filename'];
$myid= $_SESSION["angemeldet"];
$feedid = '';

// Schaue nach wem ich folge
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
                <!-- Zeige Profilbild über dem Post -->
                <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic post"
                                                                                src="pictures/<?php echo $row2['profilepic'] ?>"></a><br>
                    <!-- Zeige Username -->
                    <strong><a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo $row2['username'] ?></a></strong><br>
                    <!-- Zeige Datum -->
                    <small><?php echo $row['date'] ?></small>
                    <br>
                    <!-- Zeige Headline und Content -->
                    <h4><?php echo $row['headline'] ?></h4><br>
                <?php
                if ($row['filename'] !== $nopic) {
                ?>
                <img class="postpic" src="pictures/<?php echo $row['filename'] ?>">
                <br>
                <?php
                }

                    echo nl2br ('<p>'.$row['content'].'</p>'); ?><br>
                <!-- Verlinkung zu Single Post -->
                <div class="content-right"><a href="single_post.php?post_id=<?php echo $row["post_id"] ?>">Comment</a></div>

                <hr />

                <?php
            }
        }
    }
}
else {
    //Wenn man jemandem folgt

    while ($row = $checkfollow->fetch()) {
        $editor_id = $row['userid'];

        // Hole meine Posts und die Posts von den Leuten denen ich folge
        $display_post = $pdo->prepare("SELECT * FROM posts WHERE userid= $editor_id OR userid= $myid ORDER BY date DESC");
        $display_post->execute();
        while ($row3 = $display_post->fetch()){
            $editor = $row3['userid'];
            $display_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid= $editor");
            $display_editor->execute();
            $row2 = $display_editor->fetch();
            ?>

                <!-- Zeige Profilbild über dem Post -->
                <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic post"
                                                                                src="pictures/<?php echo $row2['profilepic'] ?>"></a>
                <br>
                <!-- Zeige Username -->
                <strong><a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo " " . $row2['username'] ?></a></strong>
                <br>
                <!-- Zeige Datum -->
                <small><?php echo $row3['date'] ?></small>
                <br>
                <br>
                <!-- Zeige Headline und Content -->
                <h4><?php echo $row3['headline'] ?></h4>
                <?php

                // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhaltet
                $nopic = "NULL";

                if ($row3['filename'] !== $nopic) {
                    ?>
                    <img class="postpic" src="pictures/<?php echo $row3['filename'] ?>">
                    <br>
                    <?php
                }
                ?>
                <p><?php echo nl2br($row3['content']) ?></p>
                <div class="content-right"><a href="single_post.php?post_id=<?php echo $row3["post_id"] ?>">Comment</a>
                </div>
                <hr/>
                <br>

                <?php
            }
        }
}

?>
    </div>
</div>
        <?php

include_once "footer.php";
?>