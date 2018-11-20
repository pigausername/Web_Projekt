
<?php
include_once "header.php";

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

    // Definiere welche Dateiformate erlaubt sind
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'pictures/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                // vorbereiten und schreiben in die Datenbank
                $upload = $pdo ->prepare ("INSERT INTO posts (`headline`,`content`,`filename`,`userid`) VALUES ('$headline', '$content', '$fileNameNew', '$userid')");
                $upload->execute();

                // wenn upload erfolgreich, schicke zurück zu home1.php
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
