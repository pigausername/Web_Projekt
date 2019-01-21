<?php

include_once "header.php";
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HDM Community</title>
</head>

<body>
<div id="place_content" style="border-radius: .25rem;">
    <div class="place_content_inside" style="border-radius: .25rem; min-width: 100%">
        <h2>HDM-Community</h2>
        <hr><br>
<?php

    $searchuser = $pdo->prepare("SELECT * FROM userdata ORDER BY username");
    if ($searchuser->execute()) {
                while ($row = $searchuser->fetch()) {
                    $userid = $row['userid'];
                    ?>

                    <h3><a href="profile.php?userid=<?php echo $row['userid'] ?>"><?php echo $row['username'] ?></a></h3><br>
                    <a href="profile.php?userid=<?php echo $row['userid'] ?>"><img class="profilepic"
                                                                                   src="pictures/<?php echo $row['profilepic'] ?>"></a>
                    <br>
                    <br>
                    E-Mail: <?php echo $row['email'] ?> <br>
                    First name: <?php echo $row['firstname'] ?> <br>
                    Last name: <?php echo $row['lastname'] ?> <br>
                    Subject: <?php echo $row['subject'] ?> <br>
                    Semester: <?php echo $row['semester'] ?> <br>

                    <br>
                    <hr/>

                    <?php
                }
            }
?>
    </div>
</div>
<?php

include_once "footer.php";
?>