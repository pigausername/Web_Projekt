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

        $searchuser = $pdo->prepare("SELECT * FROM userdata WHERE username='$username'");


        if ($searchuser->execute()) {
            while ($row = $searchuser->fetch()) {
                ?>

                <h3><?php echo $row['username'] ?></h3>

                <?php
                $userid = $row['userid'];

                echo '<table>';
                echo '<tr><td>Username:</td><td><a href="profile.php?userid='.$userid.'">' . $row['username'] . '</td></tr>';
                //echo '<tr><td>Profile picture:</td><td><img src="'.$row["avatar"].'" width="100px" /></td></tr>';
                echo '<tr><td>E-Mail:</td><td>' . $row['email'] . '</td></tr>';
                echo '<tr><td>Firstname:</td><td>' . $row['firstname'] . '</td></tr>';
                echo '<tr><td>Lastname:</td><td>' . $row['lastname'] . '</td></tr>';
                echo '</table>';
                echo '<hr />';
            }
        } else {
            echo "No user found";
        }

        $searchpost = $pdo->prepare("SELECT * FROM posts WHERE headline='$headline'");



        //$searcheditor = $pdo->prepare("SELECT username FROM userdata WHERE userid=");



        if ($searchpost->execute() //AND $searcheditor->execute()
        ) {
            while ($row = $searchpost->fetch() //AND ($row2 = $searcheditor->fetch())
                ) {
                ?>

                <h3><?php echo"'".$row['headline']."'"." by ". $row['userid'] ?></h3>

                <?php
                echo '<table>';
                echo '<tr><td>Headline:</td><td>' . $row['headline'] . '</td></tr>';
                //echo '<tr><td>File:</td><td><img src="'.$row["avatar"].'" width="100px" /></td></tr>';
                //echo '<tr><td>By:</td><td>' . $row2['username'] . '</td></tr>';
                echo '<tr><td>Content:</td><td>' . $row['content'] . '</td></tr>';
                echo '<tr><td>Date:</td><td>' . $row['date'] . '</td></tr>';
                echo '</table>';
                echo '<hr />';
            }
        } else {
            echo "No post found";
        }
    }
include_once("footer.php");

?>