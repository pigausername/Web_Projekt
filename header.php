<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Header</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/navbar-top-fixed.css" rel="stylesheet">



<!-- hier ist der Link aus deinem Webspace https://mars.iuk.hdm-stuttgart.de/~ab238/css/stylesheet.css -->

</head>

<body>

<?php
session_start();
require_once "userdata.php";

if (isset($_SESSION["angemeldet"]))
{
    ?>



<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
        <a class="navbar-brand" href="home1.php">RAM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample09">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="home1.php">Feed <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="profile_edit.php">Edit my Profile</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown09">
                        <a class="dropdown-item" href="profile_edit.php">Edit my Profil</a>

                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-md-0">
                <input class="form-control" type="text" placeholder="Search" aria-label="Search">
            </form>
        </div>
    </nav>

<!--
    <ul>
        <li><a class="active" href="home1.php">Feed</a></li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Profile</a>
            <div class="dropdown-content">
                <a href="profile.php">My Profile</a>
                <a href="profile_edit.php">Edit my Profile</a>
            </div>
        </li>
        <!--
        Suchleiste<li><a href="profil.php">Profile</a></li>
        Messages<li><a href="messages.php">Messages</a></li>
        Notifications<li><a href="notifications.php">Notifications</a></li>

        <li><a href="#">Settings</a></li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">More</a>
            <div class="dropdown-content">
                <a href="#">Imprint</a>
                <a href="#">Finde more users</a>
            </div>
        </li>
        <li class="right"><a href="logout.php">Log Out</a></li>
    </ul>

-->
    <?php
}
else
{
   header("Location: index.php");}

?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="Documents/Web_Projekt/jquery-migrate-1.4.1.min.js"><\/script>')</script>

    <script src="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.js"></script>

</body>
</html>

