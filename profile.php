<?php
session_start();
require_once "userdata.php";
include_once "header.php";

$statement=$pdo->prepare ("SELECT * FROM userdata");

if($statement->execute()) {
    while ($row = $statement->fetch()) {
        echo $row['id'] . " " . $row['content'];
        echo "<br>";
    }
};
?>

<html>
<head>
</head>
<form action="profile.php" method="GET">
    <table>
        <tr><td>Username:</td></tr>
        <tr><td>E-mail:</td></tr>
        <tr><td>First name:</td></tr>
        <tr><td>Last name:</td></tr>
    </table>


</form>
</html>
<?php
include_once "footer.php";
?>

Profilbild
Alle meine post
Eigene Daten
Galerie
Möglichkeit zu liken und zu folgen

