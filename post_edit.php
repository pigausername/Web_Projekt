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
<div class="content">
<h1>Here you can edit your post.</h1>

<?php

$post_id = $_GET["post_id"];

// Anzeigen des ursprünglichen Posts

$display_oldpost = $pdo->prepare("SELECT * FROM posts WHERE post_id=$post_id");

if ($display_oldpost->execute()){
    while ($row = $display_oldpost->fetch()) {

?>
<form action="post_edit.php?post_id=<?php echo $post_id ?>" method="post" enctype="multipart/form-data">
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

    if (isset($_POST['save_post_edit'])) {

        $userid = $_SESSION["angemeldet"];
        $newheadline = $_POST['headline'];
        $newcontent = $_POST['content'];
        $post_id = $_GET["post_id"];


        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fetchpicname = $pdo->prepare("SELECT * FROM posts WHERE post_id=$post_id");
        if ($fetchpicname->execute()) {
            $row1 = $fetchpicname->fetch();
                $Oldpicname = $row1["filename"];


            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            // Definiere welche Dateiformate erlaubt sind
            $allowed = array('jpg', 'jpeg', 'png', 'pdf');

            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 1000000) {
                        $fileDestination = 'pictures/' . $Oldpicname;
                        move_uploaded_file($fileTmpName, $fileDestination);


                       /* $PostUpdate = $pdo->prepare("UPDATE posts
                                          SET headline='$newheadline', content='$newcontent', filename='$Oldpicname'
                                          WHERE post_id= $post_id");
                       */

                        $PostUpdate = $pdo->prepare("UPDATE posts SET headline, content, filename VALUES (:newheadline, :newcontent, :oldpicname) WHERE post_id= $post_id");
                        $PostUpdate->bindParam(':newheadline', $newheadline);
                        $PostUpdate->bindParam(':newcontent', $newcontent);
                        $PostUpdate->bindParam(':oldpicname', $oldpicname);
                        if ($PostUpdate->execute()) {

                            echo "You just successfully updated your post!";
                            echo "<br>";
                            echo "Head back to your profile " . '<a href="profile.php?userid=' . $userid . '"> here</a>' . ".";
                        } else {
                            echo "Versuchen Sie es nochmal.";
                        }
                    }
                }
            }
        }
    }




    ?>

</div>
</body>
</html>
