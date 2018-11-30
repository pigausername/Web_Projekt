<?php
include_once ("header.php");
?>
    <h1>Search by Username or Posts</h1>
    <form action="search.php" method="post">
        <table>
            <tr>
                <td>Username:  </td>
                <td><input type="text" name="search_username" placeholder=""></td>
            </tr>
            <tr>
                <td>Posts: </td>
                <td><input type="text" name="search_post" placeholder=""></td>
            </tr>
            <tr>
                <td><button type="submit" name="search">Search</button></td>
            </tr>
        </table>
    </form>


<?php
if (isset($_POST['search'])) {

    echo "<h2>Your results:</h2>";

    $username = $_POST['search_username'];

    $headline = $_POST['search_post'];

    //Nutzer suchen

    $searchuser = $pdo->prepare("SELECT * FROM userdata WHERE username='$username'");


    if ($searchuser->execute()) {
        while ($row = $searchuser->fetch()) {
            $userid = $row['userid'];
            ?>

            <h3><a href="profile.php?userid=<?php echo $row['userid'] ?>"><img src="pictures<?php echo $row['profilepic'] ?>"></a><?php echo $row['username'] ?></h3>
            <table>
                <tr>
                    <td>Username:</td><td><a href="profile.php?userid=<?php echo $userid?>"><?php echo $row['username']?></a></td>
                </tr>
                <tr>
                    <td>E-Mail:</td><td> <?php echo $row['email']?> </td>
                </tr>
                <tr>
                    <td>First Name:</td><td> <?php echo $row['firstname']?> </td>
                </tr>
                <tr>
                    <td>Last Name:</td><td> <?php echo $row['lastname']?> </td>
                </tr>
            </table>
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
                <hr />
            </table>
            <?php
        }
    } else {
        echo "No post found";
    }
}
include_once("footer.php");

?>