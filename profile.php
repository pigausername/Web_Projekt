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
<div class="place_content">
<?php
$myprofile_id = $_SESSION["angemeldet"];
$profile_id = $_GET['userid'];
//Daten des jeweiligen Nutzers anzeigen
$display_user = $pdo->prepare("SELECT * FROM userdata WHERE userid= $profile_id");
if($display_user->execute()) {
    $row2 = $display_user->fetch();
        ?>
<div class="content">
        <title><?php echo $row2['username'] ?></title>
        <h1><?php echo $row2['username'] ?></h1>
    <br>
    <img src="pictures/<?php echo $row2['profilepic'] ?>"> <br>
            E-Mail: <?php echo $row2['email'] ?> <br>
            First name: <?php echo $row2['firstname'] ?> <br>
            Last name: <?php echo $row2['lastname'] ?> <br>
            Subject: <?php echo $row2['subject'] ?> <br>
            Semester: <?php echo $row2['semester'] ?> <br>

        <hr />
        <?php


} else {
    echo "No user found";
}

        include_once "follow.php";

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
                    <td>
                        <strong>
                            <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><img src="pictures/<?php echo $row2['profilepic'] ?>"></a>
                            <a href="profile.php?userid=<?php echo $row2['userid'] ?>"><?php echo " " . $row2['username'] ?></a>
                        </strong>
                    </td>
                </tr>

                <tr>
                    <td><small><?php echo $row['date']?></small></td>
                </tr>

                <tr>
                    <td><strong><a href="single_post.php?post_id=<?php echo $row["post_id"] ?>"><?php echo $row['headline']?></a></strong></td>
                </tr>

                <tr>
                    <td><?php echo $row['content'] ?></td>
                </tr>

                <tr>
                    <?php
                    // Verweis auf Editseite
                    if ($profile_id==$myprofile_id) {

                        $post_id = $row['post_id'];
                        echo '<td><a href="post_edit.php?post_id=' . $post_id . ' "> Edit </a></td>';
                        echo '<td><a href="delete_post.php?post_id='. $post_id.'"> Delete </a></td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td><a href="single_post.php?post_id=<?php echo $row["post_id"] ?>">Comment</a></td>
                </tr>
                <br>
            </table>
        </form>
</div>
</div>
        <?php
    }}
include_once "footer.php";



?>
</body>