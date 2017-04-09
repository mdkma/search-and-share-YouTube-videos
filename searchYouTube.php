<?php

/**
 * Library Requirements
 *
 * 1. Install composer (https://getcomposer.org)
 * 2. On the command line, change to this directory (api-samples/php)
 * 3. Require the google/apiclient library
 *    $ composer require google/apiclient:~2.0
 */
$finalResult = array();
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}

require_once __DIR__ . '/vendor/autoload.php';
// This code will execute if the user entered a search query in the form
// and submitted the form. Otherwise, the page displays the form above.
if (isset($_GET['q'])) {
  /*
   * Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
   * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
   * Please ensure that you have enabled the YouTube Data API for your project.
   */
  $DEVELOPER_KEY = 'AIzaSyB6ItIn7rhWcP0eKuhsW_5g930u5sIL0UE';

  $client = new Google_Client();
  $client->setDeveloperKey($DEVELOPER_KEY);

  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);

  try {
    // Call the search.list method to retrieve results matching the specified
    // query term.
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
      'q' => $_GET['q'],
      'maxResults' => 20,
      'order' => 'viewCount',
      'type' => 'video'
    ));

    // Add each result to the appropriate list, and then display the lists of
    // matching videos, channels, and playlists.
    $listResult = array();
    foreach ($searchResponse['items'] as $searchResult) {
      array_push($listResult, $searchResult['id']['videoId']);
    }

    $videoIds = join(',',$listResult);
    $videosResponse = $youtube->videos->listVideos('snippet, statistics', array(
      'id' => $videoIds,
    ));

    foreach ($videosResponse['items'] as $videoResult) {
        $thisVideo = new stdClass();
        $thisVideo -> id = $videoResult['id'];
        $thisVideo -> title = $videoResult['snippet']['title'];
        $thisVideo -> channelTitle = $videoResult['snippet']['channelTitle'];
        $thisVideo -> viewCount = $videoResult['statistics']['viewCount'];
        $thisVideo -> likeCount = $videoResult['statistics']['likeCount'];
        $thisVideo -> dislikeCount = $videoResult['statistics']['dislikeCount'];
        $thisVideo -> commentCount = $videoResult['statistics']['commentCount'];
        $thisVideo -> publishedAt = $videoResult['snippet']['publishedAt'];
        $thisVideo = json_encode($thisVideo);
        array_push($finalResult, $thisVideo);
    }
  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }
}
$finalResult = json_encode($finalResult);
echo $finalResult;
?>