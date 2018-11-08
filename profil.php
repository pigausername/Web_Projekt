<?php
session_start();
require_once "userdata.php";

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
<form action="profil.php" method="GET">
    <table>
        <tr><td>Username:</td></tr>
        <tr><td>E-mail:</td></tr>
        <tr><td>First name:</td></tr>
        <tr><td>Last name:</td></tr>
    </table>


</form>
</html>



/**
 * Created by PhpStorm.
 * User: anni
 * Date: 07.11.18
 * Time: 11:42
 */

Profilbild
Alle meine post
Eigene Daten
Galerie
Möglichkeit zu liken und zu folgen

