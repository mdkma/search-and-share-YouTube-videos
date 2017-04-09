$(document).ready(function(){
});

function getSearchResult(){
    alert("GOT");
    document.getElementById("status").innerHTML = "Loading...";
    
    $("#searchForm").submit(function(e) {
        $.ajax({
            type: 'GET',
            url: '/14110562d/searchYouTube.php',
            data: $('#searchForm').serialize(),
            success: function (data, textStatus, jqXHR) {
                var jsonData = JSON.parse(data);
                //alert(jsonData[2]);
                document.getElementById("status").innerHTML = jsonData[2];
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
	$("#searchForm").submit();
    
}

function formatSearchResult(){

}