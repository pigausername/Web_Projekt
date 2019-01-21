<?php

include_once "header.php";

$post_id = $_GET['post_id'];
$myprofile_id = $_SESSION["angemeldet"];
?>


<html>
<div id="place_content" style="border-radius: .25rem;">
    <div class="place_content_inside" style="border-radius: .25rem;">

        <!-- Headline -->
        <h4>Do you really want to delete your post?</h4>
        <br>


        <div class="row">
            <div class="col-md-2"></div>

            <div class="post_formular col-md-9">

    <!-- Formular das fragt ob der Post wirklich gelöscht werden soll-->
    <form action="delete_post.php?post_id=<?php echo $post_id ?>" method="post">

                <button class="btn btn-info" type="submit" value="post" name="yes">Yes</button>

                <button class="btn btn-info" type="submit" value="post" name="no">No</button>
    </form>
            </div>
        </div>
        </div>
</div>


</html>
<?php

// Post aus Datenbank löschen

if (isset($_POST['yes'])){

    $post_id = $_GET['post_id'];

    $delete_post = $pdo->prepare("DELETE FROM posts WHERE post_id=$post_id");
    $delete_post->execute();

        echo '<script>window.location.href="profile.php?userid='.$myprofile_id.'"</script>';


}

// Post nicht löschen

if (isset($_POST['no'])){

    $post_id = $_GET['post_id'];

    echo '<script>window.location.href="single_post.php?post_id='.$post_id.'"</script>';

}

include_once "footer.php";
?>