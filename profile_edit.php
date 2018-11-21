<?php

include_once "header.php";

$userid = $_SESSION["angemeldet"];

//Bestehende Daten des Nutzers anzeigen

$statement = $pdo->prepare("SELECT `username`, `email`, `firstname`, `lastname` FROM userdata WHERE userid=$userid");
if($statement->execute()) {
    while ($row = $statement->fetch()) {
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Edit your profile</title>
        </head>
        <body>
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
        </html>
        <?php
    }
}


// Profil bearbeiten
if (isset($_POST['save'])) {

    echo "11";

    $userid = $_SESSION["angemeldet"];
    $newusername = $_POST['username'];
    $newpassword = $_POST['password'];
    $newrepeatpassword = $_POST['repeatpassword'];
    $newemail = $_POST['email'];
    $newfirstname = $_POST['firstname'];
    $newlastname = $_POST['lastname'];

    // CHECKEN OB PROFILBILD VORHANDEN
    $checkprofilepic = $pdo->prepare("SELECT profilepic FROM userdata WHERE userid=$userid");
    $checkprofilepic->execute();

    $noo = $checkprofilepic->rowCount();
    if (!$noo > 0) { // WENN KEIN PROFILBILD VORHANDEN IST

        echo "22";

        $profilepic = $_FILES['profilepic'];

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
            echo "33";
            if (in_array($ProfilepicActualExt, $allowedfiletypes)) {
                echo "44";
                if ($ProfilepicError === 0) {
                    echo "55";
                    if ($ProfilepicSize < 1000000) {
                        $ProfilepicNameNew = uniqid('', true) . "." . $ProfilepicActualExt;
                        $ProfilepicDestination = 'pictures/' . $ProfilepicNameNew;
                        move_uploaded_file($ProfilepicTmpName, $ProfilepicDestination);

                        $UserUpdate = $pdo->prepare("UPDATE userdata
                                      SET password='$newpassword', email='$newemail',username='$newusername', firstname='$newfirstname', lastname='$newlastname', profilepic='$ProfilepicNameNew' 
                                      WHERE userid=$userid");

                        echo "66";

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
    } else // PROFILBILD VORHANDEN
    {
        //VORHANDENE DATENBANK CHECKEN
        $checkprofile = $pdo->prepare("SELECT * FROM userdata WHERE userid= $userid");
        echo "0";
        if ($checkprofile->execute()) {
            echo "1";
            while ($row = $checkprofile->fetch()) {
                $ProfilepicOld = $row['profilepic'];
                echo "2";

                //ALTES PROFILBILD LÖSCHEN
                unlink(realpath('pictures/' . $ProfilepicOld));

                //NEUES PROFILBILD HOCHLADEN

                $profilepic = $_FILES['profilepic'];

                $ProfilepicName = $_FILES['profilepic']['name'];
                $ProfilepicTmpName = $_FILES['profilepic']['tmp_name'];
                $ProfilepicSize = $_FILES['profilepic']['size'];
                $ProfilepicError = $_FILES['profilepic']['error'];
                $ProfilepicType = $_FILES['profilepic']['type'];

                $ProfilepicExt = explode('.', $ProfilepicName);
                $ProfilepicActualExt = strtolower(end($ProfilepicExt));

                // Definiere welche Dateiformate erlaubt sind
                $allowedfiletypes = array('jpg', 'jpeg', 'png');

                if (in_array($ProfilepicActualExt, $allowedfiletypes)) {
                    echo "3";
                    if ($ProfilepicError === 0) {
                        echo "4";
                        if ($ProfilepicSize < 1000000) {
                            $ProfilepicNameNew = uniqid('', true) . "." . $ProfilepicActualExt;
                            $ProfilepicDestination = 'pictures/' . $ProfilepicNameNew;
                            move_uploaded_file($ProfilepicTmpName, $ProfilepicDestination);
                            echo "5";

                            //SQL TABELLE UPDATEN

                            $ProfilepicUpdate = $pdo->prepare("UPDATE userdata
                                      SET profilepic= '$ProfilepicNameNew' 
                                      WHERE profilepic= '$ProfilepicOld'");

                            if ($ProfilepicUpdate->execute()) {
                                echo "You just successfully updated your profile!";
                                echo "<br>";
                                echo "Head back to your profile " . '<a href="profile.php?userid=' . $userid . '"> here</a>' . ".";
                            } else {
                                echo "you failed";
                            }
                        }
                    }
                }
            }
        }
    }
}

include_once "footer.php";
?>