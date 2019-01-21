<?php
include_once ("header.php");
?>

<head>
    <title>Search results</title>
</head>

<body>
<div id="place_content">
    <div class="place_content_inside">

        <?php
        if (isset($_POST['result'])){

            $username = $_POST['result'];
            $headline = $_POST['result'];

            //Nutzer suchen
            $searchuser = $pdo->prepare("SELECT * FROM userdata WHERE username='$username'");

            ?>
                <h2>Users</h2>
                <br>
            <?php

            // Durchsuche User Datenbank
            if ($searchuser->execute()) {
                while ($row = $searchuser->fetch()) {
                    $userid = $row['userid'];
                    ?>

                    <h3><a href="profile.php?userid=<?php echo $row['userid'] ?>"><?php echo $row['username'] ?></a></h3><br>
                    <a href="profile.php?userid=<?php echo $row['userid'] ?>"><img class="profilepic"
                                                                                   src="pictures/<?php echo $row['profilepic'] ?>"></a>
                    <br>
                    <br>
                    E-Mail: <?php echo $row['email'] ?> <br>
                    First name: <?php echo $row['firstname'] ?> <br>
                    Last name: <?php echo $row['lastname'] ?> <br>
                    Subject: <?php echo $row['subject'] ?> <br>
                    Semester: <?php echo $row['semester'] ?> <br>

                    <br>
                    <hr/>

                    <?php
                }
            }

            //Post-Datenbank durchsuchen
            $searchpost = $pdo->prepare("SELECT * FROM posts WHERE headline LIKE '%$headline%' ORDER BY date DESC");

            ?>
                <h2>Posts</h2>
                <br>

                <?php


                if ($searchpost->execute()) {

                while ($row2 = $searchpost->fetch()) {
                    $editor_id = $row2['userid'];

                    //Informationen des Verfassers
                    $display_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid= $editor_id");
                    $display_editor->execute();

                    $row3 = $display_editor->fetch();
                    ?>
                    <br>
                    <a href="profile.php?userid=<?php echo $row3['userid'] ?>"><img class="profilepic" src="pictures/<?php echo $row3['profilepic'] ?>"></a>
                    <br>
                    <strong><a href="profile.php?userid=<?php echo $row2['userid']?>"><?php echo $row3['username'] ?></a></strong>
                    <br>
                    <small><?php echo $row2['date']?></small>
                    <br>
                    <br>
                    <h4><?php echo $row2['headline'] ?></h4>

                        <?php

                    // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhält --> Unovllständig
                    $nopic = "NULL";

                    if ($row2['filename'] !== $nopic)
                    {
                        ?>
                        <img class="postpic" src="pictures/<?php echo $row2['filename'] ?>">
                        <br>
                        <?php
                    }

                        echo nl2br ('<p>'.$row2['content'].'</p>');
                        echo '<br>';
                        echo '<br>';
                        ?>
                    <div class="content-right"><a href="single_post.php?post_id=<?php echo $row2["post_id"] ?>">Comment</a></div>
                            <?php
                        echo '<hr />';
                        echo '<br>';

                }
            } else {
                echo "No post found";
            }
            ?>
    </div>
</div>
    <?php
}

include_once("footer.php");

?>
