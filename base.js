$(document).ready(function(){
});

function getSearchResult(){
    alert("GOT");
    document.getElementById("status").innerHTML = "Loading...";
    
    $("#searchForm").submit(function(e) {
        $.ajax({
            type: 'POST',
            url: '/14110562d/searchYouTube.php',
            data: $('searchForm').serialize(),
            success: function (data, textStatus, jqXHR) {
                alert('Form was submitted');
                alert(data);
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
	$("#searchForm").submit();
    
}

function formatSearchResult(){

}