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



if (isset($_POST['save_post_edit'])) {

    $userid = $_SESSION["angemeldet"];
    $newheadline = $_POST['headline'];
    $newcontent = $_POST['content'];
    $post_id = $_GET["post_id"];


    if ((stripos($newheadline, "<") !== false) OR (stripos($newcontent, "<") !== false)) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Don't mess with us! Head back to <a href="feed.php">your feed</a>.
        </div>
        <?php
        die();
    }

    if (empty($_POST["headline"]) OR empty($_POST["content"])) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> A good post requires both a headline and content. Try <a href="feed.php">here</a>
            again.
        </div>
        <?php
    } else {

        if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {

            $file = $_FILES['file'];
            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];

            $fetchpicname = $pdo->prepare("SELECT * FROM posts WHERE post_id=$post_id");
            echo "3".$fileName;
            if ($fetchpicname->execute()) {
                $row1 = $fetchpicname->fetch();
                $Oldpicname = $row1["filename"];

                echo "2".$Oldpicname;


                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                // Definiere welche Dateiformate erlaubt sind
                $allowed = array('jpg', 'jpeg', 'png', 'pdf');

                if (in_array($fileActualExt, $allowed)) {
                    if ($fileError === 0) {
                        if ($fileSize < 1000000) {
                            $fileDestination = 'pictures/' . $Oldpicname;
                            move_uploaded_file($fileTmpName, $fileDestination);

                            echo $fileDestination;

                            $PostUpdate = $pdo->prepare("UPDATE `posts` SET `headline` = :newheadline, `content` = :newcontent, `filename` = :oldpicname WHERE `post_id` = :post_id");

                            $PostUpdate->bindParam(':newheadline', $newheadline);
                            $PostUpdate->bindParam(':newcontent', $newcontent);
                            $PostUpdate->bindParam(':oldpicname', $oldpicname);
                            $PostUpdate->bindParam(':post_id', $post_id);

                            if ($PostUpdate->execute()) {
                                ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>You have successfully updated your post!</strong> Head <a href="feed.php">here</a> back to
                                    home!
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Info!</strong> Something went wrong. Try again!
                                </div>
                                <?php
                            }
                        }
                    }
                }
            }
        }
        else {
            $nopic = "NULL";

            $PostUpdate = $pdo->prepare("UPDATE `posts` SET `headline` = :newheadline, `content` = :newcontent, `filename` = :filename WHERE `post_id` = :post_id");

            $PostUpdate->bindParam(':newheadline', $newheadline);
            $PostUpdate->bindParam(':newcontent', $newcontent);
            $PostUpdate->bindParam(':post_id', $post_id);
            $PostUpdate->bindParam('filename', $nopic);


            if ($PostUpdate->execute()) {
                ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>You have successfully updated your post!</strong> Head <a href="feed.php">here</a> back to
                    home!
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Info!</strong> Something went wrong. Try again!
                </div>
                <?php
            }
        }
    }

}

// Anzeigen des ursprünglichen Posts

$display_oldpost = $pdo->prepare("SELECT * FROM posts WHERE post_id=$post_id");

if ($display_oldpost->execute()){
    while ($row = $display_oldpost->fetch()) {

?>
<form action="post_edit.php?post_id=<?php echo $post_id ?>" method="post" enctype="multipart/form-data">
    <br>
    <textarea class="textareastyle" name="headline" placeholder="" rows="1"> <?php echo $row['headline'] ?> </textarea>
    <br>
    <textarea class="textareastyle" name="content" placeholder="" rows="7"> <?php echo $row['content'] ?> </textarea>
    <br>
    <br> <div class="content-right">
        Select an image: <input type="file" name="file" id="file" value="File">
        <br>
        <br>

        <button class="btn btn-info" type="submit" name="save_post_edit" value="Save">Save Changes</button>
    </div>
    </form>
    <?php
    }
    }

    ?>

</div>
</body>
</html>
