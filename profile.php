<?php
include_once "header.php";

$userid = $_POST["userid"];
$username = $_POST["username"];
$email = $_POST["email"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];

$statement = $pdo->prepare("SELECT 'username', 'email', 'firstname', 'lastname' * FROM userdata");
    if($statement->execute()) //(array(':username' => $username, ':email' => $email, ':firstname' => $firstname, ':lastname' => $lastname))) {
        {
            while ($row = $statement->fetch()) {
//$_SESSION["angemeldet"] = $row["userid"];
            echo "blabla";

?>
<html>
<h1><?php echo "bla" //$_SESSION['username'];?></h1>
<form action="profile.php" method="GET">
    <table>
        <tr>
            <td>Profile picture:</td>
            <td><input type="file" name="pic"</td>
        </tr>
        <tr>
            <td>Username:</td>
            <td><?php echo $row['username'] ?> </td>
        </tr>
        <tr>
            <td>E-Mail:</td>
            <td><?php echo $row['email'] ?></td>
        </tr>
        <tr>
            <td>First name:</td>
            <td><?php echo $row['firstname'] ?></td>
        </tr>
        <tr>
            <td>Last name:</td>
            <td><?php echo $row['lastname'] ?></td>
        </tr>
    </table>

    <?php
    }
    }
    $headline= $_POST ["headline"];
    $file= $_POST ["file"];
    $content= $_POST["content"];
    $userid = $_SESSION["angemeldet"];


    $sql = $pdo->prepare("SELECT * FROM posts WHERE userid=:userid");
    if($sql->execute()) {
        while ($row = $sql->fetch()) {
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
        </table>


</form>
</html>
<?php
}
}
include_once "footer.php";
?>

