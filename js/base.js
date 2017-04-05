$(document).ready(function(){
});

function getSearchResult(){
    alert("Got you!");
    alert($('searchForm').serialize());
    $("#searchForm").submit(function(e) {
        $.ajax({
            type: 'post',
            url: 'post.php',
            data: $('searchForm').serialize(),
            dataType : 'json',
            success: function () {
                alert('Form was submitted');
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
        });
	$("#searchForm").submit();
}

function formatSearchResult(){

}