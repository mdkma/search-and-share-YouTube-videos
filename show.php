<?php
    session_start();
	$username = '';
	$pic = '';
	$accessToken = '';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/14110562d/Facebook/src/Facebook/autoload.php';

    $fb = new Facebook\Facebook([
        'app_id' => '1325805574163170',
        'app_secret' => '8d5e92b961c2eb0c04454242f56ac2c3',
        'default_graph_version' => 'v2.5'
    ]);

    $helper = $fb->getRedirectLoginHelper();
    try {
        $accessToken = $helper->getAccessToken();
		echo $accessToken;
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage() . '<br>';
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage() . '<br>';
    }
    
    if (isset($accessToken)) {
        $fb->setDefaultAccessToken($accessToken);
        $response = $fb -> get('/me?fields=id,name,picture.width(200)');
        $user = $response -> getGraphUser();
		$username = $user -> getName();
		$temp = $user['picture'];
		$pic = $temp['url'];
    } else {
        echo 'Failed to retrieve accessToken';
    }

	if (isset($_GET['post'])) {
		post();
	}
	function post(){
		if (isset($accessToken)) {
			$fb->setDefaultAccessToken($accessToken);
			try {
				// Specify the contents to post on facebook
				$data = [
					'link' => 'https://www.comp.polyu.edu.hk/',
					'message' => 'Have a look at this amazing video!',
				];

				// Calling the post method to send data to Facebook's feed
				$response = $fb->post('/me/feed', $data);
				$post = $response -> getGraphNode();
				header('Location: https://www.facebook.com/profile.php');
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				echo 'Graph returned an error: ' . $e->getMessage() . '<br>';
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				echo 'Facebook SDK returned an error: ' . $e->getMessage() . '<br>';
			}
		} else {
			$permissions = ['publish_actions'];
			$callback = 'http://localhost/14110562d/';
			$loginUrl = $helper->getLoginUrl($callback, $permissions);
			echo '<a href="' . $loginUrl . '">Log in with Facebook</a>';
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
	<link rel="stylesheet" media="screen" href="css/base.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<meta charset="UTF-8">
	<link rel="import" href="bower_components/paper-radio-button/paper-radio-button.html">
	<link rel="import" href="bower_components/paper-radio-group/paper-radio-group.html">
	<link rel="import" href="bower_components/iron-form/iron-form.html">
	<link rel="import" href="bower_components/iron-icons/social-icons.html">
	<link rel="import" href="bower_components/iron-icons/iron-icons.html">
	<link rel="import" href="bower_components/paper-input/paper-input.html">
	<!--
	<link rel="import" href="bower_components/paper-dropdown-menu/paper-dropdown-menu.html">
	<link rel="import" href="bower_components/paper-item/paper-item.html">
	<link rel="import" href="bower_components/paper-listbox/paper-listbox.html">
	-->
	<link rel="import" href="bower_components/paper-button/paper-button.html">
	<link rel="import" href="bower_components/iron-flex-layout/iron-flex-layout.html">
	<link rel="import" href="bower_components/paper-card/paper-card.html">
	<link rel="import" href="bower_components/iron-form-element-behavior/iron-form-element-behavior.html">
	<title>Search and Share YouTube Videos</title>
</head>

<body class="container bg-faded bg-frame">
<div class="row justify-content-center">
	<img src=<?php echo $pic; ?> alt="..." class="profile-img mt-3 mb-3"/>
</div>
<p class="h1 mt-3 text-center">Welcome, <?php echo $username; ?> </p>

<form is="iron-form" id="searchForm" method="get" action="/14110562d/searchYouTube.php">
    <div class="row justify-content-between align-items-center">
        <paper-input name="q" label="What kind of videos you are interested in?" class="col-6 mb-3" required>
            <iron-icon icon="icons:search" class="mr-2" prefix></iron-icon>
        </paper-input>
		<label id="label1" class="mt-2">Sort by:</label>
		<paper-radio-group name="sort-method" id="sort-method" aria-labelledby="label1" selected="likeCount" class="col4">
			<paper-radio-button name="likeCount">Like Count</paper-radio-button>
			<paper-radio-button name="hotScore">Hot Score</paper-radio-button>
		</paper-radio-group>
		<!--
        <paper-dropdown-menu name="method" id="sort-method" label="Sort by" attr-for-selected="value" selected="{{methodtemp}}" class="col-3" required>
            <paper-listbox class="dropdown-content">
                <paper-item value="likeCount">Decreasing like count</paper-item>
                <paper-item value="hotScore">Hot content score</paper-item>
            </paper-listbox>
        </paper-dropdown-menu>
		<input type="hidden" name="sort-method-real" value="{{methodtemp}}">
		-->
        <paper-button raised id="submitButton" onclick="getSearchResult()" class="col-2 custom indigo">
            Search
        </paper-button>
    </div>
</form>
<div id="status"></div>
<div id="search-result">
</div

<div class="footer mb-3 mt-3">
	<span>&copy; <a href="http://derek.ma">Derek Mingyu MA</a>. An assignment for PolyU COMP COMP3121. <a href="https://github.com/derekmma/search-and-share-YouTube-videos">Use my code</a>.</span>
</div>

<script type="text/javascript">
	var at = "<?php echo $accessToken ?>";
	function postToFacebook(id){
		alert('wow1');
		alert(at);
		alert(id);
		var base = 'https://youtu.be/';
		var linktext = base.concat(id);
		$.ajax({
			type: 'POST',
			url: '/14110562d/post.php',
			data: { 
				'accessToken': at,
				'link': linktext
			},
			success: function(data){
				alert('wow2');
				alert(data);
			}
		});
}
</script>
	
<style is="custom-style">
	  paper-button.custom {
	    --paper-button-ink-color: var(--paper-pink-a200);
	    /* These could also be individually defined for each of the
	      specific css classes, but we'll just do it once as an example */
	    --paper-button-flat-keyboard-focus: {
	      background-color: var(--paper-pink-a200);
	      color: white !important;
	    };
	    --paper-button-raised-keyboard-focus: {
	      background-color: var(--paper-pink-a200) !important;
	      color: white !important;
	    };
	  }
	  paper-button.custom:hover {
	    background-color: var(--paper-indigo-100);
	  }
	  paper-button.pink {
	    color: var(--paper-indigo-500);
	  }
	  paper-button.indigo {
	    background-color: var(--paper-indigo-500);
	    color: white;
	    --paper-button-raised-keyboard-focus: {
	      background-color: var(--paper-pink-a200) !important;
	      color: white !important;
	    };
	  }

	paper-card.record { @apply(--layout-horizontal); }
	.record-iframe {
		width: 400px;
		background: black;
		background-size: cover;
	}
	.record-content {
		@apply(--layout-flex);
		float: left;
	}
	.rate-header { @apply(--paper-font-headline); }
	.rate-name { color: var(--paper-grey-600); margin: 10px 0; }
	paper-icon-button.rate-icon {
		--iron-icon-fill-color: white;
		--iron-icon-stroke-color: var(--paper-grey-600);
	}
	  
	paper-card {
	  	max-width: 100%;
	}
	paper-card:hover {
      	@apply(--shadow-elevation-16dp);
    }
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<script src="base.js" type="text/javascript" chatset="utf-8"></script>
	<script>
		//document.getElementByClassName('record-iframe').style.height=document.getElementByClassName('record').style.height;
    	// To ensure that elements are ready on polyfilled browsers, 
    	// wait for WebComponentsReady. 
    	document.addEventListener('WebComponentsReady', function() {
        	var input = document.querySelector('paper-input');
        	var button = document.querySelector('paper-button');
        	var button = document.querySelector('iron-form');
        	var greeting = document.getElementById("greeting");
        	button.addEventListener('click', function() {
          		greeting.textContent = 'Hello, ' + input.value;
        	});
      	});
    });
}
	</script>
	
</body>
</html>
