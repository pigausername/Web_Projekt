<?php
session_start();

require_once "userdata.php";

if(!isset($_SESSION["angemeldet"]))
{
    echo"nicht angemeldet.";
    ;
}


?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>
        Mein Blog
    </title>
</head>
<body>
<h1>RAM</h1>
<a href="logout.php">Logout</a><br>
<a href="profil.php">Profil</a><br>
<a href="profile_edit.php">Edit profile</a><br>

<!-- Post schreiben -->

<form action="do_post.php" method="post">
    <table>
    <tr>
        <td><textarea name="headline" placeholder="Titel" rows="2" cols="30"></textarea></td>
    </tr>
    <tr>
        <td><input type="file" name="pic" accept="file_extension|audio/*|video/*|image/*|media_type"></td>
    <tr>
        <td><textarea name="content" placeholder="Type your text here" rows="10" cols="30"></textarea></td>
    </tr>
    <tr>
        <td><input type="submit"></td>
    </tr>
    </table>
</form>

<?php

// hole Content aus Datenbank

echo"<br>";
$content= $_POST["content"];
echo $content;

$statement = $pdo->prepare("SELECT * FROM posts");
if($statement->execute()) {
    while($row=$statement->fetch()) {
        echo $row['id']." ".$row['content'];
        echo "<br>";
    }
} else {
    echo "Datenbank-Fehler:";
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die();
}

?>

</body>

</html>
