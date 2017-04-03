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
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Search and Share YouTube Videos</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link href='https://fonts.googleapis.com/css?family=Roboto:200,300,400,700' rel='stylesheet' type='text/css'>
	<link rel="import" href="bower_components/paper-input/paper-input.html">
	<link rel="import" href="bower_components/paper-button/paper-button.html">
	<link rel="import" href="bower_components/paper-card/paper-card.html">
	<link rel="import" href="bower_components/iron-form/iron-form.html">
    <link rel="import" href="bower_components/paper-dropdown-menu/paper-dropdown-menu.html">
    <link rel="import" href="bower_components/paper-listbox/paper-listbox.html">
    <link rel="import" href="bower_components/paper-item/paper-item.html">
    <link rel="import" href="bower_components/paper-button/paper-button.html">
</head>
<body class="container bg-faded bg-frame">
    <div class="row justify-content-between">
        <paper-input label="What kind of videos you are interested in?" class="col-6">
            <iron-icon icon="search" prefix></iron-icon>
        </paper-input>
        <paper-dropdown-menu label="Sort by" class="col-3">
            <paper-listbox class="dropdown-content" selected="1">
                <paper-item>Sort by 1</paper-item>
                <paper-item>Sort by 2</paper-item>
            </paper-listbox>
        </paper-dropdown-menu>
        <paper-button raised id="submitButton" onclick="" class="col-2 custom indigo">
            Search
        </paper-button>
    </div>
	<div class="footer mb-3">
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
	  
	  paper-card {
	  	max-width: 100%;
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
