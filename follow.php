<?php
include_once "header.php";

$profile_id=$_GET['userid'];
$followerid=$_SESSION["angemeldet"];

// Check ob es ein fremdes Profil ist
if ($profile_id!=$_SESSION["angemeldet"]) {

    // check ob wir dem Nutzer schon folgen
    $checkfollow=$pdo->prepare("SELECT followerid FROM followers WHERE userid=$profile_id");
    $checkfollow->execute();
    $no=$checkfollow->rowCount();
    if(!$no > 0){
        ?>
        <form action="profile.php?userid=<?php echo $profile_id; ?>" method="post">
            <input type="submit" name="follow" value="Follow">
        </form>
        <?php
        if (isset($_POST['follow'])) {
            $follow = $pdo->prepare("INSERT INTO followers (`userid`, `followerid`) VALUES ('$profile_id', '$followerid') ");
            if ($follow->execute()) {
                echo "blabla";
            }
        }
    }
    else {
        ?>
        <!-- Folgen schon gegenseitig unfollow -->
        <form action="profile.php?userid=<?php echo $profile_id; ?>" method="post">
            <input type="submit" name="unfollow" value="Unfollow">
        </form>

        <?php
        }
}
?>