$(document).ready(function(){
});

function getSearchResult(){
    alert("GOT");
    document.getElementById("status").innerHTML = "Loading";
    $("#searchForm").submit(function(e) {
        $.ajax({
            type: 'post',
            url: 'searchYouTube.php',
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