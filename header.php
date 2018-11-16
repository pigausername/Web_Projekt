<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Footer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<style>

    ul {
        position: fixed;
        top: 0;
        width: 100%;
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: scroll;
        background-color: #333;
    }

    li {
        float: left;
    }

    li.right {
        float: right;
    }

    li a, .dropbtn {
        display: inline-block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }



    li.dropdown {
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: grey;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }


    .dropdown-content a:hover {
        background-color: grey
    }


    .dropdown:hover .dropdown-content {
        display: block;
    }


    li a:hover, .dropdown:hover .dropbtn {
        background-color: #555555;
        display: inline;
    }



</style>

<?php
session_start();
require_once "userdata.php";

if (isset($_SESSION["angemeldet"]))
{
    ?>


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
        -->
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


    <?php
}
else
{
   header("Location: index.php");}

?>
