<?php
    
    // Initiate session to store access info
    session_start();
    
    // Load Facebook SDK with autoloading
    require_once $_SERVER['DOCUMENT_ROOT'] . '/14110562d/php-graph-sdk-5.0.0/src/Facebook/autoload.php';

    // Configure Facebook App ID and App Secret
    $fb = new Facebook\Facebook([
        'app_id' => '1325805574163170',
        'app_secret' => '8d5e92b961c2eb0c04454242f56ac2c3',
        'default_graph_version' => 'v2.5'
    ]);
    
    // Retrieve helper instance which store the CSRF values in session
    $helper = $fb->getRedirectLoginHelper();

    try {
        $accessToken = $helper -> getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage() . '</br>';
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage() . '</br>';
        exit;
    }
    
    
    if (isset($accessToken)) {
        echo 'Login Successfully';
        // Logged in!
        $_SESSION['facebook_access_token'] = (string) $accessToken;
    } else {
        // Provide the login link since access token is not found
        $callback = 'http://localhost/14110562d/index.php';
        $loginUrl = $helper->getLoginUrl($callback);
        echo '<br><a href="' . $loginUrl . '">Log in with Facebook</a></br>';
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Welcome!</title>
    </head>
    <body>
        
    </body>
</html>
