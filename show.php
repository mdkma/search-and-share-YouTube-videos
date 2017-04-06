<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/COMP3121/Facebook/src/Facebook/autoload.php';

    $fb = new Facebook\Facebook([
        'app_id' => '1325805574163170',
        'app_secret' => '8d5e92b961c2eb0c04454242f56ac2c3',
        'default_graph_version' => 'v2.5'
    ]);

    $helper = $fb->getRedirectLoginHelper();
    try {
        $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage() . '<br>';
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage() . '<br>';
    }
    
    if (isset($accessToken)) {
        $fb->setDefaultAccessToken($accessToken);
        $response = $fb -> get('/me');
        $user = $response -> getGraphUser();
        echo 'ID: ' . $user -> getId() . '<br>';
        echo 'Name: ' . $user -> getName() . '<br>';
        echo '<img src="//graph.facebook.com/"' . $user -> getId() . '"/picture">';
    } else {
        echo 'Failed to retrieve accessToken';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
	<link rel="stylesheet" media="screen" href="css/base.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<meta charset="UTF-8">
	<link rel="import" href="bower_components/iron-icons/social-icons.html">
	<link rel="import" href="bower_components/iron-icons/iron-icons.html">
	<link rel="import" href="bower_components/paper-input/paper-input.html">
	<link rel="import" href="bower_components/paper-dropdown-menu/paper-dropdown-menu.html">
	<link rel="import" href="bower_components/paper-item/paper-item.html">
	<link rel="import" href="bower_components/paper-listbox/paper-listbox.html">
	<link rel="import" href="bower_components/paper-button/paper-button.html">
	<link rel="import" href="bower_components/iron-flex-layout/iron-flex-layout.html">
	<link rel="import" href="bower_components/paper-card/paper-card.html">
	<title>Search and Share YouTube Videos</title>
</head>
<body class="container bg-faded bg-frame">
<form is="iron-form" id="searchForm" method="post" action="/ai3-web-app/Info">
    <div class="row justify-content-between">
        <paper-input name="query" label="What kind of videos you are interested in?" class="col-6" required>
            <iron-icon icon="icons:search" class="mr-2" prefix></iron-icon>
        </paper-input>
        <paper-dropdown-menu name="method" label="Sort by" class="col-3" required>
            <paper-listbox class="dropdown-content">
                <paper-item>Decreasing like count</paper-item>
                <paper-item>Hot content score</paper-item>
            </paper-listbox>
        </paper-dropdown-menu>
        <paper-button raised id="submitButton" onclick="getSearchResult()" class="col-2 custom indigo">
            Search
        </paper-button>
    </div>
</form>
<div id="status"></div>
<div id="search-re sult">
	<paper-card animated-shadow class="record">
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
</div

<div class="footer mb-3 mt-3">
	<span>&copy; <a href="http://derek.ma">Derek Mingyu MA</a>. An assignment for PolyU COMP COMP3121. <a href="https://github.com/derekmma/search-and-share-YouTube-videos">Use my code</a>.</span>
</div>
	
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
		height: 170px;
		background: url('./donuts.png');
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
	<script src="js/base.js" type="text/javascript" chatset="utf-8"></script>
	<script>
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
	</script>
	
	
</body>
</html>
