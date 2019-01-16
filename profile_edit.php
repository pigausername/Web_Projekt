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

    if (empty($_POST["username"]) OR empty($_POST["password"])
        OR empty($_POST["repeatpassword"]) OR empty($_POST["email"])
        OR empty($_POST["firstname"]) OR empty($_POST["lastname"]) OR empty($_POST["subject"]) OR empty($_POST["semester"])) {

        ?>
        <br>
        <br>
        <br>
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
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Your passwords don't match!
        </div>
        <?php
    } else {
        echo "3";
        $options = ['cost' => 5];
        $hash = password_hash($password, PASSWORD_DEFAULT, $options);

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
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>You have successfully updated your profile!</strong> Head <a href="feed.php">here</a> back to
                home!
            </div>
            <?php
        } else {
            ?>
            <br>
            <br>
            <br>
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Info!</strong> Something went wrong. Try again!
            </div>
            <?php
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
            <div class="place_content_inside">


                <h2>Here you can edit your profile.</h2>
                <form action="profile_edit.php" method="POST">
                    <table>
                        <tr>
                            <td>Username:</td>
                            <td><input type="text" name="username" placeholder="<?php echo $row['username'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="password" placeholder="Password"></td>
                        </tr>
                        <tr>
                            <td>Please repeat your new password:</td>
                            <td><input type="password" name="repeatpassword" placeholder="Repeat your password"></td>
                        </tr>
                        <tr>
                            <td>E-Mail:</td>
                            <td><input type="text" name="email" placeholder="<?php echo $row['email'] ?>"</td>
                        </tr>
                        <tr>
                            <td>First name:</td>
                            <td><input type="text" name="firstname" placeholder="<?php echo $row['firstname'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Last name:</td>
                            <td><input type="text" name="lastname" placeholder="<?php echo $row['lastname'] ?>"></td>
                        </tr>
                        <!--<tr>
                            <td>Profile picture:</td>
                            <td><input type="file" name="profilepic" id="profilepic"></td>
                        </tr>
                        -->
                        <tr>
                            <td>Subject:</td>
                            <td><input type="text" name="subject" id="subject" placeholder="<?php echo $row['subject'] ?>"</td>
                        </tr>

                        <tr>
                            <td>Semester:</td>
                            <td><input type="number" name="semester" id="semester" min="1" max="10" placeholder="<?php echo $row['semester'] ?>"</td>
                        </tr>
                        <tr>
                            <td>
                                <button type="submit" name="save_changes" class="btn">Save changes</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        </body>
        <?php
    }
}




include_once "footer.php";
?>
