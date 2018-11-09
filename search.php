<?php
session_start();
include_once ("header.php");
?>
<h1>Search by Username</h1>
<form action="search.php" method="post">
    Username:  <input type="text" name="searching" placeholder="">
    <button type="submit" name="search">Search</button>
</form>

<?php
    if (isset($_POST['search'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $statement = $pdo->prepare("SELECT * FROM userdata WHERE username=:username");
        if ($pdo->exec($statement)) {
            while ($row = $statement->fetch()) {
                ?>

                <h3>Your results:</h3>

                <?php
                echo '<table>';
                echo '<tr><td>ID:</td><td>' . $row["id"] . '</td></tr>';
                echo '<tr><td>Username:</td><td>' . $row['username'] . '</td></tr>';
                //echo '<tr><td>Profile picture:</td><td><img src="'.$row["avatar"].'" width="100px" /></td></tr>';
                echo '<tr><td>E-Mail:</td><td>' . $row['email'] . '</td></tr>';
                echo '<tr><td>Firstname:</td><td>' . $row['firstname'] . '</td></tr>';
                echo '<tr><td>Lastname:</td><td>' . $row['lastname'] . '</td></tr>';
                echo '</table>';
                echo '<hr />';
                echo "bla";
            }
        } else {
            echo "0 results";
        }
    }
include_once("footer.php");

?>