<?php
session_start();
include_once "userdata.php";

?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/webprojekt/CSS/bootstrap.min.css" rel="stylesheet">

    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.css" rel="stylesheet">

    <!--    <link rel="stylesheet" type="text/css" href="stylesheet.css"> -->
    <link rel="stylesheet" type="text/css" href="stylesheet.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<?php

// variablen festgelegt die für die Verarbeitung gebraucht werden
// Upload von Post Content ohne Bild

if (isset($_POST['headline']) AND isset($_POST['content'])) {
    $headline = $_POST['headline'];
    $content = $_POST['content'];
    $userid = $_SESSION["angemeldet"];

    if ((stripos($headline, "<") !== false) OR (stripos($content, "<") !== false)) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Don't mess with us! Head back to <a href="feed.php">your feed</a>.
        </div>
        <?php
        die();
    }


    if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
        $file = $_FILES['file'];


        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        // Definiere welche Dateiformate erlaubt sind
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = 'pictures/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    echo $fileDestination;
                    echo $headline;
                    echo $content;
                    echo $fileNameNew;

                        $uploadwithpic = $pdo->prepare("INSERT INTO posts (headline, content, filename, userid) VALUES (:headline, :content, :fileNameNew, :userid)");
                        $uploadwithpic->bindParam(':headline', $headline);
                        $uploadwithpic->bindParam(':content', $content);
                        $uploadwithpic->bindParam(':fileNameNew', $fileNameNew);
                        $uploadwithpic->bindParam(':userid', $userid);
                    if ($uploadwithpic->execute()) {


                            echo '<script>window.location.href="feed.php"</script>';
                    }

                } else {
                    echo "Your file is too big!";
                }

            } else {
                echo "There was an error uploading your file!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }
    } else {

        $upload = $pdo->prepare("INSERT INTO posts (headline, content, userid) VALUES (:headline, :content, :userid)");
        $upload->bindParam('headline', $headline);
        $upload->bindParam('content', $content);
        $upload->bindParam('userid', $userid);
        echo $userid;
        if ($upload->execute()) {

        $myid = $_SESSION["angemeldet"];

             echo '<script>window.location.href="feed.php"</script>';
        }
            }
        } else {
            echo "There was a problem concerning your upload. Please try again!";
        }
?>