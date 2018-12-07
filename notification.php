<?php
session_start();
?>


<script>
        $(document).ready(function(){

            function load_unseen_notification(view = '')
            {
                $.ajax({
                url:"fetch_notification.php",
                method:"POST",
                data:{view:view},
                dataType:"json",
                success:function(data)
                {
                    $('.dropdown-menu.notification').html(data.notification);
                    if(data.unseen_notification > 0)
                    {
                        $('.count').html(data.unseen_notification);
                    }
                }
            });
        }

            load_unseen_notification();



            $(document).on('click', '.dropdown-toggle', function(){
                $('.count').html('');
                load_unseen_notification('yes');
            });

            setInterval(function(){
                load_unseen_notification();;
            }, 5000);

                /*$('.clear').on( 'click', function(){


                        var pid = $(this).data('pid');

                        $.post( "delete_notification.php", { pid: pid })

                            .done(function( data ) {

                                if(data > 0){

                                    $('.success').show(3000).html("Record deleted successfully.").delay(3200).fadeOut(6000);

                                }else{

                                    $('.error').show(3000).html("Record could not be deleted. Please try again.").delay(3200).fadeOut(6000);;

                                }

                                setTimeout(function(){
                                    window.location.reload(1);
                                }, 5000);

                            });

                });*/



        }
        );
</script>
<?php
