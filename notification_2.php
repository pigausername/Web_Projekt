
<script>
$(document).ready(function(){
    setInterval(function() {
        $("#temperature").load("wintemp.php");
    }, 2000);
});

</script>