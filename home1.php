<?php

include_once "header.php";

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/navbar-top-fixed.css" rel="stylesheet">

</head>

<body>



<!-- Post schreiben -->

<h2>Beitrag schreiben</h2>
<form action="uploads.php" method="post" enctype="multipart/form-data">
    <table>
    <tr>
        <td><textarea name="headline" placeholder="Titel" rows="2" cols="30"></textarea></td>
    </tr>
    <tr>
        <td><textarea name="content" placeholder="Type your text here" rows="10" cols="30"></textarea></td>
    </tr>
    <tr>
        <td><input type="file" name="file" id="file">
    </tr>
    <tr>
        <td><button type="submit" value="post" name="post">Post</button></td>
    </tr>
    </table>

</form>


<h2>Feed</h2>
<!-- hole Content aus Datenbank -->
<?php

$headline= $_POST ["headline"];
$file= $_POST ["file"];
$content= $_POST["content"];


$statement = $pdo->prepare("SELECT * FROM posts ORDER BY date DESC");
if($statement->execute()) {
    while($row=$statement->fetch()) {
        ?>
    <table>
        <tr>
        <?php
        $editor_id = $row['userid'];
        $display_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid= $editor_id");
        if($display_editor->execute()) {
            while ($row2 = $display_editor->fetch()) {
                ?>
                <td><?php echo $row['headline']." by " ?><a href="profile.php?userid=<?php $row['userid'] ?>"><?php echo " ".$row2['username'] ?></td>

        </tr>

        <tr>
            <td><?php echo $row['file'] ?></td>
        <tr>
            <td><?php echo $row['content']?></td>
        </tr>
        <br>
        </table>
        <tr>
            <td><?php echo $row['date']?></td>
        </tr>
        <br>
    </table>
    <?php
                }
            }
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
