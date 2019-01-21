<?php
session_start();
include_once "userdata.php";

?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/webprojekt/CSS/bootstrap.min.css" rel="stylesheet">
    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<?php
$myid = $_SESSION["angemeldet"];
// variablen festgelegt die für die Verarbeitung gebraucht werden
// Upload von Post Content ohne Bild
if (isset($_POST['headline']) AND isset($_POST['content'])) {
    $headline = $_POST['headline'];
    $content = $_POST['content'];
    $userid = $_SESSION["angemeldet"];

    if ((stripos($headline, "<") !== false) OR (stripos($content, "<") !== false)) {
        ?>
        <!-- Meldung - wenn Java in das Feld geschrieben wird -->
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Don't mess with us! Head back to <a href="feed.php">your feed</a>.
        </div>
        <?php
        die();
    }

// Show alert Button if Headline or Content is empty

    if (empty($_POST["headline"]) OR empty($_POST["content"])) {
        ?>
        <!-- Fehlermeldung - Wenn ein Feld leer ist -->
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> A good post requires both a headline and content. Try <a href="feed.php">here</a> again.
        </div>
        <?php
    } else {

        //Uploadcode dafür, wenn der Post ein Bild enthält
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

                        $uploadwithpic = $pdo->prepare("INSERT INTO posts (headline, content, filename, userid) VALUES (:headline, :content, :fileNameNew, :userid)");
                        $uploadwithpic->bindParam(':headline', $headline);
                        $uploadwithpic->bindParam(':content', $content);
                        $uploadwithpic->bindParam(':fileNameNew', $fileNameNew);
                        $uploadwithpic->bindParam(':userid', $userid);


                        if ($uploadwithpic->execute()) {

                            $checkfollow=$pdo->prepare("SELECT * FROM followers WHERE userid=$myid");
                            $checkfollow->execute();

                            $no=$checkfollow->rowCount();
                            if(!$no > 0) {
                                echo '<script>window.location.href="feed.php"</script>';
                            }
                            else
                                {

                                echo '<script>window.location.href="do_notification.php"</script>';
                            }
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

            // Uploadcode dafür, wenn der Post kein Bild beinhält
            $nopic = "NULL";

            $upload = $pdo->prepare("INSERT INTO posts (headline, content, filename, userid) VALUES (:headline, :content, :filename, :userid)");
            $upload->bindParam('headline', $headline);
            $upload->bindParam('content', $content);
            $upload->bindParam('filename', $nopic);
            $upload->bindParam('userid', $userid);

            if ($upload->execute()) {

                $checkfollow=$pdo->prepare("SELECT * FROM followers WHERE userid=$myid");
                $checkfollow->execute();

                $no=$checkfollow->rowCount();
                if(!$no > 0) {
                    echo '<script>window.location.href="feed.php"</script>';
                }
                else
                {

                    echo '<script>window.location.href="do_notification.php"</script>';
                }
            }
        }
    }
}
else {
        echo "There was a problem concerning your upload. Please try again!";
    }

?>