@@ -0,0 +1,46 @@
<?php
session_start();

if (isset($_SESSION["angemeldet"])) {
    $userid = $_SESSION["angemeldet"];
}

include_once "userdata.php";

$post_id = $_GET["post_id"];

//Kommentar auswählen und anzeigen
$fetch_comment = $pdo->prepare("SELECT * FROM comment WHERE parentcomment_id = '0' ORDER BY comment_id DESC");

if ($fetch_comment->execute()) {
    while ($row = $fetch_comment->fetch()) {
        ?>
        <div class="panel panel-default">
        <div class="panel-heading">By <b>
        <?php
        $commenterid = $row["comment_userid"];

        // Name des Kommentators herausfinden und anzeigen
        $fetch_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid= '$commenterid'");

        if ($fetch_editor->execute()) {
            $row1 = $fetch_editor->fetch();
            $commentername = $row1["username"];
            echo '<a href="profile.php?userid=' . $commenterid . '">' . $commentername . '</a>';

            ?>
            </b> on <i><?php echo $row["date"] ?></i></div>
            <div class="panel-body"><?php echo $row["comment"] ?></div>
            <div class="panel-footer" align="right">
                <button type="button" class="btn btn-default reply" id="<?php $row["comment_id"] ?>">Reply</button>
            </div>
            </div>

            <?php

        }
    }


}
?>