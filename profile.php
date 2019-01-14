<?php
include_once "header.php";
?>

<!doctype html>
    <html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
<body>
<div class="row" id="profile_place_content" style="background-color: rgb(225, 225, 225)">

    <div class="col-md-4">
        <div class="steckbrief">
            <div class="place_content_inside">

<?php
$myprofile_id = $_SESSION["angemeldet"];
$profile_id = $_GET['userid'];
//Daten des jeweiligen Nutzers anzeigen
$display_user = $pdo->prepare("SELECT * FROM userdata WHERE userid= $profile_id");
$display_user->execute();
$row2 = $display_user->fetch();
        ?>
        <title><?php echo $row2['username'] ?></title>
        <h1 style="text-align: center"><?php echo $row2['username'] ?></h1>
    <br>

        <img class="profilepic" src="pictures/<?php echo $row2['profilepic'] ?>">
    <br>
    <br>
            E-Mail: <?php echo $row2['email'] ?> <br>
            First name: <?php echo $row2['firstname'] ?> <br>
            Last name: <?php echo $row2['lastname'] ?> <br>
            Subject: <?php echo $row2['subject'] ?> <br>
            Semester: <?php echo $row2['semester'] ?> <br>

        <hr />
        <?php


include_once "show_followers.php";
include_once "show_subs.php";

//Follow Button
include_once "follow.php";

?>
            </div>
    </div>
</div>

    <div class="col-md-8">
        <div class="place_content_inside content-profile" style="border-radius: .25rem;">
            <h1>Posts</h1>
            <br>
<?php

//Posts des jeweiligen Nutzers anzeigen
$sql = $pdo->prepare("SELECT * FROM posts WHERE userid= $profile_id ORDER BY date DESC");
if($sql->execute()) {
    while ($row = $sql->fetch()) {
        ?>
                <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic post" src="pictures/<?php echo $row2['profilepic'] ?>"></a><br>
                <strong><a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo $row2['username'] ?></a></strong><br>
                <small><?php echo $row['date']?></small><br><br>
                <h4><?php echo $row['headline']?></h4>
                <?php
                // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhält

                $nopic = "NULL";

                if ($row['filename'] !== $nopic)
                {
                    ?>
                    <img class="postpic" src="pictures/<?php echo $row['filename'] ?>">
                    <br>
                    <?php
                }
                echo nl2br ('<p>'.$row['content'].'</p>'.'<br>');

                    // Verweis auf Editseite
                    if ($profile_id==$myprofile_id) {
                        $post_id = $row['post_id'];
                        ?>
                        <br>
                        <div class="content-right">


                        <a href="post_edit.php?post_id=<?php echo $post_id ?>"> Edit </a><br>
                        <a href="delete_post.php?post_id=<?php echo $post_id ?>"> Delete </a><br>
                        </div>
                        <?php
                    }
                    ?>
                <div class="content-right"><a href="single_post.php?post_id=<?php echo $row["post_id"] ?>">Comment</a></div>
        <hr />




        <?php
    }}
    ?>
        </div>
    </div>
</div>

    <?php
include_once "footer.php";
?>

</body>