<?php
include_once "header.php";

include_once "follow.php";

$profile_id = $_GET['userid'];




//Daten des jeweiligen Nutzers anzeigen
$display_user = $pdo->prepare("SELECT * FROM userdata WHERE userid= $profile_id");
    if($display_user->execute()) {
        while ($row2 = $display_user->fetch()) {
            ?>
            
            <title><?php echo $row2['username'] ?></title>
            <h3><?php $row2['username'] ?></h3>
            <table>
            <tr><td>Username:</td><td><?php echo $row2['username'] ?></td></tr>
            <tr><td><img src="pictures/<?php echo $row2['profilepic'] ?>"></td></tr>
            <tr><td>E-Mail:</td><td><?php echo $row2['email'] ?></td></tr>
            <tr><td>Firstname:</td><td><?php echo $row2['firstname'] ?></td></tr>
            <tr><td>Lastname:</td><td><?php echo $row2['lastname'] ?></td></tr>
            </table>
            <hr />
            <?php

        }
    } else {
        echo "No user found";
    }


//Posts des jeweiligen Nutzers anzeigen

    $headline= $_POST ["headline"];
    $file= $_POST ["file"];
    $content= $_POST["content"];


    $sql = $pdo->prepare("SELECT * FROM posts WHERE userid= $profile_id ORDER BY date DESC");
    if($sql->execute()) {
        while ($row = $sql->fetch()) {
            ?>
            <form>
                <table>
                    <tr>
                        <td><?php echo $row['headline'] ?></td>
                    </tr>
                    <tr>
                        <td><img src="pictures/<?php echo $row['filename'] ?>"></td>
                    <tr>

                        <td><?php echo $row['content'] ?></td>
                    </tr>
                    <tr>
                        <?php
                        // Verweis auf Editseite
                        $post_id = $row['post_id'];
                        echo
                            '<td><a href="post_edit.php?post_id=' . $post_id . ' "> Edit </a></td>'
                        ?>
                    </tr>
                </table>
            </form>
            <?php
        }}
include_once "footer.php";


?>
