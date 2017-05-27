<?php

class Twitter{
  function getTweets(){
      ini_set('display_errors',1);
      require_once('TwitterAPIExchange.php');

      $settings = array('oauth_access_token' => "348069833-ZuXLAANB78ygs1VFoZpOZ08oGOZsQh9GvmV2e53b",
                        'oauth_access_token_secret' => "mW6nE0U2gRN6XnZ8I2bU6mFaxmaHF0eOXa9wRZRe3pviG",
                        'consumer_key' => "zkyaUhh6fmAgtDFakFLy6ZrK7",
                        'consumer_secret' => "IeeGjaLauKK1X9rSgd2uPlfF9kdNf9Tcidr2HQHWFtvAmQL73k");

      $url = 'https://api.twitter.com/1.1/search/tweets.json';
      $getfield = '?geocode:10.9838039,-74.8880581,20km';
      $requestMethod = 'GET';
      $twitter = new TwitterAPIExchange($settings);
      $json = $twitter->setGetfield($getfield)
                 ->buildOauth($url, $requestMethod)
                ->performRequest();
      return $json;
  }
}
  $twitterObject = new Twitter();
  $jsonraw = $twitterObject->getTweets();
  echo($jsonraw);
?>