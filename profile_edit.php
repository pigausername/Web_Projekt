<?php

include_once "header.php";

$userid = $_SESSION["angemeldet"];

//Bestehende Daten des Nutzers anzeigen

$statement = $pdo->prepare("SELECT `username`, `email`, `firstname`, `lastname`, `subject`, `semester` FROM userdata WHERE userid=$userid");
if($statement->execute()) {
    while ($row = $statement->fetch()) {
        ?>


        <head>
            <title>Edit your profile</title>
        </head>
        <body>
        <div class="place_content">

        <h1>Here you can edit your profile.</h1>
        <form action="profile_edit.php" method="post">
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
                <!--<tr>
                    <td>Profile picture:</td>
                    <td><input type="file" name="profilepic" id="profilepic"></td>
                </tr>
                -->
                <tr>
                    <td>Subject:</td>
                    <td><input type="text" name="subject" id="subject" placeholder="Subject" value="<?php //echo $row['subject'] ?>"</td>
                </tr>

                <tr>
                    <td>Semester:</td>
                    <td><input type="number" name="semester" id="semester" min="1" max="10" placeholder="Semester" value="<?php echo $row['semester'] ?>"></td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" name="save_changes" class="btn">Save changes</button>
                    </td>
                </tr>
            </table>
        </form>
        </body>
        <?php
    }
}


// Profil bearbeiten
if (isset($_POST['save_changes']))  {
    $userid = $_SESSION["angemeldet"];

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $subject = $_POST['subject'];
    $semester = $_POST['semester'];

    $options=['cost'=>5];
    $hash=password_hash($password, PASSWORD_DEFAULT, $options);

    $updateprofile = $pdo->prepare("UPDATE userdata SET username, password, email, firstname, lastname, subject, semester VALUES (:username, :password, :email; :firstname, :lastname, :subject, :semester) WHERE userid=$userid");
    $updateprofile->bindParam(':username', $username);
    $updateprofile->bindParam(':password', $hash);
    $updateprofile->bindParam(':email', $email);
    $updateprofile->bindParam(':firstname', $firstname);
    $updateprofile->bindParam(':lastname', $lastname);
    $updateprofile->bindParam(':subject', $subject);
    $updateprofile->bindParam(':semester', $semester);

    if ($updateprofile->execute()){
        echo "bla";
    }
    else {
        echo "blaaaa";
    }


}


include_once "footer.php";
?>
