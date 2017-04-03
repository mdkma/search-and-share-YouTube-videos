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
    } else {
        echo 'Failed to retrieve accessToken';
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        
    </body>
</html>
