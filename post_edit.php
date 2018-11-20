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

$display_oldpost = $pdo->prepare("SELECT * FROM posts WHERE post_id=$post_id");

if ($display_oldpost->execute()){
    while ($row = $display_oldpost->fetch()) {
?>
<form action="post_edit.php" method="post">
    <table>
        <tr>
            <td><textarea name="headline" placeholder="" rows="2" cols="30" > <?php echo $row['headline'] ?> </textarea></td>
        </tr>
        <tr>
            <td><textarea name="content" placeholder="" rows="10" cols="30"> <?php echo $row['content'] ?> </textarea> </td>
        </tr>
        <tr>
            <td><input type="submit" name="save" value="Save"></td>
        </tr>
    </table>
    <?php
    }
    }

    if (isset($_POST['save'])) {

    $userid = $_SESSION["angemeldet"];
    $newheadline = $_POST['headline'];
    $newcontent = $_POST['content'];
    $post_id = $_GET["post_id"];


    $PostUpdate = $pdo->prepare("UPDATE posts 
                                          SET headline='$newheadline', content='$newcontent'
                                          WHERE post_id='$post_id'");
        if ($PostUpdate->execute()) {

            echo "You just successfully updated your post!";
            echo "<br>";
            echo "Head back to your profile ".'<a href="profile.php?userid='.$userid.'"> here</a>'. ".";
        }
        else {
            echo "Versuchen Sie es nochmal.";
        }
    }

?>


</body>
</html>
