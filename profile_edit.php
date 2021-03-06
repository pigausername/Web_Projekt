<?php

include_once "header.php";
?>


<head>
    <title>Edit your profile</title>
</head>

<?php

$userid = $_SESSION["angemeldet"];

// Profil bearbeiten
if (isset($_POST['save_changes'])) {
    $userid = $_SESSION["angemeldet"];

    $username = $_POST['username'];
    $password = $_POST['password'];
    $rpassword = $_POST['repeatpassword'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $subject = $_POST['subject'];
    $semester = $_POST['semester'];


    if ((stripos($username, "<") !== false) OR (stripos($password, "<") !== false)
        OR (stripos($rpassword, "<") !== false)  OR (stripos($email, "<") !== false)
        OR (stripos($firstname, "<") !== false)  OR (stripos($lastname, "<") !== false)
        OR (stripos($subject, "<") !== false)  OR (stripos($semester, "<") !== false)) {
        ?>
        <!-- Meldung - wenn Java in das Feld geschrieben wird -->
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Don't mess with us! Head back to <a href="feed.php">your feed</a>.
        </div>
        <?php
        die();
    }

    if (empty($_POST["username"]) OR empty($_POST["password"])
        OR empty($_POST["repeatpassword"]) OR empty($_POST["email"])
        OR empty($_POST["firstname"]) OR empty($_POST["lastname"]) OR empty($_POST["subject"]) OR empty($_POST["semester"])) {

        ?>
        <br>
        <br>
        <br>
        <!-- Fehlermeldung - wenn ein Feld nicht ausgefüllt ist -->
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Please fill in all fields!
        </div>
        <?php

    } elseif ($_POST["password"] != $_POST["repeatpassword"]) {
        ?>
        <br>
        <br>
        <br>
        <!-- Fehlermeldung - wenn die Passwörter nicht übereinstimmen -->
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Your passwords don't match!
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

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            // Definiere welche Dateiformate erlaubt sind
            $allowed = array('jpg', 'jpeg', 'png', 'pdf');

            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    echo "BLA BLa BLa";
                    if ($fileSize < 1000000) {
                        echo "BLA BLA BLA BLA";
                        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = 'pictures/' . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);

                        $options = ['cost' => 5];
                        $hash = password_hash($password, PASSWORD_DEFAULT, $options);

                        // Update Profilinformationen wenn Bild vorhanden
                        $updateprofile = $pdo->prepare("UPDATE `userdata` 
        SET `username` = :username, `password` = :password, `email` = :email, `firstname` = :firstname, `lastname` = :lastname, profilepic = :profilepic, `subject` = :subject, `semester` = :semester
        WHERE `userid` = :userid");

                        $updateprofile->bindParam(':username', $username);
                        $updateprofile->bindParam(':userid', $userid);
                        $updateprofile->bindParam(':password', $hash);
                        $updateprofile->bindParam(':email', $email);
                        $updateprofile->bindParam(':firstname', $firstname);
                        $updateprofile->bindParam(':lastname', $lastname);
                        $updateprofile->bindParam(':profilepic', $fileNameNew);
                        $updateprofile->bindParam(':subject', $subject);
                        $updateprofile->bindParam(':semester', $semester);
                        $updateprofile->execute();
                        $updateprofile->execute();


                        $checkprofile = $pdo->prepare("SELECT `username`, `password`, `email`, `firstname`, `lastname`, `subject`, `semester` FROM `userdata` WHERE userid=$userid");
                        $checkprofile->execute();

                        $row2 = $checkprofile->fetch();
                        $newusername = $row2["username"];
                        $newpassword = $row2["password"];
                        $newemail = $row2["email"];
                        $newfirstname = $row2["firstname"];
                        $newlastname = $row2["lastname"];
                        $newsubject = $row2["subject"];
                        $newsemester = $row2["semester"];
                        $newpic = $row2["profilepic"];


                        if ($newusername == $_POST['username'] AND $newpassword == $hash AND $newemail == $_POST['email'] AND $newfirstname == $_POST['firstname']
                            AND $newlastname == $_POST['lastname'] AND $newsubject == $_POST['subject'] AND $newsemester == $_POST['semester']) {
                            ?>
                            <br>
                            <br>
                            <br>
                            <!-- Meldung - wenn das Profil erfolgreich geupdated wurde -->
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>You have successfully updated your profile!</strong> Head <a href="feed.php">here</a> back to home!
                            </div>
                            <?php
                        } else {
                            ?>
                            <br>
                            <br>
                            <br>
                            <!-- Fehlermeldung - wenn das Profil nicht erfolgreich geupdated wurde -->
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Info!</strong> Something went wrong. Try again!
                            </div>
                            <?php
                        }


                    }
                }
            }
        } else {



            $options = ['cost' => 5];
            $hash = password_hash($password, PASSWORD_DEFAULT, $options);

            // Update Profilinformationen
            $updateprofile = $pdo->prepare("UPDATE `userdata` 
        SET `username` = :username, `password` = :password, `email` = :email, `firstname` = :firstname, `lastname` = :lastname, `subject` = :subject, `semester` = :semester
        WHERE `userid` = :userid");

            $updateprofile->bindParam(':username', $username);
            $updateprofile->bindParam(':userid', $userid);
            $updateprofile->bindParam(':password', $hash);
            $updateprofile->bindParam(':email', $email);
            $updateprofile->bindParam(':firstname', $firstname);
            $updateprofile->bindParam(':lastname', $lastname);
            $updateprofile->bindParam(':subject', $subject);
            $updateprofile->bindParam(':semester', $semester);
            $updateprofile->execute();

            $checkprofile = $pdo->prepare("SELECT `username`, `password`, `email`, `firstname`, `lastname`, `subject`, `semester` FROM `userdata` WHERE userid=$userid");
            $checkprofile->execute();

            $row2 = $checkprofile->fetch();
            $newusername = $row2["username"];
            $newpassword = $row2["password"];
            $newemail = $row2["email"];
            $newfirstname = $row2["firstname"];
            $newlastname = $row2["lastname"];
            $newsubject = $row2["subject"];
            $newsemester = $row2["semester"];


            if ($newusername == $_POST['username'] AND $newpassword == $hash AND $newemail == $_POST['email'] AND $newfirstname == $_POST['firstname']
                AND $newlastname == $_POST['lastname'] AND $newsubject == $_POST['subject'] AND $newsemester == $_POST['semester']) {
                ?>
                <br>
                <br>
                <br>
                <!-- Meldung - wenn das Profil erfolgreich geupdated wurde -->
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>You have successfully updated your profile!</strong> Head <a href="feed.php">here</a> back to home!
                </div>
                <?php
            } else {
                ?>
                <br>
                <br>
                <br>
                <!-- Fehlermeldung - wenn das Profil nicht erfolgreich geupdated wurde -->
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Info!</strong> Something went wrong. Try again!
                </div>
                <?php
            }

        }
    }
}

//Bestehende Daten des Nutzers anzeigen
$statement = $pdo->prepare("SELECT `username`, `email`, `firstname`, `lastname`, `subject`, `semester` FROM userdata WHERE userid=$userid");
if($statement->execute()) {
    while ($row = $statement->fetch()) {
        ?>

        <body>
        <div id="place_content">
            <div class="place_content_inside" style="min-width: 100%">


                <h2>Here you can edit your profile</h2><br>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-5" style="margin: auto">

                <form action="profile_edit.php" method="POST" enctype="multipart/form-data">
                    <table style="text-align: left">
                        <tr>
                            <td>Username:</td>
                            <td><input type="text" name="username" value="<?php echo $row['username'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="password" placeholder="Password"></td>
                        </tr>
                        <tr>
                            <td>Repeat your password:</td>
                            <td><input type="password" name="repeatpassword" placeholder="Repeat your password"></td>
                        </tr>
                        <tr>
                            <td>E-Mail:</td>
                            <td><input type="text" name="email" value="<?php echo $row['email'] ?>"</td>
                        </tr>
                        <tr>
                            <td>First name:</td>
                            <td><input type="text" name="firstname" value="<?php echo $row['firstname'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Last name:</td>
                            <td><input type="text" name="lastname" value="<?php echo $row['lastname'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Profile picture:</td>
                            <td><input type="file" name="file" id="file" value="File"></td>
                        </tr>

                        <tr>
                            <td>Subject:</td>
                            <td><input type="text" name="subject" id="subject" value="<?php echo $row['subject'] ?>"</td>
                        </tr>

                        <tr>
                            <td>Semester:</td>
                            <td><input type="number" name="semester" id="semester" min="1" max="10" value="<?php echo $row['semester'] ?>"</td>
                        </tr>
                    </table>

                    <br>

                    <button type="submit" name="save_changes" class="btn btn-info">Save changes</button>

                </form>

                            </div>
                            <div class="col-md-3"></div>
                        </div>
            </div>
        </div>
        </body>
        <?php
    }
}




include_once "footer.php";
?>
