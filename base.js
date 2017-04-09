$(document).ready(function(){
});

function getEpoch(dt){
    var parts = dt.match(/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})/);
    return (Date.UTC(+parts[1], parts[2]-1, +parts[3], +parts[4], +parts[5], +parts[6]))/1000;
}

function calculateHotScore(jsonData){
    var newJsonData= new Array();
    for (i=0; i < jsonData.length; i++) {
        var jsonData1 = jsonData[i];
        var ts = getEpoch(jsonData1.publishedAt) - getEpoch("2000-01-01T00:00:00");
        var x = jsonData1.likeCount - jsonData1.dislikeCount;
        if (x > 1){
            var sign = 1;
        }else if (x < 1){
            var sign = -1;
        }else{
            var sign= 0;
        }
        if (Math.abs(x) >= 1){
            var r = Math.abs(x);
        }else {
            var r = 1;
        }
        jsonData1.hotScore = (sign*Math.log10(r) + (ts/10000000)).toFixed(4);
        newJsonData.push(jsonData1);
    }
    return newJsonData;
}

function sortByViewCount(x,y) {
    return y.viewCount - x.viewCount;
}

function sortByLikeCount(x,y) {
    return y.likeCount - x.likeCount;
}

function sortByHotScore(x,y) {
    return y.hotScore - x.hotScore;
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
                    newJsonData = calculateHotScore(newJsonData);
                    newJsonData.sort(sortByHotScore);
                }
                document.getElementById("status").innerHTML = "";
                formatSearchResult(newJsonData,sortMethod);
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
	$("#searchForm").submit();
    
}

function formatSearchResult(jsonData, sortMethod){
    newHTML = "";
    var countNum = 0;
    for (i=0; i < jsonData.length; i++) {
        //var jsonData1 = JSON.parse(jsonData[i]);
        var jsonData1 = jsonData[i];
        if (jsonData1.viewCount == null && countNum < 20){
            jsonData1.viewCount = "Hidden by video owner";
            jsonData1.likeCount = "Hidden by video owner";
            jsonData1.dislikeCount = "Hidden by video owner";
            jsonData1.commentCount = "Hidden by video owner";
        }
        newHTML += "<paper-card animated-shadow class='record mt-3 md-3'>"
                        +"<div class='record-iframe'>"
                            +"<iframe width='400' height='300' src='https://www.youtube.com/embed/"+jsonData1.id+"' frameborder='0' allowfullscreen></iframe>"
                        +"</div>"
                    +"<div class='record-content'>"
                        +"<div class='card-content'>"
                            +"<div class='rate-header'>"+jsonData1.title+"</div>";
        if(sortMethod=='likeCount'){
            newHTML += "<div class='rate-name'>Like Count: "+jsonData1.likeCount+"</div>";
        }else if(sortMethod =="hotScore"){
            newHTML += "<div class='rate-name'>Hot Score: "+jsonData1.hotScore+"</div>";
        }
                            newHTML += 
                            "<div>Channel Title: "+jsonData1.channelTitle+"</div>"
                            +"<div>View Count: "+jsonData1.viewCount+"</div>"
                            +"<div>Like Count: "+jsonData1.likeCount+"</div>"
                            +"<div>Dislike Count: "+jsonData1.dislikeCount+"</div>"
                            +"<div>Comment Count: "+jsonData1.commentCount+"</div>"
                            +"<div>Publish Time: "+jsonData1.publishedAt.substr(0,10)+"</div>"
                        +"</div>"
                    +"<div class='card-actions'>"
                        +'<paper-button onclick="postToFacebook(\''+jsonData1.id+'\')">'
                            +"<iron-icon icon='social:share' class='mr-2'></iron-icon>"
                            +"Share to Facebook"
                        +"</paper-button>"
                    +"</div>"
                +"</div>"
                +"</paper-card>";
        newHTML += "";
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