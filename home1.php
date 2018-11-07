<?php
session_start();
require_once "userdata.php";

if(!isset($_SESSION["angemeldet"]))
{
    echo"angemeldet.";

}
else
{
    echo"nicht angemeldet.";
}
?>


<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>
        RAM
    </title>
</head>
<body>
<h1>RAM</h1>
<a href="logout.php">Logout</a><br>
<a href="profil.php">Profil</a><br>
<a href="profile_edit.php">Edit profile</a><br>




<!-- Post schreiben -->

<form action="home1.php" method="post">
    <textarea name="headline" placeholder="Titel" rows="2" cols="30" required></textarea><br>
    <input type="file" name="pic" accept="file_extension|audio/*|video/*|image/*|media_type"><br>
    <textarea name="content" placeholder="Type your text here" rows="10" cols="30" required></textarea>
    <input name="post" type="submit">
</form>




<!-- füge Daten in die Datenbank -->

<?php
if (isset($_POST['post'])) {
    $headline = $_POST['headline'];
    $file = $_POST['file'];
    $content = $_POST['content'];


    $sql = "INSERT INTO posts (`headline`, `file`, `content`) VALUES ('$headline', '$file', '$content')";
    header("Location: home1.php");
    $pdo->exec($sql);
    }

?>




<!-- hole Content aus Datenbank -->
<?php
echo"<br>";
$headline= $_POST ["headline"];
$file= $_POST ["file"];
$content= $_POST["content"];


$statement = $pdo->prepare("SELECT * FROM posts");
if($statement->execute()) {
    while($row=$statement->fetch()) {
        echo $row['headline'];
        echo "<br>";
        echo $row['file'];
        echo "<br>";
        echo $row['content'];
        echo "<br><br>";
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
