<form method="POST" id="comment_form">
        <div class="form-group">
            <textarea name="comment" id="comment" class="textareastyle" placeholder="Enter Comment" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id ?>" />
            <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
        </div>
    </form>
    <span id="comment_message"></span>
    <br />
    <div id="display_comment"></div>


<script>

    $(document).ready(function(){

        $('#comment_form').on('submit', function(event){
            event.preventDefault(); // Bedeutet in etwa Absicherung, was passieren würde, wenn der Code nicht funktioniert
            var form_data = $(this).serialize();
            $.ajax({
                url:"add_comment.php",
                method:"POST",
                data:form_data,
                dataType:"json",
                success:function(data)
                {
                    if(data.error !== '')
                    {
                        $('#comment_form')[0].reset();
                        $('#comment_message').html(data.error);
                        $('#comment_id').val('0');
                        load_comment();
                    }
                }
            });
        });

        load_comment();

        function load_comment()
        {
            $.ajax({
                url: "fetch_comment.php?post_id=<?php echo $post_id?>",
                method: "POST",
                success: function (data) {
                    $('#display_comment').html(data);
                }
            });
        }


    });
</script>

</body>
