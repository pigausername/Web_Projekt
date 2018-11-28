<?php
session_start();
if (isset($_SESSION["angemeldet"])) {
    $userid = $_SESSION["angemeldet"];
}

include_once "userdata.php";

// POST_ID herausfinden

$commenter_id = $_SESSION["angemeldet"];

$comment = $_POST["comment"];

$parent_comment_id = $_POST["comment_id"];

$post_id = $_POST["post_id"];


// Kommentar hinzufügen
$add_comment = $pdo->prepare("INSERT INTO comment (`parentcomment_id`, `comment`, `comment_userid`, `post_id`) 
                                        VALUES ('$parent_comment_id', '$comment', '$commenter_id', '$post_id')");


if($add_comment->execute()){
    $error = '<label class="text-success">Comment Added</label>';
}

$data = array(
    'error'  => $error
);

echo json_encode($data);
?>
