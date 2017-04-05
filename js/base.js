$(document).ready(function(){
});

function submitForm(){
    alert("Got you!");
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: 'post.php',
        data: $('form').serialize(),
        success: function () {
            alert('form was submitted');
        }
    });
}