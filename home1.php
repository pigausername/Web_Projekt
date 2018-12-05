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
    <!-- Hierbei hat der eingeloggte User die Möglichkeit einen Post zu schreiben -->
   <div class="content col-lg-10">
    <h2>Beitrag schreiben</h2>
    <form action="uploads.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><textarea name="headline" placeholder="Titel" rows="2" cols="30"></textarea></td>
            </tr>
            <tr>
                <td><textarea name="content" placeholder="Type your text here" rows="10" cols="30"></textarea></td>
            </tr>
            <tr>
                <td><input type="file" name="file" id="file"></td>
            </tr>
            <tr>
                <td><button type="submit" value="post" name="post">Post</button></td>
            </tr>
        </table>
    </form>



    <h2>Feed</h2>

    <!-- hole Content aus Datenbank -->
<?php

$headline= $_POST ["headline"];
$file= $_POST ["file"];
$content= $_POST["content"];
$filename= $_POST['filename'];
$myid= $_SESSION["angemeldet"];


// Hierbei wird kontrolliert, wem der angemeldete User folgt
$display_follower = $pdo->prepare("SELECT * FROM followers WHERE followerid= $myid");
if ($display_follower->execute()) {
    while ($row3 = $display_follower->fetch()) {
        $feedid= $row3['userid'];
    }

// Zeige den Content der Nutzer denen der angemeldete User folge und meine eigenen Beiträge

    $get_feed = $pdo->prepare("SELECT * FROM posts WHERE userid= $feedid OR userid= $myid ORDER BY date DESC");
    if($get_feed->execute()) {
        while($row=$get_feed->fetch()) {

            $editor_id = $row['userid'];


// Hierbei wird kontrolliert wer den jeweiligen Post geschrieben hat
            $display_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid= $editor_id");
            if($display_editor->execute()) {
                while ($row2 = $display_editor->fetch()) {
                    ?>
                    <!-- Hierbei wird der Content in Tabellenform angezeigt -->
                    <table>
                        <tr>
                            <td>
                                <h4><a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img src="pictures/<?php echo $row2['profilepic'] ?>"></a>
                                    <a href="single_post.php?post_id=<?php echo $row["post_id"] ?>"><?php echo $row['headline']?></a> by
                                    <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo " " . $row2['username'] ?></a>
                                </h4>
                            </td>

                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td>

                                <?php
                                // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhält --> Unovllständig

                                $checkpic=$pdo->prepare("SELECT filename FROM posts WHERE userid= $feedid OR userid= $myid");
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
                            <td><?php echo $row['content'] ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $row['date']?></td>
                        </tr>
                        <tr>
                            <td><a href="single_post.php?post_id=<?php echo $row["post_id"] ?>">Comment</a></td>
                        </tr>
                    </table>
                    <hr />
                    </div>
                    <?php
                }
            }
        }
    }
} else {
    echo "Datenbank-Fehler:";
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die();
}
include_once "footer.php";
?>