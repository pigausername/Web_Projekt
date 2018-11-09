<?php
session_start();
require_once "userdata.php";

if (isset($_SESSION["angemeldet"]))
{    ?>
    <ul>
        <li><a href="home1.php">Home</a></li>
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
        <li><a href="logout.php">Log Out</a></li>
    </ul>
    <?php
}
else
{
   header("Location: index.php");}

?>
