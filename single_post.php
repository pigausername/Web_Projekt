<?php
session_start();
include_once "header.php";

$post_id = $_GET["post_id"];

$display_post = $pdo->prepare("SELECT * FROM posts WHERE post_id='$post_id'");
$display_post->execute();
$row = $display_post->fetch();
?>


<body>
<div class="content">
<table>
    <tr>
        <td>Headline:</td><td><?php echo $row["headline"] ?></td>
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





