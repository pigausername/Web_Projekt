<?php
session_start();

if (isset($_SESSION["angemeldet"])) {
    $userid = $_SESSION["angemeldet"];
}
include_once "userdata.php";

$post_id = $_GET["post_id"];

//Kommentar aus der Datenbank holen
$fetch_comment = $pdo->prepare("SELECT * FROM comment WHERE post_id = $post_id ORDER BY comment_id DESC");

if ($fetch_comment->execute()) {
    ?>
    <h4>Comments</h4>
    <br>
    <?php
    while ($row = $fetch_comment->fetch()) {
        ?>
        <div class="content">
        <div class="panel panel-default">
        <div class="panel-heading"><b>
        <?php
        $commenterid = $row["comment_userid"];

        // Name des Kommentators herausfinden und anzeigen
        $fetch_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid= '$commenterid'");

        if ($fetch_editor->execute()) {
            $row1 = $fetch_editor->fetch();
            $commentername = $row1["username"];
            ?>
            <a href="profile.php?userid=<?php echo $commenterid ?>"><?php echo $commentername ?> </a>

            <br>
            </b>
            <small><i><?php echo $row["date"] ?></i></small>
            </div>
            <br>
            <div class="panel-body"><?php echo $row["comment"] ?></div>
            <hr />
            </div>
            </div>
            <?php

        }
    }


}
?>