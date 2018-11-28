$(document).ready(function(){
    $('#commentForm').onclick('submit', function(event){
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "add_comment.php",
            method: "POST",
            data: formData,
            dataType: "JSON",
            success:function(response) {
                if(!response.error) {
                    $('#commentForm')[0].reset();
                    $('#commentId').val('0');
                    $('#message').html(response.message);
                    showComments();
                } else if(response.error){
                    $('#message').html(response.message);
                }
            }
        })
    });
});

function showComments() {
    $.ajax({
        url:"fetch_comment.php",
        method:"POST",
        success:function(response) {
            $('#showComments').html(response);
        }
    })
}