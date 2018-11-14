<?php
include_once "header.php";


$profile_id = $_GET['userid'];

echo $profile_id;

//Daten des jeweiligen Nutzers anzeigen -> UNVOLLSTÄNDIG

$display_user = $pdo->prepare("SELECT * FROM userdata WHERE userid= $profile_id");
    if($display_user->execute()) {
        while ($row2 = $display_user->fetch()) {
            ?>
            <h3><?php $row2['username'] ?></h3>

            <?php
            echo '<table>';
            echo '<tr><td>Username:</td><td>' . $row2['username'] . '</td></tr>';
            //echo '<tr><td>Profile picture:</td><td><img src="'.$row["avatar"].'" width="100px" /></td></tr>';
            echo '<tr><td>E-Mail:</td><td>' . $row2['email'] . '</td></tr>';
            echo '<tr><td>Firstname:</td><td>' . $row2['firstname'] . '</td></tr>';
            echo '<tr><td>Lastname:</td><td>' . $row2['lastname'] . '</td></tr>';
            echo '</table>';
            echo '<hr />';
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
                <td><?php echo $row['file'] ?></td>
            <tr>
                <td><?php echo $row['content'] ?></td>
            </tr>
        </table>


</form>
<?php
}
}
include_once "footer.php";
?>

