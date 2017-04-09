$(document).ready(function(){
});
function sortBy(prop){
   return function(a,b){
      if( a.viewCount > b.viewCount){
          return 1;
      }else if( a.viewCount < b.viewCount ){
          return -1;
      }
      return 0;
   }
}

function sortByViewCount(x,y) {
    return y.viewCount - x.viewCount; 
}

function sortByLikeCount(x,y) {
    return y.likeCount - x.likeCount; 
}

function getSearchResult(){
    document.getElementById("status").innerHTML = "Loading...";
    var sortMethod = document.querySelector('#sort-method').selected;
    $("#searchForm").submit(function(e) {
        $.ajax({
            type: 'GET',
            url: '/14110562d/searchYouTube.php',
            data: $('#searchForm').serialize(),
            success: function (data, textStatus, jqXHR) {
                var jsonData = JSON.parse(data);
                var newJsonData= new Array();
                for (i=0; i<jsonData.length;i++){
                    var jsonData1 = JSON.parse(jsonData[i]);
                    newJsonData.push(jsonData1);
                }
                if(sortMethod=='likeCount'){
                    newJsonData.sort(sortByLikeCount);
                }else if(sortMethod =="hotScore"){
                    newJsonData.sort(sortByViewCount);
                }
                document.getElementById("status").innerHTML = "";
                formatSearchResult(newJsonData);
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
	$("#searchForm").submit();
    
}

function formatSearchResult(jsonData){
    newHTML = "";
    var countNum = 0;
    for (i=0; i < jsonData.length; i++) {
        //var jsonData1 = JSON.parse(jsonData[i]);
        var jsonData1 = jsonData[i]
        if (jsonData1.viewCount == null && countNum < 20){
            jsonData1.viewCount = "Hidden by video owner";
            jsonData1.likeCount = "Hidden by video owner";
            jsonData1.dislikeCount = "Hidden by video owner";
            jsonData1.commentCount = "Hidden by video owner";
        }
        newHTML += "<paper-card animated-shadow class='record mt-3 md-3'>"
                        +"<div class='record-iframe'></div>"
                    +"<div class='record-content'>"
                        +"<div class='card-content'>"
                            +"<div class='rate-header'>"+jsonData1.title+"</div>"
                            +"<div class='rate-name'>"+jsonData1.id+"</div>"
                            +"<div>Channel Title: "+jsonData1.channelTitle+"</div>"
                            +"<div>View Count: "+jsonData1.viewCount+"</div>"
                            +"<div>Like Count: "+jsonData1.likeCount+"</div>"
                            +"<div>Dislike Count: "+jsonData1.dislikeCount+"</div>"
                            +"<div>Comment Count: "+jsonData1.commentCount+"</div>"
                            +"<div>Publish Time: "+jsonData1.pubslishAt+"</div>"
                        +"</div>"
                    +"<div class='card-actions'>"
                        +"<paper-button>"
                            +"<iron-icon icon='social:share' class='mr-2'></iron-icon>"
                            +"Share to Facebook"
                        +"</paper-button>"
                    +"</div>"
                +"</div>"
                +"</paper-card>";
        countNum = countNum + 1;
    }

    /*<paper-card animated-shadow class="record">
		<div class="record-iframe"></div>
	<div class="record-content">
		<div class="card-content">
			<div class="rate-header">Rate this album</div>
			<div class="rate-name">Mac Miller</div>
			<div>Live from space</div>
		</div>
		<div class="card-actions">
			<paper-button>
				<iron-icon icon="social:share" class="mr-2"></iron-icon>
				Share to Facebook
			</paper-button>
		</div>
	</div>
	</paper-card>
    */
    document.getElementById("search-result").innerHTML = newHTML;
}