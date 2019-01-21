<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/webprojekt/CSS/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~mv065/webprojekt/CSS/navbar-top-fixed.css" rel="stylesheet">

    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/navbar-top-fixed.css" rel="stylesheet">


    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://mars.iuk.hdm-stuttgart.de/~ab238/css/navbar-top-fixed.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="stylesheet.css">



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
    <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="feed.php">RAM</a>

        <!-- folgender code lässt das responsive Menü erscheinen (Hamburgermenü)-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarsExample09">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" id="bar-link" href="feed.php">Feed</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="bar-link" href="profile.php?userid=<?php echo $userid?>">Profile</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="bar-link" href="logout.php">Log Out</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="notify_dd_toggle">
                        <span class="label label-pill label-danger count" style="border-radius:10px;"></span>
                        <span class="glyphicon glyphicon-envelope" style="font-size:18px;"></span> (<span id="notify_count"></span>)</a>
                    <ul class="dropdown-menu" id="notify_dd"></ul>
                </li>
            </ul>

            <form action="search.php" class="form-inline" method="POST">
                <input class="form-control mr-sm-2" name="result" type="search" placeholder="Search..." aria-label="Search">
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
            </form>


        </div>
    </nav>
</div>

    <script>

        $(document).ready(function(){

            $('#notify_dd_toggle').on('click', function(event){
                event.preventDefault(); // Bedeutet in etwa Absicherung, was passieren würde, wenn der Code nicht funktioniert
                $.get("fetch_notification.php", function(data, status){
                    $('#notify_dd').html(data);
                });
            });
        });

        $(document).ready(function(){
            setInterval(function() {
                $("#notify_count").load("count_notification.php");
            }, 50);
        });


    </script>



<?php

}


else

{
   header("Location: index.php");}
?>


<script>window.jQuery || document.write('<script src="Documents/Web_Projekt/jquery-migrate-1.4.1.min.js"><\/script>')</script>
<script src="https://mars.iuk.hdm-stuttgart.de/~mv065/webprojekt/CSS/bootstrap.min.js"></script>
<script src="https://mars.iuk.hdm-stuttgart.de/~ab238/css/bootstrap.min.js"></script>
<script src="https://mars.iuk.hdm-stuttgart.de/~rk067/web_projekt/css/bootstrap.min.js"></script>




