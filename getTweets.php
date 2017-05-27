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
    $count = 0;
      $rawdata = "";
      $json = "";
      for($i=0;$i<count($contenedorJson);$i++){
        
        //$json = $contenedorJson[$i];
        $json = json_decode($contenedorJson);
        $num_items = count($json->statuses);

        for ($j=0; $j<$num_items; $j++){
          $user = $json->statuses[$j];
          $id_tweet = $user->id_str;
          $fecha = $user->created_at;
          $url_imagen = $user->user->profile_image_url;
          $screen_name = $user->user->screen_name;
          $imagen = "<a href='https://twitter.com/".$screen_name."' target=_blank><img src=".$url_imagen."></img></a>";
          $tweet = $user->text;

          if(!empty($user->geo->coordinates[0])){
            $latitud = $user->geo->coordinates[0];
            $longitud = $user->geo->coordinates[1];
          }
          else{
            $latitud = 0;
            $longitud = 0;
          }
          $rawdata[$count][0] = $fecha;
          $rawdata[$count]["FECHA"] = $fecha;
          $rawdata[$count][1] = $imagen;
          $rawdata[$count]["imagen"] = $imagen;
          $rawdata[$count][3] = $url_imagen;
          $rawdata[$count]["imagen_url"] = $url_imagen; 
          $rawdata[$count][4]="@".$screen_name;
                $rawdata[$count]["nombre"]="@".$screen_name;
                $rawdata[$count][5]=$tweet;
                $rawdata[$count]["tweet"]=$tweet;
                $rawdata[$count][6]=$latitud;
                $rawdata[$count]["latitud"]=$latitud;
                $rawdata[$count][7]=$longitud;
                $rawdata[$count]["longitud"]=$longitud;
                $count++;
        }
      }
      return $rawdata;  
  }
}
  $twitterObject = new Twitter();
  $jsonraw = $twitterObject->getTweets();
  $rawdata = $twitterObject->getInfoTwitter($jsonraw);
  echo($rawdata);

?>