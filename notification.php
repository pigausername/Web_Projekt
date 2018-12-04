<?php
session_start();

include_once "userdata.php";
$profile_id=$_GET['userid'];
$followerid=$_SESSION["angemeldet"];



// Check ob es ein fremdes Profil ist
if ($profile_id!=$_SESSION["angemeldet"]) {

    // check ob wir dem Nutzer schon folgen
    $checkfollow=$pdo->prepare("SELECT followerid FROM followers WHERE userid=$profile_id");
    $checkfollow->execute();

    $no=$checkfollow->rowCount();
    if(!$no > 0){

// check ob ein User etwas gepostet hat
$checkpost=$pdo->prepare("SELECT post_id FROM posts WHERE userid=$followerid");
$checkpost->execute();


?>


<script>
        $(document).ready(function(){

            function load_unseen_notification(view = '')
            {
                $.ajax({
                url:"notification.php",
                method:"POST",
                data:{view:view},
                dataType:"json",
                success:function(data)
                {
                    $('.dropdown-menu').html(data.notification);
                    if(data.unseen_notification > 0)
                    {
                        $('.count').html(data.unseen_notification);
                    }
                }
            });
        }

            load_unseen_notification();

            $('#comment_form').on('submit', function(event){
                event.preventDefault();
                if($('#subject').val() != '' && $('#comment').val() != '')
                {
                    var form_data = $(this).serialize();
                    $.ajax({
                    url:"insert.php",
                    method:"POST",
                    data:form_data,
                    success:function(data)
                    {
                        $('#comment_form')[0].reset();
                        load_unseen_notification();
                    }
                });
            }
                else
                {
                    alert("Both Fields are Required");
                }
            });

            $(document).on('click', '.dropdown-toggle', function(){
                $('.count').html('');
                load_unseen_notification('yes');
            });

            setInterval(function(){
                load_unseen_notification();;
            }, 5000);

        });
        </script>
