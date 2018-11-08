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


<!-- Post schreiben -->

<h2>Beitrag schreiben</h2>
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
        <td><input type="submit" name="post"></td>
    </tr>
    </table>



<!-- schicke einen Post in die Datenbank -->

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



<h2>Feed</h2>
<!-- hole Content aus Datenbank -->
<?php
echo"<br>";
$headline= $_POST ["headline"];
$file= $_POST ["file"];
$content= $_POST["content"];


$statement = $pdo->prepare("SELECT * FROM posts ORDER BY date DESC");
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
