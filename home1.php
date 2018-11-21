<?php

include_once "header.php";

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<style>

    footer {
        background-color: #555;
        color: white;
        padding: 15px;
    }

</style>
<body>


<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


            <a class="navbar-brand" href="#">Logo</a>

        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>


                <button class="btn btn-default" type="button">
                    <span class="glyphicon glyphicon-envelope"<></span>
                </button>

            </ul>
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group input-group">
                    <input type="text" class="form-control" placeholder="Search..">
                    <span class="input-group-btn">
            <button class="btn btn-default" type="button">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
                </div>
            </form>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> My Account</a></li>
            </ul>
        </div>
    </div>
</nav>


<!-- Hierbei hat der eingeloggte User die Möglichkeit einen Post zu schreiben -->
<h2>Beitrag schreiben</h2>
<form action="uploads.php" method="post" enctype="multipart/form-data">
    <table>
    <tr>
        <td><textarea name="headline" placeholder="Titel" rows="2" cols="30"></textarea></td>
    </tr>
    <tr>
        <td><textarea name="content" placeholder="Type your text here" rows="10" cols="30"></textarea></td>
    </tr>
    <tr>
        <td><input type="file" name="file" id="file">
    </tr>
    <tr>
        <td><button type="submit" value="post" name="post">Post</button></td>
    </tr>
    </table>

</form>


<h2>Feed</h2>

<!-- hole Content aus Datenbank -->
<?php

$headline= $_POST ["headline"];
$file= $_POST ["file"];
$content= $_POST["content"];
$filename= $_POST['filename'];
$myid= $_SESSION["angemeldet"];


// Hierbei wird kontrolliert wem der angemeldete User folgt
$display_follower = $pdo->prepare("SELECT * FROM followers WHERE followerid= $myid");
if ($display_follower->execute()) {
    while ($row3 = $display_follower->fetch()) {
        $feedid= $row3['userid'];
    }

// Zeige den Content der Nutzer denen der angemeldete User folge und meine eigenen Beiträge
$get_feed = $pdo->prepare("SELECT * FROM posts WHERE userid= $feedid OR userid= $myid ORDER BY date DESC");
if($get_feed->execute()) {
    while($row=$get_feed->fetch()) {
        ?>
    <table>
        <tr>
        <?php
        $editor_id = $row['userid'];


// Hierbei wird kontrolliert wer den jeweiligen Post geschrieben hat
        $display_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid= $editor_id");
        if($display_editor->execute()) {
            while ($row2 = $display_editor->fetch()) {
                ?>
                <!-- Hierbei wird der Content in Tabellenform angezeigt -->
                <td><?php echo $row['headline'] . " by " ?><a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo " " . $row2['username'] ?></td>

                </tr>
                <tr>
                    <td><a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img src="pictures/<?php echo $row2['profilepic'] ?>"></td>
                </tr>
                <tr>
                    <td><img src="pictures/<?php echo $row['filename'] ?>"></td>
                </tr>
                <tr>
                    <td><?php echo $row['content'] ?></td>
                </tr>
                <br>
                <tr>
                    <td><?php echo $row['date'] ?></td>
                </tr>
                <br>
                </table>
                <?php
            }
                }
            }
    }
} else {
    echo "Datenbank-Fehler:";
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die();
}
include_once "footer.php";
?>

</body>

</html>
