<?php
include_once "header.php";

include_once "follow.php";

$myprofile_id = $_SESSION["angemeldet"];
$profile_id = $_GET['userid'];
//Daten des jeweiligen Nutzers anzeigen
$display_user = $pdo->prepare("SELECT * FROM userdata WHERE userid= $profile_id");
if($display_user->execute()) {
    while ($row2 = $display_user->fetch()) {
        ?>
<div class="content">
        <title><?php echo $row2['username'] ?></title>
        <h1><?php echo $row2['username'] ?></h1>
        <table>
            <tr><td><img src="pictures/<?php echo $row2['profilepic'] ?>"></td></tr>
            <tr><td>Username:</td><td><?php echo $row2['username'] ?></td></tr>
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
                    if ($profile_id==$_SESSION["angemeldet"]) {

                        $post_id = $row['post_id'];
                        echo '<td><a href="post_edit.php?post_id=' . $post_id . ' "> Edit </a></td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td><a href="single_post.php?post_id=<?php echo $row["post_id"] ?>">Comment</a></td>
                </tr>
                <tr>
                    <td><a href="delete_post.php?post_id=<?php echo $row["post_id"] ?>">Delete</a></td>
                </tr>
                <br>
            </table>
        </form>
</div>
        <?php
    }}
include_once "footer.php";



?>
