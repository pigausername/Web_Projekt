
<?php
include_once "header.php";

// variablen festgelegt die für die Verarbeitung gebraucht werden
// Upload von Post Content
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
                echo "Your file is too big!";
            }

        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }

}



if (isset($_POST['save'])) {

    $newusername = $_POST['username'];
    $newpassword = $_POST['password'];
    $newrepeatpassword = $_POST['repeatpassword'];
    $newemail = $_POST['email'];
    $newfirstname = $_POST['firstname'];
    $newlastname = $_POST['lastname'];
    $profilepic = $_FILES['profilepic'];
    $userid = $_SESSION["angemeldet"];

    $ProfilepicName = $_FILES['profilepic']['name'];
    $ProfilepicTmpName = $_FILES['profilepic']['tmp_name'];
    $ProfilepicSize = $_FILES['profilepic']['size'];
    $ProfilepicError = $_FILES['profilepic']['error'];
    $ProfilepicType = $_FILES['profilepic']['type'];

    $ProfilepicExt = explode('.', $ProfilepicName);
    $ProfilepicActualExt = strtolower(end($ProfilepicExt));

    // Definiere welche Dateiformate erlaubt sind
    $allowedfiletypes = array('jpg', 'jpeg', 'png');


    if ($newpassword == $newrepeatpassword) {
        if (in_array($ProfilepicActualExt, $allowedfiletypes)) {
            if ($ProfilepicError === 0) {

                if ($ProfilepicSize < 1000000) {
                    $ProfilepicNameNew = uniqid('', true) . "." . $ProfilepicActualExt;
                    $ProfilepicDestination = 'pictures/' . $ProfilepicNameNew;
                    move_uploaded_file($ProfilepicTmpName, $ProfilepicDestination);

                    $UserUpdate = $pdo->prepare("UPDATE userdata
                                      SET password='$newpassword', email='$newemail',username='$newusername', firstname='$newfirstname', lastname='$newlastname', profilepic='$ProfilepicNameNew' 
                                      WHERE userid=$userid");


                    if ($UserUpdate->execute()) {
                        echo "You just successfully updated your profile!";
                        echo "<br>";
                        echo "Head back to your profile " . '<a href="profile.php?userid=' . $userid . '"> here</a>' . ".";
                    }
                }
            }
        }
    } else {
        echo "Bestätigen Sie Ihr Passwort.";

    }
}



?>
