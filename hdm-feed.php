<?php

include_once "header.php";
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HDM-Feed</title>
</head>

<body>
<div id="place_content" style="border-radius: .25rem;">
    <div class="place_content_inside" style="border-radius: .25rem; min-width: 100%">
        <h2>HDM-Feed</h2>
        <hr><br>

<?php
                //Posts der Nutzers anzeigen
                $sql = $pdo->prepare("SELECT * FROM posts ORDER BY date DESC");
                $sql->execute();
                    while ($row = $sql->fetch()) {
                        $editor_id = $row["userid"];
                        $display_user = $pdo->prepare("SELECT * FROM userdata WHERE userid=$editor_id");
                        $display_user->execute();
                        $row2 = $display_user->fetch();
                            ?>
                            <!-- Zeige Profilbild über dem Post -->
                            <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic post"
                                                                                            src="pictures/<?php echo $row2['profilepic'] ?>"></a>
                            <br>
                            <!-- Zeige Username -->
                            <strong><a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo $row2['username'] ?></a></strong>
                            <br>
                            <!-- Zeige Datum -->
                            <small><?php echo $row['date'] ?></small>
                            <br><br>
                            <!-- Zeige Headline und Content -->
                            <h4><?php echo $row['headline'] ?></h4>
                            <?php
                            $nopic = "NULL";

                            if ($row['filename'] !== $nopic) {
                                ?>
                                <img class="postpic" src="pictures/<?php echo $row['filename'] ?>">
                                <br><br>
                                <?php
                            }

                            echo nl2br('<p>' . $row['content'] . '</p>'); ?><br>
                            <!-- Verlinkung zu Single Post -->
                            <div class="content-right"><a
                                        href="single_post.php?post_id=<?php echo $row["post_id"] ?>">Comment</a></div>

                            <hr/>

                            <?php
                        }





?>
    </div>
</div>
<?php

include_once "footer.php";
?>