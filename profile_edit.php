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
        <form action="uploads.php" method="post" enctype="multipart/form-data">
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

//Daten in der Datenbank ändern --> UNVOLLSTÄNDIG


include_once "footer.php";
?>