
<?php
session_start();

include_once "userdata.php";

// variablen festgelegt die für die Verarbeitung gebraucht werden
if (isset($_POST['post'])) {
    $headline = $_POST['headline'];
    $content = $_POST['content'];
    $userid = $_SESSION["angemeldet"];
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'pictures/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                $upload = $pdo ->prepare ("INSERT INTO posts (`headline`,`content`,`userid`) VALUES ('$headline', '$content', '$userid')");
                $upload->execute();

                header("location: home1.php");
            } else {
                echo "Your file is to big!";
            }

        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }

}


?>
