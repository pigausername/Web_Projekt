<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- hier ist der Link aus deinem Webspace https://mars.iuk.hdm-stuttgart.de/~ab238/css/stylesheet.css -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/CSS/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/CSS/navbar-top-fixed.css" rel="stylesheet">


    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/navbar-top-fixed.css" rel="stylesheet">


    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/web_projekt/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/web_projekt/css/navbar-top-fixed.css" rel="stylesheet">


</head>

<body>

<?php
session_start();
require_once "userdata.php";


if (isset($_SESSION["angemeldet"]))
{
    $userid = $_SESSION["angemeldet"];
    ?>


<div class="container"> <!-- folgender code definiert das die navbar dunkel ist und am oberen Rand fixiert ist und wann sich das Menü zu einem Hamburgermenü umwandelt.-->
    <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark rounded">
        <a class="navbar-brand" href="home1.php">RAM</a>

        <!-- folgender code lässt das responsive Menü erscheinen (Hamburgermenü)-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarsExample09">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="home1.php">Feed <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="profile.php" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown09">
                        <a class="dropdown-item" href="profile.php?userid=<?php echo $userid ?>">My Profile</a>
                        <a class="dropdown-item" href="profile_edit.php">Edit my Profil</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="search.php">Search</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Messages</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Log Out</a>
                </li>
            </ul>

            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <!--
            <form class="form-inline my-2 my-md-0">
                <input class="form-control" type="text" placeholder="Search" aria-label="Search">
            </form>
            -->

        </div>
    </nav>

    <?php
}
else
{
   header("Location: index.php");}

?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="Documents/Web_Projekt/jquery-migrate-1.4.1.min.js"><\/script>')</script>

    <script src="https://mars.iuk.hdm-stuttgart.de/~mv065/CSS/bootstrap.min.js"></script>
</body>
</html>

