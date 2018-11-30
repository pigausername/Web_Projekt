<?php
include_once "header.php";
?>

<html>
<!-- Frage ob der Post wirklich gelöscht werden soll-->
    <form action="delete_post.php" method="post">
        <table>
            <tr>
                <td>Do you really want to delete this post?</td>
            </tr>
            <tr>
                <td><button type="submit" value="post" name="yes">Yes</button></td>
            </tr>
            <tr>
                <td><button type="submit" value="post" name="no">No</button></td>
            </tr>
        </table>
    </form>
</html>
<?php
// Post aus Datenbank löschen