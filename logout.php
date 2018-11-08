<?php
session_start();
session_destroy();

//Cookies entfernen
setcookie("identifier","",time()-(3600*24*365));
setcookie("securitytoken","",time()-(3600*24*365));

echo" Logout erfolgreich.";
header('Location: index.php');
?>

