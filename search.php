<?php
include_once ("header.php");
?>
<div id="place_content">
    <div class="place_content_inside">

    <h1>Search results:</h1>


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
            <table>
                <tr>
                    <td>E-Mail:</td><td> <?php echo $row['email']?> </td>
                </tr>
                <tr>
                    <td>First Name:</td><td> <?php echo $row['firstname']?> </td>
                </tr>
                <tr>
                    <td>Last Name:</td><td> <?php echo $row['lastname']?> </td>
                </tr>
                <tr>
                    <td>Subject:</td><td> <?php echo $row['subject']?> </td>
                </tr>
                <tr>
                    <td>Semester:</td><td> <?php echo $row['semester']?> </td>
                </tr>
            </table>
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
            <h3>'<?php echo $row2['headline']?>' by <a href="profile.php?userid=<?php echo $row2['userid']?>"><?php echo $row3['username'] ?></a></h3>

            <a href="profile.php?userid=<?php echo $row3['userid'] ?>"><img src="pictures<?php echo $row3['profilepic'] ?>"></a>
            <table>
                <tr>
                    <td>

                        <?php
                        // Hierbei wird überprüft, ob der jeweilige Post ein Bild beinhält --> Unovllständig

                        $checkpic=$pdo->prepare("SELECT filename FROM posts WHERE userid= $feedid OR userid= $myid");
                        $checkpic->execute();

                        $no=$checkpic->rowCount();
                        if($no > 0){
                        ?>
                        <img src="pictures <?php echo $row2['filename'] ?>"></td>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td>Content:</td><td><?php echo $row2['content']?></td>
                </tr>
                <tr>
                    <td>Date:</td><td><?php echo $row2['date']?></td>
                </tr>
                <tr>
                    <td><a href="single_post.php?post_id=<?php echo $row2["post_id"] ?>">Comment</a></td>
                </tr>
            </table>
            <hr />
            <?php
        }
    } else {
        echo "No post found";
    }
}

include_once("footer.php");

?>
</div>
</div>
