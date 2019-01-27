<?php
//testen ob User angemeldet ist
session_start();
if (isset($_SESSION["angemeldet"])) {
    $userid = $_SESSION["angemeldet"];
}

include_once "userdata.php";

$commenter_id = $_SESSION["angemeldet"];
$comment = $_POST["comment"];
$post_id = $_POST["post_id"];

if ((stripos($comment, "<") !== false)) {
    ?>
    <!-- Meldung - wenn Java in das Feld geschrieben wird -->
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Info!</strong> Don't mess with us! Head back to <a href="feed.php">your feed</a>.
    </div>
    <?php
    die();

}
else {

// Kommentar hinzufügen
    $add_comment = $pdo->prepare("INSERT INTO comment (comment, comment_userid, post_id) 
                                        VALUES (:comment, :commenter_id, :post_id)");
    $add_comment->bindParam(':comment', $comment);
    $add_comment->bindParam(':commenter_id', $commenter_id);
    $add_comment->bindParam(':post_id', $post_id);

    if ($add_comment->execute()) {
        $error = '<label class="text-success">Comment added!</label>';
    } else {
        $error = '<label class="text-success">Fail</label>';
    }

    $data = array(
        'error' => $error
    );

    echo json_encode($data);
}
?>
