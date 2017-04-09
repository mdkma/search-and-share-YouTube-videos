<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/14110562d/Facebook/src/Facebook/autoload.php';
    
    $fb = new Facebook\Facebook([
        'app_id' => '1325805574163170',
        'app_secret' => '8d5e92b961c2eb0c04454242f56ac2c3',
        'default_graph_version' => 'v2.5'
    ]);
    $accessToken = $_POST['accessToken'];
    echo "<script>console.log('haha');</script>";
    /*
    $helper = $fb->getRedirectLoginHelper();
    
    try {
        $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage() . '<br>';
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage() . '<br>';
    }*/

    if (isset($accessToken)) {
        $fb->setDefaultAccessToken($accessToken);
        try {
            // Specify the contents to post on facebook
            $data = [
                'link' => $_POST['link'],
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
        $callback = 'http://localhost/14110562d/post.php';
        $loginUrl = $helper->getLoginUrl($callback, $permissions);
        echo '<a href="' . $loginUrl . '">Log in with Facebook</a>';
    }
echo "good!!";
?>
