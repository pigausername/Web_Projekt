<?php
session_start();

require_once "userdata.php";
include_once "header.php";

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
        RAM
    </title>
</head>
<body>
<h1>RAM</h1>
<a href="logout.php">Logout</a><br>
<a href="profile.php">Profil</a><br>
<a href="profile_edit.php">Edit profile</a><br>

<!-- Post schreiben -->

<form action="home1.php" method="post">
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
        ?>
    <table>
        <tr>
            <td><?php echo $row['headline'] ?></td>
        </tr>
        <tr>
            <td><?php echo $row['file'] ?></td>
        <tr>
            <td><?php echo $row['content']?></td>
        </tr>
        <br>
    </table>
    <?php
    }
} else {
    echo "Datenbank-Fehler:";
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die();
}
include_once "footer.php";
?>

</body>

</html>
