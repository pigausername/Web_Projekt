<?php

include_once "header.php";

$userid = $_SESSION["angemeldet"];

//Bestehende Daten des Nutzers anzeigen

$statement = $pdo->prepare("SELECT `username`, `email`, `firstname`, `lastname` FROM userdata WHERE userid=$userid");
if($statement->execute()) {
    while ($row = $statement->fetch()) {
        ?>


        <head>
            <title>Edit your profile</title>
        </head>
        <body>
        <div class="content">
        <h1>Here you can edit your profile.</h1>
        <form action="profile_edit.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Username" required
                               value="<?php echo $row['username'] ?>"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td>Please repeat your new password:</td>
                    <td><input type="password" name="repeatpassword" placeholder="Repeat your password" required></td>
                </tr>
                <tr>
                    <td>E-Mail:</td>
                    <td><input type="text" name="email" placeholder="E-mail" required
                               value="<?php echo $row['email'] ?>"></td>
                </tr>
                <tr>
                    <td>First name:</td>
                    <td><input type="text" name="firstname" placeholder="First name" required
                               value="<?php echo $row['firstname'] ?>"></td>
                </tr>
                <tr>
                    <td>Last name:</td>
                    <td><input type="text" name="lastname" placeholder="Last name" required
                               value="<?php echo $row['lastname'] ?>""></td>
                </tr>
                <tr>
                    <td>Profile picture:</td>
                    <td><input type="file" name="profilepic" id="profilepic">
                </tr>
                <tr>
                    <td>
                        <button type="submit" name="save" class="btn">Save changes</button>
                    </td>
                </tr>
            </table>
        </form>
        </body>
        <?php
    }
}


// Profil bearbeiten
if (isset($_POST['save'])) {
    $headline = $_POST['headline'];
    $content = $_POST['content'];
    $userid = $_SESSION["angemeldet"];
    $file = $_FILES['profilepic'];

    $fileName = $_FILES['profilepic']['name'];
    $fileTmpName = $_FILES['profilepic']['tmp_name'];
    $fileSize = $_FILES['profilepic']['size'];
    $fileError = $_FILES['profilepic']['error'];
    $fileType = $_FILES['profilepic']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    // Definiere welche Dateiformate erlaubt sind
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = "Profilepic".$userid. "." .$fileActualExt;
                $fileDestination = 'pictures/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);



                // vorbereiten und schreiben in die Datenbank
             /*   $updateprofile = $pdo ->prepare ("UPDATE userdata SET profilepic='$fileNameNew' WHERE userid=$userid");
                if ($updateprofile->execute()) {
                    // wenn upload erfolgreich, schicke zurück zu home1.php
             */

                    $updateprofil = $pdo->prepare("UPDATE userdata SET profilpic VALUES (?)) WHERE userid= $userid");
                    $update=array($_POST['fileNameNew']);

                if ($updateprofile->execute(update)) {


                    echo "You just successfully update your profile!";
                    echo "<br>";
                    echo "Head back to your profile ". '<a href="profile.php?userid=' . $userid . '"> here</a>' . ".";
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

}


include_once "footer.php";
?>
</div>
