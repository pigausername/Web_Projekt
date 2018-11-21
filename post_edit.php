<?php

include_once "header.php";


?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Edit your post</title>
</head>
<body>
<h1>Here you can edit your post.</h1>

<?php

$post_id = $_GET["post_id"];

// Anzeigen des ursprünglichen Posts

$display_oldpost = $pdo->prepare("SELECT * FROM posts WHERE post_id=$post_id");

if ($display_oldpost->execute()){
    while ($row = $display_oldpost->fetch()) {

?>
<form action="uploads.php?post_id=<?php echo $post_id ?>" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td><textarea name="headline" placeholder="" rows="2" cols="30" > <?php echo $row['headline'] ?> </textarea></td>
        </tr>
        <tr>
            <td><textarea name="content" placeholder="" rows="10" cols="30"> <?php echo $row['content'] ?> </textarea></td>
        </tr>
        <tr>
            <td><input type="file" name="file" id="file">
        </tr>
        <tr>
            <td><input type="submit" name="save_post_edit" value="Save"></td>
        </tr>
    </table>
    <?php
    }
    }



?>


</body>
</html>
