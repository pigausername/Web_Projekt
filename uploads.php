
<?php
include_once "header.php";

// variablen festgelegt die für die Verarbeitung gebraucht werden
// Upload von Post Content ohne Bild

if (isset($_POST['headline']) AND isset($_POST['content'])) {
    $headline = $_POST['headline'];
    $content = $_POST['content'];
    $userid = $_SESSION["angemeldet"];

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
                    echo $headline;
                    echo $content;
                    echo $fileNameNew;

                    // vorbereiten und schreiben in die Datenbank
                    $uploadwithpic = $pdo->prepare("INSERT INTO posts (`headline`,`content`,`filename`,`userid`) VALUES ('$headline', '$content', '$fileNameNew', '$userid')");
                    if ($uploadwithpic->execute()){
                    header("location: home1.php");
                    }

                    // wenn upload erfolgreich, schicke zurück zu home1.php
                    //header("location: home1.php");
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
        $upload = $pdo->prepare("INSERT INTO posts (`headline`,`content`,`userid`) VALUES ('$headline', '$content', '$userid')");
        if ($upload->execute()) {
            header("location: home1.php");
        }
    }
}
    else {
        echo "There was a problem concerning your upload. Please try again!";
    }

?>