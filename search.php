<?php
include_once ("header.php");
?>

<head>
    <title>Search results</title>
</head>

<body>
<div id="place_content">
    <div class="place_content_inside">

    <h1>Search results:</h1>
    <hr />
<?php

if (isset($_POST['result'])){
    $username = $_POST['result'];

    $headline = $_POST['result'];
    //Nutzer suchen

    $searchuser = $pdo->prepare("SELECT * FROM userdata WHERE username='$username'");


    if ($searchuser->execute()) {
        while ($row = $searchuser->fetch()) {
            $userid = $row['userid'];
            ?>



            <h3><a href="profile.php?userid=<?php echo $row['userid'] ?>"><img class="profilepic" src="pictures/<?php echo $row['profilepic'] ?>"></a>
                <a href="profile.php?userid=<?php echo $row['userid'] ?>"><?php echo $row['username'] ?></a></h3>

                <?php echo $row['email']?><br>
                <?php echo $row['firstname']?><br>
                <?php echo $row['lastname']?><br>
                <?php echo $row['subject']?><br>
                <?php echo $row['semester']?><br>

            <br>
            <hr />

            <?php
        }
    } else {
        echo "No user found";
    }

    //Post suchen

    $searchpost = $pdo->prepare("SELECT * FROM posts WHERE headline='$headline'");

    if ($searchpost->execute()) {

        while ($row2 = $searchpost->fetch()) {
            $editor_id = $row2['userid'];

            //Informationen des Verfassers

            $display_editor = $pdo->prepare("SELECT * FROM userdata WHERE userid= $editor_id");
            $display_editor->execute();

            $row3 = $display_editor->fetch();
            ?>

            <h3><a href="profile.php?userid=<?php echo $row3['userid'] ?>"><img class="profilepic" src="pictures/<?php echo $row3['profilepic'] ?>"></a>
                <a href="profile.php?userid=<?php echo $row2['userid']?>"><?php echo $row3['username'] ?></a></h3>

            <?php
                        // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhält --> Unovllständig

                        $checkpic=$pdo->prepare("SELECT filename FROM posts WHERE userid= $feedid OR userid= $myid");
                        $checkpic->execute();

                        $no=$checkpic->rowCount();
                        if($no > 0){
                        ?>
                        <img src="pictures <?php echo $row2['filename'] ?>">
                        <br>
                    <?php
                    }
                echo $row2['date'];
                echo '<br>';
                ?>
                <strong><a href="single_post.php?post_id=<?php echo $row2["post_id"] ?>"><?php echo $row2['headline'] ?></a></strong><br>
                <?php

            // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhält --> Unovllständig

            $picpost_id = $row2["post_id"];
            $checkpic = $pdo->prepare("SELECT filename FROM posts WHERE post_id= $picpost_id");
            $checkpic->execute();
            $a = $checkpic->fetch();

            $no = $checkpic->columnCount();
            if ($no > 0) {
                ?>
                <img class="postpic" src="pictures/<?php echo $row2['filename'] ?>">
                <br>
                <?php
            }

                echo $row2['content'];
                echo '<br>';
                ?><a href="single_post.php?post_id=<?php echo $row2["post_id"] ?>">Comment</a>
                    <?php
                echo '<br>';
                echo '<hr />';
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
