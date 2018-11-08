<?php
session_start();
require_once "userdata.php";
include_once "header.php";

$statement="SELECT 'username', 'email', 'firstname', 'lastname' * FROM userdata";
$pdo = exec($statement);

?>
<html>
<h1><?php echo "bla" //$_SESSION['username'];?></h1>
<head>
</head>
<form action="profile.php" method="GET">
    <table>
        <tr>
            <td>Profile picture:</td>
            <td><input type="file" name="pic"</td>
        </tr>
        <tr>
            <td>Username:</td>
            <td><?php echo "bla" //$_SESSION['username'];?> </td>
        </tr>
        <tr>
            <td>E-Mail:</td>
            <td><?php echo "bla" //$_SESSION['email'];?></td>
        </tr>
        <tr>
            <td>First name:</td>
            <td><?php echo "bla" //$_SESSION['firstname'];?></td>
        </tr>
        <tr>
            <td>Last name:</td>
            <td><?php echo "bla" //$_SESSION['lastname'];?></td>
        </tr>
    </table>

<?php
    $headline= $_POST ["headline"];
    $file= $_POST ["file"];
    $content= $_POST["content"];


    $statement = $pdo->prepare("SELECT * FROM posts");
    if($statement->execute()) {
while ($row = $statement->fetch()) {
?>
    <table>
        <tr>
            <td><?php echo $row['headline'] ?></td>
        </tr>
        <tr>
            <td><?php echo $row['file'] ?></td>
        <tr>
            <td><?php echo $row['content'] ?></td>
        </tr>
        <br>
    </table>


</form>
</html>
<?php
}
}
include_once "footer.php";
?>

