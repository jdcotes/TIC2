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
      $getfield = '?geocode=10.9838039,-74.8880581,10km';
      $requestMethod = 'GET';
      $twitter = new TwitterAPIExchange($settings);
      $json = $twitter->setGetfield($getfield)
                 ->buildOauth($url, $requestMethod)
                ->performRequest();
      return $json;
  }
      function getInfoTwitter($contenedorJson){

      $rawdata = "";
      $json = json_decode($jsonraw);
      $num_items = count($json->statuses);

      for($i=0; $i<num_items; $i++){
          $user = $json[$i];
          $fecha = $user->created_at;
          $url_imagen = $user->user->profile_image_url;
          $screen_name = $user->user->screen_name;
          $tweet = $user->text;

          $imagen = "<a href='https://twitter.com/".$screen_name."' target=_blank><img src=".$url_imagen."></img></a>";
          $name = "<a href='https://twitter.com/".$screen_name."' target=_blank>@".$screen_name."</a>";

          $rawdata[$i][0]=$fecha;
          $rawdata[$i]["FECHA"]=$fecha;
          $rawdata[$i][1]=$imagen;
          $rawdata[$i]["imagen"]=$imagen;
          $rawdata[$i][2]=$name;
          $rawdata[$i]["screen_name"]=$name;
          $rawdata[$i][3]=$tweet;
          $rawdata[$i]["tweet"]=$tweet;
      }
      return $rawdata;
    }
}
  $twitterObject = new Twitter();
  $jsonraw = $twitterObject->getTweets();
  $rawdata = $twitterObject->getInfoTwitter($jsonraw);
  echo($rawdata);

?>