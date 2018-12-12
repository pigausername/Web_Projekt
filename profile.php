<?php
include_once "header.php";
?>

<!doctype html>
    <html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>


    </head>
<body>
<div id="place_content">
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
        <h1><?php echo $row2['username'] ?></h1>
    <br>

        <img class="profilepic" src="pictures/<?php echo $row2['profilepic'] ?>">

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

//Posts des jeweiligen Nutzers anzeigen
$sql = $pdo->prepare("SELECT * FROM posts WHERE userid= $profile_id ORDER BY date DESC");
if($sql->execute()) {
    while ($row = $sql->fetch()) {
        ?>
        <form>

                <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img class="profilepic post" src="pictures/<?php echo $row2['profilepic'] ?>"></a>
                <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo $row2['username'] ?></a><br>
                <small><?php echo $row['date']?></small><br>
                <strong><a href="single_post.php?post_id=<?php echo $row["post_id"] ?>"><?php echo $row['headline']?></a></strong><br>
                <?php
                // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhält

                $checkpic = $pdo->prepare("SELECT filename FROM posts WHERE userid= $myprofile_id");
                $checkpic->execute();

                $no = $checkpic->rowCount();
                if ($no > 0) {
                    ?>
                    <img class="postpic" src="pictures/<?php echo $row['filename'] ?>">
                    <br>
                    <?php
                }
                ?>
                <?php echo $row['content'] ?><br>
                <?php
                    // Verweis auf Editseite
                    if ($profile_id==$myprofile_id) {

                        $post_id = $row['post_id'];
                        echo '<td><a href="post_edit.php?post_id=' . $post_id . ' "> Edit </a><br>';
                        echo '<td><a href="delete_post.php?post_id='. $post_id.'"> Delete </a><br>';
                    }
                    ?>
                <a href="single_post.php?post_id=<?php echo $row["post_id"] ?>">Comment</a>

        </form>

</div>
</div>
        <?php
    }}
include_once "footer.php";



?>
</body>