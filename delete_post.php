<?php

include_once "header.php";

$post_id = $_GET['post_id'];
$myprofile_id = $_SESSION["angemeldet"];
?>


<html>
<div class="content">
<!-- Frage ob der Post wirklich gelöscht werden soll-->
    <form action="delete_post.php?post_id=<?php echo $post_id ?>" method="post">
        <table>
            <tr>
                <td>Do you really want to delete this post?</td>
            </tr>
            <tr>
                <td><button type="submit" name="yes">Yes</button></td>
            </tr>
            <tr>
                <td><button type="submit" name="no">No</button></td>
            </tr>
        </table>
    </form>
</div>
</html>
<?php

// Post aus Datenbank löschen

if (isset($_POST['yes'])){

    $post_id = $_GET['post_id'];

    $delete_post = $pdo->prepare("DELETE FROM posts WHERE post_id=$post_id");
    $delete_post->execute();

        echo '<script>window.location.href="profile.php?user_id='.$myprofile_id.'"</script>';


}

// Post nicht löschen

if (isset($_POST['no'])){

    $post_id = $_GET['post_id'];

    echo '<script>window.location.href="single_post.php?post_id='.$post_id.'"</script>';

}